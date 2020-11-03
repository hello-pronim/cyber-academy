=== Pay For Post with WooCommerce ===
Contributors: mattpramschufer, freemius
Tags: woocommerce, payforpost, woo commerce, sell posts, sell pages, pay for post
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=mattpram%40gmail%2ecom
Requires at least: 3.8
Requires PHP: 5.6
Tested up to: 5.5
Stable tag: 2.6.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Sell Pages/Posts through WooCommerce 2.6+ quickly and easily. Tested up to WooCommerce Version 4.5.x

== Description ==
Quickly and easily sell access to pages, posts and custom post types through WooCommerce with Pay For Post with WooCommerce.  I originally created this plugin because I looked everywhere and I couldn't find a plugin already out there, free or premium, that would do the simple fact of selling access to a particular page or post through WooCommerce.  So I decided to write my own.

= Requirements =
* WooCommerce version 2.6+ to be installed and active
* Guest checkout to be turned OFF
* PHP 5.6+  PHP 7.4+ is recommended but 5.6 will work.

= How It Works =
Getting everything setup will take you less than 5 minutes with three simple steps.

- **Step 1** Create a product in WooCommerce
- **Step 2** Create a page or post in Wordpress
- **Step 3** Associate your product with your page using the Pay For Post with WooCommerce meta box.

**It's that simple.**

>With the Premium version, you have several other options for protecting content like, time based, number of page views, etc.

