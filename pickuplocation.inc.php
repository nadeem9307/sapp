<?php
require_once 'auth.php';
require_once 'pickup_point_class.php';
// Attempt select query execution
$sql = "SELECT * FROM `meals_pickup_locations`";

$obj = new pickup_point_class();
$result = $obj->query($sql);
if(!empty($result)){
if (mysqli_num_rows($result) > 0) {

    $result_table = $result;
}}
?>