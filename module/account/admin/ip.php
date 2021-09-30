<?php

$_auth = 90;
require_once('module/auth.php');

$id_field='uID';


$ip = _GET('ip');

$list = opPageGet(_GETN('page'), 100, "Users LEFT JOIN AddInfo ON uID=auID",
    '*',
    'aCIP=? or uLIP=?', array( $ip, $ip ),
	array(),
	_GET('sort'), $id_field
);

setPage('list', $list);

showPage();

?>