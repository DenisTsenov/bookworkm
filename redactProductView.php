<div>
    <form action="" method="" role="from">
        Book Name<input type="text" name="redact_name" value="<?= $_POST["product_name"]; ?>"><br>
        Price<input type="number" name="redact_price" value="<?= $_POST["product_price"]; ?>"><br>
        Quantity<input type="number" name="redact_quantity" value="<?= $_POST["product_quantity"]; ?>"><br>
        Picture<input type="file" name="redact-product-pic"><br>
        <input type="submit" value="Redact product" name="redact-product">

    </form>
</div>