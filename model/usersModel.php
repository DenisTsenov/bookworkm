<?php

function registerProfile($pdo, $firstName, $lastName, $email, $password, $logo_url) {
    require_once __DIR__."./load_data.php";
    try {
        $statement = $pdo->prepare("INSERT INTO users (first_name, last_name, email, pass, img_name, type) VALUES (?, ?, ?, ?, ?, 0);");
        $params = [$firstName, $lastName, $email, $password, $logo_url];

        if ($statement->execute($params)){
            return true;
        }
    } catch (PDOException $exp) {
        echo "Something  went wrong! " . $exp->getMessage();
    }
}


function login($pdo, $email, $password) {
require_once __DIR__."/load_data.php";
    try {
        $query = "SELECT first_name, email, img_name, password, type FROM users WHERE email = ? AND password = ?;";
        $statement = $pdo->prepare($query);
        $params = [$email, $password];
        
        $statement->execute($params);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        return  $user;
        
    } catch (PDOException $exp) {
        echo "Something  went wrong! " . $exp->getMessage();
    }
}

function getUserByEmail($pdo, $email){
require_once __DIR__."/load_data.php";
    try{
        $statement = $pdo->prepare("SELECT first_name, last_name, email, age FROM users WHERE email = ?");
        $statement->execute(array($email));
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    catch(PDOException $exp){
        echo "Something went wrong!" . $exp->getMessage();
    }

}
