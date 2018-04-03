<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!$_SESSION["user"]) {
    header("Location: index.php");
}

require_once '../model/productsModel.php';

/*
 * vrushta nujnata informaciqta  za 
 * knigata koqto  shte redaktirame
 */
if (isset($_GET["redact"])) {
    $productName = trim(htmlentities($_GET["book_name"]));

    if (!empty($productName) && mb_strlen($productName) > 2) {

        try {
            $result = getProductInfo($pdo, $productName);
//            echo json_encode($result, JSON_FORCE_OBJECT);
            $_SESSION['redact'] = $result;

            header("Location: ../index.php?page=redactProductView");
        } catch (PDOException $exp) {
            $errFile = fopen("../errlog/PDOExeption.txt", "a+");
            if (is_writable($errFile)) {
                fwrite($errFile, $exp->getMessage() . '. Date -->> ' . date('l jS \of F Y h:i:s A'));
                fclose($errFile);
            } else {
                fclose($errFile);
            }
            header("Location: ../index.php?page=errpage.php");
        }
    } else {
        header("Location: ../index.php?page=errpage.php");
    }
}
/*
 * redact books in table
 */
if (isset($_POST["redact_name"])) {

    $productName = trim(htmlentities($_POST["redact_name"]));
    $productPrice = trim(htmlentities($_POST["redact_price"]));
    $productQuantity = trim(htmlentities($_POST["redact_quantity"]));
    $responseArr = [];

    if (empty($productName) || mb_strlen($productName) < 2) {
        $responseArr["min_len"] = "Min  length  for  name  is  2 chars.";
    }

    if (empty($productPrice) || !is_numeric($productPrice) || $productPrice < 2.99) {
        $responseArr["min_price"] = "Min  price  2.99$";
    }

    if (empty($productQuantity) || !is_numeric($productQuantity) || $productQuantity < 1) {
        $responseArr["min_quantity"] = "Min  quantity is 1(one)";
    }

    if ($responseArr) {

        echo json_encode($responseArr);
    } else {
        try {

            if (updateBook($pdo, $productName, $productPrice, $productQuantity, $_SESSION["redact"]["old"])) {
                $_SESSION["redact"]["name"] = $productName;
                $_SESSION["redact"]["price"] = $productPrice;
                $_SESSION["redact"]["quantity"] = $productQuantity;
                $_SESSION["redact"]["success"] = true;
                $responseArr[] = "You succsessfully redact " . $_SESSION["redact"]["old"];
                echo json_encode($responseArr);
            } else {
                $responseArr[] = "Sorry... something went  wrong  with your query! Try again  later!";
                echo json_encode($responseArr);
            }
        } catch (PDOException $exp) {
            $errFile = fopen("../errlog/PDOExeption.txt", "a+");
            if (is_writable($errFile)) {
                fwrite($errFile, $exp->getMessage() . '. Date -->> ' . date('l jS \of F Y h:i:s A'));
                fclose($errFile);
            } else {
                fclose($errFile);
            }
            header("Location: ../index.php?page=errpage.php");
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
    $orig_name = basename($_FILES['new_img']['name']);
    $imageFileType = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));
    $imgSize = $_FILES['new_img']['size'];
    if ($imgSize > 1000000) {
        $insertErr[] = "Max size is 100 KB!<br>";
    }

    if ($imageFileType != "jpg" && $imageFileType != "ico" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $insertErr[] = "Sorry, only JPG, JPEG, ICO, PNG & GIF files are allowed.<br>";
    }

    if (is_uploaded_file($tmp_name)) {

        $logo_url = "../assets/uploads/product_img/$name.$imageFileType";
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

            try {

                if (insertBook($pdo, $name, $author, $price, $quantity, $genre, $name . "." . $imageFileType)) {
                    $_SESSION["success"] = true;
                    header("Location: ../index.php?page=addBook");
                } else {
                    header("Location: ../index.php?page=errpage.php");
                }
            } catch (PDOException $exp) {
                $errFile = fopen("../errlog/PDOExeption.txt", "a+");
                if (is_writable($errFile)) {
                    fwrite($errFile, $exp->getMessage() . '. Date -->> ' . date('l jS \of F Y h:i:s A'));
                    fclose($errFile);
                } else {
                    fclose($errFile);
                }
                header("Location: ../index.php?page=errpage.php");
            }
        }
    }
}

/*
 * suzdawa now zapis w  bazata
 * sus id-to  na  haresanata  kniga
 */
if (isset($_POST["like_for"])) {

    /* @var $likedProduct
     *  type string 
     */
    $likedProduct = trim(htmlentities($_POST["like_for"]));
    $resultArr = [];
    if (!empty($likedProduct) && mb_strlen($likedProduct) > 2) {

        try {

            if (!ifIsLiked($pdo, $_SESSION["user"]["id"], $likedProduct)) {
                if (likeProduct($pdo, $_SESSION["user"]["id"], $likedProduct)) {
                    $resultArr[] = "You liked $likedProduct!";
                    echo json_encode($resultArr);
                } else {
                    $resultArr[] = "Something  went wrong with $likedProduct!";
                    echo json_encode($resultArr);
                }
            } else {
                $resultArr[] = "You  allready like this book!";
                echo json_encode($resultArr);
            }
        } catch (PDOException $exp) {
            $errFile = fopen("../errlog/PDOExeption.txt", "a+");
            if (is_writable($errFile)) {
                fwrite($errFile, $exp->getMessage() . '. Date -->> ' . date('l jS \of F Y h:i:s A'));
                fclose($errFile);
            } else {
                fclose($errFile);
            }
            header("Location: ../index.php?page=errpage.php");
        }
    } else {
        $resultArr[] = "Invaid book!";
        echo json_encode($resultArr);
    }
}

/*
 *  vrushta  masiwa  s knigi koito  
 *  potrebitelq e haresal
 */
if (isset($_GET["user_id"])) {
    $userId = trim(htmlentities($_GET["user_id"]));

    if (!is_numeric($userId) || $userId < 0) {
        $resultArr = [];
        $resultArr[] = "Invaid user!!";
        echo json_encode($resultArr);
    } else {
        try {
            $r = getLikedProducts($pdo, $userId);

            if (!empty($r)) {
                echo json_encode($r);
            } else {
                return false;
            }
        } catch (PDOException $exp) {
            $errFile = fopen("../errlog/PDOExeption.txt", "a+");
            if (is_writable($errFile)) {
                fwrite($errFile, $exp->getMessage() . '. Date -->> ' . date('l jS \of F Y h:i:s A'));
                fclose($errFile);
            } else {
                fclose($errFile);
            }
            header("Location: ../index.php?page=errpage.php");
        }
    }
}

if (isset($_GET["search"])) {
    $criteria = $_GET["search"];
    $result = array();
    $counter = 0;
    $result = searchDB($pdo, $criteria);

    echo json_encode($result);
}
