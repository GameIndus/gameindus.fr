<div class="row-container submitissue-container">
    <h1 class="title" style="padding-top:20px">Support</h1>
    <h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">Rapporter un bogue rencontré</h3>

    <?php if (!getUser()): ?>
        <blockquote class="error">
            <p>
                Vous ne pouvez pas rapporter de bogue. En effet, il faut d'abord être inscrit sur la plateforme pour
                pouvoir effectuer cette action.
                Pour nous aider à améliorer cette plateforme, n'hésitez pas à aller vous inscrire (dans la barre en
                haut) et à rapporter les différents problèmes que vous avez rencontré.
            </p>
        </blockquote>
    <?php else: ?>

        <form method="POST" id="submitissue-form">
            <div class="left-column" style="width:55%">
                <div class="input">
                    <label for="tags">Tags</label>
                    <input type="text" class="form-control input-tags" id="tags" placeholder="Ajouter un tag"
                           style="width:100%" autocomplete="off">
                    <div id="tags-container"></div>
                    <input type="hidden" id="tagslist" name="tags" value="">
                </div>
                <div class="input">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" required
                              placeholder="Remplir ici la description du problème rencontré"></textarea>
                </div>
                <div class="input">
                    <label for="dropzone">Image (optionnel)</label>
                    <div class="dropzone" id="dropzone"></div>
                </div>
            </div>
            <div class="right-column" style="width:35%">
                <div class="submit-container">
                    <div class="input">
                        <label for="captcha" style="color:#EEE">Code de sécurité</label>

                        <p style="color:#fff;font-size:0.9em">
                            Ce code de sécurité permet d'éviter tout intrusion de la part d'un méchant robot.
                        </p>

                        <input type="text" class="input-captcha"
                               style="width:50%;float:left;height:50px;line-height:50px" name="captcha" id="captcha"
                               required placeholder="<?= __('Recopier le code') ?>" autocomplete="off">
                        <img src="/core/captcha/captcha.php"
                             style="position:relative;float:left;top:10px;margin-left:10px">

                        <div class="clear"></div>

                        <br><br>

                        <p style="color:#C1C1C1;font-size:0.8em;padding:15px 10px;text-align:center">
                            <i class="fa fa-warning"></i> En continuant, vous acceptez les conditions générales
                            d'utilisation.
                        </p>

                        <div id="progress-bar-container" style="width:100%;margin:15px 0">
                            <div class="progress-bar"></div>
                            <div class="progress-bar-perc" style="display:none"></div>
                        </div>

                        <div class="input submit">
                            <input type="submit" name="submitform" value="Envoyer" style="width:100%">
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="clear"></div>
    <?php endif; ?>

</div>