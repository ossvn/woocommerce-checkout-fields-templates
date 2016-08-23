<?php 
/**
 * Functions for woocommerce.
 *
 * @link       http://demo.comfythemes.com/wct/
 * @since      1.0
 *
 * @package    woocommerce-checkout-templates
 * @subpackage woocommerce-checkout-templates/classes
 * @author     OSVN <contact@outsourcevietnam.co>
 * @coder Nam
 */
defined( 'ABSPATH' ) OR exit;

/**
* 
*/
class WCT_Woocommerce
{
	/**
	* Construct
	* @since 1.0
	*/
	function __construct()
	{
		add_action( 'wp_ajax_wct_login', array($this, 'wct_login') );
        add_action( 'wp_ajax_nopriv_wct_login', array($this, 'wct_login') );

        add_action( 'wp_ajax_wct_account_fields', array($this, 'wct_ajax_save_custom_fields_to_account') );
        add_action( 'wp_ajax_nopriv_wct_account_fields', array($this, 'wct_ajax_save_custom_fields_to_account') );

        add_action( 'wp_ajax_valid_post_code', array($this, 'wct_valid_post_code') );
        add_action( 'wp_ajax_nopriv_valid_post_code', array($this, 'wct_valid_post_code') );

        //
        add_filter( 'woocommerce_checkout_fields' , array($this, 'wct_override_checkout_fields') );
        add_filter( 'woocommerce_billing_fields', array($this, 'wct_override_required_fields'), 10, 1 );
        add_filter( 'woocommerce_shipping_fields', array($this, 'wct_shipping_required_fields'), 10, 1 );

        //
        add_action( 'init', array($this, 'wct_remove_coupon_form') );
        add_action( 'init', array($this, 'wct_clear_cart_url') );
        add_action( 'init', array($this, 'wct_user_logged_in_meta_data') );

        add_action( 'wp_footer', array( $this, 'wct_allowed_countries_field' ), 100 );

        add_action( 'woocommerce_checkout_update_order_meta', array($this, 'wct_save_steps_for_order_success'));

        add_action( 'woocommerce_after_my_account', array( $this, 'wct_add_custom_fields_to_account' ) );

        add_action( 'show_user_profile', array( $this, 'wct_add_custom_fields_to_user_profile' ) );
		add_action( 'edit_user_profile', array( $this, 'wct_add_custom_fields_to_user_profile' ) );

	}

	/**
	* Remove default coupon vs login form
	* @since    1.0
	*/
	public function wct_remove_coupon_form(){
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
	}

	/**
	* Empty cart
	* @since 1.0
	*/
	public function wct_clear_cart_url() {
		global $woocommerce;
		if ( isset( $_GET['empty-cart'] ) ) {
			$woocommerce->cart->empty_cart(); 
		}
	}

	
	/**
	* AJAX Login
	* @since 1.0
	*/
	public function wct_login( $user_login = null, $password = null ){
		
		$status = array('status'=> '', 'logged_in' => false);
		
		if ( ! empty( $_POST['login'] ) && ! empty( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'wct-login' ) ) {

			$username = empty( $_POST['username'] ) ? $user_login : sanitize_text_field( $_POST['username'] );
        	$password = empty( $_POST['password'] ) ? $password : sanitize_text_field( $_POST['password'] );
        	$remember = empty( $_POST['password'] ) ? $password : sanitize_text_field( $_POST['password'] );   

        	if ( validate_username( $username ) ){

            	if ( username_exists( $username ) ){

            		$creds = array();

					$creds['user_login'] = $username;
					$creds['user_password'] = $password;
					$creds['remember'] = false;
					
					$user = wp_signon( $creds, false );
                    if( is_wp_error( $user ) ){
                    	
                    	$status['status'] = $user->get_error_code();
                    }else{
                    	$status['logged_in'] = true;
                    	$status['status'] = __('Login success. You are now logged in as <strong>'.$user->display_name.'</strong>', 'wct');
                    }

            	}else{

            		$status['status'] = __('Username does not exists', 'wct');
            	}
            }else{

            	$status['status'] = __('Invalid username', 'wct');
            }


		}else{
			$status['status'] = __( 'Security check.', 'wct ' );
		}

		echo json_encode( $status );
		die();
	}

