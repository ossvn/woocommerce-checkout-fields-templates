<?php 
/**
 * Widget coupon class.
 *
 * @link       http://demo.comfythemes.com/wct/
 * @since      1.0
 *
 * @package    woocommerce-checkout-templates
 * @subpackage woocommerce-checkout-templates/classes
 * @author     OSVN <contact@outsourcevietnam.co>
 * @coder Nam
 */
defined( 'ABSPATH' ) OR exit;

// Creating the coupon widget 
class WCT_Widget_Coupon extends WP_Widget {

	function WCT_Widget_Coupon() {
		parent::__construct(
			// Base ID of your widget
			'WCT_Widget_Coupon', 

			// Widget name will appear in UI
			__('* WCT coupon', 'wct'), 

			// Widget description
			array( 'classname' => 'ossvn-coupon-block', 'description' => __( 'Widget for checkout template', 'wct' ), ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if(!empty($title)){echo $args['before_title'].$title.$args['after_title'];}
		if(isset($instance['description']) && !empty($instance['description'])){echo wpautop($instance['description']);}
		?>
		<div id="wct_coupon_widget" class="coupon">
			<div class="checkout_coupon">
				<?php $coupon_enable = get_option( 'woocommerce_enable_coupons' ) == 'yes' ? true : false;?>
				<?php if( $coupon_enable == true ):?>
					<label for="coupon_code"><?php _e('Coupon', 'wct');?></label> 
					<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php _e('Coupon code', 'wct');?>">
					<input type="submit" class="button" name="apply_coupon" value="<?php _e('Apply Coupon', 'wct');?>">
				<?php else:?>
					<div class="uk-alert uk-alert-warning" style="padding: 10px;background: #fffceb;color: #e28327;border: solid 1px rgba(226,131,39,.3);"><p><?php _e('Please Enable Coupon Usage in Checkout Setting of WooCommerce.', 'wct');?></p></div>
				<?php endif;?>
			</div>
		</div>
		<?php 
		echo $args['after_widget'];
	}
		
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}else{
			$title = __( 'Have a coupon', 'wct' );
		}

		if ( isset( $instance[ 'description' ] ) ) {
			$description = $instance[ 'description' ];
		}else{
			$description = '';
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:' ); ?></label> 
			<textarea class="widefat" rows="16" cols="10" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo esc_textarea(stripslashes($description)); ?></textarea>
		</p>
	<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? stripslashes( $new_instance['description'] ) : '';
		return $instance;
	}
} 
/*=======Class WCT_Widget_Coupon ends here======*/


/*=======Class WCT_Widget_Order begin here======*/

class WCT_Widget_Order extends WP_Widget {

