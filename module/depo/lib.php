<?php

function opDepoGetPlanList($uid, $by_admin = false, $only_ids = false, $cid = false)
{
	global $db, $_cfg;
	$plans = $db->fetchIDRows($db->select('Plans P',
		'P.*,
		(SELECT COUNT(dID) FROM Deps LEFT JOIN Plans P2 on P2.pID=dpID WHERE P2.pGroup=P.pGroupReq and duID=?d and dState>=2 LIMIT 1) AS DCL,
		(SELECT COUNT(dID) FROM Deps WHERE duID=?d and dState=1 and dpID=P.pID' . valueIf($cid, ' and dcCurrID=?') . ') AS DCNT',
		valueIf(!$by_admin, 'pHidden=0'), array($uid, $uid, $cid), 'pGroup, pID'), false, 'pID');
	$bg = array();
	foreach ($plans as $p)
		$bg[$p['pGroup']] += $p['DCNT'];
	$pids = array();
	foreach ($plans as $pid => $p)
		if (
			(($p['pMaxCount'] > 0) and ($p['DCNT'] >= $p['pMaxCount'])) or
			(($p['pGroupReq'] > 0) and !$p['DCL']) or
			($_cfg['Depo_OneFromGroup'] and $bg[$p['pGroup']])
		)
			$plans[$pid]['Disabled'] = true;
		else
			$pids[] = $pid;
	if ($only_ids)
		return $pids;
	return $plans;
}

function opDepoUSD($sum, $curr)
{
	global $_cfg;
	return round($sum * $_cfg["Bal_Rate$curr"], 2);
}

function opDepoCreate($uid, $cid, $sum, $compnd = 0, $pid = 0, $by_admin = false, $auto = false)
{    
//error_reporting(65535);
	global $db, $_cfg, $_currs, $_currs2;
	$usr = opReadUser($uid);
	if (!$usr)
		return 'user_not_found'; 
	if (!$cid)
		return 'psys_empty';
	if (!$_currs[$cid])
		return 'psys_wrong';
	
	if (($cid=='BTC') or ($cid=='ETH') or ($cid=='XRP'))
			$sum = round($sum, 6);
		else 
			$sum = round($sum, 3);
		
	$usum = opDepoUSD($sum, $cid);
	if ($usum < 0.1)
		return 'sum_wrong';
	$compnd = round($compnd, 2);
	$pl = opDepoGetPlanList($uid, $by_admin, true, $cid); // enabled plans
	$pl = $db->fetch1Row($db->select('Plans', '*', 
		'(pID ?i) and pMin<=? and pMax>?' . valueIf($pid, ' and pID=?d'),
		array($pl, $usum, $usum, $pid), 'pMax', 1));
	if (!$pl['pID'])
		return 'plan_wrong';
           
	if (($pid == 0) and ($compnd == 0))
		$compnd = $pl['pCompndMin'];
	if ((($pl['pCompndMin'] > 0) and ($pl['pCompndMin'] > $compnd)) or
		($pl['pCompndMax'] < $compnd) or ($compnd < 0))
	{
		setPage('cmin', $pl['pCompndMin']);
		setPage('cmax', $pl['pCompndMax']);
		setPage('cplan', $pl['pName']);
		return 'compnd_wrong';
	}
	if ($auto === 2)
		return 'passed';
        
	useLib('balance');

$coef = array();
$a = calcWDAvail($uid, $cid, 1, true);
if (is_array($a) and ($a[$cid]['bal'][0] > 0))
	foreach ($a[$cid]['bal'] as $i => $z)
		if ($i)
			$coef[$i] = round($z / $a[$cid]['bal'][0], 5);

	$bsum = CalcPerc($sum, $pl['pBonus'], 3);
	if (is_string($oid = opOperCreate($uid, 'GIVE', $cid, $sum, array('bonus' => $bsum, 'auto' => $auto), valueIf($auto, 'Auto '), false, true, $currency)))
		return $oid;
	if (is_string($err = opOperConfirm($uid, $oid, array(), true)))
		return $err;
	if ($_cfg['Depo_ChargeMode'] == 2)
		$t = opDepoLastManualChargeDate();
	elseif ($_cfg['Depo_Interval'] > 0)
	{
		$t = stampToTime($_cfg['Depo_LastTime']) + HS2_UNIX_MINUTE * $_cfg['Depo_Interval'];
		if ($t < time())
			$t = time();
	}
	else
		$t = time();
	$ets = $t + $pl['pNPer'] * $pl['pPer'] * HS2_UNIX_HOUR;
	$nts = $t + $pl['pPer'] * HS2_UNIX_HOUR;
	$did = $db->insert('Deps', array(
		'duID' => $uid,
		'dState' => 1,
		'dpID' => $pl['pID'],
		'dCTS' => timeToStamp($t),
		'dETS' => timeToStamp($ets),
		'dcCurrID' => $cid,
		'dZ0' => $sum,
		'dZD' => $sum + $bsum,
		'dZDReal' => ($zreal = $sum * $_cfg['Bal_Rate' . $cid]),
		'dCompnd' => $compnd,
		'dNTS' => timeToStamp($nts),
		'dLTS' => 0,
		'dCoef' => serialize($coef)
        )
        );
	opOperComplete($uid, $oid, array('tag' => $did), true);
	$db->update('Users', array('uSumDepo=' => "uSumDepo+$zreal"), '', 'uID=?d', array($uid));
	$db->replace('Cfg',
		array(
			'Module' => 'Depo',
			'Prop' => 'LastTime',
			'Val' => timeToStamp($t)
		),
		'', 'Module=? and Prop=?', array('Depo', 'LastTime')
	);
	$a = array(
		'did' => $did,
		'pid' => $pl['pID'],
		'curr' => $cid,
		'sum' => $sum,
		'percs' => asArray($pl['pDPerc'], HS2_NL),
		'coef' => $coef
	);
	opEvent('DepoCreate', $uid, $a);
	return $did;
}

