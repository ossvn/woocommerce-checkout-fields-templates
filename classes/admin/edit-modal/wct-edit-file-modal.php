<?php 
/**
 * Modal edit block: file
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
<div id="ossvn-edit-file-modal" class="ossvn-modal ossvn-block-modal uk-modal">
	<div class="uk-modal-dialog ossvn-modal-box">
		<div class="ossvn-modal-header">
			<i class="fa fa-pencil-square-o"></i><?php _e('Edit', 'wct');?>
			<a class="uk-modal-close uk-close ossvn-modal-close"></a>
		</div>
		<div class="ossvn-modal-body uk-form">
			<ul class="uk-tab" data-uk-switcher="{connect:'#ossvn-file-general'}">
			    <li class="uk-active"><a href=""><?php _e('General', 'wct');?></a></li>
			    <li><a href=""><?php _e('Advanced', 'wct');?></a></li>
			</ul>
			<ul id="ossvn-file-general" class="uk-switcher uk-margin">
				<li>
					<div class="ossvn-title-group ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id"><?php _e('Title', 'wct');?></label>
						<?php self::wct_show_title_field('file', 'title');?>
					</div>
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id"><?php _e('Placeholder', 'wct');?></label>
						<?php self::wct_show_title_field('file', 'placeholder');?>
					</div>
					
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-class"><?php _e('File allow', 'wct');?></label>
						<input type="text" id="ossvn-checkbox-class"  data-target="block_file_allow" class="ossvn-get-data" value="" placeholder="Ex: jpeg|jpg|png"/>
						<p class="ossvn-des"><?php _e('File allow for upload. EX: jpeg|jpg|png.', 'wct');?></p>
					</div>
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id-file-1"><?php _e('Required', 'wct');?></label>
						<input type="checkbox" id="ossvn-checkbox-id-file-1" data-target="block_required" class="ossvn-get-data"/>
					</div>
					<div class="ossvn-form-group show_if_custom_fields">
						<label class="ossvn-label" for="ossvn-checkbox-id-file-2"><?php _e('Display in order recived  ', 'wct');?></label>
						<input type="checkbox" id="ossvn-checkbox-id-file-2" data-target="block_display_order_recived" class="ossvn-get-data"/>
					</div>
					<div class="ossvn-form-group show_if_custom_fields">
						<label class="ossvn-label" for="ossvn-checkbox-id-file-3"><?php _e('Display in email order  ', 'wct');?></label>
						<input type="checkbox" id="ossvn-checkbox-id-file-3" data-target="block_display_email" class="ossvn-get-data"/>
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
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-class-file-1"><?php _e('Price', 'wct');?></label>
						<input type="checkbox" id="ossvn-checkbox-class-file-1"  data-target="block_price" class="ossvn-get-data" /><input type="text" id="ossvn-block-price-value"  data-target="block_price_value" class="ossvn-get-data" placeholder="Add price" style="display:none;margin-left:20px;"/>
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