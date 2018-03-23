<section class="baic_content">
    <div class="container">
        <?= $_SESSION["user"]["first_name"]; ?>
    </div>
    <div class="container">
        <?= $_SESSION["user"]["last_name"]; ?>
    </div>
    <div class="container">
        <?= $_SESSION["user"]["email"]; ?>
    </div>
    <div class="container">
        <img id="avatar" src="<?= $_SESSION["user"]["img_name"] ?>" alt="">
    </div>
    <a href="./index.php?page=redactProfile" ><button type="button" class="register">Edit my profile</button></a>
</section>
