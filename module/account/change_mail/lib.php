<?php

function opChangeMail($uid, $mail)
{
	$usr = opReadUser($uid);
	if (!$usr['uID'])
		return false;
	global $db, $_cfg;
	if ($db->count('Users', 'uMail=? and uID<>?d', array($mail, $uid)) > 0)
		showInfo('*AlreadyUsed', moduleToLink('account/change_mail') . '?already_used');
	$a = array('uMail' => $mail);
	if ($_cfg['Const_NoLogins'])
		$a['uLogin'] = $mail;
	$db->update('Users', $a, '', 'uID=?d', array($uid));
	opAddHist('CHG_MAIL', $uid);
	SendMailToUser($mail,
		'MailChanged',
		opUserConsts($usr),
		$usr['uLang'],
		'e-mails_'.$usr['uLang']
	);
	return true;
}

function opChangeMailConfirm($uid, $params)
{
	if (opChangeMail($uid, $params['mail']))
		showInfo('Completed', moduleToLink('account/change_mail') . '?done');
}

?>