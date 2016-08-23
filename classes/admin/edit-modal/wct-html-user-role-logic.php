<?php 
/**
 * HTML user role logic
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
<div class="ossvn-form-group ossvn-form-group-user-role">
	<label class="ossvn-label ossvn-label-user-role" for="ossvn-checkbox"><?php _e('Hide/appear as user role', 'wct');?></label>
	<input type="checkbox" id="block-user-role-logic" name="block-user-logic"  data-target="block_user_logic" class="ossvn-get-data ossvn-checkbox-user-role" />
	<div class="conditional ossvn-conditional-logic hidden" data-cond-option="block-user-logic" data-cond-value="on">
		<select data-target="block_user_logic_show" class="ossvn-get-data">
			<option value=""><?php _e('Show', 'wct');?></option>
			<option value="hidden"><?php _e('Hidden', 'wct');?></option>
		</select> <?php _e('this field if user', 'wct');?>
		<select data-target="block_user_logic_logged" class="block_user_logic_logged ossvn-get-data">
			<option value=""><?php _e('Logged in', 'wct');?></option>
			<option value="not"><?php _e('Not logged in', 'wct');?></option>
		</select>

		<div class="ossvn-user-role-div" style="margin-top:10px;">
			<select name="block_user_logic_logged_role" data-target="block_user_logic_logged_role" class="ossvn-user-role-select ossvn-get-data" data-placeholder="<?php _e('Choose user role', 'wct');?>" multiple="multiple">
				<option value="all"><?php _e('All role', 'wct');?></option>
				<?php 
	            global $wp_roles;
	            $roles = $wp_roles->get_names();
	            foreach($roles as $role_key => $role_value) {
	            	if($role_key != 'administrator'){
	            ?>
	            <option value="<?php echo esc_attr($role_key);?>"><?php echo esc_html($role_value);?></option>
	            <?php }}?>
			</select>
		</div>
		
	</div>
</div>