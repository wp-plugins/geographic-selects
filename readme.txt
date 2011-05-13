=== Geographic Selects ===
Contributors: freeseodotbiz
Donate link: http://example.com/
Tags: country, country select, countries, countries select
Requires at least: 2.0.2
Tested up to: 3.1.2
Stable tag: 1.1.4
License: GPLv2 or later

Simple plugin to insert Country and State select statement's into your website.

== Description ==

Use this plugin to insert Geographic <select> statements into your website.  

== Installation ==

1. Upload `freeseodotbiz_geographicSelects.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php echo geographicSelect_insertCountries($atts); ?>` in your templates

== Frequently Asked Questions ==

= How do I include the &lt;select&gt; statement? =

Set $atts[includeselect]="TRUE", then call geographicSelect_insertCountries($atts);

= Can I use shortcodes? =

Yes, the shortcode is:

[geographicSelect-insertCountries] 
or 
[geographicSelect-insertCountries includeselect="TRUE"] if you want to include the select statement

== Screenshots ==

1. Settings Page
2. How it will be displayed on your page

== Changelog ==

= 1.1.4 (5/12/2011) =
* Bugfix: Removed errand jscript

= 1.1.3 (5/12/2011) =
* Bugfix: Enqueued jquery

= 1.1.2 (5/12/2011) =
* Bugfix: Fixed CSS which was interfering with primary Wordpress CSS elements.

= 1.1.1 (5/12/2011) =
* Added: Screenshots
* Bugfix: Removed extra spaces added onto the end of the main .php causing header problems.

= 1.1 (5/12/2011) =
* New Feature: Added OPTGROUP in order to allow the user to have certain countries appear at the top
* New Feature: Added instructions on main settings page

= 1.0 (5/11/2011) =
* First version

