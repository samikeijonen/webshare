<?php

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Social links in a list format.
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

	/* Get all sharing options in variable. */
	
	do_action( 'webshare_before_output' ); // Action before output.
	
	$webshare_output .= '<div id="webshare-wrapper">';
	$webshare_output .= '<ul id="webshare" class="webshare webshare-links">';
	
	do_action( 'webshare_before_first_list_element' ); // Action before first li element.
	
	$webshare_output .= '<li>' . __( 'Share:', 'webshare' ) . '</li>';
	$webshare_output .= '<li class="webshare-facebook"><a class="webshare-facebook" href="https://www.facebook.com/sharer.php?u=' . esc_url( get_permalink() ) . '&t=' . urlencode( get_the_title() ) . '" target="_blank" title="' . __( 'Facebook', 'webshare' ) . '"><span class="screen-reader-text webshare-link webshare-link-facebook">' . __( 'Facebook', 'webshare' ) . '</span></a></li>';
	$webshare_output .= '<li class="webshare-twitter"><a class="webshare-twitter" href="https://twitter.com/intent/tweet?url=' . esc_url( get_permalink() ) . '&text=' . urlencode( get_the_title() ) . $via_twitter . '" target="_blank" title="' . __( 'Twitter', 'webshare' ) . '"><span class="screen-reader-text webshare-link webshare-link-twitter">' . __( 'Twitter', 'webshare' ) . '</span></a></li>';
	$webshare_output .= '<li class="webshare-google"><a class="webshare-google" href="https://plus.google.com/share?url=' . esc_url( get_permalink() ) . '" target="_blank" title="' . __( 'Google+', 'webshare' ) . '"><span class="screen-reader-text webshare-link webshare-link-google">' . __( 'Google+', 'webshare' ) . '</span></a></li>';
	
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
	
	/* Check that we are not supporting webshare in our theme. And on singular 'post' and in main query. */
	if( !current_theme_supports( 'webshare' ) && is_singular( apply_filters( 'webshare_when_to_show', array( 'post' ) ) ) && is_main_query() ) {
		$webshare_add_social_sharing = sprintf( '%s', get_webshare() );
		$content .= $webshare_add_social_sharing;	
	}
	
	return $content;
}
add_filter('the_content', 'webshare_add_sharing' );

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
