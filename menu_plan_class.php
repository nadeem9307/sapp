<?php

include_once 'connect_db.php';

class menu_plan_class extends CONNECT_DB {

    private $conn;

    public function __construct() {
        parent::__construct();
        $this->conn = $this->connect;
    }

    private function add_menu($data = array()) {

        $sql = "INSERT INTO `meals_menu_plans`(`id`, `shopify_product_id`, `meal_name`, `meal_units`) VALUES ('NULL' ,'$data[0]','$data[1]','$data[2]')";
        if (mysqli_query($this->conn, $sql)) {
            return $data[0];
            //return mysqli_insert_id($this->conn);
        }
        return false;
    }

    private function update_menu_by_product_id($data = array()) {

        $sql = "UPDATE `meals_menu_plans` SET `shopify_product_id` = '$data[0]', `meal_name` = '$data[1]', `meal_units` = '$data[2]' WHERE shopify_product_id = '$data[0]'";
        if (mysqli_query($this->conn, $sql) === TRUE) {
            return $data[0];
        }
        $this->conn->close();
    }

    private function update_menu($data = array()) {
        
    }

    public function save_menu_plan($data = array()) {

        $sql = 'SELECT * FROM `meals_menu_plans` WHERE `shopify_product_id` = ' . $data[0] . ' ORDER BY `meal_name` ASC';
        $result = mysqli_query($this->conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            return $this->update_menu_by_product_id($data);
        } else if (isset($data['id']) && $data['id'] != '') {
            return $this->update_menu($data);
        } else {
            return $this->add_menu($data);
        }
        return false;
    }

    public function query($sql = '') {
        $result = array();
        if ($sql != '') {
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        return $result;
    }

    public function delete_menu_plan($data = array()) {

        $sql = "DELETE FROM meals_menu_plans WHERE shopify_product_id = $data";
        if (mysqli_query($this->conn, $sql) === TRUE) {
            echo "Deleted data successfully\n";
        }
        $this->conn->close();
    }

}
