<?php

$module = 'Sec';
setPage('via_https', $_GS['https']);
setPage('curr_ip', $_GS['client_ip']);
require_once('module/admin/setup.php');

showPage();

?>