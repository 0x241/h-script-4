<?php

require_once('module/auth.php');

try 
{

	function _resetPass($uid) 
	{
		global $_cfg;
		useLib('confirm');
		if (opConfirmPrepare($uid, 'RSTPASS'))
			showInfo('Saved', moduleToLink() . '?need_confirm');
		showInfo('*Error');
	}
	
	if (sendedForm())
	{
		checkFormSecurity();

		if (sEmpty(_IN('Login')))
			setError('login_empty');
		$usr = $db->fetch1Row($db->select('Users LEFT JOIN AddInfo ON auID=uID', 
			'uID, uLogin, uMail, aSQuestion, aSAnswer', 
			valueIf(!$_cfg['Const_NoLogins'], 'uLogin=? and ') . 'uMail=?', array(_IN('Login'), _IN('Mail'))));
		$uid = $usr['uID'];
		if (!$uid)
			setError(!$_cfg['Const_NoLogins'] ? 'login_not_found' : 'mail_not_found');

		if ($_GS['demo'] and ($_usr['uLevel'] < 99) and ($uid <= 3))
			showInfo('*Denied');
			
		if ($_cfg['Sec_MinSQA'] == 0)
			_resetPass($uid);
		if (!$usr['aSQuestion'] or !$usr['aSAnswer'])
			showInfo('*CantComplete');
		$_SESSION['_freset'][$uid] = $usr;
		$_IN['uID'] = $uid;
		resetCaptcha();
	}
	else
		$uid = _INN('uID');
	if (($uid > 0) and ($uid == $_SESSION['_freset'][$uid]['uID']))
	{
		setPage('uid', $uid);
		setPage('squest', $_SESSION['_freset'][$uid]['aSQuestion']);
		setPage('captcha', $_cfg['Account_ResPassCaptcha']);
		if (sendedForm('', 'sqa'))
		{
			checkFormSecurity('sqa');
			
			if (md5(_IN('SAnswer') . $_cfg['Const_Salt']) != $_SESSION['_freset'][$uid]['aSAnswer'])
				setError('answer_wrong', 'sqa');
			_resetPass($uid);
		}
	}

} 
catch (Exception $e) 
{
}

$_GS['vmodule'] = 'account';
showPage();

?>