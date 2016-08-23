(function($) {
    "use strict"; 
    // Author code here
    // Tooltips
	var tiptip_args = {
		'attribute' : 'data-tip',
		'fadeIn' : 50,
		'fadeOut' : 50,
		'delay' : 200
	};
	$(".tips, .help_tip").tipTip( tiptip_args );
	//field select all
	$('#select_all_rm').click(function() {
	    var rm = this.checked;
	    $('.rm').prop('checked',rm);
	});
	$('#select_all_rq').click(function() {
	    var rq = this.checked;
	    $('.rq').prop('checked',rq);
	});
	//
	$(document).ready( function() {
		// Update Order Numbers
		function update_order_numbers(div) {
			div.children('tbody').children('tr.wct-row').each(function(i) {
				$(this).children('td.wct-order').html(i+1);
			});
			div.children('tbody').find('[name]').each(function(i) {
				var order = $(this).closest('tr.wct-row').find('td.wct-order').text(),
				old_name = $(this).attr('name'),
				num_name = old_name.replace( /[^\d.]/g, '' ),
				new_name = old_name.replace('['+ num_name +']','[' + order + ']');
				$(this).attr('name', new_name);
			});
		}
		// Make Sortable
		function make_sortable(div){
			var fixHelper = function(e, ui) {
				ui.children().each(function() {
					$(this).width($(this).width());
				});
				return ui;
			};
			div.children('tbody').unbind('sortable').sortable({
				update: function(event, ui){
					update_order_numbers(div);
				},
				handle: 'td.wct-order',
				helper: fixHelper
			});
		}
		var div = $('.wct-table'),
		row_count = div.children('tbody').children('tr.wct-row').length;
		// Make the table sortable
		make_sortable(div);
		// Add button
		$('#wct-add-button').live('click', function(){

			var div = $('.wct-table'),			
			row_count = div.children('tbody').children('tr.wct-row').length,
			new_field = div.children('tbody').children('tr.wct-clone').clone(false); // Create and add the new field
			new_field.attr( 'class', 'wct-row' );
			// Update names
			new_field.find('[name]').each(function(){
				var count = parseInt(row_count);
				var name = $(this).attr('name').replace('[999]','[' + count + ']');
				$(this).attr('name', name);
			});
			// Add row
			div.children('tbody').append(new_field); 
			update_order_numbers(div);
			// There is now 1 more row
			row_count ++;
			return false;

		});
		// Remove button
		$('.wct-table .wct-remove-button').live('click', function(){
			var div = $('.wct-table'),
				tr = $(this).closest('tr');
			tr.animate({'left' : '50px', 'opacity' : 0}, 250, function(){
				tr.remove();
				update_order_numbers(div);
			});
			return false;
		});
	});
		
	
})(jQuery);