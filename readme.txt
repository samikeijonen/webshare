=== Webshare ===
Contributors: sami.keijonen
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=E65RCFVD3QGYU
Tags: social, sharing, genericons
Requires at least: 3.8
Tested up to: 3.8.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds social sharing icons.

== Description ==

Webshare is another social sharing plugin but it only displays sharing links with Genericon fonts. So it's lightweight.

= Plugin usage =

Add this code in your themes template file.

`
<?php 
if ( function_exists( 'webshare' ) ) {
	webshare(); // Sharing icons.
}
?>
`

= Theme support =

If you want to load Genericons and handle the CSS in your theme, add this code in your themes `functions.php`.

`
/* Webshare plugin support. This means that theme handles the CSS already. */
add_theme_support( 'webshare', array( 'styles' => true ) );
`

== Installation ==

1. Upload `webshare` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= Why was this plugin created? =

I needed this feature and someone else might need it too.

== Changelog ==

= 1.0.0 =

* Everything's brand new.