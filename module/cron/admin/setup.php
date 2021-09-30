<?php

$module = 'Cron';
require_once('module/admin/setup.php');

$list = array();
foreach ($_oncron as $m => $n)
	$list["$m <<$n>>"] = round(subStamps($_cfg['Cron_' . $m]) / HS2_UNIX_MINUTE) + $n;
setPage('cronlist', $list);
setPage('cronpath', realpath('cron.php'));

showPage();

?>