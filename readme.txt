=== Social Media Auto Poster - Schedule & Publish to Hootsuite ===
Contributors: n7studios,wpzinc
Donate link: https://www.wpzinc.com/plugins/wordpress-to-hootsuite-pro
Tags: social media automation, auto post, hootsuite, social media scheduler, auto publish
Requires at least: 5.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 3.1.3
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Automatically post and schedule your WordPress content to Facebook, X/Twitter, LinkedIn, Threads and more social networks using Hootsuite.

== Description ==

Social Media Auto Poster connects your WordPress site to Hootsuite, enabling automatic social media publishing whenever you create or update content. Share your blog posts, pages, and custom post types to multiple social networks without manual posting.

=== Why Choose This Social Media Automation Plugin? ===

This plugin eliminates repetitive social media posting by automatically adding your WordPress content to social media via Hootsuite.

**Automatic Social Media Publishing** - Set it once and your content automatically shares to social media when published or updated.

**Compatible Social Networks** - Auto post to Facebook Pages, Twitter (X), LinkedIn, Threads, Pinterest and Bluesky.

**Dynamic Content Templates** - Customize each social media post using template tags that pull your post title, excerpt, content, featured image, categories, tags, and custom fields.

Don't have a Hootsuite account? [Sign up for free](https://join.Hootsuite.com/wpzinc)

