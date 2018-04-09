<h3 id="main-heading">Most Liked Books!</h3>
<script type="text/javascript">
    function getLikedPage(){
    var request = new XMLHttpRequest();
    request.open("GET", "./controller/likesController.php?liked=1", true);
    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var response = JSON.parse(this.responseText);
            var main = document.getElementById("baic_content");

            for (arr in response) {

                if (response[arr]["quantity"] <= 0) {
                    
                } else {

                    var console = document.createElement("DIV");
                    console.setAttribute("class", "liked_book");

                    var img = document.createElement("img");
                    img.src = "./assets/uploads/product_img/" + response[arr]["img"];
                    img.setAttribute("id", "liked_img");

                    var likes = document.createElement("p");
                    likes.innerHTML = "Likes: " + response[arr]["likes"];

                    var name = document.createElement("p");
                    name.innerHTML = "Name: " + response[arr]["name"];

                    var price = document.createElement("p");
                    price.innerHTML = "Price: " + response[arr]["price"];
                    
                    var quantity = document.createElement("p");
                    quantity.setAttribute("id", response[arr]["name"]);
                    
                    quantity.innerHTML = "Quantity: " + response[arr]["quantity"];
<?php if (isset($_SESSION["user"])) { ?>
                        var btn = document.createElement("button");
                        btn.setAttribute("id", "by_id");
                        
                        btn.value = response[arr]["name"];
                        btn.innerHTML = "In Bucket!";
                        btn.addEventListener('click', function (e) {

                            var request = new XMLHttpRequest;
                            request.open("GET", "./controller/bucketController.php?buy_product=" + this.value);
                            request.onreadystatechange = function (ev) {
                                if (this.readyState === 4 && this.status === 200) {
                                    var resp = JSON.parse(this.responseText);
//                                    alert(resp["name"]);
                                    
                                    var q = document.getElementById(resp["name"]);
                                    q.innerHTML = "Quantity: " + resp["quantity"];
                                    
                                    if (resp["quantity"] < 1) {
                                        location.reload();

                                    }else{
                                        var modal = document.getElementById("mod");
                                        modal.style.display = "block";
                                        modal.innerHTML = "";
                                        var response = "You add nice book in your bucket!";
                                        modalWindow(modal, response);
                                    }

                                }
                            };
                            request.send();
                        });
                        console.appendChild(btn);

<?php } ?>
                   
                    console.appendChild(img);
                    console.appendChild(likes);
                    console.appendChild(name);
                    console.appendChild(price);
                    console.appendChild(quantity);
                    main.appendChild(console);
                }
            }
        }
    };
    request.send();
    }
    getLikedPage();
</script>