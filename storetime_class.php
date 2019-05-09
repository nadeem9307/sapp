<?php

include_once 'connect_db.php';

//************************ Class for store scheduler class ************************* //
class store_scheduler_class extends CONNECT_DB {

    private $conn;

    public function __construct() {
        parent::__construct();
        $this->conn = $this->connect;
    }

    public function add_store_time($data = array()) {
        
        $sql = "UPDATE `store_data` SET `open_day`='" . $data['open_day'] . "',`open_time`='" . $data['open_time'] . "',`close_day`='" . $data['close_day'] . "',`close_time`='" . $data['close_time'] . "' WHERE store_id='" . $data['store_id'] . "'";
        if (mysqli_query($this->conn, $sql) === TRUE) {
            return mysqli_insert_id($this->conn);
        }
        return false;
    }

    public function update_store_time($data = array()) {
        
        $sql = "UPDATE `store_data` SET `open_day`='" . $data['open_day'] . "',`open_time`='" . $data['open_time'] . "',`close_day`='" . $data['close_day'] . "',`close_time`='" . $data['close_time'] . "' WHERE store_id='" . $data['store_id'] . "'";
        if (mysqli_query($this->conn, $sql) === TRUE) {
            $id = $data['store_id'];
            return $id;
        }
        return false;
    }

//    public function save_store_time($data = array()) {
//        
//
//        if (isset($data['store_id']) && $data['store_id'] != ' ') {
//            return $this->update_store_time($data);
//        } else {
//            return $this->add_store_time($data);
//        }
//        return FALSE;
//    }

    public function query($sql = '') {
        $result = array();
        if ($sql != '') {
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        return $result;
    }


}
