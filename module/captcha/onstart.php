<?php

require('module/captcha/default/onstart.php');

// Captcha support

function getCaptcha($mode, $form = '')
{
	if (!isset($_SESSION))
		return false;
	$res = '';
	$t = 0; // no captcha needs
	if ($mode > 0)
		if (($mode > 1) or (abs(time() - $_SESSION['_captTS'][$form]) < HS2_UNIX_MINUTE)) 
		{
			if (function_exists('captchaGetHTML'))
				$res = captchaGetHTML($form);
			$t = time();
		}
	$_SESSION['_captTS'][$form] = $t;
	return $res;
}

function chkCaptcha($form = '') 
{
	if (!isset($_SESSION))
		return false;
	$res = false;
	$form = getFormName($form);
	$t = $_SESSION['_captTS'][$form];
	if ($t === '') // at least must be 0
		xSysStop('Security: Wrong form data', true); // ??? return false;
	$nt = time();
	if ($t > 0) 
	{
		if (function_exists('captchaCheck'))
			if ($res = captchaCheck($form))
				$nt = 0;
	} 
	else
		$res = true;
	$_SESSION['_captTS'][$form] = $nt;
	return $res;
}

function resetCaptcha($form = '')
{
	if (!isset($_SESSION))
		return false;
	$form = getFormName($form);
	$_SESSION['_captTS'][$form] = 0;
}

?>