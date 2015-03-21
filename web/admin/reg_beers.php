<?php
    include_once "header.php";
    include_once "../fpdb/fpdb.php";

    try {
        $db = new FPDB_Admin($_SESSION["credentials"]);
    } catch (FPDB_Exception $e) {
        die($e->getMessage());
    }

    if (isset($_POST["submit"])) {
        $user_id = $_SESSION["user_id"];
        extract($_POST);

        try {
            $db->inventory_append($user_id, $beer_id, $amount, $price);
        } catch (FPDB_Exception $e) {
            die($e->getMessage());
        }
    }
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

        <div>
            <input class="beer_id" id="bid" type="text" required="required" name="beer_id" placeholder="Beer ID"/>
            <span id="name"></span>
            <input class="beer_amount" type="text" required="required" name="amount" placeholder="Amount"/>
            <input type="submit" name="submit" value="Register"/>
        </div>
</form>

<br><br>
<h2>Entries today:</h2>
<table>
    <tr>
	<th>ID</th>
        <th>Amount</th>
        <th>Price</th>
        <th>Name</th>
    </tr>

    <?php
        try {
            $qres = $db->inventory_check_latest();
        } catch (FPDB_Exception $e) {
            die($e->getMessage());
        }

        /* For each beer in inventory, insert row a in the table */
        foreach ($qres as $inventory_item) {
            $beer_name = $inventory_item["namn"];
            $beer_name .= " ".$inventory_item["namn2"];
            $beer_sbl_price = $inventory_item["price"];
            $beer_id = $inventory_item["beer_id"];
            $amount = $inventory_item["amount"];

            printf("<tr><td>%s</td><td>%d</td><td>%.2f</td><td>%s</td></tr>",
                $beer_id, $amount, $beer_sbl_price, $beer_name);
        }
    ?>

</table>
<br>
<br>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    If necessary, fetch new xml-data from systembolaget:
    <input type="submit" name="submit_sbl" value="Update"/>
</form>

<script type="text/javascript">
	$(".beer_amount").blur(function () {
		//create next line
		
		});
	$(".beer_id").blur(function () {
		$("#name").load("load_beer_name.php?beer_id=" + $("#bid").val());
		
		});
</script>
<?php
    if (isset($_POST["submit_sbl"])) {
        try {
            /* Hardcode file path for now. */
            exec('bash ../tools/fetch_sbl_xml.sh');
            sbl_insert_snapshot($db, "../xml/sbl-latest.xml");
        } catch (FPDB_Exception $e) {
            die($e->getMessage());
        }
    }
    include_once "footer.php"; 
?>
