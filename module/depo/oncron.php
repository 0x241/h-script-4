<?php

if ($_cfg['Depo_ChargeMode'] == 1)
{
	useLib('depo');
	$dl = $db->select('Deps LEFT JOIN Plans ON pID=dpID LEFT JOIN Users ON uID=duID', '*', 
		'dState=1 and (dNPer<pNPer or pNPer=0) and dNTS<=? and dLTS<=?', array(timeToStamp(), timeToStamp(time() - 1 * HS2_UNIX_MINUTE)), 'dLTS, dID');
	$t = time();	
	while ((abs(time() - $t) < 20) and ($d = $db->fetch($dl)))
		opDepoCharge($d);
}


//--cron for manual accrual
if ($_cfg['Depo_ChargeMode'] == 2){

    useLib('depo');
    $pl =  $db->fetchRows($db->select('Plans', '*', 'pmndID>0', array(), 'pID'));
    $cdate = opDepoLastManualChargeDate();

    if ($cdate)
    {
        $t = time();
        $n = 0;
        foreach ($pl as $pid) {
            $dl = $db->select('Deps LEFT JOIN Plans ON pID=dpID LEFT JOIN Users ON uID=duID', '*',
                'dID>pmndIDdone and dpID=?d and dState=1 and (dNPer<pNPer or pNPer=0) and dNTS<=? and dLTS<=? and dID<=?', array($pid['pID'], timeToStamp(), timeToStamp(time() - 10 * HS2_UNIX_MINUTE),$pid['pmndID']),'dID');
            while ((abs(time() - $t) < 30) and ($d = $db->fetch($dl)))
            {
                opDepoCharge($d, $pid['pmnPerc'], $cdate);
                $db->update('Plans',array('pmndIDdone'=>$d['dID']),'','pID=?d',array($d['pID']));
                $n++;
            }

            $dl = $db->select('Deps LEFT JOIN Plans ON pID=dpID LEFT JOIN Users ON uID=duID', 'dID',
                'dID>pmndIDdone and dpID=?d and dState=1 and (dNPer<pNPer or pNPer=0) and dNTS<=? and dLTS<=? and dID<=?', array($pid['pID'], timeToStamp(), timeToStamp(time() - 10 * HS2_UNIX_MINUTE),$pid['pmndID']));
            if (!($d2=$db->fetch($dl)))
            {
                $db->update('Plans',array('pmndID'=>0, 'pmnPerc'=>0),'','pID=?d',array($pid['pID']));
            }

        }
    }


}
//-------------------------

if ($_cfg['Depo_ShowStat'])
{
	useLib('depo');
	@file_put_contents('tpl_c/stat.dat', @serialize(depoGetStat()));
}
	
?>