<?php
session_start();
require_once "./model/load_data.php";

require_once './view/header.php';

?>
<link rel="stylesheet" href="./assets/css/styles.css" type="text/css"/>
<link rel="stylesheet" href="./assets/css/cssReset.css" type="text/css"/>
<div class="main" id="main">
    <aside class="category_list">
        <!-- tuk moje  da  durjim list s kategoriite(i podkategorii) -->
    </aside>
    <div id="success"></div>
    <section class="baic_content">
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
            session_destroy();
            header("Location: index.php");
        } elseif (isset($_GET["page"])) {
            require_once "./view/" . $_GET["page"] . ".php";
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
<script type="text/javascript">
    function addToCart(name) {
        var request = new XMLHttpRequest;
        request.open("GET", "bucket.php?buy_product=" + name);
        request.onreadystatechange = function (ev) {
            if (this.readyState === 4 && this.status === 200) {
//                var resp = this.responseText;
                location.reload();

            }
        };
        request.send();
    }

    function reverseQuantity(bookName) {
        var request = new XMLHttpRequest;
        request.open("GET", "bucket.php?book=" + bookName);
        request.onreadystatechange = function (ev) {
            if (this.readyState === 4 && this.status === 200) {
                location.reload();
            }
        };
        request.send();

    }

    function removeBook(nameToRemove) {
        var request = new XMLHttpRequest;
        request.open("GET", "bucket.php?book_to_remove=" + nameToRemove);
        request.onreadystatechange = function (ev) {
            if (this.readyState === 4 && this.status === 200) {
                location.reload();
            }
        };
        request.send();
    }

    //TO DO
    function successAdd(name) {
//        var create = document.getElementById("success");
//        create.style.visibility = "visible";
//        create.innerHTML = name + " was added to  you  buket!";
//        
//        var request = new XMLHttpRequest;
//        request.open("GET", "bucket.php?minus=" + name);
//        request.onreadystatechange = function (ev) {
//            if (this.readyState === 4 && this.status === 200) {
//                
//            }
//        }
//        request.send();
    }
</script>

<?php
include_once './view/footer.php';
?>