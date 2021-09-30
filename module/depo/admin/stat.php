<?php

$_auth = 90;
require_once('module/auth.php');

try 
{
	if (sendedForm()/* or !$_IN*/)
	{
//		if ($_IN)
//			checkFormSecurity();
			
		$a = $_IN;
		strArrayToStamp($a, 'D1', 1);
		if ($d1 = $a['D1'])
		{
			$ud1 = " and aCTS>='$d1'";
			$od1 = " and oCTS>='$d1'";
			$dd1 = " and dCTS>='$d1'";
		}
		strArrayToStamp($a, 'D2', 2);
		if ($d2 = $a['D2'])
		{
			$ud2 = " and aCTS<='$d2'";
			$od2 = " and oCTS<='$d2'";
			$dd2 = " and dCTS<='$d2'";
		}
		
		$res = array();
		$res['REG'] = 0 + $db->count('AddInfo', "1$ud1$ud2");
		foreach ($_currs as $cid => $c)
			if ((_IN('PSys') === '0') or ($cid == _IN('PSys')))
			{
				foreach (array('BONUS', 'PENALTY', 'CASHIN', 'REF', 'GIVE', 'TAKE', 'CALCIN', 'CALCOUT', 'CASHOUT') as $o)
					$res[$cid][$o] = $db->fetch1($db->select('Opers', 'SUM(oSum)', "oOper='$o' and oState=3 and ocCurrID='$cid' $od1$od2"));
	//			$res[$cid]['CASHOUT2'] = $db->fetch1($db->select('Opers', 'SUM(oSum)', "oOper='CASHOUT' and oState=2$focurr$od1$od2"));
				$res[$cid]['DEPO'] = $db->fetch1($db->select('Deps', 'SUM(dZD)', "dcCurrID='$cid' $dd1$dd2"));
				$res[$cid]['DEPO2'] = $db->fetch1($db->select('Deps', 'SUM(dZD)', "dState=1 and dcCurrID='$cid' $dd1$dd2"));
			}
		setPage('res', $res);
	}

}
catch (Exception $e) 
{
}

setPage('users', array(
	'all' => $db->count('Users'),
	'active' => $db->count('Users', 'uState=1'),
	'wdepo' => $db->count('Users', 'uState=1 and EXISTS(SELECT dID FROM Deps WHERE duID=uID)')
));
setPage('deps', array(
	'all' => $db->count('Deps'),
	'active' => $db->count('Deps', 'dState=1')
));
setPage('currs', $_currs);
$stat = array();
foreach ($_currs as $cid => $c)
{
	foreach (array('BONUS', 'PENALTY', 'CASHIN', 'REF', 'GIVE', 'TAKE', 'CALCIN', 'CALCOUT', 'CASHOUT') as $o)
	{
		$stat[$cid][$o] = $db->fetch1($db->select('Opers', 'SUM(oSum)', 'oOper=? and ocCurrID=? and oState=3', array($o, $cid)));
//		$stat[0][$o] += $stat[$cid][$o];
	}
	$stat[$cid]['GIVE2'] = $db->fetch1($db->select('Opers', 'SUM(oSum)', 'oOper=? and ocCurrID=? and oState=3 and (oMemo ?%)', array('GIVE', $cid, 'Auto')));
	$stat[$cid]['CASHOUT2'] = $db->fetch1($db->select('Opers', 'SUM(oSum)', 'oOper=? and ocCurrID=? and oState=2', array('CASHOUT', $cid)));
	$stat[$cid]['DEPO'] = $db->fetch1($db->select('Deps', 'SUM(dZD)', 'dcCurrID=? and dState=1', array($cid)));
//	$o = $db->fetch1Row($db->select('Wallets', 'SUM(wBal) AS Z1, SUM(wLock) AS Z2, SUM(wOut) AS Z3', 'wcID=?d', array($cid)));
	$stat[$cid]['BAL'] = $o['Z1'];
	$stat[$cid]['LOCK'] = $o['Z2'];
	$stat[$cid]['OUT'] = $o['Z3'];
//	foreach (array('GIVE2', 'CASHOUT2', 'DEPO', 'BAL', 'LOCK', 'OUT') as $o)
//		$stat[0][$o] += $stat[$cid][$o];
}
setPage('stat', $stat);
$list = array();
foreach ($_currs2 as $id => $r)
		$list[$id] = $r['cName'];
setPage('clist', $list);
setPage('today', timeToStr(time(), 1));
showPage();

?>