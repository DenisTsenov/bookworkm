<form action="./index.php" method="POST">
  <div class="imgcontainer">
    <!--<img src="img_avatar2.png" alt="Avatar" class="avatar">-->
  </div>

  <div class="container">
    <label for="email"><b>Email Address</b></label>
    <input type="text" placeholder="Enter Email.." name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
        
    <button type="submit">Login</button>
<!--    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>-->
  </div>

  <div class="container" style="background-color:#f1f1f1">
      <a href="index.php?page=register"><button type="button" class="register" >Register</button></a>
    <!--<span class="psw">Forgot <a href="#">password?</a></span>-->
  </div>
</form>