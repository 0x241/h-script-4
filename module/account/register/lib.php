<?php
/*
	Module: account/register
*/

function opRegisterUserCheck(&$params, $uid = 0, $from_admin = false) // !!! Pass2 must be set
{
	global $db, $_cfg;
	if (!$from_admin and ($_cfg['Account_UseName'] == 1) and (sEmpty($params['aName'])))
		return 'name_empty';
	if (!$_cfg['Const_NoLogins'])
	{
		if (sEmpty($params['uLogin']))
			return 'login_empty';
		if (($_cfg['Account_MinLogin'] > 0) and (strlen($params['uLogin']) < $_cfg['Account_MinLogin']))
			return 'login_short';
		if ($_cfg['Account_LoginRegx'] and !preg_match(exValue('/[^\s]+/', $_cfg['Account_LoginRegx']), $params['uLogin']))
			return 'login_wrong';
		if ($db->count('Users', 'uID<>?d and uLogin=?', array($uid, $params['uLogin'])) > 0)
			return 'login_used';
	}
	if (sEmpty($params['uMail']))
		return 'mail_empty';
	if (!validMail($params['uMail']))
		return 'mail_wrong';
	if ($db->count('Users', 'uID<>?d and uMail=?', array($uid, $params['uMail'])) > 0)
		return 'mail_used';
	if (sEmpty($params['uLogin']) or $_cfg['Const_NoLogins'])
		$params['uLogin'] = $params['uMail'];
	if (sEmpty($params['aName']))
		$params['aName'] = get1ElemL($params['uLogin'], '@');
	if (!$uid or !sEmpty($params['uPass']))
	{
		if (sEmpty($params['uPass']))
			return 'pass_empty';
		if (($_cfg['Account_MinPass'] > 0) and (strlen($params['uPass']) < $_cfg['Account_MinPass']))
			return 'pass_short';
		if ($_cfg['Account_PassRegx'] and !preg_match($_cfg['Account_PassRegx'], $params['uPass']))
			return 'pass_wrong';
		if (!$from_admin and !$uid and ($params['Pass2'] != $params['uPass']))
			return 'pass_not_equal';
		$params['uPass'] = md5($_cfg['Const_Salt'] . $params['uPass']);
		$params['uPTS'] = timeToStamp();
	}
	else
	{
		unset($params['uPass']);
		unset($params['uPTS']);
	}
	if ($uid) // from admin
	{
		if (!sEmpty($params['uPIN']))
		{
			if (($_cfg['Sec_MinPIN'] > 0) and (strlen($params['uPIN']) < $_cfg['Sec_MinPIN']))
				return 'pin_short';
			$params['uPIN'] = md5($params['uPIN'] . $_cfg['Const_Salt']);
		}
		else
			unset($params['uPIN']);
	}
	if (!$from_admin)
	{
		if ($_cfg['SMS_REG'])
		{
			$params['aTel'] = preg_replace('|[^\d]|', '', $params['aTel']);
			if (textLen($params['aTel']) < 11)
				return 'tel_wrong';
		}
		global $_currs2;
		if (!$_currs2[$params['aDefCurr']])
			return 'defpsys_wrong';
	}
	if (($_cfg['Account_RegMode'] == 2) and !$params['uRef'])
		return 'ref_empty';
	if ((!$from_admin or $uid) and $params['uRef'])
	{
		$ruid = $db->fetch1($db->select('Users', 'uID', 'uLogin=?', array($params['uRef'])));
		if (!$ruid)
			return 'ref_not_found';
		if ($uid and ($ruid == $uid))
			return 'ref_is_self';
	}
	else
		$ruid = 0;
	$params['uRef'] = $ruid;
	if (!$uid) // from reg
	{
		if (($_cfg['Account_RegMode'] == 3) and sEmpty($params['Invite']))
			return 'inv_empty';
		// ??? check Invite
	}
	if (($_cfg['Sec_MinSQA'] > 0) and (!$from_admin))
	{
		if (!$params['aSQuestion'])
			return 'secq_empty';
		if (strlen($params['aSQuestion']) < $_cfg['Sec_MinSQA'])
			return 'secq_short';
		if (!$uid and sEmpty($params['aSAnswer']))
			return 'seca_empty';
		if (!sEmpty($params['aSAnswer']))
		{
			if (strlen($params['aSAnswer']) < $_cfg['Sec_MinSQA'])
				return 'seca_short';
			if ($params['aSAnswer'] == $params['aSQuestion'])
				return 'seqa_equal_secq';
			$params['aSAnswer'] = md5($params['aSAnswer'] . $_cfg['Const_Salt']);
		}
		else
			unset($params['aSAnswer']);
	}
	return true;
}

