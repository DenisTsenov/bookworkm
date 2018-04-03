<?php

/*
 * start new session if there is no session
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION["user"]["type"] != 1) {
    header("Location: index.php");
}

require_once '../model/typesModel.php';

/*
 * return list of types
 */
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    try {

        $result = getAllTypes($pdo);

        if ($result) {
            echo json_encode($result);
        } else {
            header("Location: ../index.php?page=errpage.php");
        }
    } catch (PDOException $exp) {
        $errFile = fopen("../errlog/PDOExeption.txt", "a+");
        if (is_writable($errFile)) {
            fwrite($errFile, $exp->getMessage() . '. Date -->> ' . date('l jS \of F Y h:i:s A'));
            fclose($errFile);
        } else {
            fclose($errFile);
        }
        header("Location: ../index.php?page=errpage.php");
    }
}


/*
 * isert new type
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
}




