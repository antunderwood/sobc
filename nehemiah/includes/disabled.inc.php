<?php
if(!defined('IN_INDEX')) 
 { 
  header('Location: ../index.php');
  exit; 
 }

if($settings['forum_disabled_message']!='')
 {
  $smarty->assign('custom_message',$settings['forum_disabled_message']);
 } 
else
 {
  $smarty->assign('message','forum_disabled');
 }

$smarty->assign('lang_section','info');
$smarty->assign('subnav_location','subnav_disabled');
$smarty->assign('subtemplate','info.tpl.inc');
$template = 'main.tpl';
?>
