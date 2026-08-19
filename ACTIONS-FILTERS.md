<h1>Filters</h1><table>
				<thead>
					<tr>
						<th>File</th>
						<th>Filter Name</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody><tr>
						<td colspan="3">../lib/social/includes/class-common.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_status_post_type_options"><code>wp_to_hootsuite_get_status_post_type_options</code></a></td>
						<td>Defines the available status post type options.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_schedule_options"><code>wp_to_hootsuite_get_schedule_options</code></a></td>
						<td>Defines the available schedule options for each individual status.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_google_business_start_date_options"><code>wp_to_hootsuite_get_google_business_start_date_options</code></a></td>
						<td>Defines the available start date options for a Google Business Profile status.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_google_business_end_date_options"><code>wp_to_hootsuite_get_google_business_end_date_options</code></a></td>
						<td>Defines the available start date options for a Google Business Profile status.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_post_types"><code>wp_to_hootsuite_get_post_types</code></a></td>
						<td>Defines the available Post Type Objects that can have statues defined and be sent to social media.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_excluded_post_types"><code>wp_to_hootsuite_get_excluded_post_types</code></a></td>
						<td>Defines the Post Type Objects that cannot have statues defined and not be sent to social media.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_excluded_taxonomies"><code>wp_to_hootsuite_get_excluded_taxonomies</code></a></td>
						<td>Defines taxonomies to exclude from the Conditions: Taxonomies dropdowns for each individual status.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_taxonomies"><code>wp_to_hootsuite_get_taxonomies</code></a></td>
						<td>Defines available taxonomies for the given Post Type, which are used in the Conditions: Taxonomies dropdowns for each individual status.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_all_taxonomies"><code>wp_to_hootsuite_get_all_taxonomies</code></a></td>
						<td>Defines available taxonomies, regardless of Post Type, which are used in the Conditions: Taxonomies dropdowns for each individual status.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_tags"><code>wp_to_hootsuite_get_tags</code></a></td>
						<td>Defines Dynamic Status Tags that can be inserted into status(es) for the given Post Type. These tags are also added to any 'Insert Tag' dropdowns.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_post_actions"><code>wp_to_hootsuite_get_post_actions</code></a></td>
						<td>Defines the Post actions which trigger status(es) to be sent to social media.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_post_actions_past_tense"><code>wp_to_hootsuite_get_post_actions_past_tense</code></a></td>
						<td>Defines the Post actions which trigger status(es) to be sent to social media, with labels set to the past tense.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_tags_excluded_from_character_limit"><code>wp_to_hootsuite_get_tags_excluded_from_character_limit</code></a></td>
						<td>Defines the tags that cannot have a character limit applied to them, as doing so would wrongly concatenate data (e.g. a URL would become malformed).</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_transient_expiration_time"><code>wp_to_hootsuite_get_transient_expiration_time</code></a></td>
						<td>Defines the number of seconds before expiring transients.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_log_filters"><code>wp_to_hootsuite_get_log_filters</code></a></td>
						<td>Defines the registered filters that can be used on the Log WP_List_Tables.</td>
					</tr><tr>
						<td colspan="3">../lib/social/includes/class-image.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_status_image_options"><code>wp_to_hootsuite_get_status_image_options</code></a></td>
						<td>Defines the available Featured Image select dropdown options on a status, depending on the Plugin and Social Network the status message is for.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_image_get_images_sources_convert"><code>wp_to_hootsuite_image_get_images_sources_convert</code></a></td>
						<td>Defines the image ID to use as the image or additional image for the status message. If an image's mime type is not supported by the social media scheduling service, this filter can be used to convert the image to a supported type, store it in the Media Library and return the converted image ID. This is already performed for webp images.</td>
					</tr><tr>
						<td colspan="3">../lib/social/includes/class-settings.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_settings"><code>wp_to_hootsuite_get_settings</code></a></td>
						<td>Filters Post Type Settings before they are returned.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_update_settings"><code>wp_to_hootsuite_update_settings</code></a></td>
						<td>Filters Post Type Settings before they are saved.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_default_installation_settings"><code>wp_to_hootsuite_default_installation_settings</code></a></td>
						<td>Filters Default Post Type Settings used on Plugin Activation before they are returned.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_settings_get_default_status"><code>wp_to_hootsuite_settings_get_default_status</code></a></td>
						<td>Returns a skeleton status object for the given action, used when defining new status(es)</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_settings_validate_status"><code>wp_to_hootsuite_settings_validate_status</code></a></td>
						<td>Filters status settings during validation, allowing them to be changed.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_update_option"><code>wp_to_hootsuite_update_option</code></a></td>
						<td>Filters the key and value pair before saving to the options table.</td>
					</tr><tr>
						<td colspan="3">../lib/social/includes/class-validation.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_validate_check_for_duplicates_status_keys"><code>wp_to_hootsuite_validate_check_for_duplicates_status_keys</code></a></td>
						<td>Defines the key values to compare across all statuses for a Post Type and Social Profile combination, to ensure no duplicate statuses have been defined.</td>
					</tr><tr>
						<td colspan="3">../lib/social/includes/class-notices.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_notices_get_success_notices"><code>wp_to_hootsuite_notices_get_success_notices</code></a></td>
						<td>Filters the success notices to return.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_notices_get_warning_notices"><code>wp_to_hootsuite_notices_get_warning_notices</code></a></td>
						<td>Filters the error notices to return.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_notices_get_error_notices"><code>wp_to_hootsuite_notices_get_error_notices</code></a></td>
						<td>Filters the error notices to return.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_notices_get_notices"><code>wp_to_hootsuite_notices_get_notices</code></a></td>
						<td>Filters the success and error notices to return.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_notices_save"><code>wp_to_hootsuite_notices_save</code></a></td>
						<td>Filters the success and error notices to save.</td>
					</tr><tr>
						<td colspan="3">../lib/social/includes/class-admin.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_admin_get_autocomplete_configuration"><code>wp_to_hootsuite_admin_get_autocomplete_configuration</code></a></td>
						<td>Defines configuration for tribute.js autocomplete instances for Tags, Facebook Pages and Twitter Username mentions.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_admin_admin_menu_minimum_capability"><code>wp_to_hootsuite_admin_admin_menu_minimum_capability</code></a></td>
						<td>Defines the minimum capability required to access the Plugin's Menu and Sub Menus</td>
					</tr><tr>
						<td colspan="3">../lib/social/includes/class-date.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_common_convert_wordpress_gmt_offset_to_offset_value"><code>wp_to_hootsuite_common_convert_wordpress_gmt_offset_to_offset_value</code></a></td>
						<td>Converts WordPress' GMT Offset (e.g. -5, +3.3) to an offset value compatible with WordPress' DateTime object (e.g. -0500, +0330)</td>
					</tr><tr>
						<td colspan="3">../lib/social/includes/class-log.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_get_log"><code>wp_to_hootsuite_get_log</code></a></td>
						<td>Filters the log entries before output.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_log_get_result_options"><code>wp_to_hootsuite_log_get_result_options</code></a></td>
						<td>Defines the available result options</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_log_get_log_levels"><code>wp_to_hootsuite_log_get_log_levels</code></a></td>
						<td>Defines the available log levels</td>
					</tr><tr>
						<td colspan="3">../lib/social/includes/class-publish.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_statuses"><code>wp_to_hootsuite_publish_statuses</code></a></td>
						<td>Determine the statuses to send, just before they're sent. Statuses can be added, edited and/or deleted as necessary here.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_build_args"><code>wp_to_hootsuite_publish_build_args</code></a></td>
						<td>Determine the standardised arguments array to send via the API for a status message's settings.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_parse_text_term_hashtag"><code>wp_to_hootsuite_publish_parse_text_term_hashtag</code></a></td>
						<td>Defines the Taxonomy Term Hashtag to replace the status template tag.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_term"><code>wp_to_hootsuite_term</code></a></td>
						<td>Backward compat filter to define the Taxonomy Term Name to replace the status template tag. _publish_parse_text_term_name and _publish_parse_text_term_hashtag should be used instead.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_parse_text"><code>wp_to_hootsuite_publish_parse_text</code></a></td>
						<td>Filters the parsed status message text on a status.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_parse_google_business_start_date_  statusgooglebusinessstart_date_option"><code>wp_to_hootsuite_publish_parse_google_business_start_date_  statusgooglebusinessstart_date_option</code></a></td>
						<td>Allows integrations to define the status' start date for a Google Business Profile Offer or Event.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_parse_google_business_end_date_  statusgooglebusinessend_date_option"><code>wp_to_hootsuite_publish_parse_google_business_end_date_  statusgooglebusinessend_date_option</code></a></td>
						<td>Allows integrations to define the status' end date for a Google Business Profile Offer or Event.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_apply_text_transformation"><code>wp_to_hootsuite_publish_apply_text_transformation</code></a></td>
						<td>Applies the given transformation to the given value</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_get_all_possible_searches_replacements"><code>wp_to_hootsuite_publish_get_all_possible_searches_replacements</code></a></td>
						<td>Registers any additional status message tags, and their Post data replacements, that are supported.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_register_post_searches_replacements"><code>wp_to_hootsuite_publish_register_post_searches_replacements</code></a></td>
						<td>Registers any additional status message tags, and their Post data replacements, that are supported for the given Post.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_get_title"><code>wp_to_hootsuite_publish_get_title</code></a></td>
						<td>Filters the dynamic {title} replacement, when a Post's status is being built.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_get_excerpt"><code>wp_to_hootsuite_publish_get_excerpt</code></a></td>
						<td>Filters the dynamic {excerpt} replacement, when a Post's status is being built.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_get_content"><code>wp_to_hootsuite_publish_get_content</code></a></td>
						<td>Filters the dynamic {content} replacement, when a Post's status is being built.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_get_date"><code>wp_to_hootsuite_publish_get_date</code></a></td>
						<td>Returns the date in the locale specified in WordPress.private function get_date( $post ) {$date = date_i18n( get_option( 'date_format' ), strtotime( $post->post_date ) );/ Filters the dynamic {date} replacement, when a Post's status is being built.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_get_permalink"><code>wp_to_hootsuite_publish_get_permalink</code></a></td>
						<td>Filters the Post's Permalink, including or excluding a trailing slash, depending on the Plugin settings</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_get_short_permalink"><code>wp_to_hootsuite_publish_get_short_permalink</code></a></td>
						<td>Filters the Post's Permalink, including or excluding a trailing slash, depending on the Plugin settings</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_apply_word_limit"><code>wp_to_hootsuite_publish_apply_word_limit</code></a></td>
						<td>Applies the given word limit to the given text.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_apply_sentence_limit"><code>wp_to_hootsuite_publish_apply_sentence_limit</code></a></td>
						<td>Applies the given sentence limit to the given text.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_publish_apply_character_limit"><code>wp_to_hootsuite_publish_apply_character_limit</code></a></td>
						<td>Filters the character limited text.</td>
					</tr><tr>
						<td colspan="3">../lib/social/includes/class-api.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_api_request_timeout"><code>wp_to_hootsuite_api_request_timeout</code></a></td>
						<td>Defines the number of seconds before timing out a request to the remote API.</td>
					</tr><tr>
						<td colspan="3">../includes/class-owly-api.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_api_request"><code>wp_to_hootsuite_api_request</code></a></td>
						<td>Defines the number of seconds before timing out a request to the Owly API.</td>
					</tr><tr>
						<td colspan="3">../includes/class-hootsuite-api.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_api_request"><code>wp_to_hootsuite_api_request</code></a></td>
						<td>Defines the number of seconds before timing out a request to the Hootsuite API.</td>
					</tr>
					</tbody>
				</table><h3 id="wp_to_hootsuite_get_status_post_type_options">
						wp_to_hootsuite_get_status_post_type_options
						<code>lib/social/includes/class-common.php::65</code>
					</h3><h4>Overview</h4>
						<p>Defines the available status post type options.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$status_post_type_options</td>
							<td>array</td>
							<td>Status Post Type Options.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_status_post_type_options', function( $status_post_type_options ) {
	// ... your code here
	// Return value
	return $status_post_type_options;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_get_schedule_options">
						wp_to_hootsuite_get_schedule_options
						<code>lib/social/includes/class-common.php::97</code>
					</h3><h4>Overview</h4>
						<p>Defines the available schedule options for each individual status.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$schedule</td>
							<td>array</td>
							<td>Schedule Options.</td>
						</tr><tr>
							<td>$post_type</td>
							<td>string</td>
							<td>Post Type.</td>
						</tr><tr>
							<td>$is_post_screen</td>
							<td>bool</td>
							<td>On Post Edit Screen.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_schedule_options', function( $schedule, $post_type, $is_post_screen ) {
	// ... your code here
	// Return value
	return $schedule;
}, 10, 3 );
</pre>
<h3 id="wp_to_hootsuite_get_google_business_start_date_options">
						wp_to_hootsuite_get_google_business_start_date_options
						<code>lib/social/includes/class-common.php::126</code>
					</h3><h4>Overview</h4>
						<p>Defines the available start date options for a Google Business Profile status.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$schedule</td>
							<td>array</td>
							<td>Schedule Options.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_google_business_start_date_options', function( $schedule, $post_type ) {
	// ... your code here
	// Return value
	return $schedule;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_get_google_business_end_date_options">
						wp_to_hootsuite_get_google_business_end_date_options
						<code>lib/social/includes/class-common.php::155</code>
					</h3><h4>Overview</h4>
						<p>Defines the available start date options for a Google Business Profile status.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$schedule</td>
							<td>array</td>
							<td>Schedule Options.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_google_business_end_date_options', function( $schedule, $post_type ) {
	// ... your code here
	// Return value
	return $schedule;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_get_post_types">
						wp_to_hootsuite_get_post_types
						<code>lib/social/includes/class-common.php::194</code>
					</h3><h4>Overview</h4>
						<p>Defines the available Post Type Objects that can have statues defined and be sent to social media.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$types</td>
							<td>array</td>
							<td>Post Types.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_post_types', function( $types ) {
	// ... your code here
	// Return value
	return $types;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_get_excluded_post_types">
						wp_to_hootsuite_get_excluded_post_types
						<code>lib/social/includes/class-common.php::225</code>
					</h3><h4>Overview</h4>
						<p>Defines the Post Type Objects that cannot have statues defined and not be sent to social media.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$types</td>
							<td>array</td>
							<td>Post Types.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_excluded_post_types', function( $types ) {
	// ... your code here
	// Return value
	return $types;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_get_excluded_taxonomies">
						wp_to_hootsuite_get_excluded_taxonomies
						<code>lib/social/includes/class-common.php::254</code>
					</h3><h4>Overview</h4>
						<p>Defines taxonomies to exclude from the Conditions: Taxonomies dropdowns for each individual status.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$taxonomies</td>
							<td>array</td>
							<td>Excluded Taxonomies.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_excluded_taxonomies', function( $taxonomies ) {
	// ... your code here
	// Return value
	return $taxonomies;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_get_taxonomies">
						wp_to_hootsuite_get_taxonomies
						<code>lib/social/includes/class-common.php::293</code>
					</h3><h4>Overview</h4>
						<p>Defines available taxonomies for the given Post Type, which are used in the Conditions: Taxonomies dropdowns for each individual status.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$taxonomies</td>
							<td>array</td>
							<td>Taxonomies.</td>
						</tr><tr>
							<td>$post_type</td>
							<td>string</td>
							<td>Post Type.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_taxonomies', function( $taxonomies, $post_type ) {
	// ... your code here
	// Return value
	return $taxonomies;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_get_all_taxonomies">
						wp_to_hootsuite_get_all_taxonomies
						<code>lib/social/includes/class-common.php::330</code>
					</h3><h4>Overview</h4>
						<p>Defines available taxonomies, regardless of Post Type, which are used in the Conditions: Taxonomies dropdowns for each individual status.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$taxonomies</td>
							<td>array</td>
							<td>Taxonomies.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_all_taxonomies', function( $taxonomies ) {
	// ... your code here
	// Return value
	return $taxonomies;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_get_tags">
						wp_to_hootsuite_get_tags
						<code>lib/social/includes/class-common.php::432</code>
					</h3><h4>Overview</h4>
						<p>Defines Dynamic Status Tags that can be inserted into status(es) for the given Post Type. These tags are also added to any 'Insert Tag' dropdowns.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$tags</td>
							<td>array</td>
							<td>Dynamic Status Tags.</td>
						</tr><tr>
							<td>$post_type</td>
							<td>string</td>
							<td>Post Type.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_tags', function( $tags, $post_type ) {
	// ... your code here
	// Return value
	return $tags;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_get_post_actions">
						wp_to_hootsuite_get_post_actions
						<code>lib/social/includes/class-common.php::486</code>
					</h3><h4>Overview</h4>
						<p>Defines the Post actions which trigger status(es) to be sent to social media.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$actions</td>
							<td>array</td>
							<td>Post Actions.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_post_actions', function( $actions ) {
	// ... your code here
	// Return value
	return $actions;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_get_post_actions_past_tense">
						wp_to_hootsuite_get_post_actions_past_tense
						<code>lib/social/includes/class-common.php::516</code>
					</h3><h4>Overview</h4>
						<p>Defines the Post actions which trigger status(es) to be sent to social media, with labels set to the past tense.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$actions</td>
							<td>array</td>
							<td>Post Actions.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_post_actions_past_tense', function( $actions ) {
	// ... your code here
	// Return value
	return $actions;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_get_tags_excluded_from_character_limit">
						wp_to_hootsuite_get_tags_excluded_from_character_limit
						<code>lib/social/includes/class-common.php::548</code>
					</h3><h4>Overview</h4>
						<p>Defines the tags that cannot have a character limit applied to them, as doing so would wrongly concatenate data (e.g. a URL would become malformed).</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$tags</td>
							<td>array</td>
							<td>Tags.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_tags_excluded_from_character_limit', function( $tags ) {
	// ... your code here
	// Return value
	return $tags;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_get_transient_expiration_time">
						wp_to_hootsuite_get_transient_expiration_time
						<code>lib/social/includes/class-common.php::574</code>
					</h3><h4>Overview</h4>
						<p>Defines the number of seconds before expiring transients.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$expiration_time</td>
							<td>int</td>
							<td>Transient Expiration Time, in seconds.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_transient_expiration_time', function( $expiration_time ) {
	// ... your code here
	// Return value
	return $expiration_time;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_get_log_filters">
						wp_to_hootsuite_get_log_filters
						<code>lib/social/includes/class-common.php::608</code>
					</h3><h4>Overview</h4>
						<p>Defines the registered filters that can be used on the Log WP_List_Tables.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$filters</td>
							<td>array</td>
							<td>Filters.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_log_filters', function( $filters ) {
	// ... your code here
	// Return value
	return $filters;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_get_status_image_options">
						wp_to_hootsuite_get_status_image_options
						<code>lib/social/includes/class-image.php::82</code>
					</h3><h4>Overview</h4>
						<p>Defines the available Featured Image select dropdown options on a status, depending on the Plugin and Social Network the status message is for.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$options</td>
							<td>array</td>
							<td>Featured Image Dropdown Options.</td>
						</tr><tr>
							<td>$network</td>
							<td>string</td>
							<td>Social Network.</td>
						</tr><tr>
							<td>$post_type</td>
							<td>string</td>
							<td>Post Type.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_status_image_options', function( $options, $network, $post_type ) {
	// ... your code here
	// Return value
	return $options;
}, 10, 3 );
</pre>
<h3 id="wp_to_hootsuite_image_get_images_sources_convert">
						wp_to_hootsuite_image_get_images_sources_convert
						<code>lib/social/includes/class-image.php::185</code>
					</h3><h4>Overview</h4>
						<p>Defines the image ID to use as the image or additional image for the status message. If an image's mime type is not supported by the social media scheduling service, this filter can be used to convert the image to a supported type, store it in the Media Library and return the converted image ID. This is already performed for webp images.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$image_id</td>
							<td>int</td>
							<td>Image ID.</td>
						</tr><tr>
							<td>$source</td>
							<td>string</td>
							<td>Source Image ID was derived from (plugin, featured_image, post_content, text_to_image).</td>
						</tr><tr>
							<td>$service</td>
							<td>string</td>
							<td>Social Media Service the image is for. If not defined, just return the large version.</td>
						</tr><tr>
							<td>$image_mime_type</td>
							<td>string</td>
							<td>Image MIME Type.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_image_get_images_sources_convert', function( $image_id, $source, $service, $image_mime_type ) {
	// ... your code here
	// Return value
	return $image_id;
}, 10, 4 );
</pre>
<h3 id="wp_to_hootsuite_get_settings">
						wp_to_hootsuite_get_settings
						<code>lib/social/includes/class-settings.php::113</code>
					</h3><h4>Overview</h4>
						<p>Filters Post Type Settings before they are returned.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$settings</td>
							<td>array</td>
							<td>Settings.</td>
						</tr><tr>
							<td>$type</td>
							<td>string</td>
							<td>Post Type.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_settings', function( $settings, $type ) {
	// ... your code here
	// Return value
	return $settings;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_update_settings">
						wp_to_hootsuite_update_settings
						<code>lib/social/includes/class-settings.php::146</code>
					</h3><h4>Overview</h4>
						<p>Filters Post Type Settings before they are saved.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$settings</td>
							<td>array</td>
							<td>Settings.</td>
						</tr><tr>
							<td>$type</td>
							<td>string</td>
							<td>Post Type.</td>
						</tr><tr>
							<td>$existing_settings</td>
							<td>array</td>
							<td>Existing Settings.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_update_settings', function( $settings, $type, $existing_settings ) {
	// ... your code here
	// Return value
	return $settings;
}, 10, 3 );
</pre>
<h3 id="wp_to_hootsuite_default_installation_settings">
						wp_to_hootsuite_default_installation_settings
						<code>lib/social/includes/class-settings.php::258</code>
					</h3><h4>Overview</h4>
						<p>Filters Default Post Type Settings used on Plugin Activation before they are returned.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$settings</td>
							<td>array</td>
							<td>Settings.</td>
						</tr><tr>
							<td>$type</td>
							<td>string</td>
							<td>Post Type.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_default_installation_settings', function( $settings ) {
	// ... your code here
	// Return value
	return $settings;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_settings_get_default_status">
						wp_to_hootsuite_settings_get_default_status
						<code>lib/social/includes/class-settings.php::497</code>
					</h3><h4>Overview</h4>
						<p>Returns a skeleton status object for the given action, used when defining new status(es)</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$status</td>
							<td>array</td>
							<td>Status.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_settings_get_default_status', function( $status ) {
	// ... your code here
	// Return value
	return $status;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_settings_validate_status">
						wp_to_hootsuite_settings_validate_status
						<code>lib/social/includes/class-settings.php::607</code>
					</h3><h4>Overview</h4>
						<p>Filters status settings during validation, allowing them to be changed.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$status</td>
							<td>array</td>
							<td>Status.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_settings_validate_status', function( $status ) {
	// ... your code here
	// Return value
	return $status;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_update_option">
						wp_to_hootsuite_update_option
						<code>lib/social/includes/class-settings.php::956</code>
					</h3><h4>Overview</h4>
						<p>Filters the key and value pair before saving to the options table.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$value</td>
							<td>string</td>
							<td>Option Value.</td>
						</tr><tr>
							<td>$key</td>
							<td>string</td>
							<td>Option Key.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_update_option', function( $value, $key ) {
	// ... your code here
	// Return value
	return $value;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_validate_check_for_duplicates_status_keys">
						wp_to_hootsuite_validate_check_for_duplicates_status_keys
						<code>lib/social/includes/class-validation.php::132</code>
					</h3><h4>Overview</h4>
						<p>Defines the key values to compare across all statuses for a Post Type and Social Profile combination, to ensure no duplicate statuses have been defined.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$status_keys_to_compare</td>
							<td>array</td>
							<td>Status Key Values to Compare.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_validate_check_for_duplicates_status_keys', function( $status_keys_to_compare ) {
	// ... your code here
	// Return value
	return $status_keys_to_compare;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_notices_get_success_notices">
						wp_to_hootsuite_notices_get_success_notices
						<code>lib/social/includes/class-notices.php::136</code>
					</h3><h4>Overview</h4>
						<p>Filters the success notices to return.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$success_notices</td>
							<td>array</td>
							<td>Success Notices.</td>
						</tr><tr>
							<td>$notices</td>
							<td>object</td>
							<td>Success and Error Notices.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_notices_get_success_notices', function( $success_notices, $notices ) {
	// ... your code here
	// Return value
	return $success_notices;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_notices_get_warning_notices">
						wp_to_hootsuite_notices_get_warning_notices
						<code>lib/social/includes/class-notices.php::207</code>
					</h3><h4>Overview</h4>
						<p>Filters the error notices to return.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$warning_notices</td>
							<td>array</td>
							<td>Warning Notices.</td>
						</tr><tr>
							<td>$notices</td>
							<td>object</td>
							<td>Success, Warning and Error Notices.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_notices_get_warning_notices', function( $warning_notices, $notices ) {
	// ... your code here
	// Return value
	return $warning_notices;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_notices_get_error_notices">
						wp_to_hootsuite_notices_get_error_notices
						<code>lib/social/includes/class-notices.php::270</code>
					</h3><h4>Overview</h4>
						<p>Filters the error notices to return.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$error_notices</td>
							<td>array</td>
							<td>Error Notices.</td>
						</tr><tr>
							<td>$notices</td>
							<td>object</td>
							<td>Success and Error Notices.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_notices_get_error_notices', function( $error_notices, $notices ) {
	// ... your code here
	// Return value
	return $error_notices;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_notices_get_notices">
						wp_to_hootsuite_notices_get_notices
						<code>lib/social/includes/class-notices.php::327</code>
					</h3><h4>Overview</h4>
						<p>Filters the success and error notices to return.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$notices</td>
							<td>array</td>
							<td>Success and Error Notices.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_notices_get_notices', function( $notices ) {
	// ... your code here
	// Return value
	return $notices;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_notices_save">
						wp_to_hootsuite_notices_save
						<code>lib/social/includes/class-notices.php::371</code>
					</h3><h4>Overview</h4>
						<p>Filters the success and error notices to save.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$notices</td>
							<td>array</td>
							<td>Success and Error Notices.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_notices_save', function( $notices ) {
	// ... your code here
	// Return value
	return $notices;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_admin_get_autocomplete_configuration">
						wp_to_hootsuite_admin_get_autocomplete_configuration
						<code>lib/social/includes/class-admin.php::606</code>
					</h3><h4>Overview</h4>
						<p>Defines configuration for tribute.js autocomplete instances for Tags, Facebook Pages and Twitter Username mentions.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$autocomplete_configuration</td>
							<td>array</td>
							<td>Autocomplete Configuration.</td>
						</tr><tr>
							<td>$post_type</td>
							<td>string</td>
							<td>Post Type.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_admin_get_autocomplete_configuration', function( $autocomplete_configuration ) {
	// ... your code here
	// Return value
	return $autocomplete_configuration;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_admin_admin_menu_minimum_capability">
						wp_to_hootsuite_admin_admin_menu_minimum_capability
						<code>lib/social/includes/class-admin.php::632</code>
					</h3><h4>Overview</h4>
						<p>Defines the minimum capability required to access the Plugin's Menu and Sub Menus</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$capability</td>
							<td>string</td>
							<td>Minimum Required Capability.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_admin_admin_menu_minimum_capability', function( $minimum_capability ) {
	// ... your code here
	// Return value
	return $minimum_capability;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_common_convert_wordpress_gmt_offset_to_offset_value">
						wp_to_hootsuite_common_convert_wordpress_gmt_offset_to_offset_value
						<code>lib/social/includes/class-date.php::168</code>
					</h3><h4>Overview</h4>
						<p>Converts WordPress' GMT Offset (e.g. -5, +3.3) to an offset value compatible with WordPress' DateTime object (e.g. -0500, +0330)</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$gmt_offset</td>
							<td>string</td>
							<td>GMT Offset (e.g. -0500, +0330).</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_common_convert_wordpress_gmt_offset_to_offset_value', function( $gmt_offset ) {
	// ... your code here
	// Return value
	return $gmt_offset;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_get_log">
						wp_to_hootsuite_get_log
						<code>lib/social/includes/class-log.php::505</code>
					</h3><h4>Overview</h4>
						<p>Filters the log entries before output.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$log</td>
							<td>array</td>
							<td>Post Log.</td>
						</tr><tr>
							<td>$post_id</td>
							<td>int</td>
							<td>Post ID.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_get_log', function( $log, $post_id ) {
	// ... your code here
	// Return value
	return $log;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_log_get_result_options">
						wp_to_hootsuite_log_get_result_options
						<code>lib/social/includes/class-log.php::572</code>
					</h3><h4>Overview</h4>
						<p>Defines the available result options</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$result_options</td>
							<td>array</td>
							<td>Result Options.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_log_get_result_options', function( $result_options ) {
	// ... your code here
	// Return value
	return $result_options;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_log_get_log_levels">
						wp_to_hootsuite_log_get_log_levels
						<code>lib/social/includes/class-log.php::604</code>
					</h3><h4>Overview</h4>
						<p>Defines the available log levels</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$log_levels</td>
							<td>array</td>
							<td>Log Levels.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_log_get_log_levels', function( $log_levels ) {
	// ... your code here
	// Return value
	return $log_levels;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_publish_statuses">
						wp_to_hootsuite_publish_statuses
						<code>lib/social/includes/class-publish.php::663</code>
					</h3><h4>Overview</h4>
						<p>Determine the statuses to send, just before they're sent. Statuses can be added, edited and/or deleted as necessary here.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$statuses</td>
							<td>array</td>
							<td>Statuses to be sent to social media.</td>
						</tr><tr>
							<td>$post_id</td>
							<td>int</td>
							<td>Post ID.</td>
						</tr><tr>
							<td>$action</td>
							<td>string</td>
							<td>Action (publish, update, repost).</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_statuses', function( $statuses, $post_id, $action ) {
	// ... your code here
	// Return value
	return $statuses;
}, 10, 3 );
</pre>
<h3 id="wp_to_hootsuite_publish_build_args">
						wp_to_hootsuite_publish_build_args
						<code>lib/social/includes/class-publish.php::885</code>
					</h3><h4>Overview</h4>
						<p>Determine the standardised arguments array to send via the API for a status message's settings.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$args</td>
							<td>array</td>
							<td>API standardised arguments.</td>
						</tr><tr>
							<td>$post</td>
							<td>WP_Post</td>
							<td>WordPress Post.</td>
						</tr><tr>
							<td>$profile_id</td>
							<td>string</td>
							<td>Social Media Profile ID.</td>
						</tr><tr>
							<td>$service</td>
							<td>string</td>
							<td>Social Media Service.</td>
						</tr><tr>
							<td>$status</td>
							<td>array</td>
							<td>Parsed Status Message Settings.</td>
						</tr><tr>
							<td>$action</td>
							<td>string</td>
							<td>Action (publish|update|repost|bulk_publish).</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_build_args', function( $args, $post, $profile_id, $service, $status, $action ) {
	// ... your code here
	// Return value
	return $args;
}, 10, 6 );
</pre>
<h3 id="wp_to_hootsuite_publish_parse_text_term_hashtag">
						wp_to_hootsuite_publish_parse_text_term_hashtag
						<code>lib/social/includes/class-publish.php::1045</code>
					</h3><h4>Overview</h4>
						<p>Defines the Taxonomy Term Hashtag to replace the status template tag.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$term_name</td>
							<td>string</td>
							<td>Term Name.</td>
						</tr><tr>
							<td>$tag_params['taxonomy_term_format']</td>
							<td>string</td>
							<td>Term</td>
						</tr><tr>
							<td>$term</td>
							<td>WP_Term</td>
							<td>Term.</td>
						</tr><tr>
							<td>$tag_params['taxonomy']</td>
							<td>string</td>
							<td>Taxonomy.</td>
						</tr><tr>
							<td>$text</td>
							<td>string</td>
							<td>Status Text.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_parse_text_term_hashtag', function( $term_name, $tag_params['taxonomy_term_format'], $term, $tag_params['taxonomy'], $text ) {
	// ... your code here
	// Return value
	return $term_name;
}, 10, 5 );
</pre>
<h3 id="wp_to_hootsuite_term">
						wp_to_hootsuite_term
						<code>lib/social/includes/class-publish.php::1059</code>
					</h3><h4>Overview</h4>
						<p>Backward compat filter to define the Taxonomy Term Name to replace the status template tag. _publish_parse_text_term_name and _publish_parse_text_term_hashtag should be used instead.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$term_name</td>
							<td>string</td>
							<td>Term Name.</td>
						</tr><tr>
							<td>$term->name</td>
							<td>string</td>
							<td>Term Name.</td>
						</tr><tr>
							<td>$tag_params['taxonomy']</td>
							<td>string</td>
							<td>Taxonomy.</td>
						</tr><tr>
							<td>$text</td>
							<td>string</td>
							<td>Status Text.</td>
						</tr><tr>
							<td>$tag_params['taxonomy_term_format']</td>
							<td>string</td>
							<td>Term Format.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_term', function( $term_name, $term->name, $tag_params['taxonomy'], $text, $tag_params['taxonomy_term_format'] ) {
	// ... your code here
	// Return value
	return $term_name;
}, 10, 5 );
</pre>
<h3 id="wp_to_hootsuite_publish_parse_text">
						wp_to_hootsuite_publish_parse_text
						<code>lib/social/includes/class-publish.php::1110</code>
					</h3><h4>Overview</h4>
						<p>Filters the parsed status message text on a status.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$text</td>
							<td>string</td>
							<td>Parsed Text, no Tags.</td>
						</tr><tr>
							<td>$message</td>
							<td>string</td>
							<td>Unparsed Text with Tags.</td>
						</tr><tr>
							<td>$searches_replacements</td>
							<td>array</td>
							<td>Specific Tag Search and Replacements for the given Text.</td>
						</tr><tr>
							<td>$all_possible_searches_replacements</td>
							<td>array</td>
							<td>All Registered Tag Search and Replacements.</td>
						</tr><tr>
							<td>$post</td>
							<td>WP_Post</td>
							<td>WordPress Post.</td>
						</tr><tr>
							<td>$author</td>
							<td>WP_User</td>
							<td>WordPress User (Author).</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_parse_text', function( $text, $message, $searches_replacements, $all_possible_searches_replacements, $post, $author ) {
	// ... your code here
	// Return value
	return $text;
}, 10, 6 );
</pre>
<h3 id="wp_to_hootsuite_publish_parse_google_business_start_date_  statusgooglebusinessstart_date_option">
						wp_to_hootsuite_publish_parse_google_business_start_date_  statusgooglebusinessstart_date_option
						<code>lib/social/includes/class-publish.php::1212</code>
					</h3><h4>Overview</h4>
						<p>Allows integrations to define the status' start date for a Google Business Profile Offer or Event.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>Date</td>
							<td>bool|string $date</td>
							<td>(yyyy-mm-dd</td>
						</tr><tr>
							<td>$google_business_args</td>
							<td>array</td>
							<td>Google Business specific arguments for status.</td>
						</tr><tr>
							<td>$status</td>
							<td>array</td>
							<td>Status.</td>
						</tr><tr>
							<td>$post</td>
							<td>WP_Post</td>
							<td>WordPress Post.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_parse_google_business_start_date_  statusgooglebusinessstart_date_option', function( $date, $google_business_args, $status, $post ) {
	// ... your code here
	// Return value
	return $date;
}, 10, 4 );
</pre>
<h3 id="wp_to_hootsuite_publish_parse_google_business_end_date_  statusgooglebusinessend_date_option">
						wp_to_hootsuite_publish_parse_google_business_end_date_  statusgooglebusinessend_date_option
						<code>lib/social/includes/class-publish.php::1272</code>
					</h3><h4>Overview</h4>
						<p>Allows integrations to define the status' end date for a Google Business Profile Offer or Event.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>Date</td>
							<td>bool|string $date</td>
							<td>(yyyy-mm-dd</td>
						</tr><tr>
							<td>$google_business_args</td>
							<td>array</td>
							<td>Google Business specific arguments for status.</td>
						</tr><tr>
							<td>$status</td>
							<td>array</td>
							<td>Status.</td>
						</tr><tr>
							<td>$post</td>
							<td>WP_Post</td>
							<td>WordPress Post.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_parse_google_business_end_date_  statusgooglebusinessend_date_option', function( $date, $google_business_args, $status, $post ) {
	// ... your code here
	// Return value
	return $date;
}, 10, 4 );
</pre>
<h3 id="wp_to_hootsuite_publish_apply_text_transformation">
						wp_to_hootsuite_publish_apply_text_transformation
						<code>lib/social/includes/class-publish.php::1434</code>
					</h3><h4>Overview</h4>
						<p>Applies the given transformation to the given value</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$value</td>
							<td>string</td>
							<td>Value.</td>
						</tr><tr>
							<td>$transformation</td>
							<td>string</td>
							<td>Transformation.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_apply_text_transformation', function( $value, $transformation ) {
	// ... your code here
	// Return value
	return $value;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_publish_get_all_possible_searches_replacements">
						wp_to_hootsuite_publish_get_all_possible_searches_replacements
						<code>lib/social/includes/class-publish.php::1474</code>
					</h3><h4>Overview</h4>
						<p>Registers any additional status message tags, and their Post data replacements, that are supported.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$searches_replacements</td>
							<td>array</td>
							<td>Registered Supported Tags and their Replacements.</td>
						</tr><tr>
							<td>$post</td>
							<td>WP_Post</td>
							<td>WordPress Post.</td>
						</tr><tr>
							<td>$author</td>
							<td>WP_User</td>
							<td>WordPress User (Author of the Post).</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_get_all_possible_searches_replacements', function( $searches_replacements, $post, $author ) {
	// ... your code here
	// Return value
	return $searches_replacements;
}, 10, 3 );
</pre>
<h3 id="wp_to_hootsuite_publish_register_post_searches_replacements">
						wp_to_hootsuite_publish_register_post_searches_replacements
						<code>lib/social/includes/class-publish.php::1548</code>
					</h3><h4>Overview</h4>
						<p>Registers any additional status message tags, and their Post data replacements, that are supported for the given Post.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$searches_replacements</td>
							<td>array</td>
							<td>Registered Supported Tags and their Replacements.</td>
						</tr><tr>
							<td>$post</td>
							<td>WP_Post</td>
							<td>WordPress Post.</td>
						</tr><tr>
							<td>$taxonomies</td>
							<td>array</td>
							<td>Post Taxonomies.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_register_post_searches_replacements', function( $searches_replacements, $post, $taxonomies ) {
	// ... your code here
	// Return value
	return $searches_replacements;
}, 10, 3 );
</pre>
<h3 id="wp_to_hootsuite_publish_get_title">
						wp_to_hootsuite_publish_get_title
						<code>lib/social/includes/class-publish.php::1577</code>
					</h3><h4>Overview</h4>
						<p>Filters the dynamic {title} replacement, when a Post's status is being built.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$title</td>
							<td>string</td>
							<td>Post Title.</td>
						</tr><tr>
							<td>$post</td>
							<td>WP_Post</td>
							<td>WordPress Post.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_get_title', function( $title, $post ) {
	// ... your code here
	// Return value
	return $title;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_publish_get_excerpt">
						wp_to_hootsuite_publish_get_excerpt
						<code>lib/social/includes/class-publish.php::1622</code>
					</h3><h4>Overview</h4>
						<p>Filters the dynamic {excerpt} replacement, when a Post's status is being built.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$excerpt</td>
							<td>string</td>
							<td>Post Excerpt.</td>
						</tr><tr>
							<td>$post</td>
							<td>WP_Post</td>
							<td>WordPress Post.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_get_excerpt', function( $excerpt, $post ) {
	// ... your code here
	// Return value
	return $excerpt;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_publish_get_content">
						wp_to_hootsuite_publish_get_content
						<code>lib/social/includes/class-publish.php::1699</code>
					</h3><h4>Overview</h4>
						<p>Filters the dynamic {content} replacement, when a Post's status is being built.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$content</td>
							<td>string</td>
							<td>Post Content.</td>
						</tr><tr>
							<td>$post</td>
							<td>WP_Post</td>
							<td>WordPress Post.</td>
						</tr><tr>
							<td>$is_gutenberg_request_content</td>
							<td>bool</td>
							<td>Is Gutenberg Post Content.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_get_content', function( $content, $post, $is_gutenberg_request_content ) {
	// ... your code here
	// Return value
	return $content;
}, 10, 3 );
</pre>
<h3 id="wp_to_hootsuite_publish_get_date">
						wp_to_hootsuite_publish_get_date
						<code>lib/social/includes/class-publish.php::1726</code>
					</h3><h4>Overview</h4>
						<p>Returns the date in the locale specified in WordPress.private function get_date( $post ) {$date = date_i18n( get_option( 'date_format' ), strtotime( $post->post_date ) );/ Filters the dynamic {date} replacement, when a Post's status is being built.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>WordPress</td>
							<td>WP_Post $post</td>
							<td>Post.</td>
						</tr><tr>
							<td>$date</td>
							<td>string</td>
							<td>Date.</td>
						</tr><tr>
							<td>$post</td>
							<td>WP_Post</td>
							<td>WordPress Post.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_get_date', function( $date, $post ) {
	// ... your code here
	// Return value
	return $date;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_publish_get_permalink">
						wp_to_hootsuite_publish_get_permalink
						<code>lib/social/includes/class-publish.php::1769</code>
					</h3><h4>Overview</h4>
						<p>Filters the Post's Permalink, including or excluding a trailing slash, depending on the Plugin settings</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$url</td>
							<td>string</td>
							<td>WordPress Post Permalink.</td>
						</tr><tr>
							<td>$post</td>
							<td>WP_Post</td>
							<td>WordPress Post.</td>
						</tr><tr>
							<td>$force_trailing_forwardslash</td>
							<td>bool</td>
							<td>Force Trailing Forwardslash.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_get_permalink', function( $url, $post, $force_trailing_forwardslash ) {
	// ... your code here
	// Return value
	return $url;
}, 10, 3 );
</pre>
<h3 id="wp_to_hootsuite_publish_get_short_permalink">
						wp_to_hootsuite_publish_get_short_permalink
						<code>lib/social/includes/class-publish.php::1797</code>
					</h3><h4>Overview</h4>
						<p>Filters the Post's Permalink, including or excluding a trailing slash, depending on the Plugin settings</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$url</td>
							<td>string</td>
							<td>WordPress Post Permalink.</td>
						</tr><tr>
							<td>$post</td>
							<td>WP_Post</td>
							<td>WordPress Post.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_get_short_permalink', function( $url, $post ) {
	// ... your code here
	// Return value
	return $url;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_publish_apply_word_limit">
						wp_to_hootsuite_publish_apply_word_limit
						<code>lib/social/includes/class-publish.php::1949</code>
					</h3><h4>Overview</h4>
						<p>Applies the given word limit to the given text.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$text</td>
							<td>string</td>
							<td>Text, with word limit applied.</td>
						</tr><tr>
							<td>$word_limit</td>
							<td>int</td>
							<td>Sentence Limit.</td>
						</tr><tr>
							<td>$original_text</td>
							<td>string</td>
							<td>Original Text, with no limit applied.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_apply_word_limit', function( $text, $word_limit, $original_text ) {
	// ... your code here
	// Return value
	return $text;
}, 10, 3 );
</pre>
<h3 id="wp_to_hootsuite_publish_apply_sentence_limit">
						wp_to_hootsuite_publish_apply_sentence_limit
						<code>lib/social/includes/class-publish.php::2010</code>
					</h3><h4>Overview</h4>
						<p>Applies the given sentence limit to the given text.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$text</td>
							<td>string</td>
							<td>Text, with word limit applied.</td>
						</tr><tr>
							<td>$sentence_limit</td>
							<td>int</td>
							<td>Sentence Limit.</td>
						</tr><tr>
							<td>$original_text</td>
							<td>string</td>
							<td>Original Text, with no limit applied.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_apply_sentence_limit', function( $text, $sentence_limit, $original_text ) {
	// ... your code here
	// Return value
	return $text;
}, 10, 3 );
</pre>
<h3 id="wp_to_hootsuite_publish_apply_character_limit">
						wp_to_hootsuite_publish_apply_character_limit
						<code>lib/social/includes/class-publish.php::2051</code>
					</h3><h4>Overview</h4>
						<p>Filters the character limited text.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$text</td>
							<td>string</td>
							<td>Text, with character limit applied.</td>
						</tr><tr>
							<td>$character_limit</td>
							<td>int</td>
							<td>Character Limit used.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_publish_apply_character_limit', function( $text, $character_limit ) {
	// ... your code here
	// Return value
	return $text;
}, 10, 2 );
</pre>
<h3 id="wp_to_hootsuite_api_request_timeout">
						wp_to_hootsuite_api_request_timeout
						<code>lib/social/includes/class-api.php::92</code>
					</h3><h4>Overview</h4>
						<p>Defines the number of seconds before timing out a request to the remote API.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$timeout</td>
							<td>int</td>
							<td>Timeout, in seconds.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_api_request_timeout', function( $timeout ) {
	// ... your code here
	// Return value
	return $timeout;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_api_request">
						wp_to_hootsuite_api_request
						<code>includes/class-owly-api.php::126</code>
					</h3><h4>Overview</h4>
						<p>Defines the number of seconds before timing out a request to the Owly API.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$timeout</td>
							<td>int</td>
							<td>Timeout, in seconds</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_api_request', function( $timeout ) {
	// ... your code here
	// Return value
	return $timeout;
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_api_request">
						wp_to_hootsuite_api_request
						<code>includes/class-hootsuite-api.php::849</code>
					</h3><h4>Overview</h4>
						<p>Defines the number of seconds before timing out a request to the Hootsuite API.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$timeout</td>
							<td>int</td>
							<td>Timeout, in seconds.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'wp_to_hootsuite_api_request', function( $timeout ) {
	// ... your code here
	// Return value
	return $timeout;
}, 10, 1 );
</pre>
<h1>Actions</h1><table>
				<thead>
					<tr>
						<th>File</th>
						<th>Filter Name</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody><tr>
						<td colspan="3">../lib/social/includes/class-notices.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_notices_delete_notices"><code>wp_to_hootsuite_notices_delete_notices</code></a></td>
						<td></td>
					</tr><tr>
						<td colspan="3">../lib/social/includes/class-admin.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_save_settings_auth"><code>wp_to_hootsuite_save_settings_auth</code></a></td>
						<td></td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_admin_admin_menu"><code>wp_to_hootsuite_admin_admin_menu</code></a></td>
						<td>Add settings menus and sub menus for the Plugin's settings.</td>
					</tr><tr>
						<td colspan="3">/settings-auth-required.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#wp_to_hootsuite_output_auth"><code>wp_to_hootsuite_output_auth</code></a></td>
						<td>Allow the API to output its authentication button link or form, to authenticate with the API.</td>
					</tr>
					</tbody>
				</table><h3 id="wp_to_hootsuite_notices_delete_notices">
						wp_to_hootsuite_notices_delete_notices
						<code>lib/social/includes/class-notices.php::400</code>
					</h3><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table><h4>Usage</h4>
