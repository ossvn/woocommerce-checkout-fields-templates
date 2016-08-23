<?php 
/**
 * Make compatible with WooCommerce PDF Invoices & Packing Slips.
 *
 * @link       http://demo.comfythemes.com/wct/
 * @since      1.0
 *
 * @package    woocommerce-checkout-templates
 * @subpackage woocommerce-checkout-templates/classes
 * @author     wct <contact@outsourcevietnam.co>
 * @coder Nam
 */
defined( 'ABSPATH' ) OR exit;


/**
* 
*/
class WCT_WooCommerce_PDF_Invoices
{
	
	function __construct()
	{
		add_action('init', array(&$this, 'init'));
	}

	/**
	* Init
	* @since 1.0
	*/
	function init(){

		add_action( 'wpo_wcpdf_after_document_label', array( $this, 'wct_wpo_wcpdf_after_document_label' ), 10, 2 );
		add_action( 'wpo_wcpdf_before_order_data', array( $this, 'wct_wpo_wcpdf_before_order_data' ), 10, 2 );
		add_action( 'wpo_wcpdf_after_order_data', array( $this, 'wct_wpo_wcpdf_after_order_data' ), 10, 2 );
		add_action( 'wpo_wcpdf_before_order_details', array( $this, 'wct_wpo_wcpdf_before_order_details' ), 10, 2 );
		add_action( 'wpo_wcpdf_after_order_details', array( $this, 'wct_wpo_wcpdf_after_order_details' ), 10, 2 );
	}


	/**
	* Get all field display to invoices.
	* @return array()
	* @since 1.0
	*/
	public static function wct_get_field_add_to_invoices(){

		$fields = array();

		if($all_fields = get_option('wct_all_field')){
			
			if(!empty($all_fields)){

				foreach ($all_fields as $key => $value) {

					if($value['block_display_pdf_invoices'] == 'on'){

						if(isset($value['block_display_pdf_position']) && !empty($value['block_display_pdf_position'])){

							$fields[$value['block_id']] = array('title'=> $value['block_title'], 'position'=> $value['block_display_pdf_position']);
						}

					}
				}
			}
		}

		return $fields;
	}

	/**
	* Apply all field to invoices
	* @since 1.0
	*/
	public function wct_wpo_wcpdf_after_document_label($template_type, $order){
		
		$all_field = self::wct_get_field_add_to_invoices();
		if(!empty($all_field)):

			foreach ($all_field as $key => $value) {
				
				if($value['position'] == 'wpo_wcpdf_after_document_label'){
					echo self::wct_print_invoices_field( $key, $value['title'], $value['position'] );
				}

			}

		endif;
	}

	/**
	* Apply all field to invoices
	* Action: wpo_wcpdf_before_order_data
	* @since 1.0
	*/
	public function wct_wpo_wcpdf_before_order_data($template_type, $order){
		
		$all_field = self::wct_get_field_add_to_invoices();
		if(!empty($all_field)):
			foreach ($all_field as $key => $value) {
				if($value['position'] == 'wpo_wcpdf_before_order_data'){
					echo self::wct_print_invoices_field( $key, $value['title'], $value['position'] );
				}
			}
		endif;
	}

	/**
	* Apply all field to invoices
	* Action: wpo_wcpdf_after_order_data
	* @since 1.0
	*/
	public function wct_wpo_wcpdf_after_order_data($template_type, $order){
		
		$all_field = self::wct_get_field_add_to_invoices();
		if(!empty($all_field)):
			foreach ($all_field as $key => $value) {
				if($value['position'] == 'wpo_wcpdf_after_order_data'){
					echo self::wct_print_invoices_field( $key, $value['title'], $value['position'] );
				}
			}
		endif;
	}

	/**
	* Apply all field to invoices
	* Action: wpo_wcpdf_before_order_details
	* @since 1.0
	*/
	public function wct_wpo_wcpdf_before_order_details($template_type, $order){
		
		$all_field = self::wct_get_field_add_to_invoices();
		if(!empty($all_field)):
			foreach ($all_field as $key => $value) {
				if($value['position'] == 'wpo_wcpdf_before_order_details'){
					echo self::wct_print_invoices_field( $key, $value['title'], $value['position'] );
				}
			}
		endif;
	}

	/**
	* Apply all field to invoices
	* Action: wpo_wcpdf_after_order_details
	* @since 1.0
	*/
	public function wct_wpo_wcpdf_after_order_details($template_type, $order){
		
		$all_field = self::wct_get_field_add_to_invoices();
		if(!empty($all_field)):
			foreach ($all_field as $key => $value) {
				if($value['position'] == 'wpo_wcpdf_after_order_details'){
					echo self::wct_print_invoices_field( $key, $value['title'], $value['position'] );
				}
			}
		endif;
	}

	/**
	* Print value custom field to invoices
	* $block_id: field id
	* $block_title: field title
	* $position: action selected
	*
	* @since 1.0
	*/
	public static function wct_print_invoices_field($block_id, $block_title, $position){
		
		$out = '';

		global $wpo_wcpdf;

		switch ($position) {
			
			case 'wpo_wcpdf_before_order_details':
				?>
				<div class="custom-text">
					<?php echo esc_html($block_title);?>: <?php $wpo_wcpdf->custom_field($block_id); ?>
				</div>
				<?php
				break;
			
			case 'wpo_wcpdf_after_order_details':
				?>
				<div class="tax-exempt">
					<?php echo esc_html($block_title);?>: <?php $wpo_wcpdf->custom_field($block_id); ?>
				</div>
				<?php
				break;

			case 'wpo_wcpdf_after_document_label':
				?>
				<h2><strong><?php echo esc_html($block_title);?></strong>: <?php $wpo_wcpdf->custom_field($block_id); ?></h2>
				<?php
				break;
			case 'wpo_wcpdf_after_order_data':
				?>
				<tr class="delivery-date">
		            <th><?php echo esc_html($block_title);?>:</th>
		            <td><?php $wpo_wcpdf->custom_field($block_id); ?></td>
		        </tr>
				<?php
				break;
			
			default:
				?>
				<tr class="<?php echo sanitize_title($block_title);?>">
		            <th><?php echo esc_html($block_title);?>:</th>
		            <td><?php $wpo_wcpdf->custom_field($block_id); ?></td>
		        </tr>
				<?php
				break;
		}

		return $out;
	}
	
}

/**
* Run class
*/
new WCT_WooCommerce_PDF_Invoices();
?>