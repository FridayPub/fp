<html>
    <head>
        <title>FridayPub User's Area</title>
    </head>
    <body>
        <?php
            include_once "user_header.php";
            include_once "fpdb.php";

            include_once "snapshot_hack.php";

            try {
                $db = new FPDB($_SESSION["credentials"]);
            } catch (FPDBException $e) {
                die($e->getMessage());
            }

            /* Print radio buttons, one for each beer on inventory. */
            try {
                $db->inventory_get();
            } catch (FPDBException $e) {
                die($e->getMessage());
            }

            printf("<form action=\"%s\" method=\"post\">", $_SERVER["PHP_SELF"]);
            foreach ($db as $inventory_item) {
                $beer_id = $inventory_item["beer_id"];

                printf("<input type=\"radio\" name=\"beer_id\" value=%d> %s </br>", 
                    $beer_id, beer_name($beer_id));
            }
            printf("<input type=\"submit\" name=\"submit\" value=\"Register\"/>");
            printf("</form>");


            /* Record beer purchase in the database. */
            if (isset($_POST["submit"])) {
                $user_id = $_SESSION["user_id"];
                $beer_id = $_POST["beer_id"];

                try {
                    $db->purchase_append($user_id, $beer_id);
                } catch (FPDBException $e) {
                    die($e->getMessage());
                }

                printf("One large beer sold to %s %s<br/>",
                    $_SESSION["first_name"], $_SESSION["last_name"]);
            }
        ?>
    </body>
</html>
