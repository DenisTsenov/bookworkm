<?php
/*
 * this function put  back  the  quantity  from
 * $_SESSION to catalogue if user is not active  for 1 hour!
 */
function removeProduct($pdo, $productsArr, $productsInCatalogue) {
//    $cnt = count($productsArr);
    foreach ($productsArr as $name => $value) {

        if (isset($productsArr[$name]["quantity"])) {
            //dostupwame  produkta w sessiqta po referenciq
            $removeQuantity = &$productsArr[$name];
            foreach ($productsInCatalogue as &$product) {
//                var_dump($productsArr);
                if ($removeQuantity["name"] == $product["name"]) {
                    require_once './model/productsModel.php';
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
                }else{
                }
            }
            unset($_SESSION["bucket"][$name]);
        }
    }
}

