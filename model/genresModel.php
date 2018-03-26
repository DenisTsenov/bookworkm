<?php
if ($_SESSION["user"]["type"] != 1) {
    header("Location: index.php");
}
require_once __DIR__ . "/load_data.php";

function getAllGenres($pdo) {
    try{
        
    $query = "SELECT id, name FROM categories;";
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

function ifGenreExsist($pdo, $name) {
    try{
    
    $query = "SELECT COUNT(id) from categories WHERE name = ?;";
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

function getGenreName($pdo, $id) {
    try{
        
    $query = "SELECT name from categories WHERE id = ?;";
    $stmt = $pdo->prepare($query);
    $params = [$id];
    $stmt->execute($params);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $result[] = $row;
    }
    if ($result) {
        return  true;
    }else{
        return  false;
    }
    
    } catch (PDOException $exp){
        return "Ups something went wrong " . $exp->getMessage();
    }
}

function addGenre($pdo, $name, $type) {
    try{
        
    $query = "INSERT INTO categories(name, type_id) VALUES(?,?);";
    $stmt = $pdo->prepare($query);
    $param = [$name, $type];
    
    if ($stmt->execute($param)) {
        return true;
    }
    } catch (PDOException $exp){
        return "Ups something went wrong " . $exp->getMessage();
    }
}

