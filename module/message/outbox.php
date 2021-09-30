<?php

$_auth = 1;
require_once('module/auth.php');

$table = 'Msg';
$id_field = 'mID';

if ($_cfg['Msg_Mode'] < 2)
	goToURL(moduleToLink('message'));

try 
{

} 
catch (Exception $e) 
{
}

$n = $_cfg['Msg_ShowCount'];
if (!$n)
	$n = 10;
		
$list = opPageGet(_GETN('page'), $n, 
	$table, '*', 'muID=?d', array(_uid()),
	array(
		'mTS' => array('mTS desc, mID desc')
	),
	_GET('sort'), $id_field
);
stampTableToStr($list, 'mTS', 2);
foreach ($list as $i => $l)
	$list[$i]['To'] = asStr(asArray($l['mTo'], HS2_NL), ', ');
	
setPage('list', $list);

$_GS['vmodule'] = 'message';
showPage();

?>