(function($) {

	// wc_checkout_params is required to continue, ensure the object exists
	if ( typeof wc_checkout_params === 'undefined' ) {
		return false;
	}

	$.blockUI.defaults.overlayCSS.cursor = 'default';

	if($('#wct-woo-template #r1').length){
			
		$('#wct-woo-template #r1').on( 'click', function(e) {

			$('.ossvn-login-block').addClass( 'processing processing-cover' ).block({
																message: null,
																overlayCSS: {
																	background: '#fff',
																	opacity: 0.8
																}
															});
			$('#wct-woo-template #account_password_field').remove();
		});
	}

	if($('#wct-woo-template #createaccount').length){
			
		$('#wct-woo-template #createaccount').on( 'click', function(e) {
			
			$('.ossvn-login-block').addClass( 'processing processing-cover' ).block({
																message: null,
																overlayCSS: {
																	background: '#fff',
																	opacity: 0.8
																}
															});
			if( $(this).val() == 1 && $("#billing_email_field").length){

				$('html,body').animate({
	            scrollTop: $("#billing_email_field").offset().top},
	            'slow');

	            $('#account_password_field').remove();
	            $("#billing_email_field").after('<div class="create-account"><p class="form-row validate-required woocommerce-validated" id="account_password_field"><label for="account_password" class="">Account password <abbr class="required" title="required">*</abbr></label><input type="password" class="input-text " name="account_password" id="account_password" value=""></p><div class="clear"></div></div>');
	            
	            $('div.create-account .form-row label').addClass('ossvn-placeholder');
				$('div.create-account .form-row .input-text').attr('placeholder','');

				$('div.create-account .form-row .input-text').each(function(){
					if ($(this).val() != ''){
						$(this).prev().hide();
					}
				});

				$('div.create-account .form-row .input-text').on('focus',function(){
					$(this).prev().hide();
				});
				
				$('div.create-account .form-row .input-text').on('focusout',function(){
					if ($(this).val() != ''){
						$(this).prev().hide();
					} else{
						$(this).prev().show();
					}
				});
			}
		});
	}

	$('#wct-woo-template input[name="wct_login"]').on( 'click', function(e) {

		var $form = $('#wct-woo-template .ossvn-login-block'),
		login = $(this).val(),
		_wpnonce = $('#wct-woo-template .ossvn-login-block #_wpnonce').val(),
		username = $('#wct-woo-template .ossvn-login-block #username').val(),
		password = $('#wct-woo-template .ossvn-login-block #password').val(),
		rememberme = $('#wct-woo-template .ossvn-login-block #rememberme').val(),
		redirect = $('#wct-woo-template .ossvn-login-block input[name="redirect"]').val();


		if ( $form.is( '.processing' ) ) return false;

		$form.addClass( 'processing' ).block({
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6
			}
		});

		var data = {
			action:			'wct_login',
			login:		login,
			_wpnonce:	_wpnonce,
			username: username,
			password: password,
			rememberme: rememberme,
			redirect: redirect



		};

		$.ajax({
			type:		'POST',
			url:		wc_checkout_params.ajax_url,
			data:		data,
			success:	function( data, textStatus, xhr ) {

				var code = $.parseJSON(data);

				$( '.woocommerce-error, .woocommerce-message' ).remove();
				
				$form.removeClass( 'processing' ).unblock();

				$("html, body").animate({ scrollTop: 0 }, "slow");

				if(code.logged_in == true){

					$('#wct-woo-template .wct-message').html('<div class="woocommerce-message">'+ code.status +'</div>');
					window.setTimeout(function() {
					    window.location.href = redirect;
					}, 3000);

				}else{
					$('#wct-woo-template .wct-message').html('<div class="woocommerce-error">'+ code.status +'</div>');
				}

				$('#wct-woo-template .wct-message').show();
				

			},
		});

		return false;
	});

})(jQuery); 
