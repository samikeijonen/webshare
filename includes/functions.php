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
function webshare() { ?>

	<?php 
	/* Check if there is twitter account added in profile page. */
	if( $twitter = get_the_author_meta( 'webshare_twitter' ) ) {
		$via_twitter = '&via=' . esc_attr( $twitter );
	} else {
		$via_twitter = '';
	}
	?>
	
	<div id="webshare-wrapper">
		<ul id="webshare" class="webshare webshare-links">
			<li><?php _e( 'Share:', 'webshare' ); ?></li>
			<li class="webshare-facebook"><a class="webshare-facebook" href="https://www.facebook.com/sharer.php?u=<?php echo esc_url( the_permalink() ); ?>&t=<?php urlencode( the_title() ); ?>" target="_blank" title="<?php _e( 'Facebook', 'webshare' ); ?>"><span class="screen-reader-text webshare-link webshare-link-facebook"><?php _e( 'Facebook', 'webshare' ); ?></span></a></li>
			<li class="webshare-twitter"><a class="webshare-twitter" href="https://twitter.com/intent/tweet?url=<?php echo esc_url( the_permalink() ); ?>&text=<?php urlencode( the_title() ); echo $via_twitter; ?>" target="_blank" title="<?php _e( 'Twitter', 'webshare' ); ?>"><span class="screen-reader-text webshare-link webshare-link-twitter"><?php _e( 'Twitter', 'webshare' ); ?></span></a></li>
			<li class="webshare-google"><a class="webshare-google" href="https://plus.google.com/share?url=<?php echo esc_url( the_permalink() ); ?>" target="_blank" title="<?php _e( 'Google+', 'webshare' ); ?>"><span class="screen-reader-text webshare-link webshare-link-google"><?php _e( 'Google+', 'webshare' ); ?></span></a></li>
		</ul>
	</div>

<?php
}

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
