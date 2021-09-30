<?php

$module = 'Bal';
require_once('module/admin/setup.php');

setPage('lastupdate', timeToStr(stampToTime($_cfg['Bal_LastUpdate']), 2));

showPage();

?>