	function WCT_Widget_Order() {
		parent::__construct(
			// Base ID of your widget
			'WCT_Widget_Order', 

			// Widget name will appear in UI
			__('* WCT order summary', 'wct'), 

			// Widget description
			array( 'classname'=> 'ossvn-order-summary-block', 'description' => __( 'Widget for checkout template', 'wct' ), ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		if(isset($instance[ 'template_display_type' ]) && !empty($instance[ 'template_display_type' ])){
			$template = $instance[ 'template_display_type' ];
		}else{
			$template = 2;
		}
		// before and after widget arguments are defined by themes

		if(WC()->cart->get_cart()):
		echo $args['before_widget'];
		if(!empty($title)){echo $args['before_title'].$title.$args['after_title'];}
		echo '<div class="flexslider"><ul class="slides">';
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

				if($template == 2){
					global $woocommerce;
		?>
				<li>
					<div class="ossvn-product-order">
						<div class="ossvn-body">
							<div class="ossvn-left">
								<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('order-summary-thumb'), $cart_item, $cart_item_key );

								if ( ! $_product->is_visible() )
									echo $thumbnail;
								else
									printf( '<a href="%s" class="ossvn-thumb">%s<span>%s</span></a>', $_product->get_permalink( $cart_item ), $thumbnail, $_product->get_title() );
								?>
								<div class="ossvn-controls">
									<button type="button" class="ossvn-control ossvn-remove-item" onclick='location.href="<?php echo esc_url( WC()->cart->get_remove_url( $cart_item_key ));?>"'><i class="fa fa-times"></i> <?php _e('Remove Item', 'wct');?></button>
									<button type="button" class="ossvn-control ossvn-empty-cart" onclick='location.href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>?empty-cart"'><i class="fa fa-shopping-cart"></i> <?php _e('Empty Cart', 'wct');?></button>
								</div>
							</div>
							<div class="ossvn-center">
								<?php if(WC()->cart->get_item_data( $cart_item )):?>
								<span class="ossvn-label"><?php _e('Your selection', 'wct');?>:</span>
								<?php echo $this->wct_get_item_data($cart_item, false, $instance);?>
								<?php endif;?>
							</div>
							<div class="ossvn-right">
								<div class="ossvn-item-price">
									<p><?php _e('Price for your order', 'wct');?>:  <span><?php echo esc_html($_product->get_title());?></span></p>
									<?php printf('<strong>%s</strong> x %s = <strong>%s</strong>', WC()->cart->get_product_price( $_product ), $cart_item['quantity'], WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ));?>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						<div class="ossvn-bottom">
							<span><?php _e('Order Total', 'wct');?>:</span>
							<span class="red">
								<?php
									echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
								?>
							</span>
						</div>
					</div>
				</li>
				<?php }else{?>
				<li>
					<div class="ossvn-product-order">
						<div class="ossvn-body">
							<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('order-summary-thumb'), $cart_item, $cart_item_key );

							if ( ! $_product->is_visible() )
								echo $thumbnail;
							else
								printf( '<a href="%s" class="ossvn-thumb">%s<span>%s</span></a>', $_product->get_permalink( $cart_item ), $thumbnail, $_product->get_title() );
							?>

							<?php if(WC()->cart->get_item_data( $cart_item )):?>
							<span class="ossvn-label"><?php _e('Your selection', 'wct');?>:</span>
							<?php echo $this->wct_get_item_data($cart_item, false, $instance);?>
							<?php endif;?>

						</div>
						<div class="ossvn-bottom">
							<span><?php _e('Order Total', 'wct');?>:</span>
							<span class="red">
								<?php
									echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
								?>
							</span>
						</div>
					</div>
				</li>
				<?php }?>
		<?php 
			}
		}
		echo '</ul></div>';
		endif;
		echo $args['after_widget'];
	}

	/**
	* Gets and formats a list of cart item data + variations for display on the frontend.
	* @since 1.0
	* @param $cart_item(array), $flat(true/false)
	* @return string
	*/
	public function wct_get_item_data( $cart_item, $flat = false, $instance ){
		$item_data = array();
	      // Variation data
	      if ( ! empty( $cart_item['data']->variation_id ) && is_array( $cart_item['variation'] ) ) {

	        foreach ( $cart_item['variation'] as $name => $value ) {

	          if ( '' === $value )
	            continue;

	          $taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );

	          // If this is a term slug, get the term's nice name
	          if ( taxonomy_exists( $taxonomy ) ) {
	            $term = get_term_by( 'slug', $value, $taxonomy );
	            if ( ! is_wp_error( $term ) && $term && $term->name ) {
	              $value = $term->name;
	            }
	            $label = wc_attribute_label( $taxonomy );

	          // If this is a custom option slug, get the options name
	          } else {
	            $value              = apply_filters( 'woocommerce_variation_option_name', $value );
	            $product_attributes = $cart_item['data']->get_attributes();
	            if ( isset( $product_attributes[ str_replace( 'attribute_', '', $name ) ] ) ) {
	              $label = wc_attribute_label( $product_attributes[ str_replace( 'attribute_', '', $name ) ]['name'] );
	            } else {
	              $label = $name;
	            }
	          }

	          $item_data[] = array(
	            'key'   => $label,
	            'value' => $value
	          );
	        }
	      }


	      // Other data - returned as array with name/value values
	      $other_data = apply_filters( 'woocommerce_get_item_data', array(), $cart_item );
	      if ( $other_data && is_array( $other_data ) && sizeof( $other_data ) > 0 ) {

	        foreach ( $other_data as $data ) {
	          // Set hidden to true to not display meta on cart.
	          if ( empty( $data['hidden'] ) ) {
	            $display_value = ! empty( $data['display'] ) ? $data['display'] : $data['value'];

	            $item_data[] = array(
	              'key'   => $data['name'],
	              'value' => $display_value
	            );
	          }
	        }
	      }

	      // Output flat or in list format
	      if ( sizeof( $item_data ) > 0 ) {

	        ob_start();

	        if ( $flat ) {
	          foreach ( $item_data as $data ) {
	            echo esc_html( $data['key'] ) . ': ' . wp_kses_post( $data['value'] ) . "\n";
	          }
	        } else {
	        	foreach ( $item_data as $data ) {
	        		$key = sanitize_text_field( $data['key'] );
	        			
	        			if( $order_setting = get_option('widget_wct_widget_order') ):
			        		
			        		if( array_key_exists( ''.esc_attr(strtolower($data['key'])).'_variables_'.esc_attr(strtolower($data['value'])).'_type', $order_setting[$this->number] ) ):

			        			$type = ''.esc_attr(strtolower($data['key'])).'_variables_'.esc_attr(strtolower($data['value'])).'_type';
			        		?>
			        		<div class="ossvn-type">
			        			<span class="ossvn-label"><?php echo wp_kses_post( $data['key'] ); ?></span>
			        			<ul class="ossvn-<?php echo esc_attr(strtolower($data['key']));?>-list">
									<?php 
									switch ($instance[$type]) {
										case ''.esc_attr(strtolower($data['key'])).'-variables-'.esc_attr(strtolower($data['value'])).'-color':
											?>
											<?php echo $this->wct_print_attribute_item(strtolower($data['key']), $instance, strtolower($data['value']));?>
											<?php
											break;
										case ''.esc_attr(strtolower($data['key'])).'-variables-'.esc_attr(strtolower($data['value'])).'-img':
											?>
											<?php echo $this->wct_print_attribute_item(strtolower($data['key']), $instance, strtolower($data['value']));?>
											<?php
											break;
										case ''.esc_attr(strtolower($data['key'])).'-variables-'.esc_attr(strtolower($data['value'])).'-icon':
											?>
											<?php echo $this->wct_print_attribute_item(strtolower($data['key']), $instance, strtolower($data['value']));?>
											<?php
											break;
										
										default:
											?>
											<?php echo $this->wct_print_attribute_item(strtolower($data['key']), $instance, strtolower($data['value']));?>
											<?php
											break;
									}
									?>
								</ul>
			        		</div>
			        		<?php
			        		endif;//check if $instance[$type]

			        	endif;//check if widget_wct_widget_order
	        	}
	        }

	        return ob_get_clean();
	      }

	      return '';
	}

	/**
	* Print attribute item.
	* @since 1.0
	* @param $key(string), $instance(array), $selected(string)
	* @return string. EX: <li class="selected">L</li>
	*/

	private function wct_print_attribute_item($key, $instance, $selected){
		$attr_array = WCT_Admin::wct_get_attribute();
		$out = '';
		if(!empty($attr_array)){
			foreach ($attr_array[$key] as $value) {
				if($selected == $value->slug){
					$class_selected = 'class="selected"';
				}else{
					$class_selected = '';
				}
				$type = ''.esc_attr(strtolower($key)).'_variables_'.esc_attr(strtolower($value->slug)).'_type';
				switch ($instance[$type]) {
					case ''.esc_attr(strtolower($key)).'-variables-'.esc_attr(strtolower($value->slug)).'-color':
						$out .= '<li '.$class_selected.' style="background: '.esc_attr($instance[''.esc_attr(strtolower($key)).'-variables-'.esc_attr(strtolower($value->slug)).'-color-input']).'"></li>';
						break;

					case ''.esc_attr(strtolower($key)).'-variables-'.esc_attr(strtolower($value->slug)).'-img':
						$out .= '<li '.$class_selected.'><img src="'.esc_attr($instance[''.esc_attr(strtolower($key)).'-variables-'.esc_attr(strtolower($value->slug)).'-img-input']).'"></li>';
						break;

					case ''.esc_attr(strtolower($key)).'-variables-'.esc_attr(strtolower($value->slug)).'-icon':
						$out .= '<li '.$class_selected.'><i class="'.esc_attr($instance[''.esc_attr(strtolower($key)).'-variables-'.esc_attr(strtolower($value->slug)).'-icon-input']).'"></i></li>';
						break;
					
					default:
						$out .= '<li '.$class_selected.'>'.esc_html($value->name).'</li>';
						break;
				}
			}
		}

		return $out;
	}
		
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}else{
			$title = __( 'Order summary', 'wct' );
		}
		// Widget admin form
		if ( isset( $instance[ 'template_display_type' ] ) ) {
			$template = $instance[ 'template_display_type' ];
		}else{
			$template = 2;
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'template_display_type' ); ?>"><?php _e( 'Display type:' ); ?></label> 
			<select name="<?php echo $this->get_field_name( 'template_display_type' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'template_display_type' ); ?>">
				<?php 
				$args_tems = array(
					'1' => __('Colorful', 'wct'),
					'2' => __('Step by steps', 'wct'),
					'3' => __('Flat', 'wct'),
					'4' => __('Accordion', 'wct'),
					'5' => __('Progress', 'wct')
				);
				foreach($args_tems as $key => $tem):
					echo '<option value="'.esc_attr($key).'" '.selected($template, $key).'>'.esc_html($tem).'</option>';
				endforeach;
				?>
			</select>
		</p>

		<div class="uk-accordion ossvn-accordion" data-uk-accordion="{showfirst: false}">
		<?php 
		$attr_array = WCT_Admin::wct_get_attribute();
		if($attr_array):
			foreach ($attr_array as $key => $value) {
				?>
				<h3 class="ossvn-title uk-accordion-title ossvn-multiple-block-title"><?php echo esc_html($key);?></h3>
				<div class="uk-accordion-content ossvn-multiple-block-content">
					<?php foreach ($value as $val) {?>
						<div class="accordion-container">
					        <div class="accordion collapsed">
								<div class="accordion-header" data-action="accordion" style="position: relative;">	
									<div class="attribute-label" data-class="pa_<?php echo esc_html($key);?>_<?php echo esc_html($val->slug);?>"><?php echo esc_html($val->name);?></div>
							    </div>
							 
							 
						        <div class="accordion-content pa_<?php echo esc_html($key);?>_<?php echo esc_html($val->slug);?>">
									<p class="form-field">
										<label for="_display_type">
											<span class="wcvaformfield"><?php _e('Display Type', 'wct');?></span>
										</label> 
									 	<select name="<?php echo $this->get_field_name( ''.esc_attr($key).'_variables_'.esc_attr($val->slug).'_type' ); ?>" id="<?php echo $this->get_field_id( 'coloredvariables-'.esc_attr($val->slug).'-type' ); ?>" class="wct-color-or-image">
								     		<option value="text"><?php _e('Text', 'wct');?></option>
								     		<option value="<?php echo esc_attr($key);?>-variables-<?php echo esc_attr($val->slug);?>-color" <?php selected( $instance[ ''.esc_attr($key).'_variables_'.esc_attr($val->slug).'_type' ], ''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-color' ); ?>><?php _e('Color', 'wct');?></option>
									 		<option value="<?php echo esc_attr($key);?>-variables-<?php echo esc_attr($val->slug);?>-img" <?php selected( $instance[ ''.esc_attr($key).'_variables_'.esc_attr($val->slug).'_type' ], ''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-img' ); ?>><?php _e('Image', 'wct');?></option>
									 		<option value="<?php echo esc_attr($key);?>-variables-<?php echo esc_attr($val->slug);?>-icon" <?php selected( $instance[ ''.esc_attr($key).'_variables_'.esc_attr($val->slug).'_type' ], ''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-icon' ); ?>><?php _e('Font icon', 'wct');?></option>
									 	</select>
									</p>

									<div class="wct-color-div" id="<?php echo esc_attr($key);?>-variables-<?php echo esc_attr($val->slug);?>-color" style="<?php if( isset($instance[ ''.esc_attr($key).'_variables_'.esc_attr($val->slug).'_type' ]) && $instance[ ''.esc_attr($key).'_variables_'.esc_attr($val->slug).'_type' ] == ''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-color'){echo 'display: block;';}else{echo 'display: none;';}?>">
										<div class="form-field">
											<label for="_chose_color"><span class="wct-aformfield"><?php _e('Chose Color', 'wct');?>:</span></label> 
									    	<input type="color" name="<?php echo $this->get_field_name(''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-color-input');?>" value="<?php if(!empty($instance[''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-color-input'])){ echo esc_attr($instance[''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-color-input']); }?>">
										</div>
									</div>

									<div class="wct-color-div" id="<?php echo esc_attr($key);?>-variables-<?php echo esc_attr($val->slug);?>-img" style="<?php if( isset($instance[ ''.esc_attr($key).'_variables_'.esc_attr($val->slug).'_type' ]) && $instance[ ''.esc_attr($key).'_variables_'.esc_attr($val->slug).'_type' ] == ''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-img'){echo 'display: block;';}else{echo 'display: none;';}?>">
										<div class="form-field">
											<label for="_chose_color"><span class="wct-aformfield"><?php _e('Upload image', 'wct');?>:</span></label> 
											<input type="hidden" class="wct_upload_url" name="<?php echo $this->get_field_name(''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-img-input');?>" value="<?php if(!empty($instance[''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-img-input'])){ echo esc_attr($instance[''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-img-input']); }?>">
									    	<input type="submit" class="wct_upload" name="Upload" value="Upload">
										</div>
										<div class="wct_upload_add_img"></div>
									</div>

									<div class="wct-color-div" id="<?php echo esc_attr($key);?>-variables-<?php echo esc_attr($val->slug);?>-icon" style="<?php if( isset($instance[ ''.esc_attr($key).'_variables_'.esc_attr($val->slug).'_type' ]) && $instance[ ''.esc_attr($key).'_variables_'.esc_attr($val->slug).'_type' ] == ''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-icon'){echo 'display: block;';}else{echo 'display: none;';}?>">
										<div class="form-field">
											<label for="_chose_color"><span class="wct-aformfield"><?php _e('Chose icon', 'wct');?>:</span></label> 
									    	<a class="icon" title="<?php _e('Select icon', 'wct');?>"><i class="<?php if(!empty($instance[''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-icon-input'])){ echo esc_attr($instance[''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-icon-input']); }else{echo 'fa fa-refresh';}?>"></i></a>
									    	<input type="hidden" name="<?php echo $this->get_field_name(''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-icon-input');?>" value="<?php if(!empty($instance[''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-icon-input'])){ echo esc_attr($instance[''.esc_attr($key).'-variables-'.esc_attr($val->slug).'-icon-input']); }?>">
										</div>
									</div>
								
									  
									
								</div>
							</div>
							 
						</div>
					<?php }?>
				</div>
				
				<?php
			}
			?>
				<div id="wct_overlay"></div>
				<div id="wct_load" style="display: none;"><img src="<?php echo esc_url(home_url('/wp-includes/js/thickbox/loadingAnimation.gif'));?>" width="208"></div>
				<div id="wct-popup-thickbox" style="display:none;">
					<h2><?php _e('Select an icon for your social', 'wct');?></h2>

					<?php 
					/*
					*==========================
					* Form filter icon
					*==========================
					*/
					?>
					<div class="wct-filter-icon">
					      <input type="text" name="wct_filter_icon_s" value="">
					      <input type="submit" name="wct_filter_icon_submit" value="<?php _e('Search', 'wct');?>">
					</div>

					<?php 
					/*
					*==========================
					* List all icon
					*==========================
					*/
					?>
					<ul id="bo-metro-zero-tb-fa" class="bo-tb-fa">
					      <h3><?php _e('Web Application Icons', 'wct');?></h3>
					      <ul class="clearfix h190">

					            <li><i class="fa fa-adjust"></i></li>
					          
					            <li><i class="fa fa-anchor"></i></li>
					          
					            <li><i class="fa fa-archive"></i></li>
					          
					            <li><i class="fa fa-arrows"></i></li>
					          
					            <li><i class="fa fa-arrows-h"></i></li>
					          
					            <li><i class="fa fa-arrows-v"></i></li>
					          
					            <li><i class="fa fa-asterisk"></i></li>
					          
					            <li><i class="fa fa-ban"></i></li>
					          
					            <li><i class="fa fa-bar-chart-o"></i></li>
					          
					            <li><i class="fa fa-barcode"></i></li>
					          
					            <li><i class="fa fa-bars"></i></li>
					          
					            <li><i class="fa fa-beer"></i></li>
					          
					            <li><i class="fa fa-bell"></i></li>
					          
					            <li><i class="fa fa-bell-o"></i></li>
					          
					            <li><i class="fa fa-bolt"></i></li>
					          
					            <li><i class="fa fa-book"></i></li>
					          
					            <li><i class="fa fa-bookmark"></i></li>
					          
					            <li><i class="fa fa-bookmark-o"></i></li>
					          
					            <li><i class="fa fa-briefcase"></i></li>
					          
					            <li><i class="fa fa-bug"></i></li>
					          
					            <li><i class="fa fa-building-o"></i></li>
					          
					            <li><i class="fa fa-bullhorn"></i></li>
					          
					            <li><i class="fa fa-bullseye"></i></li>
					          
					            <li><i class="fa fa-calendar"></i></li>
					          
					            <li><i class="fa fa-calendar-o"></i></li>
					          
					            <li><i class="fa fa-camera"></i></li>
					          
					            <li><i class="fa fa-camera-retro"></i></li>
					          
					            <li><i class="fa fa-caret-square-o-down"></i></li>
					          
					            <li><i class="fa fa-caret-square-o-left"></i></li>
					          
					            <li><i class="fa fa-caret-square-o-right"></i></li>
					          
					            <li><i class="fa fa-caret-square-o-up"></i></li>
					          
					            <li><i class="fa fa-certificate"></i></li>
					          
					            <li><i class="fa fa-check"></i></li>
					          
					            <li><i class="fa fa-check-circle"></i></li>
					          
					            <li><i class="fa fa-check-circle-o"></i></li>
					          
					            <li><i class="fa fa-check-square"></i></li>
					          
					            <li><i class="fa fa-check-square-o"></i></li>
					          
					            <li><i class="fa fa-circle"></i></li>
					          
					            <li><i class="fa fa-circle-o"></i></li>
					          
					            <li><i class="fa fa-clock-o"></i></li>
					          
					            <li><i class="fa fa-cloud"></i></li>
					          
					            <li><i class="fa fa-cloud-download"></i></li>
					          
					            <li><i class="fa fa-cloud-upload"></i></li>
					          
					            <li><i class="fa fa-code"></i></li>
					          
					            <li><i class="fa fa-code-fork"></i></li>
					          
					            <li><i class="fa fa-coffee"></i></li>
					          
					            <li><i class="fa fa-cog"></i></li>
					          
					            <li><i class="fa fa-cogs"></i></li>
					          
					            <li><i class="fa fa-comment"></i></li>
					          
					            <li><i class="fa fa-comment-o"></i></li>
					          
					            <li><i class="fa fa-comments"></i></li>
					          
					            <li><i class="fa fa-comments-o"></i></li>
					          
					            <li><i class="fa fa-compass"></i></li>
					          
					            <li><i class="fa fa-credit-card"></i></li>
					          
					            <li><i class="fa fa-crop"></i></li>
					          
					            <li><i class="fa fa-crosshairs"></i></li>
					          
					            <li><i class="fa fa-cutlery"></i></li>
					          
					            <li><i class="fa fa-dashboard"></i></li>
					          
					            <li><i class="fa fa-desktop"></i></li>
					          
					            <li><i class="fa fa-dot-circle-o"></i></li>
					          
					            <li><i class="fa fa-download"></i></li>
					          
					            <li><i class="fa fa-edit"></i></li>
					          
					            <li><i class="fa fa-ellipsis-h"></i></li>
					          
					            <li><i class="fa fa-ellipsis-v"></i></li>
					          
					            <li><i class="fa fa-envelope"></i></li>
					          
					            <li><i class="fa fa-envelope-o"></i></li>
					          
					            <li><i class="fa fa-eraser"></i></li>
					          
					            <li><i class="fa fa-exchange"></i></li>
					          
					            <li><i class="fa fa-exclamation"></i></li>
					          
					            <li><i class="fa fa-exclamation-circle"></i></li>
					          
					            <li><i class="fa fa-exclamation-triangle"></i></li>
					          
					            <li><i class="fa fa-external-link"></i></li>
					          
					            <li><i class="fa fa-external-link-square"></i></li>
					          
					            <li><i class="fa fa-eye"></i></li>
					          
					            <li><i class="fa fa-eye-slash"></i></li>
					          
					            <li><i class="fa fa-female"></i></li>
					          
					            <li><i class="fa fa-fighter-jet"></i></li>
					          
					            <li><i class="fa fa-film"></i></li>
					          
					            <li><i class="fa fa-filter"></i></li>
					          
					            <li><i class="fa fa-fire"></i></li>
					          
					            <li><i class="fa fa-fire-extinguisher"></i></li>
					          
					            <li><i class="fa fa-flag"></i></li>
					          
					            <li><i class="fa fa-flag-checkered"></i></li>
					          
					            <li><i class="fa fa-flag-o"></i></li>
					          
					            <li><i class="fa fa-flash"></i></li>
					          
					            <li><i class="fa fa-flask"></i></li>
					          
					            <li><i class="fa fa-folder"></i></li>
					          
					            <li><i class="fa fa-folder-o"></i></li>
					          
					            <li><i class="fa fa-folder-open"></i></li>
					          
					            <li><i class="fa fa-folder-open-o"></i></li>
					          
					            <li><i class="fa fa-frown-o"></i></li>
					          
					            <li><i class="fa fa-gamepad"></i></li>
					          
					            <li><i class="fa fa-gavel"></i></li>
					          
					            <li><i class="fa fa-gear"></i></li>
					          
					            <li><i class="fa fa-gears"></i></li>
					          
					            <li><i class="fa fa-gift"></i></li>
					          
					            <li><i class="fa fa-glass"></i></li>
					          
					            <li><i class="fa fa-globe"></i></li>
					          
					            <li><i class="fa fa-group"></i></li>
					          
					            <li><i class="fa fa-hdd-o"></i></li>
					          
					            <li><i class="fa fa-headphones"></i></li>
					          
					            <li><i class="fa fa-heart"></i></li>
					          
					            <li><i class="fa fa-heart-o"></i></li>
					          
					            <li><i class="fa fa-home"></i></li>
					          
					            <li><i class="fa fa-inbox"></i></li>
					          
					            <li><i class="fa fa-info"></i></li>
					          
					            <li><i class="fa fa-info-circle"></i></li>
					          
					            <li><i class="fa fa-key"></i></li>
					          
					            <li><i class="fa fa-keyboard-o"></i></li>
					          
					            <li><i class="fa fa-laptop"></i></li>
					          
					            <li><i class="fa fa-leaf"></i></li>
					          
					            <li><i class="fa fa-legal"></i></li>
					          
					            <li><i class="fa fa-lemon-o"></i></li>
					          
					            <li><i class="fa fa-level-down"></i></li>
					          
					            <li><i class="fa fa-level-up"></i></li>
					          
					            <li><i class="fa fa-lightbulb-o"></i></li>
					          
					            <li><i class="fa fa-location-arrow"></i></li>
					          
					            <li><i class="fa fa-lock"></i></li>
					          
					            <li><i class="fa fa-magic"></i></li>
					          
					            <li><i class="fa fa-magnet"></i></li>
					          
					            <li><i class="fa fa-mail-forward"></i></li>
					          
					            <li><i class="fa fa-mail-reply"></i></li>
					          
					            <li><i class="fa fa-mail-reply-all"></i></li>
					          
					            <li><i class="fa fa-male"></i></li>
					          
					            <li><i class="fa fa-map-marker"></i></li>
					          
					            <li><i class="fa fa-meh-o"></i></li>
					          
					            <li><i class="fa fa-microphone"></i></li>
					          
					            <li><i class="fa fa-microphone-slash"></i></li>
					          
					            <li><i class="fa fa-minus"></i></li>
					          
					            <li><i class="fa fa-minus-circle"></i></li>
					          
					            <li><i class="fa fa-minus-square"></i></li>
					          
					            <li><i class="fa fa-minus-square-o"></i></li>
					          
					            <li><i class="fa fa-mobile"></i></li>
					          
					            <li><i class="fa fa-mobile-phone"></i></li>
					          
					            <li><i class="fa fa-money"></i></li>
					          
					            <li><i class="fa fa-moon-o"></i></li>
					          
					            <li><i class="fa fa-music"></i></li>
					          
					            <li><i class="fa fa-pencil"></i></li>
					          
					            <li><i class="fa fa-pencil-square"></i></li>
					          
					            <li><i class="fa fa-pencil-square-o"></i></li>
					          
					            <li><i class="fa fa-phone"></i></li>
					          
					            <li><i class="fa fa-phone-square"></i></li>
					          
					            <li><i class="fa fa-picture-o"></i></li>
					          
					            <li><i class="fa fa-plane"></i></li>
					          
					            <li><i class="fa fa-plus"></i></li>
					          
					            <li><i class="fa fa-plus-circle"></i></li>
					          
					            <li><i class="fa fa-plus-square"></i></li>
					          
					            <li><i class="fa fa-plus-square-o"></i></li>
					       
					            <li><i class="fa fa-power-off"></i></li>
					          
					            <li><i class="fa fa-print"></i></li>
					          
					            <li><i class="fa fa-puzzle-piece"></i></li>
					          
					            <li><i class="fa fa-qrcode"></i></li>
					          
					            <li><i class="fa fa-question"></i></li>
					          
					            <li><i class="fa fa-question-circle"></i></li>
					          
					            <li><i class="fa fa-quote-left"></i></li>
					          
					            <li><i class="fa fa-quote-right"></i></li>
					          
					            <li><i class="fa fa-random"></i></li>
					          
					            <li><i class="fa fa-refresh"></i></li>
					          
					            <li><i class="fa fa-reply"></i></li>
					          
					            <li><i class="fa fa-reply-all"></i></li>
					          
					            <li><i class="fa fa-retweet"></i></li>
					          
					            <li><i class="fa fa-road"></i></li>
					          
					            <li><i class="fa fa-rocket"></i></li>
					          
					            <li><i class="fa fa-rss"></i></li>
					          
					            <li><i class="fa fa-rss-square"></i></li>
					          
					            <li><i class="fa fa-search"></i></li>
					          
					            <li><i class="fa fa-search-minus"></i></li>
					          
					            <li><i class="fa fa-search-plus"></i></li>
					          
					            <li><i class="fa fa-share"></i></li>
					          
					            <li><i class="fa fa-share-square"></i></li>
					          
					            <li><i class="fa fa-share-square-o"></i></li>
					          
					            <li><i class="fa fa-shield"></i></li>
					          
					            <li><i class="fa fa-shopping-cart"></i></li>
					          
					            <li><i class="fa fa-sign-in"></i></li>
					          
					            <li><i class="fa fa-sign-out"></i></li>
					          
					            <li><i class="fa fa-signal"></i></li>
					          
					            <li><i class="fa fa-sitemap"></i></li>
					          
					            <li><i class="fa fa-smile-o"></i></li>
					          
					            <li><i class="fa fa-sort"></i></li>
					          
					            <li><i class="fa fa-sort-alpha-asc"></i></li>
					          
					            <li><i class="fa fa-sort-alpha-desc"></i></li>
					          
					            <li><i class="fa fa-sort-amount-asc"></i></li>
					          
					            <li><i class="fa fa-sort-amount-desc"></i></li>
					          
					            <li><i class="fa fa-sort-asc"></i></li>
					          
					            <li><i class="fa fa-sort-desc"></i></li>
					          
					            <li><i class="fa fa-sort-down"></i></li>
					          
					            <li><i class="fa fa-sort-numeric-asc"></i></li>
					          
					            <li><i class="fa fa-sort-numeric-desc"></i></li>
					          
					            <li><i class="fa fa-sort-up"></i></li>
					          
					            <li><i class="fa fa-spinner"></i></li>
					          
					            <li><i class="fa fa-square"></i></li>
					          
					            <li><i class="fa fa-square-o"></i></li>
					          
					            <li><i class="fa fa-star"></i></li>
					          
					            <li><i class="fa fa-star-half"></i></li>
					          
					            <li><i class="fa fa-star-half-empty"></i></li>
					          
					            <li><i class="fa fa-star-half-full"></i></li>
					          
					            <li><i class="fa fa-star-half-o"></i></li>
					          
					            <li><i class="fa fa-star-o"></i></li>
					          
					            <li><i class="fa fa-subscript"></i></li>
					          
					            <li><i class="fa fa-suitcase"></i></li>
					          
					            <li><i class="fa fa-sun-o"></i></li>
					          
					            <li><i class="fa fa-superscript"></i></li>
					          
					            <li><i class="fa fa-tablet"></i></li>
					          
					            <li><i class="fa fa-tachometer"></i></li>
					          
					            <li><i class="fa fa-tag"></i></li>
					          
					            <li><i class="fa fa-tags"></i></li>
					          
					            <li><i class="fa fa-tasks"></i></li>
					          
					            <li><i class="fa fa-terminal"></i></li>
					          
					            <li><i class="fa fa-thumb-tack"></i></li>
					          
					            <li><i class="fa fa-thumbs-down"></i></li>
					          
					            <li><i class="fa fa-thumbs-o-down"></i></li>
					          
					            <li><i class="fa fa-thumbs-o-up"></i></li>
					          
					            <li><i class="fa fa-thumbs-up"></i></li>
					          
					            <li><i class="fa fa-ticket"></i></li>
					          
					            <li><i class="fa fa-times"></i></li>
					          
					            <li><i class="fa fa-times-circle"></i></li>
					          
					            <li><i class="fa fa-times-circle-o"></i></li>
					          
					            <li><i class="fa fa-tint"></i></li>
					          
					            <li><i class="fa fa-toggle-down"></i></li>
					          
					            <li><i class="fa fa-toggle-left"></i></li>
					          
					            <li><i class="fa fa-toggle-right"></i></li>
					          
					            <li><i class="fa fa-toggle-up"></i></li>
					          
					            <li><i class="fa fa-trash-o"></i></li>
					          
					            <li><i class="fa fa-trophy"></i></li>
					          
					            <li><i class="fa fa-truck"></i></li>
					          
					            <li><i class="fa fa-umbrella"></i></li>
					          
					            <li><i class="fa fa-unlock"></i></li>
					          
					            <li><i class="fa fa-unlock-alt"></i></li>
					          
					            <li><i class="fa fa-unsorted"></i></li>
					          
					            <li><i class="fa fa-upload"></i></li>
					          
					            <li><i class="fa fa-user"></i></li>
					          
					            <li><i class="fa fa-users"></i></li>
					          
					            <li><i class="fa fa-video-camera"></i></li>
					          
					            <li><i class="fa fa-volume-down"></i></li>
					          
					            <li><i class="fa fa-volume-off"></i></li>
					          
					            <li><i class="fa fa-volume-up"></i></li>
					          
					            <li><i class="fa fa-warning"></i></li>
					          
					            <li><i class="fa fa-wheelchair"></i></li>
					          
					            <li><i class="fa fa-wrench"></i></li>
					      </ul>

					      <h3><?php _e('Form Control Icons', 'wct');?></h3>
					      <ul class="clearfix">
					            <li><i class="fa fa-check-square"></i></li>
					          
					            <li><i class="fa fa-check-square-o"></i></li>
					          
					            <li><i class="fa fa-circle"></i></li>
					          
					            <li><i class="fa fa-circle-o"></i></li>
					          
					            <li><i class="fa fa-dot-circle-o"></i></li>
					          
					            <li><i class="fa fa-minus-square"></i></li>
					          
					            <li><i class="fa fa-minus-square-o"></i></li>
					          
					            <li><i class="fa fa-plus-square"></i></li>
					          
					            <li><i class="fa fa-plus-square-o"></i></li>
					          
					            <li><i class="fa fa-square"></i></li>
					          
					            <li><i class="fa fa-square-o"></i></li>
					      </ul>
					        
					      <h3><?php _e('Currency Icons', 'wct');?></h3>
					      <ul class="clearfix">
					            <li><i class="fa fa-bitcoin"></i></li>
					          
					            <li><i class="fa fa-btc"></i></li>
					          
					            <li><i class="fa fa-cny"></i></li>
					          
					            <li><i class="fa fa-dollar"></i></li>
					          
					            <li><i class="fa fa-eur"></i></li>
					          
					            <li><i class="fa fa-euro"></i></li>
					          
					            <li><i class="fa fa-gbp"></i></li>
					          
					            <li><i class="fa fa-inr"></i></li>
					          
					            <li><i class="fa fa-jpy"></i></li>
					          
					            <li><i class="fa fa-krw"></i></li>
					          
					            <li><i class="fa fa-money"></i></li>
					          
					            <li><i class="fa fa-rmb"></i></li>
					          
					            <li><i class="fa fa-rouble"></i></li>
					          
					            <li><i class="fa fa-rub"></i></li>
					          
					            <li><i class="fa fa-ruble"></i></li>
					          
					            <li><i class="fa fa-rupee"></i></li>
					          
					            <li><i class="fa fa-try"></i></li>
					          
					            <li><i class="fa fa-turkish-lira"></i></li>
					          
					            <li><i class="fa fa-usd"></i></li>
					          
					            <li><i class="fa fa-won"></i></li>
					          
					            <li><i class="fa fa-yen"></i></li>
					      </ul>

					      <h3><?php _e('Text Editor Icons', 'wct');?></h3>
					      <ul class="clearfix">
					            <li><i class="fa fa-align-center"></i></li>
					          
					            <li><i class="fa fa-align-justify"></i></li>
					          
					            <li><i class="fa fa-align-left"></i></li>
					          
					            <li><i class="fa fa-align-right"></i></li>
					          
					            <li><i class="fa fa-bold"></i></li>
					          
					            <li><i class="fa fa-chain"></i></li>
					          
					            <li><i class="fa fa-chain-broken"></i></li>
					          
					            <li><i class="fa fa-clipboard"></i></li>
					          
					            <li><i class="fa fa-columns"></i></li>
					          
					            <li><i class="fa fa-copy"></i></li>
					          
					            <li><i class="fa fa-cut"></i></li>
					          
					            <li><i class="fa fa-dedent"></i></li>
					          
					            <li><i class="fa fa-eraser"></i></li>
					          
					            <li><i class="fa fa-file"></i></li>
					          
					            <li><i class="fa fa-file-o"></i></li>
					          
					            <li><i class="fa fa-file-text"></i></li>
					          
					            <li><i class="fa fa-file-text-o"></i></li>
					          
					            <li><i class="fa fa-files-o"></i></li>
					          
					            <li><i class="fa fa-floppy-o"></i></li>
					          
					            <li><i class="fa fa-font"></i></li>
					          
					            <li><i class="fa fa-indent"></i></li>
					          
					            <li><i class="fa fa-italic"></i></li>
					          
					            <li><i class="fa fa-link"></i></li>
					          
					            <li><i class="fa fa-list"></i></li>
					          
					            <li><i class="fa fa-list-alt"></i></li>
					          
					            <li><i class="fa fa-list-ol"></i></li>
					          
					            <li><i class="fa fa-list-ul"></i></li>
					          
					            <li><i class="fa fa-outdent"></i></li>
					          
					            <li><i class="fa fa-paperclip"></i></li>
					          
					            <li><i class="fa fa-paste"></i></li>
					          
					            <li><i class="fa fa-repeat"></i></li>
					          
					            <li><i class="fa fa-rotate-left"></i></li>
					          
					            <li><i class="fa fa-rotate-right"></i></li>
					          
					            <li><i class="fa fa-save"></i></li>
					          
					            <li><i class="fa fa-scissors"></i></li>
					          
					            <li><i class="fa fa-strikethrough"></i></li>
					          
					            <li><i class="fa fa-table"></i></li>
					          
					            <li><i class="fa fa-text-height"></i></li>
					          
					            <li><i class="fa fa-text-width"></i></li>
					          
					            <li><i class="fa fa-th"></i></li>
					          
					            <li><i class="fa fa-th-large"></i></li>
					          
					            <li><i class="fa fa-th-list"></i></li>
					          
					            <li><i class="fa fa-underline"></i></li>
					          
					            <li><i class="fa fa-undo"></i></li>
					          
					            <li><i class="fa fa-unlink"></i></li>
					      </ul>
					       
					      <h3><?php _e('Directional Icons', 'wct');?></h3>
					      <ul class="clearfix">
					            <li><i class="fa fa-angle-double-down"></i></li>
					          
					            <li><i class="fa fa-angle-double-left"></i></li>
					          
					            <li><i class="fa fa-angle-double-right"></i></li>
					          
					            <li><i class="fa fa-angle-double-up"></i></li>
					          
					            <li><i class="fa fa-angle-down"></i></li>
					          
					            <li><i class="fa fa-angle-left"></i></li>
					          
					            <li><i class="fa fa-angle-right"></i></li>
					          
					            <li><i class="fa fa-angle-up"></i></li>
					          
					            <li><i class="fa fa-arrow-circle-down"></i></li>
					          
					            <li><i class="fa fa-arrow-circle-left"></i></li>
					          
					            <li><i class="fa fa-arrow-circle-o-down"></i></li>
					          
					            <li><i class="fa fa-arrow-circle-o-left"></i></li>
					          
					            <li><i class="fa fa-arrow-circle-o-right"></i></li>
					          
					            <li><i class="fa fa-arrow-circle-o-up"></i></li>
					          
					            <li><i class="fa fa-arrow-circle-right"></i></li>
					          
					            <li><i class="fa fa-arrow-circle-up"></i></li>
					          
					            <li><i class="fa fa-arrow-down"></i></li>
					          
					            <li><i class="fa fa-arrow-left"></i></li>
					          
					            <li><i class="fa fa-arrow-right"></i></li>
					          
					            <li><i class="fa fa-arrow-up"></i></li>
					          
					            <li><i class="fa fa-arrows"></i></li>
					          
					            <li><i class="fa fa-arrows-alt"></i></li>
					          
					            <li><i class="fa fa-arrows-h"></i></li>
					          
					            <li><i class="fa fa-arrows-v"></i></li>
					          
					            <li><i class="fa fa-caret-down"></i></li>
					          
					            <li><i class="fa fa-caret-left"></i></li>
					          
					            <li><i class="fa fa-caret-right"></i></li>
					          
					            <li><i class="fa fa-caret-square-o-down"></i></li>
					          
					            <li><i class="fa fa-caret-square-o-left"></i></li>
					          
					            <li><i class="fa fa-caret-square-o-right"></i></li>
					          
					            <li><i class="fa fa-caret-square-o-up"></i></li>
					          
					            <li><i class="fa fa-caret-up"></i></li>
					          
					            <li><i class="fa fa-chevron-circle-down"></i></li>
					          
					            <li><i class="fa fa-chevron-circle-left"></i></li>
					          
					            <li><i class="fa fa-chevron-circle-right"></i></li>
					          
					            <li><i class="fa fa-chevron-circle-up"></i></li>
					          
					            <li><i class="fa fa-chevron-down"></i></li>
					          
					            <li><i class="fa fa-chevron-left"></i></li>
					          
					            <li><i class="fa fa-chevron-right"></i></li>
					          
					            <li><i class="fa fa-chevron-up"></i></li>
					          
					            <li><i class="fa fa-hand-o-down"></i></li>
					          
					            <li><i class="fa fa-hand-o-left"></i></li>
					          
					            <li><i class="fa fa-hand-o-right"></i></li>
					          
					            <li><i class="fa fa-hand-o-up"></i></li>
					          
					            <li><i class="fa fa-long-arrow-down"></i></li>
					          
					            <li><i class="fa fa-long-arrow-left"></i></li>
					          
					            <li><i class="fa fa-long-arrow-right"></i></li>
					          
					            <li><i class="fa fa-long-arrow-up"></i></li>
					          
					            <li><i class="fa fa-toggle-down"></i></li>
					          
					            <li><i class="fa fa-toggle-left"></i></li>
					          
					            <li><i class="fa fa-toggle-right"></i></li>
					          
					            <li><i class="fa fa-toggle-up"></i></li>
					      </ul>

					      <h3><?php _e('Video Player Icons', 'wct');?></h3>
					      <ul class="clearfix">

					            <li><i class="fa fa-arrows-alt"></i></li>
					          
					            <li><i class="fa fa-backward"></i></li>
					          
					            <li><i class="fa fa-compress"></i></li>
					          
					            <li><i class="fa fa-eject"></i></li>
					          
					            <li><i class="fa fa-expand"></i></li>
					          
					            <li><i class="fa fa-fast-backward"></i></li>
					          
					            <li><i class="fa fa-fast-forward"></i></li>
					          
					            <li><i class="fa fa-forward"></i></li>
					          
					            <li><i class="fa fa-pause"></i></li>
					          
					            <li><i class="fa fa-play"></i></li>
					          
					            <li><i class="fa fa-play-circle"></i></li>
					          
					            <li><i class="fa fa-play-circle-o"></i></li>
					          
					            <li><i class="fa fa-step-backward"></i></li>
					          
					            <li><i class="fa fa-step-forward"></i></li>
					          
					            <li><i class="fa fa-stop"></i></li>
					          
					            <li><i class="fa fa-youtube-play"></i></li>
					      </ul>

					      <h3><?php _e('Brand Icons', 'wct');?></h3>
					      <ul class="clearfix">
					            <li><i class="fa fa-adn"></i></li>
					          
					            <li><i class="fa fa-android"></i></li>
					          
					            <li><i class="fa fa-apple"></i></li>
					          
					            <li><i class="fa fa-bitbucket"></i></li>
					          
					            <li><i class="fa fa-bitbucket-square"></i></li>
					          
					            <li><i class="fa fa-bitcoin"></i></li>
					          
					            <li><i class="fa fa-btc"></i></li>
					          
					            <li><i class="fa fa-css3"></i></li>
					          
					            <li><i class="fa fa-dribbble"></i></li>
					          
					            <li><i class="fa fa-dropbox"></i></li>
					          
					            <li><i class="fa fa-facebook"></i></li>

					          
					            <li><i class="fa fa-flickr"></i></li>
					          
					            <li><i class="fa fa-foursquare"></i></li>
					          
					            <li><i class="fa fa-github"></i></li>

					            <li><i class="fa fa-gittip"></i></li>
					          
					            <li><i class="fa fa-google-plus"></i></li>
					           
					            <li><i class="fa fa-html5"></i></li>
					          
					            <li><i class="fa fa-instagram"></i></li>
					          
					            <li><i class="fa fa-linkedin"></i></li>
					          
					            <li><i class="fa fa-linux"></i></li>
					          
					            <li><i class="fa fa-maxcdn"></i></li>
					          
					            <li><i class="fa fa-pagelines"></i></li>
					          
					            <li><i class="fa fa-pinterest"></i></li>
					          
					            <li><i class="fa fa-pinterest-square"></i></li>
					          
					            <li><i class="fa fa-renren"></i></li>
					          
					            <li><i class="fa fa-skype"></i></li>
					          
					            <li><i class="fa fa-stack-exchange"></i></li>
					          
					            <li><i class="fa fa-stack-overflow"></i></li>
					          
					            <li><i class="fa fa-trello"></i></li>
					          
					            <li><i class="fa fa-tumblr"></i></li>
					          
					            <li><i class="fa fa-tumblr-square"></i></li>
					          
					            <li><i class="fa fa-twitter"></i></li>
					          
					            <li><i class="fa fa-twitter-square"></i></li>
					          
					            <li><i class="fa fa-vimeo-square"></i></li>
					          
					            <li><i class="fa fa-vk"></i></li>
					          
					            <li><i class="fa fa-weibo"></i></li>
					          
					            <li><i class="fa fa-windows"></i></li>
					          
					            <li><i class="fa fa-xing"></i></li>
					          
					            <li><i class="fa fa-xing-square"></i></li>
					          
					            <li><i class="fa fa-youtube"></i></li>
					          
					            <li><i class="fa fa-youtube-play"></i></li>
					          
					            <li><i class="fa fa-youtube-square"></i></li>
					      </ul>
					        
					      <h3><?php _e('Medical Icons', 'wct');?></h3>
					      <ul class="clearfix">
					            <li><i class="fa fa-ambulance"></i></li>
					          
					            <li><i class="fa fa-h-square"></i></li>
					          
					            <li><i class="fa fa-hospital-o"></i></li>
					          
					            <li><i class="fa fa-medkit"></i></li>
					          
					            <li><i class="fa fa-plus-square"></i></li>
					          
					            <li><i class="fa fa-stethoscope"></i></li>
					          
					            <li><i class="fa fa-user-md"></i></li>
					          
					            <li><i class="fa fa-wheelchair"></i></li>
					      </ul>
					 </ul>
				</div>
			<?php 
		endif;
		?>
		<style>
		.ossvn-accordion h3.ossvn-title:before {
		  content: '\f107';
		  font-family: 'FA';
		  text-align: center;
		  font-size: 14px;
		  line-height: 22px;
		  color: #7b7979;
		  width: 24px;
		  height: 24px;
		  border: 1px solid #d4d4d4;
		  -webkit-border-radius: 100%;
		  -moz-border-radius: 100%;
		  border-radius: 100%;
		  position: absolute;
		  right: 0px;
		  top: 19px;
		  transition: all 0.4s ease;
		  -moz-transition: all 0.4s ease;
		  -o-transition: all 0.4s ease;
		  -ms-transition: all 0.4s ease;
		  -webkit-transition: all 0.4s ease;
		  background: #fff;
		}
		h3.uk-accordion-title{
			border-bottom: 1px solid #e9ebeb;
			padding: 22px 0px 0px 0px;
			color: #444;
			background: none;
			position: relative;
		}
		h3.ossvn-title.uk-active:before {
		  content: '\f106';
		  line-height: 21px;
		}
		h3.ossvn-title:hover:before {
		  color: #fff;
		  background: #e35c71;
		  border-color: #e35c71;
		}
		.accordion-container{margin-bottom: 5px;}
		.accordion-container .accordion-header {
		  background: #E3E3E3;
		  padding: 0.5em 1em;
		  padding-top: 0.5em;
		  padding-right: 1em;
		  padding-bottom: 0.5em;
		  padding-left: 1em;
		  border: 2px solid;
		  border-radius: 25px;
		}
		.accordion-container .accordion-content{

		  display: none;
		  height: auto;
		  border: none;
		  padding: 2em;
		}
		.accordion-container .attribute-label{cursor: pointer;}
		.accordion-container .form-field label{padding-right: 10px;}
		/*
		*---------------------------
			Style Thickbox
		*---------------------------
		*/
		/*#TB_ajaxContent div{
		    display: none !important;
		}*/
		#wct_overlay{
		  background: #000;
		  opacity: 0.7;
		  filter: alpha(opacity=70);
		  position: fixed;
		  top: 0;
		  right: 0;
		  bottom: 0;
		  left: 0;
		  z-index: 100050;
		  display: none;
		}
		#wct-popup-thickbox {
		  position: fixed;
		  background: #fff;
		  z-index: 100050;
		  text-align: left;
		  top: 5%;
		  left: 30%;
		  width: 600px;
		  max-height: 500px;
		  padding: 20px;
		  -webkit-box-shadow: 0 3px 6px rgba( 0, 0, 0, 0.3 );
		  box-shadow: 0 3px 6px rgba( 0, 0, 0, 0.3 );
		}
		#bo-metro-zero-tb-fa{
			padding-left: 0px;
			height: 400px;
  			overflow: auto;
		}
		#wct-popup-thickbox h2 {font-weight: 600;}
		.bo-tb-fa li {
		    float: left;
		    text-align: center;
		    width: 47px;
		    border: 1px solid #E1E1E1;
		    margin-left: -1px;
		    margin-top: -1px;
		    transition: all 0.1s ease-out 0s;
		    background: #FFF;
		    cursor: pointer;
		    margin-bottom: 0;
		    overflow: hidden;
		}
		.bo-tb-fa h3,.bo-tb-fa ul{
			transition: all 0.1s ease;
		}
		.bo-tb-fa li.deactive{
		    width: 0;

		    height: 0;
		    border-width: 0px;
		}
		.bo-tb-fa h3.deactive{
		    font-size: 0!important;
		    line-height: 0;
		    margin: 0!important;
		}
		.bo-tb-fa ul.deactive{
		    border-width: 0px;
		}
		.bo-tb-fa li i {
		    color: #494949;
		    font-size: 22px;
		    line-height: 45px;
		    transition: all 0.1s ease-out 0s;   
		}
		.bo-tb-fa li:hover, 
		.bo-tb-fa li:hover i {
		    transform: scale(1.2);
		    color: #278AB7;
		}
		.bo-icon-choosen i{
		    transform: scale(1.2);
		    color: #D54E21;
		}
		#bo-metro-zero-tb-fa > h3 {
		    font-weight: 400;
		    font-size: 15px;
		    color: #555555;
		    clear: both;
		    margin: 20px 0;
		}
		.h190 {
		    overflow-x: hidden;
		    overflow-y: auto;
		    height: 240px;
		    width: 90%;
		    border: 1px solid #E1E1E1;
		}
		</style>
		</div>
	<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['template_display_type'] = ( ! empty( $new_instance['template_display_type'] ) ) ? strip_tags( $new_instance['template_display_type'] ) : '';
		
		$attr_array = WCT_Admin::wct_get_attribute();
		if($attr_array):
			foreach ($attr_array as $key => $value) {
				foreach ($value as $val) {

					$instance[''.$key.'_variables_'.$val->slug.'_type'] = ( ! empty( $new_instance[''.$key.'_variables_'.$val->slug.'_type'] ) ) ? strip_tags( $new_instance[''.$key.'_variables_'.$val->slug.'_type'] ) : 'text';
					$instance[''.$key.'-variables-'.$val->slug.'-color-input'] = ( ! empty( $new_instance[''.$key.'-variables-'.$val->slug.'-color-input'] ) ) ? strip_tags( $new_instance[''.$key.'-variables-'.$val->slug.'-color-input'] ) : '#FFF';
					$instance[''.$key.'-variables-'.$val->slug.'-img-input'] = ( ! empty( $new_instance[''.$key.'-variables-'.$val->slug.'-img-input'] ) ) ? strip_tags( $new_instance[''.$key.'-variables-'.$val->slug.'-img-input'] ) : '';
					$instance[''.$key.'-variables-'.$val->slug.'-icon-input'] = ( ! empty( $new_instance[''.$key.'-variables-'.$val->slug.'-icon-input'] ) ) ? strip_tags( $new_instance[''.$key.'-variables-'.$val->slug.'-icon-input'] ) : '';

				}
			}
		endif;
		return $instance;
	}
}

