<?php 
/**
 * Settings fields compatible with WooCommerce PDF Invoices & Packing Slips plugin
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
<div class="ossvn-form-group ossvn-display-pdf-invoices" style="display:none;">
	<label class="ossvn-label ossvn-label-user-role" for="display_pdf_invoices"><?php _e('Display in PDF Invoices & Packing Slips plugin', 'wct');?></label>
	<input type="checkbox" id="display_pdf_invoices" name="display_pdf_invoices" data-target="display_pdf_invoices" class="ossvn-get-data ossvn-label-user-role"/>

	<div class="conditional hidden" data-cond-option="display_pdf_invoices" data-cond-value="on">
		<select id="display_pdf_invoices_position" data-target="display_pdf_invoices_position" class="ossvn-get-data">
			<option value="wpo_wcpdf_after_document_label"><?php _e('After the document label (Invoice, Packing Slip etc.)', 'wct');?></option>
			<option value="wpo_wcpdf_before_order_data"><?php _e('Before the order data (invoice number, order date, etc.)note that this is inside a table, and you should output the data as an html table row/cells', 'wct');?></option>
			<option value="wpo_wcpdf_after_order_data"><?php _e('After the order datanote that this is inside a table, and you should output the data as an html table row/cells', 'wct');?></option>
			<option value="wpo_wcpdf_before_order_details"><?php _e('Before the order details table with all items', 'wct');?></option>
			<option value="wpo_wcpdf_after_order_details"><?php _e('After the order details table', 'wct');?></option>
		</select>
	</div>
</div>