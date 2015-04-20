=== Webshare ===
Contributors: sami.keijonen
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=E65RCFVD3QGYU
Tags: social, sharing, genericons
Requires at least: 3.9
Tested up to: 4.2
Stable tag: 1.2.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds social sharing icons.

== Description ==

Webshare is another social sharing plugin but it only displays sharing links with Genericon fonts. So it's lightweight.

= Plugin usage =

When you activate the plugin social sharing appears after singular post. You can drag and drop social icons in
different order under Settings >> Webshare.

[youtube https://www.youtube.com/watch?v=EIEiXKO562k]

There you can choose under which post types you want social icons to appear or do you want to disable some of them.

Add Twitter username in your profile page (called Twitter Username) if you want to show it when sharing to twitter.

= Theme support =

If you want to set location where social sharing appears, load Genericons and handle the CSS in your theme, add this code in your themes `functions.php`.

`
/* Webshare plugin support. This means that theme handles the CSS and location of websharing already. */
add_theme_support( 'webshare', array( 'styles' => true ) );
`

Then add this code in your themes template file where you want webshare to appear.

`
<?php 
if ( function_exists( 'webshare' ) ) {
	webshare(); // Sharing icons.
}
?>
`

= Demo =

You can see the demo in [Mina olen demosite](https://foxland.fi/demo/minaolen/template-sticky/ "Mina olen demo"). You can
get Mina olen theme from [here](https://foxland.fi/downloads/mina-olen/ "Mina olen").

== Installation ==

1. Upload `webshare` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= Is there any settings in this plugin? =

No. You can only add Twitter username in your profile page.

= Does social sharing automatically appear after or before content? =

Not at the moment. I think about adding social sharing after content.

== Screenshots ==

1. Webshare after content

== Changelog ==

= 1.2.7 =

* Fix: Security update for XSS security flaw.

= 1.2.6 =

* Fix sanitize callback function, yes again.

= 1.2.5 =

* Fix incorrect sanitize callback function.
* Serbian language files added.

= 1.2.4 =

* Fix incorrect path to genericon CSS file.
* Use the_title_attribute in title.

= 1.2.3 =

* Tested up to WP 4.0.
* Compress CSS files.
* Update language files.

= 1.2.2 =

* Fixed a small bug in Genericons.

= 1.2.1 =

* Update Genericons to version 3.1.

= 1.2 =

* Setting page added under Settings >> Webshare.
* You can now drag and drop social icons in the order you want.
* You can disable social icons.
* You can choose under which post types you want social icons to appear.
* When you uninstall the plugin database settings are deleted.

= 1.1.1 =

Add screenshot.

= 1.1 =

* Social sharing appears now automatically after post if you don't add support for your theme.

Social sharing 

= 1.0.0 =

* Everything's brand new.