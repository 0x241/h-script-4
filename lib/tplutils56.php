<?php

require_once "smarty3/Smarty.class.php";
global $tpl_page;
global $tpl_errors;
$tpl_page = new Smarty();
$tpl_page->compile_check = true;
$tpl_page->caching = false;
$tpl_page->debugging = false;
$tpl_page->compile_dir = "tpl_c";
$tpl_page->template_dir = "tpl";
$tpl_errors = array();
require_once "lib/main.php";
/* DISABLE LICENSE CHECK
if (1 < abs(chklic() - time())) {
    exit;
}
*/
global $_DF;
$_DF = array(array("% H:i", "* j, Y", "MDYHI", "m/d/y h:m", "m/d/y", "m" => array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"), "f" => array("yesterday", "today", "tomorrow")));
$tpl_page->registerPlugin("function", "_getFormSecurity", "tplFormSecurity");
function existLang($lang)
{
    if (sEmpty($lang) || $lang == "." || $lang == "..") {
        return false;
    }
    return is_dir("tpl/" . $lang);
}
function getLang($lang = "")
{
    global $_GS;
    if ($lang == "") {
        $lang = $_GS["lang"];
    } else {
        if ($lang == "*") {
            $lang = $_GS["default_lang"];
        }
    }
    if (existlang($lang)) {
        return $lang;
    }
    return $_GS["default_lang"];
}
function getLangDir($lang = "")
{
    global $_GS;
    $dir = "tpl/";
    foreach (array(getlang($lang), $_GS["mode"], $_GS["theme"]) as $d) {
        if (sEmpty($d)) {
            break;
        }
        if (is_dir($dir . $d)) {
            $dir .= $d . "/";
        } else {
            break;
        }
    }
    return $dir;
}
function prepVal(&$vl, $conv)
{
    global $_GS;
    if (!is_array($vl)) {
        if ($conv & 1) {
            $vl = textLangFilter($vl, $_GS["lang"]);
        }
        if ($conv & 2) {
            $vl = htmlspecialchars($vl, ENT_QUOTES);
        } else {
            if ($conv & 4) {
                $vl = strip_tags($vl);
            }
        }
    } else {
        foreach ($vl as $f => $v) {
            prepVal($vl[$f], $conv);
        }
    }
}
function setPage($par, $val, $conv = 3)
{
    global $tpl_page;
    if (0 < $conv) {
        prepval($val, $conv);
    }
    $tpl_page->assign($par, $val);
}
function showPage($templ = "", $module = false, $exit_after = true)
{
    global $tpl_page;
    global $tpl_errors;
    global $_IN;
    global $_GS;
    global $_DF;
    global $_cfg;
    if ($module === false) {
        $module = $_GS["module"];
    }
    setpage("tpl_module", $module);
    setpage("tpl_vmodule", $_GS["vmodule"]);
    if (file_exists($_GS["module_dir"] . $module . ".php")) {
        $t = cutElemR($module, "/");
        if (!$templ) {
            $templ = $t;
        }
    } else {
        if (!$templ) {
            $templ = "index";
        }
    }
    setpage("tpl_name", $templ);
    $templ = $module . "/" . $templ;
    setpage("tpl_filename", $templ);
    loadDateFormat($lang);
    setpage("InputDateFormatLong", trim($_DF[$lang][3]));
    setpage("InputDateFormat", trim($_DF[$lang][4]));
    setpage("tpl_time", time() + $_GS["TZ"]);
    setpage("_IN", $_IN);
    setpage("tpl_info", getInfoData("*"));
    setpage("tpl_errors", $tpl_errors);
    $tpl_page->template_dir = $_GS["lang_dir"];
    /* DISABLE LICENSE CHECK
    if (1 < abs(chklic(5) - time())) {
        exit;
    }
    */
    if ($_cfg["Sys_ForceCharset"]) {
        header("Content-Type: text/html; charset=utf-8");
    }
    $tpl_page->display($templ . ".tpl");
    if ($exit_after) {
        exit;
    }
}
function showInfo($code = "Completed", $url = "*", $data = array())
{
    $url = fullURL($url);
    $_SESSION["_show_info"][$url] = array($code, $data);
    goToURL($url);
}
function showSplash($code = "Completed", $url = "*", $data = array(), $templ = "splash", $tm = 0)
{
    $url = fullURL($url);
    $_SESSION["_show_info"][$url] = array($code, $data);
    if ($tm < 1) {
        $tm = substr($code, 0, 1) == "*" ? 3 : 1;
    }
    refreshToURL($tm, $url);
    setpage("url", $url);
    showpage($templ);
}
function showFormInfo($code = "Completed", $form = "", $data = array())
{
    $_SESSION["_show_info"][getFormName($form)] = array($code, $data);
    goToURL(fullURL());
}
function getInfoData($id = "", $and_unset = true)
{
    $id = $id == "*" ? fullURL() : getFormName($id);
    $info = $_SESSION["_show_info"][$id];
    if ($and_unset) {
        unset($_SESSION["_show_info"][$id]);
    }
    return $info;
}
function getFormName($form = "")
{
    global $_GS;
    if (!$form || is_int($form)) {
        return $_GS["module"] . "_frm" . $form;
    }
    return $form;
}
function sendedForm($btn = "", $form = "")
{
    global $_IN;
    $form = getformname($form) . "_btn" . $btn;
    if ($res = isset_IN($form)) {
    }
    unset($_IN[$form]);
    return $res;
}
function setError($e, $form = "", $and_break = true)
{
    if (!is_string($e)) {
        return NULL;
    }
    global $tpl_errors;
    $tpl_errors[getformname($form)][] = $e;
    if ($and_break) {
        xAbort($e);
    }
}
function breakIfError($form = "", $e = "Error")
{
    global $tpl_errors;
    if (0 < count($tpl_errors[getformname($form)])) {
        xAbort($e);
    }
}
function loadText($section, $file = "texts", $lang = "")
{
    $file = getlangdir($lang) . (string) $file . ".lng";
    if (!file_exists($file)) {
        return false;
    }
    $res = array();
    $celem = "";
    $is = false;
    $h = fopen($file, "r");
    while (!feof($h)) {
        $s = trim(fgets($h, 4096));
        if (substr($s, 0, 2) == "//") {
            continue;
        }
        if (substr($s, 0, 1) == "[" && substr($s, -1) == "]") {
            if ($is && textPos(".", $celem) < 0) {
                break;
            }
            $celem = trim(substr($s, 1, -1));
            $is = get1ElemL($celem, ".") == $section;
        } else {
            if ($is) {
                $res[$celem] .= $s . HS2_NL;
            }
        }
    }
    fclose($h);
    return $res;
}
function sendMailToUser($mail, $section, $consts = array(), $lang = "", $fname = "e-mails")
{
    global $_GS;
    global $_cfg;
    if (!validMail($mail) || !$section) {
        return false;
    }
    $lang = getlang($lang);
    $txt = loadtext($section, $fname, $lang);
    if (!$txt[(string) $section . ".message"]) {
        return false;
    }
    $hdr = loadtext("_header", $fname, $lang);
    $ftr = loadtext("_footer", $fname, $lang);
    $consts["date"] = timeToStr(time(), 0, $lang);
    $consts["ip"] = $_GS["client_ip"];
    $consts["rooturl"] = $_GS["root_url"];
    $consts["sitename"] = $_cfg["Sys_SiteName"];
    prepval($consts, 2);
    return sendMail($mail, textVarReplace($txt[(string) $section . ".topic"], $consts), textVarReplace($hdr["_header"] . $txt[(string) $section . ".message"] . $ftr["_footer"], $consts), $_cfg["Sys_NotifyMail"]);
}
function sendMailToAdmin($section, $consts = array())
{
    global $_cfg;
    return sendmailtouser($_cfg["Sys_AdminMail"], $section, $consts, $_cfg["Sys_AdminLang"], "admin/e-mails");
}
function loadDateFormat(&$lang)
{
    global $_DF;
    $lang = getlang($lang);
    if (isset($_DF[$lang])) {
        return NULL;
    }
    $df = getlangdir($lang) . "date.lng";
    if (file_exists($df)) {
        $a = @file($df);
        $l1 = explode("|", $a[0], 5);
        $l2 = explode("|", $a[1], 12);
        $l3 = explode("|", $a[2], 6);
        if (3 <= count($l1) && count($l2) == 12) {
            $_DF[$lang] = $l1;
            $_DF[$lang]["m"] = $l2;
            $_DF[$lang]["f"] = $l3;
        }
    }
    if (!isset($_DF[$lang])) {
        $lang = 0;
    }
}
function timeToStr($t, $format = 0, $lang = "", $tz = "")
{
    if (!$t) {
        return "";
    }
    global $_GS;
    global $_DF;
    loaddateformat($lang);
    $s = "";
    if ($tz === "") {
        $tz = $_GS["TZ"];
    }
    $t += $tz;
    $t0 = time() + $tz;
    if ($format == 2) {
        $n = floor((gmmktime(0, 0, 0, gmdate("n", $t), gmdate("j", $t), gmdate("Y", $t)) - gmmktime(0, 0, 0, gmdate("n", $t0), gmdate("j", $t0), gmdate("Y", $t0))) / HS2_UNIX_DAY);
        $fc = floor(count($_DF[$lang]["f"]) / 2);
        if (0 - $fc <= $n && $n <= $fc) {
            $s = $_DF[$lang]["f"][$n + $fc];
        }
    }
    if (!$s) {
        $s = gmdate($_DF[$lang][1], $t);
        $m = $_DF[$lang]["m"][-1 + gmdate("m", $t)];
        $s = textReplace($s, "*", $m);
    }
    if ($format != 1) {
        $s = textReplace(gmdate($_DF[$lang][0], $t), "%", $s);
    }
    return $s;
}
function textToTime($sd, $format = 0, $lang = "", $tz = "")
{
    global $_GS;
    global $_DF;
    if (!$sd) {
        return "";
    }
    foreach (array("/", "-", ":", " ", ",", ";") as $d) {
        $sd = textReplace($sd, $d, ".");
    }
    $sd = textReplace($sd, "..", ".");
    $d = explode(".", $sd, 5);
    loaddateformat($lang);
    $sd = textUp($_DF[$lang][2]);
    $a = array(0, 0, 0, 0, 0);
    foreach (array("Y", "M", "D", "H", "I") as $i => $c) {
        $a[$i] = $d[@TextPos($c, $sd)];
    }
    if ($tz === "") {
        $tz = $_GS["TZ"];
    }
    $t0 = time() + $tz;
    if (3 <= textLen($d[0])) {
        foreach ($_DF[$lang]["f"] as $n => $m) {
            if (textPos(textUp($d[0]), textUp($m)) == 0) {
                $t = $t0 + HS2_UNIX_DAY * ($n - floor(count($_DF[$lang]["f"]) / 2));
                $a = array(gmdate("Y", $t), gmdate("n", $t), gmdate("j", $t), $d[1], $d[2]);
                break;
            }
        }
    }
    if (!intval($a[2])) {
        return "";
    }
    if (3 <= textLen($a[1])) {
        foreach ($_DF[$lang]["m"] as $n => $m) {
            if (textPos(textUp($a[1]), textUp($m)) == 0) {
                $a[1] = $n + 1;
                break;
            }
        }
    }
    if (0 < $format) {
        $a[3] = 0;
        $a[4] = 0;
    }
    if ($a[2] && !$a[0]) {
        $a[0] = gmdate("Y", $t0);
        if (!intval($a[1])) {
            $a[1] = gmdate("n", $t0);
        }
    }
    if ($t = gmmktime(intval($a[3]), intval($a[4]), 0, intval($a[1]), intval($a[2]), intval($a[0]))) {
        if ($format == 2 && 0 < $t) {
            $t += HS2_UNIX_DAY - 1;
        }
        $t -= $tz;
    }
    return $t;
}
function stampArrayToStr(&$a, $keys, $format = 2, $lang = "")
{
    if (is_array($a) && $a) {
        foreach (asArray($keys) as $k) {
            $a[$k] = timetostr(stampToTime($a[$k]), $format, $lang);
        }
    }
}
function stampTableToStr(&$a, $keys, $format = 2, $lang = "")
{
    if (is_array($a) && $a && ($keys = asArray($keys))) {
        foreach ($a as $i => $r) {
            stamparraytostr($a[$i], $keys, $format, $lang);
        }
    }
}
function strArrayToStamp(&$a, $keys, $format = 0, $lang = "")
{
    if (is_array($a) && $a) {
        foreach (asArray($keys) as $k) {
            $a[$k] = timeToStamp(texttotime($a[$k], $format, $lang));
        }
    }
}
function getFormCert($form = "")
{
    if (!isset($_SESSION)) {
        return false;
    }
    $form = getformname($form);
    $s = substr(md5(time() . rand()), 0, 8);
    $_SESSION["_cert"][$form] = $s;
    if (10 < count($_SESSION["_cert"])) {
        array_shift($_SESSION["_cert"]);
    }
    return "<input name=\"__Cert\" value=\"" . $s . "\" type=\"hidden\">";
}
function chkFormCert($s, $form = "")
{
    if (!isset($_SESSION) || !$s) {
        return false;
    }
    $form = getformname($form);
    if (!isset($_SESSION["_cert"][$form])) {
        return false;
    }
    $res = $_SESSION["_cert"][$form] === $s;
    unset($_SESSION["_cert"][$form]);
    return $res;
}
function checkFormSecurity($form = "")
{
    $form = getformname($form);
    if (!chkformcert(_IN("__Cert"), $form)) {
        xSysStop("Security: Wrong form certificate", true);
    }
    global $_IN;
    unset($_IN["__Cert"]);
    if (function_exists("chkCaptcha") && !chkCaptcha($form)) {
        seterror("captcha_wrong", $form);
    }
}
function tplFormSecurity($params, $tpl_page)
{
    $form = getformname($params["form"]);
    if (function_exists("getCaptcha")) {
        $tpl_page->assign("__Capt", getCaptcha(0 + $params["captcha"], $form));
    }
    return getformcert($form);
}

?>
