<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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
            $res = $this->get_request_data($id);
            $this->data = $res;
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
            $data['location'] = $this->get_location();
            //get meals
            $data['meals'] = $this->get_meals();
            $data['thankyou'] = $this->get_thnaku();
        } else {
            $this->error = "Id is wrong";
        }

        return $data;
    }

    //Get Location
    private function get_location() {
        $sql = "SELECT * FROM `meals_pickup_locations`";
        $res = $this->query($sql);
        $location = array();

        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
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
    $id = $data['id'];
    $key = $data['key'];

    $obj = new API_Class();

    $res = $obj->verify_key($key, $id);

    //return json response
    $result = json_encode($res);
    echo $result;
} else {
    echo "Somthing is wrong Please check key and id";
}
?>


