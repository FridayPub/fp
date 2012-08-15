<?php
    include_once "header.php";
    include_once "../common/fpdb.php";

    $user_id = $_SESSION["user_id"];
    try {
        $db = new FPDB_User();
        $iou = $db->iou_get($user_id)->next();
    } catch (FPDB_Exception $e) {
        die($e->getMessage());
    }

    extract($iou);
    printf("<h1>%dkr</h1></br>", $assets);
    include_once "footer.php"; 
?>