<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'Pages';
$id_field = 'pID';
$out_link = moduleToLink('custom/admin/pages');

try 
{

	if (sendedForm()) 
	{
		checkFormSecurity();
		
		$a = $_IN;
		if (!$a['pTopic'])
			setError('topic_empty');
		if (!$a['pText'])
			setError('text_empty');
		if ($id = $db->save($table, $a, 
			'pHidden, pDirect, pTopic, pText', $id_field))
			showInfo('Saved', $out_link . "?id=$id");
		showInfo('*Error');
	}

} 
catch (Exception $e) 
{
}

if (!isset($_GET['add']))
{
	if (_GETN('id'))
		$el = $db->fetch1Row($db->select($table, '*', "$id_field=?d", array(_GETN('id'))));
	if (!$el)
		goToURL(moduleToLink() . '?add');
	setPage('el', $el, 2);
}

showPage();

?>