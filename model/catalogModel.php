<?php

require_once __DIR__ . "/load_data.php";

function getCatalogProducts($pdo, $page, $articles) {
    try {

        $queryOffset = ($page - 1) * $articles;
        $query = "SELECT b.id, b.name , b.price, b.quantity, b.img_url,
            a.name AS author_id , c.name AS category_id  
            FROM books AS b
            JOIN authors AS a ON a.id = b.author_id
            JOIN categories AS c ON b.category_id = c.id ORDER BY b.name
            LIMIT :page OFFSET :qoffset ;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':page', $articles, PDO::PARAM_INT);
        $stmt->bindParam(':qoffset', $queryOffset, PDO::PARAM_INT);
        $stmt->execute();
        
        $productsArr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productsArr[] = $row;
            
        }
        return $productsArr;
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

function getProductsCount($pdo) {
    try{
        $query = "SELECT COUNT(id) as cnt FROM books";
    
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result["cnt"];
    } catch (PDOException $exp){
        return $exp->getMessage();
    }
}
