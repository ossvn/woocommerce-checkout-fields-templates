<?php 
/**
 * HTML conditional logic
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
<div id="block-cond-logic" class="ossvn-form-group ossvn-form-group-logic">
	<label class="ossvn-label ossvn-label-user-role" for="ossvn-checkbox-class"><?php _e('Enable conditional logic?', 'wct');?></label>
	<span class="wct_loading"></span>
	<input type="checkbox" name="block-cond-logic"  data-target="block_cond_logic" class="ossvn-get-data ossvn-checkbox-user-role" />
	<div class="conditional ossvn-conditional-logic hidden" data-cond-option="block-cond-logic" data-cond-value="on">
		<select data-target="block_cond_logic_show" class="ossvn-get-data">
			<option value=""><?php _e('Show', 'wct');?></option>
			<option value="hidden"><?php _e('Hidden', 'wct');?></option>
		</select> <?php _e('this field if', 'wct');?>
		<select data-target="block_cond_logic_all" class="ossvn-get-data">
			<option value=""><?php _e('All', 'wct');?></option>
			<option value="any"><?php _e('Any', 'wct');?></option>
		</select> <?php _e('of the following match.', 'wct');?><br><br>
		<div id="ossvn-form-group-logic-rule"></div>
		<a href="" class="submit-block-cond-logic"><?php _e('Add rule', 'wct');?></a>
	</div>
</div>

<div class="block-logic-product ossvn-form-group ossvn-form-group-logic-product show_if_custom_fields">
	
	<label class="ossvn-label ossvn-label-user-role" for="ossvn-checkbox-class"><?php _e('Enable conditional logic with product ID?', 'wct');?></label>
	<span class="wct_loading"></span>
	<input type="checkbox" name="block-cond-logic-product"  data-target="block_cond_logic_product" class="ossvn-get-data ossvn-checkbox-user-role" />
	
	<div class="conditional ossvn-conditional-logic-product hidden" data-cond-option="block-cond-logic-product" data-cond-value="on">
		<select data-target="block_cond_logic_product_show" class="ossvn-get-data">
			<option value=""><?php _e('Show', 'wct');?></option>
			<option value="hidden"><?php _e('Hidden', 'wct');?></option>
		</select> <?php _e('this field if', 'wct');?>
		<select data-target="block_cond_logic_product_all" class="ossvn-get-data">
			<option value=""><?php _e('All', 'wct');?></option>
			<option value="any"><?php _e('Any', 'wct');?></option>
		</select> <?php _e('of the following product in customer\'s cart.', 'wct');?><br><br>
		<div class="ossvn-form-group-logic-product-rule">
			<?php 
			$out = '';
			$args = array( 'post_type' => 'product', 'posts_per_page' => -1 );
			$products = new WP_Query($args);

				if( $products->have_posts() ){
					$out .= '<div class="add-block-cond-logic-product"><select name="block_logic_product" data-target="block_logic_product" class="ossvn-get-data">';
						$out .= '<option value="">'.esc_html__( 'Select product...', 'wct' ).'</option>';
						while( $products->have_posts() ){ $products->the_post();

							$out .= '<option value="'.esc_attr(get_the_ID()).'">'.esc_html( get_the_title() ).'</option>';

						}
					$out .= '</select><a href="#" class="remove-block-cond-logic-product"><i class="fa fa-times"></i></a></div>';
				}

			wp_reset_postdata();
			echo $out;
			?>
		</div>
		<a href="" class="submit-block-cond-logic-product"><?php _e('Add product', 'wct');?></a>
	</div>

</div>