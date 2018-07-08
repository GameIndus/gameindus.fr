<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

namespace GameIndus\Controller;

use GameIndus\Core\Controller;

class CommunityController extends Controller
{

    public function index()
    {
        $this->setTitle('La communauté');
        $this->setDescription('Rejoignez la communauté de GameIndus et créez des jeux vidéo en équipe avec l\'aide des autres créateurs dans l\'âme !');
    }

}
