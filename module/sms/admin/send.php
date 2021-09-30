<?php

$_auth = 90;
require_once('module/auth.php');

try 
{

	if (sendedForm('send')) 
	{
		checkFormSecurity();
		
		setError($id = smsPush(0, _IN('To'), _IN('Text'), _IN('From'), _IN('Translit'), 2));
		showInfo('Saved', moduletoLink());
	}

} 
catch (Exception $e) 
{
}

showPage();

?>