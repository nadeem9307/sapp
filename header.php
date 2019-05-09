<?php
include_once 'login_class.php';
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

$data = array();
$obj = new login();
$data['username'] = $_SESSION['username'];
$res = $obj->heder_login_check($data);

if ($res == false) {
    header("location:login.php");
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title> fuleMe Admin Theme</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <script src="assets/js/jquery-3.2.1.js" type="text/javascript"></script>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <script src="assets/js/getstore.js" type="text/javascript"></script>
    <link href="assets/css/style.css" rel="stylesheet" />
    <script src="assets/js/data.js" type="text/javascript"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</head>
<body>
    <!-- HEADER END-->
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                

            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a id="mindex" href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                            <li><a id="mplan" href="menuplan.php"> <i class="fa fa-bars" aria-hidden="true"></i> Manage Menu Plans</a></li>
                            <li><a id="mmeanls" href="menumeals.php"> <i class="fa fa-bars" aria-hidden="true"></i></i> Manage Meals</a></li>
                            <li><a id="mpickup" href="pickuploactions.php"><i class="fa fa-bars" aria-hidden="true"></i> Manage Pickup locations</a></li>
                            <li><a id="thankyou" href="thankyou.php"><i class="fa fa-bars" aria-hidden="true"></i> Manage Thankyou Page</a></li>
                            <li><a id="thankyou" href="storetime.php"><i class="fa fa-bars" aria-hidden="true"></i> Store Time</a></li>
                             <li><a id="logout" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- MENU SECTION END-->