	/**
	* Billing field manager
	* Check if field exists. If not, remove field
	* @since 1.0
	*/
	public function wct_override_checkout_fields($fields){
		
		if( $wct_all_fields = get_option('wct_all_field') ){

			/**
			* Billing fields
			*/
			if ( !in_array_r( 'billing_country', $wct_all_fields ) ) { 
			    unset($fields['billing']['billing_country']);
			}
			
			if ( !in_array_r( 'billing_first_name', $wct_all_fields ) ) { 
			    unset($fields['billing']['billing_first_name']);
			}
			
			if ( !in_array_r( 'billing_last_name', $wct_all_fields ) ) { 
			    unset($fields['billing']['billing_last_name']);
			}
			
			if ( !in_array_r( 'billing_company', $wct_all_fields ) ) { 
			    unset($fields['billing']['billing_company']);
			}
			
			if ( !in_array_r( 'billing_address_1', $wct_all_fields ) ) { 
			    unset($fields['billing']['billing_address_1']);
			}
			
			
			if ( !in_array_r( 'billing_postcode', $wct_all_fields ) ) { 
			    unset($fields['billing']['billing_postcode']);
			}
			
			if ( !in_array_r( 'billing_city', $wct_all_fields ) ) { 
			    unset($fields['billing']['billing_city']);
			}

			if ( !in_array_r( 'billing_email', $wct_all_fields ) ) { 
			    unset($fields['billing']['billing_email']);
			}

			if ( !in_array_r( 'billing_phone', $wct_all_fields ) ) { 
			    unset($fields['billing']['billing_phone']);
			}
			
			
			/**
			* Shipping fields
			*/

			if ( !in_array_r( 'order_comments', $wct_all_fields ) ) { 
			    unset($fields['order']['order_comments']);
			}
			
			if ( !in_array_r( 'shipping_country', $wct_all_fields ) ) { 
				unset($fields['shipping']['shipping_country']);
			}

			if ( !in_array_r( 'shipping_first_name', $wct_all_fields ) ) { 
				unset($fields['shipping']['shipping_first_name']);
			}
			
			if ( !in_array_r( 'shipping_last_name', $wct_all_fields ) ) { 
				unset($fields['shipping']['shipping_last_name']);
			}
			
			
			if ( !in_array_r( 'shipping_company', $wct_all_fields ) ) { 
				unset($fields['shipping']['shipping_company']);
			}
			
			if ( !in_array_r( 'shipping_address_1', $wct_all_fields ) ) { 
			    unset($fields['shipping']['shipping_address_1']);
			}
			
			if ( !in_array_r( 'shipping_postcode', $wct_all_fields ) ) { 
			    unset($fields['shipping']['shipping_postcode']);
			}
			
			if ( !in_array_r( 'shipping_city', $wct_all_fields ) ) { 
			    unset($fields['shipping']['shipping_city']);
			}

		}

		return $fields;
	}

	/**
	* Allowed countries for the store
	*
	* @author comfythemes
	* @since 1.1
	*/
	public function wct_allowed_countries_field(){

		$allowed_countries 			= get_option( 'woocommerce_allowed_countries' );
		$specific_allowed_countries = get_option('woocommerce_specific_allowed_countries');

		$countries = array();

		if( $allowed_countries == 'specific' && !empty($specific_allowed_countries) ){

			if( count($specific_allowed_countries) == 1 ){

				?>
				<script>
				(function($) {
    				"use strict";

    				$('#billing_country').val('<?php echo current(array_values($specific_allowed_countries));?>');

    			})(jQuery);
				</script>
				<?php
			}
		}

		/**
		* Add value account page
		* @since 1.3
		*/
		if( is_user_logged_in() ){

			$current_user = wp_get_current_user();
			$account_fields = get_option('wct_account_fields');
			if( !empty($account_fields[$current_user->user_email]) ){

				?>
				<script>
				(function($) {
    				"use strict";

    				<?php foreach( $account_fields[$current_user->user_email] as $account_field ): ?>

    					<?php if( !empty($account_field['block_value']) ){

    						$block_detail = self::wct_get_detail_block_by_id($account_field['block_name']); 
							
							if( !empty($block_detail) ){
								 
								if( $block_detail['block_type'] == 'checkbox' || $block_detail['block_type'] == 'radio' ){

									$option_str = $account_field['block_value'];
									$option_str = explode(",", $option_str);
									$option_str = array_map('trim', $option_str);

									if( is_array($option_str) ){

										foreach( $option_str as $option ){
											if( !empty($option) ){
												echo '$(\'.ossvn-block-field[data-title="'.esc_attr($option).'"]\').prop(\'checked\', true);';
											}
										}
									}

								}else{

									echo '$(\'.ossvn-block-field[name="'.esc_attr($account_field['block_name']).'"]\').val(\''.esc_attr($account_field['block_value']).'\');';
								}
							}

    					}?>								

    				<?php endforeach;?>

    			})(jQuery);
				</script>
				<?php

			}

		}

	}

