<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'Users';
$id_field = 'uID';
$out_link = moduleToLink('account/admin/users');

try 
{

	if (sendedForm()) 
	{
		checkFormSecurity();
		
		useLib('account/register');
		$a = $_IN;
		if (!($id = $a[$id_field]))
		{
			setError($id = opRegisterPrepare($a, true));
			showInfo('Added', moduleToLink() . "?id=$id");
		}
		
		if ($_GS['demo'] and ($_user['uLevel'] < 99))
		{
			if ($id <= 3)
				showInfo('*Denied');
			$a['uLevel'] = 1;
		}
			
		setError(opRegisterUserCheck($a, $id, true));
		strArrayToStamp($a, 'uBTS');
		if ($id = $db->save($table, $a, 
			'uGroup, uLogin, uMail, uState, uBTS, uLevel, uLang, uMode, uTheme, uRef, uBFC, uWDDisable' .
			valueIf($a['uPass'], ', uPass, uPTS') . valueIf($a['uPIN'], ', uPIN'), $id_field)
		)
			showInfo('Saved', $out_link . "?id=$id");
		showInfo('*Error');
	}

} 
catch (Exception $e) 
{
}

if (!isset($_GET['add']))
{
	if (_GETN('id'))
		$el = $db->fetch1Row($db->select("$table LEFT JOIN AddInfo ON auID=uID LEFT JOIN Users U ON U.uID=Users.uRef", 
		"$table.*, AddInfo.*, U.uLogin as uRef", "$table.$id_field=?d", array(_GETN('id'))));
	if (!$el)
		goToURL(moduleToLink() . '?add');
	if (isset($_GET['login']) and (!$_GS['demo'] or ($_user['uLevel'] == 99)))
	{
		useLib('account/login');
		opLogin($el['uID'], '', false, true);
	}
	stampArrayToStr($el, 'uBTS, uLTS');
	setPage('el', $el, 2);
	$langs = array();
	foreach ($_cfg['UI__Langs'] as $l)
		$langs[$l] = $l;
	setPage('langs', $langs);
    
    
	$_currs1 = array();
	foreach (array('USD', 'EUR', 'RUB', 'BTC', 'ETH', 'XRP') as $cn)
		foreach (array('Bal', 'Lock', 'Out') as $p)
			$_currs1[$cn][$p] = $el["u$p$cn"];
	setPage('currs', $_currs1);
    //
	//setPage('currs', $db->fetchIDRows($db->select('Currs LEFT JOIN Wallets ON wcID=cID and wuID=?d', '*', '', array($el['uID']), 'cID'), false, 'cID'));
//	$ips = $db->fetchRows($db->select('Hist', 'hIP, hTS', "hOper='LOGIN' and huID=?d", array($el['uID']), 'hTS desc', '10'));
//	stampTableToStr($ips, 'hTS');
//	setPage('ips', $ips);
}
showPage();
?>