<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

class MarketController extends Controller
{

    public function index()
    {
        $subcats = $this->DB->find(array('table' => 'assets_subcategories'));
        $d = new StdClass();

        $subcatsR = array();
        shuffle($subcats);
        foreach ($subcats as $k => $v) {
            if ($k < 8) $subcatsR[$k] = $v;
        }

        $sql = "SELECT *, assets.name AS name, 
						  assets.id AS asset_id, 
						  assets_subcategories.name AS subcategory_name, 
						  assets_categories.name AS category_name,
						  users.username AS user_name
				FROM assets 
				INNER JOIN assets_categories ON assets.category_id = assets_categories.id 
				INNER JOIN assets_subcategories ON assets.subcategory_id = assets_subcategories.id 
				INNER JOIN users ON assets.user_id = users.id 
				ORDER BY rating DESC
				LIMIT 0,5";
        $pre = $this->DB->pdo->prepare($sql);
        $pre->execute();

        // Selected assets (by team)
        $sAssets = explode(",", $this->DB->findFirst(array("table" => "config", 'conditions' => array("configKey" => "marketSelectedAssets")))->configValue);
        $whereStr = "";

        if ($sAssets[0] != "") {
            foreach ($sAssets as $v) {
                $whereStr .= "assets.id = '$v' OR ";
            }
        }

        if ($whereStr == "") $whereStr = 'assets.id = "-1"';
        else $whereStr = substr($whereStr, 0, -4);

        $sql2 = "SELECT *, assets.name AS name, 
						  assets.id AS asset_id, 
						  assets_subcategories.name AS subcategory_name, 
						  assets_categories.name AS category_name,
						  users.username AS user_name
				FROM assets 
				INNER JOIN assets_categories ON assets.category_id = assets_categories.id 
				INNER JOIN assets_subcategories ON assets.subcategory_id = assets_subcategories.id 
				INNER JOIN users ON assets.user_id = users.id 
				WHERE $whereStr";
        $pre2 = $this->DB->pdo->prepare($sql2);
        $pre2->execute();

        $d->popularAssets = $pre->fetchAll(PDO::FETCH_OBJ);
        $d->selectedAssets = $pre2->fetchAll(PDO::FETCH_OBJ);
        $d->subcats = $subcatsR;

        $this->set($d);
    }

    public function login()
    {
        if (isPost()) {
            $post = getPost();

            $user = $this->DB->findFirst(array('table' => 'users', 'conditions' => array('username' => addslashes(htmlentities($post->username)))));

            if ($user) {
                if (sha1($post->password) == $user->password) {
                    if ($user->active) {
                        unset($user->password);

                        $this->DB->save(array(
                            'table' => 'users',
                            'fields' => array('last_login' => date('Y-m-d H:i:s', time())),
                            'where' => 'id',
                            'wherevalue' => $user->id
                        ));

                        $_SESSION['user'] = $user;
                        header('Location: ' . BASE);
                    } else {
                        setNotif("Vous devez confirmer votre compte afin de vous connecter.", "danger");
                    }
                } else {
                    setNotif("Mot de passe incorrect. Veuillez réessayer.", "danger");
                }
            } else {
                setNotif("Compte inexistant. Merci de vous inscrire avant.", "danger");
            }
        }

        redirect("/");
    }

    public function account()
    {
        privatePage();

        if (isset($_GET['logout'])) {
            unset($_SESSION['user']);
            redirect('/');
        }

        $user = getUser();

        $sql = "SELECT *, assets.name AS name, 
						  assets.id AS asset_id, 
						  assets_subcategories.name AS subcategory_name, 
						  assets_categories.name AS category_name,
						  users.username AS user_name
				FROM assets 
				INNER JOIN assets_categories ON assets.category_id = assets_categories.id 
				INNER JOIN assets_subcategories ON assets.subcategory_id = assets_subcategories.id 
				INNER JOIN users ON assets.user_id = users.id 
				WHERE assets.user_id = '" . $user->id . "'
				ORDER BY assets.publish_date DESC";
        $pre = $this->DB->pdo->prepare($sql);
        $pre->execute();

        $assets = $pre->fetchAll(PDO::FETCH_OBJ);
        $user->assets = $assets;

        $this->set($user);
    }

