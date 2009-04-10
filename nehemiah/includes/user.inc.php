<?php
if(!defined('IN_INDEX'))
 {
  header('Location: ../index.php');
  exit;
 }
 
// only registered users have access to this section or user area is public:
if(isset($_SESSION[$settings['session_prefix'].'user_id']) || $settings['user_area_public']==1)
 {
  if(isset($_REQUEST['action'])) $action = $_REQUEST['action'];
  else $action = 'main';

  if(isset($_GET['user_lock'])) $action = 'user_lock';
  if(isset($_GET['show_user'])) $action = 'show_user';
  if(isset($_GET['show_posts'])) $action = 'show_posts';
  if(isset($_POST['edit_user_submit'])) $action = 'edit_userdata';
  if(isset($_POST['edit_pw_submit'])) $action = 'edit_pw_submitted';
  if(isset($_POST['edit_email_submit'])) $action = 'edit_email_submit';

  if(isset($_REQUEST['id'])) $id = $_REQUEST['id'];

  switch($action)
   {
    case 'main':
     if(isset($_GET['search_user']) && trim($_GET['search_user'])!='') $search_user = trim($_GET['search_user']);
     
     // count users and pages:
     if(isset($search_user))
      {
       $user_count_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['userdata_table']." WHERE activate_code='' AND lower(user_name) LIKE '".mysql_real_escape_string(my_strtolower($search_user, $lang['charset']))."%'", $connid);
      }
     else
      {
       $user_count_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['userdata_table']." WHERE activate_code=''", $connid);
      } 
     list($total_users) = mysql_fetch_row($user_count_result);
     mysql_free_result($user_count_result);
     $total_pages = ceil($total_users / $settings['users_per_page']);

     // who is online:
     if($settings['count_users_online']>0)
      {
       $useronline_result = mysql_query("SELECT user_id FROM ".$db_settings['useronline_table'], $connid) or raise_error('database_error',mysql_error());
       while($uid_field = mysql_fetch_array($useronline_result))
        {
         $useronline_array[] = $uid_field['user_id'];
        }
       mysql_free_result($useronline_result);
      }

     if(isset($_GET['page'])) $page = intval($_GET['page']); else $page = 1;
     if($page > $total_pages) $page = $total_pages;
     if($page < 1) $page = 1;

     if(isset($_GET['order'])) $order = $_GET['order']; else $order='user_name';
     if($order!='user_id' && $order!='user_name' && $order!='user_email' && $order!='user_type' && $order!='registered' && $order!='logins' && $order!='last_login' && $order!='user_lock') $order='user_name';
     if($order=='user_lock' && (empty($_SESSION[$settings['session_prefix'].'user_type']) || isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']<1)) $order='user_name';
     if(isset($_GET['descasc'])) $descasc = $_GET['descasc']; else $descasc = "ASC";
     if($descasc!='DESC' && $descasc!='ASC') $descasc = 'ASC';

     $ul = ($page-1) * $settings['users_per_page'];

     // get userdata:
     if(isset($search_user))
      {
       $result = @mysql_query("SELECT user_id, user_name, user_type, user_email, email_contact, user_hp, user_lock 
                               FROM ".$db_settings['userdata_table']." 
                               WHERE activate_code='' AND lower(user_name) LIKE '".mysql_real_escape_string(my_strtolower($search_user, $lang['charset']))."%' 
                               ORDER BY ".$order." ".$descasc." 
                               LIMIT ".$ul.", ".$settings['users_per_page'], $connid) or raise_error('database_error',mysql_error());
      }
     else
      {
       $result = @mysql_query("SELECT user_id, user_name, user_type, user_email, email_contact, user_hp, user_lock FROM ".$db_settings['userdata_table']." WHERE activate_code='' ORDER BY ".$order." ".$descasc." LIMIT ".$ul.", ".$settings['users_per_page'], $connid) or raise_error('database_error',mysql_error());
      }
     #$result_count = mysql_num_rows($result);

     $i=0;
     while($row = mysql_fetch_array($result))
      {
       $userdata[$i]['user_id'] = $row['user_id'];
       $userdata[$i]['user_name'] = htmlspecialchars(stripslashes($row['user_name']));
       #$userdata[$i]['user_email'] = htmlspecialchars(stripslashes($row['user_email']));
       #$userdata[$i]['email_contact'] = $row['email_contact'];
       if($row['email_contact']==1) $userdata[$i]['user_email'] = TRUE;
       $userdata[$i]['user_hp'] = htmlspecialchars(stripslashes($row['user_hp']));
       if(trim($userdata[$i]['user_hp'])!='')
        { 
         $userdata[$i]['user_hp'] = add_http_if_no_protocol($userdata[$i]['user_hp']);
        }
       $userdata[$i]['user_type'] = $row['user_type'];
       $userdata[$i]['user_lock'] = $row['user_lock'];
       // count postings:
       if($categories==false) $count_result = @mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE user_id = ".intval($row['user_id']), $connid);
       else $count_result = @mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE user_id = ".intval($row['user_id'])." AND category IN (".$category_ids_query.")", $connid);
       list($postings_count) = mysql_fetch_row($count_result);
       mysql_free_result($count_result);
       $userdata[$i]['postings'] = $postings_count;
       // is user online:
       if(isset($useronline_array) && in_array($row['user_id'], $useronline_array)) $userdata[$i]['online']=TRUE;
       $i++;
      }
     mysql_free_result($result);

     // data for browse navigation:
     $user_page_browse['page'] = $page;
     $user_page_browse['total_items'] = $total_users;
     $user_page_browse['items_per_page'] = $settings['users_per_page'];
     $user_page_browse['browse_array'][] = 1;
     if($page > 5) $user_page_browse['browse_array'][] = 0;
     for($browse=$page-3; $browse<$page+4; $browse++)
      {
       if ($browse > 1 && $browse < $total_pages) $user_page_browse['browse_array'][] = $browse;
      }
     if($page < $total_pages-4) $user_page_browse['browse_array'][] = 0;
     if($total_pages > 1) $user_page_browse['browse_array'][] = $total_pages;
     if($page < $total_pages) $user_page_browse['next_page'] = $page + 1; else $user_page_browse['next_page'] = 0;
     if($page > 1) $user_page_browse['previous_page'] = $page - 1; else $user_page_browse['previous_page'] = 0;
     $smarty->assign('user_page_browse',$user_page_browse);

     if(isset($userdata)) $smarty->assign('userdata',$userdata);
     #$smarty->assign('page',$page);
     $smarty->assign('total_users',$total_users);
     #$smarty->assign('total_pages',$total_pages);
     #$smarty->assign('previous_page',$previous_page);
     #$smarty->assign('next_page',$next_page);

     if(isset($search_user)) 
      {
       $smarty->assign('search_user',htmlspecialchars(stripslashes($search_user)));
       $smarty->assign('search_user_encoded',urlencode($search_user));
      } 
     $smarty->assign('order',$order);
     $smarty->assign('descasc',$descasc);
     $smarty->assign('ul',$ul);
     $smarty->assign('page',$page);
     $smarty->assign('subnav_location','subnav_userarea');
     $smarty->assign('subtemplate','user.tpl.inc');
     $template = 'main.tpl';
    break;
    case 'user_lock':
     $page = intval($_GET['page']);
     if($page < 1) $page = 1;
     $order = urlencode($_GET['order']);
     $descasc = urlencode($_GET['descasc']);
     if(isset($_GET['search_user'])) $search_user_q = '&search_user='.urlencode($_GET['search_user']);
     else $search_user_q = '';

     if(isset($_SESSION[$settings['session_prefix'].'user_type']) && ($_SESSION[$settings['session_prefix'].'user_type']==1 || $_SESSION[$settings['session_prefix'].'user_type']==2))
      {
       $lock_result = @mysql_query("SELECT user_type, user_lock FROM ".$db_settings['userdata_table']." WHERE user_id = ".intval($_GET['user_lock'])." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
       $field = mysql_fetch_array($lock_result);
       mysql_free_result($lock_result);
       if($field['user_type']==0)
        {
         if($field['user_lock'] == 0) $new_lock = 1; else $new_lock = 0;
         @mysql_query("UPDATE ".$db_settings['userdata_table']." SET user_lock='".$new_lock."', last_login=last_login, registered=registered WHERE user_id='".intval($_GET['user_lock'])."' LIMIT 1", $connid);
        }
      }
     header('Location: index.php?mode=user'.$search_user_q.'&page='.$page.'&order='.$order.'&descasc='.$descasc);
     exit;
    break;
    case 'show_user':
     $id = intval($_GET['show_user']);
     
     $result = mysql_query("SELECT user_id, user_type, user_name, user_real_name, gender, birthday, user_email, email_contact, user_hp, user_location, profile, cache_profile, logins, UNIX_TIMESTAMP(registered) AS registered, UNIX_TIMESTAMP(registered + INTERVAL ".$time_difference." MINUTE) AS user_registered, UNIX_TIMESTAMP(last_login + INTERVAL ".$time_difference." MINUTE) AS user_last_login FROM ".$db_settings['userdata_table']."
     LEFT JOIN ".$db_settings['userdata_cache_table']." ON ".$db_settings['userdata_cache_table'].".cache_id=".$db_settings['userdata_table'].".user_id
     WHERE user_id = ".$id." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
     
     if(mysql_num_rows($result)==1)
      {
       $row = mysql_fetch_array($result);
       #mysql_free_result($result);
       // count postings:
       $count_postings_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE user_id = ".$id, $connid);
       list($postings) = mysql_fetch_row($count_postings_result);
       mysql_free_result($count_postings_result);
       // last posting:
       if($categories==false) $result = mysql_query("SELECT id, subject, UNIX_TIMESTAMP(time + INTERVAL ".$time_difference." MINUTE) AS disp_time FROM ".$db_settings['forum_table']." WHERE user_id = ".$id." ORDER BY time DESC LIMIT 1", $connid) or raise_error('database_error',mysql_error());
       else $result = mysql_query("SELECT id, subject, UNIX_TIMESTAMP(time + INTERVAL ".$time_difference." MINUTE) AS disp_time FROM ".$db_settings['forum_table']." WHERE user_id = ".$id." AND category IN (".$category_ids_query.") ORDER BY time DESC LIMIT 1", $connid) or raise_error('database_error',mysql_error());
       $last_posting = mysql_fetch_array($result);
       mysql_free_result($result);
     
       $user_name = htmlspecialchars(stripslashes($row['user_name']));
     
       $year = my_substr($row['birthday'], 0, 4, $lang['charset']);
       $month = my_substr($row['birthday'], 5, 2, $lang['charset']);
       $day = my_substr($row['birthday'], 8, 2, $lang['charset']);
    
       $ystr = strrev(intval(strftime("%Y%m%d"))-intval($year.$month.$day));
       $years = intval(strrev(my_substr($ystr,4,my_strlen($ystr,$lang['charset']),$lang['charset'])));
     
       $smarty->assign('p_user_id', $row['user_id']);
       $smarty->assign('user_name', $user_name);
       $smarty->assign('user_type', $row['user_type']);
       $smarty->assign('user_real_name', htmlspecialchars(stripslashes($row['user_real_name'])));
       $smarty->assign('gender', $row['gender']);
       if($day!=0&&$month!=0&&$year!=0)
        {
         $birthdate['day'] = $day;
         $birthdate['month'] = $month;
         $birthdate['year'] = $year;
         $smarty->assign('birthdate', $birthdate);
         $smarty->assign('years',$years);
        }
       if($row['email_contact']==1) $smarty->assign('user_email',TRUE);
       if(trim($row['user_hp'])!='')
        {
         $row['user_hp'] = add_http_if_no_protocol($row['user_hp']);
        }
       $smarty->assign('user_hp', htmlspecialchars(stripslashes($row['user_hp'])));
       $smarty->assign('user_location', htmlspecialchars(stripslashes($row['user_location'])));
       $smarty->assign('user_registered', format_time($lang['time_format'],$row['user_registered']));
       if($row['user_registered']!=$row['user_last_login']) $smarty->assign('user_last_login', format_time($lang['time_format'],$row['user_last_login']));
       $smarty->assign('postings', $postings);
       if($postings>0) $smarty->assign('postings_percent', number_format($postings/$total_postings*100,1));
       else $smarty->assign('postings_percent', 0);
       $smarty->assign('logins', $row['logins']);
       $days_registered = (time() - $row['registered'])/86400;
       if($days_registered<1) $days_registered=1;
       $smarty->assign('logins_per_day',number_format($row['logins']/$days_registered,2));
       $smarty->assign('postings_per_day',number_format($postings/$days_registered,2));
       $smarty->assign('last_posting_id',$last_posting['id']);
       $smarty->assign('last_posting_time',$last_posting['disp_time']);
       $smarty->assign('last_posting_subject',htmlspecialchars(stripslashes($last_posting['subject'])));
     
       if($settings['avatars']>0)
        {
         if(file_exists('images/avatars/'.$id.'.jpg')) $avatar['image'] = 'images/avatars/'.$id.'.jpg';
         elseif(file_exists('images/avatars/'.$id.'.png')) $avatar['image'] = 'images/avatars/'.$id.'.png';
         elseif(file_exists('images/avatars/'.$id.'.gif')) $avatar['image'] = 'images/avatars/'.$id.'.gif';
         if(isset($avatar))
          {
           $image_info = getimagesize($avatar['image']);
           $avatar['width'] = $image_info[0];
           $avatar['height'] = $image_info[1];
           $smarty->assign('avatar', $avatar);
          } 
        }     
     
       if($row['profile']!='' && $row['cache_profile']=='')
        {
         // no cached profile so parse it and cache it:
         $profile=html_format(stripslashes($row['profile']));
       
         // check if there's already a cached record for this user_id
         list($row_count) = @mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM ".$db_settings['userdata_cache_table']." WHERE cache_id=".intval($row['user_id']), $connid));
         if($row_count==1)
          {
           // there's already a record (cached signature) so update it:
           @mysql_query("UPDATE ".$db_settings['userdata_cache_table']." SET cache_profile='".mysql_real_escape_string($profile)."' WHERE cache_id=".intval($row['user_id']), $connid);
          }
         else
          {
           // prevent double entries (probably not really necessary because we already counted the records):
           @mysql_query("DELETE FROM ".$db_settings['userdata_cache_table']." WHERE cache_id=".intval($row['user_id']), $connid);
           // insert cached profile:
           @mysql_query("INSERT INTO ".$db_settings['userdata_cache_table']." (cache_id, cache_signature, cache_profile) VALUES (".intval($row['user_id']).",'','".mysql_real_escape_string($profile)."')", $connid);
          }
        } 
       elseif($row['profile']=='')
        {
         $profile='';
        }
       else
        {
         // there's already a cached profile so just take it without any parsing:
         $profile = $row['cache_profile'];
        }

       #$profile=nl2br(htmlspecialchars(stripslashes($row['profile'])));
       #if($settings['autolink'] == 1) $profile = make_link($profile);
       #if($settings['bbcode'] == 1) $profile = bbcode($profile);
       #if($settings['smilies'] == 1) $profile = smilies($profile);
       $smarty->assign('profile', $profile);
       $breadcrumbs[0]['link'] = 'index.php?mode=user';
       $breadcrumbs[0]['linkname'] = 'subnav_userarea';
       $smarty->assign('breadcrumbs',$breadcrumbs);
       $smarty->assign('subnav_location','subnav_userarea_show_user');
       $smarty->assign('subnav_location_var',$user_name);
      }
     else
      {
       $subnav_link = array('mode'=>'index', 'title'=>'forum_index_link_title', 'name'=>'forum_index_link');
       $smarty->assign('subnav_link',$subnav_link);
      }
     $smarty->assign('subtemplate','user_profile.tpl.inc');
     $template = 'main.tpl';
    break;
    case 'show_posts':
     $id = intval($_GET['id']);
     $result = mysql_query("SELECT user_id, user_name 
                            FROM ".$db_settings['userdata_table']." 
                            WHERE user_id = ".$id." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
     $row = mysql_fetch_array($result);
     mysql_free_result($result);

     $user_name = htmlspecialchars(stripslashes($row['user_name']));
     
     // count postings:
     if($categories==false) $count_postings_result = @mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE user_id = ".$id, $connid);
     else $count_postings_result = @mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE user_id = ".$id." AND category IN (".$category_ids_query.")", $connid);
     list($user_postings_count) = mysql_fetch_row($count_postings_result);
     mysql_free_result($count_postings_result);
     
     $total_pages = ceil($user_postings_count / $settings['search_results_per_page']);
     if(isset($_GET['page'])) $page = intval($_GET['page']); else $page = 1;
     if($page < 1) $page = 1;
     if($page > $total_pages) $page = $total_pages;
     $ul = ($page-1) * $settings['search_results_per_page'];
     // data for browse navigation:
     $show_posts_browse['page'] = $page;
     $show_posts_browse['total_items'] = $user_postings_count;
     $show_posts_browse['items_per_page'] = $settings['search_results_per_page'];
     $show_posts_browse['browse_array'][] = 1;
     if($page > 5) $show_posts_browse['browse_array'][] = 0;
     for($browse=$page-3; $browse<$page+4; $browse++)
      {
       if ($browse > 1 && $browse < $total_pages) $show_posts_browse['browse_array'][] = $browse;
      }
     if($page < $total_pages-4) $show_posts_browse['browse_array'][] = 0;
     if($total_pages > 1) $show_posts_browse['browse_array'][] = $total_pages;
     if($page < $total_pages) $show_posts_browse['next_page'] = $page + 1; else $show_posts_browse['next_page'] = 0;
     if($page > 1) $show_posts_browse['previous_page'] = $page - 1; else $show_posts_browse['previous_page'] = 0;
     $smarty->assign('show_posts_browse',$show_posts_browse);
     
     if($user_postings_count>0)
      {
       if($categories==false) $result = @mysql_query("SELECT id, pid, tid, user_id, UNIX_TIMESTAMP(time) AS time, UNIX_TIMESTAMP(time + INTERVAL ".$time_difference." MINUTE) AS disp_time, UNIX_TIMESTAMP(last_reply) AS last_reply, subject, category, marked, sticky FROM ".$db_settings['forum_table']." WHERE user_id = ".$id." ORDER BY time DESC LIMIT ".$ul.", ".$settings['search_results_per_page'], $connid);
       else $result = @mysql_query("SELECT id, pid, tid, user_id, UNIX_TIMESTAMP(time) AS time, UNIX_TIMESTAMP(time + INTERVAL ".$time_difference." MINUTE) AS disp_time, UNIX_TIMESTAMP(last_reply) AS last_reply, subject, category, marked, sticky FROM ".$db_settings['forum_table']." WHERE user_id = ".$id." AND category IN (".$category_ids_query.") ORDER BY time DESC LIMIT ".$ul.", ".$settings['search_results_per_page'], $connid);
       $i=0;
       while($row = mysql_fetch_array($result))
        {
         $user_postings_data[$i]['id'] = intval($row['id']);
         $user_postings_data[$i]['pid'] = intval($row['pid']);
         $user_postings_data[$i]['name'] = $user_name;
         $user_postings_data[$i]['subject'] = htmlspecialchars(stripslashes($row['subject']));
         $user_postings_data[$i]['disp_time'] = $row['disp_time'];
         if(isset($categories[$row["category"]]) && $categories[$row['category']]!='') 
          {
           $user_postings_data[$i]['category']=$row["category"];
           $user_postings_data[$i]['category_name']=$categories[$row["category"]];
          } 
         $i++;
        }
       mysql_free_result($result);
      } 
     if(isset($user_postings_data)) $smarty->assign('user_postings_data',$user_postings_data);
     $smarty->assign('user_postings_count',$user_postings_count);
     $smarty->assign('action','show_posts');
     $smarty->assign('id',$id);

     $breadcrumbs[0]['link'] = 'index.php?mode=user';
     $breadcrumbs[0]['linkname'] = 'subnav_userarea';
     $smarty->assign('breadcrumbs',$breadcrumbs);
     $smarty->assign('subnav_location','subnav_userarea_show_posts');
     $smarty->assign('subnav_location_var',$user_name);
     $smarty->assign('subtemplate','user_postings.tpl.inc');
     $template = 'main.tpl';
    break;
    case 'edit_profile':
     if(isset($_SESSION[$settings['session_prefix'].'user_id']))
      {
       $id = $_SESSION[$settings['session_prefix'].'user_id'];
       $result = mysql_query("SELECT user_id, user_name, user_real_name, gender, birthday, user_email, email_contact, user_hp, user_location, signature, profile, time_difference, new_posting_notification, new_user_notification FROM ".$db_settings['userdata_table']." WHERE user_id = ".$id." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
       $row = mysql_fetch_array($result);
       mysql_free_result($result);
       if(trim($row['birthday']) == '' || $row['birthday']=='0000-00-00') $user_birthday = '';
       else
        {
         $year = my_substr($row['birthday'], 0, 4, $lang['charset']);
         $month = my_substr($row['birthday'], 5, 2, $lang['charset']);
         $day = my_substr($row['birthday'], 8, 2, $lang['charset']);
         $user_birthday = $day.'.'.$month.'.'.$year;
        } 
       
       if($row['time_difference']<0) $time_difference_hours = ceil($row['time_difference']/60);
       else $time_difference_hours = floor($row['time_difference']/60);
       $time_difference_minutes = abs($row['time_difference']-$time_difference_hours*60);
       if($time_difference_minutes<10) $time_difference_minutes = '0'.$time_difference_minutes;
       if(intval($row['time_difference'])>0) $user_time_difference = '+'.$time_difference_hours;
       else $user_time_difference = $time_difference_hours;
       if($time_difference_minutes>0) $user_time_difference .= ':'.$time_difference_minutes;
       $smarty->assign('user_time_difference', $user_time_difference);
       
       $smarty->assign('forum_time', format_time($lang['time_format'],time()+intval($settings['time_difference'])*60));
       
       if(isset($_GET['msg'])) $smarty->assign('msg',$_GET['msg']);
       $smarty->assign('user_name', htmlspecialchars(stripslashes($row['user_name'])));
       $smarty->assign('user_real_name', htmlspecialchars(stripslashes($row['user_real_name'])));
       $smarty->assign('user_gender', $row['gender']);
       $smarty->assign('user_birthday', $user_birthday);
       $smarty->assign('user_email',htmlspecialchars(stripslashes($row['user_email'])));
       $smarty->assign('email_contact',$row['email_contact']);
       $smarty->assign('user_hp', htmlspecialchars(stripslashes($row['user_hp'])));
       $smarty->assign('user_location', htmlspecialchars(stripslashes($row['user_location'])));
       $profile=htmlspecialchars(stripslashes($row['profile']));
       $smarty->assign('profile', htmlspecialchars(stripslashes($row['profile'])));
       $smarty->assign('signature', htmlspecialchars(stripslashes($row['signature'])));
       
       if($settings['avatars']>0)
        {
         if(file_exists('images/avatars/'.$_SESSION[$settings['session_prefix'].'user_id'].'.jpg')) $avatar['image'] = 'images/avatars/'.$_SESSION[$settings['session_prefix'].'user_id'].'.jpg';
         elseif(file_exists('images/avatars/'.$_SESSION[$settings['session_prefix'].'user_id'].'.png')) $avatar['image'] = 'images/avatars/'.$_SESSION[$settings['session_prefix'].'user_id'].'.png';
         elseif(file_exists('images/avatars/'.$_SESSION[$settings['session_prefix'].'user_id'].'.gif')) $avatar['image'] = 'images/avatars/'.$_SESSION[$settings['session_prefix'].'user_id'].'.gif';
        
         if(isset($avatar))
          {
           $image_info = getimagesize($avatar['image']);
           $avatar['width'] = $image_info[0];
           $avatar['height'] = $image_info[1];
           $smarty->assign('avatar', $avatar);
          } 
        }
       
       if($_SESSION[$settings['session_prefix'].'user_type']==1||$_SESSION[$settings['session_prefix'].'user_type']==2)
        {
         $smarty->assign('new_posting_notification', $row['new_posting_notification']);
         $smarty->assign('new_user_notification', $row['new_user_notification']);
        }

       $breadcrumbs[0]['link'] = 'index.php?mode=user';
       $breadcrumbs[0]['linkname'] = 'subnav_userarea';
       $smarty->assign('breadcrumbs',$breadcrumbs);
       $smarty->assign('subnav_location','subnav_userarea_edit_user');
       $smarty->assign('subtemplate','user_edit.tpl.inc');
       $template = 'main.tpl';
      }
    break;
    case 'edit_userdata':
     if(isset($_SESSION[$settings['session_prefix'].'user_id']))
      {
       $id = $_SESSION[$settings['session_prefix'].'user_id'];
       if(empty($_POST['email_contact'])) $email_contact = 0;
       else $email_contact = 1;
       $user_hp = trim($_POST['user_hp']);
       $user_real_name = trim($_POST['user_real_name']);
       $user_birthday = trim($_POST['user_birthday']);
       if(isset($_POST['user_gender'])) $gender = intval($_POST['user_gender']);
       else $gender=0;
       if($gender!=0&&$gender!=1&&$gender!=2) $gender=0;
       $user_location = trim($_POST['user_location']);
       $profile = trim($_POST['profile']);
       $signature = trim($_POST['signature']);
       
       // time difference:
       $time_difference = trim($_POST['user_time_difference']);
       if(isset($time_difference[0]) && $time_difference[0]=='-') $negative = true;
       $time_difference_array = explode(':',$_POST['user_time_difference']);
       $hours_difference = abs(intval($time_difference_array[0]));
       if($hours_difference<-24 || $hours_difference>24) $hours_difference = 0;
       if(isset($time_difference_array[1])) $minutes_difference = intval($time_difference_array[1]);
       if(isset($minutes_difference))
        {
         if($minutes_difference<0 || $minutes_difference>59) $minutes_difference = 0;
        }
       else
        {
         $minutes_difference = 0;
        }  
       if(isset($negative)) 
        {
         $time_difference = 0 - ($hours_difference*60 + $minutes_difference);
        }
       else $time_difference = $hours_difference*60 + $minutes_difference;
       
       if(isset($_POST['user_view'])) $user_view = intval($_POST['user_view']); else $user_view=0;
       if($user_view!=0&&$user_view!=1&&$user_view!=2) $user_view = 0;
       if($_SESSION[$settings['session_prefix'].'user_type']==1||$_SESSION[$settings['session_prefix'].'user_type']==2)
        {
         if(isset($_POST['new_posting_notification']) && $_SESSION[$settings['session_prefix'].'user_type']>0) $new_posting_notification = intval($_POST['new_posting_notification']);
         else $new_posting_notification = 0;
         if($new_posting_notification!=0&&$new_posting_notification!=1) $new_posting_notification=0;
         if(isset($_POST['new_user_notification']) && $_SESSION[$settings['session_prefix'].'user_type']>0) $new_user_notification = intval($_POST['new_user_notification']);
         else $new_user_notification = 0;
         if($new_user_notification!=0&&$new_user_notification!=1) $new_user_notification=0;
        }
       else
        {
         $new_posting_notification = 0;
         $new_user_notification = 0;
        }

       // check posted data:
       if(my_strlen(stripslashes($user_hp),$lang['charset']) > $settings['hp_maxlength']) $errors[] = 'error_hp_too_long';
       if(my_strlen(stripslashes($user_real_name),$lang['charset']) > $settings['name_maxlength']) $errors[] = 'error_name_too_long';
       if(isset($user_hp) && $user_hp != '' and !preg_match(HP_PATTERN, $user_hp)) $errors[] = 'error_hp_wrong';
       
       // birthday check:
       if($user_birthday!='')
        {
         if(is_valid_birthday($user_birthday))
          {
           $year = intval(my_substr($user_birthday, 6, 4, $lang['charset']));
           $month = intval(my_substr($user_birthday, 3, 2, $lang['charset']));
           $day = intval(my_substr($user_birthday, 0, 2, $lang['charset']));
           $birthday = $year.'-'.$month.'-'.$day;
          }
         else $errors[] = 'error_invalid_date';
        }
       if(empty($birthday)) $birthday = '0000-00-00';

       if(my_strlen(stripslashes($user_hp),$lang['charset']) > $settings['hp_maxlength']) $errors[] = 'error_hp_too_long';
       if(my_strlen(stripslashes($user_location),$lang['charset']) > $settings['location_maxlength']) $errors[] = 'error_location_too_long';
       $smarty->assign('profil_length',my_strlen(stripslashes($profile), $lang['charset']));
       if(my_strlen(stripslashes($profile), $lang['charset']) > $settings['profile_maxlength']) $errors[] = 'error_profile_too_long';
       $smarty->assign('signature_length',my_strlen(stripslashes($signature), $lang['charset']));
       if(my_strlen(stripslashes($signature), $lang['charset']) > $settings['signature_maxlength']) $errors[] = 'error_signature_too_long';

       // check for too long words:
       $too_long_word = too_long_word(stripslashes($user_real_name),$settings['name_word_maxlength']);
       if($too_long_word) $errors[] = 'error_word_too_long';

       if(empty($too_long_word))
        {
         $too_long_word = too_long_word(stripslashes($user_location),$settings['location_word_maxlength']);
         if($too_long_word) $errors[] = 'error_word_too_long';
        }

       $profile_check = html_format(stripslashes($profile));
       $profile_check = strip_tags($profile_check);
       if(empty($too_long_word))
        {
         $too_long_word = too_long_word($profile_check,$settings['text_word_maxlength']);
         if($too_long_word) $errors[] = 'error_word_too_long';
        }

       $signature_check = signature_format(stripslashes($signature));
       $signature_check = strip_tags($signature_check);
       if(empty($too_long_word))
        {
         $too_long_word = too_long_word($signature_check,$settings['text_word_maxlength']);
         if($too_long_word) $errors[] = 'error_word_too_long';
        }

       if(isset($errors))
        {
         $result = mysql_query("SELECT user_name, user_email FROM ".$db_settings['userdata_table']." WHERE user_id = ".$id." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
         $row = mysql_fetch_array($result);
         mysql_free_result($result);

         $smarty->assign('errors', $errors);
         if(isset($too_long_word)) $smarty->assign('word',$too_long_word);
          $smarty->assign('user_name', htmlspecialchars(stripslashes($row['user_name'])));
         $smarty->assign('user_email', htmlspecialchars(stripslashes($row['user_email'])));
         $smarty->assign('email_contact', $email_contact);
         $smarty->assign('user_hp', htmlspecialchars(stripslashes($user_hp)));
         $smarty->assign('user_real_name', htmlspecialchars(stripslashes($user_real_name)));
         $smarty->assign('user_gender', $gender);
         $smarty->assign('user_birthday', htmlspecialchars(stripslashes($user_birthday)));
         $smarty->assign('user_location', htmlspecialchars(stripslashes($user_location)));
         $smarty->assign('profile', htmlspecialchars(stripslashes($profile)));
         $smarty->assign('signature', htmlspecialchars(stripslashes($signature)));
         $smarty->assign('user_time_difference', htmlspecialchars($_POST['user_time_difference']));
         $smarty->assign('user_view', $user_view);
         $smarty->assign('new_posting_notification', $new_posting_notification);
         $smarty->assign('new_user_notification', $new_user_notification);

         $smarty->assign('time_difference_array',$time_difference_array);
         $breadcrumbs[0]['link'] = 'index.php?mode=user';
         $breadcrumbs[0]['linkname'] = 'subnav_userarea';
         $smarty->assign('breadcrumbs',$breadcrumbs);
         $smarty->assign('subnav_location','subnav_userarea_edit_user');
         $smarty->assign('subtemplate','user_edit.tpl.inc');
         $template = 'main.tpl';
        }
       else
        {
         @mysql_query("UPDATE ".$db_settings['userdata_table']." SET email_contact=".intval($email_contact).", user_hp='".mysql_real_escape_string($user_hp)."', user_real_name='".mysql_real_escape_string($user_real_name)."', gender=".intval($gender).", birthday='".mysql_real_escape_string($birthday)."', user_location='".mysql_real_escape_string($user_location)."', profile='".mysql_real_escape_string($profile)."', signature='".mysql_real_escape_string($signature)."', time_difference=".intval($time_difference).", user_view=".intval($user_view).", new_posting_notification=".intval($new_posting_notification).", new_user_notification=".intval($new_user_notification).", last_login=last_login,last_logout=last_logout,registered=registered WHERE user_id=".intval($id), $connid);
         @mysql_query("DELETE FROM ".$db_settings['userdata_cache_table']." WHERE cache_id=".intval($id), $connid);
         $_SESSION[$settings['session_prefix'].'usersettings']['time_difference'] = intval($time_difference);
         header('Location: index.php?mode=user&action=edit_profile&msg=profile_saved');
         exit;
        }
      }  
    break;
    case 'edit_pw':
     if(isset($_SESSION[$settings['session_prefix'].'user_id']))
      {
       $breadcrumbs[0]['link'] = 'index.php?mode=user';
       $breadcrumbs[0]['linkname'] = 'subnav_userarea';
       $breadcrumbs[1]['link'] = 'index.php?mode=user&amp;action=edit_profile';
       $breadcrumbs[1]['linkname'] = 'subnav_userarea_edit_user';
       $smarty->assign('breadcrumbs',$breadcrumbs);
       $smarty->assign('subnav_location','subnav_userarea_edit_pw');
       $smarty->assign('subtemplate','user_edit_pw.tpl.inc');
       $template = 'main.tpl';
      } 
    break;
    case 'edit_pw_submitted':
     if(isset($_SESSION[$settings['session_prefix'].'user_id']))
      {
       $user_id = $_SESSION[$settings['session_prefix'].'user_id'];
       $pw_result = mysql_query("SELECT user_pw FROM ".$db_settings['userdata_table']." WHERE user_id = ".intval($user_id)." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
       $field = mysql_fetch_array($pw_result);
       mysql_free_result($pw_result);

       $old_pw = trim($_POST['old_pw']);
       $new_pw = trim($_POST['new_pw']);
       $new_pw_conf = trim($_POST['new_pw_conf']);

       if($old_pw=='' or $new_pw=='' or $new_pw_conf =='') $errors[] = 'error_form_uncomplete';
       else
        {
         if(!is_pw_correct($old_pw,$field['user_pw'])) $errors[] = 'error_old_pw_wrong';
         if($new_pw_conf != $new_pw) $errors[] = 'error_pw_conf_wrong';
         if(my_strlen($new_pw, $lang['charset']) < $settings['min_pw_length']) $errors[] = 'error_new_pw_too_short';
        }
       // Update, if no errors:
       if(empty($errors))
        {
         $pw_hash = generate_pw_hash($new_pw);
         $pw_update_result = mysql_query("UPDATE ".$db_settings['userdata_table']." SET user_pw='".mysql_real_escape_string($pw_hash)."', last_login=last_login, registered=registered WHERE user_id=".intval($user_id), $connid);
         header('location: index.php?mode=user&action=edit_profile&msg=pw_changed');
         exit;
        }
       else
        {
         $smarty->assign('errors',$errors);
         $breadcrumbs[0]['link'] = 'index.php?mode=user';
         $breadcrumbs[0]['linkname'] = 'subnav_userarea';
         $breadcrumbs[1]['link'] = 'index.php?mode=user&amp;action=edit_profile';
         $breadcrumbs[1]['linkname'] = 'subnav_userarea_edit_user';
         $smarty->assign('breadcrumbs',$breadcrumbs);
         $smarty->assign('subnav_location','subnav_userarea_edit_pw');
         $smarty->assign('subtemplate','user_edit_pw.tpl.inc');
         $template = 'main.tpl';
        }
      }  
    break;
    case 'edit_email':
     if(isset($_SESSION[$settings['session_prefix'].'user_id']))
      {
       $breadcrumbs[0]['link'] = 'index.php?mode=user';
       $breadcrumbs[0]['linkname'] = 'subnav_userarea';
       $breadcrumbs[1]['link'] = 'index.php?mode=user&amp;action=edit_profile';
       $breadcrumbs[1]['linkname'] = 'subnav_userarea_edit_user';
       $smarty->assign('breadcrumbs',$breadcrumbs);
       $smarty->assign('subnav_location','subnav_userarea_edit_mail');
       $smarty->assign('subtemplate','user_edit_email.tpl.inc');
       $template = 'main.tpl';
      } 
    break;
    case 'edit_email_submit':
     if(isset($_SESSION[$settings['session_prefix'].'user_id']))
     {
     $new_email = trim($_POST['new_email']);
     $new_email_confirm = trim($_POST['new_email_confirm']);
     $pw_new_email = $_POST['pw_new_email'];
     // Check data:
     $email_result = @mysql_query("SELECT user_id, user_name, user_pw, user_email FROM ".$db_settings['userdata_table']." WHERE user_id = ".intval($_SESSION[$settings['session_prefix'].'user_id'])." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
     $data = mysql_fetch_array($email_result);
     mysql_free_result($email_result);
     if($pw_new_email=='' || $new_email=='') $errors[] = 'error_form_uncompl';
     if(empty($errors))
      {
       if($new_email!=$new_email_confirm) $errors[] = 'error_email_confirmation';
       if(my_strlen($new_email, $lang['charset']) > $settings['email_maxlength']) $errors[] = 'error_email_too_long';
       if($new_email == $data['user_email']) $errors[] = 'error_identic_email';
       if(!preg_match(EMAIL_PATTERN, $new_email)) $errors[] = 'error_email_invalid';
       if(!is_pw_correct($pw_new_email,$data['user_pw'])) $errors[] = 'pw_wrong';
      }
     if(empty($errors))
      {
       $smarty->config_load($settings['language_file'],'emails');
       $lang = $smarty->get_config_vars();
       
       $activate_code = random_string(32);
       $activate_code_hash = generate_pw_hash($activate_code);
       // send mail with activation key:
       $lang['edit_address_email_txt'] = str_replace("[name]", $data['user_name'], $lang['edit_address_email_txt']);
       $lang['edit_address_email_txt'] = str_replace("[activate_link]", $settings['forum_address']."index.php?mode=register&id=".$data['user_id']."&key=".$activate_code, $lang['edit_address_email_txt']);
       $lang['edit_address_email_txt'] = stripslashes($lang['edit_address_email_txt']);
       $new_user_mailto = my_mb_encode_mimeheader($data['user_name'], CHARSET, "Q")." <".$new_email.">";
       if(!my_mail($new_user_mailto, $lang['edit_address_email_sj'], $lang['edit_address_email_txt'])) $errors[] = 'error_mailserver';
       
       if(empty($errors))
        {
         @mysql_query("UPDATE ".$db_settings['userdata_table']." SET user_email='".mysql_real_escape_string($new_email)."', last_login=last_login, registered=registered, activate_code = '".mysql_real_escape_string($activate_code_hash)."' WHERE user_id=".intval($_SESSION[$settings['session_prefix'].'user_id']), $connid) or raise_error('database_error',mysql_error());
         log_out($_SESSION[$settings['session_prefix'].'user_id']);
         header("Location: index.php");
         exit;
        }
      }
     if(isset($errors))
      {
       $smarty->assign('new_user_email',htmlspecialchars(stripslashes($new_email)));
       $smarty->assign('errors',$errors);
       $breadcrumbs[0]['link'] = 'index.php?mode=user';
       $breadcrumbs[0]['linkname'] = 'subnav_userarea';
       $breadcrumbs[1]['link'] = 'index.php?mode=user&amp;action=edit_profile';
       $breadcrumbs[1]['linkname'] = 'subnav_userarea_edit_user';
       $smarty->assign('breadcrumbs',$breadcrumbs);
       $smarty->assign('subnav_location','subnav_userarea_edit_mail');
       $smarty->assign('subtemplate','user_edit_email.tpl.inc');
       $template = 'main.tpl';
      }
     } 
    break;
   }
 }
else
 {
  header("location: index.php");
  exit;
}
?>
