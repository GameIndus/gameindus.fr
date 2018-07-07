<div class="project-container">
    <div class="project-menu-container">
        <?php include "views/project/project-menu.php"; ?>
    </div>

    <div class="project-content-container row-container">
        <div class="left-column form-container">
            <h3 class="subtitle"
                style="font-size:1.4em;text-align:left;font-weight:bold;font-family:'Open Sans',Helvetica,Arial">
                Informations générales</h3>
            <br>

            <p style="font-size:1.2em">Image</p>
            <img src="<?= BASE . trim($d->project->image, '/') ?>" width="60%" style="margin:10px">
            <br>

            <p style="font-size:1.2em">Description</p>
            <p style="margin:10px"><?= stripslashes($d->project->description) ?></p>
            <br>

            <p style="font-size:1.2em">Type de jeu</p>
            <p style="margin:10px"><?= $d->project->engine ?> / <?= $d->project->gameType ?></p>
            <br>

            <p style="font-size:1.2em">Date de création</p>
            <p style="margin:10px">Le <?= date("d/m/Y", strtotime($d->project->date_created)); ?></p>
            <br>
        </div>

        <div class="right-column form-container">
            <h3 class="subtitle"
                style="font-size:1.4em;text-align:left;font-weight:bold;font-family:'Open Sans',Helvetica,Arial">
                Statistiques du projet</h3>
            <br>

            <p style="font-size:1.2em">Note de la communauté</p>
            <?php $note = ($d->project->note == -1) ? 2.5 : $d->project->note; ?>
            <p style="margin:10px;color:#f1c40f;font-weight:bold">
                <?= ratingSystem($note); ?>&nbsp;&nbsp;<?= $note ?>
            </p>
            <br>

            <p style="font-size:1.2em">Appréciation du public</p>
            <p style="margin:10px;color:#c0392b;font-weight:bold"><i
                        class="fa fa-heart"></i>&nbsp;&nbsp;<?= $d->project->likes ?></p>
            <br>
        </div>

        <!-- <div style="margin:20px 0">
			<div class="form-container">
				<p style="font-size:1.2em">Membres du projet</p>
				
				<br>

				<table class="flatTable members-table" style="min-width:450px;margin: 5px 0">
				  	<tr class="title-line" style="height:40px;font-size:1.4em">
					    <td class="titleTd"><?= count($d->users); ?> membre<?= ((count($d->users) > 1) ? "s" : "") ?></td>
					    <td colspan="3"></td>
					</tr>
				  	<tr class="heading-line">
					    <td width="220">Nom</td>
					    <td>Grade</td>
					    <td>Actions</td>
					</tr>

					<?php
        foreach ($d->users as $v):

            $role = (in_array($v->id, $d->adminusers)) ? 'Administrateur' : 'Membre';
            if ($d->project->owner_id == $v->id) $role = "Chef de projet";
            ?>
					  	<tr>
						    <td>
						    	<div class="avatar" style="display:inline-block;float:left;top:5px;position:relative">
					    			<img style="width:32px;height:32px;border-radius:50%" src="<?= $v->avatar ?>" alt="Avatar de <?= $v->username ?>">
						    	</div> 
						    	<span style="display:block;position:relative;top:10px;float:left;padding-left:15px"><?= $v->username ?></span>
						    </td>
						    <td><?= $role ?></td>
						    <td>
						    	<a href="/account/<?= $v->id; ?>" title="Voir le profil"><i class="fa fa-eye"></i></a>
				    			<?php if (canPerformAction($user, $admin, $owner, $role, $v->id)): ?><a href="<?php echo BASE ?>project/<?php echo $d->project->id ?>/changeusergrade?q=<?php echo $v->id; ?>" title="Changer de grade"><i class="fa fa-graduation-cap"></i></a><?php endif; ?>
				    			<?php if ($owner && $role != 'Chef de projet' && $v->id != getUser()->id): ?><a href="<?php echo BASE ?>project/<?php echo $d->project->id ?>/defineprojowner?q=<?php echo $v->id; ?>" title="Définir chef de projet" onclick="return confirm('Voulez-vous vraiment passer votre grade à ce membre ?');" ><i class="fa fa-trophy"></i></a><?php endif; ?>
				    			<?php if (canPerformAction($user, $admin, $owner, $role, $v->id)): ?><a href="<?php echo BASE ?>project/<?php echo $d->project->id ?>/excludeuser?q=<?php echo $v->id; ?>" onclick="return confirm('Voulez-vous vraiment exclure ce membre du projet ?');" title="Exclure du projet"><i class="fa fa-sign-out"></i></a><?php endif; ?>
						    </td>
						</tr>
					<?php endforeach ?>
				</table>

			</div>
		</div> -->


        <div class="clear"></div>
    </div>

    <div class="clear"></div>
</div>