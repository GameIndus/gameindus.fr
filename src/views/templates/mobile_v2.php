<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta name="description" content="<?= __(Config::$pageDescription) ?>">
    <meta name="keywords"
          content="plateforme,création,jeux,jeux vidéo,création jeux vidéo,gameindus,simple,facilement,débutant,équipe,collaboratif,multijoueur,2d,3d,multijoueurs,facile,script,développer,imaginez,en équipe,créer,créer jeu,jeu,jeu vidéo,gratuit,gratuitement">
    <meta name="author" content="GameIndus">
    <meta name="dcterms.rightsHolder" content="gameindus">
    <meta name="Revisit-After" content="2 days">
    <meta name="Rating" content="general">
    <meta name="language" content="<?= ($lang == "fr") ? "fr-FR" : "en-US"; ?>"/>
    <meta name="robots" content="all"/>
    <meta charset="UTF-8">

    <title>GameIndus | <?= __(Config::$pageTitle); ?></title>

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale = 1, user-scalable = no">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@GameIndus">
    <meta name="twitter:title" content="GameIndus, la plateforme de création de jeux vidéo.">
    <meta name="twitter:description"
          content="GameIndus est une plateforme gratuite et collaborative de création de jeux vidéo en ligne.">
    <meta property="og:title" content="GameIndus">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://gameindus.fr/">
    <meta property="og:image" content="https://i.imgur.com/HidpkEx.jpg">

    <link rel="publisher" href="https://plus.google.com/b/106541517808015667232/106541517808015667232">
    <?php if ($page == "index" && $lang == "en"): ?>
        <link rel="alternate" hreflang="fr-fr" href="https://gameindus.fr/">
    <?php endif; ?>
    <?php if ($page == "index" && $lang == "fr"): ?>
        <link rel="alternate" hreflang="en-us" href="https://gameindus.fr/en/">
    <?php endif; ?>

    <link rel="apple-touch-icon" href="/imgs/logo/64x64.png"/>
    <link rel="icon" type="image/png" href="/imgs/logo/64x64.png"/>

    <?php if (Config::$pageInDev): ?>
        <link rel="stylesheet" media="screen" type="text/css" href="/css/icons/awesome.css">
        <link rel="stylesheet" media="screen" type="text/css" href="/css/fonts.css">
        <link rel="stylesheet" media="screen" type="text/css" href="/css/style.v2.css">
        <link rel="stylesheet" media="screen" type="text/css" href="/css/mobile.css">
    <?php else: ?>
        <link rel="stylesheet" media="screen" type="text/css" href="/css/final.min.css">
    <?php endif; ?>
    <?php if ($page == "registration"): ?>
        <script src='https://www.google.com/recaptcha/api.js'></script><?php endif; ?>
</head>
<body data-mobile="true">

<header id="header" class="header">
    <div class="top-panel">
        <div class="top-panel-inner">
            <div class="menu-button-container">
                <button class="toggle-menu" id="btn-toggle-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

            <div class="social-links-container">
                <a href="https://facebook.com/gameindus.fr" title="Notre compte Facebook" target="_blank">
                    <i class="fa social-link fa-facebook"></i>
                </a>
                <a href="https://twitter.com/gameindus" title="Notre compte Twitter" target="_blank">
                    <i class="fa social-link fa-twitter"></i>
                </a>

                <!-- <i class="fa social-link fa-instagram"></i>  -->
            </div>
        </div>
    </div>
    <div class="header-inner">
        <div class="logo-container">
            <a href="<?= BASE; ?>" title="GameIndus">
                <img src="/imgs/logo/logo-medium.png" alt="Logo de GameIndus" title="GameIndus">
            </a>
        </div>

        <nav class="primary-navigation">
            <ul class="nav-menu">
                <li class="menu-item sub-item" data-subitem="learn"><?= __("Apprendre") ?></li>
                <li class="menu-item"><a href="<?= BASE ?>galerie"
                                         title="Galerie des jeux"><?= __("Galerie des jeux") ?></a></li>
                <li class="menu-item"><a href="https://market.gameindus.fr/" title="Magasin"><?= __("Magasin") ?></a>
                </li>
                <li class="menu-item"><a href="<?= BASE ?>blog" title="Blog"><?= __("Blog") ?></a></li>
                <?php if (!getUser()): ?>
                    <li class="menu-item"><a href="<?= BASE ?>connexion" title="Connexion"><?= __("Se connecter") ?></a>
                    </li>
                    <li class="menu-item"><a href="<?= BASE ?>inscription"
                                             title="Inscription"><?= __("Inscription") ?></a></li>
                <?php else: ?>
                    <li class="menu-item"><a href="<?= BASE ?>account" title="Mon compte"><?= __("Mon compte") ?></a>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="subnav-inner">
                <nav class="secondary-navigation">

                </nav>
            </div>
        </nav>
    </div>

    <div class="sub-item-links">
        <div class="learn-sub">
            <ul class="nav-menu">
                <li class="menu-item"><a href="<?= BASE ?>about/presentation"
                                         title="Présentation"><?= __("Présentation") ?></a></li>
                <li class="menu-item"><a href="https://docs.gameindus.fr/"
                                         title="Documentation"><?= __("Documentation") ?></a></li>
                <li class="menu-item"><a href="<?= BASE ?>helpcenter/faq"
                                         title="Questions fréquentes"><?= __("Questions fréquentes") ?></a></li>
            </ul>
        </div>
    </div>
