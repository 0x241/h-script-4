<?php

$_auth = 1;
require_once('module/auth.php');
require_once('lib/psys.php');


try 
{

	if (sendedForm()) 
	{
		checkFormSecurity();

		$a = $_IN;
		if (($_cfg['Sec_MinPIN'] > 0) and (md5($a['PIN'] . $_cfg['Const_Salt']) != $_user['uPIN']))
			setError('pin_wrong');
			
		if (!$_currs2[_INN('DefCurr')])
			setError('psys_wrong');
		$db->update('AddInfo', array('aDefCurr' => _INN('DefCurr')), '', 'auID=?d', array(_uid()));
			
		$t = time();
        
		foreach ($_currs2 as $cid => $c)
		{
			$a = opDecodeUserCurrParams($c);
			if ($_cfg['Bal_LockWallets'] and $a['acc'])
				continue;
			$pf = getPayFields($c['cCID']);
			$key = $cid . _uid() . $t;
			setError($p = opEditToCurrParams($pf, array(), (array)_IN($c['cCID']), $c['cCID']));
			$a = array(
				'wParams' => encodeArrayToStr($p, $key),
				'wMTS' => timetostamp($t)
			);
			if (!$c['wcID'])
			{
				$a['wcID'] = $cid;
				$a['wuID'] = _uid();
				$db->insert('Wallets', $a);
			}
			else
				$db->update('Wallets', $a, '', 'wcID=?d and wuID=?d', array($cid, _uid()));
		}

		showInfo('Saved');
	}

}
catch (Exception $e)
{
}

$defcurr = array();
$wfields = array();
$wdata = array();
$showbutton = false;
foreach ($_currs2 as $cid => $c)
{
	$defcurr[$cid] = $c['cName'];
	$wdata[$c['cCID']] = opDecodeUserCurrParams($c);
	$l = ($wdata[$c['cCID']]['acc'] and $_cfg['Bal_LockWallets']);
	if ($a = opCurrParamsToEdit(getPayFields($c['cCID']), $c['cCID'], $l))
	{
		$a[$c['cCID'] . '[acc]'][1] = $c['cName'];
//		$wfields[$cid] = $c['cName'];
		$wfields = array_merge($wfields, $a);
		$showbutton = ($showbutton or !$l);
	}
}
setPage('defcurr', $defcurr);
setPage('wfields', $wfields);
setPage('wdata', $wdata);
setPage('showbutton', $showbutton);

showPage();

?>