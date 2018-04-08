<!DOCTYPE html>
<html lang="en">
    <head>
        <title>BookWorms</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./assets/css/styles.css" type="text/css"/>
        <link rel="stylesheet" href="./assets/css/cssReset.css" type="text/css"/>
    </head>

    <body>
        <div class="main">
            <nav class="navigation">

                <a href="index.php"><img id="logo" src="http://akgerber.com/wp-content/uploads/Open_Book_Logo_1small.png" alt="book_logo"/></a>
                <a id="login" href="index.php?page=catalogue">Catalogue</a>

                <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] == 1) { ?>
                    <select id="drop-down" onchange="window.location.href = this.value;">
                        <option style="display:none" disabled selected value>New Content</option>
                        <option value="index.php?page=addBook">Add new Book</option>
                        <option value="index.php?page=addAuthor">Add new Author</option>
                        <option value="index.php?page=addGenre">Add new Genre</option>
                    </select>
                <?php } ?>

                <?php if (isset($_SESSION["user"])) { ?>
                    <a id="login" href="index.php?page=profile">My profile</a>
                <?php } ?>
                <?php if (isset($_SESSION["user"])) { ?>
                    <a id="login" href="index.php?page=bucket">My Cart</a>
                <?php } ?>

                <?php if (!isset($_SESSION["user"])) { ?>
                    <a id="login" href="index.php?page=login">Login</a>
                <?php } else {
                    ?>
                    <a id="login" href="index.php?page=logout">Logout</a>
                <?php } ?>
            </nav>
        </div>
    </body>