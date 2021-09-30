<?php

$_auth = 90;
require_once('module/auth.php');
require_once('lib/psys.php');

useLib('balance');

$table = 'Currs';
$id_field = 'cID';
$out_link = moduleToLink('balance/admin/currs');

try 
{

	$cids = getCIDs();

	if (sendedForm('', 'add')) 
	{
		checkFormSecurity('add');
		
		if (!($c = $cids[_IN('PSys')]))
			setError('psys_not_selected', 'add');
		if ($id = $db->insert('Currs', array('cCID' => _IN('PSys'), 'cCurrID' => $c[1], 'cName' => $c[0], 'cCurr' => $c[1])))
			showInfo('Added', moduleToLink() . "?id=$id");
		showInfo('*Error');
	}

	if (sendedForm()) 
	{
		checkFormSecurity();

		if (($cid = _INN('cID')) and (_IN('cCID')))
		{
			$a = $_IN;
			opDecodeCurrParams($db->fetch1Row($db->select($table, '*', 'cID=?d', array($cid))), $p, $p_sci, $p_api);
			$t = time();
			$key = $cid . $a['cCID'] . $t;
			setError($p = opEditToCurrParams(getPayFields($a['cCID']), $p, (array)_IN('P'), 'P'));
			setError($p_sci = opEditToCurrParams(getSCIFields($a['cCID']), $p_sci, (array)_IN('PSCI'), 'PSCI'));
			setError($p_api = opEditToCurrParams(getAPIFields($a['cCID']), $p_api, (array)_IN('PAPI'), 'PAPI'));
			$a['cParams'] = encodeArrayToStr($p, $key);
			$a['cParamsSCI'] = encodeArrayToStr($p_sci, $key, 2);
			$a['cParamsAPI'] = encodeArrayToStr($p_api, $key, 3);
			$a['cMTS'] = timeToStamp($t);
			if ($id = $db->save($table, $a,
				'cDisabled, cHidden, cName, cCurr, cNumDec, ' .
				'cCASHINMode, cCASHINMin, cCASHINMax, cCASHINInt, cCASHINComis, cCASHINComisMin, cCASHINComisMax, ' .
				'cCASHOUTMode, cCASHOUTMin, cCASHOUTMax, cCASHOUTInt, cCASHOUTComis, cCASHOUTComisMin, cCASHOUTComisMax, cCASHOUTLimitPer, cCASHOUTLimit, ' .
				'cTRMode, cTRMin, cTRMax, cTRInt, cTRComis, cTRComisMin, cTRComisMax, ' .
				'cParams, cParamsSCI, cParamsAPI, cMTS', $id_field))
				showInfo('Saved', $out_link . "?id=$id");
		}
		showInfo('*Error');
	}

} 
catch (Exception $e) 
{
}

if (!isset($_GET['add']))
{
	if ($id = _GETN('id'))
		$el = $db->fetch1Row($db->select($table, '*', "$id_field=?d", array($id)));
	if (!$el)
		goToURL(moduleToLink() . '?add');
	opDecodeCurrParams($el, $el['P'], $el['PSCI'], $el['PAPI']);
	stampArrayToStr($el, 'cMTS');
	setPage('el', $el, 2);
	setPage('cName', $cids[$el['cCID']][0]);
	setPage('pfields', opCurrParamsToEdit(getPayFields($el['cCID']), 'P'), 1);
	setPage('sfields', opCurrParamsToEdit(getSCIFields($el['cCID']), 'PSCI'), 1);
	setPage('afields', opCurrParamsToEdit(getAPIFields($el['cCID']), 'PAPI'), 1);
	if (isset($_GET['testapi']))
	{
		$res = GetBalance($el['cCID'], $el['PAPI']);
		setPage('res', $res);
	}
}
else
{
	$list = $db->fetchRows($db->select('Currs', 'cCID'), 1);
	foreach ($list as $id)
		unset($cids[$id]);
	$list = array();
	foreach ($cids as $id => $r)
		$list[$id] = $r[0] . ', ' . $r[1];
	setPage('cids', $list); // available CIDs
}

showPage();

?>