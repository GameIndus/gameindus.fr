/*
*
*	Primary & Secondary 
* 	Navigation #Menu
*
*/
var secNavOpened = false;

function initNavigation() {
    var subItems = document.querySelectorAll(".sub-item");
    var secContainer = document.querySelector("nav.secondary-navigation");

    if (document.body.dataset.mobile) return false;

    for (var i = 0; i < subItems.length; i++) {
        var si = subItems[i];

        si.onclick = function (e) {
            e.preventDefault();
            var subIN = this.dataset.subitem;
            var subIC = document.querySelector(".sub-item-links");
            var subI = subIC.querySelector("." + subIN + "-sub");

            if (secNavOpened) {
                secContainer.innerHTML = "";

                secNavOpened.classList.remove("active");
                secNavOpened = false;
            }

            if (subI == null) return false;

            secContainer.parentNode.classList.add("opened");
            secContainer.innerHTML = subI.innerHTML;

            this.classList.add("active");

            secNavOpened = this;

            return false;
        }
    }


    window.addEventListener("click", function (e) {
        var t = e.target;

        if (t.className == "menu-item sub-item" || t.className == "menu-item sub-item active" ||
            t.className == "secondary-navigation" || (t.parentNode != null && t.parentNode.className == "secondary-navigation")
            || (t.parentNode.parentNode != null && t.parentNode.parentNode.className == "secondary-navigation")
            || (t.parentNode.parentNode.parentNode != null && t.parentNode.parentNode.parentNode.className == "secondary-navigation")) return false;

        if (secNavOpened) {
            var secContainer = document.querySelector("nav.secondary-navigation");
            secContainer.parentNode.classList.remove("opened");
            secContainer.innerHTML = "";

            secNavOpened.classList.remove("active");
            secNavOpened = false;
        }
    }, false);
}

/*
*
*	Support (/helpcenter)
* 	Faq
*
*/
function initFaq() {
    var sdbContainer = document.querySelector(".faq-sidebar-container");
    if (sdbContainer == null) return false;

    var qstContainer = document.querySelector(".faq-questions-container");
    var cats = sdbContainer.querySelectorAll(".faq-category");
    var divs = qstContainer.querySelectorAll(".faq-questions");

    for (var i = 0; i < cats.length; i++) {
        var cat = cats[i];

        cat.onclick = function (e) {
            e.preventDefault();
            var category = this.dataset.category;

            // Reset
            for (var j = 0; j < cats.length; j++) cats[j].classList.remove("active");
            for (var j = 0; j < divs.length; j++) divs[j].style.display = "none";

            var divSelected = qstContainer.querySelector(".faq-questions.faq-" + category);
            if (divSelected == null) return false;

            divSelected.style.display = "block";
            this.classList.add("active");

            window.location.hash = "!" + category;
            qstContainer.querySelector(".title").innerHTML = this.innerHTML;

            return false;
        }
    }

    // At the loading of the page
    var category = (window.location.hash && window.location.hash.indexOf("!") === 1) ? window.location.hash.split("!")[1] : "primary";
    if (category == "primary") {
        cats[0].classList.add("active");
        divs[0].style.display = "block";

        qstContainer.querySelector(".title").innerHTML = cats[0].innerHTML;
    } else {
        var cat = null;
        var div = null;

        // Get category div
        for (var i = 0; i < cats.length; i++)
            if (cats[i].dataset.category == category)
                cat = cats[i];

        // Get questions div
        for (var i = 0; i < divs.length; i++)
            if (divs[i].className == "faq-questions faq-" + category)
                div = divs[i];

        if (cat == null || div == null) {
            cats[0].classList.add("active");
            divs[0].style.display = "block";

            qstContainer.querySelector(".title").innerHTML = cats[0].innerHTML;
            return false;
        }

        cat.classList.add("active");
        div.style.display = "block";

        qstContainer.querySelector(".title").innerHTML = cat.innerHTML;

    }

    // Init divs with question/answer
    var qDivs = qstContainer.querySelectorAll(".question-container");
    for (var i = 0; i < qDivs.length; i++) {
        var div = qDivs[i];
        div.onclick = function (e) {
            if (e.target.tagName == "A") return true;
            e.preventDefault();

            var opened = (this.className == "question-container opened");

            if (opened) {
                this.classList.remove("opened");
                this.querySelector(".toggle-view").classList.remove("fa-angle-up");
                this.querySelector(".toggle-view").classList.add("fa-angle-down");
            } else {
                this.classList.add("opened");
                this.querySelector(".toggle-view").classList.remove("fa-angle-down");
                this.querySelector(".toggle-view").classList.add("fa-angle-up");
            }

            return false;
        }
    }
}

