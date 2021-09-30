<?php

if (isset_IN('doFill'))
{

	if (!file_exists('_dbstru.php'))
		addMsg('Database structure "_dbstru.php" required');
	else
	{

	require_once('module/dbinit.php');
	
	require('_dbstru.php');
	
	$db->query("ALTER DATABASE $dbn DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

//	if (in_array('InnoDB', $db->fetchRows($db->query('SHOW TABLE TYPES'), 'Engine')))
//		addMsg('* Server can process transactions');

	$ts = $db->fetchRows($db->query('SHOW TABLES'));
	if (count($ts) > 0)
		foreach ($ts as $t) 
			$db->query('DROP TABLE IF EXISTS ' . reset($t));

	$dt = valueIf($_cfg['db_type'], ' TYPE=' . valueIf($_cfg['db_type'] == 1, 'InnoDB', 'MYISAM'));
	foreach ($_dbstru as $t => $cmnd)
		$db->query("CREATE TABLE $t ($cmnd)$dt CHARACTER SET utf8 COLLATE utf8_general_ci");

	$psalt = substr(md5(uniqid(rand(), true).time()), 0, rand(6, 10));
	clearstatcache();
	$cfg = array(
		'Const' => array(
			'Salt' => $psalt,
			'NoLogins' => 0 + isset_IN('noLogins'),
			'IntCurr' => 0,
			'DBVer' => @filemtime('_dbstru.php')
		),
		'Sec' => array(
			'BFC' => 1
		),
		'Confirm' => array(
			'Captcha' => 2
		),
		'Sys' => array(
			'AdminMail' => _IN('aMail'),
			'NeedReConfig' => 1
		),
		'UI' => array(
			'_Langs' => "en\r\nru",
			'NumDec' => 2
		),
		'Cron' => array(
			'Enabled' => 1
		),
		'Account' => array(
			'LoginCaptcha' => 2,
			'ChangeMailCaptcha' => 2,
			'ResetPassCaptcha' => 2
		),
		'Depo' => array(
			'ChargeMode' => 1
		),
		'Bal' => array(
			('Rate' . _IN('intCurrID')) => 1
		)
	);
	//if (isset_IN('intCurr'))
		$cfg['Bal'] = array('UpdateRates' => 1);

	foreach ($cfg as $m => $a)
		foreach ($a as $p => $v)
			$db->insert('Cfg',
				array(
					'Module' => $m,
					'Prop' => $p,
					'Val' => $v
				)
			);
		
	$admin = (isset_IN('noLogins') ? _IN('aMail') : _IN('aLogin'));
	$db->insert('Users',
		array(
			'uID' => 1,
			'uLogin' => $admin,
			'uPass' => md5($psalt . _IN('aPass')),
			'uMail' => _IN('aMail'),
			'uPIN' => md5(_IN('aPIN') . $psalt),
			'uState' => 1,
			'uLevel' => 99,
			'uPTS' => timeToStamp()
		)
	);
	$db->insert('AddInfo',
		array(
			'auID' => 1,
			'aName' => _IN('aName'),
			'aSQuestion' => _IN('aSQuest'),
			'aSAnswer' => md5(_IN('aSAnsw') . $psalt),
			'aIPSec' => 4
		)
	);
	$db->insert('Currs', 
		array(
			'cDisabled' => 0,
			'cHidden' => 0,
			'cCID' => 'EPCU', 
			'cCurrID' => 'USD',
			'cCurr' => 'USD',
			'cName' => 'ePayCore USD (ePayCore.com)'
		)
	);
	$db->insert('Currs', 
		array(
			'cDisabled' => 0,
			'cHidden' => 0,
			'cCID' => 'EPCB', 
			'cCurrID' => 'BTC',
			'cCurr' => 'BTC',
			'cName' => 'ePayCore BTC (ePayCore.com)'
		)
	);
	$db->insert('Currs', 
		array(
			'cDisabled' => 0,
			'cHidden' => 0,
			'cCID' => 'EPCT', 
			'cCurrID' => 'ETH',
			'cCurr' => 'ETH',
			'cName' => 'ePayCore ETH (ePayCore.com)'
		)
	);
	
	addMsg('Installation complete!');
	goToURL($_cfg['cfg_link'] . '?modules');
	
	}
	
}
elseif (isset_IN('bStart'))
	addMsg('To process, markup "Create and fill base.." checkbox below');

include('module/_config/_header.php');

?>

<h1>Install</h1>

<table width="400px" border="0" align="center">
<tr>
	<td align="center">
		<form method="post">
			<big>Warning!!! All existing data will be lost!</big><br>
			<label><input name="doFill" type="checkbox"> <b>Create and fill base by following data:</b></label><br>
			<br>
			<big>Initial parameters</big>
			<br> 
			<big>Admin account</big>
			<br>
			<fieldset>
				name<br>
				<input name="aName" value="Administrator" type="text"><br>
				login<br>
				<input name="aLogin" value="admin" type="text"><br>
				password<br>
				<input name="aPass" value="admin" type="text"><br>
				e-mail<br>
				<input name="aMail" value="<?php echo($_cfg['sys_mail']); ?>" type="text"><br>
				secret question<br>
				<input name="aSQuest" value="That is your name" type="text"><br>
				secret answer<br>
				<input name="aSAnsw" value="John" type="text"><br>
				PIN-code<br>
				<input name="aPIN" value="1234" type="text"><br>
			</fieldset>
			<br>
			<input name="bStart" value="Process" type="submit">
		</form>
	</td>
</tr>
</table>

<?php

include('module/_config/_footer.php');
	
?>