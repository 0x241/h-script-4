<?
/**
 * Библиотека работы с API выплатами
 * Требуется поддержка PHP XML и PHP CURL
 * @version 1.0
 */



Class PaymentApi {


	 
 	 // Укажите API ID полученный в аккаунте    
	 var  $api_id = '';
    

	 // Укажите API KEY полученный в аккаунте
	 var  $apikey     = '';


	 // Адрес платежной системы
	 var  $server = 'http://helixmoney24.com';

	 


	 // Получение баланса
	 function balance(){
		$url  =  $this->server.'/ru/api/balance';
		$params  =  'api_id='.$this->api_id;
		$params .=  '&apikey='.$this->apikey;
		$response = $this->_post($url, $params);
		return $this->_xmltoArray($response);
	 }



     // Проверка правильности логина получателя
	 function user($login){
		$url  =  $this->server.'/ru/api/user';
		$params  =  'api_id='.$this->api_id;
		$params .=  '&apikey='.$this->apikey;		
		$params .=  '&login='.$login;		
		$response = $this->_post($url, $params);
		return $this->_xmltoArray($response);
	 }




	 // Перевод пользователю
	 function transfer($to, $amount, $currency, $note){
		$url  =   $this->server.'/ru/api/transfer';
		$params  =  'api_id='.$this->api_id;
		$params .=  '&apikey='.$this->apikey;
		$params .=  '&to='.$to;
		$params .=  '&amount='.$amount;
		$params .=  '&currency='.$currency;
		$params .=  '&note='.$note;
		$response = $this->_post($url, $params);
		return $this->_xmltoArray($response);
	 }




     // Функция отправки запроса
	 function _post($url, $params){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, 'PaymentApi Client');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		$data = curl_exec($curl);
		curl_close($curl);
		return $data;
	 }



     // Конвертация ответа в Array
	 function _xmltoArray($xml, $type = ''){
	   if(!$type) $xml = simplexml_load_string($xml);
       $array = json_decode(json_encode($xml), TRUE);
       if(is_array($array)) foreach ( array_slice($array, 0) as $key => $value ) {
             if (empty($value)) $array[$key] = 0;
             elseif (is_array($value)) $array[$key] = $this->xmltoArray($value, 1);
       }
       return $array;
     }


 

}