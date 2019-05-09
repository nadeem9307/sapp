<?php

session_start();
require __DIR__ . '/vendor/autoload.php';

use phpish\shopify;

require __DIR__ . '/conf.php';
include 'order_created_class.php';

function verify_webhook($data, $hmac_header) {
    $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_APP_SECRET, true));
    return hash_equals($hmac_header, $calculated_hmac);
}

//Shopify Get
$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$data = file_get_contents('php://input');
$verified = verify_webhook($data, $hmac_header);
//Shopify Get verified
if ($verified) {
    $myfile = fopen("orderfile.txt", "w") or die("Unable to open file!");
    fwrite($myfile, $data);
    fclose($myfile);
    order_data($data);
    return true;
} else {
    error_log('Webhook verified: ' . var_export($verified, true));
}

function order_data($data = '') {

    //$data = '{"id":198215794731,"email":"chandatiwari@gmail.com","closed_at":null,"created_at":"2018-01-09T13:11:04+02:00","updated_at":"2018-01-09T13:11:04+02:00","number":35,"note":"Monday Date: 2018\/01\/15,\r\nAddress: Crossfit Basement Kurvi,\r\nDishes:- \r\n\tEnglish cuisine\r\n\tTelesko vareno, Bulgarian beef soup.\r\n-------------------------------------------,\r\nWednesday Date: 2018\/01\/17,\r\nAddress: Crossfit Basement Kurvi,\r\nDishes:- \r\n\tBritish Sunday roast\r\n\tFish and chips\r\n-------------------------------------------,\r\n","token":"169ffe87b218e6a73a0b66e85fc733aa","gateway":"Cash on Delivery (COD)","test":false,"total_price":"48.00","subtotal_price":"48.00","total_weight":100000,"total_tax":"0.00","taxes_included":true,"currency":"EUR","financial_status":"pending","confirmed":true,"total_discounts":"0.00","total_line_items_price":"48.00","cart_token":"7ab6d634e905a73c91636eff3cacda85","buyer_accepts_marketing":true,"name":"#1035","referring_site":"","landing_site":"\/password","cancelled_at":null,"cancel_reason":null,"total_price_usd":"55.86","checkout_token":"32a71578712ddfdb6491fd27ff8c631a","reference":null,"user_id":null,"location_id":null,"source_identifier":null,"source_url":null,"processed_at":"2018-01-09T13:11:04+02:00","device_id":null,"phone":null,"customer_locale":"en","app_id":580111,"browser_ip":null,"landing_site_ref":null,"order_number":1035,"discount_codes":[],"note_attributes":[],"payment_gateway_names":["Cash on Delivery (COD)"],"processing_method":"manual","checkout_id":406841688107,"source_name":"web","fulfillment_status":null,"tax_lines":[],"tags":"","contact_email":"chandatiwari@gmail.com","order_status_url":"https:\/\/fuelme.fi\/25934472\/orders\/169ffe87b218e6a73a0b66e85fc733aa\/authenticate?key=7d062b26f3e3397a6ad8250f6ac7756c","line_items":[{"id":396328665131,"variant_id":6228014170155,"title":"4 Meals per Week","quantity":1,"price":"48.00","sku":"78965","variant_title":"","vendor":"FuelMe","fulfillment_service":"manual","product_id":477178691627,"requires_shipping":true,"taxable":true,"gift_card":false,"name":"4 Meals per Week","variant_inventory_management":"shopify","properties":[],"product_exists":true,"fulfillable_quantity":1,"grams":100000,"total_discount":"0.00","fulfillment_status":null,"tax_lines":[],"origin_location":{"id":159174623275,"country_code":"FI","province_code":"","name":"FuelMe","address1":"Arkadiankatu","address2":"31 B 27","city":"Helsinki","zip":"00100"},"destination_location":{"id":190270144555,"country_code":"IN","province_code":"UP","name":"chandatiwari it","address1":"lko","address2":"","city":"lko","zip":"226012"}}],"shipping_lines":[{"id":142336688171,"title":"Test Shipping","price":"0.00","code":"Test Shipping","source":"shopify","phone":null,"requested_fulfillment_service_id":null,"delivery_category":null,"carrier_identifier":null,"discounted_price":"0.00","tax_lines":[]}],"billing_address":{"first_name":"chandatiwari","address1":"lko","phone":null,"city":"lko","zip":"226012","province":"Uttar Pradesh","country":"India","last_name":"it","address2":"","company":"","latitude":26.7814955,"longitude":80.9152434,"name":"chandatiwari it","country_code":"IN","province_code":"UP"},"shipping_address":{"first_name":"chandatiwari","address1":"lko","phone":null,"city":"lko","zip":"226012","province":"Uttar Pradesh","country":"India","last_name":"it","address2":"","company":"","latitude":26.7814955,"longitude":80.9152434,"name":"chandatiwari it","country_code":"IN","province_code":"UP"},"fulfillments":[],"client_details":{"browser_ip":"122.163.239.206","accept_language":"en-US,en;q=0.9","user_agent":"Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/63.0.3239.132 Safari\/537.36","session_hash":"f4d90bb800abc592987af8542a0bf37c","browser_width":1349,"browser_height":662},"refunds":[],"customer":{"id":351876481067,"email":"chandatiwari@gmail.com","accepts_marketing":true,"created_at":"2018-01-09T13:10:45+02:00","updated_at":"2018-01-09T13:11:04+02:00","first_name":"chandatiwari","last_name":"it","orders_count":1,"state":"invited","total_spent":"0.00","last_order_id":198215794731,"note":null,"verified_email":true,"multipass_identifier":null,"tax_exempt":false,"phone":null,"tags":"","last_order_name":"#1035","default_address":{"id":369397432363,"customer_id":351876481067,"first_name":"chandatiwari","last_name":"it","company":"","address1":"lko","address2":"","city":"lko","province":"Uttar Pradesh","country":"India","zip":"226012","phone":null,"name":"chandatiwari it","province_code":"UP","country_code":"IN","country_name":"India","default":true}}}';
    $single_order_array = json_decode($data, true);
    echo '<pre/>';
    $order_id = $single_order_array['id'];
    $order_date = $single_order_array['note'];


    $string1 = str_replace('\r', ' ', $order_date); // Replaces all spaces with hyphens.
    $string2 = str_replace('\n', ' ', $string1); // Replaces all spaces with hyphens.
    $single_order = str_replace('\t', ' ', $string2); // Replaces all spaces with hyphens.

    $order_check = explode('-------------------------------------------', $single_order);



    $monday_addr = "";
    $wednesday_addr = "";
    $monday_data = "";
    $wednesday_data = "";

    if (count($order_check) === 3) {
        $order_note = explode(',', $single_order);

        // Get Monday Dates
        $monday_date_check = explode(': ', $order_check[0]);
        $monday_data_c = explode(',', $monday_date_check[1]);
        $monday_data = trim($monday_data_c[0]);
        // Get Monday Address
        $monday_address = explode(': ', $order_check[0]);
        $monday_address = explode(',', $monday_address[2]);
        $monday_addr = $monday_address[0];


        $wednesday_address = explode(': ', $order_check[1]);
        $wednesday_date_check = explode(': ', $wednesday_address[1]);

        // Get Wednesday Dates
        $wednesday_data_c = explode(',', $wednesday_date_check[0]);
        $wednesday_data = trim($wednesday_data_c[0]);

        // Get Wednesday Address
        $wednesday_address = explode(',', $wednesday_address[2]);
        $wednesday_addr = $wednesday_address[0];
    } else {
        if (strpos($single_order, 'Monday') !== false) {
            $order_note = explode(',', $single_order);

            // Get Monday Dates
            $monday_date_check = explode(': ', $order_check[0]);
            $monday_data_c = explode(',', $monday_date_check[1]);
            $monday_data = trim($monday_data_c[0]);

            $monday_address = explode(': ', $order_check[0]);
            $monday_address = explode(',', $monday_address[2]);
            $monday_addr = $monday_address[0];
        } else {

            $order_note = explode(',', $single_order);
            $wednesday_address = explode(': ', $order_check[0]);
            $wednesday_date_check = explode(': ', $wednesday_address[1]);

            // Get Wednesday Dates
            $wednesday_data_c = explode(',', $wednesday_date_check[0]);
            $wednesday_data = trim($wednesday_data_c[0]);

            $wednesday_address = explode(',', $wednesday_address[2]);
            $wednesday_addr = $wednesday_address[0];
        }
    }

    //save into database
    if ($monday_addr) {

        $obj = new order_created_class();
        $obj->save_order(array('address' => $monday_addr, 'day' => 'Monday', 'date' => $monday_data, 'order_id' => $order_id));
//        $obj->send_email_notification($single_order_array);
    }
    if ($wednesday_addr) {
        $obj = new order_created_class();
        $obj->save_order(array('address' => $wednesday_addr, 'day' => 'Wednesday', 'date' => $wednesday_data, 'order_id' => $order_id));
//        $obj->send_email_notification($single_order_array);
    }

    echo $monday_data;
    echo '<br/>';
    echo $monday_addr;
    echo '<br/>';
    echo $wednesday_addr;
    echo '<br/>';
    echo $wednesday_data;
}

order_data();
?>