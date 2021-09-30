<?php

$keyfield = 'a-ddos';
$askfreq = 1000000;

if (isset_IN($keyfield))
{
	if (_IN($keyfield) !== $_SESSION['a-ddos_code']['code'])
		exit;
	unset($_SESSION['a-ddos_code']);
	$_SESSION['a-ddos'] = $askfreq;
	goToURL();
}
$_SESSION['a-ddos'] = intval($_SESSION['a-ddos']) - 1;
if (($_SESSION['a-ddos'] < 0) and ((count($_POST) == 0) or ($_SESSION['a-ddos'] < -1)))
{
	if (!isset($_SESSION['a-ddos_code']))
		$_SESSION['a-ddos_code'] = array(
			'code' => uniqid()
			);
	$h = file_get_contents('a-ddos/a-ddos.html');
	$a = array(
		'keyfield' => $keyfield,
		'key' => $_SESSION['a-ddos_code']['code']
		);
	foreach ($a as $f => $v)
		$h = str_replace('#' . $f . '#', $v, $h);
	echo($h);
	exit;
}

?>