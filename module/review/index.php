<?php

require_once('module/auth.php');

$table = 'Review';
$id_field = 'oID';
	
try 
{

	if (sendedForm()) 
	{
		checkFormSecurity();
		
		if (_uid())
		{
			if (!_IN('Text'))
				setError('text_empty');
			if ($id = $db->insert($table, array(
				'oTS' => timeToStamp(),
				'ouID' => _uid(),
				'oText' => _IN('Text'),
				'oState'=> valueIf(!$_cfg['Review_Mode'], 1)
			)))
				showInfo('Added', moduleToLink() . valueIf($_cfg['Review_Mode'], '?awating'));
		}
		showInfo('*Error');
	}

} 
catch (Exception $e) 
{
}

$n = $_cfg['Review_ShowCount'];
if (!$n)
	$n = 10;
$list = opPageGet(_GETN('page'), $n, "$table LEFT JOIN Users ON uID=ouID LEFT JOIN AddInfo ON auID=ouID", 
	'*', 'oState=1', array(),
	array(
		'nTS' => array('oOrder desc, oTS desc, oID desc')
	),
	_GET('sort'), $id_field
);
stampTableToStr($list, 'oTS', 0);

$total = $db->count('Review','oState = 1 ', '');

setPage('list', $list);
setPage('total', $total);

showPage();

?>