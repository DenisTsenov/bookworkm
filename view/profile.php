<section class="baic_content" id="baic_content">
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
    <button onclick="getHistory()" id="blue" class="blue left">View <?= $_SESSION["user"]["first_name"] . "'s "; ?>History</button>
</section>
<script type="text/javascript">
    function getHistory() {
        var btn = document.getElementById("blue");
        btn.setAttribute("id",'disabled');
        var request = new XMLHttpRequest();
        var user = <?= $_SESSION["user"]["id"] ?>;
        request.open("GET", "./controller/historyController.php?user=" + user, true);
        request.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var resp = JSON.parse(this.responseText);
//                console.log(resp);
                if (typeof resp === "null") {
                    alert("No history for now!");
                }
                var basicContent = document.getElementById("baic_content");
                var table = document.createElement('table');
                
                table.setAttribute("id", "histoy-table");
                var tr = document.createElement('tr');
                
                var bookName = document.createElement('th');
                bookName.innerHTML = "Book name";
                
                var price = document.createElement('th');
                price.innerHTML = "Price";
                
                var date = document.createElement('th');
                date.innerHTML = "Date";
                
                var quantity = document.createElement('th');
                quantity.innerHTML = "Quantity";
                
                var author = document.createElement('th');
                author.innerHTML = "Author";
                
                tr.appendChild(bookName);
                tr.appendChild(price);
                tr.appendChild(date);
                tr.appendChild(quantity);
                tr.appendChild(author);
                
                table.appendChild(tr);
                for (i in resp) {
                    var tr = document.createElement('tr');

                    var name = document.createElement('td');
                    var price = document.createElement('td');
                    var date = document.createElement('td');
                    var quantity = document.createElement('td');
                    var author = document.createElement('td');
                    
                    name.innerHTML = resp[i]["name"];
                    price.innerHTML = resp[i]["price"];
                    date.innerHTML = resp[i]["date"];
                    quantity.innerHTML = resp[i]["quantity"];
                    author.innerHTML = resp[i]["author"];
                    
                    tr.appendChild(name);
                    tr.appendChild(price);
                    tr.appendChild(date);
                    tr.appendChild(quantity);
                    tr.appendChild(author);
                    
                    table.appendChild(tr);
                }
                basicContent.appendChild(table);
            }
        };
        request.send();
    }
</script>
