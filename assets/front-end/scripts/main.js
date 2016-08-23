(function($) {
	"use strict"; 
	
	$(document).ready(function() {	
		if ($('.ossvn-login-block').length) placeholder_for_login_block();
		if ($('.ossvn-billing-details').length) placeholder_for_billing_block();
		if ($('.shipping_address').length) placeholder_for_shipping_block();
		if ($('.ossvn-order-summary-block .flexslider').length) flexslider_for_order_summary();
		media_query();
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
	
	function process_bar(){
		var max_process = 0;
		var max_shipping = 0;
		var current_process = 0;
		var current_shipping = 0;
		$(".validate-required input").each(function(){
			if ($(this).attr("id") != "s2id_autogen1" && $(this).attr("id") != "s2id_autogen1_search" && $(this).attr("id") != "s2id_autogen2" && $(this).attr("id") != "s2id_autogen2_search"){
				max_process++;
				if ($(this).attr("type") == "checkbox"){
					if($(this).prop("checked") == true){
						current_process++;
					}
				}else{
					if ($(this).val() != ""){
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
			current_process = current_process - current_shipping;
			max_process = max_process - max_shipping;
		}
		
		$('#ship-to-different-address-checkbox').change(function(){
			if ($(this).prop("checked") == true){
				current_process = current_process + current_shipping;
				max_process = max_process + max_shipping;
			}else{
				current_process = current_process - current_shipping;
				max_process = max_process - max_shipping;
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
})(jQuery);