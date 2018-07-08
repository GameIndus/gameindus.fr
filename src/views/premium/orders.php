<div class="account-container orders-container">
    <div class="user-menu-container">
        <?php include SRC . "/views/account/user-menu.php"; ?>
    </div>

    <h1 class="title" style="padding-top:20px">Abonnement Premium</h1>
    <h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">Les commandes que j'ai passé</h3>

    <div class="row-container">
        <table class="flatTable projects-table">
            <tr class="title-line">
                <td class="titleTd"><?= count($d->orders); ?> commande<?= ((count($d->orders) > 1) ? "s" : ""); ?></td>
                <td colspan="5"></td>
            </tr>
            <tr class="heading-line">
                <td>Nom du produit</td>
                <td>Date de paiement</td>
                <td>Service de paiement</td>
                <td>ID de transaction</td>
                <td>ID d'acheteur</td>
                <td>Détails</td>
            </tr>

            <?php foreach ($d->orders as $v): ?>
                <tr>
                    <td><?= $v->product; ?></td>
                    <td><?= date("d/m/Y à H:i:s", strtotime($v->ordertime)); ?></td>
                    <td>Paypal&copy;</td>
                    <td><?= $v->transaction_id; ?></td>
                    <td><?= $v->payer_id; ?></td>
                    <td>
                        <a href="<?= BASE ?>premium/order/<?= $v->id ?>" target="_blank"
                           title="Voir la commande au format .pdf"><i class="fa fa-file-pdf-o"
                                                                      style="color:#212121;font-size:1.3em;font-weight:bold"></i></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>

        <br><br>

        <div class="btn btn-success" style="float:right"><a href="<?= BASE ?>premium/renew" title="Procéder au paiement"
                                                            style="color:#FFF"><i class="fa fa-star"></i> Renouveller
                mon abonnement</a></div>
        <div class="clear"></div>
    </div>

</div>