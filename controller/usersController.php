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
        $logo_url = "../assets/uploads/$firstName.$ext";
        if (move_uploaded_file($tmp_name, $logo_url)) {
            
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
        $a = registerProfile($pdo, $firstName, $lastName, $email, $password, $logo_url);
        if($a){
            header("Location: ../index.php");
        }
        else{
            header("Location: ../view/register.php");
        }

    } else {
        require_once "../../view/register.php";
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
        $result = login($pdo, $email, sha1($password));
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
    $firstName = trim(htmlentities($_POST["first_name"]));
    $lastName = trim(htmlentities($_POST["last_name"]));
    $email = trim(htmlentities($_POST["email"]));
    $oldPassword = trim(htmlentities($_POST["new_pass"]));
    $newPassword = trim(htmlentities($_POST["old_pass"]));
    $error = [];
    $tmp_name = $_FILES["avatar"]["tmp_name"];
    $orig_name = $_FILES["avatar"]["name"];

    if (is_uploaded_file($tmp_name)) {
        $exploded_name = explode(".", $orig_name);
        $ext = $exploded_name[count($exploded_name) - 1];
        $logo_url = "./assets/uploads/$firstName.$ext";
        if (move_uploaded_file($tmp_name, $logo_url)) {
            
        } else {
            $error[] = "File not moved successfully";
        }
    } else {
        $error[] = "File not uploaded successfully";
    }
    if (empty($firstName) || empty($lastName) || empty($email) || empty($oldPassword) || empty($newPassword)) {
        $error[] = "All fields must be filled!";
    }
    if (!$error) {
        foreach ($users as &$user) {
            if ($user["email"] == $_SESSION["user"]["email"]) {
                if ($user["password"] == sha1($_POST["old_pass"])) {
                    $user["first_name"] = $firstName;
                    $user["last_name"] = $lastName;
                    $user["email"] = $email;
                    $user["password"] = sha1($newPassword);
                    $user["avatar"] = $logo_url;
                    file_put_contents("assets/data/users.json", json_encode($users));
                    unset($_SESSION["user"]);
                    $_SESSION["user"] = $user;
                    header("Location: index.php?page=profile");
                    break;
                }
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET["profile"])){
        $logged_mail = $_SESSION["user"]["email"];
        $user = getUserByEmail($logged_mail);
        echo json_encode($user);
    }

}