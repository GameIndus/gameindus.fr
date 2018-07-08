<div class="galerie-container">
    <div class="search-bar-container">
        <div class="row-container">
            <form action="" method="POST" style="position:relative;top:-10px">
                <div class="form-introducing">Rechercher un jeu</div>

                <input type="text"<?= (!empty($d->search)) ? " value='{$d->search->search}'" : '' ?> name="search"
                       class="search-input" placeholder="Rechercher...">
                <select name="category" class="search-category-input">
                    <option value="all">Tous les types</option>
                    <?php foreach ($d->types as $k => $v): ?>
                        <option<?= (!empty($d->search) && $k == $d->search->category) ? " selected" : '' ?>
                                value="<?= $k ?>"><?= $v ?></option>
                    <?php endforeach ?>
                </select>

                <button type="submit" class="search-submit-button"><i class="fa fa-search"></i></button>

                <div class="clear"></div>
            </form>
        </div>
    </div>

    <?php $projects = (!empty($d->search)) ? $d->search->result : $d->defaultSearch; ?>

    <div class="row-container search-results-container">
        <?php foreach ($projects as $v): ?>
            <a href="<?= BASE . 'project/' . $v->id ?>" title="Voir le projet">
                <div class="search-result">
                    <div class="preview"
                         style="background-image:url(<?= BASE ?>project/preview/<?= $v->id ?>/232/163);"></div>
                    <div class="meta">
                        <span class="name"><?= $v->project_name ?></span>
                        <span class="authors"><?= $v->user_name ?></span>
                    </div>
                </div>
            </a>
        <?php endforeach ?>

        <div class="clear"></div>


        <div class="view-more">...</div>
    </div>

</div>