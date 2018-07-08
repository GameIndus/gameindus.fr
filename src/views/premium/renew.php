<div class="account-container renew-container">
    <div class="user-menu-container">
        <?php include "views/account/user-menu.php"; ?>
    </div>

    <h1 class="title" style="padding-top:20px">Grade Premium</h1>
    <h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">Renouvellement de l'abonnement</h3>

    <div class="row-container" style="width:960px;margin-top:50px">
        <div class="progressbar-premium">
            <div class="progressbar" data-state="<?= $d->premiumState; ?>"
                 style="background-position:-<?= $d->premiumState * 183 ?>px 0px"></div>
            <div class="star-lightning"></div>

            <div class="tooltip"
                 style="bottom:<?= ($d->premiumState == 10) ? (($d->premiumState * 32) - 32) : (($d->premiumState * 32) - 16); ?>px">
                <div class="text">Il vous reste <b><?= $d->daysRemaining; ?></b>
                    jour<?= (($d->daysRemaining > 1) ? "s" : ""); ?>.
                </div>
            </div>
        </div>

        <div class="renew-content" style="margin-top:<?= (($d->daysRemaining <= 7) ? 80 : 80) ?>px">
            <h3 class="subtitle" style="text-align:right">
                <?php if ($d->daysRemaining <= 7): ?>
                    Plus beaucoup de temps !
                <?php else: ?>
                    Renouveller dès maintenant.
                <?php endif; ?>
            </h3>
            <br>
            <p>
                <?php if ($d->daysRemaining <= 7): ?>
                    Votre abonnement arrive
                    <b>bientôt</b> à expiration ! Afin de pouvoir profiter des fonctionnalités pendant un moins de plus, il est obligatoire de renouveller votre abonnement.
                    <br><br>
                    Pour cela, rien de plus simple : il suffit de cliquer sur le bouton ci-dessous et de procéder au paiement. Votre compte sera ensuite crédité d'un moins de plus, et vous aurez les avantages durant la période concernée.
                    <br>Si vous le désirez, il est possible de renouveller votre abonnement au milieu du mois,
                    <br>car notre système ajoute un mois à l'échéance de votre abonnement actuel.<br><br><br>


                    <a href="<?= BASE ?>premium/proceed" title="Renouveller mon abonnement" style="color:#FFF">
                        <div class="btn btn-success" style="width:287px;float:right"><i class="fa fa-star"></i>
                            Renouveller mon abonnement
                        </div>
                    </a>
                <?php else: ?>
                    Nous vous remercions de la confiance que vous portez envers nos services. Afin de pouvoir profiter des fonctionnalités pendant un moins de plus, il est obligatoire de renouveller votre abonnement.
                    <br><br>
                    Vous pouvez renouveller votre abonnement dès maintenant, sans problème : en effet, nous avons créé un système capable d'ajouter un mois automatiquement,
                    <br>sans perdre un jour d'abonnement.<br>Réservez donc un mois d'abonnement dès maintenant
                    <br>afin d'éviter un éventuel oubli de renouvellement.<br><br><br>


                    <a href="<?= BASE ?>premium/proceed" title="Renouveller mon abonnement" style="color:#FFF">
                        <div class="btn btn-success" style="width:287px;float:right"><i class="fa fa-star"></i>
                            Renouveller mon abonnement
                        </div>
                    </a>
                <?php endif; ?>
            </p>
        </div>


        <div class="clear"></div>
    </div>

</div>

<script type="text/javascript">
    window.addEventListener("load", function () {
        var starLight = document.querySelector(".progressbar-premium .star-lightning");
        var progressBar = document.querySelector(".progressbar-premium .progressbar");
        var tooltip = document.querySelector(".progressbar-premium .tooltip");

        var currentAnim = 0;
        var currentState = 0;
        var barState = parseInt(progressBar.dataset.state);

        function animLightning() {
            starLight.style.backgroundPosition = "-" + (currentAnim * 183) + "px -455px";

            currentAnim++;
            if (currentAnim > 7) currentAnim = 1;
            setTimeout(animLightning, 300);
        }

        function loadBar() {
            progressBar.style.backgroundPosition = "-" + (currentState * 183) + "px 0px";
            tooltip.style.bottom = ((currentState * 32) - 16) + "px";

            if (currentState == 10) tooltip.style.bottom = ((currentState * 32) - 32) + "px";

            if (currentState >= barState) {
                animLightning();
                return false;
            }

            currentState++;
            setTimeout(loadBar, 50);
        }

        loadBar();
    });
</script>