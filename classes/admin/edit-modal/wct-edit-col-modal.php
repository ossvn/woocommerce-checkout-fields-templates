<?php 
/**
 * Modal edit column
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
/*=====get template active*/
$template_active = get_option('template_active');
?>
<div id="ossvn-template-col" class="hidden">
	<div class="ossvn-col ossvn-col-12 ossvn-new-col ossvn-empty">
		<div class="ossvn-row-controls">
			<div  class="ossvn-drag ossvn-drag-col ossvn-row-control"><i class="fa fa-arrows" title="<?php _e('Drag this column', 'wct');?>"></i></div>
			<button type="button" class="ossvn-edit-col ossvn-row-control" data-uk-modal="{target:'#ossvn-edit-col-modal'}"><i class="fa fa-pencil" title="<?php _e('Edit this column', 'wct');?>"></i></button>
			<button type="button" class="ossvn-style ossvn-row-control" data-uk-modal="{target:'#ossvn-style-modal'}"><i class="fa fa-paint-brush" title="<?php _e('Style this column', 'wct');?>"></i></button>
			<button type="button" class="ossvn-add-row ossvn-row-control"><i class="fa fa-plus" title="<?php _e('Add new row', 'wct');?>"></i></button>
			<button type="button" class="ossvn-delete-col ossvn-row-control"><i class="fa fa-trash" title="<?php _e('Delete this column', 'wct');?>"></i></button>
		</div>
	</div>
</div><!--/#ossvn-template-col -->

<!-- col-modal -->
<div id="ossvn-edit-col-modal" class="ossvn-modal uk-modal">
	<div class="uk-modal-dialog ossvn-modal-box">
		<div class="ossvn-modal-header">
			<i class="fa fa-pencil-square-o"></i><?php _e('Edit', 'wct');?>
			<a class="uk-modal-close uk-close ossvn-modal-close"></a>
		</div>
		<div class="ossvn-modal-body uk-form">
			<div class="ossvn-form-group">
				<label class="ossvn-label" for="ossvn-select-id"><?php _e('Id', 'wct');?>:</label>
				<input type="text" id="ossvn-select-id"  data-target="col_id" class="ossvn-get-data" />
			</div>
			<div class="ossvn-form-group">
				<label class="ossvn-label" for="ossvn-select-class"><?php _e('Extra Class', 'wct');?>:</label>
				<input type="text" id="ossvn-select-class"  data-target="col_extra_class" class="ossvn-get-data" />
			</div>

			<?php 
			if($template_active == '1'|| $template_active == '2'):
			?>
			<div class="ossvn-form-group">
				<label class="ossvn-label" for="row_display"><?php _e('Type', 'wct');?>:</label>
				<select id="col_display" data-target="col_display" class="ossvn-get-data form-control">
					<option value=""><?php _e('Col', 'wct');?></option>
					<option value="step"><?php _e('Step bar', 'wct');?></option>
				</select>
			</div>
			<?php endif;?>


			<div class="ossvn-form-group div-display-default">
				<label class="ossvn-label" for="ossvn-select-edit-col-width"><?php _e('Width', 'wct');?>:</label>
				<select id="ossvn-select-edit-col-width" class="ossvn-select-col-width form-control">
					<option value="ossvn-col-1"><?php _e('Width 1/12', 'wct');?></option>
					<option value="ossvn-col-2"><?php _e('Width 2/12', 'wct');?></option>
					<option value="ossvn-col-3"><?php _e('Width 3/12', 'wct');?></option>
					<option value="ossvn-col-4"><?php _e('Width 4/12', 'wct');?></option>
					<option value="ossvn-col-5"><?php _e('Width 5/12', 'wct');?></option>
					<option value="ossvn-col-6"><?php _e('Width 6/12', 'wct');?></option>
					<option value="ossvn-col-7"><?php _e('Width 7/12', 'wct');?></option>
					<option value="ossvn-col-8"><?php _e('Width 8/12', 'wct');?></option>
					<option value="ossvn-col-9"><?php _e('Width 9/12', 'wct');?></option>
					<option value="ossvn-col-10"><?php _e('Width 10/12', 'wct');?></option>
					<option value="ossvn-col-11"><?php _e('Width 11/12', 'wct');?></option>
					<option value="ossvn-col-12"><?php _e('Width 12/12', 'wct');?></option>
				</select>
			</div>
			
			<div class="ossvn-modal-footer">
				<button type="button" class="ossvn-save-col"><?php _e('Save changes', 'wct');?></button>
			</div>
		</div>		
    </div>
</div><!--/#ossvn-edit-col-modal -->