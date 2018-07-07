<?php

class ErrorsController extends Controller
{

    public function error404()
    {
        $this->setTitle('Erreur 404 : page introuvable');
    }

}
