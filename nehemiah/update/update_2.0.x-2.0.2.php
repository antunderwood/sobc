<?php
/******************************************************************************
* my little forum                                                             * 
* update file to update from version 2.0 to version 2.0.1                     *
*                                                                             *
* Update instructions:                                                        *
* - Load up this file into the directory "update"                             *
* - log in as administrator                                                   *  
* - go to the Admin -- > Update                                               *
* - click on the update file and follow the further instructions.             *
******************************************************************************/

if(!defined('IN_INDEX')) exit;
if(empty($_SESSION[$settings['session_prefix'].'user_type'])) exit;
if($_SESSION[$settings['session_prefix'].'user_type']!=2) exit;

// update data:
$update['version'] = array('2.0','2.0.1');
$update['new_version'] = '2.0.2';
$update['download_url'] = 'http://downloads.sourceforge.net/mylittleforum/my_little_forum_2.0.2.zip';
#$update['message'] = '<p>HTML formated message...</p>';

// changed files (folders followed by a slash like this: folder/):
$update['items'][] = 'templates/default/subtemplates/';
$update['items'][] = 'includes/admin.inc.php';
$update['items'][] = 'includes/register.inc.php';
$update['items'][] = 'js/main.js';

// 1. check version:
if(!in_array($settings['version'],$update['version']))
 {
  $update['errors'][] = 'Error in step 1 (line '.__LINE__.'): Inappropriate update file. Works with version <b>'.$update['version'].'</b> only. Current version is <b>'.$settings['version'].'</b>.';
 } 

// 2. set new version:
if(empty($update['errors']))
 {
  if(!@mysql_query("UPDATE ".$db_settings['settings_table']." SET value='".$update['new_version']."' WHERE name = 'version'", $connid))
   {
    $update['errors'][] = 'Database error in step 2 (line '.__LINE__.'): ' . mysql_error();
   } 
 }
?>
