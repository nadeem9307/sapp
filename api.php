<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
date_default_timezone_set('Europe/Helsinki');
include_once 'connect_db.php';

//************************ Class for MenuMeals Plan ************************* //
class API_Class extends CONNECT_DB {

    private $conn;
    private $error = array();
    private $data;

    public function __construct() {
        parent::__construct();
        $this->conn = $this->connect;
    }

    public function verify_key($key, $id) {

        $sql = "SELECT store_id FROM store_data WHERE store_id='$key';";
        $res = $this->query($sql);

        if ($res->num_rows > 0) {
            $st = $this->get_store_time();
            if ($st["store_status"] == 'open') {
                $res = $this->get_request_data($id);
                $this->data = $res;
                $check_last_time = (strtotime($st["store_closing_time"]) - (strtotime($st["store_opening_time"])));
                if ($check_last_time <= 3600) {
                    $this->data["store_open_for"] = $check_last_time;
                }
            } else {
                $this->data = $st;
            }
        } else {
            $this->error = "Key not found";
        }
        $this->data['error'] = $this->error;
        return $this->data;
    }

    private function get_request_data($id = "") {
        $data = array();
        //Get Plan
        $sql = "SELECT * FROM `meals_menu_plans` WHERE `shopify_product_id` LIKE $id LIMIT 1";
        $res = $this->query($sql);
        $plans = array();

        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                array_push($plans, $row);
            }


            $data['plan'] = $plans;

            $next_monday = date('Y-m-d', strtotime("next Monday"));
            $next_wednesday = date('Y-m-d', strtotime("next Wednesday"));

            if (date('w') < 1) {
                $next_monday = date('Y-m-d', strtotime($next_monday . '+ 7 day'));
            }
            $data['next_monday'] = $next_monday;

            if (date('w') < 3) {
                $next_wednesday = date('Y-m-d', strtotime($next_wednesday . '+ 7 day'));
            }

            $data['next_wednesday'] = $next_wednesday;

            //get location
            $data['location'] = $this->get_location($next_monday, $next_wednesday);
            //get meals
            $data['meals'] = $this->get_meals();
            $data['thankyou'] = $this->get_thnaku();
        } else {
            $this->error = "Id is wrong";
        }

        return $data;
    }

    //Get Location
    private function get_location($next_monday = "", $next_wednesday = "") {

        $sql = "SELECT * FROM `meals_pickup_locations`";
        $res = $this->query($sql);

        while ($row = $res->fetch_assoc()) {

            if ($row['pickup_location_day'] == 'Monday') {
                //$next_mon = '2018-01-22';
                //$n_monday = strtotime($next_mon);

                $n_monday = strtotime($next_monday);

                if (!empty($row['last_order_date'])) {
                    $loi = $row['last_order_date'];
                    if ($n_monday != $loi) {
                        //It resets the whole order for each week plans.
                        $updated_unit = 0;
                        $sql = "UPDATE `meals_pickup_locations` SET `left_units` = '" . $updated_unit . "', `week_range`=' ',`last_order_date`=' ' WHERE pickup_location_day='Monday'";
                        $this->query($sql);
                    }
                }
            } else if ($row['pickup_location_day'] == 'Wednesday') {

                //$next_wed = '2018-01-24';
                //$n_wednesday = strtotime($next_wed);

                $n_wednesday = strtotime($next_wednesday);

                if (!empty($row['last_order_date'])) {
                    $lo = $row['last_order_date'];

                    if ($n_wednesday != $lo) {
                        $updated_unit = 0;
                        $sql = "UPDATE `meals_pickup_locations` SET `left_units` = '" . $updated_unit . "', `week_range`=' ',`last_order_date`=' ' WHERE pickup_location_day='Wednesday'";
                        $this->query($sql);
                    }
                }
            } else {
                continue;
            }
        }


        $sqli = "SELECT * FROM `meals_pickup_locations`";
        $resssss = $this->query($sqli);

        $location = array();

        if ($resssss->num_rows > 0) {
            while ($row = $resssss->fetch_assoc()) {
                array_push($location, $row);
            }
            $locations = $this->_group_by($location, "pickup_location_day");
            return $locations;
        }
    }

    //Get meals_menu_dish
    private function get_meals() {

        $sql = "SELECT * FROM `meals_menu_dish`";
        $res = $this->query($sql);
        $dish = array();

        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                array_push($dish, $row);
            }
            $dishs = $this->_group_by($dish, "week_day");
            return $dishs;
        }
    }

    //Get store time //
    private function get_store_time() {
        $times = array();
        $times["store_status"] = 'open';
        $times["store_opening_time"] = date('Y-m-d H:i:s', strtotime("Monday this week 00:00:00"));
        $times["store_closing_time"] = date('Y-m-d H:i:s', strtotime("Sunday this week 23:59:59"));
        $sql = "SELECT `open_day`, `open_time`, `close_day`, `close_time` FROM `store_data` LIMIT 1";
        $res = $this->query($sql);
        if ($res->num_rows > 0) {

            if ($row = $res->fetch_assoc()) {
                //array_push($times, $row);
                $open_day = $row['open_day'];
                $open_time = $row['open_time'];
                $close_day = $row['close_day'];
                $close_time = $row['close_time'];
            }

            if (!((strtotime(date('r', strtotime("now"))) > strtotime(date('r', strtotime("$open_day this week $open_time")))) && (strtotime(date('r', strtotime("now"))) < strtotime(date('r', strtotime("$close_day this week $close_time"))) ) )) {
                $times["store_status"] = 'not_open';
                $times["store_opening_time"] = date('Y-m-d H:i:s', strtotime("$open_day this week $open_time"));
                $times["store_closing_time"] = date('Y-m-d H:i:s', strtotime("$close_day this week $close_time"));
            }
        }
        return $times;
    }

    //Get meals_menu_dish
    private function get_thnaku() {

        $sql = "SELECT * FROM `thankyou_page` LIMIT 1";
        $res = $this->query($sql);
        $d = array();

        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                array_push($d, $row);
            }
            return $d;
        }
    }

    // function for group array
    public function _group_by($array, $key) {
        $return = array();
        foreach ($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }

    // get sql result
    public function query($sql = '') {
        $result = array();
        if ($sql != '') {
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        return $result;
    }

}

//Get data by GET Method
$data = $_GET;
if (isset($data['id']) AND isset($data['key']) AND is_numeric($data['key']) AND is_numeric($data['id'])) {
    // $id = $data['id'] = '477178691627' ;
    // $key = $data['key'] = '25934472';


    $id = $data['id'];
    $key = $data['key'];
    $obj = new API_Class();

    $res = $obj->verify_key($key, $id);

    $result = json_encode($res);
    echo $result;
} elseif (isset($data['action']) && $data['action'] == 'check_email') {
    $id = $data['id'] = '392700133419';
    

    $result = json_encode($res);
    echo $result;
} else {
    echo "Somthing is wrong Please check key and id";
}
?>


