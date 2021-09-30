<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'News';
$id_field = 'nID';
	
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
		'nTS' => array('nTS desc', 'nTS'),
		'nDBegin' => array('nDBegin desc', 'nDBegin'),
		'nDEnd' => array('nDEnd desc', 'nDEnd')
	), 
	_GET('sort'), $id_field
);
stampTableToStr($list, 'nTS');
stampTableToStr($list, 'nDBegin, nDEnd', 1);

setPage('list', $list);

showPage();

?>