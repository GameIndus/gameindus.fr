<div class="account-container">
    <div class="user-menu-container">
        <?php include "user-menu.php"; ?>
    </div>

    <div class="user-account-container row-container">
        <form method="POST" id="accountedit-form">
            <div class="left-column form-container" style="margin-top:20px">
                <h3 class="subtitle"
                    style="font-size:1.4em;text-align:left;font-weight:bold;font-family:'Open Sans',Helvetica,Arial">
                    Informations générales</h3>

                <div class="input">
                    <label for="bio">Petite description</label>
                    <textarea name="bio" id="bio" placeholder="Une courte description de vous"
                              autocomplete="off"><?= $d->bio ?></textarea>
                </div>
                <div class="input">
                    <label for="password">Mot de passe
                        <small>(laissez vide pour ne pas changer)</small>
                    </label>
                    <input type="password" name="password" id="password" placeholder="Mot de passe" autocomplete="off">
                </div>
                <div class="input">
                    <label for="password2">Confirmation du mot de passe</label>
                    <input type="password" name="password2" id="password2" placeholder="Retapez le mot de passe"
                           autocomplete="off">
                </div>

                <br>
                <div class="input submit">
                    <input type="submit" name="submitForm" value="Mettre à jour">
                </div>
            </div>

            <div class="right-column form-container" style="margin-top:20px">
                <h3 class="subtitle"
                    style="font-size:1.4em;text-align:left;font-weight:bold;font-family:'Open Sans',Helvetica,Arial">
                    Informations secondaires</h3>

                <div class="input">
                    <label for="website">Site internet</label>
                    <input type="text" name="website" id="website" placeholder="Votre site internet"
                           value="<?= $d->website ?>" autocomplete="off">
                </div>
                <div class="input">
                    <label for="twitter_username">Twitter</label>
                    <input type="text" name="twitter_username" id="twitter_username" placeholder="Votre nom Twitter"
                           value="<?= $d->twitter_username ?>" autocomplete="off">
                </div>


                <div class="input">
                    <label for="avatar">Changer d'avatar</label>
                    <img src="<?= BASE . trim($d->avatar, '/') ?>" alt="Avatar de <?= $d->username ?>"
                         style="width:144px;height:144px;float:left">
                    <div class="right-column" style="width:70%;margin:0">
                        <div class="input" style="margin:0">
                            <div id="dropzone" class="dropzone"
                                 style="overflow:hidden;height:144px;line-height:144px"></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <p class="small" style="margin-top:5px">
                        Vous pouvez seulement poster des images jpeg, png et gif.
                    </p>
                </div>

                <br>
                <div class="input submit">
                    <input type="submit" name="submitForm" value="Mettre à jour">
                </div>
            </div>

            <div class="clear"></div>

            <div class="responsive-column" style="margin-top:0">
                <h3 class="subtitle"
                    style="font-size:1.4em;text-align:left;font-weight:bold;font-family:'Open Sans',Helvetica,Arial">
                    Notifications du compte</h3>
                <div class="left-column" style="margin:10px 0;margin-right:5%">
                    <div class="input" style="margin:0">
                        <label for="newsletter">Newsletter</label>
                        <div style="display:block;position:absolute;right:50px;top:-2px">
                            <input type="checkbox" name="newsletter" id="newsletter"
                                   class="css-checkbox"<?php if ($d->newsletter): echo " checked"; endif; ?> />
                            <label for="newsletter" class="css-label"></label>
                        </div>
                        <p class="small">
                            Grâce à cette option, vous pouvez choisir de recevoir ou non la newsletter mensuelle de
                            GameIndus. Vous avez à tout moment
                            la possibilité de vous désinscrire de cette liste et de vous-y inscrire.
                        </p>
                    </div>
                </div>
                <div class="right-column" style="margin:10px 0;margin-right:5%">
                    <div class="input" style="margin:0">
                        <label for="project_notif">Notifications de projet
                            <small style="color:red;font-size:0.8em">(Dev)</small>
                        </label>
                        <div style="display:block;position:absolute;right:50px;top:-2px">
                            <input type="checkbox" name="project_notif" disabled id="project_notif"
                                   class="css-checkbox"/>
                            <label for="project_notif" class="css-label"></label>
                        </div>
                        <p class="small">
                            Grâce à cette option, vous pouvez choisir de recevoir ou non par e-mail les différentes
                            notifications de vos projets (nouveau membre, notification de groupe, demande...).
                        </p>
                    </div>
                </div>
                <div class="clear"></div>

                <br>
                <div class="input submit">
                    <input type="submit" name="submitForm" value="Mettre à jour">
                </div>
            </div>
        </form>

    </div>

    <div class="clear"></div>
</div>