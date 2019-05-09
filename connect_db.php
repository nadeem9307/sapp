<?php

class CONNECT_DB {

    protected $connect;

    public function __construct() {

        $conn = new mysqli('localhost', 'u46234', 'FQ69t7dcD8UG', 'u46234B2');
        if ($conn->connect_error) {
            throw new Exception($conn->connect_error);
        } else {
            $this->connect = $conn;
        }
    }

    protected function CLOSE_CONNECTION() {
        $this->connect->close();
    }

}

function url() {
    if (isset($_SERVER['HTTPS'])) {
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    } else {
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'];
}
