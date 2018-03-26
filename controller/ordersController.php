<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!$_SESSION["user"]) {
    header("Location: index.php");
}
require_once '../model/productsModel.php';
require_once '../model/ordersModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    unset($_POST["info"][0]);
    $bucketInfo = $_POST["info"];
//    var_dump($bucketInfo);
    /*
     * $row[0] = name
     * $row[1] = price
     * $row[2] = quantity
     */
    foreach ($bucketInfo as $row) {
        $productId = getProductId($pdo, $row[0]);

        $result = purchaseHistory($pdo, $_SESSION["user"]["id"],$productId[0]["id"], $row[2]);
        if ($result) {
            unset($_SESSION["bucket"]);
            $_SESSION["pruchase"] = true;
        }
//       echo '<pre>'. print_r($productId[0]["id"], true) .'</pre>';
       
    }
}

