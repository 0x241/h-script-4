<?php

// qState: 0 - waiting / 1 - processed / 2 - sended / 3 - delivered / 4 - error / 9 - suspended

function smsLoadLib()
{
	global $_cfg;
	$provs = array(
		'no/lib.php',
		'ePochta/lib.php',
		'smspilot/lib.php'
	);
	if ($prov = $provs[0 + $_cfg['SMS_Prov']])
		require_once("module/sms/$prov");
}

// uid: 0 - system
// mode: 0 - test / 1 - via queue / 2 - direct send
function smsPush($uid, $to, $message, $from = '', $use_translit = false, $mode = 2)
{
	global $db, $_cfg;
	$to = preg_replace('|[^\d]|', '', $to);
	if (textLen($to) < 11)
		return 'to_wrong';
	$message = strip_tags($message);
	if (sEmpty($message))
		return 'msg_empty';
	if (textLen($message) > 1600)
		return 'msg_too_long';
	$a = array(
		'quID' => $uid,
		'qTS' => timeToStamp(),
		'qFrom' => $from,
		'qTo' => $to,
		'qText' => $message,
		'qTranslit' => intval($use_translit),
		'qTest' => intval(!$mode),
		'qKey' => md5(rand() . uniqid()),
		'qState' => intval($mode == 2)
	);
	$a['qID'] = $db->insert('Queue', $a);
	smsLoadLib();
	if ($a['qID'] and ($mode == 2))
		smsTrySend($a);
	return $a['qID'];
}

function smsPop()
{
	global $db;
	do
	{
		$q = $db->fetch1Row($db->select('Queue', '*', 'qState=0', 'qTS', 1));
		if (!$q)
			break; // empty queue
		if ($db->update('Queue', array('qState' => 1, 'qSTS' => timeToStamp()), '', 
			'qID=?d and qState=0', array($q['qID'])))
			return $q; // poped))
	}
	while (true);
	return array();
}

function smsTrySend($q)
{
	global $db;
	smsLoadLib();
	$res = smsSend($q); // array: [msgID, Error, PartsCount, OnePartPrice]
	if (is_null($res)) // ?? need pause queue
		$a = array(
			'qState' => 9,
			'qError' => 'TimeOut',
			'qErrCnt=' => 'qErrCnt+1'
		);
	elseif ($res[0])
		$a = array(
			'qKey' => $res[0],
			'qState' => 2,
			'qError' => null,
			'qParts' => $res[2],
			'qPrice' => $res[3]
		);
	else
		$a = array(
			'qState' => 4,
			'qError' => $res[1],
			'qErrCnt=' => 'qErrCnt+1'
		);
	$a['qSTS'] = timeToStamp();
	$db->update('Queue', $a, '', 'qID=?d', array($q['qID']));
	return $a['qError'];
}

function smsSetSended($id)
{
	global $db;
	if (!$db->update('Queue', array('qState' => 3, 'qSTS' => timeToStamp(), 'qError' => ''), '', 
		'qKey=? and qState=2', array($id)))
		return false;
	return true;
}

function smsCount($text) // 70/63/66/66..   160/145/152/152..
{
	$na = (strlen($text) != mb_strlen($text)); // non-ASCII
	$l = mb_strlen($text);
	if (($l -= ($na ? 70 : 160)) <= 0)
		return 1;
	if (($l -= ($na ? 63 : 145)) <= 0)
		return 2;
	return 2 + ceil($l / ($na ? 66 : 152));
}

function smsToUser($uid, $to, $section, $consts = array(), $lang = '', $fname = 'sms')
{
	global $_GS, $_cfg;
	$lang = getLang($lang);
	$txt = loadText($section, $fname, $lang);
	if (!$txt["$section.message"])
		return false;
	$hdr = loadText('_header', $fname, $lang);
	$ftr = loadText('_footer', $fname, $lang);
	$consts['date'] = timeToStr(time(), 0, $lang);
	$consts['ip'] = $_GS['client_ip'];
	$consts['rooturl'] = $_GS['root_url'];
	$consts['sitename'] = $_cfg['Sys_SiteName'];
	prepVal($consts, 2);
//	textVarReplace($txt["$section.topic"], $consts)	
	return smsPush($uid, $to, textVarReplace($txt["$section.message"], $consts));
}

?>