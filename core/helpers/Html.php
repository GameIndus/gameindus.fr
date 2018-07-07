<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

class Html
{

    public function link($title, $url, $params)
    {
        if (isset($params) && isset($params["customurl"])) $url = $params['customurl'];
        else $url = BASE . $url;

        $s = '<a title="' . __($title) . '" href="' . $url . '" ';

        if (isset($params)) {
            foreach ($params as $k => $v) {
                if ($k == "customurl" || $k == "html") continue;

                $s .= $k . '="' . $v . '" ';
            }
        }

        $ctn = __($title);
        if (isset($params) && isset($params["html"])) $ctn = $params["html"];

        $s .= '>' . $ctn . '</a>';
        return $s;
    }

}

$Html = new Html();