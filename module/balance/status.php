<?php

if (!$_POST)
	$_IN = $_POST = $_GET;
if (!$_POST)
	$_IN = $_POST = json_decode(file_get_contents('php://input'), true);

$_smode = 2;
require_once('module/auth.php');
require_once('lib/psys.php');

//xAddToLog('POST: ' . print_r($_POST, true));
if (!($psys = detectSCI($_IN)))
{
	xAddToLog('*** Unknown request ***');
	xAddToLog('GET: ' . print_r($_GET, true));
	xAddToLog('POST: ' . print_r($_POST, true));
	xStop('Status URL');
}

try 
{
	$c = $db->fetch1Row($db->select('Currs', '*', 'cDisabled=0 and cCID=?', array($psys)));
	if (!$c['cID'])
		xStop("*** Payment system '$psys' disabled ***");
} 
catch (Exception $e) 
{
}

opDecodeCurrParams($c, $p, $p_sci, $p_api);
$res = chkSCI($psys, $_IN, $p_sci);
/*if ($c['cCASHOUTMode'] >= 2)
	if (!chkTrans($psys, $res, $p_api))
		$res['correct'] = false;*/
$oid = $res['tag'];
if (!$res['correct'] or !$oid)
{
	sendMailToAdmin('AddFundsError', array(
		'request' => print_r($_IN, true),
		'result' => print_r($res, true),
		'params' => print_r($p_sci, true)
		)
	);
	exit;
}
if (!$db->count('Opers', 'oID=?d and ocID=?d and oOper=? and oState<3', array($oid, $c['cID'], 'CASHIN')))
	exit;
$res['cid'] = $c['cID'];
$res['date'] = time();
$res['acc'] = $res['accfrom'];
if (($err = opOperConfirm(-1, $oid, $res, false)) === true)
	if ($res['wait'] or (($err = opOperComplete(-1, $oid)) === true))
		exit;
sendMailToAdmin('AddFundsError2', array(
	'oid' => $oid,
	'error' => $err
	)
);

?>