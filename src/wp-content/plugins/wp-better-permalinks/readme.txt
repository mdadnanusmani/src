=== Plugin Name ===
Contributors: mateuszgbiorczyk
Donate link: https://www.paypal.me/mateuszgbiorczyk/
Tags: permalinks, custom, friendly, category, seo, link, url
Requires at least: 4.7.0
Tested up to: 5.0.0
Stable tag: 3.0.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Set custom friendly permalinks structure: Custom Post Type > Taxonomy > Post and Custom Post Type > Taxonomy instead of default WordPress structure.

== Description ==

Set custom friendly permalinks structure: **Custom Post Type > Taxonomy > Post** and **Custom Post Type > Taxonomy** instead of default WordPress structure.

Default permalinks structure in WordPress:

* Custom Post Type > Post
* Taxonomy > Single Term

Friendly permalinks structure pattern available using this plugin:

* Custom Post Type > Single Term *(or Term tree)* > Post
* Custom Post Type > Post *(when no term is selected)*
* Custom Post Type > Single Term *(or Term tree)*

The plugin allows you to set your own structure with a few clicks. Everything works automatically, no need to add any additional code.

**New features:** Auto update of post slug after changing title and automatic 301 redirects for old links! Thanks to this, your website will always have correct links and you will avoid 404 errors.

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/wp-better-permalinks` directory, or install plugin through the WordPress plugins screen directly.
2. Activate plugin through `Plugins` screen in WordPress Admin Panel.
3. Use `Settings -> WP Better Permalinks` screen to configure the plugin.

== Frequently Asked Questions ==

= What happens if I choose more than one term? =

Only first selected category will be used in post url.

= For what types of posts can I set permalinks strukture? =

You can set for all Custom Post Types.

= How do I register custom post type nad taxonomy to set up permalink structure for them? =

It does not matter. You can use the Wordpress features: [register_post_type](https://codex.wordpress.org/Function_Reference/register_post_type) and [register_taxonomy](https://codex.wordpress.org/Function_Reference/register_taxonomy) or use any plugin for this. It is important to set visibility as public in arguments.

= Can I choose one taxonomy for several types? =

No. This possibility is blocked. You can assign taxonomy to only one Custom Post Type. However, you can use one taxonomy for several Custom Post Types.

= What do I do if after disabling the plugin I have a problem with links? =

Please go to `Admin Panel -> Settings -> Permalinks` and click `Save Changes` button.

= Why permalinks strukture does not work after upgrading from version 2.X.X? =

From version 3.0.0 the plugin uses a completely modified core. You need to save the settings again to run friendly permalinks strukture. Please go to `Admin Panel -> Settings -> WP Better Permalinks`.

== Screenshots ==

1. Screenshot of the options panel

== Changelog ==

= 3.0.3 =
* Fix for assets loading

= 3.0.2 =
* Possibility of manually editing post slug
* Possibility of permanent turn off admin notice
* Default hidden admin notice

= 3.0.1 =
* Support for Yoast SEO plugin (Primary category)

= 3.0.1 =
* Support for Yoast SEO plugin (Primary category)

= 3.0.0 =
* Automatic update of post slug
* 301 redirects for old links
* Support for internationalization
* Changes in plugin structure
* Minor fixes

= 2.1.4 =
* Improved rewrite rules

= 2.1.3 =
* Cleaning old rewrite rules after saving settings

= 2.1.2 =
* Support for future post type

= 2.1.1 =
* Fix for error 404 on pagination pages

= 2.1.0 =
* Cleaning database after removing plugin

= 2.0.1 =
* Change of settings saving method

= 2.0.0 =
* New plugin core
* Support for category hierarchy in permalinks
* Support for Polylang plugin
* Improved performance and reliability

= 1.0.1 =
* Modification of admin notice

= 1.0.0 =
* The first stable release