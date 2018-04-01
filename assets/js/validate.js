function validateAuthor(){
    var name = document.getElementById("author_name").value;
    var container = document.getElementById("addBook");
    return minLength(name, container);
}

function  validateBook() {
    
    var container = document.getElementById("errorContent");
    var name = document.forms['myForm']['new_name'].value;
    var author = document.forms['myForm']['author'].value;
    var price = document.forms['myForm']['new_price'].value;
    var quantity = document.forms['myForm']['new_quantity'].value;
    var category = document.forms['myForm']['new_category'].value;
    var img = document.forms['myForm']['new_img'].value;

    minLength(name, container);

    ifExsist(author, container);

    isNumber(price, container);

    minQuantity(quantity, container, 1);

    ifExsist(category, container);

    if (!checkFiles(img)) {
        var imgErr = document.createElement("h5");
        imgErr.setAttribute("id", "short_author_name");
        imgErr.className = "errJs";
        imgErr.innerHTML = "Invalid data type for Image!";
        container.appendChild(imgErr);
        return  false;
    }
    
//    unfade(container);
}
function checkFiles(img) {

    if (img === "") {
        return false;
    }
    var ext = img.substring(img.lastIndexOf('.') + 1);
    if (ext === "gif" || ext === "GIF" || ext === "png" || ext === "JPEG" || ext === "jpeg"
            || ext === "jpg" || ext === "JPG" || ext === "doc") {
        return true;
    } else {

        return false;
    }
}

function minQuantity(quantity, container, amount) {

    if (isNaN(quantity) || quantity < amount) {
        var quantityErr = document.createElement("h5");
        quantityErr.setAttribute("id", "short_author_name");
        quantityErr.className = "errJs";
        quantityErr.innerHTML = "Invalid Qunatity. Min is 1!";
        container.appendChild(quantityErr);
        return false;
    }
}

function isNumber(price, container) {

    if (isNaN(price) || price < 1.99) {
        var priceErr = document.createElement("h5");
        priceErr.setAttribute("id", "short_author_name");
        priceErr.className = "errJs";
        priceErr.innerHTML = "Invalid Price. Min is 1.99$!";
        container.appendChild(priceErr);
        return false;
    }
}

function ifExsist(author, container) {

    if (!author) {
        var authorErr = document.createElement("h5");
        authorErr.setAttribute("id", "short_author_name");
        authorErr.className = "errJs";
        authorErr.innerHTML = "Insert a valid string for Author Name";
        container.appendChild(authorErr);
        return false;
    }
}

function minLength(name, container) {

    if (name.length < 2 || name.length > 100) {
        var nameErr = document.createElement("h5");
        nameErr.setAttribute("id", "short_name");
        nameErr.className = "errJs";
        nameErr.innerHTML = "Name Field length shoud be between 2 and 100 chars!";
        container.appendChild(nameErr);
        return false;
    }
}