/*=======Class WCT_Widget_Order ends here======*/

/*=======Class WCT_Widget_Best_Seller begin here======*/

class WCT_Widget_Best_Seller extends WP_Widget {

	function WCT_Widget_Best_Seller() {
		parent::__construct(
			// Base ID of your widget
			'WCT_Widget_Best_Seller', 

			// Widget name will appear in UI
			__('* WCT best seller', 'wct'), 

			// Widget description
			array( 'classname' => 'ossvn-best-seller-block', 'description' => __( 'Widget for checkout template', 'wct' ), ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if(!empty($title)){echo $args['before_title'].$title.$args['after_title'];}

		$meta_query = WC()->query->get_meta_query();
		$args_best = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => 1,
			'meta_key'            => 'total_sales',
			'orderby'             => 'meta_value_num',
			'meta_query'          => $meta_query
		);
		$wp_best = new WP_Query($args_best);
		if($wp_best->have_posts()): 
			while($wp_best->have_posts()): $wp_best->the_post();
				$product_best = new WC_Product(get_the_ID());
		?>
				<?php if(has_post_thumbnail()){?>
				<a href="<?php the_permalink();?>" class="ossvn-thumb">
					<?php the_post_thumbnail('thumbnail');?>
					<span><?php the_title();?></span>
				</a>
				<?php }?>
				<?php if ( $price_html = $product_best->get_price_html() ) : ?>
				<span class="ossvn-price"><?php echo $price_html; ?></span>
				<?php endif; ?>
		<?php
			endwhile;
		endif;wp_reset_postdata();
		echo $args['after_widget'];
	}
		
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}else{
			$title = __( 'Best Seller', 'wct' );
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
	<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}

/*=======Class WCT_Widget_Best_Seller ends here======*/

/*=======Class WCT_Widget_Products begin here======*/

class WCT_Widget_Products extends WP_Widget {

