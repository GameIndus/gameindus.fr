function PremiumWheel() {
    this.modalContainer = null;
    this.wheelContainer = null;
    this.triggerButton = null;

    this.minDegrees = 1800; // 5 tours
    this.processStarted = false;
    this.wheelInfo = null;

    this.load();
}

PremiumWheel.prototype = {

    load: function () {
        var self = this;

        window.addEventListener("load", function () {
            self.bind();
        });
    },

    bind: function () {
        var self = this;

        if (document.getElementById("premiumwheel-trigger") == null) return false;

        this.triggerButton = document.getElementById("premiumwheel-trigger");
        this.modalContainer = document.getElementById("modal-wheel-container");
        this.wheelContainer = this.modalContainer.querySelector(".wheel-container");

        this.triggerButton.onclick = function () {
            self.openModal();
        };

        if (Cookies.get('firstLoginWheelPremium') == null) {
            Cookies.set("firstLoginWheelPremium", true, {expires: 30});
            self.openModal();
        }
    },

    openModal: function () {
        var self = this;
        if (this.modalContainer == null) return false;

        this.modalContainer.classList.add("opened");

        this.modalContainer.querySelector(".close").onclick = function () {
            self.closeModal();
        };

        if (this.modalContainer.dataset.jsondata) {
            this.showWheelResult(JSON.parse(this.modalContainer.dataset.jsondata));
            return false;
        }

        this.wheelContainer.querySelector("#inner-spin").onclick = function () {
            self.startWheelProcess();

            self.modalContainer.querySelector(".bubble").style.display = "none";
            this.onclick = function () {
            }
        }
    },

    closeModal: function () {
        if (this.modalContainer == null) return false;
        this.modalContainer.classList.remove("opened");
    },

    startWheelProcess: function () {
        var self = this;
        if (this.processStarted) return false;

        this.processStarted = true;

        this.ajaxRequest({action: "startWheelProcess"}, function (data) {
            data = JSON.parse(data);

            if (data.error) {
                self.ajaxError(data.error);
                return false;
            }

            function rand(min, max) {
                return Math.floor(Math.random() * (max - min + 1) + min);
            }

            var hasWin = data.win;
            var force = (hasWin) ? rand(346, 374) : rand(376, 704);

            self.turnWheelWithForce(force);
            delete data.success;
            self.wheelInfo = data;

            setTimeout(function () {
                self.giveWheelResult();
            }, 6500);
        });
    },

    turnWheelWithForce: function (force) {
        var totalDegree = this.minDegrees + force;
        this.wheelContainer.querySelector("#inner-wheel").style.transform = "rotate(" + totalDegree + "deg)";
    },

    showWheelResult: function (wheelInfo) {
        wheelInfo.win = parseInt(wheelInfo.win);

        this.wheelInfo = wheelInfo;
        this.giveWheelResult(true);
    },

    giveWheelResult: function (preventSave) {
        var self = this;
        var resultContainer = this.modalContainer.querySelector(".wheel-result");
        var spanText = resultContainer.querySelector("span.text");
        var spanHero1 = resultContainer.querySelector("span.hero-1");
        var closeButton = resultContainer.querySelector("div.close-button");

        resultContainer.classList.add("active");
        closeButton.style.opacity = 0;

        if (this.wheelInfo.win) {
            spanHero1.innerHTML = "<i class='fa fa-star-o' style='color:#f1c40f;font-size:3em'></i><br>Vous avez gagné !";
            spanText.innerHTML = "Bien joué, vous venez de gagner 1 mois de Premium gratuit ! Profitez bien, et bonne création !";


            closeButton.className = "btn btn-success close-button";
            closeButton.innerHTML = "Recevoir le grade";
            closeButton.style.width = "180px";
            closeButton.style.margin = "70px auto";

            closeButton.onclick = function () {
                window.location.reload();
            }
        } else {
            spanHero1.innerHTML = "<i class='fa fa-times' style='color:#c0392b;font-size:3em'></i><br>Vous avez perdu !";
            spanText.innerHTML = "Mais n'abandonnez pas, vous pourrez retenter votre chance demain !";

            closeButton.style.width = "100px";
            closeButton.style.margin = "90px auto";
            closeButton.onclick = function () {
                self.closeModal();
            }
        }

        if (!preventSave) {
            this.ajaxRequest({action: "saveWheelTrial"}, function (data) {
                data = JSON.parse(data);

                if (data.error) {
                    self.ajaxError(data.error);
                    return false;
                }

                closeButton.style.opacity = 1;
            });
        } else {
            this.modalContainer.querySelector(".close").style.display = "block";
            spanHero1.style.marginTop = "20px";
            return false;
        }

        this.modalContainer.querySelector(".close").style.display = "none";
        spanHero1.style.marginTop = "20px";
    },

    ajaxRequest: function (params, callback) {
        var xhr = null;

        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }

        if (xhr == null) throw new Error("XHR Object seems to be null. Your navigator is not compatible."); // On averti l'utilisateur

        function formatParams(params) {
            return "?" + Object
                .keys(params)
                .map(function (key) {
                    return key + "=" + params[key]
                })
                .join("&")
        }

        var processUrl = this.modalContainer.dataset.processUrl;
        var url = processUrl + formatParams(params);

        xhr.open("GET", url, false);
        xhr.onreadystatechange = function () {
            callback(this.responseText);
        };
        xhr.send(null);

    },

    ajaxError: function (errorKey) {
        window.location.href = "https://gameindus.fr/account/wheelprocess?action=userError&errorKey=" + errorKey;
    }

};

new PremiumWheel();