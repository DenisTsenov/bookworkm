<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION["user"]["type"] != 1) {
    header("Location: index.php");
}
?>

<div id="redact">
    <?php
    if (isset($_SESSION["redact"]["name"])) {
        $_SESSION["redact"]["old"] = $_SESSION["redact"]["name"];
    }
    ?>

    Book Name<input type="text" id="redact_name" name="redact_name" value="<?= isset($_SESSION["redact"]["name"]) ? $_SESSION["redact"]["name"] : ""; ?>"><br>
    Price<input type="number" id="redact_price" name="redact_price" value="<?= $_SESSION["redact"]["price"]; ?>"><br>
    Quantity<input type="number" id="redact_quantity" name="redact_quantity" value="<?= $_SESSION["redact"]["quantity"]; ?>"><br>

<!--    Picture <img id="book_img" src="./assets/uploads/product_img/<?= $_SESSION["redact"]["img_url"]; ?>" alt="book_img"/><br/>
<input type="file" id="redact_img" name="product_pic"><br>-->
    <button type="submit" value="<?= $_SESSION["redact"]["name"]; ?>" onclick="redactBook(this.value)" name="redact-product">Redact</button>
    <a href="index.php?page=addBook"><button type="submit" class="blue" name="newBook">Add  New Book!</button></a>
    <ul id="errs"></ul>
</div>

<script type="text/javascript">
    function  redactBook(bookToRedact) {

        var name = document.getElementById("redact_name").value;
        var price = document.getElementById("redact_price").value;
        var quantity = document.getElementById("redact_quantity").value;
//    var img = document.getElementById("redact_img");

        var div = document.getElementById("redact");
        
        var request = new XMLHttpRequest;
        request.open("POST", "./controller/productsController.php", true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.onreadystatechange = function (ev) {
            if (this.readyState === 4 && this.status === 200) {
//            location.reload();

                var response = JSON.parse(this.responseText);
//            alert(response);
//                console.log(response);

                var h4 = document.getElementById("errs");
                h4.innerHTML = "";
                h4.setAttribute("class", "err");
                for (var i in response) {
                    var li = document.createElement("li");
                    li.innerHTML = response[i];  
                    h4.appendChild(li);
                    
                    
                }
                div.appendChild(h4);
//                setTimeout(function(){h4.style.visibility = "none";}, 200);
                
                name.value = response.name;
                name.price = response.price;
                name.quantity = response.quantity;
                

            }

        };

        request.send("redact_name=" + name + "&redact_price=" + price + "&redact_quantity=" + quantity);

    }


    function fadeOut() {
//        document.addEventListener('click', function (e) {
            if (e.target && e.target.id === 'fade') {
                var fadeTarget = document.getElementById("fade");
                var fadeEffect = setInterval(function () {
                    if (!fadeTarget.style.opacity) {
                        fadeTarget.style.opacity = 1;
                    }
                    if (fadeTarget.style.opacity < 0.1) {
                        clearInterval(fadeEffect);
                    } else {
                        fadeTarget.style.opacity -= 0.1;
                    }
                }, 100);
            }
//        });
    }
</script>