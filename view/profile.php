<section class="baic_content">
    <div id="first_name" class="container">

    </div>
    <div id="last_name" class="container">

    </div>
    <div id="email" class="container">

    </div>
    <div id="age" class="container">

    </div>
    <div class="container" id="avatar">
        <img id="avatar" src="" alt="">
    </div>
    <a href="../index.php?page=redactProfile" ><button type="button" class="register">Edit my profile</button></a>
</section>

<script>
    var req = new XMLHttpRequest();
    req.open("get", "../controller/usersController.php");
    req.onreadystatechange = function (ev) {
        var resp = this.responseText;
        resp = JSON.parse(resp);
        document.getElementById("first_name").value = resp.first_name;
        document.getElementById("last_name").value = resp.last_name;
        document.getElementById("email").value = resp.email;
        document.getElementById("age").value = resp.age;
    }
    req.send();
</script>