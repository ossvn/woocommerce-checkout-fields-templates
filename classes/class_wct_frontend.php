<?php 
/**
 * Functions for frontend.
 *
 * @link       http://demo.comfythemes.com/wct/
 * @since      1.0
 *
 * @package    woocommerce-checkout-templates
 * @subpackage woocommerce-checkout-templates/classes
 * @author     wct <contact@outsourcevietnam.co>
 * @coder Nam
 */
defined( 'ABSPATH' ) OR exit;

/**
* 
*/
class WCT_Frontend
{
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0
	 * @var      string    $plugin_name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'wp_enqueue_scripts', array($this, 'wct_enqueue_styles') );
		add_action( 'wp_enqueue_scripts', array($this, 'wct_enqueue_scripts'), 50);
		
		add_action('woocommerce_review_order_before_submit', array($this, 'wct_newletter_checkbox'));
		add_action('woocommerce_checkout_update_order_meta', array($this, 'wct_update_order_newletter_value'));
		//update custom fields order meta
		add_action('woocommerce_checkout_update_order_meta', array($this, 'wct_update_custom_fields_order_meta'));
		//
		add_action('woocommerce_thankyou', array($this, 'wct_newsletter'));
		add_action('woocommerce_thankyou', array($this, 'wct_add_custom_fields_to_thankyou_page'));
		add_action('woocommerce_email_after_order_table', array($this, 'wct_add_custom_fields_to_thankyou_page'));
        //
        add_action('wp_footer', array($this, 'wct_information_storage_field'));
        //
        add_action( 'wp_head', array($this, 'wct_add_custom_style') );
        //
        add_action( 'wp_ajax_wct_custom_price', array($this, 'wct_add_cart_fee_ajax') );
        add_action( 'wp_ajax_nopriv_wct_custom_price', array($this, 'wct_add_cart_fee_ajax') );
        add_action( 'wp_ajax_wct_del_price', array($this, 'wct_del_cart_fee_ajax') );
        add_action( 'wp_ajax_nopriv_wct_del_price', array($this, 'wct_del_cart_fee_ajax') );

        add_action( 'woocommerce_cart_calculate_fees', array($this, 'wct_add_cart_fee') );
        add_action( 'woocommerce_checkout_process', array($this, 'wct_add_notices_required_custom_fields') );
        //
        add_filter('body_class', array($this, 'wct_body_class_template_active') );

        add_action( 'wp_ajax_wct_upload', array($this, 'wct_upload') );
        add_action( 'wp_ajax_nopriv_wct_upload', array($this, 'wct_upload') );
        add_action( 'wp_ajax_wct_delete_upload', array($this, 'wct_delete_upload') );
        add_action( 'wp_ajax_nopriv_wct_delete_upload', array($this, 'wct_delete_upload') );

        //add query var
		add_filter( 'query_vars', array( $this, 'wct_add_query_var' ) );
		add_action( 'init', array( $this, 'wct_add_endpoint' ) );

	}


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0
	 */
	public function wct_enqueue_styles() {
		$checkout_field = get_option('wct_checkout_field');

		wp_enqueue_style( 'wct-style-awesome', WCT_ASSETS_GLOBAL . 'styles/awesome.css', array(), $this->version, 'all' );
		if ( is_checkout() || is_page( get_option('woocommerce_myaccount_page_id') ) ) {
			wp_enqueue_style( 'wct-style-reset', WCT_FRONTEND_CSS. 'reset.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'wct-style-uikit', WCT_ASSETS_GLOBAL. 'uikit/css/uikit.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'wct-style-accordion', WCT_ASSETS_GLOBAL. 'uikit/css/accordion.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'wct-style-form-advanced', WCT_ASSETS_GLOBAL. 'uikit/css/form-advanced.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'wct-style-date-ui', WCT_FRONTEND_CSS. 'datapicker/css/jquery-ui-1.10.1.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'wct-style-date-template', WCT_FRONTEND_CSS. 'datapicker/css/datepicker.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'wct-style-global', WCT_FRONTEND_CSS . 'global.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'wct-font-dosis', 'https://fonts.googleapis.com/css?family=Dosis:400,700', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the script for the public-facing side of the site.
	 *
	 * @since    1.0
	 */
	public function wct_enqueue_scripts() {

		if ( is_checkout() || is_page( get_option('woocommerce_myaccount_page_id') ) ) {
			wp_deregister_script('wc-country-select');
			wp_enqueue_script( 'wc-country-select', WCT_FRONTEND_JS . 'country-select.js', array( 'jquery' ), $this->version, true );
			
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'wct-script-datepicker-addon', WCT_FRONTEND_JS . 'jquery-ui-timepicker-addon.js', array( 'jquery-ui-datepicker' ), $this->version, true );
			wp_enqueue_script( 'wct-script-modernizr', WCT_ASSETS_GLOBAL . 'scripts/modernizr.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'wct-script-flexslider', WCT_ASSETS_GLOBAL . 'scripts/jquery.flexslider-min.js', array( 'woocommerce' ), $this->version, true );
			wp_enqueue_script( 'wct-script-uikit', WCT_ASSETS_GLOBAL . 'uikit/js/uikit.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( 'wct-script-accordion', WCT_ASSETS_GLOBAL . 'uikit/js/accordion.min.js', array( 'woocommerce' ), $this->version, true );
			wp_enqueue_script( 'wct-script-notify', WCT_ASSETS_GLOBAL . 'uikit/js/notify.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'wct-script-dependsOn', WCT_FRONTEND_JS . 'dependsOn.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( 'wct-script-upload', WCT_ASSETS_GLOBAL . 'uikit/js/upload.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( 'wct-script-coupon', WCT_FRONTEND_JS . 'coupon.js', array( 'jquery' ), $this->version, true );
			
			if($template_active = get_option('template_active')){
				
				if($template_active != '_blank'){

					if($template_active == '1'){

						wp_enqueue_script( 'wct-script-color', WCT_FRONTEND_JS . 'color.js', array( 'jquery' ), $this->version, true );
					}
					wp_enqueue_script( 'wct-script-main', WCT_FRONTEND . 'templates/'.$template_active.'/assets/scripts/main.js', array( 'jquery' ), $this->version, true );
				}else{
					wp_enqueue_script( 'wct-script-main', WCT_FRONTEND_JS . 'main.js', array( 'jquery' ), $this->version, true );
				}
			}else{
				wp_enqueue_script( 'wct-script-main', WCT_FRONTEND_JS . 'main.js', array( 'jquery' ), $this->version, true );
			}

			if(!is_user_logged_in()){
				wp_enqueue_script( 'wct-script-login', WCT_FRONTEND_JS . 'login.js', array( 'jquery' ), $this->version, true );
			}
			wp_enqueue_script( 'wct-script-global', WCT_FRONTEND_JS . 'global.js', array( 'jquery' ), $this->version, true );

			if($template_active == '1' || $template_active == '2'){
				wp_enqueue_script( 'wct-script-step', WCT_FRONTEND_JS . 'step.js', array( 'jquery' ), $this->version, true );
			}
			
			if(is_user_logged_in()){
				$user_logged = 'on';
			}else{
				$user_logged = 'off';
			}
			if(get_query_var('order-received') > 0){
				$order_success = 'on';
			}else{
				$order_success = 'off';
			}

			$text_js = array(

						'confirm_delete_file' => esc_html__('Press OK to delete this file, Cancel to leave!', 'wct'),

						);

			$step_style = get_option('wct_step_style');

			$step_style_class = ( isset($step_style) && !empty($step_style) ) ? $step_style : 'ossvn-step-default';
			$wct_logic_fields 	= get_option('_wct_logic_product_fields') ? get_option('_wct_logic_product_fields') : array();

			wp_localize_script( 'wct-script-global', 'wct_ajax_url', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'user_logged'=> $user_logged, 'wct_order_success'=> $order_success, 'next_button' => __('Next', 'wct'), 'prev_button' => __('Back', 'wct'), 'text_js_translate' => $text_js, 'step_style_class' => $step_style_class, 'wct_logic_fields' => $wct_logic_fields ) );
		}

	}

	/**
	* Update custom field order meta.
	* Action woocommerce_checkout_update_order_meta
	* @since    1.0
	*/
	public function wct_update_custom_fields_order_meta($order_id){

		if($all_fields = get_option('wct_all_field')){
			
			foreach ($all_fields as $field) {
				
				if($field['block_type'] != 'new_account' || $field['block_type'] != 'login_form' || $field['block_type'] != 'woo_field' || $field['block_type'] != 'your_order' || $field['block_type'] != 'payment'){

					if($field['block_type'] == 'file'){

						if ( !empty( $_POST[$field['block_id']] ) ) {

							$file = html_entity_decode($_POST[$field['block_id']]);
							update_post_meta( $order_id, $field['block_id'], json_decode( stripslashes($file) ) );
						}

					}else{

						if ( !empty( $_POST[$field['block_id']] ) ) {

							update_post_meta( $order_id, $field['block_id'], $_POST[$field['block_id']] );
						}

					}
				}
			}
		}
	}

	/**
	* Add custom field to thankyou page, email order.
	* Action woocommerce_thankyou
	* @since    1.0
	*/
	public function wct_add_custom_fields_to_thankyou_page($order){
		
		if($all_fields = get_option('wct_all_field')){
			foreach ($all_fields as $field) {
				switch ($field['block_type']) {
					case 'title':
						break;
					case 'login_form':
						break;
					case 'new_account':
						break;
					case 'sidebar':
						break;
					case 'your_order':
						break;
					case 'payment':
						break;
					case 'process':
						break;
					case 'step':
						break;
					case 'order_success':
						break;
					case 'different_address':
						break;
					case 'woo_field':
						# code...
						break;
					case 'file':
						if($order_meta = get_post_meta($order, $field['block_id'], true)){
							echo '<h2>'.__('File upload').':</h2>';
							echo '<ol>';
							foreach ($order_meta as $key => $value) {
								echo '<li><a href="'.esc_url($value->url).'" target="_blank">'.esc_html($value->name).'</a></li>';
								$this->wct_update_parent_attachment($order, $value->id);
							}
							echo '</ol>';
						}
						break;
					case 'checkbox':
					case 'radio':
					case 'dropdown':

						if($order_meta = get_post_meta($order, $field['block_id'], true)){

							if( null !== ICL_LANGUAGE_CODE && isset($field['block_title_lang'])  ){
								$title = $field['block_title_lang'];
							}else{
								$title = $field['block_title'];
							}

							$block_detail = WCT_Woocommerce::wct_get_detail_block_by_id( $field['block_id'] );
							$option_str = explode("\n", $block_detail['block_val_option']);
							$option_str = array_map('trim', $option_str);

							if( is_array($option_str) && !empty($option_str) ){

								echo '<h2>'.esc_html($title).'</h2>';
							
								foreach( $option_str as $str ){
									if( strpos( $str, $order_meta ) !== false ){
										echo '<p>'.str_replace( $order_meta.' : ', '', $str).'</p>';
									}
								}
								
							}
							
						}

						break;
					default:
						if($order_meta = get_post_meta($order, $field['block_id'], true)){

							if( null !== ICL_LANGUAGE_CODE && isset($field['block_title_lang'])  ){
								$title = $field['block_title_lang'];
							}else{
								$title = $field['block_title'];
							}

							echo '<h2>'.esc_html($title).'</h2>';
							echo '<p>'.$order_meta.'</p>';
						}
						break;
				}
			}
		}
	}


	/**
	* Add checkbox field after place order button.
	* Action woocommerce_review_order_after_submit
	* @since    1.0
	*/
	public function wct_newletter_checkbox(){
		$subscribe = get_option('wct_newlleter');
		if(!empty($subscribe) && $subscribe == 'on'){

			$wct_newsletter_always_checked = get_option('wct_newsletter_always_checked');

			$checked = ( isset($wct_newsletter_always_checked) && $wct_newsletter_always_checked == 1 ) ? 'checked="checked"' : '';

			$out = '
			<p class="form-row">
				<label for="wct_newsletter" class="checkbox">'.__('I want to subscribe to email newsletter', 'wct').'</label>
				<input type="checkbox" class="input-checkbox" name="wct_newletter_checkbox" id="wct_newletter_checkbox" '.esc_attr( $checked ).'/>
			</p>
			';
			echo $out;
		}
	}


	/**
	* Update checkbox newsletter.
	* Action woocommerce_checkout_update_order_meta
	* @since    1.0
	*/
	public function wct_update_order_newletter_value($order_id){
		if ( ! empty( $_POST['wct_newletter_checkbox'] ) ) {
	        update_post_meta( $order_id, 'wct_newletter_checkbox', $_POST['wct_newletter_checkbox'] );
	    }
	}


	/**
	* Subscribe after checkout.
	* Action woocommerce_thankyou
	* @since    1.0
	*/
	public function wct_newsletter( $order_id ) {
		// Lets grab the order
		$order = new WC_Order( $order_id );
		$subscribe = get_post_meta($order_id, 'wct_newletter_checkbox', true);
		if ( isset( $subscribe ) && $subscribe == 'on' ){
			
			$email = $order->billing_email;
			$fname = $order->billing_first_name;
			$lname = $order->billing_last_name;

			if($subscribe_type = get_option('wct_newsletter_provider')){
				switch ($subscribe_type) {
					case 'aweber':
						$this->wct_newsletter_aweber($email);
						break;
					case 'mailchimp':
						$this->wct_newsletter_mailchimp($email, $fname, $lname);
						break;
					case 'getresponse':
						$this->wct_newsletter_getresponse($email, $fname, $lname);
						break;
					default:
						$this->wct_newsletter_database($email);
						break;
				}
			}else{
				$this->wct_newsletter_database($email);
			}

		}
		
		 
	}

	/**
	* Subscribe database.
	* @since    1.0
	*/
	public function wct_newsletter_database($email){
		if($newletter = get_option('wct_newletter_database')){
			if(!in_array($email, $newletter)){
				$new_newletter = array_push($newletter, $email);
				update_option('wct_newletter_database', $new_newletter);
			}
		}else{
			update_option('wct_newletter_database', array($email));
		}
		return 'You have been subscribed for newsletter successfully.';
	}

	/**
	* Subscribe mailchimp.com.
	* @since    1.0
	*/
	public function wct_newsletter_mailchimp($email, $fname, $lname){
		require_once(WCT_INC . 'API/mailchimp/class_MCAPI.php');
		$api_key = get_option('wct_mailchimp_key');
		$api = new MCAPI($api_key);
		$merge_vars = Array( 
	        'EMAIL' => $email,
	        'FNAME' => $fname, 
	        'LNAME' => $lname
	    );

	    $list_id = get_option('wct_mailchimp_list_id');

	    if($api->listSubscribe($list_id, $email, '') === true){
	        return 'Success!&nbsp; Check your inbox or spam folder for a message containing a confirmation link.';
	    }else{
	        return '<b>Error:</b>&nbsp; ' . $api->errorMessage;
	    }
	}

	/**
	* Subscribe aweber.
	* @since    1.0
	*/
	public function wct_newsletter_aweber($email){
		require_once(WCT_INC . 'API/aweber/aweber_api.php');
		$consumerKey    = get_option('wct_aweber_consumer_key'); # put your credentials here
		$consumerSecret = get_option('wct_aweber_consumer_secret'); # put your credentials here
		$accessKey      = get_option('wct_aweber_access_key'); # put your credentials here
		$accessSecret   = get_option('wct_aweber_access_secret'); # put your credentials here
		$account_id     = get_option('wct_aweber_account_id'); # put the Account ID here
		$list_id        = get_option('wct_aweber_list_id'); # put the List ID here

		$aweber = new AWeberAPI($consumerKey, $consumerSecret);
		try {
		    $account = $aweber->getAccount($accessKey, $accessSecret);
		    $listURL = "/accounts/{$account_id}/lists/{$list_id}";
		    $list = $account->loadFromUrl($listURL);

		    # create a subscriber
		    $params = array(
		        'email' => $email,
		    );
		    $subscribers = $list->subscribers;
		    $new_subscriber = $subscribers->create($params);

		    # success!
		    return "You have been subscribed for newsletter successfully.";

		} catch(AWeberAPIException $exc) {
		    $out = "<h3>AWeberAPIException:</h3>";
		    $out .= " <li> Type: $exc->type              <br>";
		    $out .= " <li> Msg : $exc->message           <br>";
		    $out .= " <li> Docs: $exc->documentation_url <br>";
		    $out .= "<hr>";
		    return $out;
		    exit(1);
		}
	}

	/**
	* Subscribe getresponse.com.
	* @since    1.0
	*/
	public function wct_newsletter_getresponse($email, $fname, $lname){
		require_once(WCT_INC . 'API/getresponse/jsonRPCClient.php');
		# your API key is available at
		# https://app.getresponse.com/my_api_key.html
		$api_key = get_option('wct_getresponse_api_key');
		$campaigns_name = get_option('wct_getresponse_campaigns_name');
		# API 2.x URL
		$api_url = 'http://api2.getresponse.com';

		# initialize JSON-RPC client
		$client = new jsonRPCClient($api_url);

		# find campaign named 'test'
		$campaigns = $client->get_campaigns(
		    $api_key,
		    array (
		        # find by name literally
		        'name' => array ( 'EQUALS' => $campaigns_name )
		    )
		);

		# uncomment following line to preview Response
		# print_r($campaigns);

		# because there can be only one campaign of this name
		# first key is the CAMPAIGN_ID required by next method
		# (this ID is constant and should be cached for future use)
		$CAMPAIGN_ID = array_pop(array_keys($campaigns));

		# add contact to the campaign
		$result = $client->add_contact(
		    $api_key,
		    array (
		        # identifier of 'test' campaign
		        'campaign'  => $CAMPAIGN_ID,

		        # basic info
		        'name'      => ''.$fname.' '.$lname,
		        'email'     => $email,
		    )
		);

		# uncomment following line to preview Response
		# print_r($result);

		return "You have been subscribed for newsletter successfully.";
	}

	/**
	* INFORMATION STORAGE field
	* @since 1.0
	*/
	public function wct_information_storage_field(){

		if ( is_checkout() || is_page( get_option( 'woocommerce_checkout_page_id' ) ) ) {

			if($wct_information_store = get_option('wct_information_store')){
				echo '<script>
						(function($) {
							"use strict";
							setInterval(function() {
					            $(".woocommerce .input-text").blur(function() {
					                localStorage.setItem($(this).attr("name"), $(this).val());
					            });

					        }, 1000 );
				';
							switch ($wct_information_store) {
								case 'exclude':
									/*=============BEGIN: print exclude field============*/ 
							        $all_fields = get_option('wct_all_field');
							        if(!empty($all_fields)){
							        	if($fields_checked = get_option('wct_information_storage_field_checked')){
								        	foreach($all_fields as $field){
								        		if(!in_array($field['block_id'], $fields_checked)){
								        ?>
								        			$("#<?php echo esc_attr($field['block_id']);?>").val(localStorage.getItem("<?php echo esc_attr($field['block_id']);?>"));
								        <?php 
								        		}
								        	}
								        }
							    	}
							    	/*=============END: print exclude field============*/ 
									break;

								case 'specific':
									/*=============BEGIN: print specific field============*/ 
							        $all_fields = get_option('wct_all_field');
							        if(!empty($all_fields)){
							        	if($fields_checked = get_option('wct_information_storage_field_checked')){
								        	foreach($all_fields as $field){
								        		if(in_array($field['block_id'], $fields_checked)){
								        ?>
								        			$("#<?php echo esc_attr($field['block_id']);?>").val(localStorage.getItem("<?php echo esc_attr($field['block_id']);?>"));
								        <?php 
								        		}
								        	}
								        }
							    	}
							    	/*=============END: print specific field============*/ 
									break;

								default:
							        /*=============BEGIN: print all field============*/ 
							        $all_fields = get_option('wct_all_field');
							        if(!empty($all_fields)){
							        	foreach($all_fields as $field){
							        ?>
							        		$("#<?php echo esc_attr($field['block_id']);?>").val(localStorage.getItem("<?php echo esc_attr($field['block_id']);?>"));
							        <?php 
							        	}
							    	}
							    	/*=============END: print all field============*/ 
									break;
							}
				echo '
						})(jQuery);
					</script>';
			}

		}
	}

	/**
	* Add custom style on header
	* Action: wp_head
	* @since 1.0.1
	*/
	public function wct_add_custom_style(){

		$out = '';

		if ( is_checkout() || is_page( get_option('woocommerce_myaccount_page_id') ) ) {

			$out .= '<!--#BEGIN custom css WCT-->
					<style type="text/css">';

					if(!class_exists('lessc')){

						require_once( WCT_INC . 'lessphp/less.inc.php' );

						$wct_styling = get_option('wct_styling');

						$main_color = strip_tags( stripslashes( $wct_styling['main_color'] ) );
						$text_color = strip_tags( stripslashes( $wct_styling['text_color'] ) );
						$link_hover_color = strip_tags( stripslashes( $wct_styling['link_hover_color'] ) );
						$background_color = strip_tags( stripslashes( $wct_styling['background_color'] ) );
						$border_color = strip_tags( stripslashes( $wct_styling['border_color'] ) );
						$title_color = strip_tags( stripslashes( $wct_styling['title_color'] ) );
						$button_background = strip_tags( stripslashes( $wct_styling['button_background'] ) );
						$button_background_hover = strip_tags( stripslashes( $wct_styling['button_background_hover'] ) );
						$button_text_color = strip_tags( stripslashes( $wct_styling['button_text_color'] ) );
						$button_text_color_hover = strip_tags( stripslashes( $wct_styling['button_text_color_hover'] ) );
						$price_color = strip_tags( stripslashes( $wct_styling['price_color'] ) );

						$step2 = strip_tags( stripslashes( $wct_styling['step2'] ) );
						$step3 = strip_tags( stripslashes( $wct_styling['step3'] ) );
						$step4 = strip_tags( stripslashes( $wct_styling['step4'] ) );
						$step2_text_color = strip_tags( stripslashes( $wct_styling['step2_text_color'] ) );
						$step3_text_color = strip_tags( stripslashes( $wct_styling['step3_text_color'] ) );
						$step4_text_color = strip_tags( stripslashes( $wct_styling['step4_text_color'] ) );
						$step2_background_color = strip_tags( stripslashes( $wct_styling['step2_background_color'] ) );
						$step3_background_color = strip_tags( stripslashes( $wct_styling['step3_background_color'] ) );
						$step4_background_color = strip_tags( stripslashes( $wct_styling['step4_background_color'] ) );
						$step_color = strip_tags( stripslashes( $wct_styling['step_color'] ) );

						$template_active = get_option('template_active');

						/*input less*/
						if( $template_active != '_blank' ){

							$input = WCT_DIR. 'assets/front-end/templates/'.$template_active.'/assets/less/main.less';
							$template_img = WCT_FRONTEND .'templates/'.$template_active.'/assets/images/';

						}else{
							$input = WCT_DIR. 'assets/front-end/templates/3/assets/less/main.less';
							$template_img = WCT_FRONTEND .'templates/3/assets/images/';
						}

						$step_style = '';

						if( $template_active == '1' ){

							$step_style .= '@step2: '.$step2.';@step2_text_color: '.$step2_text_color.';@step2_link_hover_color: #f7941d;@step2_background_color:'.$step2_background_color.';@step2_border_color: #d4d4d4;@step2_title_color: #bdbdbd;@step2_button_background: #5ec5ee;@step2_button_background_hover: #ffffff;@step2_button_text_color: #ffffff;@step2_button_text_color_hover: #5ec5ee;@step2_price_color: #5ec5ee;';
							$step_style .= '@step3: '.$step3.';@step3_text_color: '.$step3_text_color.';@step3_link_hover_color: #f7941d;@step3_background_color:'.$step2_background_color.';@step3_border_color: #d4d4d4;@step3_title_color: #bdbdbd;@step3_button_background: #f96161;@step3_button_background_hover: #ffffff;@step3_button_text_color: #ffffff;@step3_button_text_color_hover: #f96161;@step3_price_color: #f96161;';
							$step_style .= '@step4: '.$step4.';@step4_text_color: '.$step4_text_color.';@step4_link_hover_color: #f7941d;@step4_background_color:'.$step2_background_color.';@step4_border_color: #d4d4d4;@step4_title_color: #bdbdbd;@step4_button_background: #c57fe2;@step4_button_background_hover: #ffffff;@step4_button_text_color: #ffffff;@step4_button_text_color_hover: #c57fe2;@step4_price_color: #c57fe2;';
						}

						if( $template_active == '2' ){

							$step_style .= '@step_color: '.$step_color.';@step_color_hover: #ffffff;';
						}
						
						try{

							$options = array( 'compress'=>true );
							$parser = new Less_Parser( $options );
						    $parser->parseFile( $input, $template_img );
						    $parser->parse( '@main_color: '.$main_color.';@text_color: '.$text_color.';@link_hover_color: '.$link_hover_color.';@background_color: '.$background_color.';@border_color: '.$border_color.';@title_color: '.$title_color.';@button_background: '.$button_background.';@button_background_hover: '.$button_background_hover.';@button_text_color: '.$button_text_color.';@button_text_color_hover: '.$button_text_color_hover.';@price_color: '.$price_color.';'.$step_style.'' );
						    $out .= $parser->getCss();

						}catch(Exception $e){

						    $out .= $e->getMessage();
						}

					}

			$out .= '</style>
					<!--#END custom css WCT-->
			';
		}

		echo $out;
	}	

	/**
	* Add custom fee to cart automatically
	* @since 1.0
	*/
	public function wct_add_cart_fee(){
		
		if($wct_add_cart_fee = get_option('wct_add_cart_fee')){
			
			global $woocommerce;
			
			$all_field = get_option('wct_all_field');
			
			if(is_array($wct_add_cart_fee)){
				
				foreach ($wct_add_cart_fee as $value) {
					
					$prefix = ( isset($value['type']) && $value['type'] == 'checkbox' ) ? '_'.$value['price_value'] : '';

					$block_id = str_replace( $prefix, '', $value['block_id'] );

					if( in_array_r( $block_id, $all_field ) ){
						
						if( $value['price_value'] > 0 ){

							$woocommerce->cart->add_fee( __(sanitize_text_field( $value['price_title'].$prefix ), 'wct'), intval($value['price_value']) );
						}
					}
	  			}
			}
		}
	}

	/**
	* Add option wct_add_cart_fee with ajax
	* @since 1.0
	*/
	public function wct_add_cart_fee_ajax(){
		
		$status = array('status'=> '0', 'html'=> '');

		if(isset($_POST['price_value']) && !empty($_POST['price_value'])){

			$price_title = ( isset($_POST['price_title']) && !empty($_POST['price_title']) ) ? sanitize_text_field($_POST['price_title']) : __('Price', 'wct');

			$price_value = ( isset($_POST['input_value']) && intval($_POST['input_value']) ) ? $_POST['input_value'] : $_POST['price_value'];

			$block_type = ( isset($_POST['input_type']) && !empty($_POST['input_type']) ) ? $_POST['input_type'] : '';

			$block_id =  ( !empty($block_type) && $block_type == 'checkbox' ) ? ''.sanitize_title($_POST['block_id']).'_'.intval( $price_value ).'' : sanitize_title($_POST['block_id']);

			if(isset($_POST['input_value']) && !empty($_POST['input_value'])){

				if( $wct_add_cart_fee = get_option('wct_add_cart_fee') ){

					$current_arr = array( 'type' => $block_type, 'price_value'=> intval( $price_value ), 'price_title'=> $price_title, 'block_id'=> $block_id );
					
					if( !in_array_r( $block_id, $wct_add_cart_fee ) ){

						array_push($wct_add_cart_fee, $current_arr);
						update_option('wct_add_cart_fee', $wct_add_cart_fee);

					}else{

						foreach ($wct_add_cart_fee as $key => $value) {
							if( $value['block_id'] == $block_id ){
								$wct_add_cart_fee[$key] = $current_arr;
								update_option('wct_add_cart_fee', $wct_add_cart_fee);
								break;
							}
						}
						
					}

				}else{

					$wct_add_cart_fee = array();
					array_push($wct_add_cart_fee, array( 'type' => $block_type, 'price_value'=> intval( $price_value ), 'price_title'=> $price_title, 'block_id'=> $block_id ));
					update_option('wct_add_cart_fee', $wct_add_cart_fee);
				}

				$status['status'] = '1';
				$status['html'] = $block_type;
			}

		}

		echo json_encode($status);
		exit();
	}


	/**
	* Delete option wct_add_cart_fee with ajax
	* @since 1.0
	*/
	public function wct_del_cart_fee_ajax(){

		$status = array('status'=> '0', 'html' => '');
		
		if(isset($_POST['price_title']) && !empty($_POST['price_title'])){
			
			$price_title = sanitize_text_field($_POST['price_title']);
		}else{

			$price_title = __('Price', 'wct');
		}

		$price_value = ( isset($_POST['input_value']) && intval($_POST['input_value']) ) ? $_POST['input_value'] : $_POST['price_value'];

		$block_type = ( isset($_POST['input_type']) && !empty($_POST['input_type']) ) ? $_POST['input_type'] : '';

		$block_id =  ( !empty($block_type) && $block_type == 'checkbox' ) ? ''.sanitize_title($_POST['block_id']).'_'.intval( $price_value ).'' : sanitize_title($_POST['block_id']);
		
		$wct_add_cart_fee = get_option('wct_add_cart_fee');
		
		$i = 0;

		if(!empty($wct_add_cart_fee)){

			foreach ($wct_add_cart_fee as $key => $value) {

				if( $value['block_id'] == $block_id ){

					unset($wct_add_cart_fee[$key]);
					update_option( 'wct_add_cart_fee', $wct_add_cart_fee);
					$status = array('status'=> '1');
				}

				$i++;
			}
			
		}
		
		echo json_encode($status);
		exit();
	}

	/**
	* Add class to body with template active
	* @since 1.0
	*/
	public function wct_body_class_template_active($classes){
		if ( is_checkout() || is_page( get_option( 'woocommerce_checkout_page_id' ) ) ) {
			$template_active = get_option('template_active');
			
			if($template_active != '_blank'){
				$classes[] = 'wct-template-'.$template_active.'';
			}else{
				$classes[] = 'wct-template-blank';
			}

			if(get_query_var('order-received') > 0){
				$classes[] = 'wct-order-success';
			}
		}
		return $classes;
	}

	/**
	* Add notices to checkout process when custom required fields is empty.
	* @return: notice
	* @since 1.0
	*/
	public function wct_add_notices_required_custom_fields(){

		if($all_fields = get_option('wct_all_field')){
			
			foreach ($all_fields as $field) {
				
				switch ($field['block_type']) {
					
					case 'title':
						break;
					case 'login_form':
						break;
					case 'new_account':
						break;
					case 'sidebar':
						break;
					case 'your_order':
						break;
					case 'payment':
						break;
					case 'process':
						break;
					case 'step':
						break;
					case 'order_success':
						break;
					case 'different_address':
						break;
					case 'woo_field':
						break;
					default:
						if ( !$_POST[ $field['block_id'] ] ){
							
							if( isset($field['block_required']) && $field['block_required'] == 'on' ){
								
								wc_add_notice( '<strong>'.esc_html($field['block_title']).'</strong> '. __('is a required field', 'wct' ) . ' ', 'error');
							}
						}
						break;
				}
			}
		}
	}


	/**
	* Ajax upload
	* @since 1.0.1
	*/
	public function wct_upload(){

		$status = array('status'=> '0', 'name'=> '', 'name_tmp' => '', 'url' => '', 'id' => '', 'message'=> 'No file sent.');

		if( isset($_FILES['uploadfile']['name']) && !empty($_FILES['uploadfile']['name']) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'wct_upload_nonce' ) ){

			if( isset($_POST['wct_file_allow']) && !empty($_POST['wct_file_allow']) ){

				$mimes = array();
				$str = explode("|", $_POST['wct_file_allow']);
				foreach ($str as $str_value) {
					$mimes[] = 'image/'.$str_value.'';
				}

			}else{
				
				$mimes = array( 'image/jpeg', 'image/png', 'image/gif', 'image/jpg' );
			}

			$attach_id = false;

			$file_name = basename( $_FILES['uploadfile']['name'] );
			
			$file_type = wp_check_filetype( $file_name );
			
			$file_renamed = mt_rand( 1000, 1000000 ) . '.' . $file_type['ext'];
			
			$upload = array(
				'name' => $file_renamed,
				'type' => $file_type['type'],
				'tmp_name' => $_FILES['uploadfile']['tmp_name'],
				'error' => $_FILES['uploadfile']['error'],
				'size' => $_FILES['uploadfile']['size']
			);

			if( in_array( $file_type['type'], $mimes) && $this->wct_check_file_extension( $file_type['ext'] ) ){

				$file = wp_handle_upload( $upload, array( 'test_form' => false ) );

				if ( $file && !isset( $file['error'] ) ) {
					
					$status['status'] = '1';
					$status['name'] = $file_renamed;
					$status['name_tmp'] = $_FILES['uploadfile']['name'];
					$status['url'] = esc_url($file['url']);
					$status['message'] = __('File is uploaded successfully.', 'wct');

					if ( isset( $file['file'] ) ) {

						$file_loc = $file['file'];

						$attachment = array(
							'post_mime_type' => $file_type['type'],
							'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
							'post_content' => '',
							'post_status' => 'inherit',
							'guid' => esc_url($file['url'])
						);

						$post_id = 0;
						$attach_id = wp_insert_attachment( $attachment, $file_loc, $post_id );
						$attach_data = wp_generate_attachment_metadata( $attach_id, $file_loc );
						wp_update_attachment_metadata( $attach_id, $attach_data );
					}

					if ( $attach_id ) {

						$status['id'] = $attach_id;

					}

				}else{

					$status['message'] = $file['error'];
				}

			}else{
			
				$status['message'] = __('Invalid file format.', 'wct');
			}

		}

		echo json_encode($status);
		die();
	}

	/**
	* Function check file type upload
	*
	* @return boole
	* @author Comfythemes
	* @since 1.2
	*/
	private function wct_check_file_extension( $file_ext ) {
		$found = false;
		$mimes = get_allowed_mime_types();

		foreach ( $mimes as $type => $mime ) {
			
			if ( strpos($type, $file_ext) !== false ) {
				
				$found = true; 
            	break;
			}
		}

		return $found;
	}

	/**
	* Update parent attachment uploaded
	* @since 1.0.1
	*/
	private function wct_update_parent_attachment( $order_id, $attach_id ){

		global $wpdb;

		$tbl_posts = esc_sql( $wpdb->posts );

		$wpdb->update( 
			$tbl_posts, 
			array( 
				'post_parent' => $order_id,	// string
			), 
			array( 'ID' => $attach_id )
		);
	}

	/**
	* Ajax delete file upload
	* @since 1.0.1
	*/
	public function wct_delete_upload(){

		$status = array('status'=> '0');

		if( isset($_REQUEST['attach_id']) && !empty($_REQUEST['attach_id']) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'wct_upload_nonce' ) ){

			wp_delete_attachment( $_REQUEST['attach_id'] );
		}

		echo json_encode($status);
		die();
	}

	/**
	* Add query var edit fields in myaccount
	*
	* @author Comfythemes
	* @since 1.0
	*/
	public function wct_add_query_var( $vars ){

		$vars[] = 'wct-edit';
		return $vars;
	}

	/**
	* Add endpoint edit fields in myaccount
	*
	* @author Comfythemes
	* @since 1.0
	*/
	public function wct_add_endpoint(){
		global $wp_rewrite; 
		add_rewrite_endpoint( 'wct-edit', EP_ROOT | EP_PAGES );
	    $wp_rewrite->flush_rules();
	}



}


/**
* Run class
* @since 1.0
*/
new WCT_Frontend( WCT_FOLDER, WCT_VER );
?>