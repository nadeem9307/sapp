<?php
require_once 'auth.php';
require_once 'menu_plan_class.php';

// Attempt select query execution
$sql = "SELECT * FROM `meals_menu_plans`";
$obj = new menu_plan_class();
$result = $obj->query($sql);

if(!empty($result)){
if (mysqli_num_rows($result) > 0) {
    $result_table = $result;
}
}