function opDepoAdd($uid, $cid, $sum, $did = 0, $is_compnd = false)
{
	global $db, $_cfg;
	$d = $db->fetch1Row($db->select('Deps LEFT JOIN Plans on pID=dpID', 
		'Deps.*, Plans.*', 
		'duID=?d and dcCurrID=? and dState=1' . valueIf($did, ' and dID=?d'), array($uid, $cid, $did), 'dID', 1));
	if (!$d)
		return 'depo_wrong';
	$sum = round($sum, 2);
	$usum = opDepoUSD($sum, $d['dcCurrID']);
	if ($usum < 0.01)
		return 'sum_wrong';
	if (!$is_compnd)
	{
		if (!$d['pEnAdd'])
			return 'cant_add';
		if (($d['pMinAdd'] > 0) and ($usum < $d['pMinAdd']))
			return 'sum_wrong';
	}
	$dsum = $d['dZD'] + $sum;
	$csum = $d['dZC'] + valueIf($is_compnd, $sum, 0);
	$a = array(
		'dZD' => $dsum,
		'dZDReal' => $dsum * $_cfg['Bal_Rate' . $cid],
		'dZC' => $csum
	);
	$udsum = opDepoUSD($dsum, $d['dcCurrID']);
	if (($d['pMin'] > $udsum) or ($d['pMax'] <= $udsum)) // change plan
	{
		$pl = opDepoGetPlanList($uid, false, true, $cid); // enabled plans
		$pl = $db->fetch1Row($db->select('Plans', '*', 
			'(pID ?i) and pMin<=? and pMax>? and pHidden=0 and pGroup=?d',
			array($pl, $udsum, $udsum, $d['pGroup']), 'pMax', 1));
		if (!$pl['pID'])
			return 'plan_not_found';
		$a['dpID'] = $pl['pID'];
		$z = ($udsum - $pl['pMin']); // max compnd
		if ($csum > $z)
			$a['dZC'] = $z;
	}
	useLib('balance');
	if (is_string($oid = opOperCreate($uid, 'GIVE', $cid, $sum, array('tag' => $d['dID']),'',false,true)))
    {
      return $oid;  
    }
	if (is_string($err = opOperConfirm($uid, $oid, array(), true)))
		return $err;
	if ($db->update('Deps', $a, '', 'dID=?d and dState=1 and dZD=?', array($d['dID'], $d['dZD'])))
    {
      $res = opOperComplete($uid, $oid, array(), true);
		$db->update('Users', array('uSumDepo=' => "uSumDepo+" . ($a['dZDReal'] - $d['dZDReal'])), '', 'uID=?d', array($uid));
      return $res;  
    }
	else
		opOperCancel($uid, $oid);
	return 'depo_wrong';
}

