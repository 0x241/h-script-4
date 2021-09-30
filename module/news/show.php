<?php

require_once('module/auth.php');

$table = 'News';
$id_field = 'nID';
$out_link = moduleToLink('newses');

try 
{

} 
catch (Exception $e) 
{
}

if (_GETN('id'))
	$el = $db->fetch1Row($db->select($table, '*', "$id_field=?d", array(_GETN('id'))));
if (!$el)
	goToURL($out_link);
stampArrayToStr($el, 'nTS', 0);
setPage('el', $el, 1);

showPage();

?>