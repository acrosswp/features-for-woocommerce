jQuery( document ).ready( function ( $ ) {
	jQuery( 'body.woocommerce-checkout form.woocommerce-checkout' ).on( 'change', 'input.qty', function () {
		// This does the ajax request
		$.ajax( {
			url: woocommerce_params.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
			data: {
				'action': 'ffw_change_quantity_on_checkout',
				'woocommerce-process-checkout-nonce': wc_checkout_params.update_order_review_nonce,
				'form_value': jQuery( this ).closest( 'form' ).serialize()
			},
			success: function ( data ) {
				if ( 'success' === data.result ) {
					jQuery( 'body' ).trigger( 'update_checkout' );
				} else {
					alert( data.message );
				}
			},
			error: function ( errorThrown ) {
				console.log( errorThrown );
			}
		} );
	} )
} );