	/**
	* Check billing required fields
	* @since 1.0
	*/
	public function wct_override_required_fields( $billing_fields ){

		if( $wct_all_fields = get_option('wct_all_field') ){

			foreach ( $wct_all_fields as $wct_field ) {

				if($wct_field['block_type'] == 'woo_field'){

					if ( !in_array_r( 'billing_last_name', $wct_all_fields ) || $wct_field['block_required'] != 'on' ) {
					    $billing_fields['billing_last_name']['required'] = false;
					}
					
					if ( !in_array_r( 'billing_first_name', $wct_all_fields ) || $wct_field['block_required'] != 'on' ) {
					    $billing_fields['billing_first_name']['required'] = false;
					}
					
					if ( !in_array_r( 'billing_country', $wct_all_fields ) || $wct_field['block_required'] != 'on' ) {
						$billing_fields['billing_country']['required'] = false;
					}
					
					if ( !in_array_r( 'billing_phone', $wct_all_fields ) || $wct_field['block_required'] != 'on' ) {
						$billing_fields['billing_phone']['required'] = false;
					}

					if ( !in_array_r( 'billing_state', $wct_all_fields ) || $wct_field['block_required'] != 'on' ) {
						$billing_fields['billing_state']['required'] = false;
					}

					if ( !in_array_r( 'billing_address_1', $wct_all_fields ) || $wct_field['block_required'] != 'on' ) {
					    $billing_fields['billing_address_1']['required'] = false;
					}
					
					if ( !in_array_r( 'billing_city', $wct_all_fields ) || $wct_field['block_required'] != 'on' ) {
						$billing_fields['billing_city']['required'] = false;
					}

					if ( !in_array_r( 'billing_postcode', $wct_all_fields ) || $wct_field['block_required'] != 'on' ) {
						$billing_fields['billing_postcode']['required'] = false;
					}
					
				}

			}
		}

		return $billing_fields;
	}

	/**
	* Check shipping required fields
	* @since 1.0
	*/
	public function wct_shipping_required_fields( $shipping_fields ){

		if( $wct_all_fields = get_option('wct_all_field') ){

			foreach ( $wct_all_fields as $wct_field ) {

				if($wct_field['block_type'] == 'woo_field'){

					if ( !in_array_r( 'shipping_first_name', $wct_all_fields ) || $wct_field['block_required'] != 'on' ) {
					    $shipping_fields['shipping_first_name']['required'] = false;
					}
					
					if ( !in_array_r( 'shipping_last_name', $wct_all_fields ) || $wct_field['block_required'] != 'on' ) {
					    $shipping_fields['shipping_last_name']['required'] = false;
					}
					
				}

			}
		}

		return $shipping_fields;
	}

	/**
	* Valid post code
	*
	* @author Comfythemes
	* @since 1.2
	*/
	public function wct_valid_post_code(){
		
		$status = array('status'=> '0');

		if( isset($_POST['country']) && !empty($_POST['country']) && isset($_POST['postCode']) && !empty($_POST['postCode']) ){

			if( WC_Validation::is_postcode( $_POST['postCode'], $_POST['country'] ) ){
				$status['status'] = 1;
			}
		}

		echo json_encode($status);
		die();
	}

	/**
	* Function save html step for template 2 - Step - modern
	*
	* @author Comfythemes
	* @since 1.3
	*/
	public function wct_save_steps_for_order_success( $order_id ){

		if ( ! empty( $_POST['wct_save_steps_row_2'] ) ) {
	        update_option( 'wct_save_steps_row_2', $_POST['wct_save_steps_row_2'] );
	    }
	}

