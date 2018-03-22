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

require_once '../model/genresModel.php';

/*
 * return list of genres
 */
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $result = getAllGenres($pdo);
    
    if ($result) {
        echo json_encode($result);
    }else{
//        echo "losho mi e!";
        //todo  
        //return  error page
        //or some  err msg
    }
}


/*
 * isert new genre
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
}




