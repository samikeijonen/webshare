<?php

/* Exit if accessed directly */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

/* Delete list and settings. */
delete_option( 'webshare_list' );
delete_option( 'webshare_settings' );