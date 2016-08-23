<?php
/**
 * Template settings template.
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
		<h3><?php _e('Template options', 'wct');?></h3>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="woocommerce_default_country">Base Location</label>
						<img class="help_tip" src="http://localhost/demo/wp-content/plugins/woocommerce/assets/images/help.png" height="16" width="16" data-tip="This is the base location for your business. Tax rates will be based on this country.">						
					</th>
					<td class="forminp">
						<select name="wct_template">
							<option value="1"><?php _e('1', 'wct');?></option>
							<option value="2"><?php _e('2', 'wct');?></option>
							<option value="3"><?php _e('3', 'wct');?></option>
							<option value="4"><?php _e('4', 'wct');?></option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>