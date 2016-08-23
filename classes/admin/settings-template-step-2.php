<?php
/**
 * Settings template step 2.
 *
 * @link       http://demo.comfythemes.com/wct/
 * @since      1.0
 *
 * @package    woocommerce-checkout-templates
 * @subpackage woocommerce-checkout-templates/classes/admin
 * @author     OSVN <contact@outsourcevietnam.co>
 * @coder Nam
 */
defined( 'ABSPATH' ) OR exit;
?>
<?php 
/*=====get template active*/
$template_active = get_option('template_active');

/*=====get html row with template active===========*/
$wct_admin_html_row = get_option('wct_admin_html_row');

/*=====get setting newsletter=======*/
$newlleter = get_option('wct_newlleter');
$newsletter_provider = get_option('wct_newsletter_provider');
?>
<style>
.ossvn-newsletter-provider .uk-list{padding-left: 40px;}
.uk-list-item{float: left;padding: 13px;width:100px;cursor: pointer;}
.uk-list-item:hover, .uk-list-item.active{border: 1px solid #e35c71;}
.uk-form{padding-left: 60px;}
.uk-accordion .ossvn-accordion-title{border-top: none !important;border-left: none !important; border-right: none !important;}
</style>
<script>
var wct_template = '<?php echo $template_active;?>';
var wct_step = 2;
var wct_tour = <?php echo json_encode( 
										array( 
											'id'=>'wct-product-tour', 
											'steps'=> array( 
																array('title'=> __('WooCommerce Default', 'wct'), 'content'=>  __('This is the default fields & block of WooCommerce, you can find billing, shipping fields, login form or apply coupon.', 'wct'), 'target'=> '#wct-step-woo', 'placement'=> 'top' ), 
																array('title'=> __('Sidebar', 'wct'), 'content'=>  __('This is the sidebar, we created 2 sidebar for you, 1 is left-right sidebar, 1 is bottom sidebar, you can add anything you want in the Widgets of WordPress.', 'wct'), 'target'=> '#wct-step-sidebar', 'placement'=> 'right' ),
																array('title'=> __('Custom fields', 'wct'), 'content'=>  __('This is the custom fields, you can add many of them you want, but remember, less fields, higher revenue.', 'wct'), 'target'=> '#wct-step-custom', 'placement'=> 'right' ),
																array('title'=> __('Row - Column', 'wct'), 'content'=>  __('This is the fields container, you must add row first, then add a column inside then drag-drop elements from the left into that column. Blue border is Row, Red border is Column.', 'wct'), 'target'=> '#wct-step-content', 'placement'=> 'top' ),
																array('title'=> __('Information Storage', 'wct'), 'content'=>  __('Save user\'s input, save customer\'s time by save the fields on their computer.', 'wct'), 'target'=> '#ossvn-information-storage', 'placement'=> 'top' ),
																array('title'=> __('Save', 'wct'), 'content'=>  __('Press this to save all changes.', 'wct'), 'target'=> '#ossvn-data-raw-save', 'placement'=> 'left' ),
																array('title'=> __('Restore Default', 'wct'), 'content'=>  __('In case you want to restore to defualt, please press this.', 'wct'), 'target'=> '#ossvn-data-raw-restore', 'placement'=> 'right' )    
															), 
											'onEnd'=> array('wct_hopscotch_end'),
											'showPrevButton'=> true ) 
									);
				?>;
</script>
<div id="ossvn-wrapper">
	<div class="ossvn-container">
		<div id="ossvn-visual-composer">
			
			<div class="ossvn-left-col">

				<h3 class="ossvn-title"><?php _e('Woocommerce', 'wct');?></h3>
				<div id="wct-step-woo" class="uk-accordion ossvn-accordion" data-uk-accordion="{showfirst: false}">

					
					<?php 
					if($template_active == '1'|| $template_active == '2'):
					?>
					<h3 class="uk-accordion-title ossvn-multiple-block-title"><?php _e('Step bar', 'wct');?></h3>
					<div class="uk-accordion-content ossvn-multiple-block-content">
						<div data-type="step" class="ossvn-block ossvn-block-only-one" target-modal="#ossvn-edit-step-modal"><span class="ossvn-span-block-title"><?php _e('Step', 'wct');?></span></div>
					</div>
					<?php endif;?>

					<?php 
					if($template_active != '1' && $template_active != '2'):
					?>
					<h3 class="uk-accordion-title ossvn-multiple-block-title"><?php _e('Process bar', 'wct');?></h3>
					<div class="uk-accordion-content ossvn-multiple-block-content">
						<div data-type="process" class="ossvn-block ossvn-block-only-one" target-modal="#ossvn-edit-process-modal"><span class="ossvn-span-block-title"><?php _e('Process bar', 'wct');?></span></div>
					</div>
					<?php endif;?>

					<h3 class="uk-accordion-title ossvn-multiple-block-title"><?php _e('Account', 'wct');?></h3>
					<div class="uk-accordion-content ossvn-multiple-block-content">
						<div data-type="new_account" woo_field_id="wct_new_account" class="ossvn-block ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('New Customer', 'wct');?></span></div>
						<div data-type="login_form" woo_field_id="wct_account" class="ossvn-block ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Login form', 'wct');?></span></div>
					</div>


					<h3 class="uk-accordion-title ossvn-multiple-block-title"><?php _e('Billing Detail', 'wct');?></h3>
					<div class="uk-accordion-content ossvn-multiple-block-content">

						<div data-type="woo_field" woo_field_id="billing_first_name" woo_field_type="text" block_required="on" class="ossvn-block ossvn-block-text ossvn-block-first-name ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('First Name', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="billing_last_name" woo_field_type="text" block_required="on" class="ossvn-block ossvn-block-text ossvn-block-last-name ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Last Name', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="billing_email" woo_field_type="text" block_required="on" class="ossvn-block ossvn-block-email ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Email', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="billing_country" woo_field_type="country" block_required="on" class="ossvn-block ossvn-block-dropdown ossvn-block-first-name ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Country', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="billing_phone" woo_field_type="text" block_required="on" class="ossvn-block ossvn-block-text ossvn-block-last-name ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Phone', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="billing_company" woo_field_type="text" class="ossvn-block ossvn-block-text ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Company', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="billing_address_1" woo_field_type="text" block_required="on" class="ossvn-block ossvn-block-text ossvn-block-first-name ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Address 1', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="billing_address_2" woo_field_type="text" class="ossvn-block ossvn-block-text ossvn-block-last-name ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Address 2', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="billing_city" woo_field_type="text" block_required="on" class="ossvn-block ossvn-block-text ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('City', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="billing_postcode" woo_field_type="text" block_required="on" class="ossvn-block ossvn-block-text ossvn-block-last-name ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Postcode / Zip', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="billing_state" woo_field_type="state" block_required="on" class="ossvn-block ossvn-block-text ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('State', 'wct');?></span></div>
						<!--/Block ossvn-block-only-one cần phải có woo_field_id và ko được trùng nhau -->

					</div>
					<h3 class="uk-accordion-title ossvn-multiple-block-title"><?php _e('Shipping Detail', 'wct');?></h3>
					<div class="uk-accordion-content ossvn-multiple-block-content">

						<div data-type="different_address" woo_field_id="ship_to_different_address" woo_field_type="checkbox" class="ossvn-block ossvn-block-check-box ossvn-block-different-address-name ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Ship to a different address?', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="shipping_first_name" woo_field_type="text" block_required="on" class="shipping_address ossvn-block ossvn-block-text ossvn-block-first-name ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('First Name', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="shipping_last_name" woo_field_type="text" block_required="on" class="shipping_address ossvn-block ossvn-block-text ossvn-block-last-name ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Last Name', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="shipping_country" woo_field_type="country" block_required="on" class="shipping_address ossvn-block ossvn-block-dropdown ossvn-block-country ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Country', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="shipping_company" woo_field_type="text" class="shipping_address ossvn-block ossvn-block-text ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Company', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="shipping_address_1" woo_field_type="text" block_required="on" class="shipping_address ossvn-block ossvn-block-text ossvn-block-first-name ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Address 1', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="shipping_city" woo_field_type="text" class="shipping_address ossvn-block ossvn-block-text ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('City', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="shipping_postcode" woo_field_type="text" class="shipping_address ossvn-block ossvn-block-text ossvn-block-last-name ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Postcode / Zip', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="shipping_state" woo_field_type="state" class="shipping_address ossvn-block ossvn-block-text ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('State', 'wct');?></span></div>
						<div data-type="woo_field" woo_field_id="order_comments" woo_field_type="textarea" class="ossvn-block ossvn-block-text-area ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Order notes', 'wct');?></span></div>
						<!--/Block ossvn-block-only-one cần phải có woo_field_id và ko được trùng nhau -->

					</div>

					<h3 class="uk-accordion-title ossvn-multiple-block-title"><?php _e('Your order', 'wct');?></h3>
					<div class="uk-accordion-content ossvn-multiple-block-content">
						<div data-type="your_order" woo_field_id="wct_your_order" class="ossvn-block ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Your order', 'wct');?></span></div>
						<div data-type="payment" woo_field_id="wct_payment" class="ossvn-block ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Payment method', 'wct');?></span></div>
					</div>

					<?php 
					if( $template_active == '2'):
					?>
					<h3 class="uk-accordion-title ossvn-multiple-block-title"><?php _e('Order success', 'wct');?></h3>
					<div class="uk-accordion-content ossvn-multiple-block-content">
						<div data-type="order_success" class="ossvn-block ossvn-block-only-one" target-modal="#ossvn-edit-order-success-modal"><span class="ossvn-span-block-title"><?php _e('Order success', 'wct');?></span></div>
					</div>
					<?php endif;?>

				</div>

				<h3 class="ossvn-title"><?php _e('Sidebar', 'wct');?></h3>
				<div id="wct-step-sidebar" class="uk-accordion ossvn-accordion" data-uk-accordion="{showfirst: false}">
					<div data-type="sidebar" woo_field_id="wct_sidebar" class="ossvn-block ossvn-block-only-one"><span class="ossvn-span-block-title"><?php _e('Sidebar primary', 'wct');?></span></div>
					<div data-type="sidebar" woo_field_id="wct_sidebar_bottom" class="ossvn-block ossvn-block-only-one" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Sidebar bottom', 'wct');?></span></div>
				</div>


				<h3 class="ossvn-title"><?php  _e('Custom Fields', 'wct');?></h3>
				<div id="wct-step-custom" class="uk-accordion ossvn-accordion" data-uk-accordion="{showfirst: false}">
					<div data-type="title" class="ossvn-custom-fields ossvn-block ossvn-block-text" target-modal="#ossvn-edit-title-modal"><span class="ossvn-span-block-title"><?php _e('Title', 'wct');?></span></div>
					<div data-type="radio" class="ossvn-custom-fields ossvn-block ossvn-block-radio" target-modal="#ossvn-edit-checkbox-modal"><span class="ossvn-span-block-title"><?php _e('Radio field', 'wct');?></span></div>
					<div data-type="checkbox" class="ossvn-custom-fields ossvn-block ossvn-block-check-box" target-modal="#ossvn-edit-checkbox-modal"><span class="ossvn-span-block-title"><?php _e('Check box field', 'wct');?></span></div>
					<div data-type="button" class="ossvn-custom-fields ossvn-block ossvn-block-button" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Button field', 'wct');?></span></div>
					<div data-type="date" class="ossvn-custom-fields ossvn-block ossvn-block-date-time" target-modal="#ossvn-edit-date-modal"><span class="ossvn-span-block-title"><?php _e('Date-time field', 'wct');?></span></div>
					<div data-type="dropdown" class="ossvn-custom-fields ossvn-block ossvn-block-dropdown" target-modal="#ossvn-edit-select-modal"><span class="ossvn-span-block-title"><?php _e('Dropdown field', 'wct');?></span></div>
					<div data-type="text" class="ossvn-custom-fields ossvn-block ossvn-block-text" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Text field', 'wct');?></span></div>
					<div data-type="textarea" class="ossvn-custom-fields ossvn-block ossvn-block-text-area" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Text area field', 'wct');?></span></div>
					<div data-type="email" class="ossvn-custom-fields ossvn-block ossvn-block-email" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Email field', 'wct');?></span></div>
					<div data-type="phone" class="ossvn-custom-fields ossvn-block ossvn-block-phone" target-modal="#ossvn-edit-block-modal"><span class="ossvn-span-block-title"><?php _e('Phone field', 'wct');?></span></div>
					<div data-type="file" class="ossvn-custom-fields ossvn-block ossvn-block-file fa fa-upload" target-modal="#ossvn-edit-file-modal"><span class="ossvn-span-block-title"><?php _e('File Upload', 'wct');?></span></div>
					<div data-type="html" class="ossvn-custom-fields ossvn-block ossvn-block-html fa fa-html5" target-modal="#ossvn-edit-html-modal"><span class="ossvn-span-block-title"><?php _e('HTML', 'wct');?></span></div>
				</div>

			</div><!--/.ossvn-left-col -->
			
			<div class="ossvn-right-col">
				<h3 class="ossvn-title"><?php _e('Visual Composer', 'wct');?></h3>
				<div class="ossvn-visual-composer-content">					
					<p><?php _e('If this is the first time you use builder, you might want to see a tour for how to use. Click me please.', 'wct');?></p>
					<div id="wct-step-content" class="ossvn-drop-area">
						<?php 

						switch ($template_active) {
				
							case '1':
								if( $html_1 = get_option('wct_admin_html_row_1') ){
									
									if(!empty($html_1)){
										echo stripslashes( str_replace('&quot;', '\'', $html_1) );
									}else{
										echo stripslashes( str_replace('&quot;', '\'', $wct_admin_html_row) );
									}
								}else{
									
									echo stripslashes( str_replace('&quot;', '\'', $wct_admin_html_row) );
								}
								break;
							case '2':
								if( $html_2 = get_option('wct_admin_html_row_2') ){
									
									if(!empty($html_2)){
										echo stripslashes( str_replace('&quot;', '\'', $html_2) );
									}else{
										echo stripslashes( str_replace('&quot;', '\'', $wct_admin_html_row) );
									}
								}else{
									
									echo stripslashes( str_replace('&quot;', '\'', $wct_admin_html_row) );
								}
								break;
							case '3':
								if( $html_3 = get_option('wct_admin_html_row_3') ){
									
									if(!empty($html_3)){
										echo stripslashes( str_replace('&quot;', '\'', $html_3) );
									}else{
										echo stripslashes( str_replace('&quot;', '\'', $wct_admin_html_row) );
									}
								}else{
									
									echo stripslashes( str_replace('&quot;', '\'', $wct_admin_html_row) );
								}
								break;
							case '4':
								if( $html_4 = get_option('wct_admin_html_row_4') ){
									
									if(!empty($html_4)){
										echo stripslashes( str_replace('&quot;', '\'', $html_4) );
									}else{
										echo stripslashes( str_replace('&quot;', '\'', $wct_admin_html_row) );
									}
								}else{
									
									echo stripslashes( str_replace('&quot;', '\'', $wct_admin_html_row) );
								}
								break;
							case '5':
								if( $html_5 = get_option('wct_admin_html_row_5') ){
									
									if(!empty($html_5)){
										echo stripslashes( str_replace('&quot;', '\'', $html_5) );
									}else{
										echo stripslashes( str_replace('&quot;', '\'', $wct_admin_html_row) );
									}
								}else{
									echo stripslashes( str_replace('&quot;', '\'', $wct_admin_html_row) );
								}
								break;
							case '_blank':
								if( $html_blank = get_option('wct_admin_html_row_blank') ){
									
									if(!empty($html_blank)){
										echo stripslashes( str_replace('&quot;', '\'', $html_blank) );
									}else{
										echo stripslashes( str_replace('&quot;', '\'', $wct_admin_html_row) );
									}
								}else{
									echo stripslashes( str_replace('&quot;', '\'', $wct_admin_html_row) );
								}
								break;
							default:
								if(!empty($wct_admin_html_row)){echo stripslashes( str_replace('&quot;', '\'', $wct_admin_html_row) );}
								break;
						}
						?>
					</div><!--/.ossvn-drop-area -->
					<button type="button" class="ossvn-add-new-row" title="<?php _e('Add New Row', 'wct');?>"><i class="fa fa-plus-circle"></i></button>
				</div><!--/.ossvn-visual-composer-content -->

				
				<!--#Begin .ossvn-newsletter-provider-->
				<?php if(!empty($newlleter) && $newlleter == 'on'):?>
				<div class="ossvn-accordion-large uk-accordion ossvn-newsletter-provider" style="padding-top: 30px;" data-uk-accordion="{showfirst: false}">
					<h3 class="ossvn-accordion-title uk-accordion-title"><?php _e('Newsletter marketing provider', 'wct');?></h3>
					<div class="ossvn-accordion-content uk-accordion-content" style="padding-left: 20px;background: #FFF;">	
						<fieldset data-uk-margin>
							<div class="uk-form-row">	
								<ul class="uk-list">
									<li class="uk-list-item wct-newsletter-database <?php if(!empty($newsletter_provider) && $newsletter_provider == 'database'){echo 'active';}?>" data-val="database"><img src="<?php echo esc_url(WCT_ADMIN_IMG. 'icons/databases.png');?>"></li>
									<li class="uk-list-item wct-newsletter-aweber <?php if(!empty($newsletter_provider) && $newsletter_provider == 'aweber'){echo 'active';}?>" data-val="aweber"><img src="<?php echo esc_url(WCT_ADMIN_IMG. 'icons/aweber.png');?>"></li>
									<li class="uk-list-item wct-newsletter-mailchimp <?php if(!empty($newsletter_provider) && $newsletter_provider == 'mailchimp'){echo 'active';}?>" data-val="mailchimp"><img src="<?php echo esc_url(WCT_ADMIN_IMG. 'icons/mailchimp.png');?>"></li>
									<li class="uk-list-item wct-newsletter-getresponse <?php if(!empty($newsletter_provider) && $newsletter_provider == 'getresponse'){echo 'active';}?>" data-val="getresponse"><img src="<?php echo esc_url(WCT_ADMIN_IMG. 'icons/getresponse.jpg');?>"></li>
								</ul>
								<div class="clear"></div>
							</div>
							<div id="newsletter_provider_database" class="newsletter-provider-database hidden" style="padding-top: 30px; <?php if(!empty($newsletter_provider) && $newsletter_provider == 'database'){echo 'display: block;';}?>">
								<button type="button" class="ossvn-button ossvn-export-subscribers"><i class="fa fa-file-text"></i> <?php _e('Export subscribers', 'wct');?></button>
							</div>
							<div class="uk-form uk-form-horizontal newsletter-provider-aweber hidden" style="padding-top: 30px; <?php if(!empty($newsletter_provider) && $newsletter_provider == 'aweber'){echo 'display: block;';}?>">
								<div class="uk-form-row">
									<label class="uk-form-label" for="wct_aweber_consumer_key"><?php _e('Consumer Key', 'wct');?></label>
									<div class="uk-form-controls">
										<?php 
										$wct_aweber_consumer_key = get_option('wct_aweber_consumer_key');
										?>
										<input type="password" id="wct_aweber_consumer_key" name="wct_aweber_consumer_key" class="uk-form-danger" value="<?php if(!empty($wct_aweber_consumer_key)){echo esc_attr($wct_aweber_consumer_key);}?>"/>
									</div>
								</div>
								<div class="uk-form-row">
									<label class="uk-form-label" for="wct_aweber_consumer_secret"><?php _e('Consumer secret', 'wct');?></label>
									<div class="uk-form-controls">
										<?php 
										$wct_aweber_consumer_secret = get_option('wct_aweber_consumer_secret');
										?>
										<input type="password" id="wct_aweber_consumer_secret" name="wct_aweber_consumer_secret" class="uk-form-danger" value="<?php if(!empty($wct_aweber_consumer_secret)){echo esc_attr($wct_aweber_consumer_secret);}?>"/>
									</div>
								</div>
								<div class="uk-form-row">
									<label class="uk-form-label" for="wct_aweber_access_key"><?php _e('Access key', 'wct');?></label>
									<div class="uk-form-controls">
										<?php 
										$wct_aweber_access_key = get_option('wct_aweber_access_key');
										?>
										<input type="password" id="wct_aweber_access_key" name="wct_aweber_access_key" class="uk-form-danger" value="<?php if(!empty($wct_aweber_access_key)){echo esc_attr($wct_aweber_access_key);}?>"/>
									</div>
								</div>
								<div class="uk-form-row">
									<label class="uk-form-label" for="wct_aweber_access_secret"><?php _e('Access secret', 'wct');?></label>
									<div class="uk-form-controls">
										<?php 
										$wct_aweber_access_secret = get_option('wct_aweber_access_secret');
										?>
										<input type="password" id="wct_aweber_access_secret" name="wct_aweber_access_secret" class="uk-form-danger" value="<?php if(!empty($wct_aweber_access_secret)){echo esc_attr($wct_aweber_access_secret);}?>"/>
									</div>
								</div>
								<div class="uk-form-row">
									<label class="uk-form-label" for="wct_aweber_account_id"><?php _e('Account ID', 'wct');?></label>
									<div class="uk-form-controls">
										<?php  $wct_aweber_account_id = get_option('wct_aweber_account_id');?>
										<input type="text" id="wct_aweber_account_id" name="wct_aweber_account_id" class="uk-form-danger" value="<?php if(!empty($wct_aweber_account_id)){echo esc_attr($wct_aweber_account_id);}?>"/>
									</div>
								</div>
								<div class="uk-form-row">
									<label class="uk-form-label" for="wct_aweber_list_id"><?php _e('List ID', 'wct');?></label>
									<div class="uk-form-controls">
										<?php $wct_aweber_list_id = get_option('wct_aweber_list_id');?>
										<input type="text" id="wct_aweber_list_id" name="wct_aweber_list_id" class="uk-form-danger" value="<?php if(!empty($wct_aweber_list_id)){echo esc_attr($wct_aweber_list_id);}?>"/>
									</div>
								</div>
							</div>

							<div class="uk-form uk-form-horizontal newsletter-provider-mailchimp hidden" style="padding-top: 30px; <?php if(!empty($newsletter_provider) && $newsletter_provider == 'mailchimp'){echo 'display: block;';}?>">
								<div class="uk-form-row">
									<label class="uk-form-label" for="wct_mailchimp_key"><?php _e('API key', 'wct');?></label>
									<div class="uk-form-controls">
										<?php $wct_mailchimp_key = get_option('wct_mailchimp_key');?>
										<input type="password" id="wct_mailchimp_key" name="wct_mailchimp_key" class="uk-form-danger" value="<?php if(!empty($wct_mailchimp_key)){echo esc_attr($wct_mailchimp_key);}?>"/>
									</div>
								</div>
								<div class="uk-form-row">
									<label class="uk-form-label" for="wct_mailchimp_list_id"><?php _e('List ID', 'wct');?></label>
									<div class="uk-form-controls">
										<?php $wct_mailchimp_list_id = get_option('wct_mailchimp_list_id');?>
										<input type="text" id="wct_mailchimp_list_id" name="wct_mailchimp_list_id" class="uk-form-danger" value="<?php if(!empty($wct_mailchimp_list_id)){echo esc_attr($wct_mailchimp_list_id);}?>"/>
									</div>
								</div>
							</div>

							<div class="uk-form uk-form-horizontal newsletter-provider-getresponse hidden" style="padding-top: 30px;<?php if(!empty($newsletter_provider) && $newsletter_provider == 'getresponse'){echo 'display: block;';}?>">
								<div class="uk-form-row">
									<label class="uk-form-label" for="wct_getresponse_api_key"><?php _e('API key', 'wct');?></label>
									<div class="uk-form-controls">
										<?php $wct_getresponse_api_key = get_option('wct_getresponse_api_key');?>
										<input type="password" id="wct_getresponse_api_key" name="wct_getresponse_api_key" class="uk-form-danger" value="<?php if(!empty($wct_getresponse_api_key)){echo esc_attr($wct_getresponse_api_key);}?>"/>
									</div>
								</div>
								<div class="uk-form-row">
									<label class="uk-form-label" for="wct_getresponse_campaigns_name"><?php _e('Campaign named', 'wct');?></label>
									<div class="uk-form-controls">
										<?php $wct_getresponse_campaigns_name = get_option('wct_getresponse_campaigns_name');?>
										<input type="text" id="wct_getresponse_campaigns_name" name="wct_getresponse_campaigns_name" class="uk-form-danger" value="<?php if(!empty($wct_getresponse_campaigns_name)){echo esc_attr('$wct_getresponse_campaigns_name');}?>"/>
									</div>
								</div>
							</div>

							<div class="uk-form uk-form-horizontal" style="padding-top: 30px;">
								<div class="uk-form-row">
									<label class="uk-form-label" for="wct_newsletter_always_checked"><?php _e('Always checked?', 'wct');?></label>
									<div class="uk-form-controls">
										<?php $wct_newsletter_always_checked = get_option('wct_newsletter_always_checked');?>
										<input type="checkbox" id="wct_newsletter_always_checked" name="wct_newsletter_always_checked" class="uk-form-danger" <?php checked( $wct_newsletter_always_checked, 1 );?>/>
									</div>
								</div>
							</div>

						</fieldset>
					</div><!--/.ossvn-visual-composer-content -->
				</div>
				<?php endif;?>
				<!--#end .ossvn-newsletter-provider-->

				<?php if( $template_active == '2' ):?>
				<?php $step_style = get_option('wct_step_style');?>
				<div id="ossvn-step-styling" class="ossvn-accordion-large uk-accordion"  data-uk-accordion="{showfirst: false}">
					<h3 class="ossvn-accordion-title uk-accordion-title"><?php _e('Steps Styling', 'wct');?></h3>
					<div class="ossvn-accordion-content uk-accordion-content" style="background: #FFF;">
						<div class="ossvn-design-group">
							<span class="ossvn-label"><?php esc_html_e('Choose styling for step.', 'wct');?></span>
							<div class="ossvn-color">
								<select id="step_style" name="step_style">
									<option value=""><?php _e('Default', 'wct');?></option>
									<option value="ossvn-step-arrow" <?php selected( $step_style, 'ossvn-step-arrow' );?>><?php _e('Arrow', 'wct');?></option>
									<option value="ossvn-step-simple-circle" <?php selected( $step_style, 'ossvn-step-simple-circle' );?>><?php _e('Circle', 'wct');?></option>
									<option value="ossvn-step-link" <?php selected( $step_style, 'ossvn-step-link' );?>><?php _e('Link', 'wct');?></option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<?php endif;?>

				<div id="ossvn-styling-option" class="ossvn-accordion-large uk-accordion"  data-uk-accordion="{showfirst: false}">

					<h3 class="ossvn-accordion-title uk-accordion-title"><?php _e('Styling Options', 'wct');?></h3>
					<div class="ossvn-accordion-content uk-accordion-content" style="background: #FFF;">
						<div class="ossvn-styling-group">
							<span class="ossvn-label"><?php _e('Color Scheme', 'wct');?> :</span>
							<ul class="ossvn-color-scheme-list">
								<?php 
								$wct_styling_color_schreme = get_option('wct_styling_color_schreme');
								?>
								<li><input type="radio" class="ossvn-radio-color <?php if(!empty($wct_styling_color_schreme) && $wct_styling_color_schreme == '#000'){echo 'active';}?>" id="ossvn-radio-color-1" name="wct_styling_color_schreme" value="#000" ossvn-default-color='{"name" : "main_color","value" : "#000"};{"name" : "text_color","value" : "#7b7979"};{"name" : "link_hover_color","value" : "#f7941d"};{"name" : "background_color","value" : "#ffffff"};{"name" : "border_color","value" : "#d4d4d4"};{"name" : "title_color","value" : "#bdbdbd"};{"name" : "button_background","value" : "#000"};{"name" : "button_background_hover","value" : "#ffffff"};{"name" : "button_text_color","value" : "#ffffff"};{"name" : "button_text_color_hover","value" : "#000"};{"name" : "price_color","value" : "#000"}' /><label class="ossvn-color <?php if(!empty($wct_styling_color_schreme) && $wct_styling_color_schreme == '#000'){echo 'active';}?>" style="background: #000" for="ossvn-radio-color-1"></label></li>
								<li><input type="radio" class="ossvn-radio-color <?php if(!empty($wct_styling_color_schreme) && $wct_styling_color_schreme == '#e35c71'){echo 'active';}?>" id="ossvn-radio-color-2" name="wct_styling_color_schreme" value="#e35c71" ossvn-default-color='{"name" : "main_color","value" : "#e35c71"};{"name" : "text_color","value" : "#7b7979"};{"name" : "link_hover_color","value" : "#f7941d"};{"name" : "background_color","value" : "#ffffff"};{"name" : "border_color","value" : "#d4d4d4"};{"name" : "title_color","value" : "#bdbdbd"};{"name" : "button_background","value" : "#e35c71"};{"name" : "button_background_hover","value" : "#ffffff"};{"name" : "button_text_color","value" : "#ffffff"};{"name" : "button_text_color_hover","value" : "#e35c71"};{"name" : "price_color","value" : "#e35c71"}'  /><label class="ossvn-color <?php if(!empty($wct_styling_color_schreme) && $wct_styling_color_schreme == '#e35c71'){echo 'active';}?>" style="background: #e35c71" for="ossvn-radio-color-2"></label></li>
								<li><input type="radio" class="ossvn-radio-color <?php if(!empty($wct_styling_color_schreme) && $wct_styling_color_schreme == '#ff0000'){echo 'active';}?>" id="ossvn-radio-color-3" name="wct_styling_color_schreme" value="#ff0000" ossvn-default-color='{"name" : "main_color","value" : "#ff0000"};{"name" : "text_color","value" : "#7b7979"};{"name" : "link_hover_color","value" : "#f7941d"};{"name" : "background_color","value" : "#ffffff"};{"name" : "border_color","value" : "#d4d4d4"};{"name" : "title_color","value" : "#bdbdbd"};{"name" : "button_background","value" : "#ff0000"};{"name" : "button_background_hover","value" : "#ffffff"};{"name" : "button_text_color","value" : "#ffffff"};{"name" : "button_text_color_hover","value" : "#ff0000"};{"name" : "price_color","value" : "#ff0000"}' /><label class="ossvn-color <?php if(!empty($wct_styling_color_schreme) && $wct_styling_color_schreme == '#ff0000'){echo 'active';}?>" style="background: red" for="ossvn-radio-color-3"></label></li>
								<li><input type="color" class="ossvn-color-custom <?php if(!empty($wct_styling_color_schreme) && $wct_styling_color_schreme != '#ff0000' && $wct_styling_color_schreme != '#e35c71' && $wct_styling_color_schreme != '#000'){echo 'active';}?>" value="<?php if(!empty($wct_styling_color_schreme) && $wct_styling_color_schreme != '#ff0000' && $wct_styling_color_schreme != '#e35c71' && $wct_styling_color_schreme != '#000'){echo esc_attr($wct_styling_color_schreme);}else{echo '#fafafa';}?>"/></li>
							</ul>
						</div>


						<?php
						/**
						* Define styling option fields
						* @since 1.0.1
						*/

						$wct_styling = get_option('wct_styling');

						$my_stylings = array(
									'main_color' => array( 'title' => __('Main color', 'wct'), 'default' => '#e35c71', 'description' => __('This is main color. Default: #e35c71', 'wct') ),
									'text_color' => array( 'title' => __('Text color', 'wct'), 'default' => '#7b7979', 'description' => __('This is text color. Default: #7b7979', 'wct') ),
									'link_hover_color' => array( 'title' => __('Link hover color', 'wct'), 'default' => '#f7941d', 'description' => __('This is link hover color. Default: #f7941d', 'wct') ),
									'background_color' => array( 'title' => __('Background color', 'wct'), 'default' => '#ffffff', 'description' => __('This is background color. Default: #ffffff', 'wct') ),
									'border_color' => array( 'title' => __('Border color', 'wct'), 'default' => '#d4d4d4', 'description' => __('This is border color. Default: #d4d4d4', 'wct') ),
									'title_color' => array( 'title' => __('Title color', 'wct'), 'default' => '#bdbdbd', 'description' => __('This is title color. Default: #bdbdbd', 'wct') ),
									'button_background' => array( 'title' => __('Button background color', 'wct'), 'default' => '#e35c71', 'description' => __('This is Button background color. Default: #e35c71', 'wct') ),
									'button_background_hover' => array( 'title' => __('Button background hover color', 'wct'), 'default' => '#ffffff', 'description' => __('This is Button background hover color. Default: #ffffff', 'wct') ),
									'button_text_color' => array( 'title' => __('Button text color', 'wct'), 'default' => '#ffffff', 'description' => __('This is Button text color. Default: #ffffff', 'wct') ),
									'button_text_color_hover' => array( 'title' => __('Button text hover color', 'wct'), 'default' => '#e35c71', 'description' => __('This is Button text hover color. Default: #e35c71', 'wct') ),
									'price_color' => array( 'title' => __('Price color', 'wct'), 'default' => '#e35c71', 'description' => __('This is Price color. Default: #e35c71', 'wct') ),
									);
						if( $template_active == '1' ){

							$wct_1_style = array(
											'step2' => array( 'title' => __('Billing step', 'wct'), 'default' => '#5ec5ee', 'description' => __('This is step billing background. Default: #5ec5ee', 'wct') ),
											'step2_text_color' => array( 'title' => __('Billing step text', 'wct'), 'default' => '#7b7979', 'description' => __('This is step billing text color. Default: #7b7979', 'wct') ),
											'step2_background_color' => array( 'title' => __('Billing step content background', 'wct'), 'default' => '#ffffff', 'description' => __('This is step billing background color. Default: #ffffff', 'wct') ),
											
											'step3' => array( 'title' => __('Shipping step', 'wct'), 'default' => '#f96161', 'description' => __('This is step shipping background. Default: #f96161', 'wct') ),
											'step3_text_color' => array( 'title' => __('Shipping step text', 'wct'), 'default' => '#7b7979', 'description' => __('This is step shipping text color. Default: #7b7979', 'wct') ),
											'step3_background_color' => array( 'title' => __('Shipping step content background', 'wct'), 'default' => '#ffffff', 'description' => __('This is step shipping content background. Default: #ffffff', 'wct') ),
											
											'step4' => array( 'title' => __('Your order step', 'wct'), 'default' => '#c57fe2', 'description' => __('This is step your order background. Default: #c57fe2', 'wct') ),
											'step4_text_color' => array( 'title' => __('Your order step text', 'wct'), 'default' => '#7b7979', 'description' => __('This is step your order text color. Default: #7b7979', 'wct') ),
											'step4_background_color' => array( 'title' => __('Your order step content background', 'wct'), 'default' => '#ffffff', 'description' => __('This is your order step content background. Default: #ffffff', 'wct') ),
											);
							$my_stylings = array_merge($my_stylings, $wct_1_style);
						}

						if( $template_active == '2' ){

							$wct_2_style = array('step_color' => array( 'title' => __('Step background', 'wct'), 'default' => '#e35c71', 'description' => __('This is step background. Default: #e35c71', 'wct') ),);
							$my_stylings = array_merge($my_stylings, $wct_2_style);
						}

						foreach( $my_stylings as $style_key => $style_val ):
						?>

						<div class="ossvn-design-group">
							<span class="ossvn-label"><?php echo esc_html( $style_val['title'] );?> <img class="help_tip"  data-uk-tooltip="{pos:'top'}" title="<?php echo esc_html( $style_val['description'] );?>" src="<?php echo esc_url( WCT_ADMIN_IMG. 'help.png' );?>" height="16" width="16" /></span>
							<div class="ossvn-color">
								<input id="wct_color_<?php echo esc_attr( $style_key );?>" name="input_color_<?php echo esc_attr( $style_key );?>" type="color" class="ossvn-color-input" value="<?php if( !empty($wct_styling[$style_key]) ){echo esc_attr( $wct_styling[$style_key] );}else{echo esc_attr( $style_val['default'] );}?>"/>
								<input id="wct_<?php echo esc_attr( $style_key );?>" class="ossvn-color-text" type="text" name="<?php echo esc_attr( $style_key );?>" placeholder="<?php echo esc_html( $style_val['title'] );?>" value="<?php if( !empty($wct_styling[$style_key]) ){echo esc_attr( $wct_styling[$style_key] );}else{echo esc_attr( $style_val['default'] );}?>">
							</div>
						</div>

						<?php endforeach;?>



					</div>
				</div><!--/#ossvn-styling-option -->
				
				<div id="ossvn-information-storage" class="ossvn-accordion-large uk-accordion"  data-uk-accordion="{showfirst: false}">
					<h3 class="ossvn-accordion-title uk-accordion-title"><?php _e('Information Storage', 'wct');?></h3>
					<div class="ossvn-accordion-content uk-accordion-content" style="background: #FFF;">
						<div class="uk-form">
							<?php 
							$wct_information_store = get_option('wct_information_store');
							$wct_information_field_checked = get_option('wct_information_storage_field_checked')
							?>
							<div class="ossvn-option">
								<input id="r1" type="radio" class="ossvn-radio wct-information-storage" name="wct_information_store" value="all" <?php checked( $wct_information_store, 'all' ); ?>> <label  class="ossvn-label" for="r1"><?php _e('Store all information', 'wct');?></label>
							</div>	
							<div class="ossvn-option">
								<input id="r2" type="radio" class="ossvn-radio wct-information-storage" name="wct_information_store" value="exclude" <?php checked( $wct_information_store, 'exclude' ); ?>> <label  class="ossvn-label" for="r2"><?php _e('Store all information exclude', 'wct');?></label>
								<div class="ossvn-information-field ossvn-exclude-field ossvn-row" <?php if(!empty($wct_information_store) && $wct_information_store == 'exclude'){echo 'style="display:block;"';}?>  <?php if(!empty($wct_information_store) && $wct_information_store == 'exclude' && !empty($wct_information_field_checked)){?>data-field-checked="<?php echo join(',', $wct_information_field_checked);?>"<?php }?>>
								</div>
							</div>
							<div class="ossvn-option">
								<input id="r3" type="radio" class="ossvn-radio wct-information-storage" name="wct_information_store" value="specific" <?php checked( $wct_information_store, 'specific' ); ?>> <label  class="ossvn-label" for="r3"><?php _e('Store specific information', 'wct');?> </label>
								<div class="ossvn-information-field ossvn-specific-field ossvn-row" <?php if(!empty($wct_information_store) && $wct_information_store == 'specific'){echo 'style="display:block;"';}?> <?php if(!empty($wct_information_store) && $wct_information_store == 'specific' && !empty($wct_information_field_checked)){?>data-field-checked="<?php echo join(',', $wct_information_field_checked);?>"<?php }?>>
								</div>
							</div>

						</div>
					</div>
				</div><!--/#ossvn-information-storage -->

				<div id="ossvn-data-raw-form">
					<input type="hidden" name="ossvn-data-field-input" id="ossvn-data-field-input" />
					<input type="hidden" name="ossvn-data-raw-input" id="ossvn-data-raw-input" />
					<button type="button" id="ossvn-data-raw-save"><i class="fa fa-pencil-square-o"></i> <?php _e('Save', 'wct');?></button>
					<button type="button" id="ossvn-data-raw-restore" class="ossvn-button" data-active="<?php echo esc_attr($template_active);?>" data-href="<?php echo esc_url(admin_url('admin.php?page=wct-settings&step=2'));?>"><i class="fa fa-refresh"></i> <?php _e('Restore default', 'wct');?></button>
				</div>

			</div><!--/.ossvn-right-col -->
			
		</div>

	</div><!--/.ossvn-container -->


<!--===========================================Modal===============================================-->
	
	<!--edit file-->
	<?php self::wct_edit_file_modal();?>
	<!--end edit file-->

	<!--edit title-->
	<?php self::wct_edit_title_modal();?>
	<!--end edit title-->


	<!--edit select box-->
	<?php self::wct_edit_select_modal();?>
	<!--end select box-->


	<!--edit checkbox, radio-->
	<?php self::wct_edit_checkbox_modal();?>
	<!--end edit checkbox, radio-->

	<!--edit text, textarea, button, phone, email-->
	<?php self::wct_edit_text_modal();?>
	<!--edit text, textarea, button, phone, email-->

	<!--edit date time-->
	<?php self::wct_edit_date_modal();?>
	<!--edit date time-->



	<!--/TEMPLATE AREA -->

	<!--edit row-->
	<?php self::wct_edit_row_modal();?>
	<!--edit row-->

	<!--edit col-->
	<?php self::wct_edit_col_modal();?>
	<!--edit col-->

	<div id="ossvn-template-block" class="hidden">
		<div class="ossvn-row-controls ossvn-block-controls">
			<div  class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="<?php _e('Drag this block', 'wct');?>"></i></div>
			<button type="button" class="ossvn-edit-block ossvn-row-control"><i class="fa fa-pencil" title="<?php _e('Edit this block', 'wct');?>"></i></button>
			<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:'#ossvn-style-modal'}"><i class="fa fa-paint-brush" title="<?php _e('Style this block', 'wct');?>"></i></button>
			<button type="button" class="ossvn-delete-block ossvn-row-control"><i class="fa fa-trash" title="<?php _e('Delete this block', 'wct');?>"></i></button>	
		</div>
	</div><!--/#ossvn-template-col -->

	<div id="ossvn-template-custom-modal" class="ossvn-modal uk-modal">
		<div class="uk-modal-dialog ossvn-modal-box">
			<div class="ossvn-modal-header">
				<i class="fa fa-fa-gear"></i><?php _e('Custom Row Template', 'wct');?>
				<a class="uk-modal-close uk-close ossvn-modal-close"></a>
			</div>
			<div class="ossvn-modal-body uk-form">
				<div class="ossvn-form-group">
					<label class="ossvn-label" for="ossvn-row-custom-input"><?php _e('Custom Template', 'wct');?></label>
					<input type="text" id="ossvn-row-custom-input"  />
				</div>
				<p><?php _e('Change particular row layout manually by specifying number of columns and their size value.Example: 1/4 + 1/2 + 1/4,...', 'wct');?></p>
				<div class="ossvn-modal-footer">
					<button type="button" class="ossvn-save-col"><?php _e('Save changes', 'wct');?></button>
				</div>
			</div>		
	    </div>
	</div><!--/#ossvn-edit-checkbox-modal -->
	<!--/TEMPLATE AREA -->

	<!--edit style-->
	<?php self::wct_edit_style_modal();?>
	<!--edit style-->

	<?php 
	if($template_active == '1'|| $template_active == '2'):
	?>
		<!--edit step-->
		<?php self::wct_edit_step_modal();?>
		<!--edit step-->
	<?php endif;?>

	<?php if($template_active == '2'):?>
		<?php self::wct_edit_order_success_modal();?>
	<?php endif;?>

	<?php self::wct_edit_html_modal();?>

	<?php self::wct_edit_process_modal();?>
<!-- MODAL AREA -->
</div><!--/#ossvn-wrapper -->