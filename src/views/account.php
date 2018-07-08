<div class="account-container">
    <div class="user-menu-container">
        <?php include "account/user-menu.php"; ?>
    </div>

    <div class="user-account-container row-container" style="min-height:320px">
        <h1 class="title">Mes derniers jeux</h1>

        <div class="games-container">
            <div class="user-games">
                <?php foreach ($d->projects as $v): ?>
                    <div class="user-game">
                        <div class="preview"
                             style="background-image:url(<?= BASE ?>project/preview/<?= $v->id ?>/232/163)"></div>
                        <div class="meta">
                            <div class="infos">
                                <span class="name"><?= $v->name ?></span>
                                <span class="author">initié le <?= date("d/m/Y", strtotime($v->date_created)); ?></span>
                            </div>
                            <div class="actions">
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
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>

                <a href="<?= BASE ?>project/create" title="Créer un nouveau jeu">
                    <div class="user-game empty-game">
                        <i class="fa fa-plus"></i>
                        <p>Cliquez pour créer un nouveau jeu</p>
                    </div>
                </a>

                <div class="clear"></div>
            </div>
        </div>
    </div>

    <hr>

    <div class="user-account-container row-container" style="margin:0 auto">
        <div class="left-column">
            <?php if (isPremium($d)): ?>
                <h1 class="title left">Vous êtes premium <i class="fa fa-smile-o"></i> !</h1>

                <div style="margin-left:25px">
                    <p>
                        Merci de votre confiance.
                        Il vous reste <b><?= simpleFormatDate(remainingTimePremium($d)); ?></b> d'abonnement.
                        <br>Prend fin le <i><?= date("d/m/Y à H:i", strtotime($d->premium_finish_date)); ?></i>.
                    </p>
                    <br>

                    <a href="<?= BASE ?>premium/renew" title="Renouveller mon abonnement">
                        <div class="btn btn-success"
                             style="width:252px;float:left;text-align:center;border-radius:5px 0 0 5px;border-right:2px solid #27ae60">
                            <i class="fa fa-check"></i> Renouveller mon compte
                        </div>
                    </a>
                    <a href="<?= BASE ?>premium/orders" title="Mes commandes">
                        <div class="btn btn-danger"
                             style="width:200px;float:left;text-align:center;border-radius:0 5px 5px 0;border-left:2px solid #c0392b">
                            <i class="fa fa-list"></i> Mes commandes
                        </div>
                    </a>
                </div>
            <?php else: ?>
                <h1 class="title left">Vous n'êtes pas premium <i class="fa fa-frown-o"></i></h1>

                <a href="<?= BASE ?>premium" title="Souscrire à un abonnement premium">
                    <div class="btn btn-warning" style="width:320px;text-align:center;margin-left:25px"><i
                                class="fa fa-star"></i> Devenir premium dès maintenant
                    </div>
                </a>
                <br>
                <div class="btn btn-success" id="premiumwheel-trigger"
                     style="width:350px;text-align:center;margin-left:25px"><i class="fa fa-circle-o"></i> Tentez de le
                    devenir en lançant la roue
                </div>

                <div id="modal-wheel-container" data-process-url="<?= BASE ?>account/wheelprocess"
                     <?php if ($d->todayWheelTrial != null): ?>data-jsondata='<?= json_encode((object)$d->todayWheelTrial); ?>'<?php endif; ?>>
                    <div class="modal-container">
                        <div class="modal-header">
                            <div class="close">x</div>
                            <div class="hero-1">Roue de la chance</div>
                            <p>Tentez de remporter un grade Premium sur le site pour <b>1 mois</b> en tournant cette
                                roue <b>une fois par jour</b> ! Bonne chance !</p>
                        </div>
                        <div class="content-container">
                            <div class="wheel-container" style="margin:20px auto;width:400px;height:400px">
                                <div id="wheel">
                                    <div id="inner-wheel">
                                        <div class="sec"><span class="fa fa-times"></span></div>
                                        <div class="sec"><span class="fa fa-times"></span></div>
                                        <div class="sec"><span class="fa fa-times"></span></div>
                                        <div class="sec"><span class="fa fa-times"></span></div>
                                        <div class="sec"><span class="fa fa-times"></span></div>
                                        <div class="sec"><span class="fa fa-star"></span></div>
                                    </div>

                                    <div id="spin">
                                        <div id="inner-spin"></div>
                                    </div>

                                    <div id="shine"></div>
                                </div>
                            </div>
                            <div class="bubble">
                                Cliquez ici pour lancer la roue
                            </div>
                            <div class="wheel-result">
                                <span class="hero-1"></span>
                                <span class="text"></span>

                                <div class="btn btn-danger close-button">Fermer</div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <br><br><br><br>

            <h1 class="title left">Inviter un ami</h1>
            <p>
                GameIndus évolue sans cesse et devient de plus en plus stable. C'est pourquoi nous vous offrons la
                possibilité d'inviter un de vos amis pour tester notre plateforme, gratuitement !
                <br>

                <?php if (!getUser()->friend_key_activated): ?>
                    <b>Pour cela, il vous suffit de générer une clé grâce au bouton ci-dessous et de lui envoyer.</b>
                <?php else: ?>
                    <b>Vous avez déjà généré une clé. Vous pouvez l'afficher en cliquant sur le bouton ci-dessous.</b>
                <?php endif; ?>
            </p>

            <br>
            <?php if (!getUser()->friend_key_activated): ?>
                <a href="<?= BASE ?>account/generatefriendkey" title="Générer une clé pour un ami">
                    <div class="btn btn-success" style="width:280px;text-align:center;margin-left:25px"><i
                                class="fa fa-user"></i> Générer une clé pour un ami
                    </div>
                </a>
            <?php else: ?>
                <div class="input" style="margin:0">
                    <div class="btn btn-small"
                         style="width:100px;float:left;text-align:center;margin-left:25px;border-radius:5px 0 0 5px"
                         onclick="document.getElementById('friendKey').value='<?= $d->friend_key; ?>';"><i
                                class="fa fa-eye"></i> Afficher
                    </div>
                    <input type="text" id="friendKey"
                           style="height:30px;line-height:30px;width:250px;float:left;border-radius:0 5px 5px 0;margin:0"
                           readonly value="XXXX-XXXX-XXXX-XXXX"></input>

                    <div class="clear"></div>
                </div>
            <?php endif; ?>

        </div>
        <div class="right-column">
            <h1 class="title left">Les projets que je suis</h1>

            <div class="small-table">
                <div class="heading-line">
                    <span style="width:50%">Nom</span>
                    <span style="width:50%">Auteur</span>
                </div>
                <?php if (count($d->projectsFollowed) == 0): ?>
                    <div class="content-line">
                        <span><i class="fa fa-times"></i> Aucun projet suivi</span>
                    </div>
                <?php else: ?>
                    <?php foreach ($d->projectsFollowed as $v): ?>
                        <div class="content-line">
                            <span style="width:50%"><a href="<?= BASE ?>project/<?= $v->projectid ?>"
                                                       title="<?= $v->projectname ?>"
                                                       style="color:#383838"><?= $v->projectname; ?></a></span>
                            <span style="width:50%"><img src="<?= $v->avatar ?>"
                                                         style="position:relative;top:6px;border-radius:50%;width:24px;height:24px"
                                                         alt="Avatar de <?= $v->username ?>"> <?= $v->username; ?></span>
                        </div>
                    <?php endforeach ?>
                <?php endif; ?>
            </div>

            <br>
            <!-- <div class="btn" style="width:300px;text-align:center;float:right"><i class="fa fa-list"></i> Voir tous les projets que je suis</div> -->
            <div class="clear"></div>
        </div>

        <div class="clear"></div>
    </div>

    <div class="clear"></div>
</div>

<script src="<?= BASE ?>js/classes/jscookie.js" type="text/javascript" defer></script>
<script src="<?= BASE ?>js/account_premiumwheel.js" type="text/javascript" defer></script>