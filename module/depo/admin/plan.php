<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'Plans';
$id_field = 'pID';
$out_link = moduleToLink('depo/admin/plans');

try 
{

	if (sendedForm()) 
	{
		checkFormSecurity();
		
		$a = $_IN;
		if (sEmpty($a['pName']))
        {
          setError('name_empty');  
        }
		if ($a['pMin'] < 0.01)
        {
           setError('min_wrong');  
        }
		if ($a['pMax'] <= $a['pMin'])
        {
           setError('max_wrong'); 
        }
		if (($a['pPerc'] <= 0) and ($a['pReturn'] <= 0))
		{
			setError('perc_wrong', '', false);
			setError('perc2_wrong');
		}
		if ($a['pPer'] < 1)
        {
            setError('period_wrong');
        }
		if (($a['pCompndMin'] < 0) or ($a['pCompndMin'] > 100))
        {
           	setError('compndmin_wrong'); 
        }
		if (($a['pCompndMax'] < 0) or ($a['pCompndMax'] > 100) or ($a['pCompndMax'] < $a['pCompndMin']))
        {
           	setError('compndmax_wrong');  
        }
		if (($a['pClComis'] < 0) or ($a['pClComis'] > 100))
        {
           	setError('clcomis_wrong'); 
        }
		$a['pDays'] = round(_INN('pPer') * _INN('pNPer') / 24);
                
		if ($id = $db->save($table, $a, 
			'pHidden, pNoCalc, pGroup, pGroupReq, pMaxCount, pName, pDescr, pMin, pMax, pDays, pWDays, pPClndr, pPerc, pPer, pNPer, pMPer, pClPer, pClComis, pReturn, pBonus, pEnAdd, pMinAdd, pCompndMin, pCompndMax, pDPerc, pPPerc, pBonusDay', $id_field))
            {
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
	if (_GETN('id'))
		$el = $db->fetch1Row($db->select($table, '*', "$id_field=?d", array(_GETN('id'))));
	if (!$el)
		goToURL(moduleToLink() . '?add');
	setPage('el', $el, 2);
}

showPage();

?>