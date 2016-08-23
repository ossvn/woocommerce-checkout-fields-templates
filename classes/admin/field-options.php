<?php
/**
 * Field template.
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
		<ul class="subsubsub" style="margin-bottom: 20px;">
			<li><a href="<?php echo admin_url( 'admin.php?page=wct-settings&tab=field-manager&section=billing' );?>" class="<?php if(isset($_GET['section'])){if($_GET['section'] == 'billing'){echo 'current';}}else{echo 'current';}?>"><?php _e('Billing Section', 'wct');?></a> | </li>
			<li><a href="<?php echo admin_url( 'admin.php?page=wct-settings&tab=field-manager&section=shipping' );?>" class="<?php if( isset($_GET['section']) && $_GET['section'] == 'shipping' ){echo 'current';}?>"><?php _e('Shipping Section', 'wct');?></a> | </li>
			<li><a href="<?php echo admin_url( 'admin.php?page=wct-settings&tab=field-manager&section=additional' );?>" class="<?php if( isset($_GET['section']) && $_GET['section'] == 'additional' ){echo 'current';}?>"><?php _e('Add Fields', 'wct');?></a></li>
		</ul>
		<?php
		/**
		* Set section for fields manager options page
		* @since 1.0
		*/ 
		if( isset($_GET['section']) && $_GET['section'] == 'shipping' ){

			/**
			* shipping manager
			*/
			require_once ('field-shipping-options.php');

		}elseif ( isset($_GET['section']) && $_GET['section'] == 'additional' ) {

			/**
			* additional manager
			*/
			require_once ('field-additional-options.php');

		}else{

			/**
			* billing manager
			*/
			require_once ('field-billing-options.php');

		}
		?>