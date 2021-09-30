<?php

require_once('module/sms/smspilot/smspilot.class.php');

function smsSend($q, $is_test = false)
{
	global $_cfg;
	$sms = new SMSPilot(valueIf($is_test, 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ', $_cfg['SMS_SP_Pass']));
	if ($sms->send($q['qTo'], $q['qText'], exValue($_cfg['SMS_From'], $q['qFrom'])))
	{
		$res = $sms->status[0];
		return array($res['id'], $res['status'], smsCount($message), $res['zone']);
	}
	else
		return array(0, $sms->error, 0, 0);
/*
Array
(
    [0] => Array
        (
            [id] => 10000
            [phone] => 79272231428
            [zone] => 1
            [status] => 0
        )

)
*/
}

function smsCheck($ids) // array
{
	global $_cfg;
	$res = array();
	foreach ($ids as $id)
		$res[$id] = -3;
	$sms = new SMSPilot($_cfg['SMS_SP_Pass']);
	if ($cres = $sms->check($ids))
		foreach ($cres as $r)
			$res[$r['id']] = $r['status'];
	return $res;
}

/*
100: EMPTY APIKEY	Не указан параметр apikey	   
101: WRONG APIKEY	Неправильный apikey	   
102: APIKEY NOT FOUND	Такой ключ не найден	   
106: APIKEY BLOCKED (SPAM)	Подозрение в рассылке спама. Свяжитесь со службой поддержки.	   
107: EMPTY MESSAGE	Пустое значение параметра send	   
108: EMPTY PHONE	Пустое значение параметра to	   
109: WRONG PHONE	Неправильный номер телефона	   
110: SYSTEM ERROR	Непредвиденная ошибка системы, возможно неверный адрес отправителя	   
111: EMPTY PHONELIST	Пустой список получателей, после автоматического удаления "плохих" номеров	   
112: SMS LIMIT	Попытка отправить много смс при низком балансе	   
113: IP RESTRICTION	Попытка доступа с чужого сервера (при включенном ограничении по IP). Свяжитесь со службой поддержки для включения данной опции.	   
114: CHECK ERROR	Ошибка проверки статуса	   
115: SENDER	Ошибка значения отправителя (from): должен быть номер (6..14 цифр), или название 3-11 символов(A-Za-z0-9.-)	   
116: DEPRICATED SENDER	Запрещенное значение отправителя (from)	   
117: ACCOUNT RESTRICTION	Ограничение тест-аккаунта, возможно больше 2-х номеров в пакете	 
*/
	
?>