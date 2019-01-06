<div class="project-info-container" style="background-image:url(<?= BASE . trim($d->image, '/') ?>);height:250px">
    <div class="row-container">
        <div class="left">
            <div class="title"><?= $d->name ?></div>
            <?php if (!empty($d->users)): ?>
                <div class="authors">
                par
                <?php $i = 0;
                foreach ($d->users as $v): ?>
                    <?= '<img class="user-avatar" src="' . BASE . trim($v->avatar, '/') . '" alt="Avatar de ' . $v->username . '">' . (($i + 1 < count((array)$d->users)) ? $v->username . "," : $v->username) ?>
                    <?php $i++; endforeach ?>
                </div>
            <?php endif ?>
        </div>
        <div class="right">
            <div class="meta"<?= ((getUser()) ? ' style="margin-top:5px"' : "") ?>>Jeu <?= $d->engine; ?>
                , <?= $d->gameType ?>&nbsp;&nbsp;<i class="fa fa-gamepad" style="margin-right:-1px"></i></div>
            <div class="meta">Créé le <?= date("d/m/y", strtotime($d->date_created)); ?>&nbsp;&nbsp;<i
                        class="fa fa-calendar"></i></div>

            <?php if (getUser()): ?>
                <?php if (isMemberOfProject($d, getUser())): ?>
                    <a href="<?= BASE ?>project/<?= $d->id ?>/view" title="Accédez à l'espace projet">
                        <div class="meta btn-follow" style="border-color:#2980b9;background:#2980b9"><i
                                    class="fa fa-book"></i> Espace projet
                        </div>
                    </a>
                <?php else: ?>
                    <?php if (!$d->userFollow): ?>
                        <a href="<?= BASE ?>account/followproject/<?= $d->id ?>" title="Suivre ce projet">
                            <div class="meta btn-follow"><i class="fa fa-heart"></i> Suivre ce projet</div>
                        </a>
                    <?php else: ?>
                        <a href="<?= BASE ?>account/followproject/<?= $d->id ?>" title="Ne plus suivre ce projet">
                            <div class="meta btn-follow" style="width:180px"><i class="fa fa-times"></i> Ne plus suivre
                                ce projet
                            </div>
                        </a>
                    <?php endif; ?>

                    <?php if ($d->authorize_joins && !$d->currentRequest): ?>
                        <a href="<?= BASE ?>project/<?= $d->id ?>/useraction?a=uwj&uid=<?= getUser()->id ?>"
                           onclick="return confirm('Souhaitez-vous vraiment rejoindre le projet ?');"
                           title="J'aimerais rejoindre le projet">
                            <div class="meta btn-follow"
                                 style="border-color:#2980b9;background:#2980b9;margin-right:10px;width:160px"><i
                                        class="fa fa-briefcase"></i> Rejoindre le projet
                            </div>
                        </a>
                    <?php elseif ($d->currentRequest): ?>
                        <div class="meta btn-follow"
                             style="border-color:#2980b9;background:none;cursor:default;margin-right:10px;width:160px">
                            <i class="fa fa-check"></i> Demande envoyée
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="clear"></div>

        <div class="game-player" style="height:100px">
            <!-- <div class="overlay-button" onclick="playGame();return false;"><i class="fa fa-play"></i></div>

			<div class="canvas-container" style="display:none">
				<?php $_SESSION["last_game_id"] = $d->id; ?>
			</div> -->
            <h2 class="title" style="text-align:center;color:#CCC;padding-top:45px;font-size:1.3em"><i
                        class="fa fa-times" style="color:#e74c3c;padding-right:10px;font-size:1.3em"></i> Le jeu n'est
                pas disponible pour le moment.</h2>
        </div>
    </div>
</div>

<div class="project-view-container row-container">
    <div class="left-column" style="width:60%">
        <h3 class="parttitle">Descriptif du projet</h3>
        <p><?= stripslashes($d->description) ?></p>
    </div>
    <div class="right-column" style="width:30%">
        <h3 class="parttitle">Caractéristiques</h3>

        <div class="specifications">
            <div class="spec">
                <div class="col">Type de jeu</div>
                <div class="col"><?= $d->engine; ?></div>
            </div>
            <div class="spec">
                <div class="col">Catégorie de jeu</div>
                <div class="col" style="overflow:hidden"><?= $d->gameType; ?></div>
            </div>
            <div class="spec">
                <div class="col">Disponible sur</div>
                <div class="col">Web et PC</div>
            </div>
        </div>

        <br>

        <h3 class="parttitle">Téléchargements</h3>

        <blockquote class="error">
            <p><i class="fa fa-times"></i> Ce jeu n'est pas téléchargeable.</p>
        </blockquote>
    </div>

    <div class="clear"></div>

    <hr>

    <div class="left-column" style="width:95%" id="comments">
        <h3 class="parttitle"><?= count($d->comments); ?>
            commentaire<?php if (count($d->comments) > 1): echo "s"; endif; ?></h3>

        <?php if (getUser()): ?>
            <form method="POST" action="">
                <div class="input">
                    <label for="comment">Poster un commentaire</label>
                    <textarea name="comment" id="comment" placeholder="Ecrivez votre commentaire ici."></textarea>
                </div>
                <div class="input submit">
                    <input type="submit" value="Envoyer">
                </div>
            </form>
        <?php else: if (count($d->comments) == 0): ?>
            <p style="color:#A0A0A0"><i class="fa fa-long-arrow-right"></i> Connectez-vous pour en ajouter un.</p>
        <?php endif; endif; ?>

        <br>

        <?php foreach ($d->comments as $v): ?>
            <div class="comment">
                <div class="comment-avatar" style="background-image:url(/imgs/avatars/<?= $v->user_id ?>.jpg)"></div>
                <div class="comment-body">
                    <span class="comment-author"><?= $v->comment_username ?></span>, il y a <span
                            class="comment-date"><?= formatDate($v->date) ?></span>
                    <p class="comment-content"><?= $v->comment; ?></p>
                </div>

                <div class="clear"></div>
            </div>
        <?php endforeach ?>

    </div>

    <div class="clear"></div>

</div>
