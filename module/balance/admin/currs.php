<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'Currs';
$id_field = 'cID';

try 
{

	if (isset_IN('ids') and (count($ids = (array)_IN('ids')) > 0))
	{
		showInfo('*CantComplete');
/*		$ids = $db->fetchRows($db->select($table, $id_field, '?# ?i', array($id_field, $ids)), 1);
		if (count($ids) > 0)
		{
			checkFormSecurity();
			
			if (sendedForm('del'))
			{
				// ??? chk Internal
//				$db->delete($table, '?# ?i', array($id_field, $ids));
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

useLib('balance');

$list = opPageGet(_GETN('page'), 20, $table, '*', '', null, 
	array(
		$id_field => array($id_field)
	),
	_GET('sort'), $id_field
);
foreach ($list as $id => $r)
	opDecodeCurrParams($r, $p, $p, $list[$id]['PAPI']);
setPage('list', $list);

showPage();

?>