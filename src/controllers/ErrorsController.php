<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

class ErrorsController extends Controller
{

    public function error404()
    {
        $this->setTitle('Erreur 404 : page introuvable');
    }

}
