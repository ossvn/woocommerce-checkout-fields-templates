<?php 
/**
 * Modal edit block: title
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
<div id="ossvn-edit-title-modal" class="ossvn-modal ossvn-block-modal uk-modal">
	<div class="uk-modal-dialog ossvn-modal-box">
		<div class="ossvn-modal-header">
			<i class="fa fa-pencil-square-o"></i><?php _e('Edit', 'wct');?>
			<a class="uk-modal-close uk-close ossvn-modal-close"></a>
		</div>
		<div class="ossvn-modal-body uk-form">
			<ul class="uk-tab" data-uk-switcher="{connect:'#ossvn-title-general'}">
			    <li class="uk-active"><a href=""><?php _e('General', 'wct');?></a></li>
			    <li><a href=""><?php _e('Advanced', 'wct');?></a></li>
			</ul>
			<ul id="ossvn-title-general" class="uk-switcher uk-margin">
				<li>
					<div class="ossvn-title-group ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id"><?php _e('Title', 'wct');?></label>
						<?php self::wct_show_title_field('title', 'title');?>
					</div>
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id"><?php _e('Placeholder', 'wct');?></label>
						<?php self::wct_show_title_field('title', 'placeholder');?>
					</div>
					
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id"><?php _e('Choose tag', 'wct');?></label>
						<select id="ossvn-select-dropdown-title" data-target="block_title_h" class="ossvn-get-data">
							<option value=""><?php _e('Choose', 'wct');?></option>
							<option value="h1"><?php _e('H1', 'wct');?></option>
							<option value="h2"><?php _e('H2', 'wct');?></option>
							<option value="h3"><?php _e('H3', 'wct');?></option>
							<option value="h4"><?php _e('H4', 'wct');?></option>
							<option value="h5"><?php _e('H5', 'wct');?></option>
							<option value="h6"><?php _e('H6', 'wct');?></option>
						</select>
					</div>
				</li>
				<li>
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-class"><?php _e('Custom class', 'wct');?></label>
						<input type="text" id="ossvn-checkbox-class"  data-target="ext_class" class="ossvn-get-data" />
					</div>
				</li>
			</ul>
			<div class="ossvn-modal-footer">
				<button type="button" class="ossvn-save-col"><?php _e('Save changes', 'wct');?></button>
			</div>
		</div>		
    </div>
</div>