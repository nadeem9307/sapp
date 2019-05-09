<?php
include_once 'connect_db.php';
session_start();
error_reporting(0);

class login extends CONNECT_DB {

    public function __construct() {
        parent::__construct();
        $this->conn = $this->connect;
    }

    public function checklogin($data = array()) {
        $username = $data['username'];
        $password = $data['password'];
        $sql = "SELECT * FROM `login` WHERE username='$username' AND password='$password'";

        $result = mysqli_query($this->conn, $sql);
        $count = mysqli_num_rows($result);

        if ($count == 1) {
            $_SESSION['username'] = $username;
            header("location:index.php");
        } else {
            echo $fmsg = "Invalid Username/Password";
        }
    }

    public function heder_login_check($data = array()) {

        $user_check = $data['username'];
       
        $result = mysqli_query($this->conn, "select username from login where username = '$user_check' ");
        $count = mysqli_num_rows($result);
        if($count == 1){
            return true;
        }
       return false;
    }

}

?>