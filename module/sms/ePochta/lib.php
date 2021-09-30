<?php

function smsSend($q)
{
	global $_cfg;
	$a = array('XML' =>
'<SMS>
	<operations>
		<operation>SEND</operation>
	</operations>
	<authentification>
		<username>' . $_cfg['SMS_EP_Login'] . '</username>
		<password>' . $_cfg['SMS_EP_Pass'] . '</password>
	</authentification>
	<message>
		<sender>' . exValue($_cfg['SMS_From'], $q['qFrom']) . '</sender>
		<text>' . $q['qText'] . '</text>
	</message>
	<numbers>
		<number messageID="' . $q['qID'] . '">' . $q['qTo'] . '</number>
	</numbers>
</SMS>');
	require_once('lib/inet.php');
	$res = inet_request('http://atompark.com/members/sms/xml', $a);
	if (!preg_match('|status>(.*)</status.*credits>(.*)</credits|isU', $res, $res))
		return null;
/*

<RESPONSE>
	<status>status_code</status>
	<credits></credits>
</RESPONSE>

AUTH_FAILED			-1 	Неправильный логин и/или пароль
XML_ERROR			-2 	Неправильный формат XML
NOT_ENOUGH_CREDITS	-3 	Недостаточно кредитов на аккаунте пользователя
NO_RECIPIENTS		-4 	Нет верных номеров получателей
SEND_OK				>0 	Количество отправленных SMS.

    [0] => status>1</status>
<credits>0.3</credits
    [1] => 1
    [2] => 0.3

*/
	$errs = array(
		-1 => 'AUTH_FAILED',
		-2 => 'XML_ERROR',
		-3 => 'NOT_ENOUGH_CREDITS',
		-4 => 'NO_RECIPIENTS'
	);
	if ($res[1] > 0)
		return array($q['qID'], 'OK', 1, $res[2]);
	else
		return array(0, $errs[$res[1]], 0, 0);
}

function smsCheck($ids) // array
{
	global $_cfg;
	$a =
'<SMS>
	<operations>
		<operation>GETSTATUS</operation>
	</operations>
	<authentification>
		<username>' . $_cfg['SMS_EP_Login'] . '</username>
		<password>' . $_cfg['SMS_EP_Pass'] . '</password>
	</authentification>
	<statistics>
';
	foreach ($ids as $id)
		$a .= 
'		<messageid>' . $id . '</messageid>
';
	$a = array('XML' => $a .
'	</statistics>
</SMS>');
	require_once('lib/inet.php');
	$res = inet_request('http://atompark.com/members/sms/xml', $a);
	if (!preg_match_all('|id="(.*)".*status="(.*)"|isU', $res, $res, PREG_SET_ORDER))
		return null;
/*

<deliveryreport>
	<messageid id="msgID" sentdate="xxxxx" donedate="xxxxx" status="xxxxxx" />
	<messageid id="msgID" sentdate="xxxxx" donedate="xxxxx" status="xxxxxx" />
	...
</deliveryreport>

SENT						Отослано
NOT_DELIVERED 				Не доставлено
DELIVERED 					Доставлено
NOT_ALLOWED 				Оператор не обслуживается
INVALID_DESTINATION_ADDRESS Неверный адрес для доставки
INVALID_SOURCE_ADDRESS 		Неправильное имя "От кого"
NOT_ENOUGH_CREDITS 			Недостаточно кредитов

    [0] => Array
        (
            [0] => id="1" sentdate="0000-00-00 00:00:00" donedate="0000-00-00 00:00:00" status="0"
            [1] => 1
            [2] => 0
        )
		
*/	
	$a = array();
	foreach ($res as $r)
		$a[$r[1]] = valueIf($r[2] == 'DELIVERED', 'OK', $r[2]);
	return $a;
}
	
?>