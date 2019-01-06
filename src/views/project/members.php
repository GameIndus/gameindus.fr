<div class="project-container">
    <div class="project-menu-container">
        <?php include SRC . "/views/project/project-menu.php"; ?>
    </div>

    <div class="project-content-container row-container">
        <div class="left-column form-container" style="width:60%">
            <h3 class="subtitle"
                style="font-size:1.4em;text-align:left;font-weight:bold;font-family:'Open Sans',Helvetica,Arial">Membres
                du projet</h3>

            <table class="project-users">
                <tr class="heading-line"
                    style="background:#323232;font-family:'Open Sans',Helvetica,Arial,sans-serif;font-size:0.9em;text-transform:uppercase">
                    <td>Pseudonyme</td>
                    <td>Grade</td>
                    <td style="width:230px">Actions</td>
                </tr>
                <?php foreach ($d->users as $v): ?>
                    <tr class="project-users-content">
                        <td><?= $v->username; ?></td>
                        <td><?= (memberIsOwner($d->project, $v)) ? "Chef de projet" : ((memberIsAdmin($d->project, $v)) ? "Administrateur" : "Membre") ?></td>
                        <td style="position:relative;display:block;padding:0;width:230px;height:50px;padding-left:30px;overflow:hidden">
                            <?php if ($v->id != getUser()->id): ?>
                                <a href="#" onclick="alert('Cette fonctionnalité arrive prochainement !');return false;"
                                   title="Envoyer un message">
                                    <div class="project-user-action"><i class="fa fa-envelope"></i></div>
                                </a>
                            <?php endif; ?>
                            <?php if (memberIsOwner($d->project, getUser()) && memberIsAdmin($d->project, $v) && !memberIsOwner($d->project, $v)): ?>
                                <a href="<?= BASE ?>project/<?= $d->project->id ?>/useraction?a=uto&uid=<?= $v->id ?>"
                                   onclick="return confirm('Voulez-vous vraiment effectuer cette action ?');"
                                   title="Passer chef de projet">
                                    <div class="project-user-action"><i class="fa fa-trophy"></i></div>
                                </a>
                            <?php endif; ?>
                            <?php if ($v->id != getUser()->id && (!memberIsAdmin($d->project, $v) && !memberIsOwner($d->project, $v))): ?>
                                <a href="<?= BASE ?>project/<?= $d->project->id ?>/useraction?a=uta&uid=<?= $v->id ?>"
                                   onclick="return confirm('Voulez-vous vraiment effectuer cette action ?');"
                                   title="Passer administrateur">
                                    <div class="project-user-action"><i class="fa fa-level-up"></i></div>
                                </a>
                            <?php elseif ($v->id != getUser()->id && (memberIsAdmin($d->project, $v) && !memberIsOwner($d->project, $v))): ?>
                                <a href="<?= BASE ?>project/<?= $d->project->id ?>/useraction?a=dtm&uid=<?= $v->id ?>"
                                   onclick="return confirm('Voulez-vous vraiment effectuer cette action ?');"
                                   title="Passer membre">
                                    <div class="project-user-action"><i class="fa fa-level-down"></i></div>
                                </a>
                            <?php endif; ?>
                            <?php if ($v->id != getUser()->id && !memberIsOwner($d->project, $v)): ?>
                                <a href="<?= BASE ?>project/<?= $d->project->id ?>/useraction?a=eu&uid=<?= $v->id ?>"
                                   onclick="return confirm('Voulez-vous vraiment effectuer cette action ?');"
                                   title="Exclure du projet">
                                    <div class="project-user-action"><i class="fa fa-sign-out"></i></div>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>

        <div class="right-column form-container" style="width:30%">
            <h3 class="subtitle"
                style="font-size:1.4em;text-align:left;font-weight:bold;font-family:'Open Sans',Helvetica,Arial">
                Demandes reçues (<?= count($d->requests) ?>)</h3>

            <table class="project-requests-content"
                   style="margin-top:23px;min-width:0;border-collapse:separate;border-spacing:0 1em;">
                <?php if (!$d->project->authorize_joins): $d->requests = array(); endif; ?>

                <?php foreach ($d->requests as $v): ?>
                    <tr class="project-requests-content" style="margin-bottom:5px;background:#fff">
                        <td style="padding:0;position:relative;">
                            <div style="display:block;position:relative;width:100%;height:67px;padding:10px;padding-left:74px">
                                <img src="<?= $v->avatar ?>" width="64" height="64"
                                     style="position:absolute;left:0;top:0" alt="Avatar de <?= $v->username ?>">
                                <span style="font-size:1.3em"><?= $v->username; ?></span>
                                <br>
                                <span style="font-weight:normal">souhaite rejoindre le projet.</span>
                            </div>
                            <div style="display:block;position:relative;width:100%;height:40px;background:#eee;line-height:40px;padding:0 10px">
                                <?php if (memberIsAdmin($d->project, getUser())): ?>
                                    Votre réponse :
                                    <a href="<?= BASE ?>project/<?= $d->project->id ?>/useraction?a=rur&uid=<?= $v->user_id; ?>"
                                       title="Refuser la demande">
                                        <div style="display:block;position:relative;float:right;height:40px;width:40px;text-align:center;background:#e74c3c;color:white">
                                            <i class="fa fa-times"></i>
                                        </div>
                                    </a>
                                    <a href="<?= BASE ?>project/<?= $d->project->id ?>/useraction?a=aur&uid=<?= $v->user_id; ?>"
                                       title="Accepter la demande">
                                        <div style="display:block;position:relative;float:right;height:40px;width:40px;text-align:center;background:#2ecc71;color:white">
                                            <i class="fa fa-check"></i>
                                        </div>
                                    </a>
                                <?php else: ?>
                                    <i class="fa fa-long-arrow-right"></i> En attente d'une réponse.
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>

                <?php if (count($d->requests) == 0): ?>
                    <tr class="project-requests-content" style="margin-bottom:5px;background:#fff">
                        <td style="padding:0;position:relative;">
                            <div style="display:block;position:relative;width:100%;height:67px;text-align:center;line-height:67px">
                                <span style="font-weight:normal;font-size:1.2em">Aucune requête à traiter.</span>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>

            </table>

            <?php if (!$d->project->public && $d->project->authorize_joins): ?>
                <h3 class="subtitle"
                    style="font-size:1.4em;text-align:left;font-weight:bold;font-family:'Open Sans',Helvetica,Arial">
                    Lien à envoyer pour les demandes</h3>

                <div class="input">
                    <input onclick="this.setSelectionRange(0,this.value.length);document.execCommand('copy');"
                           type="text" name="request-link"
                           value="https://gameindus.fr/project/<?= $d->project->id ?>/useraction?a=rlink&uid=<?= $d->project->id ?>&hash=<?= md5($d->project->name) ?>"
                           readonly="true">
                </div>
            <?php endif; ?>
        </div>

        <div class="clear"></div>
    </div>

    <div class="clear"></div>
</div>
