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
            location.reload();
//            var response = JSON.parse(this.responseText);
//            
//            for(var i in response){
//                var h4 = document.createElement("h4");
//                h4.setAttribute("class", "err");
//                
//                h4.innerHTML = response[i];
//                var div = document.getElementById("redact");
//                div.appendChild(h4);
////                h4.innerHTML = "";
//            }

//            alert(response[0]);
//           
//            name.value = response.name;
//            name.price = response.price;
//            name.quantity = response.quantity;


        }
    };
    request.send("redact_name=" + name + "&redact_price=" + price + "&redact_quantity=" + quantity);

}

var request = new XMLHttpRequest;
request.open("GET", "./controller/typesController.php", true);
request.onreadystatechange = function (ev) {
    if (this.readyState === 4 && this.status) {
        var select = document.getElementById("type");
        var resp = JSON.parse(this.responseText);

        for (i in resp) {
            var option = document.createElement("option");
            option.setAttribute("value", resp[i]["id"]);
            option.innerHTML = resp[i]["name"];
            select.appendChild(option);
        }
    }
};
request.send();

function getBook(pole) {
    var div = document.getElementById("result");
    div.innerHTML = "";
    var request = new XMLHttpRequest();
    request.open("get", "server.php?search=" + pole.value);
    request.onreadystatechange = function (){
        if(this.readyState === 4 && this.status === 200){
            var names = JSON.parse(this.responseText);
            var ul = document.createElement("ul");
            for(var i = 0; i < names.length; i++){
                var li = document.createElement("li");
                li.innerHTML = names[i];
                ul.appendChild(li);
            }
            div.appendChild(ul);
            div.style.visibility = "visible";
        }
    }
    request.send();
}
