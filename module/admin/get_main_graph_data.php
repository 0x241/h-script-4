<?php

  $currency_select=isset($_POST['currency_select'])?trim($_POST['currency_select']):"";
  $payment_system_select=isset($_POST['payment_system_select'])?intval($_POST['payment_system_select']):0;
  $date_range=isset($_POST['date_range'])?trim($_POST['date_range']):"";
  $currency_select=htmlspecialchars(stripslashes($currency_select));
  $date_range=htmlspecialchars(stripslashes($date_range));
  if (empty($currency_select)) $currency_select='USD';
  if (isset($_POST['date_from']) && isset($_POST['date_to']))
  {
    $date_from=isset($_POST['date_from'])?trim($_POST['date_from']):"";
    $date_to=isset($_POST['date_to'])?trim($_POST['date_to']):"";
    $date_from=htmlspecialchars(stripslashes($date_from));
    $date_to=htmlspecialchars(stripslashes($date_to));
    $date_from_time=strtotime($date_from);
    $date_to_time=strtotime($date_to);
  }
  else
  {
    $day=(int)date("d");  $today_month=(int)date("n");  $today_year=(int)date("Y");
    $prev_month=$today_month-1; $prev_year=$today_year;
    if ($today_month == 1) {$prev_month=12;$prev_year=$today_year-1;}
    $today_date=$today_year.'/'.sprintf("%02d",$today_month).'/'.sprintf("%02d",$day);
    $prev_date=$prev_year.'/'.sprintf("%02d",$prev_month).'/'.sprintf("%02d",$day);
    $date_from_time=strtotime($prev_year.'-'.sprintf("%02d",$prev_month).'-'.sprintf("%02d",$day));
    $date_to_time=strtotime($today_year.'-'.sprintf("%02d",$today_month).'-'.sprintf("%02d",$day));
  }

  if ($date_from_time == $date_to_time)
  {
    $date_from_time=$date_to_time-86400;
    $date_to_time=$date_to_time+86400;
  }
  
  $Graph=isset($_POST['Graph'])?$_POST['Graph']:"";
  $operations_graph=array();
  if (isset($Graph['deposit']) && $Graph['deposit'] == 1) $operations_graph['CASHIN']='val1';
  if (isset($Graph['bonus']) && $Graph['bonus'] == 1) $operations_graph['BONUS']='val2';
  if (isset($Graph['fine']) && $Graph['fine'] == 1) $operations_graph['PENALTY']='val3';
  if (isset($Graph['reffs']) && $Graph['reffs'] == 1) $operations_graph['REF']='val4';
  if (isset($Graph['contribution']) && $Graph['contribution'] == 1) $operations_graph['GIVE']='val5';
  if (isset($Graph['withdraw']) && $Graph['withdraw'] == 1) $operations_graph['TAKE']='val6';
  if (isset($Graph['accrual']) && $Graph['accrual'] == 1) $operations_graph['CALCIN']='val7';
  if (isset($Graph['write']) && $Graph['write'] == 1) $operations_graph['CALCOUT']='val8';
  if (isset($Graph['wait']) && $Graph['wait'] == 1) $operations_graph['CASHOUT']='val9';
  if (isset($Graph['output']) && $Graph['output'] == 1) $operations_graph['CASHOUT2']='val10';
  if (isset($Graph['deposit_balance']) && $Graph['deposit_balance'] == 1) $operations_graph['GIVE2']='val11';
  if (isset($Graph['active_deposit']) && $Graph['active_deposit'] == 1) $operations_graph['DEPO']='val12';
  if (isset($Graph['available_balance']) && $Graph['available_balance'] == 1) $operations_graph['BAL']='val13';
  if (isset($Graph['busy_balance']) && $Graph['busy_balance'] == 1) $operations_graph['LOCK']='val14';
  if (isset($Graph['wait_balance']) && $Graph['wait_balance'] == 1) $operations_graph['OUT']='val15';
  if (isset($Graph['reg']) && $Graph['reg'] == 1) $operations_graph['REG']='val16';
  $user_options=array();
  $user_options['Graph']=$Graph;
  $user_options['currency_select']=$currency_select;
  $user_options['payment_system_select']=$payment_system_select;
  $user_options['date_range']=$date_range;
  $sql="UPDATE Users
        SET GraphMainOptions='".serialize($user_options)."'
        WHERE uID='"._uid()."'";
  $result = $db->_doQuery($sql);
    $a = array();
    $a['date_from']=date("Y",$date_from_time).sprintf("%02d",date("m",$date_from_time)).sprintf("%02d",date("d",$date_from_time))."000000";
    $a['date_to']=date("Y",$date_to_time).sprintf("%02d",date("m",$date_to_time)).sprintf("%02d",date("d",$date_to_time))."235959";
  //get opers list
    $operation_list=array();
    while ($date_from_time<=$date_to_time)
    {
      $date_from_day=date("d", $date_from_time);
      $date_from_month=date("m", $date_from_time);
      $date_str=$date_from_day.' '.(($_user['uLang'] == 'ru')?$month_short_rus[intval($date_from_month)]:$month_short_eng[intval($date_from_month)]);
      $operation_list[$date_str]=array();
      $date_from_time+=86400;
    }
    $max_summ_operation=0;
    $sql="SELECT IF(t1.oOper = 'GIVE2', 'GIVE', t1.oOper) AS Oper, t2.cName,
          CONCAT(SUBSTRING(t1.oCTS,1,4),'-',SUBSTRING(t1.oCTS,5,2),'-',SUBSTRING(t1.oCTS,7,2)) AS date_add,
          DATE_FORMAT(CONCAT(SUBSTRING(t1.oCTS,1,4),'-',SUBSTRING(t1.oCTS,5,2),'-',SUBSTRING(t1.oCTS,7,2)),'%d') AS date_add_day,
          DATE_FORMAT(CONCAT(SUBSTRING(t1.oCTS,1,4),'-',SUBSTRING(t1.oCTS,5,2),'-',SUBSTRING(t1.oCTS,7,2)),'%m') AS date_add_month,
          SUM(t1.oSum) AS summ_total
          FROM  Opers AS t1
          LEFT JOIN Currs AS t2 ON t1.ocID=t2.cID
          WHERE t1.oCTS>='".$a['date_from']."'
          AND t1.oCTS<='".$a['date_to']."'
          AND t1.oState=3
          AND t1.ocCurrID='".mysql_escape_string($currency_select)."'".
		  (($payment_system_select>0)?" AND t1.ocID='".mysql_escape_string($payment_system_select)."' ":"").
		  "GROUP BY Oper, date_add ORDER BY t1.oCTS";
    $result = $db->_doQuery($sql);
    while($row = $db->fetch($result))
    {
      $date_str=$row['date_add_day'].' '.(($_user['uLang'] == 'ru')?$month_short_rus[intval($row['date_add_month'])]:$month_short_eng[intval($row['date_add_month'])]);
      if (isset($operations_graph[$row['Oper']]))
      {
          if (!isset($operation_list[$date_str]))  $operation_list[$date_str]=array();
          $operation_list[$date_str][$operations_graph[$row['Oper']]]=$row['summ_total'];
          if ($row['summ_total']>$max_summ_operation) $max_summ_operation=$row['summ_total'];
      }
    }
    //reg
          if (isset($operations_graph['REG']))
      {
    $sql="SELECT COUNT(t1.uID) AS count_users,
          CONCAT(SUBSTRING(t1.uPTS,1,4),'-',SUBSTRING(t1.uPTS,5,2),'-',SUBSTRING(t1.uPTS,7,2)) AS date_add,
          DATE_FORMAT(CONCAT(SUBSTRING(t1.uPTS,1,4),'-',SUBSTRING(t1.uPTS,5,2),'-',SUBSTRING(t1.uPTS,7,2)),'%d') AS date_add_day,
          DATE_FORMAT(CONCAT(SUBSTRING(t1.uPTS,1,4),'-',SUBSTRING(t1.uPTS,5,2),'-',SUBSTRING(t1.uPTS,7,2)),'%m') AS date_add_month
          FROM Users AS t1
          WHERE t1.uState=1
          AND t1.uPTS>='".$a['date_from']."'
          AND t1.uPTS<='".$a['date_to']."'
          GROUP BY date_add";
    $result = $db->_doQuery($sql);
    while($row = $db->fetch($result))
    {
      $date_str=$row['date_add_day'].' '.(($_user['uLang'] == 'ru')?$month_short_rus[intval($row['date_add_month'])]:$month_short_eng[intval($row['date_add_month'])]);
          if (!isset($operation_list[$date_str]))  $operation_list[$date_str]=array();
          $operation_list[$date_str][$operations_graph['REG']]=$row['count_users'];
          if ($row['count_users']>$max_summ_operation) $max_summ_operation=$row['count_users'];
    }
    }
    $max_summ_operation=ceil($max_summ_operation/10) * 10;
    $summ_interval=ceil($max_summ_operation/10);
    $json=array();
    $json['data']='[';
    $co=sizeof($operation_list);
    $i=0;
    foreach ($operation_list as $key => $item)
    {
       $json['data'].='{"date":"'.$key.'"';
       foreach ($operations_graph as $key2 => $item2)
       {
          $json['data'].=',"'.$item2.'":"'.(($item[$item2]>0)?$item[$item2]:0).'"';
       }
       $json['data'].='}';
       if (($i+1) != $co) $json['data'].=",";
       $i++;
    }
    $json['data'].=']';
    $json['max']=(($max_summ_operation>0)?$max_summ_operation:1000);
    $json['tickInterval']=(($max_summ_operation>0)?$summ_interval:10);
    $jsonstring = json_encode($json);
    header('Content-type: application/json');
    echo $jsonstring;
    exit();

?>