<?php

/*
	Module: Global
*/

function opAddHist($oper, $uid = -1, $params = '', $memo = '', $tag = 0, $curr = '', $sum = 0, $oid = 0)
{
	global $_GS, $db;
	if ($uid < 0) 
		$uid = _uid();
	$db->insert('Hist', 
		array(
			'hTS' => timeToStamp(), 
			'hOper' => $oper,
			'huID' => $uid,
			'hIP' => $_GS['client_ip'],
			'hcCurrID' => $curr,
			'hSum' => $sum,
			'hParams' => arrayToStr($params),
			'hTag' => $tag,
			'hMemo' => $memo,
			'hoID' => $oid
		)
	);
}

function opReadUser($uid) 
{
	global $db;
	return (($uid > 0) ? $db->fetch1Row($db->select('Users LEFT JOIN AddInfo ON auID=uID', '*', 'uID=?d', array($uid))) : array());
}

function opUserConsts($usr, $a = array())
{
	$a['uid'] = $usr['uID'];
	$a['name'] = $usr['aName'];
	$a['login'] = $usr['uLogin'];
	return $a;
}

// Event

function opEvent($oper, $uid = -1, $params = array())
{
	global $_onload;
	if ($uid < 0)
		$uid = _uid();
	foreach ($_onload as $m => $s)
	{
		$m = 'on' . $m . 'Event';
		if (function_exists($m))
			$m($oper, $uid, $params);
	}
}

// Pages

function opPageReset()
{
	unset($_SESSION['_PL'][getFormName()]);
}

function opPageGet($page, $page_size, $table, 
	$fields = '*', $filter = '', $ph_values = null, $orders = array(), $order = '', $id_field = HS2_DB_DEF_ID_FIELD)
{
	$page_range = 10; // line size
	global $db, $_GS;
	foreach ($orders as $f => $a)
		if (!$a)
			if ($f == $id_field)
				$orders[$f] = array("$f desc", $f);
			else
				$orders[$f] = array($f, "$f desc");
	$form = getFormName();
	$pl = @$_SESSION['_PL'][$form];
	$params = array('Orders' => $orders, 'Order' => '');
	if ($orders)
	{
		if (!$order)
		{
			$order = $pl['Order'];
			if (!$order)
				$order = key($orders);
		}
		else
			$pl['Page'] = 0;
		$a = textRight($order, 1);
		if (is_numeric($a))
			$order = textLeft($order, -1);
		if (!$orders[$order][$a])
			$a = 0;
		if ($sorder = $orders[$order][$a])
		{
			$order .= $a;
			$pl['Order'] = $order;
			$params['Order'] = $order;
		}
	}
	else
		$sorder = '';
	$rows_count = $db->count($table, $filter, $ph_values);
	$pages_count = ceil($rows_count / $page_size);
	$params['PagesCount'] = $pages_count;
	if ($page == 0)
		$page = @$pl['Page'];
	$page = 0 + $page;
	if ($page > $pages_count)
		$page = $pages_count;
	if ($page < 1)
		$page = 1;
	$pl['Page'] = $page;
	$params['Page'] = $page;
	if ($pages_count > 1)
	{
		$ir2 = floor(($page_range - 1) / 2);
		$ir = 2 * $ir2; // index range
		if ($pages_count <= ($ir + 1))
		{
			$is = 1;
			$ie = $pages_count;
		}
		else 
		{
			$is = $page - $ir2; // index start
			if ($is < 1) 
				$is = 1;
			elseif (($is + $ir) > $pages_count) 
			{
				$is = $pages_count - $ir;
				if ($is < 1) 
					$is = 1;
			}
			$ie = $is + $ir; // range done (index end)
		}
		$pages = array();
		if ($is > 1)
			$pages[] = array('<<', 1);
		if ($page > 1)
			$pages[] = array('<', $page - 1);
		if ($page - 50 > 1)
			$pages[] = array($page - 50, $page - 50);
		if ($page - 10 > 1)
			$pages[] = array($page - 10, $page - 10);
		for ($i = $is; $i <= $ie; $i++)
			$pages[] = array($i, $i);
		if ($page + 10 < $pages_count)
			$pages[] = array($page + 10, $page + 10);
		if ($page + 50 < $pages_count)
			$pages[] = array($page + 50, $page + 50);
		if ($page < $pages_count)
			$pages[] = array('>', $page + 1);
		if ($ie < $pages_count)
			$pages[] = array('>>', $pages_count);
		$params['Pages'] = $pages;
	}
	$_SESSION['_PL'][$form] = $pl;
	setPage('pl_params', $params);
	return $db->fetchIDRows(
		$db->select($table, $fields, $filter, $ph_values, $sorder, 
			'' . (($page - 1) * $page_size) . ',' . $page_size), false, $id_field);
}

