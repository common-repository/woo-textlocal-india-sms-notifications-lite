<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_action( 'woocommerce_payment_complete', 'cspd_wc_txtlcl_sms_after_payment' );
function cspd_wc_txtlcl_sms_after_payment( $order_id ){
   $order = new WC_Order($order_id);
   $order_phone = $order->get_billing_phone();
   $total_order = $order->get_total();
   $order_currency = $order->get_currency();
   $site_name = get_bloginfo( 'name' );
   $checkadminsms = get_option('check_admin_sms');
   $checkcustsms = get_option('check_cust_sms');
   	//Message to Customer
	if ($checkcustsms == "checked") {
    //$msgtocustomer = str_replace("ORDER_ID",$order_id,get_option('sms_to_cust'));
	 $orderid_rep_cust = str_replace("ORDER_ID",$order_id,get_option('sms_to_cust'));
	 $ordertotal_rep_cust = str_replace("ORDER_TOTAL",$total_order,$orderid_rep_cust);
	 $sitename_rep_cust = str_replace("SITE_NAME",$site_name,$ordertotal_rep_cust);
	 $msgtocustomer = str_replace("ORDER_CURRENCY",$order_currency,$sitename_rep_cust);
	 
   cspd_send_textlocal_sms(get_option('textlocal_user'),get_option('textlocal_api'),get_option('sms_sender_id'),$order_phone,$msgtocustomer);
	}
   //Message to admin
   if ($checkadminsms == "checked") {
	 $orderid_rep_admin = str_replace("ORDER_ID",$order_id,get_option('sms_to_admin'));
	 $ordertotal_rep_admin = str_replace("ORDER_TOTAL",$total_order,$orderid_rep_admin);
	 $sitename_rep_admin = str_replace("SITE_NAME",$site_name,$ordertotal_rep_admin);
	 $msgtoadmin = str_replace("ORDER_CURRENCY",$order_currency,$sitename_rep_admin);
	 
   cspd_send_textlocal_sms(get_option('textlocal_user'),get_option('textlocal_api'),get_option('sms_sender_id'),get_option('admin_phone_number'),$msgtoadmin);
   }
  }
?>