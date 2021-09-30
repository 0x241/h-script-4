<?php

require_once('module/auth.php');

$uid = exValue(_SESSION('nuid'), _uid());

try 
{

	if ($uid and isset($_GET['resend']))
		opConfirmResendSMS($uid);

	if (sendedForm()) 
	{
		checkFormSecurity();

		$code = _IN('Code');
		if (sEmpty($code))
			setError('code_empty');
		$op = $db->fetch1Row($db->select('Hist', '*', 'hOper=? and hMemo=?', array('CONFIRM', $code)));
		$uid = $op['huID'];
		if (!$uid)
			setError('code_not_found');
		if ($op['hTag'])
			setError('code_used');
		if ($_cfg['Confirm_Expire'] > 0)
			if (subStamps($op['hTS']) > $_cfg['Confirm_Expire'] * HS2_UNIX_MINUTE)
				setError('code_expired');
		if ($_cfg['Confirm_DifIP'])
			if ($_GS['client_ip'] != $op['hIP'])
				setError('dif_ip');
		$a = strToArray($op['hParams']);
		if (!$a['oper'])
			setError('oper_wrong');
		$db->update('Hist', array('hTag' => 1), '', 'hID=?d', array($op['hID'])); // mark as 'used'
		
		setError($e = opConfirmTry($uid, $a));
		if ($e)
			showInfo('Completed', moduleToLink() . '?done');
		showInfo('*Error');
	}

}
catch (Exception $e) 
{
}

showPage();

?>