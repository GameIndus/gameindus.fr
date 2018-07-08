<div class="row-container login-container">
    <h1 class="title" style="padding-top:20px">Connexion</h1>
    <h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">Connectez-vous pour pouvoir continuer...</h3>

    <hr>

    <form method="POST">
        <div class="input">
            <label>Identifiant</label>
            <input type="text" name="username" placeholder="Pseudonyme/E-mail" required>
        </div>
        <div class="input">
            <label>Mot de passe</label>
            <input type="password" name="password" placeholder="Mot de passe" autocomplete="off" required>
        </div>

        <?php if (isset($_GET["n"])): ?><input type="hidden" name="nfp" value="<?= $_GET["n"]; ?>"><?php endif; ?>

        <div class="input submit">
            <input type="submit" style="float:right" value="Se connecter">

            <div class="clear"></div>
        </div>
    </form>

    <hr>

    <div class="login-others-links">
        <p>
            <i class="fa fa-angle-right"></i> Pas inscrit ? <a href="<?= BASE ?>inscription" title="Inscription">Inscrivez-vous
                ici</a>. <br>
            <i class="fa fa-angle-right"></i> Mot de passe perdu ? <a href="<?= BASE ?>account/lostpassword"
                                                                      title="Changement du mot de passe">Changez-le
                ici</a>.
        </p>
    </div>

</div>