<?php

require_once '../model/catalogModel.php';

if (isset($_GET["page"]) && isset($_GET["articles"])) {

    $pages = trim(htmlentities($_GET["page"]));
    $articles = trim(htmlentities($_GET["articles"]));
    $catalogErr = [];

    if ($pages < 0 || !is_numeric($pages)) {
        $catalogErr[] = "Invalid pages given!";
    }

    if ($articles < 0 || !is_numeric($articles)) {
        $catalogErr[] = "Invalid atricles given!";
    }

    if (!$catalogErr) {

        try {
            $pageResult = getCatalogProducts($pdo, $pages, $articles);
            echo json_encode($pageResult);
        } catch (PDOException $exp) {
            $errFile = fopen("../errlog/PDOExeption.txt", "a+");
            if (is_writable($errFile)) {
                fwrite($errFile, $exp->getMessage() . '. Date -->> ' . date('l jS \of F Y h:i:s A'));
                fclose($errFile);
            } else {
                fclose($errFile);
            }
            header("Location: ../index.php?page=errpage");
        }
    } else {
        //todo
        //err resp
    }
}

