<?php

if (!($m = strtolower(_RQ('module'))))
	xSysStop("Ajax: Module not defined");
if (!$_rwlinks[$m])
	xSysStop("Ajax: Unknown module '$m'");
if (!file_exists($f = $_GS['module_dir'] . $m . '/ajax.php'))
	xSysStop("Ajax: No '$f' module extension found");

$_GS['module'] = $m;
$_GS['script'] = $f;
	
$_smode = 1;
require($_GS['script']);

?>