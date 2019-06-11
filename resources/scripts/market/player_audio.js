/*
* GameIndus - A free online platform to imagine, create and publish your game with ease!
*
* GameIndus website
* Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
* <https://github.com/GameIndus/gameindus.fr>
*/

function AudioPlayer() {

    this.div = null;
    this.file = null;

    this.audio = null;
    this.status = 0;
    this.canvasSize = {w: 1170, h: 250};

    // Realtime spectrum canvas
    this.spectrumZone, this.spectrumContext;
    this.audioContext, this.audioSource, this.audioAnalyser;
    this.audioBuffer = null, this.animationId = null;

    // Music Time
    this.lastCurrentTime = null, this.lastDuration = null;
}

AudioPlayer.prototype = {

    load: function (id) {
        this.div = document.getElementById(id);
        if (this.div == null) {
            console.error("[AudioPlayer] Init: failed to found '" + id + "' div in document.");
            return false;
        }

        this.file = this.div.dataset.file;

        this.initAudio();
        this.initDom();

        this.initSpectrum();
    },

    initAudio: function () {
        var that = this;
        if (this.file == null) return false;

        this.audio = new Audio("/core/ajax/getAssetPreview.php?file=" + this.file);
        this.audio.volume = 0.7;

        console.log(this.audio);

        this.audio.oncanplay = function () {
            that.refreshAudioTime();
        }
    },

    initDom: function () {
        var that = this;

        if (this.div == null) return false;
        this.div.innerHTML = "";

        var canvas = document.createElement("canvas");
        this.div.appendChild(canvas);
        this.spectrumZone = canvas;


        var zonetext = document.createElement("span");
        zonetext.innerHTML = "<i class='fa fa-music'></i> Prévisualisation";
        this.div.appendChild(zonetext);


        var metabar = document.createElement("div");
        metabar.className = "metabar";

        var musicTime = document.createElement("div");
        musicTime.className = "musicTime";
        musicTime.innerHTML = "--:-- / --:--";
        musicTime.style.fontWeight = "bold";
        metabar.appendChild(musicTime);

        var play = document.createElement("i");
        play.className = "fa fa-play right";
        metabar.appendChild(play);
        var stop = document.createElement("i");
        stop.className = "fa fa-stop right";
        metabar.appendChild(stop);

        this.div.appendChild(metabar);


        this.canvasSize.h -= 30;

        play.onclick = function (e) {
            e.preventDefault();
            if (that.audio == null) return false;

            if (that.status == 0) {
                that.audio.play();
                this.className = "fa fa-pause right";
                that.status = 1;
                that.drawSpectrum();
            } else {
                that.audio.pause();
                this.className = "fa fa-play right";
                that.status = 0;
            }

            return false;
        }

        stop.onclick = function (e) {
            e.preventDefault();
            if (that.audio == null) return false;

            that.audio.pause();
            that.audio.currentTime = 0;
            play.className = "fa fa-play right";
            that.status = 0;

            return false;
        }
    },

    initSpectrum: function () {
        var that = this;
        if (this.spectrumZone == null || this.audio == null) return false;

        this.spectrumContext = this.spectrumZone.getContext('2d');
        this.spectrumZone.width = this.canvasSize.w;
        this.spectrumZone.height = this.canvasSize.h;
        this.spectrumInterval = null;

        // Init spectrum analyser
        this.audioContext = new AudioContext(); // audioContext object instance
        this.audioAnalyser = this.audioContext.createAnalyser(); // AnalyserNode method

        this.audioSource = this.audioContext.createMediaElementSource(this.audio);
        this.audioSource.connect(this.audioAnalyser);
        this.audioAnalyser.connect(this.audioContext.destination);

        // Get spectrum from file
        var req = new XMLHttpRequest();
        console.log(this.audio.src);
        req.open('GET', this.audio.src, true);
        req.responseType = 'arraybuffer';
        req.onload = function () {
            var audioData = req.response;
            that.audioContext.decodeAudioData(audioData, function (buffer) {
                that.audioBuffer = buffer.getChannelData(0);
                that.drawSpectrum();
            }, function (e) {
                "Error with decoding audio data" + e.err
            });
        }
        req.send();
    },

    refreshAudioTime: function () {
        var div = this.div.querySelector(".musicTime");
        if (div == null) return false;

        var currentT = this.audio.currentTime;
        var duration = this.lastDuration;

        if (currentT == this.lastCurrentTime) return false;
        if (duration == null) duration = this.audio.duration;

        div.innerHTML = parseTime(currentT) + " / " + parseTime(duration);

        this.lastCurrentTime = currentT;
    },

    drawSpectrum: function () {
        if (this.animationId != null) {
            cancelAnimationFrame(this.animationId);
            this.animationId = null;
        }

        var that = this;

        var meterNum = 800 / (10 + 2);
        var capYPositionArray = [];
        var allCapsReachBottom = false;

        var render = function () {
            if (that.audio == null) return false;
            if (that.audioAnalyser == null || that.audioSource == null || that.audioContext == null) return true;

            var size = ap.canvasSize;
            var ctx = that.spectrumContext;


            var fbcArray = new Uint8Array(that.audioAnalyser.frequencyBinCount);
            that.audioAnalyser.getByteFrequencyData(fbcArray);

            var bar_width = 10, bar_margin = 2;
            var spectrum_pad = 200;
            var cap_height = 2;
            var offset = {x: 0, y: (size.h - 35)};

            var gradient = ctx.createLinearGradient(0, 0, 0, 300);
            // gradient.addColorStop(0, "rgb(0, 148, 255)");
            // gradient.addColorStop(1, "rgb(0, 204, 255)");
            gradient.addColorStop(1, '#0f0');
            gradient.addColorStop(0.5, '#ff0');
            gradient.addColorStop(0, '#f00');
            ctx.fillStyle = gradient;

            // Update caps
            if (that.status === 0) {
                for (var i = fbcArray.length - 1; i >= 0; i--) fbcArray[i] = 0;
                allCapsReachBottom = true;
                for (var i = capYPositionArray.length - 1; i >= 0; i--) allCapsReachBottom = allCapsReachBottom && (capYPositionArray[i] === 0);
                if (allCapsReachBottom) {
                    cancelAnimationFrame(that.animationId);
                    that.animationId = null;
                    return;
                }
            }

            ctx.clearRect(0, 0, size.w, size.h);
            var step = Math.round(fbcArray.length / meterNum);

            // Draw spectrum
            for (var i = 0; i < meterNum; i++) {
                var value = fbcArray[i * step];
                if (capYPositionArray.length < Math.round(meterNum)) capYPositionArray.push(value);

                //draw the cap, with transition effect
                ctx.fillStyle = "#FFF";
                if (value < capYPositionArray[i]) {
                    ctx.fillRect((i * (bar_width + bar_margin)) + spectrum_pad, (size.h - (--capYPositionArray[i])) - cap_height, bar_width, cap_height);
                } else {
                    ctx.fillRect((i * (bar_width + bar_margin)) + spectrum_pad, (size.h - value) - cap_height, bar_width, cap_height);
                    capYPositionArray[i] = value;
                }
                ;
                ctx.fillStyle = gradient;
                ctx.fillRect((i * (bar_width + bar_margin)) + spectrum_pad, size.h - value + cap_height, bar_width, size.h); //the meter
            }


            that.refreshAudioTime();

            that.animationId = requestAnimationFrame(render);
        }

        this.animationId = requestAnimationFrame(render);
    }

};


var ap = new AudioPlayer();
window.onload = function () {
    ap.load("player-audio-container");
}

function parseTime(a) {
    var b = Math.floor(a / 60), c = Math.round(a - 60 * b);
    return pad(b, 2) + ":" + pad(c, 2)
}

function pad(a, b) {
    for (var c = a + ""; c.length < b;) c = "0" + c;
    return c
}