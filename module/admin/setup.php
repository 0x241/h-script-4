<?php

// var $module must be set!

$_auth = 90;
require_once('module/auth.php');

try 
{

	if (sendedForm())
	{
		checkFormSecurity();
		
		if ($_GS['demo'] and ($_user['uLevel'] < 99))
			showInfo('*Denied');

		$db->delete('Cfg', 'Module=?', array($module));
		foreach ($_IN as $p => $v)
        {
           		if (substr($p, -4) != '_btn')
				$db->insert('Cfg', array(
					'Module' => $module, 
					'Prop' => $p, 
					'Val' => $v
				)); 
        }
		showInfo('Saved');
	}
	
} 
catch (Exception $e) 
{
}

setPage('currs2', $_currs2);
setPage('cfg', $db->fetchIDRows($db->select('Cfg', '*', 'Module=?', array($module)), 'Val', 'Prop'));

?>