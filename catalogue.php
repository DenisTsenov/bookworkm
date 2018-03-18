<section class="table">
    <table id="products">
        <tr>
            <th>Book Name</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Image</th>
            <?php if (isset($_SESSION["user"])) { ?>
                <th>To Cart</th>
                <?php
            }
            ?>
        </tr>
        <?php
        foreach ($products as &$product) {
            if ($product["quantity"] > 0) {
                ?>
                <tr>
                    <td><?= $product["book_name"] ?></td>
                    <td><?= $product["author"] ?></td>
                    <td><?= $product["type"] ?></td>
                    <td><?= $product["price"] ?></td>
                    <td><?= $product["quantity"] ?></td>
                    <td><img id="book_img" src="./assets/uploads/product_img/<?= $product["img"]; ?>" alt="book_img"></td>
                    <?php if (isset($_SESSION["user"])) { ?>
                        <td>
                            <button class="btn info" value="<?= $product["book_name"]; ?>" onclick="addToCart(this.value);successAdd(this.value)" >Add to Cart</button>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</section>