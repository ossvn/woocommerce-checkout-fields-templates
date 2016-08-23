(function($) {

	// wc_checkout_params is required to continue, ensure the object exists
	if ( typeof wc_checkout_params === 'undefined' ) {
		return false;
	}

	$.blockUI.defaults.overlayCSS.cursor = 'default';


	$('#wct_coupon_widget .checkout_coupon input[name="apply_coupon"]').on( 'click', function(e) {

		var $form = $('#wct_coupon_widget .checkout_coupon'),
		coupon_code = $(this).closest('.checkout_coupon').find('input[name=coupon_code]').val();


		if ( $form.is( '.processing' ) ) return false;

		$form.addClass( 'processing' ).block({
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6
			}
		});

		var data = {
			action:			'woocommerce_apply_coupon',
			security:		wc_checkout_params.apply_coupon_nonce,
			coupon_code:	coupon_code
		};

		$.ajax({
			type:		'POST',
			url:		wc_checkout_params.ajax_url,
			data:		data,
			success:	function( code ) {
				$( '.woocommerce-error, .woocommerce-message' ).remove();
				$form.removeClass( 'processing' ).unblock();

				if ( code ) {
					$form.before( code );
					$( 'body' ).trigger( 'update_checkout' );
				}

			},
			dataType: 'html'
		});

		return false;
	});

})(jQuery); 
