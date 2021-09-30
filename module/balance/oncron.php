<?php

require_once('lib/psys.php');
useLib('balance');


if (stampToTime($_cfg['Bal_LastUpdate']) + HS2_UNIX_HOUR > time())
	return;

require_once('lib/inet.php');
foreach (array('BTC', 'ETH', 'XRP', 'LTC') as $curr)
if ($_cfg["Bal_Update{$curr}Rate"])
	if ($x = inet_request('https://api.cryptonator.com/api/ticker/' . strtolower($curr) . '-usd'))
		if (($a = json_decode($x, 1)) and $a['success'])
		{
			$v = $a['ticker']['price'];
			if ($v > 0)
				opWriteCfg('Bal', "Rate{$curr}", $v);
		}

$currlist = array('USD', 'EUR'); // !!! add new valutes here

if ($_cfg['Bal_UpdateRates'])
	if ($x = file_get_contents('http://www.cbr.ru/scripts/XML_daily.asp'))
/*
<Valute ID="R01235">
	<NumCode>840</NumCode>
	<CharCode>USD</CharCode>
	<Nominal>1</Nominal>
	<Name>Доллар США</Name>
	<Value>30,7823</Value>
</Valute>
<Valute ID="R01239">
	<NumCode>978</NumCode>
	<CharCode>EUR</CharCode>
	<Nominal>1</Nominal>
	<Name>Евро</Name>
	<Value>40,2140</Value>
</Valute>
*/
		if (preg_match_all('$<CharCode>(' . implode('|', $currlist) . ')<.+<Value>(.+)<$isU', $x, $r, PREG_SET_ORDER))
		{
			$c = array();
			foreach ($r as $v)
				$c[$v[1]] = 0 + str_replace(',', '.', $v[2]);
			try 
			{
				foreach ($currlist as $v)
					if ($c[$v] < 1)
						xAbort('course_wrong');
				switch ($_currs[1]['cCurrID'])
				{
				case 'EUR':
					$c = array(
						'USD' => round($c['USD'] / $c['EUR'], 4),
						'EUR' => 1,
						'RUB' => round(1 / $c['EUR'], 4)
					);
					break;
				case 'RUB':
					$c = array(
						'USD' => $c['USD'],
						'EUR' => $c['EUR'],
						'RUB' => 1
					);
					break;
				default:
					$c = array(
						'USD' => 1,
						'EUR' => round($c['EUR'] / $c['USD'], 4),
						'RUB' => round(1 / $c['USD'], 4)
					);
				}
				foreach ($c as $f => $v)
					opWriteCfg('Bal', 'Rate' . $f, $v);
				opWriteCfg('Bal', 'LastUpdate', timeToStamp());
			} 
			catch (Exception $e) 
			{
			}
		}
	
?>