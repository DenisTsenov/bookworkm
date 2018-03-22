<?php
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
        return  fasle;
    }
    
    } catch (PDOException $exp){
        return "Ups something went wrong " . $exp->getMessage();
    }
}

