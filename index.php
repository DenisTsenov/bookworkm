<?php
session_start();

require_once "./model/load_data.php";

require_once __DIR__ . '/view/header.php';

?>
<div class="main">
        
    </div>
<link rel="stylesheet" href="./assets/css/styles.css" type="text/css"/>
<link rel="stylesheet" href="./assets/css/cssReset.css" type="text/css"/>
<div class="main" id="main">
    <aside class="category_list">
        <!-- tuk moje  da  durjim list s kategoriite(i podkategorii) -->
    </aside>
    
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
//       var_dump($_SESSION);
//        var_dump($user);
//
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
<script src="./assets/js/ajax.js">
    
   
</script>

<?php
include_once './view/footer.php';
?>