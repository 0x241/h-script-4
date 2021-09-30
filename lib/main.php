<?php

if (!function_exists('mb_strtoupper'))
{
	function mb_strlen($string) {
		return strlen($string);
	}
	function mb_strtoupper($string) {
		return strtoupper($string);
	}
}

if (version_compare(PHP_VERSION, '5.6.0', '<'))
	require_once('lib/main53.php');
elseif (version_compare(PHP_VERSION, '7.2.0', '<'))
	require_once('lib/main56.php');
else
	require_once('lib/main72.php');