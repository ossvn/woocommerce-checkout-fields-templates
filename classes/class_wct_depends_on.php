<?php 
/**
 * Logic fields
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
class WCT_Depends_On
{
	
	function __construct()
	{
		add_action( 'wp_footer', array($this, 'wct_add_block_logic_rule') );
		
		add_action('wp_ajax_wct_load_logic_cart', array($this, 'wct_logic_fields_by_productid_in_cart'));
		add_action('wp_ajax_nopriv_wct_load_logic_cart', array($this, 'wct_logic_fields_by_productid_in_cart'));
	}

	/**
	* Printf block conditional logic rule
	* @return json
	* @since 1.0
	*/
	public function wct_add_block_logic_rule(){
		
		$out = '';

		if($wct_logic_fields = get_option('_wct_logic_fields')){
			
			if(!empty($wct_logic_fields)):
			
				$out .= '<script type=\'text/javascript\'>';
					
					$out .= '(function($) { \'use strict\';';
					
						foreach ($wct_logic_fields as $key => $values) {
								
							if($values['status'] == 'on'):

								$out .= $this->wct_depends_on_display( $values['all_any'], $key, $values['fields'], $values['show_hide'] );
							
							endif;//end check status is on

						}//endforeach

					$out .= ' } )(jQuery);';

				$out .= '</script>';

			endif;
			
		}

		echo $out;
	}

	/**
	* Display logic field with all or any field
	* Param 1: $type - all/any
	* Param 2: $key - block id
	* Param 3: $value - array() - list all rule
	* Param 4: $all_any - all/any
	* @return js
	* @since 1.0
	*/
	private function wct_depends_on_display( $type = null, $key, $values = array(), $all_any ){

		$out = '';

		$out .= 'if($(\'#'.esc_attr($key).'_field\').length){ ';

			if( isset($type) && $type == 'any' ){

				$out .= '$(\'#'.esc_attr($key).'_field\').dependsOn({';
					
					$i = 0;

					foreach($values as $val){ 

						$value = $val['logic_field_is_value'];

						if($i == 0){

							if( $this->wct_check_prefix_in_block_id( $val['logic_field'] ) ){
								$out .= '\'#'.esc_attr($val['logic_field']).'_field .ossvn-block-field\': {';
							}else{
								$out .= '\'#'.esc_attr($val['logic_field']).'\': {';
							}

								$out .= $this->wct_depends_on_qualifiers( $val['logic_field_is'], $value );

							$out .= '},';
						}

						$i++;
					}

				$out .= '}';

				if($all_any == 'hide'){
					$out .= ',{toggleClass: \'wct-disabled\', hide: false}';
				}	

				if( count($values) > 1 ){

					$out .= ')';
						
						$ii = 0;

						foreach($values as $val){ 

							if($ii != 0){
								
								if( $this->wct_check_prefix_in_block_id( $val['logic_field'] ) ){
									$out .= '\'#'.esc_attr($val['logic_field']).'_field .ossvn-block-field\': {';
								}else{
									$out .= '\'#'.esc_attr($val['logic_field']).'\': {';
								}

									$out .= $this->wct_depends_on_qualifiers( $val['logic_field_is'], $value );

								$out .= '}})';
							}
							$ii++;

						}

					$out .= ';';

				}else{

					$out .= ');';
				}

			}else{

				$out .= '$(\'#'.esc_attr($key).'_field\').dependsOn({';
					
					foreach($values as $val){ 

						$value = $val['logic_field_is_value'];

						if( $this->wct_check_prefix_in_block_id( $val['logic_field'] ) ){
							$out .= '\'#'.esc_attr($val['logic_field']).'_field .ossvn-block-field\': {';
						}else{
							$out .= '\'#'.esc_attr($val['logic_field']).'\': {';
						}

							$out .= $this->wct_depends_on_qualifiers( $val['logic_field_is'], $value );

						$out .= '},';
					}

				$out .= '}';

				if($all_any == 'hide'){
					$out .= ',{toggleClass: \'wct-disabled\', hide: false}';
				}

				$out .= ');';
			}

		$out .= ' }';

		return $out;

	}

	/**
	* Qualifiers dependsOn()
	* Param 1: $type - type dependsOn
	* Param 2: $value - value logic field
	* @return value
	* @since 1.0
	*/
	private function wct_depends_on_qualifiers($type, $value){

		$out = '';

		switch ( $type ) {

			case 'isnot':
				$out .= 'not: [\''.esc_attr($value).'\']';
				break;
			case 'contains':
				$out .= 'contains: [\''.esc_attr($value).'\']';
				break;
			case 'checked':
				$out .= 'checked: true, values: [\''.esc_attr($value).'\']';
				break;
			default:
				$out .= 'values: [\''.esc_attr($value).'\']';
				break;
		}

		return $out;
	}

	/**
	* Check prefix wct_ in string
	* @return true/false
	* @since 1.0
	*/

	private function wct_check_prefix_in_block_id($block_id){
		
		$prefix = 'wct_'; $status = false;
		
		if( substr( $block_id, 0, 4 ) == $prefix ){
			$status = true;
		}

		return $status;
	}

	/**
	* Logic fields by product ID
	*
	* @author Comfythemes
	* @since 1.3
	*/
	public function wct_logic_fields_by_productid_in_cart(){

		$status 			= array('status'=>'0', 'html' => '');
		$arr_cart 			= array();
		$products 			= array();
		$wct_logic_fields 	= get_option('_wct_logic_product_fields') ? get_option('_wct_logic_product_fields') : array();

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$arr_cart[] = $cart_item['product_id'];
		}

		if( isset($_POST['logic_status']) && !empty($_POST['logic_status']) && isset($_POST['block_id']) && !empty($_POST['block_id']) ){

			foreach ( $wct_logic_fields[$_POST['block_id']]['products'] as $value ) {
				$products[] = $value;
			}

			switch ( $_POST['logic_status'] ) {
				
				case 'show_any':
					if( array_diff($products, $arr_cart) ){
						$status['status'] = '1';
					}
					break;
				case 'hide_all':
					if( !array_diff($products, $arr_cart) && !array_diff($arr_cart, $products) ){
						$status['status'] = '1';
					}
					break;
				case 'hide_any':
					if( array_diff($products, $arr_cart) ){
						$status['status'] = '1';
					}
					break;
				default:
					if( !array_diff($products, $arr_cart) && !array_diff($arr_cart, $products) ){
						$status['status'] = '1';
					}
					break;

			}

			$status['html'] = array_diff($arr_cart, $products);

		}

		echo json_encode($status);
		exit();

	}

}

/**
* Run class
* 1.0
*/
new WCT_Depends_On();
?>