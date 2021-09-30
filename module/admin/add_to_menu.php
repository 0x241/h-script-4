<?php

  $uid = _uid();
  $url=isset($_GET['url'])?trim($_GET['url']):"";
  $url=htmlspecialchars(stripslashes($url));
  $url=str_replace($_GS['root_url'], "", $url);
  $sql="SELECT url
         FROM Admin_menu
         WHERE admin_id='".mysql_escape_string($uid)."'AND url='".mysql_escape_string($url)."'";
  $result = $db->_doQuery($sql);
  $row = $db->fetch($result);
  if (!empty($row['url']))
  {
        $sql="DELETE
              FROM Admin_menu
              WHERE admin_id='".mysql_escape_string($uid)."'
              AND url='".mysql_escape_string($row['url'])."'";
        $db->_doQuery($sql);
  }
  else
  {
     $sql="SELECT COUNT(admin_id) AS count
          FROM Admin_menu
          WHERE admin_id='".mysql_escape_string($uid)."'";
     $result = $db->_doQuery($sql);
     $row = $db->fetch($result);
     if ($row['count'] == 3)
     {
         $sql="SELECT url
              FROM Admin_menu
              WHERE admin_id='".mysql_escape_string($uid)."'
              ORDER BY date_add
              LIMIT 0,1";
         $result = $db->_doQuery($sql);
         $row = $db->fetch($result);
         $sql="DELETE
               FROM Admin_menu
               WHERE admin_id='".mysql_escape_string($uid)."'
               AND url='".mysql_escape_string($row['url'])."'";
         $db->_doQuery($sql);
     }
     $sql="REPLACE INTO Admin_menu(admin_id, url, date_add)
           VALUES('".mysql_escape_string($uid)."', '".mysql_escape_string($url)."', NOW())";
     $db->_doQuery($sql);
  }
  $admin_links=array();
  $admin_links_list=array();
  $sql="SELECT url
        FROM Admin_menu
        WHERE admin_id='".mysql_escape_string($uid)."'
        ORDER BY date_add DESC";
  $result = $db->_doQuery($sql);
  while($row = $db->fetch($result))
  {
    $r=$_rwlinks[$row['url']];
    prepVal($r['category'], 3);
    prepVal($r['admin'], 1);
    $r['admin']=str_replace("{!ru!}", "", $r['admin']);
    $r['admin']=str_replace("{!en!}", "", $r['admin']);
    $ar=explode('/', $r['admin']);
    $r['admin']=$ar[1];
    $admin_links[]=array(
                          'url' => $row['url'],
                          'name' => $r['admin']
                        );
   $admin_links_list[]=$row['url'];
  }
  setPage('defAction', 'add_to_menu');
  setPage('admin_links', $admin_links);
  setPage('admin_links_list', $admin_links_list);

?>