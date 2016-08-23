<?php 
/**
 * Functions shortcode.
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
class WCT_Shortcode extends WCT_Admin 
{
	
	function __construct()
	{
		add_shortcode( 'wct_row', array( $this, 'wct_row' ) );
		add_shortcode( 'wct_row_inner', array( $this, 'wct_row' ) );
		add_shortcode( 'wct_col', array( $this, 'wct_col' ) );
		add_shortcode( 'wct_col_inner', array( $this, 'wct_col' ) );
		add_shortcode( 'wct_block', array( $this, 'wct_block' ) );
		add_shortcode( 'wct_html', array( $this, 'wct_html' ) );

		add_filter( 'no_texturize_shortcodes', array( $this, 'wct_shortcodes_to_exempt_from_wptexturize' ) );
	}

	/**
	* Output block with user logged in or not logged in
	* $out: output html
	* $args: array()
	* @since 1.0
	*/
	private function wct_output_block_with_user_role($output, $args){
		
		$defaults = array(
			'block_user_logic' => '',
			'block_user_logic_show' => '',
			'block_user_logic_logged' => '',
			'block_user_logic_logged_role' => array(),
			);

		$args = wp_parse_args( $args, $defaults );

		$html = '';

		if(isset($args['block_user_logic']) && $args['block_user_logic'] == 'on'){

			if(isset($atts['block_user_logic_show']) && $atts['block_user_logic_show'] == 'hidden'){
				
				if(isset($args['block_user_logic_logged']) && $args['block_user_logic_logged'] != 'not'){
					
					if(is_user_logged_in()){

						$user = wp_get_current_user();
						$current_role = $user->roles;
						
						array_push($args['block_user_logic_logged_role'], 'administrator');

						if(in_array($current_role[0], $args['block_user_logic_logged_role'])){

							$html .= '';

						}else{

							$html .= $output;

						}

					}else{
						$html .= $output;
					}

				}else{
					$html .= $output;	
				}

			}else{

				if(isset($args['block_user_logic_logged']) && $args['block_user_logic_logged'] != 'not'){
					
					if(is_user_logged_in()){

						$user = wp_get_current_user();
						$current_role = $user->roles;
						array_push($args['block_user_logic_logged_role'], 'administrator');
						
						if(in_array($current_role[0], $args['block_user_logic_logged_role'])){

							$html .= $output;

						}else{

							$html .= '';

						}

					}else{
						$html .= '';
					}

				}else{
					$html .= '';	
				}

			}

		}else{
			$html .= $output;
		}

		return $html;

	}


	/**
	* Print style
	* @since 1.0
	*/
	public function wct_print_style($args){
		$defaults = array(
			'ossvn_margin_top' => '',
			'ossvn_margin_left' => '',
			'ossvn_margin_right' => '',
			'ossvn_margin_bottom' => '',
			'ossvn_border_top' => '',
			'ossvn_border_left' => '',
			'ossvn_border_right' => '',
			'ossvn_border_bottom' => '',
			'ossvn_padding_top' => '',
			'ossvn_padding_left' => '',
			'ossvn_padding_right' => '',
			'ossvn_padding_bottom' => '',
			'border_color' => '',
			'border_style' => '',
			'background_color' => '',
			);
		$args = wp_parse_args( $args, $defaults );

		if(!empty($args['border_color'])){
			$border_color = $args['border_color'];
		}else{
			$border_color = '';
		}

		if(!empty($args['border_style'])){
			$border_style = $args['border_style'];
		}else{
			$border_style = '';
		}

		$out = '';

		if(!empty($args['ossvn_margin_top'])){
			$out .= 'margin-top: '.intval($args['ossvn_margin_top']).'px;';
		}else{
			$out .= '';
		}

		if(!empty($args['ossvn_margin_left'])){
			$out .= 'margin-left: '.intval($args['ossvn_margin_left']).'px;';
		}else{
			$out .= '';
		}

		if(!empty($args['ossvn_margin_right'])){
			$out .= 'margin-right: '.intval($args['ossvn_margin_right']).'px;';
		}else{
			$out .= '';
		}

		if(!empty($args['ossvn_margin_bottom'])){
			$out .= 'margin-bottom: '.intval($args['ossvn_margin_bottom']).'px;';
		}else{
			$out .= '';
		}

		if(!empty($args['ossvn_border_top'])){
			$out .= 'border-top: '.intval($args['ossvn_border_top']).'px '.$border_style.' '.$border_color.';';
		}else{
			$out .= '';
		}

		if(!empty($args['ossvn_border_left'])){
			$out .= 'border-left: '.intval($args['ossvn_border_left']).'px '.$border_style.' '.$border_color.';';
		}else{
			$out .= '';
		}

		if(!empty($args['ossvn_border_right'])){
			$out .= 'border-right: '.intval($args['ossvn_border_right']).'px '.$border_style.' '.$border_color.';';
		}else{
			$out .= '';
		}

		if(!empty($args['ossvn_border_bottom'])){
			$out .= 'border-bottom: '.intval($args['ossvn_border_bottom']).'px '.$border_style.' '.$border_color.';';
		}else{
			$out .= '';
		}

		if(!empty($args['ossvn_padding_top'])){
			$out .= 'padding-top: '.intval($args['ossvn_padding_top']).'px;';
		}else{
			$out .= '';
		}

		if(!empty($args['ossvn_padding_left'])){
			$out .= 'padding-left: '.intval($args['ossvn_padding_left']).'px;';
		}else{
			$out .= '';
		}

		if(!empty($args['ossvn_padding_right'])){
			$out .= 'padding-right: '.intval($args['ossvn_padding_right']).'px;';
		}else{
			$out .= '';
		}

		if(!empty($args['ossvn_padding_bottom'])){
			$out .= 'padding-bottom: '.intval($args['ossvn_padding_bottom']).'px;';
		}else{
			$out .= '';
		}

		if(!empty($args['background_color'])){
			$out .= 'background-color: '.$args['background_color'].'';
		}else{
			$out .= '';
		}

		return $out;

	}

	/**
	* replace class
	* 
	* @author Comfythemes
	* @since 1.2
	*/
	private function wct_replace_class( $class ){

		$class = str_replace( 'ossvn-empty', '', $class );
		$class = str_replace( 'drag-level-1', '', $class );
		$class = str_replace( '-1-1', '', $class );
		$class = str_replace( '-1', '', $class );
		$class = str_replace( 'ossvn-block-only-one', '', $class );
		$class = str_replace( 'ui-sortable', '', $class );

		return $class;
	}

	/**
	*
	* @since 1.0
	*/
	public function wct_shortcodes_to_exempt_from_wptexturize( $shortcodes ) {
	    $shortcodes[] = 'wct_row';
	    $shortcodes[] = 'wct_col';
	    $shortcodes[] = 'wct_block';
	    return $shortcodes;
	}
	
	/**
	* Replace all OPENING paragraph tags with <br /><br />, p
	* @since    1.0
	*/
	public function wct_clean_auto_p($content) {

	    // Replace all OPENING paragraph tags with <br /><br />
	    $content = preg_replace('/<p[^>]*>/', '<br /><br />', $content);
	    // Remove all CLOSING p tags
	    $content = str_replace('</p>', '', $content);
	    return $content;
	}

	/**
	* Print html accordion
	* @since 1.0.1
	*/

	public function wct_out_html_accordion( $args ){

		$out = '';

		$defaults = array(
						'type'=>'',
						'id'=>'',
						'class'=>'',
						'title'=>'',
						'content'=>'',
						'style'=>'',
						'step_color' => '',
						'step_icon'  => ''
						);

		$args = wp_parse_args( $args, $defaults );

		/**
		* replace class
		* 
		* @author Comfythemes
		* @since 1.2
		*/
		if(!empty($args['class'])){
			$class = $this->wct_replace_class( $args['class'] );
		}else{
			$class = '';
		}

		$wct_style = get_option('wct_styling');

		$step_color = ( isset($args['step_color']) && !empty($args['step_color']) ) ? $args['step_color']: $wct_style['main_color'];
		$step_icon  = ( isset($args['step_icon']) && !empty($args['step_icon']) ) ? $args['step_icon'] : '';

		if( $args['type'] != '' ){

			$out .= '<div id="'.esc_attr($args['id']).'" class="uk-accordion ossvn-accordion '.esc_attr($class).'" data-uk-accordion="{collapse: false}" style="'.esc_attr($args['style']).'" data-title="'.esc_attr($args['title']).'" data-color="'.esc_attr( $step_color ).'" data-icon="'.esc_attr( $step_icon ).'">';
				$out .= '<div class="ossvn-col-12 ossvn-col"><h3 class="uk-accordion-title ossvn-title">'.esc_html($args['title']).'</h3></div>';
				$out .= '<div class="ossvn-accordion-content uk-accordion-content">'.do_shortcode( $this->wct_clean_auto_p( $args['content'] ) ).'</div>';
			$out .= '</div>';

		}else{

			$out .= '<div id="'.esc_attr($args['id']).'" class="'.esc_attr($class).'"  data-title="'.esc_attr($args['title']).'" data-color="'.esc_attr( $step_color ).'" data-icon="'.esc_attr( $step_icon ).'">';
				
				if(!empty($args['title'])){
					$out .= '<div class="ossvn-col-12 ossvn-col"><h3 class="uk-accordion-title ossvn-title">'.esc_html($args['title']).'</h3></div>';
				}
				$out .= do_shortcode( $this->wct_clean_auto_p( $args['content'] ) );	
			$out .= '</div>';			
		}

		return $out;

	}

	/**
	* Shortcode row.
	* @return [wct_row][/wct_row]
	* @since    1.0
	*/
	public function wct_row( $atts, $content = null ){
		$atts = shortcode_atts( array(
			'class' => '',
			'row_display'=>'',
			'row_type_display' => '',
			'row_accordion_title' => '',
			'row_class' => '',
			'row_id' => '',
			'ossvn_margin_top' => '',
			'ossvn_margin_left' => '',
			'ossvn_margin_right' => '',
			'ossvn_margin_bottom' => '',
			'ossvn_border_top' => '',
			'ossvn_border_left' => '',
			'ossvn_border_right' => '',
			'ossvn_border_bottom' => '',
			'ossvn_padding_top' => '',
			'ossvn_padding_left' => '',
			'ossvn_padding_right' => '',
			'ossvn_padding_bottom' => '',
			'border_color' => '',
			'border_style' => '',
			'background_color' => '',
			'step_color'		=> '',
			'step_icon'			=> '',
			'step_icon_display' => '',

		), $atts );
		
		if(!empty($atts['row_id'])){
			$row_id = esc_attr($atts['row_id']);
		}else{
			$row_id = '';
		}

		if(!empty($atts['row_class'])){
			$row_class = esc_attr($atts['row_class']);
		}else{
			$row_class = '';
		}

		/*=====#BEGIN styling========================*/
		$style = '';
		if(
			!empty($atts['ossvn_margin_top']) || 
			!empty($atts['ossvn_margin_left']) || 
			!empty($atts['ossvn_margin_right']) || 
			!empty($atts['ossvn_margin_bottom']) || 
			!empty($atts['ossvn_border_top']) || 
			!empty($atts['ossvn_border_left']) || 
			!empty($atts['ossvn_border_right']) || 
			!empty($atts['ossvn_border_bottom']) || 
			!empty($atts['ossvn_padding_top']) || 
			!empty($atts['ossvn_padding_left']) || 
			!empty($atts['ossvn_padding_right']) || 
			!empty($atts['ossvn_padding_bottom']) || 
			!empty($atts['border_color']) || 
			!empty($atts['border_style']) || 
			!empty($atts['background_color'])
		){

			$style .= ''.sanitize_text_field($this->wct_print_style(array(
												'ossvn_margin_top' => $atts['ossvn_margin_top'],
												'ossvn_margin_left' => $atts['ossvn_margin_left'],
												'ossvn_margin_right' => $atts['ossvn_margin_right'],
												'ossvn_margin_bottom' => $atts['ossvn_margin_bottom'],
												'ossvn_border_top' => $atts['ossvn_border_top'],
												'ossvn_border_left' => $atts['ossvn_border_left'],
												'ossvn_border_right' => $atts['ossvn_border_right'],
												'ossvn_border_bottom' => $atts['ossvn_border_bottom'],
												'ossvn_padding_top' => $atts['ossvn_padding_top'],
												'ossvn_padding_left' => $atts['ossvn_padding_left'],
												'ossvn_padding_right' => $atts['ossvn_padding_right'],
												'ossvn_padding_bottom' => $atts['ossvn_padding_bottom'],
												'border_color' => $atts['border_color'],
												'border_style' => $atts['border_style'],
												'background_color' => $atts['background_color'],
												)
											)).'';
		}/*=====#END styling========================*/

		$row_display = ( isset($atts['row_display']) && !empty($atts['row_display']) ) ?  $atts['row_display'] : '';
		$row_type_display = ( isset($atts['row_type_display']) && !empty($atts['row_type_display']) ) ?  $atts['row_type_display'] : '';

		$step_color = ( isset($atts['step_color']) && !empty($atts['step_color']) ) ? $atts['step_color']: '';
		$step_icon  = ( $atts['step_icon_display'] == 'on' && isset($atts['step_icon']) && !empty($atts['step_icon']) ) ? $atts['step_icon'] : '';
		$out = '';

		ob_start();

			switch ($row_display) {
				
				case 'form_checkout':
					?>
						<?php $get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>
						<form name="checkout" method="post" id="<?php echo $row_id;?>" class="ossvn-row <?php echo esc_attr($row_class);?> checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data" style="<?php echo esc_attr($style);?>">
							<?php echo apply_filters('the_content', $this->wct_clean_auto_p($content));?>
						</form>
					<?php
					break;
					
				case 'account':
				case 'billing':
				case 'shipping':
				case 'order':
				case 'account_step':
				case 'billing_step':
				case 'shipping_step':
				case 'order_step':
				case 'custom_step':
				case 'order_success':

					$out .= $this->wct_out_html_accordion( array( 'type'=>$row_type_display,'id'=>$row_id,'class'=> esc_attr($atts['class']).' '.$row_class,'title'=>$atts['row_accordion_title'],'content'=>$content,'style'=>esc_attr($style), 'step_color'=>esc_attr($step_color), 'step_icon' => esc_attr( $step_icon ) ) );
					break;

				default:
					?>
						<div id="<?php echo $row_id;?>" class="<?php echo esc_attr( $this->wct_replace_class( $atts['class'] ) );?> <?php echo $row_class;?>" style="<?php echo esc_attr($style);?>"><?php echo do_shortcode($this->wct_clean_auto_p($content));?></div>
					<?php
					break;
			}

		$out .= ob_get_contents();
		ob_end_clean();
		return $out;
	}

	/**
	* Shortcode col.
	* @return [wct_col][/wct_col]
	* @since    1.0
	*/
	public function wct_col( $atts, $content = null ){
		$atts = shortcode_atts( array(
			
			'class' => '',
			'col_id' => '',
			'col_extra_class' => '',
			'col_display' => '',
			'ossvn_margin_top' => '',
			'ossvn_margin_left' => '',
			'ossvn_margin_right' => '',
			'ossvn_margin_bottom' => '',
			'ossvn_border_top' => '',
			'ossvn_border_left' => '',
			'ossvn_border_right' => '',
			'ossvn_border_bottom' => '',
			'ossvn_padding_top' => '',
			'ossvn_padding_left' => '',
			'ossvn_padding_right' => '',
			'ossvn_padding_bottom' => '',
			'border_color' => '',
			'border_style' => '',
			'background_color' => '',

		), $atts );

		/*=====#BEGIN styling========================*/
		$style = '';
		if(
			!empty($atts['ossvn_margin_top']) || 
			!empty($atts['ossvn_margin_left']) || 
			!empty($atts['ossvn_margin_right']) || 
			!empty($atts['ossvn_margin_bottom']) || 
			!empty($atts['ossvn_border_top']) || 
			!empty($atts['ossvn_border_left']) || 
			!empty($atts['ossvn_border_right']) || 
			!empty($atts['ossvn_border_bottom']) || 
			!empty($atts['ossvn_padding_top']) || 
			!empty($atts['ossvn_padding_left']) || 
			!empty($atts['ossvn_padding_right']) || 
			!empty($atts['ossvn_padding_bottom']) || 
			!empty($atts['border_color']) || 
			!empty($atts['border_style']) || 
			!empty($atts['background_color'])
		){

			$style .= ''.sanitize_text_field($this->wct_print_style(array(
												'ossvn_margin_top' => $atts['ossvn_margin_top'],
												'ossvn_margin_left' => $atts['ossvn_margin_left'],
												'ossvn_margin_right' => $atts['ossvn_margin_right'],
												'ossvn_margin_bottom' => $atts['ossvn_margin_bottom'],
												'ossvn_border_top' => $atts['ossvn_border_top'],
												'ossvn_border_left' => $atts['ossvn_border_left'],
												'ossvn_border_right' => $atts['ossvn_border_right'],
												'ossvn_border_bottom' => $atts['ossvn_border_bottom'],
												'ossvn_padding_top' => $atts['ossvn_padding_top'],
												'ossvn_padding_left' => $atts['ossvn_padding_left'],
												'ossvn_padding_right' => $atts['ossvn_padding_right'],
												'ossvn_padding_bottom' => $atts['ossvn_padding_bottom'],
												'border_color' => $atts['border_color'],
												'border_style' => $atts['border_style'],
												'background_color' => $atts['background_color'],
												)
											)).'';
		}/*=====#END styling========================*/

		/**
		* replace class
		* 
		* @author Comfythemes
		* @since 1.2
		*/
		if(!empty($atts['class'])){
			$class = str_replace( 'ui-sortable', '', $atts['class'] );
		}else{
			$class = '';
		}

		ob_start();
		?>
		<div id="<?php echo esc_attr($atts['col_id']);?>" class="<?php echo esc_attr($class);?> <?php echo esc_attr($atts['col_extra_class']);?>" style="<?php echo esc_attr($style);?>">
			<?php 
			$template_active = get_option('template_active');
			if(isset($atts['col_display']) && $atts['col_display'] == 'step'):
				if($template_active == '1'){
					echo '<ul id="ossvn-step" class="ossvn-step-list">';
				}elseif ($template_active == '2') {
					echo '<div class="ossvn-steps-process"><ul id="ossvn-step">';
				}else{
					echo '';
				}
			endif;
			?>
				<?php echo do_shortcode($this->wct_clean_auto_p($content));?>
			<?php 
			if(isset($atts['col_display']) && $atts['col_display'] == 'step'):
				if($template_active == '1'){
					echo '</ul>';
				}elseif ($template_active == '2') {
					echo '</ul></div>';
				}else{
					echo '';
				}
			endif;
			?>
		</div>
		<?php
		$out = ob_get_contents();
		ob_end_clean();

		return $out;
	}

	/**
	* Shortcode block.
	* @return [wct_block]
	* @since    1.0
	*/
	public function wct_block( $atts ){
		$arr = array(
			'type' 								=> '',
			'class' 							=> '',
			'ext_class' 						=> '',
			'block_id' 							=> '',
			'block_title' 						=> '',
			'block_title_h' 					=> '',
			'block_required' 					=> '',
			'block_checkbox_options' 			=> '',
			'block_checkbox_options_p' 			=> '',
			'woo_field_id' 						=> '',
			'woo_field_type' 					=> '',
			'multiple_select' 					=> '',
			'block_cond_logic' 					=> '',
			'block_cond_logic_show' 			=> '',
			'block_cond_logic_all' 				=> '',
			'block_cond_logic_field' 			=> '',
			'block_cond_logic_field_is' 		=> '',
			'block_cond_logic_field_is_value' 	=> '',
			'date_skin' 						=> '',
			'block_price' 						=> '',
			'block_checkbox_display' 			=> '',
			'block_price_value' 				=> '',
			'ossvn_margin_top' 					=> '',
			'ossvn_margin_left' 				=> '',
			'ossvn_margin_right' 				=> '',
			'ossvn_margin_bottom' 				=> '',
			'ossvn_border_top' 					=> '',
			'ossvn_border_left' 				=> '',
			'ossvn_border_right' 				=> '',
			'ossvn_border_bottom' 				=> '',
			'ossvn_padding_top' 				=> '',
			'ossvn_padding_left' 				=> '',
			'ossvn_padding_right' 				=> '',
			'ossvn_padding_bottom' 				=> '',
			'border_color' 						=> '',
			'border_style' 						=> '',
			'background_color' 					=> '',
			'block_user_logic' 					=> '',
			'block_user_logic_show' 			=> '',
			'block_user_logic_logged' 			=> '',
			'block_user_logic_logged_role' 		=> '',
			'step_order' 						=> '',
			'step_id_content' 					=> '',
			'order_success_p'					=> '',
			'block_file_allow' 					=> '',
			'block_title_url' 					=> '',
			'ossvn_html_content_p'				=> '',
			'date_w'							=> '',
			'date_disable'						=> '',
			'date_min'							=> '',
			'date_max'							=> '',
			'step_color'						=> '',
			'remove_empty_option'				=> '',
			'time_format'						=> '',
			'block_display_account'				=> '',
			'block_fixed_process'				=> '',
			'block_fixed_process_position'		=> '',
			'block_fixed_process_style'			=> '',
			'block_cond_logic_product' 			=> '',
			'block_cond_logic_product_show' 	=> '',
			'block_cond_logic_product_all' 		=> '',

		);

		$out = '';

		/*=================#begin WPML is on====================*/

		$wpml = get_option('wct_wpml');
		$languages = self::wct_get_languages();
		if($wpml == 'on'){
			if(!empty($languages)){
				foreach($languages as $l){
					if(!in_array($l['default_locale'], $arr)){
						$arr['block_title_'.$l['default_locale'].''] = '';
						$arr['block_placeholder_'.$l['default_locale'].''] = '';
					}
				}
			}
		}

		/*=================#End WPML is on====================*/

		$atts = shortcode_atts( $arr, $atts, 'wct_block' );


		if($wpml == 'on'){

			if(!empty($languages)){

				$active_lang = ICL_LANGUAGE_CODE;

				if(!empty($atts['block_title_'.$active_lang.''])){

					$title = $atts['block_title_'.$active_lang.''];

				}else{

					$title = $atts['block_title'];
				}
				if(!empty($atts['block_placeholder_'.$active_lang.''])){

					$placeholder = $atts['block_placeholder_'.$active_lang.''];

				}else{

					$placeholder = $atts['block_title_h'];
				}
			}else{

				$title = $atts['block_title'];
				$placeholder = $atts['block_title_h'];	
			}
		}else{

			$title = $atts['block_title'];

			if(isset($atts['block_title_h']) && !empty($atts['block_title_h'])){

				$placeholder = $atts['block_title_h'];
				
			}else{
				$placeholder = '';
			}
		}

		/*=====#BEGIN styling========================*/
		if(
			!empty($atts['ossvn_margin_top']) || 
			!empty($atts['ossvn_margin_left']) || 
			!empty($atts['ossvn_margin_right']) || 
			!empty($atts['ossvn_margin_bottom']) || 
			!empty($atts['ossvn_border_top']) || 
			!empty($atts['ossvn_border_left']) || 
			!empty($atts['ossvn_border_right']) || 
			!empty($atts['ossvn_border_bottom']) || 
			!empty($atts['ossvn_padding_top']) || 
			!empty($atts['ossvn_padding_left']) || 
			!empty($atts['ossvn_padding_right']) || 
			!empty($atts['ossvn_padding_bottom']) || 
			!empty($atts['border_color']) || 
			!empty($atts['border_style']) || 
			!empty($atts['background_color'])
		){
			if($atts['type'] == 'woo_field'){
				$selector = ''.$atts['woo_field_id'].'_field';
			}else{
				$selector = $atts['block_id'];
			}
			$out .= '<style>#ossvn-wrapper #wct-woo-template #'.esc_attr($selector).'{';
			$out .= $this->wct_print_style(array(
												'ossvn_margin_top' => $atts['ossvn_margin_top'],
												'ossvn_margin_left' => $atts['ossvn_margin_left'],
												'ossvn_margin_right' => $atts['ossvn_margin_right'],
												'ossvn_margin_bottom' => $atts['ossvn_margin_bottom'],
												'ossvn_border_top' => $atts['ossvn_border_top'],
												'ossvn_border_left' => $atts['ossvn_border_left'],
												'ossvn_border_right' => $atts['ossvn_border_right'],
												'ossvn_border_bottom' => $atts['ossvn_border_bottom'],
												'ossvn_padding_top' => $atts['ossvn_padding_top'],
												'ossvn_padding_left' => $atts['ossvn_padding_left'],
												'ossvn_padding_right' => $atts['ossvn_padding_right'],
												'ossvn_padding_bottom' => $atts['ossvn_padding_bottom'],
												'border_color' => $atts['border_color'],
												'border_style' => $atts['border_style'],
												'background_color' => $atts['background_color'],
												)
											);
			$out .= '}</style>';
		}/*=====#END styling========================*/


		/*=====Enable conditional logic=======*/
		$class_logic = '';
		$class_logic_all = '';
		$block_logic_field = '';
		$block_logic_field_is = '';
		$block_logic_field_is_value = '';

		if( isset($atts['block_cond_logic_product']) && $atts['block_cond_logic_product'] == 'on' ){
			$class_logic .= ' block-logic-product-on ';
		}

		if( isset($atts['block_cond_logic_product']) && $atts['block_cond_logic_product'] == 'on' && isset($atts['block_cond_logic_product_show']) && $atts['block_cond_logic_product_show'] == 'hidden' ){
			$class_logic .= ' block-logic-product-hide ';
		}

		if( isset($atts['block_cond_logic_product']) && $atts['block_cond_logic_product'] == 'on' && isset($atts['block_cond_logic_product_all']) && $atts['block_cond_logic_product_all'] == 'any' ){
			$class_logic .= ' block-logic-product-any ';
		}

		/*=======block_required = on =================== */

		if(isset($atts['block_required']) && $atts['block_required'] == 'on'){
			$block_required = '<abbr class="required" title="required">*</abbr>';
			$class_required = 'validate-required';
			$required = true;
		}else{
			$block_required = '';
			$class_required = '';
			$required = false;
		}

		/*=====checkbox options=========*/
		

		if( $atts['type'] == 'checkbox' || $atts['type'] == 'radio' ){
			$checkbox_options = html_entity_decode($atts['block_checkbox_options_p']);
		}else{
			$checkbox_options = $atts['block_checkbox_options'];
		}

		if( isset($atts['block_checkbox_options_p']) && !empty($atts['block_checkbox_options_p']) ){
					
			$option_str = $checkbox_options;
			$option_str = explode("\n", $option_str);
			$option_str = array_map('trim', $option_str);

		}else{

			$option_str = '';
		}

		/*===multiple select===*/
		if( isset($atts['multiple_select']) && $atts['multiple_select'] == 'on' ){
			$multiple_select = 'multiple="multiple"';
		}else{
			$multiple_select = '';
		}

		/*=========price==========*/
		if(isset($atts['block_price']) && $atts['block_price'] == 'on'){
			if(isset($atts['block_price_value']) && !empty($atts['block_price_value'])){
				$price = 'data-price=on data-price-value='.esc_attr($atts['block_price_value']).'';
			}else{
				$price = '';
			}
		}else{
			$price = '';
		}

		/*=========extra class===========*/
		if( isset($atts['ext_class']) && !empty($atts['ext_class']) ){
			$ext_class = $atts['ext_class'];
		}else{
			$ext_class = '';
		}

		/**
		* Allow tag <a> in label
		*
		* @since 1.2
		*/

		if( isset($atts['block_title_url']) && !empty($atts['block_title_url']) ){
			$block_title = '<a href="'.esc_url($atts['block_title_url']).'" target="_blank">'.esc_html($title).'</a>';
		}else{
			$block_title = esc_html($title);
		}

		/**
		* replace class
		* 
		* @author Comfythemes
		* @since 1.2
		*/
		if(!empty($atts['class'])){
			$class = $this->wct_replace_class( $atts['class'] );
		}else{
			$class = '';
		}

		/**
		* Format the time
		* @since 1.3
		*/
		$time_format = ( isset($atts['time_format']) && !empty($atts['time_format']) ) ? 'hh:mm tt' : 'HH:mm';

		/**
		* Display account
		* @since 1.3
		*/
		if( $atts['block_display_account'] == 'undefined' || $atts['block_display_account'] == '' ){
			$account_page = 'data-accountpage=off';
		}else{
			$account_page = 'data-accountpage=on';
		}

		/**
		* Process bar display fixed
		* @since 1.3
		*/
		if( isset($atts['block_fixed_process']) && $atts['block_fixed_process'] == 'on' ){

			if( isset($atts['block_fixed_process_position']) && $atts['block_fixed_process_position'] == 'bottom' ){
				$progressbar_position = 'ossvn-process-bottom';
			}else{
				$progressbar_position = 'ossvn-process-top';
			}

		}else{

			$progressbar_position = '';
		}

		if( isset($atts['block_fixed_process_style']) && !empty($atts['block_fixed_process_style']) ){
			$progressbar_style = $atts['block_fixed_process_style'];
		}else{
			$progressbar_style = 'ossvn-process-default';
		}

		switch ($atts['type']) {
			case 'title':
				if($atts['block_title_h'] == ''){
					$out .= '<p id="'.esc_attr($atts['block_id']).'" class="ossvn-title '.esc_attr( $class ).' '.esc_attr($ext_class).'">'.wp_kses_post( $block_title ).'</p>';
				}else{
					$out .= '<'.esc_attr($atts['block_title_h']).' id="'.esc_attr($atts['block_id']).'" class="ossvn-title '.esc_attr( $class ).' '.esc_attr($ext_class).'">'.wp_kses_post( $block_title ).'</'.esc_attr($atts['block_title_h']).'>';
				}
				break;

			case 'text':
				$out_temp = '
				<p class="form-row-text form-row '.esc_attr($class_required).' '.esc_attr($class_logic).' '.esc_attr($class_logic_all).' '.esc_attr($ext_class).'" id="'.esc_attr($atts['block_id']).'_field" '.esc_attr($block_logic_field).' '.esc_attr($block_logic_field_is).' '.esc_attr($block_logic_field_is_value).' '.esc_attr($price).' '.esc_attr( $account_page ).'>
					<label for="'.esc_attr($atts['block_id']).'" class="">'.wp_kses_post( $block_title ).' '.$block_required.'</label>
					<input type="text" class="ossvn-block-field input-text" name="'.esc_attr($atts['block_id']).'" id="'.esc_attr($atts['block_id']).'" placeholder="'.esc_attr($placeholder).'" value="">
				</p>
				';
				$out .= $this->wct_output_block_with_user_role($out_temp, array('block_user_logic' => $atts['block_user_logic'],
																				'block_user_logic_show' => $atts['block_user_logic_show'],
																				'block_user_logic_logged' => $atts['block_user_logic_logged'],
																				'block_user_logic_logged_role' => explode(",", $atts['block_user_logic_logged_role']),)
																);
				break;
			case 'textarea':
				$out_temp = '
				<p class="form-row-textarea form-row '.esc_attr($class_required).' '.esc_attr($class_logic).' '.esc_attr($class_logic_all).' '.esc_attr($ext_class).'" id="'.esc_attr($atts['block_id']).'_field" '.esc_attr($block_logic_field).' '.esc_attr($block_logic_field_is).' '.esc_attr($block_logic_field_is_value).' '.esc_attr($price).' '.esc_attr( $account_page ).'>
					<label for="'.esc_attr($atts['block_id']).'" class="">'.wp_kses_post( $block_title ).' '.$block_required.'</label>
					<textarea name="'.esc_attr($atts['block_id']).'" class="ossvn-block-field input-textarea " id="'.esc_attr($atts['block_id']).'" placeholder="'.esc_attr($placeholder).'"></textarea>
				</p>
				';
				$out .= $this->wct_output_block_with_user_role($out_temp, array('block_user_logic' => $atts['block_user_logic'],
																				'block_user_logic_show' => $atts['block_user_logic_show'],
																				'block_user_logic_logged' => $atts['block_user_logic_logged'],
																				'block_user_logic_logged_role' => explode(",", $atts['block_user_logic_logged_role']),)
																);
				break;
			case 'phone':
				$out_temp = '
				<p class="form-row-phone form-row '.esc_attr($class_required).' '.esc_attr($class_logic).' '.esc_attr($class_logic_all).' '.esc_attr($ext_class).'" id="'.esc_attr($atts['block_id']).'_field" '.esc_attr($block_logic_field).' '.esc_attr($block_logic_field_is).' '.esc_attr($block_logic_field_is_value).' '.esc_attr($price).' '.esc_attr( $account_page ).'>
					<label for="'.esc_attr($atts['block_id']).'" class=" ">'.wp_kses_post( $block_title ).' '.$block_required.'</label>
					<input type="tel" class="ossvn-block-field input-text " name="'.esc_attr($atts['block_id']).'" id="'.esc_attr($atts['block_id']).'" placeholder="'.esc_attr($placeholder).'" value="">
				</p>
				';
				$out .= $this->wct_output_block_with_user_role($out_temp, array('block_user_logic' => $atts['block_user_logic'],
																				'block_user_logic_show' => $atts['block_user_logic_show'],
																				'block_user_logic_logged' => $atts['block_user_logic_logged'],
																				'block_user_logic_logged_role' => explode(",", $atts['block_user_logic_logged_role']),)
																);
				break;

			case 'button':
				$out_temp = '
				<p class="form-row-button form-row '.esc_attr($class_required).' '.esc_attr($class_logic).' '.esc_attr($class_logic_all).' '.esc_attr($ext_class).'" id="'.esc_attr($atts['block_id']).'_field" '.esc_attr($block_logic_field).' '.esc_attr($block_logic_field_is).' '.esc_attr($block_logic_field_is_value).' '.esc_attr($price).' '.esc_attr( $account_page ).'>
					<input type="submit" class="ossvn-block-field ossvn-button '.esc_attr($atts['class']).'" name="'.esc_attr($atts['block_id']).'" value="'.esc_html($title).'">
				</p>
				';
				$out .= $this->wct_output_block_with_user_role($out_temp, array('block_user_logic' => $atts['block_user_logic'],
																				'block_user_logic_show' => $atts['block_user_logic_show'],
																				'block_user_logic_logged' => $atts['block_user_logic_logged'],
																				'block_user_logic_logged_role' => explode(",", $atts['block_user_logic_logged_role']),)
																);
				break;

			case 'email':
				$out_temp = '
				<p class="form-row-email form-row '.esc_attr($class_required).' '.esc_attr($class_logic).' '.esc_attr($class_logic_all).' validate-email '.esc_attr($ext_class).'" id="'.esc_attr($atts['block_id']).'_field" '.esc_attr($block_logic_field).' '.esc_attr($block_logic_field_is).' '.esc_attr($block_logic_field_is_value).' '.esc_attr($price).' '.esc_attr( $account_page ).'>
					<label for="'.esc_attr($atts['block_id']).'" class=" ">'.wp_kses_post( $block_title ).' '.$block_required.'</label>
					<input type="email" class="ossvn-block-field input-text " name="'.esc_attr($atts['block_id']).'" id="'.esc_attr($atts['block_id']).'" placeholder="'.esc_attr($placeholder).'" value="">
				</p>
				';
				$out .= $this->wct_output_block_with_user_role($out_temp, array('block_user_logic' => $atts['block_user_logic'],
																				'block_user_logic_show' => $atts['block_user_logic_show'],
																				'block_user_logic_logged' => $atts['block_user_logic_logged'],
																				'block_user_logic_logged_role' => explode(",", $atts['block_user_logic_logged_role']),)
																);
				break;
			case 'file':
				ob_start();
				?>
				<div id="<?php echo esc_attr($atts['block_id']);?>_field" <?php echo esc_attr( $account_page );?>>
					<link rel="stylesheet" id="wct-uikit-doc-css"  href="<?php echo esc_url(WCT_ASSETS_GLOBAL. 'uikit/css/uikit.docs.min.css');?>" type="text/css" media="all" />
					<div id="upload-drop" class="uk-placeholder uk-text-center wct-upload-<?php echo esc_attr($atts['block_id']);?>">
	                    <i class="uk-icon-cloud-upload uk-icon-medium uk-text-muted uk-margin-small-right"></i> <?php _e('Attach binaries by dropping them here or', 'wct');?> <a class="uk-form-file"><?php _e('selecting one', 'wct');?><input id="upload-select-<?php echo esc_attr($atts['block_id']);?>" name="uploadfile" type="file"></a>.
	                	
	                	<div id="progressbar" class="uk-progress uk-hidden wct-processwct-<?php echo esc_attr($atts['block_id']);?>">
						    <div class="uk-progress-bar" style="width: 0%;">0%</div>
						    <input type="hidden" name="wct_file_allow" value="<?php echo esc_attr($atts['block_file_allow']);?>">
						</div>
						<div id="<?php echo esc_attr($atts['block_id']);?>_progress_results" class="progress-results" style="display:none;">
					    	<div class="uk-alert">
					    		<ul id="files"><li class="clearfix" style="clear: both;"></li></ul>
					    		<input type="hidden" name="<?php echo esc_attr($atts['block_id']);?>" id="<?php echo esc_attr($atts['block_id']);?>_file" value="">
					    	</div>
					    </div>
	                </div>
					<?php 
					if( isset($atts['block_file_allow']) && !empty($atts['block_file_allow']) ){
						$ext = esc_attr($atts['block_file_allow']);
						$ext_text = str_replace('|', ' ', $ext);
					}else{
						$ext = 'jpg|png|jpeg|gif';
						$ext_text = str_replace('|', ' ', $ext);
					}

					$upload_nonce = wp_create_nonce( 'wct_upload_nonce' );
					?>
					<script>

					    (function($) {
							"use strict";
						    var progressbar = $(".wct-processwct-<?php echo esc_attr($atts['block_id']);?>"),
					            bar         = progressbar.find('.uk-progress-bar'),
					            settings    = {

					            action: "<?php echo esc_url( admin_url('admin-ajax.php'));?>?action=wct_upload&_wpnonce=<?php echo $upload_nonce; ?>", // ajax upload url
					            param: 'uploadfile',
					            params: {'wct_file_allow': '<?php echo $ext;?>'},
					            allow : "*.(<?php echo $ext;?>)",
					            type: 'json',

					            loadstart: function() {
					                bar.css("width", "0%").text("0%");
					                progressbar.removeClass("uk-hidden");
					            },

					            progress: function(percent) {
					                percent = Math.ceil(percent);
					                bar.css("width", percent+"%").text(percent+"%");
					            },

					            allcomplete: function(data) {

					            	bar.css("width", "100%").text("100%");
						            setTimeout(function(){ progressbar.addClass("uk-hidden");}, 250);

					            	$("#<?php echo esc_attr($atts['block_id']);?>_progress_results").css('margin-top', '10px');
									$("#<?php echo esc_attr($atts['block_id']);?>_progress_results").show();
		
									if( data.status == "1" ){

										$("#<?php echo esc_attr($atts['block_id']);?>_progress_results .uk-alert").removeClass('uk-alert-danger');
										$("#<?php echo esc_attr($atts['block_id']);?>_progress_results .uk-alert li.error").remove();
										$("#<?php echo esc_attr($atts['block_id']);?>_progress_results .uk-alert").addClass('uk-alert-success');
										$('#files .clearfix').before('<li class="success"><img src="'+ data.url +'" alt="" data-name="'+ data.name_tmp +'" data-id="'+ data.id +'" style="max-width:75px;"/><br />'+ data.name_tmp +' <a href="" class="remove_img uk-alert-close uk-close" data-delete="'+ data.id +'"></a></li>');

										new wct_get_data_upload("#<?php echo esc_attr($atts['block_id']);?>_progress_results");
										new wct_remove_data_upload("#<?php echo esc_attr($atts['block_id']);?>_progress_results");

									} else{
										
										$("#<?php echo esc_attr($atts['block_id']);?>_progress_results .uk-alert").addClass('uk-alert-danger');
										$('#files .clearfix').before('<li class="error">'+ data.message +'</li>');
									}

					            }
					        };

					        var select = UIkit.uploadSelect($("#upload-select-<?php echo esc_attr($atts['block_id']);?>"), settings),
					            drop   = UIkit.uploadDrop($(".wct-upload-<?php echo esc_attr($atts['block_id']);?>"), settings);
					            
					    })(jQuery);

					</script>
				</div>
				<?php
				$out_temp = ob_get_contents();
				$out .= $this->wct_output_block_with_user_role($out_temp, array('block_user_logic' => $atts['block_user_logic'],
																				'block_user_logic_show' => $atts['block_user_logic_show'],
																				'block_user_logic_logged' => $atts['block_user_logic_logged'],
																				'block_user_logic_logged_role' => explode(",", $atts['block_user_logic_logged_role']),)
																);
				ob_end_clean();
				break;
			case 'date':

				$data_skin = ( isset($atts['date_skin']) && !empty($atts['date_skin']) ) ? $atts['date_skin'] : 'nigran';
				ob_start();
				?>
				<p class="uk-form form-row-date form-row <?php echo esc_attr($class_required);?> <?php echo ' '.esc_attr($class_logic).' '.esc_attr($class_logic_all).' '.esc_attr($ext_class).'';?>" id="<?php echo esc_attr($atts['block_id']);?>_field" <?php echo ' '.esc_attr($block_logic_field).' '.esc_attr($block_logic_field_is).' '.esc_attr($block_logic_field_is_value).' '.esc_attr($price).' '.esc_attr( $account_page ).'';?>>
					<label for="<?php echo esc_attr($atts['block_id']);?>" class=" "><?php echo wp_kses_post( $block_title );?> <?php echo $block_required;?></label>
					<input type="text" class="ossvn-block-field input-text input-date hasDatepicker" name="<?php echo esc_attr($atts['block_id']);?>" id="date_<?php echo esc_attr($atts['block_id']);?>" placeholder="<?php echo esc_attr($placeholder);?>">
				</p>
				<?php

				$dates_arr = array();
				$dates_range = array();
				$disableddates = '';

				if( isset($atts['date_min']) && !empty($atts['date_min']) ){
					
					$startDate = $atts['date_min'];

					if( isset($atts['date_max']) && !empty($atts['date_max']) ){
						$endDate = $atts['date_max'];
					}else{
						$endDate = date('n-j-Y');
					}

				}else{
					$startDate = '';
					$endDate = '';
				}

				if( !empty($startDate) ){
					$obj_startDate = explode('-', $startDate);
					$minDate = 'minDate: new Date('.intval($obj_startDate[2]).', '.intval($obj_startDate[0]).', '.intval($obj_startDate[1]).'),';
				}else{
					$minDate = '';
				}

				if( !empty($endDate) ){
					$obj_endDate = explode('-', $endDate);
					$maxDate = 'maxDate: new Date('.intval($obj_endDate[2]).', '.intval($obj_endDate[0]).', '.intval($obj_endDate[1]).'),';
				}else{
					$maxDate = '';
				}


				if( isset($atts['date_w']) && $atts['date_w'] == 'on' ){

					wct_enqueue_js(
						'
							$(\'#date_'.esc_attr($atts['block_id']).'\').after("<div class=\'ossvn-datepicker-wrap\'><div id=\'ossvn-datepicker-'.esc_attr($atts['block_id']).'\' class=\'ossvn-datepicker\'></div></div>")
							
							$(\'#ossvn-datepicker-'.esc_attr($atts['block_id']).'\').datetimepicker({
									timeFormat: "'.esc_attr( $time_format ).'",
									beforeShowDay: $.datepicker.noWeekends,
    								'.esc_attr( $minDate ).'
    								'.esc_attr( $maxDate ).'
									onSelect : function(dateText){
										$(this).parents(".ossvn-datepicker-wrap").parent().children("#date_'.esc_attr($atts['block_id']).'").val(dateText);
										$(this).parents(".ossvn-datepicker-wrap").parent().children(".ossvn-placeholder").hide();
									}
									}).wrap(\'<div class="ll-skin-'. esc_attr($data_skin) .'"/>\');

							$(\'#date_'.esc_attr($atts['block_id']).'\').focus(function(){
								$(this).next().addClass("active");
							});

							$(\'#ossvn-datepicker-'.esc_attr($atts['block_id']).' .ui-datepicker-current\').on(\'click\', function() {
							
								var time = $("#ossvn-datepicker-'.esc_attr($atts['block_id']).' .ui_tpicker_time").text(),
								date = new Date();
								var m = date.getMonth();
								var d = date.getDate();
								var y = date.getFullYear();
								$("#'.esc_attr($atts['block_id']).'_field .ossvn-placeholder").hide();
								$(\'#date_'.esc_attr($atts['block_id']).'\').val(""+ (("0" + (m + 1)).slice(-2)) +"/"+ (("0" + d).slice(-2)) +"/"+ y +" "+time);
								
						    });

						'
					);

				}elseif( isset($atts['date_w']) && $atts['date_w'] == 'off' && !empty($atts['date_disable']) ){
					
					$dates_arr = explode(', ', $atts['date_disable']);

					wct_enqueue_js(
						'

							var disableddates_'.esc_attr($atts['block_id']).' = '.json_encode($dates_arr).';

							$(\'#date_'.esc_attr($atts['block_id']).'\').after("<div class=\'ossvn-datepicker-wrap\'><div id=\'ossvn-datepicker-'.esc_attr($atts['block_id']).'\' class=\'ossvn-datepicker\'></div></div>")
							
							$(\'#ossvn-datepicker-'.esc_attr($atts['block_id']).'\').datetimepicker({
									timeFormat: "'.esc_attr( $time_format ).'",
									beforeShowDay: function (date) {
										
										var m = date.getMonth();
										var d = date.getDate();
										var y = date.getFullYear();

										var currentdate = (m + 1) + \'-\' + d + \'-\' + y ;
										for (var i = 0; i < disableddates_'.esc_attr($atts['block_id']).'.length; i++) {

											if ($.inArray(currentdate, disableddates_'.esc_attr($atts['block_id']).') != -1 ) {
												return [false];
											}

										}
										return [true];

									},
									'.esc_attr( $minDate ).'
    								'.esc_attr( $maxDate ).'
									onSelect : function(dateText){
										$(this).parents(".ossvn-datepicker-wrap").parent().children("#date_'.esc_attr($atts['block_id']).'").val(dateText);
										$(this).parents(".ossvn-datepicker-wrap").parent().children(".ossvn-placeholder").hide();
									}
									}).wrap(\'<div class="ll-skin-'. esc_attr($data_skin) .'"/>\');

							$(\'#date_'.esc_attr($atts['block_id']).'\').focus(function(){
								$(this).next().addClass("active");
							});
							$(\'#ossvn-datepicker-'.esc_attr($atts['block_id']).' .ui-datepicker-current\').on(\'click\', function() {
							
								var time = $("#ossvn-datepicker-'.esc_attr($atts['block_id']).' .ui_tpicker_time").text(),
								date = new Date();
								var m = date.getMonth();
								var d = date.getDate();
								var y = date.getFullYear();
								$("#'.esc_attr($atts['block_id']).'_field .ossvn-placeholder").hide();
								$(\'#date_'.esc_attr($atts['block_id']).'\').val(""+ (("0" + (m + 1)).slice(-2)) +"/"+ (("0" + d).slice(-2)) +"/"+ y +" "+time);
								
						    });

						'
					);

				}else{

					wct_enqueue_js(
					'

						$(\'#date_'.esc_attr($atts['block_id']).'\').after("<div class=\'ossvn-datepicker-wrap\'><div id=\'ossvn-datepicker-'.esc_attr($atts['block_id']).'\' class=\'ossvn-datepicker\'></div></div>")
						
						$(\'#ossvn-datepicker-'.esc_attr($atts['block_id']).'\').datetimepicker({
								timeFormat: "'.esc_attr( $time_format ).'",
								'.esc_attr( $minDate ).'
    							'.esc_attr( $maxDate ).'
								onSelect : function(dateText){
									$(this).parents(".ossvn-datepicker-wrap").parent().children("#date_'.esc_attr($atts['block_id']).'").val(dateText);
									$(this).parents(".ossvn-datepicker-wrap").parent().children(".ossvn-placeholder").hide();
								}
								}).wrap(\'<div class="ll-skin-'. esc_attr($data_skin) .'"/>\');

						$(\'#date_'.esc_attr($atts['block_id']).'\').focus(function(){
							$(this).next().addClass("active");
						});
						$(\'#ossvn-datepicker-'.esc_attr($atts['block_id']).' .ui-datepicker-current\').on(\'click\', function() {
							
							var time = $("#ossvn-datepicker-'.esc_attr($atts['block_id']).' .ui_tpicker_time").text(),
							date = new Date();
							var m = date.getMonth();
							var d = date.getDate();
							var y = date.getFullYear();
							$("#'.esc_attr($atts['block_id']).'_field .ossvn-placeholder").hide();
							$(\'#date_'.esc_attr($atts['block_id']).'\').val(""+ (("0" + (m + 1)).slice(-2)) +"/"+ (("0" + d).slice(-2)) +"/"+ y +" "+time);
							
					    });

					'
					);
				}



				?>
				<?php
				$out_temp = ob_get_contents();
				$out .= $this->wct_output_block_with_user_role($out_temp, array('block_user_logic' => $atts['block_user_logic'],
																				'block_user_logic_show' => $atts['block_user_logic_show'],
																				'block_user_logic_logged' => $atts['block_user_logic_logged'],
																				'block_user_logic_logged_role' => explode(",", $atts['block_user_logic_logged_role']),)
																);
				ob_end_clean();
				break;

			case 'dropdown':
				if(isset($atts['block_checkbox_options']) && !empty($atts['block_checkbox_options'])){
					
					$option = '';
					
					if(!empty($option_str)){
						
						foreach ($option_str as $value) {
							
							$select_value = explode(" : ", $value);
							
							if($select_value){

								if(isset($select_value[0]) && !empty($select_value[0])){
									$option_val = $select_value[0];
								}else{
									$option_val = '';
								}

								if(isset($select_value[1]) && !empty($select_value[1])){
									$option_text = str_replace( '<br/>', '', $select_value[1] );
								}else{
									$option_text = __('Text is empty!', 'wct');
								}

								$option .= '<option value="'.esc_attr($option_val).'">'.wp_kses_post($option_text).'</option>';
							}else{
								$option = '';
							}
						}
					}else{
						$option = '';
					}

				}else{

					$option = '';
				}

				if( isset($atts['remove_empty_option']) && $atts['remove_empty_option'] == 'on' ){
					$option_empty = '';
				}else{
					$option_empty = '<option value="-1">'.__( 'Select option...', 'wct' ).'</option>';
				}

				$out_temp = '
				<p class="form-row-dropdown form-row '.esc_attr($class_required).' '.esc_attr($class_logic).' '.esc_attr($class_logic_all).' '.esc_attr($ext_class).'" id="'.esc_attr($atts['block_id']).'_field" '.esc_attr($block_logic_field).' '.esc_attr($block_logic_field_is).' '.esc_attr($block_logic_field_is_value).' '.esc_attr($price).' '.esc_attr( $account_page ).'>
					<label for="'.esc_attr($atts['block_id']).'" class=" ">'.wp_kses_post( $block_title ).' '.$block_required.'</label>
					<select name="'.esc_attr($atts['block_id']).'" class="ossvn-block-field country_to_state country_select '.esc_attr($atts['class']).'" id="'.esc_attr($atts['block_id']).'" '.$multiple_select.'>
						'.$option_empty.'
						'.$option.'
					</select>
				</p>
				';
				$out .= $this->wct_output_block_with_user_role($out_temp, array('block_user_logic' => $atts['block_user_logic'],
																				'block_user_logic_show' => $atts['block_user_logic_show'],
																				'block_user_logic_logged' => $atts['block_user_logic_logged'],
																				'block_user_logic_logged_role' => explode(",", $atts['block_user_logic_logged_role']),)
																);
				break;

			case 'radio':

				if(isset($atts['block_checkbox_options_p']) && !empty($atts['block_checkbox_options_p'])){
					$radio = '';
					if($option_str){

						foreach ($option_str as $value) {

							$radio_value = explode(" : ", $value);

							if($radio_value){

								if(isset($radio_value[1]) && !empty($radio_value[1])){

									/*=======lable display type for checkbox, radio================*/
									if(isset($atts['block_checkbox_display']) && $atts['block_checkbox_display'] == 'img'){
										
										if( filter_var( $radio_value[1], FILTER_VALIDATE_URL ) ){

											$text_url = $radio_value[1];
										}else{
											
											$text_url = WCT_FRONTEND_IMG. 'logo.png';
										}

										$label_display = '<label for="'.esc_attr($atts['block_id']).esc_attr($radio_value[0]).'" class="ossvn-label-images"><img src="'.esc_url($text_url).'"></label>';
										$radio .= '<span class="form-field-checked">
											'.wp_kses_post($label_display).'
											<input type="radio" name="'.esc_attr($atts['block_id']).'" class="ossvn-block-field '.esc_attr($atts['class']).'" value="'.esc_attr($radio_value[0]).'">
										</span>';

									}else{
										
										$label_display = '<label for="'.esc_attr($atts['block_id']).esc_attr($radio_value[0]).'" class=" ">'.wp_kses_post($radio_value[1]).'</label>';
										$radio .= '
											<input type="radio" id="'.esc_attr($atts['block_id']).esc_attr($radio_value[0]).'" name="'.esc_attr($atts['block_id']).'" class="ossvn-block-field '.esc_attr($atts['class']).'" value="'.esc_attr($radio_value[0]).'">
											'.wp_kses_post($label_display).'
										';
									}

								}else{

									$label_display = '<label for="'.esc_attr($atts['block_id']).esc_attr($radio_value[0]).'" class=" "></label>';
									$radio .= '
									<input type="radio" name="'.esc_attr($atts['block_id']).'" class="ossvn-block-field '.esc_attr($atts['class']).'" value="'.esc_attr($radio_value[0]).'">
									';
								}

							}else{
								$radio = '';
							}
						}

					}else{
						$radio = '';
					}

				}else{

					$radio = '';
				}
				$out_temp = '

				<p class="form-row-radio form-row '.esc_attr($class_required).' '.esc_attr($class_logic).' '.esc_attr($class_logic_all).' '.esc_attr($ext_class).'" id="'.esc_attr($atts['block_id']).'_field" '.esc_attr($block_logic_field).' '.esc_attr($block_logic_field_is).' '.esc_attr($block_logic_field_is_value).' '.esc_attr($price).' '.esc_attr( $account_page ).'>
					<label for="'.esc_attr($atts['block_id']).'" class="ossvn-label-title">'.wp_kses_post( $block_title ).' '.$block_required.'</label>
					<br/>
					'.$radio.'
				</p>
				';
				$out .= $this->wct_output_block_with_user_role($out_temp, array('block_user_logic' => $atts['block_user_logic'],
																				'block_user_logic_show' => $atts['block_user_logic_show'],
																				'block_user_logic_logged' => $atts['block_user_logic_logged'],
																				'block_user_logic_logged_role' => explode(",", $atts['block_user_logic_logged_role']),)
																);
				break;

			case 'checkbox':
				if(isset($atts['block_checkbox_options_p']) && !empty($atts['block_checkbox_options_p'])){
					$checkbox = '';
					if($option_str){

						$i = 0;
						foreach ($option_str as $value) {
							
							$checkbox_value = explode(" : ", $value);
							if($checkbox_value){

								if(isset($checkbox_value[1]) && !empty($checkbox_value[1])){

									/*=======lable display type for checkbox, radio================*/
									if(isset($atts['block_checkbox_display']) && $atts['block_checkbox_display'] == 'img'){
										
										if( filter_var( $checkbox_value[1], FILTER_VALIDATE_URL ) ){

											$text_url = $checkbox_value[1];
										}else{
											
											$text_url = WCT_FRONTEND_IMG. 'logo.png';
										}

										$label_display = '<label class="ossvn-label-images" for="'.esc_attr($atts['block_id']).esc_attr($checkbox_value[0]).'"><img src="'.esc_url($text_url).'"></label>';
										$checkbox .= '<span class="form-field-checked">
											'.wp_kses_post($label_display).'
											<input type="checkbox" data-title="'.wp_kses_post( str_replace( '<br />', '', $checkbox_value[1] ) ).'" id="'.esc_attr($atts['block_id']).esc_attr($checkbox_value[0]).'" name="'.esc_attr($atts['block_id']).'" class="ossvn-block-field '.esc_attr($atts['class']).'" value="'.esc_attr($checkbox_value[0]).'">
										</span>';

									}else{
										
										$label_display = '<label for="'.esc_attr($checkbox_value[0]).'" class=" ">'.wp_kses_post($checkbox_value[1]).'</label>';
										$checkbox .= '
											<input type="checkbox" data-title="'.wp_kses_post( str_replace( '<br />', '', $checkbox_value[1] ) ).'" id="'.esc_attr($checkbox_value[0]).'" name="'.esc_attr($atts['block_id']).'" class="ossvn-block-field '.esc_attr($atts['class']).'" value="'.esc_attr($checkbox_value[0]).'">
											'.wp_kses_post($label_display).'
										';
									}

								}else{

									$label_display = '<label for="'.esc_attr($atts['block_id']).esc_attr($checkbox_value[0]).'" class=" "></label>';
									$checkbox .= '
										<input type="checkbox" data-title="" name="'.esc_attr($atts['block_id']).esc_attr($checkbox_value[0]).'" class="ossvn-block-field '.esc_attr($atts['class']).'" value="'.esc_attr($checkbox_value[0]).'">
									';
								}
								
							}else{

								$checkbox = '';
							}

							$i++;
						}
					}else{
						$checkbox = '';
					}

				}else{

					$checkbox = '';
				}
				$out_temp = '
				<p class="form-row-checkbox form-row '.esc_attr($class_required).' '.esc_attr($class_logic).' '.esc_attr($class_logic_all).' '.esc_attr($ext_class).'" id="'.esc_attr($atts['block_id']).'_field" '.esc_attr($block_logic_field).' '.esc_attr($block_logic_field_is).' '.esc_attr($block_logic_field_is_value).' '.esc_attr($price).' '.esc_attr( $account_page ).'>
					<label for="'.esc_attr($atts['block_id']).'" class="ossvn-label-title">'.wp_kses_post( $block_title ).' '.$block_required.'</label>
					<br/>
					'.$checkbox.'
				</p>
				';
				$out .= $this->wct_output_block_with_user_role($out_temp, array('block_user_logic' => $atts['block_user_logic'],
																				'block_user_logic_show' => $atts['block_user_logic_show'],
																				'block_user_logic_logged' => $atts['block_user_logic_logged'],
																				'block_user_logic_logged_role' => explode(",", $atts['block_user_logic_logged_role']),)
																);
				break;

			case 'new_account':
				ob_start();
				if(!is_user_logged_in()){
				?>
				<div id="<?php echo esc_attr($atts['block_id']);?>_field" class="ossvn-new-customer-block">
					<h4><?php echo esc_html($atts['block_title']);?></h4>
					<div class="uk-form ossvn-select-checkout-method">
						
						<?php 
						$guest_checkout = get_option( 'woocommerce_enable_guest_checkout' ) == 'yes' ? true : false;
						if( $guest_checkout == true ):
						?>
						<div class="ossvn-option">
							<input id="r1" type="radio" name="createaccount" value="0"> <label for="r1"><?php _e('Checkout as a Guest', 'wct');?></label>
						</div>
						<?php endif;?>

						<?php 
						$create_acc = get_option( 'woocommerce_enable_signup_and_login_from_checkout' ) == 'yes' ? true : false;
						if( $create_acc == true ):
						?>
						<div class="ossvn-option">
							<p class="create-account">
								<input class="input-checkbox" id="createaccount" type="radio" name="createaccount" value="1"><label for="r2"><?php _e('Create a New account', 'wct')?></label>
							</p>
						</div>
						<?php endif;?>

					</div>
					<p><?php _e('Register with us for future convenience', 'wct');?>: <br>+ <?php _e('Fast and easy checkout', 'wct');?>. <br>+ <?php _e('Easy access to your order history and status', 'wct');?>.</p>
				</div><!--/.ossvn-new-customer -->
				<?php
				}else{?>
				<div class="user-logged-in">
					<?php
					$current_user = wp_get_current_user();
					echo sprintf( '<p>%s <strong><a href="%s">%s</a></strong></p>', __('You are now logged in as', 'wct'), esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ), esc_html($current_user->display_name) );
					?>
				</div>
				<?php
				}
				$out .= ob_get_contents();
				ob_end_clean();
				break;

			case 'login_form':
				ob_start();
				load_template( WCT_DIR . '/woocommerce/checkout/form-login.php');
				$out .= ob_get_contents();
				ob_end_clean();
				break;

			case 'woo_field':

				$woo_class = $class;

				$checkout = WC()->checkout();

				$validate_class = array();
				ob_start();
				if($atts['woo_field_id'] == 'billing_country'){
					$default = get_option('woocommerce_default_country');
				}else{
					$default = '';
				}
				if($atts['woo_field_id'] == 'billing_state'){
					$validate_class[] = 'state';
				}
				if( $atts['woo_field_id'] == 'billing_email' || $atts['woo_field_id'] == 'shipping_email' ){
					$validate_class[] = 'email';
				}
				if($atts['woo_field_id'] == 'billing_postcode'){
					$validate_class[] = 'postcode';
				}
				if($atts['woo_field_id'] == 'billing_phone'){
					$validate_class[] = 'phone';
				}

				if( $atts['woo_field_id'] == 'billing_country' || $atts['woo_field_id'] == 'shipping_country' ){
					$woo_class .= ' address-field update_totals_on_change ';
				}

				if( $atts['woo_field_id'] == 'billing_address_1' || $atts['woo_field_id'] == 'billing_state' ){
					$woo_class .= ' address-field ';
				}

				woocommerce_form_field( 

										$atts['woo_field_id'], 
										array( 
											'type'=>$atts['woo_field_type'], 
											'label'=> wp_kses_post( $block_title ), 
											'placeholder'=> $placeholder, 
											'required'=> $required, 
											'id'=> $atts['woo_field_id'], 
											'class'=> array( $woo_class, esc_attr($class_logic), esc_attr($class_logic_all),  esc_attr($ext_class), 'form-row-woo' ), 
											'validate'=> $validate_class, 
											'default'=>$default  
											), 
										$checkout->get_value( $atts['woo_field_id'] ) 
									);
				?>
				<?php
				$out .= ob_get_contents();
				ob_end_clean();
				break;

			case 'your_order':
				ob_start();
				load_template( WCT_DIR . 'woocommerce/checkout/review-order.php' );
				$out .= ob_get_contents();
				ob_end_clean();
				break;

			case 'payment':
				ob_start();
				load_template( WCT_DIR . 'woocommerce/checkout/payment.php' );
				$out .= ob_get_contents();
				ob_end_clean();
				break;

			case 'different_address':
				$checkout = WC()->checkout();
				ob_start();
				if ( empty( $_POST ) ) {

					$ship_to_different_address = get_option( 'woocommerce_ship_to_destination' ) === 'shipping' ? 1 : 0;
					$ship_to_different_address = apply_filters( 'woocommerce_ship_to_different_address_checked', $ship_to_different_address );

				} else {

					$ship_to_different_address = $checkout->get_value( 'ship_to_different_address' );

				}
				?>
				<h3 id="ship-to-different-address">
					<label for="ship-to-different-address-checkbox" class="checkbox"><?php _e( 'Ship to a different address?', 'wct' ); ?></label>
					<input id="ship-to-different-address-checkbox" class="input-text input-checkbox" <?php checked( $ship_to_different_address, 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" />
				</h3>
				<?php
				$out .= ob_get_contents();
				ob_end_clean();
				break;

			case 'process':
				ob_start();
				?>
				<div id="<?php echo esc_attr($atts['block_id']);?>" class="ossvn-process-block <?php echo esc_attr( $progressbar_position );?> <?php echo esc_attr( $progressbar_style );?>">
					<div class="ossvn-text"><?php _e('Ordering...', 'wct');?></div>
						<div class="ossvn-process">
							<div class="ossvn-process-bar" style="width: 0%"><span>0%</span>
						</div>
					</div>
				</div>
				<?php
				$out .= ob_get_contents();
				ob_end_clean();
				break;

			case 'sidebar':
				if(is_active_sidebar('wct-sidebar') || is_active_sidebar('wct-sidebar-bottom')){
					ob_start();
					if($atts['woo_field_id'] == 'wct_sidebar'){
						require( WCT_DIR . '/woocommerce/checkout/wct-sidebar.php');
					}else{
						require( WCT_DIR . '/woocommerce/checkout/wct-sidebar-bottom.php');
					}
					$out .= ob_get_contents();
					ob_end_clean();
				}else{
					$out .= '';
				}
				break;

			case 'order_success':
				if(get_query_var('order-received') > 0){
					$success = 'ossvn-order-success';
				}else{
					$success = '';
				}
				ob_start();
				?>
				<div class="ossvn-order-success <?php echo esc_attr($success);?>">
					<?php 
					if(isset($atts['block_title']) && !empty($atts['block_title'])){
						echo '<h3>'.esc_html($atts['block_title']).'</h3>';
					}else{
						echo '<h3>'.__('Order success!', 'wct').'</h3>';
					}
					if(isset($atts['order_success_p']) && !empty($atts['order_success_p'])){
						echo wp_kses_post(wpautop(html_entity_decode($atts['order_success_p'])));
					}else{
						echo '<p>'.__('Thanks for ordering.', 'wct').'</p>';
					}
					?>
				</div>
				<?php
				$out .= ob_get_contents();
				ob_end_clean();
				break;

			/**
			* Add new shortcode output html
			*
			* @author Comfythemes
			* @since 1.2
			*/
			case 'html':
				ob_start();

				if( isset($atts['ossvn_html_content_p']) && !empty($atts['ossvn_html_content_p']) ){
					echo wp_kses_post(wpautop(html_entity_decode($atts['ossvn_html_content_p'])));
				}

				$out .= ob_get_contents();
				ob_end_clean();
				break;

			default:
				$out .= '';
				break;
		}

		return $out;
	}


	/**
	* Shortcode [html][/html]
	*/
	public function wct_html( $atts, $content = null ){
		return wp_kses_post(wpautop($content));;
	}
}

/*
* Run shortcode
*/
new WCT_Shortcode();
?>
