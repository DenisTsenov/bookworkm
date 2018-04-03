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

require_once '../model/authorsModel.php';

/*
 * return  list  of  authors
 */
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {

        $result = getAllAuthors($pdo);

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
 * isert new  author
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"])) {
    $authorName = trim(htmlentities($_POST["name"]));
    $responseArr = [];

    if (mb_strlen($authorName) < 4) {
        $responseArr[] = "Name min length  is  5 chars!";
        echo json_encode($responseArr);
    } else {
        try {

            if (!ifAuthorExsist($pdo, $authorName)) {

                if (insertAuthor($pdo, $authorName)) {
                    $responseArr[] = "You added $authorName succsessfully!";
                    echo json_encode($responseArr);
                } else {
                   header("Location: ../index.php?page=errpage.php");
                }

            } else {
                $responseArr[] = "Author allready  exsist!";
                echo json_encode($responseArr);

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
}




