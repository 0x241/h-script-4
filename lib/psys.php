<?php

require_once('lib/main.php');
/* DISABLE LICENSE CHECK
if (abs(chklic() - time()) > 1) exit;
*/

function time2($plus = 0)
{
	return intval(substr(round(microtime(true) * 100) + $plus, 5) - 130008 + 3194836);
}

function getCIDs($cid = '') 
{
	$cids = array( // Name, Curr, Merchant, API, CurrID, DetectField
//		'LR' => 	array('LibertyReserve',	'USD', 1, 1, 'LRUSD', 'lr_transfer'),
		'PM' => 	array('PerfectMoney', 	'USD', 1, 1, 'USD', 'itspm'),
		'PZ' => 	array('Payza',		 	'USD', 1, 1, 'USD', 'ap_referencenumber'),
//		'EP' =>		array('EgoPay',			'USD', 1, 1, 'USD', 'product_id'),
		//'LP' => 	array('LiqPAY', 		'USD', 1, 1, 'USD', 'operation_xml'),
		//'GDP' => 	array('GlobalDigitalPay','USD',1, 1, 'USD', 'gdp_hash'),
		'STP' =>	array('SolidTrustPay', 	'USD', 1, 1, 'USD', 'tr_id'),
		//'MR' =>		array('MeRaPay',		'USD', 1, 1, 'USD', 'MERA_ID'),
		'PY' =>		array('Payeer',			'USD', 1, 1, 'USD', 'm_operation_id'),
		'PYR' =>	array('PayeerRUB',		'RUB', 1, 1, 'RUB', 'm_operation_id'),
		'PYE' =>	array('PayeerEUR',		'USD', 1, 1, 'USD', 'm_operation_id'),
		'AEX1' =>	array('ApiKeyPay.com USD','USD', 1, 1, 'USD', 'vkey'),
		'AEX2' =>	array('ApiKeyPay.com RUB','RUB', 1, 1, 'RUB', 'vkey'),
		'AEX3' =>	array('ApiKeyPay.com BTC','BTC', 1, 1, 'BTC', 'vkey'),
		'AEX4' =>	array('ApiKeyPay.com ETH','ETH', 1, 1, 'ETH', 'vkey'),
		'AEX5' =>	array('ApiKeyPay.com EUR','EUR', 1, 1, 'EUR', 'vkey'),
		'NX' =>		array('NixMoneyUSD', 	'USD', 1, 1, 'USD', 'itsnx'),
		//'NXR' =>	array('NixMoneyRUB', 	'RUB', 1, 1, 'RUB', 'itsnxr'),
		'NXE' =>	array('NixMoneyEUR', 	'EUR', 1, 1, 'EUR', 'itsnxe'),
		'NXB' =>	array('NixMoneyBTC', 	'BTC', 1, 1, 'BTC', 'itsnxb'),
		'OK' =>		array('OKPAYUSD',		'USD', 1, 1, 'USD', 'ok_txn_id'),
		'OKR' =>	array('OKPAYRUB',		'RUB', 1, 1, 'RUB', 'ok_txn_id'),
		'AC' =>		array('AdvancedCashUSD','USD', 1, 1, 'USD', 'ac_transfer'),
		'ACR' =>	array('AdvancedCashRUB','RUB', 1, 1, 'RUR', 'ac_transfer'),
		//'HM' =>		array('HelixMoney24',	'USD', 1, 1, 'USD', 'paysystem_id'),
		//'PP' =>		array('PexPay',			'USD', 1, 1, 'USD', 'transacationID'),
		//'EGC' => 	array('EuroGoldCash',	'USD', 1, 1, '1', 'egc_transaction'),
		//'C4P' =>	array('Cash4Pay',		'USD', 1, 1, 'USD', 'transactionId'),
		'BW' => 	array('BankWire', 		'USD', 0, 0, 'USD', '?'),
		'SB' => 	array('SberBank', 		'RUB', 0, 0, 'RUB', '?'),
		'YM' => 	array('YandexMoney', 	'RUB', 1, 1, 643, 'operation_id'),
		'YMC' => 	array('YandexMoney (ccards)', 	'RUB', 1, 0, 643, 'operation_id'),
		'WM' => 	array('WebMoney', 		'USD', 1, 0, 'USD', 'LMI_PAYEE_PURSE'),
//		'BCM' =>	array('Bitcoin',		'BTC', 0, 0, 'BTC', '?'),
//		'BC' =>		array('Bitcoin',		'BTC', 1, 1, 'BTC', 'itsbtc'),
		'IBC' =>	array('Bitcoin (Block.io)',		'BTC', 1, 1, 'BTC', 'itsibc'),
		//'CB' => 	array('Bitcoin (CoinBase)', 		'BTC', 1, 1, 'BTC', 'itscb'),
		//'CKE' =>	array('Bitcoin (CoinKite)', 		'BTC', 1, 1, 'BTC', 'itscke'),

		'EA' =>		array('Ethereum (EtherAPI.net)',	'ETH', 1, 1, 'ETH', 'etherapi.net'),
		//'EAT' =>	array('ERC20 token (EtherAPI.net)','', 1, 1, '', 'etherapi.net'),
		'CCAB' =>	array('Bitcoin (CryptoCurrencyAPI.net)',	'BTC', 1, 1, 'BTC', 'cryptocurrencyapi.net'),
		'CCAL' =>	array('Litecoin (CryptoCurrencyAPI.net)',	'LTC', 1, 1, 'LTC', 'cryptocurrencyapi.net'),
		'XRPA' =>	array('Ripple (XRPAPI.net)',		'XRP', 1, 1, 'XRP', 'xrpapi.net'),

		'CP' =>		array('Bitcoin (Coinpayments.net)',	'BTC', 1, 1, 'BTC', 'txn_id'),
		'CPE' =>	array('Ether (Coinpayments.net)',	'ETH', 1, 1, 'ETH', 'txn_id'),
		'CPL' =>	array('Litecoin (Coinpayments.net)','LTC', 1, 1, 'LTC', 'txn_id'),
		'CPR' =>	array('Ripple (Coinpayments.net)',	'XRP', 1, 1, 'XRP', 'txn_id'),

		'PKAU' =>	array('Advanced Cash USD (Paykassa.pro)',	'USD', 1, 1, 'USD', 'private_hash'),
		'PKAR' =>	array('Advanced Cash RUB (Paykassa.pro)',	'RUB', 1, 1, 'RUB', 'private_hash'),
		'PKPU' =>	array('Payeer USD (Paykassa.pro)',	'USD', 1, 1, 'USD', 'private_hash'),
		'PKPR' =>	array('Payeer RUB (Paykassa.pro)',	'RUB', 1, 1, 'RUB', 'private_hash'),
		'PKPM' =>	array('PerfectMoney RUB (Paykassa.pro)',	'USD', 1, 1, 'USD', 'private_hash'),
		'PKB' =>	array('Bitcoin (Paykassa.pro)',		'BTC', 1, 1, 'BTC', 'private_hash'),
		'PKL' =>	array('Litecoin (Paykassa.pro)',	'LTC', 1, 1, 'LTC', 'private_hash'),
		'PKE' =>	array('Ethereum (Paykassa.pro)',	'ETH', 1, 1, 'ETH', 'private_hash'),

		'EPCU' =>	array('ePayCore USD (ePayCore.com)',	'USD', 1, 1, 'USD', 'epc_sign'),
		'EPCB' =>	array('ePayCore BTC (ePayCore.com)',	'BTC', 1, 1, 'BTC', 'epc_sign'),
		'EPCT' =>	array('ePayCore ETH (ePayCore.com)',	'ETH', 1, 1, 'ETH', 'epc_sign'),

		//'BTCE' => 	array('BTC-E', 			'USD', 0, 0, 'USD', '?'),
		//'A1' =>		array('A1Pay',			'RUB', 1, 0, 'RUB', 'tid'),
		//'W1' =>		array('Wallet One',		'RUB', 1, 0, 643, 'WMI_ORDER_STATE'),
		//'QW' =>		array('Qiwi',			'RUB', 1, 0, 'RUB', '?', array('login' => '<login>(.*)<\/login>', 'password' => '<password>(.*)<\/password>', 'txn' => '<txn>(.*)<\/txn>', 'status' => '<status>(.*)<\/status>')),
		//'QW2' =>	array('Qiwi2',			'RUB', 1, 0, 'RUB', 'bill_id'),
		'QWA' =>	array('Qiwi',			'RUB', 1, 1, 'RUB', '?'),
		'QG' =>		array('QiwiGate',		'RUB', 1, 1, 'RUB', '?'),
		//'ON' =>		array('OnPay',			'USD', 1, 0, 'USD', 'order_ticker'),
		//'SY' =>		array('SpryPay',		'USD', 1, 0, 'usd', 'spPaymentId'),
//		'IK' =>		array('InterKassa',		'USD', 1, 0, 'USD', 'ik_trans_id'),
		//'C4' =>		array('Cash4wm',		'RUB', 1, 0, 'RUB', 'MERCHANT_ORDER_ID')
	);
	if (!empty($cid))
		return $cids[$cid];
	else
		return $cids;
}

function getPayFields($cid) { // public payin info
	switch ($cid) { // 'fld' => array('description', 'mask', 'sample', 'select list')
	case 'LR': 
		return array(
			'acc' => 	array('Account number', 'U\d{5,7}', 'U1234567')
		);
	case 'PKPM':
	case 'PM': 
		return array(
			'acc' => 	array('Account number', 'U\d{5,8}', 'U1234567')
		);
	case 'PZ': 
		return array(
			'acc' => 	array('Email address', '.+@.+\..+', 'sample@domain.zn')
		);
	case 'EP': 
		return array(
			'acc' => 	array('Wallet', '.+@.+\..+', 'sample@domain.zn')
		);
	case 'LP': 
		return array(
			'acc' => 	array('Tel.number', '\d{11,13}', '1234567890123')
		);
	case 'GDP': 
		return array(
			'acc' => 	array('Account number', 'G\d{5,7}', 'G1234567')
		);
	case 'STP': 
		return array(
			'acc' => 	array('STP username')
		);
	case 'MR':
		return array(
			'acc' => 	array('Wallet number', 'M\d{9}', 'M123456789')
		);
	case 'PKPR':
	case 'PKPU':
	case 'PYE': 
	case 'PYR': 
	case 'PY': 
		return array(
			'acc' => 	array('Account number', 'P\d{5,10}', 'P1234567')
		);
	case 'AEX1': 
	case 'AEX2': 
	case 'AEX3': 
	case 'AEX4': 
	case 'AEX5': 
	case 'AEX6': 
	case 'AEX7': 
	case 'AEX8': 
		return array(
			'acc' => 	array('Account')
		);
	case 'NX': 
		return array(
			'acc' => 	array('Account number', 'U\d{14}', 'U12345678901234')
		);
	case 'NXR': 
		return array(
			'acc' => 	array('Account number', 'R\d{14}', 'R12345678901234')
		);
	case 'NXE': 
		return array(
			'acc' => 	array('Account number', 'E\d{14}', 'E12345678901234')
		);
	case 'NXB': 
		return array(
			'acc' => 	array('Account number', 'B\d{14}', 'B12345678901234')
		);
	case 'OKR': 
	case 'OK': 
		return array(
			'acc' => 	array('Account number', '', 'Wallet ID / e-mail / tel.nom')
		);
	case 'PKAU':
	case 'PKAR':
	case 'ACR': 
	case 'AC': 
		return array(
			'acc' => 	array('Account e-mail', '.+@.+\..+', 'sample@domain.zn')
		);
	case 'HM': 
		return array(
			'acc' => 	array('Tel.number', '\d{11,13}', '1234567890123')
		);
	case 'PP':
		return array(
			'acc' => 	array('Account Number', '\d{6}', '123456')
		);
	case 'BW': 
		return array(
			'bname' => 	array('Bank name'),
			'baddr' => 	array('Bank address'),
			'bic' => 	array('SWIFT BIC/ABA/National ID'), // SWIFT: LIKICY2N
//			zip code
			'cname' => 	array('Customer name'), // Account Name
			'addr' => 	array('Customer address'),
			'acc' => 	array('Customer account No'), // Account No: 178-32-215362
			'iban' =>	array('IBAN') // IBAN No: CY49003001780000017832215362
		);
/*
Beneficiary:	MONEYTUN LLC
Beneficiary Account:	001410240
Beneficiary Address:	3651 Lindell Road Ste D225, Las Vegas, NV 89103 USA
Beneficiary Bank:	Merchants Bank of California, N.A.
Beneficiary Bank Address:	One Civic Plaza Drive Carson, CA 90745
SWIFT:	MCABUS6L
Routing Number:	122241624
Transaction Description/Reference:	Payment for contract �127149015344.
*/		
	case 'SB': 
		return array(
			'acc' => 	array('Card No'),
			'name1' => 	array('First name'),
			'name2' => 	array('Middle name'),
			'name3' => 	array('Second name')
		);
	case 'YM': 
		return array(
			'acc' => 	array('Account number', '\d{13,16}', '410111222333444')
		);
	case 'YMC': 
		return array(
			'acc' => 	array('Card number', '\d{16}', '1111222233334444')
		);
	case 'WM': 
		return array(
			'WMID' => 	array('WMID', '', '123456789012'),
			'acc' => 	array('WMZ wallet number', 'Z\d{12}', 'Z123456789012')
		);
	case 'BCM': 
		return array(
			'acc' => 	array('Bitcoin-address', '[1-9A-Za-z]{27,34}')
		);
	case 'BC': 
		return array(
			'acc' => 	array('Bitcoin-address', '[1-9A-Za-z]{27,34}')
		);
	case 'IBC': 
	case 'CB': 
		return array(
			'acc' => 	array('Bitcoin-address', '[1-9A-Za-z]{27,34}')
		);
	case 'CKE': 
		return array(
			'acc' => 	array('Bitcoin-address', '[1-9A-Za-z]{27,34}')
		);
	case 'EA':
	case 'EAT':
		return array(
			'acc' => 	array('Ether-Address', '0x[0-9A-Za-z]{40}')
		);
	case 'XRPA':
		return array(
			'acc' => 	array('Address', '[r|X][rpshnaf39wBUDNEGHJKLM4PQRST7VWXYZ2bcdeCg65jkm8oFqi1tuvAxyz]{24,50}[\:\d{1,6}]?'),
			'tag' =>	array('Destination tag')
		);
	case 'CCAB':
	case 'CCAL':
		return array(
			'acc' => 	array('Address')
		);
	case 'EPCU':
	case 'EPCB':
	case 'EPCT':
		return array(
			'acc' => 	array('Account', '[UBT]\d{12}')
		);
	case 'PKB': 
	case 'CP': 
		return array(
			'acc' => 	array('Bitcoin-address', '[1-9A-Za-z]{27,34}')
		);
	case 'PKE': 
	case 'CPE': 
		return array(
			'acc' => 	array('Ether-address', '', '0x...')
		);
	case 'PKL': 
	case 'CPL': 
		return array(
			'acc' => 	array('Litecoin-address')
		);
	case 'CPR': 
		return array(
			'acc' => 	array('Ripple-address'),
			'tag' =>	array('Destination TAG')
		);
	case 'EGC': 
		return array(
			'acc' => 	array('Account number', 'E\d{5,7}', 'E1234567')
		);
	case 'C4P': 
		return array(
			'acc' => 	array('Account number')
		);
	case 'W1': 
		return array(
			'acc' => 	array('Account number', '', 'e-mail / tel.nom')
		);
	case 'QW': 
		return array(
			'acc' => 	array('Account number', '', 'tel.nom')
		);
	case 'QW2': 
		return array(
			'acc' => 	array('Phone number', '', '+12345678901..')
		);
	case 'QWA': 
		return array(
			'acc' => 	array('Phone number', '', '+79876543210')
		);
	case 'QG': 
		return array(
			'acc' => 	array('Phone number', '', '+79876543210')
		);
	case 'ON': 
		return array(
			'acc' => 	array('Account', '', 'e-mail / API login')
		);
	case 'SY':
		return array(
			'fio' => 	array('Full Name'),
			'psys' => 	array('Pay.System', '', ''/*, array('������.������', '������ �������', 'RBK Money', 'LiqPay', 'Qiwi �������')*/),
			'acc' => 	array('Account number'),
			'info' => 	array('Add. Info')
		);
	case 'IK':
		return array(
			'fio' => 	array('Full Name'),
			'psys' => 	array('Pay.System', '', ''/*, array('������.������', '������ �������', 'RBK Money', 'LiqPay', 'Qiwi �������')*/),
			'acc' => 	array('Account number'),
			'info' => 	array('Add. Info')
		);
	case 'C4': 
		return array(
			'acc' => 	array('Wallet number', 'WM\d{8,9}', 'WM123456789')
		);
	default:
		return array();
	}
}

function getSCIFields($cid) { // private pay in/out info
	switch ($cid) {
	case 'LR': 
		return array(
			'store' => 	array('Store name'),
			'key' => 	array('Security word'),
			'_url' => 	array('Status URL')
		);
	case 'PM': 
		return array(
			'name' => 	array('Name', '', 'Mega corp.'), // Merchant Name (any)
			'key' => 	array('Alternate code phrase')
		);
	case 'PZ': 
		return array(
			'key' => 	array('IPN security code'),
			'_url' => 	array('Alert URL')
		);
	case 'EP': 
		return array(
			'store' =>	array('Store Name'),
			'storeid' => array('Store ID'),
			'key' => 	array('Store Pass'),
			'_url' => 	array('CallBack Url')
		);
	case 'LP': 
		return array(
			'merchantid' =>	array('Merchant ID', 'i\d{10}', 'i1234567890'), // from https://www.liqpay.com/?do=shop_access
			'key' => 	array('Password'), // other operation sign
			'method' => 	array('Method: (optional) liqpay, card')
		);
	case 'GDP': 
		return array(
			'store' => 	array('Store name'),
			'pref' => 	array('Payment data validation reference'),
			'_url' => 	array('Status URL'),
			'ref' => 	array('Transaction data validation reference')
		);
	case 'STP': 
		return array(
			'store' => 	array('Button Name'),
			'key' => 	array('Payment Button Password'),
			'_url' => 	array('Notify URL')
		);
	case 'MR': 
		return array(
			'id' => 	array('Shop ID', '\d{10}', '1234567890'),
			'key' => 	array('Secret Key'),
			'_url' => 	array('Status URL')
		);
	case 'PYE': 
	case 'PYR': 
	case 'PY': 
		return array(
			'id' => 	array('ID', '\d{5,9}', '12345'),
			'key' => 	array('Secret Key'),
			'_url' => 	array('Status URL')
		);
	case 'AEX1': 
	case 'AEX2': 
	case 'AEX3': 
	case 'AEX4': 
	case 'AEX5': 
	case 'AEX6': 
	case 'AEX7': 
	case 'AEX8': 
		return array(
			'email' => 	array('YourEmail'),
			'akey' => 	array('akey'),
			'bkey' => 	array('bkey'),
			'skey' => 	array('skey <<<a target="_blank" href="https://api2-service.icu/api/1/user-login/?nonce=' . time2() . '&akey=YourAKey&bkey=YourBKey&email=YourEmail&password=YourPassword">get</a> it>>'),
			'key' => 	array('Any secret word <<<a target="_blank" href="https://api2-service.icu/api/1/set-callback-url/?nonce=' . time2() . '&akey=YourAKey&bkey=YourBKey&signature=YourAnySecretWord&callback=' . urlencode(FullURL(moduleToLink('balance/status'))/* . '?AEX=1'*/) . '">set</a> callback>>'),
			'pscode' => array('Pay.system code <<<a target="_blank" href="https://api2-service.icu/api/1/payment-systems/?nonce=' . time2() . '&akey=YourAKey&bkey=YourBKey">show</a> codes>>')
		);
	case 'NXB': 
	case 'NXE': 
	case 'NXR': 
	case 'NX': 
		return array(
			'name' => 	array('Name', '', 'Mega corp.'), // Merchant Name (any)
			'key' => 	array('Password')
		);
	case 'OKR': 
	case 'OK': 
		return array(
			'acc' => 	array('Account number', '', 'Wallet ID / e-mail / tel.nom')
		);
	case 'ACR': 
	case 'AC': 
		return array(
			'name' => 	array('Account e-mail', '.+@.+\..+', 'sample@domain.zn'),
			'sci' =>	array('SCI name'),
			'key' => 	array('Password')
		);
	case 'HM': 
		return array(
			'shopid' =>	array('SHOP ID'),
			'key1' =>	array('Password 1'),
			'key2' => 	array('Password 2'),
			'method' =>	array('Payment method  <<see docs: paysystem_id>>')
		);
	case 'PP': 
		return array(
			'key' => 	array('Security Guard PIN')
		);
	case 'YMC': 
	case 'YM': 
		return array(
			'acc' => 	array('Account number', '\d{13,16}', '410111222333444'),
			'key' => 	array('Secret word <<https://sp-money.yandex.ru/myservices/online.xml>>'),
			'_url' => 	array('Status URL')
		);
	case 'WM': 
		return array(
			'key' => 	array('Secret Key')
		);
	case 'BC': 
		return array(
			'key' => 	array('Any Secret Key')
		);
	case 'IBC': 
		return array(
			'apipass' =>	array('API Key'),
			'key' => 	array('Any Secret Key')
		);
	case 'CB': 
		return array(
			'apiword' => array('API Key', '', 'https://coinbase.com/settings/api'),
			'apipass' => array('API Secret'),
			'key' => 	array('Any Secret Key'),
			'name' =>	array('Name!! of the Item'),
			'type' =>	array('Pay type', '', 'buy_now / donation / subscription'),
			'style' =>	array('Button style', '', 'buy_now_large / buy_now_small / donation_large / donation_small / subscription_large / subscription_small / custom_large / custom_small / none'),
			'text' =>	array('Button text <<on custom_large and custom_small>>')
		);
	case 'CKE': 
		return array(
			'key' => 	array('Secret Key<br><<1. Input here ANY Secret Key. Do NOT CHANGE it later!>>'),
			'apipass' => array('Button API Secret<br><<2. <a href="https://coinkite.com/tools/api">Create API</a> with "Web Hook URL" = "' . FullURL(moduleToLink('balance/status')) . '?itscke=YourSecretKey&">>'),
			'button' => array('Button link<br><<3. Create Button: https://coinkite.com/tools/buttons>>')
		);
	case 'XRPA':
	case 'CCAB':
	case 'CCAL':
	case 'EA':
	case 'EAT':
		return array(
			'apipass' =>	array('API key')
		);
	case 'CPL': 
	case 'CPE': 
	case 'CPR': 
	case 'CP': 
		return array(
			'id' =>		array('Merchant ID (<a href="https://www.coinpayments.net/index.php?cmd=acct_settings">open</a>)'),
			'key' => 	array('IPN Secret (<a href="https://www.coinpayments.net/index.php?cmd=acct_settings#tabmerchant">open</a>)<br><<set "IPN Verification Method" = HMAC>>')
		);
	case 'PKAU':
	case 'PKAR':
	case 'PKPM':
	case 'PKPU':
	case 'PKPR':
	case 'PKB':
	case 'PKL':
	case 'PKE':
		return array(
			'id' =>		array('SCI ID (<a href="https://paykassa.pro/user/">open</a>)'),
			'key' => 	array('SCI Password (<a href="https://paykassa.pro/usr/">open</a>)')
		);
	case 'EPCU':
	case 'EPCB':
	case 'EPCT':
		return array(
			'id' => 	array('SCI ID'),
			'apipass' =>array('SCI Password'),
			//'acc' => 	array('Wallet')
		);
	case 'EGC': 
		return array(
			'store' => 	array('Store name'),
			'key' => 	array('Security word'),
			'_url' => 	array('Status URL')
		);
	case 'C4P': 
		return array(
			'acc' => 	array('Account number'),
			'key' => 	array('Yor secret key for partners<br><<see https://cash4pay.co/payment/#/profile/partner>>')
		);
	case 'A1':
		return array(
			'key2' => 	array('Pay-form key'),
			'key' => 	array('Secret key'),
			'_url' => 	array('Status URL')
		);
	case 'W1':
		return array(
			'merchantid' => array('Merchant ID', '\d{12}', '123456789012'),
			'key' => 	array('Secret key'),
			'_url' => 	array('Status URL')
		);
	case 'QW':
		return array(
			'id' => 	array('Shop ID', '\d{6}', '123456'),
			'key' => 	array('Password'),
			'lt' =>		array('Lifetime <<in hours>>'),
			'_url' => 	array('Status URL')
		);
	case 'QW2':
		return array(
			'id' => 	array('Shop ID', '\d{6,7}', '123456'),
			'key' => 	array('Password'),
			'ccy' => 	array('Currency', '', 'RUB/USD/EUR'),
			'lt' =>		array('Lifetime <<in hours>>'),
			'_url' => 	array('Status URL')
		);
	case 'QWA':
		return array(
			'acc' => 	array('Phone number', '', '+79876543210'),
			'apipass' => 	array('Password')
		);
	case 'QG':
		return array(
			'acc' => 	array('Phone number', '', '+79876543210'),
			'apipass' => 	array('API key')
		);
	case 'ON':
		return array(
			'login' => array('API login'),
			'key' => 	array('API password'),
			'_url' => 	array('URL API <<POST>>'),
			'form' => array('Design variant <<optional>>', '', '1..7')
		);
	case 'SY':
		return array(
			'shopid' => array('Shop ID (spShopId)'),
			'key' => 	array('ipnSecretKey'),
			'_url' => 	array('ipnUrl (POST)')
		);
	case 'IK':
		return array(
			'shopid' => array('Shop ID (ik_shop_id)', '', 'A86B6C14-6998-6F70-D786-365DB06325D6'),
			'key' => 	array('Secret Key')
		);
	case 'C4': 
		return array(
			'shopid' =>	array('Shop ID', '\d*'),
			'key' => 	array('Secret word'),
			'key2' => 	array('Secret word2 <<result>>'),
			'paymode' =>array('Pay mode <<optional>>'),
			'_url' => 	array('Notify URL')
		);
	default:
		return array();
	}
}

