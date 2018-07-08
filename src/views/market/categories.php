<div class="categories-list-container row-container">
    <?php foreach ($d->categories as $v): ?>
        <div class="category-list">
            <div class="left">
                <div class="title"><?= $v->name ?></div>
            </div>

            <div class="right">
                <?php foreach ($v->subcategories as $w): ?>
                    <a href="<?= BASE ?>subcategory/<?= $w->id ?>" title="<?= $w->name ?>">
                        <div class="subcategory-container">
                            <div class="preview"></div>
                            <span class="name"><?= $w->name ?></span>
                        </div>
                    </a>
                <?php endforeach ?>
                <?php if (count($v->subcategories) == 0): ?>
                    <h3 class="subtitle" style="font-size:1.6em;margin-top:30px">Aucune sous-catégorie.</h3>
                <?php endif; ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    <?php endforeach ?>
</div>