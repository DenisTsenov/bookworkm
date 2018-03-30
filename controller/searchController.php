<?php
include_once 'C:\xampp\htdocs\storm\untitled\Bookworms\model\searchModel.php';

if(isset($_POST["author"])){
    $id = null;
    $products = array();
    $author = $_POST["author"];
    getAuthor($pdo, $author, $id);
    getBooksByAuthor($pdo, $id, $products);
    include_once "../view/catalogue.php";
}
