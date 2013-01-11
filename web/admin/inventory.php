<?php
    include_once "header.php";
    include_once "../fpdb/fpdb.php";

    try {
        $db = new FPDB_Admin();
    } catch (FPDB_Exception $e) {
        die($e->getMessage());
    }
?>

<table>
    <tr>
        <th>Beer</th>
        <th>Amount</th>
        <th>Price</th>
    </tr>

    <?php
        try {
            $qres = $db->inventory_get_all();
        } catch (FPDB_Exception $e) {
            die($e->getMessage());
        }

        /* For each beer in inventory, insert row a in the table */
        foreach ($qres as $inventory_item) {
            $beer_name = $inventory_item["namn"];
            $beer_name .= " ".$inventory_item["namn2"];
            $beer_sbl_price = $inventory_item["sbl_price"];
            $beer_fp_price = $inventory_item["pub_price"];
            $beer_id = $inventory_item["beer_id"];
            $count = $inventory_item["count"];

            printf("<tr><td>%s (%s)</td><td>%d</td><td>%d (%.2f)</td></tr>",
                $beer_name, $beer_id, $count, $beer_fp_price, $beer_sbl_price);
        }
    ?>

</table>
<br>
<ul class="menu">
<li><a href="../admin/reg_beers.php">REGISTER BEERS</a></li>
</ul>
<?php 
    include_once "footer.php"; 
?>
