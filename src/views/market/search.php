<?php if (!empty($d)): ?>
    <div class="account-container">
        <div class="user-menu-container" style="height:150px">
            <div class="user-info-container"
                 style="background-image:url(https://gameindus.fr/imgs/projects/unknown.png);">
                <div class="row-container">
                    <div class="left">
                        <span class="username" style="margin-top:10px">Résultats pour "<?= ucfirst($d->q); ?>"</span>
                        <span class="role"></span>
                        <span class="registered-in"><i class="fa fa-search"></i> <?= count($d->results); ?>
                            résultat<?php if (count($d->results) > 1): echo "s"; endif; ?></span>

                        <div class="clear"></div>
                    </div>

                    <div class="right"
                         style="text-align:right;font-family:'Open Sans';font-size:0.95em;color:#27ae60;font-weight:bold;padding-top:35px">

                    </div>

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

    <div class="market-search-container row-container">
        <br>
        <?php getNotif(); ?>
        <br>

        <div class="search-results results-list">
            <?php if (empty($d->results)): ?>
                <h3 style="padding:20px 0;text-align:center;color:#AAA;font-family:'Open Sans'">Aucun résultat.</h3>
            <?php endif; ?>
            <?php foreach ($d->results as $v): ?>
                <?php include("parts/result.php"); ?>
            <?php endforeach ?>
        </div>
    </div>
<?php else: ?>
    <div class="search-container row-container">
        <div class="search-form-container">
            <h3 style="padding:20px 0;text-align:center;color:#2980b9;font-family:HeroRegular;font-size:1.7em"><i
                        class="fa fa-search"></i> Rechercher une ressource</h3>

            <form method="get" action="/search">
                <div class="input">
                    <label for="q">Tapez pour rechercher :</label>
                    <input type="text" name="q" placeholder="Tapez ici pour rechercher dans le magasin"></input>
                </div>

                <div class="input">
                    <button type="submit" class="btn btn-success" style="float:right;margin-top:-15px"><i
                                class="fa fa-search"></i> Lancer la recherche
                    </button>
                </div>
                <div class="clear"></div>
            </form>
        </div>
    </div>
<?php endif; ?>