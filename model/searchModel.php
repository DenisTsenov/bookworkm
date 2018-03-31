<?php
include_once  __DIR__ ."/load_data.php";

function getBooksByAuthor($pdo, $id, $searchedProducts){
    try{
        $query = "SELECT b.name, b.author_id, b.price, b.quantity, b.img_url
                  FROM books as b JOIN authors AS a
                  ON (b.author_id = a.id)
                  WHERE a.id = ?";
        $stmt = $pdo -> prepare($query);
        $stmt -> execute(array($id));
        $searchedProducts = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $searchedProducts[] = $row;
        }
    }
    catch(PDOException $exp){
        return "Oops, something went wrong " . $exp ->getMessage();
    }
}

function getAuthor($pdo, $author, &$id){
    try{
        $query = "SELECT id FROM authors WHERE name= ?";
        $stmt = $pdo -> prepare($query);
        $stmt -> execute(array($author));
        return $id;
    }
    catch(PDOException $exp){
        return "Oops, something went wrong " . $exp ->getMessage();
    }
}