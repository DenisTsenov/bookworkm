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

require_once '../model/authorsModel.php';

/*
 * return  list  of  authors
 */
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $result = getAllAuthors($pdo);
    
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
 * isert new  author
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
}