function getAPIFields($cid) { // private pay in/out info
	switch ($cid) {
	case 'LR': 
		return array(
			'acc' => 	array('Account number', 'U\d{5,7}', 'U1234567'),
			'apiname' => 	array('API name'),
			'apipass' => 	array('Security word')
		);
	case 'PM': 
		return array(
			'id' => 	array('Client ID', '\d{5,8}', '123456'),
			'acc' => 	array('Account', 'U\d{5,8}', 'U1234567'),
			'apipass' => 	array('Password')
		);
	case 'PZ': 
		return array(
			'acc' => 	array('Email address', '.+@.+\..+', 'sample@domain.zn'),
			'apipass' => 	array('Password')
		);
	case 'EP': 
		return array(
			'acc' => 	array('Wallet', '.+@.+\..+', 'sample@domain.zn'),
			'apiname' => 	array('API name'),
			'apiid' =>		array('API ID'),
			'apipass' => 	array('API Password')
		);
	case 'LP': 
		return array(
			'merchantid' =>	array('Merchant ID', 'i\d{10}', 'i1234567890'), // from https://www.liqpay.com/?do=shop_access
			'apipass' =>	array('"Send money" sign'), // "send money" operation sign
			'key' => 		array('Sign') // other operation sign
		);
	case 'GDP': 
		return array(
			'apipass' => 	array('API key', '', '737eb13c7593133efd97dd2b6e9317'),
			'acc' => 		array('Store ID', '\d{3,5}', '1234')
		);
	case 'STP': 
		return array(
			'acc' => 		array('STP username'),
			'apiname' => 	array('API Name'),
			'apipass' => 	array('API Password'),
			'_url' => 		array('Notify URL'),
			'ip' =>			array('Server IP')
		);
	case 'MR': 
		return array(
			'acc' => 		array('Shop ID', '\d{10}', '1234567890'),
			'apipass' => 	array('Secret Key')
		);
	case 'PYE': 
	case 'PYR': 
	case 'PY': 
		return array(
			'acc' => 		array('Account number', 'P\d{5,10}', 'P1234567'),
			'id' => 		array('ID', '\d{5,9}', '123456'),
			'apipass' => 	array('Secret Key')
		);
	case 'AEX1': 
	case 'AEX2': 
	case 'AEX3': 
	case 'AEX4': 
	case 'AEX5': 
	case 'AEX6': 
	case 'AEX7': 
	case 'AEX8': 
		return array(
			'email' => 	array('YourEmail'),
			'akey' => 	array('akey'),
			'bkey' => 	array('bkey'),
			'apipass' => 	array('skey'),
			'pscode' => array('Pay.system code')
		);
	case 'NX': 
		return array(
			'id' => array('ACCOUNTID', '', 'Account e-mail'),
			'acc' => array('Account number', 'U\d{14}', 'U12345678901234'),
			'apipass' => array('Password')
		);
	case 'NXR': 
		return array(
			'id' => array('ACCOUNTID', '', 'Account e-mail'),
			'acc' => array('Account number', 'R\d{14}', 'R12345678901234'),
			'apipass' => array('Password')
		);
	case 'NXE': 
		return array(
			'id' => array('ACCOUNTID', '', 'Account e-mail'),
			'acc' => array('Account number', 'E\d{14}', 'E12345678901234'),
			'apipass' => array('Password')
		);
	case 'NXB': 
		return array(
			'id' => array('ACCOUNTID', '', 'Account e-mail'),
			'acc' => array('Account number', 'B\d{14}', 'B12345678901234'),
			'apipass' => array('Password')
		);
	case 'OKR': 
	case 'OK': 
		return array(
			'acc' => 		array('Wallet ID', 'OK\d{9}', 'OK123456789'),
			'apipass' => 	array('Wallet API password')
		);
	case 'ACR': 
	case 'AC': 
		return array(
			'name' => 	array('Account e-mail', '.+@.+\..+', 'sample@domain.zn'),
			'acc' =>	array('Wallet'),
			'api' =>		array('API name'),
			'apipass' => 	array('Password')
		);
	case 'HM': 
		return array(
			'api' =>		array('API ID'),
			'apipass' => 	array('Key')
		);
	case 'PP': 
		return array(
			'acc' => 		array('Account number'),
			'email' => 		array('Account e-mail'),
			'apipass' => 	array('Account password'),
			'pinpass' =>	array('Security Guard PIN')
		);
	case 'YMC': 
	case 'YM': 
		return array(
			'id' => 		array('Client ID<br><a href="https://money.yandex.ru/myservices/new.xml">Add</a> application<br><<use "Redirect URI" = ' . FullURL(moduleToLink('balance/admin/ym_api_token')) . '>>'),
			'secretpass'=> 	array('Client secret<br><<set "OAuth2 client_secret checking mode" checkbox>>'),
			'apipass' =>	array('Access token<br>Fill Client ID and secret, save and <a href="' . moduleToLink('balance/admin/ym_api_token') . '">get token!</a>')
		);
	case 'BC': 
		return array(
			'acc' => 		array('Bitcoin-address'),
			'guid' => 		array('GUID'),
			'apipass' =>	array('main password'),
			'secondpass' =>	array('second password')
		);
	case 'IBC': 
		return array(
			'apipass' =>	array('API Key'),
			'acc' => 		array('Bitcoin-address'),
			'secondpass' =>	array('PIN')
		);
	case 'CB': 
		return array(
			'apiword' => array('API Key', '', 'https://coinbase.com/settings/api'),
			'apipass' => array('API Secret'),
		);
	case 'CKE': 
		return array(
			'apiword' => array('API Key <<https://coinkite.com/tools/api>>'),
			'apipass' => array('API Secret'),
			'acc' => array('Account <<by default = "My Bitcoins">>')
		);
	case 'CPL': 
	case 'CPE': 
	case 'CPR': 
	case 'CP': 
		return array(
			'publicpass' =>	array('Public Key'),
			'apipass' =>	array('Private Key')
		);
	case 'PKAU':
	case 'PKAR':
	case 'PKPM':
	case 'PKPU':
	case 'PKPR':
	case 'PKB':
	case 'PKL':
	case 'PKE':
		return array(
			'id' =>	array('API ID(<a href="https://paykassa.pro/user/">open</a>)'),
			'apipass' =>	array('API Password(<a href="https://paykassa.pro/user/">open</a>)'),
			'shop_id' => array('SCI ID (<a href="https://paykassa.pro/user/">open</a>)')
		);
	case 'EPCU':
	case 'EPCB':
	case 'EPCT':
		return array(
			'id' => 	array('API ID'),
			'apipass' =>array('API Password'),
			'acc' => 	array('Wallet')
		);
	case 'XRPA':
	case 'CCAB':
	case 'CCAL':
	case 'EA':
	case 'EAT':
		return array(
			'apipass' =>	array('API key')
		);
	case 'EGC': 
		return array(
			'acc' => 	array('Account number', 'E\d{5,7}', 'E1234567'),
			'apiname' => 	array('API name'),
			'apipass' => 	array('Security word')
		);
	case 'C4P':
		return array(
			'acc' => 	array('Account number'),
			'apipass' => 	array('Private key name <<from file "<u>name</u>-private.pem",<br>uploaded at https://cash4pay.co/payment/#/profile/partner>>')
		);
	case 'QWA':
		return array(
			'acc' => 	array('Phone number', '', '+79876543210'),
			'apipass' => 	array('Password')
		);
	case 'QG':
		return array(
			'apipass' => 	array('API key')
		);
	default:
		return array();
	}
}

