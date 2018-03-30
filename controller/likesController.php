<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../model/likesModel.php';

if (isset($_GET["liked"])) {
    try{
        $r = getMoostLiked($pdo);
        
        echo json_encode($r);
    } catch (PDOException $exp){
        echo "Somethon  went wrong " . $exp->getMessage();
    }
    
    
}