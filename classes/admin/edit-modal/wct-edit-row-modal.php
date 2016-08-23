<?php 
/**
 * Modal edit row
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
<?php $template_active = get_option('template_active');?>
<!--#ossvn-template-row-->
<div id="ossvn-template-row" class="hidden">
	<div class="ossvn-row ossvn-empty drag-level-1 ossvn-new-row">
		<div class="ossvn-row-controls">
			<div class="ossvn-drag ossvn-drag-row ossvn-row-control"><i class="fa fa-arrows" title="<?php _e('Drag this row', 'wct');?>"></i></div>
			<div class="ossvn-edit-row ossvn-row-control"><i class="fa fa-align-justify" title="<?php _e('Edit this row', 'wct');?>"></i></div>
			<button type="button" class="ossvn-edit-row-display ossvn-row-control" data-uk-modal="{target:'#ossvn-edit-row-display'}"><i class="fa fa-pencil" title="<?php _e('Display options', 'wct');?>"></i></button>
			<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:'#ossvn-style-modal'}"><i class="fa fa-paint-brush" title="<?php _e('Style this row', 'wct');?>"></i></button>
			<button type="button" class="ossvn-add-col ossvn-row-control"><i class="fa fa-plus" title="<?php _e('Add new column', 'wct');?>"></i></button>
			<button type="button" class="ossvn-delete-row ossvn-row-control"><i class="fa fa-trash" title="<?php _e('Delete this row', 'wct');?>"></i></button>
			<div class="ossvn-row-templates">
				<button type="button" data-template="ossvn-col-12" class="ossvn-row-template ossvn-row-template-1"></button>
				<button type="button" data-template="ossvn-col-6 ossvn-col-6" class="ossvn-row-template ossvn-row-template-2"></button>
				<button type="button" data-template="ossvn-col-8 ossvn-col-4" class="ossvn-row-template ossvn-row-template-3"></button>
				<button type="button" data-template="ossvn-col-4 ossvn-col-4 ossvn-col-4" class="ossvn-row-template ossvn-row-template-4"></button>
				<button type="button" data-template="ossvn-col-3 ossvn-col-3 ossvn-col-3 ossvn-col-3" class="ossvn-row-template ossvn-row-template-5"></button>
				<button type="button" data-template="ossvn-col-3 ossvn-col-9" class="ossvn-row-template ossvn-row-template-6"></button>
				<button type="button" data-template="ossvn-col-3 ossvn-col-6 ossvn-col-3" class="ossvn-row-template ossvn-row-template-7"></button>
				<button type="button" data-template="ossvn-col-10 ossvn-col-2" class="ossvn-row-template ossvn-row-template-8"></button>
				<button type="button" data-template="ossvn-col-2 ossvn-col-2 ossvn-col-2 ossvn-col-2 ossvn-col-2 ossvn-col-2" class="ossvn-row-template ossvn-row-template-9"></button>
				<button type="button" data-template="ossvn-col-2 ossvn-col-8 ossvn-col-2" class="ossvn-row-template ossvn-row-template-10"></button>
				<button type="button" data-template="ossvn-col-2 ossvn-col-2 ossvn-col-2 ossvn-col-6" class="ossvn-row-template ossvn-row-template-11"></button>
				<button type="button" class="ossvn-row-custom" data-uk-modal="{target:'#ossvn-template-custom-modal'}"><i class="fa fa-plus"></i></button>
			</div>
		</div>
	</div>
</div>
<!--END #ossvn-template-row-->

<!--#ossvn-edit-row-display-->
<div id="ossvn-edit-row-display" class="ossvn-modal uk-modal">
	<div class="uk-modal-dialog ossvn-modal-box">
		<div class="ossvn-modal-header">
			<i class="fa fa-pencil-square-o"></i><?php _e('Edit', 'wct');?>
			<a class="uk-modal-close uk-close ossvn-modal-close"></a>
		</div>
		<div class="ossvn-modal-body uk-form">
			<div class="ossvn-form-group">
				<label class="ossvn-label" for="ossvn-select-id"><?php _e('Id', 'wct');?></label>
				<input type="text" id="ossvn-select-id"  data-target="row_id" class="ossvn-get-data" />
			</div>
			<div class="ossvn-form-group">
				<label class="ossvn-label" for="ossvn-select-id"><?php _e('Class', 'wct');?></label>
				<input type="text" id="ossvn-select-id"  data-target="row_class" class="ossvn-get-data" />
			</div>

			<div class="ossvn-form-group">
				<label class="ossvn-label" for="row_display"><?php _e('Type', 'wct');?></label>
				
				<?php if( $template_active == '1' || $template_active == '2'):?>
					<select id="row_display" data-target="row_display" class="ossvn-get-data form-control">
						<option value=""><?php _e('Row', 'wct');?></option>
						<option value="form_checkout"><?php _e('Form checkout', 'wct');?></option>
						<option value="account_step"><?php _e('Account step', 'wct');?></option>
						<option value="billing_step"><?php _e('Billing step', 'wct');?></option>
						<option value="shipping_step"><?php _e('Shipping step', 'wct');?></option>
						<option value="order_step"><?php _e('Your order step', 'wct');?></option>
						<?php if( $template_active == '2' ):?>
						<option value="order_success"><?php _e('Order success step', 'wct');?></option>
						<?php endif;?>
						<option value="custom_step"><?php _e('Custom step', 'wct');?></option>
					</select>
				<?php else:?>
					<select id="row_display" data-target="row_display" class="ossvn-get-data form-control">
						<option value=""><?php _e('Row', 'wct');?></option>
						<option value="form_checkout"><?php _e('Form checkout', 'wct');?></option>
						<option value="account"><?php _e('Account block', 'wct');?></option>
						<option value="billing"><?php _e('Billing block', 'wct');?></option>
						<option value="shipping"><?php _e('Shipping block', 'wct');?></option>
						<option value="order"><?php _e('Your order block', 'wct');?></option>
					</select>
				<?php endif;?>
			</div>

			<div class="ossvn-form-group ossvn-form-row-display uk-hidden">
				<label class="ossvn-label" for="row_display"><?php _e('Row display', 'wct');?></label>
				<select id="row_type_display" data-target="row_type_display" class="ossvn-get-data form-control">
					<option value=""><?php _e('Default', 'wct');?></option>
					<option value="accordion"><?php _e('Accordion', 'wct');?></option>
				</select>
			</div>

			<div class="ossvn-form-group ossvn-form-row-display uk-hidden">
				<label class="ossvn-label" for="row_display"><?php _e('Title', 'wct');?></label>
				<input type="text" data-target="row_accordion_title" class="ossvn-get-data">
			</div>
			<?php if( $template_active == '1' ):?>
			<div class="ossvn-form-group ossvn-form-row-display uk-hidden">
				<label class="ossvn-label" for="row_display"><?php _e('Step color', 'wct');?></label>
				<input type="color" data-target="step_color" class="ossvn-get-data">
			</div>
			<?php endif;?>

			<?php if( $template_active == '2' ):?>
			<div class="ossvn-form-group show_if_custom_fields">
				<label class="ossvn-label" for="step_icon_display"><?php _e('Display step icon  ', 'wct');?></label>
				<input type="checkbox" id="step_icon_display" data-target="step_icon_display" class="ossvn-get-data"/>
			</div>
			<div class="ossvn-form-group ossvn-form-row-display uk-hidden">
				<label class="ossvn-label" for="step_icon"><?php _e('Step icon', 'wct');?></label>
				<select id="step_icon" data-target="step_icon" data-placeholder="<?php esc_html_e('Choose an icon...', 'wct');?>" class="ossvn-get-data icon-select" style="width:350px;" tabindex="2">
					<option value=""><?php esc_html_e('Choose an icon...', 'wct');?></option>
					<?php
					$json_url = WCT_URL. '/classes/admin/edit-modal/wct-font-awesome.json'; 
					$response = wp_remote_get($json_url);
					$output = json_decode( $response['body'] );
					if( isset($output->icons) && !empty($output->icons) ){

						foreach ($output->icons as $icon) {
							echo '<option value="'.esc_attr( str_replace( 'fa ', '', $icon ) ).'">'.esc_html($icon).'</option>';
						}

					}
					?>
				</select>
				<i id="step_icon_preview"></i>
			</div>
			<?php endif;?>


			<div class="ossvn-modal-footer">
				<button type="button" class="ossvn-save-col"><?php _e('Save changes', 'wct');?></button>
			</div>
		</div>		
    </div>
</div>
<!--End #ossvn-edit-row-display-->