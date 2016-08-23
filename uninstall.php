<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       http://demo.comfythemes.com/wct/
 * @since      1.0
 *
 * @package    woocommerce-checkout-templates
 * @subpackage woocommerce-checkout-templates/classes
 * @author     OSVN <contact@outsourcevietnam.co>
 * @coder Nam
 */
defined( 'ABSPATH' ) OR exit;

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}


/**
* Function remove data from plugin
* @since 1.0
*/
function wct_uninstall(){

	delete_option('template_active');
	delete_option('wct_admin_html_row');
	delete_option('template_shortcode');

	delete_option('wct_admin_html_row_1');
	delete_option('template_shortcode_1');

	delete_option('wct_admin_html_row_2');
	delete_option('template_shortcode_2');

	delete_option('wct_admin_html_row_3');
	delete_option('template_shortcode_3');

	delete_option('wct_admin_html_row_4');
	delete_option('template_shortcode_4');

	delete_option('wct_admin_html_row_5');
	delete_option('template_shortcode_5');

	delete_option('wct_admin_html_row_blank');
	delete_option('template_shortcode_blank');

	delete_option('wct_all_field');
	delete_option('_wct_logic_fields');
	delete_option('wct_product_tour_1');
	delete_option('wct_product_tour_2');
}
//remove data from plugin
wct_uninstall();
?>