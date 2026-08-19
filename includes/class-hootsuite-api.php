<?php
/**
 * Hootsuite API class
 *
 * @package WPZinc\Social
 * @author  WP Zinc
 */

namespace WPZinc\Social;

/**
 * Provides functions for sending statuses and querying Hootsuite's API.
 *
 * @package WPZinc\Social
 * @author  WP Zinc
 * @version 3.0.0
 */
class Hootsuite_API {

	/**
	 * Holds the base class object.
	 *
	 * @since   1.0.0
	 *
	 * @var     object
	 */
	public $base;

	/**
	 * Holds the Hootsuite Application's Client ID
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	private $client_id = 'l7xx225f065c3e6e4da2b9e287824299f6de';

	/**
	 * Holds the oAuth Gateway endpoint, used to exchange a code for an access token
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	private $oauth_gateway_endpoint = 'https://www.wpzinc.com/?oauth=hootsuite';

	/**
	 * Holds the API endpoint
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	private $api_endpoint = 'https://platform.hootsuite.com/';

	/**
	 * Holds the Proxy endpoint, which might be used to pass requests through
	 *
	 * @since   1.7.3
	 *
	 * @var     string
	 */
	private $proxy_endpoint = 'https://proxy.wpzinc.net/';

	/**
	 * Holds the API version
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	private $api_version = 'v1';

	/**
	 * Access Token
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	public $access_token = '';

	/**
	 * Refresh Token
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	public $refresh_token = '';

	/**
	 * Token Expiry Timestamp
	 *
	 * @since   1.0.0
	 *
	 * @var     int
	 */
	public $token_expires = false;

	/**
	 * Holds Attachment ID to Amazon S3 Media IDs,
	 * so that we don't upload the same media item
	 * multiple times.
	 *
	 * @since   1.9.2
	 *
	 * @var     array
	 */
	private $media_ids = array();

	/**
	 * Constructor
	 *
	 * @since   1.0.0
	 *
	 * @param   object $base    Base Plugin Class.
	 */
	public function __construct( $base ) {

		// Store base class.
		$this->base = $base;

		add_action( 'wp_to_hootsuite_output_auth', array( $this, 'output_oauth' ) );
		add_action( 'wp_to_hootsuite_pro_output_auth', array( $this, 'output_oauth' ) );

	}

	/**
	 * Outputs an Authorize Plugin button on Settings > General when the Plugin needs to be authenticated with Hootsuite.
	 *
	 * @since   1.7.2
	 */
	public function output_oauth() {

		?>
		<div class="wpzinc-option">
			<div class="full">
				<a href="<?php echo esc_attr( $this->get_oauth_url() ); ?>" class="button button-primary">
					<?php esc_html_e( 'Connect a Hootsuite Account', 'wp-to-hootsuite' ); ?>
				</a>
			</div>
		</div>
		<?php

	}

	/**
	 * Returns the oAuth 2 URL used to begin the oAuth process
	 *
	 * @since   1.0.0
	 *
	 * @return  string  oAuth URL
	 */
	public function get_oauth_url() {

		// Define URL args.
		$args = array(
			'client_id'     => $this->client_id,
			'response_type' => 'code',
			'scope'         => 'offline',
			'redirect_uri'  => $this->oauth_gateway_endpoint,
			'state'         => add_query_arg(
				'_wpnonce',
				wp_create_nonce( $this->base->plugin->filter_name . '_oauth' ),
				admin_url( 'admin.php?page=' . $this->base->plugin->name . '-settings' )
			),
		);

		// Return oAuth URL.
		return $this->api_endpoint . 'oauth2/auth?' . http_build_query( $args );

	}

	/**
	 * Returns the Hootsuite URL where the user can register for a Hootsuite account
	 *
	 * @since   4.6.4
	 *
	 * @return  string  URL
	 */
	public function get_registration_url() {

		return 'https://hootsuite.com/create-free-account';

	}

