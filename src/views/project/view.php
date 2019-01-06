<div class="project-container">
    <div class="project-menu-container">
        <?php include SRC . "/views/project/project-menu.php"; ?>
    </div>

    <div class="project-content-container row-container">
        <div class="left-column form-container">
            <h3 class="subtitle"
                style="font-size:1.4em;text-align:left;font-weight:bold;font-family:'Open Sans',Helvetica,Arial">
                Informations générales</h3>
            <br>

            <p style="font-size:1.2em">Image</p>
            <img src="<?= BASE . trim($d->project->image, '/') ?>" width="60%" style="margin:10px">
            <br>

            <p style="font-size:1.2em">Description</p>
            <p style="margin:10px"><?= stripslashes($d->project->description) ?></p>
            <br>

            <p style="font-size:1.2em">Type de jeu</p>
            <p style="margin:10px"><?= $d->project->engine ?> / <?= $d->project->gameType ?></p>
            <br>

            <p style="font-size:1.2em">Date de création</p>
            <p style="margin:10px">Le <?= date("d/m/Y", strtotime($d->project->date_created)); ?></p>
            <br>
        </div>

        <div class="right-column form-container">
            <h3 class="subtitle"
                style="font-size:1.4em;text-align:left;font-weight:bold;font-family:'Open Sans',Helvetica,Arial">
                Statistiques du projet</h3>
            <br>

            <p style="font-size:1.2em">Note de la communauté</p>
            <?php $note = ($d->project->note == -1) ? 2.5 : $d->project->note; ?>
            <p style="margin:10px;color:#f1c40f;font-weight:bold">
                <?= ratingSystem($note); ?>&nbsp;&nbsp;<?= $note ?>
            </p>
            <br>

            <p style="font-size:1.2em">Appréciation du public</p>
            <p style="margin:10px;color:#c0392b;font-weight:bold"><i
                        class="fa fa-heart"></i>&nbsp;&nbsp;<?= $d->project->likes ?></p>
            <br>
        </div>

        <div class="clear"></div>
    </div>

    <div class="clear"></div>
</div>
