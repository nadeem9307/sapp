<?php

include_once 'connect_db.php';

//************************ Class for MenuMeals Plan ************************* //
class menu_meals_class extends CONNECT_DB {

    private $conn;

    public function __construct() {
        parent::__construct();
        $this->conn = $this->connect;
    }

    private function add_meals($data = array()) {


        $sql = "INSERT INTO `meals_menu_dish`(`id`, `name`, `image_url`, `description`, `meal_type` ,week_day) VALUES ('NULL','" . $data['dish_name'] . "','" . $data['image_url'] . "','" . $data['dish_description'] . "','Meal Batch','" . $data['week_day'] . "')";

        if (mysqli_query($this->conn, $sql) === TRUE) {
            return mysqli_insert_id($this->conn);
        }
        return false;
    }

    private function update_meals($data = array()) {
        if (isset($data['image_url'])) {
            $sql = "UPDATE `meals_menu_dish` SET `name`='" . $data['dish_name'] . "',`image_url` ='".$data['image_url']."',`description`='" . $data['dish_description'] . "',`week_day`='" . $data['week_day'] . "' WHERE id='" . $data['id'] . "'";
            if (mysqli_query($this->conn, $sql) === TRUE) {
                $id = $data['id'];
                return $id;
            }
            return false;
        } else if(isset($data['new_image_url'])) {
            $sql = "UPDATE `meals_menu_dish` SET `name`='" . $data['dish_name'] . "',`image_url` ='".$data['new_image_url']."',`description`='" . $data['dish_description'] . "',`week_day`='" . $data['week_day'] . "' WHERE id='" . $data['id'] . "'";
            if (mysqli_query($this->conn, $sql) === TRUE) {
                $id = $data['id'];
                return $id;
            }
            return false;
        }
    }

    public function save_meals($data = array()) {
        if (isset($data['id']) && $data['id'] != '') {
            return $this->update_meals($data);
        } else {
            return $this->add_meals($data);
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

    public function delete_meals($data = array()) {

        $sql = "DELETE FROM meals_menu_dish WHERE id = $data";
        if (mysqli_query($this->conn, $sql) === TRUE) {
            echo "Deleted data successfully\n";
        }
        $this->conn->close();
    }

}
