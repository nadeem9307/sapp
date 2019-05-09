<?php

include_once 'auth.php';
include_once 'menu_plan_class.php';
include_once 'menu_meals_class.php';
include_once 'pickup_point_class.php';
include_once 'thankpage_class.php';
include_once 'storetime_class.php';

if (isset($_POST['action'])) {

    if ($_POST['action'] == 'add_meal_paln') {
        add_meal_paln();
    }
    if ($_POST['action'] == 'delete_meals_plan') {
        delete_meals_plan();
    }
    if ($_POST['action'] == 'add_new_dish') {
        add_new_dish();
    }
    if ($_POST['action'] == 'delete_dish') {
        delete_dish();
    }
    if ($_POST['action'] == 'get_row_dishes') {
        get_row_dishes();
    }
    if ($_POST['action'] == 'save_pickup_point') {

        save_pickup_point();
    }
    if ($_POST['action'] == 'delete_location') {
        delete_pickup_point();
    }
    if ($_POST['action'] == 'update_meals_plan') {
        update_meals_plan();
    }
    if ($_POST['action'] == 'get_row') {
        get_row();
    }
    if ($_POST['action'] == 'get_row_pickup') {
        get_row_pickup();
    }
    if ($_POST['action'] == 'update_location') {
        update_location();
    }
    if ($_POST['action'] == 'thankyou_msg') {
        add_thankyou_msg();
    }
     if ($_POST['action'] == 'save_store_time') {
        save_store_time();
    }
}

function get_row() {
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $row_data = array();
        $obj_table = new menu_plan_class();
        $sql = "SELECT * FROM `meals_menu_plans` WHERE shopify_product_id = $id";
        $result = $obj_table->query($sql);

        if (!empty($result)) {
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {

                    $row_data['shopify_product_id'] = $row['shopify_product_id'];
                    $row_data['meal_name'] = $row['meal_name'];
                    $row_data['meal_units'] = $row['meal_units'];
                }
            }
        }
    }


    echo json_encode($row_data);
}

function update_meals_plan() {

    $data = array();

    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $obj_table = new menu_plan_class();
        $sql = "SELECT * FROM `meals_menu_plans` WHERE id = " . $id;
        $result = $obj_table->query($sql);
    } else {
        echo '<div class="alert alert-danger>Not saved!</div>';
    }
}

function add_meal_paln() {

    $data = array();

    if (!empty($_POST['shopify_product_id'])) {
        $shp = explode(',', $_POST['shopify_product_id']);
        $data[] = $shp[0];
        $data[] = $shp[1];
    }
    if (!empty($_POST['m_units'])) {
        $data[] = $_POST['m_units'];
    }
    $obj = new menu_plan_class();
    $rid = $obj->save_menu_plan($data);

    if ($rid) {
        echo json_encode(array("pro_id" => $rid, "msg" => "<div class='alert alert-success'>New record created successfully</div>"));
    } else {
        echo json_encode(array("msg" => '<div class="alert alert-danger>Data Not processed !</div>'));
    }
}

function update_front_data() {

    $obj_table = new menu_plan_class();
    $sql = "SELECT `* FROM `meals_menu_plans`";
    $result = $obj_table->query($sql);

    if (mysqli_num_rows($result) > 0) {

        if (!empty($result)) {
            $i = 1;
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['meal_type'] . "</td>";
                echo "<td>" . $row['meal_units'] . "</td>";
                echo "<td><input type='button' name='delete' value='Delete' data-id=" . $row['id'] . "  id='del_" . $row['id'] . "' class='btn btn-primary delete_meal'></td>";
                echo "</tr>";
                $i++;
            }
        }
    }
}

function delete_meals_plan() {
    $obj = new menu_plan_class();

    if (!empty($_POST['id'])) {
        $m_id = $_POST['id'];
        $obj->delete_menu_plan($m_id);
    }
}

/* * ******************** Dishes Setup************************** */

