<?php

function newsGetBlock($n = 0)
{
	global $db, $_cfg;
	if ($n <= 0)
		$n = exValue(5, $_cfg['News_InBlock']);
	$list = $db->fetchIDRows($db->select('News', '*', 
		'(nDBegin=0 or nDBegin<=?) and (nDEnd=0 or nDEnd>=?)', array(timeToStamp(), timeToStamp()),
		'nAttn desc, nTS desc, nID desc', $n), false, 'nID');
	stampTableToStr($list, 'nTS', 0);
	return $list;
}

?>