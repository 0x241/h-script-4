<?php

// Message

// from = uID / to = array()
// params: re / cat / attn / lang / group
function messageSend($from, $frommail, $to, $params, $topic, $text)
{
	global $db, $_cfg;
	if (!$frommail and !($usr = opReadUser($from)))
		return 'user_not_found';
	if ($frommail and !validMail($frommail))
		return 'mail_wrong';
	if (!is_array($to)) 
		$to = array($to);
	for ($i = count($to) - 1; $i >= 0; $i--)
		if (!($u = trim($to[$i])))
			unset($to[$i]);
		else
			$to[$i] = $u;
	if (count($to) < 1)
		return 'to_empty';
	if (!$topic)
		return 'topic_empty';
	if (!$text)
		return 'text_empty';
	$lang = exValue($params['lang'], $usr['uLang']);
	$wrusrs = array();
	$users = array();
	foreach ($to as $u)
	{
		if (textPos('mailto:', $u) == 0)
		{
			$u = trim(textSubStr($u, 7, 60)); // e-mail
			$a = $db->fetch1Row($db->select('Users LEFT JOIN AddInfo ON auID=uID', '*', 'uMail=?', array($u)));
			if (!$a and validMail($u))
				$a = array('uMail' => $u, 'aName' => 'User', 'uLang' => $lang);
		}
		else
		{
			$a = $db->fetch1Row($db->select('Users LEFT JOIN AddInfo ON auID=uID', '*', 'uLogin=? and uState=1', array($u)));
		}
		if (!$a)
			$wrusrs[] = $u;
		else
			$users[] = $a;
	}
	if ($wrusrs)
	{
		setPage('wrusrs', asStr($wrusrs, ', '));
		return 'to_wrong';
	}
	$mid = $db->insert('Msg', array(
		'muID' => $from,
		'mTS' => timeToStamp(),
		'mMail' => $frommail,
		'mAttn' => $params['attn'],
		'mTopic' => $topic,
		'mText' => $text,
		'mLang' => $lang,
		'mGroup' => $params['group'],
		'mTo' => asStr($to, HS2_NL),
		'mToCnt' => count($to)
	));
	$a = array(
		'from' => exValue($frommail, $usr['uLogin']),
		'topic' => $topic,
		'message' => $text,
		'remessage' => $db->fetch1($db->select('MBox LEFT JOIN Msg ON mID=bmID', 'mText', 'bID=?d', array($params['re']))),
		'url' => fullURL(moduleToLink('message/show'))
	);
	foreach ($users as $u)
	{
		if ($u['uID'])
		{
			$id = $db->insert('MBox', array( // Inbox
				'buID' => $u['uID'],
				'bmID' => $mid,
				'bRe' => $params['re'],
				'buID2' => $from,
				'bMail' => $frommail
			));
		}
		if (!$u['uID'] or (!$_cfg['Msg_NoMail'] and !$u['aNoMail']))
        {
            $constants=$a + array('name' => $u['aName'], 'id' => $id);
            
            
            $sql="INSERT INTO Msg_queue(mail, section, consts, lang, fname, fromname, feed)
                  VALUES('".mysql_escape_string($u['uMail'])."', 
                  '".mysql_escape_string('Notice' . valueIf(!$u['uID'] or !$_cfg['Msg_Mode'] or $params['feed'], 'ToMail'))."',
                  '".mysql_escape_string(serialize($constants))."',
                  '".mysql_escape_string($u['uLang'])."',
                  '".mysql_escape_string('e-mails')."', 
                  '".mysql_escape_string(exValue($usr['uMail'], $frommail))."', 0)";
           $db->_doQuery($sql); 
           
           sendMailToUser2($u['uMail'], 'Notice' . valueIf(!$u['uID'] or !$_cfg['Msg_Mode'] or $params['feed'], 'ToMail'),
				$a + array('name' => $u['aName'], 'id' => $id), $u['uLang'], 'e-mails', exValue($usr['uMail'], $frommail), $params['feed']);
                 
        }
	}
    
	return $mid;
} 

function sendMailToUser2($mail, $section, $consts = array(), $lang = '', $fname = 'e-mails', $from = '', $feed = false)
{
	global $_GS, $_cfg;
	if (!validMail($mail) or !$section)
		return false;
	$lang = getLang($lang);
	$txt = loadText($section, $fname, $lang);
	if (!$txt["$section.message"])
		return false;
	$hdr = loadText('_header', $fname, $lang);
	$ftr = loadText('_footer', $fname, $lang);
	$consts['date'] = timeToStr(time(), 0, $lang);
	$consts['ip'] = $_GS['client_ip'];
	$consts['rooturl'] = $_GS['root_url'];
	$consts['sitename'] = $_cfg['Sys_SiteName'];
//	prepVal($consts, 2);
	return sendMail(
		$mail, 
		textVarReplace($txt["$section.topic"], $consts),
		valueIf($feed,
			textVarReplace($consts['message'], $consts),
			nl2br(textVarReplace(
			$hdr['_header'] . $txt["$section.message"] . $ftr['_footer'], $consts))
		),
		exValue($_cfg['Sys_NotifyMail'], $from)
	);
}

?>