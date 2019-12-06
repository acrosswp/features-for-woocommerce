if ('yes' == ffw.ffw_update_product_price_on_the_fly) {
	jQuery(document).ready(function ($) {
		jQuery('body.single-product form.cart').on('change', 'input.qty', function (e) {
			var qty = $(this).val();
			if ($(this).closest('form').hasClass('variations_form cart')) {
				$(this).closest('form').find('.woocommerce-Price-amount').each(function (index) {
					ffw_update_product_price_on_the_fly(this, qty);
				});
			} else {
				$(this).closest('.summary').find('.woocommerce-Price-amount').each(function (index) {
					ffw_update_product_price_on_the_fly(this, qty);
				});
			}
		});

		jQuery('body.single-product form.variations_form').on('woocommerce_variation_has_changed', function () {
			jQuery('body.single-product form.cart input.qty').val(1);
		});
	});

	/**
	 * Update price dynamic
	 * @param $this
	 */
	function ffw_update_product_price_on_the_fly($this, qty) {
		var $html = jQuery($this).text();
		var $symbol = jQuery($this).find('span').text();
		var main_price = $html.replace($symbol, '');


		if (jQuery($this).attr('single_price')) {
			single_price = jQuery($this).attr('single_price');
		} else {
			jQuery($this).attr('single_price', main_price);
			single_price = main_price;
		}

		price = parseInt(qty) * parseFloat(single_price);

		jQuery($this).html(jQuery($this).html().replace(main_price, price.toFixed(2)));
		jQuery($this).attr('single_price', single_price);
	}
}