	/**
	* AJAX save fields for account page
	*
	* @author Comfytheme
	* @since 1.3
	*/
	public function wct_ajax_save_custom_fields_to_account(){

		if( isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['fields']) ){

			$account_fields = get_option('wct_account_fields') ? get_option('wct_account_fields') : array();
			
			$account_fields[$_POST['email']] = $_POST['fields'];
			update_option( 'wct_account_fields', $account_fields );

		}

	}

	/**
	* Add custom fileds to account page
	*
	* @author Comfythemes
	* @since 1.3
	*/
	public function wct_add_custom_fields_to_account(){
		global $wp;
		if( is_user_logged_in() ){

			$current_user = wp_get_current_user();
			$account_fields = get_option('wct_account_fields');

			if( !empty($account_fields[$current_user->user_email]) ):
				$i = 1;
			?>
				<h2>
					<?php echo apply_filters( 'wct_customer_additional_fields_title', esc_html__( 'Customer additional fields', 'wct' ) );?> 
					<?php if( !isset( $wp->query_vars['wct-edit'] ) ){?>
					<a class="wct-link-edit-custom-fields" href="<?php echo esc_url( wc_get_endpoint_url( 'wct-edit', '', wc_get_page_permalink( 'myaccount' ) ) );?>#wct-account" style="font-size:14px;">
						<?php esc_html_e('Edit');?>
					</a>
					<?php }?>
				</h2>
				<div class="col2-set addresses">
					<div id="ossvn-wrapper">
						<div id="wct-woo-template">
							<div id="ossvn-main">
								<div class="ossvn-container">
									<div class="wct-message" style="display:none;"></div>
									<div class="ossvn-row">
										<div class="ossvn-col ossvn-col-9">
											<div id="wct-account" class="col2-set addresses">
												
												<?php foreach( $account_fields[$current_user->user_email] as $account_field ): ?>
													<div class="ossvn-row"><div class="ossvn-col-9 ossvn-col woocommerce-billing-fields">
													<?php if( !empty($account_field['block_value']) ):?>

														<?php if( isset( $wp->query_vars['wct-edit'] ) ){?>

															<?php
															$block_detail = self::wct_get_detail_block_by_id($account_field['block_name']); 
															if( !empty($block_detail) ){
																
																echo do_shortcode('[wct_block type="'.esc_attr( $block_detail['block_type'] ).'" block_id="'.esc_attr( $account_field['block_name'] ).'" block_title="'.esc_attr( $account_field['block_title'] ).'" block_checkbox_options="'.esc_attr( $block_detail['block_val_option'] ).'" block_checkbox_options_p="'.esc_attr( $block_detail['block_val_option'] ).'" block_display_account="on"]');
																 
																if( $block_detail['block_type'] == 'checkbox' || $block_detail['block_type'] == 'radio' ){

																	$option_str = $account_field['block_value'];
																	$option_str = explode(",", $option_str);
																	$option_str = array_map('trim', $option_str);

																	if( is_array($option_str) ){

																		foreach( $option_str as $option ){

																			wct_enqueue_js('
																				$(\'.ossvn-block-field[data-title="'.esc_attr($option).'"]\').prop(\'checked\', true);
																			');

																		}
																	}

																}else{

																	wct_enqueue_js('
																		$(\'.ossvn-block-field[name="'.esc_attr($account_field['block_name']).'"]\').val(\''.esc_attr($account_field['block_value']).'\');
																	');
																}
															} 
															?>
														<?php }else{?>

															<strong><?php echo esc_html( $account_field['block_title'] );?></strong> : 
															<?php echo esc_html( $account_field['block_value'] );?>

														<?php }?>

													<?php endif;?>
													</div></div>
												<?php $i++;endforeach;?>
												<?php if( isset( $wp->query_vars['wct-edit'] ) ){?>
												<div class="ossvn-row">
													<div class="ossvn-col-9 ossvn-col" style="margin-top: 10px;">
														<input type="hidden" id="wct_redirect_url" name="wct_redirect_url" value="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) );?>">
														<input type="hidden" id="billing_email" name="billing_email" value="<?php echo esc_attr( $current_user->user_email );?>">
														<input type="button" class="ossvn-button" id="place_order" value="<?php esc_html_e('Save', 'wct');?>">
													</div>
												</div>
												<?php }?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			endif;
		}
	}

	/**
	* Add custom fileds to user profile admin
	*
	* @author Comfythemes
	* @since 1.3
	*/
	public function wct_add_custom_fields_to_user_profile( $current_user ){

		$account_fields = get_option('wct_account_fields');

		if( !empty( $account_fields[$current_user->user_email] ) ):
		$i = 0;
		?>
			<h2><?php echo apply_filters( 'wct_customer_additional_fields_title', esc_html__( 'Customer additional fields', 'wct' ) );?></h2>
			<table id="custom_user_field_table" class="form-table">
				<?php foreach( $account_fields[$current_user->user_email] as $account_field ): ?>
					
					<?php if( !empty($account_field['block_value']) ):?>
						<tr class="custom_user_field_row">
							<th>
				                <label for="custom_field"><?php echo esc_html( $account_field['block_title'] );?></label>
				            </th>
				            <td>
				            	<input type="text" name="wct_user_fields[<?php echo esc_attr( $current_user->user_email );?>][block_value][]" id="custom_field_value_<?php echo esc_attr($i);?>" value="<?php echo esc_html( $account_field['block_value'] );?>" class="regular-text" /><br />
				            </td>
						</tr>
					<?php endif;?>

				<?php $i++;endforeach;?>
			</table>
		<?php
		endif;

	}

	/**
	* Get detail block with block ID
	* 
	* @param string - block ID
	* @author Comfythemes
	* @since 1.3
	*/
	public static function wct_get_detail_block_by_id( $block_id ){

		$block_detail = array();

		if( $wct_all_fields = get_option('wct_all_field') ){

			foreach ( $wct_all_fields as $wct_field ) {

				if( $wct_field['block_id'] == $block_id ){

					$block_detail['block_required'] 				= ( isset($wct_field['block_required']) ) ? $wct_field['block_required'] : '';
					$block_detail['block_title'] 					= ( isset($wct_field['block_title']) ) ? $wct_field['block_title'] : '';
					$block_detail['block_type'] 					= ( isset($wct_field['block_type']) ) ? $wct_field['block_type'] : '';
					$block_detail['block_display_order_recived'] 	= ( isset($wct_field['block_display_order_recived']) ) ? $wct_field['block_display_order_recived'] : '';
					$block_detail['block_display_email'] 			= ( isset($wct_field['block_display_email']) ) ? $wct_field['block_display_email'] : '';
					$block_detail['block_display_pdf_invoices'] 	= ( isset($wct_field['block_display_pdf_invoices']) ) ? $wct_field['block_display_pdf_invoices'] : '';
					$block_detail['block_display_pdf_position'] 	= ( isset($wct_field['block_display_pdf_position']) ) ? $wct_field['block_display_pdf_position'] : '';
					$block_detail['account_page'] 					= ( isset($wct_field['account_page']) ) ? $wct_field['account_page'] : '';
					$block_detail['block_title_lang'] 				= ( isset($wct_field['block_title_lang']) ) ? $wct_field['block_title_lang'] : '';
					$block_detail['block_val_option'] 				= ( isset($wct_field['block_val_option']) ) ? $wct_field['block_val_option'] : '';
					break;
					
				}

			}
		}

		return $block_detail;

	}

	/**
	* Current user logged in metadata
	*
	* @author Comfythemes
	* @since 1.3
	*/
	public function wct_user_logged_in_meta_data(){

		if( is_user_logged_in() ){

			$current_user = wp_get_current_user();
			$user_id = $current_user->ID;

			if( $wct_all_fields = get_option('wct_all_field') ){

				foreach ( $wct_all_fields as $field ) {
					
					switch ($field['block_type']) {

						case 'woo_field':
							$user_meta = get_user_meta( $user_id, $field['block_id'], true );
							if( isset($user_meta) && !empty($user_meta) ){
								wct_enqueue_js(' $(\'#'.esc_attr( $field['block_id'] ).'\').val(\''.esc_attr( $user_meta ).'\');$("#'.esc_attr( $field['block_id'] ).'").prev(".ossvn-placeholder").hide(); ');
							}
							break;
						default:
							break;
					}

				}

			}
		}

	}


}

/**
* Run class
* @since 1.0
*/
new WCT_Woocommerce();
?>