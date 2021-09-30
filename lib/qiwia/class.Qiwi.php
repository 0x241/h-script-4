<?php

class Qiwi {

	private $login, $pass, $tgt, $st;
	
	private $curl;
	public $error;
	
	public function __construct($login, $pass)
	{
		$this->login = $login;
		$this->pass = $pass;
		
		$this->init();
	}
		
	private function init()
	{
		$this->curl = curl_init();
		curl_setopt_array($this->curl, array(
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_TIMEOUT => 20,
			//CURLOPT_FORBID_REUSE => true,
			//CURLOPT_FRESH_CONNECT => true,
			CURLOPT_SSL_VERIFYPEER => false,
			//CURLOPT_SSL_VERIFYHOST => 2,
			CURLOPT_COOKIESESSION => true,
			CURLOPT_COOKIEFILE => 'cookies.dat',
			CURLOPT_COOKIEJAR => 'cookies.dat',
			CURLOPT_USERAGENT => 'User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36',
			//CURLOPT_FAILONERROR => true,
			CURLOPT_HEADER => false,
			CURLOPT_RETURNTRANSFER => true
		));
		@curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
		@curl_setopt($this->curl, CURLOPT_MAXREDIRS, 3);
		//@curl_setopt($this->curl, CURLOPT_AUTOREFERER, true);
		
		$this->error = 0;
	}
	
	private function exec()
	{
		$this->error = 0;
		$answ = curl_exec($this->curl);
		if (curl_errno($this->curl))
				$this->error = curl_error($this->curl);
		return $answ;
	}

	private function get($url)
	{
		curl_setopt($this->curl, CURLOPT_URL, trim($url));
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($this->curl, CURLOPT_HTTPGET, true);
		return $this->exec();
	}

	private function post($url, $data = array(), $as_json = true)
	{
		curl_setopt($this->curl, CURLOPT_URL, trim($url));
		curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($this->curl, CURLOPT_POST, true);
		if ($as_json and $data)
			$data = json_encode($data);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
		return $this->exec();
	}
	
	private function auth()
	{
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
			'Accept: application/vnd.qiwi.sso-v1+json',
			'Origin: https://qiwi.com',
			'Accept-Language: ru;q=0.8,en-US;q=0.6,en;q=0.4',
			'Content-Type: application/json',
			'Referer: https://qiwi.com/'
		));
		$answ = $this->post('http://sso.qiwi.com/cas/tgts', array(
			'login' => $this->login,
			'password' => $this->pass
		));
		$res = json_decode($answ, true);
		$this->tgt = $res['entity']['ticket'];
		if (!$this->tgt)
			return -1;

		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
			'Accept: application/vnd.qiwi.sso-v1+json',
			'Origin: https://sso.qiwi.com',
			'Content-Type: application/json',
			'Referer: https://sso.qiwi.com/app/proxy?v=1'
		));
		$answ = $this->post('https://sso.qiwi.com/cas/sts', array(
			'ticket' => $this->tgt,
			'service' => 'https://qiwi.com/j_spring_cas_security_check'
		));
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
			'Accept: application/vnd.qiwi.sso-v1+json',
			'Origin: https://qiwi.com',
			'Content-Type: application/json',
			'Referer: https://qiwi.com/'
		));
		$answ = $this->post('https://sso.qiwi.com/cas/sts', array(
			'ticket' => $this->tgt,
			'service' => 'https://qiwi.com/j_spring_cas_security_check'
		));
		$res = json_decode($answ, true);
		$this->st = $res['entity']['ticket'];
		if (!$this->st)
			return -2;

		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
			'Accept: application/json, text/javascript, */*; q=0.01',
			'X-Requested-With: XMLHttpRequest',
			'Referer: https://qiwi.com/'
		));
		$this->get('https://qiwi.com/j_spring_cas_security_check?ticket=' . $this->st);
		
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
			'Upgrade-Insecure-Requests: 1',
			'Referer: https://qiwi.com/main.action'
		));
		$this->get('https://sso.qiwi.com/app/proxy?v=1');

		return true;
	}
		
	public function getBalance()
	{
/*
(
[RUB] => 7305.21
[USD] => 0.1
)
*/
		$res = $this->auth();
		if ($res < 0)
			return $res;

		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
			'Accept: application/json, text/javascript, */*; q=0.01',
			'Origin: https://qiwi.com',
			'X-Requested-With: XMLHttpRequest',
			'Referer: https://qiwi.com/main.action'
		));
		$answ = $this->post('https://qiwi.com/person/state.action');
		$res = json_decode($answ, true);
		return $res['data']['balances'];
	}
	
	public function getHistory($d1, $d2 = 0)
	{
		if ($d2 <= 0)
			$d2 = time() + UNIX_DAY;
		$res = $this->auth();
		if ($res < 0)
			return $res;

		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'
		));
		$answ = $this->post(
			'https://qiwi.com/user/report/list.action?' .
				'daterange=true' .
				'&start=' . gmdate('d.m.Y', $d1) .
				'&finish=' . gmdate('d.m.Y', $d2),
			array(
				//'type' => 3 // 1 = today, 2 = yestoday, 3 = week
			),
			false
		);
		preg_match_all('|'.
			'"reportsLine status_(.*)".*'. 		// status: SUCCESS / PROCESSED / ...
			'DateWithTransaction.*'.
			'class="date"\>(.*)<.*'.
			'class="time"\>(.*)<.*'.
			'class="transaction">(.*)<.*'.
			'class="IncomeWithExpend (.*)".*'.	// direction: income / expenditure
			'class="cash">(.*)<.*'.				// amount and currency
			'class="commission">(.*)<.*'.
			'class="provider">.*<span>(.*)<.*<span.*>(.*)<.*'.
			'class="comment">(.*)<.*'.
			'|isU',
			$answ, $w, PREG_SET_ORDER);
