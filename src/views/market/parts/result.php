<div class="result">
    <div class="preview" style="
    <?php if($v->category_name == "Audio" || $v->category_name == "Musique"): ?>
			background-image:url(https://placeholdit.imgix.net/~text?txtsize=24&txt=Fichier%20audio&w=500&h=300)
		<?php else: ?>
			background-image:url(https://market.gameindus.fr/preview/<?= $v->filename; ?>)
		<?php endif; ?>
            ">
    </div>
    <div class="right">
        <a href="/asset/<?= nameToSlug($v->asset_id, $v->name); ?>" title="Accéder à la ressource '<?= $v->name; ?>' >">
            <div class="title"><?= $v->name; ?></div>
        </a>
        <div class="tags">
            <?php foreach (explode(",", $v->tags) as $w): ?>
                <a href="/tag/<?= $w ?>" title="<?= $w ?>">
                    <div class="tag"><?= $w ?></div>
                </a>
            <?php endforeach ?>
        </div>

        <p class="description"><?= $v->description; ?></p>

        <?php if ($v->rating == -1) $v->rating = 2.5; ?>

        <div class="meta-bar">
            <span>Publiée le <b><?= date("d/m/Y", strtotime($v->publish_date)); ?></b></span>
            <span style="color:#c0392b"><i class="fa fa-heart"></i> <b><?= $v->likes ?></b></span>
            <span style="color:#2980b9"><?= ratingSystem($v->rating) ?></span>
            <span>Catégorie: <b><?= $v->category_name; ?></b></span>
            <span>Auteur: <b><?= $v->user_name ?></b></span>
        </div>
    </div>
</div>