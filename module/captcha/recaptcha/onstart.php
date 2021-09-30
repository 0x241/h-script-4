<?php

require_once('module/captcha/recaptcha/recaptchalib.php');

global $publickey, $privatekey;
// Get a key from https://www.google.com/recaptcha/admin/create
$publickey = '6Lfb7MoSAAAAAOGIUfAgzb9OUPM1L5kGRkrFMGvQ';
$privatekey = '6Lfb7MoSAAAAAPcaPpuaSHwN_RhL5vDKJeHyi7fy';

function captchaGetHTML($form)
{
	global $publickey;
	$error = null;
	return recaptcha_get_html($publickey, $error);
}

function captchaCheck($form)
{
	global $privatekey;
	$resp = recaptcha_check_answer(
		$privatekey,
		$_SERVER["REMOTE_ADDR"],
		$_POST["recaptcha_challenge_field"],
		$_POST["recaptcha_response_field"]
	);
	return $resp->is_valid;
}

?>