<?php

// User Defined Functions module

function updateUserCounters()
{
	global $db, $_auth, $_user;
	if ($_user['uLevel'] >= 90)
		setPage('count_aopers', $db->count('Opers', 'oState=2'));
	if ($_auth < 90)
	{
		setPage('count_msg', $db->count('MBox LEFT JOIN Msg ON mID=bmID', 
			'ISNULL(bRTS) and buID=?d and muID<>buID and bDeleted=0', array(_uid())));
		setPage('count_opers', $db->count('Opers', 'oNTS>0 and ouID=?d', array(_uid())));
        setPage('count_tickets', $db->count('Tickets LEFT JOIN TMsg ON tID=mtID',
            'ISNULL(mRTS) and tuID=?d and tuID<>muID', array(_uid())));
	}
	else
	{
	}
}

define('AVATAR_DIR', 'upload/avatar/');

?>