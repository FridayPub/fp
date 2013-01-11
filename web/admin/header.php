<?php
    include_once "../include/credentials.php";
    
    if (!session_start()) {
        die("Couldn't start session");
    }

    if (!isset($_SESSION["loggedin"])) {
        head("../index.html");
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
    	<meta charset="UTF-8">
    	<link rel="stylesheet" href="../css/friday_pub.css">
    	<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <meta name="viewport" content="initial-scale=1.0, width=device-width" />
        <title>FridayPub Banks of Bros's</title>
    </head>
    <body>
    <?php 
        $credentials = $_SESSION["credentials"];
        if ($credentials != CRED_ADMIN) {
            die("BUG: Non-admin user is accessing admin area");
        }
    ?>
        <h1>FridayPub Bank</h1>
        <div class="logout">Logged in as:
            <?php echo $_SESSION["username"]; ?>
        	<a href="../common/logout.php">(logout)</a>
        </div>
        <ul class="menu">
            <li><a href="../admin/inventory.php">OUR BEERS BRO</a></li>
            <li><a href="../admin/iou.php">UR BANK BRO</a></li>
            <li><a href="../admin/payment.php">U PAY UP BRO</a></li>
            <li><a href="../admin/purchase.php">U BUY BRO</a></li>
            <li><a href="../admin/add_user.php">ADD BRO</a></li>
		</ul>
		<div class="clearfix"></div>
