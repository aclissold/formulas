window.startup = function() {
    var tex = document.getElementsByClassName("tex");
    Array.prototype.forEach.call(tex, function(el) {
        katex.render(el.getAttribute("data-expr"), el);
    });
};

window.validate = function() {
    var pass1 = document.getElementById("pass1").value;
    var pass2 = document.getElementById("pass2").value;
    if (pass1 !== pass2) {
        document.getElementById("pass2").setCustomValidity("Please make sure the passwords match.");
    } else {
        document.getElementById("pass2").setCustomValidity("");
    }
};
