<?php

    $Graph=$GraphMainOptions['Graph'];
    $date_range=$GraphMainOptions['date_range'];
    
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

    if ('now' == $date_range)
    {
       $day=(int)date("d");  $today_month=(int)date("n");  $today_year=(int)date("Y");
  
       $prev_day=$day; $prev_month=$today_month; $prev_year=$today_year;  
    }
    elseif ('yesterday' == $date_range)
    {
       $day=(int)date("d", time()-86400);  $today_month=(int)date("n", time()-86400);  $today_year=(int)date("Y", time()-86400);
  
       $prev_day=$day; $prev_month=$today_month; $prev_year=$today_year;   
    }
    elseif ('lastweek' == $date_range)
    {
       $num_day=date('w');

       $time_start_last_week=time()-$num_day*86400; 
       $time_end_last_week=$time_start_last_week-6*86400; 
       
       $day=(int)date("d", $time_start_last_week);  $today_month=(int)date("n", $time_start_last_week);  $today_year=(int)date("Y", $time_start_last_week);
  
       $prev_day=(int)date("d", $time_end_last_week); $prev_month=(int)date("n", $time_end_last_week); $prev_year=(int)date("Y", $time_end_last_week);   
    }
    elseif ('lastmonth' == $date_range)
    {
       $day=(int)date("d");  $today_month=(int)date("n");  $today_year=(int)date("Y");
  
       $prev_day=$day; $prev_month=$today_month-1; $prev_year=$today_year;
   
       if ($today_month == 1) {$prev_month=12;$prev_year=$today_year-1;} 
       
       $date_prev_time=strtotime($prev_year.'-'.sprintf("%02d",$prev_month).'-'.sprintf("%02d",$prev_day));
       
       $last_day_month=date("t",$date_prev_time);
       
       $day=$last_day_month; $today_month=$prev_month;  $today_year=$prev_year;
       $prev_day=1;
    }
    elseif ('last7days' == $date_range)
    {
      $time_last_7_days=time()-86400*7;  
        
      $day=(int)date("d");  $today_month=(int)date("n");  $today_year=(int)date("Y");
  
      $prev_day=(int)date("d", $time_last_7_days); $prev_month=(int)date("n", $time_last_7_days); $prev_year=(int)date("Y", $time_last_7_days);   
    }
    elseif ('last30days' == $date_range)
    {
      $time_last_30_days=time()-86400*30;  
        
      $day=(int)date("d");  $today_month=(int)date("n");  $today_year=(int)date("Y");
  
      $prev_day=(int)date("d", $time_last_30_days); $prev_month=(int)date("n", $time_last_30_days); $prev_year=(int)date("Y", $time_last_30_days); 
    }
    else
    {
       $day=(int)date("d");  $today_month=(int)date("n");  $today_year=(int)date("Y");
  
       $prev_day=$day; $prev_month=$today_month-1; $prev_year=$today_year;
   
       if ($today_month == 1) {$prev_month=12;$prev_year=$today_year-1;}
    }
    
    if ($today_year == $prev_year && $today_month == $prev_month && $day == $prev_day)
    {
       $day_time=strtotime($prev_year.'-'.sprintf("%02d",$prev_month).'-'.sprintf("%02d",$prev_day));
       

       $day=(int)date("d",$day_time+86400);  
       $today_month=(int)date("n",$day_time+86400);  
       $today_year=(int)date("Y",$day_time+86400); 
       
       $prev_day=(int)date("d",$day_time-86400);  
       $prev_month=(int)date("n",$day_time-86400);  
       $prev_year=(int)date("Y",$day_time-86400); 
    }   
    
    $today_date=$today_year.'/'.sprintf("%02d",$today_month).'/'.sprintf("%02d",$day);
    $prev_date=$prev_year.'/'.sprintf("%02d",$prev_month).'/'.sprintf("%02d",$prev_day);
      
    $date_str=$prev_day.' '.(($_user['uLang'] == 'ru')?$month_short_rus[$prev_month]:$month_short_eng[$prev_month]).' '.$prev_year.' - '.$day.' '.(($_user['uLang'] == 'ru')?$month_short_rus[$today_month]:$month_short_eng[$today_month]).' '.$today_year;
    setPage('date_str', $date_str);
     
    $date_from_time=strtotime($prev_year.'-'.sprintf("%02d",$prev_month).'-'.sprintf("%02d",$prev_day));
    $date_to_time=strtotime($today_year.'-'.sprintf("%02d",$today_month).'-'.sprintf("%02d",$day));  
    
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
    
    $a = array();
    $a['date_from']=$day.'.'.$prev_month.'.'.$prev_year;
    $a['date_to']=$day.'.'.$today_month.'.'.$today_year;

	strArrayToStamp($a, 'date_from', 0);
	strArrayToStamp($a, 'date_to', 1);
    
    $max_summ_operation=0;
        
    $sql="SELECT IF(t1.oOper = 'GIVE2', 'GIVE', t1.oOper) AS Oper, t2.cName, 
          CONCAT(SUBSTRING(t1.oCTS,1,4),'-',SUBSTRING(t1.oCTS,5,2),'-',SUBSTRING(t1.oCTS,7,2)) AS date_add, 
          DATE_FORMAT(CONCAT(SUBSTRING(t1.oCTS,1,4),'-',SUBSTRING(t1.oCTS,5,2),'-',SUBSTRING(t1.oCTS,7,2)),'%d') AS date_add_day,
          DATE_FORMAT(CONCAT(SUBSTRING(t1.oCTS,1,4),'-',SUBSTRING(t1.oCTS,5,2),'-',SUBSTRING(t1.oCTS,7,2)),'%m') AS date_add_month,
          SUM(t1.oSum) AS summ_total
          FROM  Opers AS t1
          LEFT JOIN Currs AS t2 ON t1.ocID=t2.cID
          WHERE t1.oCTS>='".$prev_year.sprintf("%02d",$prev_month).sprintf("%02d",$prev_day)."000000'
          AND t1.oCTS<='".$today_year.sprintf("%02d",$today_month).sprintf("%02d",$day)."235959'
          AND t1.oState=3
          ".(($GraphMainOptions['payment_system_select']>0)?" AND t1.ocID='".mysql_escape_string($GraphMainOptions['payment_system_select'])."' ":"")."
          AND t1.ocCurrID='".(!empty($GraphMainOptions['currency_select'])?$GraphMainOptions['currency_select']:"USD")."'
          GROUP BY Oper, date_add
          ORDER BY t1.oCTS";
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
          AND t1.uPTS>='".$prev_year.sprintf("%02d",$prev_month).sprintf("%02d",$prev_day)."000000'
          AND t1.uPTS<='".$today_year.sprintf("%02d",$today_month).sprintf("%02d",$day)."235959'
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
    setPage('max_summ_operation', $max_summ_operation);
    setPage('summ_interval', $summ_interval);
    setPage('date_range', $date_range);

    $payment_system_list=array();
    
    $sql="SELECT t2.cID, t2.cName
          FROM  Opers AS t1
          INNER JOIN Currs AS t2 ON t1.ocID=t2.cID
          WHERE t1.oState=3
          GROUP BY t2.cID
          ORDER BY  t2.cName";
    $result = $db->_doQuery($sql);  

    while($row = $db->fetch($result))
    {
       $payment_system_list[]=$row;
    }
    setPage('operation_graph', $operations_graph);
    setPage('operation_list', $operation_list);
    setPage('payment_system_list', $payment_system_list);
    setPage('from_date', $prev_date);
    setPage('to_date', $today_date);
    setPage('payment_system_select',$GraphMainOptions['payment_system_select']);
    setPage('currency_select',$GraphMainOptions['currency_select']);
    setPage('Graph',$GraphMainOptions['Graph']);

?>