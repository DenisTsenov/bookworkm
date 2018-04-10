<?php
if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] !== 1) {
    header("Location: index.php?page=userCatalog");
}

if (!isset($_SESSION["user"])) {
    header("Location: index.php?page=guestCatalog");
}
?>
<div id="mod"></div>
<section class="table" id="table">
    <div id="catalog" ></div>
    <table id="products">
        <thead>
            <tr>
                <th>Book Name</th>
                <th>Author</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Genre</th>
                <th>Image</th>
                <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] == 1) { ?>
                    <th>Redact</th>
                <?php } ?>

                <?php if (isset($_SESSION["user"])) { ?>
                    <th>To cart</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody id="product">

        </tbody>
    </table>
    <div id="links"></div>
</section>

<script type="text/javascript">

    createLinks(3);
    getCatalog(1, 3);
    /*
     * create  pages for  catalog
     * with pagination
     */
    function getCatalog(page, articles) {
        var request = new XMLHttpRequest();
        request.open("GET", "./controller/catalogController.php?page=" + page +
                "&articles=" + articles, true);
        request.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var resp = JSON.parse(this.responseText);
//                console.log(resp);
                var table = document.getElementById("product");

                table.innerHTML = "";
                for (i in resp) {
                    if (resp[i]["quantity"] > 0) {


                        var tr = document.createElement("tr");

                        var name = document.createElement("td");
                        name.innerHTML = resp[i]["name"];

                        var price = document.createElement("td");
                        price.innerHTML = resp[i]["price"];

                        var quantity = document.createElement("td");
                        quantity.setAttribute("id", resp[i]["name"]);
                        quantity.innerHTML = resp[i]["quantity"];

                        var img = document.createElement("img");
                        img.setAttribute("id", "book_img");
                        img.src = "./assets/uploads/product_img/" + resp[i]["img_url"];

<?php if (isset($_SESSION["user"])) { ?>

                            var like = document.createElement("button");
                            like.innerHTML = "Like!";
                            like.setAttribute("class", "like");
                            like.setAttribute("id", "like");
                            like.value = resp[i]["name"];
                            like.addEventListener("click", function () {
                                likeProduct(this.value);
                            });

                            var dislike = document.createElement("button");
                            dislike.innerHTML = "Dislike!";
                            dislike.setAttribute("id", "dislike");
                            dislike.value = resp[i]["id"];
                            dislike.addEventListener("click", function () {
                                dislikeProduct(this.value);
                            });

<?php } ?>
                        var author = document.createElement("td");
                        author.innerHTML = resp[i]["author_id"];

                        var category = document.createElement("td");
                        category.innerHTML = resp[i]["category_id"];

<?php if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] == 1) { ?>

                            var redact = document.createElement("td");

                            var f = document.createElement("form");
                            f.setAttribute('method', "GET");
                            f.setAttribute('action', "./controller/productsController.php");

                            var hid = document.createElement("input"); //input element, text
                            hid.setAttribute('type', "hidden");
                            hid.setAttribute('name', "book_name");
                            hid.value = resp[i]["name"];

                            var sub = document.createElement("input"); //input element, text
                            sub.setAttribute('type', "submit");
                            sub.setAttribute('name', "redact");
                            sub.setAttribute("class", "btn info");
                            sub.value = "Redact";

                            f.appendChild(hid);
                            f.appendChild(sub);
                            redact.appendChild(f);
<?php } if (isset($_SESSION["user"])) { ?>

                            var tocart = document.createElement("td");

                            var btn = document.createElement("button");
                            btn.innerHTML = "Add to cart";
                            btn.setAttribute("class", "btn info");
                            btn.setAttribute("id", "buy");
                            btn.value = resp[i]["name"];
                            btn.addEventListener("click", function () {
                                addToCart(this.value);
                            }, true);

                            tocart.appendChild(btn);
<?php } ?>
                        tr.appendChild(name);
                        tr.appendChild(author);
                        tr.appendChild(price);
                        tr.appendChild(quantity);
                        tr.appendChild(category);
                        tr.appendChild(img);
                        tr.appendChild(like);
                        tr.appendChild(dislike);
                        tr.appendChild(redact);
                        tr.appendChild(tocart);
                        table.appendChild(tr);
                    }

                }
            }
        };

        request.send();
    }

    function createLinks(articles) {
        var request = new XMLHttpRequest();
        request.open("GET", "./controller/countProductsController.php?pages=1", true);
        request.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var countProducts = this.responseText;

                var pages = Math.ceil(countProducts / articles);
                var linksDiv = document.getElementById("links");

                for (var j = 0; j < pages; j++) {
                    var link = document.createElement("button");
                    link.setAttribute("id", "page_number");
                    link.value = j + 1;
                    link.innerHTML = j + 1;
                    link.addEventListener("click", function (e) {
                        getCatalog(this.value, articles);
                    });

                    linksDiv.appendChild(link);
                }
            }
        };

        request.send();
    }

    function addToCart(name) {
        var request = new XMLHttpRequest;
        request.open("GET", "./controller/bucketController.php?buy_product=" + name);
        request.onreadystatechange = function (ev) {
            if (this.readyState === 4 && this.status === 200) {
                var response = JSON.parse(this.responseText);

                var q = document.getElementById(response["name"]);
                q.innerHTML = response["quantity"];

                if (response["quantity"] < 1) {
                    location.reload();

                } else {
                    var modal = document.getElementById("mod");
                    modal.style.display = "block";
                    modal.innerHTML = "";
                    var resp = "You add " + name + " in your bucket!";
                    modalWindow(modal, resp);
                }

            }
        };
        request.send();
    }

    function dislikeProduct(dislike_id) {

        var getId = document.getElementById("catalog");
        var res = document.createElement("h3");
        res.setAttribute("id", "signup-response");

        var userId = "<?= $_SESSION["user"]["id"] ?>";
        var request = new XMLHttpRequest();
        request.open("GET", "./controller/likesController.php?user_id="
                + userId + "&disliked_product=" + dislike_id, true);
        request.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var resp = JSON.parse(this.responseText);

                res.innerHTML = resp;
                getId.appendChild(res);
                fade(getId);
                unfade(getId);
            }
        };
        request.send();
    }

    function likeProduct(like_name) {
        var getId = document.getElementById("catalog");

        var res = document.createElement("h3");
        res.setAttribute("id", "signup-response");

        var req = new XMLHttpRequest();
        req.open("POST", "./controller/productsController.php", true);
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var result = JSON.parse(this.responseText);

                res.innerHTML = result[0];
                getId.appendChild(res);
                fade(getId);
                unfade(getId);
            }
        };
        req.send("like_for=" + like_name);
    }

</script>
