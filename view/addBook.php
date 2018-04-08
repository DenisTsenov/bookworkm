<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION["user"]["type"] != 1) {
    header("Location: index.php");
}
?>
<?=
isset($_SESSION["success"]) ? "<h3>Succsessfully adde  new  book!</h3>" : "";
unset($_SESSION["success"])
?>

<div id="addBook" >
    <form name="myForm" action="./controller/productsController.php" method="POST"
          onsubmit="return validateBook()" enctype="multipart/form-data">
        <label for="name">Book Name</label>
        <input type="text" id="name" name="new_name" placeholder="Book name..">

        <label for="author">Author</label>
        <select id="author" name="new_author">

        </select>
        <hr/>
        <label for="price">Price</label>
        <input type="number" step=".01" id="price" name="new_price" >
        <hr/>
        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="new_quantity" >
        <hr/>
        <label for="category">Category</label>
        <select id="category" name="new_category">

        </select>
        <hr/>
        <label for="img">Image</label>
        <input type="file" name="new_img" multiple accept='image/*' id="img">
        <br/>

        <button type="submit" class="smal_blue" name="insertBook">
            <input class="btn blue" type="submit" value="Add Book" name="insertBook">
        </button>
    </form>
    <div id="errorContent" ></div>
</div>

<script type="text/javascript">
    function takeAuthors() {
        
        var request = new XMLHttpRequest;
        request.open("GET", "./controller/authorsController.php", true);
        request.onreadystatechange = function (ev) {
            if (this.readyState === 4 && this.status) {
                var select = document.getElementById("author");
                var resp = JSON.parse(this.responseText);

                for (j in resp) {
                    var option = document.createElement("option");
                    option.setAttribute("value", resp[j]["id"]);
                    option.innerHTML = resp[j]["name"];
                    select.appendChild(option);
                }
            }
        };
        request.send();
    }
    takeAuthors();
     takeGenres();
     function takeGenres() {
    var request = new XMLHttpRequest;
    request.open("GET", "./controller/genresController.php", true);
    request.onreadystatechange = function (ev) {
        if (this.readyState === 4 && this.status) {
            var select = document.getElementById("category");
            var resp = JSON.parse(this.responseText);

            for (i in resp) {
                var option = document.createElement("option");
                option.setAttribute("value", resp[i]["id"]);
                option.innerHTML = resp[i]["name"];
                select.appendChild(option);
            }
        }
    };
    request.send();
}

//      function addBook() {
//        var name = document.getElementById("name").value;
//        var author = document.getElementById("author").value;
//        var price = document.getElementById("price").value;
//        var quantity = document.getElementById("quantity").value;
//        var genre = document.getElementById("category").value;
//        var fileInput = document.getElementById("img");
////        var img = document.getElementById("img").files[0];
//
//        var formData = new FormData();
//        formData.append("img",document.getElementById("img").files[0]);
//
//        var request = new XMLHttpRequest;
//        request.open("POST", "./controller/productsController.php", true);
//        request.setRequestHeader("Content-Type", fileInput.files[0].type);
//        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//        request.onreadystatechange = function (ev) {
//            if (this.readyState === 4 && this.status) {
//                var resp = this.responseText;
//                alert(resp);
//            }
//        }
//
//        request.send("insertBook=" + name + "&author=" + author + "&price=" + price + "&quantity="
//                + quantity + "&genre=" + genre + "&img=" + formData);
//    }


</script>
