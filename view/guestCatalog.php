<?php
if (isset($_SESSION["user"])) {
    header("Location: index.php");
}
?>
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
                console.log(resp);
                var table = document.getElementById("product");

                table.innerHTML = "";
                for (i in resp) {
                    var tr = document.createElement("tr");

                    var name = document.createElement("td");
                    name.innerHTML = resp[i]["name"];

                    var price = document.createElement("td");
                    price.innerHTML = resp[i]["price"];

                    var quantity = document.createElement("td");
                    quantity.innerHTML = resp[i]["quantity"];

                    var img = document.createElement("img");
                    img.setAttribute("id", "book_img");
                    img.src = "./assets/uploads/product_img/" + resp[i]["img_url"];

                    var author = document.createElement("td");
                    author.innerHTML = resp[i]["author_id"];

                    var category = document.createElement("td");
                    category.innerHTML = resp[i]["category_id"];

                    tr.appendChild(name);
                    tr.appendChild(author);
                    tr.appendChild(price);
                    tr.appendChild(quantity);
                    tr.appendChild(category);
                    tr.appendChild(img);

                    table.appendChild(tr);
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

</script>
