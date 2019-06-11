@extends('layouts.app')

@section('content')
    <div class="slider-container">
        <div class="slideshow">
            <div class="slide">
                <div class="hero">
                    <h1 class="hero-1">
                        <?= __("Imaginez, créez, publiez") ?><br>
                        <span><?= __("votre jeu en toute simplicité !") ?></span>
                    </h1>
                    <div class="hero-2">
                        <div class="btn btn-small"><a href="{{ route('register') }}"
                                                      title="Testez gratuitement GameIndus en cliquant ici !"><?= __("Testez gratuitement") ?>
                                <i class="fa fa-long-arrow-right"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="last-info-container">
        <i class="fa fa-code"></i>
        <p>
            <b><?= __("Plateforme en développement") ?></b>
        <?= __("Tenez-vous informé des nouveautés !") ?>
        <!-- <div class="btn">Testez la plateforme</div> -->
        </p>
    </div>

    <div class="row-container features-container">
        <h2 class="title"><?= __("Qu'est ce que GameIndus ?") ?></h2>

        <p style="text-align:center;font-size:1.1em;font-family:'Open Sans',Helvetica,Arial,sans-serif">GameIndus est
            une
            plateforme regroupant un ensemble d'outils vous permettant de créer vos jeux vidéo : création de cartes,
            d'images animées, de scènes de jeu, etc. Du navigateur jusqu'au mobile, grâce à GameIndus vous avez toutes
            les
            cartes en main pour créer les jeux de vos rêves, sans limitation.</p>

        <br><br>

        <div class="features">
            <div class="feature">
                <div class="circle">
                    <i class="fa fa-cloud"></i>
                </div>
                <div class="title">Collaborative</div>

                <p>
                    &nbsp;&nbsp;Avec GameIndus, fini les clés USB et les services tiers pour transférer des fichiers. Un
                    système collaboratif est intégré pour vous permettre de modifier vos projets <b>en même temps</b>.
                </p>
            </div>
            <div class="feature">
                <div class="circle">
                    <i class="fa fa-code-fork"></i>
                </div>
                <div class="title">Facile</div>

                <p>
                    &nbsp;&nbsp;Sur GameIndus, la création d'un jeu vidéo est possible <b>sans compétences
                        particulières</b>,
                    mais qui reste toutefois accessible aux développeurs dans l'âme qui aime notre bon JavaScript.
                </p>
            </div>
            <div class="feature">
                <div class="circle">
                    <i class="fa fa-rocket"></i>
                </div>
                <div class="title">Compatible</div>

                <p>
                    &nbsp;&nbsp;Grâce à GameIndus, vous pouvez publier vos jeux vidéo sur <b>toutes les plateformes
                        existantes</b> (Windows, Mac OSX, IOS, Android, WindowsPhone, Web...)
                    excepté les consoles.
                </p>
            </div>
            <div class="feature">
                <div class="circle">
                    <i class="fa fa-lightbulb-o"></i>
                </div>
                <div class="title">Créative</div>

                <p>
                    &nbsp;&nbsp;Certains services limitent les utilisateurs dans leur création. À l'inverse, GameIndus
                    vous
                    offre tous les outils nécessaires à la création de vos jeux gratuitement, <b>sans limite</b>.
                </p>
            </div>
        </div>

        <div class="clear"></div>
    </div>

    <div class="row-container games-container">

        <div class="row-container">
            <div class="left-games-container">
                <h2 class="title grey"><?= __("Derniers <b>jeux créés</b>") ?></h2>
                <p>
                    Avec GameIndus, vous pouvez créer des jeux vidéo complets facilement et rapidement. Voici les
                    derniers
                    jeux vidéo réalisés par les membres du site.
                </p>

                <a href="{{ route('gallery') }}" title="Plus de jeux >">
                    <div class="view-more">En voir plus &nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i></div>
                </a>
            </div>
            <div class="user-games">
                <?php foreach (array() as $v): ?>
                <a href="<?= 'project/' . $v->id ?>" title="En savoir +">
                    <div class="user-game">
                        <div class="preview"
                             style="background-image:url(<?php if ($v->image == "/imgs/projects/unknown.png"): ?>project/preview/noimage/232/163<?php else: ?>project/preview/<?= $v->id ?>/232/163<?php endif; ?>);"></div>
                        <div class="meta">
                            <span class="name"><?= $v->name ?></span>
                        </div>
                    </div>
                </a>
                <?php endforeach ?>

                <div class="clear"></div>
            </div>

            <div class="clear"></div>
        </div>

    </div>

    <div class="row-container getstarted-container">

        <div class="row-container">
            <div class="left-getstarted-container">
                <div class="shard"></div>

                <h2 class="title grey">Débuter sur <b>GameIndus</b></h2>
                <p style="font-size:1em;font-family:'Open Sans',Helvetica,Arial,sans-serif">
                    Apprendre sur GameIndus est très simple. Nous fournissons des tutoriels écrits et vidéos<br>pour
                    vous
                    aider, une section support complète en cas de problème, ainsi qu'une<br>documentation détaillée. Un
                    magasin de ressources est disponible pour démarrer sans<br>utiliser de ressource personnelle.
                </p>

                <div class="getstarted-tools">
                    <div class="getstarted-tool">
                        <i class="fa fa-diamond" style="color:#fbbe89"></i>
                        <span class="name" style="color:#fbbe89">Tutoriels</span>
                    </div>
                    <a href="https://docs.gameindus.fr/" title="Documentation" target="_blank">
                        <div class="getstarted-tool">
                            <i class="fa fa-book" style="color:#f1c40f"></i>
                            <span class="name" style="color:#f1c40f">Documentation</span>
                        </div>
                    </a>
                    <a href="helpcenter" title="Support" target="_blank">
                        <div class="getstarted-tool">
                            <i class="fa fa-life-ring" style="color:#bdc3c7"></i>
                            <span class="name" style="color:#bdc3c7">Support</span>
                        </div>
                    </a>
                    <a href="https://market.gameindus.fr/" title="Magasin" target="_blank">
                        <div class="getstarted-tool">
                            <i class="fa fa-shopping-cart" style="color:#2ecc71"></i>
                            <span class="name" style="color:#2ecc71">Magasin</span>
                        </div>
                    </a>
                </div>

                <div class="clear"></div>
            </div>


            <div class="clear"></div>
        </div>

        <div class="right-background"></div>

    </div>

    <div class="row-container index-articles-container">
        <h2 class="title grey">Derniers <b>articles</b></h2>

        <div class="index-articles">
            <?php foreach (array() as $v): ?>
            <div class="index-article">
                <div class="left-date">
                    <span class="date-number"><?= date("j", strtotime($v->date)); ?></span>
                    <span class="date-month"><?= ucfirst(mb_substr(trim(strftime("%B", strtotime($v->date))), 0, 3, "UTF-8")); ?></span>
                </div>
                <div class="article-content">
                    <span class="title"><?= $v->title; ?></span>

                    <p><?= $v->summary; ?></p>

                    <a href="<?= BASE ?>blog/<?= $v->id ?>" title="Lire plus >">
                        <div class="readmore">Lire plus &nbsp;<i class="fa fa-angle-right"></i></div>
                    </a>
                </div>
            </div>
            <?php endforeach ?>

            <div class="clear"></div>
        </div>

    </div>
@endsection