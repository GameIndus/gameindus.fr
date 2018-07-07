<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

class IndexController extends Controller
{

    public function index()
    {
        $lastProjs = $this->DB->find(array("table" => "projects", "conditions" => array("public" => 1), "limit" => "0,6", "order" => "date_created desc"));
        $lastPosts = $this->DB->find(array("table" => "blog", "limit" => "0,4", "order" => "date desc"));

        foreach ($lastProjs as $v) {
            $user = $this->DB->findFirst(array("table" => "users", "conditions" => array("id" => $v->owner_id)));
            unset($user->password);
            $v->author = $user;
        }

        foreach ($lastPosts as $post) {
            $post->summary = cutText($post->content, 100);
        }


        $d = new StdClass();
        $d->projs = $lastProjs;
        $d->posts = $lastPosts;

        $this->set($d);
    }

}
