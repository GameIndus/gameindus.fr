<div class="row-container registration-container">
    <h1 class="title" style="padding-top:20px">Création d'un projet de jeu</h1>

    <blockquote>
        <p><i class="fa fa-warning"></i> GameIndus est encore en phase de développement : vous n'aurez donc qu'un aperçu
            de ce qu'il y aura sur GameIndus dans la version finale. Pour être au courrant des nouveautés de la
            plateforme, nous vous invitons à vous inscrire à notre newsletter ou à suivre notre compte Twitter.</p>
    </blockquote>

    <form method="POST" id="registerForm">
        <div class="left-column" style="width:55%">
            <div class="input">
                <label for="name">Nom</label>
                <p class="small">Ce nom sera affiché sur l'ensemble du site. Il ne pourra pas être modifié par la
                    suite.</p>
                <input type="text" name="name" id="name" required placeholder="Nom de projet souhaité">
            </div>
            <div class="input">
                <label for="description">Description</label>
                <p class="small" style="margin-bottom:10px">Une brève description de votre projet (entre 50 et 1000
                    caractères).</p>
                <textarea type="email" name="description" id="description" required
                          placeholder="La description du projet"></textarea>
            </div>
        </div>
        <div class="right-column" style="width:35%">
            <div class="input">
                <label for="engine">Dimensions du projet</label>
                <p class="small">Séléctionnez le type de dimension de votre jeu. Exemple: 2D = 2 dimensions = jeu
                    plat.</p>
                <select name="engine" id="engine">
                    <option value="2D">2D</option>
                    <option value="2.5D" disabled>2.5D</option>
                    <option value="3D" disabled>3D</option>
                </select>
            </div>
            <div class="input">
                <label for="type">Type de projet</label>
                <p class="small">Séléctionnez le type de jeu que vous souhaitez créer. Cette option nous permet
                    seulement de trier les jeux par catégorie.</p>
                <select name="type" id="type">
                    <?php foreach ($d as $k => $v): ?>
                        <option value="<?= $k; ?>"><?= $v; ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <div class="clear"></div>

        <div style="display:block;position:relative;float:right;text-align:right;width:100%;height:30px;margin:10px 0;margin-bottom:-5px">
            <p class="small" style="margin-right:40px;font-size:1em;color:#383838">J'accepte que mon projet soit public.
                (Option modifiable par la suite)</p>

            <div style="display:block;position:absolute;right:0;top:-2px">
                <input type="checkbox" name="public" id="public" class="css-checkbox" checked>
                <label for="public" class="css-label"></label>
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

</div>

<script src="//cdn.ckeditor.com/4.5.9/standard/ckeditor.js"></script>
<script>CKEDITOR.replace('description');</script>