function opRegisterPrepare($params, $from_admin = false)
{
	$res = opRegisterUserCheck($params, 0, $from_admin);
	if ($res !== true)
		return $res;
	if (!$from_admin and !$params['Agree'])
		return 'must_agree';

	global $_GS, $db, $_cfg;
	if (!$from_admin and $_cfg['Account_RegCheck'])
	{
		if ($_cfg['Account_RegCheck'] & 1)
			if ($db->count('AddInfo', 'aCIP=?', array($_GS['client_ip'])))
				return 'multi_reg';
		if ($_cfg['Account_RegCheck'] & 2)
			if (_COOKIE('active'))
				return 'multi_reg';
	}

	$params['uState'] = 0;
	$params['uLevel'] = 1;
	$params['uLang'] = $_GS['lang'];
	$params['uMode'] = $_GS['mode'];
	$params['uTheme'] = $_GS['theme'];
    $params['aTZ'] = $_cfg['UI_DefaultTZ']*60;
	$params['auID'] = $db->insert('Users', $params,
		'uLogin, uPass, uMail, uState, uLevel, uLang, uMode, uTheme, uRef');
	if (!$params['auID'])
		return false;
	$params['aCTS'] = timeToStamp();
	$params['aCIP'] = $_GS['client_ip'];
	$db->insert('AddInfo', $params, 'auID, aName, aCTS, aCIP, aSQuestion, aSAnswer, aCountry, aTel, aTZ, aDefCurr');
	if (!$from_admin)
	{
		setcookie('active', $params['auID'], time() + 365 * HS2_UNIX_DAY, '/'); // mark 'registered'
		$params['uID'] = $params['auID'];
		SendMailToAdmin(
			'NewUser',
			opUserConsts($params)
		);
	}
	return $params['auID'];
}

function opRegisterComplete($uid, $pass = '', $url = '') // $pass (for autoregister) is send to mail
{
	$usr = opReadUser($uid);
	if ($usr['uID'] <= 1) // except admin ;)
		return 'user_not_found';
	global $_GS, $db, $_cfg;
	$pin = '';
	for ($i = 1; $i <= $_cfg['Sec_MinPIN']; $i++)
		$pin .= rand(1, 9);
	$db->update('Users', array('uPIN' => md5($pin . $_cfg['Const_Salt']), 'uState' => 1), '', 'uID=?d', array($uid));
	opAddHist('REG', $uid);
	SendMailToUser($usr['uMail'],
		'RegComplete' . valueIf($pass, '2'),
		opUserConsts($usr, array('pass' => $pass, 'pin' => $pin)),
		$usr['uLang']
	);
	if (($rusr = opReadUser($usr['uRef'])) and $rusr['uID'])
		SendMailToUser($rusr['uMail'],
			'NewRef',
			opUserConsts($rusr, array('reflogin' => $usr['uLogin'])),
			$rusr['uLang']
		);
	opEvent('RegComplete', $uid);
	if ($_cfg['Account_RegLogin'])
	{
		useLib('account/login');
		opLogin($uid, $url);
	}
	return true;
}

function opRegisterMail($uid, $mail)
{
	$usr = opReadUser($uid);
	if (!$usr['uID'])
		return false;
	global $db;
	if ($db->count('Users', 'uMail=? and uID<>?d', array($mail, $uid)) > 0)
		showInfo('*AlreadyUsed', moduleToLink('account/change_mail') . '?already_used');
	$db->update('Users', array('uMail' => $mail), '', 'uID=?d', array($uid));
	opAddHist('REG_MAIL', $uid);
	SendMailToUser($mail,
		'MailChanged',
		opUserConsts($usr),
		$usr['uLang']
	);
	return true;
}

function opRegisterTel($uid, $tel)
{
	$usr = opReadUser($uid);
	if (!$usr['uID'])
		return false;
	global $db;
	if ($db->count('AddInfo', 'aTel=? and auID<>?d', array($tel, $uid)) > 0)
		showInfo('*AlreadyUsed', moduleToLink('account/register') . '?tel_already_used');
	$db->update('AddInfo', array('aTel' => $tel), '', 'auID=?d', array($uid));
	opAddHist('REG_TEL', $uid);
	return true;
}

function opRegisterConfirm($uid, $params)
{
	if ($params['tel'])
		if (opRegisterTel($uid, $params['tel']))
		{
			opRegisterComplete($uid);
			showInfo('Completed', moduleToLink('account/register') . '?done');
		}
	if (opRegisterMail($uid, $params['mail']))
	{
		opRegisterComplete($uid);
		showInfo('Completed', moduleToLink('account/register') . '?done');
	}
}

?>