function opDepoSub($uid, $cid, $sum, $did = 0)
{
	global $db, $_cfg;
	$d = $db->fetch1Row($db->select('Deps LEFT JOIN Plans on pID=dpID', 
		'Deps.*, Plans.*', 
		'duID=?d and dcCurrID=? and dState=1' . valueIf($did, ' and dID=?d'), array($uid, $cid, $did), 'dID', 1));
	if (!$d)
		return 'depo_wrong';
	$sum = round($sum, 2);
	$usum = opDepoUSD($sum, $d['dcCurrID']);
	if ($usum < 0.01)
		return 'sum_wrong';
	if (($d['pClComis'] >= 100) or (($d['pMPer'] > 0) and ($d['dNPer'] < $d['pMPer'])))
		return 'cant_sub';
	$dsum = $d['dZD'] - $sum;
	if ($dsum < 0)
		return 'sum_wrong'; // more than depo
	if ($dsum == 0) // close
		$a = array(
			'dState' => 3,
//			'dZD' => 0,
			'dNTS' => timeToStamp(0)
		);
	else
	{
		$csum = $d['dZC'] - $sum;
		if ($csum < 0)
			$csum = 0;
		$a = array(
			'dZD' => $dsum,
			'dZDReal' => $dsum * $_cfg['Bal_Rate' . $cid],
			'dZC' => $csum
		);
		$udsum = opDepoUSD($dsum, $d['dcCurrID']);
		if (($d['pMin'] > $udsum) or ($d['pMax'] <= $udsum))
		{
			$pl = opDepoGetPlanList($uid, false, true, $cid); // enabled plans
			$pl = $db->fetch1Row($db->select('Plans', '*', 
				'(pID ?i) and pMin<=? and pMax>? and pHidden=0 and pGroup=?d', 
				array($pl, $udsum, $udsum, $d['pGroup']), 'pMax', 1));
			if (!$pl['pID'])
				return 'plan_not_found';
			$a['dpID'] = $pl['pID'];
			$z = ($udsum - $pl['pMin']); // max compnd
			if ($csum > $z)
				$a['dZC'] = $z;
		}
	}
	useLib('balance');
	if (is_string($oid = opOperCreate($uid, 'TAKE', $cid, $sum,
			array('comis' => valueIf(($d['pClPer'] > 0) and ($d['dNPer'] >= $d['pClPer']), 0, $d['pClComis']), 'tag' => $d['dID']),
			'', false, true )))
		return $oid;
	if (is_string($err = opOperConfirm($uid, $oid, array(), true)))
		return $err;
	if ($db->update('Deps', $a, '', 'dID=?d and dState=1 and dZD=?', array($d['dID'], $d['dZD'])))
	{
		$err = opOperComplete($uid, $oid, array(), true);
		$db->update('Users', array('uSumDepo=' => "uSumDepo+" . ($a['dZDReal'] - $d['dZDReal'])), '', 'uID=?d', array($uid));
		if (!is_string($err) and ($a['dState'] >= 2))
			opEvent('DepoClose', $uid, array('did' => $d['dID'], 'curr' => $cid, 'state' => $a['dState']));
		return $err;
	}
	else
		opOperCancel($uid, $oid);
	return 'depo_wrong';
}

