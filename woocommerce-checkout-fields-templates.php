<?php 
/*
 * @wordpress-plugin
 * Plugin Name:       Woocommerce Checkout Fields & Templates
 * Plugin URI:        http://demo.comfythemes.com/wct/
 * Description:       Custom templates for woocommerce checkout page
 * Version:           1.2.4
 * Author:            Comfythemes
 * Author URI:        http://comfythemes.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wct
 * Domain Path:       /languages
 */
defined( 'ABSPATH' ) OR exit;


final class Woocommerce_Checkout_Fields_Templates
{

	/**
	* @var The single instance of the class
	* @author Comfythemes
	* @since 1.2
	*/
	protected static $_instance = null;

	/**
	* Main Plugin Instance
	*
	* Ensures only one instance of Plugin is loaded or can be loaded.
	*
	* @author Comfythemes
	* @since 1.2
	* @static
	* @return Main instance
	*/
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	* Plugin Constructor.
	*
	* @author Comfythemes
	* @since 1.2
	*/
	public function __construct() {
		
		$this->define_constants();
		$this->includes();
		$this->init_hooks();

	}

	/**
	* Check plugin Woocommerce is active.
	*
	* @author Comfythemes
	* @since 1.2
	*/
	public static function check_woo_active(){

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if (is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			return true;
		}else{
			return false;
		}
	}

	/**
	* Define Constants
	*
	* @author Comfythemes
	* @since 1.2
	*/
	private function define_constants() {
		
		$this->define('WCT_VER', '1.2');
		$this->define('WCT_NAME', __('Woocommerce checkout fields & templates', 'wct'));
		$this->define('WCT_FOLDER', basename(dirname(__FILE__)));
		$this->define('WCT_DIR', plugin_dir_path(__FILE__));
		$this->define('WCT_INC', WCT_DIR.'includes'.'/');
		$this->define('WCT_CLASS', WCT_DIR.'classes'.'/');
		$this->define('WCT_URL', plugin_dir_url(WCT_FOLDER).WCT_FOLDER.'/');
		$this->define('WCT_ADMIN_JS', WCT_URL.'assets/admin/scripts/');
		$this->define('WCT_ADMIN_CSS', WCT_URL.'assets/admin/styles/');
		$this->define('WCT_ADMIN_IMG', WCT_URL.'assets/admin/images/');
		$this->define('WCT_FRONTEND', WCT_URL. 'assets/front-end/');
		$this->define('WCT_FRONTEND_JS', WCT_URL. 'assets/front-end/scripts/');
		$this->define('WCT_FRONTEND_CSS', WCT_URL. 'assets/front-end/styles/');
		$this->define('WCT_FRONTEND_IMG', WCT_URL. 'assets/front-end/images/');
		$this->define('WCT_ASSETS_GLOBAL', WCT_URL. 'assets/global/');
	}


	/**
	* Define constant if not already set
	*
	* @param  string $name
	* @param  string|bool $value
	* @author Comfythemes
	* @since 1.2
	*/
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	* Include required core files used in admin and on the frontend.
	*
	* @author Comfythemes
	* @since 1.2
	*/
	public function includes() {

		if ( $this->check_woo_active() ) {
			
			/*
			* Backend
			*/
			include_once( WCT_CLASS. 'class_wct_admin.php' );
			include_once( WCT_CLASS. 'class_wct_widget.php' );

			/**
			* Functions for woocommerce.
			* @since    1.0
			*/
			include_once( WCT_CLASS. 'class_wct_woocommerce.php' );

			/*
			* Front end
			*/
			include_once( WCT_CLASS. 'class_wct_frontend.php' );
			include_once( WCT_CLASS. 'class_wct_shortcode.php' );
			include_once( WCT_CLASS. 'class_wct_depends_on.php' );

			/**
			* Custom functions 
			*/
			include_once( WCT_INC. 'wct_custom_functions.php' );

			/**
			* Make compatible with WooCommerce PDF Invoices & Packing Slips
			*/
			if (is_plugin_active( 'woocommerce-pdf-invoices-packing-slips/woocommerce-pdf-invoices-packingslips.php' ) ) {
				
				include_once( WCT_CLASS. 'class_wct_woocommerce_pdf_invoices.php' );

			}

		}

		
	}

	/**
	* Hook into actions and filters
	*
	* @author Comfythemes
	* @since 1.2
	*/
	private function init_hooks() {

		$path = dirname(plugin_basename(__FILE__)) . '/languages';
		load_plugin_textdomain('wct', false, $path);

		/**
		* The code that runs during plugin activation.
		* @since    1.0
		*/
		register_activation_hook(__FILE__, array( 'WCT_Admin', 'wct_active' ));

		/**
		* Ovrride template checkout
		*/
		if ( $this->check_woo_active() ) {
			add_filter( 'woocommerce_locate_template', array( $this, 'wct_override_checkout_template' ), 1, 3 );
		}else{
			add_action( 'admin_notices', array( $this, 'wct_installation_notice') );
		}

	}

	/**
	* Override default template checkout.
	* @since    1.0
	*/
	public function wct_override_checkout_template( $template, $template_name, $template_path ) {
		
	    $plugin_path  = untrailingslashit( plugin_dir_path( __FILE__ ) )  . '/woocommerce/';
		
		if($shortcode = get_option('template_shortcode')){

			if(strstr($template, 'form-checkout.php')){

		    	$template = $plugin_path . 'checkout/form-checkout.php';

		    }

		    if($template_active = get_option('template_active')){
		    	if($template_active == '2'){
			    	if(strstr($template, 'thankyou.php')){

				    	$template = $plugin_path . 'checkout/thankyou.php';

				    }
				}
		    }
		} 

		return $template;
	}

	/**
	* Display notice if woocommerce is not installed
	*
	* @author Comfythemes
	* @since 1.0
	*/
    public function wct_installation_notice() {
        echo '<div class="error" style="padding:15px; position:relative;"><a href="http://wordpress.org/plugins/woocommerce/">'.__('Woocommerce','wct').'</a>  must be installed and activated before using <strong>'.WCT_NAME.'</strong> plugin. </div>';
    }

}

/**
* Plugin load
*/
function WCFT_Load_Plugin() {
	return Woocommerce_Checkout_Fields_Templates::instance();
}
add_action( 'plugins_loaded', 'WCFT_Load_Plugin' );
?>