	/**
	 * Returns the Hootsuite URL where the user can connect their social media accounts
	 * to Hootsuite
	 *
	 * @since   3.8.4
	 *
	 * @return  string  URL
	 */
	public function get_connect_profiles_url() {

		// Return Connect Profiles URL.
		return 'https://hootsuite.com/dashboard#/member';

	}

	/**
	 * Returns the Hootsuite URL where the user can change the timezone for the
	 * given profile ID.
	 *
	 * @since   3.8.1
	 *
	 * @param   string $profile_id     Profile ID.
	 * @return  string                  Timezone Settings URL
	 */
	public function get_timezone_settings_url( $profile_id = false ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter

		return 'https://hootsuite.com/dashboard#/planner';

	}

	/**
	 * Sets this class' access and refresh tokens
	 *
	 * @since   1.0.0
	 *
	 * @param   string   $access_token    Access Token.
	 * @param   string   $refresh_token   Refresh Token.
	 * @param   bool|int $token_expires   Token Expiry.
	 */
	public function set_tokens( $access_token = '', $refresh_token = '', $token_expires = false ) {

		$this->access_token  = $access_token;
		$this->refresh_token = $refresh_token;
		$this->token_expires = $token_expires;

	}

	/**
	 * Gets a new Access Token by using the Refresh Token
	 * assigned to this class, if the Access Token
	 * is nearing expiration, or has already expired.
	 *
	 * @since   1.0.0
	 *
	 * @return  mixed   WP_Error | bool
	 */
	public function refresh_token() {

		// Bail if we don't have a refresh token.
		if ( empty( $this->refresh_token ) ) {
			return new \WP_Error( 'missing_refresh_token', __( 'No refresh token exists', 'wp-to-hootsuite' ) );
		}

		// Bail if the access token hasn't yet expired.
		if ( strtotime( '+5 minutes' ) < $this->token_expires ) {
			return false;
		}

		// Send request.
		$result = wp_remote_get(
			$this->oauth_gateway_endpoint,
			array(
				'headers' => array(
					'Content-Type' => 'application/json',
				),
				'body'    => array(
					'refresh_token' => $this->refresh_token,
				),
				'timeout' => 10,
			)
		);

		// Fetch the body.
		$body = json_decode( wp_remote_retrieve_body( $result ) );

		// Bail if an error occured.
		if ( ! $body->success ) {
			// Define error.
			$result = new \WP_Error(
				'wp_to_social_pro_hootsuite_api_update_access_token',
				sprintf(
					/* translators: Error message */
					__( 'Error refreshing access token.  Hootsuite said: %s', 'wp-to-hootsuite' ),
					$body->data
				)
			);

			/**
			 * Perform any actions when refreshing an expired access token fails.
			 *
			 * @since   3.0.0
			 *
			 * @param   WP_Error  $result        Error from API.
			 * @param   string    $client_id     OAuth Client ID.
			 * @param   string    $access_token  Access Token.
			 * @param   string    $refresh_token Refresh Token.
			 */
			do_action( 'wp_to_hootsuite_pro_api_refresh_token_error', $result, $this->client_id, $this->access_token, $this->refresh_token );

			return $result;
		}

		// Build result data.
		$result = array(
			'access_token'  => $body->data->access_token,
			'refresh_token' => $body->data->refresh_token,
			'token_expires' => strtotime( '+' . $body->data->expires_in . ' seconds' ),
		);

		/**
		 * Perform any actions with the new access token, such as saving it.
		 *
		 * @since   3.0.0
		 *
		 * @param   array   $result                  New Access Token, Refresh Token and Expiry timestamp.
		 * @param   string  $client_id               OAuth Client ID.
		 * @param   string  $previous_access_token   Existing Access Token.
		 * @param   string  $previous_refresh_token  Existing Refresh Token.
		 */
		do_action( 'wp_to_hootsuite_pro_api_refresh_token', $result, $this->client_id, $this->access_token, $this->refresh_token );

		// Update the access and refresh tokens in this class.
		$this->set_tokens( $result['access_token'], $result['refresh_token'], $result['token_expires'] );

		// Return new access token, refresh token and expiry timestamp.
		return $result;

	}

