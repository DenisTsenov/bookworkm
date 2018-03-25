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

require_once '../model/typesModel.php';

/*
 * return list of types
 */
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $result = getAllTypes($pdo);
    
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
 * isert new type
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
}




