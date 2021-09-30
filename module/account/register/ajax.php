<?php

require_once('module/auth.php');

try 
{

	switch (_RQ('do'))
	{
	case 'chklogin':
		echo(_RQ('login') ? $db->count('Users', 'uLogin=?', array(_RQ('login'))) : 0);
		break;
	case 'chkmail':
		echo(_RQ('mail') ? $db->count('Users', 'uMail=?', array(_RQ('mail'))) : 0);
		break;
	}

}
catch (Exception $e) 
{
}

?>