    public function newasset()
    {
        privatePage();
        if (getUser() && !isPremium(getUser())) redirect("/");

        $user = getUser();

        if (getPost() && !empty($_POST)) {
            $post = getPost();

            $this->DB->save(array(
                'table' => 'assets',
                'fields' => array(
                    'name' => $post->name,
                    'description' => $post->description,
                    'type' => $post->type,
                    'tags' => $post->tags,
                    'filename' => $post->filename,
                    'user_id' => getUser()->id,
                    'category_id' => $post->category,
                    'subcategory_id' => $post->subcategory
                )
            ));

            setNotif("Votre ressource à bien été envoyée. Elle est accessible dans le magasin dès maintenant.", "success");
            redirect("/");
        }

        $d = new StdClass();

        $user->categories = $this->DB->find(array('table' => 'assets_categories'));
        $user->subcategories = $this->DB->find(array('table' => 'assets_subcategories'));

        $this->set($user);
    }

    public function search($q)
    {

        if (!empty($_GET["q"])) {
            $q = htmlentities(addslashes(getGet("q")));

            $q = strtolower(preg_replace("/ /", "-", $q));

            redirect("/search/$q");
        }

        if (!empty($q)) {
            $q = preg_replace("/\-/", " ", $q);

            $d = new StdClass();
            $d->q = $q;

            $sql = "SELECT *, assets.name AS name, 
						  	  assets.id AS asset_id, 
							  assets_categories.name AS category_name,
						  	  users.username AS user_name
					FROM assets
					INNER JOIN assets_categories ON assets.category_id = assets_categories.id 
					INNER JOIN users ON assets.user_id = users.id 
					WHERE assets.name LIKE :like";
            $pre = $this->DB->pdo->prepare($sql);
            $pre->execute(array('like' => "%" . $q . "%"));

            $d->results = $pre->fetchAll(PDO::FETCH_OBJ);

            $this->set($d);
        }
    }

    public function categories()
    {
        $subcategories = $this->DB->find(array("table" => "assets_subcategories"));
        $categories = $this->DB->find(array("table" => "assets_categories"));
        $cats = array();

        foreach ($categories as $k => $v) {
            $cats[$k] = $v;
            $cats[$k]->subcategories = array();

            foreach ($subcategories as $w) if ($w->assets_category_id == $v->id) $cats[$k]->subcategories[] = $w;
        }


        $d = new StdClass();

        $d->categories = $cats;

        $this->set($d);
    }

    public function subcategory($id)
    {
        if (empty($id)) redirect("/");

        $sql = "SELECT *, assets.name AS name, 
						  assets.id AS asset_id,
						  assets_subcategories.name AS subcategory_name, 
						  assets_categories.name AS category_name,
						  users.username AS user_name
				FROM assets 
				INNER JOIN assets_categories ON assets.category_id = assets_categories.id 
				INNER JOIN assets_subcategories ON assets.subcategory_id = assets_subcategories.id 
				INNER JOIN users ON assets.user_id = users.id 
				WHERE assets_subcategories.id = :id
				ORDER BY assets.publish_date DESC";
        $pre = $this->DB->pdo->prepare($sql);
        $pre->execute(array('id' => $id));

        $assets = $pre->fetchAll(PDO::FETCH_OBJ);
        $d = (object)array();

        if (empty($assets)) {
            $subact = $this->DB->findFirst(array('table' => 'assets_subcategories', 'conditions' => array('id' => $id)));
            if (empty($subact)) redirect("/");

            $act = $this->DB->findFirst(array('table' => 'assets_categories', 'conditions' => array('id' => $subact->assets_category_id)));
            $d->subcategory_name = $subact->name;
            $d->category_name = $act->name;
        } else {
            $d->subcategory_name = $assets[0]->subcategory_name;
            $d->category_name = $assets[0]->category_name;
        }

        $d->subcategory_id = $id;
        $d->assets = $assets;

        $this->set($d);
    }

