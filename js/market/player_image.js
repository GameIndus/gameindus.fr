function ImagePlayer() {

    this.div = null;
    this.file = null;

    this.image = null;
    this.loaded = false;
    this.ctx = null;

    this.canvasSize = {w: 1170, h: 325};

}

ImagePlayer.prototype = {

    load: function (id) {
        this.div = document.getElementById(id);
        if (this.div == null) {
            console.error("[ImagePlayer] Init: failed to found '" + id + "' div in document.");
            return false;
        }

        this.file = this.div.dataset.file;

        this.initImage();
        this.initDom();

        var canvas = document.createElement("canvas");
        canvas.style.width = this.canvasSize.w + "px";
        canvas.style.height = this.canvasSize.h + "px";

        canvas.width = this.canvasSize.w;
        canvas.height = this.canvasSize.h;

        this.canvas = canvas;
        this.ctx = canvas.getContext("2d");

        this.updInt = loadInterval();

        this.div.appendChild(canvas);

        var zonetext = document.createElement("span");
        zonetext.innerHTML = "<i class='fa fa-image'></i> Prévisualisation";
        this.div.appendChild(zonetext);
    },

    initImage: function () {
        var that = this;

        this.image = new Image();
        this.image.src = "https://market.gameindus.fr/preview/" + this.file;

        this.image.onload = function () {
            that.loaded = true;
        }

        this.image.onerror = function () {
            console.error("[ImagePlayer] Init: failed. Image '" + this.src + "' not found on the disk.");
        }
    },

    update: function () {
        if (!this.loaded) return false;

        var c = this.ctx;
        var can = this.canvas;
        var imgSize = {w: this.image.width, h: this.image.height};
        c.clearRect(0, 0, this.canvas.width, this.canvas.height);

        var wF = imgSize.w, hF = imgSize.h;
        hF = can.height, wF = (can.height * imgSize.w) / imgSize.h;

        var oX = 0, oY = 0;

        if (wF < can.width) oX = (can.width - wF) / 2;

        c.drawImage(this.image, oX, oY, wF, hF);
    },

    initDom: function () {

    }

};

var ap = new ImagePlayer();

window.onload = function () {
    ap.load("player-image-container");
};

var loadInterval = function () {
    ap.update();
    requestAnimationFrame(loadInterval);
};