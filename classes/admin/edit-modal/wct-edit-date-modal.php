<?php 
/**
 * Modal edit block: date
 *
 * @link       http://demo.comfythemes.com/wct/
 * @since      1.0
 *
 * @package    woocommerce-checkout-templates
 * @subpackage woocommerce-checkout-templates/classes/admin/edit-modal
 * @author     OSVN <contact@outsourcevietnam.co>
 * @coder Nam
 */
defined( 'ABSPATH' ) OR exit;
?>
<div id="ossvn-edit-date-modal" class="ossvn-modal ossvn-block-modal uk-modal">
	<div class="uk-modal-dialog ossvn-modal-box">
		<div class="ossvn-modal-header">
			<i class="fa fa-pencil-square-o"></i><?php _e('Edit', 'wct');?>
			<a class="uk-modal-close uk-close ossvn-modal-close"></a>
		</div>
		<div class="ossvn-modal-body uk-form">
			<ul class="uk-tab" data-uk-switcher="{connect:'#ossvn-date-general'}">
			    <li class="uk-active"><a href=""><?php _e('General', 'wct');?></a></li>
			    <li><a href=""><?php _e('Advanced', 'wct');?></a></li>
			</ul>
			<ul id="ossvn-date-general" class="uk-switcher uk-margin">
				<li>
					<div class="ossvn-title-group ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id"><?php _e('Title', 'wct');?></label>
						<?php self::wct_show_title_field('title', 'title');?>
					</div>
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id"><?php _e('Placeholder', 'wct');?></label>
						<?php self::wct_show_title_field('title', 'placeholder');?>
					</div>
					
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id-date-1"><?php _e('Required', 'wct');?></label>
						<input type="checkbox" id="ossvn-checkbox-id-date-1" data-target="block_required" class="ossvn-get-data"/>
					</div>
					<div class="ossvn-form-group show_if_custom_fields">
						<label class="ossvn-label" for="ossvn-checkbox-id-date-2"><?php _e('Display in order recived  ', 'wct');?></label>
						<input type="checkbox" id="ossvn-checkbox-id-date-2" data-target="block_display_order_recived" class="ossvn-get-data"/>
					</div>
					<div class="ossvn-form-group show_if_custom_fields">
						<label class="ossvn-label" for="ossvn-checkbox-id-date-3"><?php _e('Display in email order  ', 'wct');?></label>
						<input type="checkbox" id="ossvn-checkbox-id-date-3" data-target="block_display_email" class="ossvn-get-data"/>
					</div>

					<div class="ossvn-form-group show_if_custom_fields">
						<label class="ossvn-label" for="ossvn_display_account"><?php _e('Display in my accouny page  ', 'wct');?></label>
						<input type="checkbox" id="ossvn_display_account" data-target="block_display_account" class="ossvn-get-data"/>
						<input type="text" id="ossvn_display_account_title" name="ossvn_display_account_title" data-target="block_display_account_title" class="ossvn-get-data uk-hidden" />
					</div>
					
					<?php 
					if(class_exists('WooCommerce_PDF_Invoices')){
						require('wct-support-field-to-pdf-invoices-packing-slips.php');
					}
					?>

					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id"><?php _e('Style', 'wct');?></label>
						<?php 
						$date_style = array(
							'cangas' => __('Cangas', 'wct'),
							'latoja' => __('Latoja', 'wct'),
							'lugo' => __('Lugo', 'wct'),
							'melon' => __('Melon', 'wct'),
							'nigran' => __('Nigran', 'wct'),
							'santiago' => __('Santiago', 'wct'),
							'siena' => __('Siena', 'wct'),
							'vigo' => __('Vigo', 'wct'),
							'dosis' => __('Dosis', 'wct'),
						);
						echo '<select name="date_skin" data-target="date_skin" class="ossvn-get-data">';
							echo '<option value="">--Select--</option>';
						foreach ($date_style as $key => $value) {
							echo '<option value="'.esc_attr($key).'">'.sanitize_text_field($value).'</option>';
						}
						echo '<select>';
						?>
					</div>
					<div class="ossvn-form-group">
						<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
						<label class="ossvn-label" for="ossvn-checkbox-id"><?php _e('Selectable date range', 'wct');?></label>
						<div class="row">
							<div class="col6">
								<?php _e('Min', 'wct');?><input type="text" id="date_min" data-target="date_min" class="input-date ossvn-get-data"/>
							</div>
							<div class="col6">
								<?php _e('Max', 'wct');?><input type="text" id="date_max" data-target="date_max" class="input-date ossvn-get-data"/>
							</div>
						</div>
					</div>
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id-date-4"><?php _e('Exerpt weekend', 'wct');?></label>
						<input type="radio" id="ossvn-checkbox-id-date-4" name="date_w"  data-target="date_w" class="ossvn-get-data" value="on"/>
					</div>
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id-date-5"><?php _e('Specific day', 'wct');?></label>
						<input type="radio" id="ossvn-checkbox-id-date-5" name="date_w"  data-target="date_w" class="ossvn-get-data" value="off"/>
					</div>
					<div class="conditional ossvn-form-group"  data-cond-option="date_w" data-cond-value="off"> 
						<label class="ossvn-label" for="ossvn-checkbox-id"><?php _e('Days to be disabled', 'wct');?></label>
						<input type="text" id="date_disable" data-target="date_disable" class="ossvn-get-data"/>
						<p class="des"><?php _e('Ex: 8-25-2015, 8-26-2015', 'wct');?></p>
					</div>

					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-time-format"><?php _e('Format the time', 'wct');?></label>
						<select id="ossvn_time_format" data-target="time_format" class="ossvn-get-data form-control">
							<option value=""><?php _e('24H', 'wct');?></option>
							<option value="12"><?php _e('12H', 'wct');?></option>
						</select>
					</div>
				</li>
				<li>
					
					<div class="ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-class"><?php _e('Custom class', 'wct');?></label>
						<input type="text" id="ossvn-checkbox-class"  data-target="ext_class" class="ossvn-get-data"/>
					</div>
					<div class="ossvn-price ossvn-form-group">
						<label class="ossvn-label" for="ossvn-checkbox-id-date-6"><?php _e('Price', 'wct');?></label>
						<input type="checkbox" id="ossvn-checkbox-id-date-6"  data-target="block_price" class="ossvn-get-data" /><input type="text" id="ossvn-block-price-value"  data-target="block_price_value" class="ossvn-get-data" placeholder="Add price" style="display:none;margin-left:20px;"/>
					</div>
					<?php 
					/**
					* HTML conditional logic
					* @since 1.0
					*/
					require('wct-html-user-role-logic.php');
					/**
					* HTML user role logic
					* @since 1.0
					*/
					require('wct-html-conditional-logic.php');
					?>
				</li>
			</ul>
			<div class="ossvn-modal-footer">
				<button type="button" class="ossvn-save-col"><?php _e('Save changes', 'wct');?></button>
			</div>
		</div>		
    </div>
</div>
