<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../model/likesModel.php';

if (isset($_GET["liked"])) {
    try {
        $r = getMoostLiked($pdo);

        echo json_encode($r);
    } catch (PDOException $exp) {
        $errFile = fopen("../errlog/PDOExeotion.txt", "a+");
        if (is_writable($errFile)) {
            fwrite($errFile, $exp->getMessage() . '. Date -->> ' . date('l jS \of F Y h:i:s A'));
            fclose($errFile);
        } else {
            fclose($errFile);
        }
        header("Location: ../index.php?page=errpage.php");
    }
}

if (isset($_GET["disliked_product"]) && isset($_GET["user_id"])) {
    $productId = trim(htmlentities($_GET["disliked_product"]));
    $userId = trim(htmlentities($_GET["user_id"]));
    $likeErr = [];
    $dislikeSuccess = [];
    if (empty($productId) || $productId < 0) {
        $likeErr[] = "Invalid product!";
    }

    if (empty($userId) || $userId < 0) {
        $likeErr[] = "Invalid user!";
    }

    if ($likeErr) {
        echo json_encode($likeErr);
    } else {
        try {
            $result = dislikeProduct($pdo, $productId, $userId);
            if ($result) {
                $dislikeSuccess [] = "Your dislike is succsessfull!";
                echo json_encode($dislikeSuccess);
            } else {
                header("Location: ../index.php?page=errpage.php");
            }
        } catch (PDOException $exp) {
            $errFile = fopen("../errlog/PDOExeotion.txt", "a+");
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