    public function category($id)
    {
        if (empty($id)) redirect("/");

        $sql = "SELECT *, assets.name AS name, 
						  assets.id AS asset_id,
						  assets_subcategories.name AS subcategory_name, 
						  assets_categories.name AS category_name,
						  users.username AS user_name
				FROM assets 
				INNER JOIN assets_categories ON assets.category_id = assets_categories.id 
				INNER JOIN assets_subcategories ON assets.subcategory_id = assets_subcategories.id 
				INNER JOIN users ON assets.user_id = users.id 
				WHERE assets_categories.id = :id";
        $pre = $this->DB->pdo->prepare($sql);
        $pre->execute(array('id' => $id));

        $assets = $pre->fetchAll(PDO::FETCH_OBJ);
        $subcats = $this->DB->find(array('table' => 'assets_subcategories', 'conditions' => array('assets_category_id' => $id)));
        $d = (object)array();


        if (empty($assets)) {
            $act = $this->DB->findFirst(array('table' => 'assets_categories', 'conditions' => array('id' => $id)));
            if (empty($act)) redirect("/");
            $d->category_name = $act->name;
        } else {
            $d->category_name = $assets[0]->category_name;
        }

        $d->category_id = $id;
        $d->assets = $assets;
        $d->subcats = $subcats;

        $this->set($d);
    }

    public function tag($tag)
    {
        if (empty($tag)) redirect("/");

        $sql = "SELECT *, assets.name AS name, 
						  assets.id AS asset_id,
						  assets_categories.name AS category_name,
						  users.username AS user_name
				FROM assets 
				INNER JOIN assets_categories ON assets.category_id = assets_categories.id 
				INNER JOIN users ON assets.user_id = users.id";

        $pre = $this->DB->pdo->prepare($sql);
        $pre->execute();
        $assets = $pre->fetchAll(PDO::FETCH_OBJ);

        foreach ($assets as $k => $v) {
            if (!in_array($tag, explode(",", $v->tags)))
                unset($assets[$k]);
        }

        $d = (object)array();

        $d->assets = $assets;
        $d->tag = $tag;

        $this->set($d);
    }

    public function asset($assetQ)
    {
        if (empty($assetQ)) redirect("/");
        $id = -1;

        if (strpos($assetQ, "-") === false) $id = $assetQ;
        else $id = explode("-", $assetQ)[0];

        if ($id === -1 || !is_numeric($id)) redirect('/');

        $sql = "SELECT *, assets.name AS name, 
						  assets.id AS asset_id, 
						  assets_subcategories.name AS subcategory_name, 
						  assets_categories.name AS category_name,
						  users.username AS user_name
				FROM assets 
				INNER JOIN assets_categories ON assets.category_id = assets_categories.id 
				INNER JOIN assets_subcategories ON assets.subcategory_id = assets_subcategories.id 
				INNER JOIN users ON assets.user_id = users.id 
				WHERE assets.id = :id";
        $pre = $this->DB->pdo->prepare($sql);
        $pre->execute(array('id' => $id));

        $assets = $pre->fetchAll(PDO::FETCH_OBJ);
        if (empty($assets)) redirect('/');

        $asset = end($assets);
        unset($asset->password);

        if ($asset->type == "sprite") $asset->preview = "https://market.gameindus.fr/preview/{$asset->filename}";
        if (!isset($asset->preview)) $asset->preview = "https://gameindus.fr/imgs/projects/unknown.png";
        if ($asset->rating == -1) $asset->rating = 2.5;

        $this->set($asset);
    }

