<?php

require_once __DIR__ . "/load_data.php";

function minusQuantity($pdo, $bookName) {

    try {
        $bookCelan = trim(htmlentities($bookName));
        $query = "UPDATE books SET quantity = quantity - 1 WHERE name = ?;";
        $statement = $pdo->prepare($query);
        $params = [$bookCelan];
        if ($statement->execute($params)) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $exp) {
        return "Something  went wrong " . $exp->getMessage();
    }
}

function plusOneQuantity($pdo, $bookName) {
    try {
        $bookClean = trim(htmlentities($bookName));
        $query = "UPDATE books SET quantity = quantity + 1 WHERE name = ?;";
        $statement = $pdo->prepare($query);
        $params = [$bookClean];
        $statement->execute($params);
    } catch (PDOException $exp) {
        return "Something  went wrong " . $exp->getMessage();
    }
}

function plusQuantity($pdo, $qunatity, $bookName) {
    try {
        $bookNameClean = trim(htmlentities($bookName));
        $qunatityClean = trim(htmlentities($qunatity));
        $query = "UPDATE books SET quantity = quantity + ? WHERE name = ?;";
        $statement = $pdo->prepare($query);
        $params = [$qunatityClean, $bookNameClean];
        $statement->execute($params);
    } catch (PDOException $exp) {
        return "Something  went wrong " . $exp->getMessage();
    }
}

function getProductInfo($pdo, $bookName) {
    try {

        $query = "SELECT name, price, quantity, img_url FROM  books WHERE name = ?;";
        $statement = $pdo->prepare($query);
        $params = [$bookName];
        $statement->execute($params);
        $product = $statement->fetch(PDO::FETCH_ASSOC);
        return $product;
    } catch (PDOException $exp) {
        return "Something  went wrong. " . $exp->getMessage();
    }
}

function updateBook($pdo, $name, $price, $quantity, $oldName) {
    try {
        $query = "UPDATE books SET name = ?, price= ? , quantity = ? WHERE name = ?;";
        $statement = $pdo->prepare($query);
        $params = [$name, $price, $quantity, $oldName];
        
        if ($statement->execute($params)) {
            return getProductInfo($pdo, $name);
        }else{
            return  FALSE;
        }
        
        
    } catch (PDOException $exp) {
        return "Something  went wrong. " . $exp->getMessage();
    }
}
