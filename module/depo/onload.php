<?php

function onDepoEvent($oper, $uid, $params)
{
	global $_cfg;
	if (!$_cfg['Depo_AutoDepo'])
		return;
	if (($oper != 'Oper') or ($params['oper'] != 'CASHIN'))
		return;
	if ($params['cid2'])
	{
		$params['cid'] = $params['cid2'];
		$params['sum'] = $params['sum2'];
	}
	useLib('depo');
	if (is_string($res1 = opDepoAdd($uid, $params['curr'], $params['sum'])))
		$res2 = opDepoCreate($uid, $params['curr'], $params['sum'], $params['compnd'], $params['pid'], false, true);
}

?>