<?php

$_auth = 90;
require_once('module/auth.php');
require_once('lib/psys.php');

$table = 'Currs';
$id_field = 'cID';

try 
{

	if (sendedForm('send'))
	{
		checkFormSecurity();
		
		$a = $_IN;
		$c = $_currs[$a['PSys']];
		if (!$c)
			setError('psys_empty');
		$a['Sum'] = _z($a['Sum'], $a['PSys']);
		if ($a['Sum'] <= 0)
			setError('sum_wrong');
		if (!$a['To'])
			setError('wallet_empty');
		opDecodeCurrParams($c, $r, $r, $aparams);
		$r = sendMoney($c['cCID'], $aparams, array('acc' => $a['To']), $a['Sum'], $a['Memo']);
		if ($r['result'] != 'OK')
			setError($r['result']);
		showInfo('Completed', moduleToLink() . '?batch=' . $r['batch']);
	}

} 
catch (Exception $e) 
{
}

useLib('balance');

$clist = array();
$list = $db->fetchIDRows($db->select($table, '*', '', null, $id_field), false, $id_field);
foreach ($list as $id => $r)
{
	opDecodeCurrParams($r, $p, $p, $a);
	if ($a['apipass'])
	{
		$list[$id]['balance'] = GetBalance($r['cCID'], $a);
		$clist[$id] = $r['cName'] . ' (' . _z($list[$id]['balance']['sum'], $id) . ' ' . $r['cCurr'] . ')';
	}
	else
		unset($list[$id]);
}
setPage('clist', $clist);
setPage('list', $list);
//xstop($list);
showPage();

?>