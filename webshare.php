<?php
/**
* Plugin Name: WebShare
* Plugin URI: https://foxland.fi/downloads/webshare
* Description: Adds social sharing links.
* Version: 1.2.7
* Author: Sami Keijonen
* Author URI: https://foxland.fi
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
* @version 1.2.7
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
		
		/* Get Webshare settings. */
		add_action( 'plugins_loaded', array( $this, 'settings' ), 2 );

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 3 );

		/* Load the functions files. */
		add_action( 'plugins_loaded', array( $this, 'includes' ), 4 );
		
		/* Enqueue scripts and styles. */
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		
		/* Enqueue scripts and styles. */
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		
		/* Register init functions. */
		add_action( 'init', array( $this, 'init' ) );
		
		/* Register activation hook. */
		register_activation_hook( __FILE__, array( $this, 'activation' ) );

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
			define( 'WEBSHARE_VERSION', '1.2.7' );
		}

	}
	
	/**
	* Get settings of the plugin.
	*
	* @since 1.2
	*/
	public function settings() {

		/* Get webshare options. */
		global $webshare_list;
		$webshare_list = get_option( 'webshare_list' );
		global $webshare_settings;
		$webshare_settings = get_option( 'webshare_settings' );

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
		require_once( WEBSHARE_DIR . 'admin/settings.php' );
		
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
			trailingslashit( plugin_dir_url( __FILE__ ) ) . "css/genericons/genericons/genericons$suffix.css",
			null,
			'3.1'
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
	* Load scripts for the setting page.
	*
	* @since  1.2
	* @return void
	*/
	function enqueue_admin_scripts( $hook ) {
	
		/* Return if we are not on our setting page. */
		global $webshare_settings_page;
 
		if( $hook != $webshare_settings_page ) {
			return;
		}
	
		/* Load jquery sortable. */
		wp_enqueue_script( 'jquery-ui-sortable' );
	
		/* Load update order js. */
		wp_enqueue_script( 'webshare-update-order', plugin_dir_url(__FILE__) . 'admin/js/update-order.js' );
	
		/* Send this for nonce referer. */
		wp_localize_script(
			'webshare-update-order',
			'webshare_ajax',
			array(
				'webshare_ajax_nonce' => wp_create_nonce( 'webshare_ajax_nonce' )
			)
		);
	
		/* Load admin styles. */
		wp_enqueue_style( 'webshare-admin', plugin_dir_url(__FILE__) . 'admin/css/admin.css' );
	
		/* Load the Genericons styles. */
		wp_enqueue_style(
			'genericons',
			plugin_dir_url( __FILE__ ) . "css/genericons/genericons.css",
			null,
			'3.1'
		);
	}
	
	/**
	* Defines init functions used by the plugin.
	*
	* @since 1.0.0
	*/
	public function init() {
		
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'webshare_settings_link' ) );

	}
	
	/**
	* Add Settings page to plugin action links in the Plugins table.
	*
	* @since  1.2
	* @return string
	*/
	public static function webshare_settings_link( $links ) {

		$webshare_setting_link = sprintf( '<a href="%s">%s</a>', esc_url( add_query_arg( array( 'page' => 'webshare-options' ), admin_url( 'options-general.php' ) ) ), __( 'Settings', 'webshare' ) );
		array_unshift( $links, $webshare_setting_link );
		return $links;
		
	}
	
	/**
	 * On plugin activation, save default order of the social sharing icons.
	 *
	 * @since  1.2
	 * @access public
	 * @return void
	 */
	function activation() {
		
		/* Get webshare list and options. */
		$webshare_list = get_option( 'webshare_list' );
		$webshare_settings = get_option( 'webshare_settings' );
		
		/* If no options yet set it as array. */
		if ( !isset( $webshare_list ) || !is_array( $webshare_list ) ) {
		
			/* Defaults. */
			$webshare_list = array( 'Facebook', 'Twitter', 'Google' );
			add_option( 'webshare_list', $webshare_list );
		
		}
		
		/* If no options yet set it as array. */
		if ( !isset( $webshare_settings ) || !is_array( $webshare_settings ) ) {
		
			/* Defaults. */
			$webshare_settings = array(
				'webshare_hide' => array(),
				'webshare_show' => array( 'post' )
			);
			add_option( 'webshare_settings', $webshare_settings );
		
		}
		
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
