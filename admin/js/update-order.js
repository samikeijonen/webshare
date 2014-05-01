jQuery(document).ready(function($) {
	
	$('#webshare-ul-sort').sortable({
		stop: function() {
			show_hide_update_gif();
		},
		items: '.list_item', // For list to use
		opacity: 0.6,
		cursor: 'move',
		update: function() {
			var order = $(this).sortable('serialize') + '&action=webshare_update_order' + '&nonce=' + webshare_ajax.webshare_ajax_nonce;
			//alert(order);
			$.post(ajaxurl, order, function(response) {
				// success at this point.
			});
		}
		
	});
	
	/* Show update gif. */
	function show_gif() {
		$( '.webshare-update-gif' ).show();
	}
	
	/* Hide update gif. */
	function show_hide_update_gif() {
		show_gif(); // Show gif, wait for 1 second and hide it.
		setTimeout(function() {
			$( '.webshare-update-gif' ).hide();
		}, 1000); // <-- time in milliseconds
	}
	
	
});