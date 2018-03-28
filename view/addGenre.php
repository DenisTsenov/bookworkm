<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION["user"]["type"] != 1) {
    header("Location: index.php");
}
?>

<div id="addBook" >

    <!--<form action="./controller/genresController.php" method="POST" >-->
    <label for="new_genre">Genre name</label>
    <input type="text" id="new_genre" name="new_genre" placeholder="Genre name..">

    <label for="type">Type of genre</label>
    <select id="type" name="type">

    </select>
    <br/>

    <button type="submit" onclick="insertGenre();"  class="smal_blue" name="insertBook"><input  class="btn blue" type="submit" value="Add Book"></button>
    <!--</form>-->
</div>

<script type="text/javascript">
    function insertGenre() {
        var h = document.createElement("h3");
        h.setAttribute("id", "clear");
//        if (document.getElementById("clear").innerHTML !== "") {
//            document.getElementById("clear").innerHTML = "";
//        }
        var name = document.getElementById("new_genre").value;
        var type = document.getElementById("type").value;
        var request = new XMLHttpRequest;
        request.open("POST", "./controller/genresController.php", true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.onreadystatechange = function (ev) {
            if (this.readyState === 4 && this.status) {

                var resp = JSON.parse(this.responseText);
                h.innerHTML = resp;
                var d = document.getElementById("addBook").appendChild(h);
            }
        };
        request.send("new_genre=" + name + "&type=" + type);
    }

</script>