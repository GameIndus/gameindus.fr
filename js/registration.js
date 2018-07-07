/**
 *    FlatRadio module
 */
function FlatRadio() {
    this.binds = {};
    this.listeners = {};
}

FlatRadio.prototype = {

    bind: function (name, divId) {
        var div = document.getElementById(divId);
        if (div == null) return false;

        this.binds[name] = div;
        this.prepare(name);
    },
    prepare: function (name) {
        var that = this;
        var div = this.binds[name];
        if (div == null) return false;

        var radios = div.querySelectorAll("div");

        for (var i = 0; i < radios.length; i++) {
            var radio = radios[i];
            radio.onclick = function () {
                var radios = this.parentNode.querySelectorAll("div");
                var name = this.parentNode.dataset.flatRadioName;

                for (var i = 0; i < radios.length; i++) {
                    radios[i].classList.remove("active");
                }

                if (this.parentNode.dataset.to != null) {
                    var inputTo = document.getElementById(this.parentNode.dataset.to);
                    if (inputTo != null) inputTo.value = this.getAttribute("value");
                }

                this.classList.add("active");

                if (that.listeners[name] != null) {
                    var listeners = that.listeners[name];

                    for (var i = 0; i < listeners.length; i++)
                        listeners[i](this.getAttribute("value"));
                }
            }
        }

        div.dataset.flatRadioName = name;
    },

    onChange: function (name, callback) {
        if (this.listeners[name] == null) this.listeners[name] = [];
        this.listeners[name].push(callback);
    }

};

window.addEventListener("load", function () {
    var flatRadio = new FlatRadio();

    flatRadio.bind("select-experience", "select-experience");
});

/**
 *    Register module
 */
var username = false;
var email = false;
var key = false;

document.getElementById("username").onkeyup = function () {
    var el = document.getElementById("username");
    var error = document.createElement("p");
    var val = el.value;
    var regex = /^[a-zA-Z0-9\-]+$/;
    var hasElement = false;

    if (val.length < 4 || !val.match(regex)) {
        error.className = "error";

        if (!val.match(regex))
            error.innerHTML = "Le nom d'utilisateur est incorrect.";
        if (val.length < 4)
            error.innerHTML = "Le nom d'utilisateur doit être supérieur ou égal à 4 caractères.";

        el.classList.add("error");
        username = false;

        for (var i = 0; i < el.parentNode.childNodes.length; i++)
            if (el.parentNode.childNodes[i].tagName == "P" && el.parentNode.childNodes[i].className == "error")
                hasElement = true;

        if (!hasElement) el.parentNode.appendChild(error);
    } else {
        username = true;
        el.classList.remove("error");
        for (var i = 0; i < el.parentNode.childNodes.length; i++)
            if (el.parentNode.childNodes[i].className == "error") el.parentNode.childNodes[i].remove();
    }
}

document.getElementById("email").onkeyup = function () {
    var el = document.getElementById("email");
    var error = document.createElement("p");
    var val = el.value;
    var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    var hasElement = false;

    if (val.length < 6 || !val.match(regex)) {
        error.className = "error";

        if (!val.match(regex))
            error.innerHTML = "L'e-mail est incorrect.";

        el.classList.add("error");
        email = false;

        for (var i = 0; i < el.parentNode.childNodes.length; i++)
            if (el.parentNode.childNodes[i].tagName == "P" && el.parentNode.childNodes[i].className == "error")
                hasElement = true;

        if (!hasElement) el.parentNode.appendChild(error);
    } else {
        email = true;
        el.classList.remove("error");
        for (var i = 0; i < el.parentNode.childNodes.length; i++)
            if (el.parentNode.childNodes[i].className == "error") el.parentNode.childNodes[i].remove();
    }
}

if (document.getElementById("key1") != null) {
    var keyInputs = ["key1", "key2", "key3", "key4"];
    var lastKeyInput = keyInputs[keyInputs.length - 1];
    var errorTimeout = null;

    for (var i in keyInputs) {
        var keyInput = keyInputs[i];
        var input = document.getElementById(keyInput);

        if (input == null) continue;

        input.onkeydown = function (event) {
            if (this.value.length == 0 && event.keyCode == 8) {
                var prevInputKey = keyInputs[keyInputs.indexOf(this.id) - 1];
                if (!prevInputKey) return false;
                var prevInput = document.getElementById(prevInputKey);

                event.preventDefault();
                prevInput.focus();
                return false;
            }
            if (event.keyCode == 8 || event.keyCode == 9) return true;

            if (this.value.length >= 4) {
                event.preventDefault();
                return false;
            }
        }

        input.onkeyup = function (event) {
            if (this.value.length == 4 && event.keyCode != 8) {
                var nextInputKey = keyInputs[keyInputs.indexOf(this.id) + 1];
                if (!nextInputKey) {
                    checkForKey();
                    return false;
                }
                var nextInput = document.getElementById(nextInputKey);

                event.preventDefault();
                nextInput.focus();
                return false;
            } else if (this.id == lastKeyInput && this.value.length < 4) {
                message(null);
                return true;
            }
        }
    }

    function checkForKey() {
        var sendedKey = "";

        for (var i in keyInputs) {
            var input = document.getElementById(keyInputs[i]);
            sendedKey += input.value;
        }

        var http = new XMLHttpRequest();
        var url = "core/checkForKey.php";
        var params = "key=" + sendedKey;

        http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        http.onreadystatechange = function () {
            if (http.readyState == 4 && http.status == 200) {
                if (http.responseText == "free") {
                    key = true;

                    message("Clé valide", "success");
                } else {
                    key = false;

                    if (http.responseText == "used") message("Cette clé est déjà utilisée.", "error");
                    else message("Clé invalide. Veuillez réessayer.", "error");
                }
            }
        }
        http.send(params);
    }

    function message(message, type) {
        var container = document.querySelector(".keys-form");
        var resultDiv = document.getElementById("resultKeyMessage");
        var nextInput = container.parentNode.nextSibling.nextSibling;

        if (!message) {
            if (errorTimeout) {
                clearTimeout(errorTimeout);
                rerrorTimeout = null;
            }

            for (var i in keyInputs) {
                var input = document.getElementById(keyInputs[i]);
                input.classList.remove("error");
                input.classList.remove("success");
            }

            container.removeAttribute("style");
            resultDiv.innerHTML = "";
            resultDiv.className = "hide";
            nextInput.style.marginTop = "60px";
            return false;
        }

        if (!type) type = "success";


        container.style.height = "222px";
        nextInput.style.marginTop = "20px";

        for (var i in keyInputs) {
            var input = document.getElementById(keyInputs[i]);
            input.classList.add(type);
        }

        errorTimeout = setTimeout(function () {
            resultDiv.classList.add(type);
            resultDiv.classList.remove("hide");
            resultDiv.innerHTML = message;
        }, 300);
    }
} else {
    key = true;
}

document.getElementById("registerForm").onsubmit = function (e) {
    if (!key || !username || !email) {
        e.preventDefault();
        document.getElementById("errorMsg").innerHTML = "Un des champs a mal été rempli. Veuillez réessayer.";
        return false;
    } else {
        document.getElementById("errorMsg").innerHTML = "";
    }
}

document.getElementById("username").onchange = document.getElementById("username").onkeyup;
document.getElementById("email").onchange = document.getElementById("email").onkeyup;