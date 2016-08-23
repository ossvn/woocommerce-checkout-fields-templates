<?php 
/**
 * Modal edit block: Order success
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
<div id="ossvn-edit-order-success-modal" class="ossvn-modal ossvn-block-modal uk-modal">
	<div class="uk-modal-dialog ossvn-modal-box">
		<div class="ossvn-modal-header">
			<i class="fa fa-pencil-square-o"></i><?php _e('Edit', 'wct');?>
			<a class="uk-modal-close uk-close ossvn-modal-close"></a>
		</div>
		<div class="ossvn-modal-body uk-form">
			<ul class="uk-tab" data-uk-switcher="{connect:'#ossvn-order-success-general'}">
			    <li class="uk-active"><a href=""><?php _e('General', 'wct');?></a></li>
			    <li><a href=""><?php _e('Advanced', 'wct');?></a></li>
			</ul>
			<ul id="ossvn-order-success-general" class="uk-switcher uk-margin">
				<li>
					<div class="ossvn-title-group ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id"><?php _e('Title', 'wct');?></label>
						<?php self::wct_show_title_field('title', 'title');?>
					</div>
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id"><?php _e('Content', 'wct');?></label>
						<textarea data-target="order_success_content" class="ossvn-get-data"></textarea>
					</div>
					
				</li>
				<li>
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-class"><?php _e('Class', 'wct');?></label>
						<input type="text" id="ossvn-checkbox-class"  data-target="class" class="ossvn-get-data" />
					</div>

				</li>
			</ul>
			<div class="ossvn-modal-footer">
				<button type="button" class="ossvn-save-col"><?php _e('Save changes', 'wct');?></button>
			</div>
		</div>		
    </div>
</div>