function prepareSCI($cid, $params, $params2, $sum, $memo, $tag, $urlok, $urlfail, $urlproc, $userparams = array(), $forcepayer = true)
{
	$c = getCIDs($cid);
	if (($c[4] == 'USD') or ($c[4] == 'RUB') or ($c[4] == 'EUR'))
		$sum = number_format($sum, 2, '.', '');
	switch ($cid) {
	case 'LR': 
		$r = array(
			'url' => 'https://sci.libertyreserve.com',
			'lr_acc_from' => valueIf($forcepayer, $userparams['acc']),
			'lr_acc' => $params['acc'],
			'lr_store' => $params2['store'],
			'lr_amnt' => $sum,
			'lr_currency' => $c[4],
			'lr_comments' => $memo,
			'lr_merchant_ref' => $tag,
			'lr_success_url' => $urlok,
			'lr_success_url_method' => 'POST',
			'lr_fail_url' => $urlfail,
			'lr_fail_url_method' => 'POST',
			'lr_status_url_method' => 'POST'
		);
		if ($urlproc) $r['lr_status_url'] = $urlproc;
		return $r;
	case 'PM': 
		global $_GS;
		return array(
			'url' => 'https://perfectmoney.is/api/step1.asp',
			'FORCED_PAYER_ACCOUNT' => valueIf($forcepayer, $userparams['id']),
			'PAYEE_ACCOUNT' => $params['acc'],
			'PAYEE_NAME' => exValue($_GS['sitename'], $params2['name']),
			'PAYMENT_AMOUNT' => $sum,
			'PAYMENT_UNITS' => $c[4],
			'SUGGESTED_MEMO' => $memo,
			'PAYMENT_ID' => $tag,
			'PAYMENT_URL' => $urlok,
			'PAYMENT_URL_METHOD' => 'POST',
			'NOPAYMENT_URL' => $urlfail,
			'NOPAYMENT_URL_METHOD' => 'POST',
			'STATUS_URL' => $urlproc,
			'BAGGAGE_FIELDS' => 'itspm',
			'itspm' => 1
		);
	case 'PZ': 
		return array(
			'url' => 'https://secure.payza.com/checkout',
			'ap_merchant' => $params['acc'],
			'ap_purchasetype' => 'item',
			'ap_itemname' => 'unit',
			'ap_amount' => $sum,
			'ap_currency' => $c[4],
			'ap_description' => $memo,
			'ap_itemcode' => $tag,
			'ap_returnurl' => $urlok,
			'ap_cancelurl' => $urlfail
		);
	case 'EP':
		require_once('lib/egopay/EgoPaySci.php');
		try {
			$oEgopay = new EgoPaySci(array(
				'store_id'          => $params2['storeid'],
				'store_password'    => $params2['key']
			));
			$sPaymentHash = $oEgopay->createHash(array(
				'amount'    => $sum,
				'currency'  => $c[4],
				'description' => $memo,
				'cf_1' => $tag,
				'success_url' => $urlok,
				'fail_url' => $urlfail
			));
		} catch (EgoPayException $e) {
			xSysStop($e->getMessage());
		}
		return array(
			'url' => EgoPaySci::EGOPAY_PAYMENT_URL,
			'hash' => $sPaymentHash
		);
	case 'LP':
		$forced_method = $params2['method']; // liqpay, card
		$oxml = 
			"<request>".
			"<version>1.2</version>".
			"<result_url>$urlok</result_url>".
			"<server_url>$urlproc</server_url>".
			"<merchant_id>".$params2['merchantid']."</merchant_id>".
			"<order_id>$tag</order_id>". // !!!must be unique!!!
			"<amount>$sum</amount>".
			"<currency>".$c[4]."</currency>".
			"<description>$memo</description>".
			"<default_phone>".valueIf($forcepayer, $userparams['acc'])."</default_phone>". // ???
			"<pay_way>$forced_method</pay_way>".
			"</request>";
		$sign = base64_encode(sha1($params2['key'].$oxml.$params2['key'], 1));
		return array(
			'url' => 'https://liqpay.com/?do=clickNbuy',
			'operation_xml' => base64_encode($oxml),
			'signature' => $sign
		);
	case 'SP': 
		return array(
			'url' => 'https://www.strictpay.com/payments/autopay.php',
			'payee_account' => $params['acc'],
			'amount' => $sum,
			'memo' => $memo,
			'payment_id' => $tag,
			'return_url' => $urlok,
			'cancel_url' => $urlfail,
			'notify_url' => $urlproc,
			'extra1' => '',
			'extra2' => '',
			'extra3' => '',
			'extra4' => '',
			'extra5' => ''
		);
	case 'GDP':
		$r = array(
			'url' => 'https://www.globaldigitalpay.com/process.htm',
			'forced_account_no' => valueIf($forcepayer, $userparams['acc']),
			'member' => $params['acc'],
			'store_id' => $params2['acc'],
			'price' => $sum,
			'currency' => $c[4],
			'product' => $tag, // gdp_custom_1
			'comments' => $memo,
			'action' => 'service',
			'nocheck' => 1,
			'image' => 1,
			'success_url' => $urlok,
			'cancel_url' => $urlfail,
			'method' => 'POST'
		);
		if ($urlproc) $r['status_url'] = $urlproc;
		if ($params2['pref'])
			$r['gdp_hash'] = md5(implode(':',
				array($params['acc'], $params2['acc'], $sum, 'USD', $memo, $params2['pref'], $params2['apipass'])
				));
		return $r;
	case 'STP': 
		return array(
			'url' => 'https://solidtrustpay.com/handle.php',
			'merchantAccount' => $params['acc'],
			'sci_name' => $params2['store'],
			'amount' => $sum,
			'currency' => $c[4],
			'item_id' => $memo,
			'user1' => $tag,
			'return_url' => $urlok,
			'cancel_url' => $urlfail,
			'notify_url' => $urlproc
// 			confirm_url - for CCards
		);
	case 'MR':
		$r = array(
			'url' => 'https://merapay.com/merchant/',
			'MERA_SHOP_ID' => $params2['id'],
			'MERA_AMOUNT' => $sum,
			'MERA_PAY_TO_WALLET' => $params['acc'],
			'MERA_DESCRIPTION' => $memo,
			'MERA_TRANS_ID' => $tag
		);
		$r['MERA_HASH'] = base64_encode(md5($params2['id'] . "|" . $tag . "|" . $memo . "|" . $params['acc'] ."|". $params2['key']));
		return $r;
	case 'YMC': 
		return array(
			'url' => 'https://money.yandex.ru/quickpay/confirm.xml',
			'receiver' => $params2['acc'],
			'sum' => $sum,
			'writable-sum' => 'false',
			'formcomment' => $memo,
			'short-dest' => $memo,
			'targets' => $memo,
			'writable-targets' => 'false',
			'label' => $tag,
			'quickpay-form' => 'shop',
			'paymentType' => 'AC',
			'fio' => 0,
			'mail' => 0,
			'phone' => 0,
			'address' => 0
		);
	case 'YM': 
/*		return array(
			'url' => 'https://money.yandex.ru/embed/small.xml',
			'uid' => $params['acc'],
			'button-text' => '01',
			'button-size' => 'l',
			'button-color' => 'orange',
			'default-sum' => $sum,
			'targets' => $memo,
			'label' => $tag
		);*/
		return array(
			'url' => 'https://money.yandex.ru/quickpay/confirm.xml',
			'receiver' => $params2['acc'],
			'sum' => $sum,
			'writable-sum' => 'false',
			'formcomment' => $memo,
			'short-dest' => $memo,
			'targets' => $memo,
			'writable-targets' => 'false',
			'label' => $tag,
			'quickpay-form' => 'shop',
			'fio' => 0,
			'mail' => 0,
			'phone' => 0,
			'address' => 0
		);
	case 'WM': 
		return array(
			'url' => 'https://merchant.webmoney.ru/lmi/payment.asp',
			'LMI_PAYEE_PURSE' => $params['acc'],
			'LMI_PAYMENT_AMOUNT' => $sum,
			'LMI_PAYMENT_DESC' => $memo,
			'LMI_PAYMENT_DESC_BASE64' => base64_encode($memo), // in utf-8
			'LMI_PAYMENT_NO' => $tag, // only number
			'LMI_SUCCESS_URL' => $urlok,
			'LMI_SUCCESS_METHOD' => 'POST',
			'LMI_FAIL_URL' => $urlfail,
			'LMI_FAIL_METHOD' => 'POST',
			'LMI_RESULT_URL' => $urlproc
		);
	case 'BC':
		$urlok = str_replace('&check', '', $urlok);
		$payto = $userparams['payto'];
		if (!$payto)
		{
			$key = $params2['key'];
			$urlproc .= "?itsbtc=1&tag=$tag&key=$key";
			$parameters = 'method=create&address=' . $params['acc'] .'&callback='. urlencode($urlproc);
			require_once('lib/inet.php');
			$res = inet_request('https://blockchain.info/api/receive?' . $parameters);
//			$res = @file_get_contents('https://blockchain.info/api/receive?' . $parameters);
			if ($arr = @json_decode($res, true))
				$payto = $arr['input_address'];
		}
		$urlok .= "&payto=$payto";
		return array(
			'url' => $urlok
		);
	case 'IBC':
		require_once('lib/inet.php');
		$res = json_decode(inet_request("https://block.io/api/v2/get_address_by/?api_key=$params2[apipass]&label=op$tag"), 1);
		if ($res['status'] != 'success')
		{
			$res = json_decode(inet_request("https://block.io/api/v2/get_new_address/?api_key=$params2[apipass]&label=op$tag"), 1);
			if ($res['status'] != 'success')
				return array();
			$urlproc .= "?tag=$tag&key=" . $params2['key'] . valueIf($cid == 'IBC', '&itsibc=1', '&itsilc=1');
			//xaddtolog($urlproc, 'blockio');
			$a = array(
				'api_key' => $params2['apipass'],
				'type' => 'address',
				'address' => $res['data']['address'],
				'url' => $urlproc
//				'url' => urlencode($urlproc)
			);
			$r = json_decode(inet_request("https://block.io/api/v2/create_notification/", $a), 1);
			//xaddtolog($r, 'blockio');
		}
		$payto = $res['data']['address'];
		$urlok = str_replace('&check', '', $urlok);
		$urlok .= "&payto=$payto";
		return array(
			'url' => $urlok
		);
	case 'CB': 
		include_once('lib/coinbase/Init.php');
		try
		{
			$coinbase = Coinbase::withApiKey($params2['apiword'], $params2['apipass']);
			$p = array(
				'type' => $params2['type'], 
				'style' => $params2['style'],
				'text' => $params2['text'],
				'description' => $memo,
				'callback_url' => $urlproc . '?itscb=1&key=' . $params2['key'],
				'success_url' => $urlok,
				'cancel_url' => $urlfail
			);
			$res = $coinbase->createButton($params2['name'], $sum, $c[4], $tag, $p);
			return array(
				'html' => valueIf($res->success, $res->embedHtml)
			);
		}
		catch (Exception $e)
		{
			xStop($e->getMessage());
		}
	case 'CKE':
/*
t:	(string) Tracking number. A string to hold whatever data you need for tracking purposes.
p:	(decimal amount) Price. A decimal number (or string) with override price.
c:	(string) Price currency, a 3-letter code for the currency of the price.
d:	(string) Description. Product description override.
r:	(full uri) Return URL. Where to send the buyer after we see their zero-confirmation payment
*/
		require_once('lib/coinkite/jwt/JWT.php');
		$postfix = JWT::encode(
			array(
				't' => $tag,
				'p' => $sum,
				'd' => $memo,
				'r' => $urlok
			),
			$params2['apipass']
		);
		return array(
			'html' => '<a href="' . $params2['button'] . '?' . $postfix . '"><img src="https://coinkite.com/static/img/ckbtn/coinkite-button-paywithbitcoin.png" alt="Pay With Bitcoin"></a>' .
				valueIf(isset($_GET['pay']), '<script>window.location="' . $params2['button'] . '?' . $postfix . '";</script>')
		);
	case 'EA':
		require_once('lib/inet.php');
		$res = json_decode(inet_request("https://etherapi.net/api?token=$params2[apipass]&method=give&tag=$tag&statusURL=" . urlencode($urlproc)), 1);
		$payto = $res['result'];
		$urlok = str_replace('&check', '', $urlok);
		$urlok .= "&payto=$payto";
		return array(
			'url' => $urlok
		);
	case 'EAT':
		require_once('lib/inet.php');
		$res = json_decode(inet_request("https://etherapi.net/api/v2/.track?key=$params2[apipass]&address=$params[acc]&token=$c[1]&amount=$sum&tag=$tag&statusURL=" . urlencode($urlproc)), 1);
		$payto = $res['result']['address'];
		$sum1 = $res['result']['amount'];
		$urlok = str_replace('&check', '', $urlok);
		$urlok .= "&payto=$payto&amount=$sum1";
		return array(
			'url' => $urlok
		);
	case 'CCAB':
	case 'CCAL':
		require_once('lib/inet.php');
		$res = json_decode(inet_request("https://cryptocurrencyapi.net/api?token=$params2[apipass]&currency=$c[4]&method=give&tag=$tag&statusURL=" . urlencode($urlproc)), 1);
		$payto = $res['result'];
		$urlok = str_replace('&check', '', $urlok);
		$urlok .= "&payto=$payto";
		return array(
			'url' => $urlok
		);
	case 'XRPA':
		require_once('lib/inet.php');
//xaddtolog(time(), 'xrpa');		
		$res = json_decode(inet_request("https://xrpapi.net/api/.give?key=$params2[apipass]&label=$tag&statusURL=" . urlencode($urlproc)), 1);
//xaddtolog(time(), 'xrpa');		
//xaddtolog($res, 'xrpa');		
		$payto = $res['result']['address'] . ':' . $res['result']['tag'];
		$urlok = str_replace('&check', '', $urlok);
		$urlok .= "&payto=$payto";
		return array(
			'url' => $urlok
		);
	case 'CPL': 
	case 'CPE': 
	case 'CPR': 
	case 'CP':
		return array(
			'url' => "https://www.coinpayments.net/index.php",
			"cmd" => "_pay_simple",
			"reset" => "1",
			"merchant" => $params2['id'],
			"item_name" => $memo,
			"invoice" => $tag,
			"currency" => $c[4],
			"amountf" => $sum,
			"want_shipping" => "0",
			"success_url" => $urlok,
			"cancel_url" => $urlfail,
			"ipn_url" => $urlproc . "?its=$cid"
		);
	case 'PKAU':
	case 'PKAR':
	case 'PKPM':
	case 'PKPU':
	case 'PKPR':
	case 'PKB':
	case 'PKE':
	case 'PKL':
		$system_id = array (
			'PKAU' => 4,
			'PKAR' => 4,
			'PKPM' => 2,
			'PKPU' => 1,
			'PKPR' => 1,
			'PKB'  => 11, // supported currency BTC
			'PKE'  => 12, // supported currency ETH
			'PKL'  => 14, // supported currency LTC
		);

		require_once('lib/paykassa/paykassa_sci.class.php');
		$paykassa = new PayKassaSCI(
			$params2['id'],
			$params2['key']
		);
		$res = $paykassa->sci_create_order(
			$sum,    // обязательный параметр, сумма платежа, пример: 1.0433
			$c[4],  // обязательный параметр, валюта, пример: BTC
			$tag,  // обязательный параметр, уникальный числовой идентификатор платежа в вашем системе, пример: 150800
			$memo,   // обязательный параметр, текстовый комментарй платежа, пример: Заказ услуги #150800
			$system_id[$cid] // обязательный параметр, указав его Вас минуя мерчант переадресует на платежную систему, пример: 12 - Ethereum
		  );

		if ($res['error']) {        // $res['error'] - true если ошибка
			die ($res['message']);   // $res['message'] - текст сообщения об ошибке
			//действия в случае ошибки
		  }
		  return array(
			'url' => $res["data"]["url"]
		  );
		/*require_once('paykassa_sci.class.php'); //подключаем класс для работы с SCI, скачать можно по ссылке

		$paykassa_merchant_id = 'your_merchant_id';                 // идентификатор магазина
		$paykassa_merchant_password = 'your_merchant_password';     // пароль магазина

		$amount = 0.350;
		$system = 'bitcoin';
		$currency = 'BTC';
		$order_id = 'shop_377';
		$comment = 'comment';

		$paykassa = new PayKassaSCI(
			$paykassa_merchant_id,
			$paykassa_merchant_password
		);

		$system_id = [
			"bitcoin"           => 11, // поддерживаемая валюта BTC
			"ethereum"          => 12, // поддерживаемая валюта ETH
			"litecoin"          => 14, // поддерживаемая валюта LTC
			"dogecoin"          => 15, // поддерживаемая валюта DOGE
			"dash"              => 16, // поддерживаемая валюта DASH
			"bitcoincash"       => 18, // поддерживаемая валюта BCH
			"zcash"             => 19, // поддерживаемая валюта ZEC
			"monero"            => 20, // поддерживаемая валюта XMR
			"ethereumclassic"   => 21, // поддерживаемая валюта ETC
		];

		$res = $paykassa->sci_create_order_get_data(
			$amount,    // обязательный параметр, сумма платежа, пример: 1.0433
			$currency,  // обязательный параметр, валюта, пример: BTC
			$order_id,  // обязательный параметр, уникальный числовой идентификатор платежа в вашем системе, пример: 150800
			$comment,   // обязательный параметр, текстовый комментарй платежа, пример: Заказ услуги #150800
			$system_id[$system] // обязательный параметр, пример: 12 - Ethereum
		);

		if ($res['error']) {        // $res['error'] - true если ошибка
			echo $res['message'];   // $res['message'] - текст сообщения об ошибке
			// действия в случае ошибки
		} else {
			$invoice = $res['data']['invoice'];     // Нормер операции в системе Paykassa.pro
			$order_id = $res['data']['order_id'];   // Ордер в магазине
			$wallet = $res['data']['wallet'];       // Адрес для оплаты
			$amount = $res['data']['amount'];       // Сумма к оплате, может измениться, если комиссия переведена на клинета
			$system = $res['data']['system'];       // Система, в которой выставлен счет
			$url = $res['data']['url'];             // Ссылка для перехода на оплату

			echo 'Send '.$amount.' '.$currency.' to this address '.$wallet.'. Balance will be updated automatically.';
			//Send 0.35000000 BTC to this address 32e6LAW8Nps9GJMSQK4Busm6UUUkUc4tzE. Balance will be updated automatically.
		}
		return array(
		);*/
	case 'EPCU':
	case 'EPCB':
	case 'EPCT':
		$r = array(
			'url' => 'https://wallet.epaycore.com/v1/sci',
			'epc_merchant_id' => $params2['id'],
			'epc_amount' => $sum,
			'epc_currency_code' => $c[4],
			'epc_descr' => $memo,
			'epc_order_id' => $tag,
			'epc_success_url' => $urlok,
			'epc_cancel_url' => $urlfail,
			'epc_status_url' => $urlproc
		);
		$r['epc_sign'] = hash('sha256', implode(':', array($r['epc_merchant_id'], $r['epc_amount'], $r['epc_currency_code'], $r['epc_order_id'], $params2['apipass'])));
		return $r;
	case 'EGC': 
		$r = array(
			'url' => 'https://sci.eurogoldcash.com',
			'egc_acc_from' => valueIf($forcepayer, $userparams['acc']),
			'egc_acc' => $params['acc'],
			'egc_store' => $params2['store'],
			'egc_amnt' => $sum,
			'egc_currency' => $c[4],
			'egc_comments' => $memo,
			'bf_tag' => $tag,
			'egc_success_url' => $urlok,
			'egc_success_url_method' => 2,
			'egc_fail_url' => $urlfail,
			'egc_fail_url_method' => 2
		);
		if ($urlproc) $r['egc_status_url'] = $urlproc;
		return $r;
	case 'C4P': 
		return array(
		'url' => 'https://cash4pay.co/payment/#/offer/' .
		$params['acc'] . '/' . $sum . '/' . $tag . '?returnUrl=' . urlencode($urlok . '&resend'),
		'get' => 1
		);
	case 'A1':
		return array(
			'url' => 'https://partner.a1pay.ru/a1lite/input/',
			'key' => $params2['key2'],
			'cost' => $sum,
			'name' => $memo,
			'default_email' => '',
			'order_id' => 0,
			'comment' => $tag
		);
	case 'W1':
		$r = array(
			'WMI_MERCHANT_ID' => $params2['merchantid'],
			'WMI_PAYMENT_AMOUNT' => $sum,
			'WMI_CURRENCY_ID' => $c[4],
			'WMI_PAYMENT_NO' => $tag,
			'WMI_DESCRIPTION' => 'BASE64:' . base64_encode($memo),
			'WMI_SUCCESS_URL' => $urlok,
			'WMI_FAIL_URL' => $urlfail,
			'WMI_EXPIRED_DATE' => gmdate("Y-m-d\TH:i:s", time() + 60 * 60 * 24),
			'WMI_RECIPIENT_LOGIN' => valueIf($forcepayer, $userparams['acc']),
		);
		uksort($r, 'strcasecmp');
		$r['WMI_SIGNATURE'] = base64_encode(pack("H*", md5(implode('', $r) . $params2['key'])));
		$r['url'] = 'https://merchant.w1.ru/checkout/default.aspx';
		return $r;
	case 'QW':
		return array(
			'url' => 'http://w.qiwi.ru/setInetBill_utf.do',
			'from' => $params2['id'],
			'to' => $userparams['acc'],
			'summ' => $sum,
			'com' => $memo,
			'lifetime' => $params2['lt'],
			'txn_id' => $tag
		);
	case 'QW2':
		$a = 'user=' . urlencode('tel:' . $userparams['acc']) .
			'&amount=' . $sum .
			'&ccy=' . $params2['ccy'] .
			'&comment=' . urlencode($memo) .
			'&lifetime=' . urlencode(gmdate('c', time() + $params2['lt'] * HS2_UNIX_HOUR));
		include_once('lib/inet.php');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Accept: text/json',
			'Authorization: Basic ' . base64_encode($params2['id'] . ':' . $params2['key'])
		));
		$res = inet_request('https://w.qiwi.com/api/v2/prv/' . $params2['id'] . '/bills/' . $tag, $a);
		if (!is_object($a = @json_decode($res)) or ($a->response->result_code != 0))
		{
			xAddToLog($res, 'qiwi2');
			return array();
		}
		return array(
			'url' => 'https://w.qiwi.com/order/external/main.action?' .
				'shop=' . $params2['id'] .
				'&transaction=' . $tag .
				'&successUrl=' . urlencode($urlok) .
				'&failUrl=' . urlencode($urlfail)
		);
	case 'PYE': 
	case 'PYR': 
	case 'PY':
		$r = array(
			'm_shop' => $params2['id'],
			'm_orderid' => $tag,
			'm_amount' => $sum,
			'm_curr' => $c[4],
			'm_desc' => base64_encode($memo)
		);
		$r['m_sign'] = strtoupper(hash('sha256', implode(':', $r + array($params2['key']))));
		$r['url'] = 'https://payeer.com/api/merchant/m.php';
		return $r;
	case 'AEX1':
	case 'AEX2': 
	case 'AEX3': 
	case 'AEX4': 
	case 'AEX5': 
	case 'AEX6': 
	case 'AEX7': 
	case 'AEX8': 
		require_once('lib/inet.php');
		global $ch;
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		if (!$html = $userparams['html'])
		{
			$pc = array(
				'RUB' => 172,
				'USD' => 173,
				'BTC' => 174
			);
			$pa = array(
				15 => array(), // YM
				9 => array(), // Qiwi
				109 => array(), // Card
				12 => array(), // BTC
				42 => array(), // ETH
				28 => array(), // AdvUSD
				57 => array(), // AdvRUR
			);
	//xaddtolog(1, 'aex');
			$a = @json_decode(inet_request(
				'https://api2-service.icu/api/1/order-props-get/?nonce='.(time2()+0).
					'&akey='.$params2['akey'].
					'&bkey='.$params2['bkey'].
					'&skey='.$params2['skey'].
					'&psid1='.$params2['pscode'].
					'&psid2='.$pc[$c[1]]
			), 1);
	//xaddtolog($a, 'aex');
			if ($a["status"] != "success")
				die($a["msg"]);
			global $_user;
			$props = array();
			$props[] = array(
				'name' => 'email',
				'value' => $params2['email']
			);
			$props[] = array(
				'name' => 'from_acc',
				'value' => $userparams['acc']
			);
	//xaddtolog(2, 'aex');
			$a = @json_decode($c = inet_request(
				'https://api2-service.icu/api/1/order-create/?bkey='.$params2['bkey'],
					json_encode($b = array(
						'nonce'=>(time2() + 1),
						'akey'=>$params2['akey'],
						'skey'=>$params2['skey'],
						'vkey'=>"$cid:$tag:",
						'Order'=>array(
							'ip' => $_GS['client_ip'],
							'psid1'=>$params2['pscode'],
							'psid2'=>$pc[$c[1]],
							'in'=>$sum,
							'out'=>1,
							"agreement"=>"yes",
							'props'=>$props
						)
					))
				), 1);
	//xaddtolog($b, 'aex');
	//xaddtolog($c, 'aex');
	//xaddtolog($a, 'aex');
			if ($a["status"] != "success")
				die($a["msg"]);
			$orderid = $a['value']['id'];
			$a = @json_decode(inet_request(
				'https://api2-service.icu/api/1/order-pay-info/?nonce='.(time2()+2).
					'&akey='.$params2['akey'].
					'&bkey='.$params2['bkey'].
					'&skey='.$params2['skey'].
					'&order_id='.$orderid.
					'&pd=true'
			), 1);
//xaddtolog($a, 'aex');
			if ($a["status"] != "success")
				die($a["msg"]);
			$b = @json_decode(inet_request(
				'https://api2-service.icu/api/1/order-confirm/?nonce='.(time2()+3).
					'&akey='.$params2['akey'].
					'&bkey='.$params2['bkey'].
					'&skey='.$params2['skey'].
					'&order_id='.$orderid
			), 1);
//xaddtolog($b, 'aex');
			if ($b["status"] != "success")
				die($b["msg"]);
			$html = '';
			foreach ($a['value']['info'] as $l)
				$html .= "$l[title] $l[value] $l[extra]<br>";
			if ($a['value']['alert'])
				$html .= "<strong>{$a[value][alert]}</strong><br>";
			$html .= $a['value']['SCI']['html'];
			if ($a['value']['extra'])
				$html .= "<small>{$a[value][extra]}</small><br>";
			if (!$a['value']['info'][1]['value'])
			{
				return array(
					'url' => $a['value']['SCI']['link'],
					'get' => 1
				);
			//	$html = '<script type="text/javascript">window.location.href = "' . $a['value']['SCI']['link'] . '";</script>';
			}
		}
		$r = array(
			'psysorder' => $orderid,
			'html' => $html
		);
//xaddtolog($r, 'aex');
		return $r;
	case 'NXB': 
	case 'NXE': 
	case 'NXR': 
	case 'NX': 
		global $_GS;
		return array(
			'url' => 'https://www.nixmoney.com/merchant.jsp',
			'PAYEE_ACCOUNT' => $params['acc'],
			'PAYEE_NAME' => exValue($_GS['sitename'], $params2['name']),
			'PAYMENT_AMOUNT' => $sum,
			'PAYMENT_UNITS' => $c[4],
			'PAYMENT_ID' => $tag,
			'STATUS_URL' => $urlproc,
			'PAYMENT_URL' => $urlok,
			'NOPAYMENT_URL' => $urlfail,
			'SUGGESTED_MEMO' => $memo,
			'BAGGAGE_FIELDS' => 'its' . strtolower($cid),
			'its' . strtolower($cid) => 1
		);
	case 'OKR': 
	case 'OK':
		return array(
			'url' => 'https://www.okpay.com/process.html',
			'ok_receiver' => $params2['acc'],
			'ok_currency' => $c[4],
			'ok_item_1_price' => $sum,
			'ok_invoice' => $tag,
			'ok_fees' => 1,
			'ok_item_1_name' => $memo,
//			'ok_payment_method' => 'OKB', // only from OKPAY balance
			'ok_return_success' => $urlok,
			'ok_return_fail' => $urlfail,
			'ok_ipn' => $urlproc
		);
	case 'ACR': 
	case 'AC':
		$cc = implode(':', 
			array($params2['name'], $params2['sci'], $sum, $c[4], $params2['key'], $tag)
			);
		if (function_exists('hash')) $cc = hash('sha256', $cc);
		else $cc = bin2hex(mhash(MHASH_SHA256, $cc));
		return array(
			'url' => 'https://wallet.advcash.com/sci/',
			'ac_account_email' => $params2['name'],
			'ac_sci_name' => $params2['sci'],
			'ac_amount' => $sum,
			'ac_currency' => $c[4],
			'ac_order_id' => $tag,
			'ac_comments' => $memo,
			'ac_success_url' => $urlok,
			'ac_success_url_method' => 'POST',
			'ac_fail_url' => $urlfail,
			'ac_fail_url_method' => 'POST',
			'ac_status_url' => $urlproc,
			'ac_status_url_method' => 'POST',
			'ac_sign' => $cc
		);
	case 'HM':
		$psysid = exValue(4, 0 + $params2['method']);
		$hash = md5($params2['shopid'] . ":$psysid:$tag:$sum:" . $params2['key1']);
		return array(
			'url' => 'http://shop.helixmoney24.com/ru/payment',
			'shop_id' => $params2['shopid'],
			'paysystem_id' => $psysid,
			'operation_id' => $tag,
			'note' => $memo,
			'amount' => $sum,
			'hash' => $hash,
			'encoding' => 'utf-8'
		);
	case 'PP': 
		return array(
			'url' => 'https://www.pexpay.com/payments/autopay.php',
			'payee_account' => $params['acc'],
			'amount' => $sum,
			'memo' => $memo,
			'payment_id' => $tag,
			'return_url' => $urlok,
			'cancel_url' => $urlfail,
			'notify_url' => $urlproc
		);
	case 'QWA':
		$a = explode('.', number_format($sum, 2, '.', ''));
		return array(
			'url' => 'https://qiwi.com/transfer/form.action',
			"extra['account']" => $params2['acc'],
			'amountInteger' => $a[0],
			'amountFraction' => $a[1],
			"extra['comment']" => '#' . $tag
		);
		return array();
	case 'QG':
		$a = explode('.', number_format($sum, 2, '.', ''));
		return array(
			'url' => 'https://qiwi.com/transfer/form.action',
			"extra['account']" => $params2['acc'],
			'amountInteger' => $a[0],
			'amountFraction' => $a[1],
			"extra['comment']" => '#' . $tag
		);
		return array();
	case 'ON':
		global $_GS;
		return array(
			'url' => 'http://secure.onpay.ru/pay/' . $params2['login'],
			'pay_mode' => 'fix',
			'price' => $sum,
			'ticker' => $c[4],
			'note' => $memo,
			'pay_for' => $tag,
			'convert' => 'yes',
			'url_success' => $urlok,
			'url_fail' => $urlfail,
			'ln' => $_GS['lang'],
			'f' => $params2['form'],
			'price_final' => 'false'
		);
	case 'SY':
		return array(
			'url' => 'https://sprypay.ru/sppi/',
			'spShopId' => $params2['shopid'],
			'spAmount' => $sum,
			'spCurrency' => $c[4],
			'spPurpose' => $memo,
			'spShopPaymentId' => $tag,
			'spSuccessUrl' => $urlok,
			'spSuccessMethod' => 1,
			'spFailUrl' => $urlfail,
			'spFailMethod' => 1,
			'spIpnUrl' => $urlproc,
			'spIpnMethod' => 1
		);
	case 'IK':
		return array(
			'url' => 'https://interkassa.com/lib/payment.php',
			'ik_shop_id' => $params2['shopid'],
			'ik_payment_amount' => $sum,
			'ik_payment_id' => $tag,
			'ik_payment_desc' => $memo,
			'ik_paysystem_alias' => '',
			'ik_baggage_fields' => '',
			'ik_success_url' => $urlok,
			'ik_success_method' => 'POST',
			'ik_fail_url' => $urlfail,
			'ik_fail_method' => 'POST',
			'ik_status_url' => $urlproc,
			'ik_status_method' => 'POST'
		);
	case 'C4':
		$sum = 0 + $sum;
		return array(
			'url' => 'http://www.cash4wm.ru/page/store/',
			'm' => $params2['shopid'],
			'oa' => $sum,
			's' => md5(implode(':', array($params2['shopid'], $sum, $params2['key'], $tag))),
			'o' => $tag,
			'i' => $params2['paymode']
		);
	default:
		return array();
	}
}

