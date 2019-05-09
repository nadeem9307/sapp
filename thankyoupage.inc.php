<?php
require_once 'auth.php';
require_once 'thankpage_class.php';

// Attempt select query execution
$sql = "SELECT * FROM `thankyou_page` LIMIT 1";
$objs = new thankpage_class();
$result = $objs->query($sql);
if (!empty($result)) {
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    }
}
?>