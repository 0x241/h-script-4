<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'Msg';
$id_field = 'mID';
	
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
				$db->delete('MBox', '?# ?i', array('bmID', $ids));
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
	"$table LEFT JOIN Users ON uID=muID", 
	"$table.*, uLogin, (mAttn=9) AS _Marked", '', null, 
	array(
		$id_field => array(),
		'mTS' => array('mTS desc', 'mTS'),
		'uLogin' => array('uLogin', 'uLogin desc')
	), 
	_GET('sort'), $id_field
);
stampTableToStr($list, 'mTS');
foreach ($list as $i => $l)
	$list[$i]['To'] = asStr(asArray($l['mTo'], HS2_NL), ', ');

setPage('list', $list);

showPage();

?>