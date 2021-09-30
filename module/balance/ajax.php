<?php

require_once('module/auth.php');
useLib('balance');

try 
{

	switch (_RQ('do'))
	{
	case 'getcurr':
		$c = $_currs[_RQ('cid')];
		echo('<small>' . textLangFilter($c['cCurr'], $_GS['lang']) . '</small>');
		break;
	case 'getsum':
		cn($_REQUEST['sum']);
		$oper = _RQ('oper');
		$curr = _RQ('curr');
		$cid = _RQ('cid');
		$sum = _zr(_RQ('sum'), $curr);
		$c = $_currs2[$cid];
		$res = array('-','-','-','-', array());
		if ($curr)
		{
		$sum2 = $sum3 = 0;
		if ($c and ($oper == 'CASHIN'))
		{
			$a = opReCalcAF($cid, $curr, $sum);
			$csum = opCalcComis($cid, 'CASHIN', $a[1], $_user['uLevel'] >= 90);
			$res = array(
				valueIf($a[1] >= 0, _z($a[1], $c['cCurrID'], 2), '-'),
				'<small>' . textLangFilter($c['cCurr'], $_GS['lang']) . '</small>',
				valueIf($csum > 0, _z($csum, $c['cCurrID'], 2), '-'),
				valueIf($a[0] >= 0, _z($a[0], $curr, 2), '-')
			);
		}
		elseif ($c and (($oper == 'CASHOUT') or ($oper == 'TR')))
		{
			$a = opReCalcAF($cid, $curr, $sum);
			$csum = opCalcComis($cid, $oper, $a[1], $_user['uLevel'] >= 90);
			$res = array(
				valueIf($a[1] >= 0, _z($a[1], $c['cCurrID'], 2), '-'),
				'<small>' . textLangFilter($c['cCurr'], $_GS['lang']) . '</small>',
				valueIf($csum > 0, _z($csum, $c['cCurrID'], 2), '-'),
				valueIf($a[0] >= 0, _z($a[0], $curr, 2), '-'),
				array()
			);
		}
		elseif ($oper == 'EX')
		{
			$curr2 = _RQ('curr2');			
			$a = opReCalcEX($curr, $curr2, $sum);
			$csum = opCalcComis($curr, 'EX', $a[0], $_user['uLevel'] >= 90);			
			$csum2 = opCalcComis($curr2, 'EX', $a[1], $_user['uLevel'] >= 90);			
			if ($csum > 0 && $a[1] > 0)
			    $a[1] -= $csum2;
			$res = array(
				valueIf($a[1] >= 0, _z($a[1], $curr2, 2), '-'),
				'<small>' . $curr2 . '</small>',
				valueIf($csum > 0, _z($csum, $curr, 2), '-'),
				valueIf($a[0] >= 0, _z($a[0], $curr, 2), '-')
			);
		}
		}
		if ($curr and (($oper == 'CASHOUT') or ($oper == 'TR')))
			foreach ($_currs2 as $cid => $c)
				$res[4][$cid] = calcWDAvail(_uid(), $curr, $cid);
		echo(json_encode($res));
		break;
	}

}
catch (Exception $e) 
{
}

?>