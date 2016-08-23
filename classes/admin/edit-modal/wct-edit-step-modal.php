<?php 
/**
 * Modal edit step
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
<div id="ossvn-edit-step-modal" class="ossvn-modal uk-modal">
	<div class="uk-modal-dialog ossvn-modal-box">
		<div class="ossvn-modal-header">
			<i class="fa fa-pencil-square-o"></i><?php _e('Edit', 'wct');?>
			<a class="uk-modal-close uk-close ossvn-modal-close"></a>
		</div>
		<div class="ossvn-modal-body uk-form">
			
			<div class="ossvn-title-group ossvn-form-group">
				<label class="ossvn-label" for="ossvn-checkbox-id">
					<?php _e('Title', 'wct');?>:
				</label>
				<?php self::wct_show_title_field('title', 'title');?>
			</div>

			<?php if($template_active == '2'){?>
			<div class="ossvn-title-group ossvn-form-group">
				<label class="ossvn-label" for="ossvn-checkbox-id">
					<?php _e('Step number', 'wct');?>:
				</label>
				<input type="number" id="ossvn-checkbox-id" data-target="step_order" class="ossvn-get-data" />
			</div>
			<?php }?>

			<div class="ossvn-title-group ossvn-form-group">
				<label class="ossvn-label" for="ossvn-checkbox-id">
					<?php _e('ID step content', 'wct');?>:
				</label>
				<input type="text" id="ossvn-checkbox-id" data-target="step_id_content" class="ossvn-get-data" />
			</div>

			<?php if( $template_active == '1' ):?>
			<div class="ossvn-form-group">
				<label class="ossvn-label" for="row_display"><?php _e('Step color', 'wct');?></label>
				<input type="color" data-target="step_color" class="ossvn-get-data">
			</div>
			<?php endif;?>
			
			<div class="ossvn-modal-footer">
				<button type="button" class="ossvn-save-col"><?php _e('Save changes', 'wct');?></button>
			</div>
		</div>		
    </div>
</div><!--/#ossvn-edit-step-modal -->