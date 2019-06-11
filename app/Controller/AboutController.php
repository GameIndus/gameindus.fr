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

class AboutController extends Controller
{

    public function conditions()
    {
        $this->setTitle('Nos conditions générales d\'utilisation');
    }

    public function cgv()
    {
        $this->setTitle('Nos conditions générales de vente');
    }

    public function helpus()
    {
        $this->setTitle('Nous aider');
        $this->set(array(
            "donations" => 2,
            "donateState" => 3
        ));
    }

    public function team()
    {
        $this->setTitle('L\'équipe');
    }

    public function jobs()
    {
        $this->setTitle('Rejoindre notre équipe');
        $this->setDescription('GameIndus recrute ! Si vous souhaitez nous aider à la création de cette plateforme, n\'hésitez pas et postulez.');
    }

    public function presentation()
    {
        $this->setTitle('Présentation du projet');
    }

}
