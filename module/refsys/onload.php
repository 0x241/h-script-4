<?php

function _refPay($uid, $usr, $cid, $sum, $perc, $level, $coef) // uID, uLogin
{
	useLib('balance');
	return opOperCreate($uid, 'REF', $cid, _z(calcPerc($sum, $perc,6),$cid),
		array('tag' => $usr['uID'], 'reflogin' => $usr['uLogin'], 'coef' => $coef),
		$usr['uLogin'] . valueIf($level > 1, " L$level"), true, true);
}

function _refPayByLevels($uid, $cid, $sum, $percs, $type, $userproc, $coef)
{
	global $db, $_cfg;
	if (!$percs)
		return false;
	if ($usr = opReadUser($uid))
		if ($uid = $usr['uRef'])
			if ($type > 0)
			{				
				switch ($type)
				{
				case 3: // от_суммы_депозитов_рефов
				
					$a = $db->fetchRows($db->select('Users', 'uID', 'uRef=?d', array($uid))); // reflist
					$u=array();
					foreach ($a as $v) $u[]=$v['uID'];
					$n = $_cfg["Bal_RateUSD"] * $db->fetch1($db->select('Deps', 'SUM(dZDReal)', 'duID ?i', array($u)));
					break;
				case 4: // от_суммы_активных_депозитов_юзера
					$n = $_cfg["Bal_RateUSD"] * $db->fetch1($db->select('Deps', 'SUM(dZDReal)', 'duID=?d and dState=1', array($uid)));
					break;
				default:
					$n = $db->count('Users', 'uRef=?d and (SELECT COUNT(*) FROM Deps WHERE duID=uID)>0', array($uid));
				}
				$rusr = opReadUser($uid);
				if ($a = asArray($rusr[$userproc], HS2_NL))
					$percs = $a;
				$perc = 0;
				foreach ($percs as $i => $l)
					if ($l = explode('-', $l, 2))
					{
						cn($l[0]);
						cn($l[1]);
						if ((0 + $l[0]) > $n)
							break;
						else
							$perc = (0 + $l[1]);
					}
				_refPay($uid, $usr, $cid, $sum, $perc, $i + 1, $coef);
			}
			else
				foreach (asArray($percs) as $i => $perc)
					if ($rusr = opReadUser($uid)) // upref
					{
						if ($a = asArray($rusr[$userproc], HS2_NL))
							$perc = $a[$i];
						cn($perc);
						if ($perc > 0)
							_refPay($uid, $usr, $cid, $sum, $perc, $i + 1, $coef);
						$uid = $rusr['uRef'];
					}
					else
						break;
}

function onRefSysEvent($oper, $uid, $params)
{
	global $db, $_cfg;
	switch ($oper)
	{
	case 'Oper':
		if ($params['oper'] == 'CASHIN')
			_refPayByLevels($uid, $params['curr'], $params['sum'], $_cfg['Ref__Perc'], $_cfg['Ref_Type'], 'aPerc', $params['coef']);
		break;
	case 'DepoCreate':
		_refPayByLevels($uid, $params['curr'], $params['sum'], exValue($_cfg['Ref__DPerc'], $params['percs']), $_cfg['Ref_DType'], 'aDPerc', $params['coef']);
		break;
	case 'DepoCharge':
		_refPayByLevels($uid, $params['curr'], $params['sum'], exValue($_cfg['Ref__PPerc'], $params['percs']), $_cfg['Ref_PType'], 'aPPerc', $params['coef']);
		break;
	default:
		return;
	}
}

?>