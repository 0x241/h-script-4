<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'Calend';
$id_field = 'cID';
$out_link = moduleToLink('calendar/admin/days');

try 
{

	if (sendedForm()) 
	{
		checkFormSecurity();
		
		$a = $_IN;
		strArrayToStamp($a, 'cTS', 1);
		if (!$a['cTS'])
			setError('date_empty');
		if ($db->count($table, 'cID<>?d and cTS=?', array($a['cID'], $a['cTS'])) > 0)
			setError('date_exist');
		if (!$a['cType'])
			setError('type_empty');
        if ($a['cPerc'] < 0)
            setError('perc_wrong');
		if ($id = $db->save($table, $a, 
			'cTS, cType, cPerc', $id_field))
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
	stampArrayToStr($el, 'cTS', 1);
	setPage('el', $el, 2);
}
else
	setPage('today', timeToStr(time(), 1));

showPage();

?>