<?php
/**
 * Checkout login form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
	return '';
}
?>
<div class="ossvn-login-block">
	<h4><?php _e('Login', 'wct');?></h4>
	<?php do_action( 'woocommerce_login_form_start' ); ?>
	<div class="login">
		<p><?php _e('If you have shopped with us before, please enter your details in the boxes below. If you are a new customer please proceed to the Billing & Shipping section.', 'wct');?></p>
		<p class="form-row form-row-first">
			<label for="username"><?php _e('Username', 'wct');?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="wct_username" id="username">
		</p>
		<p class="form-row form-row-last">
			<label for="password"><?php _e('Password', 'wct');?> <span class="required">*</span></label>
			<input class="input-text" type="password" name="wct_password" id="password">
		</p>
		<div class="clear"></div>
		<?php do_action( 'woocommerce_login_form' ); ?>
		<p class="form-row">
			<?php wp_nonce_field( 'wct-login' ); ?>
			<input type="hidden" name="redirect" value="<?php echo esc_url( get_permalink(get_option( 'woocommerce_checkout_page_id' )) ) ?>" />
			<input type="submit" class="button" name="wct_login" value="Login">
			<label for="rememberme" class="inline">
				<input name="wct_rememberme" type="checkbox" id="rememberme" value="forever"> <?php _e('Remember me', 'wct');?>
			</label>
			<a class="lost_password" href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e('Forgot your password?', 'wct');?></a>
		</p>
		<div class="clear"></div>
	</div>
	<?php do_action( 'woocommerce_login_form_end' ); ?>
</div><!--/.ossvn-login-block-->
