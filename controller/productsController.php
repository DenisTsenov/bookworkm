<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!$_SESSION["user"]) {
    header("Location: index.php");
}

require_once '../model/productsModel.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $productName = trim(htmlentities($_GET["productName"]));

    if (!empty($productName) && mb_strlen($productName) > 2) {

        try {
            $result = getProductInfo($pdo, $productName);
//            echo json_encode($result, JSON_FORCE_OBJECT);
            $_SESSION['redact'] = $result;

            header("Location: " . "http://localhost/bookworkm/view/redactProductView.php");
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
//    $img = basename($_FILES['product_pic']['name']);
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

//    $imageFileType = strtolower(pathinfo($img, PATHINFO_EXTENSION));
//
//    $imgSize = $_FILES['product_pic']['size'];
//    if ($imgSize > 1000000) {
//        echo "Max size is 100 KB!<br>";
//    }
//    $f = false;
//    if ($imageFileType != "jpg" && $imageFileType != "ico" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
//        echo "Sorry, only JPG, JPEG, ICO, PNG & GIF files are allowed.<br>";
//    }
//
//    if (!file_exists($img)) {
//        if (is_uploaded_file($_FILES['product_pic']['tmp_name'])) {
//            $path = "../assets/uploads/product_img/" . $productName . $imageFileType;
//            if (move_uploaded_file($_FILES['product_pic']['tmp_name'], $path)) {
//                $f = true;
//            } else {
//                echo "Sorry, something  went  wrong! Try  again  later<br>";
//            }
//        } else {
//            echo "File is  not uploaded!<br>";
//        }
//    } else {
//        echo "Sorry, the  file  allready exist!<br>";
//    }

    try {
        $result = updateBook($pdo, $productName, $productPrice, $productQuantity, $_SESSION["redact"]["old"]);
        if ($result) {
            echo json_encode($result);
        }else{
            //TODO
            
        }
    } catch (PDOException $exp) {
        echo "something went  wrong! " . $exp->getMessage();
    }
}