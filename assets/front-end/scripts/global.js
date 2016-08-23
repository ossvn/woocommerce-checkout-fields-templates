(function($) {
	"use strict"; 
	var ajax_url = wct_ajax_url.ajax_url;
	
	$(document).ready(function() { 

		var checkout_form = $( 'form.checkout' );

		/*======remove file upload=========*/
		$('.progress-results .wct-file-remove').click(function(e) {
			
			$(this).closest('.uk-placeholder').find('.progress-results').hide();
			$(this).closest('.uk-placeholder').find('.progress-results p strong').text('');
			$(this).closest('.uk-placeholder').find('input[type="file"]').val('')
			e.preventDefault();

			return false;
		});

		/*=====remove account when already login==========*/
		if ($(".ossvn-account .user-logged-in").length){

			var text = $(".ossvn-account .ossvn-title").text();
			$(".ossvn-account .ossvn-title").html(''+ text +' <i class="fa fa-check"></i>');
		}
		
		$("#ossvn-wrapper #wct-woo-template .woocommerce-billing-fields .form-row label").each(function(){
			var current = $(this).next('.input-text');
			if (current.attr("placeholder")){
				$(this).hide();
			}
		});

		/*===special country checkout========*/
		if( $('#billing_country_field select').length == 0 ){
			$('#billing_country_field label').removeClass('ossvn-placeholder');
			$('#shipping_country_field label').removeClass('ossvn-placeholder');
		}

		if( $('#billing_state').hasClass('state_select ') ){
			$('#billing_state_field label').hide();
		}
		
		/*===replace button instead input in .ossvn-button-with-icon========*/
		$("#ossvn-wrapper .ossvn-button-with-icon").each(function(){
			if ($(this).find("input").length){
				var parent = $(this);
				var new_html = "<button ";
				var element = $(this).find("input");
				var element_value = "";
				//get class fa from parent for children
				var classList = $(this).attr('class').split(/\s+/);
				$.each(classList, function(index, item) {
					if (item.search("fa-") > -1) {
						element.addClass(item);
						parent.removeClass(item);
					}
				});
				$(element[0].attributes).each(function(){//get all atrribute
					if (this.nodeName == "value"){
						element_value = this.nodeValue;
					}else{
						new_html = new_html + this.nodeName + '="' + this.nodeValue + '"';
					}
				});
				
				new_html = new_html + ">" + element_value + "</button>";
				$(this).html(new_html);
			}
		});
		/*===END SCRIPT replace button instead input in .ossvn-button-with-icon========*/
		/*===clone process bar to sticky========*/
		if ($("#ossvn-wrapper .ossvn-process-block").length){
			$("#ossvn-wrapper .ossvn-process-block").each(function(){
				var source = $(this);
				var new_html = $(this).html();
				if (source.hasClass("ossvn-process-top") || source.hasClass("ossvn-process-bottom")){
					$("body").append('<div class="' + source.attr("class") + ' ossvn-process-sticky ossvn-hidden ossvn-new-append">' + new_html + '</div>')
					var clone = $(".ossvn-new-append");
					clone.removeClass("ossvn-new-append");
					if (source.hasClass("ossvn-process-top")){
						if ($("body").hasClass("admin-bar")){
							clone.addClass(".ossvn-with-admin-bar");
						}
					}
					$(window).scroll(function(){
						var current_offset = source.offset();
						var current_top = current_offset.top;
						var window_top = window.scrollY;
						if (window_top > current_top){
							clone.removeClass("ossvn-hidden");
						}else{
							clone.addClass("ossvn-hidden");
						}
					});
				}
			});
		}
		/*===END SCRIPT clone process bar to sticky========*/
	});
	
	
	$(window).bind("load",function(){
		if( $('body').hasClass('woocommerce-checkout') ){

			$("#ossvn-wrapper .input-text").each(function(){
				if ($(this).attr("placeholder")){
					if ($(this).prev(".ossvn-placeholder").length){
						$(this).attr("placeholder","");
					}
				}
			});
			responsiveColumn();//Gọi 2 lần để cập nhật lại mấy cái row bên trong row
			setTimeout(function(){
				responsiveColumn();
			}, 100);

		}
	});
	
	$(window).on("resize",function(){
		if( $('body').hasClass('woocommerce-checkout') ){
			responsiveColumn();
		}
	});

	//Dùng để responsive column
	function responsiveColumn(){
		var screenWidth = $(window).width();
		if (screenWidth < 1200){ //Nếu màn hình tablet hoặc mobile thì mới responsive
			$("#wct-woo-template .ossvn-row").each(function(){ //Kiểm tra từng dòng
				var rowWidth = $(this).width();
				if (rowWidth < 680){//full width toàn bộ col nếu row nhỏ hơn 680
					$(this).find(".ossvn-col").addClass("ossvn-full-width");
				}else{
					if (rowWidth < 970){//full width toàn bộ col trực tiếp nếu row nhỏ hơn 970 và có col nhỏ từ col-3 trở xuống
						if ($(this).children(".ossvn-col-3").length || $(this).children(".ossvn-col-2").length || $(this).children(".ossvn-col-1").length){
							$(this).children(".ossvn-col").addClass("ossvn-full-width");
						}else{
							$(this).children(".ossvn-col").removeClass("ossvn-full-width");
						}
					}
				}
			})
		}else{
			$(".ossvn-full-width").removeClass("ossvn-full-width"); //Reset lại responsive trên desktop
		}
	}
	
	
	function goToByScroll(id){
          // Reove "link" from the ID
        id = id.replace("link", "");
          // Scroll
        $('html,body').animate({
            scrollTop: $("#"+id).offset().top},
            'slow');
    }

	$('#r2').click(function(e) {
        e.preventDefault();
        $('#r1').removeAttr('checked');
        $('#r2').prop("checked", true);;
        $('#ossvn-billing').addClass('uk-active');
        goToByScroll('ossvn-billing');
    });

    $('body').on('click',function(event){
		if ($(".ossvn-datepicker-wrap.active").length){
			var current = $(event.target);
			if (!(current.parents(".ossvn-datepicker-wrap").length || current.hasClass("ossvn-datepicker-wrap") || current.next().hasClass("active"))){
				$(".ossvn-datepicker-wrap").removeClass("active");
			}
		}
	});
	
	//
	window.wct_get_data_upload = function (selector) {
        
        var data = [];

        $(''+ selector +' .uk-alert li img').each(function(){
        	
        	var img_url = $(this).attr('src'),
        	img_name = $(this).data('name'),
        	img_id = $(this).data('id');
        	data.push({
				'name' : img_name,
				'url' : img_url,
				'id': img_id
			});

        });
        if( data != '' ){

        	$(''+ selector +' .uk-alert input[type="hidden"]').val( JSON.stringify(data) );
        }else{
        	$(''+ selector +' .uk-alert').hide();
        	$(''+ selector +' .uk-alert input[type="hidden"]').val('');
        }
    };

    window.wct_remove_data_upload = function (selector) {
        
        var data = [];

        $(''+ selector +' .success .remove_img').click(function(e) {

        	var ajax_url = wc_checkout_params.ajax_url,
        	$this = $(this),
			attach_id = $(this).data('delete'),
			r = confirm(wct_ajax_url.text_js_translate.confirm_delete_file);

			if (r == true) {

				$.ajax({
					type: 'POST',
					url: ajax_url,
					data: {
						action: 'wct_delete_upload',
						attach_id: attach_id
					},
					success: function(respon)
					{
						$this.parent('.success').remove();
        				wct_get_data_upload(selector);
					}
				});
			}
        	return false;
        });

    };

    window.disable_specific_dates = function ( date ) {

    	var m = date.getMonth();
		var d = date.getDate();
		var y = date.getFullYear();

		var currentdate = (m + 1) + '-' + d + '-' + y ;
		for (var i = 0; i < specific_dates.length; i++) {
			if ($.inArray(currentdate, specific_dates) != -1 ) {
				return [false];
			}
		}

    };

    /**
    * Price fields
    *
    * @author Comfythemes
    * @since 1.0
    */
    var wct_price_field = {
		
		ajax_url: wct_ajax_url.ajax_url,
		$checkout_form: $( 'form.checkout' ),
		init: function() {

			this.$checkout_form.on( 'blur input change', '.form-row[data-price="on"] .input-text, .form-row[data-price="on"] select, .form-row[data-price="on"] input[type="radio"]', this.wct_update_price_fields );
			this.$checkout_form.on( 'change', '.form-row[data-price="on"] input[type="checkbox"]', this.wct_checkbox_update_price_fields );

		},
		wct_update_price_fields: function() {
			
			var id = $(this),
			type = id.attr('type'),
			val = id.val();

			if( val == null || val == '-1' || val == '' ){
				wct_price_field.wct_delete_price_field(id);
			}else{
				wct_price_field.wct_add_price_field(id);
			}

		},
		wct_checkbox_update_price_fields: function() {

			var id = $(this),
			val = id.val(),
			parent = id.closest('.form-row').attr('id');

			var $val = $('#'+ parent + ' .ossvn-block-check-box:checked').map(function() {
			    return this.value;
			}).get().join(', ');

			if( $val == '' ){
				wct_price_field.wct_delete_price_field(id);
			}else{
				wct_price_field.wct_add_price_field(id);
			}

		},
		wct_add_price_field: function(id) {
			
			var parent = id.closest('.form-row').attr('id'),
			block_id = id.attr('name'),
			price = $('#'+ parent).attr('data-price'),
			price_value = $('#'+ parent).attr('data-price-value'),
			price_title = $('#'+ parent +' label').first().text(),
			input_value = id.val();

			if( $('#'+ parent).hasClass('form-row-dropdown') ){
				var input_type = 'select';
			}else{
				var input_type = id.attr('type');
			}

			if ( typeof price !== 'undefined' && price != '' ) {

		        $.ajax({
		            type: 'POST',
		            url: ajax_url,
		            data: {
		                action: 'wct_custom_price',
		                price_value: price_value,
		                price_title: price_title,
		                input_value: input_value,
		                input_type: input_type,
		                block_id: block_id
		            },
		            success: function(respon)
		            {
		                var data = $.parseJSON(respon);
		                if(data.status == 1){
		                	$( 'body' ).trigger( 'update_checkout' );
		                }
		            }
		        }); 	
			}

		},
		wct_delete_price_field: function(id) {
			
			var parent = id.closest('.form-row').attr('id'),
			block_id = id.attr('name'),
			price = $('#'+ parent).attr('data-price'),
			price_value = $('#'+ parent).attr('data-price-value'),
			price_title = $('#'+ parent +' label').first().text(),
			input_value = id.val();

			if( $('#'+ parent).hasClass('form-row-dropdown') ){
				var input_type = 'select';
			}else{
				var input_type = id.attr('type');
			}

			if ( typeof price !== 'undefined' && price == 'on' ) {

		        $.ajax({
		            type: 'POST',
		            url: ajax_url,
		            data: {
		                action: 'wct_del_price',
		                price_value: price_value,
		                price_title: price_title,
		                input_value: input_value,
		                input_type: input_type,
		                block_id: block_id
		            },
		            success: function(respon)
		            {
		                var data = $.parseJSON(respon);
		                if(data.status == 1){
		                	$('.woocommerce-checkout-review-order-table .fee').hide();
		                	$( 'body' ).trigger( 'update_checkout' );
		                }
		            }
		        }); 	
			}

		}

	};

	wct_price_field.init();

	/**
	* Add custom fields to account
	* @since 1.3
	*/
	var wct_account_field = {
		
		ajax_url: wct_ajax_url.ajax_url,
		logged_in: wct_ajax_url.user_logged,
		redirect_url: '',
		$checkout_form: $( '.woocommerce-page' ),
		init: function() {

			this.$checkout_form.on( 'click', '#place_order', this.wct_account_update_fields );

		},
		wct_account_update_fields: function(){
			
			if( wct_account_field.logged_in == 'on' ){

				var email = $('#billing_email').val();
				var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);

				if( $('#wct_redirect_url').val() ){
					wct_account_field.redirect_url += $('#wct_redirect_url').val();
				}

				if( email != '' && pattern.test(email) ){
					var fields = wct_account_field.wct_get_account_fields(email);
					
					$.ajax({
			            type: 'POST',
			            url: ajax_url,
			            data: {
			                action: 'wct_account_fields',
			                email: email,
			                fields: fields
			            },
			            beforeSend: function( xhr ) {
			            	
			            	if( $('body').hasClass('woocommerce-account') ){

			            		$('#ossvn-wrapper').addClass( 'processing' ).block({
																message: null,
																overlayCSS: {
																	background: '#fff',
																	opacity: 0.8
																}
															});
			            	}

			            },
			            success: function(respon)
			            {
			                if( wct_account_field.redirect_url != '' && ! $('body').hasClass('woocommerce-checkout') ){
			                	$('#ossvn-wrapper').removeClass( 'processing' ).unblock();
			                	window.location.href = wct_account_field.redirect_url;
			                }
			            }
			        });

				}
				
			}

		},
		wct_get_account_fields: function( email ){

			var data = [];

			wct_account_field.$checkout_form.find('.form-row[data-accountpage="on"]').each(function(){

				var $this = $(this),
				val = '',
				custom_val = '',
				title = '',
				input = $this.find('.ossvn-block-field'),
				row_id = $this.attr('id');

				if ( input.is("input") ) {
			        //input
			        if( input.attr('type') == 'checkbox' || input.attr('type') == 'radio' ){

			        	var type = input.attr('type');
			        	var i = 1;
			        	var count = wct_account_field.$checkout_form.find('#'+ row_id +' input').length;
			        	wct_account_field.$checkout_form.find('#'+ row_id +' input').each(function(){

			        		var input_id = $(this).attr('id');
			        		if( $(this).is(':checked') ){

			        			val += $('label[for="'+ input_id +'"]').text();
			        			if( i < count ){
			        				val += ', ';
			        			}

			        			custom_val += $(this).val();
			        			if( i < count ){
			        				custom_val += ',';
			        			}

			        		}

			        		i++;

			        	});

			        	title += $this.find('label.ossvn-label-title').text();

			        }else{
			        	var type = input.attr('type');
			        	val += input.val();
			        	title += $this.find('label').text();
			        }

			    }else{
			    	var type = 'input';
			        val += input.val();
			        title += $this.find('label').text();
			    }

			    var name = input.attr('name');

				if( val != '' ){

					data.push({
						'block_name' 	: name,
						'block_type'    : type,
						'block_title'   : title,
						'block_value'   : val,
						'block_value_c' : custom_val,
					});

				}

			});

			return data;

		}

	};

	wct_account_field.init();

	/**
	* Logic fields by product ID
	* @author Comfythemes
	* @since 1.3
	*/
	var wct_logic_product = {
		logic_fields: wct_ajax_url.wct_logic_fields,
		init: function(){

			this.wct_load_logic_product();
		},
		wct_load_logic_product: function(){

			var fields_default 	= wct_logic_product.wct_get_logic_product_fields(),
	        fields_checkout = wct_logic_product.wct_get_logic_product_fields_checkout(),
	        show_all = true,
	        show_any = true,
	        hide_all = true,
	        hide_any = true;

	        $.each(fields_default, function(k, v) {
			    
	            if( wct_logic_product.wct_logic_product_show_all(fields_checkout[k]) == true ){
	            	wct_logic_product.wct_check_logic_product( 'show_all', v );
	            }

	            if( wct_logic_product.wct_logic_product_show_any(fields_checkout[k]) == true ){
	            	wct_logic_product.wct_check_logic_product( 'show_any', v );
	            }

	            if( wct_logic_product.wct_logic_product_hide_all(fields_checkout[k]) == true ){
	            	wct_logic_product.wct_check_logic_product( 'hide_all', v );
	            }

	            if( wct_logic_product.wct_logic_product_hide_any(fields_checkout[k]) == true ){
	            	wct_logic_product.wct_check_logic_product( 'hide_any', v );
	            }

	        });
			

		},
		wct_check_logic_product: function( logic_status, block_id ){
			
			$.ajax({
	            type: 'POST',
	            url: ajax_url,
	            data: {
	                action: 'wct_load_logic_cart',
	                logic_status: logic_status,
	                block_id: block_id
	            },
	            success: function(respon)
	            {
	                var data = $.parseJSON(respon);

	                switch ( logic_status ) {
				
						case 'show_any':
							if( data.status == 1 ){
								$('#'+ block_id +'_field').show();
							}
							break;
						case 'hide_all':
							if( data.status == 1 ){
								$('#'+ block_id +'_field').hide();
							}
							break;
						case 'hide_any':
							if( data.status == 1 ){
								$('#'+ block_id +'_field').hide();
							}
							break;
						default:
							if( data.status == 0 ){
								$('#'+ block_id +'_field').hide();
							}
							break;

					}
	            }
	        });

		},
		wct_get_logic_product_fields: function(){

			var obj = wct_logic_product.logic_fields,
			length = Object.keys(obj).length,
			data = [];
			if( length > 0 ){
				
				$.each(obj, function(key, value) {
		            if(value.status == 'on'){data.push(key);}
		        });

			}

			return data;

		},
		wct_get_logic_product_fields_checkout: function(){

			var data = [];
			$('form.woocommerce-checkout .block-logic-product-on').each(function(){
				var id = $(this).attr('id');
				data.push(id);
			});

			return data;

		},
		wct_logic_product_show_all: function( id ){

			var status = false;
			if( !$('#'+id).hasClass('block-logic-product-hide') && !$('#'+id).hasClass('block-logic-product-any') ){
				status = true;
			}
			return status;

		},
		wct_logic_product_show_any: function( id ){

			var status = false;
			if( !$('#'+id).hasClass('block-logic-product-hide') && $('#'+id).hasClass('block-logic-product-any') ){
				status = true;
			}
			return status;

		},
		wct_logic_product_hide_all: function( id ){

			var status = false;
			if( $('#'+id).hasClass('block-logic-product-hide') && !$('#'+id).hasClass('block-logic-product-any') ){
				status = true;
			}
			return status;

		},
		wct_logic_product_hide_any: function( id ){

			var status = false;
			if( $('#'+id).hasClass('block-logic-product-hide') && $('#'+id).hasClass('block-logic-product-any') ){
				status = true;
			}
			return status;

		}
	};
	wct_logic_product.init();

	
	/**
	* Checkout process bar
	* 
	* @author Comfythemes
	* @since 1.0
	*/
	function process_bar(){
		
		

		var max_process 	= 0,
		max_shipping 		= 0,
		current_process 	= 0,
		current_shipping 	= 0,
		max_max_process = 0;

		$(".validate-required input").each(function(){

			if ($(this).attr("id") != "s2id_autogen1" && $(this).attr("id") != "s2id_autogen1_search" && $(this).attr("id") != "s2id_autogen2" && $(this).attr("id") != "s2id_autogen2_search" && !($(this).parents(".select2-container").length)){
				max_process++;
				max_max_process++;
				if ($(this).attr("type") == "checkbox"){

					if($(this).prop("checked") == true){

						current_process++;

					}

				}else{

					if ($(this).val() != "" || $(this).hasClass("hidden")){

						current_process++;

					}

				}

			}

		});
		
		 

		$(".shipping_address .validate-required input").each(function(){

			if ($(this).attr("id") != "s2id_autogen1" && $(this).attr("id") != "s2id_autogen1_search" && $(this).attr("id") != "s2id_autogen2" && $(this).attr("id") != "s2id_autogen2_search"){

				max_shipping++;

				if ($(this).attr("type") == "checkbox"){

					if($(this).prop("checked") == true){

						current_shipping++;

					}

				}else{

					if ($(this).val() != ""){

						current_shipping++;

					}

				}

			}

		});



		if ($('#ship-to-different-address-checkbox').prop("checked") == false){
			
			if (max_max_process == max_process){
				current_process = current_process - current_shipping;
				max_process = max_process - max_shipping;
			}

			

		}

		$('#ship-to-different-address-checkbox').on('change',function(){

			if ($(this).prop("checked") == true){
				if (max_max_process > max_process){
					current_process = current_process + current_shipping;

					max_process = max_process + max_shipping;
				}

			}else{
				if (max_max_process == max_process){
					current_process = current_process - current_shipping;

					max_process = max_process - max_shipping;
				}
			}

			set_process_bar(max_process,current_process);

		});

		

		set_process_bar(max_process,current_process);
		

		$(".validate-required input").change(function(){
			if ($(this).attr("id") != "s2id_autogen1" && $(this).attr("id") != "s2id_autogen1_search" && $(this).attr("id") != "s2id_autogen2" && $(this).attr("id") != "s2id_autogen2_search"){

				if ($(this).val() == ""){

					current_process--;

					if ($(this).parents(".shipping_address").length) current_shipping--;
					
					set_process_bar(max_process,current_process);

				}else{

					current_process++;
					if ($(this).parents(".shipping_address").length) current_shipping++;

					set_process_bar(max_process,current_process);

				}

			}

		});

	}

	

	function set_process_bar(max_process,current_process){
		
		var percent_process;

		if (max_process > 0){

			percent_process = Math.floor(current_process * 100 / max_process);
		}else{

			percent_process = 100;

		}

		$(".ossvn-process-block .ossvn-process-bar").width(percent_process + "%");

		$(".ossvn-process-block .ossvn-process-bar span").text(percent_process + "%");

	}

	if ($(".ossvn-process-block").length > 0){ process_bar(); }

	
})(jQuery);