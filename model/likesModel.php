<?php

if ($_SESSION["user"]["type"] != 1) {
    header("Location: index.php");
}
require_once __DIR__ . "/load_data.php";

function getMoostLiked($pod) {
    try {
        $query = "SELECT COUNT(id) as likes, b.name, b.price, b.quantity, img_url as img FROM likes as l
              JOIN books as b
              ON b.id = l.b_id
              GROUP BY b.id
              order by likes desc
              limit 6";
        $stmt = $pod->prepare($query);

        $stmt->execute();
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result [] = $row;
        }
        return $result;
    } catch (PDOException $exp) {
        return "No book's liked yet!" . $exp->getMessage();
    }
}
