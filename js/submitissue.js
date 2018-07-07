/*
* GameIndus - A free online platform to imagine, create and publish your game with ease!
*
* GameIndus website
* Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
* <https://github.com/GameIndus/gameindus.fr>
*/

window.onload = function () {

    var df = new dropFile("dropzone", "Glissez votre image ou cliquez-ici.", "progress-bar-container");
    df.onFileDeposed(function (file) {
        var reader = new FileReader();

        reader.onload = (function (theFile) {
            return function (e) {
                if (document.getElementById("dropzone").querySelector(".preview"))
                    document.getElementById("dropzone").removeChild(document.getElementById("dropzone").querySelector(".preview"));

                var preview = document.createElement('div');
                preview.style.display = "block";
                preview.style.position = "absolute";
                preview.style.width = "100%";
                preview.style.height = "100%";
                preview.style.left = "0";
                preview.style.right = "0";
                preview.style.top = "0";
                preview.style.bottom = "0";
                preview.className = "preview";

                preview.style.background = "url(" + e.target.result + ") no-repeat center center";
                preview.style.backgroundSize = "100%";

                document.getElementById("dropzone").appendChild(preview);
            };
        })(file);
        reader.readAsDataURL(file);
    });

    var form = document.getElementById("submitissue-form");
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        if (df.files.length > 0) {
            df.phpFile = "/core/ajax/uploadHelpcenterImage.php?captcha=" + document.getElementById("captcha").value;
            df.upload(0, function (json) {
                if (json.name != null && json.name.indexOf(".jpg") > -1) {
                    form.submit();
                } else {
                    if (json.error) {
                        alert("Erreur: " + json.error);
                        return false;
                    } else {
                        if (json == "bad_captcha") {
                            window.location.href = window.location.href + "?badcaptcha";
                            return false;
                        } else {
                            alert("Erreur inconnue. Merci de réessayer plus tard.");
                            return false;
                        }
                    }
                }
            });
        } else {
            form.submit();
        }

        return false;
    });

    /*
    * Tags system
    */
    var tagsInput = document.getElementById("tags");
    var tagsCont = document.getElementById("tags-container");
    var tagsList = document.getElementById("tagslist");

    if (tagsInput != null) {
        tagsInput.onkeydown = function (e) {
            if (e.keyCode == 9) { // Tab
                e.preventDefault();
                var v = tagsInput.value;

                if (v.length >= 3) {
                    tagsCont.innerHTML += '<div class="tag">' + v + '</div>';

                    tagsInput.value = "";
                    tagsInput.style.paddingLeft = (tagsCont.offsetWidth) + "px";
                }

                var tagsDom = tagsCont.querySelectorAll(".tag");
                var tags = new Array();

                for (var i = 0; i < tagsDom.length; i++) tags.push(tagsDom[i].innerHTML);
                tagsList.value = tags.join(",");

                return false;
            } else if (e.keyCode == 8) { // Back
                var v = tagsInput.value;

                if (v.length == 0) {
                    e.preventDefault();

                    var tagsDom = tagsCont.querySelectorAll(".tag");
                    if (tagsDom.length > 0) {
                        var ltd = tagsDom[tagsDom.length - 1];
                        ltd.parentNode.removeChild(ltd);

                        tagsInput.style.paddingLeft = (tagsCont.offsetWidth) + "px";

                        var tags = new Array();

                        for (var i = 0; i < tagsDom.length; i++) tags.push(tagsDom[i].innerHTML);
                        tagsList.value = tags.join(",");
                    }

                    return false;
                }
            }
        }
    }

}