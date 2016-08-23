<?php
/**
 * Field additional template.
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
if (isset($_POST['wct-save']) && !empty($_POST['wct-save'])){
	if (!wp_verify_nonce($_POST['save-wct'], 'init-save-settings'))
	{
	    wp_die('Something go wrong!');
	}
	update_option('wct_add_field', $_POST);
}
$wct_addfield_option = get_option('wct_add_field');
?>
<div class="additional-semi">

	<table class="widefat wct-table" border="1" >
		<thead>
			<tr>
				<th>	
					<span style="width:5%"><?php _e('Section Name', 'wct');  ?></span>
					<input style="width:70%" type="text" name="wct_addfield_section_name" value="<?php if(!empty($wct_addfield_option['wct_addfield_section_name'])){echo esc_attr( $wct_addfield_option['wct_addfield_section_name'] );}else{echo __('Additional Information', 'wct');} ?>" />
				</th>	
				<th style="text-align:center;">
					<input style="float: center;margin-left: 0;" name="wct_addfield_checkout_page" type="checkbox" value="true" <?php echo (isset($wct_addfield_option['wct_addfield_checkout_page'])) ? "checked='checked'": ""; ?> />
				</th>
				<th><?php _e('Checkout Page', 'wct');  ?></th>
				<th style="text-align:center;">
					<input style="float: center;margin-left: 0;" name="wct_addfield_checkout_detail" type="checkbox" value="true" <?php echo (isset($wct_addfield_option['wct_addfield_checkout_detail'])) ? "checked='checked'": ""; ?> />
				</th>
				<th><?php _e('Checkout Details and Email Receipt', 'wct');  ?></th>
			</tr>
		</thead>
	</table>

	<table class="widefat wct-table" border="1">
		<thead>
			<tr>
				<th style="width:3%;" class="wct-order" title="<?php esc_attr_e( 'Change order' , 'wct' ); ?>">#</th>
				<th><?php _e('Label' , 'wct' ); ?></th>
				<th><?php _e('Placeholder' , 'wct' ); ?></th>
				<th><?php _e('Option' , 'wct' ); ?></th>
				<th width="10%"><?php _e('Choose Type' , 'wct' ); ?></th>
				<th width="5%"><?php _e('Required' , 'wct' ); ?></th>
				<th width="3%" style="text-align:center;font-weight: bold;font-size: 20px;color: #a00;" scope="col" title="<?php esc_attr_e( 'Remove button', 'wct' ); ?>">&times;</th>		
			</tr>
		</thead>
		<tbody>
			<?php 
			if(isset($wct_addfield_option['wct_addfield'][1]['label']) && !empty($wct_addfield_option['wct_addfield'][1]['label'])):
				for($ii = 1; $ii < count($wct_addfield_option['wct_addfield']); $ii++){
					if(!empty($wct_addfield_option['wct_addfield'][$ii]['label'])){
			?>
						<tr valign="top" class="wct-row">
							<td class="wct-order" title="<?php esc_attr_e( 'Change order' , 'wct' ); ?>"><?php echo $ii; ?></td>
							<td><input type="text" class="wct-field" name="wct_addfield[<?php echo $ii; ?>][label]" value="<?php if(!empty($wct_addfield_option['wct_addfield'][$ii]['label'])){echo esc_attr($wct_addfield_option['wct_addfield'][$ii]['label']);}?>"/></td>
							<td><input type="text" class="wct-field" name="wct_addfield[<?php echo $ii; ?>][placeholder]" value="<?php if(!empty($wct_addfield_option['wct_addfield'][$ii]['placeholder'])){echo esc_attr($wct_addfield_option['wct_addfield'][$ii]['placeholder']);}?>"/></td>
							<td>
								<textarea class="wct-field" name="wct_addfield[<?php echo $ii; ?>][option]"><?php if(!empty($wct_addfield_option['wct_addfield'][$ii]['option'])){echo esc_textarea($wct_addfield_option['wct_addfield'][$ii]['option']);}?></textarea>
							</td>
							<td>
								<select class="wct-field" name="wct_addfield[<?php echo $ii; ?>][type]" >
									<option value="text" <?php echo (isset($wct_addfield_option['wct_addfield'][$ii]['type']) && $wct_addfield_option['wct_addfield'][$ii]['type'] == 'text') ? "selected='selected'": ""; ?>><?php _e('Text', 'wct');?></option>
									<option value="select" <?php echo (isset($wct_addfield_option['wct_addfield'][$ii]['type']) && $wct_addfield_option['wct_addfield'][$ii]['type'] == 'select') ? "selected='selected'": ""; ?>><?php _e('Select', 'wct');?></option>
									<option value="multi-select" <?php echo (isset($wct_addfield_option['wct_addfield'][$ii]['type']) && $wct_addfield_option['wct_addfield'][$ii]['type'] == 'multi-select') ? "selected='selected'": ""; ?>><?php _e('Multi Select', 'wct');?></option>
									<option value="checkbox" <?php echo (isset($wct_addfield_option['wct_addfield'][$ii]['type']) && $wct_addfield_option['wct_addfield'][$ii]['type'] == 'checkbox') ? "selected='selected'": ""; ?>><?php _e('Checkbox', 'wct');?></option>
									<option value="radio" <?php echo (isset($wct_addfield_option['wct_addfield'][$ii]['type']) && $wct_addfield_option['wct_addfield'][$ii]['type'] == 'radio') ? "selected='selected'": ""; ?>><?php _e('Radio', 'wct');?>Radio</option>
									<option value="textarea" <?php echo (isset($wct_addfield_option['wct_addfield'][$ii]['type']) && $wct_addfield_option['wct_addfield'][$ii]['type'] == 'textarea') ? "selected='selected'": ""; ?>><?php _e('Textarea', 'wct');?></option>
									<option value="email" <?php echo (isset($wct_addfield_option['wct_addfield'][$ii]['type']) && $wct_addfield_option['wct_addfield'][$ii]['type'] == 'email') ? "selected='selected'": ""; ?>><?php _e('Email', 'wct');?></option>
									<option value="number" <?php echo (isset($wct_addfield_option['wct_addfield'][$ii]['type']) && $wct_addfield_option['wct_addfield'][$ii]['type'] == 'number') ? "selected='selected'": ""; ?>><?php _e('Number', 'wct');?></option>
									<option value="date" <?php echo (isset($wct_addfield_option['wct_addfield'][$ii]['type']) && $wct_addfield_option['wct_addfield'][$ii]['type'] == 'date') ? "selected='selected'": ""; ?>><?php _e('Date Picker', 'wct');?></option>
									<option value="color" <?php echo (isset($wct_addfield_option['wct_addfield'][$ii]['type']) && $wct_addfield_option['wct_addfield'][$ii]['type'] == 'color') ? "selected='selected'": ""; ?>><?php _e('Color Picker', 'wct');?></option>    
								</select>
							</td>
							<td style="text-align:center;">
								<input class="wct-field" style="float:none;" name="wct_addfield[<?php echo $ii; ?>][required]" type="checkbox" title="<?php esc_attr_e( 'Add/Remove Required Attribute', 'wct' ); ?>" <?php echo (isset($wct_addfield_option['wct_addfield'][$ii]['required']) && $wct_addfield_option['wct_addfield'][$ii]['required'] == 'on') ? "checked='checked'": ""; ?>/>
							</td>
							<td class="wct-remove"><a style="color: #a00 !important;" class="wct-remove-button" href="javascript:;" title="<?php esc_attr_e( 'Remove Field' , 'wct' ); ?>">&times;</a></td>
						</tr>
					<?php }?>
				<?php }?>
			<?php endif;?>
			<!-- Empty -->
			<?php $i = 999; ?>
			<tr valign="top" class="wct-clone" >
				<td class="wct-order" title="<?php esc_attr_e( 'Change order' , 'wct' ); ?>"><?php echo $i; ?></td>
				<td><input type="text" class="wct-field" name="wct_addfield[<?php echo $i; ?>][label]" placeholder="<?php esc_attr_e( 'Label of the New Field', 'wct' ); ?>"/></td>
				<td><input type="text" class="wct-field" name="wct_addfield[<?php echo $i; ?>][placeholder]" placeholder="<?php esc_attr_e( 'Placeholder - Preview of Data to Input', 'wct' ); ?>"/></td>
				<td>
					<textarea class="wct-field" name="wct_addfield[<?php echo $i; ?>][option]"></textarea>
				</td>
				<td>
					<select class="wct-field" name="wct_addfield[<?php echo $i; ?>][type]" >
						<option value="text"><?php _e('Text', 'wct');?></option>
						<option value="select"><?php _e('Select', 'wct');?></option>
						<option value="multi-select"><?php _e('Multi Select', 'wct');?></option>
						<option value="checkbox"><?php _e('Checkbox', 'wct');?></option>
						<option value="radio"><?php _e('Radio', 'wct');?></option>
						<option value="textarea"><?php _e('Textarea', 'wct');?></option>
						<option value="email"><?php _e('Email', 'wct');?></option>
						<option value="number"><?php _e('Number', 'wct');?></option>
						<option value="date"><?php _e('Date Picker', 'wct');?></option>
						<option value="color"><?php _e('Color Picker', 'wct');?></option>    
					</select>
				</td>
				<td style="text-align:center;">
					<input class="wct-field" style="float:none;" name="wct_addfield[<?php echo $i; ?>][required]" type="checkbox" title="<?php esc_attr_e( 'Add/Remove Required Attribute', 'wct' ); ?>"/>
				</td>
				<td class="wct-remove"><a style="color: #a00 !important;" class="wct-remove-button" href="javascript:;" title="<?php esc_attr_e( 'Remove Field' , 'wct' ); ?>">&times;</a></td>
			</tr>
		</tbody>					
	</table>

	<div class="wct-table-footer">
		<a href="javascript:;" id="wct-add-button" class="button-secondary"><?php _e( '+ Add New Field' , 'wct' ); ?></a>
	</div>
</div>