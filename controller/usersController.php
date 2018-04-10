<?php

require_once "../model/usersModel.php";
session_start();
$error = false;

if (isset($_POST["register"])) {
    $firstName = trim(htmlentities($_POST["first_name"]));
    $lastName = trim(htmlentities($_POST["last_name"]));
    $email = trim(htmlentities($_POST["email"]));
    $password = htmlentities(sha1($_POST["pass"]));
    $confirm = htmlentities(sha1($_POST["c_pass"]));
    $error_reg = [];
    $tmp_name = $_FILES["avatar"]["tmp_name"];
    $orig_name = $_FILES["avatar"]["name"];

    if (is_uploaded_file($tmp_name)) {
        $exploded_name = explode(".", $orig_name);
        $ext = $exploded_name[count($exploded_name) - 1];
        $logo_url = "./assets/uploads/$firstName.$ext";
        if (move_uploaded_file($tmp_name, ".".$logo_url)) {
            
        } else {
            $error_reg[] = "File not moved successfully";
        }
    } else {
        $error_reg[] = "File not uploaded successfully";
    }
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $error_reg[] = "All fields must be filled!";
    }
    if ($password !== $confirm) {
        $error_reg[] = "Password mismatch!";
    }
    if (!$error_reg) {
        $existingUser = checkForExistingUser($email);
        if(empty($existingUser)){
            $a = registerProfile($firstName, $lastName, $email, $password, $logo_url);
            header("Location: ../index.php?page=login");
        }
        else{
            $error_reg[] = "That email is already in use!";
        }

    } else {
        header("Location: ../index.php?page=register");
    }
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["pass"];
    $error_log = [];
    if(empty($email) || empty($password)){
        $error_log[] = "Please fill in the fields";
    }
    if(!$error_log){
        $result = login($email, sha1($password));
    }
    else{
        header("Location: ../index.php?page=login");
        echo $error_log[0];
        die();
    }
    if ($result) {
        $_SESSION["user"] = $result;
        $_SESSION["bucket"] = [];
        header("Location: ../index.php");
    }else{
        echo $error_reg[] = "Invaid User Name/Password";
    }
    
    
}

if (isset($_POST["edit_profile"])) {
    $id = $_SESSION["user"]["id"];
    $firstName = trim(htmlentities($_POST["first_name"]));
    $lastName = trim(htmlentities($_POST["last_name"]));
    $email = trim(htmlentities($_POST["email"]));
    $oldPassword = trim(htmlentities(sha1($_POST["old_pass"])));
    $newPassword = trim(htmlentities(sha1($_POST["new_pass"])));
    $error = [];
    $tmp_name = $_FILES["avatar"]["tmp_name"];
    $orig_name = $_FILES["avatar"]["name"];

    if (is_uploaded_file($tmp_name)) {
        $exploded_name = explode(".", $orig_name);
        $ext = $exploded_name[count($exploded_name) - 1];
        $logo_url = "./assets/uploads/$firstName.$ext";
        if (move_uploaded_file($tmp_name, ".".$logo_url)) {
            
        } else {
            $error[] = "File not moved successfully";
        }
    } else {
        $error[] = "File not uploaded successfully";
    }
    if (empty($firstName) || empty($lastName) || empty($email) || empty($oldPassword) || empty($newPassword)) {
        $error[] = "All fields must be filled!";
    }
    if($oldPassword !== $_SESSION["user"]["password"]){
        echo "Invalid username and/or password.";
    }
    if (!$error) {
        $user = array();
        $user = editUser($id, $firstName, $lastName, $email, $newPassword, $logo_url);
        unset($_SESSION["user"]);
        $_SESSION["user"] = $user;
        header("Location: ../index.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET["profile"])){
        $logged_mail = $_SESSION["user"]["email"];
        $user = getUserByEmail($logged_mail);
        echo json_encode($user);
    }

}