<?php
/**
 * Support template.
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

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
//send email support
//subject
if(isset($_POST['subject']) && !empty($_POST['subject'])){
	$subject = $_POST['subject'];
}else{
	$subject = 'This email was send from form support plugin Punder Coming Soon';
}
//purchase_code
if(isset($_POST['purchase_code']) && !empty($_POST['purchase_code'])){
	$purchase_code = $_POST['purchase_code'];
}else{
	$purchase_code = 'N/A';
}
//name
if(isset($_POST['name']) && !empty($_POST['name'])){
	$name = $_POST['name'];
}else{
	$name = 'N/A';
}
//email
if(isset($_POST['email']) && !empty($_POST['email'])){
	$email = $_POST['email'];
}else{
	$email = get_option('admin_email');
}
//question
if(isset($_POST['question']) && !empty($_POST['question'])){
	$question = $_POST['question'];
}else{
	$question = '';
}
//file_upload_url
if(isset($_POST['file_upload_url']) && !empty($_POST['file_upload_url'])){
	$file_upload_url = $_POST['file_upload_url'];
}else{
	$file_upload_url = '';
}
//message
if(isset($_POST['message']) && !empty($_POST['message'])){
	$message = $_POST['message'];
}else{
	$message = '';
}
//email to
$email_to = 'support@comfythemes.com';
//email header
$headers = "From: ".$name." <noreply@outsourcevietnam.co>\r\n";
$headers .='Reply-To: '. $email_to . "\r\n" ;
$headers .='X-Mailer: PHP/' . phpversion();
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
//$email_body
   $email_body = "<html><body>";
   $email_body .= "<h1>Email support plugin - Punder Coming Soon</h1>";
   $email_body .= '<h3>Email: '.$email.'</h3>';
   $email_body .= '<h3>Name: '.$name.'</h3>';
   $email_body .= '<h3>Purchase code: <span style="color:#FF0000;">'.$purchase_code.'</span></h3>';

   if($question != ''){
   		$email_body .= '<p>Question type: '.$question.'</p>';
   }
   if($file_upload_url != ''){
   		$email_body .= '<p>File: <a href="'.$file_upload_url.'" target="_blank">Click here</a></p>';
   }
   $email_body .= '<p>Message: '.$message.'</p>';
   $email_body .= "</body></html>";
//
if($file_upload_url != ''){
   	$attachments = array( $file_upload_url );
}else{
	$attachments = '';
}
$pcs_about_page_title = __('Supports', 'pcs');
?>
<div class="wrap">
	<h1><?php echo $pcs_about_page_title; ?></h1>
	<h3 style="color: #FE4444; font-weight: 700;"><?php echo WCT_NAME;?></h3>
	<p><?php _e('Thank you for purchasing my plugin. If you have any questions that are beyond the scope of this documentation, please feel free to email via my user page contact form here. Thanks so much!', 'wct');?></p>
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo WCT_ADMIN_CSS;?>bootstrap.min.css">
	<script>
	jQuery(document).ready(function () {

	    jQuery('#support-form').validate({
	        rules: {
	            name: {
	                minlength: 2,
	                required: true
	            },
	            email: {
	                minlength: 5,
	                email: true,
	                required: true
	            },
	            subject: {
	                minlength: 5,
	                required: true
	            },
	            purchase_code: {
	            	minlength: 5,
	                required: true,
	            },
	            message: {
	                minlength: 5,
	                required: true
	            }
	        },
	        highlight: function (element) {
	            jQuery(element).closest('.form-group').removeClass('success').addClass('error');
	        },
	        success: function (element) {
	            element.text('OK!').addClass('valid')
	                .closest('.form-group').removeClass('error').addClass('success');
	        }
	    });

	    var custom_uploader;

	});
	</script>
	<style>
	.form-group.error{padding-top: 10px;}
	label.error{color: #FF0000;}
	.form-group.success label.valid{color: #7ad03a !important;}
	</style>
	<form id="support-form" class="form-horizontal" role="form" method="post">
		<div class="col-md-7">
		    <div class="form-group">
		        <label for="subject" class="col-sm-2 control-label"><?php _e('Subject', 'pcs');?></label>
		        <div class="col-sm-10">
		            <input type="text" class="form-control" id="subject" name="subject" placeholder="<?php _e('Subject', 'pcs');?>" value="">
		        </div>
		    </div>
		    <div class="form-group">
		        <label for="purchase_code" class="col-sm-2 control-label"><?php _e('Purchase code', 'pcs');?></label>
		        <div class="col-sm-10">
		            <input type="text" class="form-control" id="purchase_code" name="purchase_code" placeholder="<?php _e('Purchase code', 'pcs');?>" value="">
		        </div>
		    </div>
		    <div class="form-group">
		        <label for="name" class="col-sm-2 control-label"><?php _e('Name', 'pcs');?></label>
		        <div class="col-sm-10">
		            <input type="text" class="form-control" id="name" name="name" placeholder="<?php _e('Your Name', 'pcs');?>" value="">
		        </div>
		    </div>
		    <div class="form-group">
		        <label for="email" class="col-sm-2 control-label"><?php _e('Email', 'pcs');?></label>
		        <div class="col-sm-10">
		            <input type="text" class="form-control" id="email" name="email" placeholder="<?php _e('Your email', 'pcs');?>" value="">
		        </div>
		    </div>
		    <div class="form-group">
		        <label for="question" class="col-sm-2 control-label"><?php _e('Question', 'pcs');?></label>
		        <div class="col-sm-10">
		            <select class="form-control" id="question" name="question">
						<option value=""><?php _e('-- Select type --', 'pcs');?></option>
						<option value="technical"><?php _e('Technical', 'pcs');?></option>
						<option value="bug-report"><?php _e('Bug report', 'pcs');?></option>
						<option value="feature-request"><?php _e('Feature Request', 'pcs');?></option>
					</select>
		        </div>
		    </div>
		    <div class="form-group">
		        <label for="file_upload" class="col-sm-2 control-label"><?php _e('Upload  file', 'pcs');?></label>
		        <div class="col-sm-10">
		            <input type="text" class="form-control" id="file_upload_url" name="file_upload_url" placeholder="<?php _e('Paste url file or upload file', 'pcs');?>" value="">
		            <input id="file_upload" name="file_upload" type="submit" value="<?php _e('Upload', 'pcs');?>" class="btn btn-primary"  style="margin-top:10px;">
		        </div>
		    </div>
		    <div class="form-group">
		        <label for="message" class="col-sm-2 control-label"><?php _e('Message', 'pcs');?></label>
		        <div class="col-sm-10">
		            <textarea class="form-control" rows="4" name="message"></textarea>
		        </div>
		    </div>
		    <div class="form-group">
		        <div class="col-sm-10 col-sm-offset-2">
		            <input id="submit" name="submit" type="submit" value="<?php _e('Send', 'pcs');?>" class="btn btn-primary">
		        </div>
		    </div>
		    <div class="form-group">
		        <div class="col-sm-10 col-sm-offset-2">
				<?php 
				if ( isset($_POST['submit']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['purchase_code'])) {
					
					if( class_exists('wpMandrill')){
						wpMandrill::mail( $email_to, $subject, $email_body, $headers );
					}else{
						mail($email_to, $subject, $email_body, $headers);
					}
            		echo "Email send success.";
            	}
				?>
		        </div>
		    </div>
		</div>
	</form>
</div>