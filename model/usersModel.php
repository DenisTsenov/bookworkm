<?php

function registerProfile($firstName, $lastName, $email, $password, $logo_url) {
    require_once __DIR__."./load_data.php";
    try {
        $query = "INSERT INTO users (first_name, last_name, email, password, img_name, type) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $params = [$firstName, $lastName, $email, $password, $logo_url, 0];
        var_dump($params);
        $result =  $stmt -> execute($params);
        var_dump($result);
        return $result;
    } catch (PDOException $exp) {
        echo "Something  went wrong! " . $exp->getMessage();
    }
}


function login($email, $password) {
require_once __DIR__."/load_data.php";
    try {
        $query = "SELECT id, first_name, last_name, email, img_name, password, type FROM users WHERE email = ? AND password = ?;";
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

function editUser($id,  $firstName, $lastName, $email, $password, $avatar){
    require_once __DIR__."/load_data.php";
    try{
        $statement = $pdo -> prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ?, img_name = ? WHERE id = ?");
        $params = [$firstName, $lastName, $email, $password, $avatar, $id];
        $statement->execute($params);
        $statement = $pdo -> prepare("SELECT * FROM users WHERE id = ?");
        $params = [$id];
        $statement -> execute($params);
        $user = $statement -> fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    catch(PDOException $exp){
        echo "Something went wrong! " . $exp->getMessage();
    }
}
