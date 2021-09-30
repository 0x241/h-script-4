<?php

$_auth = 1;
require_once('module/auth.php');

$table = 'Tickets';
$id_field = 'tID';
	
try
{

	if (isset_IN('ids') and (count($ids = (array)_IN('ids')) > 0))
	{
		$ids = $db->fetchRows($db->select($table, $id_field, 'tuID=?d and ?# ?i', array(_uid(), $id_field, $ids)), 1);
		if (count($ids) > 0)
		{
			checkFormSecurity();
			
			if (sendedForm('del'))
			{
				$db->delete($table, '?# ?i', array($id_field, $ids));
				$db->delete('TMsg', '?# ?i', array('mtID', $ids));
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

$list = opPageGet(_GETN('page'), 20, 
	$table, 
	"$table.*, (SELECT COUNT(*) FROM TMsg WHERE mtID=tID and muID<>?d) AS cnt", 
	'tuID=?d', array(_uid(), _uid()), 
	array(
		$id_field => array(),
		'tLTS' => array('tLTS desc', 'tLTS')
	), 
	_GET('sort'), $id_field
);
stampTableToStr($list, 'tTS, tLTS');

setPage('list', $list);

showPage();

?>