	/**
	 * Returns the User object
	 *
	 * @since   1.0.0
	 *
	 * @return  mixed   WP_Error | User object
	 */
	public function user() {

		// Run the main request.
		return $this->get( 'me' );

	}

	/**
	 * Returns the account ID and name for the current account.
	 *
	 * @since   2.8.0
	 *
	 * @param   string $account_id     Account ID. Unused in Hootsuite.
	 * @return  WP_Error|array
	 */
	public function account( $account_id = '' ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found

		// Query API.
		$account = $this->user();

		// Bail if an error occurred.
		if ( is_wp_error( $account ) ) {
			return $account;
		}

		// Return the account ID, name and other information expected by the shared library.
		// Hootsuite does not expose a channel limit via its API, so this is always zero (no limit).
		return array(
			'id'            => $account->id,
			'name'          => ! empty( $account->companyName ) ? $account->companyName : $account->fullName, // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			'email'         => ! empty( $account->email ) ? $account->email : '',
			'channel_limit' => 0,
			'plan'          => 'unknown',
		);

	}

	/**
	 * Returns a list of Social Media Profiles attached to the Hootsuite Account.
	 *
	 * @since   1.0.0
	 *
	 * @param   bool   $force       Force API call (false = use WordPress transient).
	 * @param   string $account_id  Account ID.
	 * @return  WP_Error|array
	 */
	public function profiles( $force = false, $account_id = 'default' ) {

		// Determine how long to cache profiles for in the transient.
		$transient_expiration_time = $this->base->get_class( 'common' )->get_transient_expiration_time();

		// Setup profiles array.
		$profiles = array();

		// Check if our WordPress transient already has this data.
		// This reduces the number of times we query the API.
		$profiles = get_transient( $this->base->plugin->name . '_hootsuite_api_profiles_' . $account_id );
		if ( $force || false === $profiles ) {
			// Get user, which contains the timezone.
			// Individual profiles do not have their own timezones vs. Hootsuite, where they do.
			$timezone = false;
			$user     = $this->user();
			if ( $user !== false && ! is_wp_error( $user ) ) {
				if ( isset( $user->defaultTimezone ) ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					$timezone = $user->defaultTimezone; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				}
			}

			// Get profiles.
			$results = $this->get( 'socialProfiles' );

			// Check for errors.
			if ( is_wp_error( $results ) ) {
				return $results;
			}

			// Define profiles as a blank array.
			$profiles = array();

			// Check data is valid.
			foreach ( $results as $result ) {
				// We don't support Instagram or Pinterest in the Free version.
				if ( $this->base->plugin->name === 'wp-to-hootsuite' ) {
					if ( $result->type === 'INSTAGRAM' || $result->type === 'PINTEREST' ) {
						continue;
					}
				}

				// Hootsuite doesn't support Instagram Business profiles for statuses via the API.
				if ( $result->type === 'INSTAGRAMBUSINESS' ) {
					continue;
				}

				// Add profile to array.
				$profiles[ (string) $result->id ] = array(
					// Hootsuite ID.
					'id'                 => $result->id,
					// Social Network (e.g. FB, Twitter) ID.
					'social_network_id'  => $result->socialNetworkId, // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					'formatted_service'  => $this->get_formatted_service( $result->type ),
					'formatted_username' => $result->socialNetworkUsername, // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					'service'            => $this->get_service( $result->type ),
					'timezone'           => $timezone,
					// For pinterest, the profile is the account, not the board.
					'can_be_subprofile'  => false,
				);

				// Twitter's 2019 Developer Policies mean that the formatted username and profile image are no longer returned.
				// In turn, Hootsuite cannot provide this information, so we must directly query for it through the Twitter API.
				if ( $result->type === 'TWITTER' && empty( $profiles[ (string) $result->id ]['formatted_username'] ) ) {
					// Fetch Twitter username from the API.
					// The API class will check the transient first and use cached results if available.
					$twitter_username = $this->base->get_class( 'twitter_api' )->get_username_by_id( $profiles[ $result->id ]['social_network_id'], $transient_expiration_time );
					if ( is_wp_error( $twitter_username ) ) {
						continue;
					}

					// Add username to results.
					$profiles[ $result->id ]['formatted_username'] = $twitter_username;
				}
			}

			// Store profiles in transient.
			set_transient( $this->base->plugin->name . '_hootsuite_api_profiles_' . $account_id, $profiles, $transient_expiration_time );
		}

		// Return results.
		return $profiles;

	}

