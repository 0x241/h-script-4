<?php

error_reporting(3);
define("HS2_BR", "<br />");
define("HS2_NL", "\r\n");
define("HS2_UNIX_SECOND", 1);
define("HS2_UNIX_MINUTE", 60);
define("HS2_UNIX_HOUR", 60 * HS2_UNIX_MINUTE);
define("HS2_UNIX_DAY", 24 * HS2_UNIX_HOUR);
global $_GS;
$_GS = array();
$_GS["info"] = array();
require_once "lib/sutils.php";
require_once "lib/mail.php";
$_GS["domain"] = preg_replace("|^(www\\.)|i", "", $_SERVER["SERVER_NAME"]);
$s = $_GS["domain"];
cutElemR($s, ".");
cutElemR($s, ".");
$_GS["subdomain"] = $s;
$s = $_SERVER["SCRIPT_NAME"];
$_GS["script"] = cutElemR($s, "/");
$_GS["root_dir"] = $s ? substr($s, 1) . "/" : "";
$s = $_GS["script"];
cutElemR($s, ".");
$_GS["module"] = strtolower($s);
$_GS["https"] = $_SERVER["SERVER_PORT"] == 443;
$_GS["root_url"] = getrooturl($_GS["https"]);
$s = $_SERVER["REQUEST_URI"];
cutElemL($s, "/" . $_GS["root_dir"]);
$_GS["uri"] = $s;
$_GS["server_ip"] = $_SERVER["SERVER_ADDR"];
$_GS["client_ip"] = $_SERVER["REMOTE_ADDR"];
$_GS["is_local"] = substr($_GS["server_ip"], 0, -1) == "127.0.0.";
$_GS["is_self"] = $_GS["client_ip"] == $_GS["server_ip"];
$_GS["lang"] = "";
$_GS["mode"] = "";
$_GS["theme"] = "";
$_GS["default_lang"] = "en";
$_GS["TZ"] = 0;
$_GS["site_name"] = "";
global $_IN;
$_IN = fromGPC($_POST);
/* DISABLE LICENSE CHECK
if (1 < abs(chklic() - time())) {
    exit;
}
*/
function xAbort($message = "")
{
    throw new Exception($message);
}
function xSysInfo($message, $type = 0)
{
    $_GS["info"][$type][] = $message;
    if ($type < 2) {
        return NULL;
    }
    xAddToLog($message, "system");
    if ($type == 2) {
        xabort($message);
    }
    xStop($message);
}
function xSysWarning($message)
{
    xsysinfo($message, 1);
}
function xSysError($message)
{
    xsysinfo($message, 2);
}
function xSysStop($message, $and_refresh = false)
{
    if ($and_refresh && !headers_sent()) {
        refreshToURL(5);
    }
    xsysinfo($message, 3);
}
function xTerminal($is_debug = false)
{
    global $_GS;
    if ($is_debug) {
        error_reporting(30719);
    }
    ob_implicit_flush();
    header("Content-Type: text/plain; charset=\"utf-8\"");
    header("Pragma: no-cache");
    $_GS["as_term"] = true;
}
function xEcho()
{
    global $_GS;
    foreach (func_num_args() ? func_get_args() : array("- - - - -") as $message) {
        if (is_array($message) || is_object($message)) {
            $message = print_r($message, true);
        }
        $message .= HS2_NL;
        if (!$_GS["as_term"]) {
            $message = nl2br($message);
        }
        echo $message;
    }
}
function xStop()
{
    foreach (func_get_args() as $message) {
        xecho($message);
    }
    exit;
}
function xAddToLog($message, $topic = "", $clear_before = false)
{
    global $_GS;
    $fname = "logs/log_" . $topic . ".txt";
    if ($clear_before) {
        unlink($fname);
    }
    clearstatcache();
    $t = file_exists($fname) ? @filemtime($fname) : 0;
    if ($f = fopen($fname, "a")) {
        $d = abs(time() - $t);
        if (10 <= $d) {
            fwrite($f, "- - - - - [" . gmdate("d.m.y H:i:s") . ($d <= 120 ? " +" . $d : "") . "] - - - - -" . HS2_NL);
        }
        if (is_array($message) || is_object($message)) {
            $message = print_r($message, true);
        }
        fwrite($f, "<" . $_GS["module"] . "> " . $message . HS2_NL);
        fclose($f);
    }
}
function getRootURL($as_HTTPS = false)
{
    global $_GS;
    return ($as_HTTPS ? "https" : "http") . "://" . $_GS["domain"] . "/" . $_GS["root_dir"];
}
function ss1Elem(&$s)
{
    if (!is_array($s)) {
        $s = stripslashes($s);
    } else {
        foreach ($s as $i => $v) {
            ss1Elem($s[$i]);
        }
    }
}
function fromGPC($s)
{
    if (!is_null($s)) {
        if (get_magic_quotes_gpc()) {
            ss1elem($s);
        }
        mTrim($s);
    }
    return $s;
}
function filterInput($s, $mask = "")
{
    if (is_null($s) || !$mask) {
        return $s;
    }
    if ($mask == "*") {
        return strip_tags($s);
    }
    preg_match("/^" . $mask . "\$/", $s, $a);
    return $a[0];
}
function _arr_val(&$arr, $p)
{
    if (!isset($arr)) {
        return NULL;
    }
    if (preg_match("/(.+)\\[(.*)\\]/", $p, $a)) {
        return _arr_val($arr[$a[1]], $a[2]);
    }
    return $arr[$p];
}
function isset_IN($p = "btn")
{
    global $_IN;
    return !is_null(_arr_val($_IN, $p));
}
function _IN($p, $mask = "")
{
    global $_IN;
    return filterinput(_arr_val($_IN, $p), $mask);
}
function _COOKIE($p, $mask = "")
{
    return isset($_COOKIE[$p]) ? filterinput(fromgpc($_COOKIE[$p]), $mask) : NULL;
}
function _GET($p, $mask = "")
{
    return isset($_GET[$p]) ? filterinput(fromgpc($_GET[$p]), $mask) : NULL;
}
function _POST($p, $mask = "")
{
    return isset($_POST[$p]) ? filterinput(fromgpc($_POST[$p]), $mask) : NULL;
}
function isset_RQ($p)
{
    $_RQ = $_GET + $_POST;
    return !is_null(_arr_val($_RQ, $p));
}
function _RQ($p, $mask = "")
{
    $_RQ = $_GET + $_POST;
    return filterinput(fromgpc(_arr_val($_RQ, $p)), $mask);
}
function _SESSION($p)
{
    return isset($_SESSION[$p]) ? $_SESSION[$p] : NULL;
}
function _INN($p)
{
    return intval(_in($p));
}
function _COOKIEN($p)
{
    return intval($_COOKIE[$p]);
}
function _GETN($p)
{
    return intval($_GET[$p]);
}
function _POSTN($p)
{
    return intval($_POST[$p]);
}
function _RQN($p)
{
    return intval(_rq($p));
}
function validMail($s)
{
    $mask = "|^.+@.+\\..+\$|";
    return preg_match($mask, textLow($s));
}
function validURL($s)
{
    $mask = "|^https?:\\/\\/.+\\..+\$|i";
    return preg_match($mask, textLow($s));
}
function getDomain($s)
{
    $mask = "|^(?:https?:\\/\\/)?(?:www\\.)?([^\\/]+)|i";
    preg_match($mask, textLow($s), $a);
    return $a[1];
}
function validDomain($s)
{
    return preg_match("|.+\\..+\$|", $s);
}
function valid_filename($f)
{
    return !sEmpty($f) && $f != "." && $f != ".." && textPos("/", $f) < 0 && textPos(chr(0), $f) < 0;
}
function compare_ip($ip1, $ip2, $level = 4)
{
    $ip1 = explode(".", $ip1);
    $ip2 = explode(".", $ip2);
    for ($i = 0; $i <= $level - 1; $i++) {
        if ($ip1[$i] != $ip2[$i]) {
            return false;
        }
    }
    return true;
}
function numInRange($z, $a, $b)
{
    return $a <= $z && $z <= $b;
}
function numRange($z, $a, $b)
{
    if ($z < $a) {
        $z = $a;
    } else {
        if ($b < $z) {
            $z = $b;
        }
    }
    return $z;
}
function calcPerc($sum, $perc, $r = 2)
{
    return round($sum * $perc / 100, $r);
}
function idArrayCreate($arr, $fld = 0)
{
    $res = array();
    foreach ($arr as $r) {
        $res[$r[$fld]] = $r;
    }
    return $res;
}
function idArrayFind($arr, $fld, $value)
{
    foreach ($arr as $i => $r) {
        if ($r[$fld] == $value) {
            return $i;
        }
    }
}
function idArraySum($arr, $fld)
{
    $z = 0;
    foreach ($arr as $r) {
        $z += $r[$fld];
    }
    return $z;
}
function asArray($a, $dlm = ",", $skip_empty = true)
{
    if (is_array($a)) {
        return $a;
    }
    $r = array();
    foreach (explode($dlm, $a) as $v) {
        $v = trim($v);
        if (!$skip_empty || !sEmpty($v)) {
            $r[] = $v;
        }
    }
    return $r;
}
function asStr($s, $dlm = ",")
{
    if (!is_array($s)) {
        return $s;
    }
    return strval(@implode($dlm, $s));
}
function arrayToStr($a)
{
    if (is_array($a)) {
        return serialize($a);
    }
    return $a;
}
function strToArray($s)
{
    if (is_array($a = @unserialize($s))) {
        return $a;
    }
    return array();
}
function encodeArrayToStr($arr, $key)
{
    return encode1(arraytostr($arr), $key, true, ord($key) % 8);
}
function decodeArrayFromStr($s, $key)
{
    return strtoarray(decode1($s, $key, true, ord($key) % 8));
}
function fullURL($url = "*", $as_HTTPS = -1)
{
    global $_GS;
    $url = trim($url);
    if ($url == "*") {
        $url = $_GS["uri"];
    } else {
        $url = get1ElemL($url, "\n");
    }
    if (!validurl($url)) {
        if ($as_HTTPS === -1) {
            $as_HTTPS = $_GS["https"];
        }
        $url = getrooturl($as_HTTPS) . $url;
    }
    return $url;
}
function goToURL($url = "*", $work_after = 0)
{
    /* DISABLE LICENSE CHECK
    if (1 < abs(chklic() - time())) {
        exit;
    }
    */
    $url = fullurl($url);
    session_commit();
    session_start();
    session_regenerate_id();
    header("Location: " . $url);
    $work_after = intval($work_after);
    if ($work_after < 1) {
        exit;
    }
    @ignore_user_abort(1);
    @set_time_limit($work_after);
    header("Connection: close");
    header("Content-Length: 0");
    ob_end_clean();
    ob_end_flush();
    flush();
}
function refreshToURL($t = 0, $url = "*")
{
    if ($t < 1) {
        $t = 1;
    }
    $url = fullurl($url);
    session_commit();
    session_start();
    session_regenerate_id();
    header("Refresh: " . $t . "; URL=" . $url);
}
function timeToStamp($t = "*")
{
    if ("" === $t) {
        return "";
    }
    if ("*" === $t) {
        $t = time();
    }
    return gmdate("YmdHis", $t);
}
function stampToTime($p)
{
    if (empty($p)) {
        return NULL;
    }
    $p = str_pad($p, 14, "0", STR_PAD_LEFT);
    return @gmmktime(@substr($p, 8, 2), @substr($p, 10, 2), @substr($p, 12, 2), @substr($p, 4, 2), @substr($p, 6, 2), @substr($p, 0, 4));
}
function subStamps($p1, $p2 = -1)
{
    $t1 = stamptotime($p1);
    if ($p2 < 0) {
        $t2 = $t1;
        $t1 = time();
    } else {
        $t2 = stamptotime($p2);
    }
    return $t1 - $t2;
}
function encode1($text, $pass, $as_hex = true, $dl = 0)
{
    $text = strval(base64_encode($text));
    $pass = mb_strtoupper(md5($pass . mb_strlen($text)));
    $code = "";
    $n = $dl;
    for ($i = 0; $i < mb_strlen($text); $i++) {
        if (mb_strlen($pass) - $dl <= $n) {
            $n = 0;
        }
        $c = ord($text[$i]) ^ ord($pass[$n]);
        $code .= $as_hex ? sprintf("%02x", $c) : chr($c);
        $n++;
    }
    if (!$as_hex) {
        $code = base64_encode($code);
    }
    return $code;
}
function decode1($code, $pass, $as_hex = true, $dl = 0)
{
    if (!$as_hex) {
        $code = base64_decode($code);
    }
    $pass = mb_strtoupper(md5($pass . (mb_strlen($code) >> $as_hex)));
    $text = "";
    $n = $dl;
    $i = 0;
    while ($i < mb_strlen($code)) {
        if (mb_strlen($pass) - $dl <= $n) {
            $n = 0;
        }
        if ($as_hex) {
            $c = hexdec(mb_substr($code, $i, 2));
        } else {
            $c = ord($code[$i]);
        }
        $text .= chr($c ^ ord($pass[$n]));
        $n++;
        $i += 1 + $as_hex;
    }
    return base64_decode($text);
}
/* DISABLE LICENSE CHECK
function chkLic($n = 1)
*/
{
    global $_GS;
    if (rand(1, $n) == 1) {
        $l = trim(@file_get_contents($_GS["domain"] . ".lic"));
        if ($l !== md5("?hhdn@\${aryhe)2273ru@1f/|" . $_GS["domain"])) {
            xstop("No license");
        }
    }
    return time();
}

?>
