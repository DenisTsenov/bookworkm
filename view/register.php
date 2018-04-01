<?php
    if (isset($_SESSION["user"]["first_name"])) {
        header("location: index.php");
    }
?>
<form action="./controller/usersController.php" method="POST" enctype="multipart/form-data">
  <div class="imgcontainer">
    <!--<img src="img_avatar2.png" alt="Avatar" class="avatar">-->
  </div>

  <div class="container">
    <label for="uname"><b>First Name</b></label>
    <input type="text" placeholder="Enter your first name" name="first_name" required>
    
    <label for="last_name"><b>Last Name</b></label>
    <input type="text" placeholder="Enter your last name" name="last_name" required>
    
     <label for="email"><b>Email</b></label>
     <input type="text" placeholder="Enter Email" name="email" required>

    <label for="pass"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="pass" required>
    
     <label for="c_pass"><b>Confirm Password</b></label>
    <input type="password" placeholder="Enter Password" name="c_pass" required>
        
    <label for="c_pass"><b>Avatar Image</b></label>
    <input type="file" name="avatar" required>
    <button type="submit" name="register">Register</button>
<!--    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>-->
  </div>

  <div class="container" style="background-color:#f1f1f1">
      <a href="index.php?page=login"><button type="button" class="register" >Login</button></a>
    <!--<span class="psw">Forgot <a href="#">password?</a></span>-->
  </div>
</form>