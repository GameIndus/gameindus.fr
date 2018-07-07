<div class="row-container registration-container">
    <a href="<?= BASE ?>account/active?logout" style="color:white" title="Se déconnecter">
        <div class="btn btn-danger" style="width:180px;border-radius:0;float:right"><i class="fa fa-lock"
                                                                                       style="padding-right:10px"></i>
            Se déconnecter
        </div>
    </a>
    <div class="clear"></div>

    <br><br>

    <h1 class="title" style="padding-top:20px">Activez votre compte</h1>
    <h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">Afin d'accéder à la plateforme, vous devez activer
        votre compte</h3>
    <br>
    <br><br>

    <div class="col" style="display:block;float:left;width:40%;height:auto;text-align:right">
        <h3 class="subtitle" style="text-align:right;padding-top:25px">J'ai une clé d'inscription</h3>

        <p>
            Vous souhaitez participer à la version de développement et vous possédez une clé ?
            Remplissez le champ ci-dessous<br> pour l'activer et accéder à votre compte dès maintenant.<br><br>

            <form method="POST" action="">
                <div class="input" style="margin-top:-10px">
        <p style="color:white;font-size:1em">
            <input type="text" class="form-control" name="key1" id="key1" placeholder="XXXX" maxLength="4"
                   onClick="this.setSelectionRange(0, this.value.length)" required
                   style="width:80px;display:inline-block" autocomplete="off"> -
            <input type="text" class="form-control" name="key2" id="key2" placeholder="XXXX" maxLength="4"
                   onClick="this.setSelectionRange(0, this.value.length)" required
                   style="width:80px;display:inline-block" autocomplete="off"> -
            <input type="text" class="form-control" name="key3" id="key3" placeholder="XXXX" maxLength="4"
                   onClick="this.setSelectionRange(0, this.value.length)" required
                   style="width:80px;display:inline-block" autocomplete="off"> -
            <input type="text" class="form-control" name="key4" id="key4" placeholder="XXXX" maxLength="4"
                   onClick="this.setSelectionRange(0, this.value.length)" required
                   style="width:80px;display:inline-block" autocomplete="off">
        </p>
    </div>
    <div class="input" style="width:112px;display:inline-block;float:right;clear:none;margin:0;margin-top:-20px">
        <button type="submit" class="btn btn-default" style="border-radius:0"><i class="fa fa-send"></i> Valider
        </button>
    </div>

    <div class="clear"></div>
    </form>
    </p>

    <br><br><br>
</div>
<div class="col" style="display:block;float:left;width:15%;margin:0 2.5%;height:auto">
    <img src="/imgs/mascotte.png" alt="Mascotte GameIndus" style="width:100%">
</div>
<div class="col" style="display:block;float:left;width:40%;height:auto">
    <h3 class="subtitle" style="text-align:left;padding-top:25px">Je prend un compte premium</h3>

    <p>
        Il est possible d'accéder à la version de développement de GameIndus en souscrivant à un abonnement premium
        mensuel (<i class="fa fa-heart" style="color:#c0392b"></i>). Pour cela, veuillez cliquer sur le bouton
        ci-dessous.
        <br><br>

        <a href="<?= BASE ?>premium/proceed" style="color:white"
           title="Activer mon compte en souscrivant à un compte premium">
            <div class="btn btn-success" style="width:300px;border-radius:0"
                 onclick="window.location.href='<?= BASE ?>premium/proceed';return false;"><i class="fa fa-key"></i>
                Activer mon compte
            </div>
        </a>
    </p>

    <br><br><br>
</div>

<div class="clear"></div>
</div>