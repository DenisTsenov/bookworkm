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

    try {
        $result = getAllGenres($pdo);

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

        try {

            if (ifTypeExsist($pdo, $type)) {

                if (!ifGenreExsist($pdo, $genre)) {

                    if (addGenre($pdo, $genre, $type)) {

                        $responseArr[] = "Succsessfuly added " . $genre . " genre!";

                        echo json_encode($responseArr);

                    } else {
                        $responseArr[] = "Something went wrong! Please  try  again  later!";
                        echo json_encode($responseArr);

                    }
                } else {
                    $responseArr[] = "This genre allready exsist!";
                    echo json_encode($responseArr);

                }
            } else {
                $responseArr[] = "Type not exsist!";
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




