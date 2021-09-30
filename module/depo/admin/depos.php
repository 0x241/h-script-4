<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'Deps';
$id_field = 'dID';
$fform = 'deps_filter';
	
try 
{

	if (sendedForm('', $fform))
	{
		checkFormSecurity($fform);
		
		foreach (array('uLogin', 'dcCurrID', 'dpID', 'dState') as $f)
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

}
catch (Exception $e) 
{
}

if ($user = $_GET['user'])
{
	$flt = 'uLogin=?';
	$fp = array($user);
}
else
{
	$flt = '1';
	$fp = array();
	if (isset($_SESSION[$fform]))
		foreach (array('uLogin' => '', 'dcCurrID' => '', 'dpID' => '0', 'dState' => '9') as $f => $v0)
			if (($v = $_SESSION[$fform][$f]) != $v0)
			{
				if ($f == 'uLogin')
				{
					$flt .= ' and ((Users.uLogin=?) or (Users.uMail=?))';
					$fp[] = $v;
				}
				else
			                $flt .= " and ($f=?)"; 
				$fp[] = $v;
			}
}
$list = opPageGet(_GETN('page'), 20, 
	"$table LEFT JOIN Users ON uID=duID LEFT JOIN Plans ON pID=dpID", '*', 
	$flt, $fp,
	array(
		$id_field => array(),
		'uLogin' => array('uLogin', 'uLogin desc'),
		'pName' => array('pName', 'pName desc'),
		'dLTS' => array('dLTS desc', 'dLTS'),
		'dNTS' => array('dNTS desc', 'dNTS')
	), 
	_GET('sort'), $id_field
);
stampTableToStr($list, 'dCTS, dLTS, dNTS');

setPage('list', $list);

$currs = array();
foreach ($_currs as $id => $c)
	$currs[$id] = $c['cName'];
setPage('currs', $currs);

setPage('plans', $db->fetchIDRows($db->select('Plans', 'pID, pName'), 2, 'dpID'));

showPage();

?>