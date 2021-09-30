<?php

$_auth = 90;
require_once('module/auth.php');
require_once('lib/psys.php');

global $self_category, $admin_modules;
$self_category = '';
$admin_modules = array();
foreach ($_rwlinks as $m => $r)
	if ($r['admin'])
	{
		if (!is_string($r['admin']))
			$r['admin'] = $m;
		if (!$r['category'])
		{
			$s = explode('/', $r['admin'], 2);
			if ($s[1])
			{
				$r['category'] = $s[0];
				$r['admin'] = $s[1];
			}
		}
		prepVal($r['category'], 3);
		prepVal($r['admin'], 3);

		if ($m == $_GS['module'])
			$self_category = $r['category'];
		if ($r['admin'] != '-')
        {
          $admin_modules[$r['category']][$r['admin']] = $m;
        }
	}
setPage('up_category', $self_category);
setPage('up_modules', $admin_modules[$self_category]);
setPage('admin_modules_links', $admin_modules);


$uid = _uid();

$admin_links_list=array();
$admin_links=array();

 $sql="SELECT url
       FROM Admin_menu
       WHERE admin_id='".mysql_escape_string($uid)."'
       ORDER BY date_add DESC";
  $result = $db->_doQuery($sql);
  while($row = $db->fetch($result))
  {
    $r=$_rwlinks[$row['url']];

    prepVal($r['category'], 3);
    prepVal($r['admin'], 1);

    $r['admin']=str_replace("{!ru!}", "", $r['admin']);
    $r['admin']=str_replace("{!en!}", "", $r['admin']);

    $ar=explode('/', $r['admin']);
    $r['admin']=$ar[1];

    $admin_links[]=array(
                          'url' => $row['url'],
                          'name' => $r['admin']
                        );

     $admin_links_list[]=$row['url'];
  }

  $root_dir=str_replace("/rw.php", "", $_SERVER['SCRIPT_FILENAME']);
  $SiteInf=file_get_contents($root_dir.'/module/_config/siteinf.txt');

  setPage('admin_links', $admin_links);
  setPage('admin_links_list', $admin_links_list);
  setPage('SiteInf', $SiteInf);
  setPage('SiteInfDisable', $_cfg['Sys_SiteInfDisable']);

useLib('balance');

$table = 'Opers';
$id_field = 'oID';
$out_link = moduleToLink('balance/admin/opers');

try
{

	if (sendedForm('', 'add'))
	{
		checkFormSecurity('add');

		if (!_IN('Oper'))
			setError('oper_empty', 'add');
		$uid = $db->fetch1($db->select('Users', 'uID', 'uLogin=? and (uState=1 or uState=2)', array(_IN('Login'))));
		if (!$uid)
			setError('user_empty', 'add');
		if (!isset_IN('PSys') and !isset_IN('Curr'))
			goToURL(moduleToLink() . '?add=' . _IN('Oper') . '&user=' . _IN('Login'));
		$a = $_IN;
		cn($a['Sum']);
		$params = array(
			'cid' => $a['PSys'],
			'uid2' => $db->fetch1($db->select('Users', 'uID', 'uLogin=?', array($a['Login2']))),
			'curr2' => $a['Curr2'],
			'pid' => $a['Plan'],
			'compnd' => $a['Compnd']
		);
		if (($a['Oper'] == 'CASHIN') or ($a['Oper'] == 'BONUS'))
		{
			$b = opReCalcAF($a['PSys'], $a['Curr'], $a['Sum']);
			$a['Sum'] = $b[0];
			$params['sum2'] = $b[1];
		}
		elseif (($a['Oper'] == 'CASHOUT') or ($a['Oper'] == 'TR') or ($a['Oper'] == 'PENALTY'))
		{
			$b = opReCalcWD($a['PSys'], $a['Curr'], $a['Sum']);
			$a['Sum'] = $b[0];
			$params['sum2'] = $b[1];
		}
		elseif ($a['Oper'] == 'EX')
		{
			$b = opReCalcEX($a['Curr'], $a['Curr2'], $a['Sum']);
			$a['Sum'] = $b[0];
			$params['sum2'] = $b[1];
		}
		if (($a['Oper'] == 'CALCIN') and (_INN('Curr') < 0))
		{
			$d = $db->fetch1Row($db->select('Deps LEFT JOIN Plans ON pID=dpID LEFT JOIN Users ON uID=duID', '*',
				'duID=?d and dState=1 and (dNPer<pNPer or pNPer=0)', array($uid)));
			useLib('depo');
			setError(opDepoCharge($d, -1, false, true));
		}
		else
        {
			$id = opOperCreate($uid, $a['Oper'], $a['Curr'], $a['Sum'], $params, strip_tags($a['Memo']), false, true);
			setError($id, 'add');
        }

		showInfo('Added', moduleToLink() . "?id=$id");
	}

	if (sendedForm('', 'data'))
	{
		checkFormSecurity('data');
		if ($o = $db->fetch1Row($db->select('Opers LEFT JOIN Currs on cID=ocID', '*',
			"$id_field=?d and oState<=2", array(_INN('oID')))))
		{
			$a = array(
				'date' => timeToStamp(textToTime(_IN('date'))),
				'batch' => strip_tags(_IN('batch')),
				'memo' => strip_tags($_POST['Memo'])
			);
			if (!$a['date'] or (stampToTime($a['date']) >= time()))
				setError('data_date_wrong', 'data');
			if (!$a['batch'])
				setError('data_batch_wrong', 'data');
			setError($a = opEditToCurrParams(getPayFields($o['cCID']), $a, $_IN), 'data');
			$db->update('Opers', array('oBatch' => valueIf($o['oState'] == 2, $a['batch']), 'oParams2' => arrayToStr($a)), '', 'oID=?d', array($o['oID']));
			showInfo('Saved');
		}
		showInfo('*Error');
	}

	if ($id = _INN($id_field))
	{
		checkFormSecurity();

		if ($o = $db->fetch1Row($db->select('Opers', '*', "$id_field=?d", array($id))))
		{
			if (sendedForm('del') and ($o['oState'] >= 4))
			{
				$db->delete('Opers', 'oID=?d', array($id));
				showInfo('Deleted', $out_link);
			}
			elseif (sendedForm('cancel') and ($o['oState'] <= 2))
			{
				if (opOperCancel($o['ouID'], $id, array(), true) === true)
					showInfo('Canceled');
			}
			elseif (/*sendedForm() and */($o['oState'] <= 2))
			{
				if ($o['oState'] < 2)
					setError(opOperConfirm($o['ouID'], $id, array(), true));
				setError(opOperComplete($o['ouID'], $id, array(), true, (array)_IN('API')));
				showInfo();
			}
		}
		showInfo('*Error');
	}

}
catch (Exception $e)
{
//	xstop($e->getMessage());
}

