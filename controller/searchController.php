<?php
include_once dirname(__DIR__). DIRECTORY_SEPARATOR. "model" . DIRECTORY_SEPARATOR ."searchModel.php";

if(isset($_POST["author"])){
    $id = null;
    $products = array();
    $author = $_POST["author"];
    getAuthor($pdo, $author, $id);
    getBooksByAuthor($pdo, $id, $products);
    include_once "../view/catalogue.php";
}
