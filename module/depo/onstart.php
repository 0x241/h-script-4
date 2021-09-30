<?php

if ($_cfg['Depo_ShowStat'])
	setPage('leftstat', @unserialize(@file_get_contents('tpl_c/stat.dat')));

if ($_cfg['Depo_Interval'] > 0)
{
	$nextdepotime = stampToTime($_cfg['Depo_LastTime']) + HS2_UNIX_MINUTE * $_cfg['Depo_Interval'];
	if ($nextdepotime > (time() + HS2_UNIX_MINUTE))
	{
		setPage('nextdepotime', timetoStr($nextdepotime, 2));
		setPage('nextdepoleft', round(($nextdepotime - time()) / HS2_UNIX_MINUTE));
	}
}

?>