[youtube https://www.youtube.com/watch?v=GESEMwKSSQg]

=== How to Auto Post to Social Media with Hootsuite ===

1. **Connect Your Hootsuite Account** - Simple one-click authorization, no API keys or technical setup required
2. **Link Your Social Networks** - Connect Facebook, X/Twitter, LinkedIn, and other profiles through Hootsuite's interface
3. **Configure Post Settings** - Choose which post types to share and customize your social media message templates
4. **Publish Content** - Your WordPress posts automatically share to social media according to your Hootsuite schedule

=== Social Media Networks Supported ===

**Facebook Auto Posting** - Share to Facebook Pages automatically when you publish WordPress content.

**X/Twitter Auto Posting** - Still works! Hootsuite is [not impacted](https://x.com/Hootsuite/status/1652659063073783808) by X/Twitter API changes. Auto post to Twitter (X) reliably.

**LinkedIn Auto Posting** - Publish to LinkedIn Company Pages and personal LinkedIn Profiles to grow your professional network.

**Instagram & Pinterest** (Pro) - Direct posting to Instagram Business Profiles (Feed and Stories) and Pinterest Boards available in [Pro version](https://www.wpzinc.com/plugins/wordpress-to-Hootsuite-pro/).

**Additional Networks** - Threads, Google Business Profile, Mastodon, Bluesky, and TikTok support included.

=== Dynamic Template Tags for Customized Posts ===

Create unique social media messages using template tags:

* **{title}** - Your post title
* **{excerpt}** - Post excerpt (with character/word limits)
* **{content}** - Post content (with character/word limits)
* **{url}** - Post permalink
* **{date}** - Publication date
* **{taxonomy_post_tag}** - Tags as hashtags
* **{taxoomy_category}** - Categories as hashtags

=== Better Than Traditional Auto Posting Plugins ===

Unlike direct posting plugins (WP to Facebook, WP to Twitter clones), this plugin uses Hootsuite's smart queue system. Benefits include:

**Prevents Social Media Penalties** - Hootsuite spaces posts naturally, avoiding spam flags from posting too frequently
**Optimized Timing** - Schedule posts for when your audience is most active
**Cross-Network Management** - Manage all social networks from one Hootsuite dashboard
**No API Complications** - Hootsuite handles all social network API connections and changes
**Duplicate Prevention** - Built-in protection ensures you never post the same content twice

=== Pro Version Features ===

> <a href="https://www.wpzinc.com/plugins/wordpress-to-Hootsuite-pro/" rel="friend" title="WordPress to Hootsuite Pro">WordPress to Hootsuite Pro</a> includes advanced social media automation features:<br />
>
> **Instagram and Pinterest Support** - Direct posting to Instagram Business Profiles (Feed and Stories) and Pinterest Boards
>
> **Multiple Hootsuite Accounts** - Connect multiple Hootsuite accounts to one WordPress site
>
> **Advanced Scheduling Options** - Post immediately, add to start/end of Hootsuite queue, or schedule for specific times
>
> **Conditional Publishing** - Send posts to social media based on author, category, tags, or custom field values
>
> **Multiple Status Templates** - Create different messages for each social network with unique templates per post type
>
> **Repost Old Posts** - Automatically reshare evergreen content on social media at scheduled intervals
>
> **Bulk Publish Feature** - Manually select and republish multiple posts to social media at once
>
> **Event Calendar Integration** - Schedule social posts based on event dates from The Events Calendar, Event Manager, and Modern Events Calendar
>
> **WooCommerce Integration** - Display product prices, SKUs, and other WooCommerce data in social media posts
>
> **SEO Plugin Integration** - Use SEO titles, descriptions, and meta data from Yoast SEO, Rank Math, All-In-One SEO Pack, and SEOPress
>
> **Advanced Custom Fields Support** - Pull any custom field data into social media messages
>
> **Multiple Images** - Share multiple images from Featured Image, Media Gallery, Post Content, or ACF Image fields
>
> **WP-Cron Support** - Queue posts to send via WP-Cron for better performance on high-traffic sites
>
> **Priority Email Support** - One-on-one support with our team
>
> [Upgrade to Pro](https://www.wpzinc.com/plugins/wordpress-to-Hootsuite-pro/)

=== How to Schedule Social Media Posts ===

**Default Hootsuite Schedule** - Hootsuite automatically spaces posts throughout the day based on your time zone preferences

**Immediate Posting** - Override the queue and post immediately to social media

**Custom Posting Schedule** (Pro) - Define specific days and times in Hootsuite when posts should publish to each social network

**Scheduled Publishing** (Pro) - Set exact date and time for each social media post

=== Support for Free Version ===

We provide community support through the <a href="https://wordpress.org/support/plugin/wp-to-Hootsuite/">WordPress support forums</a>.

For priority email support, comprehensive documentation, and faster response times, consider <a href="http://www.wpzinc.com/plugins/wordpress-to-Hootsuite-pro" rel="friend">upgrading to Pro</a>.

=== Privacy and Data Usage ===

Our [API](https://www.wpzinc.com/documentation/wordpress-Hootsuite-pro/data/) connects your website to [Hootsuite](https://Hootsuite.com/join/6392aeec568614de895ed38fafa7784b8718c77dc7800419bdfbbacaaaa793d8). An account with Hootsuite is required.

We connect directly to your Hootsuite (Hootsuite.com) account, via their API, to:
- Fetch your social media profile names and IDs, 
- Send your WordPress Posts to one or more of your social media profiles.  The profiles and content sent will depend on the plugin settings you have configured.

We connect to our own [API](https://www.wpzinc.com/documentation/wordpress-Hootsuite-pro/data/) to pass the following requests through to Hootsuite:
- Connect our Plugin to Hootsuite, when you click the Authorize button (this obtains an access token from Hootsuite, once you have approved authorization)

Both of these are done via our own API, to ensure that no secret data (such as oAuth client secret keys) are included in this Plugin's code or made public.

We **never** store any information on our web site or API during this process.

== Installation ==

1. Upload the `wp-to-hootsuite` folder to the `/wp-content/plugins/` directory
2. Active the WordPress to Hootsuite plugin through the 'Plugins' menu in WordPress
3. Configure the plugin by going to the `WordPress to Hootsuite` menu that appears in your admin menu

== Frequently Asked Questions ==

== Screenshots ==

1. Settings Screen when Plugin is first installed.
2. Settings Screen when Hootsuite is authorized.
3. Settings Screen showing available options for Posts.
4. Post-level Logging.

== Changelog ==

= 3.1.3 (2026-08-24) =
* Fix: Authentication: Only show Reconnect button if the connection has expired

= 3.1.2 (2026-08-21) =
* Added: PHPStan static analysis improvements

= 3.1.1 (2026-08-20) =
* Fix: Status: Images: Don't attempt to assign image to status if no image exists

= 3.1.0 (2026-08-19) =
* Added: Namespaced `WPZinc\Social` (previously `WP_To_Social_*` classes) and `WPZinc\Shared` (previously WPZincDashboardSubmodule)
* Updated: Improved WordPress Coding Standards for dates
* Fix: Authentication: OAuth: Use nonce for improved security when connecting to Hootsuite

= 3.0.1 (2026-05-28) =
* Fix: PHP Warning: Attempt to read property "base" on null
* Fix: Store refreshed tokens

= 3.0.0 (2026-05-26) =
* Added: Status: Type. See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/status-settings/#type
* Fix: Settings: Authentication: Align account name with Reconnect + Disconnect buttons
* Removed: Status: Image: No Image, OpenGraph and Feat. Image, Linked to Post. See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/featured-image-settings/

= 1.7.0 (2026-05-20) =
* Fix: Automatically delete temporary images
* Updated: Coding standards
* Updated: Sanitization

= 1.6.7 (2026-04-08) =
* Removed: Settings: Products section

= 1.6.6 (2026-04-02) =
* Added: Status: Display notice if settings do not save and WordPress options table charset and default collation are invalid
* Updated: Dashboard submodule

= 1.6.5 (2025-11-17) =
* Fix: Logs: PHP Warning: Undefined array key `0`

= 1.6.4 (2025-10-17) =
* Fix: Status: Text: Taxonomy: Retain non-Latin characters

= 1.6.3 (2025-06-30) =
* Fix: Remove unnecessary `migrate_settings` routine 

= 1.6.2 (2025-04-23) =
* Fix: Notice: Function `_load_textdomain_just_in_time` was called incorrectly in WordPress 6.8 and higher

= 1.6.1 (2025-03-27) =
* Updated: Coding standards

= 1.6.0 (2025-03-06) =
* Fix: Logs: Add nonce check on Bulk Actions and Clear Log functionality

= 1.5.9 (2025-02-27) =
* Added: Optimized admin CSS for better performance

= 1.5.8 (2025-02-19) =
* Added: Updated UI

= 1.5.7.1 (2024-11-25) =
* Fix: Notice: Function _load_textdomain_just_in_time was called incorrectly in WordPress 6.7 and higher

= 1.5.6 (2024-10-08) =
* Fix: Hootsuite API Error: #400: 5000: Unknown error occurred when attempting to publish a status with an image

= 1.5.5 (2024-07-22) =
* Added: Status: Text: Convert HTML links to plain text without link in brackets when using {excerpt}.
* Fix: Status: Strip inline styles when using {content}

= 1.5.4 (2023-11-17) =
* Fix: Hootsuite API Error: #400: 5000: Unknown error occurred when attempting to publish a status with an image

= 1.5.3 (2023-10-09) =
* Fix: Correctly detect and differentiate REST API requests from Gutenberg REST API requests, ensuring REST API requests trigger status(es)

= 1.5.2 (2023-09-07) =
* Fix: Updated dashboard submodule

= 1.5.1 (2023-08-23) =
* Fix: Updated WordPress Coding Standards to 3.0.0

= 1.5.0 (2023-08-03) =
* Added: Plugins: Link to settings screen
* Fix: Remove duplicate call to load_language_files()
* Fix: PHP Deprecated notices in PHP 8.2

= 1.4.9 (2023-05-16) =
* Fix: Post: Log: Export Log: Check user can edit posts to permit export log functionality

= 1.4.8 (2023-01-26) =
* Added: Log: Log errors when image operations (resizing, converting, uploading to Media Library) fails
* Fix: Use get_temp_dir() instead of assumed /tmp folder for writing temporary images when resizing, converting or generating text to image
* Fix: Status: Clear profiles cache when deauthorizing and authorizing with a different Hootsuite account
* Fix: Improved WordPress Coding Standards
* Fix: Removed clipboard.js, as WordPress provides this library

= 1.4.7 (2022-10-25) =
* Fix: Remove unused 1200x1200 registered image size

= 1.4.6 (2022-06-21) =
* Fix: Status: Correctly sanitize and escape status textarea field value to prevent possible XSS

= 1.4.5 (2022-06-09) =
* Added: Support for WordPress 6.0

= 1.4.4 (2022-05-12) =
* Fix: Multisite: Activation: Conditionally load required hook depending on WordPress version

= 1.4.3 (2022-04-24) =
* Fix: Upgrade link would incorrectly redirect to WordPress Admin dashboard

= 1.4.2 (2022-03-08) =
* Fix: Call to undefined function _disable_block_editor_for_navigation_post_type when creating/updating Post in Gutenberg or via the REST API in WordPress 5.9+
* Fix: Scheduled Posts: Publish action would not run when using Gutenberg
* Fix: Customizer: Don't load inline CSS for menu icon when loading WordPress Admin > Theme > Customize

= 1.4.1 (2022-03-03) =
* Added: Status: Insert Tags: Insert tag at textarea caret position, with leading/trailing space as applicable
* Fix: Multisite: Activation: Use wp_insert_site hook when available in WordPress 5.1 and higher

= 1.4.0 (2021-12-22) =
* Added: Support for images added to the Media Library by Plugins that don't store images locally e.g. External Media without Import
* Added: Status: Tags: {date} uses WordPress Admin > Settings > Site Language and Date Format options.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/status-text-tags/#available-tags
* Fix: Always include WordPress media functions when converting a WebP image to JPEG and storing it in the Media Library to avoid PHP errors

= 1.3.9 (2021-09-17) =
* Fix: Logs: Correctly escape search and form action

= 1.3.8 (2021-09-16) =
* Fix: PHP Deprecated notices in PHP 8

= 1.3.7 (2021-09-09) =
* Added: Status: Text: Convert HTML links to plain text with link in brackets, instead of just displaying the unlinked text
* Added: Status: Text: Convert HTML lists to plain text with hyphens, instead of just displaying plain text
* Added: Status: Image: Support for .webp images when Use Feat. Image enabled and .webp image used as Featured Image. See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/featured-image-settings/#webp-image-support
* Added: Status: Remove HTML from shortcodes included in status text

= 1.3.6 (2021-07-15) =
* Added: New Installations: Clearer workflow for connecting to Hootsuite and connecting social media profiles to Hootsuite account.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/authentication-settings/
* Added: Status: Tags: Character Limit, Sentence Limit, Word Limit, Date and URL Encoding transformations.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/status-text-tags/#applying-transformations
* Fix: Don't minify Plugin Javascript if a third party minification Plugin is active, which would prevent status settings from sometimes saving
* Fix: Status: PowerPress: Prevent PowerPress from appending podcast URL to Content and Excerpt tags. 

= 1.3.5 (2021-06-10) =
* Fix: Authorization: Changed oAuth Authorization URL to prevent 404 error
* Fix: Authorization: More detailed error message displayed when Hootsuite API fails

= 1.3.4 (2021-04-29) =
* Added: Status: Text: Autocomplete suggestions for Tags.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/status-text-tags/#autocomplete-suggestions

= 1.3.3 (2021-04-15) =
* Added: Settings: Post Type: Show prompt if changes made but unsaved when navigating away from the status settings
* Fix: Log: Warning: `Edit the Post` link correctly loads the Edit Post screen

= 1.3.2 (2021-04-01) =
* Added: Settings: Post Type: Immediately show/hide green tick on Post Type tab after clicking Save, to confirm whether the Post Type is configured to send status(es) to Hootsuite
* Fix: Settings: Post Type: Profile: Text order and links were incorrect when displaying a Timezone warning

= 1.3.1 (2021-03-18) =
* Added: Log: Enable wp-content/debug.log only when WP_DEBUG=true, WP_DEBUG_LOG=true, WP_DEBUG_DISPLAY=false and Plugin Logging enabled.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/repost-settings/#testing
* Added: Localization support, with .pot file and translators comments
* Fix: Status: Retain paragraphs when using {content} tag
* Fix: Settings: Log Settings: Corrected link to Logs screen, and don't link "Plugin Logs" text when logging not enabled
* Fix: Log: Don't show Logs in Plugin Submenu if Logging is disabled

= 1.3.0 (2021-01-07) =
* Added: Status: If a Featured Image is required, attempt to fetch it from the Post Content when a Featured Image has not been specified

= 1.2.9 (2020-12-22) =
* Fix: Status: Removed debugging code

= 1.2.8 (2020-12-21) =
* Fix: Status: Include Featured Image with status when required

= 1.2.7 (2020-11-27) =
* Added: Display error notice if PHP cURL extension is not installed
* Added: Settings: Force Trailing Forwardslash: Updated description to clarify why this setting might need to be enabled i.e. for correct status image
* Fix: Settings: Force Trailing Forwardslash: Truly force a forwardslash if Permalink settings don't add one.

= 1.2.6 (2020-09-03) =
* Added: Logs: Screen Options: Choose table columns to display.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/log-settings/#define-table-columns-to-display
* Added: Logs: Screen Options: Choose number of logs per page to display.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/log-settings/#define-number-of-logs-per-page
* Fix: Status: Enabling/Disabling Publish or Update wouldn't update green tick in tab UI in WordPress 5.5+
* Fix: Status: Don't display "Post sucessfully added" admin notification if Test Mode is enabled
* Fix: Logs: Lighter success/error row background colors to make text easier to read
* Fix: Logs: When filtering by date, include results matching the date, not just results between the dates

= 1.2.5 (2020-08-20) =
* Added: Settings: General Settings: Enable Test Mode. See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/general-settings/#enable-test-mode
* Added: Settings: Logs: Option to choose specific Log Levels.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/log-settings/#log-level
* Added: Settings: Logs: Added Pending Log Level, for status(es) due to be sent when Use WP Cron enabled in Plugin's Settings.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/log-settings/#log-level
* Added: Logs: Confirmation when clicking Clear Log button
* Fix: Logs: Set Clear Log button to red
* Fix: Logs: Clear Log: Contextualized confirmation message based on whether the Log is being cleared at Post or Plugin level
* Fix: Fatal error when detecting current admin screen on some Page Builders 
* Fix: Some notifications weren't dismissible

= 1.2.4 =
* Fix: Prevent fatal error when upgrading to Pro when Free is still active 

= 1.2.3 =
* Added: Settings: General Settings: Use Proxy option.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/general-settings/#use-proxy-
* Added: Settings: Log Settings: Log Level option.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/log-settings/#log-level 
* Fix: Log: Honor Enabled Setting, ensuring logging does not take place if not enabled

= 1.2.2 =
* Added: Status: Option to specify Taxonomy Tags
* Fix: Status: Taxonomy Tags: Remove non-alphanumeric characters to avoid breaking tag links

= 1.2.1 =
* Fix: CSS: Renamed option class to wpzinc-option to avoid CSS conflicts with third party Plugins
* Fix: Log: Unknown column 'status' in 'where clause' for query when clearing pending status log entries
* Fix: Elementor: Removed unused tooltip classes to prevent Menu and Element Icons from not displaying

= 1.2.0 =
* Added: Forms: Accessibility: Replaced Titles with <label> elements that focus the given input element on click
* Added: General Settings: Option to force trailing forwardslash on {url}.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/general-settings/#force-trailing-forwardslash 
* Fix: Activation: Prevent DB character set / collation errors on table creation by using WordPress' native get_charset_collate()
* Fix: Log: Call to undefined method WP_To_Social_Pro_Log::clear_pending_log()
* Fix: Log: Display Status Text's breaklines
* Fix: Status: Don't send status(es) to Hootsuite for non-public Post Types containing Post-level Status Settings copied from a public Post.
* Fix: Status: More verbose error message when a status is too long for the target social network 
* Fix: Status: Use AJAX to save statuses to avoid settings not saving or changing when PHP's max_input_vars is exceeded due to e.g. several profiles and statuses defined
* Fix: Status: Better method to remove double/triple spaces in text whilst retaining newlines/breaklines and unicode/accented characters
* Fix: Status: Strip query parameters (added by e.g. Jetpack) from images before sending status to prevent errors
* Fix: Settings: Removed disabled CSS class on tabs, as not used and avoids potential conflicts with third party Plugins
* Fix: Settings: Display confirmation notice that settings have saved

= 1.1.9 =
* Added: Log: Option to filter Logs by Request Sent Date. See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/log-settings/#filtering-logs
* Added: Log: Provide solutions to common issues
* Added: Log: New Log screen with filters and searching to view Status Logs across all Posts for all actions (Publish, Update, Repost, Bulk Publish).  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/logs/
* Added: Log: Improved messages explaining why a Post is not sent to Hootsuite
* Added: Log: Use separate database table for storing Plugin Status Logs instead of Post Meta, for performance
* Added: Status: Image: No Image option
* Removed: Status: Image: Use OpenGraph settings.  Hootsuite have disabled the ability for third party applications (such as this Plugin) to request that status messages read OpenGraph data for a given URL.

= 1.1.8 =
* Added: Status: Tags: Content and Excerpt Tag options with Word or Character Limits
* Added: Gutenberg: Better detection to check if Gutenberg is enabled
* Added: Gutenberg: Better detection to check if Post Content contains Gutenberg Block Markup
* Fix: Status: Removed loading of unused tags.js dependency for performance
* Fix: Status: {content} would return blank on WordPress 5.1.x or older

= 1.1.7 =
* Added: Status: Textarea will automatically expand based on the length of the status text. Fixes issues for some iOS devices where textarea scrolling would not work
* Fix: Status: {content} and {excerpt} tags always return the full content / excerpt, which can then be limited using word / character limits
* Fix: Publish: Add checks to prevent duplicate statuses being sent when a Page Builder (Elementor) fires wp_update_post multiple times when publishing
* Fix: Status: Strip additional unwanted newlines produced by Gutenberg when using {content}
* Fix: Status: Convert <br> and <br /> in Post Content to newlines when using {content}
* Fix: Status: Trim Post Content when using {content}

= 1.1.6 =
* Added: Settings: Display notice if the Hootsuite account does not have any social media profiles attached to it
* Fix: Publish: Display errors and log if authentication fails, or profiles cannot be fetched

= 1.1.5 =
* Fix: Settings: Status: Display warning if a timezone in WordPress or Hootsuite is not a valid timezone, instead of throwing a fatal error

= 1.1.4 =
* Added: Status: Secondary level tabbed UI for Profile actions (Publish, Update)
* Added: Settings: Post Type: Profile: Display warning with instructions when the WordPress Timezone and Hootsuite Profile Timezone do not match
* Added: Settings: Warning if the max_input_vars PHP setting might be too low for the Plugin's settings to successfully be saved
* Fix: Status: Documentation Tab Link

= 1.1.3 =
* Added: New Installations: Automatically enable Publish and Update Statuses on Posts
* Added: Plugin Activation: Enable Logging by default
* Added: Status: Option to limit the number of characters output on a Template Tag
* Fix: Log: Output dates according to WordPress' installation date locale formatting
* Fix: Log: Split data into more table columns for easier reading
* Fix: Status: Don't attempt publishing to any existing linked Google+ Accounts, as Google+ no longer exists.
* Fix: Publish: Improved performance when sending several statuses for a single Post.
* Fix: Publish: Display errors on Post Edit screen if status(es) failed to send to Hootsuite

= 1.1.2 =
* Fix: Menu Icon size preserved when Gravity Forms no conflict mode is set to on
* Fix: Display White Menu Icon unless the User is using WordPress' Light Admin Color Scheme, in which case display the Dark Menu Icon

= 1.1.1 =
* Fix: Publish: Removed global $post reference, which caused some installations to fetch the wrong Post to send to Hootsuite

= 1.1.0 =
* Added: Status: Featured Image: Option to choose between using OpenGraph image (clicking image links to URL) and using image, not linked to URL.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/featured-image-settings/
* Fix: Compatibility when using multiple WP Zinc Plugins
* Fix: Minified all CSS and JS for performance

= 1.0.9 =
* Fix: Multisite: Network Activation: Ensure activation routines automatically run on all existing sites
* Fix: Multisite: Network Activation: Ensure activation routines automatically run created on new sites created after Network Activation of Plugin
* Fix: Multisite: Site Activation: Ensure activation routines automatically run

= 1.0.8 =
* Added: Settings: Header UI enhancements
* Fix: Settings: Added Pinterest Board URL option for Pinterest Statuses.  See Docs: https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro/status-settings/
* Fix: Settings: Display Twitter Usernames
* Fix: Settings: Status: When using Custom Time, ensure it is at least 5 minutes after Publish, Update or Repost (required by Hootsuite's API)
* Fix: PHP warning on count() when trying to fetch an excerpt for a Post
* Fix: Settings: Only load settings for the displayed screen, for better performance
* Fix: Settings: Save settings more efficiently, for better performance

= 1.0.7 =
* Fix: Settings: Changed Authentication Tab Icon
* Fix: Settings and Status Settings: UI Enhancements for mobile compatibility
* Fix: {title} would sometimes result in HTML encoded characters on Facebook

= 1.0.6 =
* Fix: Status: Apply WordPress default filters to Post Title, Excerpt and Content. Ensures third party Plugins e.g. qtranslate can process content and remove shortcodes

= 1.0.5 =
* Added: Gutenberg: Support for Custom Field Tags when Custom Fields / Meta are registered as a meta box outside of the Gutenberg editor.
* Added: REST API: Support for Custom Field Tags when Posts are created or updated via the REST API with Custom Field / Meta data.

= 1.0.4 =
* Added: Gutenberg Support
* Added: Settings and Status Settings: UI Enhancements to allow for a larger number of connected social media profiles
* Added: Status: Tag: Post ID option
* Fix: Removed unused datepicker dependency
* Fix: CRON Scheduled Posts: Don't rely on wp_get_current_user() for User Access settings, as it's not always available
* Added: Status: Support for Shortcode processing on Status Text

= 1.0.3 =
* Fix: Publish: Ensure Post has fully saved (including all Custom Fields / ACF / Yoast data etc) before sending status to Hootsuite
* Fix: Publish: Removed duplicate do_action() call on save_post to prevent some third party plugins running routines twice
* Fix: Log: Report 'Plugin: Request Sent' and 'Created At' datetime using WordPress configured date time zone.
* Fix: Profiles: Serve social media profile images over SSL to avoid mixed content warning messages
* Fix: Settings: Changed WordPress standard .nav-tab-active class to .wpzinc-nav-tab-active, to prevent third party plugins greedily trying to control our UI.

= 1.0.2 =
* Fix: Publish: Only consider publishing statuses to Hootsuite on supported Post Types (resolves issues with Advanced Custom Fields Free Version saving Fields).

= 1.0.1 =
* Fix: Call to member function get_error_message() on null when attempting to fetch Hootsuite User Profile.

= 1.0 =
* First release.

== Upgrade Notice ==