</header><!-- /header -->

<main id="content" class="content">
    <?php if (!in_array($page, Config::$hideBreadcrumb)): ?>
        <div class="row-container">
            <div class="breadcrumbs">
                <a href="<?= BASE ?>" title="Accueil">
                    <div class="breadcrumb" style="width:50px;padding-right:20px"><i class="fa fa-home"></i></div>
                </a>

                <?php if (strpos($page, "/") === false): ?>
                    <div class="breadcrumb"><?= formatBreadCumb($page); ?></div>
                <?php else: $pages = explode("/", $page); ?>
                    <?php $i = 0;
                    foreach ($pages as $v): $len = strlen(formatBreadCumb($v)); ?>
                        <?php if ($i != count($pages) - 1): ?>
                            <a href="<?= BASE . ($pages[$i]); ?>" title="<?= formatBreadCumb($v); ?>">
                                <div class="breadcrumb arrowright"><?= formatBreadCumb($v); ?></div>
                            </a>
                        <?php else: ?>
                            <div class="breadcrumb"<?php if ($len >= 12): echo ' style="width:200px"'; endif; ?>><?= formatBreadCumb($v); ?></div>
                        <?php endif; ?>
                        <?php $i++; endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?= $content_for_layout; ?>
</main>

<footer id="footer" class="footer">
    <div class="row-container">
        <div class="logo-container">
            <img src="/imgs/logo/logo-medium.png" alt="Logo de GameIndus" title="GameIndus">
        </div>
        <div class="links-col">
            <div class="title">Services</div>

            <a href="#" title="Blog de développement">Blog de développement</a>
            <a href="<?= BASE ?>galerie" title="Galerie">Galerie</a>
            <a href="http://docs.gameindus.fr/" target="_blank" title="Documentation">Documentation</a>
        </div>
        <div class="links-col">
            <div class="title">Support</div>

            <a href="http://status.gameindus.fr/" target="_blank" title="Statut des services">Statut des services</a>
            <a href="<?= BASE ?>helpcenter" title="Support">Support</a>
            <a href="mailto:contact@gameindus.fr" title="Contactez-nous">Contactez-nous</a>
        </div>
        <div class="links-col">
            <div class="title">A propos</div>

            <a href="<?= BASE ?>about/helpus" title="Aider le projet">Aider le projet</a>
            <a href="<?= BASE ?>about/conditions" title="Conditions générales">Conditions générales</a>
            <a href="<?= BASE ?>about/cgv" title="Conditions de vente">Conditions de vente</a>
        </div>

        <div class="clear"></div>

        <div class="copyright">GameIndus 2015-<?= date("Y") ?>
            <small>en version <span class="u"><?= VERSION ?></span></small>
        </div>

        <div class="social-buttons">
            <div class="fb-follow" data-href="https://www.facebook.com/gameindus.fr" data-width="200" data-height="20"
                 data-layout="button" data-show-faces="true"></div>
            <a href="https://twitter.com/GameIndus" class="twitter-follow-button" data-show-count="false">Follow
                @GameIndus</a>
            <script>!function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = p + '://platform.twitter.com/widgets.js';
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, 'script', 'twitter-wjs');</script>
        </div>
    </div>

    <div class="clear"></div>

</footer>


<script src="/js/app.js"></script>
<script src="/js/mobile.js"></script>

<?php if ($page == "helpcenter/submitissue"): ?>
    <script type="text/javascript" src="/js/submitissue.js"></script>
<?php endif; ?>

<?php if ($page == "registration"): ?>
    <script type="text/javascript" src="/js/registration.js"></script>
<?php endif; ?>
<?php if ($page == "account/edit"): ?>
    <script type="text/javascript" src="/js/account_edit.js"></script>
<?php endif; ?>

<?php if ($page == "project/edit"): ?>
    <script type="text/javascript" src="/js/project_edit.js"></script>
<?php endif; ?>

<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.5&appId=459126300784415";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<script src="/js/cookiechoices.js"></script>
<script>document.addEventListener('DOMContentLoaded', function (event) {
        cookieChoices.showCookieConsentBar('Ce site utilise des cookies pour vous offrir le meilleur service. En poursuivant votre navigation, vous acceptez l’utilisation des cookies.', 'J’accepte', 'En savoir plus', 'https://gameindus.fr/about/conditions');
    });</script>

<!--
Bonjour, je m'appelle John. Je suis le gardien des fichiers de GameIndus.
Je suis dans l'ombre et je hante les fichiers pour y inspecter les moindres intrusions de la part de méchantes personnes.

Je suis coincé dans les fichiers depuis la création du site, à savoir mai 2015.
Si vous arrivez à m'en faire sortir, je vous offirai une boîte de chocolats.

Voici le lien pour activer le badge :
http://gameindus.fr/account/activejohnbadge
-->
</body>
</html>