<section class="baic_content">
    <div class="container">
        <?php echo $_SESSION["user"]["first_name"] ?>
    </div>
    <div class="container">
        <?php echo $_SESSION["user"]["last_name"] ?>
    </div>
    <div class="container">
        <?php echo $_SESSION["user"]["email"] ?>
    </div>
    <div class="container" id="avatar">
        <img id="avatar" src="<?= $_SESSION["user"]["avatar"] ?>" alt="">
    </div>
    <a href="index.php?page=redactProfile" ><button type="button" class="register">Edit my profile</button></a>
</section>