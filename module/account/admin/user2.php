<?php

$_auth = 90;
require_once('module/auth.php');
require_once('lib/psys.php');

$table = 'Users';
$id_field = 'uID';
$out_link = moduleToLink('account/admin/users');

useLib('balance');

try 
{

	if (sendedForm()) 
	{
		checkFormSecurity();
		
		$a = $_IN;
		if (!($id = $a['auID']))
			showInfo('*Error', $out_link);
		
		if ($_GS['demo'] and ($_user['uLevel'] < 99) and ($id <= 3))
			showInfo('*Denied');
			
		if (($_cfg['Account_UseName'] == 2) and !$a['aName'])
			setError('name_empty');
		list($h, $m) = explode(':', $a['aTZ'], 2);
		if ((abs($h) > 12) or ($m < 0) or ($m >= 60))
			setError('tz_wrong');
		$a['aTZ'] = $h * 60 + $m;
		$a['aTimeOut'] = abs($a['aTimeOut']);
		if ($_cfg['Sec_MinSQA'] > 0)
		{
			if (!$a['aSQuestion'])
				setError('secq_empty');
			if (strlen($a['aSQuestion']) < $_cfg['Sec_MinSQA'])
				setError('secq_short');
			$f = 'aSQuestion, ';
			if (!sEmpty($a['aSAnswer']))
			{
				if (strlen($a['aSAnswer']) < $_cfg['Sec_MinSQA'])
					setError('seca_short');
				if ($a['aSAnswer'] == $a['aSQuestion'])
					setError('seqa_equal_secq');
				$a['aSAnswer'] = md5($a['aSAnswer'] . $_cfg['Const_Salt']);
				$f .= 'aSAnswer, ';
			} 
			else
				unset($a['aSAnswer']);
		}
		else
			$f = '';
		strArrayToStamp($a, 'aBD', 1);
		$a['aSessIP'] = $a['aSessIP'];
		$a['aSessUniq'] = $a['aSessUniq'];
		$db->update('AddInfo', $a, '', 'auID=?d', array($a['auID']));
		showInfo('Saved', $out_link . "?id=$id");
	}

	if (sendedForm('', 'wallets'))
	{
		checkFormSecurity('wallets');

		$a = $_IN;
		
		if ($_cfg['Const_IntCurr'])
			if ((_INN('DefCurr') <= 1) or !$_currs[_INN('DefCurr')])
				setError('psys_wrong', 'wallets');
		$db->update('AddInfo', array('aDefCurr' => _INN('DefCurr')), '', 'auID=?d', array($a['auID']));
			
		$t = time();
		$_ucurrs = $db->fetchIDRows($db->select('Currs LEFT JOIN Wallets ON wcID=cID and wuID=?d',
			'*', 'cDisabled=0', array($a['auID']), 'cID'), false, 'cID');
		foreach ($_ucurrs as $cid => $c)
		{
			$p = opDecodeUserCurrParams($c);
			$pf = getPayFields($c['cCID']);
			$key = $cid . $a['auID'] . $t;
			setError($p = opEditToCurrParams($pf, array(), (array)_IN($c['cCID']), $c['cCID']), 'wallets');
			$p = array(
				'wParams' => encodeArrayToStr($p, $key),
				'wMTS' => timetostamp($t)
			);
			if (!$c['wcID'])
			{
				$p['wcID'] = $cid;
				$p['wuID'] = $a['auID'];
				$db->insert('Wallets', $p);
			}
			else
				$db->update('Wallets', $p, '', 'wcID=?d and wuID=?d', array($cid, $a['auID']));
		}
		showInfo('Saved');
	}

} 
catch (Exception $e) 
{
}

if ($uid = _GETN('id'))
	$el = $db->fetch1Row($db->select("$table LEFT JOIN AddInfo ON auID=uID", 
		'*', "$id_field=?d", array(_GETN('id'))));
if (!$el)
	goToURL(moduleToLink() . '?add');
stampArrayToStr($el, 'aCTS');
stampArrayToStr($el, 'aBD', 1);
$el['aTZ'] = sprintf("%+02d:%02d", floor($el['aTZ'] / 60), abs($el['aTZ'] % 60));
setPage('el', $el, 2);

$defcurr = array();
$wfields = array();
$wdata = array('auID' => $uid);
$_ucurrs = $db->fetchIDRows($db->select('Currs LEFT JOIN Wallets ON wcID=cID and wuID=?d',
	'*', 'cDisabled=0', array($uid), 'cID'), false, 'cID');
foreach ($_ucurrs as $cid => $c)
{
	if ($cid > 1)
		$defcurr[$cid] = $c['cName'];
	$wdata[$c['cCID']] = opDecodeUserCurrParams($c);
	if ($a = opCurrParamsToEdit(getPayFields($c['cCID']), $c['cCID']))
	{
		$wfields[$cid] = $c['cName'];
		$wfields = array_merge($wfields, $a);
	}
}
setPage('defcurr', $defcurr);
setPage('wfields', $wfields);
setPage('wdata', $wdata);

showPage();

?>