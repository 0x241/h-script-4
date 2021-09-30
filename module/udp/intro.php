<?php

require_once('module/auth.php');

if (!$_cfg['UI_ShowIntro'])
	goToURL(moduleToLink('index'));

showPage();

?>