/*
[1] => SUCCESS (статус)
[2] => 15.02.2016
[3] => 09:14:15
[4] => 1455516854 (батч)
[5] => income/expenditure (направление)
[6] => 3 141,24
		руб.
[7] => комиссия
[8] => Visa QIWI Wallet (провайдер)
[9] => номер
[10] => комент
*/
		$res = array();
		$currs = array(
			'руб.' => 'RUB',
			'долл.' => 'USD',
			'тенге' => 'KZT',
			' ' => ''
		);
		foreach ($w as $i => $l)
		{
			foreach ($l as $j => $v)
				$l[$j] = trim($v);
			foreach ($currs as $s => $curr)
				if (strpos($l[6], $s))
					break;
			$res[] = array(
				'time' => date_format(date_create_from_format('d.m.Y H:i:s', $l[2] . ' ' . $l[3]), 'U'),
				'from' => $l[9],
				'from_prov' => $l[8],
				'type' => strtolower($l[5]),
				'sum' => str_replace(',', '.', preg_replace('|[^0-9\,]+|', '', $l[6])),
				'curr' => $curr,
				'comis' => str_replace(',', '.', preg_replace('/[^0-9\.]+/', '', $l[7])),
				'memo' => $l[10],
				'state' => strtolower($l[1]),
				'batch' => $l[4]
			);
		}
		return $res;
	}

	public function getIncomeHistory($days = 1)
	{
		$res = $this->getHistory(time() - abs($days) * 60 * 60 * 24);
		if (is_array($res))
			foreach ($res as $i => $r)
				if (($r['type'] != 'income') or ($r['state'] != 'success'))
					unset($res[$i]);
		return $res;
	}
//////////////////////////////////////////////////////////////////////////////////////////////	
	public function sendMoney($to, $amount, $curr = 'RUB', $memo = '')
	{
		$res = $this->auth();
		if ($res < 0)
			return $res;

		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
			'Accept: application/vnd.qiwi.v2+json',
			'Origin: https://qiwi.com',
			'X-Requested-With: XMLHttpRequest',
			'Content-Type: application/json',
			'Referer: https://qiwi.com/payment/form.action?provider=99&state=confirm'
		));
		$answ = $this->post('https://qiwi.com/user/sinap/api/terms/99/payments/proxy.action', array(
			"id" => time() . '000',
			"sum" => array(
				"amount" => $amount,
				"currency" => "643"
			),
			"source" => "account_643",
			"paymentMethod" => array(
				"type" => "Account",
				"accountId" => "643"
			),
			"comment" => $memo,
			"fields" => array(
				"account" => $to,
				"_meta_pay_partner" => ""
			)
		));
		if (!$answ)
			return array('error' => 'NoConn');
		$res = json_decode($answ, true);
		$state = $res['data']['body']['transaction']['state']['code'];
		if ($state == 'Accepted')
			return array('batch' => $res['data']['body']['id']);
		else
			return array('error' => $state);
	}

}