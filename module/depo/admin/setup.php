<?php

$module = 'Depo';
require_once('module/admin/setup.php');

setPage('depolasttime', timeToStr(stampToTime($_cfg['Depo_LastTime']), 2));
setPage('depolast', round(subStamps($_cfg['Depo_LastTime']) / HS2_UNIX_MINUTE));

showPage();

?>