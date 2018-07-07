<div class="row-container premium-container">
    <h1 class="title" style="padding-top:20px">Devenir premium</h1>
    <h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">Et accédez à des fonctionnalités en plus !</h3>

    <div style="margin:20px 10%">
        <p>
            Si GameIndus laisse une grande majorité de la plateforme accessible à tous, c'est pour offrir à tout le
            monde la possibilité de créer facilement son jeu vidéo en ligne. Néanmoins l'ensemble de l'infrastructure de
            GameIndus à un coût, et c'est pourquoi nous vous donnons la possibilité de nous aider, tout en ayant
            certaines fonctionnalités supplémentaires. <br><br>
            <!-- Notre service <b>multijoueur</b> est uniquement disponible pour les membres premiums pour des raisons économiques : une grande partie de notre infrastructure est réservée aux serveurs multijoueurs et il ne serait donc pas rentable pour nous de rendre ce service disponible pour tous. -->
        </p>

        <blockquote class="warning">
            <p><i class="fa fa-warning"></i> Les services <b>multijoueur</b> et <b>exportation de jeu sur mobile</b>
                sont pour le moment <b>indisponibles</b>.</p>
        </blockquote>

        <br><br>

        <h4 class="section-title" style="font-size:1.6em">Nos offres</h4>
        <br><br>

        <div class="offers-table">
            <div class="offers-header">
                <div class="col">
                    <span class="name">Classique</span>
                    <span class="price">00,00<small>€ HT</small></span>
                    <span class="sub-price">/par mois</span>
                </div>
                <div class="col highlight">
                    <span class="name"><i class="fa fa-star"></i> Premium</span>
                    <span class="price">01,99<small>€ HT</small></span>
                    <span class="sub-price">/par mois</span>
                </div>
            </div>
            <div class="clear"></div>

            <div class="offers-content">
                <div class="col">
                    <div class="offer-line"><i class="fa fa-check"></i> Création gratuite de jeux vidéo</div>
                    <div class="offer-line"><i class="fa fa-check"></i> Accès complet à l'éditeur</div>
                    <div class="offer-line"><i class="fa fa-times"></i> Création de jeux multijoueurs</div>
                    <div class="offer-line"><i class="fa fa-times"></i> Accès complet au magasin</div>
                    <div class="offer-line"><i class="fa fa-times"></i> Accès aux versions de test</div>
                    <div class="offer-line"><i class="fa fa-times"></i> Exportation des jeux sur mobile</div>
                    <div class="offer-line"><i class="fa fa-times"></i> Personnalisation complète</div>
                    <div class="offer-line"><i class="fa fa-times"></i> Soutenir notre travail</div>

                    <div class="offer-line" style="height:60px">
                        <?php if (getUser() && !isPremium(getUser())): ?>
                            <p style="text-align:center;padding:0;line-height:60px;color:#565656;font-size:1.3em">Votre
                                offre actuelle.</p>
                        <?php else: ?>
                            <?php if (getUser() && isPremium(getUser())): ?>
                                <p style="text-align:center;padding:0;line-height:60px;color:#565656;font-size:1.3em">
                                    Offre de base.</p>
                            <?php else: ?>
                                <a href="<?= BASE ?>inscription" title="Inscription">
                                    <div class="offer-btn"><i class="fa fa-user-plus"></i> Inscription</div>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col highlight">
                    <div class="offer-line"><i class="fa fa-check"></i> Création gratuite de jeux vidéo</div>
                    <div class="offer-line"><i class="fa fa-check"></i> Accès complet à l'éditeur</div>
                    <div class="offer-line"><i class="fa fa-warning"></i> <s>Création de jeux multijoueurs</s>
                        <small class="dev">(dev)</small>
                    </div>
                    <div class="offer-line"><i class="fa fa-check"></i> Accès complet au magasin</div>
                    <div class="offer-line"><i class="fa fa-check"></i> Accès aux versions de test</div>
                    <div class="offer-line"><i class="fa fa-warning"></i> <s>Exportation sur mobile</s>
                        <small class="dev">(dev)</small>
                    </div>
                    <div class="offer-line"><i class="fa fa-check"></i> Personnalisation complète</div>
                    <div class="offer-line"><i class="fa fa-check"></i> Soutenir notre travail</div>

                    <div class="offer-line" style="height:60px">
                        <?php if (getUser() && !isPremium(getUser())): ?>
                            <a href="<?= BASE ?>premium/proceed" title="Choisir cette offre">
                                <div class="offer-btn offer-btn-gold"><i class="fa fa-arrow-up"></i> Choisir cette offre
                                </div>
                            </a>
                        <?php else: ?>
                            <?php if (getUser() && isPremium(getUser())): ?>
                                <p style="text-align:center;padding:0;line-height:60px;color:#FFF;font-size:1.3em">Votre
                                    offre actuelle.</p>
                            <?php else: ?>
                                <a href="<?= BASE ?>inscription?premium" title="Inscription">
                                    <div class="offer-btn offer-btn-gold"><i class="fa fa-user-plus"></i> Inscription
                                    </div>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <br><br>
    </div>
</div>