<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION["user"]["type"] != 1) {
    header("Location: index.php");
}
?>
<?= isset($_SESSION["success"]) ? "<h3>Succsessfully added ". $_SESSION['success'] . " in DataBase</h3>" : "";
unset($_SESSION["success"]) ?>

<div id="addBook" >

    <!--<form action="./controller/authorsController.php" method="POST">-->
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" placeholder="Author name..">
    
    <button type="submit" class="smal_blue" onclick="insertAuthor();" name="insertBook"><input class="btn blue" type="submit" value="Add Author" name="insertBook"></button>
<!--</form>-->
</div>
<script type="text/javascript">
    
    function insertAuthor() {
    var name = document.getElementById("name").value;
    var request = new XMLHttpRequest;

    request.open("POST", "./controller/authorsController.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function (ev) {
        if (this.readyState === 4 && this.status === 200) {
            var response = JSON.parse(this.responseText);
            var h = document.createElement("h3");
            h.setAttribute("id", "addAuthor");
            h.innerHTML = response;
            
            var d = document.getElementById("addBook").appendChild(h);
            fade(f);
        }
    };
    request.send("name=" + name);
}
    
    
</script>