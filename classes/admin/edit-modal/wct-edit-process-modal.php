<?php 
/**
 * Modal edit process
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
<?php 
$template_active = get_option('template_active');
?>
<!-- ossvn-edit-step-modal -->
<div id="ossvn-edit-process-modal" class="ossvn-modal uk-modal ossvn-block-modal">
	<div class="uk-modal-dialog ossvn-modal-box">
		<div class="ossvn-modal-header">
			<i class="fa fa-pencil-square-o"></i><?php _e('Edit', 'wct');?>
			<a class="uk-modal-close uk-close ossvn-modal-close"></a>
		</div>
		<div class="ossvn-modal-body uk-form">

			<div class="ossvn-form-group">
				<label class="ossvn-label" for="ossvn-checkbox-fixed-process"><?php _e('Display fixed process bar?', 'wct');?></label>
				<input type="checkbox" id="ossvn_checkbox_fixed_process" data-target="block_fixed_process" class="ossvn-get-data"/>
			</div>

			<div class="ossvn-form-group">
				<label class="ossvn-label" for="ossvn_checkbox_fixed_process_position"><?php _e('Process bar position', 'wct');?></label>
				<select id="ossvn_checkbox_fixed_process_position" data-target="block_fixed_process_position" class="ossvn-get-data form-control">
					<option value=""><?php _e('Top', 'wct');?></option>
					<option value="bottom"><?php _e('Bottom', 'wct');?></option>
				</select>
			</div>

			<div class="ossvn-form-group">
				<label class="ossvn-label" for="ossvn_checkbox_fixed_process_styles"><?php _e('Process bar style', 'wct');?></label>
				<select id="ossvn_checkbox_fixed_process_styles" data-target="block_fixed_process_style" class="ossvn-get-data form-control">
					<option value=""><?php _e('Default', 'wct');?></option>
					<option value="ossvn-process-round"><?php _e('Round', 'wct');?></option>
					<option value="ossvn-process-line"><?php _e('Line', 'wct');?></option>
					<option value="ossvn-process-boostrap"><?php _e('Boostrap', 'wct');?></option>
					<option value="ossvn-3d-gradient"><?php _e('3D Gradient', 'wct');?></option>
					<option value="ossvn-simple-gradient"><?php _e('Simple Gradient', 'wct');?></option>
					<option value="ossvn-stripes-gradient"><?php _e('Striples', 'wct');?></option>
					<option value="ossvn-sparkle-gradient"><?php _e('Sparkle', 'wct');?></option>
				</select>
			</div>

			<div class="ossvn-modal-footer">
				<button type="button" class="ossvn-save-col"><?php _e('Save changes', 'wct');?></button>
			</div>
		</div>	

    </div>
</div><!--/#ossvn-edit-process-modal -->