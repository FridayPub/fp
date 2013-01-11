<?php
    include_once "header.php";
    include_once "../fpdb/fpdb.php";

    try {
        $db = new FPDB_User();
    } catch (FPDB_Exception $e) {
        die($e->getMessage());
    }

   /* Record beer purchase in the database. */
    if (isset($_POST["submit"])) {
        $user_id = $_SESSION["user_id"];
        $beer_id = $_POST["beer_id"];

        try {
            $db->purchases_append($user_id, $beer_id);
        } catch (FPDB_Exception $e) {
            die($e->getMessage());
        }

        printf("One large beer sold to %s %s<br/>",
            $_SESSION["first_name"], $_SESSION["last_name"]);
    }
  
    /* Print radio buttons, one for each beer on inventory. */
    try {
        $qres = $db->inventory_get_all();
    } catch (FPDB_Exception $e) {
        die($e->getMessage());
    }

    printf("<form action=\"%s\" method=\"post\">", $_SERVER["PHP_SELF"]);
    foreach ($qres as $inventory_item) {
        $beer_name = $inventory_item["namn"];
        $beer_name .= " ".$inventory_item["namn2"];
        $beer_id = $inventory_item["beer_id"];
        $beer_price = $inventory_item["pub_price"] ;
        $beer_count = $inventory_item["count"];
        if ($beer_count > 0)
            printf("<input id=\"$beer_id\" type=\"radio\" name=\"beer_id\" value=%d><label for=\"$beer_id\"> <span style=\"color: #f092a5\">&bull;</span> %s, %d kr (%d kvar)</label></br>", 
            $beer_id, $beer_name, $beer_price, $beer_count);
    }
    printf("<input class=\"login\" type=\"submit\" name=\"submit\" value=\"BUY!\"/>");
    printf("</form>");

    include_once "footer.php"; 
?>
