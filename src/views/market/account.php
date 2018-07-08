<div class="account-container">
    <div class="user-menu-container">
        <?php include "views/account/user-menu.php"; ?>
    </div>

    <div class="user-account-container row-container">
        <h1 class="title" style="font-size:2em">Mes ressources postées</h1>
        <h3 class="subtitle" style="font-size:1.2em;margin-top:-15px">Tous les ressources que j'ai posté</h3>

        <?php getNotif(); ?>

        <table class="flatTable projects-table">
            <tr class="title-line">
                <td class="titleTd" style="width:250px"><?= count($d->assets); ?>
                    ressource<?= ((count($d->assets) > 1) ? "s" : "") ?></td>
                <td colspan="5"></td>
            </tr>
            <tr class="heading-line">
                <td>Nom</td>
                <td style="width:200px">Catégorie / Sous-Catégorie</td>
                <td>Description</td>
                <td style="width:200px">Communauté</td>
                <td>Date de publication</td>
                <td>Actions</td>
            </tr>

            <?php foreach ($d->assets as $v): if ($v->rating == -1): $v->rating = 2.5; endif; ?>
                <tr>
                    <td><?= stripslashes($v->name) ?></td>
                    <td><?= ucfirst($v->category_name); ?> / <?= ucfirst($v->subcategory_name); ?></td>
                    <td><?= cutText(stripslashes($v->description), 100) ?></td>
                    <td>
                        <b><span style="color:#c0392b"><i class="fa fa-heart"></i> <?= $v->likes ?></span> / <span
                                    style="color:#2980b9"><?= ratingSystem($v->rating); ?></span></b>
                    </td>
                    <td><?= date("d/m/Y", strtotime($v->publish_date)); ?></td>
                    <td>
                        <a href="<?= BASE ?>asset/<?= $v->asset_id ?>" title="Plus de détails"><i class="fa fa-eye"></i></a>
                        <a href="<?= BASE ?>editasset/<?= $v->asset_id ?>" title="Editer"><i
                                    class="fa fa-pencil"></i></a>
                        <a href="<?= BASE ?>rmasset/<?= $v->asset_id ?>" title="Supprimer"><i
                                    class="fa fa-times"></i></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
        <br>

        <a href="<?= BASE ?>newasset" title="Poster une ressource">
            <div class="btn btn-success" style="width:220px;float:right"><i class="fa fa-cloud-upload"></i> Poster une
                ressource
            </div>
        </a>
        <div class="clear"></div>
    </div>
</div>