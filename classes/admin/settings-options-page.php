<?php
/**
 * Main settings template.
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
<style>
#ossvn-admin-header h2 {
  text-transform: uppercase;
}
#overlay{display: none;background: #f0f0f0;position: absolute;width: 100%;height: 100%;z-index: 999;top: 0;left: 0;}
#overlay img{position: fixed;top:50%;left:50%;}
</style>
<div id="ossvn-wrapper">
	<form id="wct_choose_template" method="POST">
		<?php wp_nonce_field("init-save-settings", "save-wct") ?>
		<?php 
			if(isset($_GET['page']) && $_GET['page'] == 'wct-settings'){
				if(isset($_GET['step']) && $_GET['step'] == 2){
					require 'settings-template-step-2.php';
				}else{
					require 'settings-template-step-1.php';
				}
			}
		?>
	</form>
</div><!--/#ossvn-wrapper -->