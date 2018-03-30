<section class="table">
    <div id="catalog" ></div>
    <table id="products">
        <tr>
            <th>Book Name</th>
            <th>Author</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Genre</th>
            <th>Image</th>
            <?php if (isset($_SESSION["user"])) { ?>
    <th>To Cart</th>
<?php } ?>

<?php if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] == 1) { ?>
    <th>Redact</th>
<?php } ?>
</tr>
<?php
foreach ($products as $product) {
    if ($product["quantity"] > 0) {
        ?>
        <tr>
            <td><?= $product["name"] ?></td>
            <td><?= $product["author_id"] ?></td>
            <td><?= $product["price"] ?></td>
            <td><?= $product["quantity"] ?></td>
            <td><?= $product["category_id"] ?></td>
            <td>
                <img id="book_img" src="./assets/uploads/product_img/<?= $product["img_url"]; ?>" alt="book_img">
                <?php if (isset($_SESSION["user"])) { ?>
                    <button id="like" class="like" onclick="likeProduct(this.value)" value="<?= $product["name"] ?>">Like</button>
                <?php } ?>
            </td>

            <?php if (isset($_SESSION["user"])) { ?>
                <td>
                    <button class="btn info" value="<?= $product["name"]; ?>" onclick="addToCart(this.value);" >Add to Cart</button>
                </td>
            <?php } ?>
            <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] == 1) { ?>
                <td>
                    <form action="./controller/productsController.php" method="GET">
                        <input type="hidden" name="book_name" value="<?= $product["name"] ?>"/>
                        <input type="submit" class="btn info" name="redact" value="Redact"/>
                    </form>
                </td>
            <?php } ?>
        </tr>
        <?php
    }
}
?>
</table>

</section>