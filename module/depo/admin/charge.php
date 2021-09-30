<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'Plans';
$id_field = 'pID';
	
if ($_cfg['Depo_ChargeMode'] == 2)
{

	$cdate = opDepoLastManualChargeDate();

	try 
	{

		if (isset_IN('ids'))
		{
			$ids = $db->fetchRows($db->select($table, $id_field, '?# ?i', array($id_field, (array)_IN('ids'))), 1);
			if (count($ids) > 0)
			{
				checkFormSecurity();

                //--add to cron for manual---
                $p = (array)_IN('p'); // percents
                foreach ($ids as $pid) {
                    $did = $db->fetch1($db->select('Deps','dID','dpID=?d and dState=1',array($pid),'dID desc',1));
                    if ($did and ($p[$pid]>0))
                        $db->update('Plans',array('pmndID'=>$did, 'pmnPerc'=>$p[$pid],'pmndIDdone'=>0),'','pID=?d',array($pid));
                }
                //----------------------------

				if (!$cdate)
					setError('date_wrong');
				$p = (array)_IN('p'); // percents
				$t = time();
				$n = 0;
				foreach ($ids as $pid) {
					$dl = $db->select('Deps LEFT JOIN Plans ON pID=dpID LEFT JOIN Users ON uID=duID', '*', 
						'dID>pmndIDdone and dpID=?d and dState=1 and (dNPer<pNPer or pNPer=0) and dNTS<=? and dLTS<=?'
						, array($pid, timeToStamp(), timeToStamp(time() - 10 * HS2_UNIX_MINUTE)),'dID');
					while ((abs(time() - $t) < 30) and ($d = $db->fetch($dl)))
					{
						opDepoCharge($d, $p[$pid], $cdate);
						$db->update('Plans',array('pmndIDdone'=>$d['dID']),'','pID=?d',array($d['pID']));
						$n++;
					}
				}
				showInfo('Completed', moduleToLink() . "?done=$n");
			}
			else
				showInfo('*NoSelected');
		}

	} 
	catch (Exception $e) 
	{
	}

	$list = opPageGet(_GETN('page'), 20, $table, "*, (SELECT COUNT('*') FROM Deps WHERE dpID=pID AND dState=1) AS cnt", 'pNoCalc=0', null, 
		array(
		), 
		_GET('sort'), $id_field
	);

	setPage('list', $list);
	setPage('cdate', timeToStr($cdate, 1));

}

showPage();

?>