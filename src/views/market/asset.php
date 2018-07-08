<div class="account-container">
    <div class="user-menu-container" style="height:150px">
        <div class="user-info-container" style="background-image:url(<?= $d->preview ?>);">
            <div class="row-container">
                <div class="left">
                    <span class="username"><?= $d->name ?></span>
                    <span class="role"><i class="fa fa-user"></i> par <?= $d->user_name; ?></span>
                    <span class="registered-in"><i
                                class="fa fa-calendar"></i> Ajoutée le <?= date("d/m/Y", strtotime($d->publish_date)) ?></span>

                    <div class="clear"></div>
                </div>

                <div class="right"
                     style="text-align:right;font-family:'Open Sans';font-size:0.95em;color:#27ae60;font-weight:bold;padding-top:35px">
                    <span>Disponible dans l'éditeur <i class="fa fa-check"></i> </span>
                </div>

                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>


<div class="search-bar">
    <div class="row-container">
        <p class="bl">
            <span style="color:#c0392b;font-weight:bold"><i class="fa fa-heart"></i> <?= $d->likes ?></span>
        </p>
        <p>
            <span style="color:#2980b9;font-weight:bold"><?= ratingSystem($d->rating); ?> <?= $d->rating ?> / 5</span>
        </p>
        <p class="bl" style="float:right">
            <span style="color:#383838;font-weight:bold"><i class="fa fa-bookmark"
                                                            style="margin-right:5px"></i> <?= $d->category_name ?>
                / <?= $d->subcategory_name ?></span>
        </p>

        <div class="clear"></div>
    </div>
</div>

<div class="row-container">
    <?php $filename = $d->filename;
    if ($d->type == "music" || $d->type == "sound"): require("parts/player_audio.php");
    else: require("parts/player_image.php"); endif; ?>

    <br>

    <div class="container" style="min-height:400px">
        <div class="left" style="float:left;position:relative;width:60%;margin-right:5%">
            <div class="asset-tabs">
                <div class="tab">
                    <div class="title">Description</div>
                    <div class="content"><p><?= $d->description ?></p></div>
                </div>
                <div class="tab">
                    <div class="title">Partager</div>
                    <div class="content">
                        <p>
                            <small>Très prochainement.</small>
                        </p>
                    </div>
                </div>
                <div class="tab">
                    <div class="title">Avis</div>
                    <div class="content">
                        <p>
                            <small>Très prochainement.</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="left" style="float:left;position:relative;width:35%">
            <div class="infosbox">
                <div class="title"><?= $d->name ?></div>
                <div class="sub-title"><i class="fa fa-info-circle"></i> Informations</div>
                <div class="content">
                    <div class="line" style="overflow:hidden">Catégorie <b
                                style="width:90%;margin-right:-30%"><?= $d->category_name ?></b></div>
                    <div class="line">Auteur <b><?= $d->username ?></b></div>
                    <div class="line">Type <b><?= formatAssetType($d->type) ?></b></div>
                    <div class="line">Taille <b><?= getFileSize("system/assets/{$d->filename}", true); ?></b></div>
                    <div class="line">Accessibilité <b>Editeur</b></div>

                    <?php if ($d->type == "music" || $d->type == "sound"): ?>
                        <br>

                        <div class="line">Durée:
                            <b><?= formatTime(intval(get_web_page("http://gameindus.fr/core/ajax/getAssetPreview.php?file=" . $d->filename . "&time")["content"])); ?>
                                min.</b></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
