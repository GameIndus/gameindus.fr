<div class="account-container proceed-container">
    <?php if (isPremium($d)): ?>
        <div class="user-menu-container">
            <?php include "views/account/user-menu.php"; ?>
        </div>
    <?php endif ?>

    <h1 class="title"
        style="padding-top:20px"><?= ((isPremium($d)) ? "Renouvellement de l'abonnement" : "Abonnement Premium"); ?></h1>
    <h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">Récapitulatif de votre commande</h3>

    <div class="row-container">
        <table class="flatTable projects-table">
            <tr class="title-line">
                <td class="titleTd">Récapitulatif de commande</td>
                <td colspan="5"></td>
            </tr>
            <tr class="heading-line">
                <td>Nom du produit</td>
                <td>Description</td>
                <td>Quantité</td>
                <td style="width:110px">Durée</td>
                <td>Prix (HT)</td>
            </tr>

            <tr>
                <td>Abonnement Premium</td>
                <td>
                    Abonnement Premium de 1 mois aux services de GameIndus donnants accès à des fonctionnalités
                    supplémentaires.
                </td>
                <td>1</td>
                <td>1 mois</td>
                <td>1.99€</td>
            </tr>
        </table>

        <div class="price-container">
            <div class="price-line">
                <div class="col">Prix total de votre commande</div>
                <div class="col"><b>1.99
                        <small>€ HT</small>
                    </b></div>
            </div>
            <div class="price-line">
                <div class="col">Taxes (TVA)</div>
                <div class="col"><b>+ 20%</b></div>
            </div>
            <div class="price-line">
                <div class="col">Prix total <b>TTC</b> de votre commande</div>
                <div class="col"><b>2.39
                        <small>€</small>
                    </b></div>
            </div>
        </div>
        <div class="clear"></div>

        <br><br>
        <div class="btn btn-success" style="float:right"><a href="<?= $d->paypalLink; ?>" title="Procéder au paiement"
                                                            style="color:#FFF">Procéder au paiement</a></div>
        <div class="clear"></div>

        <p style="float:right">
            <small>(Vous allez quitter le site de gameindus.fr)</small>
        </p>
        <div class="clear"></div>
    </div>

</div>