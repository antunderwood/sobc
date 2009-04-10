<?php
if(!defined('IN_INDEX'))
 {
  header('Location: ../index.php');
  exit;
 }

$current_time = time();

$smarty->config_load($settings['language_file'],'emails');
$lang = $smarty->get_config_vars();

if(empty($_SESSION[$settings['session_prefix'].'user_id']) && $settings['captcha_posting']>0)
 {
  require('modules/captcha/captcha.php');
  $captcha = new Captcha();
 }

if(isset($_REQUEST['p_category']) && isset($_SESSION[$settings['session_prefix'].'usersettings']['category']) && $_SESSION[$settings['session_prefix'].'usersettings']['category']!=intval($_REQUEST['p_category'])) $_SESSION[$settings['session_prefix'].'usersettings']['category'] = 0;

$category = isset($_SESSION[$settings['session_prefix'].'usersettings']['category']) ? intval($_SESSION[$settings['session_prefix'].'usersettings']['category']) : 0;

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$back = isset($_REQUEST['back']) ? $_REQUEST['back'] : 'index';
$posting_mode = isset($_REQUEST['posting_mode']) ? $_REQUEST['posting_mode'] : 0; // 0 = post, 1 = edit

if(isset($_GET['edit']) && intval($_GET['edit'])>0) $posting_mode = 1;

if(isset($_POST['p_category'])) $p_category = intval($_POST['p_category']);
else $p_category = 0;

#if(isset($_REQUEST['page'])) $page = intval($_REQUEST['page']); else $page = 1;
#if(isset($_REQUEST['order'])) $order = $_REQUEST['order']; else $order = 'last_reply';
#if(isset($_REQUEST['descasc']) && $_REQUEST['descasc']=='ASC') { $descasc = 'DESC'; $page = 1; } else $descasc="DESC";

// determine mode:
if(isset($_SESSION[$settings['session_prefix'].'user_id'])) // registered user
 {
  if($posting_mode==1) // edit
   {
    if(isset($_GET['edit'])) $pu_id = $_GET['edit']; // posting about to edit
    elseif(isset($_POST['id'])) $pu_id = $_POST['id']; // posting edited and submitted
    $pui_result = @mysql_query("SELECT user_id FROM ".$db_settings['forum_table']." WHERE id = ".intval($pu_id)." LIMIT 1", $connid) or die(mysql_error());
    if(mysql_num_rows($pui_result)==1)
     {
      list($posting_user_id) = mysql_fetch_array($pui_result);
      if(isset($posting_user_id) && intval($posting_user_id)>0) $smarty->assign('form_type',1); // posting is by a registered user
      else $smarty->assign('form_type',0); // posting is by an unregistered user
     }
    else // posting not available
     {
      $smarty->assign('no_authorisation','error_posting_unavailable');
     }
    @mysql_free_result($pui_result);
   }
  else // new posting:
   {
    $posting_user_id = $_SESSION[$settings['session_prefix'].'user_id'];
    $smarty->assign('form_type',1);
   }
 }
else // unregistered user:
 {
  $smarty->assign('form_type',0);
 }

