<?php

global $ch;
if (function_exists('curl_init')) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 5); 
//	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
} else
	$ch = -1;

function inet_request($url, $par = array(), $cookiefl = '', $agent = '', $onlyheader = false) {
	global $ch;
	try {
		if ($ch < 0) xAbort();
		curl_setopt($ch, CURLOPT_URL, trim($url));
		curl_setopt($ch, CURLOPT_HEADER, $onlyheader);
		curl_setopt($ch, CURLOPT_USERAGENT, ($agent ? $agent : 'Mozilla/5.0 (Windows; U; Windows NT 6.1; ru; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13'));
		if ($onlyheader) 
			curl_setopt($ch, CURLOPT_NOBODY, true);
		elseif (empty($par)) 
			curl_setopt($ch, CURLOPT_HTTPGET, true);
		else {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $par);
		}
		@curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefl);
		@curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefl);
		$answ = curl_exec($ch);
		if (curl_errno($ch) != 0) $answ = false;
	} catch (Exception $e) {
		$answ = false;
	}
	return $answ;
}

function inet_lasturl() {
	global $ch;
	return curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
}

?>