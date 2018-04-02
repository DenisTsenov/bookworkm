<?php

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
            if ($row["quantity"] > 0) {
                $result [] = $row;
            }
        }
        return $result;
    } catch (PDOException $exp) {
        return "No book's liked yet!" . $exp->getMessage();
    }
}

function dislikeProduct($pdo, $dislikeId, $userId) {
    try {
        $pdo->beginTransaction();
        $query = "DELETE FROM likes WHERE b_id = ? AND user_id = ? ;";
        $stmt = $pdo->prepare($query);
        $params = [$dislikeId, $userId];
        
        if ($stmt->execute($params)) {
            $pdo->commit();
            return true;
        }else{
            $pdo->rollBack();
            return  false;
        }
    } catch (PDOException $exp) {
        $pdo->rollBack();
        return "Oops, something  went  wrong! " . $exp->getMessage();
    }
}