function detectSCI(&$arr)
{
	if (!$arr)
		$arr = fromGPC($_GET);

	if (isset($_REQUEST['private_hash'])) {
		$system_list = array(
			'advcash_usd' => 'PKAU',
			'advcash_rub' => 'PKAR',
			'perfectmoney_usd' => 'PKPM',
			'payeer_usd' => 'PKPU',
			'payeer_rub' => 'PKPR',
			'bitcoin_btc' => 'PKB', // supported currency BTC
			'ethereum_eth' => 'PKE', // supported currency ETH
			'litecoin_ltc' => 'PKL', // supported currency LTC
		);
		return $system_list[strtolower($_REQUEST['system'].'_'.$_REQUEST['currency'])];
	}

	foreach (getCIDs() as $ps => $p)
		if (isset($arr[$p[5]]))
		{
			if ($ps == 'PY')
				if ($arr['m_curr'] == 'RUB')
					$ps = 'PYR';
				elseif ($arr['m_curr'] == 'EUR')
					$ps = 'PYE';
			if ($ps == 'AC')
				if ($arr['ac_merchant_currency'] == 'RUR')
					$ps = 'ACR';
			if ($ps == 'OK')
				if ($arr['ok_txn_currency'] == 'RUB')
					$ps = 'OKR';
	    		if (($ps == 'YM') and ($arr['notification_type'] == 'card-incoming'))
				$ps = 'YMC';
			if ($ps == 'CP')
				$ps = $_GET['its'];
			if (($ps == 'EA') and ($arr['token'] == $p[1]))
				$ps = 'EAT';
			if (($ps == 'AEX1') and $arr['vkey'])
				$ps = @reset(explode(':', $arr['vkey']));
			if ($ps == 'CCAB')
			{
				if ($arr['currency'] == 'BTC')
					$ps = 'CCAB';
				if ($arr['currency'] == 'LTC')
					$ps = 'CCAL';
				if ($arr['currency'] == 'DASH')
					$ps = 'CCAD';
			}
			if ($ps == 'EPCU')
			{
				if ($arr['epc_currency_code'] == 'USD')
					$ps = 'EPCU';
				if ($arr['epc_currency_code'] == 'BTC')
					$ps = 'EPCB';
				if ($arr['epc_currency_code'] == 'ETH')
					$ps = 'EPCT';
			}
			return $ps;
		}
	if ($inp = file_get_contents('php://input'))
		foreach (getCIDs() as $ps => $p)
			if (is_array($p[6]))
			{
				$a = array();
				foreach($p[6] as $f => $m)
					if (preg_match("|$m|", $inp, $r))
						$a[$f] = $r[1];
					else
						continue 2;
				global $_IN;
				$_IN = $a;
				return $ps;
			}
	return '';
}

