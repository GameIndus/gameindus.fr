var secNavOpened = false;

function initMobileNavigation() {
    var btnMenu = document.getElementById("btn-toggle-menu");
    var menuItems = document.querySelectorAll("header .header-inner nav.primary-navigation ul.nav-menu li");
    var menuSubBar = document.querySelector(".subnav-inner");
    var ulMenu = document.querySelector("header .header-inner nav.primary-navigation ul.nav-menu");

    var subItems = document.querySelectorAll(".sub-item");
    var secContainer = document.querySelector("nav.secondary-navigation");

    btnMenu.addEventListener("touchstart", function () {
        var topbar = document.querySelector("header .top-panel");
        var menu = document.querySelector("header .header-inner nav.primary-navigation");

        if (menu.style.display == "none" || menu.style.display == '') {
            menu.style.display = "block";

            topbar.style.position = "fixed";
            topbar.style.zIndex = 50;
            topbar.style.top = 0;

            this.classList.add("opened");
        } else {
            menu.style.display = "none";

            topbar.style.position = "relative";
            topbar.style.zIndex = null;
            topbar.style.top = null;

            this.classList.remove("opened");
        }
    });

    for (var i = 0; i < menuItems.length; i++) {
        var menuItem = menuItems[i];

        menuItem.addEventListener("touchstart", function (e) {
            e.preventDefault();
            var subIN = this.dataset.subitem;
            var subIC = document.querySelector(".sub-item-links");
            var subI = subIC.querySelector("." + subIN + "-sub");

            if (subI == null) {
                window.location.href = this.querySelector("a").href;
            }

            if (secNavOpened) {
                secContainer.innerHTML = "";

                for (var j = 0; j < menuItems.length; j++) menuItems[j].style.marginBottom = null;
                secNavOpened.classList.remove("active");
                secNavOpened = false;
            }

            var _el = this;
            setTimeout(function () {
                if (subI == null) return false;

                secContainer.parentNode.classList.add("opened");
                secContainer.innerHTML = subI.innerHTML;

                _el.classList.add("active");

                secNavOpened = _el;

                menuSubBar.style.display = "block";
                menuSubBar.style.top = (_el.offsetTop + _el.offsetHeight + ulMenu.offsetTop + btnMenu.offsetHeight + 1) + "px";

                _el.style.marginBottom = (menuSubBar.offsetHeight + 10) + "px";
            }, 100);
        });
    }

    window.addEventListener("touchstart", function (e) {
        var t = e.target;

        if (t.className == "menu-item sub-item" || t.className == "menu-item sub-item active" ||
            t.className == "secondary-navigation" || (t.parentNode != null && t.parentNode.className == "secondary-navigation")
            || (t.parentNode.parentNode != null && t.parentNode.parentNode.className == "secondary-navigation")
            || (t.parentNode.parentNode.parentNode != null && t.parentNode.parentNode.parentNode.className == "secondary-navigation")) return false;

        if (secNavOpened) {
            var secContainer = document.querySelector("nav.secondary-navigation");
            secContainer.parentNode.classList.remove("opened");
            secContainer.innerHTML = "";

            for (var j = 0; j < menuItems.length; j++) menuItems[j].style.marginBottom = null;

            secNavOpened.classList.remove("active");
            secNavOpened = false;
        }
    }, false);
}

window.addEventListener("load", function () {
    initMobileNavigation();
});