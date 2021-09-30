<?php

if (!file_exists('_dbstru.php'))
	addMsg('Database structure "_dbstru.php" required');
else
{

require_once('module/dbinit.php');

require('_dbstru.php');

$dbq = $db->query('SHOW TABLES');
$tables = $db->fetchRows($dbq);
$tsm = array();
foreach ($tables as $t) 
	$tsm[] = strtolower(reset($t));

$dt = valueIf($_cfg['db_type'], ' TYPE=' . valueIf($_cfg['db_type'] == 1, 'InnoDB', 'MYISAM'));
foreach ($_dbstru as $tn => $cmnd) 
{
	$rem = '';
	$_tn = '_'.$tn;
	$db->query('DROP TABLE IF EXISTS '.$_tn);
	if (in_array(strtolower($tn), $tsm))
		$db->query('RENAME TABLE '.$tn.' TO '.$_tn);
	else
		$rem = 'NEW TABLE';
	$db->query("CREATE TABLE $tn ($cmnd)$dt CHARACTER SET utf8 COLLATE utf8_general_ci");
	if (in_array(strtolower($tn), $tsm)) 
	{
		$db->query('TRUNCATE TABLE '.$tn);
		$dbq = $db->query('SHOW FIELDS FROM '.$_tn);
		$_fields = $db->fetchRows($dbq, 'Field');
		$dbq = $db->query('SHOW FIELDS FROM '.$tn);
		$fields = $db->fetchRows($dbq, 'Field');
		$d = count($fields) - count($_fields);
		if ($d != 0) $rem = 'FIELDS: '.$d;
		$flds = implode(',', array_intersect($fields, $_fields));
		$db->query('INSERT INTO '.$tn.' ('.$flds.') SELECT '.$flds.' FROM '.$_tn);
		$db->query('DROP TABLE IF EXISTS '.$_tn);
	}
}

addMsg('Updating complete!');

clearstatcache();
$db->replace('Cfg',
		array(
			'Module' => 'Const',
			'Prop' => 'DBVer',
			'Val' => @filemtime('_dbstru.php')
		), 
		'', 'Module=? and Prop=?', array('Const', 'DBVer')
	);

}

goToURL($_cfg['cfg_link'] . '?modules');

?>