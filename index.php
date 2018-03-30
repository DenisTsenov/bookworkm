<?php
session_start();
require_once "./model/load_data.php";

require_once './config/session.php';
$now = time();
if (isset($_SESSION["user"])) {
    if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
        // the time  has expired and  start  new  session
        require_once './heplerFunctions/bucketHelper.php';
        if (LOG) {
            removeProduct($pdo, $_SESSION["bucket"], $products);
            session_unset();
            session_destroy();
            session_start();
            $_SESSION["too_late"] = true;
        } else {
            removeProduct($pdo, $_SESSION["bucket"], $products);
            $_SESSION["too_late"] = true;
        }
    }

    $_SESSION['discard_after'] = $now + BUCKET_LIVE;
}
require_once __DIR__ . '/view/header.php';
?>
<div class="main">

    <link rel="stylesheet" href="./assets/css/styles.css" type="text/css"/>
    <link rel="stylesheet" href="./assets/css/cssReset.css" type="text/css"/>
    <div class="main" id="main">

        <aside class="category_list">
            <input type="text" onkeydown="getBook(this);">
            <form action="./controller/productsController.php" method="post">
                <select name="category">
                    <option value="category1">Category1</option>
                    <option value="category2">Category2</option>
                    <option value="category3">Category3</option>
                    <option value="category4">Category4</option>
                </select>
                <input type="submit" name="search" value="Submit">
            </form>
            <div id="result">

            </div>
        </aside>

        <section class="baic_content" id="baic_content">
            <?php
            if (isset($error_reg)) {
                foreach ($error_reg as $err) {
                    echo $err . "<br/>";
                }
                require_once './view/register.php';
            }
            if (isset($error_log)) {
                foreach ($error_log as $err) {
                    echo $err . "<br/>";
                }
                require_once './view/login.php';
            }
            if (isset($_GET["page"]) && $_GET["page"] == "logout") {
                require_once './heplerFunctions/bucketHelper.php';
                removeProduct($pdo, $_SESSION["bucket"], $products);
                session_destroy();
                header("Location: index.php");
            } elseif (isset($_GET["page"])) {
                require_once "./view/" . $_GET["page"] . ".php";
            }else{
                require_once "./view/main.php";
            }

//            var_dump($_SESSION);
//        var_dump($user);
            ?>
            <!-- tuk moje  da sa knigite spored towa  dali  e  lognat poterbitelq ili ne -->    
        </section>

        <!--        <article class="popular_book">
                 w tozi  tag moje  da slojim naj-novi ili  naj-pupolqrni knigi 
                
                </article>-->
        <footer class="footer">
            <p>This is footer</p>
        </footer>
    </div>
    <script src="./assets/js/ajax.js" type="text/javascript"></script>
    <script src="./assets/js/jQuery.js" type="text/javascript"></script>
    <script src="./assets/js/validate.js"  type="text/javascript"></script>
    <script src="./assets/js/effects.js"  type="text/javascript"></script>
    
    <?php
    include_once './view/footer.php';
    