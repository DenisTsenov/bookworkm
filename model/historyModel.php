<?php

if (!$_SESSION["user"]) {
    header("Location: index.php");
}
require_once __DIR__ . "/load_data.php";

function getUserHistory($pdo, $userId) {
    try{
        $query = "SELECT b.name, b.price, br.date, br.quantity, a.name as author FROM
              books as b
              JOIN books_in_order AS br
              ON b.id = br.bought_book_id 
              JOIN  authors AS a
              ON a.id = b.author_id
              JOIN users AS u
              ON u.id = br.user_id
              AND u.id = ?";
    
        $stmt = $pdo->prepare($query);
        $param = [$userId];
        $stmt->execute($param);
        $result = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $result[] = $row;
        }
        return  $result;
    }catch(PDOException $exp){
        return  "Opps erro! " . $exp->getMessage();
    }
}