	function WCT_Widget_Products() {
		parent::__construct(
			// Base ID of your widget
			'WCT_Widget_Products', 

			// Widget name will appear in UI
			__('* WCT product', 'wct'), 

			// Widget description
			array(  'classname' => 'ossvn-products-block', 'description' => __( 'Widget for checkout template', 'wct' ), ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );
		$type = $instance[ 'type' ];
		$number = $instance[ 'number' ];
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if(!empty($title)){echo $args['before_title'].$title.$args['after_title'];}
		?>
			<?php
			if(!empty($number) && $number > 0){
				$per_page = $number;
			}else{
				$per_page = get_option('posts_per_page');
			}

			if($type == 'featured'){
				$args_product = array('post_type'=> 'product', 'meta_key' => '_featured', 'meta_value' => 'yes');
			}else{
				$args_product = array('post_type'=> 'product', 'posts_per_page' => $per_page);
			}

			$wp_product = new WP_Query($args_product);
			if($wp_product->have_posts()):
			?>
				<ul>
					<?php 
					while($wp_product->have_posts()): $wp_product->the_post();
						$product = new WC_Product(get_the_ID());
					?>
					<li>
						<?php if(has_post_thumbnail()){?>
						<a href="<?php the_permalink();?>" class="ossvn-thumb"><?php the_post_thumbnail('thumbnail');?></a>
						<?php }?>
						<a href="<?php the_permalink();?>"><?php the_title();?></a>
						<?php if ( $price_html = $product->get_price_html() ) : ?>
							<span class="ossvn-price"><?php echo $price_html; ?></span>
						<?php endif; ?>
					</li>
					<?php endwhile;?>
				</ul>
			<?php else:?>
				<p><?php _e('No product', 'wct');?></p>
			<?php endif;wp_reset_postdata();?>
		<?php
		echo $args['after_widget'];
	}
		
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}else{
			$title = __( 'Product', 'wct' );
		}
		if ( isset( $instance[ 'type' ] ) ) {
			$type = $instance[ 'type' ];
		}else{
			$type = 'recent';
		}
		if ( isset( $instance[ 'number' ] ) ) {
			$number = $instance[ 'number' ];
		}else{
			$number = 4;
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Type:' ); ?></label> 
			<select name="<?php echo $this->get_field_name( 'type' ); ?>" id="<?php echo $this->get_field_id( 'type' ); ?>" class="widefat">
				<option value="recent" <?php selected( $type, 'recent' ); ?>><?php _e('Recent products', 'wct');?></option>
				<option value="featured" <?php selected( $type, 'featured' ); ?>><?php _e('Featured products', 'wct');?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" value="<?php echo esc_attr( $number ); ?>" />
		</p>


	<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['type'] = ( ! empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
		$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
		return $instance;
	}
}

/*=======Class WCT_Widget_Products ends here======*/


/*=======Class WCT_Widget_Adv begin here======*/

class WCT_Widget_Adv extends WP_Widget {