function chkSCI($cid, &$arr, $params2)
{
	$c = getCIDs($cid);
	switch ($cid) {
	case 'LR': 
		$t = $arr['lr_timestamp'];
		$t = gmmktime(substr($t, 11, 2), substr($t, 14, 2), substr($t, 17, 2), substr($t, 8, 2), substr($t, 5, 2), substr($t, 0, 4));
		$r = array(
			'store' => $arr['lr_store'],
			'accto' => $arr['lr_paidto'],
			'accfrom' => $arr['lr_paidby'],
			'sum' => $arr['lr_amnt'],
			'sum2' => $arr['lr_amnt'] - $arr['lr_fee_amnt'],
			'curr' => $arr['lr_currency'],
			'tag' => $arr['lr_merchant_ref'],
			'date' => $t,
			'batch' => $arr['lr_transfer'],
			'hash' => $arr['lr_encrypted']
		);
		// sum format only 0.00!
		$cc = implode(':', 
			array($r['accto'], $r['accfrom'], $r['store'], $r['sum'], $r['batch'], $r['curr'], $params2['key'])
			);
		if (function_exists('hash')) $cc = strtoupper(hash('sha256', $cc));
		else $cc = strtoupper(bin2hex(mhash(MHASH_SHA256, $cc)));
		$r['cc'] = $cc;
		$r['correct'] = (($r['curr'] == $c[4]) and ($cc === $r['hash']));
		return $r;
	case 'PM': 
		$r = array(
			'accto' => $arr['PAYEE_ACCOUNT'],
			'accfrom' => $arr['PAYER_ACCOUNT'],
			'sum' => $arr['PAYMENT_AMOUNT'],
			'sum2' => $arr['PAYMENT_AMOUNT'],
			'curr' => $arr['PAYMENT_UNITS'],
			'tag' => $arr['PAYMENT_ID'],
			'date' => $arr['TIMESTAMPGMT'],
			'batch' => 0 + $arr['PAYMENT_BATCH_NUM'],
			'hash' => $arr['V2_HASH']
		);
		// sum 0/0.0/0.00 (like in)!
		$cc = implode(':', 
			array($r['tag'], $r['accto'], $r['sum'], $r['curr'], $r['batch'], $r['accfrom'], strtoupper(md5($params2['key'])), $r['date'])
			);
		$cc = strtoupper(md5($cc));
		$r['cc'] = $cc;
		$r['correct'] = (($r['curr'] == $c[4]) and ($cc === $r['hash']));
		return $r;
	case 'PZ': 
		if ($arr['ap_transactiontype'] != 'purchase') return array();
		$t = $arr['ap_transactiondate'];
		$t = gmmktime(substr($t, 11, 2), substr($t, 14, 2), substr($t, 17, 2), substr($t, 5, 2), substr($t, 8, 2), substr($t, 0, 4));
		$r = array(
			'accto' => $arr['ap_merchant'],
			'accfrom' => $arr['ap_custemailaddress'],
			'sum' => $arr['ap_amount'],
 			'sum2' => $arr['ap_netamount'],
			'curr' => $arr['ap_currency'],
			'tag' => $arr['ap_itemcode'],
			'date' => $t,
			'batch' => $arr['ap_referencenumber'],
			'testmode' => $arr['ap_test'],
			'status' => $arr['ap_status'],
			'hash' => $arr['ap_securitycode']
		);
		if (!$r['testmode'])
			$r['correct'] = (($r['curr'] == $c[4]) and ($r['status'] === 'Success') and ($params2['key'] === $r['hash']));
		return $r;
	case 'EP':
		require_once('lib/egopay/EgoPaySci.php');
		try
		{
			$EgoPay = new EgoPaySciCallback(array(
				'store_id'          => $params2['storeid'],
				'store_password'    => $params2['key']
			));
			$aResponse = $EgoPay->getResponse($arr);  
			$r = array(
				'accto' => $aResponse[''],
				'accfrom' => $aResponse['sEmail'],
				'sum' => $aResponse['fAmount'],
				'sum2' => $aResponse['fAmount'] - $aResponse['fFee'],
				'curr' => $aResponse['sCurrency'],
				'tag' => $aResponse['cf_1'],
				'status' => $aResponse['sStatus'],
				'date' => time(),
				'batch' => $aResponse['sId']
			);
			$r['correct'] = (($r['curr'] == $c[4]) and ($r['batch'] != 'TEST MODE'));
			return $r;
		}
		catch(EgoPayException $e)
		{
			xSysStop($e->getMessage());
		}              
	case 'LP':
		$resp = base64_decode($arr['operation_xml']);
		$sign = $arr['signature']; // b64encoded!
		$sign2 = base64_encode(sha1($params2['key'].$resp.$params2['key'], 1));
		if ($sign != $sign2) return array();
		$resp = str_replace("\n", "", str_replace("\r", "", $resp));
		$r = array(
			'accto' => parse_tag($resp, 'merchant_id'),
			'accfrom' => parse_tag($resp, 'sender_phone'),
			'sum' => parse_tag($resp, 'amount'),
			'sum2' => parse_tag($resp, 'amount'),
			'curr' => parse_tag($resp, 'currency'),
			'tag' => parse_tag($resp, 'order_id'),
			'date' => time(),
			'batch' => parse_tag($resp, 'transaction_id'),
			'method' => parse_tag($resp, 'pay_way'),
			'action' => parse_tag($resp, 'action'),
			'status' => parse_tag($resp, 'status'), // success, failure, wait_secure
			'pending' => (parse_tag($resp, 'status') === 'wait_secure'),
			'code' => parse_tag($resp, 'code') // not used
		);
		$r['correct'] = (($r['curr'] == $c[4]) and ($r['status'] === 'success'));
		return $r;
	case 'SP':
		$r = array(
			'accto' => $arr['payee_account'],
			'accfrom' => $arr['payer_account'],
			'sum' => $arr['amount'],
			'tag' => $arr['payment_id'],
			'date' => $arr['date'],
			'batch' => $arr['transactionID'],
			'hash' => $arr['ver_string']
		);
		$cc = md5($r['accto'].$r['sum'].$params2['key']);
		$r['cc'] = $cc;
		$r['correct'] = ($cc === $r['hash']);
		return $r;
	case 'GDP': 
		$t = $arr['timestamp'];
		$t = gmmktime(substr($t, 11, 2), substr($t, 14, 2), substr($t, 17, 2), substr($t, 8, 2), substr($t, 5, 2), substr($t, 0, 4));
		$r = array(
			'accountname' => $arr['account_name'],
			'accto' => $arr['paidto'],
			'accfrom' => $arr['paidby'],
			'sum' => $arr['amount'],
			'sum2' => $arr['amount'] - $arr['fee_amount'],
			'curr' => $arr['currency'],
			'tag' => $arr['merchant_comment'], // gdp_custom_1
			'date' => $t,
			'batch' => $arr['TransactionID'], // gdp_reference
			'usercomment' => $arr['user_comment'],
			'hash' => $arr['gdp_hash']
		);
		$cc = md5(implode(':',
			array($r['accto'], $r['accfrom'], $params2['store'], $r['sum'], $r['curr'], $r['batch'], $params2['ref'], $params2['apipass'])
			));
		$r['cc'] = $cc;
		$r['correct'] = (($r['curr'] == $c[4]) and ($cc === $r['hash']));
//		$r['correct'] = ($_SERVER['REMOTE_ADDR'] == '111.235.137.104');
		return $r;
	case 'STP': 
		$r = array(
			'accto' => $arr['merchantAccount'],
			'accfrom' => $arr['payerAccount'],
			'sum' => $arr['amount'],
			'curr' => $c[4],
			'tag' => $arr['user1'],
//			memo - from user
			'date' => time(),
			'batch' => $arr['tr_id'],
			'testmode' => $arr['testmode'],
			'status' => $arr['status'],
			'pending' => ($arr['status'] === 'PENDING'),
			'hash' => $arr['hash']
		);
		if (!$r['testmode']) {	// PENDING/CANCELED
			$cc = md5(implode(':',
				array($r['batch'], md5(md5($params2['key'] . 's+E_a*')), $r['sum'], $r['accto'], $r['accfrom'])
				));
			$r['cc'] = $cc;
			$r['correct'] = (($r['status'] === 'COMPLETE') and ($cc === $r['hash']));
		}
		return $r;
	case 'MR':
		$r = array(
			'shopid' => $arr['MERA_SHOP_ID'],
			'accto' => $arr['MERA_PAY_TO_WALLET'],
			'accfrom' => $arr['MERA_PAY_FROM_WALLET'],
			'sum' => $arr['MERA_AMOUNT'],
			'sum2' => $arr['MERA_AMOUNT'],
			'status' => $arr['MERA_TYPE'],
			'tag' => $arr['MERA_TRANS_ID'],
			'date' => time(),
			'batch' => $arr['MERA_ID'],
			'hash' => $arr['MERA_HASH']
		);
		$cc = base64_encode(md5(
			$arr['MERA_SHOP_ID'] . "|" . $arr['MERA_TRANS_ID'] . "|" . $arr['MERA_DESCRIPTION'] . "|" . $arr['MERA_PAY_TO_WALLET'] . "|" . $arr['MERA_PAY_FROM_WALLET'] . "|" . $arr['MERA_AMOUNT'] . "|" . $arr['MERA_ID'] . "|" . $params2['key'] 
		));
		$r['cc'] = $cc;
		$r['correct'] = ($cc === $r['hash']);
		return $r;
	case 'YMC':
	case 'YM':
		$comis = valueIf($arr['notification_type'] == 'card-incoming', 0.02, 0.005);
		$sum = round($arr['amount'] * (1 + $comis), 2);
		$r = array(
			'accfrom' => valueIf($cid == 'YM', $arr['sender']),
			'sum' => $sum,
			'sum2' => $sum,
			'curr' => $arr['currency'],
			'tag' => $arr['label'],
			'date' => time(),
			'batch' => $arr['operation_id'],
			'testmode' => $arr['test_notification'],
			'hash' => $arr['sha1_hash']
		);
		if (!$r['testmode'] and ($arr['codepro'] == 'false'))
		{
			$cc = strtolower(sha1(implode('&',
				array($arr['notification_type'], $arr['operation_id'], $arr['amount'], $arr['currency'], 
					$arr['datetime'], $arr['sender'], $arr['codepro'], $params2['key'], $arr['label'])
				)));
			$r['cc'] = $cc;
			$r['correct'] = ($cc === $r['hash']);
		}
		return $r;
	case 'WM':                                
		if ($arr['LMI_PREREQUEST']) {
			echo('YES');
			exit;
		}
		$t = $arr['LMI_SYS_TRANS_DATE'];
		$ts = gmmktime(substr($t, 9, 2), substr($t, 12, 2), substr($t, 15, 2), substr($t, 4, 2), substr($t, 6, 2), substr($t, 0, 4));
		$r = array(
			'accto' => $arr['LMI_PAYEE_PURSE'],
			'accfrom' => $arr['LMI_PAYER_PURSE'],
			'accwmid' => $arr['LMI_PAYER_WM'],
			'paymer' => $arr['LMI_PAYMER_NUMBER'],
			'euronote' => $arr['LMI_EURONOTE_NUMBER'],
			'atm' => $arr['LMI_CASHIER_ATMNUMBERINSIDE'],
			'sum' => $arr['LMI_PAYMENT_AMOUNT'],
			'sum2' => $arr['LMI_PAYMENT_AMOUNT'],
			'tag' => $arr['LMI_PAYMENT_NO'],
			'date' => $ts,
			'batch' => $arr['LMI_SYS_TRANS_NO'],
			'testmode' => $arr['LMI_MODE'],
			'hash' => $arr['LMI_HASH']
		);
		if (!$r['testmode']) {
			$cc = strtoupper(hash('sha256', implode('',
				array($r['accto'], $r['sum'], $r['tag'], $r['testmode'], $arr['LMI_SYS_INVS_NO'], 
					$r['batch'], $t, $params2['key'], $r['accfrom'], $r['accwmid'])
				)));
			$r['cc'] = $cc;
			$r['correct'] = ($cc === $r['hash']);
		}
		return $r;
	case 'BC':                                
		$r = array(
			'accto' => $arr['destination_address'],
			//'accfrom' => $arr['address'],
			'sum' => $arr['value'] / 100000000,
			'sum2' => $arr['value'] / 100000000,
			'tag' => $arr['tag'],
			'date' => time(),
//			'batch' => $arr['transaction_hash'],
			'batch' => $arr['input_transaction_hash'],
			'confirmations' => 0 + $arr['confirmations'],
			'wait' => ((0 + $arr['confirmations']) < 6),
			'hash' => $arr['key']
		);
		$r['cc'] = $params2['key'];
		$r['correct'] = ($r['hash'] == $params2['key']);
		if (!$r['wait'])
			echo('*ok*');
		return $r;
	case 'IBC':
		if (_GET('key') != $params2['key'])
			exit;
		$arr = json_decode(file_get_contents('php://input'), true);
		if ($arr['type'] != 'address')
			exit;
		if (!$arr['data']['is_green'] and ($arr['data']['confirmations'] < 3))
			exit;
		require_once('lib/inet.php');
		$res = json_decode(inet_request("https://block.io/api/v2/get_address_balance/?api_key=$params2[apipass]&addresses={$arr[data][address]}"), 1);
		//xaddtolog($req, 'blockio');
		$r = array(
			'sum' => $res['data']['available_balance'] + $res['data']['pending_received_balance'],
			'curr' => $arr['data']['network'],
			'tag' => _GETN('tag'),
			'date' => time(),
			'batch' => $arr['data']['txid'],
			'hash' => _GET('key')
		);
		$r['cc'] = $params2['key'];
		$r['correct'] = ($r['curr'] == $c[1]);
		return $r;
	case 'CB':
		$arr = json_decode(file_get_contents('php://input'), true);
		$r = array(
			'sum' => $arr['order']['total_btc']['cents'] / 100000000,
			'curr' => $arr['order']['total_btc']['currency_iso'],
			'tag' => $arr['order']['custom'],
			'date' => time(),
			'batch' => $arr['order']['transaction']['id'],
			'status' => $arr['order']['status'],
			'confirmations' => 0 + $arr['order']['transaction']['confirmations'],
			'wait' => ((0 + $arr['order']['transaction']['confirmations']) < 0),
			'hash' => _GET('key')
		);
		$r['cc'] = $params2['key'];
		$r['correct'] = (($r['status'] === 'completed') and ($r['hash'] == $params2['key']) and ($r['curr'] == $c[1]));
		return $r;
	case 'CKE':
		$word = $arr['itscke'];
		if ($word != $params2['key'])
			return array();
		$event = exValue($arr['?event_code'], $arr['event_code']);
		if ($event != 'credit_full')
			return array();
		return array(
			'sum' => exValue($arr['?total'], $arr['total']),
			'curr' => $c[4],
			'tag' => exValue($arr['?tracking'], $arr['tracking']),
			'date' => time(),
			'batch' => exValue($arr['?request'], $arr['request']),
			'correct' => true
		);
	case 'EA':
	case 'EAT':
		$arr = json_decode(file_get_contents('php://input'), true);
//xaddtolog($arr, 'ea');
		if (!$arr['etherapi.net'])
			exit;
		$r = array(
			'accto' => $arr['to'],
			'accfrom' => $arr['from'],
			'sum' => $arr['amount'],
			'sum2' => $arr['amount'],
			'tag' => $arr['tag'],
			'date' => (($arr['date'] > 0) ? $arr['date'] : time()),
			'batch' => $arr['txid'],
			'hash' => $arr['sign']
		);
		$a = array(
			$arr['type'],
			$arr['date'],
			$arr['from'],
			$arr['to'],
			$arr['token'],
			$arr['amount'],
			$arr['txid'],
			$arr['confirmations'],
			$arr['tag'],
			$params2['apipass']
		);
		if (!$arr['token'])
			unset($a[4]);
		$r['cc'] = sha1(implode(':', $a));
		echo(($r['hash'] == $r['cc']) ? "OK" : 'sign_wrong');
		$r['correct'] = (($r['hash'] == $r['cc']) and ($arr['confirmations'] >= 12));
		if ((($cid == 'EA') and $arr['token']) or (($cid == 'EAT') and ($arr['token'] != $c[1])))
			$r['correct'] = false;
//xaddtolog($r, 'ea');
		if ($arr['type'] == 'out')
		{
			global $db;
			if ($r['correct'])
				$db->update('Opers', array('oBatch' => $r['batch']), '', 
					'oID=?d and oOper=? and oState=3 and SUBSTR(oBatch, 1, 1)=?', array($r['tag'], 'CASHOUT', '?'));
			exit;
		}
		return $r;
	case 'CCAB':
	case 'CCAL':
		$arr = json_decode(file_get_contents('php://input'), true);
//xaddtolog($arr, 'cca');
		if (!$arr['cryptocurrencyapi.net'])
			exit;
		$r = array(
			'sum' => $arr['amount'],
			'sum2' => $arr['amount'],
			'curr' => $arr['currency'],
			'tag' => $arr['tag'],
			'date' => (($arr['date'] > 0) ? $arr['date'] : time()),
			'batch' => $arr['txid'],
			'hash' => $arr['sign']
		);
		$r['cc'] = sha1(implode(':', array(
			$arr['currency'],
			$arr['type'],
			$arr['date'],
			$arr['to'],
			$arr['amount'],
			$arr['txid'],
			$arr['confirmations'],
			$arr['tag'],
			$params2['apipass']
		)));
		echo(($r['hash'] == $r['cc']) ? "OK" : 'sign_wrong');
		$r['correct'] = (($r['hash'] == $r['cc']) and ($arr['confirmations'] >= 3));
//xaddtolog($r, 'cca');
		if ($arr['type'] == 'out')
		{
			global $db;
			$db->update('Opers', array('oBatch' => ($r['correct'] ? '' : '?') . $r['batch']), '', 
				'oID=?d and oOper=? and oState=3 and SUBSTR(oBatch, 1, 1)=?', array($r['tag'], 'CASHOUT', '?'));
			if ($r['correct'])
			{
				//have been transferred to your #acc# #psys#  wallet #sum# #curr# (batch: #batch#)
				$uid = $db->fetch1($db->select('Opers', 'ouID', 'oID=?d', array($r['tag'])));
				if ($usr = opReadUser($uid))
					sendMailToUser($usr['uMail'], 'OperCASHOUT2', 
						opUserConsts($usr, array(
							'acc' => $arr['to'],
							'psys' => '',
							'sum' => $arr['amount'],
							'curr' => $c[4],
							'batch' => $arr['txid']
						)),
						$usr['uLang']
					);
			}
			exit;
		}
		return $r;
	case 'XRPA':
		$arr = json_decode(file_get_contents('php://input'), true);
xaddtolog($arr, 'xrp');
		if (!$arr['xrpapi.net'])
			exit;
		$r = array(
			//'accto' => $arr['to'],
			//'accfrom' => $arr['from'],
			'sum' => $arr['amount'],
			'sum2' => $arr['amount'],
			'tag' => $arr['label'],
			'date' => (($arr['date'] > 0) ? $arr['date'] : time()),
			'batch' => $arr['txid'],
			'hash' => $arr['sign']
		);
		$r['cc'] = sha1(implode(':', array(
			$arr['type'],
			$arr['date'],
			$arr['from'],
			$arr['to'],
			$arr['tag'],
			$arr['amount'],
			$arr['fee'],
			$arr['txid'],
			$arr['label'],
			$params2['apipass']
		)));
		echo(($r['hash'] == $r['cc']) ? "OK" : 'sign_wrong');
		$r['correct'] = ($r['hash'] == $r['cc']);
xaddtolog($r, 'xrpa');
		if ($arr['type'] == 'out')
		{
			global $db;
			$db->update('Opers', array('oBatch' => ($r['correct'] ? '' : '?') . $r['batch']), '', 
				'oID=?d and oOper=? and oState=3 and SUBSTR(oBatch, 1, 1)=?', array($r['tag'], 'CASHOUT', '?'));
			if ($r['correct'])
			{
				//have been transferred to your #acc# #psys#  wallet #sum# #curr# (batch: #batch#)
				$uid = $db->fetch1($db->select('Opers', 'ouID', 'oID=?d', array($r['tag'])));
				if ($usr = opReadUser($uid))
					sendMailToUser($usr['uMail'], 'OperCASHOUT2', 
						opUserConsts($usr, array(
							'acc' => $arr['to'],
							'psys' => 'Ripple',
							'sum' => $arr['amount'],
							'curr' => 'XRP',
							'batch' => $arr['txid']
						)),
						$usr['uLang']
					);
			}
			exit;
		}
		return $r;
	case 'CPL': 
	case 'CPE': 
	case 'CPR': 
	case 'CP':
/*
    [ipn_version] => 1.0
    [ipn_id] => 73d44579c1830d538241340547c44d5c
    [ipn_mode] => hmac
    [merchant] => ...
    [ipn_type] => simple
    [txn_id] => CPAE6A05V0CVIJ5PGMCJIDXDPT
    +[status] => 0 / 1 / 100
    [status_text] => Complete
    +[currency1] => BTC
    [currency2] => BTC
    +[amount1] => 0.001
    [amount2] => 0.001
    [subtotal] => 0.001
    [shipping] => 0
    [tax] => 0
    [fee] => 1.0E-5
    [net] => 0.00099
    [item_amount] => 0.001
    [item_name] => ...
    [first_name] => 1
    [last_name] => 2
    [email] => ...
    +[invoice] => 45
    [received_amount] => 0.001
    [received_confirms] => 2
*/
xaddtolog('mmmmmmmmmmmmmmmmmmmmmmm', 'cp');
		$merchant_id = $params2['id'];
		$secret = $params2['key'];
		if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC']))
			xstop("No HMAC signature sent");
		$request = file_get_contents('php://input');
xaddtolog($_POST, 'cp');
xaddtolog($request, 'cp');
		if ($request === FALSE || empty($request))
			xstop("Error reading POST data");
		echo('IPN OK'); 
		$merchant = isset($_POST['merchant']) ? $_POST['merchant'] : '';
		if (empty($merchant))
			xstop("No Merchant ID passed");
		if ($merchant != $merchant_id)
			xstop("Invalid Merchant ID");
		$hmac = hash_hmac("sha512", $request, $secret);
		if ($hmac != $_SERVER['HTTP_HMAC'])
			xstop("HMAC signature does not match");
		$r = array(
			'sum' => floatval($_POST['amount1']),
			'curr' => $_POST['currency1'],
			'tag' => $_POST['invoice'],
			'date' => time(),
			'status' => intval($_POST['status']),
			'batch' => $_POST['txn_id']
		);
xaddtolog($r, 'cp');
		if ($r['status'] >= 100 || $r['status'] == 2)
			$r['correct'] = (($r['curr'] == $c[1]) and ($r['status'] >= 100));
		else
			exit;
		return $r;
	case 'PKAU':
	case 'PKAR':
	case 'PKPM':
	case 'PKPU':
	case 'PKPR':
	case 'PKB':
	case 'PKE':
	case 'PKL':
		require_once('lib/paykassa/paykassa_sci.class.php');
		$paykassa = new PayKassaSCI(
			$params2['id'],
			$params2['key']
		);
		$res = $paykassa->sci_confirm_order();

	    if ($res['error']) {
	        die ($res['message']);
	    }	
	    $r = array(
	    	'sum' => $res["data"]["amount"],
	    	'curr' => $res["data"]["currency"],
	    	'tag' => $res["data"]["order_id"],
	    	'date' => time(),
	    	'batch' => $res["data"]["transaction"],
	    	'status' => 'success',
	    	'correct' => true
	    );
	    echo $res["data"]["order_id"].'|success';
	  	return $r;
	case 'EPCU':
	case 'EPCB':
	case 'EPCT':
		if (!isset($arr['epc_batch']) or !isset($arr['epc_sign']))
			return xstop('Wrong IPN');
		$r = array(
			'accto' => $arr['epc_dst_account'],
			'accfrom' => $arr['epc_src_account'],
			'sum' => $arr['epc_amount'],
			'sum2' => $arr['epc_amount'] - 0, // ???
			'curr' => $arr['epc_currency_code'],
			'tag' => $arr['epc_order_id'],
			'date' => $arr['epc_created_at'],
			'batch' => $arr['epc_batch'],
			'hash' => $arr['epc_sign']
		);
		$sign = array(
			$arr['epc_merchant_id'],
			$arr['epc_order_id'],
			$arr['epc_created_at'],
			$arr['epc_amount'],
			$arr['epc_currency_code'],
			$arr['epc_dst_account'],
			$arr['epc_src_account'],
			$arr['epc_batch'],
			$params2['apipass']
		);
		$cc = hash('sha256', implode(':', $sign));
		$r['cc'] = $cc;
		$r['correct'] = (($r['curr'] == $c[4]) and ($cc === $r['hash']));
		if (!$r['correct'])
		{
			header('HTTP/1.1 400 Bad request');
			xstop('Invalid signature');
		}
		return $r;
	case 'EGC': 
		$t = $arr['egc_timestamp'];
		$t = gmmktime(substr($t, 11, 2), substr($t, 14, 2), substr($t, 17, 2), substr($t, 8, 2), substr($t, 5, 2), substr($t, 0, 4));
		$r = array(
			'store' => $arr['egc_store'],
			'accto' => $arr['egc_acc'],
			'accfrom' => $arr['egc_acc_from'],
			'sum' => $arr['egc_amnt'],
			'sum2' => $arr['egc_amnt'] - 0, // ???
			'curr' => $arr['egc_currency'],
			'tag' => $arr['bf_tag'],
			'date' => $t,
			'batch' => $arr['egc_transaction'],
			'hash' => $arr['egc_transactionhash']
		);
		// sum as like POST
		$cc = implode(':', 
			array($r['accto'], $r['accfrom'], $r['store'], $r['sum'], $r['curr'], $r['batch'], $params2['key'])
			);
		if (function_exists('hash')) $cc = strtoupper(hash('sha256', $cc));
		else $cc = strtoupper(bin2hex(mhash(MHASH_SHA256, $cc)));
		$r['cc'] = $cc;
		$r['correct'] = (($r['curr'] == $c[4]) and ($cc === $r['hash']));
		return $r;
	case 'C4P':
		$r = array(
			'accto' => $arr['account'],
			'sum' => $arr['value'],
			'sum2' => $arr['value'],
			'tag' => $arr['transactionId'],
			'date' => time()
		);
		$cc = implode('', 
			array($arr['account'], $arr['value'], $arr['transactionId'], $params2['key'])
			);
		$cc = md5($cc);
		$r['cc'] = $cc;

		$json = json_decode(file_get_contents('https://cash4pay.co/payment/status/' . $arr['account'] . '/' . $arr['transactionId']));
		$hashFromCash4pay = $json->hash;
		if ($cc == $hashFromCash4pay)
		{
			$r['batch'] = $hashFromCash4pay;
			$r['correct'] = true;
		}
		return $r;
	case 'A1':
		$r = array(
			'partner_id' => $arr['partner_id'],
			'service_id' => $arr['service_id'],
			'order_id' => $arr['order_id'],
			'accfrom' => $arr['type'] . valueIf($arr['email'], ' [' . $arr['email'] . ']'),
			'sum' => $arr['system_income'],
			'sum2' => $arr['partner_income'],
			'tag' => $arr['comment'],
			'date' => time(),
			'batch' => $arr['tid'],
			'hash' => $arr['check']
		);
		$cc = md5(implode('', 
			array($arr['tid'], $arr['name'], $arr['comment'], $arr['partner_id'], $arr['service_id'], $arr['order_id'], $arr['type'], $arr['partner_income'], $arr['system_income'], $params2['key'])
			));
		$r['cc'] = $cc;
		$r['correct'] = ($cc === $r['hash']);
		return $r;
	case 'W1': 
		$r = array(
			'accto' => $arr['WMI_MERCHANT_ID'],
			'accfrom' => $arr['WMI_TO_USER_ID'] . valueIf($arr['WMI_PAYMENT_TYPE'], ' [' . $arr['WMI_PAYMENT_TYPE'] . ']'),
			'sum' => $arr['WMI_PAYMENT_AMOUNT'],
			'sum2' => $arr['WMI_PAYMENT_AMOUNT'],
			'curr' => $arr['WMI_CURRENCY_ID'],
			'tag' => $arr['WMI_PAYMENT_NO'],
			'date' => time(),
			'batch' => $arr['WMI_ORDER_ID'],
			'status' => $arr['WMI_ORDER_STATE'],
			'hash' => $arr['WMI_SIGNATURE']
		);
		unset($arr['WMI_SIGNATURE']);
		uksort($arr, 'strcasecmp');
		$cc = base64_encode(pack("H*", md5(implode('', $arr) . $params2['key'])));
		$r['cc'] = $cc;
		$r['correct'] = (($r['curr'] == $c[4]) and ($cc === $r['hash']) and (strtoupper($r['status']) == 'ACCEPTED'));
		if ($cc != $r['hash'])
			echo('WMI_RESULT=RETRY&WMI_DESCRIPTION=Wrong_Signature');
		elseif (strtoupper($r['status']) != 'ACCEPTED')
			echo('WMI_RESULT=RETRY&WMI_DESCRIPTION=Wrong_Order_State');
		elseif ($r['curr'] != $c[4])
			echo('WMI_RESULT=RETRY&WMI_DESCRIPTION=Wrong_Currency');
		else
			echo('WMI_RESULT=OK');
		return $r;
	case 'QW':
		$r = array(
			'accto' => $arr['login'],
			'accfrom' => '',
			'sum' => '?',
			'sum2' => '?',
			'curr' => 'RUB',
			'tag' => $arr['txn'],
			'date' => time(),
			'batch' => $arr['txn'],
			'status' => $arr['status'],
			'hash' => $arr['password']
		);
		$cc = strtoupper(md5($r['tag'] . strtoupper(md5($params2['key']))));
		$r['cc'] = $cc;
		$r['correct'] = (($cc == $r['hash']) and ($r['status'] == 60));
		$RC = ($r['correct'] ? 0 : 150);
		$answ = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://client.ishop.mw.ru/"><SOAP-ENV:Body><ns1:updateBillResponse><updateBillResult>status</updateBillResult></ns1:updateBillResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>';
		$answ = str_replace('status', $RC, $answ);
		header('Content-Type: text/xml; charset=utf-8');
		echo $answ;
		return $r;
	case 'QW2':
		$r = array(
			'accfrom' => $arr['user'],
			'sum' => $arr['amount'],
			'sum2' => $arr['amount'],
			'curr' => $arr['ccy'],
			'tag' => $arr['bill_id'],
			'date' => time(),
			'batch' => $arr['bill_id'] . time(),
			'status' => $arr['status']
		);
		$cc = $_SERVER['PHP_AUTH_USER'] . ':' . $_SERVER['PHP_AUTH_PW'];
		$r['cc'] = $cc;
		$r['correct'] = (($cc == ($params2['id'] . ':' . $params2['key'])) and ($r['status'] == 'paid'));
		$RC = ($r['correct'] ? 0 : 150);
		header('Content-Type: text/xml; charset=utf-8');
		echo "<?xml version=\"1.0\"?><result><result_code>$RC</result_code></result>";
		return $r;
	case 'PYE': 
	case 'PYR': 
	case 'PY': 
		$t = $arr['m_operation_pay_date'];
		$t = gmmktime(substr($t, 11, 2), substr($t, 14, 2), 0, substr($t, 3, 2), substr($t, 0, 2), substr($t, 6, 4));
		$r = array(
			'store' => $arr['m_shop'],
			'accfrom' => $arr['client_account'],
			'sum' => $arr['m_amount'],
			'sum2' => $arr['m_amount'],
			'curr' => $arr['m_curr'],
			'tag' => $arr['m_orderid'],
			'date' => $t,
			'method' => $arr['m_operation_ps'],
			'batch' => $arr['m_operation_id'],
			'hash' => $arr['m_sign']
		);
		$cc = implode(':', 
			array($arr['m_operation_id'], $arr['m_operation_ps'], $arr['m_operation_date'], $arr['m_operation_pay_date'], $arr['m_shop'], $arr['m_orderid'], $arr['m_amount'], $arr['m_curr'], $arr['m_desc'], $arr['m_status'], $params2['key'])
			);
		if (function_exists('hash')) $cc = strtoupper(hash('sha256', $cc));
		else $cc = strtoupper(bin2hex(mhash(MHASH_SHA256, $cc)));
		$r['cc'] = $cc;
		$r['correct'] = (($r['curr'] == $c[4]) and ($cc == $r['hash']) and ($arr['m_status'] == 'success'));
		echo $arr['m_orderid'] . valueIf($r['correct'], '|success' , '|error');
		return $r;
	case 'AEX1': 
	case 'AEX2': 
	case 'AEX3': 
	case 'AEX4': 
	case 'AEX5': 
	case 'AEX6': 
	case 'AEX7': 
	case 'AEX8': 
//xaddtolog('------------', 'aexx');
//xaddtolog(1, 'aexx');
		$hmac = $_SERVER['HTTP_HMAC'];
//xaddtolog(2, 'aexx');
		$privkey = $params2['key'];
//xaddtolog(3, 'aexx');
		$body = file_get_contents('php://input');
//xaddtolog(function_exists('hash_hmac'), 'aexx');
//xaddtolog(4, 'aexx');
		$myHmac = hash_hmac('sha256', $body, $privkey);
//xaddtolog("body: $body, myHmac: $myHmac, hmac: $hmac", 'aexx');
		if ($myHmac != $hmac)
			die('Hmac wrong');
		echo('OK');
		$o = @json_decode($body, 1);
//xaddtolog($o, 'aexx');
/*
{
 'vkey': false,
 'type': 'order-status',
 'value' : {
   'status': 'deleted',
   'order_id': 15553195554077,
   'msg': 'Заявка удалена'
 }
}
*/		
		if ($o['type'] != 'order-status')
			die('Type wrong');
		if ($o['value']['status'] != 'completed')
			die('Status wrong');
		require_once('lib/inet.php');
		$a = @json_decode(inet_request(
			'https://api2-service.icu/api/1/order-get/?nonce='.(time2()+0).
				'&akey='.$params2['akey'].
				'&bkey='.$params2['bkey'].
				'&order_id='.$o['value']['order_id']
		), 1);
//xaddtolog($a, 'aexx');
		if ($a["status"] != "success")
			die($a["msg"]);
		if ($a['value']['status'] != 'completed')
			die('Status2 wrong');
		$b = explode(':', $o['vkey']);
//xaddtolog($b, 'aexx');
		$r = array(
			'sum' => $a['value']['in'],
			'sum2' => $a['value']['in'],
			'curr' => $c[1],
			'tag' => $b[1],
			'date' => time(),
			'batch' => $a['value']['id']
		);
		$r['correct'] = true;
//xaddtolog($r, 'aexx');
		return $r;
	case 'NXB': 
	case 'NXE': 
	case 'NXR': 
	case 'NX': 
		$r = array(
			'accto' => $arr['PAYEE_ACCOUNT'],
			'accfrom' => $arr['PAYER_ACCOUNT'],
			'sum' => $arr['PAYMENT_AMOUNT'],
			'sum2' => $arr['PAYMENT_AMOUNT'],
			'curr' => $arr['PAYMENT_UNITS'],
			'tag' => $arr['PAYMENT_ID'],
			'date' => $arr['TIMESTAMPGMT'],
			'batch' => 0 + $arr['PAYMENT_BATCH_NUM'],
			'hash' => $arr['V2_HASH']
		);
		// sum 0/0.0/0.00 (like in)!
		$cc = implode(':', 
			array($r['tag'], $r['accto'], $r['sum'], $r['curr'], $r['batch'], $r['accfrom'], strtoupper(md5($params2['key'])), $r['date'])
			);
		$cc = strtoupper(md5($cc));
		$r['cc'] = $cc;
		$r['correct'] = (($r['curr'] == $c[4]) and ($cc === $r['hash']));
		return $r;
	case 'OKR': 
	case 'OK':
		include_once('lib/inet.php');
		$r = array('ok_verify' => 'true') + $arr;
		$answ = inet_request('https://www.okpay.com/ipn-verify.html', $r);
		$r = array(
			'payeer' => $arr['ok_payer_id'],
			'tag' => $arr['ok_invoice'],
			'sum' => $arr['ok_txn_net'],
			'curr' => $arr['ok_txn_currency'],
			'batch' => $arr['ok_txn_id'],
			'status' => $arr['ok_txn_status'],
			'kind' => $arr['ok_txn_kind'],
			'method' => $arr['ok_txn_payment_method'],
			'date' => time()
		);
		$r['correct'] = (($arr['ok_receiver'] == $params2['acc']) and ($answ == 'VERIFIED') and ($r['curr'] == $c[4]) and ($r['status'] == 'completed'));
		return $r;
	case 'ACR': 
	case 'AC': 
		$r = array(
			'sci' => $arr['ac_sci_name'],
			'accto' => $arr['ac_dest_wallet'],
			'accfrom' => $arr['ac_buyer_email'],
			'sum' => $arr['ac_amount'],
			'sum2' => $arr['ac_amount'] - $arr['ac_fee'],
			'curr' => $arr['ac_merchant_currency'],
			'tag' => $arr['ac_order_id'],
			'date' => time(),
			'batch' => $arr['ac_transfer'],
			'hash' => $arr['ac_hash']
		);
		$cc = implode(':', array(
$arr['ac_transfer'],
$arr['ac_start_date'],
$arr['ac_sci_name'],
$arr['ac_src_wallet'],
$arr['ac_dest_wallet'],
$arr['ac_order_id'],
$arr['ac_amount'],
$arr['ac_merchant_currency'],
$params2['key']
		)
			);
		if (function_exists('hash')) $cc = hash('sha256', $cc);
		else $cc = bin2hex(mhash(MHASH_SHA256, $cc));
		$r['cc'] = $cc;
		$r['correct'] = (($r['curr'] == $c[4]) and ($cc === $r['hash']));
		return $r;
	case 'HM': 
		$r = array(
			'sum' => $arr['amount'],
			'sum2' => $arr['amount'],
			'curr' => strtoupper($arr['currency']),
			'tag' => ($operation_id = $arr['operation_id']),
			'paysys' => $arr['paysystem_id'],
			'date' => time(),
			'batch' => 'HM' . substr(strtoupper(md5(uniqid(microtime()))), -8),
			'hash' => $arr['hash']
		);
		$cc = md5(implode(':', 
			array($arr['shop_id'], $arr['paysystem_id'], $arr['operation_id'], $arr['amount'], $arr['currency'], $params2['key2'])
			));
		$r['cc'] = $cc;
		if ($r['correct'] = (($r['curr'] == $c[4]) and ($cc === $r['hash'])))
			echo "OK$operation_id\n";
		else
			echo "bad sign\n";
		return $r;
	case 'PP':
		$t = time();
		$ts = gmmktime(substr($t, 9, 2), substr($t, 12, 2), substr($t, 15, 2), substr($t, 4, 2), substr($t, 6, 2), substr($t, 0, 4));
		$r = array(
			'accto' => $arr['payee_account'],
			'accfrom' => $arr['payer_account'],
			'sum' => $arr['amount'],
			'sum2' => $arr['amount'],
			'tag' => $arr['payment_id'],
			'date' => $arr['date'],
			'batch' => $arr['transacationID'],
			'hash1' => $arr['ver_string_pid'],
			'hash2' => $arr['ver_string_tid']
		);
		$cc1 = md5(implode('',
			array($r['accto'], $r['sum'], $params2['key'], $r['tag'])
			));
		$cc2 = md5(implode('',
			array($r['accto'], $r['sum'], $params2['key'], $r['batch'])
			));
		$r['cc1'] = $cc1;
		$r['cc2'] = $cc2;
		$r['correct'] = ($cc1 == $r['hash1']) and ($cc2 == $r['hash2']);
		return $r;
		$myhash = strtoupper(hash('sha512', $params2['id'] . '+' . $params2['key']));
		$cc = strtoupper(hash('sha512', implode('',
			array($arr['comment'], $arr['fee'], $arr['payer'], $arr['payee'], $arr['amount'], $arr['date'], $arr['type'], $arr['id'], $myhash)
			)));
		$r['cc'] = $cc;
		$r['correct'] = ($cc == $r['hash']);
		return $r;
	case 'ON':
		if ($arr['type'] == 'check')
		{
			$cc = implode(';', 
				array($arr['type'], $arr['pay_for'], $arr['order_amount'], $arr['order_ticker'], $params2['key'])
				);
			$cc = strtoupper(md5($cc));
			if ($cc == $arr['md5'])
			{
				$code = 0;
				$text = 'OK';
			}
			else
			{
				$code = 7;
				$text = 'Wrong sign';
			}
			$cc = implode(';', 
				array($arr['type'], $arr['pay_for'], $arr['order_amount'], $arr['order_ticker'], $code, $params2['key'])
				);
			$cc = strtoupper(md5($cc));
			echo(
				"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" .
				"<result>" .
				"	<code>$code</code>" .
				"	<pay_for>{$arr['pay_for']}</pay_for>" .
				"	<comment>$text</comment>" .
				"	<md5>$cc</md5>" .
				"</result>"
				);
			exit;
		}
		$r = array(
			'sum' => $arr['order_amount'],
			'sum2' => $arr['order_amount'],
			'curr' => $arr['order_ticker'],
			'tag' => $arr['pay_for'],
			'date' => time(),
			'batch' => $arr['onpay_id'],
			'hash' => $arr['md5']
			);
		$cc = implode(';', 
			array($arr['type'], $arr['pay_for'], $arr['onpay_id'], $arr['order_amount'], $arr['order_ticker'], $params2['key'])
			);
		$cc = strtoupper(md5($cc));
		$r['cc'] = $cc;
		$r['correct'] = (($cc == $r['hash']) and ($r['curr'] == $c[4]));
		
		if ($r['correct'])
		{
			$code = 0;
			$text = 'OK';
		}
		else
		{
			$code = 7;
			$text = 'Wrong sign';
		}
		$cc = implode(';', 
			array($arr['type'], $arr['pay_for'], $arr['onpay_id'], $arr['order_id'], $arr['order_amount'], $arr['order_ticker'], $code, $params2['key'])
			);
		$cc = strtoupper(md5($cc));
		echo(
			"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" .
			"<result>" .
			"	<code>$code</code>" .
			"	<comment>$text</comment>" .
			"	<onpay_id>{$arr['onpay_id']}</onpay_id>" .
			"	<pay_for>{$arr['pay_for']}</pay_for>" .
			"	<order_id>{$arr['order_id']}</order_id>" .
			"	<md5>$cc</md5>" .
			"</result>"
			);
		return $r;
	case 'SY':
		$r = array(
			'tag' => $arr['spShopPaymentId'],
			'sum' => $arr['spAmount'], // spBalanceAmount??
			'curr' => $arr['spCurrency'],
			'batch' => $arr['spPaymentId'],
			'psys' => $arr['spPaymentSystemId'],
			'date' => time(),
			'hash' => $arr['spHashString']
		);
		$cc = strtoupper(md5(
			$arr['spPaymentId'].
			$arr['spShopId'].
			$arr['spShopPaymentId'].
			$arr['spBalanceAmount'].
			$arr['spAmount'].
			$arr['spCurrency'].
			$arr['spCustomerEmail'].
			$arr['spPurpose'].
			$arr['spPaymentSystemId'].
			$arr['spPaymentSystemAmount'].
			$arr['spPaymentSystemPaymentId'].
			$arr['spEnrollDateTime'].
			$key
		));
		$r['cc'] = $cc;
		$r['correct'] = (($r['curr'] == $c[4]) and ($cc == strtoupper($r['hash'])));
		echo('ok');
		return $r;
	case 'IK':
		$r = array(
			'shopid' => $arr['ik_shop_id'],
			'accto' => '',
			'accfrom' => $arr['paid_by_acc'],
			'sum' => $arr['ik_payment_amount'],
			'sum2' => $arr['ik_payment_amount'],
			'curr' => 'USD',
			'tag' => $arr['ik_payment_id'],
			'method' => $arr['ik_paysystem_alias'],
			'date' => $arr['ik_payment_timestamp'],
			'state' => $arr['ik_payment_state'],
			'batch' => $arr['ik_trans_id'],
			'hash' => $arr['ik_sign_hash']
			);
		$cc = implode(':', 
			array($arr['ik_shop_id'], $arr['ik_payment_amount'], $arr['ik_payment_id'], $arr['ik_paysystem_alias'], $arr['ik_baggage_fields'], $arr['ik_payment_state'], $arr['ik_trans_id'], $arr['ik_currency_exch'], $arr['ik_fees_payer'], $params2['key'])
			);
		$cc = strtoupper(md5($cc));
		$r['cc'] = $cc;
		$r['correct'] = (($cc == $r['hash']) and ($r['state'] == 'success'));
		return $r;
	case 'C4':
		$r = array(
			'accto' => $arr['MERCHANT_ID'],
			'accfrom' => $arr[''],
			'sum' => $arr['AMOUNT'],
			'sum2' => $arr['AMOUNT'],
			'tag' => $arr['MERCHANT_ORDER_ID'],
			'date' => time(),
			'batch' => 'C4B' . $arr['MERCHANT_ORDER_ID'],
			'hash' => $arr['SIGN']
		);
		$cc = md5(implode(':',
			array($r['accto'], $r['sum'], $params2['key2'], $r['tag'])
			));
		$r['cc'] = $cc;
		$r['correct'] = ($cc === $r['hash']);
		return $r;
	default:
		return array();
	}
}

