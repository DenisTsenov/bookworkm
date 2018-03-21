function addToCart(name) {
    var request = new XMLHttpRequest;
    request.open("GET", "./controller/bucketController.php?buy_product=" + name);
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
    request.open("GET", "./controller/bucketController.php?book=" + bookName);
    request.onreadystatechange = function (ev) {
        if (this.readyState === 4 && this.status === 200) {
            location.reload();
        }
    };
    request.send();

}

function removeBook(nameToRemove) {
    var request = new XMLHttpRequest;
    request.open("GET", "./controller/bucketController.php?book_to_remove=" + nameToRemove);
    request.onreadystatechange = function (ev) {
        if (this.readyState === 4 && this.status === 200) {
            location.reload();
        }
    };
    request.send();
}
function getBookInfo(bookName) {
    var request = new XMLHttpRequest;
    request.open("get", "./controller/productsController.php?productName=" + bookName);
    request.onreadystatechange = function (ev) {
        if (this.readyState === 4 && this.status === 200) {

//                var resp = JSON.parse(this.responseText);
//                alert(resp.name);
//                var f = document.createElement("form");
//                f.setAttribute('method', "post");
//                f.setAttribute('action', "submit.php");
//
//                var i = document.createElement("input"); //input element, text
//                i.setAttribute('type', "text");
//                i.setAttribute('name', "username");
//
//                var s = document.createElement("input"); //input element, Submit button
//                s.setAttribute('type', "submit");
//                s.setAttribute('value', "Submit");
//
//                f.appendChild(i);
//                f.appendChild(s);


        }
    };
    request.send();
}

function  redactBook(bookToRedact) {
    var name = document.getElementById("redact_name").value;
    var price = document.getElementById("redact_price").value;
    var quantity = document.getElementById("redact_quantity").value;
//    var img = document.getElementById("redact_img");
    
    var request = new XMLHttpRequest;
    request.open("POST", "./controller/productsController.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function (ev) {
        if (this.readyState === 4 && this.status === 200) {
            
            var response = JSON.parse(this.resposeText);
            name.value = response.name;
            name.price = response.price;
            name.quantity = response.quantity;
            
            
        }
    };
    request.send("name=" + name + "&price=" + price + "&quantity=" + quantity);

}