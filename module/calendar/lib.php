<?php

function getDayType($t)
{
	$y = gmdate('Y', $t);
	$m = gmdate('n', $t);
	$d = gmdate('j', $t);
	$t = gmmktime(0, 0, 0, $m, $d, $y);
	global $db;
	if ($c=$db->count('Calend','cTS>=?',array(timeToStamp($t))))
	{
		$t = $db->fetch1($db->select('Calend', 'cType', 'cTS=?', array(timeToStamp($t))));
		if ($t < 1)
			$t = 1;
	}
	else
	{
		$t = valueIf(gmdate('N', $t) > 5, 2, 1);
	}
	return $t;
}

function getDayPerc($t)
{
    $y = gmdate('Y', $t);
    $m = gmdate('n', $t);
    $d = gmdate('j', $t);
    $t = gmmktime(0, 0, 0, $m, $d, $y);
    global $db;
    $perc = $db->fetch1($db->select('Calend', 'cPerc', 'cTS=?', array(timeToStamp($t))));

    if (!$perc)
        return 0 ;
//        $perc = $db->fetch1($db->select('Calend', 'cPerc', 'cTS<?', array(timeToStamp($t)),'cTS desc',1));

    return $perc;
}

?>