// result: array(answer, result, sum);   sum < 0 - error
function getBalance($cid, $params) {
	include_once('lib/inet.php');
	$res = array('result' => 'NoConn', 'sum' => -1);
	$c = GetCIDs($cid);
	$uniqtag = time().rand(0, 1000);
	switch ($cid) {
	case 'LR':
		// Security Word:ID:Date UTC in YYYYMMDD format:Time UTC in HH format (only hours, not minutes).
		// MySecWord:20121227175937:20121227:17
		$token = implode(':', array($params['apipass'], $uniqtag, gmdate('Ymd:H')));
		$req =
			'id=' . $uniqtag .
			'&account=' . $params['acc'] .
			'&api=' . $params['apiname'] .
			'&token=' . hash('sha256', $token);
		$answ = inet_request('https://api2.libertyreserve.com/nvp/balance?' . $req);
		@parse_str($answ, $res);
		/*Array
		(
			[ID] => 1358274138323
			[TIMESTAMP] => 2013-01-15 18:22:13
			[STATUS] => Success
			[USD] => 0.0700
			[EURO] => 0.0000
			[GOLD] => 0.0000
		)*/
		$res['answer'] = $answ;
		if ($res['STATUS'] == 'Success')
		{
			$res['result'] = 'OK';
			$res['sum'] = $res['USD'];
		}
		else
			$res['result'] = $res['ERRORMESSAGE'];
		return $res;
	case 'LR0': 
		$req = hash('sha256', $params['apipass'].':'.gmdate('Ymd:H'));
		$req = '<Auth><ApiName>'.$params['apiname'].'</ApiName><Token>'.$req.'</Token></Auth>';
		$req = "<BalanceRequest id=\"$uniqtag\">$req<Balance>".
			'<CurrencyId>'.$c[4].'</CurrencyId>'.
			'<AccountId>'.$params['acc'].'</AccountId>'.
			'</Balance></BalanceRequest>';
		$answ = inet_request('https://api.libertyreserve.com/xml/balance.aspx?req='.urlencode($req));
		if (!$answ) return $res;
		$res['answer'] = $answ;
/*
<BalanceResponse id="1307901139" date="2011-12-06 17:52:21"><Error>
<Code>301</Code>
<Text>Invalid data format</Text>
<Description>CurrencyId element is empty or contains invalid data</Description>
</Error></BalanceResponse>
*/
		if (preg_match_all('|<Error><Code>(.*)</Code><Text>(.*)</Text><Description>(.*)</|U', $answ, $w, PREG_SET_ORDER)) {
			$res['result'] = $w[0][1].': '.$w[0][2];
			if ($w[0][3]) $res['result'] .= ' ('.$w[0][3].')';
			return $res;
		}
/*
<BalanceResponse id="1307903355" date="2011-12-06 18:29:18"><Balance>
<CurrencyId>LRUSD</CurrencyId>
<AccountId>U2762864</AccountId>
<Date>2011-12-06 18:29:18</Date>
<Value>16.0900</Value>
</Balance></BalanceResponse>
*/
		if (!preg_match_all('|<Balance><CurrencyId>(.*)</.*<Value>(.*)</|U', $answ, $w, PREG_SET_ORDER)) break;
		$res['result'] = 'OK';
		$res['sum'] = $w[0][2];
		return $res;
	case 'PM':
		$req = 'AccountID='.urlencode($params['id']).
			'&PassPhrase='.urlencode($params['apipass']);
		$answ = inet_request('https://perfectmoney.is/acct/balance.asp?'.$req);
		if (!$answ) return $res;
		$res['answer'] = $answ;
/*
<input name='ERROR' type='hidden' value='API is disabled for this IP (78.29.73.184)'>
*/
/*
<input name='U1471093' type='hidden' value='1.1'>
*/
		if (!preg_match_all("|<input name='(.*)' type='hidden' value='(.*)'>|", $answ, $w, PREG_SET_ORDER)) break;
		$a = array();
		foreach ($w as $i => $r) $a[$r[1]] = $r[2];
		if (!$a['ERROR']) {
			$res['result'] = 'OK';
			$res['sum'] = $a[$params['acc']];
		} else
			$res['result'] = $a['ERROR'];
		return $res;
	case 'PZ':
		$req = 'USER='.urlencode($params['acc']).'&PASSWORD='.urldecode($params['apipass']).'&CURRENCY='.$c[4];
		$answ = inet_request('https://api.payza.com/svc/api.svc/GetBalance', $req);
		if (!$answ) return $res;
		$res['answer'] = $answ;
		parse_str($answ, $w);
		if (!$w) break;
/*
RETURNCODE=224&DESCRIPTION=Cannot%20perform%20the%20request.%20USER%20account%20is%20not%20active.
*/
/*
AVAILABLEBALANCE_1=53.94&CURRENCY_1=USD
*/
		if ($n = array_search($c[4], $w)) {
			$res['result'] = 'OK';
			$res['sum'] = $w['AVAILABLEBALANCE_'.substr($n, -1)];
		} else
			$res['result'] = $w['RETURNCODE'].': '.$w['DESCRIPTION'];
		return $res;
	case 'EP':
		require_once 'lib/egopay/Api.php';
		require_once 'lib/egopay/EgoPayJsonApiAgent.php';
		$oAuth = new EgoPayAuth($params['apiname'], $params['apiid'], $params['apipass']);
		$oJsonApiAgent = new EgoPayJsonApiAgent($oAuth);
		try {
			$oResponse = $oJsonApiAgent->getBalance();
			if ($oResponse->status == 'ok')
				return array(
					'result' => 'OK',
					'sum' => round($oResponse->USD, 2)
				);
			return array(
				'result' => 'UnknError'
			);
		} catch (EgoPayApiException $e) {
			return array(
				'result' => $e->getCode() . ': ' . $e->getMessage()
			);
		}
	case 'LP':
		$oxml = 
			"<request>".
			"<version>1.2</version>".
			"<action>view_balance</action>".
			"<merchant_id>".$params['merchantid']."</merchant_id>".
			"</request>";
		$sign = base64_encode(sha1($params['key'].$oxml.$params['key'], 1));
		$req = 
			"<operation_xml>".base64_encode($oxml)."</operation_xml>".
			"<signature>$sign</signature>";
		$req =
			"<?xml version=\"1.0\" encoding=\"UTF-8\"?>".
			"<request><liqpay><operation_envelope>$req</operation_envelope></liqpay></request>";
		$answ = inet_request('https://www.liqpay.com/?do=api_xml', $req, '', '', false,
			array("Content-type: text/xml; charset=\"utf-8\""));
		if (!$answ) return $res;
		$res['answer'] = $answ;
/*
<?xml version="1.0" encoding="UTF-8"?>
...
<response>
  <action>view_balance</action>
  <balances>
    <EUR>0</EUR>
    <RUR>0.00</RUR>
    <UAH>0</UAH>
    <USD>7.05</USD>
  </balances>
  <merchant_id>ix..x</merchant_id>
  <status>success</status>
  <version>1.2</version>
</response>
----------------------------------------
<code>signature|</code>
<response_description> Incorrect incoming signature|</response_description>
<status>failure</status>
*/
		$oxml = base64_decode(parse_tag($answ, 'operation_xml'));
		$sign = base64_encode(sha1($params['key'].$oxml.$params['key'], 1));
		$sign2 = parse_tag($answ, 'signature'); // b64encoded
		if ($sign2 != $sign) break;
		$oxml = str_replace("\n", "", str_replace("\r", "", $oxml));
		if (parse_tag($oxml, 'status') == 'success') {
			$res['result'] = 'OK';
			$res['sum'] = parse_tag($oxml, $c[4]);
		} else
			$res['result'] = parse_tag($oxml, 'code').': '.parse_tag($oxml, 'response_description');
		return $res;
	case 'MR':
		$req = array(
			'MERA_SHOP' => $params['acc'],
			'ACTION' => 'balance',
			'MERA_HASH' => md5($params['acc'] . ':balance:' . $params['apipass'])
		);
		$answ = inet_request('https://api.merapay.com', $req);
//
		$res['answer'] = $answ;
		$res['result'] = trim($answ);
		if ($r = json_decode($answ, true))
			if (!$r['errornom'])
			{
				$res['result'] = 'OK';
				$res['sum'] = $r['amount'];
			}
			else
				$res['result'] = $r['errornom'] . ': ' . $r['error'];
		return $res;
	case 'PYE': 
	case 'PYR': 
	case 'PY':
		require_once('lib/payeer/cpayeer.php');
		$payeer = new CPayeer($params['acc'], $params['id'], $params['apipass']);
		if ($payeer->isAuth())
		{
			$res['answer'] = $payeer->getBalance();
			$res['result'] = $res['answer']['auth_error'];
			if (!$res['result'])
			{
				$res['result'] = 'OK';
				$res['sum'] = $res['answer']['balance'][$c[4]]['DOSTUPNO'];
			}
		}
		else
			$res['result'] = 'Auth Error';
		return $res;
	case 'AEX1':
	case 'AEX2': 
	case 'AEX3': 
	case 'AEX4': 
	case 'AEX5': 
	case 'AEX6': 
	case 'AEX7': 
	case 'AEX8': 
		$a = @json_decode($res['answer'] = inet_request($req =
			'https://api2-service.icu/api/1/user-balance/?nonce='.time2().
				'&akey='.$params['akey'].
				'&bkey='.$params['bkey'].
				'&skey='.$params['apipass']
		), 1);
//xaddtolog($req, 'aex');
		if ($a["status"] == "success")
		{
			$res['result'] = 'OK';
			$res['sum'] = $a['value'][$c[4]];
		}
		else
			$res['result'] = $a["msg"];
		return $res;
	case 'NXB': 
	case 'NXE': 
	case 'NXR': 
	case 'NX':
		$req = 'ACCOUNTID='.urlencode($params['id']).
			'&PASSPHRASE='.urlencode($params['apipass']);
		$answ = inet_request('https://www.nixmoney.com/balance?' . $req);
		if (!$answ) return $res;
		$res['answer'] = $answ;
/*
<input name='ERROR' type='hidden' value='Password mismatch'>
*/
/*
<input name='U12345678901234' type='hidden' value='100.43'>
*/
		if (!preg_match_all("|<input name='(.*)' type='hidden' value='(.*)'>|", $answ, $w, PREG_SET_ORDER)) break;
		$a = array();
		foreach ($w as $i => $r) $a[$r[1]] = $r[2];
		if (!$a['ERROR']) {
			$res['result'] = 'OK';
			$res['sum'] = $a[$params['acc']];
		} else
			$res['result'] = $a['ERROR'];
		return $res;
	case 'OKR': 
	case 'OK':
		try
		{
			$s = $params['apipass'] . ':' . gmdate("Ymd:H");
			$secToken = hash('sha256', $s);
			$secToken = strtoupper($secToken);
			$client = new SoapClient("https://api.okpay.com/OkPayAPI?wsdl");
			$obj->WalletID = $params['acc'];
			$obj->SecurityToken = $secToken;
			$obj->Currency = $c[4];
			$webService1 = $client->Wallet_Get_Currency_Balance($obj);
			$res['answer'] = $webService1->Wallet_Get_Currency_BalanceResult;
			$res['result'] = 'OK';
			$res['sum'] = $res['answer']->Amount;
		}
		catch (Exception $e)
		{
			$res['result'] = $e->getMessage();
		}
		return $res;
	case 'ACR': 
	case 'AC':
		require_once("lib/advcash/MerchantWebService.php");
		$merchantWebService = new MerchantWebService();
		$arg0 = new authDTO();
		$arg0->apiName = $params['api'];
		$arg0->accountEmail = $params['name'];
		$arg0->authenticationToken = $merchantWebService->getAuthenticationToken($params['apipass']);
		$getBalances = new getBalances();
		$getBalances->arg0 = $arg0;
		try {
			$getBalancesResponse = $merchantWebService->getBalances($getBalances);
			if ($res['answer'] = print_r($getBalancesResponse->return, 1))
				foreach ($getBalancesResponse->return as $r)
					if ($r->id == $params['acc'])
					{
						$res['result'] = 'OK';
						$res['sum'] = 0 + $r->amount;
					}
		} catch (Exception $e) {
			$res['result'] = $e->getMessage();
		}
		return $res;
	case 'HM':
		require_once('lib/helixmoney/paymentapi.class.php');
		$pay =  new PaymentApi;
		$pay->api_id = $params['api']; // ID  API 
		$pay->apikey = $params['apipass']; //  API  KEY
		$res['answer'] = $pay->balance();
		$res['result'] = $res['answer']['error'];
		if (!$res['result'])
		{
			$res['result'] = 'OK';
			$res['sum'] = $res['answer'][strtolower($c[4])];
		}
		return $res;
	case 'PP':
		$req = array(
			'acctNumber' => $params['acc'],
			'email' => $params['email'],
			'password' => base64_encode($params['apipass']),
			'securityPIN' => base64_encode($params['pinpass'])
		);
		$answ = inet_request('https://www.pexpay.com/api/balance.php', $req);
//
		$res['answer'] = $answ;
		$res['result'] = trim($answ);
		if (is_numeric($answ))
		{
			$res['result'] = 'OK';
			$res['sum'] = $answ;
		}
		return $res;
	case 'YM':
		require_once("lib/yandexmoney/api.php");
		$api = new YandexMoney\API($params['apipass']);
		$account_info = (array)$api->accountInfo();
		if (isset($account_info['balance']))
		{
			$res['result'] = 'OK';
			$res['sum'] = $account_info['balance'];
		}
		return $res;
	case 'BC':
		$req = 'password=' . urlencode($params['apipass']) . '&address=' . $params['acc'] . '&confirmations=0';
		$answ = inet_request('https://blockchain.info/ru/merchant/' . $params['guid'] . '/address_balance?' . $req);
		$res['answer'] = $answ;
		$answ = @json_decode($answ, true);
		if (is_array($answ))
		{
			$res['result'] = 'OK';
			$res['sum'] = $answ['balance'] / 100000000;
		}
		return $res;
	case 'IBC':
		$res['answ'] = inet_request($req = "https://block.io/api/v2/get_address_balance/?api_key=$params[apipass]");
		//xaddtolog($req, 'blockio');
		$answ = json_decode($res['answ'], 1);
		//xaddtolog($answ, 'blockio');
		if ($answ['status'] == 'success')
		{
			$res['result'] = 'OK';
			$res['sum'] = $answ['data']['available_balance'];
		}
		else
			$res['result'] = $answ['data']['error_message'];
		return $res;
	case 'CB':
		include_once('lib/coinbase/Init.php');
		try
		{
			$coinbase = Coinbase::withApiKey($params['apiword'], $params['apipass']);
			$answ = $coinbase->getBalance();
			$res['answer'] = $answ;
			$res['result'] = 'OK';
			$res['sum'] = $answ;
		}
		catch (Exception $e)
		{
			$res['result'] = $e->getMessage();
		}
		return $res;
	case 'CKE':
		include_once('lib/coinkite/requestor.php');
		try
		{
			$CK_API = new CKRequestor($params['apiword'], $params['apipass']);
			$answ = $CK_API->get_balance($params['acc']);
			if ($answ['balance_optimistic']['currency'] == 'BTC')
			{
				$res['result'] = 'OK';
				$res['sum'] = $answ['balance_optimistic']['decimal'];
			}
			else
				$res['result'] = serialize($answ);
		}
		catch (Exception $e)
		{
			$res['result'] = $e->getMessage();
		}
		return $res;
	case 'EA':
		$res['answ'] = inet_request($req = "https://etherapi.net/api?token=$params[apipass]&method=balance");
//xaddtolog($res['answ'], 'ea');
		$answ = json_decode($res['answ'], 1);
		if (is_array($answ) and isset($answ['result']))
		{
			$res['result'] = 'OK';
			$res['sum'] = $answ['result'];
		}
		else
			$res['result'] = $res['answ'];
		return $res;
	case 'EAT':
		$res['answ'] = inet_request($req = "https://etherapi.net/api/v2/.balance?key=$params[apipass]&token=$c[1]");
//xaddtolog($res['answ'], 'ea');
		$answ = json_decode($res['answ'], 1);
		if (is_array($answ) and isset($answ['result']))
		{
			$res['result'] = 'OK';
			$res['sum'] = $answ['result'];
		}
		else
			$res['result'] = $res['answ'];
		return $res;
	case 'CCAB':
	case 'CCAL':
		$res['answ'] = inet_request($req = "https://cryptocurrencyapi.net/api?token=$params[apipass]&currency=$c[4]&method=balance");
//xaddtolog($res['answ'], 'cca');
		$answ = json_decode($res['answ'], 1);
		if (is_array($answ) and isset($answ['result']))
		{
			$res['result'] = 'OK';
			$res['sum'] = $answ['result'];
		}
		else
			$res['result'] = $res['answ'];
		return $res;
	case 'XRPA':
		$res['answ'] = inet_request($req = "https://xrpapi.net/api/.balance?key=$params[apipass]");
xaddtolog($res['answ'], 'xrpa');
		$answ = json_decode($res['answ'], 1);
		if (is_array($answ) and isset($answ['result']))
		{
			$res['result'] = 'OK';
			$res['sum'] = $answ['result'];
		}
		else
			$res['result'] = $res['answ'];
		return $res;
	case 'CPL': 
	case 'CPE': 
	case 'CPR': 
	case 'CP':
		require_once('lib/cp/coinpayments.php');
		$cps = new CoinPaymentsAPI();
		$cps->Setup($params['apipass'], $params['publicpass']);
		$result = $cps->GetBalances();
		if ($result['error'] == 'ok')
		{
			$res['result'] = 'OK';
			$res['sum'] = $result['result'][$c[4]]['balancef'];
		}
		else
			$res['result'] = $result['error'];
		return $res;
	case 'PKAU':
	case 'PKAR':
	case 'PKPM':
	case 'PKPU':
	case 'PKPR':
	case 'PKB':
	case 'PKE':
	case 'PKL':
		$system_list = array(
			'PKAU' => 'advcash_usd',
			'PKAR' => 'advcash_rub',
			'PKPM' => 'perfectmoney_usd',
			'PKPU' => 'payeer_usd',
			'PKPR' => 'payeer_rub',
			'PKB'  => 'bitcoin_btc', // supported currency BTC
			'PKE'  => 'ethereum_eth', // supported currency ETH
			'PKL'  => 'litecoin_ltc', // supported currency LTC
		);

		require_once('lib/paykassa/paykassa_api.class.php');
		$paykassa = new PayKassaAPI(
			$params['id'],
			$params['apipass']
		);
		$res = $paykassa->api_get_shop_balance($params['shop_id']);
		$result = array();
		if ($res['error']) {
			$result['result'] = $res['message'];
		} else {
			$result['result'] = 'OK';
			$result['sum'] = $res['data'][$system_list[$cid]];
		}
		return $result;
	case 'EPCU':
	case 'EPCB':
	case 'EPCT':
		require_once('lib/inet.php');
		global $ch;
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		$answ = inet_request('https://wallet.epaycore.com/v1/api/balance', json_encode(array(
			'api_id' => $params['id'],
			'api_secret' => $params['apipass'],
			'account' => $params['acc']
		)));
//xaddtolog($answ);
		$answ = json_decode($answ, 1);
//xaddtolog($answ);
		if ($answ['error'])
			$res['error'] = $answ['error'];
		else
		{
			$res['result'] = 'OK';
			$res['sum'] = $answ['account']['balance'];
		}
		return $res;
	case 'QWA':
		require_once('lib/qiwia/class.Qiwi.php');
		$qiwi = new Qiwi($params['acc'], $params['apipass']);
		$answ = $qiwi->getBalance();
		$res['answer'] = $answ;
		if (is_array($answ) and isset($answ['RUB']))
		{
			$res['result'] = 'OK';
			$res['sum'] = $answ['RUB'];
		}
		return $res;
	case 'QG':
		require_once('lib/inet.php');
		$answ = @json_decode(inet_request(
			'https://qiwigate.ru/api' .
			'?key=' . $params['apipass'] .
			'&method=qiwi.get.balance'
		), 1);
		if ($answ['status'] != 'success')
			$res['error'] = $answ['message'];
		else
		{
			$res['result'] = 'OK';
			$res['sum'] = $answ['balance'][$c[4]];
		}
		return $res;
	default:
		$res['result'] = 'UnknPSys';
		return $res;
	}
	$res['result'] = 'UnknAnsw';
	return $res;
}

