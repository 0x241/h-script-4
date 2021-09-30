<?php
// Templates lib

require_once('smarty3/Smarty.class.php');

global $tpl_page, $tpl_errors;

$tpl_page = new Smarty;
$tpl_page->compile_check = true;
$tpl_page->caching = false;
$tpl_page->debugging = false;
$tpl_page->compile_dir = 'tpl_c';
$tpl_page->template_dir = 'tpl';

$tpl_errors = array();

require_once('lib/main.php');
if (abs(chklic() - time()) > 1) exit;

// Langs

function existLang($lang)
{
	if (sEmpty($lang) or ($lang == '.') or ($lang == '..'))
		return false;
	//return is_dir("tpl/$lang");
	return true;
}

function getLang($lang = '') // '' - current / '*' - default lang
{
	global $_GS;
	if ($lang == '')
		$lang = $_GS['lang'];
	elseif ($lang == '*')
		$lang = $_GS['default_lang'];
	if (existLang($lang))
		return $lang;
	return $_GS['default_lang'];
}

function getLangDir($lang = '')
{
	global $_GS;
	$dir = 'tpl/';
	foreach (array(getLang($lang), $_GS['mode'], $_GS['theme']) as $d)
		if (sEmpty($d))
			break;
		else
			if (is_dir($dir . $d))
				$dir .= $d . '/';
			else
				break;
	return $dir;
}

// Page
// conv: 0 (00) - none / 1,3 (x1) - lang filter / 2,3 (1x) - html filter / 4 (1xx) - strip tags
function prepVal(&$vl, $conv) {
	global $_GS;
	if (!is_array($vl))
	{
		if ($conv & 1) // and ($vl{0} == '<'))
			$vl = textLangFilter($vl, $_GS['lang']);
		if ($conv & 2)
			$vl = htmlspecialchars($vl, ENT_QUOTES);
		elseif ($conv & 4)
			$vl = strip_tags($vl);
	}
	else
		foreach ($vl as $f => $v)
			prepVal($vl[$f], $conv);
}

function setPage($par, $val, $conv = 3)
{
	global $tpl_page;
	if ($conv > 0)
		prepVal($val, $conv);
	$tpl_page->assign($par, $val);
}

function showPage($templ = '', $module = false, $exit_after = true)
{
	global $tpl_page, $tpl_errors, $_IN, $_GS, $_DF, $_cfg;
	if ($module === false)
		$module = $_GS['module'];
	setPage('tpl_module', $module);
	setPage('tpl_vmodule', $_GS['vmodule']);
	if (file_exists($_GS['module_dir'] . $module . '.php'))
	{
		$t = cutElemR($module, '/');
		if (!$templ)
			$templ = $t;
	}
	else
		if (!$templ)
			$templ = 'index';
	setPage('tpl_name', $templ);
	$templ = $module . '/' . $templ;
	setPage('tpl_filename', $templ);
	loadDateFormat($lang);
	setPage('InputDateFormatLong', trim($_DF[$lang][3]));
	setPage('InputDateFormat', trim($_DF[$lang][4]));
	setPage('tpl_time', time() + $_GS['TZ']);
	setPage('_IN', $_IN);
	setPage('tpl_info', getInfoData('*'));
	setPage('tpl_errors', $tpl_errors);
	$tpl_page->template_dir = $_GS['lang_dir'];
	if (abs(chklic(5) - time()) > 1) exit;
	if ($_cfg['Sys_ForceCharset'])
		header("Content-Type: text/html; charset=utf-8");
	$tpl_page->display($templ . '.tpl');
	if ($exit_after)
		exit;
}

function showInfo($code = 'Completed', $url = '*', $data = array())
{
	$url = fullURL($url);
	$_SESSION['_show_info'][$url] = array($code, $data);
	goToURL($url);
}

function showSplash($code = 'Completed', $url = '*', $data = array(), $templ = 'splash', $tm = 0)
{
	$url = fullURL($url);
	$_SESSION['_show_info'][$url] = array($code, $data);
	if ($tm < 1)
		$tm = (substr($code, 0, 1) == '*' ? 3 : 1);
	refreshToURL($tm, $url);
	setPage('url', $url);
	showPage($templ);
}

function showFormInfo($code = 'Completed', $form = '', $data = array())
{
	$_SESSION['_show_info'][getFormName($form)] = array($code, $data);
	goToURL(fullURL());
}

function getInfoData($id = '', $and_unset = true)
{
	$id = ($id == '*' ? fullURL() : getFormName($id));
	$info = @$_SESSION['_show_info'][$id];
	if ($and_unset)
		unset($_SESSION['_show_info'][$id]);
	return $info;
}

function getFormName($form = '')
{
	global $_GS;
	if (!$form or is_int($form))
		return $_GS['module'] . '_frm' . $form;
	else
		return $form;
}

// Form support

