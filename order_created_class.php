<?php

require __DIR__ . '/vendor/autoload.php';

use phpish\shopify;

require __DIR__ . '/conf.php';
include_once 'connect_db.php';

//************************ Class for MenuMeals Plan ************************* //
class order_created_class extends CONNECT_DB {

    private $conn;

    public function __construct() {
        parent::__construct();
        $this->conn = $this->connect;
    }

    private function update_location($data = array()) {

        $order_id = $data['order_id'];
        $r_start_end = "";
        $last_order_dil_date = strtotime($data['date']);

        $sql = "SELECT perdaylimit, left_units, week_range, last_order_date FROM `meals_pickup_locations` WHERE address='" . $data['address'] . "' AND pickup_location_day='" . $data['day'] . "' LIMIT 1";

        $res = mysqli_query($this->conn, $sql);

        if ($res) {
            $arr = mysqli_fetch_assoc($res);

            if ($data['day'] == 'Monday') {

                $r_start_end = $data['date'] . '-' . date('Y/m/d', strtotime($data['date'] . ' + 5 days'));
            } else {

                $r_start_end = $data['date'] . '-' . date('Y/m/d', strtotime($data['date'] . ' + 3 days'));
            }

            if ($last_order_dil_date == $arr['last_order_date']) {

                if (($arr['perdaylimit'] - 1) >= $arr['left_units']) {
                    if ($arr['left_units'] == 0) {
                        $updated_unit = 1;
                    } else {
                        $updated_unit = ($arr['left_units'] + 1);
                    }
                    $sql = "UPDATE `meals_pickup_locations` SET `left_units` = '" . $updated_unit . "' , `week_range`='" . $r_start_end . "' , `last_order_date` ='" . $last_order_dil_date . "'  WHERE address='" . $data['address'] . "' AND pickup_location_day='" . $data['day'] . "'";

                    $res = mysqli_query($this->conn, $sql);
                    if ($res) {
                        return true;
                    } else {
                        return false;
                        //no not permission 
                    }
                } else {

                    try {
                        $shopify = shopify\client(SHOPIFY_SHOP, SHOPIFY_APP_API_KEY, SHOPIFY_APP_PASSWORD, true);
                        $shop_content = $shopify('POST /admin/orders/' . $order_id . '/cancel.json?reason=inventory&note=Order+limit+reached!&email=true');
                        return $shop_content;
                    } catch (shopify\ApiException $e) {
                        
                    } catch (shopify\CurlException $e) {
                        
                    }
                }
            } else if (empty($arr['last_order_date'])) {

                $updated_unit = 1;
                $sql = "UPDATE `meals_pickup_locations` SET `left_units` = '" . $updated_unit . "' , `week_range`='" . $r_start_end . "' , `last_order_date` ='" . $last_order_dil_date . "'  WHERE address='" . $data['address'] . "' AND pickup_location_day='" . $data['day'] . "'";
                $res = mysqli_query($this->conn, $sql);
                if ($res) {
                    return true;
                } else {
                    return false;
                    //no not permission
                }
            } else {
                // Code works in next week from if last_order_date is greater then last week order date any time in months.
                // It resets the whole order for each week plans.
                $updated_unit = 0;
                $sql = "UPDATE `meals_pickup_locations` SET `left_units` = '" . $updated_unit . "' , `week_range`='" . $r_start_end . "' , `last_order_date` ='" . $last_order_dil_date . "'  WHERE address='" . $data['address'] . "' AND pickup_location_day='" . $data['day'] . "'";
                $res = mysqli_query($this->conn, $sql);
                if ($res) {
                    return true;
                } else {
                    return false;
                    //no not permission
                }
            }
            die;
        }
        return false;
    }

    public function save_order($data = array()) {

        if (isset($data['address']) && $data['address'] != ' ') {
            return $this->update_location($data);
        }
        return FALSE;
    }

    public function cancel_order($param) {
        
    }
    public function send_email_notification($single_order_array){
        print_r($single_order_array);
        
        
    }

}
