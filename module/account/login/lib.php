<?php
/* 
	Module: account/login
*/

function opLoginPrepare($login, $pass)
{
	global $db, $_cfg;
	if (sEmpty($login) or sEmpty($pass))
		return 'login_empty';
	if ($a = $db->fetch1Row($db->select('Users LEFT JOIN AddInfo ON auID=uID', 
		'uID, uLogin, aGA', 'uLogin=? and aGA<>""', array($login))))
	{
		require_once('module/account/ga/class.GoogleAuthenticator.php');
		$ga = new GoogleAuthenticator();
		if ($ga->checkCode($a['aGA'], $pass))
			$usr = $a;
		else
			return 'GA_wrong';
	}
	else
		$usr = $db->fetch1Row($db->select('Users', 'uID, uLogin', 'uLogin=? and uPass=?',
			array($login, md5($_cfg['Const_Salt'] . $pass))));
	if (($usr['uID'] < 1) or ($usr['uLogin'] != $login))
	{
	    $usr = $db->fetch1Row($db->select('Users', 'uID, uLogin, uMail', 'uMail=? and uPass=?',
		    array($login, md5($_cfg['Const_Salt'] . $pass))));
        if (($usr['uID'] < 1) or ($usr['uMail'] != $login))
	    {
	       if ($_cfg['Sec_BFC'] > 0)
		   	   $db->update('Users', array('uBFC=' => 'uBFC+1'), '', 'uLogin=?', array($login));
		    return 'login_not_found';
        }
	}
	return 0 + $usr['uID'];
}

function opLogin($uid, $url, $set_new_ip = false, $from_admin = false, $remember = false)
{
	$usr = opReadUser($uid);
	if (!$usr['uID'])
		return 'user_not_found';
	global $_GS, $db, $_cfg;
	if (!$from_admin)
	{
		if ($usr['uState'] == 0)
			return 'not_active';
		elseif ($usr['uState'] == 2)
		{
			$t = stampToTime($usr['uBTS']);
			if (time() < $t)
			{
				setPage('ban_date', timeToStr($t));
				return 'banned';
			}
			else
				$db->update('Users', array('uState' => 1, 'uBTS' => 0), 'uID=?d', array($uid));
		}
		elseif ($usr['uState'] == 3)
			return 'blocked';
		if ($_cfg['Sec_LockSite'] and ($usr['uLevel'] < 90))
			showInfo('*Denied', moduleToLink('account/login'));
		if (!$set_new_ip)
		{
			if (($_cfg['Sec_BFC'] > 0) and ($usr['uBFC'] >= $_cfg['Sec_BFC']))
			{
				useLib('confirm');
				opConfirmPrepare($uid, 'BFLOGIN', array('url' => $url, 'remember' => $remember), 'account/login');
				showInfo('Saved', moduletolink('account/login') . '?brute_force');
			}
			if (($_cfg['Sec_IP'] > 0) or ($usr['uIPSec'] > 0))
				if (!compare_ip($usr['uLIP'], $_GS['client_ip'], max($_cfg['Sec_IP'], $usr['uIPSec']))) 
				{
					useLib('confirm');
					opConfirmPrepare($uid, 'SECLOGIN', array('url' => $url, 'remember' => $remember), 'account/login');
					showInfo('Saved', moduletolink('account/login') . '?ip_changed');
				}
		}
	}
	session_destroy();
	session_start();
	$_SESSION['_sid'] = $_cfg['sys_id'];
	$_SESSION['_remember'] = $remember;
	$_SESSION['_uid'] = $uid;
	$_SESSION['_lts'] = time();
	$_SESSION['_lip'] = $_GS['client_ip'];
	$_SESSION['_lsess'] = md5(uniqid($uid, true));
	if ($remember)
		setcookie('sess', $_SESSION['_lsess'], time() + 30 * HS2_UNIX_DAY, '/');
	else
		setcookie('sess', '', time() - HS2_UNIX_DAY, '/');
	setcookie('lang', $usr['uLang'], time() + 30 * HS2_UNIX_DAY, '/');
	setcookie('mode', $usr['uMode'], time() + 30 * HS2_UNIX_DAY, '/');
	setcookie('theme', $usr['uTheme'], time() + 30 * HS2_UNIX_DAY, '/');
	if (!$from_admin)
	{
		$db->update('Users', array('uLIP' => $_SESSION['_lip'], 'uLSess' => $_SESSION['_lsess'], 'uBFC' => 0), '', 'uID=?d', array($uid));
		opAddHist('LOGIN', $uid);
		if ($usr['uLevel'] >= 90)
			SendMailToAdmin(
				'AdminIn', 
				opUserConsts($usr)
			);
	}
	showInfo('LogIn', exValue(moduleToLink('cabinet'), $url));
}

function opLoginOut($text)
{
	if ($uid = _uid())
	{
		setcookie('sess', '', time() - HS2_UNIX_DAY, '/');
		global $db;
		$db->update('Users', array('uLTS' => 0), '', 'uID=?d', array($uid));
		opAddHist('LOGOUT', $uid, $text);
	}
	session_destroy();
	session_start();
}

function opLoginConfirm($uid, $params)
{
	return opLogin($uid, $params['url'], true, false, $params['remember']);
}

?>