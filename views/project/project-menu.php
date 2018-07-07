<?php
function getStringAuthorsOf($array)
{
    $str = "";

    foreach ($array as $v) {
        $str .= $v->username . ", ";
    }

    $str = substr($str, 0, -2);
    return $str;
}

function canPerformAction($project, $role)
{
    $r = false;

    $user = getUser();
    if ($user == null) return false;

    $owner = ($project->owner_id == $user->id) ? true : false;
    $admin = (in_array($user->id, explode(',', $project->adminusers_id))) ? true : false;

    if ($owner || $admin) { // If connected user is project's admin/owner
        if ($role == 1 && $admin) { // If connected user is admin & the tested user a member
            $r = true;
        } else if ($role == 2 && $owner) { // If connected user is owner & the tested user an admin
            $r = true;
        }
    }

    return $r;
}

?>
<div class="project-info-container" style="background-image:url(<?= BASE . trim($d->project->image, '/') ?>);">
    <div class="row-container">
        <div class="left">
            <span class="title"><?= $d->project->name ?></span>
            <span class="authors">par <?= getStringAuthorsOf($d->users); ?></span>

            <div class="clear"></div>
        </div>

        <div class="right">
            <a href="<?= BASE ?>project/<?= $d->project->id ?>/editor" title="Accéder à l'éditeur">
                <div class="meta btn-follow"
                     style="width:170px;margin-top:12px;padding:5px 4px;background:#f39c12;border-color:#f39c12"><i
                            class="fa fa-magic"></i> Accéder à l'éditeur
                </div>
            </a>
            <div class="clear"></div>
            <a href="<?= BASE ?>project/<?= $d->project->id ?>" title="Page de présentation">
                <div class="meta btn-follow"
                     style="width:190px;padding:5px 4px;background:#2980b9;border-color:#2980b9"><i
                            class="fa fa-eye"></i> Page de présentation
                </div>
            </a>
        </div>

        <div class="clear"></div>
    </div>
</div>

<div class="project-menu">
    <div class="row-container">
        <a href="<?= BASE ?>account/projects" title="Retour au profil">
            <div class="menu-item item-logout" style="float:left"><i class="fa fa-angle-double-left"></i> <span>Retour au profil</span>
            </div>
        </a>

        <a href="<?= BASE ?>project/<?= $d->project->id ?>/view" title="Information du projet">
            <div class="menu-item<?= ($page == "project/view") ? " active" : ""; ?>"><i class="fa fa-info-circle"></i>
                <span>Information</span></div>
        </a>
        <a href="<?= BASE ?>project/<?= $d->project->id ?>/members" title="Voir les membres du projet">
            <div class="menu-item<?= ($page == "project/members") ? " active" : ""; ?>"><i class="fa fa-users"></i>
                <span>Membres du projet</span></div>
        </a>
        <?php if (canPerformAction($d->project, 1)): ?>
            <a href="<?= BASE ?>project/<?= $d->project->id ?>/edit" title="Modifier les options">
                <div class="menu-item<?= ($page == "project/edit") ? " active" : ""; ?>"><i class="fa fa-cog"></i>
                    <span>Modifier le projet</span></div>
            </a>
        <?php endif; ?>

    </div>
</div>