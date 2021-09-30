<?php

$_auth = 90;
require_once('module/auth.php');
$id_field='aCIP';

/*
 * SELECT DISTINCT (ip) from (SELECT aCIP as ip FROM   AddInfo	UNION SELECT uLIP as ip FROM   Users) as U
 */
$ips =  $db->fetchRows(
    $db->query('SELECT DISTINCT (ip)  from (SELECT aCIP as ip FROM   AddInfo	UNION SELECT uLIP as ip FROM   Users) as U WHERE ip<>""'  )
);

$users = $db->fetchIDRows($db->select('Users LEFT JOIN AddInfo ON auID=uID', 'uID, uLogin, uLIP, aCIP'),false,'uID');
$ipres=array();
foreach ($ips as $k=>$ip){
    $ips[$k]['reg']=0;
    $ips[$k]['auth']=0;
    foreach ($users as $u){
        if ($u['uLIP']==$ip['ip'])
            $ips[$k]['auth']++;
        if ($u['aCIP']==$ip['ip'])
            $ips[$k]['reg']++;
    }
    $ips[$k]['sum'] = $ips[$k]['auth'] + $ips[$k]['reg'];
    if (($ips[$k]['reg']>1) or ($ips[$k]['auth']>1))
        $ipres[]=$ips[$k];
}
$ips=$ipres;

//sort array
$data_sum=array();
foreach($ips as $key=>$arr){
    $data_sum[$key]=$arr['sum'];
}


$list = array_multisort($data_sum, SORT_NUMERIC,  $ips);
$ips=array_reverse($ips) ;


setPage('list', $ips);

showPage();

?>