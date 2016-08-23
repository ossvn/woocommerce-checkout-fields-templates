<?php
/**
 * Field shipping template.
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
	update_option('wct_shipping', $_POST);
}
$wct_shipping_options = get_option('wct_shipping');
?>
<table class="widefat shipping-wct-table" border="1">
	<thead>
        <tr>
            <th><?php _e('Field Name', 'wct');  ?></th>
            <th><?php _e('Remove Field Entirely', 'wct');  ?></th>		
            <th><?php _e('Remove Required Attribute', 'wct');  ?></th>
            <th class="wct_replace"><?php _e('Replace Label Name', 'wct');  ?></th>
            <th class="wct_replace"><?php _e('Replace Placeholder Name', 'wct');  ?></th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td><strong><?php _e('Select All Check boxes in this Column', 'wct');  ?></strong></td>
            <td><input name="wct_shipping_settings_rm" type="checkbox" id="select_all_rm" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_rm'])) ? "checked='checked'" : ""; ?> /></td>
            <td><input name="wct_shipping_settings_rq" type="checkbox" id="select_all_rq" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_rq'])) ? "checked='checked'" : ""; ?> /></td>
            <td></td>
            <td></td>
        </tr>
    </tbody><!--#check all-->

    <tbody>
        <tr>
            <td><?php _e('First Name', 'wct');  ?></td>
            <td><input name="wct_shipping_settings_fn_rm" type="checkbox" class="rm" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_fn_rm'])) ? "checked='checked'" : ""; ?>   /></td>
            <td><input name="wct_shipping_settings_fn_rq" type="checkbox" class="rq" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_fn_rq'])) ? "checked='checked'" : ""; ?> /></td>
            <td><input type="text" name="wct_shipping_settings_fn_lb" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_fn_lb'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_fn_lb'] );} ?>" /></td>
            <td><input type="text" name="wct_shipping_settings_fn_pl" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_fn_pl'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_fn_pl'] );} ?>" /></td>
        </tr>
    </tbody><!--#First Name-->

    <tbody>
        <tr>
            <td><?php _e('Last Name', 'wct');  ?></td>
            <td><input name="wct_shipping_settings_ln_rm" type="checkbox" class="rm" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_ln_rm'])) ? "checked='checked'" : ""; ?> /></td>
            <td><input name="wct_shipping_settings_ln_rq" type="checkbox" class="rq" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_ln_rq'])) ? "checked='checked'" : ""; ?> /></td>
            <td><input type="text" name="wct_shipping_settings_ln_lb" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_ln_lb'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_ln_lb'] );} ?>" /></td>
            <td><input type="text" name="wct_shipping_settings_ln_pl" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_ln_pl'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_ln_pl'] );} ?>" /></td>
        </tr>
    </tbody><!--#Last Name-->

    <tbody>
        <tr>
            <td><?php _e('Country', 'wct');  ?></td>
            <td><input name="wct_shipping_settings_country_rm" type="checkbox" class="rm" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_country_rm'])) ? "checked='checked'" : ""; ?> /></td>
            <td><input name="wct_shipping_settings_country_rq" type="checkbox" class="rq" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_country_rq'])) ? "checked='checked'" : ""; ?> /></td>
            <td><input type="text" name="wct_shipping_settings_country_lb" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_country_lb'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_country_lb'] );} ?>" /></td>
            <td></td>
        </tr>
    </tbody><!--#Country-->


    <tbody>
        <tr>
            <td><?php _e('Company', 'wct');  ?></td>
            <td><input name="wct_shipping_settings_company_rm" type="checkbox" class="rm" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_company_rm'])) ? "checked='checked'" : ""; ?> /></td>
            <td></td>
            <td><input type="text" name="wct_shipping_settings_company_lb" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_company_lb'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_company_lb'] );} ?>" /></td>
            <td><input type="text" name="wct_shipping_settings_company_pl" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_company_pl'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_company_pl'] );} ?>" /></td>
        </tr>
    </tbody><!--#Company-->

    <tbody>
        <tr>
            <td><?php _e('Address 1', 'wct');  ?></td>
            <td><input name="wct_shipping_settings_add1_rm" type="checkbox" class="rm" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_add1_rm'])) ? "checked='checked'" : ""; ?></td>
            <td><input name="wct_shipping_settings_add1_rq" type="checkbox" class="rq" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_add1_rq'])) ? "checked='checked'" : ""; ?> /></td>
            <td><input type="text" name="wct_shipping_settings_add1_lb" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_add1_lb'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_add1_lb'] );} ?>" /></td>
            <td><input type="text" name="wct_shipping_settings_add1_pl" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_add1_pl'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_add1_pl'] );} ?>" /></td>
        </tr>
    </tbody><!--#Address 1-->

    <tbody>
        <tr>
            <td><?php _e('Address 2', 'wct');  ?></td>
            <td><input name="wct_shipping_settings_add2_rm" type="checkbox" class="rm" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_add2_rm'])) ? "checked='checked'" : ""; ?></td>
            <td></td>
            <td><input type="text" name="wct_shipping_settings_add2_lb" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_add2_lb'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_add2_lb'] );} ?>" /></td>
            <td><input type="text" name="wct_shipping_settings_add2_pl" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_add2_pl'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_add2_pl'] );} ?>" /></td>
        </tr>
    </tbody><!--#Address 1-->

    <tbody>
        <tr>
            <td><?php _e('City', 'wct');  ?></td>
            <td><input name="wct_shipping_settings_city_rm" type="checkbox" class="rm" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_city_rm'])) ? "checked='checked'" : ""; ?> /></td>
            <td><input name="wct_shipping_settings_city_rq" type="checkbox" class="rq" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_city_rq'])) ? "checked='checked'" : ""; ?> /></td>
            <td><input type="text" name="wct_shipping_settings_city_lb" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_city_lb'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_city_lb'] );} ?>" /></td>
            <td><input type="text" name="wct_shipping_settings_city_pl" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_city_pl'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_city_pl'] );} ?>" /></td>
        </tr>
    </tbody><!--#City-->

    <tbody>
        <tr>
            <td><?php _e('Postal Code', 'wct');  ?></td>
            <td><input name="wct_shipping_settings_zip_rm" type="checkbox" class="rm" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_zip_rm'])) ? "checked='checked'" : ""; ?> /></td>
            <td><input name="wct_shipping_settings_zip_rq" type="checkbox" class="rq" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_zip_rq'])) ? "checked='checked'" : ""; ?> /></td>
            <td><input type="text" name="wct_shipping_settings_zip_lb" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_zip_lb'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_zip_lb'] );} ?>" /></td>
            <td><input type="text" name="wct_shipping_settings_zip_pl" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_zip_pl'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_zip_pl'] );} ?>" /></td>
        </tr>
    </tbody><!--#Postal Code-->

    <tbody>
        <tr>
            <td><?php _e('State', 'wct');  ?></td>
            <td><input name="wct_shipping_settings_state_rm" type="checkbox" class="rm" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_state_rm'])) ? "checked='checked'" : ""; ?> /></td>
            <td><input name="wct_shipping_settings_state_rq" type="checkbox" class="rq" value="1" <?php echo (isset($wct_shipping_options['wct_shipping_settings_state_rq'])) ? "checked='checked'" : ""; ?> /></td>
            <td><input type="text" name="wct_shipping_settings_state_lb" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_state_lb'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_state_lb'] );} ?>" /></td>
            <td><input type="text" name="wct_shipping_settings_state_pl" value="<?php if(!empty($wct_shipping_options['wct_shipping_settings_state_pl'])){echo esc_attr( $wct_shipping_options['wct_shipping_settings_state_pl'] );} ?>" /></td>
        </tr>
    </tbody><!--#State-->


</table>