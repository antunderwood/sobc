<?php
if(!defined('IN_INDEX'))
 {
  header('Location: ../index.php');
  exit;
 }

if(isset($_SESSION[$settings['session_prefix'].'usersettings']['user_view'])) $user_view = $_SESSION[$settings['session_prefix'].'usersettings']['user_view'];
else $user_view = $settings['default_view'];

if(isset($_SESSION[$settings['session_prefix'].'usersettings']['fold_threads'])) $fold_threads = $_SESSION[$settings['session_prefix'].'usersettings']['fold_threads'];
else $fold_threads = $settings['fold_threads'];

if(isset($_SESSION[$settings['session_prefix'].'usersettings']['thread_order']))
 {
  if($_SESSION[$settings['session_prefix'].'usersettings']['thread_order']==0) $thread_order = 0;
  else $thread_order = 1;
 }
elseif(isset($_GET['thread_order']))
 {
  if(isset($_GET['thread_order'])) $thread_order = 0;
  else $thread_order = 1;
 }
else $thread_order = 0; 
 
if(isset($_SESSION[$settings['session_prefix'].'usersettings']['category'])) $category = intval($_SESSION[$settings['session_prefix'].'usersettings']['category']);
elseif(isset($_GET['category'])) $category = intval($_GET['category']);
else $category = 0;

if(isset($_GET['page'])) 
 {
  $page = intval($_GET['page']);
  $_SESSION[$settings['session_prefix'].'usersettings']['page']=$page;
 }
if(empty($page)) $page = 1;
  
if(isset($_SESSION[$settings['session_prefix'].'usersettings']['page'])) $page = intval($_SESSION[$settings['session_prefix'].'usersettings']['page']);

if($thread_order==0) $db_thread_order = 'time';
else $db_thread_order = 'last_reply';

$_SESSION[$settings['session_prefix'].'usersettings']['current_page'] = $page;

$descasc="DESC";
$ul = ($page-1) * $settings['threads_per_page'];

// database request
if($categories == false) // no categories defined
 {
  $result=mysql_query("SELECT id, tid FROM ".$db_settings['forum_table']." WHERE pid = 0".$display_spam_query_and." ORDER BY sticky DESC, ".$db_thread_order." ".$descasc." LIMIT ".$ul.", ".$settings['threads_per_page'], $connid) or raise_error('database_error',mysql_error());
 }
elseif(is_array($categories) && $category == 0) // there are categories and all categories should be shown
 {
  $result=mysql_query("SELECT id, tid FROM ".$db_settings['forum_table']." WHERE pid = 0".$display_spam_query_and." AND category IN (".$category_ids_query.") ORDER BY sticky DESC, ".$db_thread_order." ".$descasc." LIMIT ".$ul.", ".$settings['threads_per_page'], $connid) or raise_error('database_error',mysql_error());
 }
elseif(is_array($categories) && $category != 0) // there are categories and only one category should be shown
 {
  if(in_array($category, $category_ids))
   {
    $result=mysql_query("SELECT id, tid FROM ".$db_settings['forum_table']." WHERE category = '".mysql_real_escape_string($category)."' AND pid = 0".$display_spam_query_and." ORDER BY sticky DESC, ".$db_thread_order." ".$descasc." LIMIT ".$ul.", ".$settings['threads_per_page'], $connid) or raise_error('database_error',mysql_error());
    // how many entries?
    $pid_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE pid = 0".$display_spam_query_and." AND category = '".mysql_real_escape_string($category)."'", $connid);
    list($total_threads) = mysql_fetch_row($pid_result);
    mysql_free_result($pid_result);
   }
  else // invalid category
   {
    header('Location: index.php');
    exit;
   }  
 }

