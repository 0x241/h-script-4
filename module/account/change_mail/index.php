<?php

require_once('module/auth.php');

try 
{

	function _changeMail($uid, $mail) 
	{
		global $_cfg;
		useLib('confirm');
		if ($_cfg['Account_ChMailConfirm']) 
		{
			if (opConfirmPrepare($uid, 'CHGMAIL', array('mail' => $mail), '', $mail))
				showInfo('Saved', moduleToLink() . '?need_confirm');
		}
		else
			if (opChangeMail($uid, $mail) !== false)
			{
				if (_uid())
					showInfo('Completed', moduleToLink('account'));
				else
					showInfo('Completed', moduleToLink('account/change_mail') . '?done');
			}
		showInfo('*Error');
	}
	
	if (sendedForm())
	{
		checkFormSecurity();

		if ($_GS['demo'] and ($_user['uLevel'] < 99) and (_uid() <= 3))
			showInfo('*Denied');
			
		$pass = _IN('Pass');
		$mail = _IN('NewMail');
		if (_uid())
		{
			if (md5($_cfg['Const_Salt'] . $pass) != $_user['uPass'])
				setError('pass_not_found');
			$usr = array(
				'uID' => $_user['uID'],
				'uMail' => $_user['uMail'],
				'aSQuestion' => $_user['aSQuestion'],
				'aSAnswer' => $_user['aSAnswer']
			);
		}
		else
		{
			$login = _IN('Login');
			if (sEmpty($login) or sEmpty($pass))
				setError('login_empty');
			$f = (!$_cfg['Const_NoLogins'] ? 'uLogin' : 'uMail');
			$usr = $db->fetch1Row($db->select('Users LEFT JOIN AddInfo ON auID=uID', 
				'uID, uLogin, uMail, aSQuestion, aSAnswer, uState, uBTS',
				"$f=? and uPass=?", array($login, md5($_cfg['Const_Salt'] . $pass))
				)
			);
			if (($usr['uID'] < 1) or ($usr[$f] != $login)) 
				setError('login_not_found');
			if ($usr['uState'] == 2) 
			{
				setPage('ban_date', timeToStr(stampToTime($usr['uBTS'])));
				setError('banned');
			}
			if ($usr['uState'] == 3)
				setError('blocked');
		}
		$uid = $usr['uID'];
		if (sEmpty($mail))
			setError('mail_empty');
		if (!validMail($mail))
			setError('mail_wrong');
		if ($db->count('Users', 'uID<>?d and uMail=?', array($uid, $mail)) > 0)
			setError('mail_used');
		if (_uid() or ($_cfg['Sec_MinSQA'] == 0))
			_changeMail($uid, $mail);
		if (!$usr['aSQuestion'] or !$usr['aSAnswer'])
			showInfo('*CantComplete');
		$usr['NewMail'] = $mail;
		$_SESSION['_fchange'][$uid] = $usr;
		$_IN['uID'] = $uid;
		resetCaptcha();
	}
	else
		$uid = _INN('uID');
	if (($uid > 0) and ($uid == $_SESSION['_fchange'][$uid]['uID'])) 
	{
		setPage('uid', $uid);
		setPage('squest', $_SESSION['_fchange'][$uid]['aSQuestion']);
		setPage('captcha', $_cfg['Account_ChMailCaptcha']);
		if (sendedForm('', 'sqa'))
		{
			checkFormSecurity('sqa');
			
			if (md5(_IN('SAnswer') . $_cfg['Const_Salt']) != $_SESSION['_fchange'][$uid]['aSAnswer'])
				setError('answer_wrong', 'sqa');
			_changeMail($uid, $_SESSION['_fchange'][$uid]['NewMail']);
		}
	}

} 
catch (Exception $e) 
{
}

$_GS['vmodule'] = 'account';
showPage();

?>