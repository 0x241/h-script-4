<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'Plans';
$id_field = 'pID';
	
try 
{

	if (isset_IN('ids') and (count($ids = (array)_IN('ids')) > 0))
	{
/*		$ids = $db->fetchRows($db->select($table, $id_field, '?# ?i', array($id_field, $ids)), 1);
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
			showInfo('*NoSelected');*/
	}

} 
catch (Exception $e) 
{
}

$list = opPageGet(_GETN('page'), 20, $table,
	"*,
	(SELECT SUM(dZD) FROM Deps WHERE dpID=pID) AS dsum,
	(SELECT COUNT(*) FROM Deps WHERE dpID=pID) AS cnt,
	(SELECT SUM(dZD) FROM Deps WHERE dpID=pID AND dState=1) AS adsum,
	(SELECT COUNT(*) FROM Deps WHERE dpID=pID AND dState=1) AS acnt
	", '', null,
	array(
		'pGroup' => array('pGroup, pID'),
		$id_field => array(),
		'pName' => array('pName', 'pName desc')
	), 
	_GET('sort'), $id_field
);

setPage('list', $list);

showPage();

?>