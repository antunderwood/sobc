<?php
if(!defined('IN_INDEX')) 
 { 
  header('Location: ../index.php');
  exit;
 }

$current_time = time();

if(empty($_SESSION[$settings['session_prefix'].'user_id']) && $settings['captcha_email']>0)
 {
  require('modules/captcha/captcha.php');
  $captcha = new Captcha();
 }

if(isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'main';

if(isset($_POST['message_submit'])) $action = 'message_submit';

switch($action)
 {
  case 'main':
   // sender:
   if(isset($_SESSION[$settings['session_prefix'].'user_id']))
    {
     $result = @mysql_query("SELECT user_email FROM ".$db_settings['userdata_table']." WHERE user_id = '".intval($_SESSION[$settings['session_prefix'].'user_id'])."' LIMIT 1", $connid) or raise_error('database_error',mysql_error());
     $data = mysql_fetch_array($result);
     mysql_free_result($result);
     $smarty->assign('sender_email',htmlspecialchars(stripslashes($data['user_email'])));
    }
   else
    {
     $smarty->assign('sender_email','');
    }
   
   if(isset($_REQUEST['id']))
    {
     // contact by entry:  
     $result = @mysql_query("SELECT user_id, name, email FROM ".$db_settings['forum_table']." WHERE id = ".intval($_REQUEST['id'])." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
     if(mysql_num_rows($result)!=1)
      {
       header('Location: index.php');
       exit;
      }
     $data = mysql_fetch_array($result);
     mysql_free_result($result);
     if($data['user_id']>0)
      {
       // registered user, get  data from userdata table:
       $result = @mysql_query("SELECT user_name, email_contact FROM ".$db_settings['userdata_table']." WHERE user_id = ".intval($data['user_id'])." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
       $userdata = mysql_fetch_array($result);
       mysql_free_result($result);
       if($userdata['email_contact']!=1)
        {
         $smarty->assign('error_message','impossible_to_contact');
        }
       else
        {
         $smarty->assign('recipient_name',htmlspecialchars(stripslashes($userdata['user_name'])));
         $smarty->assign('recipient_user_id',intval($data['user_id']));
        } 
      }
     else
      {
       // not registered user, get data from forum table:
       if($data['email']=='')
        {
         $smarty->assign('error_message','impossible_to_contact');
        }
       else
        {
         $smarty->assign('recipient_name',htmlspecialchars(stripslashes($data['name'])));
         $smarty->assign('id',intval($_REQUEST['id']));
        } 
      } 
    }
   elseif(isset($_REQUEST['user_id']))
    {
     $result = @mysql_query("SELECT user_name, email_contact FROM ".$db_settings['userdata_table']." WHERE user_id = '".intval($_REQUEST['user_id'])."' LIMIT 1", $connid) or raise_error('database_error',mysql_error());
      if(mysql_num_rows($result)!=1)
      {
       header('Location: index.php');
       exit;
      }
     $userdata = mysql_fetch_array($result);
     mysql_free_result($result);
     if($userdata['email_contact']!=1)
      {
       $smarty->assign('error_message','impossible_to_contact');
      }
     else
      {
       $smarty->assign('recipient_name',htmlspecialchars(stripslashes($userdata['user_name'])));
       $smarty->assign('recipient_user_id',intval($_REQUEST['user_id']));
      } 
    } 
   $_SESSION[$settings['session_prefix'].'formtime'] = $current_time;
  break;
  case 'message_submit':
   if(isset($_POST['id'])) $id = intval($_POST['id']);
   if(isset($_POST['user_id'])) $user_id = intval($_POST['user_id']);
   if(isset($_POST['sender_email'])) $sender_email = trim(preg_replace("/\r/", "", $_POST['sender_email']));
   if(isset($_POST['text'])) $text = trim($_POST['text']);
   if(isset($_POST['subject'])) $subject = trim($_POST['subject']);
   
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
   
   if(empty($errors))
    {
     if(empty($sender_email) || $sender_email=='') $errors[] = 'error_no_email';
     elseif(!preg_match(EMAIL_PATTERN, $sender_email)) $errors[] = 'error_email_invalid';
     if(empty($subject) || $subject=='') $errors[] = 'error_no_subject';
     if(empty($text) || $text=='') $errors[] = 'error_no_text';
     if(my_strlen(stripslashes($subject),$lang['charset']) > $settings['email_subject_maxlength']) $errors[] = 'error_email_subject_too_long';
     if(my_strlen(stripslashes($text),$lang['charset']) > $settings['email_text_maxlength']) $errors[] = 'error_email_text_too_long';
     $smarty->assign('text_length',my_strlen(stripslashes($text),$lang['charset']));
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
       $not_accepted_words = explode(',',trim($data['list']));
       foreach($not_accepted_words as $not_accepted_word)
        {
         if($not_accepted_word!='' && (preg_match("/".$not_accepted_word."/i",$sender_email) || preg_match("/".$not_accepted_word."/i",$subject) || preg_match("/".$not_accepted_word."/i",$text)))
          {
           $errors[] = 'error_not_accepted_word';
           break;
          }
        }
      }
    }
   
   // CAPTCHA check:
   if(empty($errors) && empty($_SESSION[$settings['session_prefix'].'user_id']) && $settings['captcha_email']>0)
    {
     if($settings['captcha_email']==2)
      {
       if(empty($_SESSION['captcha_session']) || empty($_POST['captcha_code']) || $captcha->check_captcha($_SESSION['captcha_session'],$_POST['captcha_code'])!=true) $errors[] = 'captcha_check_failed';
      }
     else
      {
       if(empty($_SESSION['captcha_session']) || empty($_POST['captcha_code']) || $captcha->check_math_captcha($_SESSION['captcha_session'][2],$_POST['captcha_code'])!=true) $errors[] = 'captcha_check_failed';
      }
     unset($_SESSION['captcha_session']);
    }
   
   // Akismet spam check:
   if(empty($errors) && $settings['akismet_key']!='' && $settings['akismet_mail_check']==1 && empty($_SESSION[$settings['session_prefix'].'user_id']))
    {
     require('modules/akismet/akismet.class.php');
     $mail_parts = explode("@", $sender_email);
     $sender_name = $mail_parts[0];
     $check_mail['author'] = $mail_parts[0];
     $check_mail['email'] = $sender_email;
     #$check_mail['body'] = $subject."\n\n".$text;
     $check_mail['body'] = $text;
     $akismet = new Akismet($settings['forum_address'], $settings['akismet_key'], $check_mail); 
     // test for errors
     if($akismet->errorsExist()) 
      { 
       // returns true if any errors exist 
       if($akismet->isError(AKISMET_INVALID_KEY)) 
        { 
         $errors[] = 'error_akismet_api_key';
        }
       elseif($akismet->isError(AKISMET_RESPONSE_FAILED)) 
        {
         $errors[] = 'error_akismet_connection';
        } 
       elseif($akismet->isError(AKISMET_SERVER_NOT_FOUND))
        { 
         $errors[] = 'error_akismet_connection';
        } 
      }
     else
      { 
       // No errors, check for spam
       if($akismet->isSpam())
        { 
         $errors[] = 'error_spam_suspicion';
        }
      }      
    }

   if(isset($id))
    {
     // get email address from entry:  
     $result = @mysql_query("SELECT user_id, name, email FROM ".$db_settings['forum_table']." WHERE id = ".intval($id)." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
     if(mysql_num_rows($result)!=1)
      {
       header('Location: index.php');
       exit;
      }
     $data = mysql_fetch_array($result);
     mysql_free_result($result);
     if($data['user_id']>0)
      {
       // registered user, get  data from userdata table:
       $result = @mysql_query("SELECT user_email, email_contact FROM ".$db_settings['userdata_table']." WHERE user_id = ".intval($data['user_id'])." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
       $userdata = mysql_fetch_array($result);
       mysql_free_result($result);
       if($userdata['email_contact']!=1)
        {
         $errors[] = TRUE;
         $smarty->assign('error_message','impossible_to_contact');
        }
       else
        {
         $smarty->assign('recipient_name',htmlspecialchars(stripslashes($userdata['user_name'])));
         $recipient_email = stripslashes($data['user_email']);
        } 
      }
     else
      {
       // not registered user, get data from forum table:
       if($data['email']=='')
        {
         $errors[] = TRUE;
         $smarty->assign('error_message','impossible_to_contact');
        }
       else
        {
         $recipient_name = htmlspecialchars(stripslashes($data['name']));
         $recipient_email = stripslashes($data['email']);
         $smarty->assign('recipient_name',$recipient_name);
        } 
      } 
    }
   elseif(isset($user_id))
    {
     $result = @mysql_query("SELECT user_name, user_email, email_contact FROM ".$db_settings['userdata_table']." WHERE user_id = '".intval($user_id)."' LIMIT 1", $connid) or raise_error('database_error',mysql_error());
     if(mysql_num_rows($result)!=1)
      {
       header('Location: index.php');
       exit;
      }
     $userdata = mysql_fetch_array($result);
     mysql_free_result($result);
     if($userdata['email_contact']!=1)
      {
       $errors[] = TRUE;
       $smarty->assign('error_message','impossible_to_contact');
      }
     else
      {
       $recipient_name = htmlspecialchars(stripslashes($userdata['user_name']));
       $recipient_email = stripslashes($userdata['user_email']);
       $smarty->assign('recipient_name',$recipient_name);
      } 
    }
   else
    {
     $recipient_name = $settings['forum_name'];
     $recipient_email = $settings['forum_email'];
    } 
   
   if(empty($errors))
    {
     $smarty->config_load($settings['language_file'],'emails');
     $lang = $smarty->get_config_vars();
     if(isset($_SESSION[$settings['session_prefix'].'user_name'])) $emailbody = str_replace("[user]", stripslashes($_SESSION[$settings['session_prefix'].'user_name']), $lang['contact_email_txt_user']);
     else $emailbody = $lang['contact_email_txt'];
     $emailbody = str_replace("[message]", stripslashes($text), $emailbody);
     $emailbody = str_replace("[forum_address]", $settings['forum_address'], $emailbody);
     if(!my_mail($recipient_email, $subject, $emailbody, $sender_email)) $errors[] = 'error_mailserver';
    }
   if(isset($errors))
    {
     $_SESSION[$settings['session_prefix'].'formtime'] = $current_time - 7; // 7 seconds credit (form already sent)
     $smarty->assign('errors',$errors);
     if(isset($id)) $smarty->assign('id',$id);
     if(isset($user_id)) $smarty->assign('recipient_user_id',$user_id);
     if(isset($sender_email)) $smarty->assign('sender_email',htmlspecialchars(stripslashes($sender_email)));
     if(isset($text)) $smarty->assign('text',htmlspecialchars(stripslashes($text)));
     if(isset($subject)) $smarty->assign('subject',htmlspecialchars(stripslashes($subject)));
    } 
   else
    {
     $smarty->assign('sent',TRUE);
     // e-mail to sender:
     // disabled, see here: http://mylittleforum.net/forum/index.php?id=2485
     /*
     $emailsubject = str_replace("[subject]", stripslashes($subject), $lang['contact_notification_sj']);
     $emailbody = str_replace("[subject]", stripslashes($subject), $lang['contact_notification_txt']);
     $emailbody = str_replace("[message]", stripslashes($text), $emailbody);
     $emailbody = str_replace("[forum_address]", $settings['forum_address'], $emailbody);
     $emailbody = str_replace("[recipient]", $recipient_name, $emailbody);
     my_mail($sender_email, $subject, $emailbody);     
     */ 
    }
  break;
 } 

// CAPTCHA:
if(empty($_SESSION[$settings['session_prefix'].'user_id']) && $settings['captcha_email']>0)
 {
  if($settings['captcha_email']==2)
   {
    $_SESSION['captcha_session'] = $captcha->generate_code();
   } 
  else 
   {
    $_SESSION['captcha_session'] = $captcha->generate_math_captcha();
    $captcha_tpl['number_1'] = $_SESSION['captcha_session'][0];
    $captcha_tpl['number_2'] = $_SESSION['captcha_session'][1];
   } 
  $captcha_tpl['type'] = $settings['captcha_email'];
  $smarty->assign('captcha',$captcha_tpl);
 }

if(empty($_SESSION[$settings['session_prefix'].'user_id']))
 {
  $session['name'] = session_name();
  $session['id'] = session_id();
  $smarty->assign('session',$session);
 }

$smarty->assign('subnav_location','subnav_contact');
$smarty->assign('subtemplate','contact.tpl.inc');
$template = 'main.tpl';
?>
