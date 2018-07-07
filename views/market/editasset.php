<div class="account-container">
    <div class="user-menu-container">
        <?php include "views/account/user-menu.php"; ?>
    </div>

    <div class="user-account-container row-container">
        <h1 class="title" style="font-size:2em">Editer une ressource</h1>
        <h3 class="subtitle" style="font-size:1.2em;margin-top:-15px">Edition de "<?= $d->asset->name ?>"</h3>

        <?php getNotif(); ?>


        <h3 style="font-family:HeroRegular;font-size:1.6em;color:#383838">Informations générales</h3>

        <form method="POST" action="" id="editAssetForm">
            <div class="left" style="float:left;position:relative;width:45%;margin-right:5%">
                <div class="input">
                    <label for="name">Nom</label>
                    <input type="text" name="name" id="name" placeholder="Nom" value="<?= $d->asset->name; ?>" required
                           style="width:100%" autocomplete="off">
                </div>
                <div class="input">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" placeholder="Description"
                              style="height:100px;max-height:200px;max-width:100%"><?= $d->asset->description; ?></textarea>
                </div>
                <div class="input" style="position:relative">
                    <label for="tags">Tags</label>
                    <input type="text" class="input-tags" id="tags" placeholder="Ajouter un tag" style="width:100%"
                           autocomplete="off">
                    <div id="tags-container"></div>
                    <input type="hidden" id="tagslist" name="tags" value="<?= $d->asset->tags ?>">
                </div>
            </div>

            <div class="right" style="float:left;position:relative;width:50%">
                <div class="input">
                    <label for="category">Catégorie</label>
                    <select name="category" id="category">
                        <option value="undefined">-- Choisissez une catégorie --</option>
                        <?php foreach ($d->asset->categories as $v): ?>
                            <option value="<?= $v->id ?>"<?php if ($v->id == $d->asset->category_id): echo ' selected'; endif; ?>><?= $v->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="input">
                    <label for="subcategory">Sous-catégorie</label>
                    <select name="subcategory" id="subcategory" disabled>
                        <option value="undefined">Choisissez d'abord une catégorie</option>
                        <?php foreach ($d->asset->subcategories as $v): ?>
                            <option value="<?= $v->id ?>" data-category="<?= $v->assets_category_id; ?>"
                                    style="display:none"><?= $v->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="clear"></div>

            <button type="submit" class="btn btn-success" style="float:right"><i class="fa fa-cloud-upload"></i> Mettre
                à jour
            </button>

            <div class="clear"></div>
        </form>
    </div>
</div>

<script type="text/javascript">
    window.addEventListener("load", function () {
        reloadTagsFromInput();

        // Reload categories
        setTimeout(function () {
            if ("createEvent" in document) {
                var evt = document.createEvent("HTMLEvents");
                evt.initEvent("change", false, true);
                document.getElementById("category").dispatchEvent(evt);
            } else {
                document.getElementById("category").fireEvent("onchange");
            }

            // Select good option
            var opts = document.getElementById("subcategory").querySelectorAll("option");
            for (var i = 0; i < opts.length; i++) {
                var opt = opts[i];
                if (opt.value == <?= $d->asset->subcategory_id; ?>) {
                    opt.selected = true;
                    break;
                }
            }
        }, 20);
    });
</script>
<script src="/js/tinymce/tinymce.js"></script>
<script>tinymce.init({selector: 'textarea', language: 'fr_FR'});</script>