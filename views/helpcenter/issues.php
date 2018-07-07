<div class="row-container issues-container">
    <h1 class="title" style="padding-top:20px">Support</h1>
    <h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">La liste des bogues rapportés</h3>

    <?php if (!getUser()): ?>
        <blockquote class="info">
            <p>
                Vous pouvez, vous aussi, participer au développement de la plateforme afin de rapporter des bogues et
                nous aider dans l'amélioration de cette dernière.
                Pour ce faire, vous pouvez commencer à vous inscrire ici: <a href="<?= BASE ?>inscription"
                                                                             title="Inscription">Inscription</a>.
            </p>
        </blockquote>
    <?php else: ?>
        <blockquote class="success">
            <p>
                Si vous souhaitez nous faire part d'un bogue/problème que vous avez découvert, n'hésitez pas.
                Cela nous permet d'améliorer sans cesse la plateforme et d'en faire outil personnalisé, sans que ce
                dernier soit rongé par les erreurs.<br>
                <b>Pour soumettre un bogue, c'est par ici : <a href="<?= BASE ?>helpcenter/submitissue"
                                                               title="Soumettre un bogue">Soumettre un bogue</a>.</b>
            </p>
        </blockquote>
    <?php endif; ?>


    <table class="flatTable">
        <tr class="title-line">
            <td class="titleTd"><?= $d->bugsNum; ?> bogues rapportés</td>
            <td colspan="4"></td>
        </tr>
        <tr class="heading-line">
            <td width="600">Description</td>
            <td>Image</td>
            <td width="250">Posteur</td>
            <td width="180">Posté il y a</td>
            <td width="180">Status</td>
        </tr>

        <?php foreach ($d->bugs as $v): $tags = explode(",", $v->tags); ?>
            <tr>
                <td>
                    <?= stripslashes($v->description) ?>

                    <?php if ($tags[0] != ""): ?>
                        <br>
                        <div class="tags-container">
                            <?php foreach ($tags as $w): ?>
                                <div class="tag"><?= $w ?></div>
                            <?php endforeach ?>
                        </div>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (file_exists("/home/gameindus/site/imgs/helpcenter/{$v->id}.jpg")): ?>
                        <a href="<?= BASE ?>imgs/helpcenter/<?= $v->id ?>.jpg" rel="nofollow" target="_BLANK"
                           title="Image du bug <?= $v->id ?>" style="color:#383838">
                            Voir
                        </a>
                    <?php else: ?>
                        <i class="fa fa-times" style="color:#AAA"></i>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="avatar" style="display:inline-block;float:left;top:5px;position:relative">
                        <img style="width:32px;height:32px;border-radius:50%" src="<?= $v->user->avatar ?>"
                             alt="Avatar de <?= $v->user->username ?>">
                    </div>
                    <span style="display:block;position:relative;top:10px;float:left;padding-left:15px"><?= $v->user->username ?></span>

                    <div class="clear"></div>
                </td>
                <td><?= formatDate($v->date); ?></td>
                <td>
                    <?php if ($v->status == 3): ?>
                        <span style="color:#27ae60"><i class="fa fa-check"></i> Résolu <br><small
                                    style="font-size:0.8em;color:#2ecc71">le <?= date("d/m/Y", strtotime($v->resolve_date)); ?></small></span>
                    <?php elseif ($v->status == 2): ?>
                        <span style="color:#c0392b"><i class="fa fa-times"></i> Non résolu</span>
                    <?php elseif ($v->status == 5): ?>
                        <span style="color:#A1A1A1"><i class="fa fa-circle"></i> En attente</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach ?>
    </table>


</div>