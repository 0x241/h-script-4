<?php
/*
	Module: confirm
*/

function opConfirmPrepare($uid, $oper, $params = array(), $module = '', $mail = '')
{
	global $_GS;
	$usr = opReadUser($uid);
	if (!$usr['uID'])
		return false;
	$params['oper'] = $oper;
	if (!$module)
		$module = $_GS['module'];
	$params['module'] = $module;
	$params['mname'] = textReplace(cutElemR($module, '/'), '_', '');
	$code = md5(uniqid() . $uid . $oper);
	opAddHist('CONFIRM', $uid, $params, $code); // tag = 0
	return sendMailToUser(exValue($usr['uMail'], $mail),
		'AskConfirm' . $oper,
		opUserConsts($usr, array('code' => $code, 'url' => fullURL(moduleToLink('confirm')))),
		$usr['uLang']
	);
}

function opConfirmPrepareSMS($uid, $oper, $params = array(), $module = '', $tel = '')
{
	global $_GS;
	$usr = opReadUser($uid);
	if (!$usr['uID'])
		return false;
	$params['oper'] = $oper;
	if (!$module)
		$module = $_GS['module'];
	$params['module'] = $module;
	$params['mname'] = textReplace(cutElemR($module, '/'), '_', '');
	$code = '';
	for ($i = 1; $i <= 5; $i++)
		$code .= rand(0, 9);
	opAddHist('CONFIRM', $uid, $params, $code); // tag = 0
	useLib('sms');
	$params['code'] = $code;
	$params['url'] = fullURL(moduleToLink('confirm'));
	return smsPush($uid, exValue($usr['aTel'], $tel), "Code: $code", '', false, 2);
}

function opConfirmResendSMS($uid)
{
	global $db;
	$op = $db->fetch1Row($db->select('Hist', '*', 'huID=? and hOper=?', array($uid, 'CONFIRM'), 'hID desc', 1));
	$t = subStamps($op['hTS']);
	if (!$op['hTag'] and (($t > 1 * HS2_UNIX_MINUTE) and ($t < 10 * HS2_UNIX_MINUTE)))
	{
		$a = strToArray($op['hParams']);
		$a['count'] = $a['count'] + 1;
		if ($a['count'] <= 3)
		{
			opConfirmPrepareSMS($uid, $a['oper'], $a, $a['module']);
			showInfo('Completed', moduleToLink('confirm') . '?need_confirm_sms');
		}
	}
	showInfo('*Error', moduleToLink('confirm') . '?need_confirm_sms');
}

function opConfirmTry($uid, $params)
{
	useLib($m = $params['module']);
	$f = 'op' . $params['mname'] . 'Confirm';
	if (function_exists($f))
		return $f($uid, $params);
	return false;
}

?>