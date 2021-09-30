<?php

useLib('sms');

$uc = valueIf($_cfg['SMS_UpdateCount'] > 0, $_cfg['SMS_UpdateCount'], 20);
$qs = $db->fetchRows($db->select('Queue', 'qKey', 'qState=2', '', 'qSTS', $uc), 1);
if ($qs)
{
$res = smsCheck($qs);
foreach ($res as $id => $state)
	if ($state == 'OK')
		smsSetSended($id);
	else
		$db->update('Queue', array('qSTS' => timeToStamp(), 'qError' => $state), '', 
			'qKey=? and qState=2', array($id));
}

$db->update('Queue', array('qTS' => timeToStamp(), 'qState'=>0), '', 'qState=1 and qTS<?', array(timeToStamp(time() - 3 * HS2_UNIX_MINUTE)));
$db->update('Queue', array('qTS' => timeToStamp(), 'qState'=>0), '', 'qState=9 and qErrCnt<5 and qTS<?', array(timeToStamp(time() - 5 * HS2_UNIX_MINUTE)));

$sc = valueIf($_cfg['SMS_SendCount'] > 0, $_cfg['SMS_SendCount'], 20);
for ($ns = 1; $ns <= $sc; $ns++)
{
	$q = smsPop();
	if (!$q)
		break;
	smsTrySend($q);
}

?>