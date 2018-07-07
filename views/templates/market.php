<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="<?= __(Config::$pageDescription) ?>">
    <meta name="keywords"
          content="gameindus, plateforme, création, jeux, vidéo, jeux vidéo, jeu vidéo, collaborative, plateforme collaborative, assets store, magasin, créer, création, jeu, html5">
    <meta name="author" content="Utarwyn">
    <meta name="dcterms.rightsHolder" content="gameindus">
    <meta name="Revisit-After" content="2 days">
    <meta name="Rating" content="general">
    <meta name="language" content="<?= ($lang == "fr") ? "fr-FR" : "en-US"; ?>"/>
    <meta name="robots" content="all"/>
    <meta charset="UTF-8">

    <title>GameIndus | Magasin de ressources</title>

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width,initial-scale = 1, user-scalable = no">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <link rel="apple-touch-icon" href="/imgs/logo/logo-only-16x16.png"/>
    <link rel="icon" type="image/png" href="/imgs/logo/logo-only-16x16.png"/>

    <link href='https://fonts.googleapis.com/css?family=Droid+Sans:300,400,700|Montserrat' rel='stylesheet'
          type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/css/style.v2.css">
    <link rel="stylesheet" type="text/css" href="/css/market.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-width:690px)" href="/css/mobile.css">
    <!-- <link rel="stylesheet" type="text/css" media="screen and (max-width:690px) and (min-width:500px)" href="/css/tablet.css"> -->
</head>
<body>
<header id="header" class="header">
    <div class="top-panel">
        <div class="top-panel-inner">
            <div class="lang-select-container">
                <a href="<?= ($lang == "fr") ? BASE : substr(BASE, 0, -3); ?>"
                   <?php if ($lang == "fr"): ?>class="active" <?php endif; ?>title="Français">fr</a>
                <a href="<?= BASE ?>en/" <?php if ($lang == "en"): ?>class="active"
                   <?php endif; ?>title="Anglais">en</a>
            </div>

            <div class="social-links-container">
                <a href="https://facebook.com/gameindus.fr" title="Notre compte Facebook" target="_blank">
                    <i class="fa social-link fa-facebook"></i>
                </a>
                <a href="https://twitter.com/gameindus" title="Notre compte Twitter" target="_blank">
                    <i class="fa social-link fa-twitter"></i>
                </a>

                <i class="fa social-link fa-instagram"></i>
            </div>

            <div class="member-links-container">
                <?php if (!isSessionKey("user")): ?>
                    <a href="https://gameindus.fr/inscription" title="Inscription"><?= __("Inscription") ?></a>
                    <a href="https://gameindus.fr/connexion?n=<?= base64_encode("https://market.gameindus.fr/"); ?>"
                       title="Connexion"><?= __("Connexion") ?></a>
                <?php else: ?>
                    <a href="<?= BASE ?>account" title="Mon compte">
                        <img class="avatar" src="<?= getUser()->avatar; ?>">
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
            <a href="<?= BASE; ?>" title="GameIndus">
                <img src="/imgs/logo/logo-medium-market.png" alt="Logo de GameIndus" title="GameIndus">
            </a>
        </div>

        <nav class="primary-navigation">
            <ul class="nav-menu">
                <a href="<?= BASE ?>search" title="Rechercher">
                    <li class="menu-item"><i class="fa fa-search"></i> Rechercher</li>
                </a>
                <a href="<?= BASE ?>categories" title="<?= __("Catégories") ?>">
                    <li class="menu-item sub-item" data-subitem="about"><?= __("Catégories") ?></li>
                </a>
            </ul>
        </nav>
    </div>

    <span class="sub-item-links" style="display:none;position:absolute;left:-100000px;top:-100000px">
			<div class="about-sub">
				<ul class="nav-menu">
					<a href="<?= BASE ?>about/team" title="L'équipe"><li class="menu-item">L'équipe</li></a>
					<a href="<?= BASE ?>about/jobs" title="Nous rejoindre"><li class="menu-item">Nous rejoindre</li></a>
					<a href="<?= BASE ?>about/helpus" title="Aider le projet"><li class="menu-item">Aider le projet</li></a>
					<a href="<?= BASE ?>about/conditions" title="Conditions générales"><li class="menu-item">Conditions générales</li></a>
				</ul>
			</div>
			<div class="services-sub">
				<ul class="nav-menu">
					<a href="http://market.gameindus.fr/" title="Magasin de ressources"><li class="menu-item">Magasin de ressources</li></a>
					<a href="http://docs.gameindus.fr/" title="Documentation"><li
                                class="menu-item">Documentation</li></a>
				</ul>
			</div>
		</span>
</header><!-- /header -->

<main>
    <?php if ($page != "market" && $page != "market/newasset" && $page != "market/search" && $page != "market/category"
        && $page != "market/tag" && $page != "market/editasset" && $page != "market/account" && $page != "market/subcategory" && $page != "market/asset" && $page != "market/categories"): ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php getNotif(); ?>
                    <?php echo $content_for_layout; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php echo $content_for_layout; ?>
    <?php endif; ?>
</main>

<footer id="footer" class="footer">
    <div class="row-container">
        <a href="https://gameindus.fr/" title="Retour sur GameIndus">
            <div class="logo-container">
                <img src="/imgs/logo/logo-medium.png" alt="Logo de GameIndus" title="GameIndus">
            </div>
        </a>
        <div class="links-col">
            <div class="title">Services</div>

            <a href="#" title="Blog de développement">Blog de développement</a>
            <a href="https://gameindus.fr/galerie" title="Galerie">Galerie</a>
            <a href="http://docs.gameindus.fr/" target="_blank" title="Documentation">Documentation</a>
        </div>
        <div class="links-col">
            <div class="title">Support</div>

            <a href="http://status.gameindus.fr/" target="_blank" title="Statut des services">Statut des services</a>
            <a href="https://gameindus.fr/helpcenter" title="Support">Support</a>
            <a href="#" title="Contactez-nous">Contactez-nous</a>
        </div>
        <div class="links-col">
            <div class="title">A propos</div>

            <a href="https://gameindus.fr/about/helpus" title="Aider le projet">Aider le projet</a>
            <a href="https://gameindus.fr/about/conditions" title="Conditions générales">Conditions générales</a>
            <a href="https://gameindus.fr/about/cgv" title="Conditions de vente">Conditions de vente</a>
        </div>

        <div class="copyright">Copyright GameIndus&copy; 2015-<?= date("Y") ?>
            <small>en version <u><?= VERSION ?></u></small>
        </div>
    </div>

    <div class="clear"></div>

</footer>

<script type="text/javascript">var index = false;</script>
<script type="text/javascript" src="/js/app.js"></script>
<script type="text/javascript" src="/js/market.js"></script>
<script type="text/javascript" src="/js/classes/dropfile.js"></script>

<?php if ($page == "market/newasset"): ?>
    <script type="text/javascript">var df = new dropFile("dropfile", "Déposer votre fichier ici", "progress-bar-container");</script>
<?php endif; ?>
</body>
</html>