function opDepoClose($uid, $cid, $did = 0)
{
	global $db;
	$d = $db->fetch1Row($db->select('Deps LEFT JOIN Plans on pID=dpID', '*', 
		'duID=?d and dcCurrID=? and dState=1' . valueIf($did, ' and dID=?d'), array($uid, $cid, $did), 'dID', 1));
	if (!$d)
		return 'depo_wrong';
	$dsum = $d['dZD'];
	$a = array(
		'dState' => 3,
//		'dZD' => 0,
		'dNTS' => timeToStamp(0)
	);
	if (!$db->update('Deps', $a, '', 'dID=?d and dState=1 and dZD=?', array($d['dID'], $d['dZD'])))
		return 'depo_wrong';
	$db->update('Users', array('uSumDepo=' => "uSumDepo-$dsum"), '', 'uID=?d', array($uid));
	useLib('balance');
	return opOperCreate($uid, 'TAKE', $cid, $dsum, array('tag' => $d['dID']), '', true, true);
}

function opDepoChangePlan($uid, $pid, $did)
{
	global $db;
	$d = $db->fetch1Row($db->select('Deps LEFT JOIN Plans on pID=dpID', '*', 
		'dID=?d and duID=?d and dState=1', array($did, $uid)));
	if (!$d)
		return 'depo_wrong';
	return $db->update('Deps', array('dpID' => $pid), '', 'dID=?d and dState=1', array($did));
}

function opDepoChangeCompnd($uid, $did, $compnd)
{
	global $db;
	$d = $db->fetch1Row($db->select('Deps LEFT JOIN Plans on pID=dpID', '*', 
		'dID=?d and duID=?d and dState=1', array($did, $uid)));
	if (!$d)
		return 'depo_wrong';
	$compnd = round($compnd, 2);
	if ((($d['pCompndMin'] > 0) and ($d['pCompndMin'] > $compnd)) or
		($d['pCompndMax'] < $compnd) or ($compnd < 0))
	{
		setPage('cmin', $d['pCompndMin']);
		setPage('cmax', $d['pCompndMax']);
		setPage('cplan', $d['pName']);
		return 'compnd_wrong';
	}
	return $db->update('Deps', array('dCompnd' => $compnd), '', 'dID=?d and dState=1', array($did));
}
//=============Calculate percent from calendar========================================================================
function opDepoGetCalendarPerc()
{
    useLib('calendar');
    $perc = getDayPerc(time())+0;
    return $perc;
}
//=====================================================================================================================
function opDepoCharge($d, $perc = -1, $cdate = false) // !!! Deps JOIN Plans, Users
{
	if (!$d['dID'])
		return 'depo_wrong';
	if ($d['dState'] != 1)
		return 'depo_wrong_state';
	$perc = round($perc, 2);
	if ($perc < 0)
	{ // auto
		$perc = $d['pPerc'];
        //----------Change from calendar----------
        if ($d['pPClndr'])
        {
            if (($pClndr = opDepoGetCalendarPerc())>0)
             $perc = $pClndr;
        }
        //--------------------------------------
		$t = stampToTime($d['dNTS']);
		$nts = $t + $d['pPer'] * HS2_UNIX_HOUR;
		$nc = ($d['pNoCalc'] or ($d['uState'] != 1));
		if (!$nc and $d['pWDays'] and ($d['pPer'] <= 24))
		{
			useLib('calendar');
			$nc = (getDayType($t) > 1);
		}
	}
	else
	{ // manual
		if (!$cdate)
			return 'date_wrong';
		$nts = $cdate + $d['pPer'] * HS2_UNIX_HOUR;
		$nc = ($d['pNoCalc'] or ($d['uState'] != 1) or ($perc == 0));
	}
	global $db;
	$a = array(
		'dNTS' => timeToStamp($nts),
		'dLTS' => timeToStamp()
	);
	if ($nc) // NO Calc
	{
		$db->update('Deps', $a, '', 'dID=?d and dState=1 and dNTS=?', array($d['dID'], $d['dNTS']));
		return false;
	}
	// Calc
	$psum = _zr(calcPerc($d['dZD'], $perc, 6), $d['dcCurrID']);
    
    if ($d['pBonusDay']>0)
    {
        $bonus_day=round(($d['dZP']+$psum)*$d['pBonusDay']/100,2);
    }
    else
    {
        $bonus_day=0;
    }
    
	$a['dZP='] = "dZP+$psum+$bonus_day";
	$a['dNPer='] = "dNPer+1";
	$d['dNPer']++;
	if (($d['pNPer'] > 0) and ($d['dNPer'] >= $d['pNPer'])) // end of depo
	{
		$dsum = $d['dZD'] - $d['dZC']; // real deposit sum
		if ($dsum < 0)
			$dsum = 0;
		$csum = $d['dZD'] - $dsum; // compnd sum
		$rsum = $csum + calcPerc($dsum, $d['pReturn'], 3);
		$dsum = $d['dZD'];
		$csum = 0;
		$a['dState'] = 2; // closed
//		$a['dZD'] = 0;
		$a['dNTS'] = timeToStamp(0);
	}
	else
	{
		$rsum = 0; // +return
		$dsum = 0; // -worked
		$csum = calcPerc($psum, $d['dCompnd'], 3); // compaund depo+
	}
	if (!$db->update('Deps', $a, '', 'dID=?d and dState=1 and dNTS=?', array($d['dID'], $d['dNTS'])))
		return 'depo_not_saved';
	useLib('balance');
	// psum+rsum = +return / dsum = -worked // csum = +compaund
	opChangeBalance($d['duID'], $d['dcCurrID'], $psum + $rsum, -$dsum, 0, false, 0, 'CALCIN');
	$a = array(
		'tag' => $d['dID'],
		'did' => $d['dID'],
		'pid' => $d['dpID'],
		'curr' => $d['dcCurrID'],
		'sum' => $psum,
		'csum' => $csum,
		'rsum' => $rsum,
		'nper' => $d['dNPer'],
		'coef' => unserialize($d['dCoef'])
	);
    if ($bonus_day>0)
       opOperCreateInfo($d['duID'], 'BONUS', $d['dcCurrID'], $bonus_day, $a, '#' . $d['dID']);  
	if ($psum > 0)
		opOperCreateInfo($d['duID'], 'CALCIN', $d['dcCurrID'], $psum, $a, '#' . $d['dID']);
	if ($rsum > 0) // depo closed
		opOperCreateInfo($d['duID'], 'TAKE', $d['dcCurrID'], $rsum, $a, '#' . $d['dID']);
	elseif ($csum > 0) // compaund
		opDepoAdd($d['duID'], $d['dcCurrID'], $csum, $d['dID'], true);
	$a['percs'] = asArray($d['pPPerc'], HS2_NL);
	opEvent('DepoCharge', $d['duID'], $a);
	if ($a['dState'] >= 2)
		opEvent('DepoClose', $d['duID'], array('did' => $d['dID'], 'curr' => $d['dcCurrID'], 'state' => $a['dState'], 'sum' => $d['dZD'] - $d['dZC']));
	return true;
}

