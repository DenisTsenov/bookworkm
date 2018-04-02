function fade(element) {
    var op = 1;  // initial opacity
    var timer = setInterval(function () {
        var finish = document.getElementById("signup-response");
        finish.parentNode.removeChild(finish);

        if (op <= 0.1) {
            clearInterval(timer);
            element.style.display = 'none';
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op -= op * 0.1;
    }, 4000);
    element.style.display = 'visible';
}
function unfade(element) {
    var op = 0.1;  // initial opacity
    element.style.display = 'block';
    var timer = setInterval(function () {
        var finish = document.getElementById("signup-response");
        finish.parentNode.removeChild(finish);

        if (op >= 1) {
            clearInterval(timer);
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op += op * 0.1;
    }, 4000);
}