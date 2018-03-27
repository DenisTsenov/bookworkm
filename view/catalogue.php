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
                <?php
            }
            ?>

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
                        <button id="like" class="like" onclick="likeProduct(this.value)" value="<?= $product["name"] ?>">Like</button>
                    </td>

                    <?php if (isset($_SESSION["user"])) { ?>
                        <td>
                            <button class="btn info" value="<?= $product["name"]; ?>" onclick="addToCart(this.value);successAdd(this.value)" >Add to Cart</button>
                        </td>
                        <?php
                    }
                    ?>
                    <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] == 1) { ?>
                        <td>        
                            <form action="./controller/productsController.php" method="GET">
                                <input type="hidden" name="book_name" value="<?= $product["name"] ?>"/>
                                <input type="submit" class="btn info" name="redact" value="Redact"/>
                            </form>
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

<script type="text/javascript">
//    function getLikedProducts() {
//        var userId = "<?= $_SESSION["user"]["id"] ?>";
//
//        var request = new XMLHttpRequest();
//
//        request.open("GET", "./controller/productsController.php?user_id=" + userId, true);
//        request.onreadystatechange = function () {
//            if (this.readyState === 4 && this.status === 200) {
//                var resp =  JSON.parse(this.responseText);
//                for(j in resp){
//                    var f = document.getElementsByClassName("like")
////                    var d = document.getElementById("like");
//                    f.innerHTML = resp[j]["b_id"];
//                }
//            }
//        };
//        request.send();
//    }
    function likeProduct(like_name) {
        var req = new XMLHttpRequest();
        req.open("POST", "./controller/productsController.php", true);
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var result = JSON.parse(this.responseText);
                var getId = document.getElementById("catalog");

                var res = document.createElement("h3");
                res.setAttribute("id", "finish");
                
                res.innerHTML = result[0];
                getId.appendChild(res);

            }
        };
        req.send("like_for=" + like_name);
    }

</script>