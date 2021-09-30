<?php

$_auth = 90;
require_once('module/auth.php');

try 
{

	if (sendedForm() or !$_IN)
	{
		if ($_IN)
			checkFormSecurity();
			
		$a = $_IN;
		strArrayToStamp($a, 'D1', 1);
        
        if ($d1 = $a['D1'] && !empty($a['D1']))
		{
			$ud1 = " and aCTS>='$d1'";
			$od1 = " and oCTS>='$d1'";
			$dd1 = " and dCTS>='$d1'";
		}
		strArrayToStamp($a, 'D2', 2);
		if ($d2 = $a['D2'] && !empty($a['D2']))
		{
			$ud2 = " and aCTS<='$d2'";
			$od2 = " and oCTS<='$d2'";
			$dd2 = " and dCTS<='$d2'";
		}
		if (!empty($a['cCurr']))
		{
			$focurr = " and cCurrID='".mysql_escape_string($a['cCurr'])."'";
			$fdcurr = " and cCurrID='".mysql_escape_string($a['cCurr'])."'";
		}
		
		$res = array();
		$res['REG'] = 0 + $db->count('AddInfo', "1$ud1$ud2");
		foreach (array('BONUS', 'PENALTY', 'CASHIN', 'REF', 'GIVE', 'TAKE', 'CALCIN', 'CALCOUT', 'CASHOUT') as $o)
			$res[$o] = $db->fetch1($db->select('Opers', 'SUM(oSum)', "oOper='$o' and oState=3$focurr$od1$od2"));
//		$res['CASHOUT2'] = $db->fetch1($db->select('Opers', 'SUM(oSum)', "oOper='CASHOUT' and oState=2$focurr$od1$od2"));
		$res['DEPO'] = $db->fetch1($db->select('Deps', 'SUM(dZD)', "1$fdcurr$dd1$dd2"));
		$res['DEPO2'] = $db->fetch1($db->select('Deps', 'SUM(dZD)', "dState=1$fdcurr$dd1$dd2"));
        
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

foreach ($_currs2 as $cid => $c)
{
	foreach (array('BONUS', 'PENALTY', 'CASHIN', 'REF', 'GIVE', 'TAKE', 'CALCIN', 'CALCOUT', 'CASHOUT') as $o)
	{
		$stat[$cid][$o] = $db->fetch1($db->select("Opers AS t1 LEFT JOIN Currs AS t2 ON t1.ocID=t2.cID LEFT JOIN Cfg AS t3 ON t3.Module='Bal' AND t3.Prop=CONCAT('Rate', IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr)) LEFT JOIN Cfg AS t4 ON t4.Module='Bal' AND t4.Prop=CONCAT('Rate', t2.cCurr)", "IF(IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr) = t2.cCurr, t1.oSum, SUM(ROUND(ROUND(t1.oSum/t4.Val,2)*t3.Val,2)))", "t1.oOper=? and t1.cCurrID='".mysql_escape_string($c)."' and t1.oState=3", array($o)));
		$stat[0][$c][$o] += $stat[$cid][$o];
	}

	$stat[$cid]['GIVE2'] = $db->fetch1($db->select("Opers AS t1 LEFT JOIN Currs AS t2 ON t1.ocID=t2.cID LEFT JOIN Cfg AS t3 ON t3.Module='Bal' AND t3.Prop=CONCAT('Rate', IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr)) LEFT JOIN Cfg AS t4 ON t4.Module='Bal' AND t4.Prop=CONCAT('Rate', t2.cCurr)", "IF(IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr) = t2.cCurr, t1.oSum, SUM(ROUND(ROUND(t1.oSum/t4.Val,2)*t3.Val,2)))", "t1.oOper=? and t1.cCurrID='".mysql_escape_string($c)."' and t1.oState=3 and (t1.oMemo ?%)", array('GIVE', 'Auto')));
	$stat[$cid]['CASHOUT2'] = $db->fetch1($db->select("Opers AS t1 LEFT JOIN Currs AS t2 ON t1.ocID=t2.cID LEFT JOIN Cfg AS t3 ON t3.Module='Bal' AND t3.Prop=CONCAT('Rate', IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr)) LEFT JOIN Cfg AS t4 ON t4.Module='Bal' AND t4.Prop=CONCAT('Rate', t2.cCurr)", "IF(IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr) = t2.cCurr, t1.oSum, SUM(ROUND(ROUND(t1.oSum/t4.Val,2)*t3.Val,2)))", "t1.oOper=? and t1.cCurrID='".mysql_escape_string($c)."' and t1.oState=2", array('CASHOUT')));
	$stat[$cid]['DEPO'] = $db->fetch1($db->select('Deps', 'SUM(dZD)', 'dcID=?d and dState=1', array($cid)));

    $sql="SELECT 
          SUM(IF((IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr)= t2.cCurr OR t1.oSumReal>0), IF(t1.oOper='BONUS' OR t1.oOper='CASHIN' OR t1.oOper='EXIN' OR t1.oOper='TRIN' OR t1.oOper='SELL'  OR t1.oOper='REF' OR t1.oOper='TAKE' OR t1.oOper='CALCIN', 1,-1)*IF(t1.oSumReal>0,t1.oSumReal,IF(t1.oSum IS NULL, 0, t1.oSum)), ROUND(ROUND(IF(t1.oOper='BONUS' OR t1.oOper='CASHIN' OR t1.oOper='EXIN' OR t1.oOper='TRIN' OR t1.oOper='SELL'  OR t1.oOper='REF' OR t1.oOper='TAKE' OR t1.oOper='CALCIN', 1,-1)*IF(t1.oSum IS NULL, 0, t1.oSum)/t4.Val,2)*t3.Val,2))) AS Z1
          FROM Currs AS t2
          INNER JOIN Opers AS t1 ON t1.ocID=t2.cID AND (t1.oState=3 OR (t1.oOper='CASHOUT' AND t1.oState<>4))
          LEFT JOIN Cfg AS t3 ON t3.Module='Bal' AND t3.Prop=CONCAT('Rate', IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr))
          LEFT JOIN Cfg AS t4 ON t4.Module='Bal' AND t4.Prop=CONCAT('Rate', t2.cCurr) 
          WHERE t2.cDisabled=0
          AND t1.oState<>5
          AND IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr)='".mysql_escape_string($c)."'";   
    $result = $db->_doQuery($sql);
    $o = $db->fetch($result);
	$stat[$cid]['BAL'] = $o['Z1'];
    $stat[0][$c]['BAL'] += $stat[$cid]['BAL'];
    
    $sql="SELECT  SUM(IF(IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr) = t2.cCurr, IF(t1.dZD IS NULL, 0, t1.dZD), ROUND(ROUND(IF(t1.dZD IS NULL, 0, t1.dZD)/t4.Val,2)*t3.Val,2))) AS Z2
          FROM Currs AS t2
          INNER JOIN Deps AS t1 ON t1.dcID=t2.cID AND t1.dState=1
          LEFT JOIN Cfg AS t3 ON t3.Module='Bal' AND t3.Prop=CONCAT('Rate', IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr))
          LEFT JOIN Cfg AS t4 ON t4.Module='Bal' AND t4.Prop=CONCAT('Rate', t2.cCurr) 
          WHERE t2.cDisabled=0
          AND t1.dState=1 
          AND IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr)='".mysql_escape_string($c)."'";   
    $result = $db->_doQuery($sql);
    $o = $db->fetch($result);      
  	$stat[$cid]['LOCK'] = $o['Z2'];
    $stat[0][$c]['LOCK'] += $stat[$cid]['LOCK'];   
              
    $o = $db->fetch1Row($db->select('Wallets', 'SUM(wBal) AS Z1, SUM(wLock) AS Z2, SUM(wOut) AS Z3', "cCurrID='".mysql_escape_string($c)."'", array()));          
    
	foreach (array('GIVE2', 'CASHOUT2', 'DEPO') as $o)
		$stat[0][$c][$o] += $stat[$cid][$o];
        
        }

setPage('stat', $stat);
$list = array();
foreach ($_currs as $id => $r)
		$list[$id] = $r['cName'];
setPage('clist', $list);
setPage('today', timeToStr(time(), 1));
showPage();
?>