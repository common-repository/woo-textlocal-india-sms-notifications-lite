<?php
/**
 * @package Woo_Textlocal_India_SMS_Notifications_Lite
 * @version 1.0
 */
/*
Plugin Name: Woo Textlocal India SMS Notifications Lite
Description: A plugin to send SMS depending upon different order status for WooCommerce using textlocal Indian SMS API. It can send SMS to both buyers and admin's phone numbers.
Author: CodeSpeedy
Version: 1.0
Author URI: https://www.codespeedy.com
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
function cspd_send_textlocal_sms($username,$api_key,$sender,$number,$message)
{
	// Account details
	$apiKey = urlencode($api_key);
	
	// Message details
	$numbers = array($number);
	$sender = urlencode($sender);
	$message = rawurlencode($message);
 
	$numbers = implode(',', $numbers);
	// Prepare data for POST request
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
	// $response = wp_remote_post( 'https://api.textlocal.in/send/', array( 'data' => $data ) );
    

    $response = wp_remote_post( 'https://api.textlocal.in/send/', array(
    'method'      => 'POST',
    'timeout'     => 45,
    'redirection' => 5,
    'httpversion' => '1.0',
    'blocking'    => true,
    'headers'     => array(),
    'body'        => $data,
    'cookies'     => array()
    )
);


    // echo "<pre>"; print_r($response); echo "</pre>";
}
add_action("admin_menu", "cspd_txtlcl_sms_options");
function cspd_txtlcl_sms_options() {
	add_submenu_page(
        'woocommerce',
        'WooCommerce Customizable SMS By Online Virtue',
        '<span style="color: #10de0f;">Textlocal SMS</span>',
        'administrator',
        'cspd-wc-textlocal-sms',
        'cspd_wc_txtlcl_sms_settings_page' );
}
add_action('admin_init', 'cspd_wc_txtlcl_sms_options');
function cspd_wc_txtlcl_sms_options() {
	register_setting('wc_sms_option_group', 'admin_phone_number');
	register_setting('wc_sms_option_group', 'textlocal_user');
	register_setting('wc_sms_option_group', 'textlocal_api');
	register_setting('wc_sms_option_group', 'sms_sender_id');
	
	register_setting('wc_sms_option_group', 'sms_to_admin');
	register_setting('wc_sms_option_group', 'sms_to_cust');
	//register_setting('wc_sms_option_group', 'sms_from');
	register_setting('wc_sms_option_group', 'check_admin_sms');
	register_setting('wc_sms_option_group', 'check_cust_sms');
	
	//ORDER Processing SMS
	register_setting('wc_sms_option_group', 'process_smsenable_check');
	register_setting('wc_sms_option_group', 'process_sendadmin_check');
	register_setting('wc_sms_option_group', 'process_sendcust_check');
	register_setting('wc_sms_option_group', 'process_msgtxt_admin');
	register_setting('wc_sms_option_group', 'process_msgtxt_cust');
	
	//ORDER complete SMS
	register_setting('wc_sms_option_group', 'complete_smsenable_check');
	register_setting('wc_sms_option_group', 'complete_sendadmin_check');
	register_setting('wc_sms_option_group', 'complete_sendcust_check');
	register_setting('wc_sms_option_group', 'complete_msgtxt_admin');
	register_setting('wc_sms_option_group', 'complete_msgtxt_cust');
	
	//ORDER pending SMS
	register_setting('wc_sms_option_group', 'pending_smsenable_check');
	register_setting('wc_sms_option_group', 'pending_sendadmin_check');
	register_setting('wc_sms_option_group', 'pending_sendcust_check');
	register_setting('wc_sms_option_group', 'pending_msgtxt_admin');
	register_setting('wc_sms_option_group', 'pending_msgtxt_cust');
	
	//ORDER pending Cancelled
	register_setting('wc_sms_option_group', 'cancelled_smsenable_check');
	register_setting('wc_sms_option_group', 'cancelled_sendadmin_check');
	register_setting('wc_sms_option_group', 'cancelled_sendcust_check');
	register_setting('wc_sms_option_group', 'cancelled_msgtxt_admin');
	register_setting('wc_sms_option_group', 'cancelled_msgtxt_cust');
	
	//ORDER failed SMS
	register_setting('wc_sms_option_group', 'failed_smsenable_check');
	register_setting('wc_sms_option_group', 'failed_sendadmin_check');
	register_setting('wc_sms_option_group', 'failed_sendcust_check');
	register_setting('wc_sms_option_group', 'failed_msgtxt_admin');
	register_setting('wc_sms_option_group', 'failed_msgtxt_cust');
	
	//ORDER Refunded SMS
	register_setting('wc_sms_option_group', 'refunded_smsenable_check');
	register_setting('wc_sms_option_group', 'refunded_sendadmin_check');
	register_setting('wc_sms_option_group', 'refunded_sendcust_check');
	register_setting('wc_sms_option_group', 'refunded_msgtxt_admin');
	register_setting('wc_sms_option_group', 'refunded_msgtxt_cust');
	
	//ORDER On Hold SMS
	register_setting('wc_sms_option_group', 'hold_smsenable_check');
	register_setting('wc_sms_option_group', 'hold_sendadmin_check');
	register_setting('wc_sms_option_group', 'hold_sendcust_check');
	register_setting('wc_sms_option_group', 'hold_msgtxt_admin');
	register_setting('wc_sms_option_group', 'hold_msgtxt_cust');
	
	
}

function cspd_wc_txtlcl_sms_settings_page() { ?>

<div class="wrap">
   <div class="container" style="margin: 0;padding: 0;"><h2 style="font-size: 1.9em;"><img src="<?php echo plugin_dir_url( __FILE__ ) . '/assets/textlocal-logo.png'; ?>" width="40px" style="margin-bottom: -8px;"> Woo Textlocal India SMS Integration</h2>
   	<p>Textlocal India WooCommerce SMS notifications lite plugin</p></div>


  <div class="navitems container" style="margin: 0;padding: 0;">
     <span class="nav-tab" id="msgconfig_link">Configure</span>
     <span class="nav-tab" id="order_processing_link">Order processing</span>
     <span class="nav-tab" id="order_completed_link">Order complete</span>
     <span class="nav-tab" id="order_failed_link">Order failed</span>
     <span class="nav-tab" id="order_cancelled_link">Order cancelled</span>
     <span class="nav-tab" id="payment_complete_link">Payment complete</span>
     <span class="nav-tab" id="order_refunded_link">Order refund</span>
     <span class="nav-tab" id="order_hold_link">Order hold</span>
     <span class="nav-tab" id="order_pending_link">Order pending</span>
     <!-- <span class="nav-tab" id="otp_verify_link">OTP</span> -->
     <!-- <span class="nav-tab" id="btn-clr">Button Color</span> -->
  </div>
 
   
	<div class="container" style="margin: 0;padding: 0;">
	<form class="smsform" action="options.php" method="post">

	<div class="seven columns">
	<?php settings_fields('wc_sms_option_group');
	do_settings_sections('wc_sms_option_group'); ?>

	<div id="msgconfig">
	<div class="option-item1">
	<h4>Configure Textlocal SMS</h4><hr>

	<div class="form-group">
	<label>Textlocal Username: </label>
	<input type="text" name="textlocal_user" class="form-control" value="<?php echo get_option('textlocal_user'); ?>">
	</div>

	<div class="form-group">
	<label>Textlocal API Key: </label>
	<input type="text" name="textlocal_api" class="form-control" value="<?php echo get_option('textlocal_api'); ?>">
	</div>
	
	<div class="form-group">
	<label>Admin phone number to get order notification: </label>
	<input type="number" name="admin_phone_number" class="form-control" value="<?php echo get_option('admin_phone_number'); ?>">
	</div>
	
	<div class="form-group">
	<label>Sender ID (Generally it is <strong>TXTLCL</strong> by default): </label>
	<input type="text" name="sms_sender_id" class="form-control" value="<?php echo get_option('sms_sender_id'); ?>"><br/>
	</div>
	</div>
	</div>
	
	
	
  <div id="payment_complete">
  <div class="option-item2">

  <div style="text-align: center;">
    <h3 style="color: red;">This feature is available in our pro version of this plugin.</h3>
    <a rel="nofollow" target="_blank" href="https://www.codespeedy.com/products/textlocal-india-woocommerce-sms-notifications-plugin/" style="background-color: #ccc; color: #000;padding: 6px;text-decoration: none;font-size: 1.15em;border:solid 1px #000;"><strong>Buy Pro Version</strong></a>
    

  </div>

  <h4>Send SMS FOR Payment Complete</h4>
  <p>SMS will be sent after making online payment during checkout</p><hr>
  SMS To Admin: <br/>
  <textarea name="sms_to_admin" rows="3" style="cursor: not-allowed;" disabled >You have got a payment of ORDER_TOTAL ORDER_CURRENCY for order ID ORDER_ID on SITE_NAME.</textarea><br/><br/>
    SMS To Customer: <br/>
  <textarea name="sms_to_cust" rows="3" style="cursor: not-allowed;" disabled >You have made a payment of ORDER_TOTAL ORDER_CURRENCY for order ID ORDER_ID on SITE_NAME.</textarea><br/><br/>
  <input type="checkbox" name="check_admin_sms" value="checked"  style="cursor: not-allowed;" disabled > Send SMS to admin when successful payment made<br/><br/>
  <input type="checkbox" name="check_cust_sms" value="checked"  style="cursor: not-allowed;" disabled > Send SMS to customer for payment success<br/><br/>
  </div>
  </div>
	
	<div id="order_processing">
	<div class="option-item1">
	<!-- SEND SMS for Order Processing -->
	<h4>Send SMS FOR Order Processing</h4><hr>

	SMS Text To Admin For Order Processing: <br/>
	<textarea name="process_msgtxt_admin" rows="3"><?php echo get_option('process_msgtxt_admin', 'You have got an order of ORDER_TOTAL ORDER_CURRENCY is under processing on SITE_NAME. Order ID ORDER_ID.'); ?></textarea><br/><br/>
    SMS To Customer For Order Processing: <br/>
	<textarea name="process_msgtxt_cust" rows="3"> <?php echo get_option('process_msgtxt_cust', 'You have just order on SITE_NAME of ORDER_TOTAL ORDER_CURRENCY. Your Order ID ORDER_ID.'); ?></textarea><br/><br/>
	<input type="checkbox" name="process_sendadmin_check" value="checked" <?php echo get_option('process_sendadmin_check'); ?>> Send SMS to admin on order processing<br/><br/>
	<input type="checkbox" name="process_sendcust_check" value="checked" <?php echo get_option('process_sendcust_check'); ?>> Send SMS to customer on order processing<br/><br/>
	</div>
	</div>
	
	
	<div id="order_completed">
	<div class="option-item2">
	<!-- SEND SMS for Order Complete -->
	<h4>Send SMS FOR Order Complete</h4><hr>
	SMS Text To Admin For Order Complete: <br/>
	<textarea name="complete_msgtxt_admin" rows="3"><?php echo get_option('complete_msgtxt_admin', 'Order ORDER_ID of ORDER_TOTAL ORDER_CURRENCY has been completed on SITE_NAME.'); ?></textarea><br/><br/>
    SMS To Customer For Order Complete: <br/>
	<textarea name="complete_msgtxt_cust" rows="3"> <?php echo get_option('complete_msgtxt_cust', 'Your order ORDER_ID of ORDER_TOTAL ORDER_CURRENCY has been completed on SITE_NAME.'); ?></textarea><br/><br/>
	<input type="checkbox" name="complete_sendadmin_check" value="checked" <?php echo get_option('complete_sendadmin_check'); ?>> Send SMS to admin on order Complete<br/><br/>
	<input type="checkbox" name="complete_sendcust_check" value="checked" <?php echo get_option('complete_sendcust_check'); ?>> Send SMS to customer on order Complete<br/><br/>
	</div>
	</div>	
	
	<div id="order_failed">
	<div class="option-item1">
	<!-- SEND SMS for Order Failed -->
	<h4>Send SMS FOR Order Failed</h4><hr>
	SMS Text To Admin For Order Failed: <br/>
	<textarea name="failed_msgtxt_admin" rows="3"><?php echo get_option('failed_msgtxt_admin', 'Order ORDER_ID of ORDER_TOTAL ORDER_CURRENCY on SITE_NAME has failed.'); ?></textarea><br/><br/>
    SMS To Customer For Order Failed: <br/>
	<textarea name="failed_msgtxt_cust" rows="3"><?php echo get_option('failed_msgtxt_cust', 'Your order ORDER_ID of ORDER_TOTAL ORDER_CURRENCY on SITE_NAME has failed.'); ?></textarea><br/><br/>
	<input type="checkbox" name="failed_sendadmin_check" value="checked" <?php echo get_option('failed_sendadmin_check'); ?>> Send SMS to admin on order Failed<br/><br/>
	<input type="checkbox" name="failed_sendcust_check" value="checked" <?php echo get_option('failed_sendcust_check'); ?>> Send SMS to customer on order Failed<br/><br/>
	</div>
	</div>
	
	
		
		
	
	<div id="order_cancelled">
	<div class="option-item2">
	<!-- SEND SMS for Order Cancelled -->
	<h4>Send SMS FOR Order Cancelled</h4><hr>
	SMS Text To Admin For Order Cancelled: <br/>
	<textarea name="cancelled_msgtxt_admin" rows="3"><?php echo get_option('cancelled_msgtxt_admin', 'Order ORDER_ID of ORDER_TOTAL ORDER_CURRENCY has been cancelled on SITE_NAME.'); ?></textarea><br/><br/>
    SMS To Customer For Order Cancelled: <br/>
	<textarea name="cancelled_msgtxt_cust" rows="3"> <?php echo get_option('cancelled_msgtxt_cust', 'Your order ORDER_ID of ORDER_TOTAL ORDER_CURRENCY on SITE_NAME has cancelled.'); ?></textarea><br/><br/>
	<input type="checkbox" name="cancelled_sendadmin_check" value="checked" <?php echo get_option('cancelled_sendadmin_check'); ?>> Send SMS to admin on order Cancelled<br/><br/>
	<input type="checkbox" name="cancelled_sendcust_check" value="checked" <?php echo get_option('cancelled_sendcust_check'); ?>> Send SMS to customer on order Cancelled<br/><br/>
	</div>
	</div>
	
	

  <div id="order_refunded">
  <div class="option-item1">
  <div style="text-align: center;">
    <h3 style="color: red;">This feature is available in our pro version of this plugin.</h3>
    <a rel="nofollow" target="_blank" href="https://www.codespeedy.com/products/textlocal-india-woocommerce-sms-notifications-plugin/" style="background-color: #ccc; color: #000;padding: 6px;text-decoration: none;font-size: 1.15em;border:solid 1px #000;"><strong>Buy Pro Version</strong></a>
    
  </div>
  <!-- SEND SMS for Order Refunded -->
  <h4>Send SMS FOR Order Refund</h4><hr>
  SMS Text To Admin For Order Refund: <br/>
  <textarea name="refunded_msgtxt_admin" rows="3" style="cursor: not-allowed;" readonly><?php echo get_option('refunded_msgtxt_admin', 'Order ORDER_ID of ORDER_TOTAL ORDER_CURRENCY on SITE_NAME has refunded.'); ?></textarea><br/><br/>
    SMS To Customer For Order Refunded: <br/>
  <textarea name="refunded_msgtxt_cust" rows="3" style="cursor: not-allowed;" readonly> <?php echo get_option('refunded_msgtxt_cust', 'Your order ORDER_ID of ORDER_TOTAL ORDER_CURRENCY on SITE_NAME has refunded.'); ?></textarea><br/><br/>
  <input type="checkbox" name="refunded_sendadmin_check" value="checked" <?php echo get_option('refunded_sendadmin_check'); ?> style="cursor: not-allowed;opacity: 0.5;" onclick="return false"> Send SMS to admin on order Refund<br/><br/>
  <input type="checkbox" name="refunded_sendcust_check" value="checked" <?php echo get_option('refunded_sendcust_check'); ?> style="cursor: not-allowed;opacity: 0.5;" onclick="return false"> Send SMS to customer on order Refund<br/><br/>
  </div>
  </div>
	
	
  
  <div id="order_hold">
  <div class="option-item2">
  <div style="text-align: center;">
    <h3 style="color: red;">This feature is available in our pro version of this plugin.</h3>
    <a rel="nofollow" target="_blank" href="https://www.codespeedy.com/products/textlocal-india-woocommerce-sms-notifications-plugin/" style="background-color: #ccc; color: #000;padding: 6px;text-decoration: none;font-size: 1.15em;border:solid 1px #000;"><strong>Buy Pro Version</strong></a>
    
    
  </div>
  <!-- SEND SMS for Order on Hold -->
  <h4>Send SMS FOR Order On Hold</h4><hr>
  SMS Text To Admin For Order On Hold: <br/>
  <textarea name="hold_msgtxt_admin" rows="3" style="cursor: not-allowed;" readonly><?php echo get_option('hold_msgtxt_admin', 'Order ORDER_ID of ORDER_TOTAL ORDER_CURRENCY on SITE_NAME is on hold.'); ?></textarea><br/><br/>
    SMS To Customer For Order On Hold: <br/>
  <textarea name="hold_msgtxt_cust" rows="3" style="cursor: not-allowed;" readonly> <?php echo get_option('hold_msgtxt_cust', 'Your order ORDER_ID of ORDER_TOTAL ORDER_CURRENCY on SITE_NAME is on hold.'); ?></textarea><br/><br/>
  <input type="checkbox" name="hold_sendadmin_check" value="checked" <?php echo get_option('hold_sendadmin_check'); ?> style="cursor: not-allowed;opacity: 0.5;" onclick="return false"> Send SMS to admin on order on Hold<br/><br/>
  <input type="checkbox" name="hold_sendcust_check" value="checked" <?php echo get_option('hold_sendcust_check'); ?> style="cursor: not-allowed;opacity: 0.5;" onclick="return false"> Send SMS to customer on order on Hold<br/><br/>
  </div>
  </div>
	
	
	 <div id="order_pending">
  <div class="option-item1">
  <div style="text-align: center;">
    <h3 style="color: red;">This feature is available in our pro version of this plugin.</h3>
    <a rel="nofollow" target="_blank" href="https://www.codespeedy.com/products/textlocal-india-woocommerce-sms-notifications-plugin/" style="background-color: #ccc; color: #000;padding: 6px;text-decoration: none;font-size: 1.15em;border:solid 1px #000;"><strong>Buy Pro Version</strong></a>
    
    
  </div>
  <!-- SEND SMS for Order Pending -->
  <h4>Send SMS FOR Order Pending</h4><hr>
  SMS Text To Admin For Order Pending: <br/>
  <textarea name="pending_msgtxt_admin" rows="3" style="cursor: not-allowed;" readonly><?php echo get_option('pending_msgtxt_admin', 'Order ORDER_ID of ORDER_TOTAL ORDER_CURRENCY on SITE_NAME is pending payment.'); ?></textarea><br/><br/>
    SMS To Customer For Order Pending: <br/>
  <textarea name="pending_msgtxt_cust" rows="3" style="cursor: not-allowed;" readonly> <?php echo get_option('pending_msgtxt_cust', 'Your order ORDER_ID of ORDER_TOTAL ORDER_CURRENCY on SITE_NAME is pending payment.'); ?></textarea><br/><br/>
  <input type="checkbox" name="pending_sendadmin_check" value="checked" <?php echo get_option('pending_sendadmin_check'); ?> style="cursor: not-allowed;opacity: 0.5;" onclick="return false"> Send SMS to admin on order Pending<br/><br/>
  <input type="checkbox" name="pending_sendcust_check" value="checked" <?php echo get_option('pending_sendcust_check'); ?> style="cursor: not-allowed;opacity: 0.5;" onclick="return false"> Send SMS to customer on order Pending<br/><br/>
  </div>
  </div>



	
	</div> <!-- end col-sm-8-->
	<div class="three columns">
	<div id="msgsavebtn"><?php submit_button('Save Settings'); ?></div>

     <img width="110px" src="<?php echo plugin_dir_url( __FILE__ ) . '/assets/textlocal-logo.png'; ?>"><br/>
     <p><b>To get the SMS API visit <a href="http://www.textlocal.in/?tlrx=706551" target="blank">Textlocal</a></b></p>
     
	</div>
	
	</form>

   <div class="twelve columns">
    <p>This plugin work with transactional route to send order status SMS.</p>
     <p>Buy Transactional route SMS credit if you want to send order status in SMS</p>
     
    <h3>Text replacement</h3>
    <p><b>SITE_NAME</b> will show the name of your WordPress site</p>
    <p><b>ORDER_TOTAL</b> will show the total amount cost of the order</p>
    <p><b>ORDER_CURRENCY</b> will show the currency name</p>
    <p><b>ORDER_ID</b> will show the ID of the particular order</p>
    

   </div>


	</div><!-- end container-->
</div>
	
<?php
}

// include "process_wc_payment.php";

//My TESTS ------------------
//Run after Order Status

// include 'order_status_processing/order_pending.php';
include 'order_status_processing/order_failed.php';
// include 'order_status_processing/order_hold.php';
include 'order_status_processing/order_processing.php';
include 'order_status_processing/order_completed.php';
// include 'order_status_processing/order_refunded.php';
include 'order_status_processing/order_cancelled.php';

// add_action( 'woocommerce_order_status_pending', 'wc_msg_order_pending', 10, 1);
add_action( 'woocommerce_order_status_failed', 'cspd_wc_txtlcl_msg_order_failed', 10, 1);
// add_action( 'woocommerce_order_status_on-hold', 'wc_msg_order_hold', 10, 1);
// Note that it's woocommerce_order_status_on-hold, and NOT on_hold.
add_action( 'woocommerce_order_status_processing', 'cspd_wc_txtlcl_msg_order_processing', 10, 1);
add_action( 'woocommerce_order_status_completed', 'cspd_wc_txtlcl_msg_order_complete', 10, 1);
// add_action( 'woocommerce_order_status_refunded', 'wc_msg_order_refunded', 10, 1);
add_action( 'woocommerce_order_status_cancelled', 'cspd_wc_txtlcl_msg_order_cancel', 10, 1);

// OTP verification on Checkout page
/*$checkotpenable = get_option('enable_otp_checkbox');
if ($checkotpenable == "checked") {
include "otp_verify.php";
}*/
include "style.php";
function cspd_wc_twiliosms_notice() {
    ?>
        <!-- This site is using Woo Textlocal India SMS Notifications Lite plugin developed by CodeSpeedy -->
    <?php
}
add_action('wp_head', 'cspd_wc_twiliosms_notice');

