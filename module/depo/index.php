<?php

$_auth = 1;
require_once('module/auth.php');

$table = 'Deps';
$id_field = 'dID';
$uid_field = 'duID';
	
try 
{

} 
catch (Exception $e) 
{
}

$list = opPageGet(_GETN('page'), 20, "$table LEFT JOIN Users ON uID=duID LEFT JOIN Plans ON pID=dpID", '*',
	"$uid_field=?d", array(_uid()), 
	array(
		$id_field => array(),
		'uLogin' => array('uLogin', 'uLogin desc'),
		'pName' => array('pName', 'pName desc'),
		'dLTS' => array('dLTS desc', 'dLTS'),
		'dNTS' => array('dNTS desc', 'dNTS')
	), 
	_GET('sort'), $id_field
);
opDepoListPrepare($list);

useLib('calendar');
foreach($list as $k=>$el){
	//--calculte next time accrual, if weekend
	$nc = $el['pNoCalc'] ;
	$t = stampToTime($el['dNTS']);
	if (!$nc and $el['pWDays'] and ($el['pPer'] <= 24) and ($el['dState']==1))
	{
		while (getDayType($t) > 1)	{$t += $el['pPer'] * HS2_UNIX_HOUR;}
		$list[$k]['dNTS']=timeToStamp($t);
	}
}

stampTableToStr($list, 'dCTS, dLTS, dNTS');

setPage('list', $list);

showPage();

?>