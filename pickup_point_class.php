<?php

include_once 'connect_db.php';

//************************ Class for MenuMeals Plan ************************* //
class pickup_point_class extends CONNECT_DB {

    private $conn;

    public function __construct() {
        parent::__construct();
        $this->conn = $this->connect;
    }

    private function add_pickup_point($data = array()) {

        $sql = "INSERT INTO `meals_pickup_locations`(`id`, `address`, `perdaylimit`,`timezones` ,`pickup_location_day`) VALUES ('NULL','" . $data['pickup_point'] . "','" . $data['per_day_limit'] . "','" . $data['timezones'] . "','" . $data['pickup_location_day'] . "')";
        if (mysqli_query($this->conn, $sql) === TRUE) {
            return mysqli_insert_id($this->conn);
        }
        return false;
    }

    private function update_pickup_point($data = array()) {

        $sql = "UPDATE `meals_pickup_locations` SET `address`='" . $data['pickup_point'] . "',`perdaylimit`='" . $data['per_day_limit'] . "',`timezones`='" . $data['timezones'] . "',`pickup_location_day`='" . $data['pickup_location_day'] . "' WHERE id='" . $data['id'] . "'";
        if (mysqli_query($this->conn, $sql) === TRUE) {
            $id = $data['id'];
            return $id;
        }
        return false;
    }

    public function save_pickup_point($data = array()) {

        if (isset($data['id']) && $data['id'] != ' ') {
            return $this->update_pickup_point($data);
        } else {
            return $this->add_pickup_point($data);
        }
        return FALSE;
    }

    public function query($sql = '') {
        $result = array();
        if ($sql != '') {
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        return $result;
    }

    public function delete_pickup_point($data = array()) {

        $sql = "DELETE FROM meals_pickup_locations WHERE id = $data";
        if (mysqli_query($this->conn, $sql) === TRUE) {
            echo "Deleted data successfully\n";
        }
        $this->conn->close();
    }

    public function return_location_data($data = array()) {

        $sql = "SELECT * FROM `meals_pickup_locations` WHERE id = $data";
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }

}
