<?php
include_once 'pickuplocation.inc.php';
include_once 'header.php';
?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-head-line">Pickup Location</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading pickup_ins">

                    </div>
                    <div class="panel-body">
                        <form name="pickup_point_form"  id="pickup_point_form"  method="post">
                            <div class="form-group">

                                <label for="mealunit">Per Day Order Limit</label>
                                <input type="number" class="form-control" id="per_day_limit" name="per_day_limit" placeholder="per day order limit" required="true">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pickup Point Name</label>
                            </div>
                            <div class="form-group">
                                <textarea cols="40" rows="2" name="pickup_point" id="pickup_point" placeholder="Pickup point Address here .."></textarea>
                            </div> 
                            <div class="form-group">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="pickup_location_day" class="pickup_location_day" value="Monday" checked="true">
                                        Monday 
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="pickup_location_day" class="pickup_location_day" value="Wednesday" >
                                        Wednesday
                                    </label>
                                </div>

                            </div>    
                            <div class="form-group">
                                <label class="control-label" for="name">Which timezone do you follow?</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    <select class="form-control" name="timezones" class="selectpicker" id="timezones">
                                        <option value="">Select All</option>
                                        <option value="Europe/Helsinki">Europe/Helsinki</option>
                                        <option value="Europe/Amsterdam">Europe/Amsterdam</option>
                                        <option value="Europe/Andorra">Europe/Andorra</option>
                                        <option value="Europe/Asoptionakhan">Europe/Asoptionakhan</option>
                                        <option value="Europe/Athens">Europe/Athens</option>
                                        <option value="Europe/Belgrade">Europe/Belgrade</option>
                                        <option value="Europe/Berlin">Europe/Berlin</option>
                                        <option value="Europe/Bratislava">Europe/Bratislava</option>
                                        <option value="Europe/Brussels">Europe/Brussels</option>
                                        <option value="Europe/Bucharest">Europe/Bucharest</option>
                                        <option value="Europe/Budapest">Europe/Budapest</option>
                                        <option value="Europe/Busingen">Europe/Busingen</option>
                                        <option value="Europe/Chisinau">Europe/Chisinau</option>
                                        <option value="Europe/Copenhagen">Europe/Copenhagen</option>
                                        <option value="Europe/Dublin">Europe/Dublin</option>
                                        <option value="Europe/Gibraltar">Europe/Gibraltar</option>
                                        <option value="Europe/Guernsey">Europe/Guernsey</option>
                                        <option value="Europe/Isle_of_Man">Europe/Isle_of_Man</option>
                                        <option value="Europe/Istanbul">Europe/Istanbul</option>
                                        <option value="Europe/Jersey">Europe/Jersey</option>
                                        <option value="Europe/Kaliningrad">Europe/Kaliningrad</option>
                                        <option value="Europe/Kiev">Europe/Kiev</option>
                                        <option value="Europe/Kirov">Europe/Kirov</option>
                                        <option value="Europe/Lisbon">Europe/Lisbon</option>
                                        <option value="Europe/Ljubljana">Europe/Ljubljana</option>
                                        <option value="Europe/London">Europe/London</option>
                                        <option value="Europe/Luxembourg">Europe/Luxembourg</option>
                                        <option value="Europe/Madrid">Europe/Madrid</option>
                                        <option value="Europe/Malta">Europe/Malta</option>
                                        <option value="Europe/Mariehamn">Europe/Mariehamn</option>
                                        <option value="Europe/Minsk">Europe/Minsk</option>
                                        <option value="Europe/Monaco">Europe/Monaco</option>
                                        <option value="Europe/Moscow">Europe/Moscow</option>
                                        <option value="Europe/Oslo">Europe/Oslo</option>
                                        <option value="Europe/Paris">Europe/Paris</option>
                                        <option value="Europe/Podgorica">Europe/Podgorica</option>
                                        <option value="Europe/Prague">Europe/Prague</option>
                                        <option value="Europe/Rome">Europe/Rome</option>
                                        <option value="Europe/Samara">Europe/Samara</option>
                                        <option value="Europe/San_Marino">Europe/San_Marino</option>
                                        <option value="Europe/Sarajevo">Europe/Sarajevo</option>
                                        <option value="Europe/Saratov">Europe/Saratov</option>
                                        <option value="Europe/Simferopol">Europe/Simferopol</option>
                                        <option value="Europe/Skopje">Europe/Skopje</option>
                                        <option value="Europe/Sofia">Europe/Sofia</option>
                                        <option value="Europe/Stockholm">Europe/Stockholm</option>
                                        <option value="Europe/Tallinn">Europe/Tallinn</option>
                                        <option value="Europe/Tirane">Europe/Tirane</option>
                                        <option value="Europe/Ulyanovsk">Europe/Ulyanovsk</option>
                                        <option value="Europe/Uzhgorod">Europe/Uzhgorod</option>
                                        <option value="Europe/Vaduz">Europe/Vaduz</option>
                                        <option value="Europe/Vatican">Europe/Vatican</option>
                                        <option value="Europe/Vienna">Europe/Vienna</option>
                                        <option value="Europe/Vilnius">Europe/Vilnius</option>
                                        <option value="Europe/Volgograd">Europe/Volgograd</option>
                                        <option value="Europe/Warsaw">Europe/Warsaw</option>
                                        <option value="Europe/Zagreb">Europe/Zagreb</option>
                                        <option value="Europe/Zaporozhye">Europe/Zaporozhye</option>
                                        <option value="Europe/Zurich">Europe/Zurich</option>

                                    </select>

                                </div>
                            </div>
                            <input type="button" name="add" value="Save pickup point" class="btn btn-primary save_pickup_point">
                            <input type="text" name="action" value="save_pickup_point" hidden="true">
                            <input type="reset" value="reset" class="btn btn-primary"> 
                            <input type="text" name="id" id="r_id" value="" hidden="true">
                        </form>
                        <div class="pickup_msg">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Available Pickup Locations
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive output_menu_meals">
                            <table class='table table-striped table-bordered table-hover'>
                                <thead><tr>
                                        <th>#</th>
                                        <th>Location</th>
                                        <th>Day Limit</th>
                                        <th>Day</th>
                                        <th>Time Zone</th>
                                        <th>Action</th>
                                    </tr>
                                <thead><tbody>
                                    <?php
                                    if (!empty($result_table)) {
                                        $i = 1;
                                        while ($row = mysqli_fetch_array($result)) {
                                            echo "<tr class='" . $row['id'] . "'>";
                                            echo "<td>#" . $row['id']. "</td>";
                                            echo "<td>" . $row['address'] . "</td>";
                                            echo "<td>" . $row['perdaylimit'] . "</td>";
                                            echo "<td>" . $row['pickup_location_day'] . "</td>";
                                            echo "<td>" . $row['timezones'] . "</td>";
                                            echo "<td><button name='delete' value='Delete' data-id=" . $row['id'] . " class='btn btn-primary btn-xs delete_location'><i class='fa fa-trash-o' aria-hidden='true'></i></button>"
                                            . "<button name='edit' value='Edit' data-id='" . $row['id'] . "'  class='btn btn-primary btn-xs update_pickup'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button></td>";
                                            echo "</tr>";
                                            $i++;
                                        }
                                    } else {
                                        echo "<div class='no_data'>No records matching  found.</div>";
                                    }
                                    ?>
                                </tbody></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!--                <div class="alert alert-warning">
                                    This is blank page for which you can customize for your project. 
                                    Use this admin template 100% free to use for personal and commercial use which is crafted by 
                                    <br />
                                    <a href="http://www.designbootstrap.com/" target="_blank">DesignBootstrap.com</a> . For more free templates and snippets keep looking <a href="http://www.designbootstrap.com/" target="_blank">DesignBootstrap.com</a> . Hope you will like our work
                
                                </div>-->
            </div>

        </div>
    </div>
</div>
<?php include 'footer.php'; ?>    