// result: array(answer, result, batch);   empty batch - error
function sendMoney($cid, $fromparams, $toparams, $sum, $memo = '', $uniqtag = 0, $urlproc = '') {
	include_once('lib/inet.php');
	$res = array('result' => 'NoConn');
	$c = GetCIDs($cid);
	if (($c[4] == 'USD') or ($c[4] == 'RUB') or ($c[4] == 'EUR'))
		$sum = round($sum, 2);
	if (!$uniqtag) 
		$uniqtag = time().rand(0, 1000);
	switch ($cid) {
	case 'LR':
		// Security Word:ID:Reference:Payee:Currency:Amount:Date UTC in YYYYMMDD format:Time UTC in HH format (only hours, not minutes).
		// MySecWord:20121227170733:Reference:U1234567:usd:10.00:20121227:17
		$token = implode(':', array($fromparams['apipass'], $uniqtag, '', urlencode($toparams['acc']), 'usd', $sum, gmdate('Ymd:H')));
		$req =
			'id=' . $uniqtag .
			'&account=' . $fromparams['acc'] .
			'&api=' . $fromparams['apiname'] .
			'&token=' . hash('sha256', $token) .
			'&reference=' .
			'&type=transfer' .
			'&payee=' . urlencode($toparams['acc']) .
			'&currency=usd' .
			'&amount=' . $sum .
			'&memo=' . urlencode(trim($memo)) .
			'&private=false' .
			'&purpose=service';
		$answ = inet_request('https://api2.libertyreserve.com/nvp/transfer?' . $req);
		@parse_str($answ, $res);
		$res['answer'] = $answ;
		if ($res['STATUS'] == 'Success')
		{
			$res['result'] = 'OK';
			$res['batch'] = $res['BATCH'];
		}
		else
			$res['result'] = $res['ERRORMESSAGE'];
		return $res;
	case 'LR0':
		$req = hash('sha256', $fromparams['apipass'].':'.gmdate('Ymd:H'));
		$req = '<Auth><ApiName>'.$fromparams['apiname'].'</ApiName><Token>'.$req.'</Token></Auth>';
		$req = "<TransferRequest id=\"$uniqtag\">$req<Transfer>".
			'<TransferId></TransferId>'.
			'<TransferType>transfer</TransferType>'.
			'<Payer>'.$fromparams['acc'].'</Payer>'.
			'<Payee>'.strip_tags($toparams['acc']).'</Payee>'.
			'<CurrencyId>'.$c[4].'</CurrencyId>'.
			'<Amount>'.$sum.'</Amount>'.
			'<Memo>'.strip_tags($memo).'</Memo>'.
			'<Anonymous>False</Anonymous>'.
			'</Transfer></TransferRequest>';
		$answ = inet_request('https://api.libertyreserve.com/xml/transfer.aspx?req='.urlencode($req));
		if (!$answ) return $res;
		$res['answer'] = $answ;
/*
<TransferResponse id="1308153643913" date="2011-15-06 16:00:43"><Error>
<Code>301</Code>
<Text>Invalid data format</Text>
<Description>Payee element is empty or contains invalid data</Description>
</Error></TransferResponse>
*/
		if (preg_match_all('|<Error><Code>(.*)</Code><Text>(.*)</Text><Description>(.*)</|U', $answ, $w, PREG_SET_ORDER)) {
			$res['result'] = $w[0][1].': '.$w[0][2];
			if ($w[0][3]) $res['result'] .= ' ('.$w[0][3].')';
			return $res;
		}
/*
<TransferResponse id="1308155366850" date="2011-15-06 16:29:26"><Receipt>
<ReceiptId>63417982</ReceiptId>
<Date>2011-15-06 16:29:26</Date>
<PayerName>InvestorJournal</PayerName>
<PayeeName>Klubnika</PayeeName>
<Amount>-0.0100</Amount>
<Fee>0.0000</Fee>
<ClosingBalance>16.0800</ClosingBalance>
<Transfer>
<TransferId></TransferId>
<TransferType>transfer</TransferType>
<Payer>U2762864</Payer>
<Payee>U4269374</Payee>
<CurrencyId>LRUSD</CurrencyId>
<Amount>0.0100</Amount>
<Memo>memotest</Memo>
<Anonymous>False</Anonymous>
<Source>API</Source>
</Transfer>
</Receipt></TransferResponse>
*/
		if (!preg_match_all('|<ReceiptId>(.*)</.*<PayeeName>(.*)</|U', $answ, $w, PREG_SET_ORDER)) break;
		$res['result'] = 'OK'; // .$w[0][2]
		$res['batch'] = $w[0][1];
		return $res;
	case 'PM':
		$req = 'AccountID='.urlencode($fromparams['id']).
			'&PassPhrase='.urlencode($fromparams['apipass']).
			'&Payer_Account='.urlencode($fromparams['acc']).
			'&Payee_Account='.urlencode($toparams['acc']).
			'&Amount='.$sum.
			'&Memo='.urlencode($memo);
		$answ = inet_request('https://perfectmoney.is/acct/confirm.asp?'.$req);
		if (!$answ) return $res;
		$res['answer'] = $answ;
/*
<input name='ERROR' type='hidden' value='API is disabled for this IP (78.29.73.184)'>
*/
/*
<input name='Payee_Account' type='hidden' value='U1710411'>
<input name='Payer_Account' type='hidden' value='U1471093'>
<input name='PAYMENT_AMOUNT' type='hidden' value='0.01'>
<input name='PAYMENT_BATCH_NUM' type='hidden' value='5629489'>
<input name='PAYMENT_ID' type='hidden' value=''>
*/
		if (!preg_match_all("|<input name='(.*)' type='hidden' value='(.*)'>|", $answ, $w, PREG_SET_ORDER)) break;
		$a = array();
		foreach ($w as $r) $a[$r[1]] = $r[2];
		if ($a['ERROR']) 
			$res['result'] = $a['ERROR'];
		else {
			$res['result'] = 'OK'; // .$a['Payee_Account']
			$res['batch'] = $a['PAYMENT_BATCH_NUM'];
		}
		return $res;
	case 'PZ':
		$req = 'USER='.urlencode($fromparams['acc']).'&PASSWORD='.urldecode($fromparams['apipass']).'&CURRENCY='.$c[4].
			'&AMOUNT='.$sum.'&RECEIVEREMAIL='.urlencode($toparams['acc']).'&NOTE='.urlencode($memo).'&PURCHASETYPE=0';
		$answ = inet_request('https://api.payza.com/svc/api.svc/sendmoney', $req);
		if (!$answ) return $res;
		$res['answer'] = $answ;
		parse_str($answ, $w);
		if (!$w) break;
/*
RETURNCODE=231&DESCRIPTION=Incomplete%20transaction.%20Amount%20to%20be%20sent%20must%20be%20positive%20and%20greater%20than%201.00.&REFERENCENUMBER=&TESTMODE=0
*/
/*
RETURNCODE=100&DESCRIPTION=Transaction%20was%20completed%20successfully&REFERENCENUMBER=D2976-3CE4F-0A2D4&TESTMODE=0
*/
		$res['result'] = $w['RETURNCODE'].': '.$w['DESCRIPTION'];
		$res['batch'] = $w['REFERENCENUMBER'];
		return $res;
	case 'EP':
		require_once 'lib/egopay/Api.php';
		require_once 'lib/egopay/EgoPayJsonApiAgent.php';
		$oAuth = new EgoPayAuth($fromparams['apiname'], $fromparams['apiid'], $fromparams['apipass']);
		$oJsonApiAgent = new EgoPayJsonApiAgent($oAuth);
		try {      
			$oResponse = $oJsonApiAgent->getTransfer(
				$toparams['acc'],
				$sum,
				$c[4],
				$memo
			);
			if ($oResponse->status == 'ok')
				return array(
					'result' => 'OK',
					'batch' => $oResponse->transaction->sId
				);
			return array(
				'result' => 'UnknError'
			);
		} catch (EgoPayApiException $e) {
			return array(
				'result' => $e->getCode() . ': ' . $e->getMessage()
			);
		}
	case 'LP':
		$oxml = 
			"<request>".
			"<version>1.2</version>".
			"<action>send_money</action>".
			"<kind>phone</kind>". // phone/card/account
			"<merchant_id>".$fromparams['merchantid']."</merchant_id>".
			"<order_id>$uniqtag</order_id>".
			"<to>".$toparams['acc']."</to>".
			"<amount>$sum</amount>".
			"<currency>".$c[4]."</currency>".
			"<description>".strip_tags($memo)."</description>".
			"</request>";
		$sign = base64_encode(sha1($fromparams['apipass'].$oxml.$fromparams['apipass'], 1));
		$req = 
			"<operation_xml>".base64_encode($oxml)."</operation_xml>".
			"<signature>$sign</signature>";
		$req =
			"<?xml version=\"1.0\" encoding=\"UTF-8\"?>".
			"<request><liqpay><operation_envelope>$req</operation_envelope></liqpay></request>";
		$answ = inet_request('https://www.liqpay.com/?do=api_xml', $req, '', '', false,
			array("Content-type: text/xml; charset=\"utf-8\""));
		if (!$answ) return $res;
		$res['answer'] = $answ;
		$oxml = base64_decode(parse_tag($answ, 'operation_xml'));
		$sign = base64_encode(sha1($fromparams['apipass'].$oxml.$fromparams['apipass'], 1));
		$sign2 = parse_tag($answ, 'signature'); // b64encoded
		if ($sign2 != $sign) break;
		$oxml = str_replace("\n", "", str_replace("\r", "", $oxml));
/*
<response>
    <status>failure</status> 
    <code>add</code>
    <response_description> add your IP in your Shop Settings vkluchite api na stranice dostupa i ogranicheniya signature_error wrong_to_phone</response_description>
    <transaction_id></transaction_id>
</response>
*/
		if (parse_tag($oxml, 'status') == 'success') {
			$res['result'] = 'OK';
			$res['batch'] = parse_tag($oxml, 'transaction_id');
		} else
			$res['result'] = parse_tag($oxml, 'code').': '.parse_tag($oxml, 'response_description');
		return $res;
	case 'STP':
		$req =
			'api_id=' . $fromparams['apiname'] .
			'&api_pwd=' . md5($fromparams['apipass'] . 's+E_a*') .
			'&user=' . urlencode($toparams['acc']) .
			'&amount=' . $sum .
			'&currency=' . $c[4] .
			'&item_id=' . urlencode(trim($memo));
		$answ = inet_request('https://solidtrustpay.com/accapi/process.php', $req);
//Transaction ID = 000-Tapi_TestStatus is ACCEPTED
		$res['answer'] = $answ;
		if (preg_match('|Transaction ID = (\d*).*Status is ACCEPTED|s', $answ, $w))
		{
			$res['result'] = 'OK';
			$res['batch'] = $w[1];
		}
		else
			$res['result'] = trim($answ);
		return $res;
	case 'MR':
		$req = array(
			'MERA_SHOP' => $fromparams['acc'],
			'ACTION' => 'sendmera',
			'MERA_PAYEE' => $toparams['acc'],
			'MERA_AMOUNT' => $sum,
			'MERA_COMMENT' => $memo,
			'MERA_HASH' => md5($fromparams['acc'] . ':sendmera:'  . $toparams['acc'] . ':' . $sum . ':' . $memo . ':' . $fromparams['apipass'])
		);
		$answ = inet_request('https://api.merapay.com', $req);
//
		$res['answer'] = $answ;
		$res['result'] = trim($answ);
		if ($r = json_decode($answ, true))
			if (!$r['errornom'])
			{
				$res['result'] = 'OK';
				$res['batch'] = $r['transaction_id'];
			}
			else
				$res['result'] = $r['errornom'] . ': ' . $r['error'];
		return $res;
	case 'PYE': 
	case 'PYR': 
	case 'PY':
		require_once('lib/payeer/cpayeer.php');
		$payeer = new CPayeer($fromparams['acc'], $fromparams['id'], $fromparams['apipass']);
		if ($payeer->isAuth())
		{
			$res['answer'] = $payeer->transfer(array(
				'curIn' => $c[4],
				'sum' => $sum,
				'curOut' => $c[4],
				'to' => $toparams['acc'],
				'comment' => $memo
			));
			if ($res['batch'] = $res['answer']['historyId'])
				$res['result'] = 'OK';
			else
				$res['result'] = $res['answer']['errors'][0];
		}
		else
			$res['result'] = 'Auth Error';
		return $res;
	case 'AEX1':
	case 'AEX2': 
	case 'AEX3': 
	case 'AEX4': 
	case 'AEX5': 
	case 'AEX6': 
	case 'AEX7': 
	case 'AEX8': 
		require_once('lib/inet.php');
		global $ch;
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		$pc = array(
			'RUB' => 172,
			'USD' => 173,
			'BTC' => 174
		);
		$pa = array(
			15 => array(), // YM
			9 => array(), // Qiwi
			109 => array(), // Card
			12 => array(), // BTC
			42 => array(), // ETH
			28 => array(), // AdvUSD
			57 => array(), // AdvRUR
		);
//xaddtolog(1, 'aex');
		$a = @json_decode(inet_request(
			'https://api2-service.icu/api/1/order-props-get/?nonce='.(time2()+0).
				'&akey='.$fromparams['akey'].
				'&bkey='.$fromparams['bkey'].
				'&skey='.$fromparams['apipass'].
				'&psid1='.$pc[$c[1]].
				'&psid2='.$fromparams['pscode']
		), 1);
//xaddtolog($a, 'aex');
		if ($a["status"] != "success")
			return array('result' => $a["msg"]);
		global $_user;
		$props = array();
		$props[] = array(
			'name' => 'email',
			'value' => $fromparams['email']
		);
		$props[] = array(
			'name' => 'to_acc',
			'value' => $toparams['acc']
		);
//xaddtolog(2, 'aex');
		$a = @json_decode($c = inet_request(
			'https://api2-service.icu/api/1/order-create/?bkey='.$fromparams['bkey'],
				json_encode($b = array(
					'nonce'=>(time2() + 1),
					'akey'=>$fromparams['akey'],
					'skey'=>$fromparams['apipass'],
					'Order'=>array(
						'psid1'=>$pc[$c[1]],
						'psid2'=>$fromparams['pscode'],
						'in'=>1,
						'out'=>$sum,
						"agreement"=>"yes",
						'direct' => 1,
						'props'=>$props
					)
				))
			), 1);
//xaddtolog($b, 'aex');
//xaddtolog($c, 'aex');
//xaddtolog($a, 'aex');
		if ($a["status"] != "success")
			return array('result' => $a["msg"]);
		$orderid = $a['value']['id'];
		$a = @json_decode(inet_request(
			'https://api2-service.icu/api/1/order-confirm/?nonce='.(time2()+2).
				'&akey='.$fromparams['akey'].
				'&bkey='.$fromparams['bkey'].
				'&skey='.$fromparams['apipass'].
				'&order_id='.$orderid
		), 1);
//xaddtolog($a, 'aex');
		if ($a["status"] == "success")
		{
			$res['batch'] = $orderid;
			$res['result'] = 'OK';
		}
		else
			$res['result'] = $a['msg'];
		return $res;
	case 'NXB': 
	case 'NXE': 
	case 'NXR': 
	case 'NX':
		$req = 
			'PASSPHRASE=' . urlencode($fromparams['apipass']) .
			'&PAYER_ACCOUNT=' . urlencode($fromparams['acc']) .
			'&PAYEE_ACCOUNT=' . urlencode($toparams['acc']) .
			'&AMOUNT=' . $sum .
			'&MEMO=' . urlencode($memo);
		$answ = inet_request('https://www.nixmoney.com/send?' . $req);
		if (!$answ) return $res;
		$res['answer'] = $answ;
/*
<input name='ERROR' type='hidden' value='API is disabled for this IP (...)'>
*/
/*
<input name='Payee_Account' type='hidden' value='U1710411'>
<input name='Payer_Account' type='hidden' value='U1471093'>
<input name='PAYMENT_AMOUNT' type='hidden' value='0.01'>
<input name='PAYMENT_BATCH_NUM' type='hidden' value='5629489'>
<input name='PAYMENT_ID' type='hidden' value=''>
*/
		if (!preg_match_all("|<input name='(.*)' type='hidden' value='(.*)'>|", $answ, $w, PREG_SET_ORDER)) break;
		$a = array();
		foreach ($w as $r) $a[$r[1]] = $r[2];
		if ($a['ERROR']) 
			$res['result'] = $a['ERROR'];
		else {
			$res['result'] = 'OK'; // .$a['Payee_Account']
			$res['batch'] = $a['PAYMENT_BATCH_NUM'];
		}
		return $res;
	case 'OKR': 
	case 'OK':
		try
		{
			$s = $fromparams['apipass'] . ':' . gmdate("Ymd:H");
			$secToken = hash('sha256', $s);
			$secToken = strtoupper($secToken);
			$client = new SoapClient("https://api.okpay.com/OkPayAPI?wsdl");
			$obj->WalletID = $fromparams['acc'];
			$obj->SecurityToken = $secToken;
			$obj->Currency = $c[4];
			$obj->Receiver = $toparams['acc'];
			$obj->Amount = $sum;
			$obj->Comment = $memo;
			$obj->IsReceiverPaysFees = false;
//			$obj->Invoice = md5($memo);
			$webService1 = $client->Send_Money($obj);
			$res['answer'] = $webService1->Send_MoneyResult;			
			if ($res['batch'] = $res['answer']->ID)
				$res['result'] = 'OK';
			else
				$res['result'] = $res['answer']->Status;
		}
		catch (Exception $e)
		{
			$res['result'] = $e->getMessage();
		}
		return $res;
	case 'ACR': 
	case 'AC':
		require_once("lib/advcash/MerchantWebService.php");
		$merchantWebService = new MerchantWebService();
		$arg0 = new authDTO();
		$arg0->apiName = $fromparams['api'];
		$arg0->accountEmail = $fromparams['name'];
		$arg0->authenticationToken = $merchantWebService->getAuthenticationToken($fromparams['apipass']);
		$arg1 = new sendMoneyRequest();
		$arg1->amount = $sum;
		$arg1->currency = $c[4];
		$arg1->email = $toparams['acc'];
		$arg1->note = $memo;
		$arg1->savePaymentTemplate = false;
		$validationSendMoney = new validationSendMoney();
		$validationSendMoney->arg0 = $arg0;
		$validationSendMoney->arg1 = $arg1;
		$sendMoney = new sendMoney();
		$sendMoney->arg0 = $arg0;
		$sendMoney->arg1 = $arg1;
		try {
			$merchantWebService->validationSendMoney($validationSendMoney);
			$sendMoneyResponse = $merchantWebService->sendMoney($sendMoney);
			if ($res['batch'] = strval($sendMoneyResponse->return))
				$res['result'] = 'OK';
			else
				$res['result'] = strval($sendMoneyResponse->return);
		} catch (Exception $e) {
			$res['result'] = $e->getMessage();
		}
		return $res;
	case 'HM':
		require_once('lib/helixmoney/paymentapi.class.php');
		$pay = new PaymentApi;
		$pay->api_id = $fromparams['api']; // ID  API 
		$pay->apikey = $fromparams['apipass']; //  API  KEY
		$res['answer'] = $pay->transfer('+' . $toparams['acc'], $sum, $c[4], $memo);
		$res['result'] = $res['answer']['error'];
		if (!$res['result'])
		{
			$res['batch'] = exValue('HM' . substr(strtoupper(md5(uniqid(microtime()))), -8), $res['id']);
			$res['result'] = 'OK';
		}
		return $res;
	case 'PP':
		$req = array(
			'acctNumber' => $fromparams['acc'],
			'email' => $fromparams['email'],
			'password' => base64_encode($fromparams['apipass']),
			'securityPIN' => base64_encode($fromparams['pinpass']),
			'payList' => $toparams['acc'] . ';' . $sum . ';;' . $memo . ';',
			'notifyURL' => $urlproc
		);
/*
TrID: XXX - The payment was made successfully, and the XXX will be the transaction ID number 
as you would see it in your account history. One will be sent for each transaction, in the same order
*/
		$answ = inet_request('https://www.pexpay.com/autopay/makepayments.php', $req);
//
		$res['answer'] = $answ;
		$res['result'] = trim($answ);
		return $res;
	case 'PC':
		$myhash = strtoupper(hash('sha512', $fromparams['acc'] . '+' . $fromparams['apipass']));
		$req = array(
			'hash' => $myhash,
			'name' => $fromparams['acc'],
			'to' => $toparams['acc'],
			'amount' => $sum
		);
		$answ = inet_request('https://piratcoin.me/api/send/', $req);
//
		$res['answer'] = $answ;
		if ($answ == 'Success')
		{
			$res['result'] = 'OK';
			$res['batch'] = 'PC' . substr(strtoupper(md5(uniqid(microtime()))), -8); // ???
		}
		else
			$res['result'] = trim($answ);
		return $res;
	case 'YM':
		require_once("lib/yandexmoney/api.php");
		$api = new YandexMoney\API($fromparams['apipass']);
		$request_payment = $api->requestPayment(array(
			"pattern_id" => "p2p",
			"to" => $toparams['acc'],
			"amount_due" => $sum,
			"comment" => $memo,
			"message" => $memo
		));
		xaddtolog($request_payment, 'YD');
		$process_payment = $api->processPayment(array(
			"request_id" => $request_payment->request_id,
		));
		xaddtolog($process_payment, 'YD');
		if (($process_payment->status == 'success') and ($batch = $process_payment->payment_id))
		{
			$res['result'] = 'OK';
			$res['batch'] = $batch;
		}
		else
			$res['result'] = serialize($process_payment);
		return $res;
	case 'BC':
		if (!preg_match('|[1-9A-Za-z]{27,34}|', $toparams['acc']))
			return $res;
		$req = 'password=' . urlencode($fromparams['apipass']) . '&second_password=' . urlencode($fromparams['secondpass']) . 
			'&from=' . $fromparams['acc'] . '&to=' . $toparams['acc'] . 
			'&amount=' . round($sum * 100000000) . '&note=' . urlencode($memo) . '&shared=' . valueIf($fromparams['shared'], 'true', 'false');
		$answ = inet_request('https://blockchain.info/ru/merchant/' . $fromparams['guid'] . '/payment?' . $req);
		$res['answer'] = $answ;
		$answ = @json_decode($answ, true);
		if (is_array($answ))
		{
			if ($answ['tx_hash'])
			{
				$res['result'] = 'OK';
				$res['batch'] = $answ['tx_hash'];
			}
			else
				$res['result'] = $answ->error;
		}
		return $res;
    case 'IBC':
            if (!preg_match('|[1-9A-Za-z]{27,34}|', $toparams['acc']))
                return $res;
            require_once 'lib/blockio/block_io.php';
            $apiKey = $fromparams['apipass'];
            $pin = $fromparams['secondpass'];
            $version = 2; // the API version
            $block_io = new BlockIo($apiKey, $pin, $version);
            try {
                $withdrawInfo = $block_io->withdraw(array('to_address' => $toparams['acc'], 'amount' => $sum));
                //xaddtolog( $withdrawInfo->status. "\n",'blockio');
                if ($withdrawInfo->status == 'success')
                {
                    $res['result'] = 'OK';
                    $res['batch'] = $withdrawInfo->data->txid;
                }
                else
                    $res['result'] = $withdrawInfo->data->error_message;
            } catch (Exception $e) {
                $res['result'] =$e->getMessage();
               // xaddtolog( $res['result']. "\n",'blockio');
            }
            return $res;
	case 'CB':
		if (!preg_match('|[1-9A-Za-z]{27,34}|', $toparams['acc']))
			return $res;
		include_once('lib/coinbase/Init.php');
		try
		{
			$coinbase = Coinbase::withApiKey($fromparams['apiword'], $fromparams['apipass']);
			$answ = $coinbase->sendMoney($toparams['acc'], round($sum, 8), $memo);
			$res['answer'] = $answ;
			if ($answ->success)
			{
				$res['result'] = 'OK';
				$res['batch'] = $answ->transaction->id;
			}
		}
		catch (Exception $e)
		{
			$res['result'] = $e->getMessage();
		}
		return $res;
	case 'CKE':
		if (!preg_match('|[1-9A-Za-z]{27,34}|', $toparams['acc']))
			return $res;
		include_once('lib/coinkite/requestor.php');
		try
		{
			$CK_API = new CKRequestor($fromparams['apiword'], $fromparams['apipass']);
			$ck_send = $CK_API->put('/v1/new/send', array(
				'account' => $fromparams['acc'],
				'amount' => $sum,
				'dest' => $toparams['acc'],
				'memo' => $memo
			));
			$ck_auth = $CK_API->put($ck_send['next_step']);
			$res['result'] = 'OK';
			$res['batch'] = 'CKE' . substr(strtoupper(md5(uniqid(microtime()))), -8);
		}
		catch (CKException $e)
		{
			$res['result'] = $e->printMessage();
		}
		return $res;
	case 'EA':
		$res['answ'] = inet_request($req = "https://etherapi.net/api?token=$fromparams[apipass]&method=send&" .
			"address=$toparams[acc]&amount=$sum&fee=medium&tag=$uniqtag&statusURL=" . urlencode($urlproc));
//xaddtolog($res['answ'], 'ea');
		$answ = json_decode($res['answ'], 1);
		if ($answ['result'])
		{
			$res['result'] = 'OK';
			$res['batch'] = '?' . $answ['result'];
		}
		else
			$res['result'] = $answ['error'];
		return $res;
	case 'EAT':
		$res['answ'] = inet_request($req = "https://etherapi.net/api/v2/.send?key=$fromparams[apipass]&token=$c[1]&" .
			"address=$toparams[acc]&amount=$sum&fee=medium&tag=$uniqtag&statusURL=" . urlencode($urlproc));
//xaddtolog($res['answ'], 'ea');
		$answ = json_decode($res['answ'], 1);
		if ($answ['result'])
		{
			$res['result'] = 'OK';
			$res['batch'] = '?' . $answ['result'];
		}
		else
			$res['result'] = $answ['error'];
		return $res;
	case 'CCAB':
	case 'CCAL':
		$res['answ'] = inet_request($req = "https://cryptocurrencyapi.net/api?token=$fromparams[apipass]&currency=$c[4]&method=send&" .
			"address=" . urlencode($toparams['acc']) .
			"&amount=$sum&fee=medium&tag=$uniqtag&statusURL=" . urlencode($urlproc)/* . "&memo=" . urlencode($memo)*/);
//xaddtolog($res['answ'], 'cca');
		$answ = json_decode($res['answ'], 1);
		if ($answ['result'])
		{
			$res['result'] = 'OK';
			$res['batch'] = '?pending' . $answ['result'];
		}
		else
			$res['result'] = $answ['error'];
		return $res;
	case 'XRPA':
		$res['answ'] = inet_request($req = "https://xrpapi.net/api/.send?key=$fromparams[apipass]&" .
			"address=" . urlencode($toparams['acc']) . '&tag=' . $toparams['tag'] .
			"&amount=$sum&label=$uniqtag&statusURL=" . urlencode($urlproc)/* . "&memo=" . urlencode($memo)*/);
xaddtolog($res['answ'], 'arpa');
		$answ = json_decode($res['answ'], 1);
		if ($answ['result'])
		{
			$res['result'] = 'OK';
			$res['batch'] = '?pending' . $answ['result'];
		}
		else
			$res['result'] = $answ['error'];
		return $res;
	case 'CP':
		if (!preg_match('|[1-9A-Za-z]{27,34}|', $toparams['acc']))
			return $res;
	case 'CPL': 
	case 'CPE': 
	case 'CPR': 
		require_once('lib/cp/coinpayments.php');
		$cps = new CoinPaymentsAPI();
		$cps->Setup($fromparams['apipass'], $fromparams['publicpass']);
		$result = $cps->CreateWithdrawal($sum, $c[4], $toparams['acc'], true, $toparams['tag']);
//xaddtolog($result, 'cp');
		if ($result['error'] == 'ok')
		{
			$res['result'] = 'OK';
			$res['batch'] = $result['result']['id'];
		}
		else
			$res['result'] = $result['error'];
		return $res;
	case 'PKAU':
	case 'PKAR':
	case 'PKPM':
	case 'PKPU':
	case 'PKPR':
	case 'PKB':
	case 'PKE':
	case 'PKL':
		$system_id = array(
			'PKAU' => 4,
			'PKAR' => 4,
			'PKPM' => 2,
			'PKPU' => 1,
			'PKPR' => 1,
			'PKB'  => 11, // supported currency BTC
			'PKE'  => 12, // supported currency ETH
			'PKL'  => 14, // supported currency LTC
		);

		require_once('lib/paykassa/paykassa_api.class.php');
		$paykassa = new PayKassaAPI(
			$fromparams['id'],
			$fromparams['apipass']
		);
		$res = $paykassa->api_payment(
			$fromparams['shop_id'],  // обязательный параметр, id магазина с которого нужно сделать выплату
			$system_id[$cid],    // обязательный параметр, id платежного метода
			$toparams['acc'],                // обязательный параметр, номер кошелька на который отправляем деньги
			(float)$sum,         // обязательный параметр, сумма платежа, сколько отправить
			$c[4],              // обязательный параметр, валюта платежа
			$toparams['tag']                // обязательный параметр, комметнарий к платежу, можно передать пустой
		);

		$result = array();
		if ($res['error']) {
			$result['result'] = $res['message'];
		} else {
			$result['result'] = 'OK';
			$result['batch'] = $res['data']['transaction'];
		}
		return $result;
	case 'EPCU':
	case 'EPCB':
	case 'EPCT':
		require_once('lib/inet.php');
		global $ch;
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		$answ = inet_request('https://wallet.epaycore.com/v1/api/transfer', json_encode(array(
			'api_id' => $fromparams['id'],
			'api_secret' => $fromparams['apipass'],
			'src_account' => $fromparams['acc'],
			'dst_account' => $toparams['acc'],
			'amount' => $sum,
			'descr' => $memo,
			'payment_id' => $uniqtag
		)));
//xaddtolog($answ);
		$answ = json_decode($answ, 1);
//xaddtolog($answ);
		if ($answ['error'])
			$res['error'] = $answ['error'];
		elseif (!$answ['batch'])
			$res['error'] = print_r($answ, 1);
		else
		{
			$res['result'] = 'OK';
			$res['batch'] = $answ['batch'];
		}
		return $res;
	case 'C4P':
		$fromAccount = $fromparams['acc'];
		$toAccount = $toparams['acc'];
		$value = $sum;
		$transactionId = $uniqtag;
		$dataForSign = $fromAccount.$toAccount.sprintf("%.02F", $value).$transactionId;

		$privateKeyPath = 'lib/cash4pay/' . $fromparams['apipass'] . '-private.pem';
		$privateKey = openssl_pkey_get_private("file://$privateKeyPath");
		openssl_sign($dataForSign, $sign, $privateKey, 'sha512');
		$sign = base64_encode($sign);
		openssl_free_key($privateKey);

		$url = "https://cash4pay.co/payment/exchange";
		$data = array(
			"toAccount" => (string)$toAccount,
			"fromAccount" => (string)$fromAccount,
			"value" => 0+$value,
			"transactionId" => (string)$transactionId,
			"sign" => $sign
		);

		require_once('lib/inet.php');
		global $ch;
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		$result = inet_request($url, json_encode($data));
//xaddtolog("result: *$result*", 'c4p2');
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//xaddtolog("http_status: *$http_status*", 'c4p2');
		if ($result and ($http_status == 200))
		{
//$result = json_decode($result, true);
			$res['result'] = 'OK';
			$res['batch'] = $uniqtag;
		}
		else
			$res['error'] = 'Error';
		return $res;
	case 'QWA':
		require_once('lib/qiwia/class.Qiwi.php');
		$qiwi = new Qiwi($fromparams['acc'], $fromparams['apipass']);
		$answ = $qiwi->sendMoney($toparams['acc'], $sum, $c[4], $memo);
		$res['answer'] = $answ;
		if (is_array($answ))
		{
			if ($answ['batch'])
			{
				$res['result'] = 'OK';
				$res['batch'] = $answ['batch'];
			}
			else
				$res['error'] = $answ['error'];
		}
		else
			$res['error'] = $answ;
		return $res;
	case 'QG':
		require_once('lib/inet.php');
		$answ = @json_decode(inet_request(
			'https://qiwigate.ru/api' .
			'?key=' . $fromparams['apipass'] .
			'&method=qiwi.send.money' .
			'&phone=' . $toparams['acc'] .
			'&sum=' . $sum .
			'&account=' . $c[4] .
			'&currency=' . $c[4]
		), 1);
		if ($answ['status'] != 'success')
			$res['error'] = $answ['message'];
		elseif ($answ['tx'])
		{
			$res['result'] = 'OK';
			$res['batch'] = $answ['tx'];
		}
		return $res;
	default:
		$res['result'] = 'UnknPSys';
		return $res;
	}
	$res['result'] = 'UnknAnsw';
	return $res;
}

