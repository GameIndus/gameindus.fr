/*
* GameIndus - A free online platform to imagine, create and publish your game with ease!
*
* GameIndus website
* Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
* <https://github.com/GameIndus/gameindus.fr>
*/

window.onload = function () {

    var bs = document.getElementById('websitebase').value;
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

    var form = document.getElementById("projectedit-form");
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        if (df.files.length > 0) {
            df.phpFile = bs + "core/ajax/saveProjectImage.php";
            df.upload(0, function (json) {
                if (json.name != null && json.name.indexOf(".jpg") > -1) {
                    var hidden = document.createElement("input");

                    hidden.type = "hidden";
                    hidden.name = "imageUpload";
                    hidden.value = bs + "imgs/projects/" + json.name;

                    form.appendChild(hidden);

                    form.submit();
                } else {
                    if (json.error) {
                        alert("Erreur: " + json.error);
                        return false;
                    } else {
                        alert("Erreur inconnue. Merci de réessayer plus tard.");
                        return false;
                    }
                }
            });
        } else {
            form.submit();
        }

        return false;
    });


    var removeButton = document.getElementById("remove-image-button");
    if (removeButton != null) {
        removeButton.onclick = function () {
            if (!confirm('Voulez-vous vraiment supprimer l\'image du projet ? Toute suppression est définitive.')) return false;

            var xhr = new XMLHttpRequest();

            xhr.onload = function (e) {
                removeButton.parentNode.removeChild(removeButton);
                document.getElementById("project-image").src = bs + "imgs/projects/unknown.png";
                document.querySelector(".project-info-container").style.backgroundImage = "url(" + bs + "imgs/projects/unknown.png)";
            };

            xhr.open("POST", bs + "core/ajax/saveProjectImage.php", true);
            xhr.setRequestHeader("content-type", "multiport/form-data");
            xhr.setRequestHeader("x-file-type", false);
            xhr.setRequestHeader("x-file-size", false);
            xhr.setRequestHeader("x-file-name", false);
            xhr.send(null);
        }
    }
};
