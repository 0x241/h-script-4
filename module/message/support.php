<?php

require_once('module/auth.php');

try 
{

	if (sendedForm()) 
	{
		checkFormSecurity();
		
		$admin = $db->fetch1($db->select('Users', 'uLogin', 'uID=1'));
		$params = array('cat' => _IN('Category'), 'lang' => $_GS['lang'], 'attn' => 9);
		setError(messageSend(_uid(), _IN('Mail'), $admin, $params, _IN('Topic'), _IN('Message')));
		showInfo('Completed', moduleToLink() . '?done');
	}

} 
catch (Exception $e) 
{
}

$cats = array();
foreach ((array)$_cfg['Msg__Cats'] as $c)
	$cats[textLangFilter($c, $_GS['lang'])] = $c;
setPage('cats', $cats);

showPage();

?>