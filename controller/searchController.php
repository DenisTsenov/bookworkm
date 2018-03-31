<?php


require_once dirname(__DIR__).'/config/db.php';
include_once dirname(__DIR__). DIRECTORY_SEPARATOR. "model" . DIRECTORY_SEPARATOR ."searchModel.php";


if(isset($_POST["author"])){
    $id = null;
    $searchedProducts = array();
    $author = $_POST["findAuthor"];
    getAuthor($pdo, $author, $id);
    getBooksByAuthor($pdo, $id);
    header("Location: ../index.php?page=searched");
}
if(isset($_POST["category"])){
    $id = null;
    $searchedProducts = array();
    $category = $_POST["findCategory"];
    getCategory($pdo, $category, $id);
    getBooksByCategory($pdo, $id);
    header("Location: ../index.php?page=searched");
}