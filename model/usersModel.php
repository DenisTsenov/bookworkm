<?php
require_once __DIR__."/load_data.php";
function registerProfile($pdo, $firstName, $lastName, $email, $password, $logo_url) {
    
    try {
        $statement = $pdo->prepare("INSERT INTO users (first_name, last_name, email, pass, img_name) VALUES (?, ?, ?, ?, ?)");
        $params = [$firstName, $lastName, $email, $password, $logo_url];
        $statement->execute($params);
    } catch (PDOException $exp) {
        echo "Something  went wrong! " . $exp->getMessage();
    }
}


function login($pdo, $email, $password) {
require_once __DIR__."/load_data.php";
    try {
        
        $query = "SELECT first_name, email, img_name, password FROM users WHERE email = ? AND password = ?;";
        $statement = $pdo->prepare($query);
        $params = [$email, $password];
        
        $statement->execute($params);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        return  $user;
        
    } catch (PDOException $exp) {
        echo "Something  went wrong! " . $exp->getMessage();
    }
}
