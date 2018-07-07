<div class="project-container">
    <div class="project-menu-container">
        <?php include "views/project/project-menu.php"; ?>
    </div>

    <div class="project-content-container row-container">
        <form method="POST" id="projectedit-form">
            <div class="left-column form-container">
                <h3 class="subtitle"
                    style="font-size:1.4em;text-align:left;font-weight:bold;font-family:'Open Sans',Helvetica,Arial">
                    Informations générales</h3>

                <div class="input">
                    <label for="description">Description</label>
                    <textarea name="description" id="description"
                              placeholder="Description du projet"><?= stripslashes($d->project->description); ?></textarea>
                </div>

                <div class="input">
                    <?php function checkForSelectedType($d, $type)
                    {
                        if ($type === $d->project->type): return " selected";
                        else: return ""; endif;
                    } ?>

                    <label for="type">Type de jeu</label>
                    <select name="type" id="type">
                        <?php foreach ($d->project->types as $k => $v): ?>
                            <option value="<?= $k; ?>"<?php echo checkForSelectedType($d, $k); ?>><?= $v; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="right-column form-container">
                <h3 class="subtitle"
                    style="font-size:1.4em;text-align:left;font-weight:bold;font-family:'Open Sans',Helvetica,Arial">
                    Informations secondaires</h3>

                <div class="input">
                    <label for="public">Public</label>
                    <div style="display:block;position:absolute;right:50px;top:-2px">
                        <input type="checkbox" name="public" id="public"
                               class="css-checkbox" <?php if ($d->project->public): echo " checked"; endif; ?>>
                        <label for="public" class="css-label"></label>
                    </div>
                    <p class="small">
                        Grâce à cette option, vous pouvez choisir si vous voulez que votre projet soit public,
                        c'est-à-dire qu'il peut être jouable par tout le monde. En mode privé, le projet ne sera pas
                        affiché dans la galerie.
                    </p>
                </div>

                <div class="input">
                    <label for="image">Changer d'image</label>
                    <img src="<?= BASE . trim($d->project->image, '/') ?>" id="project-image"
                         alt="Image du projet en cours d'utilisation" style="width:144px;height:144px;float:left">

                    <input type="hidden" id="websitebase" value="<?= BASE ?>">

                    <div class="right-column" style="width:70%;margin:0">
                        <div class="input" style="margin:0">
                            <div id="dropzone" class="dropzone" style="overflow:hidden;height:144px;line-height:144px">
                                <span>Glissez votre image ou cliquez-ici.</span>
                                <input type="file" name="file"
                                       style="opacity: 0; position: absolute; left: 0px; right: 0px; bottom: 0px; top: 0px; width: 100%; height: 100%; z-index: 1; cursor: pointer;">
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <p class="small" style="margin-top:5px">Vous pouvez seulement poster des images jpeg, png et
                        gif.</p>

                    <?php if (strpos($d->project->image, "unknown") === false): ?>
                        <div class="btn btn-danger" id="remove-image-button"
                             style="display:block;position:absolute;right:15px;top:-2px;height:25px;line-height:25px;font-size:0.8em">
                            Supprimer l'image enregistrée
                        </div>
                    <?php endif; ?>
                </div>

                <div class="input">
                    <label for="allowjoins">Autoriser les demandes</label>
                    <div style="display:block;position:absolute;right:50px;top:-2px">
                        <input type="checkbox" name="allowjoins" id="allowjoins"
                               class="css-checkbox" <?php if ($d->project->authorize_joins): echo " checked"; endif; ?>>
                        <label for="allowjoins" class="css-label"></label>
                    </div>
                    <p class="small">
                        Grâce à cette option, vous pouvez choisir si vous voulez que votre projet puisse être rejoint
                        par des membres. Si vous activez cette option, vous pourrez potientellement recevoir des
                        demandes dans la section <b>Membres du projet</b>.
                    </p>
                </div>
            </div>

            <div class="input submit">
                <div id="progress-bar-container" style="top:7px">
                    <div class="progress-bar"></div>
                    <div class="progress-bar-perc"></div>
                </div>

                <input type="submit" style="float:right" name="submitForm" value="Mettre à jour">
            </div>
        </form>


        <div class="clear"></div>
    </div>

    <div class="clear"></div>
</div>

<script src="//cdn.ckeditor.com/4.5.9/standard/ckeditor.js"></script>
<script>CKEDITOR.replace('description');</script>