	/**
	 * Depending on the social media profile type, return the formatted service name.
	 *
	 * @since   1.0.0
	 *
	 * @param   string $type   Social Media Profile Type.
	 * @return  string          Formatted Social Media Profile Service Name
	 */
	private function get_formatted_service( $type ) {

		switch ( $type ) {

			case 'TWITTER':
				return __( 'Twitter', 'wp-to-hootsuite' );

			case 'INSTAGRAM':
				return __( 'Instagram', 'wp-to-hootsuite' );

			case 'FACEBOOKPAGE':
				return __( 'Facebook Page', 'wp-to-hootsuite' );

			case 'FACEBOOK':
				return __( 'Facebook', 'wp-to-hootsuite' );

			case 'LINKEDINCOMPANY':
				return __( 'LinkedIn Page', 'wp-to-hootsuite' );

			case 'LINKEDIN':
				return __( 'LinkedIn', 'wp-to-hootsuite' );

			case 'GOOGLEPLUSPAGE':
				return __( 'Google+ Page', 'wp-to-hootsuite' );

			case 'PINTEREST':
				return __( 'Pinterest', 'wp-to-hootsuite' );

			case 'THREADS':
				return __( 'Threads', 'wp-to-hootsuite' );

			case 'TIKTOKBUSINESS':
				return __( 'TikTok', 'wp-to-hootsuite' );

			default:
				return '';

		}

	}

	/**
	 * Depending on the social media profile type, return the service name.
	 *
	 * @since   1.0.0
	 *
	 * @param   string $type   Social Media Profile Type.
	 * @return  string          Social Media Profile Service Name
	 */
	private function get_service( $type ) {

		switch ( $type ) {

			case 'FACEBOOKPAGE':
			case 'FACEBOOKGROUP':
				return 'facebook';

			case 'TWITTER':
				return strtolower( $type );

			case 'INSTAGRAM':
				return 'instagram';

			case 'LINKEDINCOMPANY':
			case 'LINKEDIN':
				return 'linkedin';

			case 'GOOGLEPLUSPAGE':
				return 'google';

			case 'PINTEREST':
				return 'pinterest';

			case 'THREADS':
				return 'threads';

			case 'TIKTOKBUSINESS':
				return 'tiktok';

			default:
				return '';

		}

	}

