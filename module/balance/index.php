<?php

$_auth = 1;
require_once('module/auth.php');

$fform = 'opers_filter';
$table = 'Opers';
$id_field = 'oID';
$uid_field = 'ouID';

$list = array();
foreach ($_currs2 as $id => $c)
	$list[$c['cID']] = $c['cName'];
setPage('currs_list', $list);

try
{
}
catch (Exception $e)
{
}
setPage('currs', $_currs);
if (sendedForm('', $fform))
{
		checkFormSecurity($fform);

		foreach (array('uLogin', 'oOper', 'ocID', 'oBatch', 'oState', 'oMemo','ocCurrID', 'date_start', 'date_end') as $f)
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

if (isset($_SESSION[$fform]['date_start']) && isset($_SESSION[$fform]['date_end']))
{
    $date_from=isset($_SESSION[$fform]['date_start'])?trim($_SESSION[$fform]['date_start']):"";
    $date_to=isset($_SESSION[$fform]['date_end'])?trim($_SESSION[$fform]['date_end']):"";

    $date_from=htmlspecialchars(stripslashes($date_from));
    $date_to=htmlspecialchars(stripslashes($date_to));

    $date_from_time=strtotime($date_from);
    $date_to_time=strtotime($date_to);
}
else
{
   $date_from_time=0;
   $date_to_time=0;

}

$flt = '1';
	$fp = array();

	if (isset($_SESSION[$fform]))
		foreach (array('uLogin' => '', 'oOper' => '0', 'ocID' => '0', 'oBatch' => '', 'oState' => '9', 'oMemo' => '', 'ocCurrID' => '') as $f => $v0)
			if (($v = $_SESSION[$fform][$f]) != $v0 && $v != '0')
			{
	                  	$flt .= ' and (Opers.' . $f . valueIf($f == 'oMemo', ' ?%)' ,'=?)');
				$fp[] = $v;
			}

            $flt.=" AND Opers.$uid_field=?";
            $fp[]=_uid();



            if ($date_from_time>0 && $date_to_time>0)
            {
                 $a = array();
    $a['date_from']=date("Y",$date_from_time).sprintf("%02d",date("m",$date_from_time)).date("d",$date_from_time)."000000";
    $a['date_to']=date("Y",$date_to_time).sprintf("%02d",date("m",$date_to_time)).date("d",$date_from_time)."000000";


                $flt.=" AND $table.oCTS>='".$a['date_from']."' ";
                $fp[]="";


                $flt.=" AND $table.oCTS<='".$a['date_to']."' ";
                $fp[]="";
            }

$list = opPageGet(_GETN('page'), 10, 
	"$table LEFT JOIN Users on uID=ouID LEFT JOIN Currs on cID=ocID",
	"$table.*, uLogin, cName, cCurr, (oNTS>0) AS _Marked",
	$flt, $fp,
	array(
		'oTS' => array('oID desc', 'oID'),
		'oState' => array()
	),
	_GET('sort'), $id_field
);




stampTableToStr($list, 'oCTS, oTS, oNTS');
foreach ($list as $id => $r)
	$list[$id]['oParams'] = strToArray($r['oParams']);

setPage('list', $list);

showPage();
?>