<?php

require_once dirname(__DIR__).'/config/db.php';

$pdo = null;
try{
    $pdo = new PDO("mysql:host=" . DB_HOST . ":" . DB_PORT . ";dbname=" . DB_NAME, USER, PASS,
        [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'']);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exp){
    echo "Something  went wrong " . $exp->getMessage();
}

include_once 'C:\xampp\htdocs\storm\untitled\Bookworms\model\searchModel.php';

if(isset($_POST["author"])){
    $id = null;
    $products = array();
    $author = $_POST["author"];
    getAuthor($pdo, $author, $id);
    getBooksByAuthor($pdo, $id, $products);
    header("Location: ../index.php?page=catalogue");
}
