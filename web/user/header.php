<?php
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
    	<link rel="stylesheet" href="../css/friday_pub.css">
    	<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
	
        <title>FridayPub Admin's Area</title>
    </head>
    <body>
    <?php 
        echo "FridayPub User's Area<br>";
        echo "Logged in as: <b>${_SESSION["username"]}</b> ";
    ?>

<a href="../common/logout.php">(logout)</a> <br>
<a href="../user/buy_beer.php">BUY BEER</a>
<a href="../user/iou.php">IOU</a>
<a href="../user/history.php">HISTORY</a>
<hr>
