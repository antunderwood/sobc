<?php
if(!defined('IN_INDEX'))
 {
  header('Location: ../index.php');
  exit;
 }

// add slashes to all POSTs, GETs and COOKIEs if magic_quotes_gpc is not enabled:
do_magic_quotes_gpc_if_not_enabled();

// database connection:
$connid = connect_db($db_settings['host'], $db_settings['user'], $db_settings['password'], $db_settings['database']);

// get settings:
$settings = get_settings();

// Bad Behavior check:
if($settings['bad_behavior']==1)
 {
  require_once("modules/bad-behavior/bad-behavior-generic.php");
 }

// look if IP or user agent is banned:
$ip_result=mysql_query("SELECT name, list FROM ".$db_settings['banlists_table']." WHERE name = 'ips' OR name = 'user_agents'", $connid) or raise_error('database_error',mysql_error());
while($data = mysql_fetch_array($ip_result))
 {
  if($data['name'] == 'ips') $ips = $data['list'];
  if($data['name'] == 'user_agents') $user_agents = $data['list'];
 }
mysql_free_result($ip_result);
if(isset($ips) && trim($ips) != '')
 {
  $banned_ips_array = explode(',',trim($ips));
  if(in_array($_SERVER["REMOTE_ADDR"],$banned_ips_array)) raise_error('403');
 }
if(isset($user_agents) && trim($user_agents) != '')
 {
  $banned_user_agents_array = explode(',',trim($user_agents));
  foreach($banned_user_agents_array as $banned_user_agent)
   {
    if($banned_user_agent!='' && (preg_match("/".$banned_user_agent."/i",$_SERVER['HTTP_USER_AGENT']))) raise_error('403');
   }
 }
  
