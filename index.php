<?php
session_start();
require_once "load_data.php";
require_once './header.php';
$error = false;

if(isset($_POST["register"])){
    $firstName = htmlentities($_POST["first_name"]);
    $lastName = htmlentities($_POST["last_name"]);
    $email = htmlentities($_POST["email"]);
    $password = htmlentities(sha1($_POST["pass"]));
    $confirm = htmlentities(sha1($_POST["c_pass"]));

    $tmp_name = $_FILES["avatar"]["tmp_name"];
    $orig_name = $_FILES["avatar"]["name"];

    if(is_uploaded_file($tmp_name)){
        $exploded_name = explode(".", $orig_name);
        $ext = $exploded_name[count($exploded_name)-1];
        $logo_url = "./assets/uploads/$firstName.$ext";
        if(move_uploaded_file($tmp_name, $logo_url)){

        }
        else{
            $error = "File not moved successfully";
        }
    }
    else{
        $error = "File not uploaded successfully";
    }
    foreach ($users as $user) {
        if($user["email"] == $email){
            $error = "A user with that email already exists.";
            break;
        }
    }
    if(empty($firstName) || empty($lastName) || empty($email) || empty($password)){
        $error = "All fields must be filled!";
    }
    if($password !== $confirm){
        $error = "Password mismatch!";
    }
    if(!$error){
        $user = array();
        $user["first_name"] = $firstName;
        $user["last_name"] = $lastName;
        $user["email"] = $email;
        $user["password"] = $password;
        $user["avatar"] = $logo_url;
        $user["cart"] = array();
        $user["history"] = array();
        $users[] = $user;
        file_put_contents("assets/data/users.json", json_encode($users));
        header("Location: index.php?page=login");
    }
    else{
        require_once "register.php";
    }
}

if(isset($_POST["login"])){
    $email = $_POST["email"];
    $password = $_POST["pass"];
    foreach ($users as $user) {
        if($user["email"] == $email){
            if($user["password"] == sha1($password)){
                $_SESSION["user"]= $user;
                header("Location: index.php?page=catalogue");
            }
            else{
                $error = "Wrong email and/or password";
            }
        }
        else{
            $error = "Wrong email and/or password";
        }
    }
}

if(isset($_POST["edit_profile"])){
    $firstName = htmlentities($_POST["first_name"]);
    $lastName = htmlentities($_POST["last_name"]);
    $email = htmlentities($_POST["email"]);
    $oldPassword = htmlentities($_POST["new_pass"]);
    $newPassword = htmlentities($_POST["old_pass"]);

    $tmp_name = $_FILES["avatar"]["tmp_name"];
    $orig_name = $_FILES["avatar"]["name"];

    if(is_uploaded_file($tmp_name)){
        $exploded_name = explode(".", $orig_name);
        $ext = $exploded_name[count($exploded_name)-1];
        $logo_url = "./assets/uploads/$firstName.$ext";
        if(move_uploaded_file($tmp_name, $logo_url)){

        }
        else{
            $error = "File not moved successfully";
        }
    }
    else{
        $error = "File not uploaded successfully";
    }
    if(empty($firstName) || empty($lastName) || empty($email) || empty($oldPassword) || empty($newPassword)){
        $error = "All fields must be filled!";
    }
    if(!$error){
        foreach ($users as &$user) {
            if($user["email"] == $_SESSION["user"]["email"]){
                if($user["password"] == sha1($_POST["old_pass"])){
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

?>

<div class="main">
    <aside class="category_list">
        <!-- tuk moje  da  durjim list s kategoriite(i podkategorii) -->
    </aside>
    <section class="baic_content">
        <?php

        if(isset($_GET["page"]) && $_GET["page"] == "logout"){
            session_destroy();
            header("Location: index.php");
        }
        elseif (isset($_GET["page"])) {
            require_once $_GET["page"] . ".php";
        }
        ?>


        <!-- tuk moje  da sa knigite spored towa  dali  e  lognat poterbitelq ili ne -->    
    </section>

<!--        <article class="popular_book">
         w tozi  tag moje  da slojim naj-novi ili  naj-pupolqrni knigi 
        
        </article>-->
    <footer class="footer">
        <p>This is  footer</p>
    </footer>
</div>

<?php
include_once './footer.php';
?>