	/**
	 * Creates an Update
	 *
	 * @since   1.0.0
	 *
	 * @param   array $params     Status Parameters.
	 * @return  mixed               WP_Error | Update object
	 */
	public function updates_create( $params ) {

		// Convert parameters into Hootsuite REST API compatible params.
		$status = array(
			'text'             => $params['text'],
			'socialProfileIds' => $params['profile_ids'],
		);

		// Scheduling.
		switch ( $params['schedule_type'] ) {
			case 'immediate':
				$variables['mode'] = 'shareNow';
				break;

			default:
				$status['scheduledSendTime'] = str_replace( ' ', 'T', $params['scheduled_at'] ) . 'Z';
				break;
		}

		// Extended Info.
		$extended_info = array();
		switch ( $params['post_type'] ) {
			case 'pin':
				// If the subprofile is a URL, it'll be a Pinterest Board URL that we need to convert to a Board ID.
				if ( filter_var( $params['pinterest']['board'], FILTER_VALIDATE_URL ) ) {
					// Fetch Pinterest Board ID from the API.
					// The API class will check the transient first and use cached results if available.
					$board_id = $this->base->get_class( 'pinterest_api' )->get_board_id_by_url( $params['pinterest']['board'], $this->base->get_class( 'common' )->get_transient_expiration_time() );
					if ( is_wp_error( $board_id ) ) {
						return $board_id;
					}
				} else {
					$board_id = $params['pinterest']['board'];
				}

				$extended_info = array(
					'socialProfileType' => 'PINTEREST',
					'socialProfileId'   => $params['profile_ids'][0], // Pinterest account.
					'data'              => array(
						'boardId'        => (string) $board_id, // Pinterest Board ID.
						'destinationUrl' => $params['url'],
					),
				);
				break;
		}

		if ( ! empty( $extended_info ) ) {
			$status['extendedInfo'] = array(
				$extended_info,
			);
		}

		// Assets / Images.
		$media_ids  = array();
		$media_urls = array();
		switch ( $params['post_type'] ) {
			case 'image':
			case 'story':
			case 'pin':
			case 'googlebusiness':
				$assets = array();
				$images = array();

				// Bail if no images are defined.
				if ( ! array_key_exists( 'media_urls', $params ) ) {
					break;
				}

				// Build images array.
				foreach ( $params['media_urls'] as $media ) {
					// Use Amazon S3 method if we have an image ID, or fallback to the ow.ly if we don't.
					if ( isset( $media['id'] ) ) {
						// Upload the media to Hootsuite, if we haven't already for this Attachment ID.
						if ( ! array_key_exists( $media['id'], $this->media_ids ) ) {
							$result = $this->media_upload( $media['id'], $media['image'] );

							// Bail if the upload failed.
							if ( is_wp_error( $result ) ) {
								return $result;
							}

							// Store the Amazon S3 ID.
							$this->media_ids[ $media['id'] ] = $result;
						}

						// Define the Amazon S3 ID which Hootsuite provided, so the media
						// is included in the status.
						$media_ids[] = array(
							'id' => $this->media_ids[ $media['id'] ],
						);
					} elseif ( isset( $media['image'] ) ) {
						// Upload the media to ow.ly.
						$result = $this->base->get_class( 'owly_api' )->photo_upload( $media['image'] );

						// Bail if the upload failed.
						if ( is_wp_error( $result ) ) {
							return $result;
						}

						// Define the ow.ly media URL.
						$media_urls[] = array(
							'url' => $result,
						);
					}
				}

				// Add media to status.
				if ( ! empty( $media_ids ) ) {
					$status['media'] = $media_ids;
				}
				if ( ! empty( $media_urls ) ) {
					$status['mediaUrls'] = $media_urls;
				}
				break;
		}

		// Send request.
		$result = $this->post( 'messages', $status );

		// If an error occured, try again, as the Media ID on Amazon S3 might not yet be ready.
		if ( is_wp_error( $result ) ) {
			sleep( 3 );
			$result = $this->post( 'messages', $status );
		}

		// If an error still occured, bail.
		if ( is_wp_error( $result ) ) {
			return $result;
		}

		// Return array of just the data we need to send to the Plugin.
		return array(
			'profile_id'        => $result[0]->socialProfile->id,
			'message'           => $result[0]->state,
			'status_text'       => $result[0]->text,
			'status_created_at' => current_time( 'timestamp' ), // phpcs:ignore WordPress.DateTime.CurrentTimeTimestamp.Requested
			'due_at'            => ( isset( $result[0]->scheduledSendTime ) ? strtotime( $result[0]->scheduledSendTime ) : current_time( 'timestamp' ) ), // phpcs:ignore WordPress.DateTime.CurrentTimeTimestamp.Requested
		);

	}

