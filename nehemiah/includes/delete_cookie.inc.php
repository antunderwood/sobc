<?php
if(!defined('IN_INDEX')) 
 { 
  header('Location: ../index.php');
  exit;
 }

setcookie($settings['session_prefix'].'userdata','',0);

if(isset($_POST['method']) && $_POST['method']=='ajax') exit;
 
else
 {
  $smarty->assign('lang_section','delete_cookie');
  $smarty->assign('message','delete_cookie');
  $smarty->assign('subnav_location','subnav_delete_cookie');
  $smarty->assign('subtemplate','info.tpl.inc');
  $template = 'main.tpl';
 }
?>
