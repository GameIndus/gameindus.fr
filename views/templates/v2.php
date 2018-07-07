<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta name="description" content="<?= __($ctrl->getDescription()) ?>">
    <meta name="keywords"
          content="plateforme,création,jeux,jeux vidéo,création jeux vidéo,gameindus,simple,facilement,débutant,équipe,collaboratif,multijoueur,2d,3d,multijoueurs,facile,script,développer,imaginez,en équipe,créer,créer jeu,jeu,jeu vidéo,gratuit,gratuitement">
    <meta name="author" content="GameIndus">
    <meta name="dcterms.rightsHolder" content="gameindus">
    <meta name="Revisit-After" content="2 days">
    <meta name="Rating" content="general">
    <meta name="language" content="<?= ($lang == "fr") ? "fr-FR" : "en-US"; ?>"/>
    <meta name="robots" content="all"/>
    <meta charset="UTF-8">

    <title>GameIndus | <?= __($ctrl->getTitle()); ?></title>

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

    <link rel="apple-touch-icon" href="<?= BASE ?>imgs/logo/64x64.png"/>
    <link rel="icon" type="image/png" href="<?= BASE ?>imgs/logo/64x64.png"/>

    <?php if ($config->development): ?>
        <link rel="stylesheet" media="screen" type="text/css" href="<?= BASE ?>css/icons/awesome.css">
        <link rel="stylesheet" media="screen" type="text/css" href="<?= BASE ?>css/fonts.css">
        <link rel="stylesheet" media="screen" type="text/css" href="<?= BASE ?>css/style.v2.css">
        <link rel="stylesheet" media="screen" type="text/css" href="<?= BASE ?>css/mobile.css">
    <?php else: ?>
        <link rel="stylesheet" media="screen" type="text/css" href="<?= BASE ?>css/final.min.css">
    <?php endif; ?>
    <?php if ($page == "registration"): ?>
        <script src='https://www.google.com/recaptcha/api.js'></script><?php endif; ?>

</head>
<body>

<header id="header" class="header">
    <div class="top-panel">
        <div class="top-panel-inner">
            <div class="lang-select-container">
                <a href="<?= ($lang == "fr") ? BASE : substr(BASE, 0, -3); ?>"
                   <?php if ($lang == "fr"): ?>class="active" <?php endif; ?>title="Français">fr</a>
                <!-- <a href="<?= BASE ?>en/" <?php if ($lang == "en"): ?>class="active" <?php endif; ?>title="Anglais">en</a> -->
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

            <div class="member-links-container">
                <?php if (!isSessionKey("user")): ?>
                    <a href="<?= BASE ?>inscription" title="Inscription"><?= __("Inscription") ?></a>
                    <a href="<?= BASE ?>connexion" title="Connexion"><?= __("Connexion") ?></a>
                <?php else: ?>
                    <a href="<?= BASE ?>account" title="Mon compte">
                        <img class="avatar" alt="Avatar de <?= getUser()->username ?>"
                             src="<?= BASE . trim(getUser()->avatar, '/'); ?>">
                        <div class="hover"></div>
                        <?= getUser()->username; ?>
                    </a>
                <?php endif; ?>

                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="header-inner">
        <div class="logo-container">
            <a href="<?= LANG_BASE ?>" title="GameIndus">
                <img src="<?= BASE ?>imgs/header-logo.jpg" width="348" height="70" alt="Logo de GameIndus"
                     title="GameIndus">
            </a>
        </div>

        <nav class="primary-navigation">
            <ul class="nav-menu">
                <li class="menu-item sub-item" data-subitem="learn"><?= __("Apprendre") ?></li>
                <li class="menu-item"><a href="<?= LANG_BASE ?>galerie"
                                         title="Galerie des jeux"><?= __("Galerie des jeux") ?></a></li>
                <li class="menu-item"><a href="https://market.gameindus.fr/" title="Magasin"><?= __("Magasin") ?></a>
                </li>
                <li class="menu-item"><a href="<?= LANG_BASE ?>blog" title="Blog"><?= __("Blog") ?></a></li>
            </ul>
        </nav>
    </div>

    <div class="sub-item-links">
        <div class="learn-sub">
            <ul class="nav-menu">
                <li class="menu-item"><a href="<?= LANG_BASE ?>about/presentation"
                                         title="Présentation"><?= __("Présentation") ?></a></li>
                <li class="menu-item"><a href="https://docs.gameindus.fr/"
                                         title="Documentation"><?= __("Documentation") ?></a></li>
                <li class="menu-item"><a href="<?= LANG_BASE ?>helpcenter/faq"
                                         title="Questions fréquentes"><?= __("Questions fréquentes") ?></a></li>
            </ul>
        </div>
    </div>
