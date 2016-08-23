/*global wc_country_select_params */
/**
* Edit by Comfythemes
* @since 1.3
*/
jQuery( function( $ ) {

	// wc_country_select_params is required to continue, ensure the object exists
	if ( typeof wc_country_select_params === 'undefined' ) {
		return false;
	}

	function getEnhancedSelectFormatString() {
		var formatString = {
			formatMatches: function( matches ) {
				if ( 1 === matches ) {
					return wc_country_select_params.i18n_matches_1;
				}

				return wc_country_select_params.i18n_matches_n.replace( '%qty%', matches );
			},
			formatNoMatches: function() {
				return wc_country_select_params.i18n_no_matches;
			},
			formatAjaxError: function() {
				return wc_country_select_params.i18n_ajax_error;
			},
			formatInputTooShort: function( input, min ) {
				var number = min - input.length;

				if ( 1 === number ) {
					return wc_country_select_params.i18n_input_too_short_1;
				}

				return wc_country_select_params.i18n_input_too_short_n.replace( '%qty%', number );
			},
			formatInputTooLong: function( input, max ) {
				var number = input.length - max;

				if ( 1 === number ) {
					return wc_country_select_params.i18n_input_too_long_1;
				}

				return wc_country_select_params.i18n_input_too_long_n.replace( '%qty%', number );
			},
			formatSelectionTooBig: function( limit ) {
				if ( 1 === limit ) {
					return wc_country_select_params.i18n_selection_too_long_1;
				}

				return wc_country_select_params.i18n_selection_too_long_n.replace( '%qty%', limit );
			},
			formatLoadMore: function() {
				return wc_country_select_params.i18n_load_more;
			},
			formatSearching: function() {
				return wc_country_select_params.i18n_searching;
			}
		};

		return formatString;
	}

	// Select2 Enhancement if it exists
	if ( $().select2 ) {
		var wc_country_select_select2 = function() {
			$( 'select.country_select, select.state_select' ).each( function() {
				var select2_args = $.extend({
					placeholder: $( this ).attr( 'placeholder' ),
					placeholderOption: 'first',
					width: '100%'
				}, getEnhancedSelectFormatString() );

				$( this ).select2( select2_args );
			});
		};

		wc_country_select_select2();

		$( document.body ).bind( 'country_to_state_changed', function() {
			wc_country_select_select2();
		});
	}

	/* State/Country select boxes */
	var states_json = wc_country_select_params.countries.replace( /&quot;/g, '"' ),
		states = $.parseJSON( states_json );

	$( document.body ).on( 'change', 'select.country_to_state, input.country_to_state', function() {

		var country     = $( this ).val(),
			$wrapper    = $( this ).closest('#content'), // Grab wrapping form-row parent to target stateboxes in same 'group'
			$statebox   = $wrapper.find( '#billing_state, #shipping_state, #calc_shipping_state' ),
			$parent     = $statebox.parent(),
			input_name  = $statebox.attr( 'name' ),
			input_id    = $statebox.attr( 'id' ),
			value       = $( this ).val(),
			placeholder = $statebox.attr( 'placeholder' );
		
		$('p.validate-state label').addClass('ossvn-placeholder');
		
		if( $( this ).attr('id') == 'billing_country' ){

			if ( states[ country ] ) {

				if ( $.isEmptyObject( states[ country ] ) ) {

					$('#billing_state_field').hide();
					$('#billing_state_field').find( '.select2-container' ).remove();
					$('#billing_state').replaceWith( '<input type="hidden" class="hidden" name="billing_state" id="billing_state" value="" />' );
					$( document.body ).trigger( 'country_to_state_changed', [ country ] );

				}else{
					
					var options = '',
					state = states[ country ];

					for( var index in state ) {
						if ( state.hasOwnProperty( index ) ) {
							options = options + '<option value="' + index + '">' + state[ index ] + '</option>';
						}
					}

					$('#billing_state_field').show();

					if ( $('#billing_state').is( 'input' ) ) {
						// Change for select
						$('#billing_state').replaceWith( '<select name="billing_state" id="billing_state" class="state_select" placeholder="' + $('#billing_state_field label').text() + '"></select>' );
					}
					$('#billing_state').html( '<option value="">' + wc_country_select_params.i18n_select_state_text + '</option>' + options );
					$('#billing_state').val( value ).change();
					$( document.body ).trigger( 'country_to_state_changed', [ country ] );

				}
				
			}else{
				
				if ( $('#billing_state').is( 'select' ) ) {

					$('#billing_state_field').show().find( '.select2-container' ).remove();
					$('#billing_state').replaceWith( '<input type="text" class="input-text" name="billing_state" id="billing_state" />' );

					$( document.body ).trigger( 'country_to_state_changed', [country] );

				} else if ( $('#billing_state').is( '.hidden' ) ) {

					$('#billing_state_field').show().find( '.select2-container' ).remove();
					$('#billing_state').replaceWith( '<input type="text" class="input-text" name="billing_state" id="billing_state" />' );

					$( document.body ).trigger( 'country_to_state_changed', [country] );

				}
			}

		}

		if( $( this ).attr('id') == 'shipping_country' ){

			if ( states[ country ] ) {

				if ( $.isEmptyObject( states[ country ] ) ) {

					$('#shipping_state_field').hide();
					$('#shipping_state_field').find( '.select2-container' ).remove();
					$('#shipping_state').replaceWith( '<input type="hidden" class="hidden" name="shipping_state" id="shipping_state" value="" />' );
					$( document.body ).trigger( 'country_to_state_changed', [ country ] );

				}else{
					
					var options = '',
					state = states[ country ];

					for( var index in state ) {
						if ( state.hasOwnProperty( index ) ) {
							options = options + '<option value="' + index + '">' + state[ index ] + '</option>';
						}
					}

					$('#shipping_state_field').show();

					if ( $('#shipping_state').is( 'input' ) ) {
						// Change for select
						$('#shipping_state').replaceWith( '<select name="shipping_state" id="shipping_state" class="state_select" placeholder="' + $('#shipping_state_field label').text() + '"></select>' );
					}
					$('#shipping_state').html( '<option value="">' + wc_country_select_params.i18n_select_state_text + '</option>' + options );
					$('#shipping_state').val( value ).change();
					$( document.body ).trigger( 'country_to_state_changed', [ country ] );

				}
				
			}else{
				
				if ( $('#shipping_state').is( 'select' ) ) {

					$('#shipping_state_field').show().find( '.select2-container' ).remove();
					$('#shipping_state').replaceWith( '<input type="text" class="input-text" name="shipping_state" id="shipping_state" />' );

					$( document.body ).trigger( 'country_to_state_changed', [country] );

				} else if ( $('#shipping_state').is( '.hidden' ) ) {

					$('#shipping_state_field').show().find( '.select2-container' ).remove();
					$('#shipping_state').replaceWith( '<input type="text" class="input-text" name="shipping_state" id="shipping_state" />' );

					$( document.body ).trigger( 'country_to_state_changed', [country] );

				}
			}

		}

	});

	$(function() {
		$( ':input.country_to_state' ).change();
	});

});
