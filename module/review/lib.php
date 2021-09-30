<?php

function reviewGetBlock($n = 0)
{
	global $db, $_cfg;
	if ($n <= 0)
		$n = exValue(1, $_cfg['Review_InBlock']);
	$list = $db->fetchIDRows($db->select('Review LEFT JOIN Users ON uID=ouID LEFT JOIN AddInfo ON auID=ouID', 
		'*', 'oState=1', array(), 'RAND()', $n), false, 'oID');
	stampTableToStr($list, 'oTS', 0);
	return $list;
}

?>