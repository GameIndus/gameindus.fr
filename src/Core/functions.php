<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

function getPost($key = null)
{
    if ($key == null)
        return ((object)$_POST);
    else
        return $_POST[$key];
}

function getGet($key = null)
{
    if ($key == null)
        return ((object)$_GET);
    else
        return $_GET[$key];
}

function getSession($key = null)
{
    if ($key == null)
        return ((object)$_SESSION);
    else
        return $_SESSION[$key];
}

function getUser()
{
    return (isset($_SESSION['user'])) ? $_SESSION['user'] : null;
}

function isSessionKey($key)
{
    return (isset($_SESSION[$key]) && !empty($_SESSION[$key]));
}


function isPost()
{
    return (isset($_POST) && !empty($_POST));
}

function isGet()
{
    return (isset($_GET) && !empty($_GET));
}


function privatePage($cancelActiveCheck = false)
{
    if (!isSessionKey("user")) redirect("connexion");

    if (isset($cancelActiveCheck) && !$cancelActiveCheck) {
        if (!getUser()->active || (!isPremium(getUser()) && getUser()->activated_with_premium && !getUser()->active)) redirect("account/active");
    }
}

function connectPage()
{
    if (isSessionKey("user") && isInMaintenance() && isAdmin(getUser())) return false;
    if (isSessionKey("user")) redirect("account");
}

function redirect($url)
{
    @header('Location: ' . BASE . trim($url, '/'));
    die();
}

function redirectWithNotif($url, $message, $type)
{
    setNotif($message, $type);
    redirect($url);
}

function isDevVersion()
{
    return (strpos(VERSION, "dev") !== false);
}

function isInMaintenance()
{
    return false;
}

function nameToSlug($id, $name)
{
    $str = strtolower(remove_accents(preg_replace("/ /", "-", $id . "-" . $name)));
    if (substr($str, -1) == "-") $str = substr($str, 0, -1);
    return trim($str);
}

function stringToSlug($str)
{
    $str = strtolower(remove_accents(preg_replace("/ /", "-", $str)));
    if (substr($str, -1) == "-") $str = substr($str, 0, -1);
    return trim($str);
}

function slugToId($slug)
{
    return preg_split("/\-/", $slug)[0];
}

function remove_accents($str, $charset = 'utf-8')
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
    $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str); // supprime les caractères spéciaux

    return $str;
}

function print_var_name($var)
{
    foreach ($GLOBALS as $var_name => $value) {
        if ($value === $var) {
            return $var_name;
        }
    }

    return false;
}

