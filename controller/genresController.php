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

require_once '../model/genresModel.php';

/*
 * return list of genres
 */
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $result = getAllGenres($pdo);

    if ($result) {
        echo json_encode($result);
    } else {
//    echo json_encode("okk");
    }
}

/*
 * isert new genre
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_genre"])) {
    $genre = trim(htmlentities($_POST["new_genre"]));
    $type = trim(htmlentities($_POST["type"]));
    $responseArr = [];

    if (strlen($genre) < 2) {
        $responseArr[] = "Invalid genre name.(Min legth  chars is  2!)";
        echo json_encode($responseArr);
//        echo $_SESSION["success"];
//        header("Location: ../index.php?page=addGenre");
    } else {
        require_once '../model/typesModel.php';

        if (ifTypeExsist($pdo, $type)) {

            if (!ifGenreExsist($pdo, $genre)) {

                if (addGenre($pdo, $genre, $type)) {

                    $responseArr[] = "Succsessfuly added " . $genre . " genre!";
                    
                    echo json_encode($responseArr);
//                    header("Location: ../index.php?page=addGenre");
                } else {
                    $responseArr[] =  "Something went wrong! Please  try  again  later!";
                    echo json_encode($responseArr);
//                    header("Location: ../index.php?page=addGenre");
                }
            } else {
                $responseArr[] = "This genre allready exsist!";
                echo json_encode($responseArr);
//                header("Location: ../index.php?page=addGenre");
            }
        } else {
            $responseArr[] = "Type not exsist!";
            echo json_encode($responseArr);
//            header("Location: ../index.php?page=addGenre");
        }
    }
}