function sendedForm($btn = '', $form = '')
{
	global $_IN;
	$form = getFormName($form) . '_btn' . $btn;
    
	if ($res = isset_IN($form));
		unset($_IN[$form]);
	return $res;
}

function setError($e, $form = '', $and_break = true)
{
	if (!is_string($e)) // no error
		return;
	global $tpl_errors;
	$tpl_errors[getFormName($form)][] = $e;
	if ($and_break)
		xAbort($e);
}

function breakIfError($form = '', $e = 'Error')
{
	global $tpl_errors;
	if (count($tpl_errors[getFormName($form)]) > 0)
		xAbort($e);
}

// Multilang support

function loadText($section, $file = 'texts', $lang = '')
{
	$file = getLangDir($lang) . "{$file}_$lang.lng";
	if (!file_exists($file))
		return false;
	$res = array();
	$celem = ''; // current section name
	$is = false; // current section == $section
	$h = fopen($file, 'r');
	while (!feof($h))
	{
		$s = trim(fgets($h, 4096));
		if (substr($s, 0, 2) == '//') // remark
			continue;
		if ((substr($s, 0, 1) == '[') and (substr($s, -1) == ']')) // next section
		{
			if ($is and (textPos('.', $celem) < 0))
				break; // last section is non-dot (simple)
			$celem = trim(substr($s, 1, -1));
			$is = (get1ElemL($celem, '.') == $section);
		}
		elseif ($is)
			$res[$celem] .= $s . HS2_NL;
	}
	fclose($h);
	return $res;
}

// Mail sending

function sendMailToUser($mail, $section, $consts = array(), $lang = '', $fname = 'e-mails')
{
	global $_GS, $_cfg;
	if (!validMail($mail) or !$section)
		return false;
	$lang = getLang($lang);
	$txt = loadText($section, $fname, $lang);
	if (!$txt["$section.message"])
		return false;
	$hdr = loadText('_header', $fname, $lang);
	$ftr = loadText('_footer', $fname, $lang);
	$consts['date'] = timeToStr(time(), 0, $lang);
	$consts['ip'] = $_GS['client_ip'];
	$consts['rooturl'] = $_GS['root_url'];
	$consts['sitename'] = $_cfg['Sys_SiteName'];
	prepVal($consts, 2);
	foreach ($consts as $k=>$v)
	    if (is_array($v))  $consts[$k]='';
	return sendMail(
		$mail,
		textVarReplace($txt["$section.topic"], $consts),
		nl2br(textVarReplace(
			$hdr['_header'] . $txt["$section.message"] . $ftr['_footer'],
			$consts
		)),
		$_cfg['Sys_NotifyMail']
	);
}

function sendMailToAdmin($section, $consts = array())
{
	global $_cfg;
	return sendMailToUser($_cfg['Sys_AdminMail'], $section, $consts, $_cfg['Sys_AdminLang'], 'admin/admin/e-mails');
}

// Dates support

global $_DF;
$_DF = array(
	0 => array(
		'% H:i', '* j, Y', 'MDYHI', 'm/d/y h:m', 'm/d/y',
		'm' => array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
		'f' => array('yesterday', 'today', 'tomorrow')
	)
);

function loadDateFormat(&$lang)
{
	global $_DF;
	$lang = getLang($lang);
	if (isset($_DF[$lang]))
		return;
	//$df = getLangDir($lang) . 'date.lng';
	$df = 'tpl/date_'.$lang.'.lng';
	if (file_exists($df))
	{
		$a = @file($df);
		$l1 = explode('|', @$a[0], 5);
		$l2 = explode('|', @$a[1], 12);
		$l3 = explode('|', @$a[2], 6);
		if ((count($l1) >= 3) and (count($l2) == 12))
		{
			$_DF[$lang] = $l1;
			$_DF[$lang]['m'] = $l2;
			$_DF[$lang]['f'] = $l3;
		}
	}
	if (!isset($_DF[$lang]))
		$lang = 0;
}

// 0 - date and time / 1 - only date / 2 - human friendly
function timeToStr($t, $format = 0, $lang = '', $tz = '') // in time() format
{
	if (!$t)
		return '';
	global $_GS, $_DF;
	loadDateFormat($lang);
	$s = '';
	if ($tz === '')
		$tz = $_GS['TZ'];
	$t += $tz;
	$t0 = time() + $tz;
	if ($format == 2)
	{
		$n = floor((
			gmmktime(0, 0, 0, gmdate('n', $t), gmdate('j', $t), gmdate('Y', $t)) -
			gmmktime(0, 0, 0, gmdate('n', $t0), gmdate('j', $t0), gmdate('Y', $t0))
			) / HS2_UNIX_DAY);
		$fc = floor(count($_DF[$lang]['f']) / 2);
		if (($n >= -$fc) and ($n <= $fc))
			$s = $_DF[$lang]['f'][$n + $fc];
	}
	if (!$s)
	{
		$s = gmdate($_DF[$lang][1], $t);
		$m = $_DF[$lang]['m'][-1 + gmdate('m', $t)];
		$s = textReplace($s, '*', $m);
	}
	if ($format != 1)
		$s = textReplace(gmdate($_DF[$lang][0], $t), '%', $s);
	return $s;
}