	function WCT_Widget_Adv() {
		parent::__construct(
			// Base ID of your widget
			'WCT_Widget_Adv', 

			// Widget name will appear in UI
			__('* WCT advertisement', 'wct'), 

			// Widget description
			array( 'classname' => 'ossvn-adv-block', 'description' => __( 'Widget for checkout template', 'wct' ), ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$image = $instance[ 'image' ];
		$button_text = $instance[ 'button_text' ];
		$button_link = $instance[ 'button_link' ];
		$custom_code = $instance[ 'custom_code' ];
		
		if(!empty($custom_code)){echo esc_html($custom_code);}
		echo $args['before_widget'];
		?>
			<?php if(!empty($image)){?>
			<img src="<?php echo esc_attr($image);?>" alt="">
			<?php }else{?>
			<img src="<?php echo WCT_FRONTEND_IMG;?>ad-cover-bg.png" alt="">
			<?php }?>
			<div class="ossvn-content">
				<h3>
					<?php 
					if(!empty($title)){
						echo esc_html($title);
					}else{
						echo "Delivery Flower";
					}
					?>
				</h3>
				<?php if ( isset( $instance[ 'description' ] ) && !empty($instance[ 'description' ]) ) {echo wpautop($instance[ 'description' ]);}?>
				<?php if(!empty($button_text)){?>
				<a href="<?php if(!empty($button_link)){echo esc_url($button_link);}else{echo '#';}?>" class="ossvn-btn"><?php echo esc_html($button_text);?></a>
				<?php }?>
			</div>
		<?php
		echo $args['after_widget'];
	}
		
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}else{
			$title = __( 'Delivery Flower', 'wct' );
		}
		if ( isset( $instance[ 'image' ] ) ) {
			$image = $instance[ 'image' ];
		}else{
			$image = esc_url(WCT_FRONTEND_IMG . 'ad-cover-bg.png');
		}
		if ( isset( $instance[ 'button_text' ] ) ) {
			$button_text = $instance[ 'button_text' ];
		}else{
			$button_text = __( 'Call us', 'wct' );
		}
		if ( isset( $instance[ 'button_link' ] ) ) {
			$button_link = $instance[ 'button_link' ];
		}else{
			$button_link = '#';
		}
		if ( isset( $instance[ 'custom_code' ] ) ) {
			$custom_code = $instance[ 'custom_code' ];
		}else{
			$custom_code = '';
		}

		if ( isset( $instance[ 'description' ] ) ) {
			$description = $instance[ 'description' ];
		}else{
			$description = '';
		}

		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Image:' ); ?></label> 
			<input class="widefat wct-upload-url"  id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="text" value="<?php echo esc_attr( $image ); ?>" />
			<input type="submit" class="wct-upload" value="<?php _e( 'Upload', 'wct' ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Button text:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'button_link' ); ?>"><?php _e( 'Button link:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'button_link' ); ?>" name="<?php echo $this->get_field_name( 'button_link' ); ?>" type="text" value="<?php echo esc_attr( $button_link ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:' ); ?></label> 
			<textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo esc_textarea(stripslashes($description)); ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'custom_code' ); ?>"><?php _e( 'Custom code:' ); ?></label> 
			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('custom_code'); ?>" name="<?php echo $this->get_field_name('custom_code'); ?>"><?php echo esc_textarea(stripslashes($custom_code)); ?></textarea>
		</p>
	<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['image'] = ( ! empty( $new_instance['image'] ) ) ? strip_tags( $new_instance['image'] ) : '';
		$instance['button_text'] = ( ! empty( $new_instance['button_text'] ) ) ? strip_tags( $new_instance['button_text'] ) : '';
		$instance['button_link'] = ( ! empty( $new_instance['button_link'] ) ) ? strip_tags( $new_instance['button_link'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? stripslashes( $new_instance['description'] ) : '';
		$instance['custom_code'] = ( ! empty( $new_instance['custom_code'] ) ) ? stripslashes( $new_instance['custom_code'] ) : '';
		return $instance;
	}
}

/*=======Class WCT_Widget_Adv ends here======*/

// Register and load the widget
function wct_load_widget() {
	register_widget( 'WCT_Widget_Coupon' );
	register_widget( 'WCT_Widget_Order' );
	register_widget( 'WCT_Widget_Best_Seller' );
	register_widget( 'WCT_Widget_Products' );
	register_widget( 'WCT_Widget_Adv' );
}
add_action( 'widgets_init', 'wct_load_widget' );
?>