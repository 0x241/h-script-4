<?php
@ignore_user_abort(1);
@set_time_limit(60);

header('Connection: close');
header('Content-Length: 0');
ob_end_clean();
ob_end_flush();
flush();

$_smode = 2;
require_once('module/auth.php');
require_once('module/message/lib.php');
require_once('module/balance/lib.php');

if (!$_cfg['Cron_Enabled'] or !$_oncron)
	exit;
    
// onCron init

$cron_time = time();
function checkCronTO()
{
	global $cron_time;
	if (abs(time() - $cron_time) > 30)
		exit;
}

$cron_ts = timeToStamp();

//process balance queue
$sql="SELECT order_id, type
      FROM Opers_queue";
$result = $db->_doQuery($sql);
while ($row = $db->fetch($result)) 
{
   if ('complete' == $row['type'])
   {
      opOperComplete(0, $row['order_id'], array(), true);
   }
   elseif ('confirm' == $row['type'])
   {
      if ($o = $db->fetch1Row($db->select('Opers', '*', '(oID=?d) and (oState<3) and (oOper=? or oOper=?)', array($row['order_id'], 'CASHIN', 'CASHOUT'))))
	  {
					$p = strToArray($o['oParams2']);
					if (!$p['date'])
						$p['date'] = timeToStamp();
					if (!$p['batch'])
						$p['batch'] = 'M' . str_pad($row['order_id'], 6, '0', STR_PAD_LEFT);
					$db->update('Opers', array('oParams2' => arrayToStr($p)), '', 'oID=?d', array($row['order_id']));
					opOperConfirm($o['ouID'], $row['order_id'], array(), true);
					opOperComplete($o['ouID'], $row['order_id'], array(), true);
	  }
   }    
    
   $sql="DELETE
         FROM Opers_queue
         WHERE order_id='".mysql_escape_string($row['order_id'])."'
         AND type='".mysql_escape_string($row['type'])."'"; 
   $db->_doQuery($sql);  
}    

//process msg queue
$sql="SELECT id, mail, section, consts, lang, fname, fromname, feed
      FROM Msg_queue
      ORDER BY id";
$result = $db->_doQuery($sql);
while ($row = $db->fetch($result)) 
{    
   sendMailToUser2($row['mail'], $row['section'], unserialize($row['consts']), $row['lang'], $row['fname'], $row['from'], (($row['feed'] == 1)?true:false)); 
   
   $sql="DELETE
         FROM Msg_queue
         WHERE id='".mysql_escape_string($row['id'])."'"; 
   $db->_doQuery($sql); 
}

foreach ($_oncron as $m => $n)
	if (($n > 0) and ($_cfg['Cron_' . $m] <= $cron_ts))
		if (file_exists($f = $_GS['module_dir'] . $m . '/oncron.php'))
			if (opWriteCfg('Cron', $m, timeToStamp(time() + $n * HS2_UNIX_MINUTE), ' and Val<=?', array($cron_ts)))
			{
				@include_once($f);
				checkCronTO();
			}
?>