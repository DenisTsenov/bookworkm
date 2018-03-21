<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!$_SESSION["user"]) {
    header("Location: index.php");
}
?>
<div id="redact">
    <?php 
    if (isset( $_SESSION["redact"]["name"])) {
        $_SESSION["redact"]["old"] = $_SESSION["redact"]["name"];  
    }?>
    
    Book Name<input type="text" id="redact_name" name="redact_name" value="<?= isset($_SESSION["redact"]["name"]) ? $_SESSION["redact"]["name"]: "" ; ?>"><br>
    Price<input type="number" id="redact_price" name="redact_price" value="<?= $_SESSION["redact"]["price"]; ?>"><br>
    Quantity<input type="number" id="redact_quantity" name="redact_quantity" value="<?= $_SESSION["redact"]["quantity"]; ?>"><br>
    
    Picture <img id="book_img" src="./assets/uploads/product_img/<?= $_SESSION["redact"]["img_url"]; ?>" alt="book_img"/>
    <input type="file" id="redact_img" name="product_pic"><br>
    <button type="submit" value="<?= $_SESSION["redact"]["name"]; ?>" onclick="redactBook(this.value)" name="redact-product">Redact</button>
</div>
