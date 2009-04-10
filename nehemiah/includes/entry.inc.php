<?php
if(!defined('IN_INDEX'))
 {
  header('Location: ../index.php');
  exit;
 }

if(isset($_REQUEST['id'])) $id = intval($_REQUEST['id']);
else 
 { 
  header('Location: index.php');
  exit;
 }

unset($entrydata);
unset($parent_array);
unset($child_array);

if(isset($_GET['page'])) $page = intval($_GET['page']);
else $page = 1;

if(isset($_GET['order']) && $_GET['order']=='last_reply') $order = 'last_reply';
else $order = 'time';

if(isset($id) && $id > 0)
  {
   $result=@mysql_query("SELECT id, pid, tid, ".$db_settings['forum_table'].".user_id, UNIX_TIMESTAMP(time + INTERVAL ".$time_difference." MINUTE) AS disp_time,
                         UNIX_TIMESTAMP(time) AS time, UNIX_TIMESTAMP(edited + INTERVAL ".$time_difference." MINUTE) AS e_time,
                         UNIX_TIMESTAMP(edited - INTERVAL ".$settings['edit_delay']." MINUTE) AS edited_diff, edited_by, name, email,
                         subject, hp, location, ip, text, cache_text, tags, show_signature, category, locked, ip, views, spam, spam_check_status, edit_key,
                         user_name, user_type, user_email, email_contact, user_hp, user_location, signature, cache_signature
                         FROM ".$db_settings['forum_table']."
                         LEFT JOIN ".$db_settings['entry_cache_table']." ON ".$db_settings['entry_cache_table'].".cache_id=id
                         LEFT JOIN ".$db_settings['userdata_table']." ON ".$db_settings['userdata_table'].".user_id=".$db_settings['forum_table'].".user_id
                         LEFT JOIN ".$db_settings['userdata_cache_table']." ON ".$db_settings['userdata_cache_table'].".cache_id=".$db_settings['userdata_table'].".user_id
                         WHERE id = ".$id, $connid) or raise_error('database_error',mysql_error());
   
   if(mysql_num_rows($result) == 1)
    {
     $entrydata = mysql_fetch_array($result);
     mysql_free_result($result);

     $entrydata['formated_time'] = format_time($lang['time_format_full'],$entrydata['disp_time']);
     
     // category of this posting accessible by user?
     if(is_array($category_ids) && !in_array($entrydata['category'], $category_ids))
      {
       header("Location: index.php");
       exit;
      }

     if(isset($settings['count_views']) && $settings['count_views'] == 1) mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply=last_reply, edited=edited, views=views+1 WHERE id=".$id, $connid);

     if(isset($visited))
      {
       $visited[] = $id;
       $visited = array_unique($visited);
       
       $visited_items = count($visited);
       
       // maximum cookie items:
       if($visited_items>200)
        {
         $too_much_items = $visited_items - 200;
         for($i=0;$i<$too_much_items;$i++)
          {
           unset($visited[$i]);
          }
        }
       setcookie($settings['session_prefix'].'visited',implode('.',$visited),time()+(3600*24*30));
      }   
     else
      {
       setcookie($settings['session_prefix'].'visited',$id,time()+(3600*24*30));
      }
      
     if($entrydata['user_id'] > 0)
      {
       
       if($settings['avatars']==2)
        {
         if(file_exists('images/avatars/'.$entrydata['user_id'].'.jpg')) $avatar['image'] = 'images/avatars/'.$entrydata['user_id'].'.jpg';
         elseif(file_exists('images/avatars/'.$entrydata['user_id'].'.png')) $avatar['image'] = 'images/avatars/'.$entrydata['user_id'].'.png';
         elseif(file_exists('images/avatars/'.$entrydata['user_id'].'.gif')) $avatar['image'] = 'images/avatars/'.$entrydata['user_id'].'.gif';
         if(isset($avatar))
          {
           $image_info = getimagesize($avatar['image']);
           $avatar['width'] = $image_info[0];
           $avatar['height'] = $image_info[1];
           $smarty->assign('avatar', $avatar);
          } 
        }     
      
      $entrydata['email'] = $entrydata['user_email'];
      #$entrydata['email_contact'] = $userdata['email_contact'];
      $entrydata['location'] = $entrydata['user_location'];
      $entrydata['hp'] = $entrydata['user_hp'];
     }
     else $entrydata['email_contact']=1;
   }
   else 
    { 
     header("Location: index.php");
     exit;
    }
  }
 else 
  { 
   header("Location: index.php"); 
   exit;
  }

 if($entrydata['cache_text']=='')
  {
   // no cached text so parse it and cache it:
   $ftext = html_format(stripslashes($entrydata['text']));
   // make sure not to make a double entry:
   @mysql_query("DELETE FROM ".$db_settings['entry_cache_table']." WHERE cache_id=".intval($entrydata['id']), $connid);
   @mysql_query("INSERT INTO ".$db_settings['entry_cache_table']." (cache_id, cache_text) VALUES (".intval($entrydata['id']).",'".mysql_real_escape_string($ftext)."')", $connid);
  } 
 else
  {
   $ftext = $entrydata['cache_text'];
  }
 
 if(isset($_REQUEST['ajax_preview']))
  {
   header('Content-Type: application/xml; charset=UTF-8');
   echo '<?xml version="1.0"?>';
   ?><posting><content><![CDATA[<?php echo $ftext; ?>]]></content></posting><?php
   exit;
  }
  
 // thread-data:
 $thread = $entrydata['tid'];
 if($entrydata['spam']==1) $display_spam_query_and='';
 $result = mysql_query("SELECT id, pid, tid, ".$db_settings['forum_table'].".user_id, UNIX_TIMESTAMP(time) AS time, UNIX_TIMESTAMP(time + INTERVAL ".$time_difference." MINUTE) AS disp_time,
                        UNIX_TIMESTAMP(last_reply) AS last_reply, name, user_name, subject, category, marked, text, spam FROM ".$db_settings['forum_table']."
                        LEFT JOIN ".$db_settings['userdata_table']." ON ".$db_settings['userdata_table'].".user_id=".$db_settings['forum_table'].".user_id
                        WHERE tid = ".$thread.$display_spam_query_and." ORDER BY time ASC", $connid);
 if(!$result) raise_error('database_error',mysql_error());

 while($data = mysql_fetch_array($result))
  {
   if($data['user_id']>0)
    {
     if(!$data['user_name']) $data['name'] = $lang['unknown_user'];
     else $data['name'] = htmlspecialchars(stripslashes($data['user_name']));
    } 
   else $data['name'] = htmlspecialchars(stripslashes($data['name']));
   
   $data['subject'] = htmlspecialchars(stripslashes($data['subject']));

   // convert formated time to a utf-8:
   $data['formated_time'] = format_time($lang['time_format'],$data['disp_time']);
   
   if($data['text']=='') $data['no_text'] = true;
   unset($data['text']);
   
   if(isset($categories[$data["category"]]) && $categories[$data['category']]!='') $data['category_name']=$categories[$data["category"]];
   $data_array[$data['id']] = $data;
   $child_array[$data['pid']][] =  $data['id'];
   if($data['pid']==$id) $direct_replies[] = $data['id']; 
  }
 if(isset($child_array)) 
  {
   $tree[] = tree($entrydata['tid'], $child_array);
   $branch[] = tree($entrydata['id'], $child_array);
  } 
 mysql_free_result($result);

// tags:
$tags = stripslashes($entrydata['tags']);
if($tags!='')
 { 
  $tags_help_array = explode(';',$tags);
  $i=0;
  foreach($tags_help_array as $tag)
   {
    if($tag!='') 
     {
      if(my_strpos($tag, ' ', 0, $lang['charset'])) $tag_escaped='"'.$tag.'"';
      else $tag_escaped = $tag;
      $tags_array[$i]['escaped'] = urlencode($tag_escaped);
      $tags_array[$i]['display'] = htmlspecialchars($tag);
      $keywords[] = htmlspecialchars($tag);
      $i++;
     } 
   }
  if(isset($tags_array)) $smarty->assign('tags',$tags_array);
  if(isset($keywords)) $smarty->assign('keywords',implode(', ',$keywords)); 
 }

$category = $category;
$smarty->assign('id',$entrydata['id']);
$smarty->assign('tid',$entrydata['tid']);
$smarty->assign('pid',$entrydata['pid']);
$smarty->assign('posting_user_id',$entrydata['user_id']);
$smarty->assign('page_title',htmlspecialchars(stripslashes($entrydata['subject'])));
$smarty->assign('subject',htmlspecialchars(stripslashes($entrydata['subject'])));

if($entrydata['user_id']>0) 
 {
  if(!$entrydata['user_name']) $name = $lang['unknown_user'];
  else $name = htmlspecialchars(stripslashes($entrydata['user_name']));
 } 
else $name = htmlspecialchars(stripslashes($entrydata['name']));

$smarty->assign('name',$name);

$smarty->assign('user_type',$entrydata['user_type']);
$smarty->assign('disp_time',$entrydata['disp_time']);
$smarty->assign('formated_time',$entrydata['formated_time']);
$smarty->assign('locked',$entrydata['locked']);

$authorization = get_edit_authorization($id, $entrydata['user_id'], $entrydata['edit_key'], $entrydata['time'], $entrydata['locked']);
if($authorization['edit']==true) $smarty->assign('edit_authorization',true);
if($authorization['delete']==true) $smarty->assign('delete_authorization',true);

if(isset($direct_replies)) $smarty->assign('direct_replies',$direct_replies);
if($settings['count_views'] == 1) 
 {
  $views = $entrydata['views']-1; // this subtracts the first view by the author after posting
  if($views<0) $views=0; // prevents negative number of views
  $smarty->assign('views',$entrydata['views']);
 } 
$smarty->assign('ip',$entrydata['ip']);
if($entrydata['spam']==1) $smarty->assign('spam',true);
if (isset($categories[$entrydata["category"]]) && $categories[$entrydata['category']]!='')
 {
  $smarty->assign('category_name',$categories[$entrydata["category"]]);
 }

if(empty($entrydata['email_contact'])) $entrydata["email_contact"]=0;
if ($entrydata['hp']!='')
 {
  $entrydata['hp'] = add_http_if_no_protocol($entrydata['hp']);
  $smarty->assign('hp',$entrydata["hp"]);
 }
if($entrydata['email']!='' && $entrydata["email_contact"]==1) $smarty->assign('email',true);
if($entrydata['location'] != '') $smarty->assign('location',htmlspecialchars(stripslashes($entrydata['location'])));

$subnav_link = array('mode'=>'index', 'name'=>'thread_entry_back_link', 'title'=>'thread_entry_back_title');

// edited:
if($entrydata["edited_diff"] > 0 && $entrydata["edited_diff"] > $entrydata["time"] && $settings['show_if_edited'] == 1)
 {
  $smarty->assign('edited',true);
  $entrydata['formated_edit_time'] = format_time($lang['time_format_full'],$entrydata['e_time']);
  $smarty->assign('formated_edit_time',$entrydata['formated_edit_time']);
  if($entrydata['user_id'] == $entrydata['edited_by']) $edited_by = $name;
  else
   {
    $result = @mysql_query("SELECT user_name 
                            FROM ".$db_settings['userdata_table']." 
                            WHERE user_id = ".intval($entrydata['edited_by'])." LIMIT 1", $connid);
    $edited_data = mysql_fetch_array($result);
    @mysql_free_result($result);
    if(!$edited_data['user_name']) $edited_by = $lang['unknown_user'];
    else $edited_by = htmlspecialchars(stripslashes($edited_data['user_name']));
   }
  $smarty->assign('edited_by',$edited_by);
 }

if(isset($entrydata['signature']) && $entrydata['signature'] != '' && $entrydata["show_signature"]==1) 
 {
  // user has a signature and wants it to be displaed in this posting. Check if it's already cached:
  if($entrydata['cache_signature']!='')
  {
   $smarty->assign('signature',$entrydata['cache_signature']);
  }  
  else
  {
   $signature = signature_format(stripslashes($entrydata['signature']));
   // cache signature:
   list($row_count) = @mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM ".$db_settings['userdata_cache_table']." WHERE cache_id=".intval($entrydata['user_id']), $connid));
   if($row_count==1)
    {
     mysql_query("UPDATE ".$db_settings['userdata_cache_table']." SET cache_signature='".mysql_real_escape_string($signature)."' WHERE cache_id=".intval($entrydata['user_id']), $connid);
    }
   else
    {
     @mysql_query("DELETE FROM ".$db_settings['userdata_cache_table']." WHERE cache_id=".intval($entrydata['user_id']), $connid);
     @mysql_query("INSERT INTO ".$db_settings['userdata_cache_table']." (cache_id, cache_signature, cache_profile) VALUES (".intval($entrydata['user_id']).",'".mysql_real_escape_string($signature)."','')", $connid);
    }
   $smarty->assign('signature',$signature);
  }
 }
  
if(isset($tree)) $smarty->assign('tree',$tree);
if(isset($branch)) $smarty->assign('branch',$branch);
if(isset($data_array)) $smarty->assign("data",$data_array);
$smarty->assign('posting',$ftext);
$smarty->assign('subnav_link',$subnav_link);
$smarty->assign('page',$page);
$smarty->assign('order',$order);
$smarty->assign('category',$category);
if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0) $smarty->assign('move_posting_link',true);
if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0 && $settings['akismet_key']!='' && $settings['akismet_entry_check']==1 && $entrydata['spam']==0 && $entrydata['spam_check_status']>0) $smarty->assign('report_spam_link',true);
if(isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type']>0 && $entrydata['spam']==1) $smarty->assign('flag_ham_link',true);
$smarty->assign('subtemplate','entry.tpl.inc');
$template = 'main.tpl';
?>