$result_count = @mysql_num_rows($result);
if($result_count > 0)
 {
  while($zeile = mysql_fetch_array($result))
   {
    $thread_result = @mysql_query("SELECT id, pid, tid, ".$db_settings['forum_table'].".user_id, user_type, UNIX_TIMESTAMP(time) AS time, UNIX_TIMESTAMP(time + INTERVAL ".$time_difference." MINUTE) AS timestamp, UNIX_TIMESTAMP(last_reply) AS last_reply, name, user_name, subject, IF(text='',true,false) AS no_text, category, views, marked, locked, sticky, spam 
                                   FROM ".$db_settings['forum_table']." 
                                   LEFT JOIN ".$db_settings['userdata_table']." ON ".$db_settings['userdata_table'].".user_id=".$db_settings['forum_table'].".user_id 
                                   WHERE tid = ".$zeile['tid'].$display_spam_query_and." ORDER BY time ASC", $connid) or raise_error('database_error',mysql_error());
    // put result into arrays:
    while($data = mysql_fetch_array($thread_result))
     {
      // how many replies:
      $replies=0;
      if($data['pid']==0)
       {
        $count_replies_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE id!= ".intval($data['id'])." AND tid = ".intval($data['tid']), $connid);
        list($replies) = mysql_fetch_row($count_replies_result);
        mysql_free_result($count_replies_result);
       }
      $data['replies'] = $replies;
      
      if($settings['count_views'] != 0)
       {
        $data['views'] = $data['views']-1; // this subtracts the first view by the author after posting
        if($data['views']<0) $data['views']=0; // prevents negative number of views
       }
      
      if($data['user_id']>0)
       {
        if(!$data['user_name']) $data['name'] = $lang['unknown_user'];
        else $data['name'] = htmlspecialchars(stripslashes($data['user_name']));
       } 
      else $data['name'] = htmlspecialchars(stripslashes($data['name']));
      
      $data['subject'] = htmlspecialchars(stripslashes($data['subject']));
      if(isset($categories[$data['category']]) && $categories[$data['category']]!='') $data['category_name']=$categories[$data['category']];

      // convert formated time to a utf-8:
      $data['formated_time'] = format_time($lang['time_format'],$data['timestamp']);
       
      if($data['pid']==0) $threads[] = $data['id'];
      $data_array[$data['id']] = $data;
      $child_array[$data['pid']][] =  $data['id'];
     }
    $tree[$zeile['id']] = tree($zeile['id'],$child_array);
    mysql_free_result($thread_result);
   }
  @mysql_free_result($result);
 }
  
// latest postings:
if($settings['latest_postings']>0)
 {
  if($categories == false) 
   {
    $latest_postings_result = @mysql_query("SELECT id, pid, tid, name, user_name, ".$db_settings['forum_table'].".user_id, UNIX_TIMESTAMP(time) AS time, UNIX_TIMESTAMP(time + INTERVAL ".$time_difference." MINUTE) AS timestamp, UNIX_TIMESTAMP(last_reply) AS last_reply, subject, category 
                                            FROM ".$db_settings['forum_table']." 
                                            LEFT JOIN ".$db_settings['userdata_table']." ON ".$db_settings['userdata_table'].".user_id=".$db_settings['forum_table'].".user_id
                                            WHERE spam=0 
                                            ORDER BY time DESC LIMIT ".$settings['latest_postings'], $connid) or raise_error('database_error',mysql_error());
   }                                         
  else 
   {
    $latest_postings_result = @mysql_query("SELECT id, pid, tid, name, user_name, ".$db_settings['forum_table'].".user_id, UNIX_TIMESTAMP(time) AS time, UNIX_TIMESTAMP(time + INTERVAL ".$time_difference." MINUTE) AS timestamp, UNIX_TIMESTAMP(last_reply) AS last_reply, subject, category 
                                            FROM ".$db_settings['forum_table']." 
                                            LEFT JOIN ".$db_settings['userdata_table']." ON ".$db_settings['userdata_table'].".user_id=".$db_settings['forum_table'].".user_id
                                            WHERE spam=0 AND category IN (".$category_ids_query.") 
                                            ORDER BY time DESC LIMIT ".$settings['latest_postings'], $connid) or raise_error('database_error',mysql_error());
   }
  if(mysql_num_rows($latest_postings_result)>0)
   {
    $i=0;
    while($latest_postings_data = mysql_fetch_array($latest_postings_result))
     {
      $latest_postings[$i]['id'] = intval($latest_postings_data['id']);
      $latest_postings[$i]['tid'] = intval($latest_postings_data['tid']);
      $latest_postings[$i]['pid'] = intval($latest_postings_data['pid']);
      $latest_postings[$i]['subject'] = htmlspecialchars(stripslashes($latest_postings_data['subject']));
      
      if($latest_postings_data['user_id']>0)
       {
        if(!$latest_postings_data['user_name']) $latest_postings[$i]['name'] = $lang['unknown_user'];
        else $latest_postings[$i]['name'] = htmlspecialchars(stripslashes($latest_postings_data['user_name']));
       } 
      else
       {
        $latest_postings[$i]['name'] = htmlspecialchars(stripslashes($latest_postings_data['name']));
       }
      
      $latest_postings[$i]['timestamp'] = $latest_postings_data['timestamp'];
      $latest_postings[$i]['formated_time'] = format_time($lang['time_format'],$latest_postings_data['timestamp']);
      if(isset($categories[$latest_postings_data['category']]) && $categories[$latest_postings_data['category']]!='') $latest_postings[$i]['category_name']=$categories[$latest_postings_data['category']];    
      $days_ago = floor((time() - $latest_postings_data['time'])/86400);
      $hours_ago = floor(((time() - $latest_postings_data['time'])/3600)-($days_ago*24));
      $minutes_ago = floor(((time() - $latest_postings_data['time'])/60)-($hours_ago*60+$days_ago*1440));
      $latest_postings[$i]['days_ago'] = $days_ago;
      $latest_postings[$i]['hours_ago'] = $hours_ago;
      $latest_postings[$i]['minutes_ago'] = $minutes_ago;
      $i++;
     }
    $smarty->assign('latest_postings',$latest_postings);
   }
  mysql_free_result($latest_postings_result);
 }
 
// tag cloud:
if($settings['tag_cloud']==1) $smarty->assign("tag_cloud",tag_cloud($settings['tag_cloud_day_period'],$settings['tag_cloud_scale_min'],$settings['tag_cloud_scale_max']));

$page_count = ceil($total_threads / $settings['threads_per_page']);

$subnav_link = array('mode'=>'posting', 'title'=>'new_topic_link_title', 'name'=>'new_topic_link');

if(isset($data_array)) $smarty->assign("data",$data_array);
if(isset($tree)) $smarty->assign("tree",$tree);
if(isset($threads)) $smarty->assign("threads",$threads);
$smarty->assign("page",$page);
$smarty->assign("category",$category);
$smarty->assign("page_count",$page_count);
$smarty->assign("browse_array",browse_array($page_count,$page,$settings['page_browse_range'],$settings['page_browse_show_last']));
$smarty->assign("item_count",$total_threads);
$smarty->assign("items_per_page",$settings['threads_per_page']);
$smarty->assign("thread_order",$thread_order);
$smarty->assign("descasc",$descasc);
$smarty->assign('fold_threads',$fold_threads);

if($total_spam>0 && isset($_SESSION[$settings['session_prefix'].'usersettings']['show_spam'])) 
 {
  $smarty->assign('hide_spam_link',true);
  $smarty->assign('delete_spam_link',true);
 }
elseif(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0 && $total_spam>0) $smarty->assign('show_spam_link',true);

$smarty->assign("subnav_link",$subnav_link);
if($user_view==1) $smarty->assign('subtemplate','index_table.tpl.inc');
else $smarty->assign('subtemplate','index.tpl.inc');
$template = 'main.tpl';
?>
