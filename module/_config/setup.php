<?php

if (isset_IN('bSave')) {

	function chkwr($n) 
	{
		if (file_exists($n) and !is_writeable($n))
			addMsg('Please set 777 permissions for "' . $n . '"');
	}
	chkwr('logs');
	chkwr('module');
	chkwr('tpl_c');
	chkwr('_config.php');
	chkwr('cron.php');

	$sysID = substr(md5(uniqid()), -8);
	$k = md5($_GS['domain'] . $sysID);

	$fn = 'cron.php';
	if ($f = fopen($fn, 'w'))
	{
		fputs($f, "<?php @fclose(@fopen('" . fullURL('cron?auto', false) . "', 'r'));");
		fclose($f);
	}
	else
		addMsg("Can't open \"$fn\" for writing");
	$fn = '_config.php';
	if ($f = fopen($fn, 'w'))
	{
		fputs($f,
"<?php

\$_cfg = array(
	'sys_id' => '" . $sysID . "',
	'sys_mail' => '" . addslashes(_IN('sysMail')) . "',
	'cfg_link' => '" . addslashes(_IN('cfgLink')) . "',
	'db_host' => '" . addslashes(_IN('dbHost')) . "',
	'db_name' => '" . addslashes(_IN('dbName')) . "',
	'db_login' => '" . addslashes(encode1(_IN('dbLogin'), $k, false, 1)) . "',
	'db_pass' => '" . addslashes(encode1(_IN('dbPass'), $k, false, 2)) . "',
	'db_type' => '" . addslashes(_IN('dbType')) . "'
);"
		);
		fclose($f);
		require($fn);
		addMsg('Configuration saved!');
		
		if (sendMail(_IN('sysMail'), 'Test mail', 'This is a test mail from ' . $_GS['root_url']))
			addMsg('Test mail sended to "' . _IN('sysMail') . '"');
		else
			addMsg('Can\'t send test mail to "' . _IN('sysMail') .'"');
		
		@unlink('tpl_c/nt_db');
		
		require_once('module/dbinit.php');
		
		addMsg('Please do not forget to set 666 permissions for "_config.php" and "cron.php"');
	} 
	else
		addMsg("Can't open \"$fn\" for writing");
		
	goToURL($_cfg['cfg_link'] . '?install');
	
}

include('module/_config/_header.php');

?>

<h1>Setup</h1>

<table width="300px" border="0" align="center">
<tr>
	<td align="center">
		<form method="post">
			<big>System parameters</big>
			<br>
			<fieldset>
				e-mail<br>
				<input name="sysMail" value="<?php echo($_cfg['sys_mail']); ?>" type="text"><br>
				'Configurator' (this module) link<br>
				<input name="cfgLink" value="<?php echo($_cfg['sys_link'] ? $_cfg['sys_link'] : '_cfg'); ?>" type="text"><br>
			</fieldset>
			<br>
			<big>Database parameters</big>
			<br>
			<fieldset>
				host<br>
				<input name="dbHost" value="<?php echo($_cfg['db_host'] ? $_cfg['db_host'] : 'localhost'); ?>" type="text"><br>
				name<br>
				<input name="dbName" value="<?php echo($_cfg['db_name']); ?>" type="text"><br>
				user<br>
				<input name="dbLogin" value="" type="text"><br>
				password<br>
				<input name="dbPass" value="" type="text"><br>
				type<br>
				<select name="dbType">
					<option value="0" selected>- Default -</option>
					<option value="1">InnoDB</option>
					<option value="2">MyISAM</option>
				</select><br>
			</fieldset>
			<br>
			<input name="bSave" value="Save" type="submit">
		</form>
	</td>
</tr>
</table>

<?php

include('module/_config/_footer.php');
	
?>