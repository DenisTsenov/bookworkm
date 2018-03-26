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
    $result = getAllAuthors($pdo);

    if ($result) {
        echo json_encode($result);
    } else {
//        echo "losho mi e!";
        //todo  
        //return  error page
        //or some  err msg
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

        if (!ifAuthorExsist($pdo, $authorName)) {

            if (insertAuthor($pdo, $authorName)) {
                $responseArr[] = "You added $authorName succsessfully!";
                echo json_encode($responseArr);
            } else {
                $responseArr[] = "Something  went  wrong!";
                echo json_encode($responseArr);
            }
//            $_SESSION["success"] = $authorName;
//            header("Location: ../index.php?page=addAuthor");
        } else {
            $responseArr[] = "Author allready  exsist!";
            echo json_encode($responseArr);
//        header("Location: ../index.php?page=addAuthor");
        }
    }
}




