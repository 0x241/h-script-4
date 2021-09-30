<?php

require_once('module/auth.php');

// 'http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST'];
try 
{

	if (_uid() and _GET('sub'))
	{
		$v = base64_decode(_GET('sub')) . "\n";
		$db->update('AddInfo', array('aOIDs' => str_replace($v, '', $_user['aOIDs'])), '', 'auID=?d', array(_uid()));
		showInfo('Completed', moduleToLink());
	}
	
	if (_IN('token'))
	{
                
		$data = file_get_contents('http://ulogin.ru/token.php?token=' . _IN('token') . '&host=' . $_SERVER['HTTP_HOST']);
		if ($data = file_get_contents('http://ulogin.ru/token.php?token=' . _IN('token') . '&host=' . $_SERVER['HTTP_HOST']))
			if ($data = json_decode($data))
			{
//$user['network'] - соц. сеть, через которую авторизовался пользователь
//$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
//$user['first_name'] - имя пользователя
//$user['last_name'] - фамилия пользователя
//				$v = md5($data->identity) . '=' . $data->provider . "\n";
				$v = $data->identity . "\n";
				$uid = $db->fetch1($db->select('AddInfo', 'auID', "INSTR(CONCAT(?, aOIDs), ?)>0", array("\n", "\n" . $v)));
				if (_uid()) // attach account
				{
					$url = moduleToLink();
					if (!$uid)
					{
						$db->query('UPDATE AddInfo SET `aOIDs`=CONCAT(aOIDs,?) WHERE auID=?d', array($v, _uid()));
						showInfo('Added', $url);
					}
					else
						showInfo('*AlreadyUsed', $url);
				} 
				else // login or register
				{
					if ($url = _SESSION('_go_after_login'))
						unset($_SESSION['_go_after_login']);
					if ($uid)
					{
						useLib('account/login');
						opLogin($uid, $url);
					}
					else // register
					{
						useLib('account/register');
						$l = getDomain($data->network) . '-' . uniqid();
						$pass = '';
						for ($i = 1; $i <= 8; $i++)
							$pass .= rand($i == 1, 9);
						$uid = opRegisterPrepare(
							array(
								'aName' => firstNotEmpty(
									array(
										$data->first_name, 
										trim($data->first_name . ' ' . $data->last_name)
									)
								),
								'uLogin' => $l,
								'uMail' => firstNotEmpty(
									array(
										$data->email, 
										$l . '@' . $_GS['domain']
									)
								),
								'uPass' => $pass,
								'Pass2' => $pass,
								'uRef' => _SESSION('_ref'),
								'aTel' => '+79876543210',
								'Agree' => 1
							));
						if ($uid > 1)
						{
							$login = "User$uid";
							while ($db->count('Users', 'uLogin=?', array($login)))
								$login .= '!';
							$db->update('Users', array('uLogin' => $login, 'uLang' => $data->language), '', 'uID=?d', array($uid));
							$db->update('AddInfo', array('aOIDs' => $v, 'aTel' => $data->preferred), '', 'auID=?d', array($uid));
							opRegisterComplete($uid, $pass, $url);
							showInfo('Completed', moduleToLink('account/register') . '?done');
						}
					}
				}
			}
		showInfo('*Error');
	}
	
}
catch (Exception $e)
{
}

if (!_uid())
	goToURL(moduleToLink('account/login'));
	
$logins = array();
$a = explode("\n", $db->fetch1($db->select('AddInfo', 'aOIDs', 'auID=?d', array(_uid()))));
foreach ($a as $l)
	if ($l)
		$logins[] = array('url' => $l);
/*if (preg_match_all("|(.*)=(.*)\n|", $a . "\n", $a, PREG_SET_ORDER))
	foreach ($a as $l)
		if ($l[1])
			$logins[$l[1]] = $l[2];*/
setPage('logins', $logins);
setPage('loginza_url', urlencode(fullURL(moduleToLink('account/loginza'))));
$_GS['vmodule'] = 'account';

showPage();

?>