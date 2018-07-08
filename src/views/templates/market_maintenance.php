<?php
$protocol = "HTTP/1.0";
if ("HTTP/1.1" == $_SERVER["SERVER_PROTOCOL"]) $protocol = "HTTP/1.1";

header("$protocol 503 Service Unavailable", true, 503);
header("Retry-After: 3600");
?>
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

    <title>GameIndus | Magasin en maintenance</title>

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width,initial-scale = 1, user-scalable = no">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <link rel="apple-touch-icon" href="/imgs/logo/logo-only-16x16.png"/>
    <link rel="icon" type="image/png" href="/imgs/logo/logo-only-16x16.png"/>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400' rel='stylesheet' type='text/css'>
    <style type="text/css" media="screen">
        * {
            margin: 0;
            padding: 0;
            outline: 0;
            border: 0;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            background: #EFEFEF;
        }

        img {
            display: block;
            position: absolute;
            left: calc(50% - 250px);
            top: calc(50% - 120px);
            width: 500px;
        }

        h1 {
            display: block;
            position: absolute;
            left: calc(50% - 400px);
            top: calc(50% + 40px);
            width: 800px;
            height: auto;

            text-align: center;

            font-family: "Open Sans", Helvetica, Arial, sans-serif;
            font-weight: 300;
            font-size: 2em;
            color: #383838;
        }

        p {
            display: block;
            position: absolute;
            left: calc(50% - 400px);
            top: calc(50% + 150px);
            width: 800px;
            height: auto;

            text-align: center;
            text-decoration: none;

            font-family: "Open Sans", Helvetica, Arial, sans-serif;
            font-weight: 400;
            font-size: 1em;
            color: #383838;
        }
    </style>
</head>
<body>

<img src="/imgs/logo/logo-medium-market.png" alt="Logo de GameIndus" title="GameIndus">
<h1>Notre magasin est en maintenance.<br>Veuillez nous excuser pour la gène occasionnée.</h1>
<p><a href="https://gameindus.fr/" title="Revenir sur GameIndus">Revenir sur GameIndus</a></p>

</body>
</html>