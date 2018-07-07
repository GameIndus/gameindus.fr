<div class="account-container">
    <div class="user-menu-container" style="height:150px">
        <div class="user-info-container" style="background-image:url(https://gameindus.fr/imgs/projects/unknown.png);">
            <div class="row-container">
                <span class="username" style="top:10px">Résultats pour le tag "<?= $d->tag ?>"</span>
                <span class="registered-in" style="top:5px"><i class="fa fa-search"></i> <?= count($d->assets); ?>
                    résultat<?php if (count($d->assets) > 1): echo "s"; endif; ?></span>

                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<div class="search-bar">
    <div class="row-container">
        <p>
            Afficher
            <select id="elementsPerPage" style="display:inline-block">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            éléments
        </p>

        <div class="search-template-icons">
            <i class="fa fa-list active"></i>
            <i class="fa fa-th"></i>
        </div>
    </div>
</div>

<div class="subcategory-container row-container">
    <br>
    <?php getNotif(); ?>
    <br>

    <div class="search-results results-list">
        <?php if (empty($d->assets)): ?>
            <h3 style="padding:20px 0;text-align:center;color:#AAA;font-family:'Open Sans'">Aucun résultat.</h3>
        <?php endif; ?>
        <?php foreach ($d->assets as $v): ?>
            <?php include("parts/result.php"); ?>
        <?php endforeach ?>
    </div>
</div>