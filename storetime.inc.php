<?php
require_once 'auth.php';
require_once 'storetime_class.php';
// Attempt select query execution
$sql = "SELECT * FROM `store_data` LIMIT 1";

$obj = new store_scheduler_class();
$result = $obj->query($sql);

if (!empty($result)) {
    if (mysqli_num_rows($result) > 0) {
        $store_data = mysqli_fetch_assoc($result);
        
    }
}
?>