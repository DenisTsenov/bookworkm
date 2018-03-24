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
//        echo "losho mi e!";
        //todo  
        //return  error page
        //or some  err msg
    }
}

/*
 * isert new genre
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_genre"])) {
    $genre = trim(htmlentities($_POST["new_genre"]));
    $type = trim(htmlentities($_POST["type"]));
    $rsponseArr = [];

    if (strlen($genre) < 2) {
        $rsponseArr[] = "Invalid genre name.(Min legth  chars is  2!)";
        echo json_encode($rsponseArr);
//        echo $_SESSION["success"];
//        header("Location: ../index.php?page=addGenre");
    } else {
        require_once '../model/typesModel.php';

        if (ifTypeExsist($pdo, $type)) {

            if (!ifGenreExsist($pdo, $genre)) {

                if (addGenre($pdo, $genre, $type)) {

                    $rsponseArr[] = "Succsessfuly added " . $genre . " genre!";
                    
                    echo json_encode($rsponseArr);
//                    header("Location: ../index.php?page=addGenre");
                } else {
                    $rsponseArr[] =  "Something went wrong! Please  try  again  later!";
                    echo json_encode($rsponseArr);
//                    header("Location: ../index.php?page=addGenre");
                }
            } else {
                $rsponseArr[] = "This genre allready exsist!";
                echo json_encode($rsponseArr);
//                header("Location: ../index.php?page=addGenre");
            }
        } else {
            $rsponseArr[] = "Type not exsist!";
            echo json_encode($rsponseArr);
//            header("Location: ../index.php?page=addGenre");
        }
    }
}




