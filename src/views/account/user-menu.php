<?php
function formatGrade($grade, $premium)
{
    if ($grade == "administrator" || $grade == "administrateur") return "Administrateur";
    else {
        if ($premium) return "Membre Premium";
        else return "Membre classique";
    }
}

function gradeIcon($grade, $premium)
{
    if ($grade == "administrator" || $grade == "administrateur") return "bookmark";
    else {
        if ($premium) return "star";
        else return "user";
    }
}

?>

    <div class="user-info-container" style="background-image:url(<?= BASE . trim($d->avatar, '/') ?>);">
        <div class="row-container">
            <div class="left">
                <img src="<?= BASE . trim($d->avatar, '/') ?>" class="avatar" alt="Avatar de <?= $d->username ?>">

                <span class="username"<?php if (strlen($d->username) > 10): echo ' style="font-size:1.2em"'; endif; ?>><?= $d->username ?></span>
                <span class="role"><i
                            class="fa fa-<?= gradeIcon($d->grade, isPremium($d)); ?>"></i> <?= formatGrade($d->grade, isPremium($d)); ?></span>
                <span class="registered-in"><i
                            class="fa fa-calendar"></i> Membre depuis le <?= date("d/m/Y", strtotime($d->date_registered)) ?></span>

                <div class="clear"></div>
            </div>

            <div class="right">

            </div>

            <div class="clear"></div>
        </div>
    </div>

<?php if (!MARKETPLACE): ?>
    <div class="user-menu">
        <div class="row-container">
            <a href="<?= BASE ?>account" title="Mon profil">
                <div class="menu-item<?= ($page == "account") ? " active" : ""; ?>"><i class="fa fa-user"></i> <span>Mon profil</span>
                </div>
            </a>
            <a href="<?= BASE ?>account/projects" title="Mes projets">
                <div class="menu-item<?= ($page == "account/projects") ? " active" : ""; ?>"><i
                            class="fa fa-gamepad"></i> <span>Mes jeux</span></div>
            </a>
            <a href="<?= BASE ?>account/badges" title="Mes succès">
                <div class="menu-item<?= ($page == "account/badges") ? " active" : ""; ?>"><i
                            class="fa fa-certificate"></i> <span>Mes succès</span></div>
            </a>
            <a href="<?= BASE ?>account/edit" title="Editer le compte">
                <div class="menu-item<?= ($page == "account/edit") ? " active" : ""; ?>"><i class="fa fa-pencil"></i>
                    <span>Editer mon profil</span></div>
            </a>

            <a href="<?= BASE ?>account?logout" title="Se déconnecter">
                <div class="menu-item item-logout"><i class="fa fa-lock"></i> <span>Se déconnecter</span></div>
            </a>
        </div>
    </div>
<?php else: ?>
    <div class="user-menu">
        <div class="row-container">
            <a href="<?= BASE ?>account" title="Mes ressources">
                <div class="menu-item<?= ($page == "market/account") ? " active" : ""; ?>"><i
                            class="fa fa-picture-o"></i> Mes ressources
                </div>
            </a>
            <a href="<?= BASE ?>newasset" title="Poster une ressource">
                <div class="menu-item<?= ($page == "market/newasset") ? " active" : ""; ?>"><i
                            class="fa fa-cloud-upload"></i> Poster une ressource
                </div>
            </a>

            <a href="<?= BASE ?>account?logout" title="Se déconnecter">
                <div class="menu-item item-logout"><i class="fa fa-lock"></i> Se déconnecter</div>
            </a>
            <a href="<?= BASE ?>account" title="Mon profil">
                <div class="menu-item item-logout"><i class="fa fa-long-arrow-left"></i> Retour sur mon profil</div>
            </a>
        </div>
    </div>
<?php endif; ?>