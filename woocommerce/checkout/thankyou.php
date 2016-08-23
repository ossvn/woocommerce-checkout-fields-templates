<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="ossvn-wrapper">
	<div id="wct-woo-template">
		<div id="ossvn-main">
			<div class="ossvn-container">
				<div id="wct_order_success_steps">
					<?php
					/**
					* Get html steps
					* @since 1.3
					*/ 
					$steps = get_option('wct_save_steps_row_2');
					if( !empty($steps) ){
						echo wp_kses_post( $steps );
					}
					?>
				</div>
				<div id="wct_order_success_content"></div>
				<?php 
					$shortcode = get_option('template_shortcode');
					echo do_shortcode($shortcode);
				?>
				<div id="wct_action_thankyou" style="display:none;">
					<?php do_action( 'woocommerce_thankyou', get_query_var('order-received') ); ?>
				</div>
			</div>
		</div>
	</div>
</div>
