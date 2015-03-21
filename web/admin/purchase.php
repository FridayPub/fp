<?php
    include_once "header.php";
    include_once "../fpdb/fpdb.php";

    try {
        $db = new FPDB_Admin();
    } catch (FPDB_Exception $e) {
        die($e->getMessage());
    }
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <select name = "user_id">
	<option value = "choose"> --- Choose user --- </option>
        
	<?php
            /* User dropdown */
            try {
                $qres = $db->user_get_all();
            } catch (FPDB_Exception $e) {
                die($e->getMessage());
            }

            foreach ($qres as $user) {
                printf("<option value = %d> %s %s </option>",
                    $user["user_id"], $user["first_name"], $user["last_name"]);
            }
        ?>

    </select>
    <select name = "beer_id">
        <option value = "choose"> --- Choose beverage --- </option>

        <?php
            /* Beer dropdown */
            try {
                $qres = $db->inventory_get_all();
            } catch (FPDB_Exception $e) {
                die($e->getMessage());
            }

            foreach ($qres as $inventory_item) {
                $beer_name = $inventory_item["namn"] . " " . $inventory_item["namn2"];
		$beer_size = $inventory_item["size"] . " ml";
		$beer_price = $inventory_item["pub_price"] . " kr";
                $beer_id = $inventory_item["beer_id"];

                printf("<option value = %d> %s (%s) %s </option>", 
                    $beer_id, $beer_name, $beer_size, $beer_price);
            }
        ?>

    </select>
    <input type="submit" name="submit" value="Register"/>
</form>

<?php

    /*
     * Returns the array of purchase data
     */
    function getPurchases($db) {
        $qres;
            try {
            $qres = $db->purchases_get_all();
        } catch (FPDB_Exception $e) {
            die($e->getMessage());
        }
        return $qres;
    }

    function formatPurchases($qres)
    {
    global $db;
        $p_table = "";
        $p_table .= "<div class=\"tablewrapper\">";
        $p_table .= "<h2>Purchases</h2>";
        $p_table .= "<table class=\"history\">";
        foreach ($qres as $purchase)
        {
            $p_table .= sprintf("<tr><th>%s</th><td>%s %s (%s)</td><td>%s %s (%d)</td><td class=\"right\">%d&nbsp;kr</td></tr>",
                $purchase["timestamp"], $purchase["first_name"], $purchase["last_name"], $purchase["username"], $purchase["namn"], $purchase["namn2"], $purchase["beer_id"], $purchase["price_out"]);
        }
        $p_table .= "</table>";
        $p_table .= "</div>";

        return $p_table;
    }
?>



<?php
    
    if (isset($_POST["submit"]) && ($_POST["user_id"] === "choose" || $_POST["beer_id"] === "choose")) {
    	printf("Please choose both user and beverage before trying to complete purhase<br>");    
    } else if (isset($_POST["submit"])) {
    	$admin_id = $_SESSION["user_id"];
        extract($_POST);

        try {
            $db->purchases_append($user_id, $beer_id);
	    printf("Purchase successful<br>");
        } catch (FPDB_Exception $e) {
            die($e->getMessage());
        }
    }

    $purchases = getPurchases($db);
    echo formatPurchases($purchases);

    include_once "footer.php"; 
?>

