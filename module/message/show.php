<?php

$_auth = 1;
require_once('module/auth.php');

$table = 'MBox';
$id_field = 'bID';
$out_link = moduleToLink('message');

if (($_cfg['Msg_Mode'] < 1) or (isset($_GET['new']) and ($_cfg['Msg_Mode'] < 2)))
	goToURL($out_link);

try 
{

	if (sendedForm('send')) 
	{
		checkFormSecurity();
		
		$params = array(
			're' => _INN('Re'),
			'attn' => _IN('Attn'),
			'group' => 0
		);
		setError($id = messageSend(_uid(), '', _IN('mTo'), $params, _IN('mTopic'), _IN('mText')));
		showInfo('Completed', moduleToLink('message/outbox') . "?id=$id");
	}

} 
catch (Exception $e) 
{
}

if (!isset($_GET['new']))
{
	if ($id = _GETN('id'))
		$el = $db->fetch1Row($db->select("$table LEFT JOIN Msg ON mID=bmID LEFT JOIN Users ON uID=buID2", 
		'*', "$id_field=?d and (buID=?d or muID=?d)", array($id, _uid(), _uid())));
	if (!$el)
		goToURL($out_link);
	stampArrayToStr($el, 'mTS, bRTS', 0);

	if (($el['buID'] == _uid()) and !$el['bRTS'] and $db->update($table, array('bRTS' => timeToStamp()), '', "$id_field=?d and buID=?d", array($id, _uid())))
		updateUserCounters();
}
elseif ($re = _GETN('re'))
	if ($rel = $db->fetch1Row($db->select("$table LEFT JOIN Msg ON mID=bmID LEFT JOIN Users ON uID=muID", 
		"$table.*, Msg.*, Users.uLogin", "$id_field=?d", array($re))))
		$el = array(
			'Re' => $re,
			'mTopic' => 'Re: ' . $rel['mTopic'],
			'mText' => HS2_NL . HS2_NL . textReplace(HS2_NL . $rel['mText'], HS2_NL, HS2_NL . '> '),
			'mLang' => $rel['mLang'],
			'mGroup' => exValue($re, $rel['mGroup']),
			'mTo' => exValue('mailto:' . $rel['mMail'], $rel['uLogin'])
		);

setPage('el', $el, 2);
showPage();

?>