if ('yes' == ffw.ffw_remove_product_on_checkout) {
	jQuery( document ).ready( function ( $ ) {
		jQuery( 'body.woocommerce-checkout form.woocommerce-checkout' ).on( 'click', '.ffw_remove_product_on_checkout', function ( e ) {
	
			if ( 0 < $( this ).parent().find( 'input.ffw-qty' ).length ) {
				e.preventDefault();
				$( this ).parent().find( 'input.ffw-qty' ).val( 0 ).trigger("change");
			}
		} );
	} );
}