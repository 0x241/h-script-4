<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'Users';
$id_field = 'uID';
$fform = 'users_filter';
	
try 
{

	if (sendedForm('', $fform))
	{
		checkFormSecurity($fform);
		
		foreach (array('uGroup', 'uLogin', 'aName', 'uMail', 'uState', 'RefLogin') as $f)
			$_SESSION[$fform][$f] = _IN($f);
		opPageReset();
		goToURL();
	}

	if (sendedForm('clear', $fform))
	{
		checkFormSecurity($fform);
		
		unset($_SESSION[$fform]);
		opPageReset();
		goToURL();
	}

	if (isset_IN('ids') and (count($ids = (array)_IN('ids')) > 0))
	{
		$ids = $db->fetchRows($db->select($table, $id_field, '?# ?i', array($id_field, $ids)), 1);
		if (count($ids) > 0)
		{
			checkFormSecurity();
			
			if (sendedForm('setgroup'))
			{
				$db->update('Users', array('uGroup' => _IN('Group')), '', '?# ?i', array($id_field, $ids));
			}
			
			if (sendedForm('del'))
			{
//				$db->delete('AddInfo', '?# ?i', array('auID', $ids));
//				$db->delete($table, '?# ?i', array($id_field, $ids));
			}
			
			showInfo();
		}
		else
			showInfo('*NoSelected');
	}

} 
catch (Exception $e) 
{
}

$flt = '1';
$fp = array();
if (isset($_SESSION[$fform]))
	foreach (array('uGroup' => 'Users.uGroup', 'uLogin' => 'Users.uLogin', 'aName' => 'aName', 'uMail' => 'Users.uMail', 'uState' => 'Users.uState', 'RefLogin' => 'U.uLogin') as $f => $b)
		if (($v = $_SESSION[$fform][$f]) != valueIf($f == 'uState', '9'))
		{
			if ($f == 'uLogin')
			{
				$flt .= ' and ((Users.uLogin=?) or (Users.uMail=?))';
				$fp[] = $v;
			}
			else
				$flt .= ' and (' . $b . valueIf(in_array($f, array('uLogin', 'aName', 'uMail')), ' ?%)' ,'=?)');
			$fp[] = $v;
		}

$list = opPageGet(_GETN('page'), 20, "$table LEFT JOIN AddInfo ON auID=uID LEFT JOIN Users U ON U.uID=Users.uRef", 
	'Users.*, AddInfo.aName, U.uLogin as RefLogin', 
	$flt, $fp, 
	array(
		$id_field => array(),
		'uGroup' => array(),
		'uLogin' => array(),
		'aName' => array(),
		'uMail' => array(),
		'uState' => array(),
		'uLevel' => array(),
		'RefLogin' => array(),
		'uBal' => array()
	), 
	_GET('sort'), $id_field
);
stampTableToStr($list, 'nBTS, nLTS');

$list_balances=array();
if (is_array($list) && count($list)>0)
{
    foreach ($list as $key => $item) 
    {
        $list_balances[$key]=array();
        $sql="SELECT t2.cName, t2.cID, IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr) AS currency_account,
             SUM(IF((IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr)= t2.cCurr OR t1.oSumReal>0), IF(t1.oOper='BONUS' OR t1.oOper='CASHIN' OR t1.oOper='EXIN' OR t1.oOper='TRIN' OR t1.oOper='SELL'  OR t1.oOper='REF' OR t1.oOper='TAKE' OR t1.oOper='CALCIN', 1,-1)*IF(t1.oSumReal>0,t1.oSumReal,IF(t1.oSum IS NULL, 0, t1.oSum)), ROUND(ROUND(IF(t1.oOper='BONUS' OR t1.oOper='CASHIN' OR t1.oOper='EXIN' OR t1.oOper='TRIN' OR t1.oOper='SELL'  OR t1.oOper='REF' OR t1.oOper='TAKE' OR t1.oOper='CALCIN', 1,-1)*IF(t1.oSum IS NULL, 0, t1.oSum)/t4.Val,2)*t3.Val,2))) AS wBal
             FROM Currs AS t2
             LEFT JOIN Opers AS t1 ON t1.ocID=t2.cID AND t1.ouID='".mysql_escape_string($key)."' AND  (t1.oState=3 OR (t1.oOper='CASHOUT' AND t1.oState<>4))
             LEFT JOIN Cfg AS t3 ON t3.Module='Bal' AND t3.Prop=CONCAT('Rate', IF(t1.cCurrID <>'', t1.cCurrID, t2.cCurr))
             LEFT JOIN Cfg AS t4 ON t4.Module='Bal' AND t4.Prop=CONCAT('Rate', t2.cCurr) 
             WHERE t2.cDisabled=0
             AND t1.oState<>5
             GROUP BY currency_account";
      $result = $db->_doQuery($sql);
      while ($row = $db->fetch($result)) 
      {
        $list_balances[$key][]=$row;
      } 
    }
}

setPage('list', $list);
setPage('list_balances', $list_balances);

showPage();

?>