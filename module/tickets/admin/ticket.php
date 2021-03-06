<?php

$_auth = 90;
require_once('module/auth.php');

$table = 'Tickets';
$id_field = 'tID';
$out_link = moduleToLink('tickets/admin');

try
{

	if (sendedForm('create'))
	{
		checkFormSecurity();

		if (!_IN('mMail') and !($uid = $db->fetch1($db->select('Users', 'uID', 'uLogin=? and uState=1', array(_IN('uLogin'))))))
			setError('user_not_found');
		setError($id = ticketCreate($uid, _IN('tCat'), _IN('tTopic'), _IN('tText')));
		showInfo('Completed', $out_link . "?id=$id");
	}

	if (sendedForm('answer'))
	{
		checkFormSecurity();

		setError($id = ticketAsk(_uid(), _INN('tID'), _IN('mText')));
		showInfo('Completed', $out_link . "?id=$id");
	}

	if (sendedForm('close', 'ticket'))
	{
		checkFormSecurity('ticket');

		setError(ticketClose(_uid(), $id = _INN('tID')), 'ticket');
		showInfo('Completed', $out_link . "?id=$id");
	}

}
catch (Exception $e)
{
}

if (!isset($_GET['add']))
{
	if ($id = _GETN('id'))
		$el = $db->fetch1Row($db->select("$table LEFT JOIN Users ON uID=tuID",
			"$table.*, Users.uLogin", "$id_field=?d", array($id)));
	if (!$el)
		goToURL(moduleToLink() . '?add');
	stampArrayToStr($el, 'tTS, tLTS', 0);
	setPage('el', $el, 2);

	$list = $db->fetchRows($db->select('TMsg LEFT JOIN Users ON uID=muID LEFT JOIN AddInfo ON auID=uID',
		'TMsg.*, Users.uLogin, AddInfo.aName', 'mtID=?d', array($id)));
	stampTableToStr($list, 'mTS, mRTS');
	setPage('list', $list, 2);
}

showPage();

?>