<?php


include_once  __DIR__ ."/load_data.php";


function getBooksByAuthor($pdo, $id){
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
        $_SESSION["searchedProducts"]=$searchedProducts;
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

function getBooksByCategory($pdo, $id){
    try{
        $query = "SELECT b.name, b.category_id, b.price, b.quantity, b.img_url
                  FROM books as b JOIN categories AS a
                  ON (b.category_id = a.id)
                  WHERE a.id = ?";
        $stmt = $pdo -> prepare($query);
        $stmt -> execute(array($id));
        $searchedProducts = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $searchedProducts[] = $row;
        }
        $_SESSION["searchedProducts"]=$searchedProducts;
    }
    catch(PDOException $exp){
        return "Oops, something went wrong " . $exp ->getMessage();
    }
}


function getCategory($pdo, $category, &$id){
    try{
        $query = "SELECT id FROM categories WHERE name= ?";
        $stmt = $pdo -> prepare($query);
        $stmt -> execute(array($category));
        return $id;
    }
    catch(PDOException $exp){
        return "Oops, something went wrong " . $exp ->getMessage();
    }
}