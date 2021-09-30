<?php

require('module/auth.php');

$lang = _RQ('lang');
$mode = _RQ('mode');
$theme = _RQ('theme');
$url = exValue($_SERVER['HTTP_REFERER'], _RQ('url'));
if (fullURL(get1ElemL($url, '?')) == fullURL(moduleToLink('system')))
	$url = moduleToLink('index');
if (sEmpty($lang))
{
	setPage('url', $url);
	setPage('langs', $_cfg['UI__Langs']);
	showPage();
}

if (@in_array($lang, $_cfg['UI__Langs']))
{
	setcookie('lang', $lang, time() + 30 * HS2_UNIX_DAY, '/');
	setcookie('mode', $mode, time() + 30 * HS2_UNIX_DAY, '/');
	setcookie('theme', $theme, time() + 30 * HS2_UNIX_DAY, '/');
	if (_uid())
		$db->update('Users', array('uLang' => $lang, 'uMode' => $mode, 'uTheme' => $theme), '', 'uID=?d', array(_uid()));
}

goToURL($url);

?>