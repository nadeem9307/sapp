<?php
include_once 'storetime.inc.php';
include_once 'header.php';

?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-head-line">Store Time Scheduler</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading pickup_ins">
                        
                    </div>
                    <div class="panel-body">
                        <form name="store_time_form"  id="store_time_form"  method="post">
                            <div class="form-group col-md-6">
                                <label for="storeopeningday">Opening Day</label>
                                <select class="form-control" id="open_day">
                                    <option value="Monday" <?php echo($store_data['open_day']=="Monday")?"selected":""?>>Monday</option>
                                    <option value="Tuesday" <?php echo($store_data['open_day']=="Tuesday")?"selected":""?>>Tuesday</option>
                                    <option value="Wednesday" <?php echo($store_data['open_day']=="Wednesday")?"selected":""?>>Wednesday</option>
                                    <option value="Thursday" <?php echo($store_data['open_day']=="Thursday")?"selected":""?>>Thursday</option>
                                    <option value="Friday" <?php echo($store_data['open_day']=="Friday")?"selected":""?>>Friday</option>
                                    <option value="Saturday" <?php echo($store_data['open_day']=="Saturday")?"selected":""?>>Saturday</option>
                                    <option value="Sunday" <?php echo($store_data['open_day']=="Sunday")?"selected":""?>>Sunday</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="open_time">Opening Time</label>
                                
                                <input type="text" class="form-control timepicker text-center" id="open_time" name="open_time" value="<?php if(isset($store_data['open_time'])){echo $store_data['open_time'];} ?>" placeholder="store opening time" required="true">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="storeclosingday">Closing Day</label>
                                <select class="form-control" id="close_day">
                                    <option value="Monday" <?php echo($store_data['close_day']=="Monday")?"selected":""?>>Monday</option>
                                    <option value="Tuesday" <?php echo($store_data['close_day']=="Tuesday")?"selected":""?>>Tuesday</option>
                                    <option value="Wednesday" <?php echo($store_data['close_day']=="Wednesday")?"selected":""?>>Wednesday</option>
                                    <option value="Thursday" <?php echo($store_data['close_day']=="Thursday")?"selected":""?>>Thursday</option>
                                    <option value="Friday" <?php echo($store_data['close_day']=="Friday")?"selected":""?>>Friday</option>
                                    <option value="Saturday" <?php echo($store_data['close_day']=="Saturday")?"selected":""?>>Saturday</option>
                                    <option value="Sunday" <?php echo($store_data['close_day']=="Sunday")?"selected":""?>>Sunday</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="close_time">Closing Time</label>
                                <input type="text" class="form-control timepicker text-center" id="close_time" name="close_time" value="<?php if(isset($store_data['close_time'])){echo $store_data['close_time'];} ?>" placeholder="store closing time" required="true">
                            </div>
                        
                            <input type="button" name="add" value="Save Store Time" class="btn btn-primary save_store_time" id="store">
                            <input type="text" name="action" value="save_store_time" hidden="true">
                            <!-- <input type="reset" value="reset" class="btn btn-primary">  -->
                            <input type="text" name="id" id="r_id" value="<?php if(isset($store_data['store_id'])){echo $store_data['store_id'];}?>" hidden="">
                        </form>
                        <div class="pickup_msg">

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