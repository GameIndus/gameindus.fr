<div class="slider-container market-slider-container">
    <div class="slide">
        <div class="hero" style="margin:60px 0">
            <p class="hero-1"></p>
            <p class="hero-2">Magasin de ressources</p>
            <p class="hero-3">par GameIndus</p>
            <p class="hero-4">Des ressources pour créer vos jeux vidéo</p>
        </div>
    </div>
</div>

<div class="primary-assets-container row-container">
    <div class="assets-bar-container">
        <div class="header-line">
            <span class="name">Top ressources</span>
        </div>
        <div class="sub-header-line">
            <span class="sub-name">Les 5 meilleures ressources</span>
        </div>

        <?php foreach ($d->popularAssets as $v): if ($v->rating == -1): $v->rating = 2.5; endif; ?>
            <a href="<?= BASE ?>asset/<?= nameToSlug($v->asset_id, $v->name); ?>" title="<?= $v->name ?>">
                <div class="asset-line">
                    <span class="title"><?= $v->name ?></span>
                    <span class="author">par Utarwyn</span>
                    <p class="desc">
                        <?= cutText($v->description, 50) ?>
                    </p>
                    <div class="rating">
                        <span class="likes"><i class="fa fa-heart"></i> <?= $v->likes ?></span>
                        <div class="rating-stars">
                            <?= ratingSystem($v->rating); ?>
                        </div>
                    </div>

                    <div class="preview"<?php if ($v->type != "music" && $v->type != "sound"): echo ' style="background:url(' . BASE . 'preview/' . $v->filename . ') center center no-repeat;background-size:cover;background-color:#ccc"'; endif; ?>></div>
                </div>
            </a>
        <?php endforeach ?>
    </div>

    <div class="assets-bar-container">
        <div class="header-line" style="background:#27ae60">
            <span class="name">Ressources de la semaine</span>
        </div>
        <div class="sub-header-line" style="background:#2ecc71">
            <span class="sub-name">Séléctionnées par l'équipe</span>
        </div>

        <?php foreach ($d->selectedAssets as $v): if ($v->rating == -1): $v->rating = 2.5; endif; ?>
            <a href="<?= BASE ?>asset/<?= nameToSlug($v->asset_id, $v->name); ?>" title="<?= $v->name ?>">
                <div class="asset-line">
                    <span class="title"><?= $v->name ?></span>
                    <span class="author">par <?= $v->user_name; ?></span>
                    <p class="desc">
                        <?= cutText($v->description, 50) ?>
                    </p>
                    <div class="rating">
                        <span class="likes"><i class="fa fa-heart"></i> <?= $v->likes ?></span>
                        <div class="rating-stars">
                            <?= ratingSystem($v->rating); ?>
                        </div>
                    </div>

                    <div class="preview"<?php if ($v->type != "music" && $v->type != "sound"): echo ' style="background:url(' . BASE . 'preview/' . $v->filename . ') center center no-repeat;background-size:cover;background-color:#ccc"'; endif; ?>></div>
                </div>
            </a>
        <?php endforeach ?>
        <?php if (count($d->selectedAssets) == 0): ?>
            <div class="asset-line disable" style="padding:0">
                <span class="title" style="text-align:center;line-height:120px;color:#9A9A9A"><i
                            class="fa fa-times"></i> Aucune ressource.</span>
            </div>
        <?php endif; ?>
    </div>
    <div class="assets-bar-container">
        <div class="header-line" style="background:#2980b9">
            <span class="name">Top ressources Premium</span>
        </div>
        <div class="sub-header-line" style="background:#3498db">
            <span class="sub-name">Les 5 meilleures ressources Premium</span>
        </div>

        <div class="asset-line disable" style="padding:0">
            <span class="title" style="text-align:center;line-height:120px;color:#9A9A9A"><i class="fa fa-times"></i> Aucune ressource.</span>
        </div>
    </div>
    <div class="clear"></div>
</div>

<div class="secondary-assets-container row-container">
    <div class="categories-container">
        <div class="left">
            <div class="title">Catégories</div>
            <p class="presentation">
                Ci-contre, plusieurs catégories aléatoires vous sont présentées. Ces différentes catégories sont
                elles-mêmes inclues dans des grandes sections pour optimiser votre temps de recherche.
            </p>
            <br><br>
            <a href="<?= BASE ?>categories" title="En voir plus >">
                <div class="btn btn-success btn-more">En voir plus &nbsp;&nbsp;<i class="fa fa-long-arrow-right"></i>
                </div>
            </a>
        </div>
        <div class="right">
            <div class="categories-list-container">
                <div class="category-container">
                    <div class="preview"></div>
                    <span class="name">Texture de plateforme</span>
                </div>
                <div class="category-container">
                    <div class="preview"></div>
                    <span class="name">Construction</span>
                </div>
                <div class="category-container">
                    <div class="preview"></div>
                    <span class="name">Musique de monde</span>
                </div>
                <div class="category-container">
                    <div class="preview"></div>
                    <span class="name">Musique éléctronique</span>
                </div>
                <div class="category-container">
                    <div class="preview"></div>
                    <span class="name">Son Sci-Fi</span>
                </div>
                <div class="category-container">
                    <div class="preview"></div>
                    <span class="name">Bruit</span>
                </div>
                <div class="category-container">
                    <div class="preview"></div>
                    <span class="name">Personnage</span>
                </div>
                <div class="category-container">
                    <div class="preview"></div>
                    <span class="name">Objet</span>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>