<?php

function captchaGetHTML($form)
{
	$url = moduleToLink('captcha') . "?f=$form";
	return "<img src=\"$url\" onclick=\"this.src='$url&'+Math.random();\" border=\"0\" class=\"captcha\">";
}

function captchaCheck($form)
{
	$rk = @$_SESSION['_capt'][$form]; // real (true) code
	unset($_SESSION['_capt'][$form]);
	return ($rk and (_RQ('__Capt') === $rk));
}

?>