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
    request.open("GET", "controller/productsController.php?search=" + pole.value, true);
    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var names = this.responseText;
            console.log(names);
//            var ul = document.createElement("ul");
//            for(var i = 0; i < names.length; i++){
//                var li = document.createElement("li");
//                li.innerHTML = names[i];
//                ul.appendChild(li);
//            }
//            div.appendChild(ul);
//            div.style.visibility = "visible";
        }
    };
    request.send();
}

function fadeOut() {
        document.addEventListener('click', function (e) {
            if (e.target && e.target.id === 'fade') {
                var fadeTarget = document.getElementById("fade");
                var fadeEffect = setInterval(function () {
                    if (!fadeTarget.style.opacity) {
                        fadeTarget.style.opacity = 1;
                    }
                    if (fadeTarget.style.opacity < 0.1) {
                        clearInterval(fadeEffect);
                    } else {
                        fadeTarget.style.opacity -= 0.1;
                    }
                }, 100);
            }
        });
    }

function takeGenres() {
    var request = new XMLHttpRequest;
    request.open("GET", "./controller/genresController.php", true);
    request.onreadystatechange = function (ev) {
        if (this.readyState === 4 && this.status) {
            var select = document.getElementById("category");
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
}