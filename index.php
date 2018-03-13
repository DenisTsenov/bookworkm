<?php
require_once './header.php';
?>

<div class="main">
    <nav class="navigation">
        <a href="index.php"><img id="logo" src="http://akgerber.com/wp-content/uploads/Open_Book_Logo_1small.png" alt="book_logo"/></a> 
        <a id="login" href="index.php?page=login">Login</a>
    </nav>

    <aside class="category_list">
        <!-- tuk moje  da  durjim list s kategoriite(i podkategorii) -->
    </aside>
    <section class="baic_content">
        <?php
        if (isset($_GET["page"])) {
            require_once $_GET["page"] . ".php";
        }
//    else{
//        require_once 'index.php';
//    }
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
