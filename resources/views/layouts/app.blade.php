<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Basic metas -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Info for search engines -->
    <meta name="description" content="Imaginez et créez vos jeux vidéo gratuitement et facilement avec GameIndus. Concevez vos jeux de tout type avec vos amis ou votre équipe simplement !">
    <meta name="keywords"
          content="plateforme,création,jeux,jeux vidéo,création jeux vidéo,gameindus,simple,facilement,débutant,équipe,collaboratif,multijoueur,2d,3d,multijoueurs,facile,script,développer,imaginez,en équipe,créer,créer jeu,jeu,jeu vidéo,gratuit,gratuitement">
    <meta name="author" content="GameIndus">
    <meta name="dcterms.rightsHolder" content="gameindus">
    <meta name="Revisit-After" content="2 days">
    <meta name="Rating" content="general">
    <meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="all"/>

    <title>{{ config('app.name', 'Laravel') }} | @yield('title', 'Créez vos jeux vidéo 2D et 3D en ligne !')</title>

    <!-- Info for Twitter -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@GameIndus">
    <meta name="twitter:title" content="GameIndus, la plateforme de création de jeux vidéo.">
    <meta name="twitter:description"
          content="GameIndus est une plateforme gratuite et collaborative de création de jeux vidéo en ligne.">

    <link rel="publisher" href="https://plus.google.com/b/106541517808015667232/106541517808015667232">

    <!-- Scripts -->
    <script src="{{ url('/') . mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ url('/') . mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <header id="header" class="header">
        <div class="top-panel">
            <div class="top-panel-inner">
                <div class="lang-select-container">
                    <a>FR</a>
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
                    @guest
                        <a href="{{ route('register') }}" title="Inscription">Inscription</a>
                        <a href="{{ route('login') }}" title="Connexion">Connexion</a>
                    @endguest
                    @auth
                        <a href="{{ route('account') }}" title="Mon compte">
                            <img class="avatar" alt="Avatar de {{ Auth::user()->name }}"
                                 src="https://www.arcticnorth.ca/skin/frontend/fengo/default/images/chestnut/avatar/avatar.png">
                            <div class="hover"></div>
                            {{ Auth::user()->name }}
                        </a>
                    @endauth

                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="header-inner">
            <div class="logo-container">
                <a href="{{ url('/') }}" title="GameIndus">
                    <img src="{{ asset('media/logo.jpg') }}" width="348" height="70" alt="Logo de GameIndus"
                         title="GameIndus">
                </a>
            </div>

            <nav class="primary-navigation">
                <ul class="nav-menu">
                    <li class="menu-item sub-item" data-subitem="learn"><?= __("Apprendre") ?></li>
                    <li class="menu-item"><a href="{{ route('gallery') }}"
                                             title="Galerie des jeux"><?= __("Galerie des jeux") ?></a></li>
                    <li class="menu-item"><a href="https://market.gameindus.fr/" title="Magasin"><?= __("Magasin") ?></a>
                    </li>
                    <li class="menu-item"><a href="{{ route('blog') }}" title="Blog"><?= __("Blog") ?></a></li>
                </ul>
            </nav>
        </div>

        <div class="sub-item-links">
            <div class="learn-sub">
                <ul class="nav-menu">
                    <li class="menu-item"><a href="about/presentation"
                                             title="Présentation"><?= __("Présentation") ?></a></li>
                    <li class="menu-item"><a href="https://docs.gameindus.fr/"
                                             title="Documentation"><?= __("Documentation") ?></a></li>
                    <li class="menu-item"><a href="helpcenter/faq"
                                             title="Questions fréquentes"><?= __("Questions fréquentes") ?></a></li>
                </ul>
            </div>
        </div>
    </header><!-- /header -->

    <div class="subnav-inner">
        <nav class="secondary-navigation">

        </nav>
    </div>

    <? // getNotif(); ?>

    <main id="content" class="content">
        @yield('content')
    </main>

    <footer id="footer" class="footer">
        <div class="row-container">
            <div class="logo-container">
                <img src="{{ asset('media/logo.jpg') }}" width="348" height="70" alt="Logo de GameIndus"
                     title="GameIndus">
            </div>
            <div class="links-col">
                <div class="title">Services</div>

                <a href="{{ route('blog') }}" title="Blog de développement">Blog de développement</a>
                <a href="{{ route('gallery') }}" title="Galerie des jeux">Galerie des jeux</a>
                <a href="https://docs.gameindus.fr/" target="_blank" title="Documentation">Documentation</a>
                <a href="https://market.gameindus.fr/" target="_blank" title="Magasin de ressources">Magasin de
                    ressources</a>
            </div>
            <div class="links-col">
                <div class="title">Support</div>

            <!-- <a href="community" title="Communauté">Communauté</a> -->
                <a href="helpcenter" title="Support">Support</a>
                <a href="http://status.gameindus.fr/" target="_blank" title="Statut des services">Statut des services</a>
            <!-- <a href="community/feedbacks" title="Poster un avis">Poster un avis</a> -->
            </div>
            <div class="links-col">
                <div class="title"><?= __("A propos") ?></div>

            <!-- <a href="about/helpus" title="Aider le projet"><?= __("Aider le projet") ?></a> -->
                <a href="about/jobs" title=">>Nous rejoindre"><?= __("Nous rejoindre") ?></a>
                <a href="about/team" title=">L'équipe"><?= __("L'équipe") ?></a>
                <a href="about/conditions" title="Conditions générales"><?= __("Conditions générales") ?></a>
                <a href="about/cgv" title="Conditions de vente"><?= __("Conditions de vente") ?></a>
            </div>

            <div class="copyright">GameIndus 2015 - <?= date("Y") ?>
                <small>en version <span class="u">2.0.0</span></small>
            </div>

            <div class="social-buttons">
            <!-- <div class="fb-follow" data-href="https://www.facebook.com/gameindus.fr" data-width="200" data-height="20" data-layout="button" data-show-faces="true"></div>
                    <a href="https://twitter.com/GameIndus" class="twitter-follow-button" data-show-count="false"><?= __("Suivez") ?> @GameIndus</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script> -->
            </div>
        </div>

        <div class="clear"></div>

    </footer>
</body>
</html>
