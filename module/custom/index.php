<?php

require_once('module/auth.php');

$table = 'Pages';
$id_field = 'pID';
$out_link = moduleToLink('index');

try 
{

} 
catch (Exception $e) 
{
}

if (_GETN('id'))
	$el = $db->fetch1Row($db->select($table, '*', "$id_field=?d and pHidden=0", array(_GETN('id'))));
if (!$el)
	goToURL($out_link);
setPage('el', $el, 1);

showPage();

?>