// Write to Cfg

function opWriteCfg($m, $f, $v, $flt = '', $fltarr = array())
{
	global $db;
	return $db->replace('Cfg', array(
			'Module' => $m,
			'Prop' => $f,
			'Val' => $v
		), '',
		'Module=? and Prop=?' . $flt, array_merge(array($m, $f), $fltarr)
	);
}

//functions

function FilterHTML($string) {
    if (get_magic_quotes_gpc()) {
    	$string = stripslashes($string);
    }
    $string = html_entity_decode($string, ENT_QUOTES, "ISO-8859-1");
    // convert decimal
    $string = preg_replace('/&#(\d+)/me', "chr(\\1)", $string); // decimal notation
    // convert hex
    $string = preg_replace('/&#x([a-f0-9]+)/mei', "chr(0x\\1)", $string); // hex notation
    //$string = html_entity_decode($string, ENT_COMPAT, "UTF-8");
    $string = preg_replace('#(&\#*\w+)[\x00-\x20]+;#U', "$1;", $string);
    $string = preg_replace('#(<[^>]+[\s\r\n\"\'])(on|xmlns)[^>]*>#iU', "$1>", $string);
    //$string = preg_replace('#(&\#x*)([0-9A-F]+);*#iu', "$1$2;", $string); //bad line
    $string = preg_replace('#/*\*()[^>]*\*/#i', "", $string); // REMOVE /**/
    $string = preg_replace('#([a-z]*)[\x00-\x20]*([\`\'\"]*)[\\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iU', '...', $string); //JAVASCRIPT
    $string = preg_replace('#([a-z]*)([\'\"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iU', '...', $string); //VBSCRIPT
    $string = preg_replace('#([a-z]*)[\x00-\x20]*([\\\]*)[\\x00-\x20]*@([\\\]*)[\x00-\x20]*i([\\\]*)[\x00-\x20]*m([\\\]*)[\x00-\x20]*p([\\\]*)[\x00-\x20]*o([\\\]*)[\x00-\x20]*r([\\\]*)[\x00-\x20]*t#iU', '...', $string); //@IMPORT
    $string = preg_replace('#([a-z]*)[\x00-\x20]*e[\x00-\x20]*x[\x00-\x20]*p[\x00-\x20]*r[\x00-\x20]*e[\x00-\x20]*s[\x00-\x20]*s[\x00-\x20]*i[\x00-\x20]*o[\x00-\x20]*n#iU', '...', $string); //EXPRESSION
    $string = preg_replace('#</*\w+:\w[^>]*>#i', "", $string);
    $string = preg_replace('#</?t(able|r|d)(\s[^>]*)?>#i', '', $string); // strip out tables
    $string = preg_replace('/(potspace|pot space|rateuser|marquee)/i', '...', $string); // filter some words
    //$string = str_replace('left:0px; top: 0px;','',$string);
    do {
    	$oldstring = $string;
    	//bgsound|
    	$string = preg_replace('#</*(applet|meta|xml|blink|link|script|iframe|frame|frameset|ilayer|layer|title|base|body|xml|AllowScriptAccess|big)[^>]*>#i', "...", $string);
    } while ($oldstring != $string);
    return addslashes($string);

}

function _z($z, $curr, $mode = 0) // 0-only sum / 1-sum and curr / 2-sum (+bold) and curr 
{
	global $_GS, $_cfg, $_currs, $_currs2;
	$cid = intval($curr);
	if (is_numeric($curr) and ($cid > 0))
	{
		$r = $_currs2[$cid]['cNumDec'];
		if ($r <= 0)
			$r = $_cfg['UI_NumDec'];
		$z = number_format(0 + $z, 0 + $r, '.', '');
		if ($mode < 1)
			return $z;
		if ($mode === 2)
			$z = "<b>$z</b>";
		return $z . ' <small>' . textLangFilter($_currs2[$cid]['cCurr'], $_GS['lang']) . '</small>';
	}
	elseif ($curr)
	{
		if (($curr == 'BTC') or ($curr == 'ETH') or ($curr == 'XRP'))
			$r = 6;
		else
			$r = 2;
		$z = number_format(0 + $z, 0 + $r, '.', '');
		if ($mode < 1)
			return $z;
		if ($mode === 2)
			$z = "<b>$z</b>";
		return "$z <small>$curr</small>";
	}
		
}

function cn(&$v)
{
	$v = str_replace(' ', '', $v);
	$v = str_replace(',', '.', $v);
	return $v;
}

?>