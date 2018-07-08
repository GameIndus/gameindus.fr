<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

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

        $d = new StdClass();
        $d->donations = 2;
        $d->donateState = 3;

        $this->set($d);
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
