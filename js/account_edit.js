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

    var form = document.getElementById("accountedit-form");
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        if (df.files.length > 0) {
            df.phpFile = "/core/ajax/saveAvatar.php";
            df.upload(0, function (json) {
                if (json.name != null && json.name.indexOf(".jpg") > -1) {
                    var hidden = document.createElement("input");

                    hidden.type = "hidden";
                    hidden.name = "avatarUpload";
                    hidden.value = "/imgs/avatars/" + json.name;

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

};
