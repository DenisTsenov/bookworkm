<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!$_SESSION["user"]) {
    header("Location: index.php");
}
?>
    <table id="products">
        <tr>
            <th>Book Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Minus one!</th>
            <th>Remove</th>
        </tr>
        <?php $total = 0; ?>
        <?php
        foreach ($_SESSION["bucket"] as $productInBucket) {
            $total += $productInBucket["price"] * $productInBucket["quantity"];
            ?>
            <tr>
                <td><?= $productInBucket["name"] ?></td>
                <td><?= $productInBucket["price"] ?></td>
                <td><?= $productInBucket["quantity"] ?></td>
                <td><button class="" value="<?= $productInBucket["name"] ?>" onclick="reverseQuantity(this.value)">Minus one quantity</button></td>
                <td><button class="" value="<?= $productInBucket["name"] ?>" onclick="removeBook(this.value)">Remove</button></td>
            </tr>

            <?php
        }
    
    ?>
</table>
<?php
if (!$_SESSION["bucket"]) {
    echo "<h3>Your  Bucket is empty!</h3>";
} else {  ?>
    <?= isset($total) ? "<h4>Total in  bucket &nbsp -> &nbsp" . $total . "</h4>" : "" ?>
<?php }
?>