function opDepoLastManualChargeDate()
{
	global $_cfg;
	$y = gmdate('Y');
	$m = gmdate('n');
	$d = gmdate('j');
	$cdate = gmmktime(0, 0, 0, $m, $d, $y);
	$md = $_cfg['Depo_ManualDay'];
	switch ($_cfg['Depo_ManualPeriod'])
	{
	case 1:
		if (($md < 1) or ($md > 7))
			$nd = 7;
		else
			$nd = $md;
		$dd = gmdate('N');
		if ($dd != $nd)
			$cdate = gmmktime(0, 0, 0, $m, $d - $dd - 7 + $nd, $y);
		break;
	case 2:
		$ld = gmdate('j', gmmktime(0, 0, 0, $m + 1, 0, $y));
		if (($md < 1) or ($md > $ld))
		{
			$md = 0;
			$nd = $ld;
		}
		else
			$nd = $md;
		if ($d != $nd)
			if ($md == 0)
				$cdate = gmmktime(0, 0, 0, $m, 0, $y);
			else
				$cdate = gmmktime(0, 0, 0, $m - 1, $md, $y);
		break;
	}
	return $cdate;
}

function depoPrepareCalc()
{
	global $_GS, $db, $_cfg, $_currs;
	$p = array();
	if ($_cfg['Depo__Compnd'])
		foreach ($_cfg['Depo__Compnd'] as $c)
			$p[$c] = $c;
	setPage('calc_compnd', $p);
	$plans = $db->fetchIDRows($db->select('Plans', '*', 'pHidden=0', 0, 'pID'), false, 'pID');
	$sp = array();
	$p = array();
	foreach ($plans as $id => $pl)
	{
		$sp[] = $pl['pName'];
		$p[] = "['" . textLangFilter($pl['pName'], $_GS['lang']) . "', {$pl['pMin']}, {$pl['pMax']}, {$pl['pPerc']}, {$pl['pNPer']}, {$pl['pBonus']}, {$pl['pReturn']}, " . ($pl['pPer'] * HS2_UNIX_HOUR / HS2_UNIX_DAY) . "]";
	}
	setPage('calc_pselect', $sp, 1);
	setPage('calc_plans', implode(', ', $p), 1);
}

