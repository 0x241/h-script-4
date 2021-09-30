<?php

$_auth = 90;
require_once('module/auth.php');

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
       WHERE admin_id='".mysql_escape_string(_uid())."'
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

$table = 'Opers';
$id_field = 'oID';
$fform = 'opers_filter';

try
{

	if (sendedForm('', $fform))
	{
		checkFormSecurity($fform);

		foreach (array('D1', 'D2', 'uLogin', 'oOper', 'ocID', 'oBatch', 'oState', 'oMemo', 'ocCurrID') as $f)
			$_SESSION[$fform][$f] = _IN($f);
		opPageReset();
		goToURL();
	}

	if (sendedForm('clear', $fform))
	{
		checkFormSecurity($fform);

		unset($_SESSION[$fform]);
		opPageReset();
		goToURL();
	}

	if (isset_IN('ids') and (count($ids = (array)_IN('ids')) > 0))
	{
		$ids = $db->fetchRows($db->select($table, $id_field, '?# ?i', array($id_field, $ids)), 1);
		if (count($ids) > 0)
		{
			checkFormSecurity();

			if (sendedForm('complete'))
			{
				/*
                foreach ($ids as $id)
                {
                    $sql="INSERT INTO Opers_queue(order_id, type)
                          VALUES('".mysql_escape_string($id)."', 'complete')";
                    $db->_doQuery($sql);
                }
				*/
			
                foreach ($ids as $id)
					opOperComplete(0, $id, array(), true);
            
			}

			if (sendedForm('confirm'))
			{
			    foreach ($ids as $id)
                {
                    $sql="INSERT INTO Opers_queue(order_id, type)
                          VALUES('".mysql_escape_string($id)."', 'confirm')";
                    $db->_doQuery($sql);
                }

				/*
                foreach ($ids as $id)
				if ($o = $db->fetch1Row($db->select('Opers', '*', '(oID=?d) and (oState<3) and (oOper=? or oOper=?)', array($id, 'CASHIN', 'CASHOUT'))))
				{
					$p = strToArray($o['oParams2']);
					if (!$p['date'])
						$p['date'] = timeToStamp();
					if (!$p['batch'])
						$p['batch'] = 'M' . str_pad($id, 6, '0', STR_PAD_LEFT);
					$db->update('Opers', array('oParams2' => arrayToStr($p)), '', 'oID=?d', array($id));
					opOperConfirm($o['ouID'], $id, array(), true);
					opOperComplete($o['ouID'], $id, array(), true);
				}
                */
			}

			if (sendedForm('cancel'))
			{
				foreach ($ids as $id)
					opOperCancel(0, $id, array(), true);
			}

			if (sendedForm('del'))
			{
				$db->delete($table, '(oState >= 4) and (?# ?i)', array($id_field, $ids));
			}

			showInfo();
		}
		else
			showInfo('*NoSelected');
	}

}
catch (Exception $e)
{
}

if ($user = $_GET['user'])
{
	$flt = 'uLogin=?';
	$fp = array($user);
	setPage('linkparams', "&user=$user");
}
else
{
	$flt = '1';
	$fp = array();

	if (isset($_SESSION[$fform]))
	{
		if ($v = timeToStamp(textToTime($_SESSION[$fform]['D1'], 1)))
		{
			$flt .= ' and (oCTS>=?)';
			$fp[] = $v;
		}
		if ($v = timeToStamp(textToTime($_SESSION[$fform]['D2'], 2)))
		{
			$flt .= ' and (oCTS<=?)';
			$fp[] = $v;
		}
		foreach (array('uLogin' => '', 'oOper' => '0', 'ocID' => '0', 'oBatch' => '', 'oState' => '9', 'oMemo' => '', 'ocCurrID' => '') as $f => $v0)
			if (($v = $_SESSION[$fform][$f]) != $v0)
			{
				if ($f == 'uLogin')
				{
					$flt .= ' and ((Users.uLogin=?) or (Users.uMail=?))';
					$fp[] = $v;
				}
				else
	        	          	$flt .= ' and (' . $f . valueIf($f == 'oMemo', ' ?%)' ,'=?)');
				$fp[] = $v;
			}
	}
}
//xstop($fp);

$list = opPageGet(_GETN('page'), 20,
	"$table LEFT JOIN Users on uID=ouID LEFT JOIN Currs on cID=ocID",
	"$table.*, uLogin, uMail, cName, cCurr, (oState=2) AS _Marked",
	$flt, $fp,
	array(
		$id_field => array(),
		'uLogin' => array('uLogin', 'uLogin desc'),
		'oTS' => array('oCTS desc', 'oCTS', 'oTS desc', 'oTS')
	),
	_GET('sort'), $id_field
);
stampTableToStr($list, 'oCTS, oTS');
foreach ($list as $id => $r)
{
	$list[$id]['oParams'] = strToArray($r['oParams']);
	$list[$id]['oParams2'] = strToArray($r['oParams2']);
}

setPage('list', $list);

$currs = array();
foreach ($_currs as $id => $c)
	$currs[$id] = $c['cName'];
setPage('currs', $currs);

$currs2 = array();
foreach ($_currs2 as $id => $c)
	$currs2[$id] = $c['cName'];
setPage('currs2', $currs2);

showPage();

?>