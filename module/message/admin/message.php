<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'Msg';
$id_field = 'mID';
$out_link = moduleToLink('message/admin/messages');

try 
{

	if (sendedForm('send')) 
	{
		checkFormSecurity();
		
		if (!_IN('mMail') and !($uid = $db->fetch1($db->select('Users', 'uID', 'uLogin=? and uState=1', array(_IN('uLogin'))))))
			setError('user_not_found');
		$params = array(
			're' => _INN('Re'),
			'attn' => _IN('Attn'),
			'feed' => _IN('Feed'),
			'group' => 0
		);
		if (trim($mTo = _IN('mTo')) == '*')
			$mTo = $db->fetchRows($db->select('Users', 'uLogin', 'uState=1'), 1);
		else
			$mTo = asArray($mTo, HS2_NL);
		setError($id = messageSend($uid, _IN('mMail'), $mTo, $params, _IN('mTopic'), _IN('mText')));
		showInfo('Completed', $out_link . "?id=$id");
	}

} 
catch (Exception $e) 
{
}

if (!isset($_GET['add']))
{
	if ($id = _GETN('id'))
		$el = $db->fetch1Row($db->select("$table LEFT JOIN Users ON uID=muID", 
			"$table.*, Users.uLogin", "$id_field=?d", array($id)));
	if (!$el)
		goToURL(moduleToLink() . '?add');
	$db->update($table, array('mAttn' => 1), '', "$id_field=?d and mAttn=9", array($id));
	stampArrayToStr($el, 'mTS', 0);
}
elseif ($re = _GETN('re'))
	if ($rel = $db->fetch1Row($db->select("$table LEFT JOIN Users ON uID=muID", 
		"$table.*, Users.uLogin", "$id_field=?d", array($re))))
	{
		if ($rel['mToCnt'] != 1)
			goToURL(moduleToLink() . '?add');
		$el = array(
			'Re' => $db->fetch1($db->select('MBox', 'bID', 'bmID=?d', array($re))), // Inbox
			'mTopic' => 'Re: ' . $rel['mTopic'],
			'mText' => HS2_NL . HS2_NL . textReplace(HS2_NL . $rel['mText'], HS2_NL, HS2_NL . '> '),
			'mLang' => $rel['mLang'],
			'mGroup' => exValue($re, $rel['mGroup']),
			'mTo' => exValue('mailto:' . $rel['mMail'], $rel['uLogin'])
		);
		if (textPos('mailto:', $rel['mTo']) == 0)
			$el['mMail'] = trim(textSubStr($rel['mTo'], 7, 60));
		else
			$el['uLogin'] = $rel['mTo'];
	}
	
setPage('el', $el, 2);

showPage();

?>