<div class="row-container registration-container">
    <h1 class="title" style="padding-top:20px">Inscription</h1>

    <?php if (isset($_GET["form"]) || isset($_GET["premium"])): ?>
        <h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">Remplissez le formulaire ci-dessous</h3>
        <!-- <hr> -->

        <blockquote>
            <p><i class="fa fa-warning"></i> GameIndus est en version de développement. Si vous recontrez un
                problème/bug en utilisant un de nos services, n'hésitez pas à nous le faire savoir via <a
                        target="_BLANK" href="<?= BASE ?>helpcenter/submitissue" title="Support GameIndus"><b>notre
                        support</b></a>.</p>
        </blockquote>

        <form method="POST" id="registerForm">
            <div class="left-column" style="width:55%">
                <div class="input">
                    <label for="username">Nom d'utilisateur</label>
                    <p class="small">Le nom d'utilisateur est un surnom unique que vous ne pourrez plus changer par la
                        suite.</p>
                    <input type="text" name="username" id="username" required placeholder="Nom d'utilisateur souhaité">
                </div>
                <div class="input">
                    <label for="email">E-mail</label>
                    <p class="small">Ce sera l'adresse e-mail principale de votre compte. Il est nécessaire d'entrer une
                        adresse e-mail valide car elle permettera notamment de confirmer votre compte.</p>
                    <input type="email" name="email" id="email" required placeholder="Votre adresse e-mail">
                </div>
                <div class="input">
                    <label for="password">Mot de passe</label>
                    <p class="small">Ce mot de passe vous permettera de vous connecter à votre compte. Vous pourrez le
                        changer par la suite. Il est conseillé d'avoir <u>un minimum de <b>8</b> caractères</u>.</p>
                    <input type="password" name="password" id="password" required placeholder="Votre mot de passe">
                </div>
                <div class="input">
                    <label for="password2">Retapez votre mot de passe</label>
                    <p class="small">Retapez ci-dessous votre mot de passe pour des raisons de sécurité.</p>
                    <input type="password" name="password2" id="password2" required placeholder="Votre mot de passe">
                </div>
            </div>
            <div class="right-column" style="width:35%">
                <div class="accountinfo-container">
                    <?php if (!isset($_GET["premium"])): ?>
                        <div class="keys-form">
                            <div class="input">
                                <i class="fa fa-key"
                                   style="font-size:3em;margin:10px 0;margin-bottom:-20px;color:#f1c40f"></i>
                                <p style="font-size:1.5em;color:white;margin-top:-20px;margin-bottom:-15px;font-family:'Open Sans',Helvetica,Arial,sans-serif">
                                    Clé d'inscription</p>
                                <input type="text" class="form-control" name="key1" id="key1" placeholder="XXXX"
                                       maxLength="4" onClick="this.setSelectionRange(0, this.value.length)" required
                                       style="width:80px;display:inline-block" autocomplete="off"> -
                                <input type="text" class="form-control" name="key2" id="key2" placeholder="XXXX"
                                       maxLength="4" onClick="this.setSelectionRange(0, this.value.length)" required
                                       style="width:80px;display:inline-block" autocomplete="off"> -
                                <input type="text" class="form-control" name="key3" id="key3" placeholder="XXXX"
                                       maxLength="4" onClick="this.setSelectionRange(0, this.value.length)" required
                                       style="width:80px;display:inline-block" autocomplete="off"> -
                                <input type="text" class="form-control" name="key4" id="key4" placeholder="XXXX"
                                       maxLength="4" onClick="this.setSelectionRange(0, this.value.length)" required
                                       style="width:80px;display:inline-block" autocomplete="off">

                                <div class="clear"></div>

                                <div id="resultKeyMessage" class="hide"></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="input">
                            <label for="key1" class="premium-label-form">
                                <img style="display:block;position:relative;height:100px;margin:auto;top:19px;margin-bottom:10px"
                                     src="https://gameindus.fr/imgs/mascotte.png" alt="Mascotte GameIndus">
                                Vous avez choisi l'offre <span style="color:#f1c40f"><i class="fa fa-star"></i> Premium</span>
                            </label>
                            <div class="clear"></div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="input"
                     style="margin-top:60px;-webkit-transition:ease-out .2s;-moz-transition:ease-out .2s;-ms-transition:ease-out .2s;-o-transition:ease-out .2s;transition:ease-out .2s">
                    <label>Expérience dans le domaine de la création de jeu vidéo</label>
                    <p class="small">Cette option va nous permettre d'adapter nos services en fonction de vos
                        besoins.</p>
                    <input type="hidden" id="experience" name="experience">

                    <div class="inline-select-container" id="select-experience" data-to="experience" style="">
                        <div class="option" value="beginner">Débutant(e)</div>
                        <div class="option" value="intermediate">Intermédiaire</div>
                        <div class="option" value="experimented">Expérimenté(e)</div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="input">
                    <label>Vérification</label>
                    <div class="g-recaptcha" data-sitekey="6LejGSITAAAAACCB93WOlEiy2vIY2LjZHrp_DH7j"></div>
                </div>
            </div>

            <div class="clear"></div>

            <div style="display:block;position:relative;float:right;text-align:right;width:100%;height:30px;margin:10px 0;margin-bottom:-5px">
                <p class="small" style="margin-right:40px;font-size:1em;color:#383838">J'accepte de recevoir par e-mail
                    les actualités de GameIndus.</p>

                <div style="display:block;position:absolute;right:0;top:-2px">
                    <input type="checkbox" name="newsletter" id="newsletter" class="css-checkbox" checked>
                    <label for="newsletter" class="css-label"></label>
                </div>
            </div>

            <div class="clear"></div>
            <p class="submitcaption small">
                En continuant, vous acceptez nos conditions générales d'utilisation.
            </p>

            <div class="input submit" style="float:right">
                <input type="submit" name="submitform" value="Envoyer" style="width:100%">
                <p class="error" id="errorMsg" style="margin-top:10px;text-align:center"></p>
            </div>

            <div class="clear"></div>
        </form>
    <?php elseif (isset($_GET["nodevkey"])): ?>
        <h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">Accès à la version de développement sans clé
            d'inscription</h3>
        <br><br><br>

        <div class="col" style="display:block;float:left;width:42.5%;height:auto;text-align:right">
            <div class="registration-choice warning">
                <i class="fa fa-send" style="font-size:3em"></i>
                <span style="font-size:1.2em;width:80%;margin:0 10%;padding-bottom:0">S'inscrire pour recevoir une clé dans sa boîte e-mail (non immédiat)</span>

                <form method="POST" action="inscription/subscription" style="width:90%;margin:0 5%">
                    <div class="input"
                         style="width:60%;display:inline-block;float:left;clear:none;margin:0 10px;margin-left:25px">
                        <input type="text" name="email" value="" placeholder="Adresse e-mail">
                    </div>
                    <div class="input"
                         style="width:100px;top:10px;display:inline-block;float:left;clear:none;margin:0 10px">
                        <button type="submit" class="btn" style="border-radius:0">S'inscrire</button>
                    </div>

                    <div class="clear"></div>
                </form>
            </div>
        </div>
        <div class="col img-col"
             style="display:block;float:left;width:15%;margin:0;height:250px;background:white;border-right:3px solid #ddd;border-left:3px solid #ddd">
            <img src="/imgs/mascotte.png" alt="Mascotte GameIndus" style="width:80%;margin:27px 10%">
        </div>
        <div class="col" style="display:block;float:left;width:42.5%;height:auto">
            <a href="<?= BASE ?>inscription?premium" title="S'inscrire en s'abonnant à un compte Premium">
                <div class="registration-choice blue">
                    <i class="fa fa-star"></i>
                    <span style="font-size:1.2em;width:80%;margin:0 10%;padding-bottom:0">S'inscrire en s'abonnant à un compte Premium</span>
                </div>
            </a>
        </div>

        <div class="clear"></div>

        <br><br><br><br>
    <?php else: ?>
        <h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">Accès à la version de développement</h3>
        <br><br><br>

        <div class="col" style="display:block;float:left;width:42.5%;height:auto;text-align:right">
            <a href="<?= BASE ?>inscription?nodevkey" title="Je n'ai pas de clé d'inscription">
                <div class="registration-choice warning">
                    <i class="fa fa-ban"></i>
                    <span>Je n'ai pas de clé d'inscription</span>
                </div>
            </a>
        </div>
        <div class="col img-col"
             style="display:block;float:left;width:15%;margin:0;height:250px;background:white;border-right:3px solid #ddd;border-left:3px solid #ddd">
            <img src="/imgs/mascotte.png" alt="Mascotte GameIndus" style="width:80%;margin:27px 10%">
        </div>
        <div class="col" style="display:block;float:left;width:42.5%;height:auto">
            <a href="<?= BASE ?>inscription?form" title="J'ai une clé d'inscription">
                <div class="registration-choice green">
                    <i class="fa fa-key"></i>
                    <span>J'ai une clé d'inscription</span>
                </div>
            </a>
        </div>

        <div class="clear"></div>

        <br><br><br><br>
    <?php endif; ?>

</div>