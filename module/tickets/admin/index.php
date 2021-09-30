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

$table = 'Tickets';
$id_field = 'tID';

try
{

	if (isset_IN('ids') and (count($ids = (array)_IN('ids')) > 0))
	{
		$ids = $db->fetchRows($db->select($table, $id_field, '?# ?i', array($id_field, $ids)), 1);
		if (count($ids) > 0)
		{
			checkFormSecurity();

			if (sendedForm('del'))
			{
				$db->delete($table, '?# ?i', array($id_field, $ids));
				$db->delete('TMsg', '?# ?i', array('mtID', $ids));
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

$list = opPageGet(_GETN('page'), 20,
	"$table LEFT JOIN Users ON uID=tuID",
	"$table.*, uLogin, (SELECT COUNT(*) FROM TMsg WHERE mtID=tID and muID<>?d) AS cnt, (tState<=2) AS _Marked", '', array(_uid()),
	array(
		$id_field => array(),
		'tLTS' => array('tLTS desc', 'tLTS'),
		'uLogin' => array('uLogin', 'uLogin desc')
	),
	_GET('sort'), $id_field
);
stampTableToStr($list, 'tTS, tLTS');

setPage('list', $list);

showPage();

?>