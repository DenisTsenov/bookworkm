<?php

if ($_SESSION["user"]["type"] != 1) {
    header("Location: index.php");
}
require_once __DIR__ . "/load_data.php";

function purchaseHistory($pdo, $userId, $productId, $quantity) {
    try {
        $pdo->beginTransaction();
        $query = "INSERT INTO books_in_order (user_id, bought_book_id, quantity) VALUES(?,?,?)";
        $stmt = $pdo->prepare($query);
        $params = [$userId, $productId, $quantity];

        if (!$stmt->execute($params)) {
            $pdo->rollBack();
            return;
        }else{
             $pdo->commit();
             return  true;
        }

//        $mydate = getdate(date("U"));
//        $queryUserOrd = "INSERT INTO user_orders (user_id, date) VALUES(?,?);";
//        $st = $pdo->prepare($queryUserOrd);
//        $param = [$userId, "$mydate[weekday], $mydate[month] $mydate[mday], $mydate[year]"];
//
//        if (!$st->execute($param)) {
//            $pdo->rollBack();
//            return;
//        } 
       

    } catch (PDOException $exp) {
        $pdo->rollBack();

        throw $exp;
    } catch (Exception $e) {
        return "Something  wenr wrong " . $e->getMessage();
    }
}
