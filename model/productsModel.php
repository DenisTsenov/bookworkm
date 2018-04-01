<?php

if (!$_SESSION["user"]) {
    header("Location: index.php");
}
require_once __DIR__ . "/load_data.php";

if (!$_SESSION["user"]) {
    header("Location: index.php");
}

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

function getProductId($pdo, $bookName) {
    try {

        $query = "SELECT id FROM  books WHERE name = ?;";
        $statement = $pdo->prepare($query);
        $params = [$bookName];
        $statement->execute($params);

        $product = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $product[] = $row;
        }
        return $product;
    } catch (PDOException $exp) {
        return "Something  went wrong. " . $exp->getMessage();
    }
}

/*
 * ne sum i  nameril prilojenie  wse oshte :)
 */

function getProductPrice($pdo, $bookName) {
    try {

        $query = "SELECT price FROM  books WHERE name = ?;";
        $statement = $pdo->prepare($query);
        $params = [$bookName];
        $statement->execute($params);
        $product = [];

        if ($statement->fetch(PDO::FETCH_ASSOC)) {
            $product[] = $statement->fetch(PDO::FETCH_ASSOC);
        }
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
            return true;
        } else {
            return false;
        }
    } catch (PDOException $exp) {
        return "Something  went wrong. " . $exp->getMessage();
    }
}

function insertBook($pdo, $name, $author, $price, $quantity, $genre, $img) {
    try {
        $query = "INSERT INTO books(name, author_id, price, quantity, category_id, img_url)
                VALUES(?,?,?,?,?,?)";
        $statement = $pdo->prepare($query);
        $params = [$name, $author, $price, $quantity, $genre, $img];

        if ($statement->execute($params)) {
            return true;
        }
    } catch (PDOException $exp) {
        return "Something  went wrong. " . $exp->getMessage();
    }
}

function likeProduct($pdo, $user, $productToLike) {

    try {
        $pdo->beginTransaction();
        $productId = getProductId($pdo, $productToLike);

        $query = "INSERT INTO likes(b_id, user_id) VALUES(?,?)";
        $stmt = $pdo->prepare($query);
        $params = [$productId[0]["id"], $user];
        if ($stmt->execute($params)) {

            $pdo->commit();
            return true;
        } else {
            $pdo->rollBack();
            return false;
        }
    } catch (\PDOException $exp) {
        return $exp->getMessage();
        $pdo->rollBack();
    }
}

function ifIsLiked($pdo, $userId, $productName) {
    try {

        $productId = getProductId($pdo, $productName);
            
        $query = "SELECT COUNT(*) FROM likes WHERE b_id = ? AND user_id = ?";
        $stmt = $pdo->prepare($query);
        $params = [$productId[0]["id"], $userId];
        $stmt->execute($params);
        $num_rows = $stmt->fetchColumn();
        
        if ($num_rows > 0) { 
            return true;
        } else {
            
            return false;
        }
    } catch (\PDOException $exp) {
        return $exp->getMessage();
        
    }
}

function getLikedProducts($pdo, $userId) {
    try {
        $query = "SELECT b_id FROM likes WHERE user_id = ?";
        $stmt = $pdo->prepare($query);
        $params = [$userId];
        $stmt->execute($params);
        $result = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $result[] = $row;
        }
        return  $result;
    } catch (PDOException $exp) {
        return "Something  wrnt Wrong " . $exp->getMessage();
    }
}

function searchForBooks($category) {
    try {
        $query = "SELECT b.name FROM books as B JOIN categories as C ON (b.category_id = c.id) WHERE c.name = ?";
        $statement = $pdo->prepare($query);
        $statement = execute($category);
    } catch (PDOException $exp) {
        return "Something went wrong." . $exp->getMessage();
    }
}

function searchDB($pdo, $criteria) {
    try {

        $query = 'SELECT name FROM books WHERE name LIKE ?;';
        $statement = $pdo->prepare($query);

        $params = [trim($criteria) . "%"];

        if ($statement->execute($params)) {
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return false;
        }
    } catch (PDOException $exp) {
        return "Something went wrong." . $exp->getMessage();
    }
}