= How-to Videos =
**How-to Install and Configure**
[youtube https://www.youtube.com/watch?v=ZepEicA3yeA]
**How-to Protect a Page/Post**
[youtube https://www.youtube.com/watch?v=UEjs8JCknFU]

== Demo ==
You can view a front-end demo by going to [https://demo.pramadillo.com](https://demo.pramadillo.com) if you would like to schedule an admin demo please visit [https://pramadillo.com/support](https://pramadillo.com/support) and select Plugin Admin Demo.


== Features ==
* Restrict content from pages, posts and custom post types based on if they have purchased a specific WooCommerce product
* Ability to protect a single post or multiple posts with a single product
* Ability to protect posts with multiple products
* Simple to use
* Uses native WooCommerce functionality to ensure future compatibility
* Global restricted content message which is used for **all** protected content
* Utilize any standard WooCommerce shortcodes
* **PREMIUM ONLY** Ability to override Restricted Content Message on a per page basis
* **PREMIUM ONLY** Delay Restriction - This allows you to delay the paywall from appearing for a set amount of time.
* **PREMIUM ONLY** Page View Restriction - This allows you to limit the number of page views the user who purchased this product has before the paywall reappears. Options to specify over a set amount of time or forever.
* **PREMIUM ONLY** Expiry Restriction - This allows you to specify an expiration on this post which would require the user to repurchase the product associated with this post.
* **PREMIUM ONLY** Custom WooCommerce tab on the My Account page to list out all purchased content
* **PREMIUM ONLY** Listing of purchased content on order receipt and order confirmation page
* **PREMIUM ONLY** PolyLang Multiple Language support
* **PREMIUM ONLY** Priority Support
* **PREMIUM ONLY** Woo Memberships Support!
* **PREMIUM ONLY** Woo Subscriptions Support!

>The premium version of this plugin consists of more advanced features to really get the most out of selling your pages and posts! To purchase the premium version please visit [https://pramadillo.com/plugins/woocommerce-pay-per-post/](https://pramadillo.com/plugins/woocommerce-pay-per-post/)

= Shortcodes =

`[woocommerce-payperpost template='purchased']`
This outputs an unordered list of the posts that have been purchased by the current user logged in.

>There are several additional shortcodes available in the free and premium version.  Take a look at [https://pramadillo.com/plugins/woocommerce-pay-per-post/](https://pramadillo.com/plugins/woocommerce-pay-per-post/) for other available shortcodes.

= Template Functions =
**IMPORTANT** Out of the box this plugin will work with any theme which uses the standard Wordpress function `the_content()`. For those themes that do not utilize `the_content()` you can use the following static functions in your templates.

`Woocommerce_Pay_Per_Post_Helper::has_access()`
This checks if the current user has access to the page.  It returns true/false

`Woocommerce_Pay_Per_Post_Helper::get_no_access_content()`
This returns the content specified in the PPP Options.

>For a full example of this take a look at [https://pramadillo.com/plugins/woocommerce-pay-per-post/](https://pramadillo.com/plugins/woocommerce-pay-per-post/)

== Installation ==
1. Activate the plugin through the `Plugins` menu in WordPress
1. Browse to Admin->WooCommerce PayPerPost->Settings
1. Go to Page or Post and you should see a meta box for Pay For Post with WooCommerce.
1. You can find out more on how to install by visiting [https://pramadillo.com/documentation/installing-woocommerce-pay-per-post/](https://pramadillo.com/documentation/installing-woocommerce-pay-per-post/)


== Frequently Asked Questions ==

= Do you offer installation and customization services? =
Yes, if you need help with installation and/or would like additional customization work done for your website, you can fill out a request form at [https://pramadillo.com/support](https://pramadillo.com/support)

= I wish this plugin had XZY feature =

While I try to do my best to incorporate new features all the time, I implemented a new Feature Request board located at [https://pramadillo.com/feature-requests](https://pramadillo.com/feature-requests)

= Can this plugin work with custom post types? =

Yes, this plugin worked with all custom post types.  In the settings you can add and remove which post types you would like the metabox to show up on.

= How do you link to your post after an order has been placed? =

What I have done in the past is use the Order Notes for the product in WooCommerce. So what will happen is after they purchase, on the Payment Received page they will see the order notes, and they will get sent in the receipt also.

So for instance, I have a Vimeo video that I embed in a page, on the Vimeo Product in WooCommerce I add the Password and notes on how to view the video, they gets transmitted via email and on the thank you page for the user.

**For PREMIUM users, there is a built in option to include the post links in the order email, confirmation screen and on the users My Account page.**

= Do I need to have user accounts turned on? =

Yes, in order to keep track of who purchased what, it is a requirement that all customers have user accounts/

= Do you offer support? =

Yes, I do the absolute best I can to support the free version of the plugin.  If you upgrade to the premium version you will have priority support.

== Screenshots ==

1. Settings Screen including premium features.
2. Pay For Post with WooCommerce meta box, including premium features.
3. Protected Page
4. Protected Page after checkout
5. Premium Feature - WooCommerce My Account Tab
6. Premium Feature - WooCommerce Order Confirmation


== Changelog ==
= 2.6.2 =
* IMPORTANT - Changed the way the shortcode PURCHASED works.  The shortcode now returns all purchased products, not just ones the user has access to.

* BUGFIX - Fixed issue with orders in the processing state when using Expiration protection was not getting the last order date.
* BUGFIX - Fixed issue with shortcode not accepting multiple product ids.
* BUGFIX - Fixed issue with inline shortcode returning content that did not process shortcodes.

* UPDATE - Confirmed working for WooCommerce 4.5.x
* UPDATE - Added video library to Getting Started page.

* FEATURE - Added in new shortcode for HAS ACCESS which is what the old PURCHASED shortcode was.  You can now have two shortcodes, one to show if the user has access to posts, and one to show if they purchased the product.
* FEATURE - Added in new filters for no posts short code messages. wc_pay_per_post_shortcode_has_access_no_posts,wc_pay_per_post_shortcode_purchased_no_posts
* FEATURE - Added in admin notification if debug mode is running in production.

= 2.6.1 =
* HOTFIX - Duplicate filter name for wc_pay_per_post_allowed_roles, changed the newly released filter to be wc_pay_per_post_allowed_roles_for_meta_box

= 2.6.0 =
* FEATURE - Added in filter wc_pay_per_post_allowed_roles_for_meta_box which allows users to limit the meta box from displaying to specific roles.
* UPDATE - Confirmed working with Wordpress 5.5
* UPDATE - Confirmed everything works with WooCommerce 4.4.x
* UPDATE - Updated to latest Freemius package
* BUGFIX - On activation of premium plugin, the pageviews table sometimes would not get created due to foreign key restraints.  We have a fallback in place now for this.
* BUGFIX - Fixed PHP Warning on activation
* BUGFIX - Fixed PHP Warnings on Debug Page.

= 2.5.9 =
* UPDATE - Confirmed everything works with WooCommerce 4.3.1
* FEATURE - Added in crude debug log viewer on debug page.
* FEATURE - Implemented new template engine to allow for overwriting of the template through the wc_pay_for_post_locate_template filter.
* PREMIUM FEATURE - Added in two new shortcodes for [wc-pay-for-post-status template="expiration-status"] and [wc-pay-for-post-status template="pageview-status"]

= 2.5.8 =
* UPDATE - Confirmed everything works with WooCommerce 4.2.2
* UPDATE - Wrapped Paywall content in <div class="wc_ppp_paywall"> for easier styling
* FEATURE - Added a css class to paywall `wc_ppp_paywall` to make it easier to style
* FEATURE - Added the ability to protect attachment pages
* PREMIUM FEATURE - Inline Shortcodes for protecting content! BETA You can now protect multiple pieces of content using the shortcode [wc-pay-for-post-inline][/wc-pay-for-post-inline]!!!
* PREMIUM FEATURE - Added new filter wc_pay_per_post_modify_excerpt for modifying excerpt when using {{excerpt}}
* PREMIUM FEATURE - Added in action wc_pay_per_post_page_view_threshold_reached for when users page views reach 3 page views left
* PREMIUM FEATURE - Added in filter wc_pay_per_post_page_view_action_threshold to allow to override page_view threshold action
* PREMIUM FEATURE - Added in filter wc_pay_for_post_allowed_roles to allow specific user roles to bypass paywall
* PREMIUM FEATURE - Added in filter wc_pay_for_post_show_warnings_position to allow to control the position of the warning box either TOP of post or BOTTOM of post

= 2.5.7 =
* BUGFIX - Correct javascript error when multiple versions of Select2 library are running

= 2.5.6 =
* BUGFIX - Corrected PHP 7.4 error when using template tags
* UPDATE - Added in new filter wc_pay_per_post_override_purchase_date_sql to override the purchase date SQL.

= 2.5.5 =
* UPDATE - Added filter wc_pay_per_post_disable_in_the_loop to account for some themes that do not use the_loop
* BUGFIX - Corrected issue of purchased content links not showing up in order emails if using a variable product.

= 2.5.4 =
* PERFORMANCE - Refactored function that checks if post is protected to be 2x faster.
* BUGFIX - Applied fix to account for themes that call the_content filter multiple times on page which would cause the pageview counter to fire multiple times.  Thanks @Elio for the assist!
* PREMIUM FEATURE - Added in a new short tag {{excerpt}} which will automatically pull the excerpt from the current post.  This can be used in the global Restricted Content Message or in the Override Restricted Content Section.

= 2.5.3 =
* UPDATE - Exposed ability to turn on or off tracking at a code level.
* UPDATE - Updated all vendor files
* BUGFIX - Addressed bug for tracking page views.  Previously if you had page view to be set to one, it would actually allow two page views
* BUGFIX - Addressed bug for pageview tracking which used a users pageview when firing the purchased_content shortcode
* REMOVAL - Removed old database upgrade functions.

= 2.5.2 =
* BUGFIX - Fixed issue introduced in 2.5.1 with saving product_ids not storing correctly in database.
* SECURITY FIX - Implemented custom sanitization function for product_ids array.

= 2.5.1 =
* PREMIUM FEATURE - Added in support for Paid Memberships Pro!
* UPDATE - Removed all logos of WooCommerce in banner images and logos
* UPDATE - Corrected two instances to properly sanitize data before saving in database.

= 2.5.0 =
* UPDATE - Changed name of plugin for legal reasons. :( The name going forward will be Pay For Post with WooCommerce

= 2.4.15 =
* FEATURE - Added new filter wc_pay_per_post_woocommerce_email_args
* FEATURE - Added new filter wc_pay_per_post_hide_delay_restricted_posts_when_paywall_should_not_be_shown
* SECURITY FIX - Added esc_html() to page title that was outputted and not escaped.
* UPDATE - Updated to latest version of Freemius SDK

= 2.4.14 =
* FEATURE - Added ability to delete log file from settings page.
* BUG FIX - Fixed CSS issue with badge icon

= 2.4.13 =
* BUG FIX - Fixed issue with readme.txt VS README.txt on what's new page
* UPDATE - Accounted for post_meta being stored as boolean rather than yes/no on woocommerce items.

= 2.4.12 =
* BUG FIX - Removed the +1 from premium page view counter
* BUG FIX - Excluded shortcodes from processing in the admin when using builders like Gutenberg

= 2.4.11 =
* BUG FIX - Addressed wc_pay_per_post_hide_item_meta_in_email filter bug which stopped working with 2.4 release.

= 2.4.10 =
* BUG FIX - Correctly Addressed the issue when free version users had WooSubscriptions or WooMemberships active, and not utilizing premium version.

= 2.4.9 =
* BUG FIX - Addressed issue when free version users had WooSubscriptions or WooMemberships active

= 2.4.8 =
* BUG FIX - Corrected issue when Debug Mode was enabled it would throw a fatal error in Free Version
* BUG FIX - Corrected issue of __premium_only functions not being found in free version.

= 2.4.7 =
* Public 2.4x Release!
* UPDATE - Complete rewrite of majority of code base to put added emphasis on scalability!
* UPDATE - Added in Monolog Logger for more robust debugging
* UPDATE - Updated to latest Freemius SDK for a wide range of account related updates
* UPDATE - Made the navigation menus a bit more friendly.
* UPDATE - Changed the logic behind has_purchased function to be has_access instead to account for Premium Membership protection.
* PREMIUM FEATURE - Added in support for Woo Memberships!!
* PREMIUM FEATURE - Added in support for Woo Subscriptions!!
* PREMIUM FEATURE - Added in javascript page refresh for page expiration protection
* PREMIUM FEATURE - Filter added wc_pay_per_post_enable_javascript_expiration_refresh to disable javascript refresh protection
* PREMIUM UPDATE - Added in conditional logic for expiration-status partial to account for admins that have access.
* BUG FIX - Corrected bug which would cause admin screen to refresh when viewing an expired post - Thanks @ryan!
* BUG FIX - Corrected bug which would improperly set the expiration status of the post - Thanks @ryan!
* BUG FIX - Corrected issue when protecting posts with membership they would not show up in purchased shortcode - Thanks @ryan!
* BUG FIX - Fixed issue with purchased and remaining shortcode which would not display standard protection products
* BUG FIX - If setting enabled to allow admin's to view protected post content, then do not enforce the javascript page reloading.
* BUG FIX - Corrected issue with expiration protection for if last purchase date was empty it would allow access to protected content. - Thanks @ryan!

= 2.4.6 =
* BUG FIX - Corrected issue with expiration protection for if last purchase date was empty it would allow access to protected content. - Thanks @ryan!
* UPDATE - Added in conditional logic for expiration-status partial to account for admins that have access.

= 2.4.5 =
* BUG FIX - If setting enabled to allow admin's to view protected post content, then do not enforce the javascript page reloading.

= 2.4.4 =
* BUG FIX - Fixed issue with purchased and remaining shortcode which would not display standard protection products
* FEATURE - Filter added wc_pay_per_post_enable_javascript_expiration_refresh to disable javascript refresh protection

= 2.4.3 =
* BUG FIX - Corrected issue when protecting posts with membership they would not show up in purchased shortcode - Thanks @ryan!
* UPDATE - Changed the logic behind has_purchased function to be has_access instead to account for Membership protection.

= 2.4.2 =
* BUG FIX - Corrected bug which would cause admin screen to refresh when viewing an expired post - Thanks @ryan!
* BUG FIX - Corrected bug which would improperly set the expiration status of the post - Thanks @ryan!

= 2.4.1 =
* PREMIUM FEATURED - Added in support for Woo Memberships!!
* PREMIUM FEATURED - Added in support for Woo Subscriptions!!
* PREMIUM FEATURED - Added in javascript page refresh for page expiration protection

* UPDATE - Complete rewrite of majority of code base to put added emphasis on scalability
* UPDATE - Added in Monolog Logger for more robust debugging
* UPDATE - Updated to latest Freemius SDK for a wide range of account related updates
* UPDATE - Made the navigation menus a bit more friendly.

= 2.3.2 =
* BUGFIX - Fixed issue with template replacements not working in 2.3.1

= 2.3.1 =
* FEATURE - Added in new filter to hide the purchased content links from woocommerce receipt emails.
* UPDATE - Refactored a ton of code for performance increases!
* BUGFIX - Updated links in settings page to work with installs that are not in the root directory.

= 2.3.0 =
* FEATURE - Added in Debug tools to check if page view tables are created, and if WooCommerce products are created.
* FEATURE - Added in new shortcode parameter for the purchased shortcode, to allow to group by product ids!
* UPDATE - Added in timezone locale to date of last purchase for page view protection
* UPDATE - Added in Wordpress Version check for the Debug Screen.  Older versions of Wordpress do not have SiteHealth functions.
* UPDATE - Removed animated GIFs from getting started section and introduced more documentation at pramadillo.com
* UPDATE - Included latest version of symfony translation library
* UPDATE - Updated language translations to latest machine translations.  If anyone is wanting to help translate please reach out!

= 2.2.9 =
* UPDATE - Added in new Getting Started section
* UPDATE - Added in new Debug section
* UPDATE - Refactored functions to be more performant
* UPDATE - Dynamically pulling in change log from README.TXT
* UPDATE - Updated premium feature screen shots.
* BUG FIX - Corrected issue with Polylang support which was only querying the default language.
* BUG FIX - Fixed issue with orders in the Processing state and Page View protection
* BUG FIX - Fixed bug which wasn't displaying the protected content heading on the order page without filter.

= 2.2.8 =
* PREMIUM FEATURED - Added in Polylang support

= 2.2.7 =
* UPDATE - Added in saving permalinks after turning on the my account tab.

= 2.2.6 =

* PREMIUM FEATURE - Added ability to have a tab on the My Account section appear with purchased content
* PREMIUM FEATURE - Added in filter to change My Account Tab name
* PREMIUM FEATURE - Added in two actions before and after shortcode for My Account section

= 2.2.5 =

* PREMIUM FEATURE - Purchased content links now appear on Order Confirmation screen AND in all Order Receipt emails!
* PREMIUM FEATURE - Added in filter to change purchased content title on emails.

* UPDATE - Updated translations with latest content
* UPDATE - Removed unnecessary filter call.
* UPDATE - Added more documentation links and links to pramadillo.com for feature requests

= 2.2.4 =

* FEATURE - Added in expiration status attribute to purchased shortcode template
* UPDATE - Confirmed working with WooCommerce 3.7.x
* UPDATE - Updated Symphony SDK, Carbon SDK, and Freemius SDK to latest versions

= 2.2.3 =
* UPDATE - Updated Symphony SDK, Carbon SDK, and Freemius SDK
* UPDATE - Limited product list meta box to only published products.

= 2.2.2 =
* BUG FIX - Fixed issue with Fatal error when displaying pageviews remaining without having a end date
* BUG FIX - Fixed issue where if user purchased product again, it would not reset pageviews
* UPDATE - Updated Symphony SDK, Carbon SDK, and Freemius SDK
* UPDATE - Confirmed working with WP 5.1.1 and WC 3.6.1

= 2.2.1 =
* BUG FIX - Fixed issue on what's new page and GIANT Pramadillo taking over screen on free version!
* UPDATE - Updated Symphony SDK
* UPDATE - Confirmed working with WP 5.1 and WC 3.5.5

= 2.2.0 =
* BUG FIX - Fixed issue in pro version for Expiration timeframe, date/time of last order now comes from order_completed date rather than post_date
* UPDATE - Updated Freemius SDK to latest version
* UPDATE - Updated Carbon Library to latest version
* UPDATE - Updated Symfony Library to latest version

= 2.1.16 =
* BUG FIX - Fixed issue if admin's were allowed to view paid content, and comment restriction was enabled, to allow admins to view comments too.

= 2.1.15 =
* BUG FIX - Fixed plugin conflict with WC Email Verification by XL plugins

= 2.1.14 =
* BUG FIX - Fixed issue with PHP Warning on PHP 7.1
* UPDATE - Updated to latest Freemius SDK
* UPDATE - Confirmed compatibility with Wordpress 5.0 & WooCommerce 3.5.2
* UPDATE - Confirmed working, not pretty, but working with Gutenberg

= 2.1.13 =
* NEW FEATURE - Added in two new filters wc_pay_per_post_all_product_args and wc_pay_per_post_virtual_product_args
* UPDATE - Updated the virtual product filter to adhere to new WooCommerce meta values
* UPDATE - Addressed more pages to make them translatable
* BUG FIX - Corrected PHP warning message for invalid argument when using implode()

= 2.1.12 =
* BUG FIX - Corrected issue with debug code displaying on protected products

= 2.1.11 =
* BUG FIX - Fixed issue with comments being displayed through entire site instead of just on protected posts

= 2.1.10 =
* BUG FIX - Fixed issue where if multiple products were associated with post it would only look for the first product

= 2.1.9 =
* Updated composer to default to php 5.6 instead of php 7

= 2.1.8 =
* Modified codebase to conform with Wordpress coding standards.
* NEW PREMIUM FEATURE - Ability to turn comments off for JUST folks that have not purchased page
* NEW PREMIUM FEATURE - Added the ability to show how many pageviews / how much time was remaining before post expired.
* FIXED issue with premium page view expiration
* FIXED issue with help page tabs not working

= 2.1.7 =
* NEW PREMIUM FEATURE Ability to utilize product variations
* NEW Shortcode replacement for {{parent_id}} which is to be used with Variations to get the main product ID
* FIXED issue which help page tabs would not work

= 2.1.6 =
* REFACTOR refactored the way the Select2 javascript library was enqueued to minimize conflicts with other plugins using Select2

= 2.1.5 =
* FIXED minor bug with upgrade script that accounts for blank records on post_meta

= 2.1.4 =
* FIXED bug which if upgraded would still show as FREE license sometimes.
* UPDATED Freemius Wordpress SDK to latest version
* UPDATED POT File for translations
* UPDATED Spanish translation
* UPDATED French translation

= 2.1.3 =
* FIXED allow for multiple product ids to be show in shortcode
* FIXED issue with trial subscriptions which still showed upgrade to premium even though you were in premium trial

= 2.1.2 =
* FIXED PHP Notice on Upgrade complete page
* FIXED bug which did not account for custom post types in upgrade process
* FIXED bug in shortcode that did not account for custom post types

= 2.1.1 =
* FIXED bug which if toggle for allow admins to view protected content it would allow users to view protected content
* FIXED bug which was double encoding the restricted message before saving in database.

= 2.1.0 =
* Initial public release!

= 2.0.3 =
* fixed issue when activating and post_type options blank causing PHP notice
* Added text to clarify the Override Restricted Content Message
* Fixed issue when viewing posts in EXCEPT view that restricted content message would appear.
* Added new option to only show Virtual / Downloadable products in Products Dropdown
* Added English POT file for translations
* Added Spanish translation

= 2.0.0 =
* Complete Rewrite

= 1.4.9 =
* Changed dependency code for WC to work correctly with MU. Thanks @sdbox

= 1.4.8 =
* Tested Wordpress 4.8 Compatibility
* Tested WooCommerce 3.0.8 Compatibility
* Added in template wrapper functions to be able to integrate with more themes.

= 1.4.7 =
* Tested Wordpress 4.7 Compatibility
* Tested WooCommerce 2.6.11 Compatibility
* Laid the ground work for many new features
* Delay Restriction Coming Soon in PRO version
* Page View Restriction Coming Soon in PRO version
* Post Expiry Restriction Coming Soon in PRO version

= 1.4.6 =
* Added in a "Do Not Protect" option to the dropdown of the PPP Meta box.  You can now select that to remove restrictions from post.

= 1.4.5 =
* Changed the way I query the products to display the meta box on the admin pages.  This should correct issue with other plugin meta boxes not displaying previously inputted data.

= 1.4.4 =
* Changed the logic on custom post types.  Instead of including all post types by default and allowing users to exclude specific post types.  I now include only page, and post by default and then let users INCLUDE specific post types.
* Not sure why I didn't program it that way to begin with.  Sorry all!

= 1.4.3 =
* Updated the PURCHASED Shortcode to work with all custom post types by default.  Uses same Exclude post type functionality from settings screen.
* Fixed PHP Warning message due to type

= 1.4.2 =
* Excluded WooCommerce default custom post types from adding PPP Meta Box on.
* Added in field in settings for users to be able to exclude specific custom post types.

= 1.4.1 =
* Quick fix for the multiple select field for product ID.  Add in nopaging=true.

= 1.4 =
* Made it so if you are an ADMIN you can view the post content.  If you need to see what the Oops screen looks like, just use a non logged in user.
* Add in support for all registered custom post types, so you now do not need to hack the plugin to make it work for your custom post type!
* Made it easier to enter in product ids, you now have a multiple select box instead of just a text field
* Confirmed support for Wordpress 4.3
* Confirmed support for WooCommerce 2.4.5

= 1.3 =
* Added in the ability for multiple product IDs per post/page *
* Updated FAQ Section *
= 1.2.2 =
* Removed the pagination from the products listed out on the purchased page. *
= 1.2.1 =
* Fixed error displaying when debug mode is enabled for Missing argument 2 on get() function *
= 1.2 =
* Initial Release

== Upgrade Notice ==

= 2.6.2 =
IMPORTANT - Changed the way the shortcode PURCHASED works.  The shortcode now returns all purchased products, not just ones the user has access to.