<?php
/**
 * Settings template step 1.
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
$wpml = get_option('wct_wpml');
$i_sell = get_option('wct_i_sell');
$newlleter = get_option('wct_newlleter');
?>
<script>
var wct_step = 1;
var wct_tour = <?php echo json_encode( array( 'id'=>'wct-product-tour', 'steps'=>array( array('title'=> __('Step 1', 'wct'), 'content'=> __('Hover on the screen, Slide On to select template.', 'wct'), 'target'=> '#ossvn-template-item-2', 'placement'=> 'bottom' ), array('title'=> __('Step 2', 'wct'), 'content'=> __('Click Continue to custom checkout fields.', 'wct'), 'target'=> '#ossvn-submit-item2 .ossvn-submit', 'placement'=> 'top', 'yOffset'=> -15, 'xOffset'=> -15 ) ), 'onEnd'=> array('wct_hopscotch_end'), 'showPrevButton'=> true ) );?>;
</script>
<div class="ossvn-container">
	<div id="overlay"><img src="<?php echo esc_url(WCT_ADMIN_IMG. 'loader.gif');?>"></div>
		<div id="ossvn-admin-header">
			<img class="ossvn-logo" src="<?php echo esc_url(WCT_ADMIN_IMG. 'logo.png');?>" alt="" />
			<div class="clear"></div>
			<h2><?php echo WCT_NAME;?></h2>
		</div><!--/#ossvn-admin-header -->
		<div id="ossvn-template-choose">
			<?php 
			$args_tems = array(
				'1' => __('Step - colorful', 'wct'),
				'2' => __('Step - modern', 'wct'),
				'3' => __('Flat', 'wct'),
				'4' => __('Accordion', 'wct'),
				'5' => __('Progress', 'wct')
			);
			?>
			<div class="ossvn-row">
				<?php 
				foreach($args_tems as $key => $tem):
				?>
					<div class="ossvn-col ossvn-col-6">
						<div class="ossvn-form-choose uk-form <?php if($template_active = get_option('template_active')){if($template_active == $key){echo 'active';}else{echo 'inactive';}}?>">
							<div class="ossvn-template-item">
								<div id="ossvn-template-item-<?php echo esc_attr($key);?>" class="ossvn-screen">
									<img src="<?php echo esc_url(WCT_ADMIN_IMG. 'screen-'.$key.'.jpg');?>" class="ossvn-screen-images" alt="" />
									<div class="ossvn-tab-wrap">
										<div class="ossvn-tab">
											<ul class="ossvn-tab-header" data-uk-switcher="{connect:'#template-<?php echo esc_attr($key);?>-tab'}">
												<?php 
												include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
												if (is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' )) {
												?>
												<li><a href="#"><?php _e('WPML', 'wct');?></a></li>
												<?php }?>
												<li><a href="#"><?php _e('Newsletter', 'wct');?></a></li>
											</ul>
											<ul id="template-<?php echo esc_attr($key);?>-tab" class="uk-switcher ossvn-tab-contents">
												
												<?php
												if (is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' )) {
												?>
												<li>
													<div class="ossvn-tab-content">
														<ul class="ossvn-form-control-list">
															<li>
																<input class="ossvn-input ossvn-wpml" type="radio" value="on" id="template-<?php echo esc_attr($key);?>-wpml-on" name="template-<?php echo esc_attr($key);?>-wpml-enable" <?php checked( $wpml, 'on' ); ?>>
																<label for="template-<?php echo esc_attr($key);?>-wpml-on"><?php _e('On', 'wct');?></label>
															</li>
															<li>
																<input class="ossvn-input ossvn-wpml" type="radio" value="off" id="template-<?php echo esc_attr($key);?>-wpml-off" name="template-<?php echo esc_attr($key);?>-wpml-enable" <?php checked( $wpml, 'off' ); ?>>
																<label for="template-<?php echo esc_attr($key);?>-wpml-off"><?php _e('Off', 'wct');?></label>
															</li>
														</ul>
													</div>
												</li>
												<?php }?>
											
												<li>
													<div class="ossvn-tab-content">
														<ul class="ossvn-form-control-list">
															<li>
																<input class="ossvn-input ossvn-newlleter" type="radio" value="on" id="template-<?php echo esc_attr($key);?>-newlleter-on" name="template-<?php echo esc_attr($key);?>-newlleter" <?php checked( $newlleter, 'on' ); ?>>
																<label for="template-<?php echo esc_attr($key);?>-newlleter"><?php _e('On', 'wct');?></label>
															</li>
															<li>
																<input class="ossvn-input ossvn-newlleter" type="radio" value="off" id="template-<?php echo esc_attr($key);?>-newlleter-off" name="template-<?php echo esc_attr($key);?>-newlleter" <?php checked( $newlleter, 'off' ); ?>>
																<label for="template-<?php echo esc_attr($key);?>-newlleter"><?php _e('Off', 'wct');?></label>
															</li>
														</ul>
													</div>
												</li>
											</ul><!--/.ossvn-tab-contents -->
										</div><!--/.ossvn-tab -->
									</div><!--/.ossvn-tab-wrap -->
									<div class="ossvn-turn-control">
										<span class="ossvn-text"><?php _e('OFF', 'wct');?></span>
										<span class="ossvn-control <?php if($template_active = get_option('template_active')){if($template_active == $key){echo 'active';}}?>"></span>
										<span class="ossvn-text"><?php _e('ON', 'wct');?></span>
									</div>
								</div>
							</div><!--/.ossvn-template-item -->
							<div id="ossvn-submit-item<?php echo esc_attr($key);?>" class="ossvn-submit-control">
								<div class="ossvn-button ossvn-sub-title"><?php echo esc_html($tem);?></div>
								<input type="hidden" name="wct_template_active" class="wct_template_active" value="<?php echo esc_attr($key);?>">
								<input type="submit" class="ossvn-save ossvn-button ossvn-submit" value="Continue" data-href="<?php echo esc_url(admin_url('admin.php?page=wct-settings&step=2'));?>"/>
							</div>
						</div><!--/.ossvn-form-choose -->
					</div><!--/.ossvn-col-6 -->
				<?php endforeach;?>

					<div class="ossvn-col-6 ossvn-col">
						<div class="ossvn-form-choose uk-form <?php if($template_active = get_option('template_active')){if($template_active == '_blank'){echo 'active';}else{echo 'inactive';}}?>">
							<div class="ossvn-template-item-blank">
								<div class="ossvn-tab-wrap">
									<div class="ossvn-tab">
										<ul class="ossvn-tab-header" data-uk-switcher="{connect:'#template-blank-tab'}">
											<?php 
											if (is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' )) {
											?>
											<li><a href="#"><?php _e('WPML', 'wct');?></a></li>
											<?php }?>
											<li><a href="#"><?php _e('Newlleter', 'wct');?></a></li>
										</ul>
										<ul id="template-blank-tab" class="uk-switcher ossvn-tab-contents">
											
											<?php 
											if (is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' )) {
											?>
											<li>
												<div class="ossvn-tab-content">
													<ul class="ossvn-form-control-list">
														<li>
															<input class="ossvn-input ossvn-wpml" type="radio" value="on" id="template-<?php echo esc_attr($key);?>-wpml-on" name="template-<?php echo esc_attr($key);?>-wpml-enable" <?php checked( $wpml, 'on' ); ?>>
															<label for="template-<?php echo esc_attr($key);?>-wpml-on"><?php _e('On', 'wct');?></label>
														</li>
														<li>
															<input class="ossvn-input ossvn-wpml" type="radio" value="off" id="template-<?php echo esc_attr($key);?>-wpml-off" name="template-<?php echo esc_attr($key);?>-wpml-enable" <?php checked( $wpml, 'off' ); ?>>
															<label for="template-<?php echo esc_attr($key);?>-wpml-off"><?php _e('Off', 'wct');?></label>
														</li>
													</ul>
												</div>
											</li>
											<?php }?>
											
											<li>
												<div class="ossvn-tab-content">
													<ul class="ossvn-form-control-list">
														<li>
															<input class="ossvn-input ossvn-newlleter" type="radio" value="on" id="template-<?php echo esc_attr($key);?>-newlleter-on" name="template-<?php echo esc_attr($key);?>-newlleter" <?php checked( $newlleter, 'on' ); ?>>
															<label for="template-<?php echo esc_attr($key);?>-newlleter"><?php _e('On', 'wct');?></label>
														</li>
														<li>
															<input class="ossvn-input ossvn-newlleter" type="radio" value="off" id="template-<?php echo esc_attr($key);?>-newlleter-off" name="template-<?php echo esc_attr($key);?>-newlleter" <?php checked( $newlleter, 'off' ); ?>>
															<label for="template-<?php echo esc_attr($key);?>-newlleter"><?php _e('Off', 'wct');?></label>
														</li>
													</ul>
												</div>
											</li>
										</ul><!--/.ossvn-tab-contents -->
									</div><!--/.ossvn-tab -->
								</div><!--/.ossvn-tab-wrap -->
								<div class="ossvn-turn-control ossvn-submit-control-blank">
									<span class="ossvn-text"><?php _e('OFF', 'wct');?></span>
									<span class="ossvn-control <?php if($template_active = get_option('template_active')){if($template_active == '_blank'){echo 'active';}}?>"></span>
									<span class="ossvn-text"><?php _e('ON', 'wct');?></span>
								</div>
							</div><!--/.ossvn-template-item-blank -->
							<div class="ossvn-submit-control">
								<div class="ossvn-button ossvn-sub-title"><?php _e('Blank Page', 'wct');?></div>
								<input type="hidden" name="wct_template_active" class="wct_template_active" value="_blank">
								<input type="submit" class="ossvn-save ossvn-button ossvn-submit" value="<?php _e('Continue', 'wct');?>" data-href="<?php echo esc_url(admin_url('admin.php?page=wct-settings&step=2'));?>"/>
							</div>
						</div><!--/.ossvn-form-choose -->	
					</div>
			</div><!--/.ossvn-row -->
		</div><!--/#ossvn-template-choose -->
</div><!--/.ossvn-container -->