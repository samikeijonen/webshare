<?php

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Echo social links in a list format.
 *
 * @since  1.0.0
 * @access public
 * @var    void
 */
function webshare() {

	echo get_webshare();

}

/**
 * Get social links in a variable.
 *
 * @since  1.1
 * @access public
 * @var    void
 */
function get_webshare() {
 
	/* Check if there is twitter account added in profile page. */
	if( $twitter = get_the_author_meta( 'webshare_twitter' ) ) {
		$via_twitter = '&via=' . esc_attr( $twitter );
	} else {
		$via_twitter = '';
	}
	
	/* Get webshare settings for what to hide. */
	global $webshare_settings;
	
	/* Get webshare icons list. */
	global $webshare_list;
	
	/* Set what to hide as an array. This means Facebook, Twitter and Google. */
	$webshare_what_to_hide = array();
	
	/* Add from settings. */
	if( !empty( $webshare_settings['webshare_hide'] ) ) {
		$webshare_what_to_hide = $webshare_settings['webshare_hide'];
	}
	
	do_action( 'webshare_before_output' ); // Action before output.
	
	/* Start the output. */
	$webshare_output  = '';
	$webshare_output .= '<div id="webshare-wrapper">';
	$webshare_output .= '<ul id="webshare" class="webshare webshare-links">';
	
	$webshare_output .= '<li>' . __( 'Share:', 'webshare' ) . '</li>';
	
	do_action( 'webshare_before_first_list_element' ); // Action before first li element.
	
	/* Loop webshare options array and output correct value. */
	foreach( $webshare_list as $key => $item ) :
				
		if( 'Facebook' == $item && !in_array( 'Facebook', $webshare_what_to_hide ) ) {
			$webshare_output .= '<li class="webshare-facebook"><a class="webshare-facebook" href="https://www.facebook.com/sharer.php?u=' . esc_url( get_permalink() ) . '&t=' . urlencode( the_title_attribute( 'echo=0' ) ) . '" target="_blank" title="' . esc_attr( __( 'Facebook', 'webshare' ) ) . '"><span class="screen-reader-text webshare-link webshare-link-facebook">' . esc_attr( __( 'Facebook', 'webshare' ) ) . '</span></a></li>';
		}
		elseif( 'Twitter' == $item && !in_array( 'Twitter', $webshare_what_to_hide ) ) {
			$webshare_output .= '<li class="webshare-twitter"><a class="webshare-twitter" href="https://twitter.com/intent/tweet?url=' . esc_url( get_permalink() ) . '&text=' . urlencode( the_title_attribute( 'echo=0' ) ) . $via_twitter . '" target="_blank" title="' . esc_attr( __( 'Twitter', 'webshare' ) ) . '"><span class="screen-reader-text webshare-link webshare-link-twitter">' . esc_attr( __( 'Twitter', 'webshare' ) ) . '</span></a></li>';
		}
		elseif( 'Google' == $item && !in_array( 'Google', $webshare_what_to_hide ) ) {
			$webshare_output .= '<li class="webshare-google"><a class="webshare-google" href="https://plus.google.com/share?url=' . esc_url( get_permalink() ) . '" target="_blank" title="' . esc_attr( __( 'Google+', 'webshare' ) ) . '"><span class="screen-reader-text webshare-link webshare-link-google">' . esc_attr( __( 'Google+', 'webshare' ) ) . '</span></a></li>';
		}
	
	endforeach;
	
	do_action( 'webshare_after_last_list_element' ); // Action after last li element.
	
	$webshare_output .= '</ul>';
	$webshare_output .= '</div>';
	
	do_action( 'webshare_after_output' ); // Action after output.
	
	/* Return output. */
	return $webshare_output;
	
}

/**
 * Add webshare after content.
 *
 * @since  1.1
 * @access public
 * @var    void
 */
function webshare_add_sharing( $content ) {

	/* Get webshare settings for where to show icons. */
	global $webshare_settings;
	
	/* Return content if there is nothing to show. */
	if( !isset( $webshare_settings['webshare_show'] ) || empty( $webshare_settings['webshare_show'] ) ) {
		return $content;
	}
	
	/* Set where to show as an array. */
	$webshare_where_to_show = (array) $webshare_settings['webshare_show'];
	
	/* Check that we are not supporting webshare in our theme. And on wanted singular 'pages' and in main query. */
	if( !current_theme_supports( 'webshare' ) && is_singular( apply_filters( 'webshare_where_to_show', $webshare_where_to_show ) ) && is_main_query() ) {
		$webshare_add_social_sharing = sprintf( '%s', get_webshare() );
		$content .= $webshare_add_social_sharing;	
	}
	
	return $content;
}
add_filter( 'the_content', 'webshare_add_sharing' );

/**
 * Add Twitter username in profile page.
 *
 * @since  1.0.0
 * @access public
 * @var    array
 */
function webshare_contact_methods( $meta ) {

	/* Twitter contact method. */
	$meta['webshare_twitter'] = __( 'Twitter Username', 'webshare' );

	/* Return the array of contact methods. */
	return $meta;

}
add_filter( 'user_contactmethods', 'webshare_contact_methods' );
