<div class="account-container">
    <div class="user-menu-container">
        <?php include "views/account/user-menu.php"; ?>
    </div>

    <div class="user-account-container row-container">
        <h1 class="title" style="font-size:2em">Poster une ressource</h1>
        <h3 class="subtitle" style="font-size:1.2em;margin-top:-15px">Privilège <span
                    style="color:#EDC951;font-weight:bold"><i class="fa fa-star"></i> Premium</span></h3>

        <?php getNotif(); ?>


        <h3 style="font-family:HeroRegular;font-size:1.6em;color:#383838">Informations générales</h3>

        <form method="POST" action="" id="newAssetForm">
            <div class="left" style="float:left;position:relative;width:45%;margin-right:5%">
                <div class="input">
                    <label for="name">Nom</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Nom" required
                           style="width:100%" autocomplete="off">
                </div>
                <div class="input">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" placeholder="Description"
                              style="height:100px;max-height:200px;max-width:100%"></textarea>
                </div>
                <div class="input">
                    <label for="type">Type</label>
                    <select name="type" id="type">
                        <option value="sprite">Image animée</option>
                        <option value="tilemap">Tilemap</option>
                        <option value="sound">Son</option>
                        <option value="music">Musique</option>
                    </select>
                </div>
                <div class="input" style="position:relative">
                    <label for="tags">Tags</label>
                    <input type="text" class="input-tags" id="tags" placeholder="Ajouter un tag" style="width:100%"
                           autocomplete="off">
                    <div id="tags-container"></div>
                    <input type="hidden" id="tagslist" name="tags" value="">
                </div>
            </div>
            <div class="right" style="float:left;position:relative;width:50%">
                <div class="input">
                    <label for="category">Catégorie</label>
                    <select name="category" id="category">
                        <option value="undefined">-- Choisissez une catégorie --</option>
                        <?php foreach ($d->categories as $v): ?>
                            <option value="<?= $v->id ?>"><?= $v->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="input">
                    <label for="subcategory">Sous-catégorie</label>
                    <select name="subcategory" id="subcategory" disabled>
                        <option value="undefined">Choisissez d'abord une catégorie</option>
                        <?php foreach ($d->subcategories as $v): ?>
                            <option value="<?= $v->id ?>" data-category="<?= $v->assets_category_id; ?>"
                                    style="display:none"><?= $v->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="clear"></div>


            <h3 style="font-family:HeroRegular;font-size:1.6em;color:#383838;margin-top:20px">Dépôt de la ressource</h3>
            <div class="dropzone" id="dropfile"></div>

            <br><br>

            <blockquote>
                <p><i class="fa fa-warning"></i> En postant cette ressource, vous acceptez les conditions générales
                    d'utilisation disponible <a href="https://gameindus.fr/about/conditions" target="_blank"
                                                title="Conditions générales d'utilisation">ici</a>.</p>
            </blockquote>

            <button type="submit" class="btn btn-success" style="float:left"><i class="fa fa-cloud-upload"></i> Poster
                la ressource
            </button>
            <div id="progress-bar-container">
                <div class="progress-bar"></div>
                <div class="progress-bar-perc"></div>
            </div>

            <div class="clear"></div>

        </form>

    </div>
</div>

<script src="/js/tinymce/tinymce.js"></script>
<script>tinymce.init({selector: 'textarea', language: 'fr_FR'});</script>