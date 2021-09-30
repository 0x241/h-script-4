<?php

require_once('module/auth.php');

// http://loginza.ru/api/authinfo?token=[TOKEN_KEY_VALUE]&id=[WIDGET_ID]&sig=[API_SIGNATURE]
try 
{

	if (_uid() and _GET('sub'))
	{
		$v = base64_decode(_GET('sub')) . "\n";
		$db->update('AddInfo', array('aOIDs' => str_replace($v, '', $_user['aOIDs'])), '', 'auID=?d', array(_uid()));
		showInfo('Completed', moduleToLink());
	}
	
	if (_IN('token'))
	{
		if ($data = file_get_contents('http://loginza.ru/api/authinfo?token=' . _IN('token')))
			if ($data = json_decode($data))
			{
//				$v = md5($data->identity) . '=' . $data->provider . "\n";
				$v = $data->identity . "\n";
				$uid = $db->fetch1($db->select('AddInfo', 'auID', "INSTR(CONCAT(?, aOIDs), ?)>0", array("\n", "\n" . $v)));
				if (_uid()) // attach account
				{
					$url = moduleToLink();
					if (!$uid)
					{
						$db->query('UPDATE AddInfo SET `aOIDs`=CONCAT(aOIDs,?) WHERE auID=?d', array($v, _uid()));
						showInfo('Added', $url);
					}
					else
						showInfo('*AlreadyUsed', $url);
				} 
				else // login or register
				{
					if ($url = _SESSION('_go_after_login'))
						unset($_SESSION['_go_after_login']);
					if ($uid)
					{
						useLib('account/login');
						opLogin($uid, $url);
					}
					else // register
					{
						useLib('account/register');
						$l = getDomain($data->provider) . '-' . exValue(uniqid(), $data->uid);
						$pass = '';
						for ($i = 1; $i <= 8; $i++)
							$pass .= rand($i == 1, 9);
						$uid = opRegisterPrepare(
							array(
								'aName' => firstNotEmpty(
									array(
										$data->name->full_name, 
										trim($data->name->first_name . ' ' . $data->name->last_name),
										$data->nickname
									)
								),
								'uLogin' => $l,
								'uMail' => firstNotEmpty(
									array(
										$data->email, 
										$l . '@' . $_GS['domain']
									)
								),
								'uPass' => $pass,
								'Pass2' => $pass,
								'uRef' => _SESSION('_ref'),
								'Agree' => 1
							));
						if ($uid > 1)
						{
							$login = "User$uid";
							while ($db->count('Users', 'uLogin=?', array($login)))
								$login .= '!';
							$db->update('Users', array('uLogin' => $login, 'uLang' => $data->language), '', 'uID=?d', array($uid));
							$db->update('AddInfo', array('aOIDs' => $v, 'aTel' => $data->preferred), '', 'auID=?d', array($uid));
							opRegisterComplete($uid, $pass, $url);
							showInfo('Completed', moduleToLink('account/register') . '?done');
						}
					}
				}
			}
		showInfo('*Error');
	}
	
}
catch (Exception $e)
{
}

if (!_uid())
	goToURL(moduleToLink('account/login'));
	
$logins = array();
$a = explode("\n", $db->fetch1($db->select('AddInfo', 'aOIDs', 'auID=?d', array(_uid()))));
foreach ($a as $l)
	if ($l)
		$logins[] = array('url' => $l);
/*if (preg_match_all("|(.*)=(.*)\n|", $a . "\n", $a, PREG_SET_ORDER))
	foreach ($a as $l)
		if ($l[1])
			$logins[$l[1]] = $l[2];*/
setPage('logins', $logins);
setPage('loginza_url', urlencode(fullURL(moduleToLink('account/loginza'))));
$_GS['vmodule'] = 'account';

showPage();

/*
identity 	Уникальный идентификатор авторизовавшегося пользователя. Значение представлено в виде URL. Это значение должно использоваться аналогично логину, как в привычной авторизации.
provider 	Обозначение провайдера, через который прошла авторизация.
uid 	Идентификатор пользователя, используемый на стороне провайдера.
nickname 	Ник пользователи или его логин.
email 	Адрес электронной почты. Данные о email у некоторых провайдеров могут быть не проверены на владение, поэтому рекомендуем делать такую проверку самостоятельно.
gender 	Пол пользователя. Возможные значения: M, F. Соответственно, мужской и женский.
photo 	URL-адрес на файл аватарки. Ширина и высота изображения, для различных провайдеров, могут отличаться.
name 	Массив содержащий данные ФИО из профиля.
full_name 	Имя и фамилия пользователя.
first_name 	Имя
last_name 	Фамилия
middle_name 	Отчество
dob 	Дата рождения. Формат: ГГГГ-ММ-ДД. Значения года, дня или месяца могут быть не указаны в профиле пользователя. Неуказанная пользователем часть даты рождения будет заполнена нулями (например: 0000-12-31).
work 	Массив данных о месте работы и должности.
company 	Название компании.
job 	Профессия или должность.
address 	Массив данных о домашнем адресе и адрес места работы:
home 	Массив с данными о домашнем адресе (доступны данные: country, postal_code, state, city, street_address).
business 	Массив с данными о рабочем адресе (доступны данные: country, postal_code, state, city, street_address).
phone 	Массив содержащий данные об указанных в профиле телефонах. Подробнее в таблице Структура данных поля phone.
preferred 	Номер телефона указанный по умолчанию.
home 	Домашний телефон.
work 	Рабочий телефон.
mobile 	Мобильный телефон.
fax 	Факс.
im 	Массив с аккаунтами для связи.
icq 	Номер ICQ аккаунта.
jabber 	Jabber аккаунт.
skype 	Skype аккаунт.
web 	Массив содержащий адреса сайтов пользователя.
default 	Адрес профиля или персональной страницы.
blog 	Адрес блога
language 	Язык.
timezone 	Временная зона.
biography 	Другая информация о пользователе и его интересах.
*/

?>