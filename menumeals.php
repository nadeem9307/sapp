<?php
include_once 'menumeals.inc.php';
include_once 'header.php';
?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-head-line">Weekly Meals</h4>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">


            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading pickup_ins">

                    </div>
                    <div class="panel-heading">
                        Monday & Wednesday dishes
                    </div>
                    <div class="panel-body">
                        <form name="weekly_dishes" method="post" id="weekly_dishes" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name of the dish</label>
                                <input type="text" class="form-control" id="sish_name" name="dish_name" placeholder="Enter name">                           
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Choose day dish availability on</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="week_day" id="week_day" value="Monday" checked="">
                                        Monday 
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="week_day" id="week_day" value="Wednesday" checked="">
                                        Wednesday
                                    </label>
                                </div>

                            </div> 
                            <div class="form-group">
                                <label for="exampleInputPassword1">Some description about ingredient's:</label>
                            </div>
                            <div class="form-group">
                                <textarea cols="40" rows="4" name="dish_description" id="dish_description" placeholder="Short description here .."></textarea>
                            </div>
                            <div class="form-group">
                                <label for="img">Dish Image</label>
                                <input type="file" name="fileToUpload" id="fileToUpload" value="">
                                <input type="text" name="new_image_url" id="new_image_url" value="" hidden="true">
                                <p class="help-block">Example Image size ( 150px X 150px )</p>
                                
                               

                            </div>
                            <input type="text" name="action" value="add_new_dish" hidden="true">
                            <input type="button" name="add_disk" class="btn btn-primary add_dish_meal" value="Save Dish!">
                            <input type="reset" name="reset" class="btn btn-primary" value="Reset">
                            <input type="text" name="id" id="r_id" value="" hidden="true">
                        </form>
                        <div class="msg_dish_error">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Dishes database
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive output_menu_plans_dishes">
                            <table class='table table-striped table-bordered table-hover'>
                                <thead><tr>
                                        <th>#code</th>
                                        <th>Image</th>
                                        <th>Dish Name</th>
                                        <th>Description</th>
                                        <th>Week Day</th>
                                        <th>Action</th>
                                    </tr><thead>
                                <tbody>
                                    <?php
                                    if (!empty($result_table)) {
                                        $i = 1;
                                        while ($row = mysqli_fetch_array($result)) {
                                            echo "<tr class='" . $row['id'] . "'>";
                                            echo "<td>#" . $row['id'] . "</td>";
                                            echo "<td><img src='" . url() . "/dev/uploads/" . $row['image_url'] . "' width='80px'/></td>";
                                            // echo "<td><img src='" . url() . "/fuleMeApp/dashboard-theme/uploads/" . $row['image_url'] . "' width='80px'/></td>";
                                            echo "<td>" . $row['name'] . "</td>";
                                            echo "<td>" . $row['description'] . "</td>";
                                            echo "<td>" . $row['week_day'] . "</td>";
                                            echo "<td><button name='delete' value='Delete' data-id=" . $row['id'] . " class='btn btn-primary btn-xs delete_dish'><i class='fa fa-trash-o' aria-hidden='true'></i></button>";
                                            echo "<button name='edit' value='Edit' data-id=" . $row['id'] . " class='btn btn-primary btn-xs update_dish'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button><br></td>";
                                            echo "</tr>";
                                            $i++;
                                        }
                                    } else {
                                        echo "<div class='no_dish_er'>No records matching  found.</div>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>    