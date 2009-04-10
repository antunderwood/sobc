<?php
/*******************************************************************************
* my little forum                                                              *
* Version 2.0.2 (2009-01-31)                                                   *
* Copyright (C) 2008 alex@mylittleforum.net                                    *
* http://mylittleforum.net/                                                    *
*******************************************************************************/

/*******************************************************************************
* This program is free software: you can redistribute it and/or modify         *
* it under the terms of the GNU General Public License as published by         *
* the Free Software Foundation, either version 3 of the License, or            *
* (at your option) any later version.                                          *
*                                                                              *
* This program is distributed in the hope that it will be useful,              *
* but WITHOUT ANY WARRANTY; without even the implied warranty of               *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                *
* GNU General Public License for more details.                                 *
*                                                                              *
* You should have received a copy of the GNU General Public License            *
* along with this program.  If not, see <http://www.gnu.org/licenses/>.        *
*******************************************************************************/

define('EMAIL_PATTERN', "/^[^@]+@.+\.\D{2,6}$/"); // regex pattern for e-mail addresses
define('HP_PATTERN', "/^.+\..+$/"); // regex pattern for homepage addresses
define('MAIL_HEADER_SEPARATOR', "\n"); // try to use "\r\n" if messages are not sent (see http://php.net/manual/en/function.mail.php)
define('IN_INDEX', TRUE);

session_start();

include('config/db_settings.php');
include('includes/functions.inc.php');
include('includes/main.inc.php');

require('modules/smarty/Smarty.class.php'); // requires plugin compiler.defun.php
$smarty = new Smarty;
$smarty->template_dir = 'templates';
$smarty->compile_dir = 'templates_c';
$smarty->config_dir = 'lang';
$smarty->config_overwrite = false;
$smarty->config_booleanize = false;
$smarty->config_load($settings['language_file']);
$lang = $smarty->get_config_vars();

define('CHARSET', $lang['charset']);

@ini_set('default_charset', $lang['charset']);
setlocale(LC_ALL, $lang['locale']);

$smarty->assign('settings', $settings);

if(isset($_SESSION[$settings['session_prefix'].'usersettings'])) $smarty->assign('usersettings', $_SESSION[$settings['session_prefix'].'usersettings']);
$smarty->assign('category', $category);
if(isset($categories)) $smarty->assign('categories', $categories);

$smarty->assign('total_postings', $total_postings);
$smarty->assign('total_spam', $total_spam);
$smarty->assign('total_threads', $total_threads);
$smarty->assign('registered_users', $registered_users);
if(isset($total_users_online))
 {
  $smarty->assign('total_users_online', $total_users_online);
  $smarty->assign('unregistered_users_online', $unregistered_users_online);
  $smarty->assign('registered_users_online', $registered_users_online);
 }
 
if(isset($_SESSION[$settings['session_prefix'].'user_id']) && isset($_SESSION[$settings['session_prefix'].'user_name']))
 {
  $smarty->assign('user_id', $_SESSION[$settings['session_prefix'].'user_id']);
  $smarty->assign('user', htmlspecialchars(stripslashes($_SESSION[$settings['session_prefix'].'user_name'])));
 }
if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']==1) $smarty->assign('mod', true);
if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']==2) $smarty->assign('admin', true);
if(isset($_SESSION[$settings['session_prefix'].'usersettings']['newtime'])) $smarty->assign('newtime', $_SESSION[$settings['session_prefix'].'usersettings']['newtime']);
if(isset($last_visit)) $smarty->assign('last_visit',$last_visit);
if(isset($menu)) $smarty->assign('menu',$menu);
if(isset($visited)) $smarty->assign('visited',$visited);

$mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : '';

if($settings['access_for_users_only'] == 1 && empty($_SESSION[$settings['session_prefix'].'user_id']))
 {
  if(empty($mode) || $mode!='account_locked' && $mode!='register' && $mode!='page') $mode = 'login';
 }
if($settings['forum_enabled']!=1 && (empty($_SESSION[$settings['session_prefix'].'user_type']) || $_SESSION[$settings['session_prefix'].'user_type']<2))
 {
  if(empty($mode) || $mode!='disabled' && $mode!='rss' && $mode!='login') $mode = 'disabled';
 }
if(empty($mode) && isset($_REQUEST['id'])) $mode = 'entry';

if(empty($mode)) 
 {
  // set user settings to default values if index page is requestes
  $_SESSION[$settings['session_prefix'].'usersettings']['page']=1;
  $_SESSION[$settings['session_prefix'].'usersettings']['category']=0;
  $mode = 'index';
 } 

switch($mode)
 {
  case 'index': 
     include('includes/index.inc.php');
     break;
  case 'admin':
     include('includes/admin.inc.php');
     break;
  case 'contact':
     include('includes/contact.inc.php');
     break;
  case 'delete_cookie':
     include('includes/delete_cookie.inc.php');
     break;
  case 'login':
     include('includes/login.inc.php');
     break;
  case 'posting':
     include('includes/posting.inc.php');
     break;
  case 'register':
     include('includes/register.inc.php');
     break;
  case 'rss':
     include('includes/rss.inc.php');
     break;
  case 'search':
     include('includes/search.inc.php');
     break;
  case 'entry':
     include('includes/entry.inc.php');
     break;
  case 'thread':
     include('includes/thread.inc.php');
     break;
  case 'user':
     include('includes/user.inc.php');
     break;
  case 'page':
     include('includes/page.inc.php');
     break;
  case 'upload_image':
     include('includes/upload_image.inc.php');
     break;
  case 'avatar':
     include('includes/avatar.inc.php');
     break;          
  case 'account_locked':
     include('includes/account_locked.inc.php');
     break;
  case 'disabled':
     include('includes/disabled.inc.php');
     break;
  default: 
     $mode='index';
     include('includes/index.inc.php');
 }

$smarty->assign('mode', $mode);

if(empty($template)) 
 {
  header('Location: index.php');
  exit;
 }

if($mode=='rss') 
 {
  header("Content-Type: text/xml; charset=".$lang['charset']);
 } 
else 
 {
  if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')==false)
   { 
    // do not send cache-control header to Internet Explorer
    // causes problems when toggeling views or folding threads 
    header('Cache-Control: public, max-age=300');
   }
  header('Content-Type: text/html; charset='.$lang['charset']);
 }

$smarty->display($settings['template'].'/'.$template);
?>