//  Color Picker

// WooCommerce Order edit page send sms
// Add a custom metabox only for shop_order post type (order edit pages)
add_action( 'add_meta_boxes', 'cspd_txtlcl_order_sms_add_meta' );
function cspd_txtlcl_order_sms_add_meta()
{
    add_meta_box( 'custom_order_meta_box', __( 'Send SMS' ),
        'cspd_txtlcl_custom_meta_content', 'shop_order', 'side', 'default');
}

function cspd_txtlcl_custom_meta_content(){
   $order = new WC_Order( get_the_ID() );
   $order_phone = $order->get_billing_phone();
   $total_order = $order->get_total();
   $order_currency = $order->get_currency();
   $order_country_code = $order->get_billing_country();

   $site_name = get_bloginfo( 'name' );
   // include 'order_status_processing/phone_code.php';

    $post_id = isset($_GET['post']) ? $_GET['post'] : false;
    if(! $post_id ) return; // Exit

    ?>
<div style="background: rgb(161, 217, 239);padding: 4px">

	<strong>This feature available in pro version</strong>
	<br>
	<a class="button" target="_blank" href="https://www.codespeedy.com/products/textlocal-india-woocommerce-sms-notifications-plugin/">Buy Pro Version</a>

   <div id="send_sms_side_content">
    	<p>SMS to <strong><?php echo $order_phone; ?></strong></p>
    	<input type="hidden" id="cspd_sms_phone" value="<?php echo $order_phone; ?>">

    	<input type="hidden" id="total_order" value="<?php echo $total_order; ?>">
    	<input type="hidden" id="order_currency" value="<?php echo $order_currency; ?>">
    	<input type="hidden" id="order_id" value="<?php echo get_the_ID(); ?>">
    	<input type="hidden" id="site_name" value="<?php echo $site_name; ?>">

    	<textarea id="cspd_sms_text" name="cspd_sms_text" placeholder="Type SMS text" style="width: 100%;height: 85px;" disabled="disabled"></textarea>
    	<span id="cspd_send_sms_btn" class="button" onclick="cspd_send_sms();" style="background: #8ea9b4;color: #fff;border-color: #05719c;cursor: context-menu;">Send SMS</span>

   </div>


  <strong id="sms_sent_notice"></strong>
  <span id="send_another_sms_btn" class="button" onclick="cspd_send_another_sms();" style="display: none;">Send Another SMS</span>

  <p style="font-size: 11px;">
    <h3>SMS text replacement</h3>
    <p><b>SITE_NAME</b>: Your site name</p>
    <p><b>ORDER_TOTAL</b>: Total order price</p>
    <p><b>ORDER_CURRENCY</b>: Order currency</p>
    <p><b>ORDER_ID</b> Order ID</p>
  </p>

</div>


    <?php
    // The displayed value using GET method
    if ( isset( $_GET['abc'] ) && ! empty( $_GET['abc'] ) ) {
        echo '<p>Value: '.$_GET['abc'].'</p>';
    }
}
// wp_enqueue_script('jquery');

add_action( 'admin_footer', 'cspd_txtlcl_send_sms_ajax' ); // Write our JS below here

function cspd_txtlcl_send_sms_ajax() { ?>
	<script type="text/javascript" >


 function cspd_send_sms() {

	alert("Buy pro version to send SMS");
		
 }




 function cspd_send_another_sms()
 {

	jQuery(document).ready(function($) {

       $('#send_another_sms_btn').css('display','none');
       $('#send_sms_side_content').css('display','block');
	   $('#sms_sent_notice').html('');
	   $('#cspd_sms_text').val("");

    });
 }

	</script> <?php
}

