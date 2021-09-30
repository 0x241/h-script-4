<?php

// Tickets

// creator = uID / array(Name, Mail)
function ticketCreate($creator, $cat, $topic, $text)
{
	global $db, $_cfg;
	if (!is_array($creator))
	{
		$usr = opReadUser($creator);
		if (!$usr)
			return 'user_not_found';
		$creator = array('uID' => $creator, 'Name' => $usr['aName'], 'Mail' => $usr['uMail']);
	}
//	if (!validMail($frommail))
//		return 'mail_wrong';
	if (!$topic)
		return 'topic_empty';
	if (!$text)
		return 'text_empty';
	$tid = $db->insert('Tickets', array(
		'tuID' => $creator['uID'],
		'tTS' => timeToStamp(),
//		'tTID' => ???,
		'tName' => $creator['Name'],
		'tMail' => $creator['Mail'],
		'tCat' => $cat,
		'tTopic' => $topic,
		'tText' => $text,
		'tPriority' => 1,
		'tState' => 1,
		'tLTS' => timeToStamp()
	));
	$creator['id'] = $tid;
	$creator['topic'] = $topic;
	$creator['text'] = $text;
	$creator['url'] = fullURL(moduleToLink('tickets/admin/ticket'));
	sendMailToAdmin('NewTicket', $creator);
	return $tid;
}

function ticketAsk($creator, $tid, $text)
{
	global $db, $_cfg;
	$t = $db->fetch1Row($db->select('Tickets', '*', '?#=?d',
		array(valueIf(is_string($tid), 'tTID', 'tID'), $tid)));
	if (!$t)
		return 'ticket_not_found';
	if (!is_array($creator))
	{
		$usr = opReadUser($creator);
		if (!$usr)
			return 'user_not_found';
		$creator = array('uID' => $creator, 'Name' => $usr['aName'], 'Mail' => $usr['uMail']);
		if (($usr['uLevel'] < 50) and ($usr['uID'] != $t['tuID']))
			return 'ticket_wrong';
	}
	else
		if ($t['tMail'] != $creator['Mail'])
			return 'ticket_wrong';
	if ($t['tState'] >= 8)
		return 'ticket_wrong';
	if (!$text)
		return 'text_empty';

	$mid = $db->insert('TMsg', array(
		'mtID' => $t['tID'],
		'muID' => $creator['uID'],
		'mTS' => timeToStamp(),
		'mText' => $text
	));
	if ($mid)
		$db->update('Tickets',
			array(
				'tState' => valueIf($usr['uID'] == $t['tuID'], 2, 5),
				'tLTS' => timeToStamp()
			),
			'', 'tID=?', array($t['tID']));
	$creator['id'] = $t['tuID'];
	$creator['topic'] = $t['tTopic'];
	$creator['text'] = $text;
	if ($usr['uID'] == $t['tuID'])
	{
		$creator['url'] = fullURL(moduleToLink('tickets/admin/ticket'));
		sendMailToAdmin('Ticket', $creator);
	}
	else
	{
		$creator['url'] = fullURL(moduleToLink('tickets/ticket'));
		sendMailToUser($creator['Mail'], 'Ticket', $creator, $usr['uLang'],'e-mails_'.$usr['uLang']);
	}
	return $mid;
}

function ticketClose($creator, $tid)
{
	global $db, $_cfg;
	$t = $db->fetch1Row($db->select('Tickets', '*', '?#=?d',
		array(valueIf(is_string($tid), 'tTID', 'tID'), $tid)));
	if (!$t)
		return 'ticket_not_found';
	if (!is_array($creator))
	{
		$usr = opReadUser($creator);
		if (!$usr)
			return 'user_not_found';
		$creator = array('uID' => $creator, 'Name' => $usr['aName'], 'Mail' => $usr['uMail']);
		if (($usr['uLevel'] < 90) and ($usr['uID'] != $t['tuID']))
			return 'ticket_wrong';
	}
	else
		if ($t['tMail'] != $creator['Mail'])
			return 'ticket_wrong';
	if ($t['tState'] >= 8)
		return 'ticket_wrong';
	$db->update('Tickets',
		array(
			'tState' => 9,
			'tLTS' => timeToStamp()
		),
		'', 'tID=?', array($t['tID']));
	return true;
}

?>