// look if user blocked:
if(isset($_SESSION[$settings['session_prefix'].'user_id']))
 {
  $block_result=mysql_query("SELECT user_lock FROM ".$db_settings['userdata_table']." WHERE user_id = ".intval($_SESSION[$settings['session_prefix'].'user_id'])." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
  $data = mysql_fetch_array($block_result);
  mysql_free_result($block_result);
  if($data['user_lock']==1) 
   {
    log_out($_SESSION[$settings['session_prefix'].'user_id'],'account_locked');
   }  
 }

// user settings:
if(isset($_COOKIE[$settings['session_prefix'].'usersettings']))
 {
  $usersettings_cookie = explode('.',$_COOKIE[$settings['session_prefix'].'usersettings']);
 }

// visited postings:
if(isset($_COOKIE[$settings['session_prefix'].'visited']))
 {
  $visited = explode('.',$_COOKIE[$settings['session_prefix'].'visited']);
 }

if(empty($_SESSION[$settings['session_prefix'].'usersettings']))
 {
  #$usersettings['view'] = $settings['default_view'];
  if(isset($usersettings_cookie[0])) $usersettings['user_view'] = intval($usersettings_cookie[0]);
  else $usersettings['user_view'] = $settings['default_view'];
  if(isset($usersettings_cookie[1])) $usersettings['thread_order'] = intval($usersettings_cookie[1]);
  else $usersettings['thread_order'] = 0;
  if(isset($usersettings_cookie[2])) $usersettings['sidebar'] = intval($usersettings_cookie[2]);
  else $usersettings['sidebar'] = 1;
  if(isset($usersettings_cookie[3])) $usersettings['fold_threads'] = intval($usersettings_cookie[3]);
  else $usersettings['fold_threads'] = $settings['fold_threads'];
  if(isset($usersettings_cookie[4])) $usersettings['thread_display'] = intval($usersettings_cookie[4]);
  else $usersettings['thread_display'] = 0;
  $usersettings['page'] = 1;
  $usersettings['category'] = 0;
  $usersettings['latest_postings'] = 1;
  #$usersettings['tag_cloud'] = 1;
  $_SESSION[$settings['session_prefix'].'usersettings'] = $usersettings;
  setcookie($settings['session_prefix'].'usersettings',$_SESSION[$settings['session_prefix'].'usersettings']['user_view'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_order'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['sidebar'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['fold_threads'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_display'],time()+(3600*24*30));
 }

if(isset($_REQUEST['toggle_sidebar']))
 {
  if(empty($_SESSION[$settings['session_prefix'].'usersettings']['sidebar'])) $_SESSION[$settings['session_prefix'].'usersettings']['sidebar']=1;
  else $_SESSION[$settings['session_prefix'].'usersettings']['sidebar']=0;
  setcookie($settings['session_prefix'].'usersettings',$_SESSION[$settings['session_prefix'].'usersettings']['user_view'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_order'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['sidebar'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['fold_threads'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_display'],time()+(3600*24*30));
  // update database for registered users:
  if(isset($_SESSION[$settings['session_prefix'].'user_id']))
   {
    @mysql_query("UPDATE ".$db_settings['userdata_table']." SET last_login=last_login, last_logout=last_logout, registered=registered, sidebar = ".intval($_SESSION[$settings['session_prefix'].'usersettings']['sidebar'])." WHERE user_id='".intval($_SESSION[$settings['session_prefix'].'user_id'])."'", $connid);
   }
  
  if(isset($_POST['toggle_sidebar'])) exit; // AJAX request
  
  if(isset($_GET['category']) && isset($_GET['page']) && isset($_GET['order'])) $q = '?page='.$_GET['page'].'&category='.$_GET['category'].'&order='.$_GET['order']; else $q = '';
  header('location: index.php'.$q);
  exit;
 } 

if(isset($_GET['thread_order']) && isset($_SESSION[$settings['session_prefix'].'usersettings']['thread_order']))
 {
  $page = 1;
  if($_GET['thread_order']==1) $thread_order = 1;
  else $thread_order = 0;
  if($thread_order != $_SESSION[$settings['session_prefix'].'usersettings']['thread_order'])
   {
    $_SESSION[$settings['session_prefix'].'usersettings']['page']=1;
    $_SESSION[$settings['session_prefix'].'usersettings']['thread_order']=$thread_order;
    setcookie($settings['session_prefix'].'usersettings',$_SESSION[$settings['session_prefix'].'usersettings']['user_view'].'.'.$thread_order.'.'.$_SESSION[$settings['session_prefix'].'usersettings']['sidebar'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['fold_threads'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_display'],time()+(3600*24*30));
    if(isset($_SESSION[$settings['session_prefix'].'user_id'])) @mysql_query("UPDATE ".$db_settings['userdata_table']." SET last_login=last_login, last_logout=last_logout, registered=registered, thread_order=".intval($thread_order)." WHERE user_id='".intval($_SESSION[$settings['session_prefix'].'user_id'])."'", $connid);
   }
 } 

if(isset($_GET['toggle_view']))
 {
  if(isset($_SESSION[$settings['session_prefix'].'usersettings']) && $_SESSION[$settings['session_prefix'].'usersettings']['user_view'] == 0) 
   { 
    $_SESSION[$settings['session_prefix'].'usersettings']['user_view'] = 1;
    setcookie($settings['session_prefix'].'usersettings','1.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_order'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['sidebar'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['fold_threads'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_display'],time()+(3600*24*30));
   }
  elseif(isset($_SESSION[$settings['session_prefix'].'usersettings']) && $_SESSION[$settings['session_prefix'].'usersettings']['user_view'] == 1)  
   { 
    $_SESSION[$settings['session_prefix'].'usersettings']['user_view'] = 0;
    setcookie($settings['session_prefix'].'usersettings','0.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_order'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['sidebar'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['fold_threads'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_display'],time()+(3600*24*30));
   } 
  // update database for registered users:
  if(isset($_SESSION[$settings['session_prefix'].'user_id']))
   {
    @mysql_query("UPDATE ".$db_settings['userdata_table']." SET last_login=last_login, last_logout=last_logout, registered=registered, user_view = ".intval($_SESSION[$settings['session_prefix'].'usersettings']['user_view'])." WHERE user_id='".intval($_SESSION[$settings['session_prefix'].'user_id'])."'", $connid) or die(mysql_error());
   }
  #$clear_cache=true;
  if(isset($_GET['category']) && isset($_GET['page']) && isset($_GET['order'])) $q = '?page='.$_GET['page'].'&category='.$_GET['category'].'&order='.$_GET['order']; else $q = '';
  header('location: index.php'.$q);
  exit;
 } 

if(isset($_GET['toggle_thread_display']) && isset($_GET['id']))
 {
  if(isset($_SESSION[$settings['session_prefix'].'usersettings']) && $_SESSION[$settings['session_prefix'].'usersettings']['thread_display'] == 0) 
   { 
    $_SESSION[$settings['session_prefix'].'usersettings']['thread_display'] = 1;
    setcookie($settings['session_prefix'].'usersettings',$_SESSION[$settings['session_prefix'].'usersettings']['user_view'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_order'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['sidebar'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['fold_threads'].'.1',time()+(3600*24*30));
   }
  elseif(isset($_SESSION[$settings['session_prefix'].'usersettings']) && $_SESSION[$settings['session_prefix'].'usersettings']['thread_display'] == 1)  
   { 
    $_SESSION[$settings['session_prefix'].'usersettings']['thread_display'] = 0;
    setcookie($settings['session_prefix'].'usersettings',$_SESSION[$settings['session_prefix'].'usersettings']['user_view'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_order'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['sidebar'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['fold_threads'].'.0',time()+(3600*24*30));
   } 
  // update database for registered users:
  if(isset($_SESSION[$settings['session_prefix'].'user_id']))
   {
    @mysql_query("UPDATE ".$db_settings['userdata_table']." SET last_login=last_login, last_logout=last_logout, registered=registered, thread_display = ".intval($_SESSION[$settings['session_prefix'].'usersettings']['thread_display'])." WHERE user_id='".intval($_SESSION[$settings['session_prefix'].'user_id'])."'", $connid) or die(mysql_error());
   }
  #$clear_cache=true;
  header('location: index.php?mode=thread&id='.intval($_GET['id']));
  exit;
 } 

if(isset($_GET['fold_threads']))
 {
  if($_SESSION[$settings['session_prefix'].'usersettings']['fold_threads'] == 0) 
   {
    $_SESSION[$settings['session_prefix'].'usersettings']['fold_threads'] = 1;
    setcookie($settings['session_prefix'].'usersettings',$_SESSION[$settings['session_prefix'].'usersettings']['user_view'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_order'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['sidebar'].'.1.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_display'],time()+(3600*24*30));
   } 
  else
   {
    $_SESSION[$settings['session_prefix'].'usersettings']['fold_threads'] = 0;
    setcookie($settings['session_prefix'].'usersettings',$_SESSION[$settings['session_prefix'].'usersettings']['user_view'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_order'].'.'.$_SESSION[$settings['session_prefix'].'usersettings']['sidebar'].'.0.'.$_SESSION[$settings['session_prefix'].'usersettings']['thread_display'],time()+(3600*24*30));
   }
  $clear_cache=true;
  // update database for registered users:
  if(isset($_SESSION[$settings['session_prefix'].'user_id']))
   {
    @mysql_query("UPDATE ".$db_settings['userdata_table']." SET last_login=last_login, last_logout=last_logout, registered=registered, fold_threads = ".intval($_SESSION[$settings['session_prefix'].'usersettings']['fold_threads'])." WHERE user_id='".intval($_SESSION[$settings['session_prefix'].'user_id'])."'", $connid) or die(mysql_error());
   }
  
  if(isset($_GET['category']) && isset($_GET['page']) && isset($_GET['order'])) $q = '?page='.$_GET['page'].'&category='.$_GET['category'].'&order='.$_GET['order']; else $q = '';
  header('location: index.php'.$q);
  exit;
 } 

if(isset($_GET['update']) && isset($_SESSION[$settings['session_prefix'].'usersettings']['newtime']))
 {
  $_SESSION[$settings['session_prefix'].'usersettings']['newtime'] = time();
  if(isset($_SESSION[$settings['session_prefix'].'user_id'])) @mysql_query("UPDATE ".$db_settings['userdata_table']." SET last_login=last_login, last_logout=NOW(), registered=registered WHERE user_id='".intval($_SESSION[$settings['session_prefix'].'user_id'])."'", $connid);
  header('location: index.php?mode=index');
  exit;
 } 

if(isset($_GET['show_spam']) && isset($_SESSION[$settings['session_prefix'].'user_id']) && $_SESSION[$settings['session_prefix'].'user_id']>0)
 {
  if(isset($_SESSION[$settings['session_prefix'].'usersettings']['show_spam'])) unset($_SESSION[$settings['session_prefix'].'usersettings']['show_spam']);
  else $_SESSION[$settings['session_prefix'].'usersettings']['show_spam'] = true;
  header('location: index.php?mode=index');
  exit;
 } 

// determine last visit:
if(empty($_SESSION[$settings['session_prefix'].'user_id']) && $settings['remember_last_visit'] == 1)
 {
  if (isset($_COOKIE[$settings['session_prefix'].'last_visit']))
   {
    $c_last_visit = explode(".", $_COOKIE[$settings['session_prefix'].'last_visit']);
    if (isset($c_last_visit[0])) $c_last_visit[0] = trim($c_last_visit[0]); else $c_last_visit[0] = time();
    if (isset($c_last_visit[1])) $c_last_visit[1] = trim($c_last_visit[1]); else $c_last_visit[1] = time();
    if ($c_last_visit[1] < (time() - 600))
     {
      $c_last_visit[0] = $c_last_visit[1];
      $c_last_visit[1] = time();
      setcookie($settings['session_prefix'].'last_visit',$c_last_visit[0].".".$c_last_visit[1],time()+(3600*24*30));
     }
   }
  else setcookie($settings['session_prefix'].'last_visit',time().".".time(),time()+(3600*24*30));
 }
if(isset($c_last_visit)) $last_visit = intval($c_last_visit[0]); else $last_visit = time();

if(isset($_GET['category'])) 
 {
  $category = intval($_GET['category']);
  $_SESSION[$settings['session_prefix'].'usersettings']['category']=$category;
  $_SESSION[$settings['session_prefix'].'usersettings']['page']=1;
 } 
$categories = get_categories();
$category_ids = get_category_ids($categories);
if($category_ids!=false) $category_ids_query = implode(", ", $category_ids);
if(empty($category)) $category=0;

// show spam?
$display_spam_query_and = ' AND spam = 0';
$display_spam_query_where = ' WHERE spam = 0';
if(isset($_SESSION[$settings['session_prefix'].'usersettings']['show_spam']))
 {
  $display_spam_query_and = '';
  $display_spam_query_where = '';
 } 

// count postings, threads, users and users online:
if ($categories == false) // no categories defined
  {
   $count_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE pid = 0".$display_spam_query_and, $connid);
   list($total_threads) = mysql_fetch_row($count_result);
   mysql_free_result($count_result);
   $count_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table'].$display_spam_query_where, $connid);
   list($total_postings) = mysql_fetch_row($count_result);
   mysql_free_result($count_result);
  }
 else // there are categories
  {
   #foreach($categories as $part) $request_categories[] = "'".mysql_real_escape_string($part)."'";
   #$request_categories = implode(", ", $request_categories).", ''";
   $count_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE pid = 0".$display_spam_query_and." AND category IN (".$category_ids_query.")", $connid);
   list($total_threads) = mysql_fetch_row($count_result);
   mysql_free_result($count_result);
   $count_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE category IN (".$category_ids_query.")".$display_spam_query_and, $connid);
   list($total_postings) = mysql_fetch_row($count_result);
   mysql_free_result($count_result);
  }
// count spam:
$count_spam_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE spam = 1", $connid);
list($total_spam) = mysql_fetch_row($count_spam_result);
mysql_free_result($count_spam_result);


$count_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['userdata_table']." WHERE activate_code=''", $connid);
list($registered_users) = mysql_fetch_row($count_result);

if($settings['count_users_online']>0)
 {
  user_online($settings['count_users_online']);
  $count_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['useronline_table']." WHERE user_id > 0", $connid);
  list($registered_users_online) = mysql_fetch_row($count_result);
  $count_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['useronline_table']." WHERE user_id = 0", $connid);
  list($unregistered_users_online) = mysql_fetch_row($count_result);
  $total_users_online = $unregistered_users_online + $registered_users_online;
 }
mysql_free_result($count_result);

if(isset($settings['time_difference'])) $time_difference = intval($settings['time_difference']);
else $time_difference = 0;
if(isset($_SESSION[$settings['session_prefix'].'usersettings']['time_difference'])) $time_difference = $_SESSION[$settings['session_prefix'].'usersettings']['time_difference']+$time_difference;
#elseif (isset($_COOKIE['user_time_difference'])) $time_difference = $_COOKIE['user_time_difference']+$time_difference;

if(!isset($_SESSION[$settings['session_prefix'].'user_id']) && isset($_COOKIE[$settings['session_prefix'].'auto_login']) && isset($settings['autologin']) && $settings['autologin'] == 1)
 {
  if(isset($_GET['mode'])) $back = $_GET['mode'];
  if(isset($_GET['id'])) $id = intval($_GET['id']);
  $_REQUEST['mode'] = 'login';
 }

// page menu:
if(isset($_SESSION[$settings['session_prefix'].'user_id'])) $menu_result = @mysql_query("SELECT id, menu_linkname FROM ".$db_settings['pages_table']." WHERE menu_linkname!='' ORDER BY order_id ASC", $connid) or raise_error('database_error',mysql_error());
else $menu_result = @mysql_query("SELECT id, menu_linkname FROM ".$db_settings['pages_table']." WHERE menu_linkname!='' AND access=0 ORDER BY order_id ASC", $connid) or raise_error('database_error',mysql_error());
if(mysql_num_rows($menu_result)>0)
 {
  $i=0;
  while($pages_data = mysql_fetch_array($menu_result))
   {
    $menu[$i]['id'] = stripslashes($pages_data['id']);
    $menu[$i]['linkname'] = stripslashes($pages_data['menu_linkname']);
    $i++;
   }
 }
mysql_free_result($menu_result);
?>
