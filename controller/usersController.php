<?php
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
        if (move_uploaded_file($tmp_name, $logo_url)) {
            
        } else {
            $error_reg[] = "File not moved successfully";
        }
    } else {
        $error_reg[] = "File not uploaded successfully";
    }
    foreach ($users as $user) {
        if ($user["email"] == $email) {
            $error_reg[] = "A user with that email already exists.";
            break;
        }
    }
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $error_reg[] = "All fields must be filled!";
    }
    if ($password !== $confirm) {
        $error_reg[] = "Password mismatch!";
    }
    if (!$error_reg) {
        $user = array();
        $user["first_name"] = $firstName;
        $user["last_name"] = $lastName;
        $user["email"] = $email;
        $user["password"] = $password;
        $user["avatar"] = $logo_url;
        $user["type"] = 0;
        $user["cart"] = array();
        $user["history"] = array();
        $users[] = $user;
        file_put_contents("assets/data/users.json", json_encode($users));
        header("Location: index.php?page=login");
    } else {
        require_once "register.php";
    }
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["pass"];
    $error_log = [];
    foreach ($users as $user) {
        if ($user["email"] == $email) {
            if ($user["password"] == sha1($password)) {
                $_SESSION["user"] = $user;
                $_SESSION["bucket"] = [];
                header("Location: index.php?page=catalogue");
            } else {
                $error_log[] = "Wrong email and/or password";
            }
        } else {
            $error_log[] = "Wrong email and/or password";
        }
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