<?php
/**
* Plugin Name: WebShare
* Plugin URI: https://foxnet-themes.fi/downloads/webshare
* Description: Adds social sharing links.
* Version: 1.0.0
* Author: Sami Keijonen
* Author URI: https://foxnet-themes.fi
* Text Domain: webshare
* Domain Path: /languages
*
* This program is free software; you can redistribute it and/or modify it under the terms of the GNU
* General Public License version 2, as published by the Free Software Foundation. You may NOT assume
* that you can use any other version of the GPL.
*
* This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
* even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*
* @package WebShare
* @version 1.0.0
* @author Sami Keijonen <sami.keijonen@foxnet.fi>
* @copyright Copyright (c) 2014, Sami Keijonen
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) exit;

final class WEBSHARE {

	/**
	 * Holds the instances of this class.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	* PHP5 constructor method.
	*
	* @since  1.0.0
	* @access public
	* @var    void
	*/
	public function __construct() {
		
		/* Set the constants needed by the plugin. */
		add_action( 'plugins_loaded', array( $this, 'constants' ), 1 );

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 2 );

		/* Load the functions files. */
		add_action( 'plugins_loaded', array( $this, 'includes' ), 3 );
		
		/* Enqueue scripts and styles. */
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}

	/**
	* Defines constants used by the plugin.
	*
	* @since 1.0.0
	*/
	public function constants() {

		/* Set constant path to the plugin directory. */
		define( 'WEBSHARE_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		
		/* Set constant path to the plugin directory. */
		define( 'WEBSHARE_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		/* Set the constant path to the includes directory. */
		define( 'WEBSHARE_INCLUDES', WEBSHARE_DIR . trailingslashit( 'includes' ) );
		
		/* Define Plugin Version. */
		if ( ! defined( 'WEBSHARE_VERSION' ) ) {
			define( 'WEBSHARE_VERSION', '1.0.0' );
		}

	}

	/**
	* Load the translation of the plugin.
	*
	* @since 1.0.0
	*/
	public function i18n() {
	
		/* Load the translation of the plugin. */
		$domain = 'webshare';
		$locale = apply_filters( 'webshare_locale', get_locale(), $domain );
		
		/* You can put custom translation files in wp-content/languages/plugins folder. */
		load_plugin_textdomain( 'webshare', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	}

	/**
	* Loads the initial files needed by the plugin.
	*
	* @since 1.0.0
	*/
	public function includes() {

		/* Load necessary files. */
		require_once( WEBSHARE_INCLUDES . 'functions.php' );
		
	}
	
	/**
	* Loads the stylesheet for the plugin.
	*
	* @since  1.0.0
	* @access public
	* @return void
	*/
	public static function enqueue_scripts() {

		/* Use the .min stylesheet if SCRIPT_DEBUG is turned off. */
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		
		/* Do not load styles if theme already handles all the styles. */
		if ( current_theme_supports( 'webshare', 'styles' ) ) {
			return;
		}
		
		/* Enqueue the Genericons styles. */
		wp_enqueue_style(
			'genericons',
			trailingslashit( plugin_dir_url( __FILE__ ) ) . "css/genericons/genericons.css",
			null,
			'3.0.3'
		);
		
		/* Enqueue stylesheet. */
		wp_enqueue_style(
			'webshare-styles',
			trailingslashit( plugin_dir_url( __FILE__ ) ) . "css/webshare-styles$suffix.css",
			array( 'genericons' ),
			WEBSHARE_VERSION
		);
		
	}
	
	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( !self::$instance ) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}

}

WEBSHARE::get_instance();
