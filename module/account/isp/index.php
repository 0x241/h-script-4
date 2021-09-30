<?php

require_once('module/auth.php');
$pa = json_decode($_POST['isp_profile'], 1);

// 'http://login.investorsstartpage.com/check.aspx?token=' . $pa['token'];
/*
    [token] => f7ab4b8b-1e97-46aa-b1d5-0a6c5dd71a54
	
    [UID] => 4
    [Login] => ISP
    [E-Mail] => nock@list.ru

    [referrer] => InvestorsStartPage

    [AdvancedCash RUB] => 
    [AdvancedCash USD] => 
    [Bitcoin BTC] => 
    [Ethereum ETH] => 
    [Litecoin LTC] => 
    [Payeer RUB] => 
    [Payeer USD] => 
    [PerfectMoney USD] => U4949820
    [QIWI RUB] => 
    [Ripple XRP] => 
    [YandexMoney RUB] => 
*/

try 
{

	if ($pa['token'])
	{
                
		$data = @json_decode(file_get_contents('http://login.investorsstartpage.com/check.aspx?token=' . $pa['token']), 1);
			if ($data['status'] == 1)
			{
// { "status" : 1, "UID" : "facebook123456789012345" }
				$v = $data['UID'] . "\n";
				$uid = $db->fetch1($db->select('AddInfo', 'auID', "INSTR(CONCAT(?, aOIDs), ?)>0", array("\n", "\n" . $v)));
				if ($url = _SESSION('_go_after_login'))
					unset($_SESSION['_go_after_login']);
				if ($uid)
				{
					useLib('account/login');
						$res = opLogin($uid, $url, false, true);
				}
				else // register
				{
					useLib('account/register');
					$l = $pa['Login'];
					while ($db->count('Users', 'uLogin=?', array($l)))
						$l .= '1';
					$pass = '';
					for ($i = 1; $i <= 8; $i++)
						$pass .= rand($i == 1, 9);
					$uid = opRegisterPrepare(
						array(
							'aName' => firstNotEmpty(
								array(
									$pa['Full Name'],
									$l
								)
							),
							'uLogin' => $l,
							'uMail' => firstNotEmpty(
								array(
									$pa['E-Mail'],
									$l . '@' . $_GS['domain']
								)
							),
							'uPass' => $pass,
							'Pass2' => $pass,
							'uRef' => ($db->count('Users', 'uLogin=? and uState=1', array($pa['referrer'])) ? $pa['referrer'] : _SESSION('_ref')),
							'aTel' => $pa['Phone'],
							'Agree' => 1
						));
					if ($uid > 1)
					{
						$login = $l;
						while ($db->count('Users', 'uLogin=? and uID<>?d', array($login, $uid)))
							$login .= '1';
						$db->update('Users', array('uLogin' => $login,/*, 'uLang' => $data->language*/), '', 'uID=?d', array($uid));
						$tz = explode(':', $pa['Timezone'], 3);
						$db->update('AddInfo', array('aOIDs' => $v, 'aTZ' => $tz[0] * 60 + $tz[1]/*, 'aTel' => $data->preferred*/), '', 'auID=?d', array($uid));
						$res = opRegisterComplete($uid, $pass, $url);

require_once('lib/psys.php');
useLib('balance');
$ccurrs = $db->fetchIDRows($db->select('Currs LEFT JOIN Wallets ON wcID=cID and wuID=?d', '*', '', array($uid), 'cID'), false, 'cID');
$t = time();
foreach ($pa as $f => $v)
	if ($v)
	{
		$a = explode(' ', $f);
		if (count($a) > 1)
		{
			$curr = array_pop($a);
			$cn = implode('', $a);
			foreach ($ccurrs as $cid => $c)
				if ($curr == $c['cCurrID'])
				{
					$cname = str_replace(' ', '', $c['cName']);
					if (strpos($cname, $cn) !== false)
					{
						$pf = getPayFields($c['cCID']);
						if (preg_match('/^' . $pf['acc'][1] . '$/', $v))
						{
							$key = $cid . $uid . $t;
							$p = array('acc' => $v);
							$a = array(
								'wParams' => encodeArrayToStr($p, $key),
								'wMTS' => timetostamp($t)
							);
							$a['wcID'] = $cid;
							$a['wuID'] = $uid;
							$db->insert('Wallets', $a);
						}
					}
				}
		}
	}

						useLib('account/login');
						$res = opLogin($uid, $url, false, true);
						echo('OK');
						exit;
					}
				}
			}
		showInfo('*Error');
	}
	
}
catch (Exception $e)
{
	xaddtolog($e->getMessage(), 'isp');
}

goToURL(moduleToLink('account/login'));
	
?>