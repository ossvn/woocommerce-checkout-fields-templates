<?php
/**
 * Custom function for plugin
 *
 *
 * @package    woocommerce-checkout-templates
 * @subpackage woocommerce-checkout-templates/includes
 * @author     OSVN <contact@outsourcevietnam.co>
 * @coder Nam
 */
defined( 'ABSPATH' ) OR exit;

require(ABSPATH. 'wp-includes/pluggable.php');
/**
* Check value exists in array
* @since 1.0
*/ 
function in_array_r($needle, $haystack) {
    $found = false;
    foreach ($haystack as $item) {
    if ($item === $needle) { 
            $found = true; 
            break; 
        } elseif (is_array($item)) {
            $found = in_array_r($needle, $item); 
            if($found) { 
                break; 
            } 
        }    
    }
    return $found;
}

/**
* Check user role
* @since 1.0
*/
function wct_check_user_role( $role, $user_id = null ) {
 
    if ( is_numeric( $user_id ) )
    $user = get_userdata( $user_id );
    else
        $user = wp_get_current_user();
 
    if ( empty( $user ) )
    return false;
 
    return in_array( $role, (array) $user->roles );
}

/**
* Queue some JavaScript code to be output in the footer.
*
* @param string $code
* @author Comfythemes
* @since 1.2
*/
function wct_enqueue_js( $code ) {
    global $wct_queued_js;

    if ( empty( $wct_queued_js ) ) {
        $wct_queued_js = '';
    }

    $wct_queued_js .= "\n" . $code . "\n";
}


/**
* Output any queued javascript code in the footer.
*
* @author Comfythemes
* @since 1.2
*/
function wct_print_js() {
    
    global $wct_queued_js;

    if ( ! empty( $wct_queued_js ) ) {

        echo "<!-- ". WCT_NAME ." JavaScript -->\n<script type=\"text/javascript\">\njQuery(function($) {";

        // Sanitize
        $wct_queued_js = wp_check_invalid_utf8( $wct_queued_js );
        $wct_queued_js = preg_replace( '/&#(x)?0*(?(1)27|39);?/i', "'", $wct_queued_js );
        $wct_queued_js = str_replace( "\r", '', $wct_queued_js );

        echo $wct_queued_js . "});\n</script>\n";

        unset( $wct_queued_js );
    }
}
add_action( 'wp_footer', 'wct_print_js', 25 );

?>