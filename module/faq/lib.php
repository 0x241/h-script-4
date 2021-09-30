<?php

function faqGetBlock($n = 0)
{
	global $db, $_cfg;
	if ($n <= 0)
		$n = exValue(1, $_cfg['FAQ_InBlock']);
	$list = $db->fetchIDRows($db->select('FAQ', '*', 'fHidden=0', array(), 'RAND()', $n), false, 'fID');
	return $list;
}

?>