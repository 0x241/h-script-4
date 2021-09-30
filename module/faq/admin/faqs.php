<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'FAQ';
$id_field = 'fID';
	
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

$list = opPageGet(_GETN('page'), 20, $table, '*', '', null, 
	array(
		$id_field => array(),
		'fCTS' => array('fCTS desc', 'fCTS')
	), 
	_GET('sort'), $id_field
);
stampTableToStr($list, 'fCTS');

setPage('list', $list);

showPage();

?>