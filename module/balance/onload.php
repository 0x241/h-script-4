<?php

function onBalanceEvent($oper, $uid, $params)
{
	global $_cfg, $_currs2;
	
	if (($oper != 'RegComplete') or ($_cfg['Bal_RegBonus'] <= 0))
		return;
	useLib('balance');
	$c = $_currs2[$_cfg['Bal_RegBonusCurrency']];
	return opOperCreate($uid, 'BONUS', $c['cCurrID'], $_cfg['Bal_RegBonus'], array('cid' => $c['cID']), 'Bonus', true, true);
}

?>