<?php

require_once('module/auth.php');

$table = 'News';
$id_field = 'nID';
	
try 
{

} 
catch (Exception $e) 
{
}

$n = $_cfg['News_ShowCount'];
if (!$n)
	$n = 10;
$list = opPageGet(_GETN('page'), $n, $table, '*', 
	'(nDBegin=0 or nDBegin<=?) and (nDEnd=0 or nDEnd>=?)', array(timeToStamp(), timeToStamp()),
	array(
		'nTS' => array('nAttn desc, nTS desc, nID desc')
	),
	_GET('sort'), $id_field
);
stampTableToStr($list, 'nTS', 0);
setPage('list', $list, 1);

showPage();

?>