/*
*
*	Project view page (/project/{id})
* 	ProjectViewpage
*
*/
function initProjectViewpage() {
    var sdbContainer = document.querySelector(".project-sidebar-container");
    if (sdbContainer == null) return false;

    var qstContainer = document.querySelector(".project-divs-container");
    var cats = sdbContainer.querySelectorAll(".menu-item");
    var divs = qstContainer.querySelectorAll(".project-div");

    for (var i = 0; i < cats.length; i++) {
        var cat = cats[i];

        cat.onclick = function (e) {
            e.preventDefault();
            var category = this.dataset.div;

            // Reset
            for (var j = 0; j < cats.length; j++) cats[j].classList.remove("active");
            for (var j = 0; j < divs.length; j++) divs[j].style.display = "none";

            var divSelected = qstContainer.querySelector(".project-div.div-" + category);
            if (divSelected == null) return false;

            divSelected.style.display = "block";
            this.classList.add("active");

            window.location.hash = "!" + category;
            qstContainer.querySelector(".title").innerHTML = this.innerHTML;

            return false;
        }
    }

    // At the loading of the page
    var category = (window.location.hash && window.location.hash.indexOf("!") === 1) ? window.location.hash.split("!")[1] : "primary";
    if (category == "primary") {
        cats[0].classList.add("active");
        divs[0].style.display = "block";

        qstContainer.querySelector(".title").innerHTML = cats[0].innerHTML;
    } else {
        var cat = null;
        var div = null;

        // Get category div
        for (var i = 0; i < cats.length; i++)
            if (cats[i].dataset.div == category)
                cat = cats[i];

        // Get questions div
        for (var i = 0; i < divs.length; i++)
            if (divs[i].className == "project-div div-" + category)
                div = divs[i];

        if (cat == null || div == null) {
            cats[0].classList.add("active");
            divs[0].style.display = "block";

            qstContainer.querySelector(".title").innerHTML = cats[0].innerHTML;
            return false;
        }

        cat.classList.add("active");
        div.style.display = "block";

        qstContainer.querySelector(".title").innerHTML = cat.innerHTML;

    }

    // Canvas fullscreen (or not)
    var cvsContainer = document.querySelector(".canvas-container");
    if (cvsContainer == null) return false;
    var canvas = document.getElementsByTagName("iframe")[0];

    var icon = cvsContainer.querySelector(".fullscreen");
    icon.onclick = function (e) {
        if (canvas.webkitRequestFullScreen) canvas.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        if (canvas.mozRequestFullScreen) canvas.mozRequestFullScreen();
    }

    function _fullscreenEnabled() {
        if (window['fullScreen'] !== undefined) return window.fullScreen;
        return screen.width == window.innerWidth && Math.abs(screen.height - window.innerHeight) < 5;
    }

    function FSHandler(e) {
        if (!_fullscreenEnabled()) {
            canvas.width = 812;
            canvas.height = 400;
        } else {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
    }

    window.addEventListener("error", function (e) {
        console.log(e);
    });

    document.addEventListener("fullscreenchange", FSHandler);
    document.addEventListener("webkitfullscreenchange", FSHandler);
    document.addEventListener("mozfullscreenchange", FSHandler);
    document.addEventListener("MSFullscreenChange", FSHandler);
}

function initProjectCenter() {
    var projectUsers = document.querySelector("table.project-users");
    projectUsers = null; // Bypass to stop the script

    if (projectUsers != null) {
        var actions = projectUsers.querySelectorAll(".project-users-content td .project-user-action");
        var widthHover = 150;

        for (var i = 0; i < actions.length; i++) {
            var action = actions[i];

            action.onmouseenter = function () {
                var index = getNodeIndex(this.parentNode);
                var actions2 = this.parentNode.parentNode.querySelectorAll(".project-user-action");

                this.style.position = "absolute";
                this.style.left = ((index * 50) + 30) + "px";
                this.style.width = widthHover + "px";
                this.style.zIndex = 2;

                for (var j = 0; j < actions2.length; j++) {
                    var action2 = actions2[j];
                    var index2 = getNodeIndex(action2.parentNode);

                    if (index2 != index) {
                        action2.style.position = "absolute";
                        action2.style.left = ((index2 * 50) + 30) + "px";

                        action2.style.zIndex = 0;
                    }
                }
            }
            action.onmouseleave = function (e) {
                var index = getNodeIndex(this.parentNode);
                var target = e.toElement || e.relatedTarget || e.target || function () {
                    throw "Failed to attach an event target!";
                }
                var actions2 = this.parentNode.parentNode.querySelectorAll(".project-user-action");

                this.style.width = "50px";

                var delay = 220;
                if (target.classList.contains("project-user-action")) return false;

                setTimeout(function () {
                    for (var j = 0; j < actions2.length; j++) {
                        var action2 = actions2[j];
                        var index2 = getNodeIndex(action2.parentNode);

                        action2.removeAttribute("style");
                    }
                }, delay);
            }
        }
    }
}

function initSlideshow() {
    var slideshow = document.querySelector(".slideshow");
    if (slideshow == null) return false;

    var s = false;

    var change = function () {
        var slides = slideshow.querySelectorAll(".slide");

        if (!s) {
            slides[0].style.top = "-400px";
            slides[1].style.top = "0";
            s = true;
        } else {
            slides[0].style.top = "0";
            slides[1].style.top = "400px";
            s = false;
        }
    };

    // setInterval(change, 15000);
}

var closeNotifInterval = null;

function initNotifCenter() {
    var notif = document.querySelector(".notif");
    if (notif == null) return false;

    notif.classList.add("opened");

    closeNotifInterval = setTimeout(function () {
        notif.classList.remove("opened");
    }, 8000);

    notif.querySelector(".close").onclick = function () {
        clearTimeout(closeNotifInterval);
        this.parentNode.classList.remove("opened");
    }
}


function playGame() {
    var button = document.querySelector(".overlay-button");
    var container = document.querySelector(".canvas-container");

    button.style.display = "none";

    container.innerHTML = '<iframe src="https://gameindus.fr/core/ajax/gameTest.php" width="812" height="400" scrolling="no" frameborder="0"></iframe><div class="fullscreen"><i class="fa fa-arrows-alt"></i></div>';
    container.style.display = "block";

    document.querySelector(".project-info-container").style.height = "650px";

    initProjectViewpage();
}


window.addEventListener("load", function () {
    initNavigation();
    initFaq();
    initProjectViewpage();
    initSlideshow();

    initProjectCenter();

    setTimeout(function () {
        initNotifCenter();
    }, 100);

    console.info("Tu aimerais voir comment le système fonctionne ? Rejoins notre équipe pour nous aider à construire le futur de GameIndus : https://gameindus.fr/about/jobs !");
});

function getNodeIndex(node) {
    var index = 0;
    while ((node = node.previousSibling)) {
        if (node.nodeType != 3 || !/^\s*$/.test(node.data)) {
            index++;
        }
    }
    return index;
}
