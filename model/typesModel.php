<?php
if ($_SESSION["user"]["type"] != 1) {
    header("Location: index.php");
}
require_once __DIR__ . "/load_data.php";

function getAllTypes($pdo) {
    try{
        
    $query = "SELECT id, name FROM categories_type;";
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

function ifTypeExsist($pdo, $id) {
    try{
        
    $query = "SELECT COUNT(*) from categories_type WHERE id = ?;";
    $stmt = $pdo->prepare($query);
    $params = [$id];
    $stmt->execute($params);
    $num_rows = $stmt->fetchColumn();
    
    if ($num_rows > 0) {
        return true;
    }else{
        return false;
    }
    
    } catch (PDOException $exp){
        return "Ups something went wrong " . $exp->getMessage();
    }
}