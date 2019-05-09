<?php include_once 'header.php';?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Dashboard</h4>

                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success">
                       From this dashboard admin can manage following :<br>
                       -Admin can manage Menu plans<br>
                       -Admin can mange Menu dishes for each week.<br>
                       -Admin can setup pickup location limits.<br>
                       -Admin can change per week order limit for each pickup location .<br>
                       -Admin can manage the order start and end time from dashboard for pickup locations. <br>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="dashboard-div-wrapper bk-clr-one">
                        <i class="fa fa-eye dashboard-div-icon"></i>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            </div>

                        </div>
                        <h5>Manage Menu Plans</h5>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="dashboard-div-wrapper bk-clr-two">
                        <i class="fa fa-edit dashboard-div-icon"></i>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                            </div>

                        </div>
                        <h5>Manage Meals</h5>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="dashboard-div-wrapper bk-clr-three">
                        <i class="fa fa-cogs dashboard-div-icon"></i>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            </div>

                        </div>
                        <h5>Manage Pickup locations</h5>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="dashboard-div-wrapper bk-clr-four">
                        <i class="fa fa-bell-o dashboard-div-icon"></i>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                            </div>

                        </div>
                        <h5>Order Alerts</h5>
                    </div>
                </div>

            </div>

        </div>
    </div>
<?php include 'footer.php';?>   