function checkCaptcha($captcha, $secretKey)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('blabla'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $data = array('secret' => $secretKey, 'response' => $captcha, 'remoteip' => $_SERVER["REMOTE_ADDR"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $r = curl_exec($ch);
    if (!empty($r)) $r = json_decode($r);
    curl_close($ch);

    return ($r != null && isset($r->success)) ? $r->success : false;
}

function formatBreadCumb($title)
{
    switch ($title) {
        case "login":
            return "Connexion";
        case "registration":
            return "Inscription";
        case "active":
            return "Activez le compte";
        case "about":
            return "A propos";
        case "project":
            return "Projet";
        case "account":
            return "Compte";
        case "conditions":
            return "Conditions";
        case "helpus":
            return "Aidez-nous";
        case "cgv":
            return "Conditions de vente";
        case "team":
            return "L'Equipe";
        case "helpcenter":
            return "Support";
        case "faq":
            return "Foire aux questions";
        case "issues":
            return "Liste des bogues";
        case "submitissue":
            return "Rapporter un bogue";
        case "submitidea":
            return "Envoyer son idée";
        case "confirm":
            return "Confirmation";
        case "lostpassword":
            return "Récupération";
        case "create":
            return "Création";
        case "presentation":
            return "Présentation";
        case "jobs":
            return "Nous rejoindre";
        case "premium":
            return "Premium";
        case "proceed":
            return "Récapitulatif";
        case "cancel":
            return "Commande annulée";
        case "finish":
            return "Terminé !";

        default:
            return ucfirst($title);
    }
}

/**
 * To send informations (random ID & project ID) to a NodeJS server
 * @param  Integer $id ProjectID
 * @param  Integer $port Server port
 * @param  String $randomID The random ID generated
 * @return String            The random ID passed
 */
function sendProjectInfos($id, $port, $randomID)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://127.0.0.1/');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('blabla'));
    curl_setopt($ch, CURLOPT_PORT, $port);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $data = array('ID' => $randomID, 'PID' => $id);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $ctn = curl_exec($ch);
    curl_close($ch);

    return $randomID;
}

function sendCredentials($token, $projectId)
{
    $port = 40000;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://127.0.0.1/');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('blabla'));
    curl_setopt($ch, CURLOPT_PORT, $port);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $data = array('token' => $token, 'projectId' => $projectId);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $ctn = curl_exec($ch);
    curl_close($ch);
}

/*
*	Function cutText
*	Return the text send cutted
*/
function cutText($text, $caracs)
{
    $LongueurtextBrutSansHtml = strlen(strip_tags($text));
    if ($LongueurtextBrutSansHtml < $caracs) return $text;
    $MasqueHtmlSplit = '#</?([a-zA-Z1-6]+)(?: +[a-zA-Z]+="[^"]*")*( ?/)?>#';
    $MasqueHtmlMatch = '#<(?:/([a-zA-Z1-6]+)|([a-zA-Z1-6]+)(?: +[a-zA-Z]+="[^"]*")*( ?/)?)>#';
    $text .= ' ';
    $Boutstext = preg_split($MasqueHtmlSplit, $text, -1, PREG_SPLIT_OFFSET_CAPTURE | PREG_SPLIT_NO_EMPTY);
    $NombreBouts = count($Boutstext);
    if ($NombreBouts == 1) {
        $longueur = strlen($text);
        return substr($text, 0, strpos($text, ' ', $longueur > $caracs ? $caracs : $longueur));
    }
    $longueur = 0;
    $indexDernierBout = $NombreBouts - 1;
    $position = $Boutstext[$indexDernierBout][1] + strlen($Boutstext[$indexDernierBout][0]) - 1;
    $indexBout = $indexDernierBout;
    $rechercheEspace = true;
    foreach ($Boutstext as $index => $bout) {
        $longueur += strlen($bout[0]);
        if ($longueur >= $caracs) {
            $position_fin_bout = $bout[1] + strlen($bout[0]) - 1;
            $position = $position_fin_bout - ($longueur - $caracs);
            if (($positionEspace = strpos($bout[0], ' ', $position - $bout[1])) !== false) {
                $position = $bout[1] + $positionEspace;
                $rechercheEspace = false;
            }
            if ($index != $indexDernierBout)
                $indexBout = $index + 1;
            break;
        }
    }
    if ($rechercheEspace === true) {
        for ($i = $indexBout; $i <= $indexDernierBout; $i++) {
            $position = $Boutstext[$i][1];
            if (($positionEspace = strpos($Boutstext[$i][0], ' ')) !== false) {
                $position += $positionEspace;
                break;
            }
        }
    }
    $text = substr($text, 0, $position);
    preg_match_all($MasqueHtmlMatch, $text, $retour, PREG_OFFSET_CAPTURE);
    $BoutsTag = array();
    foreach ($retour[0] as $index => $tag) {
        if (isset($retour[3][$index][0]))
            continue;
        if ($retour[0][$index][0][1] != '/')
            array_unshift($BoutsTag, $retour[2][$index][0]);
        else
            array_shift($BoutsTag);
    }
    if (!empty($BoutsTag)) {
        foreach ($BoutsTag as $tag)
            $text .= '</' . $tag . '>';
    }

    return $text . ' <small>[...]</small>';
}

function ratingSystem($rate)
{
    $html = "";
    $rate = round($rate * 2) / 2;

    for ($i = 0; $i < 5; $i++) {
        if ($i <= $rate) {
            if ($i + 0.5 == $rate) {
                $html .= '<i class="fa fa-star-half-o"></i> ';
            } else if ($i == $rate) {
                $html .= '<i class="fa fa-star-o"></i> ';
            } else {
                $html .= '<i class="fa fa-star"></i> ';
            }
        } else {
            $html .= '<i class="fa fa-star-o"></i> ';
        }
    }

    return $html;
}

function get_web_page($url)
{
    $user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

    $options = array(
        CURLOPT_CUSTOMREQUEST => "GET",        //set request type post or get
        CURLOPT_POST => false,        //set to GET
        CURLOPT_USERAGENT => $user_agent, //set user agent
        CURLOPT_COOKIEFILE => "cookie.txt", //set cookie file
        CURLOPT_COOKIEJAR => "cookie.txt", //set cookie jar
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING => "",       // handle all encodings
        CURLOPT_AUTOREFERER => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT => 120,      // timeout on response
        CURLOPT_MAXREDIRS => 10,       // stop after 10 redirects
    );

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);
    $err = curl_errno($ch);
    $errmsg = curl_error($ch);
    $header = curl_getinfo($ch);
    curl_close($ch);

    $header['errno'] = $err;
    $header['errmsg'] = $errmsg;
    $header['content'] = $content;
    return $header;
}