function opDepoListPrepare(&$list)
{
	useLib('balance');
	foreach ($list as &$d)
	if ($d['dState'] == 1)
	{
		$t = stampToTime($d['dNTS']); 		// actual calc time = end of current calc period (now)
		$perc = $d['pPerc']/* + $d['pReturn']*/;
		//----------Change from calendar----------
		if ($d['pPClndr'])
		{
			if (($pClndr = opDepoGetCalendarPerc())>0)
			 $perc = $pClndr;
		}
		//--------------------------------------
		$zper = calcPerc($d['dZD'], $perc, 6);
		$d['NextCalcTime'] = $t;

		$dt = stampToTime($d['dNTS']) - time();
		if ($dt > 0)
		{
			$d['Timer']['D'] = floor($dt / 86400);
			$d['Timer']['H'] = floor($dt / 3600) % 24;
			$d['Timer']['M'] = floor($dt / 60) % 60;
			$d['Timer']['S'] = $dt % 60;
		}

		//if ($d['pGroup'] == 99)
		//{
			$tnow = min($t, time()); // now
			$lts = stampToTime(exValue($d['dCTS'], $d['dLTS'])); // last calc time
			$tcalc = $tnow - $lts;				// final calc period (part of full)
			if ($tcalc <= 1)
				$tcalc = 0;
			$tper = $d['pPer'] * HS2_UNIX_HOUR; // full calc period
			$d['CurrentProfit'] = round($zper * $tcalc / $tper, 6);
		//}
		//else
		//	$d['CurrentProfit'] = $d['dZP'];
		$d['ProfitPerHour'] = round($zper / $d['pPer'], 6);

		$cts = stampToTime($d['dCTS']);
		$ets = stampToTime($d['dETS']);
		if (($dts = ($ets - $cts)) > 0)
		{
			$d['CurrentProgress'] = round((time() - $cts) * 100 / $dts, 2);
			$d['ProgressPerHour'] = round(HS2_UNIX_HOUR * 100 / $dts, 2);
		}
	}
}

function depoGetStat()
{
	global $db, $_cfg;
	$stat = array();
	$stat['worked'] = floor((time() - stampToTime($_cfg['Depo_S0'])) / HS2_UNIX_DAY);
	$stat['users'] = $db->count('Users', 'uState=1') + $_cfg['Depo_S1'];
	$stat['usersonline'] = $db->count('Users', 'uState=1 and uLTS>?', array(timeToStamp(time() - 5 * HS2_UNIX_MINUTE)));
	foreach (array('zin' => 'CASHIN', 'zout' => 'CASHOUT', 'zref' => 'REF') as $v => $o)
		foreach (array('USD', 'EUR', 'RUB', 'BTC', 'ETH', 'XRP') as $c)
			$stat["$v$c"] = $db->fetch1($db->select('Opers', 'SUM(oSum)', "oOper='$o' AND oState=3 AND ocCurrID='$c'")) + $_cfg["Depo_$v$c"];
	$stat['lastuser'] = $db->fetch1Row($db->select('Users LEFT JOIN AddInfo ON auID=uID', 'uLogin, aCIP', 'uState=1', array(), 'uID desc', 1));
	return $stat;
}

?>