if (!isset($_GET['add']))
{
	if ($id = _GETN('id'))
		$el = $db->fetch1Row($db->select("$table LEFT JOIN Users on uID=ouID LEFT JOIN Currs on cID=ocID", '*', "$id_field=?d", array($id)));
	if (!$el)
		goToURL($out_link);
	stampArrayToStr($el, 'oCTS, oTS, oNTS');
	$el['oParams'] = strToArray($el['oParams']);
	$el['oParams2'] = strToArray($el['oParams2']);
	stampArrayToStr($el['oParams2'], 'date', 1);
	setPage('el', $el);
	if ((($el['oOper'] == 'CASHIN') or ($is_out = ($el['oOper'] == 'CASHOUT'))) and ($el['oState'] <= 2))
	{
		$c = getCIDs($el['cCID']);
		if ($a = opCurrParamsToEdit(getPayFields($el['cCID'])))
			setPage('dfields', array(1 => '') + $a, 1);
		if (!$c[2 + $is_out])
			setPage('defaultbatch', valueIf($is_out, 'OUT', 'IN') . str_pad($el['oID'], 6, '0', STR_PAD_LEFT));
		opDecodeCurrParams($el, $p, $p, $p);
		if ($is_out and $c[3] and !$p['apipass'])
			if ($a = opCurrParamsToEdit(getAPIFields($el['cCID']), 'API'))
				setPage('afields', array(1 => '') + $a, 1);
	}
}
else
{

	if ($oper = _GET('add'))
	{
		$uid = $db->fetch1($db->select('Users', 'uID', 'uLogin=? and (uState=1 or uState=2)', array(_GET('user'))));
		if (!$uid)
			goToURL(moduleToLink() . '?add');
		$usr = opReadUser($uid);
		$ucurrs = array();
		foreach (array('USD', 'EUR', 'RUB', 'BTC', 'ETH', 'XRP') as $cn)
			foreach (array('Bal', 'Lock', 'Out') as $p)
				$ucurrs[$cn][$p] = $usr["u$p$cn"];
		setPage('currs', $ucurrs);
	}

	$list = array();
	foreach ($_currs2 as $id => $r)
		$list[$id] = $r['cName'];
	if ($oper == 'CALCIN')
	{
		if ($dlist = $db->fetchRows($db->select('Deps LEFT JOIN Plans ON pID=dpID', '*', 'duID=?d and dState=1', array($uid), 'dID')))
		{
			foreach ($dlist as $d)
				$list[-$d['dID']] = '#' . $d['dID'] . ' [' . textLangFilter($d['pName'], $_GS['lang']) . '] - ' . _z($d['dZD'], $d['dcID']) . ' ' . $_currs[$d['dcID']]['cCurr'] . ' ' . $_currs[$d['dcID']]['cName'];
		}
	}
	setPage('clist', $list);
}

showPage();

?>