// 0 - date and time / 1 - only date / 2 - it is ending date
function textToTime($sd, $format = 0, $lang = '', $tz = '')
{
	global $_GS, $_DF;
	if (!$sd)
		return '';
	foreach(array('/', '-', ':', ' ', ',', ';') as $d)
		$sd = textReplace($sd, $d, '.');
	$sd = textReplace($sd, '..', '.');
	$d = explode('.', $sd, 5);
	loadDateFormat($lang);
	$sd = textUp($_DF[$lang][2]);
	$a = array(0, 0, 0, 0, 0);
	foreach (array('Y', 'M', 'D', 'H', 'I') as $i => $c)
		$a[$i] = @$d[TextPos($c, $sd)];
	if ($tz === '')
		$tz = $_GS['TZ'];
	$t0 = time() + $tz;
	if (textLen($d[0]) >= 3)
		foreach ($_DF[$lang]['f'] as $n => $m)
			if (textPos(textUp($d[0]), textUp($m)) == 0)
			{
				$t = $t0 + HS2_UNIX_DAY * ($n - floor(count($_DF[$lang]['f']) / 2));
				$a = array(
					gmdate('Y', $t),
					gmdate('n', $t),
					gmdate('j', $t),
					$d[1],
					$d[2]
				);
				break;
			}
	if (!intval($a[2]))
		return '';
	if (textLen($a[1]) >= 3)
		foreach ($_DF[$lang]['m'] as $n => $m)
			if (textPos(textUp($a[1]), textUp($m)) == 0)
			{
				$a[1] = $n + 1;
				break;
			}
	if ($format > 0)
	{
		$a[3] = 0;
		$a[4] = 0;
	}
	if ($a[2] and !$a[0])
	{
		$a[0] = gmdate('Y', $t0);
		if (!intval($a[1]))
			$a[1] = gmdate('n', $t0);
	}
	if ($t = gmmktime(intval($a[3]), intval($a[4]), 0, intval($a[1]), intval($a[2]), intval($a[0])))
	{
		if (($format == 2) and ($t > 0))
			$t += HS2_UNIX_DAY - 1;
		$t -= $tz;
	}
	return $t;
}

function stampArrayToStr(&$a, $keys, $format = 2, $lang = '')
{
	if (is_array($a) and $a)
		foreach (asArray($keys) as $k)
			$a[$k] = timeToStr(stampToTime($a[$k]), $format, $lang);
}

function stampTableToStr(&$a, $keys, $format = 2, $lang = '')
{
	if (is_array($a) and $a and ($keys = asArray($keys)))
		foreach ($a as $i => $r)
			stampArrayToStr($a[$i], $keys, $format, $lang);
}

function strArrayToStamp(&$a, $keys, $format = 0, $lang = '')
{
	if (is_array($a) and $a)
		foreach (asArray($keys) as $k)
			$a[$k] = timeToStamp(textToTime($a[$k], $format, $lang));
}

// Form security

function getFormCert($form = '')
{
	if (!isset($_SESSION))
		return false;
	$form = getFormName($form);
	$s = substr(md5(time() . rand()), 0, 8);
	$_SESSION['_cert'][$form] = $s;
	if (count($_SESSION['_cert']) > 10)
		array_shift($_SESSION['_cert']);
	return "<input name=\"__Cert\" value=\"$s\" type=\"hidden\">";
}

function chkFormCert($s, $form = '')
{
	if (!isset($_SESSION) or !$s)
		return false;
	$form = getFormName($form);
	if (!isset($_SESSION['_cert'][$form]))
		return false;
	$res = ($_SESSION['_cert'][$form] === $s);
	unset($_SESSION['_cert'][$form]);
	return $res;
}

// Check form

function checkFormSecurity($form = '')
{
	$form = getFormName($form);
	if (!chkFormCert(_IN('__Cert'), $form))
		xSysStop('Security: Wrong form certificate', true);
	global $_IN;
	unset($_IN['__Cert']);
	if (function_exists('chkCaptcha') and !chkCaptcha($form))
		setError('captcha_wrong', $form);
}

function tplFormSecurity($params, $tpl_page)
{
	$form = getFormName($params['form']);
	if (function_exists('getCaptcha'))
		$tpl_page->assign('__Capt', getCaptcha(0 + $params['captcha'], $form));
	return getFormCert($form);
}

$tpl_page->registerPlugin('function', '_getFormSecurity', 'tplFormSecurity');

?>