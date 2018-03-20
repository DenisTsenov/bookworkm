<?php 
require_once '../model/productsModel.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $productName = trim(htmlentities($_GET["productName"]));
    
    if (!empty($productName) && mb_strlen($productName) > 2) {
        
        try {
            $result = getProductInfo($pdo, $productName);
            echo json_encode($result, JSON_FORCE_OBJECT);

        } catch (Exception $exp) {
            echo "Something  went  worng. " . $exp->getMessage();
        }
        
    }else{
        //TODO
        //display  error view
    }
}