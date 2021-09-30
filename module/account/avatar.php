<?php

$_auth = 1;
require_once('module/auth.php');

try 
{

	if (sendedForm()) 
	{
		checkFormSecurity();
		
		useLib('files');
		if ($im = imageLoad('Avatar'))
		{
			@unlink($fname = AVATAR_DIR . 'a' . _uid() . '.jpg');
			@unlink($fname2 = AVATAR_DIR . 'i' . _uid() . '.jpg');
			$res = imagejpeg(imageResize($im, 100, 100), $fname, 80);
			$db->update('AddInfo', array('aAvatar' => $res), '', 'auID=?d', array(_uid()));
			if ($res)
			{
				imagejpeg(imageResize($im, 20, 20), $fname2, 80);
				showInfo('Completed', moduleToLink('account'));
			}
		}

		showInfo('*Error');
	}
	
	if (sendedForm('clear')) 
	{
		checkFormSecurity();
		
		@unlink(AVATAR_DIR . 'a' . _uid() . '.jpg');
		@unlink(AVATAR_DIR . 'i' . _uid() . '.jpg');
		$db->update('AddInfo', array('aAvatar' => 0), '', 'auID=?d', array(_uid()));
		showInfo('Completed', moduleToLink('account'));
	}
} 
catch (Exception $e) 
{
}

showPage();

?>