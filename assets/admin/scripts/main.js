/*------------------------------------------------------------------
[Table of contents]

1. General
2. Toggle Laptop In Page 1
3. Row/Col
------3.1 Add first row into .ossvn-drop-area if it's empty
------3.2 Add new row/col
------3.3 Add new row by template
------3.4 Add new row by custom template
------3.5 Sort Row/Col
------------3.5.1 Add sortable to the Row/Col that already have in page
------------3.5.2 Add sortable to new Row/Col/Block 
------3.6 Edit Row/Col
------3.7 Delete Row/Col/Block
4. Block
------4.1 Add new Block
------4.2 Edit Block
------4.3 Set max block_id when page load
5. Styling Modal
6. Add class not-hover to parent of current row/col/block
7. Color Control
8. Information Field
------8.1 Add new checkbox
------8.2 Edit checkbox
------8.3 Delete checkbox
9. Save Data to shortcode
10. Other Function
------10.1 Set data value from div to modal
------10.2 Get data value from modal
------10.3 Reset all input in modal
------10.4 Left Column Mobile
------10.5 Sticky Sidebar
------10.6 Addclass and id for label checkbox and radio
-------------------------------------------------------------------*/
(function($) {
	"use strict"; 

/*------------------------------------------------------------------
[1. General]
*/
	var max_id = 1;
	var arr_id = [];
	var check_change_color = false;
	
	$(document).ready(function() {
		toggle_when_click_on_off();
		expand_first_row();
		expand_rowcol();
		manage_control_hover();
		drag_content_to_col();
		sort_rowcol();
		expand_template_row();
		expand_template_row_custom();
		del_rowcol();
		edit_rowcol();
		edit_block();
		styling();
		change_color();
        row_display_option();
        step_save_data();
		data_raw_save();
		set_max_id();
		information_storage_data();
		left_col_mobile();
		sticky_sidebar();
		checkbox_radio_manage();
		wct_step_settings.wct_reorder_step();
	});

/*------------------------------------------------------------------
[2. Toggle Laptop In Page 1]
*/
	function toggle_when_click_on_off(){
		$('.ossvn-turn-control .ossvn-control').click(function(){
			if ($(this).hasClass('active')){
				$(this).removeClass('active');
				$(this).parents('.ossvn-form-choose').removeClass('active');
				$('.ossvn-form-choose').removeClass('inactive');
			}else{
				$('.ossvn-turn-control .ossvn-control').removeClass('active');
				$(this).addClass('active');
				$('.ossvn-form-choose').addClass('inactive');
				$('.ossvn-form-choose').removeClass('active');
				$(this).parents('.ossvn-form-choose').removeClass('inactive');
				$(this).parents('.ossvn-form-choose').addClass('active');
			}
		});
	}
	
/*------------------------------------------------------------------
[3. Row/Col]
*/
/*------------------------------------------------------------------
[3.1 Add first row into .ossvn-drop-area if it's empty]
*/
	function expand_first_row(){
		var check_current = true;
		$('.ossvn-drop-area .ossvn-row').each(function(){
			check_current = false;
		});
		if (check_current == true){
			$('.ossvn-drop-area').append($('#ossvn-template-row').html());
			var new_row = $('.ossvn-drop-area .ossvn-new-row');
			new_row.removeClass('ossvn-new-row');
			add_sortable_to_new_element(new_row);
		}
	}
	
/*------------------------------------------------------------------
[3.2 Add new row/col]
*/	
	function expand_rowcol(){
		$('.ossvn-visual-composer-content').on('click','.ossvn-add-new-row',function(event){
			event.preventDefault();
			$('.ossvn-drop-area').append($('#ossvn-template-row').html());
			var new_row = $('.ossvn-drop-area .ossvn-new-row');
			new_row.removeClass('ossvn-new-row');
			add_sortable_to_new_element(new_row);
		});
		$('.ossvn-drop-area').on('click','.ossvn-add-col',function(event){
			event.preventDefault();
			var parent = $(this).parent().parent();
			parent.append($('#ossvn-template-col').html());
			parent.removeClass('ossvn-empty');
			var new_col = parent.children('.ossvn-new-col');
			if (parent.parent().hasClass('ossvn-col')){
				new_col.find(".ossvn-add-row").remove();
			}
			new_col.removeClass('ossvn-new-col');
			add_sortable_to_new_element(new_col);
		});
		$('.ossvn-drop-area').on('click','.ossvn-add-row',function(event){
			event.preventDefault();
			var parent = $(this).parent().parent();
			parent.append($('#ossvn-template-row').html());
			parent.removeClass('ossvn-empty');
			var new_row = parent.children('.ossvn-new-row');
			new_row.removeClass('ossvn-new-row');
			add_sortable_to_new_element(new_row);
		});
	}
	
/*------------------------------------------------------------------
[3.3 Add new row by template]
*/	

	function expand_template_row(){
		$('.ossvn-drop-area').on('click','.ossvn-edit-row',function(event){
			event.preventDefault();
			$(this).parent().toggleClass('active');
		});		
		$('.ossvn-drop-area').on('click','.ossvn-row-template',function(event){
			event.preventDefault();
			var current = $(this).parent().parent().parent();
			var arr = $(this).attr('data-template').split(' ');
			var i,new_col;
			current.removeClass('ossvn-empty');
			current.children('.ossvn-col').remove();
			for (i = 0; i < arr.length; i++){
				current.append($('#ossvn-template-col').html());
				new_col = current.children('.ossvn-new-col');
				new_col.removeClass('ossvn-new-col');
				new_col.removeClass('ossvn-col-12');
				new_col.addClass(arr[i]);
				if (current.parent().hasClass('ossvn-col')){
					new_col.find(".ossvn-add-row").remove();
				}
				add_sortable_to_new_element(new_col);
			}
		});
	}

/*------------------------------------------------------------------
[3.4 Add new row by custom template]
*/	
	function expand_template_row_custom(){
		$('.ossvn-drop-area').on('click','.ossvn-edit-row',function(event){
			event.preventDefault();
			$('#ossvn-row-custom-input').val("");
		});
		$('#ossvn-template-custom-modal .ossvn-save-col').on('click',function(event){
			event.preventDefault();
			var current = $('.target-waiting-for-change');
			var str_arr = "";
			var row_change = $('#ossvn-row-custom-input').val();
			var error = false;
			current.removeClass('target-waiting-for-change');
			if (row_change){
				var arr = row_change.split('+');
				var i;
				for (i=0;i<arr.length;i++){
					var arr_con = arr[i].split('/');
					if (arr_con.length == 2){
						if (isNaN(parseInt(arr_con[0].trim())) == false && isNaN(parseInt(arr_con[1].trim())) == false){
							switch(parseInt(arr_con[0]) / parseInt(arr_con[1])){
								case 1/12: str_arr = str_arr + " ossvn-col-1"; break;
								case 1/6: str_arr = str_arr + " ossvn-col-2"; break;
								case 1/4: str_arr = str_arr + " ossvn-col-3"; break;
								case 1/3: str_arr = str_arr + " ossvn-col-4"; break;
								case 5/12: str_arr = str_arr + " ossvn-col-5"; break;
								case 1/2: str_arr = str_arr + " ossvn-col-6"; break;
								case 7/12: str_arr = str_arr + " ossvn-col-7"; break;
								case 8/12: str_arr = str_arr + " ossvn-col-8"; break;
								case 3/4: str_arr = str_arr + " ossvn-col-9"; break;
								case 5/6: str_arr = str_arr + " ossvn-col-10"; break;
								case 11/12: str_arr = str_arr + " ossvn-col-11"; break;
								case 1: str_arr = str_arr + " ossvn-col-12"; break;
								default: error = true;
							}
						}else{
							error = true;
							break;
						}
					}else{
						error = true;
						break;
					}
				}
			}else{
				alert(ossvn_ajax_url.text_js_translate.error_layout_format_text);
			}
			
			if (error == true){
				alert(ossvn_ajax_url.text_js_translate.error_layout_format_text);
			}else{
				var new_col;
				var arr_col = str_arr.trim().split(" ");
				current.removeClass('ossvn-empty');
				current.children('.ossvn-col').remove();
				for (i = 0; i < arr_col.length; i++){
					current.append($('#ossvn-template-col').html());
					new_col = current.children('.ossvn-new-col');
					new_col.removeClass('ossvn-new-col');
					new_col.removeClass('ossvn-col-12');
					new_col.addClass(arr_col[i]);
					if (current.parent().hasClass('ossvn-col')){
						new_col.find(".ossvn-add-row").remove();
					}
					add_sortable_to_new_element(new_col);
				}
			}
			var modal = UIkit.modal("#ossvn-template-custom-modal");
			modal.hide();
		});
	}
	
/*------------------------------------------------------------------
[3.5 Sort Row/Col]
*/
/*------------------------------------------------------------------
[3.5.1 Add sortable to the Row/Col that already have in page]
*/	
	function sort_rowcol(){
		$( ".ossvn-drop-area").sortable({
			items: ".drag-level-1",
			handle: "> .ossvn-row-controls .ossvn-drag"
		});
		$( ".ossvn-drop-area .ossvn-row").each(function(){
			$(this).sortable({
				items: "." + $(this).attr('data_drag'),
				handle: "> .ossvn-row-controls .ossvn-drag",
			});
		});
		$( ".ossvn-drop-area .ossvn-col").each(function(){
			$(this).sortable({
				items: "." + $(this).attr('data_drag'),
				connectWith: ".ossvn-col",
				placeholder: "ossvn-placeholder",
				handle: "> .ossvn-row-controls .ossvn-drag",
				stop: function( e, ui ){
					wct_step_settings.wct_reorder_step();
					//wct_reorder_step_bar();
				}
			});
		});
		$(".ossvn-drop-area .ossvn-col").on("sortover",function(){
			$(this).addClass("ossvn-active-placeholder");
		});
		$(".ossvn-drop-area .ossvn-col").on("sortout",function(){
			$(this).removeClass("ossvn-active-placeholder");
		});

	}
/*------------------------------------------------------------------
[3.5.2 Add sortable to new Row/Col/Block ]
*/	
	function add_sortable_to_new_element(selector){
		if (selector.parent().attr('data_drag')){
			selector.addClass(selector.parent().attr('data_drag'));
			selector.attr('data_drag',selector.parent().attr('data_drag') + '-1');
		}else{
			selector.addClass('drag-level-1');
			selector.attr('data_drag','drag-level-1-1');
		}
		if (selector.hasClass("ossvn-col")){
			selector.sortable({
				items: "." + selector.attr('data_drag'),
				connectWith: ".ossvn-col",
				placeholder: "ossvn-placeholder",
				handle: "> .ossvn-row-controls .ossvn-drag",
				over: function( event, ui ) {
					selector.addClass("ossvn-active-placeholder");
				},out: function(event,ui){
					selector.removeClass("ossvn-active-placeholder");
				}
			});
		}else{
			selector.sortable({
				items: "." + selector.attr('data_drag'),
				handle: "> .ossvn-row-controls .ossvn-drag"
			});
		}
	}
/*------------------------------------------------------------------
[3.6 Edit Row/Col]
*/		
	function edit_rowcol(){
		$('.ossvn-drop-area').on('click','.ossvn-edit-col',function(event){
			event.preventDefault();
			var parent = $(this).parent().parent();
			var i;
			parent.addClass('target-waiting-for-change');
			for (i = 1;i<13; i++){
				if(parent.hasClass('ossvn-col-' + i)) $('#ossvn-edit-col-modal .ossvn-select-col-width').val('ossvn-col-' + i);
			}
			
			reset_form_data('#ossvn-edit-col-modal');
			
			parent.each(function() {
				$.each(this.attributes, function() {
					if(this.specified) {
						set_data_value('#ossvn-edit-col-modal',this);
					}
				});
			});
		});
		$('#ossvn-edit-col-modal .ossvn-save-col').on('click',function(){
			var selector = $('.target-waiting-for-change');
			var modal = UIkit.modal("#ossvn-edit-col-modal");
			if (selector.hasClass('ossvn-empty')){
				selector.removeClass();
				selector.addClass('ossvn-empty');
			} else{
				selector.removeClass();
			}
			selector.addClass($('#ossvn-edit-col-modal .ossvn-select-col-width').val());
			selector.addClass('ossvn-col');
			if (selector.parent().attr('data_drag'))
				selector.addClass(selector.parent().attr('data_drag'));
			else
				selector.addClass('drag-level-1');
			get_data_value("#ossvn-edit-col-modal",selector);
			modal.hide();
		});
		$('#ossvn-edit-col-modal').on('hide.uk.modal',function(){
			$('.target-waiting-for-change').removeClass('target-waiting-for-change');
		});
	}
/*------------------------------------------------------------------
[3.7 Delete Row/Col/Block]
*/			
	function del_rowcol(){
		$('.ossvn-drop-area').on('click','.ossvn-delete-row',function(event){
			var current_row = $(this).parent().parent();
			var r = confirm(ossvn_ajax_url.text_js_translate.confirm_delete_row_text);
			if (r == true) {
				current_row.find(".ossvn-block").each(function(){
					delete_block($(this));
				});
				current_row.remove();
				wct_step_settings.wct_reorder_step();
			}
		});
		$('.ossvn-drop-area').on('click','.ossvn-delete-col',function(event){
			var r = confirm(ossvn_ajax_url.text_js_translate.confirm_delete_col_text);
			if (r == true) {
				var current_row = $(this).parent().parent().parent();
				var check_row = false;
				$(this).parent().parent().find(".ossvn-block").each(function(){
					delete_block($(this));
				});
				$(this).parent().parent().remove();
				current_row.children('.ossvn-col').each(function(){
					check_row = true;
				});
				if (check_row == false){
					current_row.addClass("ossvn-empty");
				}
			}
		});
		$('.ossvn-drop-area').on('click','.ossvn-delete-block',function(event){
			var r = confirm(ossvn_ajax_url.text_js_translate.confirm_delete_block_text);
			if (r == true) {
				var this_block =  $(this).parent().parent();
				delete_block(this_block);
				
				this_block.remove();
				
				var parent = this_block;
				var parent_step = parent.attr('step_id_content');
				if(parent_step){
					$('#'+ parent_step +'').remove();	
				}
				
			}
		});
	}
	function delete_block(this_block){
		var i,data_id = this_block.attr('block_id');
		if (data_id){
			for (i = 0; i < arr_id.length;i++){
				if (data_id == arr_id[i]){
					delete_checkbox_in_information_field(i);
					break;
				}
			}
		}
		if (this_block.hasClass('ossvn-block-only-one')){
			$('.ossvn-left-col .ossvn-block-only-one[woo_field_id="' + this_block.attr('woo_field_id') + '"]').show();
		}
	}
/*------------------------------------------------------------------
[4. Block]
*/	
/*------------------------------------------------------------------
[4.1 Add new Block]
*/
	// Add placeholder field
	var check_drag = false;	
	function add_placeholder_field(){
		$(window).mousemove(function(event){
			if (check_drag == true){
				var current;
				var current_child;
				$('.ossvn-drop-area .ossvn-col').each(function(){
					if (event.pageX > $(this).offset().left && event.pageY > $(this).offset().top && event.pageX < $(this).offset().left + $(this).width() +14 && event.pageY < $(this).offset().top + $(this).height() + 40 ){
						current = $(this);
					}
				});
				if (current){
					if (!(current.hasClass('ossvn-active-placeholder'))){
						if ($(".ossvn-placeholder").length){
							$(".ossvn-placeholder").remove();
						}
						$('.ossvn-active-placeholder').removeClass('ossvn-active-placeholder');
						current.addClass('ossvn-active-placeholder');
					}
					if (current.children(".ossvn-row").length || current.children(".ossvn-block").length){
						var poi_top = event.pageY - current.offset().top;
						current.children().each(function(){
							if (!($(this).hasClass("ossvn-placeholder")) && !($(this).hasClass("ossvn-row-controls"))){
								var padding = 21;// ossvn-row padding and border
								if ($(this).hasClass("ossvn-block")){
									padding = 8;
								}
								if (event.pageY > $(this).offset().top + ($(this).height() / 2) + padding ){
									current_child = $(this);
								}
							}
						});
					}
					if (current_child){
						if (!(current_child.hasClass("ossvn-current-after-placeholder"))){
							$(".ossvn-current-after-placeholder").removeClass("ossvn-current-after-placeholder");
							current_child.addClass("ossvn-current-after-placeholder");
							if ($(".ossvn-placeholder").length){
								$(".ossvn-placeholder").remove();
							}
							$("<div class='ossvn-placeholder'></div>").insertAfter(current_child);
						}
					}else{
						if (!($('.ossvn-active-placeholder').children(".ossvn-placeholder").length)){
							$("<div class='ossvn-placeholder'></div>").insertAfter('.ossvn-active-placeholder >  .ossvn-row-controls');
						} else{
							if ($('.ossvn-active-placeholder').children(".ossvn-current-after-placeholder").length){
								$(".ossvn-placeholder").remove();
								$("<div class='ossvn-placeholder'></div>").insertAfter('.ossvn-active-placeholder >  .ossvn-row-controls');
								$(".ossvn-current-after-placeholder").removeClass("ossvn-current-after-placeholder");
							}
						}
					}
				}else{
					if ($('.ossvn-active-placeholder').length){
						$('.ossvn-active-placeholder').removeClass('ossvn-active-placeholder');
						if ($(".ossvn-placeholder").length){
							$(".ossvn-placeholder").remove();
							current_child = null;
							$(".ossvn-current-after-placeholder").removeClass("ossvn-current-after-placeholder");
						}
					}
				}
			}
		});
	}

	function drag_content_to_col(){
		add_placeholder_field();
		$('#ossvn-visual-composer .ossvn-left-col .ossvn-block').draggable({
			helper:'clone',			
			appendTo: '.ossvn-right-col',
			cursorAt: { top: 0, left: 0 },
			containment: '#ossvn-wrapper',
			start: function(event,ui){
				$(ui.helper).addClass('block-dragging');
				check_drag = true;
				$("#ossvn-visual-composer .ossvn-left-col").removeClass("ossvn-active");
			},
			stop: function(event,ui){
				check_drag = false;
				$(".ossvn-active-placeholder").removeClass("ossvn-active-placeholder");
				$(".ossvn-current-after-placeholder").removeClass("ossvn-current-after-placeholder");
			}
		});
		$('#ossvn-visual-composer .ossvn-right-col').droppable({
			drop: function( event, ui ) {
				if ($(ui.helper).hasClass('block-dragging')){
					if ($(".ossvn-placeholder").length){
						var html;
						if ($(ui.helper).hasClass('ossvn-block-only-one')){
							html = "<div type='" + $(ui.helper).attr('data-type') + "' woo_field_id='" + $(ui.helper).attr('woo_field_id') + "' block_required='" + $(ui.helper).attr('block_required') + "' woo_field_type='" + $(ui.helper).attr('woo_field_type') + "' class='" + $(ui.helper).attr('class') + " ossvn-new-block'>" + ui.draggable.html() + "</div>";
							$('.ossvn-left-col .ossvn-block-only-one[woo_field_id="' + $(ui.helper).attr('woo_field_id') + '"]').hide();
						}else{
							html = "<div type='" + $(ui.helper).attr('data-type') + "' class='" + $(ui.helper).attr('class') + " ossvn-new-block'>" + ui.draggable.html() + "</div>";
						}
						$(".ossvn-placeholder").parent().removeClass('ossvn-empty');
						$(".ossvn-placeholder").replaceWith(html);
						var new_block = $('.ossvn-new-block');
						new_block.removeClass('ui-draggable');
						new_block.removeClass('ui-draggable-handle');
						new_block.removeClass('ui-draggable-dragging');
						new_block.removeClass('block-dragging');
						new_block.removeClass('ossvn-new-block');
						new_block.append($('#ossvn-template-block').html());
						new_block.children('.ossvn-block-controls').children('.ossvn-edit-block').attr('data-uk-modal','{target:"' + $(ui.helper).attr('target-modal') + '"}');
						new_block.children('.ossvn-block-controls').children('.ossvn-edit-block').attr('data-modal', $(ui.helper).attr('target-modal'));
						new_block.attr("block_title",new_block.children(".ossvn-span-block-title").text());
						arr_id[arr_id.length] = "wct_" + max_id;
						new_block.attr("block_id","wct_" + max_id);
						max_id++;
						add_sortable_to_new_element(new_block);
						$('.ossvn-drop-area .ossvn-row,.ossvn-drop-area .ossvn-col').addClass("not-hover");
						append_checkbox_to_information_field(arr_id[arr_id.length - 1],arr_id.length - 1);
					}else{
						$("#ossvn-visual-composer .ossvn-left-col").addClass("ossvn-active");
					}
				}
			}
		});
	}
	
/*------------------------------------------------------------------
[4.2 Edit Block]
*/
	function edit_block(){
		
		$('.ossvn-drop-area').on('click','.ossvn-edit-block',function(event){
			event.preventDefault();
			var parent = $(this).parent().parent();
			var i;
			parent.addClass('target-waiting-for-change');
			reset_form_data('.ossvn-block-modal');
			
			parent.each(function() {
				$.each(this.attributes, function() {
					if(this.specified) {
						set_data_value(parent.find('.ossvn-edit-block').attr('data-modal'),this);
					}
				});
			});

			/*================nam====================*/
			var modal_id = $(this).attr('data-modal');
			var modal_title = $('.target-waiting-for-change').attr('block_title');
			$(''+ modal_id +' .ossvn-modal-header').html('<i class="fa fa-pencil-square-o"></i>Edit '+ modal_title +'<a class="uk-modal-close uk-close ossvn-modal-close"></a>');

			$(''+ modal_id +' input[type="checkbox"]').each(function() {
				var attribute = $(this).attr('data-target');
				wct_set_checkbox_checked( parent, attribute);
			});

			wct_reset_data_logic_fields(modal_id);

			if(parent.hasClass('ossvn-custom-fields')){

				$('.ossvn-block-modal .ossvn-price').show();
				$('.ossvn-block-modal .ossvn-form-group-user-role').show();
				/*============field price modal=================*/
				$('.ossvn-modal .ossvn-price input[type="checkbox"]').click(function() {
					if($(this).is(":checked")){
						$(this).next().show();
					}else{
						$(this).next().hide();
					}
				});
				$('.ossvn-block-modal .ossvn-display-pdf-invoices').show();
				$('.ossvn-block-modal .show_if_custom_fields').show();

			}else{
				$('.ossvn-block-modal .ossvn-price').hide();
				$('.ossvn-block-modal .ossvn-form-group-user-role').hide();
				$('.ossvn-block-modal .show_if_custom_fields').hide();
			}
			/*================END nam====================*/
			
		}).trigger('wct_edit_block');;

		$('.ossvn-block-modal .ossvn-save-col').on('click',function(){
			var selector = $('.target-waiting-for-change');
			var modal_id = '#' + $(this).parents('.ossvn-block-modal').attr('id');
			var modal = UIkit.modal(modal_id);
			var check_id  = true;


			/*==============nam==============*/

				/*===========Save logic fields=============*/
				if(selector.attr('type') == 'woo_field'){
						
					var selector_id = selector.attr('woo_field_id');
				}else{
					
					var selector_id = selector.attr('block_id');
				}

				var logic_field = [],
				logic_field_show = $(''+ modal_id +' select[data-target="block_cond_logic_show"]').val(),
				logic_field_all = $(''+ modal_id +' select[data-target="block_cond_logic_all"]').val();

				if($('.ossvn-block-modal #block-cond-logic .ossvn-checkbox-user-role').is(':checked')){

					logic_field = wct_get_rule_conditional_logic(modal_id);

					wct_update_block_rule_conditional_logic( 'on', logic_field_show, logic_field_all, selector_id, logic_field );

				}else{
					
					logic_field = wct_get_rule_conditional_logic(modal_id);

					wct_update_block_rule_conditional_logic( 'off', logic_field_show, logic_field_all, selector_id, logic_field);
				}



				
				/*===========END Save logic fields=============*/


				if ($(modal_id + ' .ossvn-get-data[data-target="order_success_content"]').length){
					var order_content = $(modal_id + ' .ossvn-get-data[data-target="order_success_content"]').val();
					var res_order_content = order_content
					            .replace(/&/g, '&amp;')
					            .replace(/"/g, '&quot;')
					            .replace(/'/g, '&#39;')
					            .replace(/</g, '&lt;')
					            .replace(/>/g, '&gt;');
		            selector.attr('order_success_p', res_order_content);

				}

				if ($(modal_id + ' .ossvn-get-data[data-target="ossvn_html_content"]').length){
					var html_content = $(modal_id + ' .ossvn-get-data[data-target="ossvn_html_content"]').val();
					var res_html_content = html_content
					            .replace(/&/g, '&amp;')
					            .replace(/"/g, '&quot;')
					            .replace(/'/g, '&#39;')
					            .replace(/</g, '&lt;')
					            .replace(/>/g, '&gt;');
		            selector.attr('ossvn_html_content_p', res_html_content);

				}

				if ($(modal_id + ' .ossvn-get-data[data-target="block_checkbox_options"]').length){
					var html_checkbox_options = $(modal_id + ' .ossvn-get-data[data-target="block_checkbox_options"]').val();
					var res_checkbox_options = html_checkbox_options
					            .replace(/&/g, '&amp;')
					            .replace(/"/g, '&quot;')
					            .replace(/'/g, '&#39;')
					            .replace(/</g, '&lt;')
					            .replace(/>/g, '&gt;');
		            selector.attr('block_checkbox_options_p', res_checkbox_options);

				}

			/*==============End nam==============*/



			if ($(modal_id + ' .ossvn-get-data[data-target="block_id"]').length){
				var i,data_id = $(modal_id + ' .ossvn-get-data[data-target="block_id"]').val();
				if (data_id){
					for(i =0; i<arr_id.length;i++){
						if (arr_id[i] == data_id && data_id != $('.target-waiting-for-change').attr("block_id"))
							check_id = false;
					}
				} else{
					check_id = false;
				}
			}
			if (check_id == true){
				var i,data_id = $(modal_id + ' .ossvn-get-data[data-target="block_id"]').val();
				if (data_id){
					for(i =0; i<arr_id.length;i++){
						if (arr_id[i] == $('.target-waiting-for-change').attr("block_id")){
							
							edit_checkbox_in_information_field(arr_id[i],data_id,$(modal_id + ' .ossvn-get-data[data-target="block_title"]').val());
							arr_id[i] = data_id;
						}
					}
				}
				if ($(modal_id + ' .ossvn-get-data[data-target="block_title"]').length){
					selector.children(".ossvn-span-block-title").text($(modal_id + ' .ossvn-get-data[data-target="block_title"]').val());
				}
				get_data_value(modal_id,selector);
				modal.hide();
			} else{
				alert(ossvn_ajax_url.text_js_translate.block_exist_text);
			}
		}).trigger('wct_save_block');

		$('.ossvn-block-modal').on('hide.uk.modal',function(){
			/*reset value checkbox*/
			wct_reset_checkbox_value_on($('.target-waiting-for-change'), 'block_required');
			wct_reset_checkbox_value_on($('.target-waiting-for-change'), 'block_display_order_recived');
			wct_reset_checkbox_value_on($('.target-waiting-for-change'), 'block_display_email');
			wct_reset_checkbox_value_on($('.target-waiting-for-change'), 'block_price');
			wct_reset_checkbox_value_on($('.target-waiting-for-change'), 'block_user_logic');
			wct_reset_checkbox_value_on($('.target-waiting-for-change'), 'block_cond_logic');
			$('.target-waiting-for-change').removeClass('target-waiting-for-change');
		});
	}
/*------------------------------------------------------------------
[4.3 Set max block_id when page load]
*/	
	function set_max_id(){
		$('.ossvn-drop-area .ossvn-block').each(function(){
			if ($(this).attr("block_id")){
				var check_id = parseInt($(this).attr("block_id").replace("wct_",""));
				arr_id[arr_id.length] = $(this).attr("block_id");
				if (isNaN(check_id) == false){
					if (check_id > max_id - 1)
						max_id = check_id + 1;
				}
			}
		});
	}
	
/*------------------------------------------------------------------
[5. Styling Modal]
*/

	function styling(){
		$('.ossvn-drop-area').on('click','.ossvn-style',function(event){
			event.preventDefault();
			var parent = $(this).parent().parent();
			var i;
			parent.addClass('target-waiting-for-change');
			reset_form_data('#ossvn-style-modal');
			
			parent.each(function() {
				$.each(this.attributes, function() {
					if(this.specified) {
						set_data_value('#ossvn-style-modal',this);
					}
				});
			});
		});
		$('#ossvn-style-modal .ossvn-save-col').on('click',function(){
			var selector = $('.target-waiting-for-change');
			var modal_id = '#ossvn-style-modal';
			var modal = UIkit.modal(modal_id);
			get_data_value(modal_id,selector);
			modal.hide();
		});
		$('#ossvn-style-modal').on('hide.uk.modal',function(){
			$('.target-waiting-for-change').removeClass('target-waiting-for-change');
		});
	}

/*------------------------------------------------------------------
[6. Add class not-hover to parent of current row/col/block]
*/
	function manage_control_hover(){
		$('.ossvn-drop-area').on('mouseover',function(event){
			var current = $(event.target);
			if (current.hasClass('ossvn-row') || current.hasClass('ossvn-col') || current.hasClass('ossvn-block')){
				current.removeClass('not-hover');
				current.parents('.ossvn-row').addClass('not-hover');
				current.parents('.ossvn-col').addClass('not-hover');
				$('.not-hover').children('.ossvn-row-controls').removeClass('active');
			}
		});
	}
	
/*------------------------------------------------------------------
[7. Color Control]
*/
	function change_color(){
		
		// Set color for current color scheme
		if (!($('#ossvn-styling-option input[type="color"]').val())){
			$('#ossvn-styling-option input[type="color"]').val("#fafafa");// if color scheme not set, set default color;
		}
		$('#ossvn-styling-option .ossvn-radio-color').each(function(){
			if ($(this).prop('checked') == true){
				change_all_field_to_color($(this));
			}
		});
		
		$('.ossvn-color-input').on('change',function(){
			$(this).parent().children('.ossvn-color-text').val($(this).val());
		});
		$('#ossvn-styling-option .ossvn-color-custom').on('click',function(){
			if (check_change_color == true){
				var cf = confirm("Are you sure you want to change colors to this color scheme? All field you have changes will be removed");
				if (cf == false){
					event.preventDefault();
				}else{
					if ($(this).val() != '#fafafa'){
						$(this).addClass('active');
						$('#ossvn-styling-option .ossvn-color-scheme-list .ossvn-radio-color').attr('checked',false);
						change_all_field_to_custom($(this).val());
					}
				}
			} else {
				if ($(this).val() != '#fafafa'){
					$(this).addClass('active');
					$('#ossvn-styling-option .ossvn-color-scheme-list .ossvn-radio-color').attr('checked',false);
					change_all_field_to_custom($(this).val());
				}
			}
		});
		$('#ossvn-styling-option .ossvn-color-custom').on('change',function(){
			$('#ossvn-styling-option .ossvn-color-scheme-list .ossvn-radio-color').attr('checked',false);
			$(this).addClass('active');
			change_all_field_to_custom($(this).val());
		});
		$('#ossvn-styling-option .ossvn-radio-color').on('click',function(event){
			if (check_change_color == true){
				var cf = confirm(ossvn_ajax_url.text_js_translate.styling_change_color_text);
				if (cf == true){
					$('#ossvn-styling-option .ossvn-color-custom').removeClass('active');
						change_all_field_to_color($(this));
					
				}else{
					event.preventDefault();
				}
			}else{
				$('#ossvn-styling-option .ossvn-color-custom').removeClass('active');
				
						change_all_field_to_color($(this));
					
			}
		});
		$('#ossvn-styling-option .ossvn-design-group .ossvn-color-input').on('change',function(){
			check_change_color = true;
		});
	}
	
	// Set all color to current color scheme
	function change_all_field_to_color(color){
		var arr_color = color.attr("ossvn-default-color").split(";");
		arr_color.forEach(function(entry){
			var arr_entry = $.parseJSON(entry);
			$('#ossvn-styling-option .ossvn-design-group .ossvn-color-input,#ossvn-styling-option .ossvn-design-group .ossvn-color-text[name="' + arr_entry.name + '"]').val(arr_entry.value);
		});
		$('#ossvn-styling-option .ossvn-design-group .ossvn-color-input,#ossvn-styling-option .ossvn-design-group .ossvn-color-text').each(function(){
			$(this).prev().val($(this).val());
		});
		check_change_color = false;
	}
	
	function change_all_field_to_custom(color){
		var current_value = $("#wct_main_color").val();
		$('#ossvn-styling-option .ossvn-design-group .ossvn-color-input,#ossvn-styling-option .ossvn-design-group .ossvn-color-text').each(function(){
			if ($(this).val() == current_value){
				$(this).val(color);
				$(this).parent().children('.ossvn-color-input').val(color);
			}
		});
		check_change_color = false;
	}

	
/*------------------------------------------------------------------
[8. Information Field]
*/
	function information_storage_data(){
		$('#ossvn-information-storage .ossvn-radio').on('click',function(){
			$('#ossvn-information-storage .ossvn-option .ossvn-information-field').hide();
			$(this).parent().children('.ossvn-information-field').show(400);
		});
		if (arr_id.length > 0){
			var i;
			for (i = 0; i < arr_id.length;i++){
				append_checkbox_to_information_field(arr_id[i],i);
			}
		}
	}
/*------------------------------------------------------------------
[8.1 Add new checkbox]
*/
	function append_checkbox_to_information_field(arr_id,i){
		$( "#ossvn-information-storage .ossvn-information-field").each(function(){
			var str_append,str_name,str_id_chk, new_id;
			if ($(this).hasClass("ossvn-exclude-field")){
				str_name = "ossvn-exclude-checkbox";
				str_id_chk = "chk-exclude-" + i;
			}else{
				str_name = "ossvn-specific-checkbox";
				str_id_chk = "chk-specific-" + i;
			}

			/*==========nam===========*/
			if($('.ossvn-block[block_id="' + arr_id + '"]').attr('type') == 'woo_field'){
				new_id = $('.ossvn-block[block_id="' + arr_id + '"]').attr('woo_field_id');
			}else{
				new_id = arr_id;
			}
			/*==========end nam===========*/

			str_append = '<div class="ossvn-col ossvn-col-4" data_block_id="' + new_id + '"><input type="checkbox" value="' + new_id + '" id="' + str_id_chk + '" class="' + str_name + '" name="' + str_name + '"' + ' /><label class="ossvn-name" for="' + str_id_chk + '">' + $('.ossvn-drop-area .ossvn-block[block_id="' + arr_id + '"]').attr('block_title') + '</label></div>';
			
			//chá»‰ append vá»›i cÃ¡c file woo vÃ  custom field
			switch($('.ossvn-block[block_id="' + arr_id + '"]').attr('type')){
				case 'new_account':
					break;
				case 'login_form':
					break;
				case 'sidebar':
					break;
				case 'step':
					break;
				case 'your_order':
					break;
				case 'payment':
					break;
				case 'order_success':
					break;
				case 'process':
					break;
				case 'different_address':
					break;
				default :
					$(this).append(str_append);
					break;
			}
			
			/*==========nam===========*/
			if($('#ossvn-information-storage .ossvn-option .ossvn-exclude-field').attr("data-field-checked")){
				if ($('#ossvn-information-storage .ossvn-option .ossvn-exclude-field').attr("data-field-checked").search(arr_id[i]) > -1){
					var exclude_fields = $('#ossvn-information-storage .ossvn-option .ossvn-exclude-field').attr("data-field-checked"),
					arr_exclude = exclude_fields.split(',');
					$.each(arr_exclude,function(key, value){
				        $('#ossvn-information-storage .ossvn-option .ossvn-exclude-checkbox[value="' + value + '"]').prop('checked', true);
				    });
				}
			}
			if($('#ossvn-information-storage .ossvn-option .ossvn-specific-field').attr("data-field-checked")){
				if ($('#ossvn-information-storage .ossvn-option .ossvn-specific-field').attr("data-field-checked").search(arr_id[i]) > -1){
					var specific_fields = $('#ossvn-information-storage .ossvn-option .ossvn-specific-field').attr("data-field-checked"),
					arr_specific = specific_fields.split(',');
					$.each(arr_specific,function(key, value){
				    	$('#ossvn-information-storage .ossvn-option .ossvn-specific-field .ossvn-specific-checkbox[value="' + value + '"]').attr('checked', 'checked');
				    });
				}
			}
			/*==========end nam===========*/

		});
	}
	
/*------------------------------------------------------------------
[8.2 Edit checkbox]
*/
	function edit_checkbox_in_information_field(id,new_id,title){
		var this_id = $( "#ossvn-information-storage .ossvn-information-field .ossvn-col[data_block_id='" + id + "']" );
		this_id.attr("data_block_id",new_id);
		this_id.children('input[type="checkbox"]').val(new_id);
		this_id.children('label').text(title + ' (' + new_id + ')');
	}
/*------------------------------------------------------------------
[8.3 Delete checkbox]
*/
	function delete_checkbox_in_information_field(id){
		$( "#ossvn-information-storage .ossvn-information-field .ossvn-col[data_block_id='" + arr_id[id] + "']" ).remove();
		arr_id.splice(id, 1);
	}
	
/*------------------------------------------------------------------
[9. Save Data to shortcode]
*/
	function data_raw_save(){
		$("#ossvn-data-raw-save").click(function(){
			var content_data = "";
			$(".ossvn-drop-area").children(".ossvn-row").each(function(){
				content_data = content_data + loop_row_inside($(this),'wct_row');
			});
			$("#ossvn-data-raw-input").val(content_data);
			
			
			var data_newsletter = $('.ossvn-newsletter-provider .uk-list-item.active').attr('data-val');
			var status_newsletter = wct_check_newsletter_provider(data_newsletter);
			if(status_newsletter != 0){
				
				wct_save_template_2();
				return false;
			}else{

				UIkit.notify(ossvn_ajax_url.text_js_translate.data_raw_save_text, {status: 'warning', timeout : 7000, pos:'top-right'});
				return false;
			}
			return false;
			//$("#ossvn-data-raw-form").submit();
		});
	}
	
	function loop_row_inside(selector,text_row){
		var content_data;
		content_data = '[' + text_row;
		selector.each(function() {
			$.each(this.attributes, function() {
				if(this.specified) {
					content_data = content_data + ' ' + this.name + '="' + this.value + '"';
				}
			});
		});		
		content_data = content_data + ']';
		
		selector.children(".ossvn-col").each(function(){
			if (text_row == 'wct_row'){
				content_data = content_data + loop_col_inside($(this),'wct_col');
			}else{
				content_data = content_data + loop_col_inside($(this),'wct_col_inner');
			}
		});
		
		content_data = content_data + '[/' + text_row + ']';
		return content_data;		
	}
	
	function loop_col_inside(selector,text_col){
		var content_data;
		content_data = '[' + text_col;
		selector.each(function() {
			$.each(this.attributes, function() {
				if(this.specified) {
					content_data = content_data + ' ' + this.name + '="' + this.value + '"';
				}
			});
		});		
		content_data = content_data + ']';
		
		selector.children("div").each(function(){
			if ($(this).hasClass("ossvn-row")){
				content_data = content_data + loop_row_inside($(this),'wct_row_inner');
			}
			if ($(this).hasClass("ossvn-block")){
				content_data = content_data + '[wct_block';
				$(this).each(function() {
					$.each(this.attributes, function() {
						if(this.specified) {
							content_data = content_data + ' ' + this.name + '="' + this.value + '"';
						}
					});
				});
				content_data = content_data + ']';
			}
		});
		
		content_data = content_data + '[/' + text_col + ']';
		return content_data;
	}
	
/*------------------------------------------------------------------
[10. Other Function]
*/	
/*------------------------------------------------------------------
[10.1 Set data value from div to modal]
*/
	function set_data_value(modal_id,selector){
		if ($(modal_id + ' .ossvn-get-data[data-target="' + selector.name + '"]').attr('type') == 'radio'){
			$(modal_id + ' .ossvn-get-data[data-target="' + selector.name + '"]').each(function(){
				if ($(this).val() == selector.value){
					$(this).prop("checked", true);
				}
			});
		}else{
			if ($(modal_id + ' .ossvn-get-data[data-target="' + selector.name + '"]').attr('type') == 'checkbox'){
				if (selector.value == "on"){
					$(modal_id + ' .ossvn-get-data[data-target="' + selector.name + '"]').prop("checked",true);
				}else{
					$(modal_id + ' .ossvn-get-data[data-target="' + selector.name + '"]').prop("checked",false);
				}
			}else{
				$(modal_id + ' .ossvn-get-data[data-target="' + selector.name + '"]').val(selector.value);
				if($(modal_id + ' .ossvn-get-data[data-target="' + selector.name + '"]').hasClass('ossvn-color-text')){
					$(modal_id + ' .ossvn-get-data[data-target="' + selector.name + '"]').parent().children('.ossvn-color-input').value = selector.value;
				}
			}
		}
	}
/*------------------------------------------------------------------
[10.2 Get data value from modal]
*/
	function get_data_value(modal_id,selector){
		var check_checkbox = '';
		var current_val = '';
		$(modal_id).find('.ossvn-get-data').not('[type="checkbox"]').each(function(){
			if ($(this).attr('type') == 'radio'){
				if ($(this).prop("checked") == true){
					selector.attr($(this).attr('data-target'),$(this).val());
				}
			}else{
				selector.attr($(this).attr('data-target'),$(this).val());
			}
		});
		$(modal_id).find('.ossvn-get-data[type="checkbox"]').each(function(){
			if ($(this).prop("checked") == true){
				selector.attr($(this).attr('data-target'),"on");
			}else{
				selector.attr($(this).attr('data-target'),"undefined");
			}
		},function(){
			check_checkbox = '';
		});
	}
/*------------------------------------------------------------------
[10.3 Reset all input in modal]
*/	
	function reset_form_data(modal_id){
		$(modal_id + ' .ossvn-get-data').not('[type="radio"],[type="checkbox"]').each(function(){
				$(this).val('');
			});
		$(modal_id + ' .ossvn-get-data[type="radio"]').attr('checked',false);
		$(modal_id + ' .ossvn-get-data[type="checkbox"]').attr('checked',false);
		$(modal_id + ' input[type="color"]').val("#fafafa");
	}
/*------------------------------------------------------------------
[10.4 Left Column Mobile]
*/	
	
	function left_col_mobile(){
		$("#ossvn-visual-composer .ossvn-left-col").prepend('<button type="button" class="ossvn-button-for-mobile"></button>');
		$("#ossvn-visual-composer .ossvn-left-col").on("click",".ossvn-button-for-mobile",function(){
			$("#ossvn-visual-composer .ossvn-left-col").toggleClass("ossvn-active");
		});
	}

/*------------------------------------------------------------------
[10.5 Sticky Sidebar]
*/	
	function sticky_sidebar(){
		$(".ossvn-left-col").mCustomScrollbar({autoHideScrollbar: true});
		var left_col_position = $('.ossvn-left-col').offset();
		var right_col_position = $('.ossvn-drop-area').offset();
		var window_position = window.scrollY;
		if ($('.ossvn-drop-area').length && $('.ossvn-left-col').length){
			if (right_col_position.top < window_position){
				$('.ossvn-left-col').css({'margin-top' : window_position - left_col_position.top});
			}
		}
		$(window).scroll(function(){
			var window_position = window.scrollY;
			var right_col_position = $('.ossvn-drop-area').offset();
			if ($('.ossvn-drop-area').length && $('.ossvn-left-col').length){
				if ((left_col_position.top < window_position) && (right_col_position.top + $('.ossvn-drop-area').height() > window_position)){
					$('.ossvn-left-col').css({
						'margin-top' : window_position - left_col_position.top,
						'height' : $(window).height()
					});
					$('.ossvn-left-col').addClass("ossvn-sticky-col");
				}else if (left_col_position.top > window_position){
					$('.ossvn-left-col').css({
						'margin-top' : 0,
						'height' : 'auto'
					});
					$('.ossvn-left-col').removeClass("ossvn-sticky-col");
				} else {
					$('.ossvn-left-col').css({
						'margin-top' : right_col_position.top + $('.ossvn-drop-area').height() - left_col_position.top,
						'height' : 'auto'
					});
					$('.ossvn-left-col').removeClass("ossvn-sticky-col");
				}
			}
		});
	}

/*------------------------------------------------------------------
[10.6 Addclass and id for label checkbox and radio]
*/	
	function checkbox_radio_manage(){
		$(".ossvn-modal-box .ossvn-form-group").each(function(){
			if ($(this).children("input[type='checkbox']").length || $(this).children("input[type='radio']").length)
				$(this).addClass("ossvn-form-check");
		});
		
		var iidd = 1;
		$(".ossvn-label-user-role").each(function(){
			var new_iidd = "ossvn-user-role-id-" + iidd;
			iidd++;
			$(this).attr("for",new_iidd);
			$(this).parent().children(".ossvn-checkbox-user-role").attr("id",new_iidd);
		});
	}
	
	/*=============row display option===========*/
	function row_display_option(){
		$('.ossvn-drop-area').on('click','.ossvn-edit-row-display',function(event){
			event.preventDefault();
			var parent = $(this).parent().parent();
			var i;
			parent.addClass('target-waiting-for-change');

			/**
			* 
			* @since 1.0.1
			*/
			var current_row_display = parent.attr('row_display');

			if( typeof current_row_display === 'undefined' || current_row_display == '' || current_row_display == 'form_checkout' ){
				$('#ossvn-edit-row-display .ossvn-form-row-display').addClass('uk-hidden');
			}else{
				$('#ossvn-edit-row-display .ossvn-form-row-display').removeClass('uk-hidden');
			}

			reset_form_data('#ossvn-edit-row-display');
			
			parent.each(function() {
				$.each(this.attributes, function() {
					if(this.specified) {
						set_data_value('#ossvn-edit-row-display',this);
					}
				});
			});

			if( $("#ossvn-edit-row-display #step_icon").length > 0 ){

				var icon = $("#ossvn-edit-row-display #step_icon").val();
				$('#step_icon_preview').removeAttr('class');
				$('#step_icon_preview').addClass('fa '+icon).css('font-size', '30px');

			}
		});
		$('#ossvn-edit-row-display .ossvn-save-col').on('click',function(){
			var selector = $('.target-waiting-for-change');
			var modal_id = '#ossvn-edit-row-display';
			var modal = UIkit.modal(modal_id);

			/** 
			* Change title step
			* 
			* @code Nam
			* @since 1.2
			*/
			if( $('.target-waiting-for-change.step-content .block_step_overlay').length ){
				var step_title = $('#ossvn-edit-row-display input[data-target="row_accordion_title"]').val(),
				data_step = $('.target-waiting-for-change.step-content').attr('data_step_order');
				$('.target-waiting-for-change.step-content .block_step_overlay h5').text(step_title);
				$('#wct_col_step .ossvn-block[data_step_order="'+ data_step +'"]').attr( 'block_title', step_title );
				$('#wct_col_step .ossvn-block[data_step_order="'+ data_step +'"] .ossvn-span-block-title').text(step_title);
			}

			get_data_value(modal_id,selector);
			modal.hide();
		});
		$('#ossvn-edit-row-display').on('hide.uk.modal',function(){
			$('.target-waiting-for-change').removeClass('target-waiting-for-change');
		});
	}
	/*=============step save data===========*/
	function step_save_data(){

		$('#ossvn-edit-step-modal .ossvn-save-col').on('click',function(){
			var selector = $('.target-waiting-for-change');
			var modal_id = '#ossvn-edit-step-modal';
			var modal = UIkit.modal(modal_id);
			selector.children('.ossvn-span-block-title').text($('#ossvn-edit-step-modal .ossvn-title-group input').val());
			get_data_value(modal_id,selector);
			modal.hide();
		});
		$('#ossvn-edit-step-modal').on('hide.uk.modal',function(){
			$('.target-waiting-for-change').removeClass('target-waiting-for-change');
		});
	}
	/*=====get field data=======================*/
	function wct_get_field_data(){

		var languages = ossvn_ajax_url.ossvn_language,
		data = [];

		$('.ossvn-right-col .ossvn-block').each(function(){

			var block_title = $(this).attr('block_title'),
			block_type = $(this).attr('type'),
			required = $(this).attr('block_required'),
			block_val_option = '',
			block_display_order_recived = $(this).attr('block_display_order_recived'),
			block_display_email = $(this).attr('block_display_email'),
			display_pdf_invoices = $(this).attr('display_pdf_invoices'),
			display_pdf_position = $(this).attr('display_pdf_invoices_position'),
			display_account_page = $(this).attr('block_display_account');
			
			if(block_type == 'woo_field'){
				var block_id = $(this).attr('woo_field_id');
			}else{
				var block_id = $(this).attr('block_id');
			}

			if(block_display_order_recived != ''){
				var order_recived = 'on';
			}else{
				var order_recived = '';
			}

			if(block_display_email != ''){
				var display_email = 'on';
			}else{
				var display_email = '';
			}

			if(display_pdf_invoices == 'on'){
				var display_pdf = 'on';
			}else{
				var display_pdf = 'off';
			}

			if( display_account_page == 'undefined' || display_account_page == '' ){
				var account_page = 'off';
			}else{
				var account_page = 'on';
			}

			if( $(this).attr(languages) == '' || $(this).attr(languages) == undefined ){ 
				var block_title_lang = block_title;
			}else{
				var block_title_lang = $(this).attr(languages);
			}

			if( block_type == 'checkbox' || block_type == 'radio' || block_type == 'dropdown' ){

				if( $(this).attr('block_checkbox_options') != '' ){
					block_val_option += $(this).attr('block_checkbox_options');
				}

			}

			data.push({
				'block_id' : 					block_id,
				'block_required': 				required,
				'block_title' : 				block_title,
				'block_type' : 					block_type,
				'block_display_order_recived': 	order_recived,
				'block_display_email': 			display_email,
				'block_display_pdf_invoices': 	display_pdf,
				'block_display_pdf_position': 	display_pdf_position,
				'account_page': 				account_page,
				'block_title_lang': 			block_title_lang,
				'block_val_option': 			block_val_option,
			});
		});
		return data;
	}
	/*=====check fill data newsletter=======================*/
	function wct_check_newsletter_provider(data_newsletter){
		var news_status = 1;
		$('.newsletter-provider-' +data_newsletter+ ' .uk-form-danger').each(function() {
			if($(this).val() == ''){
				news_status = 0;
				return false;
			}

		});
		return news_status;
	}
	/*=====ajax save template data=======================*/
	function wct_information_storage_field(){
		var field = [];
		$('#ossvn-information-storage .wct-information-storage:checked').parent('.ossvn-option').children('.ossvn-information-field').find('input[type="checkbox"]').each(function(){
			if($(this).is(':checked')){
				field.push($(this).val());
			}
		});

		return field;
	}
	function wct_save_template_2(){

		var ajax_url = ossvn_ajax_url.ajax_url,
		html_row = $('.ossvn-right-col .ossvn-drop-area').html(),
		wct_checkout_template = $("#wct_choose_template").serialize(),
		template_shortcode = $('#ossvn-data-raw-input').val(),
		data_newsletter = $('.ossvn-newsletter-provider .uk-list-item.active').attr('data-val'),
		wct_styling_color_schreme = $('#ossvn-styling-option .ossvn-color-scheme-list li input.active').val(),
		information_storage_field = $('.wct-information-storage:checked').parent('.ossvn-option').children('.ossvn-information-field').html(),
		wct_all_field = wct_get_field_data(),
		information_storage_field_checked = wct_information_storage_field(),
		redirect_url = $('#ossvn-data-raw-restore').data('href');

		$.ajax({
			type: 'POST',
			url: ajax_url,
			data: {
				action: 'save_template_2',
				html_row: html_row,
				wct_checkout_template: wct_checkout_template,
				template_shortcode: template_shortcode,
				data_newsletter: data_newsletter,
				wct_styling_color_schreme: wct_styling_color_schreme,
				information_storage_field: information_storage_field,
				information_storage_field_checked: information_storage_field_checked,
				wct_all_field: wct_all_field,
			},
			beforeSend: function ()
			{
				$('html,body').animate({scrollTop: $('#ossvn-wrapper').offset().top},'slow');
				UIkit.notify("Sending...", {timeout : 1000, pos:'top-right'});
			},
			success: function(data)
			{
				
				var success_data = $.parseJSON(data);
				$('.ossvn-right-col .ossvn-drop-area').empty();
				$('.ossvn-right-col .ossvn-drop-area').html(success_data.wct_html_row);
				$('.wct-information-storage:checked').parent('.ossvn-option').children('.ossvn-information-field').html(success_data.wct_html_isf);
				$('.wct-information-storage:checked').parent('.ossvn-option').children('.ossvn-information-field').attr('data-field-checked', information_storage_field_checked.join(','));
				$('.wct-information-storage:checked').parent('.ossvn-option').children('.ossvn-information-field').html(information_storage_field);
				UIkit.notify(""+ success_data.message +"", {status: ''+ success_data.status +'', pos:'top-right'});
				setTimeout(function () {
                    window.location.href = redirect_url;
                }, 3000);
				return false;
			},
			error: function()
			{
				UIkit.notify(ossvn_ajax_url.text_js_translate.ajax_error_text, {status:'danger', pos:'top-right'});
			}
		});
		
		
		return false;	
	}


	/*====================save data template active======================*/
	$('#ossvn-template-choose .ossvn-save').on('click',function(){
		var template_active = $(this).closest('.ossvn-submit-control').find('.wct_template_active').val(),
		redirect_url = $(this).attr('data-href'),
		wpml = $(this).closest('.ossvn-col-6').find('.ossvn-wpml:checked').val(),
		i_sell = $(this).closest('.ossvn-col-6').find('.ossvn-i-sell:checked').val(),
		newlleter = $(this).closest('.ossvn-col-6').find('.ossvn-newlleter:checked').val();
		var ajax_url = ossvn_ajax_url.ajax_url;

		$.ajax({
			type: 'POST',
			url: ajax_url,
			data: {
				action: 'save_template_1',
				template_active: template_active,
				wpml: wpml,
				i_sell: i_sell,
				newlleter: newlleter
			},
			beforeSend: function ()
			{
				//Show loader here
				$('#overlay').show();
			},
			success: function(respon)
			{
				var data = $.parseJSON(respon);
				window.location.href = redirect_url;
				return false;
			},
			error: function()
			{
				$("#genre-results").html('<p>'+ ossvn_ajax_url.text_js_translate.ajax_error_text +'</p>');
			}
		});
		return false;	
	});
	
	/*======================#BEGIN conditional logic==============================*/

	/*===conditional logic=========*/
	$("input[name='block-cond-logic']").change(function() {
		var select = $(this).closest('.ossvn-form-group').find('select.block-cond-logic-field');
		var selector = $('.target-waiting-for-change');
		
		if(selector.attr('type') == 'woo_field'){
			var selector_id = selector.attr('woo_field_id');
		}else{
			var selector_id = selector.attr('block_id');
		}
		
		if($(this).is(":checked")){

			wct_show_block_rule_conditional_logic( selector_id );
			$('.ossvn-conditional-logic').removeClass('wct-disable');

		}else{

			$('.ossvn-conditional-logic').addClass('wct-disable');
		}
	});

	$('.conditional').conditionize();

	/*===add rule conditional logic=========*/

	function remove_logic_rule(){

		$('.ossvn-modal #ossvn-form-group-logic-rule .remove-block-cond-logic').on('click',function(){
			var parent = $(this).closest('.add-block-cond-logic'),
			modal_id = $(this).closest('.ossvn-modal').attr('id');
			
			if( $('#'+ modal_id +' #ossvn-form-group-logic-rule .add-block-cond-logic').size() > 1 ){
				parent.remove();
			}else{alert(ossvn_ajax_url.text_js_translate.remove_logic_rule_text);}

			return false;
		});
	}

	$('#ossvn-wrapper .ossvn-modal .submit-block-cond-logic').on('click',function(){
		var clone = $(this).closest('.ossvn-conditional-logic').find('.add-block-cond-logic').first().clone(false);
		$(this).closest('.ossvn-conditional-logic').find('.add-block-cond-logic').last().after(clone);
		remove_logic_rule();
		return false;
	});

	$('.ossvn-modal #block_cond_logic_field_type').change(function(){
		
		if($(this).val() == 'checked'){
			wct_block_cond_logic_field_type();
		}

	});

	function wct_get_rule_conditional_logic(modal_id){
		var data = [];

		$(''+ modal_id +' .ossvn-conditional-logic .add-block-cond-logic').each(function(){
			var block_cond_logic_field = $(this).find('select[data-target="block_cond_logic_field"]').val(),
			block_cond_logic_field_is = $(this).find('select[data-target="block_cond_logic_field_is"]').val(),
			block_cond_logic_field_is_value = $(this).find('input[data-target="block_cond_logic_field_is_value"]').val();
			if(block_cond_logic_field_is != '' && block_cond_logic_field_is_value != ''){
				data.push({
					'logic_field' : block_cond_logic_field,
					'logic_field_is' : block_cond_logic_field_is,
					'logic_field_is_value' : block_cond_logic_field_is_value,
				});
			}

		});

		return data;

	}

	function wct_update_block_rule_conditional_logic(status, show_hide, all_any, selector_id, logic_field){

		var ajax_url = ossvn_ajax_url.ajax_url,
		display_show_type = '',
		display_all_type = '';

		if( show_hide == '' ){
			display_show_type = 'show';
		}else{
			display_show_type = 'hide';
		}

		if( all_any == '' ){
			display_all_type = 'all';
		}else{
			display_all_type = 'any';
		}

		$.ajax({
			type: 'POST',
			url: ajax_url,
			data: {
				action: 'wct_update_block_rule_conditional_logic',
				status: status,
				selector_id: selector_id,
				logic_field: logic_field,
				show_type: display_show_type,
				all_type: display_all_type
			},
			beforeSend: function ()
			{
				
			},
			success: function(respon)
			{
				var data = $.parseJSON(respon);
				$('.ossvn-modal #block_cond_logic_field_type').change(function(){
					if($(this).val() == 'checked'){
						wct_block_cond_logic_field_type();
					}

				});
				console.log(data);
			},
			error: function()
			{
				$("#genre-results").html('<p>'+ ossvn_ajax_url.text_js_translate.ajax_error_text +'</p>');
			}
		});
		return false;
	}

	function wct_show_block_rule_conditional_logic(selector_id){

		var ajax_url = ossvn_ajax_url.ajax_url,
		all_fields = wct_get_field_data();
		$.ajax({
			type: 'POST',
			url: ajax_url,
			data: {
				action: 'wct_show_block_rule_conditional_logic',
				selector_id: selector_id,
				all_fields: all_fields
			},
			beforeSend: function ()
			{
				//Show loader here
				$('.ossvn-modal .wct_loading').html('<i class="fa fa-refresh uk-icon-spin"></i>');
			},
			success: function(respon)
			{	
				var data = $.parseJSON(respon);
				$('.ossvn-modal .wct_loading').empty();
				$('.ossvn-block-modal #ossvn-form-group-logic-rule').html(data.html);
				remove_logic_rule();
				$('.ossvn-modal #block_cond_logic_field_type').change(function(){
					if($(this).val() == 'checked'){
						wct_block_cond_logic_field_type();
					}

				});
			},
			error: function()
			{
				$("#genre-results").html('<p>'+ ossvn_ajax_url.text_js_translate.ajax_error_text +'</p>');
			}
		});
		return false;
	}

	function wct_block_cond_logic_field_type(){

		var ajax_url = ossvn_ajax_url.ajax_url,
		all_fields = wct_get_field_data();
		$.ajax({
			type: 'POST',
			url: ajax_url,
			data: {
				action: 'wct_block_cond_logic_field_type',
				all_fields: all_fields
			},
			beforeSend: function ()
			{
				//Show loader here
				$('.ossvn-modal #block_cond_logic_field').empty();
			},
			success: function(respon)
			{
				var data = $.parseJSON(respon);
				$('.ossvn-modal #block_cond_logic_field').html(data.html);
			},
			error: function()
			{
				$("#genre-results").html('<p>'+ ossvn_ajax_url.text_js_translate.ajax_error_text +'</p>');
			}
		});
		return false;
	}

	function wct_reset_data_logic_fields(modal_id){
		
		if($(''+ modal_id +' #block-cond-logic .ossvn-checkbox-user-role').is(':checked')){
			
			var selector = $('.target-waiting-for-change');
		
			if(selector.attr('type') == 'woo_field'){
				var selector_id = selector.attr('woo_field_id');
			}else{
				var selector_id = selector.attr('block_id');
			}

			wct_show_block_rule_conditional_logic( selector_id );
			$(''+ modal_id +' .ossvn-conditional-logic').show();

		}else{

			$(''+ modal_id +' .ossvn-conditional-logic').hide();
			$(''+ modal_id +' #ossvn-form-group-logic-rule').empty();
		}
	}

	/*======================#END conditional logic=============================*/


	/*========================*/
	$( ".input-date" ).datepicker({dateFormat : 'm-dd-yy'});
	
	/*========Newsletter marketing provider========*/
	$('.ossvn-newsletter-provider .uk-list-item').on('click',function(){
		$('.ossvn-newsletter-provider .uk-list-item').removeClass('active');
		$(this).addClass('active');
		var newlleter = $(this).attr('data-val');
		$('.ossvn-newsletter-provider .hidden').hide();
		$('.newsletter-provider-' +newlleter+ '').toggle(700);
	});

	/*========widget=================*/
	$('.accordion-container .accordion-content').hide();
	$('.accordion-container .attribute-label').on('click',function(){
		var class_val = $(this).attr('data-class');
		$('.accordion-container .'+ class_val +'').toggle(700);
	});

	//$('.accordion-content .wct-color-div').hide();
	$('.accordion-content select').on('change',function(){
		var select_val = this.value,
		parent = $(this).closest('.accordion-content');
		parent.find('.wct-color-div').hide();
		parent.find('#'+ select_val +'').toggle(700);
	});

	/*==================Choose Icon=================*/

	$('.accordion-container .icon').on('click',function(){
		var _self = $(this),
		current_id = $(this).parents('.wct-color-div').attr('id');
		$('.widget-content #wct_load').show();
		$('.widget-content #wct_overlay').show();
		$('.widget-content #wct-popup-thickbox').show();
		$('#' + current_id).addClass("ossvn-im-here");
		
	});

	$("#bo-metro-zero-tb-fa i.fa").on("click", function(){
		var codeFa = $(this).attr("class");
		var current_id = $(".ossvn-im-here").attr("id");
		$('#' + current_id).removeClass("ossvn-im-here");
		$('#'+ current_id +' i.fa').attr("class", codeFa);
		$('#'+ current_id +' input[type="hidden"]').val(codeFa);
		$('.widget-content #wct_load').hide();
		$('.widget-content #wct_overlay').hide();
		$('.widget-content #wct-popup-thickbox').hide();
	});
    

    /*========upload===============*/
    var custom_uploader, 
    parent_input = '';
    $('.accordion-container .wct_upload').click(function(e) {
 		parent_input = $(this).closest('.wct-color-div').attr('id');

        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            //$('#list_upload_image_ul').hide();
            var selection = custom_uploader.state().get('selection');
            selection.map( function( attachment ) {
                attachment = attachment.toJSON();
                var urlLogo = attachment.url;
                var insert = '<img width="32" height="32" src="' + urlLogo +'">';
                $('#'+ parent_input + ' .wct_upload_url').val(urlLogo);
                $('#'+ parent_input + ' .wct_upload_add_img').html(insert);
            });

        });
 
        //Open the uploader dialog
        custom_uploader.open();

        return false;
    });

	$('#ossvn-edit-checkbox-modal .ossvn-checkbox-option-display input[type="checkbox"]').click(function(e) {
		if($(this).is(':checked')){
			$('#ossvn-edit-checkbox-modal .ossvn-checkbox-option-display .display-label').hide();
			$('#ossvn-edit-checkbox-modal .ossvn-checkbox-option-display .display-img').show();
		}else{
			$('#ossvn-edit-checkbox-modal .ossvn-checkbox-option-display .display-label').show();
			$('#ossvn-edit-checkbox-modal .ossvn-checkbox-option-display .display-img').hide();
		}
	});


	/*=====export data subscribers========*/
	if($('#newsletter_provider_database .ossvn-export-subscribers').length){
		
		$('#newsletter_provider_database .ossvn-export-subscribers').click(function(e) {
			$.download(ajaxurl,'action=wct_export');
			return false;
		});
		$.download = function(url, data, method){
	        if( url && data ){
	            data = typeof data == 'string' ? data : jQuery.param(data);
	            var inputs = '';
	            jQuery.each(data.split('&'), function(){
	                var pair = this.split('=');
	                inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />';
	            });
	            jQuery('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>').appendTo('body').submit().remove();
	        };
	    };
	}

	/*=======restore default=================*/
	$('#ossvn-data-raw-restore').click(function(e) {
		var r = confirm("Press OK to restore to default template, Cancel to leave!");
		if (r == true) {
			
			var ajax_url = ossvn_ajax_url.ajax_url,
			template_active = $(this).attr('data-active'),
			redirect = $(this).attr('data-href');
			$.ajax({
				type: 'POST',
				url: ajax_url,
				data: {
					action: 'wct_restore_default_template',
					template_active: template_active
				},
				beforeSend: function ()
				{
					//Show loader here
					//$('.ossvn-modal #block_cond_logic_field').empty();
				},
				success: function(respon)
				{
					var data = $.parseJSON(respon);
					if(data.status == true){
						window.location.href = redirect;
					}else{
						alert(''+ ossvn_ajax_url.text_js_translate.ajax_error_text +'');
					}
				},
				error: function()
				{
					$("#genre-results").html('<p>'+ ossvn_ajax_url.text_js_translate.ajax_error_text +'</p>');
				}
			});
		}		
		return false;
	});

	/*=============================support==============================*/
	$('#file_upload').click(function(e) {
     
        var input_img = $('#file_upload_url');
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            var selection = custom_uploader.state().get('selection');
            selection.map( function( attachment ) {
                attachment = attachment.toJSON();
                var urlLogo = attachment.url;
                var insert = '<img width="50" src="' + urlLogo +'">';
                input_img.val(urlLogo);
            });

        });
 
        //Open the uploader dialog
        custom_uploader.open();


        return false;
    });
	
	function wct_set_checkbox_checked(selector, attribute){

		var attr = selector.attr(attribute);

		if(attr == 'on' || attr == 'undefined on'){

			$('.ossvn-modal input[data-target="'+ attribute +'"]').prop('checked', true);
		}
	}

	function wct_reset_checkbox_value_on(selector, attribute){

		var $attr = selector.attr(attribute),
		modal_id = selector.find('.ossvn-edit-block').attr('data-modal');
		if( $(''+ modal_id +' input[data-target="'+ attribute +'"]').is(':checked') ){
			
			selector.removeAttr(attribute);
			selector.attr(attribute, 'on');
		}	

	}

	/**
	* Tabs language
	* @since 1.0.1
	*/
	$('.tabs.animated-fade .tab-links a').on('click', function(e)  {
		var currentAttrValue = $(this).attr('href');

		// Show/Hide Tabs
		$('.tabs ' + currentAttrValue).fadeIn(400).siblings().hide();

		// Change/remove current tab to active
		$(this).parent('li').addClass('active').siblings().removeClass('active');

		e.preventDefault();
		return false;
	});

	/**
	* Step js
	* @since 1.3
	*/
	var wct_step_settings = {

		init: function(){

			$("#ossvn-edit-row-display #row_display").on('change', function(e)  {
		
				var val = $(this).val();
				wct_step_settings.wct_render_element_block_woo(val);
				wct_step_settings.wct_reorder_step();

			});

			if( $("#ossvn-edit-row-display #step_icon").length > 0 ){

				$("#ossvn-edit-row-display #step_icon").on('change', function(e)  {
				
					var val = $(this).val();
					$('#step_icon_preview').removeAttr('class');
					$('#step_icon_preview').addClass('fa '+val).css('font-size', '30px');

				});

			}

		},
		wct_render_element_block_woo: function( value ){

			var clone = '<div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-row ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_row_text +'"></i></div><div class="ossvn-edit-row ossvn-row-control"><i class="fa fa-align-justify" title="'+ ossvn_ajax_url.text_js_translate.edit_row_text +'"></i></div><button type="button" class="ossvn-edit-row-display ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-row-display\'}"><i class="fa fa-pencil" title="Display options"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_row_style_text +'"></i></button><button type="button" class="ossvn-add-col ossvn-row-control"><i class="fa fa-plus" title="'+ ossvn_ajax_url.text_js_translate.add_col_text +'"></i></button><button type="button" class="ossvn-delete-row ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_row_text +'"></i></button><div class="ossvn-row-templates"><button type="button" data-template="ossvn-col-12" class="ossvn-row-template ossvn-row-template-1"></button><button type="button" data-template="ossvn-col-6 ossvn-col-6" class="ossvn-row-template ossvn-row-template-2"></button><button type="button" data-template="ossvn-col-8 ossvn-col-4" class="ossvn-row-template ossvn-row-template-3"></button><button type="button" data-template="ossvn-col-4 ossvn-col-4 ossvn-col-4" class="ossvn-row-template ossvn-row-template-4"></button><button type="button" data-template="ossvn-col-3 ossvn-col-3 ossvn-col-3 ossvn-col-3" class="ossvn-row-template ossvn-row-template-5"></button>				<button type="button" data-template="ossvn-col-3 ossvn-col-9" class="ossvn-row-template ossvn-row-template-6"></button><button type="button" data-template="ossvn-col-3 ossvn-col-6 ossvn-col-3" class="ossvn-row-template ossvn-row-template-7"></button><button type="button" data-template="ossvn-col-10 ossvn-col-2" class="ossvn-row-template ossvn-row-template-8"></button><button type="button" data-template="ossvn-col-2 ossvn-col-2 ossvn-col-2 ossvn-col-2 ossvn-col-2 ossvn-col-2" class="ossvn-row-template ossvn-row-template-9"></button>				<button type="button" data-template="ossvn-col-2 ossvn-col-8 ossvn-col-2" class="ossvn-row-template ossvn-row-template-10"></button>				<button type="button" data-template="ossvn-col-2 ossvn-col-2 ossvn-col-2 ossvn-col-6" class="ossvn-row-template ossvn-row-template-11"></button><button type="button" class="ossvn-row-custom" data-uk-modal="{target:\'#ossvn-template-custom-modal\'}"><i class="fa fa-plus"></i></button></div></div>';
			var r = confirm(ossvn_ajax_url.text_js_translate.confirm_import_row_text);
			var template = wct_template;
			
			/* clone billing fields */
			var clone_billing = '';
			clone_billing += '<div class="ossvn-col-12 ossvn-col drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="woocommerce-billing-fields"><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div>			<button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button><button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button></div><div type="woo_field" woo_field_id="billing_country" woo_field_type="country" class="ossvn-block ossvn-block-dropdown ossvn-block-first-name ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Country" block_id="wct_9" data_drag="drag-level-1-1-1-1-1-1" block_title_vi="Quá»‘c gia" block_title_en="Country" block_title_h_vi="" block_title_h_en="" block_title_h="" ext_class="" block_price_value="" block_user_logic_show="" block_user_logic_logged="" block_cond_logic_show="" block_cond_logic_all="" block_required="on"><span class="ossvn-span-block-title">Country</span>	<div class="ossvn-row-controls ossvn-block-controls">		<div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div>		<button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button>		<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button><button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_billing += '<div class="ossvn-col-6 ossvn-col drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="woocommerce-billing-fields"><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div>			<button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button>			<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button>						<button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button>		</div><div type="woo_field" woo_field_id="billing_first_name" block_required="on" woo_field_type="text" class="ossvn-block ossvn-block-text ossvn-block-first-name ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="First Name" block_id="wct_10" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">First Name</span>	<div class="ossvn-row-controls ossvn-block-controls">		<div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div>		<button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button>		<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button>		<button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_billing += '<div class="ossvn-col-6 ossvn-col drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="woocommerce-billing-fields">		<div class="ossvn-row-controls">			<div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div>			<button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button>			<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button>						<button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button>		</div><div type="woo_field" woo_field_id="billing_last_name" block_required="on" woo_field_type="text" class="ossvn-block ossvn-block-text ossvn-block-last-name ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Last Name" block_id="wct_11" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">Last Name</span>	<div class="ossvn-row-controls ossvn-block-controls">		<div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div>		<button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button>		<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button>		<button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_billing += '<div class="ossvn-col-12 ossvn-col drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="woocommerce-billing-fields">		<div class="ossvn-row-controls">			<div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div>			<button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button>			<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button>						<button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button>		</div><div type="woo_field" woo_field_id="billing_address_1" block_required="on" woo_field_type="text" class="ossvn-block ossvn-block-text ossvn-block-first-name ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Address 1" block_id="wct_12" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">Address 1</span>	<div class="ossvn-row-controls ossvn-block-controls">		<div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div>		<button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button>		<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button>		<button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_billing += '<div class="ossvn-col-6 ossvn-col drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="woocommerce-billing-fields">		<div class="ossvn-row-controls">			<div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div>			<button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button>			<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button>						<button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button>		</div><div type="woo_field" woo_field_id="billing_city" block_required="on" woo_field_type="text" class="ossvn-block ossvn-block-text ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="City" block_id="wct_13" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">City</span>	<div class="ossvn-row-controls ossvn-block-controls">		<div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div>		<button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button>		<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button>		<button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_billing += '<div class="ossvn-col-6 ossvn-col drag-level-1-1-1-1 ui-sortable not-hover" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="woocommerce-billing-fields">		<div class="ossvn-row-controls">			<div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div>			<button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button>			<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button>						<button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button>		</div><div type="woo_field" woo_field_id="billing_state" block_required="on" woo_field_type="text" class="ossvn-block ossvn-block-text ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="State" block_id="wct_14" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">State</span>	<div class="ossvn-row-controls ossvn-block-controls">		<div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div>		<button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button>		<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button>		<button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_billing += '<div class="ossvn-col-12 ossvn-col drag-level-1-1-1-1 ui-sortable not-hover" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="woocommerce-billing-fields">		<div class="ossvn-row-controls">			<div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div>			<button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button>			<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button>						<button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button>		</div><div type="woo_field" woo_field_id="billing_postcode" block_required="on" woo_field_type="text" class="ossvn-block ossvn-block-text ossvn-block-last-name ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Postcode / Zip" block_id="wct_15" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">Postcode / Zip</span>	<div class="ossvn-row-controls ossvn-block-controls">		<div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div>		<button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button>		<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button>		<button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_billing += '<div class="ossvn-col-6 ossvn-col drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="woocommerce-billing-fields">		<div class="ossvn-row-controls">			<div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div>			<button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button>			<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button>						<button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button>		</div><div type="woo_field" woo_field_id="billing_email" block_required="on" woo_field_type="text" class="ossvn-block ossvn-block-email ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Email" block_id="wct_16" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">Email</span>	<div class="ossvn-row-controls ossvn-block-controls">		<div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div>		<button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button>		<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button>		<button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_billing += '<div class="ossvn-col-6 ossvn-col drag-level-1-1-1-1 ui-sortable not-hover" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="woocommerce-billing-fields">		<div class="ossvn-row-controls">			<div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div>			<button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button>			<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button>						<button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button>		</div><div type="woo_field" woo_field_id="billing_phone" block_required="on" woo_field_type="text" class="ossvn-block ossvn-block-text ossvn-block-last-name ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Phone" block_id="wct_17" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">Phone</span>	<div class="ossvn-row-controls ossvn-block-controls">		<div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div>		<button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button>		<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button>		<button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';

			/* clone shipping fields */
			var clone_shipping = '';
			clone_shipping += '<div class="ossvn-col-12 ossvn-col drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class=""><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div><button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button><button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button></div><div type="different_address" woo_field_id="ship_to_different_address" block_required="undefined" woo_field_type="checkbox" class="ossvn-block ossvn-block-check-box ossvn-block-different-address-name ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Ship to a different address?" block_id="wct_18" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">Ship to a different address?</span><div class="ossvn-row-controls ossvn-block-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div><button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button><button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_shipping += '<div class="ossvn-col-12 ossvn-col drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="shipping_address"><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div><button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button><button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button></div><div type="woo_field" woo_field_id="shipping_country" block_required="on" woo_field_type="country" class="shipping_address ossvn-block ossvn-block-dropdown ossvn-block-country ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Country" block_id="wct_19" data_drag="drag-level-1-1-1-1-1-1" block_placeholder="" block_cond_logic_show="" block_cond_logic_all="" block_cond_logic_field_is_value=""><span class="ossvn-span-block-title">Country</span>	<div class="ossvn-row-controls ossvn-block-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div><button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button><button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_shipping += '<div class="ossvn-col-6 ossvn-col drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="shipping_address"><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div><button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button><button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button></div><div type="woo_field" woo_field_id="shipping_first_name" block_required="on" woo_field_type="text" class="shipping_address ossvn-block ossvn-block-text ossvn-block-first-name ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="First Name" block_id="wct_20" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">First Name</span><div class="ossvn-row-controls ossvn-block-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div><button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button><button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_shipping += '<div class="ossvn-col-6 ossvn-col drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="shipping_address"><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div><button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button><button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button></div><div type="woo_field" woo_field_id="shipping_last_name" block_required="on" woo_field_type="text" class="shipping_address ossvn-block ossvn-block-text ossvn-block-last-name ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Last Name" block_id="wct_21" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">Last Name</span><div class="ossvn-row-controls ossvn-block-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div><button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button><button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_shipping += '<div class="ossvn-col-12 ossvn-col drag-level-1-1-1-1 ui-sortable not-hover" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="shipping_address" style="position: relative;"><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div><button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button><button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button></div><div type="woo_field" woo_field_id="shipping_company" block_required="undefined" woo_field_type="text" class="shipping_address ossvn-block ossvn-block-text ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Company" block_id="wct_23" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">Company</span><div class="ossvn-row-controls ossvn-block-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div><button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button><button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_shipping += '<div class="ossvn-col-12 ossvn-col drag-level-1-1-1-1 ui-sortable not-hover" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="shipping_address"><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div><button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button><button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button></div><div type="woo_field" woo_field_id="shipping_address_1" block_required="on" woo_field_type="text" class="shipping_address ossvn-block ossvn-block-text ossvn-block-first-name ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Address 1" block_id="wct_22" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">Address 1</span>	<div class="ossvn-row-controls ossvn-block-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div><button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button><button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_shipping += '<div class="ossvn-col-12 ossvn-col drag-level-1-1-1-1 ui-sortable not-hover" data_drag="drag-level-1-1-1-1-1" style="position: relative;" col_id="" col_extra_class="shipping_address"><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div><button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button><button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button></div><div type="woo_field" woo_field_id="shipping_state" block_required="on" woo_field_type="text" class="shipping_address ossvn-block ossvn-block-text ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="State" block_id="wct_30" data_drag="drag-level-1-1-1-1-1-1" block_placeholder="" block_cond_logic_show="" block_cond_logic_all="" block_cond_logic_field_is_value=""><span class="ossvn-span-block-title">State</span><div class="ossvn-row-controls ossvn-block-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div><button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button><button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_shipping += '<div class="ossvn-col-6 ossvn-col drag-level-1-1-1-1 ui-sortable not-hover" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="shipping_address" style="position: relative;"><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div><button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button><button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button></div><div type="woo_field" woo_field_id="shipping_postcode" block_required="on" woo_field_type="text" class="shipping_address ossvn-block ossvn-block-text ossvn-block-last-name ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Postcode / Zip" block_id="wct_24" data_drag="drag-level-1-1-1-1-1-1" block_placeholder="" block_cond_logic_show="" block_cond_logic_all="" block_cond_logic_field_is_value=""><span class="ossvn-span-block-title">Postcode / Zip</span><div class="ossvn-row-controls ossvn-block-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div><button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button><button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_shipping += '<div class="ossvn-col-6 ossvn-col drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="shipping_address"><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div><button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button><button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button></div><div type="woo_field" woo_field_id="shipping_city" block_required="on" woo_field_type="text" class="shipping_address ossvn-block ossvn-block-text ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="City" block_id="wct_25" data_drag="drag-level-1-1-1-1-1-1" block_placeholder="" block_cond_logic_show="" block_cond_logic_all="" block_cond_logic_field_is_value=""><span class="ossvn-span-block-title">City</span>	<div class="ossvn-row-controls ossvn-block-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div><button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button><button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_shipping += '<div class="ossvn-col ossvn-col-12 drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1"><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div><button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button><button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button></div><div type="woo_field" woo_field_id="order_comments" block_required="undefined" woo_field_type="textarea" class="ossvn-block ossvn-block-text-area ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Order notes" block_id="wct_26" data_drag="drag-level-1-1-1-1-1-1" block_placeholder="Notes about your order, e.g. special notes for delivery." block_cond_logic_show="" block_cond_logic_all="" block_cond_logic_field_is_value="" block_title_h="Notes about your order, e.g. special notes for delivery."><span class="ossvn-span-block-title">Order notes</span><div class="ossvn-row-controls ossvn-block-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div><button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button><button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';

			/* colone order fields */
			var clone_order = '';
			clone_order += '<div class="ossvn-col ossvn-col-12 drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1"><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div><button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button><button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button></div><div type="your_order" woo_field_id="wct_your_order" block_required="undefined" woo_field_type="undefined" class="ossvn-block ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Your order" block_id="wct_28" data_drag="drag-level-1-1-1-1-1-1" style="position: relative;"><span class="ossvn-span-block-title">Your order</span><div class="ossvn-row-controls ossvn-block-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div><button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button><button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_order += '<div class="ossvn-col ossvn-col-12 drag-level-1-1-1-1 ui-sortable not-hover" data_drag="drag-level-1-1-1-1-1"><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div><button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button><button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button></div><div type="payment" woo_field_id="wct_payment" block_required="undefined" woo_field_type="undefined" class="ossvn-block ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Payment method" block_id="wct_29" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">Payment method</span><div class="ossvn-row-controls ossvn-block-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div><button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button><button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button><button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';

			/* clone account */
			var clone_account = '';
			clone_account += '<div class="ossvn-col-5 ossvn-col drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="" col_display=""><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div> <button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button> <button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button> <button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button> </div><div type="new_account" woo_field_id="wct_new_account" block_required="undefined" woo_field_type="undefined" class="ossvn-block ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="New Customer" block_id="wct_19" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">New Customer</span> <div class="ossvn-row-controls ossvn-block-controls"> <div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div> <button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button> <button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button> <button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';
			clone_account += '<div class="ossvn-col-7 ossvn-col drag-level-1-1-1-1 ui-sortable not-hover" data_drag="drag-level-1-1-1-1-1" col_id="" col_extra_class="" col_display=""><div class="ossvn-row-controls"><div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div> <button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button> <button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button> <button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button> </div><div type="login_form" woo_field_id="wct_account" block_required="undefined" woo_field_type="undefined" class="ossvn-block ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Login form" block_id="wct_20" data_drag="drag-level-1-1-1-1-1-1"><span class="ossvn-span-block-title">Login form</span> <div class="ossvn-row-controls ossvn-block-controls"> <div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div> <button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-block-modal\'}" data-modal="#ossvn-edit-block-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button> <button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button> <button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';

			/* clone order success */
			var clone_order_success = '<div class="ossvn-col ossvn-col-12 drag-level-1-1-1-1 ui-sortable" data_drag="drag-level-1-1-1-1-1"> <div class="ossvn-row-controls"> <div class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_col_text +'"></i></div> <button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-col-modal\'}"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_col_text +'"></i></button> <button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_col_style_text +'"></i></button> <button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_col_text +'"></i></button> </div><div type="order_success" woo_field_id="undefined" block_required="undefined" woo_field_type="undefined" class="ossvn-block ossvn-block-only-one drag-level-1-1-1-1-1 ui-sortable" block_title="Order success!" block_id="wct_36" data_drag="drag-level-1-1-1-1-1-1" order_success_content="<p>Thanks for ordering. Many new product.<br><a href=\'#\'>Click</a> to see and join with us</p>" order_success_p="&amp;lt;p&amp;gt;Thanks for ordering. Many new product.&amp;lt;br&amp;gt;&amp;lt;a href=&amp;quot;#&amp;quot;&amp;gt;Click&amp;lt;/a&amp;gt; to see and join with us&amp;lt;/p&amp;gt;"><span class="ossvn-span-block-title">Order success!</span> <div class="ossvn-row-controls ossvn-block-controls"> <div class="ossvn-drag ossvn-drag-col ossvn-row-control ui-sortable-handle"><i class="fa fa-arrows" title="'+ ossvn_ajax_url.text_js_translate.drag_block_text +'"></i></div> <button type="button" class="ossvn-edit-block ossvn-row-control" data-uk-modal="{target:\'#ossvn-edit-order-success-modal\'}" data-modal="#ossvn-edit-order-success-modal"><i class="fa fa-pencil" title="'+ ossvn_ajax_url.text_js_translate.edit_block_text +'"></i></button> <button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:\'#ossvn-style-modal\'}"><i class="fa fa-paint-brush" title="'+ ossvn_ajax_url.text_js_translate.edit_block_style_text +'"></i></button> <button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="'+ ossvn_ajax_url.text_js_translate.delete_block_text +'"></i></button></div></div></div>';

			switch(value){
				
				case 'account':

					clone += clone_account;
					$('#ossvn-edit-row-display .ossvn-form-row-display').removeClass('uk-hidden');
					$('input[data-target="row_accordion_title"]').val(ossvn_ajax_url.text_js_translate.step_account_text);
					$('.target-waiting-for-change').addClass('ossvn-account');
					break;

				case 'billing':

					clone += clone_billing;
					$('.target-waiting-for-change').addClass('ossvn-billing-details');
					$('.target-waiting-for-change').removeClass('woocommerce-shipping-fields ossvn-shipping-information woocommerce-checkout-review-order');
					$('#ossvn-edit-row-display .ossvn-form-row-display').removeClass('uk-hidden');
					$('input[data-target="row_accordion_title"]').val(ossvn_ajax_url.text_js_translate.step_billing_text);
					break;

				case 'shipping':

					clone += clone_shipping;
					$('.target-waiting-for-change').addClass('woocommerce-shipping-fields ossvn-shipping-information');
					$('#ossvn-edit-row-display .ossvn-form-row-display').removeClass('uk-hidden');
					$('input[data-target="row_accordion_title"]').val(ossvn_ajax_url.text_js_translate.step_shipping_text);
					$('.target-waiting-for-change').removeClass('ossvn-billing-details woocommerce-checkout-review-order');
					break;

				case 'order':

					clone += clone_order;
					$('.target-waiting-for-change').attr('row_id','order_review');
					$('.target-waiting-for-change').addClass('woocommerce-checkout-review-order');
					$('input[data-target="row_id"]').val('order_review');
					$('#ossvn-edit-row-display .ossvn-form-row-display').removeClass('uk-hidden');
					$('input[data-target="row_accordion_title"]').val(ossvn_ajax_url.text_js_translate.step_order_text);
					$('.target-waiting-for-change').removeClass('woocommerce-checkout-review-order');
					break;

				case 'account_step':
					clone += '<div class="block_step_overlay"><h4>'+ ossvn_ajax_url.text_js_translate.step_text +': </h4><h5>'+ ossvn_ajax_url.text_js_translate.step_account_text +'</h5></div>';
					clone += clone_account;
					$('#ossvn-edit-row-display .ossvn-form-row-display').removeClass('uk-hidden');
					$('input[data-target="row_accordion_title"]').val(ossvn_ajax_url.text_js_translate.step_account_text);
					$('.ossvn-row.target-waiting-for-change').addClass('step-content');
					break;

				case 'billing_step':
					clone += '<div class="block_step_overlay"><h4>'+ ossvn_ajax_url.text_js_translate.step_text +': </h4><h5>Billing</h5></div>';
					clone += clone_billing;
					$('.target-waiting-for-change').addClass('ossvn-billing-details');
					$('.target-waiting-for-change').removeClass('woocommerce-shipping-fields ossvn-shipping-information woocommerce-checkout-review-order');
					$('#ossvn-edit-row-display .ossvn-form-row-display').removeClass('uk-hidden');
					$('input[data-target="row_accordion_title"]').val(ossvn_ajax_url.text_js_translate.step_billing_text);
					$('.ossvn-row.target-waiting-for-change').addClass('step-content');
					break;

				case 'shipping_step':
					clone += '<div class="block_step_overlay"><h4>'+ ossvn_ajax_url.text_js_translate.step_text +': </h4><h5>Shipping</h5></div>';
					clone += clone_shipping;
					$('.target-waiting-for-change').addClass('woocommerce-shipping-fields ossvn-shipping-information');
					$('#ossvn-edit-row-display .ossvn-form-row-display').removeClass('uk-hidden');
					$('input[data-target="row_accordion_title"]').val(ossvn_ajax_url.text_js_translate.step_shipping_text);
					$('.target-waiting-for-change').removeClass('ossvn-billing-details woocommerce-checkout-review-order');
					$('.ossvn-row.target-waiting-for-change').addClass('step-content');
					break;

				case 'order_step':
					clone += '<div class="block_step_overlay"><h4>'+ ossvn_ajax_url.text_js_translate.step_text +': </h4><h5>Your order</h5></div>';
					clone += clone_order;
					$('.target-waiting-for-change').attr('row_id','order_review');
					$('.target-waiting-for-change').addClass('woocommerce-checkout-review-order');
					$('input[data-target="row_id"]').val('order_review');
					$('#ossvn-edit-row-display .ossvn-form-row-display').removeClass('uk-hidden');
					$('input[data-target="row_accordion_title"]').val(ossvn_ajax_url.text_js_translate.step_order_text);
					$('.target-waiting-for-change').removeClass('woocommerce-checkout-review-order');
					$('.ossvn-row.target-waiting-for-change').addClass('step-content');
					break;

				case 'order_success':
					clone += '<div class="block_step_overlay"><h4>'+ ossvn_ajax_url.text_js_translate.step_text +': </h4><h5>Order success</h5></div>';
					clone += clone_order_success;
					$('#ossvn-edit-row-display .ossvn-form-row-display').removeClass('uk-hidden');
					$('input[data-target="row_accordion_title"]').val(ossvn_ajax_url.text_js_translate.step_order_success_text);
					$('.target-waiting-for-change').removeClass('ossvn-billing-details woocommerce-shipping-fields ossvn-shipping-information woocommerce-checkout-review-order');
					$('.ossvn-row.target-waiting-for-change').addClass('step-content');
					break;

				case 'custom_step':
					clone += '<div class="block_step_overlay"><h4>'+ ossvn_ajax_url.text_js_translate.step_text +': </h4><h5>Custom</h5></div>';
					$('#ossvn-edit-row-display .ossvn-form-row-display').removeClass('uk-hidden');
					$('input[data-target="row_accordion_title"]').val(ossvn_ajax_url.text_js_translate.step_custom_text);
					$('.target-waiting-for-change').removeClass('ossvn-billing-details woocommerce-shipping-fields ossvn-shipping-information woocommerce-checkout-review-order');
					$('.ossvn-row.target-waiting-for-change').addClass('step-content');
					break;

				default :
					if( !$('#ossvn-edit-row-display .ossvn-form-row-display.uk-hidden').length ){
						$('#ossvn-edit-row-display .ossvn-form-row-display').addClass('uk-hidden');
						$('.target-waiting-for-change').attr('row_type_display', '');
						$('input[data-target="row_accordion_title"]').val('');
						$('.target-waiting-for-change').removeClass('ossvn-billing-details woocommerce-shipping-fields ossvn-shipping-information woocommerce-checkout-review-order');
					}
					break;
			}

			if( $('.target-waiting-for-change .ossvn-col').length == 0 ){

				$('.target-waiting-for-change').html(clone);set_max_id();

			}else{

				if(r == true){ $('.target-waiting-for-change').html(clone);set_max_id(); }
			}

		},
		wct_reorder_step: function(){

			if( $('.ossvn-row.step-content').length ){

				var $i = 1;
				$('.ossvn-row.step-content').each(function(){
					var data_step = $(this).attr( 'row_display' );
					$(this).attr( 'data_step_order', $i );
					$(this).attr( 'id', 'step-'+ $i );
					$(this).find('.block_step_overlay h4').text('Step '+ $i +': ');
					$('#wct_step_bar .ossvn-block[data_step="'+ data_step +'"]').attr( 'data_step_order', $i );
					$('#wct_step_bar .ossvn-block[data_step="'+ data_step +'"]').attr( 'step_id_content', 'step-'+ $i );
					$i++;
				});
			}

		}

	};
	wct_step_settings.init();

	/**
	* LOgic fields with product ID
	* @since 1.3
	*/
	var wct_logic_product = {
		ajax_url: ossvn_ajax_url.ajax_url,
		init: function(){

			$("input[name='block-cond-logic-product']").change(function() {
				
				var selector = $('.target-waiting-for-change'),
				block_id = selector.attr('block_id');

			});

			$('#ossvn-wrapper .ossvn-modal').on('click', '.submit-block-cond-logic-product',function(){
				var clone = $(this).closest('.ossvn-conditional-logic-product').find('.add-block-cond-logic-product').first().clone(false),
				modal_id = $(this).closest('.ossvn-block-modal').attr('id');
				$(this).closest('.ossvn-conditional-logic-product').find('.add-block-cond-logic-product').last().after(clone);
				wct_logic_product.wct_reorder_logic_product(modal_id);
				return false;
			});

			$('#ossvn-wrapper .ossvn-block-modal').on('click', '.ossvn-save-col', function(){
				
				var modal_id = $(this).closest('.ossvn-block-modal').attr('id'),
				selector_id = $('.target-waiting-for-change').attr('block_id'),
				products = wct_logic_product.wct_get_logic_product(modal_id);

				if( $('#'+ modal_id +' input[name="block-cond-logic-product"]').is(':checked') ){
					var status = 'on';
				}else{ 
					var status = 'off';
				}

				wct_logic_product.wct_save_logic_product( products, selector_id, status );

			}).trigger('wct_save_block');

			$('.ossvn-drop-area').on('click','.ossvn-edit-block', function(){
				
				var modal_id = $(this).attr('data-modal'),
				selector_id = $(this).closest('.ossvn-custom-fields.ossvn-block').attr('block_id'),
				status = $(this).closest('.ossvn-custom-fields.ossvn-block').attr('block_cond_logic_product');
				if( status == 'on' ){
					$(''+ modal_id +' .ossvn-conditional-logic-product').show();
					wct_logic_product.wct_load_logic_product(modal_id, selector_id);
				}

			}).trigger('wct_edit_block');

			$(document).on( 'click', 'a.remove-block-cond-logic-product', function(){

				var parent = $(this).closest('.add-block-cond-logic-product');
				parent.remove();
				return false;

			});

		},
		wct_load_logic_product: function( modal_id, selector_id ){ 

			$.ajax({
				type: 'POST',
				url: wct_logic_product.ajax_url,
				data: {
					action: 'wct_load_logic_product',
					selector_id: selector_id
				},
				beforeSend: function( xhr ) {

	            	$(''+ modal_id +' .block-logic-product .wct_loading').html('<i class="fa fa-refresh uk-icon-spin"></i>');

	            },
				success: function(respon){

					$(''+ modal_id +' .block-logic-product .wct_loading').html('');
					var data = $.parseJSON(respon);
		            if(data.status == 1){
	                	$(''+ modal_id +' .block-logic-product .ossvn-form-group-logic-product-rule').html(data.html);
	                }

				}
			});

		},
		wct_save_logic_product: function ( products, selector_id, status ){
			
			$.ajax({
				type: 'POST',
				url: wct_logic_product.ajax_url,
				data: {
					action: 'wct_save_logic_product',
					selector_id: selector_id,
					products: products,
					status: status
				}
			});

		},
		wct_get_logic_product: function( modal_id ){

			var data = [];
			$('#'+ modal_id +' .add-block-cond-logic-product').each(function(i){
				var name = 'block_logic_product',
				select = $(this).children('select'),
				select_val = select.val();
				if( select_val != '' ){
					data.push(select_val);
				}
			});

			return data;

		},
		wct_reorder_logic_product: function( modal_id ){

			$('#'+ modal_id +' .add-block-cond-logic-product').each(function(i){
				var name = 'block_logic_product',
				select = $(this).children('select');
				select.attr('data-target', name+ '_'+ i );
			});

		}
	};
	wct_logic_product.init();
	
})(jQuery);