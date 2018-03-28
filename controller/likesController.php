<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../model/likesModel.php';

if (isset($_GET["liked"])) {
    $r = getMoostLiked($pdo);
    echo json_encode($r);
    
}