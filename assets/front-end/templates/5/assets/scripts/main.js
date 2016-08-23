(function($) {
	"use strict"; 
	
	$(document).ready(function() {	
		if ($('.ossvn-login-block').length) placeholder_for_login_block();
		if ($('.ossvn-billing-details').length) placeholder_for_billing_block();
		if ($('.shipping_address').length) placeholder_for_shipping_block();
		if ($('.ossvn-order-summary-block .flexslider').length) flexslider_for_order_summary();
		if( $('body').hasClass('woocommerce-checkout') ){media_query();}
	});
	
	function media_query(){
		
		add_class_resize();
		
		$(window).resize(function(){
			$("#wct-woo-template").attr("class","");
			add_class_resize();
		});
	}
	
	function add_class_resize(){
		var width_w = $("#wct-woo-template").width();
		if (width_w < 1200) $("#wct-woo-template").addClass("width1199");
		if (width_w < 960) $("#wct-woo-template").addClass("width959");
		if (width_w < 768) $("#wct-woo-template").addClass("width767");
		if (width_w < 680) $("#wct-woo-template").addClass("width679");
		if (width_w < 546) $("#wct-woo-template").addClass("width545");
		if (width_w < 320) $("#wct-woo-template").addClass("width319");
	}
	
	
	function flexslider_for_order_summary(){
		if ($('.ossvn-order-summary-block .flexslider .slides li').length > 1){
			$('.ossvn-order-summary-block .flexslider').flexslider({
				controlNav: false,
				animation: "fade"
			});
		}
	}
	
	function placeholder_for_shipping_block(){
		$('.shipping_address .input-text').each(function(){
			$(this).attr('placeholder','');
			$(this).parent().children("label").addClass('ossvn-placeholder');
		});
		$("#shipping_country_field .input-text").attr('placeholder','');
		$("#shipping_country_field label").addClass('ossvn-placeholder');
		placeholder_process('.shipping_address .input-text');
	}
	
	function placeholder_for_billing_block(){
		$('.ossvn-billing-details .input-text').each(function(){
			$(this).attr('placeholder','');
			$(this).parent().children("label").addClass('ossvn-placeholder');
		});
		$("#billing_country_field .input-text").attr('placeholder','');
		$("#billing_country_field label").addClass('ossvn-placeholder');
		placeholder_process('.ossvn-billing-details .input-text');
	}
	
	function placeholder_for_login_block(){
		$('label[for="username"]').addClass('ossvn-placeholder');
		$('label[for="password"]').addClass('ossvn-placeholder');
		placeholder_process('.ossvn-login-block .input-text');
	}
	
	function placeholder_process(selector){
		$(selector).each(function(){
			if ($(this).val() != ''){
				$(this).prev().hide();
			}
		});
		$(selector).on('focus',function(){
			$(this).prev().hide();
		});
		$(selector).on('focusout',function(){
			if ($(this).val() != ''){
				$(this).prev().hide();
			} else{
				$(this).prev().show();
			}
		});
	}
	
	function re_arrange(selector){
		selector.children("br").remove();
		selector.children("label").first().addClass("ossvn-label-title");
		selector.children("input").each(function(){
			var label_before = $(this).prev().clone();
			$(this).after(label_before);
			$(this).prev().remove();
		});
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
    //$('#billing_country').select2();
    //$('#shipping_country').select2();

    /*================upload
    $('.input-date').datepicker({
				inline: true,
				showOtherMonths: true
			})
			.datepicker('widget').wrap('<div class="ll-skin-nigran"/>');
	/*======hidden if user-logged-in*/
	$('.user-logged-in').closest('.ossvn-accordion').find('.ossvn-title').hide();

})(jQuery);