    public function editasset($id)
    {
        privatePage();
        $user = getUser();

        if (empty($id)) redirect("/");

        $asset = $this->DB->findFirst(array("table" => 'assets', 'conditions' => array('id' => $id)));
        if (empty($asset)) redirect("/");

        if ($asset->user_id != getUser()->id) redirect("/");

        if (isPost()) {
            $post = getPost();

            $this->DB->save(array(
                "insert" => false,
                "table" => "assets",
                "fields" => array(
                    "name" => $post->name,
                    "description" => $post->description,
                    "tags" => $post->tags,
                    "category_id" => $post->category,
                    "subcategory_id" => $post->subcategory
                ),
                "where" => "id",
                "wherevalue" => $asset->id
            ));

            setNotif("Ressource " . $post->name . " mis à jour avec succès !");
            redirect("/account");
        }


        $user->asset = $asset;

        $user->asset->categories = $this->DB->find(array('table' => 'assets_categories'));
        $user->asset->subcategories = $this->DB->find(array('table' => 'assets_subcategories'));

        $this->set($user);
    }


    public function preview($file)
    {

        function watermarkv2($sourcefile, $watermarkfile)
        {
            $sourcename = basename($sourcefile);

            // Return preview saved if it's fresh & exists
            $cacheTime = 60 * 60;
            $previewFile = "/home/gameindus/system/assets/previews/$sourcename";

            if (file_exists($previewFile)) {
                $mtime = filemtime($previewFile);
                $ctime = time();
                $diff = $ctime - $mtime;

                if ($diff <= $cacheTime) {

                    $ftype = strtolower(substr($previewFile, strlen($previewFile) - 3));
                    $type = "image/$ftype";

                    header('Content-Type:' . $type);
                    header('Content-Length: ' . filesize($previewFile));
                    readfile($previewFile);
                    return false;
                }
            }

            $watermarkfile_id = imagecreatefrompng($watermarkfile);
            $sourcefile_id = imagecreatefromfile($sourcefile);
            $fileType = strtolower(substr($sourcefile, strlen($sourcefile) - 3));

            $sourcefile_width = imageSX($sourcefile_id);
            $sourcefile_height = imageSY($sourcefile_id);
            $watermarkfile_width = imageSX($watermarkfile_id);
            $watermarkfile_height = imageSY($watermarkfile_id);

            $dest_x = 0;
            $dest_y = 0;
            $offset = -15;

            $numX = ceil($sourcefile_width / $watermarkfile_width) + 1;
            $numY = ceil($sourcefile_height / $watermarkfile_height) + 1;

            $out = imagecreatetruecolor($sourcefile_width, $sourcefile_height);
            imagealphablending($out, false);
            imagesavealpha($out, true);

            for ($i = 0; $i < $numX; $i++) {
                for ($j = 0; $j < $numY; $j++) {
                    imagecopy($out, $watermarkfile_id, ($watermarkfile_width * $i) + $offset, ($watermarkfile_height * $j) + $offset, 0, 0, $watermarkfile_width, $watermarkfile_height);
                }
            }

            imagealphablending($out, true);
            imagecopy($out, $sourcefile_id, 0, 0, 0, 0, $sourcefile_width, $sourcefile_height);

            switch ($fileType) {
                case('png'):
                    header("Content-type: image/png");
                    imagepng($out, $previewFile);
                    imagepng($out);
                    break;
                default:
                    header("Content-type: image/jpg");
                    imagejpeg($out, $previewFile);
                    imagejpeg($out);
            }

            imagedestroy($sourcefile_id);
            imagedestroy($watermarkfile_id);
        }

        function imagecreatefromfile($image_path)
        {
            list($width, $height, $image_type) = getimagesize($image_path);

            switch ($image_type) {
                case IMAGETYPE_GIF:
                    return imagecreatefromgif($image_path);
                    break;
                case IMAGETYPE_JPEG:
                    return imagecreatefromjpeg($image_path);
                    break;
                case IMAGETYPE_PNG:
                    return imagecreatefrompng($image_path);
                    break;
                default:
                    return '';
                    break;
            }
        }

        if ($file == "" || !file_exists("/home/gameindus/system/assets/$file")) die("Erreur");

        watermarkv2("/home/gameindus/system/assets/$file", '/home/gameindus/site/imgs/watermark-market.png');
    }

}

?>