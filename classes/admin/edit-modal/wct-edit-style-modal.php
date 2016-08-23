<?php 
/**
 * Modal edit style: row, col, block
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
<div id="ossvn-style-modal" class="ossvn-modal ossvn-styling-modal uk-modal">
	<div class="uk-modal-dialog ossvn-modal-box">
		<div class="ossvn-modal-header">
			<i class="fa fa-paint-brush"></i><?php _e('Styling', 'wct');?>
			<a class="uk-modal-close uk-close ossvn-modal-close"></a>
		</div>
		<div class="ossvn-modal-body uk-form">
			<div class="ossvn-row">
				<div class="ossvn-style-box ossvn-col-modal">
					<h4 class="ossvn-small-title"><?php _e('CSS', 'wct');?></h4>
					<div class="ossvn-style-margin">
						<input class="ossvn-get-data ossvn-margin-top ossvn-position-top ossvn-position-input" placeholder="-" name="ossvn-margin-top" data-target="ossvn_margin_top" />
						<input class="ossvn-get-data ossvn-margin-left ossvn-position-left ossvn-position-input" placeholder="-" name="ossvn-margin-left" data-target="ossvn_margin_left" />
						<input class="ossvn-get-data ossvn-margin-right ossvn-position-right ossvn-position-input" placeholder="-" name="ossvn-margin-right" data-target="ossvn_margin_right" />
						<input class="ossvn-get-data ossvn-margin-bottom ossvn-position-bottom ossvn-position-input" placeholder="-" name="ossvn-margin-bottom" data-target="ossvn_margin_bottom" />
						<div class="ossvn-style-border">
							<input class="ossvn-get-data ossvn-border-top ossvn-position-top ossvn-position-input" placeholder="-" name="ossvn-border-top" data-target="ossvn_border_top" />
							<input class="ossvn-get-data ossvn-border-left ossvn-position-left ossvn-position-input" placeholder="-" name="ossvn-border-left" data-target="ossvn_border_left" />
							<input class="ossvn-get-data ossvn-border-right ossvn-position-right ossvn-position-input" placeholder="-" name="ossvn-border-right" data-target="ossvn_border_right" />
							<input class="ossvn-get-data ossvn-border-bottom ossvn-position-bottom ossvn-position-input" placeholder="-" name="ossvn-border-bottom" data-target="ossvn_border_bottom" />
							<div class="ossvn-style-padding">
								<input class="ossvn-get-data ossvn-padding-top ossvn-position-top ossvn-position-input" placeholder="-" name="ossvn-padding-top" data-target="ossvn_padding_top" />
								<input class="ossvn-get-data ossvn-padding-left ossvn-position-left ossvn-position-input" placeholder="-" name="ossvn-padding-left" data-target="ossvn_padding_left" />
								<input class="ossvn-get-data ossvn-padding-right ossvn-position-right ossvn-position-input" placeholder="-" name="ossvn-padding-right" data-target="ossvn_padding_right" />
								<input class="ossvn-get-data ossvn-padding-bottom ossvn-position-bottom ossvn-position-input" placeholder="-" name="ossvn-padding-bottom" data-target="ossvn_padding_bottom" />
							</div>
						</div>
					</div>
				</div><!--/.ossvn-style-box -->
				<div class="ossvn-col-modal">
					<h4><?php _e('Design Options', 'wct');?></h4>
					<label class="ossvn-label-design"><?php _e('Border', 'wct');?></label>
					<div class="ossvn-design-group">
						<div class="ossvn-color">
							<input type="color" class="ossvn-color-input" /><input class="ossvn-color-text ossvn-get-data" type="text" data-target="border_color" placeholder="<?php _e('Select color', 'wct');?>">
						</div>
						<select name="border_style" class="ossvn-get-data" data-target="border_style">
							<option value=""><?php _e('Theme defaults', 'wct');?></option>
							<option value="solid"><?php _e('Solid', 'wct');?></option>
							<option value="dotted"><?php _e('Dotted', 'wct');?></option>
							<option value="dashed"><?php _e('Dashed', 'wct');?></option>
							<option value="none"><?php _e('None', 'wct');?></option>
							<option value="hidden"><?php _e('Hidden', 'wct');?></option>
							<option value="double"><?php _e('Double', 'wct');?></option>
							<option value="groove"><?php _e('Groove', 'wct');?></option>
							<option value="ridge"><?php _e('Ridge', 'wct');?></option>
							<option value="inset"><?php _e('Inset', 'wct');?></option>
							<option value="outset"><?php _e('Outset', 'wct');?></option>
							<option value="initial"><?php _e('Initial', 'wct');?></option>
							<option value="inherit"><?php _e('Inherit', 'wct');?></option>
						</select>
					</div>
					<label class="ossvn-label-design"><?php _e('Background', 'wct');?></label>
					<div class="ossvn-design-group">
						<div class="ossvn-color">
							<input type="color" class="ossvn-color-input" /><input class="ossvn-color-text ossvn-get-data" type="text" data-target="background_color" placeholder="<?php _e('Select color', 'wct');?>">
						</div>
					</div>
				</div>
			</div><!--/.ossvn-row -->
			<div class="ossvn-modal-footer">
				<button type="button" class="ossvn-save-col"><?php _e('Save changes', 'wct');?></button>
			</div>
		</div>		
    </div>
</div><!--/#ossvn-style-modal -->