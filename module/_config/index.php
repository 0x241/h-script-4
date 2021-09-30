<?php

error_reporting(0);
session_start();

function getMsg()
{
	return '' . @$_SESSION['cfg_info_message'];
}

function addMsg($s)
{
	$_SESSION['cfg_info_message'] .= "$s<br>";
}

function showMsg()
{
	if ($s = getMsg())
	{
		unset($_SESSION['cfg_info_message']);
		echo "<fieldset>$s</fieldset>";
	}
}

if (!$_SESSION['cfg_logged'])
	if (!isset($_GET['login']))
		goToURL($_cfg['cfg_link'] . '?login');

$pass = trim(@file_get_contents('module/_config/pass'));
if (!$pass)
	$_GET['pass'] = 1;
elseif (!$_cfg['cfg_link'])
	$_GET['setup'] = 1;
foreach (array('login', 'pass', 'setup', 'install', 'modules', 'update') as $m)
	if (isset($_GET[$m]))
	{
		include("module/_config/$m.php");
		exit;
	}
	
include("module/_config/modules.php");

?>