function emailTemplate($to, $message, $title, $template)
{
    require_once 'core/email/dkim.php';

    $base = 'core/email/';
    if (!is_file($base . $template . '.php'))
        return false;

    ob_start();
    require $base . $template . '.php';
    $tmp = ob_get_clean();

    $boundary = uniqid('np1');
    $subject = 'GameIndus | ' . $title;
    $sender = "contact@gameindus.fr";

    // BuildDNSTXTRR();

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "From: GameIndus <$sender> \r\n";
    $headers .= "To: " . $to . "\r\n";
    $headers .= "Reply-To: contact@gameindus.fr\r\n";
    $headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";

    $msgToSend = "This is a MIME encoded message.";
    $msgToSend .= "\r\n\r\n--" . $boundary . "\r\n";
    $msgToSend .= "Content-type: text/plain;charset=utf-8\r\n\r\n";

    //Plain text body
    $msgToSend .= $message;
    $msgToSend .= "\r\n\r\n--" . $boundary . "\r\n";
    $msgToSend .= "Content-type: text/html;charset=utf-8\r\n\r\n";

    //Html body
    $msgToSend .= $tmp;
    $msgToSend .= "\r\n\r\n--" . $boundary . "--";

    $headers = AddDKIM($headers, $subject, $msgToSend) . $headers;
    $headers = str_replace("\r\n", "\n", $headers);

    return mail($to, $subject, $msgToSend, $headers, "-f $sender");
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function formatDate($date)
{
    $time = time() - strtotime($date);

    if (strtotime($date) < 0) return '? jours';

    $sec = $time;
    $min = floor($sec / 60);
    $hrs = floor($min / 60);
    $day = floor($hrs / 24);
    $wee = floor($day / 7);

    if ($min <= 0) return ($sec > 1) ? $sec . ' secondes' : $sec . ' seconde';
    else if ($hrs <= 0) return ($min > 1) ? $min . ' minutes' : $min . ' minute';
    else if ($day <= 0) return ($hrs > 1) ? $hrs . ' heures' : $hrs . ' heure';
    else if ($wee <= 0) return ($day > 1) ? $day . ' jours' : $day . ' jour';
    else return ($wee > 1) ? $wee . ' semaines' : $wee . ' semaine';
}

function simpleFormatDate($date)
{
    $time = $date;

    $sec = $time;
    $min = floor($sec / 60);
    $hrs = floor($min / 60);
    $day = floor($hrs / 24);
    $wee = floor($day / 7);

    $dayText = "";
    $dayWW = $day - $wee * 7;
    if ($dayWW > 0) $dayText = " et " . $dayWW . " jour" . (($dayWW > 1) ? "s" : "");

    if ($min <= 0) return ($sec > 1) ? $sec . ' secondes' : $sec . ' seconde';
    else if ($hrs <= 0) return ($min > 1) ? $min . ' minutes' : $min . ' minute';
    else if ($day <= 0) return ($hrs > 1) ? $hrs . ' heures' : $hrs . ' heure';
    else if ($wee <= 0) return ($day > 1) ? $day . ' jours' : $day . ' jour';
    else return ($wee > 1) ? $wee . ' semaines' . $dayText : $wee . ' semaine' . $dayText;
}

function formatTime($time)
{
    $min = floor($time / 60);
    $sec = $time - (60 * $min);

    return str_pad($min, 2, "0", STR_PAD_LEFT) . ":" . str_pad($sec, 2, "0", STR_PAD_LEFT);
}

function setNotif($message, $type = 'success')
{
    $_SESSION['notification'] = array('message' => $message, 'type' => $type);
}

function getNotif()
{
    if (!isset($_SESSION['notification']) || empty($_SESSION['notification'])) return false;
    echo '<div class="notif notif-' . $_SESSION['notification']['type'] . '"><div class="icon"></div><div class="message">' . __($_SESSION['notification']['message']) . '</div><div class="close"><i class="fa fa-times"></i></div></div>';
    unset($_SESSION['notification']);
}


function __($str)
{
    if (isset($GLOBALS['strings']) && isset($GLOBALS['strings'][$str])) {
        return $GLOBALS['strings'][$str];
    } else {
        return $str;
    }
}


/**
 *    Customs functions
 */
function memberIsAdmin($project, $user)
{
    if (memberIsOwner($project, $user)) return true;

    $adminusers = preg_split('/,/', $project->adminusers_id);
    return (in_array($user->id, $adminusers));
}

function memberIsOwner($project, $user)
{
    return ($project->owner_id == $user->id);
}

function isMemberOfProject($project, $user)
{
    $users = preg_split('/,/', $project->users_id);
    return (in_array($user->id, $users));
}

function getMemberById($DB, $id)
{
    return $DB->findFirst(array('table' => 'users', 'conditions' => array('id' => $id)));
}

function completeBadge($DB, $user, $badge_id)
{
    if ($DB == null || $user == null || $user->id == null) return false;

    $already = $DB->findFirst(array('table' => 'users_completedbadges', 'conditions' => array('badge_id' => $badge_id, 'user_id' => $user->id)));
    if (!empty($already)) return false;

    $DB->save(array(
        'table' => 'users_completedbadges',
        'fields' => array(
            'badge_id' => $badge_id,
            'user_id' => $user->id
        )
    ));

    if ($_SESSION["user"] == null) return false;
    getUser()->hasNotification = true;
}

function isPremium($user)
{
    if ($user == null) return false;
    return ($user->premium && remainingTimePremium($user) > 0);
}

function isAdmin($user)
{
    if ($user == null) return false;
    return ($user->grade && $user->grade == "administrator");
}

function remainingTimePremium($user)
{
    $t = $user->premium_finish_date;
    if ($t == null) return -1;
    else return (strtotime($t) - time());
}

function formatAssetType($type)
{
    switch ($type) {
        case "music":
            return "Musique";
        case "image":
            return "Image";
        default:
            return $type;
    }
}

function getFileSize($file, $humanreadable)
{
    $size = filesize("/home/gameindus/$file");

    if (!$humanreadable) return $size;

    if ($size >= 1073741824)
        $size = round($size / 1073741824 * 100) / 100 . " Go";
    elseif ($size >= 1048576)
        $size = round($size / 1048576 * 100) / 100 . " Mo";
    elseif ($size >= 1024)
        $size = round($size / 1024 * 100) / 100 . " Ko";
    else
        $size = $size . " o";

    if ($size == 0) $size = "-";

    return $size;
}

function get_mime_type($file)
{
    // our list of mime types
    $mime_types = array(
        "pdf" => "application/pdf",
        "exe" => "application/octet-stream",
        "zip" => "application/zip",
        "docx" => "application/msword",
        "doc" => "application/msword",
        "xls" => "application/vnd.ms-excel",
        "ppt" => "application/vnd.ms-powerpoint",
        "gif" => "image/gif",
        "png" => "image/png",
        "jpeg" => "image/jpg",
        "jpg" => "image/jpg",
        "mp3" => "audio/mpeg",
        "wav" => "audio/x-wav",
        "mpeg" => "video/mpeg",
        "mpg" => "video/mpeg",
        "mpe" => "video/mpeg",
        "mov" => "video/quicktime",
        "avi" => "video/x-msvideo",
        "3gp" => "video/3gpp",
        "css" => "text/css",
        "jsc" => "application/javascript",
        "js" => "application/javascript",
        "php" => "text/html",
        "htm" => "text/html",
        "html" => "text/html",
        "txt" => "text/plain",
        "json" => "text/plain"
    );
    $extension = strtolower(@end(explode('.', $file)));
    return $mime_types[$extension];
}
