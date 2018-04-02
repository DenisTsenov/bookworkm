<?php

/*
 * start new session if there is no session
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!$_SESSION["user"]) {
    header("Location: index.php");
}

require_once '../model/historyModel.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $userId = trim(htmlentities($_GET["user"]));
    $historyErr = [];
    if (!is_numeric($userId) || $userId < 1) {
        $historyErr[] = "Invalid  history!";
        echo json_encode($historyErr);
    } else {
        $list = getUserHistory($pdo, $userId);
        if ($list) {
            echo json_encode($list);
        } else {
            $historyErr[] = null;
            echo json_encode($historyErr);
        }
    }
}


