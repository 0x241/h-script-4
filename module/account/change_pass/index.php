<?php

$_auth = 1;
require_once('module/auth.php');

try
{

	if (sendedForm())
	{
		checkFormSecurity();

		if ($_GS['demo'] and ($_user['uLevel'] < 99) and (_uid() <= 3))
			showInfo('*Denied');

		if (md5($_cfg['Const_Salt'] . _IN('Pass0')) != $_user['uPass'])
			setError('pass0_wrong');
		if (sEmpty(_IN('Pass')))
			setError('pass_empty');
		if (($_cfg['Account_MinPass'] > 0) and (strlen(_IN('Pass')) < $_cfg['Account_MinPass']))
			setError('pass_short');
		if ($_cfg['Account_PassRegx'] and !preg_match($_cfg['Account_PassRegx'], _IN('Pass')))
			setError('pass_wrong');
		if (_IN('Pass2') != _IN('Pass'))
			setError('pass_not_equal');
		if (($_cfg['Sec_MinPIN'] > 0) and (md5(_IN('PIN') . $_cfg['Const_Salt']) != $_user['uPIN']))
			setError('pin_wrong');
		$db->update('Users', array('uPass' => md5($_cfg['Const_Salt'] . _IN('Pass')), 'uPTS' => timeToStamp()), '', 'uID=?d', array(_uid()));
		opAddHist('CHG_PASS');
		SendMailToUser($_user['uMail'],
			'PassChanged2',
			opUserConsts($_user, array('pass' => _IN('Pass'))),
			$_user['uLang'],
			'e-mails_'.$usr['uLang']
		);
		showInfo('Completed', moduleToLink('account'));
	}

	if (sendedForm('skip'))
	{
		checkFormSecurity();

		$db->update('Users', array('uPTS' => timeToStamp()), '', 'uID=?d', array(_uid()));
		goToURL(moduleToLink('account'));
	}

}
catch (Exception $e)
{
}

$_GS['vmodule'] = 'account';
showPage();

?>