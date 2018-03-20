<?php
function registerProfile($firstName, $lastName, $email, $password, $logo_url){
    require_once "load_data.php";
    $statement = $pdo->prepare("INSERT INTO users (first_name, last_name, email, pass, img_name) VALUES (?, ?, ?, ?, ?)");
    $statement->execute(array($firstName, $lastName, $email, $password, $logo_url));
    echo $statement;
}