function add_new_dish() {
//    print_r($_POST);die;
    if ($_POST['id']) {
        $data = array();
        if (!empty($_POST['id'])) {
            $data['id'] = $_POST['id'];
        }
        if (!empty($_POST['dish_name'])) {
            $data['dish_name'] = $_POST['dish_name'];
        }
        if (!empty($_POST['dish_description'])) {
            $data['dish_description'] = $_POST['dish_description'];
        }
        if (!empty($_POST['week_day'])) {
            $data['week_day'] = $_POST['week_day'];
        }
        if (!empty($_POST['new_image_url'])) {
            $data['new_image_url'] = $_POST['new_image_url'];
        }
        if (isset($_FILES['fileToUpload'])) {

            $target_dir = 'uploads/';
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $msg = '';
            // Check if image file is a actual image or fake image
//            if (isset($_POST)) {
//                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//                if ($check !== false) {
//                    $msg = "File is an image - " . $check["mime"] . ".";
//                    $uploadOk = 1;
//                } else {
//                    $msg = "File is not an image.";
//                    $uploadOk = 0;
//                }
//            }

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $msg = "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
//            print_r($_FILES["fileToUpload"]["name"]);DIE;
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $data['image_url'] = $_FILES["fileToUpload"]["name"];
                } else {
                    $msg = "Sorry, there was an error uploading your file.";
                }
            }
        }
    } else if (isset($_POST['dish_name']) && isset($_POST['dish_description']) && isset($_POST['week_day']) && isset($_FILES['fileToUpload'])) {
        $data = array();
        
        if (!empty($_POST['dish_name'])) {
            $data['dish_name'] = $_POST['dish_name'];
        }
        if (!empty($_POST['dish_description'])) {
            $data['dish_description'] = $_POST['dish_description'];
        }
        if (!empty($_POST['week_day'])) {
            $data['week_day'] = $_POST['week_day'];
        }
        /* ======================== */
        if (isset($_FILES['fileToUpload'])) {

            $target_dir = 'uploads/';
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $msg = '';
            // Check if image file is a actual image or fake image
            if (isset($_POST)) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check !== false) {
                    $msg = "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    $msg = "File is not an image.";
                    $uploadOk = 0;
                }
            }

//            if ($_FILES["fileToUpload"]["size"] > 500000) {
//                $msg = "Sorry, your file is too large.";
//                $uploadOk = 0;
//            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $msg = "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
//            print_r($_FILES["fileToUpload"]["name"]);DIE;
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $data['image_url'] = $_FILES["fileToUpload"]["name"];
                } else {
                    $msg = "Sorry, there was an error uploading your file.";
                }
            }
        }
    }

    $obj = new menu_meals_class();
    $r_id = $obj->save_meals($data);

    if (!empty($r_id)) {
        echo json_encode(array('r_id' => $r_id, 'msg' => '<div class="alert alert-success">Successfully updated.</div>'));
    } else {
        echo json_encode(array('msg' => '<div class="alert alert-danger>Not Added !.. </div>'));
    }
}

function delete_dish() {
    $obj = new menu_meals_class();
    if (!empty($_POST['id'])) {
        $m_id = $_POST['id'];
        $obj->delete_meals($m_id);
    }
}

function get_row_dishes() {

    if (!empty($_POST['id'])) {

        $id = $_POST['id'];

        $row_data = array();

        $obj_table = new menu_meals_class();
        $sql = "SELECT * FROM `meals_menu_dish` WHERE id = $id";
        $result = $obj_table->query($sql);

        if (!empty($result)) {
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {

                    $row_data['id'] = $row['id'];
                    $row_data['name'] = $row['name'];
                    $row_data['image_url'] = $row['image_url'];
                    $row_data['description'] = $row['description'];
                    $row_data['meal_type'] = $row['meal_type'];
                    $row_data['week_day'] = $row['week_day'];
                }
            }
        }
    }

    echo json_encode($row_data);
}

/* * *********************Pickup setups***************************** */

function save_pickup_point() {


    if (!empty($_POST['id'])) {

        $data = array();

        $data['id'] = $_POST['id'];

        if (!empty($_POST['per_day_limit'])) {
            $data['per_day_limit'] = $_POST['per_day_limit'];
        }
        if (!empty($_POST['pickup_point'])) {
            $data['pickup_point'] = $_POST['pickup_point'];
        }
        if (!empty($_POST['timezones'])) {
            $data['timezones'] = $_POST['timezones'];
        }
        if (!empty($_POST['pickup_location_day'])) {
            $data['pickup_location_day'] = $_POST['pickup_location_day'];
        }
    } else {

        $data = array();

        if (isset($_POST['per_day_limit']) && isset($_POST['pickup_point']) && isset($_POST['timezones']) && isset($_POST['pickup_location_day'])) {
            if (!empty($_POST['per_day_limit'])) {
                $data['per_day_limit'] = $_POST['per_day_limit'];
            }
            if (!empty($_POST['pickup_point'])) {
                $data['pickup_point'] = $_POST['pickup_point'];
            }
            if (!empty($_POST['timezones'])) {
                $data['timezones'] = $_POST['timezones'];
            }
            if (!empty($_POST['pickup_location_day'])) {
                $data['pickup_location_day'] = $_POST['pickup_location_day'];
            }
        }
    }

    $obj = new pickup_point_class();
    $last_insertid = $obj->save_pickup_point($data);

    //print_r($last_insertid);

    if (!empty($last_insertid)) {
        echo json_encode(array('last_insertid' => $last_insertid, 'msg' => '<div class="alert alert-success">New record created successfully</div>'));
    } else {
        echo json_encode(array('msg' => '<div class="alert alert-danger>Not inserted</div>'));
    }
}

