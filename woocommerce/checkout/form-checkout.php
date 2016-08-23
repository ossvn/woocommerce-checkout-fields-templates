<?php 
/**
 * Checkout Form
 *
 * @author 		comfythemes
 * @package    woocommerce-checkout-templates
 * @subpackage woocommerce-checkout-templates/woocommerce/checkout
 * @author     OSVN <contact@outsourcevietnam.co>
 * @coder Nam
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}
?>
<div id="ossvn-wrapper">
	<div id="wct-woo-template">
		<div id="ossvn-main">
			<div class="ossvn-container">
				<div class="wct-message" style="display:none;"></div>
				<?php 
					$shortcode = get_option('template_shortcode');
					echo do_shortcode($shortcode);
				?>
			</div>
		</div>
	</div>
</div>