function chkTrans($cid, &$arr, $params2) {
	include_once('libs/inet.php');
	$c = GetCIDs($cid);
	switch ($cid) {
	case 'LR': 
		break;
	}
	return true;
}

function parse_tag($resp, $tag) {
	$tag1 = '<'.$tag.'>';
	$tag2 = '</'.$tag;
	$start = strpos($resp, $tag1) + strlen($tag1);
	$end = strpos($resp, $tag2, $start);
	return substr($resp, $start, ($end - $start));
}

function psysOnCron($psys)
{
	global $db, $_cfg;
	$c = $db->fetch1Row($db->select('Currs', '*', 'cDisabled=0 and cCID=?', array($psys)));
	if (!$c)
		return;
	opDecodeCurrParams($c, $p, $p_sci, $p_api);
	switch ($psys)
	{
	case 'QWA':
		require_once('lib/qiwia/class.Qiwi.php');
		$qiwi = new Qiwi($p_sci['acc'], $p_sci['apipass']);
		$h = $qiwi->getIncomeHistory(1);
		if (is_array($h))
			foreach ($h as $p)
			if (preg_match('|.*\#(\d+)|', $p['memo'], $w)) // chpu
			{
				/*
				[time] => 1455908305
				[from] => +380939236607
				[from_prov] => Visa QIWI Wallet
				[type] => income
				[sum] => 8316.01
				[curr] => RUB
				[comis] => 
				[memo] => 
				[state] => success
				[batch] => 1455911654
				*/
				if ($p['curr'] == 'USD')
				{
					$p['sum'] = round($p['sum'] / $_cfg['Bal_RateRUB'], 2);
					$p['curr'] = 'RUB';
				}
				if ($p['curr'] == 'RUB')
				{
					$r = array(
						'accfrom' => $p['from'],
						'sum' => $p['sum'],
						'sum2' => $p['sum'],
						'curr' => $p['curr'],
						'tag' => $w[1],
						'date' => $p['time'],
						'batch' => $p['batch'],
						'correct' => true
					);
					if (!$db->count('Opers', 'ocID=?d and oOper=? and oBatch=? and oState=3', array($c['cID'], 'CASHIN', $r['batch'])))
						if ($db->count('Opers', 'oID=?d and ocID=?d and oOper=? and oState<3', array($w[1], $c['cID'], 'CASHIN')))
						{
							$r['cid'] = $c['cID'];
							$r['acc'] = $res['accfrom'];
							if ((($res = opOperConfirm(-1, $w[1], $r, false)) !== true) or 
								(($res = opOperComplete(-1, $w[1])) !== true))
									sendMailToAdmin('AddFundsError2', array(
										'oid' => $w[1],
										'error' => $r
										)
									);
						}
				}
			}
		break;
	case 'QG':
		require_once('lib/inet.php');
		$d0 = gmmktime(0, 0, 0);
		$answ = @json_decode(inet_request(
			'https://qiwigate.ru/api' .
			'?key=' . $fromparams['apipass'] .
			'&method=qiwi.get.history' .
			'&start=' . gmdate('d.m.Y', $d0 - HS2_UNIX_DAY) .
			'&finish=' . gmdate('d.m.Y', $d0 + HS2_UNIX_DAY) .
			'&status=SUCCESS' .
			'&currency=qiwi_RUB' .
			'&type=in'
		), 1);
		if ($answ['status'] != 'success')
			break;
		if (is_array($h = $answ['history']))
			foreach ($h as $p)
			if (preg_match('|.*\#(\d+)|', $p['comment'], $w))
			{
				/*
					[status] => success
					[history] => Array
						(
							[0] => Array
								(
									[tx] => 1500617359121
									[status] => SUCCESS
									[date] => 22.07.2017
									[time] => 04:36:11
									[cash] => 5 882,46руб.
									[orig] => 5 882,46руб.
									[provider] => VisaQIWIWallet
									[opnum] => +79*********
									[comment] => 
								)
				*/
				if (substr($p['orig'], -4) == 'руб.')
				{
					$z = substr($p['orig'], 0, -4);
					cn($z);
					$r = array(
						'accfrom' => $p['opnum'],
						'sum' => $z,
						'sum2' => $z,
						'curr' => 'RUB',
						'tag' => $w[1],
						'date' => time(),
						'batch' => $p['tx'],
						'correct' => true
					);
					if (!$db->count('Opers', 'ocID=?d and oOper=? and oBatch=? and oState=3', array($c['cID'], 'CASHIN', $r['batch'])))
						if ($db->count('Opers', 'oID=?d and ocID=?d and oOper=? and oState<3', array($w[1], $c['cID'], 'CASHIN')))
						{
							$r['cid'] = $c['cID'];
							$r['acc'] = $res['accfrom'];
							if ((($res = opOperConfirm(-1, $w[1], $r, false)) !== true) or 
								(($res = opOperComplete(-1, $w[1])) !== true))
									sendMailToAdmin('AddFundsError2', array(
										'oid' => $w[1],
										'error' => $r
										)
									);
						}
				}
			}
		break;
	}
	if ($res = getBalance($psys, $p_api))
		if ($res['result'] == 'OK')
		{
			$db->update('Currs', array('cBal' => $res['sum'], 'cBalTS' => timeToStamp()), '', 'cCID=?', array($psys));
			$c['cBal'] = $res['sum'];
			if (($c['cBalMin'] > 0) and ($c['cBal'] < $c['cBalMin']))
				sendMailToAdmin('WalletBalanceLow', $c);
		}
}
		
?>
