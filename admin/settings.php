<?php

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add options page under Settings >> Webshare.
 *
 * @since  1.2
 * @return void
 */
function webshare_add_setting_page() {
	
	global $webshare_settings_page;
	
	$webshare_settings_page = add_options_page( __( 'Webshare settings', 'webshare' ), __( 'Webshare', 'webshare' ), apply_filters( 'webshare_settings_capability', 'manage_options' ), 'webshare-options', 'webshare_options_page' );
	
}
add_action( 'admin_menu', 'webshare_add_setting_page' );

/**
 * Update order.
 *
 * @since  1.2
 * @return void
 */
function webshare_update_order() {

	/* Check nonce. */
	if( check_ajax_referer( 'webshare_ajax_nonce', 'nonce' ) ) {
	
		/* Get order from our setting. */
		global $webshare_list;
	
		$list = $webshare_list;
		$new_order = $_POST['list_items'];
		$new_list = array();
	
		/* Update order. */
		foreach( $new_order as $v ) {
			if( isset( $list[$v] ) ) {
				$new_list[$v] = $list[$v];
			}
		}
	
		/* Save the new order. */
		update_option( 'webshare_list', $new_list );
	
	}
	die();
}
add_action( 'wp_ajax_webshare_update_order', 'webshare_update_order' );

/**
 * Registers the plugin settings.
 *
 * @since  1.2
 * @return void
 */
function webshare_register_settings() {
	register_setting( 'webshare_settings_group', 'webshare_settings', 'webshare_settings_sanitize' );
}
add_action( 'admin_init', 'webshare_register_settings' );

function webshare_options_page() {
	
	/* Get list what social sharing icons to use. */
	global $webshare_settings;
	global $webshare_list;
	
	ob_start(); ?>
	<div class="wrap">
	
		<h2><?php _e( 'Webshare Settings', 'webshare'); ?></h2>
		
		<p><?php _e( 'Drag and drop social icons in the order you want them in the front end. After that setting is automatically saved.', 'webshare' ); ?></p>
	
		<div id="webshare-wrapper">
			<ul id="webshare-ul-sort" class="webshare-ul-sort">
			<?php
				echo '<li class="webshare-share">' . __( 'Share:', 'webshare' ) . '</li>';
				$count = 0;
				foreach( $webshare_list as $key => $item ) :
				
					if( 'Facebook' == $item ) {
						$webshare_genericon_font = 'facebook-alt';
					}
					elseif( 'Twitter' == $item ) {
						$webshare_genericon_font = 'twitter';
					}
					elseif( 'Google' == $item ) {
						$webshare_genericon_font = 'googleplus';
					}
					echo '<li id="list_items_' . $key . '" class="list_item genericon genericon-' . $webshare_genericon_font . '">';
					echo '<span class="webshare-span">' . $item . '</span>';
					echo '</li>';
					$count++;
				endforeach;
			?>
				<li class="webshare-update-gif" style="vertical-align: bottom; display: none"><img src="<?php echo admin_url( 'images/loading.gif' ); ?>" width="16" height="16" alt="loading" /></li>
			<ul>
		</div>
		
		<?php
		
		if( !empty( $webshare_settings['webshare_hide'] ) ) {
			$webshare_hide = (array) $webshare_settings['webshare_hide'];
		}
		
		if( !empty( $webshare_settings['webshare_show'] ) ) {
			$webshare_where_show = (array) $webshare_settings['webshare_show'];
		}
		
		/* Get public post types. */
		$webshare_shows = array_values( get_post_types( array( 'public' => true ) ) ); ?>
		
	  	<form method="post" action="options.php">
		
			<?php settings_fields( 'webshare_settings_group' ); ?>
			
	  		<table class="form-table">
	  			<tbody>
	  				<tr valign="top">
	  					<th scope="row"><label><?php _e( 'Hide buttons on front end:', 'webshare' ); ?></label></th>
	  					<td>
						<?php
							$br = false;
							foreach ( $webshare_list as $webshare_list_icon ) :
							
								if ( 'Facebook' == $webshare_list_icon ) {
									$webshare_list_icon_echo = __( 'Facebook', 'webshare' ); 
								}
								elseif ( 'Twitter' == $webshare_list_icon ) {
								$webshare_list_icon_echo = __( 'Twitter', 'webshare' ); 
								}
								elseif ( 'Google' == $webshare_list_icon ) {
									$webshare_list_icon_echo = __( 'Google+', 'webshare' ); 
								}
						?>
							<?php if ( $br ) echo '<br />'; ?><label><input type="checkbox"<?php if( isset( $webshare_hide ) ) checked( in_array( $webshare_list_icon, $webshare_hide ) ); ?> name="webshare_settings[webshare_hide][]" value="<?php echo esc_attr( $webshare_list_icon ); ?>" /> <?php echo esc_html( $webshare_list_icon_echo ); ?></label>
						<?php	$br = true; endforeach; ?>
	  					</td>
	  				</tr>
	  			</tbody>
	  		</table>
			
	  		<table class="form-table">
	  			<tbody>
	  				<tr valign="top">
	  					<th scope="row"><label><?php _e( 'Show buttons on:', 'webshare' ); ?></label></th>
	  					<td>
						<?php
							$br = false;
							foreach ( $webshare_shows as $webshare_show ) :
								$post_type_object = get_post_type_object( $webshare_show );
								$label = $post_type_object->labels->name;
						?>
							<?php if ( $br ) echo '<br />'; ?><label><input type="checkbox"<?php if( isset( $webshare_where_show ) ) checked( in_array( $webshare_show, $webshare_where_show ) ); ?> name="webshare_settings[webshare_show][]" value="<?php echo esc_attr( $webshare_show ); ?>" /> <?php echo esc_html( $label ); ?></label>
						<?php	$br = true; endforeach; ?>
	  					</td>
	  				</tr>
	  			</tbody>
	  		</table>
			
			<?php submit_button(); ?>
	  	
		</form>
		
	</div>
	<?php
	echo ob_get_clean();
}

function webshare_settings_sanitize( $input ) {
	
	/* Sanitize arrays. */
	$input['webshare_hide'] = array_map( 'sanitize_text_field', $input['webshare_hide'] );
	$input['webshare_show'] = array_map( 'sanitize_text_field', $input['webshare_show'] );
	
	return $input;

}