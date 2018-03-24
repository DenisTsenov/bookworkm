<?php
require_once __DIR__ . "/load_data.php";

if (!$_SESSION["user"]) {
    header("Location: index.php");
}

function getAllAuthors($pdo) {
    try{
        
    $query = "SELECT id, name from authors";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $result[] = $row;
    }
    return  $result;
    } catch (PDOException $exp){
        return "Ups something went wrong " . $exp->getMessage();
    }
}

function getAuthorName($pdo, $id) {
    try{
        
    $query = "SELECT name from authors WHERE id = ?;";
    $stmt = $pdo->prepare($query);
    $params = [$id];
    $stmt->execute($params);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $result[] = $row;
    }
    if ($result) {
        return true;
    }else{
        return false;
    }
    
    } catch (PDOException $exp){
        return "Ups something went wrong " . $exp->getMessage();
    }

}


function ifAuthorExsist($pdo, $name) {
    try{
        
    $query = "SELECT COUNT(*) from authors WHERE name = ?;";
    $stmt = $pdo->prepare($query);
    $params = [$name];
    $stmt->execute($params);
    $num_rows = $stmt->fetchColumn();
    if ($num_rows) {
        return true;
    }else{
        return false;
    }
    
    } catch (PDOException $exp){
        return "Ups something went wrong " . $exp->getMessage();
    }
}
       

function insertAuthor($pdo, $name) {
    try{
        
    $query = "INSERT INTO authors(name) VALUES(?);";
    $stmt = $pdo->prepare($query);
    $param = [$name];
    
    
    if ($stmt->execute($param)) {
        return getAuthorName($pdo, $name);
    }
    } catch (PDOException $exp){
        return "Ups something went wrong " . $exp->getMessage();
    }
}

