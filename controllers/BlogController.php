<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

class BlogController extends Controller
{

    public function index()
    {
        $lastPosts = $this->DB->find(array("table" => "blog", "limit" => "0,10", "order" => "date desc"));
        $popuPosts = $this->DB->find(array("table" => "blog", "fields" => array("id", "title", "views"), "limit" => "0,5", "order" => "views desc"));

        $d = new StdClass();
        $d->posts = $lastPosts;
        $d->popuPosts = $popuPosts;

        $this->setTitle('Le blog');
        $this->set($d);
    }

    public function view($req)
    {
        $req = htmlentities(addslashes($req));
        $id = slugToId($req);
        $slug = substr(strstr($req, '-'), 1);

        $post = $this->DB->findFirst(array("table" => "blog", "conditions" => array("id" => $id)));
        if (empty($post)) redirect("/blog");

        $goodSlug = nameToSlug($post->id, $post->title);
        if ($req != $goodSlug) redirect("/blog/" . $goodSlug . "/");

        $post->author = $this->DB->findFirst(array("table" => "users", "conditions" => array("id" => $post->user_id)));

        // Save the view in the BDD
        $this->DB->save(array("table" => "blog", "fields" => array("views" => ($post->views + 1)), "where" => "id", "wherevalue" => $post->id));

        // Other posts (suggestions)
        $otherPosts = $this->DB->find(array("table" => "blog", "fields" => array("id", "title")));
        $postWords = explode(" ", $post->title);

        foreach ($postWords as $key => $word) {
            $word = strtolower($word);
            if (preg_match("/[^A-Za-z0-9]/", $word) || $word == "de" || $word == "du" || $word == "le" || $word == "la") unset($postWords[$key]);
        }

        foreach ($otherPosts as $k => $v) {
            if ($v->id == $post->id) {
                unset($otherPosts[$k]);
                continue;
            }

            $hasWords = false;
            foreach ($postWords as $w) {
                if (strpos(strtolower($v->title), strtolower($w)) !== false) $hasWords = true;
            }


            if (!$hasWords) unset($otherPosts[$k]);
        }

        $post->otherPosts = $otherPosts;

        // Parse the post content from markdown to HTML
        require_once 'core/libs/markdown/Markdown.inc.php';
        $post->content = Michelf\Markdown::defaultTransform($post->content);

        $this->setTitle('Blog : ' . $post->title);
        $this->set($post);
    }

}
