<?php 
/**
 * Modal edit block: checkbox, radio
 *
 * @link       http://demo.comfythemes.com/wct/
 * @since      1.0
 *
 * @package    woocommerce-checkout-templates
 * @subpackage woocommerce-checkout-templates/classes/admin/edit-modal
 * @author     OSVN <contact@outsourcevietnam.co>
 * @coder Nam
 */
defined( 'ABSPATH' ) OR exit;
?>
<div id="ossvn-edit-checkbox-modal" class="ossvn-modal ossvn-block-modal uk-modal">
	<div class="uk-modal-dialog ossvn-modal-box">
		<div class="ossvn-modal-header">
			<i class="fa fa-pencil-square-o"></i><?php _e('Edit', 'wct');?>
			<a class="uk-modal-close uk-close ossvn-modal-close"></a>
		</div>
		<div class="ossvn-modal-body uk-form">
			<ul class="uk-tab" data-uk-switcher="{connect:'#ossvn-checkbox-general'}">
			    <li class="uk-active"><a href=""><?php _e('General', 'wct');?></a></li>
			    <li><a href=""><?php _e('Advanced', 'wct');?></a></li>
			</ul>
			<ul id="ossvn-checkbox-general" class="uk-switcher uk-margin">
				<li>
					<div class="ossvn-title-group ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id"><?php _e('Title', 'wct');?></label>
						<?php self::wct_show_title_field('title', 'title');?>
					</div>
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id"><?php _e('Placeholder', 'wct');?></label>
						<?php self::wct_show_title_field('title', 'placeholder');?>
					</div>
					
					<label class="ossvn-label"><?php _e('Options', 'wct');?></label>
					<div class="ossvn-checkbox-option-display ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-checkbox-class"><?php _e('Use Image as placeholder', 'wct');?></label>
						<input type="checkbox" id="ossvn-checkbox-checkbox-class" name="block_checkbox_display" data-target="block_checkbox_display" class="ossvn-get-data" value="img">
						<textarea col="50" data-target="block_checkbox_options" class="ossvn-get-data"></textarea>
						<p><?php _e('Enter each choice on a new line.', 'wct');?><br><?php _e('For more control, you may specify both a value and label like this', 'wct');?>:</p>
						<p class="display-label"><?php _e('option-1 : Option 1', 'wct');?><br><?php _e('option-2 : Option 2', 'wct');?></p>
						<p class="display-img" style="display:none;"><?php _e('option-1 : url_for_image_1', 'wct');?><br><?php _e('option-2 : url_for_image_2', 'wct');?></p>
					</div>
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id-checkbox-1"><?php _e('Required', 'wct');?></label>
						<input type="checkbox" id="ossvn-checkbox-id-checkbox-1" data-target="block_required" class="ossvn-get-data"/>
					</div>
					<div class="ossvn-form-group show_if_custom_fields">
						<label class="ossvn-label" for="ossvn-checkbox-id-checkbox-2"><?php _e('Display in order recived page ', 'wct');?></label>
						<input type="checkbox" id="ossvn-checkbox-id-checkbox-2" data-target="block_display_order_recived" class="ossvn-get-data"/>
					</div>
					<div class="ossvn-form-group show_if_custom_fields">
						<label class="ossvn-label" for="ossvn-checkbox-id-checkbox-3"><?php _e('Display in email order  ', 'wct');?></label>
						<input type="checkbox" id="ossvn-checkbox-id-checkbox-3" data-target="block_display_email" class="ossvn-get-data"/>
					</div>

					<div class="ossvn-form-group show_if_custom_fields">
						<label class="ossvn-label" for="ossvn_display_account"><?php _e('Display in my accouny page  ', 'wct');?></label>
						<input type="checkbox" id="ossvn_display_account" data-target="block_display_account" class="ossvn-get-data"/>
						<input type="text" id="ossvn_display_account_title" name="ossvn_display_account_title" data-target="block_display_account_title" class="ossvn-get-data uk-hidden" />
					</div>

					<?php 
					if(class_exists('WooCommerce_PDF_Invoices')){
						require('wct-support-field-to-pdf-invoices-packing-slips.php');
					}
					?>

				</li>
				<li>
					
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-class"><?php _e('Custom class', 'wct');?></label>
						<input type="text" id="ossvn-checkbox-class"  data-target="ext_class" class="ossvn-get-data"/>
					</div>
					<div class="ossvn-price ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-modal-price"><?php _e('Price', 'wct');?></label>
						<input type="checkbox" id="ossvn-checkbox-modal-price"  data-target="block_price" class="ossvn-get-data" /><input type="text" id="ossvn-block-price-value"  data-target="block_price_value" class="ossvn-get-data" placeholder="Add price" style="display:none;margin-left:20px;"/>
					</div>

					<?php 
					/**
					* HTML conditional logic
					* @since 1.0
					*/
					require('wct-html-user-role-logic.php');
					/**
					* HTML user role logic
					* @since 1.0
					*/
					require('wct-html-conditional-logic.php');
					?>

				</li>
			</ul>
			<div class="ossvn-modal-footer">
				<button type="button" class="ossvn-save-col"><?php _e('Save changes', 'wct');?></button>
			</div>
		</div>		
    </div>
</div>