</header><!-- /header -->

<div class="subnav-inner">
    <nav class="secondary-navigation">

    </nav>
</div>

<?= getNotif(); ?>

<main id="content" class="content">
    <?php if (false && !in_array($page, Config::$hideBreadcrumb)): ?>
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
            <img src="<?= BASE ?>imgs/header-logo.jpg" width="348" height="70" alt="Logo de GameIndus"
                 title="GameIndus">
        </div>
        <div class="links-col">
            <div class="title">Services</div>

            <a href="<?= LANG_BASE ?>blog" title="Blog de développement">Blog de développement</a>
            <a href="<?= LANG_BASE ?>galerie" title="Galerie des jeux">Galerie des jeux</a>
            <a href="https://docs.gameindus.fr/" target="_blank" title="Documentation">Documentation</a>
            <a href="https://market.gameindus.fr/" target="_blank" title="Magasin de ressources">Magasin de
                ressources</a>
        </div>
        <div class="links-col">
            <div class="title">Support</div>

            <!-- <a href="<?= BASE ?>community" title="Communauté">Communauté</a> -->
            <a href="<?= BASE ?>helpcenter" title="Support">Support</a>
            <a href="http://status.gameindus.fr/" target="_blank" title="Statut des services">Statut des services</a>
            <!-- <a href="<?= BASE ?>community/feedbacks" title="Poster un avis">Poster un avis</a> -->
        </div>
        <div class="links-col">
            <div class="title"><?= __("A propos") ?></div>

            <!-- <a href="<?= BASE ?>about/helpus" title="Aider le projet"><?= __("Aider le projet") ?></a> -->
            <a href="<?= BASE ?>about/jobs" title=">>Nous rejoindre"><?= __("Nous rejoindre") ?></a>
            <a href="<?= BASE ?>about/team" title=">L'équipe"><?= __("L'équipe") ?></a>
            <a href="<?= BASE ?>about/conditions" title="Conditions générales"><?= __("Conditions générales") ?></a>
            <a href="<?= BASE ?>about/cgv" title="Conditions de vente"><?= __("Conditions de vente") ?></a>
        </div>

        <div class="copyright">GameIndus 2015 - <?= date("Y") ?>
            <small>en version <span class="u"><?= $config->version ?></span></small>
        </div>

        <div class="social-buttons">
            <!-- <div class="fb-follow" data-href="https://www.facebook.com/gameindus.fr" data-width="200" data-height="20" data-layout="button" data-show-faces="true"></div>
				<a href="https://twitter.com/GameIndus" class="twitter-follow-button" data-show-count="false"><?= __("Suivez") ?> @GameIndus</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script> -->
        </div>
    </div>

    <div class="clear"></div>

</footer>


<script src="<?= BASE ?>js/app.js" defer></script>

<?php if ($page == "helpcenter/submitissue"): ?>
    <script type="text/javascript" src="<?= BASE ?>js/classes/dropfile.js"></script>
    <script type="text/javascript" src="<?= BASE ?>js/submitissue.js"></script>
<?php endif; ?>

<?php if ($page == "registration"): ?>
    <script type="text/javascript" src="<?= BASE ?>js/registration.js"></script>
<?php endif; ?>
<?php if ($page == "account/edit"): ?>
    <script type="text/javascript" src="<?= BASE ?>js/classes/dropfile.js"></script>
    <script type="text/javascript" src="<?= BASE ?>js/account_edit.js"></script>
<?php endif; ?>

<?php if ($page == "project/edit"): ?>
    <script type="text/javascript" src="<?= BASE ?>js/classes/dropfile.js"></script>
    <script type="text/javascript" src="<?= BASE ?>js/project_edit.js"></script>
<?php endif; ?>

<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-53751215-2', 'auto');
    ga('send', 'pageview');

</script>
<script src="<?= BASE ?>js/cookiechoices.js" defer></script>
<script>document.addEventListener('DOMContentLoaded', function (event) {
        cookieChoices.showCookieConsentBar('Ce site utilise des cookies pour vous offrir le meilleur service. En poursuivant votre navigation, vous acceptez l’utilisation des cookies.', 'OK', 'En savoir plus', 'https://gameindus.fr/about/conditions');
    });</script>
</body>
</html>