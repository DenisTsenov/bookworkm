<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!$_SESSION["user"]) {
    header("Location: index.php");
}

require_once '../model/productsModel.php';

if (isset($_GET["redact"])) {
    $productName = trim(htmlentities($_GET["book_name"]));

    if (!empty($productName) && mb_strlen($productName) > 2) {

        try {
            $result = getProductInfo($pdo, $productName);
//            echo json_encode($result, JSON_FORCE_OBJECT);
            $_SESSION['redact'] = $result;

            header("Location: ../index.php?page=redactProductView");
            
        } catch (Exception $exp) {
            echo "Something  went  worng. " . $exp->getMessage();
        }
    } else {
        //TODO
        //display  error view
    }
} 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $productName = trim(htmlentities($_POST["name"]));
    $productPrice = trim(htmlentities($_POST["price"]));
    $productQuantity = trim(htmlentities($_POST["quantity"]));

    $errArr = [];
    
    if (empty($productName) || mb_strlen($productName) < 2) {
        $errArr[] = "Min  length  for  name  is  2 chars.";
    }

    if (empty($productPrice) || !is_numeric($productPrice) || $productPrice < 2.99) {
        $errArr[] = "Min  price  2.99$";
    }

    if (empty($productQuantity) || !is_numeric($productQuantity) || $productQuantity < 1) {
        $errArr[] = "Min  quantity is 1(one)";
    }

    if (empty($productName) || mb_strlen($productName) < 2) {
        $errArr[] = "Min  length  for  name  is  2 chars.";
    }

    try {
        $result = updateBook($pdo, $productName, $productPrice, $productQuantity, $_SESSION["redact"]["old"]);
        if ($result) {
            $_SESSION["redact"]["name"] = $result["name"];
            $_SESSION["redact"]["price"] = $result["price"];
            $_SESSION["redact"]["quantiy"] = $result["quantity"];
            echo json_encode($result);
        }else{
            
        }
    } catch (PDOException $exp) {
        echo "something went  wrong! " . $exp->getMessage();
    }
}