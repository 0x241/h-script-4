<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'Queue';
$id_field = 'qID';
	
try 
{

	if (isset_IN('ids') and (count($ids = (array)_IN('ids')) > 0))
	{
		$ids = $db->fetchRows($db->select($table, $id_field, '?# ?i', array($id_field, $ids)), 1);
		if (count($ids) > 0)
		{
			checkFormSecurity();
			
			if (sendedForm('del'))
			{
				$db->delete($table, '?# ?i', array($id_field, $ids));
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

$list = opPageGet(_GETN('page'), 20, "$table LEFT JOIN Users on uID=quID", "$table.*, uLogin", '', null, 
	array(
		$id_field => array(),
		'uLogin' => array('uLogin', 'uLogin desc', 'qTS desc', 'qTS'),
		'qFromTo' => array('qFrom', 'qFrom desc', 'qTo', 'qTo desc'),
		'qText' => array(),
		'qState' => array('qState', 'qState desc', 'qSTS desc', 'qSTS'),
		'qError' => array()
	), 
	_GET('sort'), $id_field
);
stampTableToStr($list, 'qTS, qSTS');

setPage('list', $list);

showPage();

?>