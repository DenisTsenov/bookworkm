<?php

require_once '../model/catalogModel.php';

if (isset($_GET['pages'])) {

    try {
        echo getProductsCount($pdo);
    } catch (PDOException $exp) {
        $errFile = fopen("../errlog/PDOExeption.txt", "a+");
        if (is_writable($errFile)) {
            fwrite($errFile, $exp->getMessage() . '. Date -->> ' . date('l jS \of F Y h:i:s A'));
            fclose($errFile);
        } else {
            fclose($errFile);
        }
        header("Location: ../index.php?page=errpage");
    }
}