function delete_pickup_point() {

    $obj = new pickup_point_class();

    if (!empty($_POST['id'])) {
        $m_id = $_POST['id'];
        $obj->delete_pickup_point($m_id);
    }
    //print_r($expression);
}

function get_row_pickup() {
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $row_data = array();

        $obj_table = new pickup_point_class();
        $sql = "SELECT * FROM `meals_pickup_locations` WHERE id = $id";
        $result = $obj_table->query($sql);

        if (!empty($result)) {
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {

                    $row_data['id'] = $row['id'];
                    $row_data['address'] = $row['address'];
                    $row_data['perdaylimit'] = $row['perdaylimit'];
                    $row_data['timezones'] = $row['timezones'];
                    $row_data['pickup_location_day'] = $row['pickup_location_day'];
                }
            }
        }
    }


    echo json_encode($row_data);
}

function update_location() {

    $obj = new pickup_point_class();

    if (!empty($_POST['id'])) {
        $m_id = $_POST['id'];
        $result = $obj->return_location_data($m_id);

        if (!empty($result)) {
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {

                    $row_data['id'] = $row['id'];
                    $row_data['address'] = $row['address'];
                    $row_data['perdaylimit'] = $row['perdaylimit'];
                    $row_data['timezones'] = $row['timezones'];
                    $row_data['pickup_location_day'] = $row['pickup_location_day'];
                }
            }
        }
    }
    echo json_encode($row_data);
}

//Here is Thank You Page Function//
function add_thankyou_msg() {
    $data = array();
    if (isset($_POST['msg_description'])) {
        if (!empty($_POST['msg_description'])) {
            $data['msg'] = $_POST['msg_description'];
        }
    }
    /* ======================== */
    if (isset($_FILES['fileToUpload'])) {

        $target_dir = 'uploads/';
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $msg = '';
        // Check if image file is a actual image or fake image
        if (isset($_POST)) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                $msg = "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $msg = "File is not an image.";
                $uploadOk = 0;
            }
        }

        /* if ($_FILES["fileToUpload"]["size"] > 500000) {
          $msg = "Sorry, your file is too large.";
          $uploadOk = 0;
          } */
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $msg = "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
//            print_r($_FILES["fileToUpload"]["name"]);DIE;
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $data['file'] = $_FILES["fileToUpload"]["name"];
            } else {
                $msg = "Sorry, there was an error uploading your file.";
            }
        }
    }

    //Add Thank You Msg in database
    $obj = new thankpage_class();
    $r_id = $obj->add_thankyou_message($data);
    if (!empty($r_id)) {
        echo json_encode(array('msg' => '<div class="alert alert-success">Successfully updated.</div>'));
    } else {
        echo json_encode(array('msg' => '<div class="alert alert-danger>Not Added !.. </div>'));
    }
}
function save_store_time(){
   
    $data = array();
    
    if (!empty($_POST['store_id'])) {
            $data['store_id'] = $_POST['store_id'];
        }
        if (!empty($_POST['open_day'])) {
            $data['open_day'] = $_POST['open_day'];
        }
    if (!empty($_POST['open_time'])) {
            $data['open_time'] = $_POST['open_time'];
        }
        if (!empty($_POST['close_day'])) {
            $data['close_day'] = $_POST['close_day'];
        }
        if (!empty($_POST['close_time'])) {
            $data['close_time'] = $_POST['close_time'];
        }
         $obj = new store_scheduler_class();
         $r_id = $obj->update_store_time($data);
    if (!empty($r_id)) {
        echo json_encode(array('msg' => '<div class="alert alert-success">Successfully updated.</div>'));
    } else {
        echo json_encode(array('msg' => '<div class="alert alert-danger>Not Added !.. </div>'));
    }
    
}