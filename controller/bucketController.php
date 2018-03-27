<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!$_SESSION["user"]) {
    header("Location: index.php");
}
require_once '../model/productsModel.php';
if (isset($_GET["buy_product"])) {
    $productToBuy = trim(htmlentities($_GET["buy_product"]));
    $noProductError = "No such  a product!";
    $success = false;

    foreach ($products as &$product) {
        if ($product["name"] === $productToBuy) {
            $price = $product["price"];

            try {
                $result = minusQuantity($pdo, $product["name"]);
            } catch (PDOException $exp) {
                $exp->getMessage();
            }
//            $product["quantity"] --;
//            $encod = json_encode($products);
//            file_put_contents("./assets/data/books.json", $encod);

            $success = true;
            break;
        }
    }

    if ($success) {

        $bucket = $_SESSION["bucket"];
        if (isset($bucket[$productToBuy])) {
            $bucket[$productToBuy]["quantity"] ++;
        } else {
            $bucket[$productToBuy] = ["name" => $productToBuy, "price" => $price, "quantity" => 1];
        }
        $_SESSION["bucket"] = $bucket;
        $success = "You added " . $_SESSION["bucket"][$productToBuy]["name"] . " in  your bucket!";
//        echo $success;
    } else {
        echo $noProductError;
    }
}



if (isset($_GET["book_to_remove"])) {
    //premahwame kolichestwoto  ot producta  i go wrushtame obratno  w kataloga
    $productToRemove = trim(htmlentities($_GET["book_to_remove"]));
    if (isset($_SESSION["bucket"][$productToRemove])) {
        //dostupwame  produkta w sessiqta po referenciq
        $removeQuantity = &$_SESSION["bucket"][$productToRemove];
        foreach ($products as &$product) {
            if ($removeQuantity["name"] == $product["name"]) {
                //fakticheskoto wrushtane na kolichestwoto  w kataloga
//                $product['quantity'] += $removeQuantity["quantity"];
                $result = plusQuantity($pdo, $removeQuantity["quantity"], $removeQuantity["name"]);

                if (!$result) {
                    echo $result;
                }

                //zapiswame books.json sus nowoto(staro) kolichestwo
//                $encod = json_encode($products);
//                file_put_contents("./assets/data/books.json", $encod);
                break;
            }
        }

        unset($_SESSION["bucket"][$productToRemove]);
    }
}

if (isset($_GET["book"])) {

    $productToRev = trim(htmlentities($_GET["book"]));
    if (isset($_SESSION["bucket"][$productToRev])) {
        $bookName = &$_SESSION["bucket"][$productToRev];
        foreach ($products as &$product) {
            if ($bookName["name"] == $product["name"]) {

                plusOneQuantity($pdo, $product["name"]);
//                $product['quantity'] ++;
//                $encod = json_encode($products);
//                file_put_contents("./assets/data/books.json", $encod);
                break;
            }
        }
        if ($bookName['quantity'] > 1) {
            $bookName['quantity'] --;
        } else {
            unset($_SESSION["bucket"][$productToRev]);
        }
    }
}