if(isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'posting';

if(isset($_GET['lock'])) $action = 'lock';
if(isset($_GET['lock_thread'])) $action = 'lock_thread';
if(isset($_GET['unlock_thread'])) $action = 'unlock_thread';
if(isset($_GET['edit'])) $action = 'edit';
if(isset($_GET['report_spam'])) $action = 'report_spam';
if(isset($_GET['flag_ham'])) $action = 'flag_ham';
if(isset($_GET['delete_marked'])) $action = 'delete_marked';
if(isset($_GET['manage_postings'])) $action = 'manage_postings';
if(isset($_POST['lock_old_threads_submit'])) $action = 'lock_old_threads_submit';
if(isset($_POST['lock_all_threads_submit']) || isset($_POST['unlock_all_threads_submit'])) $action = 'lock_all_threads_submit';
if(isset($_GET['delete_spam'])) $action = 'delete_spam';
if(isset($_POST['report_spam_submit']) || isset($_POST['report_spam_delete_submit'])) $action = 'report_spam_submit';
if(isset($_POST['report_flag_ham_submit']) || isset($_POST['flag_ham_submit'])) $action = 'flag_ham_submit';
if(isset($_POST['delete_marked_submit'])) $action = 'delete_marked_submit';
if(isset($_POST['delete_spam_submit'])) $action = 'delete_spam_submit';
if(isset($_POST['save_entry']) || isset($_POST['preview'])) $action = 'posting_submitted';
if(isset($_REQUEST['mark'])) $action = 'mark';
if(isset($_GET['move_posting'])) $action = 'move_posting'; 

// permission to upload images:
if($settings['upload_images']==1 && isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0) $smarty->assign('upload_images',true);
elseif($settings['upload_images']==2 && isset($_SESSION[$settings['session_prefix'].'user_id'])) $smarty->assign('upload_images',true);
elseif($settings['upload_images']==3) $smarty->assign('upload_images',true);

if(isset($_REQUEST['delete_posting'])) 
 {
  if(empty($_REQUEST['delete_posting_confirm'])) $action = 'delete_posting';
  else $action = 'delete_posting_confirmed';
 } 

// clicked on "spam" but should only be deleted without reporting:
if(isset($_POST['delete_submit'])) 
 {
  $_REQUEST['delete_posting'] = intval($_POST['id']);
  $action = 'delete_posting_confirmed';
 } 

if(isset($_POST['move_posting_submit']) && isset($_POST['move_posting']) && isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0)
 {
  $original_thread_result = @mysql_query("SELECT tid 
                                          FROM ".$db_settings['forum_table']." 
                                          WHERE id = ".intval($_POST['move_posting'])." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
  $o_data = mysql_fetch_array($original_thread_result);
  mysql_free_result($original_thread_result);
  
  if(isset($_POST['move_mode']) && $_POST['move_mode']==1 && isset($_POST['move_to']))
   {
    // move posting:
    list($count) = @mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE id=".intval($_POST['move_to']), $connid));
    if($count!=1 || intval($_POST['move_posting'])==intval($_POST['move_to'])) $errors[] = 'invalid_posting_to_move';
    if(empty($errors))
     {
      $child_ids = get_child_ids($_POST['move_posting']);
      $move_result = @mysql_query("SELECT tid 
                                   FROM ".$db_settings['forum_table']." 
                                   WHERE id = ".intval($_POST['move_to'])." LIMIT 1", $connid);
      $data = mysql_fetch_array($move_result);
      mysql_free_result($move_result);
      @mysql_query("UPDATE ".$db_settings['forum_table']." SET pid=".intval($_POST['move_to']).", tid=".intval($data['tid']).", time=time, last_reply=last_reply, edited=edited WHERE id=".intval($_POST['move_posting']), $connid);
      if(is_array($child_ids))
       {
        foreach($child_ids as $id)
         {
          @mysql_query("UPDATE ".$db_settings['forum_table']." SET tid=".intval($data['tid']).", time=time, last_reply=last_reply, edited=edited WHERE id=".intval($id), $connid);
         }
       }
      // set last reply of original thread:
      $last_reply_result = @mysql_query("SELECT time FROM ".$db_settings['forum_table']." WHERE tid = ".intval($o_data['tid'])." ORDER BY time DESC LIMIT 1", $connid);
      $field = mysql_fetch_array($last_reply_result);
      mysql_free_result($last_reply_result);
      @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, edited=edited, last_reply='".$field['time']."' WHERE tid=".intval($o_data['tid']), $connid);
      // set last reply of new thread:
      $last_reply_result = @mysql_query("SELECT time FROM ".$db_settings['forum_table']." WHERE tid = ".intval($data['tid'])." ORDER BY time DESC LIMIT 1", $connid);
      $field = mysql_fetch_array($last_reply_result);
      mysql_free_result($last_reply_result);
      @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, edited=edited, last_reply='".$field['time']."' WHERE tid=".intval($data['tid']), $connid);
      // set category of new thread:
      $last_reply_result = @mysql_query("SELECT category FROM ".$db_settings['forum_table']." WHERE id = ".intval($data['tid']), $connid);
      $field = mysql_fetch_array($last_reply_result);
      mysql_free_result($last_reply_result);
      @mysql_query("UPDATE ".$db_settings['forum_table']." SET category=".$field['category'].", time=time, edited=edited, last_reply=last_reply WHERE tid=".intval($data['tid']), $connid);
      if(isset($back) && $back=='thread') header('Location: index.php?mode=thread&id='.intval($_POST['move_posting']));
      else header('Location: index.php?id='.intval($_POST['move_posting']));
      exit;
     }
    else
     {
      $smarty->assign('errors',$errors);
      $action = 'move_posting';
     } 
   }
  else
   {
    // make	self-contained thread:
    $child_ids = get_child_ids($_POST['move_posting']);
    @mysql_query("UPDATE ".$db_settings['forum_table']." SET pid=0, tid=".intval($_POST['move_posting']).", time=time, last_reply=last_reply, edited=edited WHERE id=".intval($_POST['move_posting']), $connid);
    if(is_array($child_ids))
     {
      foreach($child_ids as $id)
       {
        @mysql_query("UPDATE ".$db_settings['forum_table']." SET tid=".intval($_POST['move_posting']).", time=time, last_reply=last_reply, edited=edited WHERE id=".intval($id), $connid);
       }
     }
    // set last reply of original thread:
    $last_reply_result = @mysql_query("SELECT time FROM ".$db_settings['forum_table']." WHERE tid = ".intval($o_data['tid'])." ORDER BY time DESC LIMIT 1", $connid);
    $field = mysql_fetch_array($last_reply_result);
    mysql_free_result($last_reply_result);
    @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, edited=edited, last_reply='".$field['time']."' WHERE tid=".intval($o_data['tid']), $connid);
    // set last reply of new thread:
    $last_reply_result = @mysql_query("SELECT time FROM ".$db_settings['forum_table']." WHERE tid = ".intval($_POST['move_posting'])." ORDER BY time DESC LIMIT 1", $connid);
    $field = mysql_fetch_array($last_reply_result);
    mysql_free_result($last_reply_result);
    @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, edited=edited, last_reply='".$field['time']."' WHERE tid=".intval($_POST['move_posting']), $connid);
    if(isset($back) && $back=='thread') header('Location: index.php?mode=thread&id='.intval($_POST['move_posting']));
    else header('Location: index.php?id='.intval($_POST['move_posting']));
    exit;
   } 
 }

     // smilies:
     if($settings['smilies']==1 && ($action=='posting' || $action=='edit' || $action == 'posting_submitted'))
      {
       $smiley_result = @mysql_query("SELECT id, file, code_1, code_2, code_3, code_4, code_5, title FROM ".$db_settings['smilies_table']." ORDER BY order_id ASC", $connid) or raise_error('database_error',mysql_error());
       $i=0;
       while($row = mysql_fetch_array($smiley_result))
        {
         $smilies[$i]['id'] = $row['id'];
         $smilies[$i]['file'] = stripslashes($row['file']);
         $smilies[$i]['code'] = stripslashes($row['code_1']);
         $smilies[$i]['title'] = stripslashes($row['title']); 
         $i++;
        }
       mysql_free_result($smiley_result);
       if(isset($smilies)) 
        {
         $smarty->assign('smilies',$smilies);
         $smarty->assign('smilies_count',count($smilies));
        } 
      }

switch($action)
 {
  case 'mark':
   if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0)
    {
     $id = intval($_REQUEST['mark']);
     $mark_result = @mysql_query("SELECT marked FROM ".$db_settings['forum_table']." WHERE id=".$id." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
     $field = mysql_fetch_array($mark_result);
     mysql_free_result($mark_result);
     if($field['marked']==0) $marked = 1; else $marked = 0;

     @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=edited, marked=".$marked." WHERE id=".$id, $connid);

     if(isset($_POST['method']) && $_POST['method']=='ajax')
      {
       header('Content-Type: application/xml; charset=UTF-8');
       echo '<?xml version="1.0"?>';
       ?><mark><action><?php echo $marked; ?></action></mark><?php
      }
     else
      {
       if(isset($_GET['back'])) header('Location: index.php?id='.intval($_GET['back']));
       else header('Location: index.php?mode=index');
      } 
     exit;
    }
   else
    {
     header('Location: index.php?mode=index');
     exit;
    }
  break;
  case 'posting':
   if($settings['forum_readonly']==1)
    {
     $subnav_link = array('mode'=>'index', 'name'=>'forum_index_link', 'title'=>'forum_index_link_title');
     $smarty->assign("subnav_link",$subnav_link);
     $smarty->assign('no_authorisation','no_auth_readonly');
     $smarty->assign('subtemplate','posting.tpl.inc');
    }
   // is user authorisized to post messages?
   elseif($settings['entries_by_users_only']!=0 && empty($_SESSION[$settings['session_prefix'].'user_id']))
    {
     $back = '&back=posting';
     if(isset($id) && $id>0) $back .= '&id='.$id;
     header('Location: index.php?mode=login&login_message=registered_users_only'.$back);
     exit;
    }
   else
    {
     if($id==0) // new posting
      {
       $link_name = 'back_to_index_link';
       $link_title = 'back_to_index_link_title';
       $smarty->assign('p_category',$category);
       $subnav_link = array('mode'=>$back, 'id' => $id, 'title'=>$link_title, 'name'=>$link_name);
      }
     else // reply
      {
       // get data of message:
       $result = mysql_query("SELECT tid, pid, name, user_name, ".$db_settings['forum_table'].".user_id, subject, category, text, locked 
                              FROM ".$db_settings['forum_table']." 
                              LEFT JOIN ".$db_settings['userdata_table']." ON ".$db_settings['userdata_table'].".user_id=".$db_settings['forum_table'].".user_id
                              WHERE id = ".intval($id), $connid) or raise_error('database_error',mysql_error());
       if(mysql_num_rows($result)==1)
        {
         $field = mysql_fetch_array($result);
         mysql_free_result($result);

         if($field['locked'] > 0)
          {
           $smarty->assign('no_authorisation','posting_locked_no_reply');
          }
         else
          {
           $smarty->assign('subject',htmlspecialchars(stripslashes($field['subject'])));
           $smarty->assign('p_category',$field['category']);
           $text = stripslashes($field['text']);
           $text = quote_reply($text);
           $text = addslashes($text);
           $smarty->assign('text',htmlspecialchars(stripslashes($text)));
           $smarty->assign('hide_quote',true);
          }
         
         $link_name = 'back_to_entry_link';
         $link_title = 'back_to_entry_link_title';
         if($field['user_id']>0)
          {
           if(!$field['user_name']) $smarty->assign('name_repl_subnav',$lang['unknown_user']);
           else $smarty->assign('name_repl_subnav',htmlspecialchars(stripslashes($field['user_name'])));
          } 
         else $smarty->assign('name_repl_subnav',htmlspecialchars(stripslashes($field['name'])));
         
         if(empty($back) || isset($back) && $back=='entry')
          {
           $subnav_link = array('id' => $id, 'title'=>$link_title, 'name'=>$link_name);
          } 
         elseif(isset($back) && $back=='index')
          {
           $subnav_link = array('mode'=>'index', 'name'=>'thread_entry_back_link', 'title'=>'thread_entry_back_title');
          }
         else
          {
           $subnav_link = array('mode'=>$back, 'id' => $id, 'title'=>$link_title, 'name'=>$link_name);
          }
        }
       else
        {
         $subnav_link = array('mode'=>$back, 'title'=>'forum_index_link_title', 'name'=>'forum_index_link');
         $smarty->assign('no_authorisation','error_posting_unavailable');
        } 
      }
       
     if(isset($_COOKIE[$settings['session_prefix'].'userdata']))
      {
       $cookie_parts = explode("|", $_COOKIE[$settings['session_prefix'].'userdata']);
       $smarty->assign('name',htmlspecialchars(stripslashes(urldecode($cookie_parts[0]))));
       if(isset($cookie_parts[1])) htmlspecialchars($smarty->assign('email',stripslashes(urldecode($cookie_parts[1]))));
       if(isset($cookie_parts[2])) htmlspecialchars($smarty->assign('hp',stripslashes(urldecode($cookie_parts[2]))));
       if(isset($cookie_parts[3])) htmlspecialchars($smarty->assign('location',stripslashes(urldecode($cookie_parts[3]))));
       $smarty->assign('setcookie',1);
       $smarty->assign('cookie',TRUE);
      }

     if(isset($_SESSION[$settings['session_prefix'].'user_id'])) 
      {
       list($signature) = @mysql_fetch_row(mysql_query("SELECT signature FROM ".$db_settings['userdata_table']." WHERE user_id=".intval($_SESSION[$settings['session_prefix'].'user_id']), $connid));
       if(!empty($signature))
        {
         $smarty->assign('signature',true);
         $smarty->assign('show_signature',1);
        } 
      } 
      
     $smarty->assign("uniqid",uniqid(""));
     $smarty->assign('posting_mode',0);
     $smarty->assign('id',$id);
     $smarty->assign('back',$back);
     $smarty->assign('action',$action);
     if($settings['terms_of_use_agreement']==1 && empty($_SESSION[$settings['session_prefix'].'user_id'])) $smarty->assign("terms_of_use_agreement",true);
     
     if(isset($_SESSION[$settings['session_prefix'].'user_id']) || $settings['email_notification_unregistered']==1) $smarty->assign('provide_email_notification',true);
     if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0 && (empty($id) || $posting_mode==1 && $pid==0)) $smarty->assign('provide_sticky',true);
     
     $smarty->assign("subnav_link",$subnav_link);
     
     $_SESSION[$settings['session_prefix'].'formtime'] = $current_time;
     
     $smarty->assign('subtemplate','posting.tpl.inc');
    }
  break;
  case 'posting_submitted':
   if($settings['forum_readonly']==1)
    {
     $subnav_link = array('mode'=>'index', 'name'=>'forum_index_link', 'title'=>'forum_index_link_title');
     $smarty->assign("subnav_link",$subnav_link);
     $smarty->assign('no_authorisation','no_auth_readonly');
     $smarty->assign('subtemplate','posting.tpl.inc');
    }
   elseif($settings['entries_by_users_only']!=0 && empty($_SESSION[$settings['session_prefix'].'user_name'])) 
    {
     if(isset($_POST['text']))
      {
       $smarty->assign('no_authorisation','no_auth_session_expired');
       $smarty->assign('text',htmlspecialchars(stripslashes($_POST['text'])));
      }
     else
      {
       $smarty->assign('no_authorisation','no_auth_post_reg_users');
      }
     $smarty->assign('subtemplate','posting.tpl.inc');
    }
   else
    {
   
   if(isset($_POST['posting_mode'])) $posting_mode = intval($_POST['posting_mode']);
   else $posting_mode = 0;

   // clear edit keys
   if($settings['user_edit']==2 && $settings['edit_max_time_period']>0)
    {
     @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=edited, edit_key='' WHERE time < (NOW() - INTERVAL ".intval($settings['edit_max_time_period'])." MINUTE)", $connid);
    }

   // import, trim and complete data:
   if(isset($_POST['uniqid'])) $uniqid = trim($_POST['uniqid']);
   if(isset($_POST['pid'])) $pid = intval($_POST['pid']); else $pid=0;
   if(empty($name) && isset($_POST['name'])) $name = trim($_POST['name']);
   if(empty($user_id)) $user_id = 0;
   if(isset($_POST['email'])) $email = trim($_POST['email']); else $email = '';
   if(isset($_POST['hp'])) $hp = trim($_POST['hp']); else $hp = '';
   if(isset($_POST['location'])) $location = trim($_POST['location']); else $location = '';
   if(isset($_POST['show_signature'])) $show_signature = intval($_POST['show_signature']); else $show_signature=0;
   if(isset($_POST['email_notification'])) $email_notification = intval($_POST['email_notification']); else $email_notification=0;;
   if(isset($_POST['subject'])) $subject = trim($_POST['subject']);
   if(isset($_POST['text'])) $text = trim($_POST['text']);
   if(isset($_POST['setcookie'])) $setcookie = trim($_POST['setcookie']); else $setcookie=0;
   if(isset($_POST['sticky']) && $_POST['sticky']==1 && isset($_SESSION[$settings['session_prefix'].'user_type']) && ($_SESSION[$settings['session_prefix'].'user_type']>0)) $sticky=1; else $sticky=0;
   if(isset($_POST['terms_of_use_agree']) && $_POST['terms_of_use_agree']==1) $terms_of_use_agree=1; else $terms_of_use_agree=0;
   
   if($id!=0 && $posting_mode==0 || $posting_mode==1 && $pid>0)
    {
     // get category of parent posting:
     $c_result = @mysql_query("SELECT category FROM ".$db_settings['forum_table']." WHERE id = ".intval($id)) or raise_error('database_error',mysql_error());
     $c_data = mysql_fetch_array($c_result);
     $p_category = $c_data['category'];
     mysql_free_result($c_result);
    } 
   #elseif(isset($_POST['p_category'])) $p_category = intval($_POST['p_category']);
   // end trim and complete data

   if($posting_mode==0) // new message
    {
     // double entry?
     list($double_entry_count) = @mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE uniqid = '".mysql_real_escape_string($uniqid)."' AND time > (NOW()-INTERVAL 1 HOUR)", $connid));
     if($double_entry_count > 0) 
      {
       header("Location: index.php?mode=index");
       exit;
      } 
     
     // check form session and time used to complete the form: 
     if(empty($_SESSION[$settings['session_prefix'].'user_id']))
      {
       if(empty($_SESSION[$settings['session_prefix'].'formtime'])) $errors[] = 'error_invalid_form';
       else
        {
         $time_need = $current_time - intval($_SESSION[$settings['session_prefix'].'formtime']);
         if($time_need<10) $errors[] = 'error_form_sent_too_fast';
         elseif($time_need>10800) $errors[] = 'error_form_sent_too_slow'; 
         unset($_SESSION[$settings['session_prefix'].'formtime']);
        }
      }
     
     // flood prevention:
     if(empty($_SESSION[$settings['session_prefix'].'user_id']) && isset($_POST['save_entry']))
      {
       list($flood_count) = @mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE user_id = 0 AND ip = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."' AND time > (NOW()-INTERVAL ".$settings['flood_prevention_minutes']." MINUTE)", $connid));
       if($flood_count > 0) 
        {
         $smarty->assign('minutes',$settings['flood_prevention_minutes']);
         $errors[] = 'error_repeated_posting';
        }
      }
     
     // is it a registered user?
     if(isset($_SESSION[$settings['session_prefix'].'user_id']))
      {
       $user_id = $_SESSION[$settings['session_prefix'].'user_id'];
       $name = $_SESSION[$settings['session_prefix'].'user_name'];
      }

      // get thread ID if reply:
      if($id!=0)
       {
        $tid_result = @mysql_query("SELECT tid, name, user_name, ".$db_settings['forum_table'].".user_id, category, locked 
                                   FROM ".$db_settings['forum_table']." 
                                   LEFT JOIN ".$db_settings['userdata_table']." ON ".$db_settings['userdata_table'].".user_id=".$db_settings['forum_table'].".user_id
                                   WHERE id=".intval($id), $connid) or raise_error('database_error',mysql_error());
        if(mysql_num_rows($tid_result)!=1)
         {
          $errors[] = 'error_posting_unavailable';
         }
        else
         {
          $field = mysql_fetch_array($tid_result);
          mysql_free_result($tid_result);
          if($field['locked']!=0) $errors[] = 'posting_locked_no_reply'; 
          if($field['category']!=0 && !in_array($field['category'], $category_ids)) $errors[] = 'error_invalid_category'; 
          $thread = $field['tid'];
          
          if($field['user_id']>0)
           {
            if(!$field['user_name']) $smarty->assign('name_repl_subnav',$lang['unknown_user']);
            else $smarty->assign('name_repl_subnav',htmlspecialchars(stripslashes($field['user_name'])));
           } 
          else $smarty->assign('name_repl_subnav',htmlspecialchars(stripslashes($field['name'])));
          
          $link_name = 'back_to_entry_link';
          $link_title = 'back_to_entry_link_title';
         }
       }
      else
       {
        $thread = 0;
        $link_name = 'back_to_index_link';
        $link_title = 'back_to_index_link_title';
       }
     if(isset($link_title))
      {
       if($back=='entry') $subnav_link = array('id' => $id, 'title'=>$link_title, 'name'=>$link_name);
       else $subnav_link = array('mode'=>$back, 'id' => $id, 'title'=>$link_title, 'name'=>$link_name);
      }
     else
      {
       $subnav_link = array('mode'=>'index', 'name'=>'forum_index_link', 'title'=>'forum_index_link_title');
      }
     $smarty->assign("subnav_link",$subnav_link);
    }

   elseif($posting_mode==1) // edit message
    {
     $edit_result = mysql_query("SELECT ".$db_settings['forum_table'].".user_id, name, user_name, locked, UNIX_TIMESTAMP(time) AS time FROM ".$db_settings['forum_table']."
                                 LEFT JOIN ".$db_settings['userdata_table']." ON ".$db_settings['userdata_table'].".user_id=".$db_settings['forum_table'].".user_id
                                 WHERE id = ".intval($id), $connid) or raise_error('database_error',mysql_error());
     if(mysql_num_rows($edit_result)!=1) $errors[] = 'error_posting_unavailable';
     $field = mysql_fetch_array($edit_result);
     mysql_free_result($edit_result);
     
     if(empty($errors))
      {
       if(empty($name) && $field['user_id']>0) $name = $field['user_name'];
       if($field['user_id']==0) $subnav_name = $field['name'];
       elseif($field['user_id']>0 && isset($name)) $subnav_name = $name;
       else $subnav_name = $lang['unknown_user'];
       
       $subnav_link = array('mode'=>$back, 'id' => $id, 'title'=>'back_to_entry_link_title', 'name'=>'back_to_entry_link');
       $smarty->assign('subnav_link', $subnav_link);
       $smarty->assign('name_repl_subnav',htmlspecialchars(stripslashes($subnav_name)));
    
       if($settings['edit_max_time_period']>0 && (empty($_SESSION[$settings['session_prefix'].'user_type']) || isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']==0))
        {
         $minutes_left_to_edit = round((($field['time']+$settings['edit_max_time_period']*60)-$current_time)/60);
         #if($minutes_left_to_edit==0) $minutes_left_to_edit = '< 1';
         if($minutes_left_to_edit>=0) $smarty->assign('minutes_left_to_edit',$minutes_left_to_edit);
        }
      }
    }

   // check data:
   if(isset($_POST['tags']) && isset($_SESSION[$settings['session_prefix'].'user_type']) && ($_SESSION[$settings['session_prefix'].'user_type']>0)) 
    {
     $tags = trim($_POST['tags']);
     if(my_strlen($tags,$lang['charset']) > 253) $errors[] = 'error_tags_too_long';

     if($tags!='')
      {
       $s_tags = str_replace(';','', $tags);
       $s_tags = str_replace('"', '', $s_tags); 
       $s_tags_array=explode(',',$s_tags);
       $s_tags = ';';
       foreach($s_tags_array as $tag)
        {
         unset($too_long_word);
         $too_long_word = too_long_word($tag,$settings['text_word_maxlength']);
         if($too_long_word) { $errors[] = 'error_word_too_long'; break; }
         $s_tags .= trim($tag).';';
        }
      }
     else $s_tags = '';  
    }
   else $s_tags = '';
   
  
  if($posting_mode==1)
   {
    $edit_result = mysql_query("SELECT tid, pid, name, user_id, email, hp, location, subject, text, tags, category, email_notification, show_signature, sticky, locked, UNIX_TIMESTAMP(time) AS time, edit_key FROM ".$db_settings['forum_table']." WHERE id = ".intval($id), $connid) or raise_error('database_error',mysql_error());
    $field = mysql_fetch_array($edit_result);
    mysql_free_result($edit_result);
    $pid = $field['pid'];
    
     // authorisatin check:
     $authorization = get_edit_authorization($id, $field['user_id'], $field['edit_key'], $field['time'], $field['locked']);
   
     if($authorization['edit']!=true)
      {
       $errors[] = 'no_authorization_edit';
       #$smarty->assign('minutes',$settings['edit_max_time_period']);
      }
   }    
   
   if($posting_mode==1 && empty($errors))
    {
     // e-mail available for notification?
     if(isset($_SESSION[$settings['session_prefix'].'user_id']))
      {  
       if($field['user_id']==0 && $field['email']=='' && isset($email_notification) && $email_notification==1) $errors[] = 'error_no_email_to_notify';    
      }
    }
    
   if(empty($errors))
    {
     // check for not accepted words:
     $result=mysql_query("SELECT list FROM ".$db_settings['banlists_table']." WHERE name = 'words' LIMIT 1", $connid);
     if(!$result) raise_error('database_error',mysql_error());
     $data = mysql_fetch_array($result);
     mysql_free_result($result);
     if(trim($data['list']) != '')
      {
       $joined_message = my_strtolower($name.' '.$email.' '.$hp.' '.$location.' '.$subject.' '.$text, $lang['charset']);
       $not_accepted_words = explode(',',trim($data['list']));
       foreach($not_accepted_words as $not_accepted_word)
        {
         #if($not_accepted_word!='' && (preg_match("/".$not_accepted_word."/i",$name) || preg_match("/".$not_accepted_word."/i",$text) || preg_match("/".$not_accepted_word."/i",$subject) || preg_match("/".$not_accepted_word."/i",$email) || preg_match("/".$not_accepted_word."/i",$hp) || preg_match("/".$not_accepted_word."/i",$location)))
         if($not_accepted_word!='' && my_strpos($joined_message, my_strtolower($not_accepted_word, $lang['charset']), 0, $lang['charset'])!==false) 
          {
           $smarty->assign('not_accepted_word',htmlspecialchars(stripslashes($not_accepted_word)));
           $errors[] = 'error_not_accepted_word';
           break;
          }
        }
      }
   
     if(!isset($name) || $name == '') $errors[] = 'error_no_name';
     
     // name reserved?
     $result = mysql_query("SELECT user_id, user_name FROM ".$db_settings['userdata_table']." WHERE lower(user_name) = '".mysql_real_escape_string(my_strtolower($name, $lang['charset']))."'") or raise_error('database_error',mysql_error());
     if(mysql_num_rows($result)>0) 
      {
       if(empty($_SESSION[$settings['session_prefix'].'user_id']))
        {
         $errors[] = 'error_name_reserved';
        }
       elseif(isset($_SESSION[$settings['session_prefix'].'user_id']))
        {
         $data = mysql_fetch_array($result);
         #if($data['user_id'] != $_SESSION[$settings['session_prefix'].'user_id']) $errors[] = 'error_name_reserved';
         if(isset($posting_user_id) && $data['user_id'] != $posting_user_id) $errors[] = 'error_name_reserved';
        }
      }
     mysql_free_result($result);  
     
     // name = subject?
     if(empty($_SESSION[$settings['session_prefix'].'user_id']) && my_strtolower($name, $lang['charset']) == my_strtolower($subject, $lang['charset'])) $errors[] = 'error_name_like_subject';
     
     if(isset($email) && $email != "" and !preg_match(EMAIL_PATTERN, $email)) $errors[] = 'error_email_wrong';
     if(isset($hp) && $hp != "" and !preg_match(HP_PATTERN, $hp)) $errors[] = 'error_hp_wrong';
     if($email == '' && isset($email_notification) && $email_notification == 1 && !isset($_SESSION[$settings['session_prefix'].'user_id'])) $errors[] = 'error_no_email_to_notify';
     if (empty($subject) || $subject == "") $errors[] = 'error_no_subject';
     if(empty($settings['empty_postings_possible']) || isset($settings['empty_postings_possible']) && $settings['empty_postings_possible'] != 1)
      {
       if (empty($text) || $text == "")
       $errors[] = 'error_no_text';
      }
     
     if($settings['terms_of_use_agreement']==1 && empty($_SESSION[$settings['session_prefix'].'user_id']) && $terms_of_use_agree!=1) $errors[] = 'terms_of_use_agree_error_posting';
     
     if(my_strlen(stripslashes($name),$lang['charset']) > $settings['username_maxlength']) $errors[] = 'error_name_too_long';
     if(my_strlen(stripslashes($email),$lang['charset']) > $settings['email_maxlength']) $errors[] = 'error_email_too_long';
     if(isset($hp) && my_strlen(stripslashes($hp),$lang['charset']) > $settings['hp_maxlength']) $errors[] = 'error_hp_too_long';
     if(my_strlen(stripslashes($location),$lang['charset']) > $settings['location_maxlength']) $errors[] = 'error_location_too_long';
     if(my_strlen(stripslashes($subject),$lang['charset']) > $settings['subject_maxlength']) $errors[] = 'error_subject_too_long';
     if(my_strlen(stripslashes($text),$lang['charset']) > $settings['text_maxlength']) $errors[] = 'error_text_too_long';
     $smarty->assign('text_length',my_strlen(stripslashes($text),$lang['charset']));
     
     // check for too long words:
     if(empty($too_long_word))
      {
       $too_long_word = too_long_word(stripslashes($name),$settings['name_word_maxlength']);
       if($too_long_word) $errors[] = 'error_word_too_long';
      }
     if(empty($too_long_word))
      {
       $too_long_word = too_long_word(stripslashes($location),$settings['location_word_maxlength']);
       if($too_long_word) $errors[] = 'error_word_too_long';
      }
     if(empty($too_long_word))
      {
       $too_long_word = too_long_word(stripslashes($subject),$settings['subject_word_maxlength']);
       if($too_long_word) $errors[] = 'error_word_too_long';
      }
     
     // format text and hide allowed tags:
     $check_text = html_format(stripslashes($text));
     // hide <pre>...</pre> from checking (code):
     $check_text = preg_replace("#\<pre\>(.+?)\</pre\>#is", "", $check_text);
     $check_text = strip_tags($check_text);

     if(empty($too_long_word))
      {
       $too_long_word = too_long_word($check_text,$settings['text_word_maxlength']);
       if($too_long_word) $errors[] = 'error_word_too_long';
      }
    }
   
   // category check:
   if($id==0 && $categories!=false && empty($categories[$p_category])) $errors[] = 'error_invalid_category';

   // CAPTCHA check:
   if(empty($errors) && isset($_POST['save_entry']) && empty($_SESSION[$settings['session_prefix'].'user_id']) && $settings['captcha_posting']>0)
    {
     if($settings['captcha_posting']==2)
      {
       if(empty($_SESSION['captcha_session']) || empty($_POST['captcha_code']) || $captcha->check_captcha($_SESSION['captcha_session'],$_POST['captcha_code'])!=true) $errors[] = 'captcha_check_failed';
      }
     else
      {
       if(empty($_SESSION['captcha_session']) || empty($_POST['captcha_code']) || $captcha->check_math_captcha($_SESSION['captcha_session'][2],$_POST['captcha_code'])!=true) $errors[] = 'captcha_check_failed';
      }
     unset($_SESSION['captcha_session']);
    }

   // default values for flagging spam:
   $spam = 0;
   $spam_check_status = 0;
   
   // Akismet spam check:
   if(empty($errors) && $settings['akismet_key']!='' && $settings['akismet_entry_check']==1 && isset($_POST['save_entry']) && empty($_SESSION[$settings['session_prefix'].'user_id']))
    {
     require('modules/akismet/akismet.class.php');
     $check_posting['author'] = $name;
     if($email!='') $check_posting['email'] = $email;
     if($hp!='') $check_posting['website'] = $hp;
     $check_posting['body'] = $text;
     #$check_posting['permalink']
     #$check_posting['user_ip']
     #$check_posting['user_agent']
     
     $akismet = new Akismet($settings['forum_address'], $settings['akismet_key'], $check_posting); 

     // test for errors
     if($akismet->errorsExist()) // returns true if any errors exist
      { 
       if($akismet->isError(AKISMET_INVALID_KEY)) 
        { 
         if($settings['save_spam']==0) $errors[] = 'error_akismet_api_key';
         else $spam_check_status = 3;
        }
       elseif($akismet->isError(AKISMET_RESPONSE_FAILED)) 
        {
         if($settings['save_spam']==0) $errors[] = 'error_akismet_connection';
         else $spam_check_status = 2;
        } 
       elseif($akismet->isError(AKISMET_SERVER_NOT_FOUND))
        { 
         if($settings['save_spam']==0) $errors[] = 'error_akismet_connection';
         else $spam_check_status = 2;
        } 
      }
     else
      { 
       // No errors, check for spam
       if($akismet->isSpam())
        { 
         if($settings['save_spam']==0) $errors[] = 'error_spam_suspicion';
         else $spam = 1;
        }
       else
        {
         $spam_check_status = 1;
        }
      }      
    }
   // end check data

   if(empty($errors))
    {
     // save new posting:
     if(isset($_POST['save_entry']) && $posting_mode==0)
      {
       if($settings['entries_by_users_only']!=0 && empty($_SESSION[$settings['session_prefix'].'user_name'])) die('No autorisation!');
       
       // if editing own postings by unregistered users, generate edit_key:
       if(empty($_SESSION[$settings['session_prefix'].'user_id']) && $settings['user_edit']==2)
        {
         $edit_key = random_string(32);
         $edit_key_hash = generate_pw_hash($edit_key);
        }
       else 
        {
         $edit_key = '';
         $edit_key_hash = '';
        }
       
       $locked = $spam == 0 ? 0 : 1;
       
       if(isset($_SESSION[$settings['session_prefix'].'user_id'])) $savename = '';
       else $savename = $name;
       
       @mysql_query("INSERT INTO ".$db_settings['forum_table']." (pid, tid, uniqid, time, last_reply, user_id, name, subject, email, hp, location, ip, text, tags, show_signature, email_notification, category, locked, sticky, spam, spam_check_status, edit_key) VALUES (".intval($id).",".intval($thread).",'".mysql_real_escape_string($uniqid)."',NOW(), NOW(),".intval($user_id).",'".mysql_real_escape_string($savename)."','".mysql_real_escape_string($subject)."','".mysql_real_escape_string($email)."','".mysql_real_escape_string($hp)."','".mysql_real_escape_string($location)."','".mysql_real_escape_string($_SERVER["REMOTE_ADDR"])."','".mysql_real_escape_string($text)."','".mysql_real_escape_string($s_tags)."',".intval($show_signature).",".intval($email_notification).",".intval($p_category).",".intval($locked).",".intval($sticky).",".intval($spam).", ".intval($spam_check_status).", '".mysql_real_escape_string($edit_key_hash)."')", $connid) or raise_error('database_error',mysql_error());

       if($id == 0)
        {
         // new thread, set thread id:
         @mysql_query("UPDATE ".$db_settings['forum_table']." SET tid=id, time=time WHERE id = LAST_INSERT_id()", $connid) or raise_error('database_error',mysql_error());
        }
       // reply, set last reply:
       if($id != 0 && $spam == 0)
        {
         @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=NOW() WHERE tid=".$thread, $connid) or raise_error('database_error',mysql_error());
        }
       // get last entry:
       $result_new = mysql_query("SELECT tid, pid, id FROM ".$db_settings['forum_table']." WHERE id = LAST_INSERT_ID()");
       $new_data = mysql_fetch_array($result_new);
       mysql_free_result($result_new);
       
       // if editing own postings by unregistered users, set set cookie/session with edit_key:
       if(empty($_SESSION[$settings['session_prefix'].'user_id']) && $settings['user_edit']==2 && isset($edit_key) && $edit_key!='')
        {
         $_SESSION[$settings['session_prefix'].'edit_keys'][$new_data['id']] = $edit_key;
        }
       
       // lock thread if auto_lock is enabled and there are more than the maximum number of entries in the thread: 
       if($settings['auto_lock']>0 && $new_data['pid']!=0)
        {
         list($thread_count) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE tid=".intval($new_data['tid']), $connid));
         if($thread_count>=$settings['auto_lock']) @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=edited, locked=1 WHERE tid = ".intval($new_data['tid']), $connid);
        }
       
       // e-mail notification:
       if($spam==0) emailNotification2ParentAuthor($new_data['id']);
       
       // e-mail notification to admins and mods
       if($spam==0) emailNotification2ModsAndAdmins($new_data['id']);
        
       // set userdata cookie:
       if($settings['remember_userdata'] == 1)
        {
         if($setcookie==1)
          {
           $cookie_data = urlencode($name).'|'.urlencode($email).'|'.urlencode($hp).'|'.urlencode($location);
           setcookie($settings['session_prefix'].'userdata',$cookie_data,$current_time+(3600*24*30));
          }
        }
       if(isset($back) && $back=='thread') header('Location: index.php?mode=thread&id='.$new_data['id'].'#p'.$new_data['id']);
       else header('Location: index.php?id='.$new_data['id']);
       exit;
      }
     
     // save edited posting:
     elseif(isset($_POST['save_entry']) && $posting_mode==1)
      {
       $tid_result=@mysql_query("SELECT pid, tid, name, location, user_id, category, subject, text FROM ".$db_settings['forum_table']." WHERE id = ".intval($id), $connid) or raise_error('database_error',mysql_error());
       $field = mysql_fetch_array($tid_result);
       mysql_free_result($tid_result);

       // set category if not initial posting:
       if($field['pid']!=0)
        {
         $p_category = intval($field['category']);
        }    
 
       if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']==2 && $settings['dont_reg_edit_by_admin']==1 || isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']==1 && $settings['dont_reg_edit_by_mod']==1 || ($field['text']==$text && $field['subject']==$subject && ($field['user_id']>0 || $field['name']==$name && $field['location']==$location) && isset($_SESSION[$settings['session_prefix'].'user_type']) && ($_SESSION[$settings['session_prefix'].'user_type']==2 || $_SESSION[$settings['session_prefix'].'user_type']==1)))
        {
         // unnoticed editing for admins and mods
         $edited_query = 'edited';
         $edited_by_query = 'edited_by';
         $locked_query = 'locked';
        }
       elseif(isset($_SESSION[$settings['session_prefix'].'user_id'])) 
        {
         $edited_query = 'NOW()';
         $edited_by_query = intval($_SESSION[$settings['session_prefix'].'user_id']);
         $locked_query = 'locked';
        }
       else 
        {
         $edited_query = 'NOW()';
         $edited_by_query = 0;
         $locked_query = $spam == 0 ? 'locked' : 1;
        }
         
       if($field['user_id']>0) // posting of a registered user edited
        {
         @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=".$edited_query.", edited_by=".$edited_by_query.", subject='".mysql_real_escape_string($subject)."', category=".intval($p_category).", email='".mysql_real_escape_string($email)."', hp='".mysql_real_escape_string($hp)."', location='".mysql_real_escape_string($location)."', text='".mysql_real_escape_string($text)."', tags='".mysql_real_escape_string($s_tags)."', email_notification='".intval($email_notification)."', show_signature='".intval($show_signature)."', sticky=".intval($sticky)." WHERE id=".intval($id), $connid);
        }
       else // posting of a not registed user edited
        {
         @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=".$edited_query.", edited_by=".$edited_by_query.", name='".mysql_real_escape_string($name)."', subject='".mysql_real_escape_string($subject)."', category=".intval($p_category).", email='".mysql_real_escape_string($email)."', hp='".mysql_real_escape_string($hp)."', location='".mysql_real_escape_string($location)."', text='".mysql_real_escape_string($text)."', tags='".mysql_real_escape_string($s_tags)."', email_notification='".intval($email_notification)."', show_signature='".intval($show_signature)."', locked=".$locked_query.", sticky=".intval($sticky).", spam=".intval($spam).", spam_check_status=".intval($spam_check_status)." WHERE id=".intval($id), $connid) or die(mysql_error());
        }

       $category_update_result = mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=edited, category=".intval($p_category)." WHERE tid = ".intval($field['tid']), $connid);
       @mysql_query("DELETE FROM ".$db_settings['entry_cache_table']." WHERE cache_id=".intval($id), $connid);
       header('location: index.php?mode='.$back.'&id='.$id);
       exit;
      }
     }
     
    // preview:
    if(isset($_POST['preview']) && empty($errors))
     {
       $smarty->assign('preview',true);
       if(isset($posting_user_id) && intval($posting_user_id)>0)
        {  
         $pr_result = @mysql_query("SELECT email_contact, user_hp, user_location, signature FROM ".$db_settings['userdata_table']." WHERE user_id = ".intval($posting_user_id)." LIMIT 1", $connid) or die(mysql_error());
         $pr_data = mysql_fetch_array($pr_result);
         mysql_free_result($pr_result);
         if($pr_data['email_contact']!=0) $smarty->assign('email',true);
         if(trim($pr_data['user_hp'])!='') 
          {
           $smarty->assign('preview_hp',htmlspecialchars(stripslashes(add_http_if_no_protocol($pr_data['user_hp']))));
          }
         if(trim($pr_data['user_location'])!='') $smarty->assign('preview_location',htmlspecialchars(stripslashes($pr_data['user_location'])));
         if(trim($pr_data['signature'])!='') $smarty->assign('preview_signature',signature_format(stripslashes($pr_data['signature'])));
         if($pr_data['signature']!='') 
          {
           $smarty->assign('signature',true);
           $smarty->assign('show_signature',$show_signature);
          } 
         $smarty->assign('provide_email_notification',true);
        }
       else
        {
         $smarty->assign('email',htmlspecialchars(stripslashes($email)));
         if(trim($hp) != '')
          {
           $smarty->assign('preview_hp',htmlspecialchars(stripslashes(add_http_if_no_protocol($hp))));
          } 
         $smarty->assign('hp',htmlspecialchars(stripslashes($hp)));
         $smarty->assign('location',htmlspecialchars(stripslashes($location)));
         $smarty->assign('preview_location',htmlspecialchars(stripslashes($location)));
         if($settings['email_notification_unregistered']) $smarty->assign('provide_email_notification',true);
        }
       if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0 && (empty($id) || $posting_mode==1 && $pid==0)) $smarty->assign('provide_sticky',true);
       // actual time:
       list($preview_time) = mysql_fetch_row(mysql_query("SELECT UNIX_TIMESTAMP(NOW() + INTERVAL ".$time_difference." MINUTE)"));
       $smarty->assign('preview_timestamp',$preview_time);
       $preview_formated_time = format_time($lang['time_format_full'],$preview_time);
       $smarty->assign('preview_formated_time',$preview_formated_time);
       $smarty->assign('uniqid',$uniqid);
       $smarty->assign('posting_mode',$posting_mode);
       $smarty->assign('id',$id);
       $smarty->assign('pid',$pid);
       $smarty->assign('back',$back);
       $smarty->assign('name',htmlspecialchars(stripslashes($name)));
       $smarty->assign('subject',htmlspecialchars(stripslashes($subject)));
       $smarty->assign('text',htmlspecialchars(stripslashes($text)));
       if(isset($tags)) $smarty->assign('tags',htmlspecialchars(stripslashes($tags)));
       if(isset($p_category)) $smarty->assign('p_category',$p_category);
       $smarty->assign('setcookie',$setcookie);
       $smarty->assign('email_notification',$email_notification);
       $smarty->assign('sticky',$sticky);
       $smarty->assign('preview_name',htmlspecialchars(stripslashes($name)));
       $preview_text = html_format(stripslashes($text));
       if($settings['terms_of_use_agreement']==1 && empty($_SESSION[$settings['session_prefix'].'user_id'])) $smarty->assign("terms_of_use_agreement",true);
       $smarty->assign('terms_of_use_agree',$terms_of_use_agree);
       $smarty->assign('preview_text',$preview_text);
       $smarty->assign('preview_subject',htmlspecialchars(stripslashes($subject)));
       
       $_SESSION[$settings['session_prefix'].'formtime'] = $current_time - 7; // 7 seconds credit for preview
       
       $smarty->assign('subtemplate','posting.tpl.inc');
     }

    if(isset($errors))
     {
      if(isset($show_signature)) $smarty->assign('show_signature',$show_signature);
      if(isset($posting_user_id) && intval($posting_user_id)>0)
       {
        list($signature) = @mysql_fetch_row(mysql_query("SELECT signature FROM ".$db_settings['userdata_table']." WHERE user_id=".intval($posting_user_id), $connid));
        if(!empty($signature)) 
         {
          $smarty->assign('signature',true);
          $smarty->assign('show_signature',$show_signature);
         } 
       }   
      $smarty->assign('id',$id);
      $smarty->assign('pid',$pid);
      $smarty->assign('errors',$errors);
      if(isset($too_long_word)) $smarty->assign('word',$too_long_word);
      $smarty->assign("uniqid",$uniqid);
      $smarty->assign('back',$back);
      $smarty->assign('posting_mode',$posting_mode);
      if(isset($name)) $smarty->assign('name',htmlspecialchars(stripslashes($name)));
      $smarty->assign('email',htmlspecialchars(stripslashes($email)));
      $smarty->assign('hp',htmlspecialchars(stripslashes($hp)));
      $smarty->assign('location',htmlspecialchars(stripslashes($location)));
      $smarty->assign('subject',htmlspecialchars(stripslashes($subject)));
      $smarty->assign('text',htmlspecialchars(stripslashes($text)));
      if(isset($tags)) $smarty->assign('tags',htmlspecialchars(stripslashes($tags)));
      if(isset($p_category)) $smarty->assign('p_category',$p_category);
      $smarty->assign('setcookie',$setcookie);
      $smarty->assign('email_notification',$email_notification);
      $smarty->assign('sticky',$sticky);

      if((isset($posting_user_id) && intval($posting_user_id)>0) || $settings['email_notification_unregistered']==1) $smarty->assign('provide_email_notification',true);
      if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0 && (empty($id) || $posting_mode==1 && $pid==0)) $smarty->assign('provide_sticky',true);     
      
      if($settings['terms_of_use_agreement']==1 && empty($_SESSION[$settings['session_prefix'].'user_id'])) $smarty->assign("terms_of_use_agreement",true);
      $smarty->assign('terms_of_use_agree',$terms_of_use_agree);

      $_SESSION[$settings['session_prefix'].'formtime'] = $current_time - 7; // 7 seconds credit (form already sent)

      $smarty->assign('subtemplate','posting.tpl.inc');
     }
   }
  break;
  case 'edit':
   if($settings['forum_readonly']==1)
    {
     $subnav_link = array('mode'=>'index', 'name'=>'forum_index_link', 'title'=>'forum_index_link_title');
     $smarty->assign("subnav_link",$subnav_link);
     $smarty->assign('no_authorisation','no_auth_readonly');
     $smarty->assign('subtemplate','posting.tpl.inc');
     break;
    }   
   
   $id = intval($_GET['edit']);
   $edit_result = @mysql_query("SELECT tid, pid, name, user_name, ".$db_settings['forum_table'].".user_id, email, hp, location, subject, UNIX_TIMESTAMP(time) AS time, text, tags, category, email_notification, show_signature, sticky, locked, edit_key 
                                FROM ".$db_settings['forum_table']." 
                                LEFT JOIN ".$db_settings['userdata_table']." ON ".$db_settings['userdata_table'].".user_id=".$db_settings['forum_table'].".user_id
                                WHERE id = ".intval($id), $connid) or raise_error('database_error',mysql_error());
   if(mysql_num_rows($edit_result)!=1) 
    {
     $smarty->assign('no_authorisation','error_posting_unavailable');
     $subnav_link = array('mode'=>'index', 'name'=>'thread_entry_back_link', 'title'=>'thread_entry_back_title');
     $smarty->assign("subnav_link",$subnav_link);
     #$_SESSION[$settings['session_prefix'].'formtime'] = $current_time - 7;
     $smarty->assign('subtemplate','posting.tpl.inc');
     break;
    }
   
   $field = mysql_fetch_array($edit_result);
   mysql_free_result($edit_result);

   // authorisatin check:
   $authorization = get_edit_authorization($id, $field['user_id'], $field['edit_key'], $field['time'], $field['locked']);
   
   if($authorization['edit']!=true)
    {
     $smarty->assign('no_authorisation','no_authorization_edit');
     #$smarty->assign('minutes',$settings['edit_max_time_period']);
    }
   elseif($authorization['edit']==true) 
    {
     $tags = htmlspecialchars(stripslashes($field['tags']));
     $tags_array = explode(';',$tags);
     foreach($tags_array as $tag)
      {
       if(trim($tag)!='') $tags_array2[] = $tag;
      }
     if(isset($tags_array2)) $tags = implode(', ',$tags_array2);
     else $tags = ''; 
     
     // if posting is by a registered user, check if he has signature
     if($field['user_id']>0)
      {
       list($signature) = @mysql_fetch_row(mysql_query("SELECT signature FROM ".$db_settings['userdata_table']." WHERE user_id=".intval($field['user_id']), $connid));
       if(!empty($signature))
        {
         $smarty->assign('signature',true);
         $smarty->assign('show_signature',$field['show_signature']);
        } 
      }
     
     if($settings['edit_max_time_period']>0 && (empty($_SESSION[$settings['session_prefix'].'user_type']) || isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']==0))
      {
       $minutes_left_to_edit = round((($field['time']+$settings['edit_max_time_period']*60)-$current_time)/60);
       $smarty->assign('minutes_left_to_edit',$minutes_left_to_edit);
      }
      
     $smarty->assign('id',$id);
     $smarty->assign('pid',$field['pid']);
     $smarty->assign('name',htmlspecialchars(stripslashes($field['name'])));
     $smarty->assign('email',htmlspecialchars(stripslashes($field['email'])));
     $smarty->assign('hp',htmlspecialchars(stripslashes($field['hp'])));
     $smarty->assign('location',htmlspecialchars(stripslashes($field['location'])));
     $smarty->assign('subject',htmlspecialchars(stripslashes($field['subject'])));
     $smarty->assign('text',htmlspecialchars(stripslashes($field['text'])));
     $smarty->assign('tags',$tags);
     $smarty->assign('p_category',$field['category']);
     $smarty->assign('email_notification',$field['email_notification']);
     #$smarty->assign('show_signature',$field['show_signature']);
     $smarty->assign('sticky',$field['sticky']);
     $smarty->assign('back',$back);
     $smarty->assign('posting_mode',1);
     if($settings['terms_of_use_agreement']==1 && empty($_SESSION[$settings['session_prefix'].'user_id'])) $smarty->assign("terms_of_use_agreement",true);
    }
   
   if($field['user_id']>0)
    {
     if(!$field['user_name']) $smarty->assign('name_repl_subnav',$lang['unknown_user']);
     else $smarty->assign('name_repl_subnav',htmlspecialchars(stripslashes($field['user_name'])));
    } 
   else $smarty->assign('name_repl_subnav',htmlspecialchars(stripslashes($field['name'])));
   
   if($field['user_id']>0 || $settings['email_notification_unregistered']) $smarty->assign('provide_email_notification',true);
   if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0 && (empty($id) || $posting_mode==1 && $field['pid']==0)) $smarty->assign('provide_sticky',true);
   
   $subnav_link = array('mode'=>$back, 'id' => $id, 'title'=>'back_to_entry_link_title', 'name'=>'back_to_entry_link');
   $smarty->assign('subnav_link',$subnav_link);

   #$_SESSION[$settings['session_prefix'].'formtime'] = $current_time - 7;

   $smarty->assign('subtemplate','posting.tpl.inc');
  break;
  case 'delete_posting':
   $delete_check_result = @mysql_query("SELECT pid, name, user_name, subject, ".$db_settings['forum_table'].".user_id, UNIX_TIMESTAMP(time) AS time, UNIX_TIMESTAMP(time + INTERVAL ".$time_difference." MINUTE) AS disp_time, locked, edit_key 
                                       FROM ".$db_settings['forum_table']." 
                                       LEFT JOIN ".$db_settings['userdata_table']." ON ".$db_settings['userdata_table'].".user_id=".$db_settings['forum_table'].".user_id
                                       WHERE id = ".intval($_REQUEST['delete_posting']), $connid) or raise_error('database_error',mysql_error());
   $field = mysql_fetch_array($delete_check_result);
   mysql_free_result($delete_check_result);
   
   if($field['user_id']>0)
    {
     if(!$field['user_name']) $field['name'] = $lang['unknown_user'];
     else $field['name'] = $field['user_name'];
    } 
   
   $authorization = get_edit_authorization(intval($_REQUEST['delete_posting']), $field['user_id'], $field['edit_key'], $field['time'], $field['locked']);
   
   if($authorization['delete']==true)
    {
     $smarty->assign('id',intval($_REQUEST['delete_posting']));
     $smarty->assign('pid',$field['pid']);
     $smarty->assign('name',htmlspecialchars(stripslashes($field['name'])));
     $smarty->assign('subject',htmlspecialchars(stripslashes($field['subject'])));
     $smarty->assign('formated_time',format_time($lang['time_format_full'],$field['disp_time']));
     if(isset($_REQUEST['back'])) $smarty->assign('back',$_REQUEST['back']);
     #$smarty->assign('page',$page);
     #$smarty->assign('order',$order);
     #$smarty->assign('descasc',$descasc);
     $smarty->assign('category',$category);
     $smarty->assign('posting_mode',1);
    }
   else         
    {
     $smarty->assign('no_authorisation','no_authorisation_delete');
    }  
   $smarty->assign('name_repl_subnav',htmlspecialchars(stripslashes($field['name'])));
   $backlink = 'entry';
   $subnav_link = array('mode'=>$back, 'id' => intval($_REQUEST['delete_posting']), 'title'=>'back_to_entry_link_title', 'name'=>'back_to_entry_link');
   $smarty->assign("subnav_link",$subnav_link);
   $smarty->assign('subtemplate','posting_delete.tpl.inc');
  break;
  case 'delete_posting_confirmed':
   $delete_check_result = mysql_query("SELECT pid, name, subject, user_id, UNIX_TIMESTAMP(time) AS time, UNIX_TIMESTAMP(time + INTERVAL ".$time_difference." MINUTE) AS disp_time, locked, edit_key FROM ".$db_settings['forum_table']." WHERE id = ".intval($_REQUEST['delete_posting']), $connid) or raise_error('database_error',mysql_error());
   $field = mysql_fetch_array($delete_check_result);
   mysql_free_result($delete_check_result);
   $authorization = get_edit_authorization(intval($_REQUEST['delete_posting']), $field['user_id'], $field['edit_key'], $field['time'], $field['locked']);
   if($authorization['delete']==true)
    {
     if(isset($_REQUEST['back']))
      {
       $result = @mysql_query("SELECT pid FROM ".$db_settings['forum_table']." WHERE id=".intval($_REQUEST['delete_posting'])." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
       if(mysql_num_rows($result)==1)
        {
         $data = mysql_fetch_array($result);
         if($data['pid']!=0) $pid = $data['pid'];
        } 
      } 
     delete_posting_recursive($_REQUEST['delete_posting']);
     if(isset($_REQUEST['back']) && $_REQUEST['back']=='entry' && isset($pid)) header('Location: index.php?id='.$pid); 
     elseif(isset($_REQUEST['back']) && $_REQUEST['back']=='thread' && isset($pid)) header('Location: index.php?mode=thread&id='.$pid);
     else header('Location: index.php?mode=index');
     exit;
    }
   else         
    {
     $smarty->assign('no_authorisation','no_authorisation_delete');
    }      
   if($field['name']) $smarty->assign('name_repl_subnav',htmlspecialchars(stripslashes($field['name'])));
   else $smarty->assign('name_repl_subnav',$lang['unknown_user']);
   $backlink = 'entry';
   $subnav_link = array('mode'=>$back, 'id' => $id, 'title'=>'back_to_entry_link_title', 'name'=>'back_to_entry_link');
   $smarty->assign("subnav_link",$subnav_link);
   $smarty->assign('subtemplate','posting_delete.tpl.inc');
  break;
  case 'delete_marked':
   if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0)
    {
     // OK.
    }
   else 
    {
     $smarty->assign('no_authorisation','no_authorisation');
    }
   $subnav_link = array('mode'=>'index', 'title'=>'back_to_index_link_title', 'name'=>'back_to_index_link');   
   $smarty->assign("subnav_link",$subnav_link);
   $smarty->assign('subtemplate','posting_delete_marked.tpl.inc');
  break;
  case 'delete_marked_submit':
   if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0)
    {
     $result = mysql_query("SELECT id FROM ".$db_settings['forum_table']." WHERE marked = 1", $connid) or raise_error('database_error',mysql_error());
     while($data = mysql_fetch_array($result))
      {
       delete_posting_recursive($data['id']);
      }
     mysql_free_result($result);
    }
   header('Location: index.php?mode=index');
   exit;
  break;
  case 'move_posting':
   if(isset($_REQUEST['move_posting']) && intval($_REQUEST['move_posting'])>0)
    {
     $move_result = @mysql_query("SELECT pid, name, user_name, subject, ".$db_settings['forum_table'].".user_id, UNIX_TIMESTAMP(time) AS time, UNIX_TIMESTAMP(time + INTERVAL ".$time_difference." MINUTE) AS disp_time, locked, edit_key 
                                  FROM ".$db_settings['forum_table']." 
                                  LEFT JOIN ".$db_settings['userdata_table']." ON ".$db_settings['userdata_table'].".user_id=".$db_settings['forum_table'].".user_id
                                  WHERE id = ".intval($_REQUEST['move_posting']), $connid) or raise_error('database_error',mysql_error());
     $field = mysql_fetch_array($move_result);
     if(mysql_num_rows($move_result)==1)
      {
       if($field['user_id']>0)
        {
         if(!$field['user_name']) $field['name'] = $lang['unknown_user'];
         else $field['name'] = $field['user_name'];
        } 
       if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0)
        {
         $smarty->assign('move_posting',intval($_REQUEST['move_posting']));
         if($field['pid']==0) $smarty->assign('posting_type',0);
         else $smarty->assign('posting_type',1);
        }
       else
        {
         $smarty->assign('no_authorisation','no_authorisation');
        }
       $smarty->assign('name',htmlspecialchars(stripslashes($field['name'])));
       $smarty->assign('subject',htmlspecialchars(stripslashes($field['subject'])));
       $smarty->assign('formated_time',format_time($lang['time_format_full'],$field['disp_time']));
       $smarty->assign('name_repl_subnav',htmlspecialchars(stripslashes($field['name'])));
       $subnav_link = array('mode'=>$back, 'id' => intval($_REQUEST['move_posting']), 'title'=>'back_to_entry_link_title', 'name'=>'back_to_entry_link');
       $smarty->assign("back",$back);
       $smarty->assign("subnav_link",$subnav_link);
       $smarty->assign('subtemplate','posting_move.tpl.inc');
      }
     else
      {
       header('Location: index.php?mode=index');
       exit;
      } 
     mysql_free_result($move_result);
    }
  break;
  case 'manage_postings':
   if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0)
    {
     // OK.
    }
   else 
    {
     $smarty->assign('no_authorisation','no_authorisation');
    }
   $subnav_link = array('mode'=>'index', 'title'=>'back_to_index_link_title', 'name'=>'back_to_index_link');   
   $smarty->assign("subnav_link",$subnav_link);
   $smarty->assign('subtemplate','posting_manage_postings.tpl.inc');
  break;
  case 'lock_old_threads_submit':
   if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0)
    {
     $days = intval($_POST['days']);
     if($days > 0)
      {
       @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=edited, locked=1 WHERE locked=0 AND last_reply < (NOW() - INTERVAL ".intval($days)." DAY)", $connid);
       /*
       $result = mysql_query("SELECT id FROM ".$db_settings['forum_table']." WHERE pid=0 AND time < (NOW() - INTERVAL ".intval($days)." DAY)", $connid) or raise_error('database_error',mysql_error());
       while($data = mysql_fetch_array($result))
        {
         @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=edited, locked=1 WHERE tid = ".intval($data['id']), $connid);
        }
       mysql_free_result($result);
       */
      }
    }
   header('Location: index.php?mode=index');
   exit;
  break;
  case 'lock_all_threads_submit':
   if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0)
    {
     if(isset($_POST['lock_all_threads_submit']))
      {
       @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=edited, locked=1", $connid);
      }
     elseif(isset($_POST['unlock_all_threads_submit']))
      {
       @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=edited, locked=0", $connid);
      }
    }
   header('Location: index.php?mode=index');
   exit;
  break;
  case 'delete_spam':
   if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0)
    {
     // OK.
    }
   else 
    {
     $smarty->assign('no_authorisation','no_authorisation');
    }
   $subnav_link = array('mode'=>'index', 'id' => $id, 'title'=>'back_to_index_link_title', 'name'=>'back_to_index_link');   
   $smarty->assign("subnav_link",$subnav_link);
   $smarty->assign('subtemplate','posting_delete_spam.tpl.inc');
  break;
  case 'delete_spam_submit':
   if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0)
    {
     $result = mysql_query("SELECT id FROM ".$db_settings['forum_table']." WHERE spam=1", $connid) or raise_error('database_error',mysql_error());
     while($data = mysql_fetch_array($result))
      {
       delete_posting_recursive($data['id']);
      }
     mysql_free_result($result);
    }
   header('Location: index.php?mode=index');
   exit;
  break;
  case 'report_spam':
   $id = intval($_GET['report_spam']);
   $delete_result = mysql_query("SELECT tid, pid, UNIX_TIMESTAMP(time + INTERVAL ".$time_difference." MINUTE) AS disp_time, name, subject, category, spam, spam_check_status FROM ".$db_settings['forum_table']." WHERE id = ".$id." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
   $field = mysql_fetch_array($delete_result);
   if(mysql_num_rows($delete_result)==1)
   {
   if(empty($_SESSION[$settings['session_prefix'].'user_type']) || $_SESSION[$settings['session_prefix'].'user_type']!=1&&$_SESSION[$settings['session_prefix'].'user_type']!=2)
    {
     $smarty->assign('no_authorisation','no_auth_delete');
    }
   else
    {
     $smarty->assign('id',$id);
     $smarty->assign('pid',$field['pid']);
     $smarty->assign('name',htmlspecialchars(stripslashes($field['name'])));
     $smarty->assign('subject',htmlspecialchars(stripslashes($field['subject'])));
     $smarty->assign('disp_time',$field['disp_time']);
     $smarty->assign('spam',intval($field['spam']));
     $smarty->assign('spam_check_status',intval($field['spam_check_status']));
     $smarty->assign('back',$back);
     #$smarty->assign('page',$page);
     #$smarty->assign('order',$order);
     #$smarty->assign('descasc',$descasc);
     $smarty->assign('category',$category);
     $smarty->assign('posting_mode',1);
    } 
  if($field['name']) $smarty->assign('name_repl_subnav',htmlspecialchars(stripslashes($field['name'])));
  else $smarty->assign('name_repl_subnav',$lang['unknown_user']);
   $subnav_link = array('mode'=>$back, 'id' => $id, 'title'=>'back_to_entry_link_title', 'name'=>'back_to_entry_link');
   }
   else $subnav_link = array('mode'=>'index', 'name'=>'forum_index_link', 'title'=>'forum_index_link_title');
   $smarty->assign("subnav_link",$subnav_link);
   #$backlink = 'entry';
   $smarty->assign('subtemplate','posting_report_spam.tpl.inc');
   mysql_free_result($delete_result);
  break;
  case 'report_spam_submit':
   if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0)
    {
     if($settings['akismet_key']!='' && $settings['akismet_entry_check']==1)
      {
       $result = mysql_query("SELECT name, email, hp, subject, location, text FROM ".$db_settings['forum_table']." WHERE id = ".intval($id)." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
       $data = mysql_fetch_array($result);
       if(mysql_num_rows($result)==1)
        {
         require('modules/akismet/akismet.class.php');
         $check_posting['author'] = $data['name'];
         if($data['email'] != '') $check_posting['email'] = $data['email'];
         if($data['hp'] != '') $check_posting['website'] = $data['hp'];
         $check_posting['body'] = $data['text'];
         $akismet = new Akismet($settings['forum_address'], $settings['akismet_key'], $check_posting);
         if(!$akismet->errorsExist())
          { 
           $akismet->submitSpam();
          } 
        }
       mysql_free_result($result);
      }
     if(isset($_POST['report_spam_delete_submit']))
      {
       delete_posting_recursive($id);
       header('location: index.php?mode=index');
       exit;
      }
     else
      {
       header('location: index.php?id='.$id);
       exit;
      }  
    }
   else die('No authorisation!');
  break;
  case 'flag_ham':
   $id = intval($_GET['flag_ham']);
   $result = mysql_query("SELECT tid, pid, UNIX_TIMESTAMP(time + INTERVAL ".$time_difference." MINUTE) AS disp_time, name, subject, category, spam, spam_check_status FROM ".$db_settings['forum_table']." WHERE id = ".$id." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
   $field = mysql_fetch_array($result);
   if(mysql_num_rows($result)==1)
    {
     if(empty($_SESSION[$settings['session_prefix'].'user_type']) || $_SESSION[$settings['session_prefix'].'user_type']!=1&&$_SESSION[$settings['session_prefix'].'user_type']!=2)
      {
       $smarty->assign('no_authorisation','no_auth_delete');
      }
     else
      {
       $smarty->assign('id',$id);
       $smarty->assign('pid',$field['pid']);
       $smarty->assign('name',htmlspecialchars(stripslashes($field['name'])));
       $smarty->assign('subject',htmlspecialchars(stripslashes($field['subject'])));
       $smarty->assign('disp_time',$field['disp_time']);
       $smarty->assign('spam',intval($field['spam']));
       $smarty->assign('spam_check_status',intval($field['spam_check_status']));
       $smarty->assign('back',$back);
       #$smarty->assign('page',$page);
       #$smarty->assign('order',$order);
       #$smarty->assign('descasc',$descasc);
       $smarty->assign('category',$category);
       $smarty->assign('posting_mode',1);
      } 
    if($field['name']) $smarty->assign('name_repl_subnav',htmlspecialchars(stripslashes($field['name'])));
    else $smarty->assign('name_repl_subnav',$lang['unknown_user']);
     $subnav_link = array('mode'=>$back, 'id' => $id, 'title'=>'back_to_entry_link_title', 'name'=>'back_to_entry_link');
    }
   else $subnav_link = array('mode'=>'index', 'name'=>'forum_index_link', 'title'=>'forum_index_link_title');
   $smarty->assign("subnav_link",$subnav_link);
   #$backlink = 'entry';
   $smarty->assign('subtemplate','posting_flag_ham.tpl.inc');
   mysql_free_result($result);
  break;
  case 'flag_ham_submit':
   if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0)
    {
     $result = mysql_query("SELECT tid, name, email, hp, subject, location, text FROM ".$db_settings['forum_table']." WHERE id = ".intval($id)." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
     $data = mysql_fetch_array($result);
     if(mysql_num_rows($result)==1)
      {
       @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=edited, locked=0, spam=0, spam_check_status=0 WHERE id = ".intval($id), $connid);
       
       // set last reply time of thread as it wasn't set in spam status:
       $last_reply_result = @mysql_query("SELECT time FROM ".$db_settings['forum_table']." WHERE tid = ".intval($data['tid'])." ORDER BY time DESC LIMIT 1", $connid) or raise_error('database_error',mysql_error());
       $field = mysql_fetch_array($last_reply_result);
       mysql_free_result($last_reply_result);
       @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply='".$field['time']."' WHERE tid=".intval($data['tid']), $connid);
       
       // send confirm mails as they haven't been seent in spam status: (2nd parameter "true" adds a delayed message)
       emailNotification2ParentAuthor($id, true);
       emailNotification2ModsAndAdmins($id, true);
       
       if(isset($_POST['report_flag_ham_submit']) && $settings['akismet_key']!='' && $settings['akismet_entry_check']==1)
        {
         require('modules/akismet/akismet.class.php');
         $check_posting['author'] = $data['name'];
         if($data['email'] != '') $check_posting['email'] = $data['email'];
         if($data['hp'] != '') $check_posting['website'] = $data['hp'];
         $check_posting['body'] = $data['text'];
         $akismet = new Akismet($settings['forum_address'], $settings['akismet_key'], $check_posting);
         if(!$akismet->errorsExist())
          { 
           $akismet->submitHam();
          } 
        }
       header('location: index.php?id='.$id);
      }
     else
      {
       header('location: index.php?mode=index');
      }
     exit; 
    }
   else die('No authorisation!');
  break;
  case 'lock':
   // lock/unlock posting if user is authorized:
   if(isset($_SESSION[$settings['session_prefix'].'user_id']) && $_SESSION[$settings['session_prefix']."user_type"] == 2 || isset($_GET['lock']) && isset($_SESSION[$settings['session_prefix'].'user_id']) && $_SESSION[$settings['session_prefix']."user_type"] == 1) 
    {
     $id = intval($_GET['lock']);
     $lock_result = mysql_query("SELECT locked FROM ".$db_settings['forum_table']." WHERE id='".$id."' LIMIT 1", $connid);
     if (!$lock_result) raise_error('database_error',mysql_error());
     $field = mysql_fetch_array($lock_result);
     mysql_free_result($lock_result);
     if ($field['locked']==0) mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=edited, locked=1 WHERE id = ".intval($id), $connid);
     else mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=edited, locked=0 WHERE id = ".intval($id), $connid);
     #if (empty($page)) $page = 0;
     #if (empty($order)) $order = "time";
     #if (empty($descasc)) $descasc = "DESC";
    }
   header("location: index.php?mode=".$back."&id=".$id);
   exit;
   break;
  case 'lock_thread':
   // lock thread if user is authorized:
   if(isset($_SESSION[$settings['session_prefix'].'user_id']) && $_SESSION[$settings['session_prefix']."user_type"] == 2 || isset($_GET['lock_thread']) && isset($_SESSION[$settings['session_prefix'].'user_id']) && $_SESSION[$settings['session_prefix']."user_type"] == 1)
    {
     $id = intval($_GET['lock_thread']);
     $lock_result = mysql_query("SELECT tid FROM ".$db_settings['forum_table']." WHERE id='".$id."' LIMIT 1", $connid);
     if(!$lock_result) raise_error('database_error',mysql_error());
     $field = mysql_fetch_array($lock_result);
     mysql_free_result($lock_result);
     mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=edited, locked=1 WHERE tid = ".intval($field['tid']), $connid);
    }
   header("location: index.php?mode=".$back."&id=".$id);
   exit;
   break;
  case 'unlock_thread':
   // unlock thread if user is authorized:
   if(isset($_SESSION[$settings['session_prefix'].'user_id']) && $_SESSION[$settings['session_prefix']."user_type"] == 2 || isset($_GET['unlock_thread']) && isset($_SESSION[$settings['session_prefix'].'user_id']) && $_SESSION[$settings['session_prefix']."user_type"] == 1)
    {
     $id = intval($_GET['unlock_thread']);
     $lock_result = mysql_query("SELECT tid FROM ".$db_settings['forum_table']." WHERE id='".$id."' LIMIT 1", $connid);
     if(!$lock_result) raise_error('database_error',mysql_error());
     $field = mysql_fetch_array($lock_result);
     mysql_free_result($lock_result);
     mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=edited, locked=0 WHERE tid = ".intval($field['tid']), $connid);
    }
   header("location: index.php?mode=".$back."&id=".$id);
   exit;
   break;

 }

// CAPTCHA:
if(empty($_SESSION[$settings['session_prefix'].'user_id']) && $settings['captcha_posting']>0)
 {
  if($settings['captcha_posting']==2)
   {
    $_SESSION['captcha_session'] = $captcha->generate_code();
   } 
  else 
   {
    $_SESSION['captcha_session'] = $captcha->generate_math_captcha();
    $captcha_tpl['number_1'] = $_SESSION['captcha_session'][0];
    $captcha_tpl['number_2'] = $_SESSION['captcha_session'][1];
   } 
  $captcha_tpl['type'] = $settings['captcha_posting'];
  $smarty->assign('captcha',$captcha_tpl);
 }

if(empty($_SESSION[$settings['session_prefix'].'user_id']))
 {
  $session['name'] = session_name();
  $session['id'] = session_id();
  $smarty->assign('session',$session);
 }

$template = 'main.tpl';
?>
