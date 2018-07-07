window.onload = function () {

    /*
    *	NewAsset page
    */

    // Form submit
    if (document.getElementById("newAssetForm") != null) {
        document.getElementById("newAssetForm").onsubmit = function (e) {
            var form = this;

            e.preventDefault();
            if (df == undefined) return false;
            if (df.files.length == 0) return false;

            df.upload(0, function (obj) {
                if (typeof obj === "string") {
                    df.error(obj);
                    if (df.progressBar != null) df.progressBar.style.display = "none";
                    return false;
                }

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "filename";
                input.value = obj.name;
                form.appendChild(input);

                form.submit();
            });

            return false;
        }
    }

    // Type input
    if (document.getElementById("type") != null) {
        var lastType = document.getElementById("type").value;
        document.getElementById("type").onchange = function (e) {
            var val = this.value;
            var exts = [];

            if (df == undefined) return false;
            if (df.files.length > 0) {
                if (!confirm("Voulez-vous vraiment changer le type de ressource et supprimer le fichier envoyé ?")) {
                    e.preventDefault();
                    this.value = lastType;
                    return false;
                }
            }

            switch (val) {
                case "sprite":
                    exts = ["image/jpeg", "image/png", "image/gif"];
                    break;
                case "tilemap":
                    exts = ["image/jpeg", "image/png", "image/gif"];
                    break;
                case "sound":
                    exts = ["audio/mp3", "audio/wav", "audio/ogg"];
                    break;
                case "music":
                    exts = ["audio/mp3", "audio/wav", "audio/ogg"];
                    break;
            }

            df.clean();
            df.types = exts;

            lastType = val;
        }
    }

    // Tags input
    if (document.getElementById("tags") != null) {
        document.getElementById("tags").onkeydown = function (e) {
            var val = this.value;
            var tagsDiv = document.getElementById("tags-container");

            if (e.keyCode == 9) { // On ajout le tag (touche tab)
                if (val.length < 1) return true;
                if (val.indexOf(",") > -1) return false;

                this.value = "";

                var tag = document.createElement("div");
                tag.innerHTML = val;
                tag.className = "tag";
                tagsDiv.appendChild(tag);

                this.style.paddingLeft = (tagsDiv.offsetWidth + 2) + "px";
                reloadTagInput();

                return false;
            } else if (e.keyCode == 8) { // On supprime le dernier tag (touche suppr)
                if (val.length > 0) return true;
                var cn = tagsDiv.childNodes;
                var lastTag = cn[cn.length - 1];
                if (lastTag == null) return true;

                lastTag.parentNode.removeChild(lastTag);

                this.style.paddingLeft = (tagsDiv.offsetWidth + 2) + "px";
                reloadTagInput();

                return false;
            }
        }
    }

    // Categories (& sub!) inputs
    if (document.getElementById("category") != null) {
        document.getElementById("category").onchange = function () {
            var val = this.value;
            var sci = document.getElementById("subcategory");
            var opts = sci.getElementsByTagName("option");

            if (val == "undefined") {
                for (var i = 0; i < opts.length; i++) {
                    var opt = opts[i];
                    if (opt.value == "undefined") {
                        opt.innerHTML = "Choisissez d'abord une catégorie";
                        continue;
                    }
                    opt.style.display = "none";
                }

                sci.disabled = true;
                return true;
            }


            for (var i = 0; i < opts.length; i++) {
                var opt = opts[i];
                if (opt.value == "undefined") {
                    opt.innerHTML = "-- Choisissez une sous-catégorie --";
                    continue;
                }

                if (opt.dataset.category == val) opt.style.display = "block";
                else opt.style.display = "none";
            }

            sci.disabled = false;
        }
    }
}


function reloadTagInput() {
    var tagsDiv = document.getElementById("tags-container");
    var tagsInp = document.getElementById("tagslist");
    var cn = tagsDiv.childNodes;

    tagsInp.value = "";
    for (var i = 0; i < cn.length; i++) {
        var tag = cn[i];
        tagsInp.value += tag.innerHTML + ",";
    }

    tagsInp.value = tagsInp.value.substring(0, tagsInp.value.length - 1);
}

function reloadTagsFromInput() {
    var tagsDiv = document.getElementById("tags-container");
    var tagsInp = document.getElementById("tagslist");
    var tagsVIn = document.getElementById("tags");
    var cn = tagsDiv.childNodes;

    var tags = tagsInp.value.split(",");
    tagsVIn.value = "";

    for (var i = 0; i < tags.length; i++) {
        var tag = tags[i];

        var tagDom = document.createElement("div");
        tagDom.innerHTML = tag;
        tagDom.className = "tag";
        tagsDiv.appendChild(tagDom);

        tagsVIn.style.paddingLeft = (tagsDiv.offsetWidth + 2) + "px";
    }
}

// console.info("Tu aimerais voir comment le système fonctionne ? Rejoins notre équipe pour nous aider à construire le futur de GameIndus : https://gameindus.fr/about/jobs !");