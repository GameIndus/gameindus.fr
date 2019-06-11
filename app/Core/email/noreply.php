<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

define('WEBBASE', 'http://gameindus.fr/');

?><!DOCTYPE html PUBLIC "-//WC//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!-- If you delete this meta tag, the ground will open and swallow you. -->
    <meta name="viewport" content="width=device-width"/>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title><?php echo $title; ?> | GameIndus.</title>

    <link rel="stylesheet" type="text/css" href="<?php echo WEBBASE; ?>core/email/email.css">
</head>

<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#323232" style="width: 100%;border-bottom:2px solid #303030;">
    <tr>
        <td></td>
        <td class="header container" align=""
            style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important;">

            <!-- /content -->
            <div class="content" style="padding:15px;max-width:600px;margin:0 auto;display:block;">
                <table bgcolor="#323232">
                    <tr>
                        <td><img src="<?php echo WEBBASE; ?>imgs/logo/logo-medium-white.png" width="550"
                                 alt="Logo GameIndus"/></td>
                        <!-- <td align="right"><h6 class="collapse" style="font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;font-family: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; line-height: 1.1;margin:0!important;color:#DDD;">
							<p style="margin-bottom: 10px; "><?php echo $title; ?></p></h6></td> -->
                    </tr>
                </table>
            </div><!-- /content -->

        </td>
        <td></td>
    </tr>
</table><!-- /HEADER -->

<!-- BODY -->
<table class="body-wrap" bgcolor="" style="width: 100%;">
    <tr>
        <td></td>
        <td class="container" align="" bgcolor="#ECECEC"
            style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important;">

            <!-- content -->
            <div class="content" style="padding:15px;max-width:600px;margin:0 auto;display:block;">
                <table>
                    <tr>
                        <td>
                            <h3 style="font-family: Helvetica, Arial, sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;font-weight:500; font-size: 27px;"><?php echo $title; ?></h3>
                            <p style="font-family: Helvetica, Arial, sans-serif; margin-bottom: 10px; font-weight: normal; font-size:14px; line-height:1.6;">
                                <?php echo $message; ?>

                                <br><br><br>
                                ----------------------------<br>
                                Cet email est automatique, merci de ne pas y répondre.<br>
                                ----------------------------<br>
                            </p>
                        </td>
                    </tr>
                </table>
            </div><!-- /content -->

            <!-- content -->
            <div class="content" style="padding:15px;max-width:600px;margin:0 auto;display:block;">
                <table bgcolor="">
                    <tr>
                        <td>

                            <!-- social & contact -->
                            <table bgcolor="" class="social" width="100%" style="background-color: #ebebeb;">
                                <tr>
                                    <td>

                                        <!--- column 1 -->
                                        <div class="column" style="width:280px;min-width:279px;float:left;">
                                            <table bgcolor="" cellpadding="" align="left" style="width:100%;">
                                                <tr>
                                                    <td style="padding:15px;display:table-cell;vertical-align:inherit;">

                                                        <h5 class=""
                                                            style="font-family: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;font-weight: 900;font-size: 17px;">
                                                            Réseaux sociaux</h5>
                                                        <p class=""
                                                           style="margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;">
                                                            <!-- <a href="https://www.facebook.com/pages/Le-monde-des-legos/406682052724429" class="soc-btn fb" style="background-color: #3B5998!important;padding: 3px 7px;font-size: 12px;margin-bottom: 10px;text-decoration: none;color: #FFF;font-weight: bold;display: block;text-align: center;font-family: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;">Facebook</a> -->
                                                            <a href="https://twitter.com/GameIndus" class="soc-btn tw"
                                                               style="background-color: #1daced!important;padding: 3px 7px;font-size: 12px;margin-bottom: 10px;text-decoration: none;color: #FFF;font-weight: bold;display: block;text-align: center;font-family: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;">Twitter</a>
                                                            <!-- <a href="#" class="soc-btn gp" style="background-color: #DB4A39!important;padding: 3px 7px;font-size: 12px;margin-bottom: 10px;text-decoration: none;color: #FFF;font-weight: bold;display: block;text-align: center;font-family: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;">Google+</a> -->
                                                        </p>


                                                    </td>
                                                </tr>
                                            </table><!-- /column 1 -->
                                        </div>

                                        <!--- column 2 -->
                                        <div class="column" style="width:280px;min-width:279px;float:left;">
                                            <table bgcolor="" cellpadding="" align="left" style="width:100%;">
                                                <tr>
                                                    <td style="padding:15px;display:table-cell;vertical-align:inherit;">

                                                        <h5 class=""
                                                            style="font-weight: 900;font-size: 17px;font-family: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;">
                                                            Nous contacter</h5>
                                                        Email: <strong><a href="mailto:contact@gameindus.fr"
                                                                          style="color: #2BA6CB;">contact@gameindus.fr</a></strong></p>

                                                    </td>
                                                </tr>
                                            </table><!-- /column 2 -->
                                        </div>

                                        <div class="clear"></div>
                                    </td>
                                </tr>
                            </table><!-- /social & contact -->

                        </td>
                    </tr>
                </table>
            </div><!-- /content -->


        </td>
        <td></td>
    </tr>
</table><!-- /BODY -->

<!-- FOOTER -->
<table class="footer-wrap" bgcolor="#323232" style="width: 100%;">
    <tr>
        <td></td>
        <td class="container"
            style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important;background-color:#323232;">

            <!-- content -->
            <div class="content" style="padding:15px;max-width:600px;margin:0 auto;display:block;text-align:center">
                <table align="center">
                    <tr>
                        <td align="center">
                            <p>
                                <a href="http://docs.gameindus.fr/" style="color:#BBB">Documentation</a> |
                                <a href="<?php echo WEBBASE; ?>about/conditions" style="color:#BBB">Conditions
                                    générales</a> |
                                <a href="<?php echo WEBBASE; ?>helpcenter" style="color:#BBB">Support</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </div><!-- /content -->

        </td>
        <td></td>
    </tr>
</table><!-- /FOOTER -->

</body>
</html>