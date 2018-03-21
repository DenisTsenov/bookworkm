<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!$_SESSION["user"]) {
    header("Location: index.php");
}
?>
<div>
    <form action="" method="" role="from">
            Book Name<input type="text" name="redact_name" value="<?= $_SESSION["redact"]["name"]; ?>"><br>
            Price<input type="number" name="redact_price" value="<?= $_SESSION["redact"]["price"]; ?>"><br>
            Quantity<input type="number" name="redact_quantity" value="<?= $_SESSION["redact"]["quantity"]; ?>"><br>
            Picture<input type="file" name="redact-product-pic"><br>
            <input type="submit" value="Redact product" name="redact-product">
    </form>
</div>