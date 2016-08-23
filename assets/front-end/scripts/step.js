/* Created by jankoatwarpspeed.com */

(function($) {
    
    /**
    * Function steps
    * 
    * @author Comfythemes
    * @since 1.2
    */
    if( $("#wct-woo-template .step-content") ){

        var wct_steps = {
            element: $("#wct-woo-template"),
            steps: $("#wct-woo-template .step-content"),
            count: $("#wct-woo-template .step-content").size(),
            status_user_logged: wct_ajax_url.user_logged,
            order_success: wct_ajax_url.wct_order_success,
            ajax_url: wct_ajax_url.ajax_url,
            next_text: wct_ajax_url.next_button,
            prev_text: wct_ajax_url.prev_button,
            steps_i: 0,
            $form: $('form.woocommerce-checkout'),

            init: function() {
                
                $("#wct-woo-template .step-content .validate-required input").addClass('wct-validate-required-input');
                $("#wct-woo-template .step-content .validate-required select").addClass('wct-validate-required-input');
                
                $('body').on('change', '#billing_country', function (){
                    wct_steps.wct_validate_country();
                    if ( $("#billing_postcode").length ) {
                        wct_steps.wct_check_postcode('billing');
                    }
                });

                $('body').on('blur', '#billing_postcode', function (){
                    if ( $("#billing_postcode").length ) {
                        wct_steps.wct_check_postcode('billing');
                    }
                });


                $('body').on('change', '#shipping_country', function (){
                    if ($("#shipping_country").is(":visible")) {
                        wct_steps.wct_check_postcode('shipping');
                    }

                });

                $('body').on('blur', '#shipping_postcode', function (){
                    if ($("#shipping_postcode").is(":visible")) {
                        wct_steps.wct_check_postcode('shipping');
                    }

                });

                $("body").on('blur input change', '#billing_phone', function () {
                    if ( $("#billing_phone").length && $("#billing_phone_field").hasClass('validate-required') ) {
                        wct_steps.wct_validate_phone();
                    }
                });

                $("body").on('blur input change', '#billing_email', function () {
                    if ( $("#billing_email").length && $("#billing_email_field").hasClass('validate-required') ) {
                        wct_steps.wct_validate_email();
                    }
                });

                wct_steps.steps.each(function(i) {

                    wct_steps.steps_i = parseInt(i) + 1;

                    if( wct_steps.steps_i == 1 ){
                        $('body').addClass('ossvn-step-1');
                        $(this).wrap("<div id='step" + wct_steps.steps_i + "' class='ossvn-step-wrap'></div>");
                    }else{
                        $(this).wrap("<div id='step" + wct_steps.steps_i + "' class='ossvn-step-wrap' style='display:none;'></div>");
                    }
                    
                    $(this).append("<div id='step-control-" + wct_steps.steps_i + "' class='ossvn-col-12 ossvn-col ossvn-step-control' style='margin-top: 10px;'><p class='step-info'></p><p id='step" + wct_steps.steps_i + "commands'></p></div>");

                    if( wct_steps.order_success == 'on' ){

                        var step_content = $('.ossvn-order-success').closest('.ossvn-row').html();
                        $('#wct_order_success_content').html(step_content);
                        $("#ossvn-step li").addClass("ossvn-active");
                        $('form.woocommerce-checkout').remove();
                        $('.step-content').remove();

                    }else{

                        if( $(this).find('.ossvn-order-success').length == 0 ){
                            
                            wct_steps.wct_create_prev_button(wct_steps.steps_i);
							 wct_steps.wct_create_next_button(wct_steps.steps_i);

                        /*    if( $(this).find('.woocommerce-checkout-review-order-table').length == 0 ){
                                
                                wct_steps.wct_create_next_button(wct_steps.steps_i);
                            }*/
                        }
                    }

                });
                
                if( $('#ossvn-steps').length == 0 ){
                    wct_steps.$form.before( wct_steps.wct_insert_step_bar(wct_steps.count) );
                }

                wct_steps.wct_check_account(wct_steps.count);

                if( $('body.wct-template-1').length > 0 ){wct_steps.wct_steps_color();}

                if( $('body.wct-template-2').length > 0 && $("#wct-woo-template #wct-save-steps-row").length == 0 ){
                    
                    var $steps = wct_steps.wct_insert_step_bar(wct_steps.count),
                    steps_save = $steps
                                .replace(/&/g, '&amp;')
                                .replace(/"/g, '&quot;')
                                .replace(/'/g, '&#39;')
                                .replace(/</g, '&lt;')
                                .replace(/>/g, '&gt;');
                    $('#payment').before('<input type="hidden" name="wct_save_steps_row_2" id="wct-save-steps-row" value="'+ steps_save +'">');
                }


            },
            wct_insert_step_bar: function(count){

                var row = '';

                row += '<div class="ossvn-row">';

                    row += '<div id="ossvn-steps" class="ossvn-col-12 ossvn-col">';
                        
                        if( $('body').hasClass('wct-template-2') ){
                            row += '<div class="ossvn-steps-process '+ wct_ajax_url.step_style_class +'">';
                        }
                            
                            if( $('body').hasClass('wct-template-2') ){
                                row += '<ul id="ossvn-step">';
                            }else{
                                row += '<ul id="ossvn-step" class="ossvn-step-list">';
                            }

                                for( var i = 1; i <= count; i++ ){
                                    
                                    var step_name = "step" + i,
                                    step_title = $('#'+ step_name +' .step-content').data('title'),
                                    color = $('#'+ step_name +' .step-content').data('color'),
                                    step_icon = $('#'+ step_name +' .step-content').data('icon');

                                    if( i == 1 ){
                                        var active = 'ossvn-active ossvn-last-child';
                                    }else{
                                        var active = '';
                                    }

                                    row += '<li class="ossvn-step-process '+ active +'" data-step-color="'+ color +'" data-content="step-'+ i +'">';

                                        if( $('body').hasClass('wct-template-2') ){
											if (step_icon){
												$("#ossvn-wrapper").append('<i class="fa ' + step_icon + ' ossvn-step-for-remove"></i>');
												var data_icon = window.getComputedStyle(
													document.querySelector('.ossvn-step-for-remove'), ':before'
												).getPropertyValue('content');
												row += '<span class="number ossvn-with-icon">'+ data_icon.slice(1,data_icon.length - 1) +'</span><span class="text">'+ step_title +'</span>';
												$("#ossvn-wrapper .ossvn-step-for-remove").remove();
											}else{
												row += '<span class="number">'+ i +'</span><span class="text">'+ step_title +'</span>';
												//row += '<span class="number ossvn-with-icon">&#xf030;</span><span class="text">'+ step_title +'</span>';
											}

                                            

                                        }else{
                                            
                                            row += '<div class="ossvn-content"><span>'+ step_title +'</span><div class="ossvn-after"></div></div>';

                                        }

                                    row += '</li>';

                                }

                            row += '</ul>';

                        if( $('body').hasClass('wct-template-2') ){
                            row += '</div>';
                        }

                    row += '</div>';

                row += '</div>';

                return row;
            },
            wct_create_next_button: function(i){
                
                var stepName = "step" + i;
                
                if( i < wct_steps.count ){
					
					if ($("#" + stepName).find("#place_order").length){
						$("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Final' class='next ossvn-button ossvn-button-next-step'>"+ $("#place_order").val() +"</a>");
						$("#" + stepName + "Final").bind("click", function(e) {
							e.preventDefault();
							if( wct_steps.wct_validate(stepName) ){
								$("#place_order").trigger("click");
							}else{
								wct_steps.wct_message('error');
							}

							return false;
						});
					}else{
					
						$("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Next' class='next ossvn-button ossvn-button-next-step'>"+ wct_steps.next_text +"</a>");

						$("#" + stepName + "Next").bind("click", function(e) {
							
							wct_steps.wct_scroll_to_top(stepName);
							wct_steps.wct_validate_email();
							wct_steps.wct_validate_country();
							wct_steps.wct_validate_phone();

							if( wct_steps.wct_validate(stepName) ){

								wct_steps.wct_select_step(i);
								$( "#" + stepName ).hide();
								$( "#step" + (i + 1) ).show();
								wct_steps.wct_message('success');
								$('body').removeClass( 'ossvn-step-' + i );
								$('body').addClass( 'ossvn-step-' + (i + 1) );
								responsiveColumn();
								scrollTopStep();
							}else{
								wct_steps.wct_message('error');
							}

							return false;
						});
					}
                }else{
					if ($("#" + stepName).find("#place_order").length){
						$("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Final' class='next ossvn-button ossvn-button-next-step'>"+ $("#place_order").val() +"</a>");
						$("#" + stepName + "Final").bind("click", function(e) {
							e.preventDefault();
							if( wct_steps.wct_validate(stepName) ){
								$("#place_order").trigger("click");
							}else{
								wct_steps.wct_message('error');
							}

							return false;
						});
					}
				}

            },
            wct_create_prev_button: function(i){
                var stepName = "step" + i;
                if( i > 1 ){

                    $("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Prev' class='prev ossvn-button ossvn-button-next-step'>"+ wct_steps.prev_text +"</a>");
                    
                    $("#" + stepName + "Prev").bind("click", function() {
                        
                        $('body').removeClass( 'ossvn-step-' + i );
                        $('body').addClass( 'ossvn-step-' + (i - 1) );
                        wct_steps.wct_scroll_to_top(stepName);
                        $( "#" + stepName ).hide();
                        $( "#step" + (i - 1) ).show();
                        wct_steps.wct_unselect_step(i);
						responsiveColumn();
						scrollTopStep();
                        return false;
						

                    });
                }
            },
            wct_check_account: function(count){

                for( var i = 1; i <= count; i++ ){

                    if( $('#step'+ i +' .user-logged-in').length > 0 && wct_steps.status_user_logged == 'on' ){
                        $('body').removeClass( 'ossvn-step-' + i );
                        $('body').addClass( 'ossvn-step-' + (i + 1) );
                        $( '#step'+ i ).hide();
                        $( "#step" + (i + 1) ).show();
                        wct_steps.wct_select_step(i);

                    }
                }
            },
            wct_validate: function(stepName){

                var validate = true;

                if( $( '#'+ stepName +' #ship-to-different-address-checkbox' ).is(':checked') ){
                    
                    if( $( '#'+ stepName +' .form-row.woocommerce-invalid' ).length > 0 ){
                        validate = false;
                    }

                }else{

                    if( $( '#'+ stepName +' .woocommerce-billing-fields .form-row.woocommerce-invalid' ).length > 0 ){
                        validate = false;
                    }

                }

                return validate;
            },
            wct_check_postcode: function(type){

                result = $(".form-row#" + type + "_postcode_field").length > 0 && $("#" + type + "_postcode").val() != false
                && $("#" + type + "_country").length > 0 && $("#" + type + "_country").val() != false;

                if (result) {


                    var data = {
                        action: 'valid_post_code',
                        country: $("#" + type + "_country").val(),
                        postCode: $("#" + type + "_postcode").val()
                    };

                    $(document).ajaxStart( $.blockUI(
                            {
                                message: null,
                                overlayCSS:
                                        {
                                            background: "#fff",
                                            opacity: 0.6
                                        }
                            }
                    )).ajaxStop($.unblockUI);

                    $.post( wct_steps.ajax_url, data, function (response) {
                        var code = $.parseJSON(response);
                        if ( code.status == 0 ) {
                            $("#" + type + "_postcode").parent().removeClass("woocommerce-validated").addClass("woocommerce-invalid woocommerce-invalid-required-field");
                            return false;
                        } else {
                            return true;
                        }



                    });
                }

            },
            wct_validate_phone: function(){

                var phone = $('#billing_phone').val();
                phone = phone.replace(/[\s\#0-9_\-\+\(\)]/g, '');
                phone = $.trim(phone);

                if ( $('#billing_phone').val() != "" ) {
                    $("#billing_phone_field").removeClass("woocommerce-invalid woocommerce-invalid-required-field").addClass('woocommerce-validated');
                }
                if ( phone.length > 0) {
                    $("#billing_phone_field").removeClass("woocommerce-validated").addClass("woocommerce-invalid woocommerce-invalid-required-field");
                } else {
                    $("#billing_phone_field").removeClass("woocommerce-invalid woocommerce-invalid-required-field").addClass('woocommerce-validated');
                }

            },
            wct_validate_email: function(){

                var email = $('#billing_email').val();
                var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);

                if ( ! pattern.test( email  ) ) {
                    $("#billing_email_field").removeClass("woocommerce-validated").addClass("woocommerce-invalid woocommerce-invalid-required-field");
                }else{
                    $("#billing_email_field").removeClass("woocommerce-invalid woocommerce-invalid-required-field").addClass("woocommerce-validated");
                }

                if( $('#billing_country').val() == '' ){
                    $("#billing_country_field").removeClass("woocommerce-validated").addClass("woocommerce-invalid woocommerce-invalid-required-field");
                    $("#billing_country_field .select2-choice").css('border-color', '#e35c71');
                }else{
                    $("#billing_country_field .select2-choice").css('border-color', '');
                    $("#billing_country_field").removeClass("woocommerce-invalid woocommerce-invalid-required-field").addClass("woocommerce-validated");
                }

            },
            wct_validate_country: function(){

                if( $('#billing_country').val() == '' ){
                    $("#billing_country_field").removeClass("woocommerce-validated").addClass("woocommerce-invalid woocommerce-invalid-required-field");
                    $("#billing_country_field .select2-choice").css('border-color', '#e35c71');
                }else{
                    $("#billing_country_field .select2-choice").css('border-color', '');
                    $("#billing_country_field").removeClass("woocommerce-invalid woocommerce-invalid-required-field").addClass("woocommerce-validated");
                }

            },
            wct_scroll_to_top: function(stepName){

                var top_middle_steps = Math.floor($("#"+stepName).offset().top - ( ($(window).height() - $("#"+stepName).height()) / 2 ));
                if($("#"+stepName).length){$('html,body').animate({scrollTop: top_middle_steps},400);}
            },
            wct_select_step: function(i){
				$('#ossvn-step .ossvn-last-child').removeClass("ossvn-last-child");
                $('#ossvn-step li[data-content="step-'+ (i+1) +'"]').addClass("ossvn-active");
                $('#ossvn-step li[data-content="step-'+ (i+1) +'"]').addClass("ossvn-last-child");
                
            },
            wct_unselect_step: function(i){
                $('#ossvn-step li[data-content="step-'+ i +'"]').removeClass("ossvn-active");
				$('#ossvn-step .ossvn-last-child').removeClass("ossvn-last-child");
				$('#ossvn-step li[data-content="step-'+ (i - 1) +'"]').addClass("ossvn-last-child");
            },
            wct_message: function(type){

                if( $('#wct-woo-template .woocommerce-message.error').length == 0 ){
                    wct_steps.$form.before('<div class="wct-message woocommerce-message error">Please fill required fields!</div>');
                }

                if( type == 'success' ){
                    $('#wct-woo-template .woocommerce-message').remove();
                }

            },
            wct_steps_color: function(){

                var numberli = $("#ossvn-step .ossvn-step-list li").length;
                
                if (numberli != 4){
                    numberli = 100 / numberli;
                    $("#ossvn-step .ossvn-step-list li").css({
                        "width" : numberli + "%"
                    })
                }

                var count_step = 0;
                
                $("#wct-woo-template .step-content").each(function(){

                    var color_step = $(this).data("color");
                    count_step++;
                    if (color_step){
                        var darkenedColor = tinycolor(color_step).darken(10).toString();
                        $("#ossvn-wrapper").append('<style>.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #ossvn-header{background:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-title:hover{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-title:hover *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-title:hover:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-title:hover:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-title:hover :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-title:hover :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-checkbox .ossvn-block-check-box:before{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-checkbox .ossvn-block-check-box:before *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-checkbox .ossvn-block-check-box:before:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-checkbox .ossvn-block-check-box:before:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-checkbox .ossvn-block-check-box:before :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-checkbox .ossvn-block-check-box:before :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-checkbox .ossvn-block-check-box:checked+label{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-checkbox .ossvn-block-check-box:checked+label *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-checkbox .ossvn-block-check-box:checked+label:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-checkbox .ossvn-block-check-box:checked+label:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-checkbox .ossvn-block-check-box:checked+label :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-checkbox .ossvn-block-check-box:checked+label :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-radio .ossvn-block-radio:before{background:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-radio .ossvn-block-radio:checked+label{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-radio .ossvn-block-radio:checked+label *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-radio .ossvn-block-radio:checked+label:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-radio .ossvn-block-radio:checked+label:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-radio .ossvn-block-radio:checked+label :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-radio .ossvn-block-radio:checked+label :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-date input:focus,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-text input:focus,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-email input:focus,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-phone input:focus{border-color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .form-row-textarea textarea:focus{border-color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-button{border:1px solid ' + color_step + ';background:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-process-block .ossvn-process{border:10px solid ' + color_step + ';background:' + darkenedColor + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-new-customer-block .ossvn-select-checkout-method input[type="radio"]:before{background:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-new-customer-block .ossvn-select-checkout-method input[type="radio"]:checked+label{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-new-customer-block .ossvn-select-checkout-method input[type="radio"]:checked+label *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-new-customer-block .ossvn-select-checkout-method input[type="radio"]:checked+label:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-new-customer-block .ossvn-select-checkout-method input[type="radio"]:checked+label:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-new-customer-block .ossvn-select-checkout-method input[type="radio"]:checked+label :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-new-customer-block .ossvn-select-checkout-method input[type="radio"]:checked+label :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block input.input-text:focus{border-color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block .ossvn-placeholder span{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block .ossvn-placeholder span *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block .ossvn-placeholder span:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block .ossvn-placeholder span:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block .ossvn-placeholder span :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block .ossvn-placeholder span :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block input[type="submit"],.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block button{border:1px solid ' + color_step + ';background:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block input[type="submit"]:hover,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block button:hover{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block input[type="submit"]:hover *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block button:hover *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block input[type="submit"]:hover:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block button:hover:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block input[type="submit"]:hover:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block button:hover:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block input[type="submit"]:hover :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block button:hover :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block input[type="submit"]:hover :after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block button:hover :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block #rememberme:before{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block #rememberme:before *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block #rememberme:before:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block #rememberme:before:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block #rememberme:before :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block #rememberme:before :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block a{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block a *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block a:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block a:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block a :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-login-block a :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-billing-details .form-row .input-text:focus{border-color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-billing-details .form-row abbr.required{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-billing-details .form-row abbr.required *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-billing-details .form-row abbr.required:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-billing-details .form-row abbr.required:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-billing-details .form-row abbr.required :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-billing-details .form-row abbr.required :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-billing-details .woocommerce-invalid .input-text{border-color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .shipping_address .form-row .input-text:focus{border-color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .shipping_address .form-row abbr.required{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .shipping_address .form-row abbr.required *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .shipping_address .form-row abbr.required:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .shipping_address .form-row abbr.required:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .shipping_address .form-row abbr.required :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .shipping_address .form-row abbr.required :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .shipping_address .woocommerce-invalid .input-text{border-color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #ship-to-different-address .input-checkbox:before{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #ship-to-different-address .input-checkbox:before *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #ship-to-different-address .input-checkbox:before:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #ship-to-different-address .input-checkbox:before:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #ship-to-different-address .input-checkbox:before :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #ship-to-different-address .input-checkbox:before :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #payment input[type="radio"]:before{background:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #payment input[type="radio"]:checked+label{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #payment input[type="radio"]:checked+label *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #payment input[type="radio"]:checked+label:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #payment input[type="radio"]:checked+label:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #payment input[type="radio"]:checked+label :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #payment input[type="radio"]:checked+label :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #payment .place-order .form-row input[type="checkbox"]:before{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #payment .place-order .form-row input[type="checkbox"]:before *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #payment .place-order .form-row input[type="checkbox"]:before:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #payment .place-order .form-row input[type="checkbox"]:before:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #payment .place-order .form-row input[type="checkbox"]:before :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template #payment .place-order .form-row input[type="checkbox"]:before :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-coupon-block .coupon .input-text:focus{border-color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-coupon-block .coupon .button{background:' + color_step + ';border:1px solid ' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-coupon-block .coupon .button:hover{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-coupon-block .coupon .button:hover *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-coupon-block .coupon .button:hover:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-coupon-block .coupon .button:hover:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-coupon-block .coupon .button:hover :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-coupon-block .coupon .button:hover :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-thumb span{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-thumb span *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-thumb span:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-thumb span:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-thumb span :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-thumb span :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-controls .ossvn-empty-cart{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-controls .ossvn-empty-cart *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-controls .ossvn-empty-cart:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-controls .ossvn-empty-cart:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-controls .ossvn-empty-cart :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-controls .ossvn-empty-cart :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-controls .ossvn-empty-cart .fa{border:1px solid ' + color_step + ';background:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-controls .ossvn-empty-cart:hover .fa{background:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-item-price span{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-item-price span *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-item-price span:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-item-price span:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-item-price span :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-item-price span :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-size-list li.selected{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-size-list li.selected *,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-size-list li.selected:before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-size-list li.selected:after,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-size-list li.selected :before,.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-size-list li.selected :after{color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .ossvn-product-order .ossvn-size-list li.selected:before{border:1px solid ' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-order-summary-block .flexslider .flex-direction-nav a:hover{background:' + color_step + ';border-color:' + color_step + '}.ossvn-step-' + count_step + ' #ossvn-wrapper #wct-woo-template .ossvn-adv-block .ossvn-content .ossvn-btn:hover{background:' + color_step + ';border-color:' + color_step + '}</style>')
                    }

                });

            },
            wct_save_steps: function(){

            }

            
        };

        wct_steps.init();

    }

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
	
	function scrollTopStep(){
		$('html,body').animate({scrollTop: $("#ossvn-step").offset().top - 150},'slow');
	}

})(jQuery); 