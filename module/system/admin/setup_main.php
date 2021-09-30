<?php

$module = 'Sys';
require_once('module/admin/setup.php');

setPage('ip_server', $_SERVER['SERVER_ADDR']);

showPage();

?>