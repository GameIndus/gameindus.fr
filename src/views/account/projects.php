<div class="account-container">
    <div class="user-menu-container">
        <?php include "views/account/user-menu.php"; ?>
    </div>

    <div class="user-account-container row-container">
        <h1 class="title" style="font-size:2em">Mes jeux</h1>
        <h3 class="subtitle" style="font-size:1.2em;margin-top:-15px">Tous les projets auxquels je participe</h3>

        <div class="games-container">
            <div class="user-games">
                <?php foreach ($d->projects as $v): ?>
                    <div class="user-game">
                        <div class="preview"
                             style="background-image:url(<?= BASE ?>project/preview/<?= $v->id ?>/232/163)"></div>
                        <div class="meta">
                            <div class="infos">
                                <span class="name"><?= $v->name ?></span>
                                <span class="author">par <?= $v->users_str ?></span>
                            </div>
                            <div class="actions">
                                <?php if ($v->owner_id == getUser()->id): ?>
                                    <a href="<?= BASE ?>project/<?= $v->id ?>/view"
                                       title="Accéder au projet <?= $v->name ?>">
                                        <div class="action"><i class="fa fa-eye"></i></div>
                                    </a>
                                    <a href="<?= BASE ?>project/<?= $v->id ?>/editor"
                                       title="Modifier le projet <?= $v->name ?>">
                                        <div class="action"><i class="fa fa-magic"></i></div>
                                    </a>
                                    <a href="<?= BASE ?>project/<?= $v->id ?>/delete"
                                       title="Supprimer le projet <?= $v->name; ?>"
                                       onclick="return confirm('Voulez-vous vraiment supprimer ce projet ? Toute supression est définitive !');">
                                        <div class="action"><i class="fa fa-trash-o"></i></div>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= BASE ?>project/<?= $v->id ?>/view"
                                       title="Accéder au projet <?= $v->name ?>">
                                        <div class="action" style="width:50%"><i class="fa fa-eye"></i></div>
                                    </a>
                                    <a href="<?= BASE ?>project/<?= $v->id ?>/editor"
                                       title="Modifier le projet <?= $v->name ?>">
                                        <div class="action" style="width:50%"><i class="fa fa-magic"></i></div>
                                    </a>
                                <?php endif; ?>

                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>

                <div class="clear"></div>
            </div>
        </div>

        <div class="clear"></div>
        <br>

        <a href="<?= BASE ?>project/create" title="Créer un nouveau projet">
            <div class="btn btn-success" style="width:220px;font-size:0.9em"><i class="fa fa-plus"></i> Créer un nouveau
                projet
            </div>
        </a>

    </div>

    <div class="clear"></div>
</div>