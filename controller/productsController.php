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
/*
 * redact books in table
 */
if (isset($_POST["redact_name"])) {

    $productName = trim(htmlentities($_POST["redact_name"]));
    $productPrice = trim(htmlentities($_POST["redact_price"]));
    $productQuantity = trim(htmlentities($_POST["redact_quantity"]));

    $rsponseArr = [];

    if (empty($productName) || mb_strlen($productName) < 2) {
        $rsponseArr["min_len"] = "Min  length  for  name  is  2 chars.";
    }

    if (empty($productPrice) || !is_numeric($productPrice) || $productPrice < 2.99) {
        $rsponseArr["min_price"] = "Min  price  2.99$";
    }

    if (empty($productQuantity) || !is_numeric($productQuantity) || $productQuantity < 1) {
        $rsponseArr["min_quantity"] = "Min  quantity is 1(one)";
    }

    if ($rsponseArr) {

        echo json_encode($rsponseArr);
    } else {
        try {
            $result = updateBook($pdo, $productName, $productPrice, $productQuantity, $_SESSION["redact"]["old"]);
            if ($result) {
                $output = getProductInfo($pdo, $productName);
                $_SESSION["redact"]["name"] = $output["name"];
                $_SESSION["redact"]["price"] = $output["price"];
                $_SESSION["redact"]["quantity"] = $output["quantity"];
//            echo json_encode($output);
                $_SESSION["redact"]["success"] = true;
            } else {
                header("Location: ../imdex.php?page=updateError");
            }
        } catch (PDOException $exp) {
            echo "something went  wrong! " . $exp->getMessage();
        }
    }
}

/*
 * inser  new  book in  table
 */
if (isset($_POST["insertBook"])) {
    $name = trim(htmlentities($_POST["new_name"]));
    $author = trim(htmlentities($_POST["new_author"]));
    $price = trim(htmlentities($_POST["new_price"]));
    $quantity = trim(htmlentities($_POST["new_quantity"]));
    $genre = trim(htmlentities($_POST["new_category"]));
    
    $insertErr = [];

    if (empty($name) || mb_strlen($name) < 2) {
        $insertErr[] = "Name  min length is  2 chars!";
    }

    if ($author < 0) {
        $insertErr[] = "Invaid author name";
    }

    if (empty($price) || $price < 1.99) {
        $insertErr[] = "Min  price  is 1.99$!";
    }

    if (empty($quantity) || $quantity < 1) {
        $insertErr[] = "Minimum quantity is 1!";
    }

    if ($genre < 0) {
        $insertErr[] = "Invaid genre!";
    }
    $tmp_name = $_FILES["new_img"]["tmp_name"];
    $orig_name = $_FILES["new_img"]["name"];

    if (is_uploaded_file($tmp_name)) {
        $exploded_name = explode(".", $orig_name);
        $ext = $exploded_name[count($exploded_name) - 1];
        $logo_url = "../assets/uploads/product_img/$name.$ext";
        if (move_uploaded_file($tmp_name, $logo_url)) {
            
        } else {
            $error_reg[] = "File not moved successfully";
        }
    } else {
        $error_reg[] = "File not uploaded successfully";
    }

    if ($insertErr) {
        echo json_encode($insertErr);
    } else {
        require_once '../model/authorsModel.php';
        require_once '../model/genresModel.php';

        $authorResult = getAuthorName($pdo, $author);
        $genreResult = getGenreName($pdo, $genre);
        
        if (!$genreResult) {
            $insertErr[] = "Invalid  author!";

        }
        
        if (!$authorResult) {
            $insertErr[] = "Invalid  author!";

        }

        if ($insertErr) {
            echo json_encode($insertErr);
        } else {

            
            if (insertBook($pdo, $name, $author, $price, $quantity, $genre, $name . ".jpg")) {
                $_SESSION["success"] = true;
                header("Location: ../index.php?page=addBook");
            } else {
                //todo
                //return err msg or redirect
            }
        }
    }
}

if(isset($_POST["search"])){
    $category = trim(htmlentities($_POST["category"]));

}
