<?php

$_auth = 90;
require_once('module/auth.php');


$currs = $db->fetchIDRows($db->select('Currs','*', '', array(), 'cID'), false, 'cID');

foreach ($currs as $cid => $c)
	if ($c['cCID'] == 'YM')
	{
		$el = $c;
		opDecodeCurrParams($el, $el['P'], $el['PSCI'], $el['PAPI']);
		break;
	}

if (!$el)
	ShowInfo('*Error', moduleToLink('balance/admin/currs'));

$uri = FullURL(moduleToLink());
if (!$el['PAPI']['id'] or !$el['PAPI']['secretpass'] or $el['PAPI']['apipass'])
	ShowInfo('*Error', moduleToLink('balance/admin/curr') . '?id=' . $el['cID']);

require_once("lib/yandexmoney/api.php");

if (!$code = _GET('code'))
{
	$scope = array("account-info operation-history operation-details payment-p2p");
	GoToURL(YandexMoney\API::buildObtainTokenUrl($el['PAPI']['id'], $uri, $scope));
}

$access_token_response = YandexMoney\API::getAccessToken($el['PAPI']['id'], $code, $uri, $el['PAPI']['secretpass']);
xaddtolog($access_token_response, 'YD');

$el['PAPI']['apipass'] = $access_token_response->access_token;
$key = $el['cID'] . $el['cCID'] . stampToTime($el['cMTS']);
if ($db->update('Currs', array('cParamsAPI' => encodeArrayToStr($el['PAPI'], $key, 3)), '', 'cID=?d', array($el['cID'])))
	showInfo('Saved', moduleToLink('balance/admin/curr') . '?id=' . $el['cID']);

?>
