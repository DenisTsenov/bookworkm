<?php


require_once dirname(__DIR__).'/config/db.php';

include_once dirname(__DIR__). DIRECTORY_SEPARATOR. "model" . DIRECTORY_SEPARATOR ."searchModel.php";


if(isset($_POST["author"])){
    $id = null;
    $products = array();
    $author = $_POST["author"];
    getAuthor($pdo, $author, $id);
    getBooksByAuthor($pdo, $id, $searchedProducts);
    header("Location: ../index.php?page=catalogue");
}