<pre>
do_action( 'wp_to_hootsuite_notices_delete_notices', function(  ) {
	// ... your code here
}, 10, 0 );
</pre>
<h3 id="wp_to_hootsuite_save_settings_auth">
						wp_to_hootsuite_save_settings_auth
						<code>lib/social/includes/class-admin.php::196</code>
					</h3><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table><h4>Usage</h4>
<pre>
do_action( 'wp_to_hootsuite_save_settings_auth', function(  ) {
	// ... your code here
}, 10, 0 );
</pre>
<h3 id="wp_to_hootsuite_admin_admin_menu">
						wp_to_hootsuite_admin_admin_menu
						<code>lib/social/includes/class-admin.php::641</code>
					</h3><h4>Overview</h4>
						<p>Add settings menus and sub menus for the Plugin's settings.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$minimum_capability</td>
							<td>string</td>
							<td>Minimum capability required.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
do_action( 'wp_to_hootsuite_admin_admin_menu', function( $minimum_capability ) {
	// ... your code here
}, 10, 1 );
</pre>
<h3 id="wp_to_hootsuite_output_auth">
						wp_to_hootsuite_output_auth
						<code>/settings-auth-required.php::71</code>
					</h3><h4>Overview</h4>
						<p>Allow the API to output its authentication button link or form, to authenticate with the API.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$schedule</td>
							<td>array</td>
							<td>Schedule Options</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
do_action( 'wp_to_hootsuite_output_auth', function(  ) {
	// ... your code here
}, 10, 0 );
</pre>