	/**
	 * Uploads media to Hootsuite, per https://developer.hootsuite.com/docs/uploading-media
	 *
	 * @since   1.0.0
	 *
	 * @param   int    $id             WordPress Attachment ID.
	 * @param   string $media_url      Media URL.
	 * @return  mixed                   WP_Error | string (ID)
	 */
	private function media_upload( $id, $media_url ) {

		// Get Attachment.
		$file = get_attached_file( $id );

		// Bail if Attachment doesn't exist in WordPress.
		if ( ! $file ) {
			return new \WP_Error(
				$this->base->plugin->name . '_api_media_upload',
				sprintf(
					/* translators: %1$s: Attachment ID, %2$s: Attachment URL */
					__( 'Attachment ID %1$s (%2$s) could not be found in the Media Library.', 'wp-to-hootsuite' ),
					$id,
					$media_url
				)
			);
		}

		// If file is an URL, it's been added to the Media Library by e.g. an External Media Library Plugin,
		// such as External Media without Import.
		if ( filter_var( $file, FILTER_VALIDATE_URL ) !== false ) {
			$headers   = get_headers( $file, 1 );
			$file_size = absint( $headers['Content-Length'] ); // Cast as an integer, otherwise API returns a sizeBytes error.
		} else {
			$file_size = absint( filesize( $file ) );
		}

		// Request a media URL.
		$result = $this->post(
			'media',
			array(
				'sizeBytes' => $file_size,
				'mimeType'  => get_post_mime_type( $id ),
			)
		);

		// Bail if an error occured.
		if ( is_wp_error( $result ) ) {
			return $result;
		}

		// Upload Media.
		$upload_result = wp_remote_request(
			$result->uploadUrl, // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			array(
				'headers' => array(
					'Content-Type'   => get_post_mime_type( $id ),
					'Content-Length' => $file_size,
				),
				'body'    => file_get_contents( $file ), // phpcs:ignore WordPress.WP.AlternativeFunctions
				'method'  => 'PUT',
				'timeout' => 60,
			)
		);

		// Bail if an error occured.
		if ( is_wp_error( $upload_result ) ) {
			return $upload_result;
		}

