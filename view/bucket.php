<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!$_SESSION["user"]) {
    header("Location: index.php");
}
?>

<div id="addBook">
    <table id="products">
        <tr>
            <th>Book Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Minus one!</th>
            <th>Remove</th>
        </tr>
        <?php $total = 0;
        ?>
        <?php
        if (isset($_SESSION["bucket"])) {


            foreach ($_SESSION["bucket"] as $productInBucket) {
                $total += $productInBucket["price"] * $productInBucket["quantity"];
                ?>
                <tr id="list">
                    <td id="name"><?= $productInBucket["name"] ?></td>
                    <td id="price"><?= $productInBucket["price"] ?></td>
                    <td id="quantity"><?= $productInBucket["quantity"] ?></td>
                    <td><button value="<?= $productInBucket["name"] ?>" onclick="reverseQuantity(this.value)">Minus one quantity</button></td>
                    <td><button value="<?= $productInBucket["name"] ?>" onclick="removeBook(this.value)">Remove</button></td>
                </tr>

                <?php
            }
        }
        ?>
    </table>
    <?php
    if (!isset($_SESSION["bucket"])) {
        echo "<h3>Your  Bucket is empty!</h3>";
    } else {
        ?>
        <?= isset($total) ? "<h4 id='total' >Total in  bucket &nbsp -> &nbsp" . $total . "</h4>" : "" ?>
        <button class="finish" id="finish" onclick="finishOrder();" value="">Finish your order!</button>
    <?php } ?>
</div>
<script type="text/javascript">
    function convertTableIntoArray(tbl) {
        var tblData = "";
        var tblArr = new Array();
        tblLength = document.getElementById(tbl).rows.length;
        for (i = 0; i < tblLength; i++) {
            tblData = "";
            for (j = 0; j < 3; j++) {
                tblData += document.getElementById(tbl).rows[i].cells[j].innerHTML + ",";
            }
            tblData = tblData.substring(0, tblData.length - 1);
            tblArr[i] = tblData.split(",");
        }
        return tblArr;
//            console.log(tblArr);
    }
    function finishOrder() {

        $.ajax({
            type: "POST",
            data: {info: convertTableIntoArray("products")},
            url: "./controller/ordersController.php",
            success: function () {

                for (var i = 0; i <= convertTableIntoArray("products").length + 2; i++) {
                    var elem = document.getElementById("list");
                    elem.parentNode.removeChild(elem);
                }


                var total = document.getElementById("total");
                total.parentNode.removeChild(total);

                var finish = document.getElementById("finish");
                finish.parentNode.removeChild(finish);

                var div = document.getElementById("addBook");
                var h3 = document.createElement("h3");

                h3.innerHTML = "Congrats! You finished  your order :)";
                div.appendChild(h3);

//                location.reload();
//                alert(this.responseText);
            }
        });
    }


</script>




