<?php
if(!defined('IN_INDEX')) 
 { 
  header('Location: ../index.php');
  exit; 
 }

$smarty->assign('lang_section','info');
$smarty->assign('message','user_locked');
$smarty->assign('subnav_location','subnav_locked');
$smarty->assign('subtemplate','info.tpl.inc');
$template = 'main.tpl';
?>
