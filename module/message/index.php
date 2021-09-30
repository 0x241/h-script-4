<?php

$_auth = 1;
require_once('module/auth.php');

$table = 'MBox';
$id_field = 'bID';
	
try 
{

	if (isset_IN('ids') and (count($ids = (array)_IN('ids')) > 0))
	{
		$ids = $db->fetchRows($db->select($table, $id_field, '(?# ?i) and buID=?d', array($id_field, $ids, _uid())), 1);
		if (count($ids) > 0)
		{
			checkFormSecurity();
			
			if (sendedForm('del'))
				$db->delete($table, '(?# ?i) and buID=?d', array($id_field, $ids, _uid()));
			
			showInfo();
		}
		else
			showInfo('*NoSelected');
	}
	
}
catch (Exception $e) 
{
}

$n = $_cfg['Msg_ShowCount'];
if (!$n)
	$n = 10;
		
$list = opPageGet(_GETN('page'), $n, "$table LEFT JOIN Msg ON mID=bmID LEFT JOIN Users ON uID=buID2", 
	"$table.*, Msg.*, Users.uLogin, ISNULL(bRTS) AS _Marked", 
	'buID=?d and muID<>buID and bDeleted=0', array(_uid()),
	array(
		'mTS' => array('mTS desc, bID desc')
	),
	_GET('sort'), $id_field
);
stampTableToStr($list, 'mTS, bRTS', 2);

setPage('list', $list);

showPage();

?>