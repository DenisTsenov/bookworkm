<?php

function minusQuantity($pdo, $bookName) {
    try {
        $bookCelan = trim(htmlentities($bookName));
        $query = "UPDATE books SET quantity = quantity - 1 WHERE name = ?;";
        $statement = $pdo->prepare($query);
        $params = [$bookCelan];
        $statement->execute($params);
        
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

function plusQuantity($pdo, $qunatity, $bookName ) {
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