		// Return Amazon S3 Media ID.
		return $result->id;

	}

	/**
	 * Private function to perform a GET request
	 *
	 * @since  1.0.0
	 *
	 * @param  string $cmd        Command (required).
	 * @param  array  $params     Params (optional).
	 * @return mixed               WP_Error | object
	 */
	private function get( $cmd, $params = array() ) {

		return $this->request( $cmd, 'get', $params );

	}

	/**
	 * Private function to perform a POST request
	 *
	 * @since  1.0.0
	 *
	 * @param  string $cmd        Command (required).
	 * @param  array  $params     Params (optional).
	 * @return mixed               WP_Error | object
	 */
	private function post( $cmd, $params = array() ) {

		return $this->request( $cmd, 'post', $params );

	}

	/**
	 * Main function which handles sending requests to the Hootsuite API
	 *
	 * @since   1.0.0
	 *
	 * @param   string $cmd        Command.
	 * @param   string $method     Method (get|post).
	 * @param   array  $params     Parameters (optional).
	 * @return  mixed               WP_Error | object
	 */
	private function request( $cmd, $method = 'get', $params = array() ) {

		// Check required parameters exist.
		if ( empty( $this->access_token ) ) {
			return new \WP_Error( 'missing_access_token', __( 'No access token was specified', 'wp-to-hootsuite' ) );
		}

		// Fetch a new access token and refresh token.
		$result = $this->refresh_token();

		// Bail if something went wrong.
		if ( is_wp_error( $result ) ) {
			return $result;
		}

		// Build endpoint URL.
		$url = $this->api_endpoint . $this->api_version . '/' . $cmd;

		// Define the timeout.
		$timeout = 10;

		/**
		 * Defines the number of seconds before timing out a request to the Hootsuite API.
		 *
		 * @since   1.0.0
		 *
		 * @param   int     $timeout    Timeout, in seconds.
		 */
		$timeout = apply_filters( $this->base->plugin->filter_name . '_api_request', $timeout );

		// Request via WordPress functions.
		$result = $this->request_wordpress( $url, $method, $params, $timeout );

		// Request via cURL if WordPress functions failed.
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG === true ) {
			if ( is_wp_error( $result ) ) {
				$result = $this->request_curl( $url, $method, $params, $timeout );
			}
		}

		// Result will be WP_Error or the data we expect.
		return $result;

	}

	/**
	 * Performs POST and GET requests through WordPress wp_remote_post() and
	 * wp_remote_get() functions.
	 *
	 * @since   1.0.0
	 *
	 * @param   string $url        URL.
	 * @param   string $method     Method (post|get).
	 * @param   array  $params     Parameters.
	 * @param   int    $timeout    Timeout, in seconds (default: 10).
	 * @return  mixed               WP_Error | object
	 */
	private function request_wordpress( $url, $method, $params, $timeout = 10 ) {

		// Define headers.
		$headers = array(
			'Content-Type'  => 'application/json',
			'Authorization' => 'Bearer ' . $this->access_token,
		);

		// If proxy is enabled, send the request to our proxy with the URL, method and parameters.
		if ( $this->base->get_class( 'settings' )->get_option( 'proxy', false ) ) {
			$response = wp_remote_get(
				$this->proxy_endpoint,
				array(
					'headers' => $headers,
					'body'    => array(
						'url'    => $url,
						'method' => $method,

						// GET requests need to send params using http_build_query.
						// POST requests need to send params using json_encode.
						'params' => ( ! empty( $params ) ? ( $method === 'get' ? http_build_query( $params ) : wp_json_encode( $params ) ) : '' ),
					),
				)
			);
		} else {
			// Send request.
			switch ( $method ) {
				/**
				 * GET
				 */
				case 'get':
					$response = wp_remote_get(
						$url,
						array(
							'headers' => $headers,
							'body'    => ( ! empty( $params ) ? wp_json_encode( $params ) : '' ),
							'timeout' => $timeout,
						)
					);
					break;

				/**
				 * POST
				 */
				case 'post':
					$response = wp_remote_post(
						$url,
						array(
							'headers' => $headers,
							'body'    => ( ! empty( $params ) ? wp_json_encode( $params ) : '' ),
							'timeout' => $timeout,
						)
					);
					break;
			}
		}

		// If an error occured, return it now.
		if ( is_wp_error( $response ) ) {
			return $response;
		}

		// Fetch HTTP code and body.
		$http_code = wp_remote_retrieve_response_code( $response );
		$response  = wp_remote_retrieve_body( $response );

		// Parse the response, to return the JSON data or an WP_Error object.
		return $this->parse_response( $response, $http_code, $params, $url );

	}

	/**
	 * Performs POST and GET requests through PHP's curl_exec() function.
	 *
	 * If this function is called, request_wordpress() failed, most likely
	 * due to a DNS lookup failure or CloudFlare failing to respond.
	 *
	 * We therefore use CURLOPT_RESOLVE, to tell cURL the IP address for the domain.
	 *
	 * @since   1.0.0
	 *
	 * @param   string $url        URL.
	 * @param   string $method     Method (post|get).
	 * @param   array  $params     Parameters.
	 * @param   int    $timeout    Timeout, in seconds (default: 10).
	 * @return  mixed               WP_Error | object
	 */
	private function request_curl( $url, $method, $params, $timeout = 10 ) {

		// Bail if cURL isn't installed.
		if ( ! function_exists( 'curl_init' ) ) {
			return new \WP_Error(
				$this->base->plugin->name . '_api_request_curl',
				sprintf(
					/* translators: Plugin Name */
					__( '%s requires the PHP cURL extension to be installed and enabled by your web host.', 'wp-to-hootsuite' ),
					$this->base->plugin->displayName
				)
			);
		}

		// Init.
		// phpcs:disable WordPress.WP.AlternativeFunctions
		$ch = curl_init();

		// If proxy is enabled, send the request to our proxy with the URL, method and parameters.
		if ( $this->base->get_class( 'settings' )->get_option( 'proxy', false ) ) {
			curl_setopt_array(
				$ch,
				array(
					CURLOPT_URL => $this->proxy_endpoint . '?' . http_build_query(
						array(
							'url'    => $url,
							'method' => $method,

							// GET requests need to send params using http_build_query.
							// POST requests need to send params using json_encode.
							'params' => ( ! empty( $params ) ? ( $method === 'get' ? http_build_query( $params ) : wp_json_encode( $params ) ) : '' ),
						)
					),
				)
			);
		} else {
			// Set request specific options.
			switch ( $method ) {
				/**
				 * GET
				 */
				case 'get':
					curl_setopt_array(
						$ch,
						array(
							CURLOPT_URL     => $url . '?' . ( ! empty( $params ) ? http_build_query( $params ) : '' ),
							CURLOPT_RESOLVE => array(
								str_replace( 'https://', '', $this->api_endpoint ) . ':443:52.1.58.91',
								str_replace( 'https://', '', $this->api_endpoint ) . ':443:54.174.38.127',
							),
						)
					);
					break;

				/**
				 * POST
				 */
				case 'post':
					curl_setopt_array(
						$ch,
						array(
							CURLOPT_URL        => $url,
							CURLOPT_POST       => true,
							CURLOPT_POSTFIELDS => ( ! empty( $params ) ? wp_json_encode( $params ) : '' ),
							CURLOPT_RESOLVE    => array(
								str_replace( 'https://', '', $this->api_endpoint ) . ':443:52.1.58.91',
								str_replace( 'https://', '', $this->api_endpoint ) . ':443:54.174.38.127',
							),
						)
					);
					break;
			}
		}

		// Set shared options.
		curl_setopt_array(
			$ch,
			array(
				CURLOPT_HTTPHEADER     => array(
					'Content-Type: application/json',
					'Authorization: Bearer ' . $this->access_token,
				),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HEADER         => false,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_MAXREDIRS      => 10,
				CURLOPT_CONNECTTIMEOUT => $timeout,
				CURLOPT_TIMEOUT        => $timeout,
			)
		);

		// Execute.
		$response  = curl_exec( $ch );
		$http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		$error     = curl_error( $ch );
		curl_close( $ch );

		// phpcs:enable

		// Parse the response, to return the JSON data or an WP_Error object.
		return $this->parse_response( $response, $http_code, $params, $url );

	}

	/**
	 * Parses the response body and HTTP code, returning either
	 * a WP_Error object or the JSON decoded response body
	 *
	 * @since   3.9.8
	 *
	 * @param   string $response   Response Body.
	 * @param   int    $http_code  HTTP Code.
	 * @param   array  $params     Request Parameters.
	 * @param   string $url        Request URL.
	 * @return  mixed               WP_Error | object
	 */
	private function parse_response( $response, $http_code, $params, $url ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter

		// Decode response.
		$body = json_decode( $response );

		// Return body if HTTP code is 200.
		if ( $http_code === 200 ) {
			return $body->data;
		}

		// Return basic WP_Error if we don't have any more information.
		if ( is_null( $body ) ) {
			return new \WP_Error(
				$http_code,
				sprintf(
					/* translators: HTTP Error Code */
					__( 'Hootsuite API Error: %1$s returned a %2$s %3$s error. Please try again.', 'wp-to-hootsuite' ),
					$url,
					$http_code,
					$response
				)
			);
		}

		// Return detailed WP_Error.
		// Define the error message.
		$message = array();
		if ( isset( $body->error ) ) {
			$message[] = $body->error;
		}
		if ( isset( $body->errors ) ) {
			foreach ( $body->errors as $error ) {
				$message[] = $error->code . ': ' . $error->message;
			}
		}

		// Return WP_Error.
		return new \WP_Error(
			$http_code,
			sprintf(
				/* translators: %1$s: HTTP Error Code, %2$s: Error Message */
				__( 'Hootsuite API Error: #%1$s: %2$s', 'wp-to-hootsuite' ),
				$http_code,
				implode( "\n", $message )
			)
		);

	}

}
