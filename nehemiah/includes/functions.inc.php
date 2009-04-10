<?php
if(!defined('IN_INDEX'))
 {
  header('Location: ../index.php');
  exit;
 }
 
/**
 * adds slashes to all POSTs, GETs and COOKIEs if magic_quotes_gpc is not enabled
 */ 
function do_magic_quotes_gpc_if_not_enabled() 
 {
  if(!get_magic_quotes_gpc())
   {
    foreach (array('POST', 'GET', 'REQUEST', 'COOKIE') as $gpc)
    $GLOBALS["_$gpc"] = array_map('recursive_addslashes', $GLOBALS["_$gpc"]);
   }
 }

/**
 * help function for do_magic_quotes_gpc_if_not_enabled 
 */ 
function recursive_addslashes($v) 
 {
  return is_array($v) ? array_map('recursive_addslashes', $v) : addslashes($v);
 }

/**
 * connects to the MySQL database
 *
 * @param string $host
 * @param string $user
 * @param string $pw
 * @param string $db
 * @return resource 
 */ 
function connect_db($host,$user,$pw,$db)
 {
  $connid = @mysql_connect($host, $user, $pw) or raise_error('mysql_connect',mysql_error());
  @mysql_select_db($db, $connid) or raise_error('mysql_select_db',mysql_error());
  @mysql_query('SET NAMES utf8', $connid);
  return $connid;
 }

/**
 * logs a user out, saves log out time and removes user from user online table 
 *
 * @param int $user_id
 * @param string $mode
 */ 
function log_out($user_id,$mode='')
 {
  global $connid, $settings, $db_settings;
  session_destroy();
  $update_result = @mysql_query("UPDATE ".$db_settings['userdata_table']." SET last_login=last_login, last_logout=NOW(), registered=registered, auto_login_code='' WHERE user_id=".intval($user_id), $connid);
  setcookie($settings['session_prefix'].'auto_login','',0);
  if($db_settings['useronline_table'] != '') @mysql_query("DELETE FROM ".$db_settings['useronline_table']." WHERE ip = 'uid_".intval($user_id)."'", $connid);
  if($mode!='') header('Location: index.php?mode='.$mode);
  else header('Location: index.php');
  exit;
 }

/**
 * fetches settings from database 
 */ 
function get_settings()
 {
  global $connid, $db_settings;
  $result = mysql_query("SELECT name, value FROM ".$db_settings['settings_table'], $connid) or raise_error('database_error',mysql_error());
  while($line = mysql_fetch_array($result))
   {
    $settings[$line['name']] = stripslashes($line['value']);
   }
  mysql_free_result($result);
  return $settings;
 }

/**
 * generates an array of the message tree 
 *
 * @param int $id
 * @param array $child_array
 * @param int $current
 * @return array  
 */ 
function tree($id, $child_array, $current = 0)
 {
  $tree[] = $id;
  if(isset($child_array[$id]))
   {
    foreach($child_array[$id] as $child)
     {
      $tree[] = tree($child, $child_array, $current);
     }
   }
  return $tree;
 }

/**
 * returns all available categories 
 *
 * @return array  
 */ 
function get_categories()
 {
  global $settings, $connid, $db_settings;
  $count_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['category_table'], $connid);
  list($category_count) = mysql_fetch_row($count_result);
  mysql_free_result($count_result);

  if ($category_count > 0)
   {
    if (empty($_SESSION[$settings['session_prefix'].'user_id']))
     {
      $result = mysql_query("SELECT id, category FROM ".$db_settings['category_table']." WHERE accession = 0 ORDER BY order_id ASC", $connid);
     }
    elseif (isset($_SESSION[$settings['session_prefix'].'user_id']) && isset($_SESSION[$settings['session_prefix'].'user_type']) && $_SESSION[$settings['session_prefix'].'user_type'] == 0)
     {
      $result = mysql_query("SELECT id, category FROM ".$db_settings['category_table']." WHERE accession = 0 OR accession = 1 ORDER BY order_id ASC", $connid);
     }
    elseif (isset($_SESSION[$settings['session_prefix'].'user_id']) && isset($_SESSION[$settings['session_prefix'].'user_type']) && ($_SESSION[$settings['session_prefix'].'user_type'] == 1 || $_SESSION[$settings['session_prefix'].'user_type'] == 2))
     {
      $result = mysql_query("SELECT id, category FROM ".$db_settings['category_table']." WHERE accession = 0 OR accession = 1 OR accession = 2 ORDER BY order_id ASC", $connid);
     }
    if(!$result) raise_error('database_error',mysql_error());
    $categories[0]='';
    while ($line = mysql_fetch_array($result))
     {
      $categories[$line['id']] = htmlspecialchars(stripslashes($line['category']));
     }
    mysql_free_result($result);
    return $categories;
   }
  else return false;
 }

/**
 * returns all available catgory ids 
 *
 * @return array  
 */ 
function get_category_ids($categories)
 {
  if($categories!=false)
   {
    while(list($key) = each($categories))
     {
      $category_ids[] = $key;
     }
    return $category_ids;
   }
  else return false;
 }

/**
 * returns an array for the page navigation  
 *
 * @param int $page_count : number of pages  
 * @param int $page : current page
 * @param int $browse_range
 * @param int $page
 * @param int $show_last   
 * @return array  
 */  
function browse_array($page_count,$page,$browse_range,$show_last)
 {
  $browse_array[] = 1;
  if ($page > $browse_range*2) $browse_array[] = 0;
  $n_range = $page-($browse_range-1);
  $p_range = $page+$browse_range;
  for($page_browse=$n_range; $page_browse<$p_range; $page_browse++)
   {
    if($page_browse > 1 && $page_browse <= $page_count) $browse_array[] = $page_browse;
   }
  if($page < $page_count-($browse_range+1)) $browse_array[] = 0;
  if($show_last==1)
   {
    if(!in_array($page_count,$browse_array)) $browse_array[] = $page_count;
   }
  return $browse_array;
 }

/**
 * replaces urls with links
 *
 * @param string $string
 * @return string
 */
function make_link($string)
 {
  $string = ' ' . $string;
  $string = preg_replace_callback("#(^|[\n ])([\w]+?://.*?[^ \"\n\r\t<]*)#is", "shorten_link", $string);
  $string = preg_replace("#(^|[\n ])((www|ftp)\.[\w\-]+\.[\w\-.\~]+(?:/[^ \"\t\n\r<]*)?)#is", "$1<a href=\"http://$2\">$2</a>", $string);
  #$string = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $string);
  $string = my_substr($string, 1, my_strlen($string, CHARSET), CHARSET);
  return $string;
 }

/**
 * unifies line breaks
 *
 * @param string $string
 * @return string
 */
function convertlinebreaks($string) 
 {
  return preg_replace ("/\015\012|\015|\012/", "\n", $string);
 }

/**
 * strips everything except new line symbol
 *
 * @param string $string
 * @return string
 */
function bbcode_stripcontents($string) 
 {
  return preg_replace ("/[^\n]/", '', $string);
 }

/**
 * makes inlinecode replacements
 */  
function parse_inlinecode($string)
 { 
  $string = nl2br(htmlspecialchars($string));
  $string = str_replace("  ", "&nbsp; ", $string);
  $string = str_replace("  ", " &nbsp;", $string);
  return $string;
 }

/**
 * makes inlinecode replacements
 */  
function parse_monospace($string)
 { 
  $string = nl2br(htmlspecialchars($string));
  $string = str_replace("  ", "&nbsp; ", $string);
  $string = str_replace("  ", " &nbsp;", $string);
  return $string;
 }

/**
 * checks if an url is valid
 *
 * @param string $url
 * @return bool
 */
function is_valid_url($url)
 {
  #if((substr($url,0,7) == 'http://' || substr($url,0,8) == 'https://' || substr($url,0,6) == 'ftp://' || substr($url,0,9) == 'gopher://' || substr($url,0,7) == 'news://' ||  substr($url,0,7) == 'mailto:') && strpos($url, '.')) return true;
  #else return false;
  if(substr ($url, 0, 5) == 'data:' || substr ($url, 0, 5) == 'file:' || substr ($url, 0, 11) == 'javascript:' || substr ($url, 0, 4) == 'jar:') 
   {
    return false;
   }
  else return true;
 }
/**
 * processes BBCode links
 */
function do_bbcode_url ($action, $attributes, $content, $params, &$node_object) 
 {
  // 1) the code is validated
  if ($action == 'validate') 
   {
    // the code has been eneterd like this: [url]http://.../[/url]
    if (!isset($attributes['default'])) 
     {
      // is it a valid url?
      return is_valid_url ($content);
     }
    // the code has been eneterd like this: [url=http://.../]Text[/url]
    // is it a valid url?
    return is_valid_url ($attributes['default']);
   }
  // 2) the code is outputed
  else 
   {
    // the code has been eneterd like this: [url]http://.../[/url]
    if(!isset ($attributes['default'])) return '<a href="'.htmlspecialchars($content).'">'.htmlspecialchars(shorten_url($content)).'</a>';
    // the code has been eneterd like this: [url=http://.../]Text[/url]
    return '<a href="'.htmlspecialchars ($attributes['default']).'">'.$content.'</a>';
   }
 }

/**
 * processes BBCode message links
 */
function do_bbcode_msg($action, $attributes, $content, $params, &$node_object) 
 {
  if ($action == 'validate') 
   {
    if(!isset($attributes['default'])) 
     {
      if(intval($content)>0) return true;
     }
    if(intval($attributes['default'])>0) return true;
   }
  else 
   {
    if(!isset ($attributes['default'])) return '<a href="index.php?id='.intval($content).'">#'.intval($content).'</a>';
    return '<a href="index.php?id='.intval($attributes['default']).'">'.$content.'</a>';
   }
 }

/**
 * processes BBCode images
 */  
function do_bbcode_img($action, $attributes, $content, $params, &$node_object) 
 {
  if ($action == 'validate') 
   {
    if(!is_valid_url($content))
     {
      return false;
     }
    else
     {
      // [img]image[/img]
      if(!isset($attributes['default'])) return true;
      // [img=xxx]image[/img]
      elseif(isset($attributes['default']) && ($attributes['default']=='left' || $attributes['default']=='right')) return true;
      else return false;
     }
   }
  else
   {
    // [img]image[/img]
    if(!isset ($attributes['default'])) return '<img src="'.htmlspecialchars($content).'" alt="[image]" />';
    // [img=xxx]image[/img]
    if($attributes['default']=='left') $padding='0px 10px 10px 0px';
    elseif($attributes['default']=='right') $padding='0px 0px 10px 10px';
    else $padding='0px';
    return '<img src="'.htmlspecialchars($content).'" style="float:'.htmlspecialchars($attributes['default']).';padding:'.$padding.';" alt="[image]" />';
   }
 }

/**
 * processes BBCode color
 */ 
function do_bbcode_color($action, $attributes, $content, $params, $node_object) 
 {
  if($action == 'validate') return true;
  return '<span style="color:'.htmlspecialchars($attributes['default']).';">'.$content.'</span>';
 }

/**
 * processes BBCode size
 */ 
function do_bbcode_size($action, $attributes, $content, $params, $node_object) 
 {
  // font size definitions:
  #$size['tiny'] = 'x-small';
  $size['small'] = 'smaller';
  $size['large'] = 'large';
  #$size['huge'] = 'x-large';
  // end font size definitions
  
  if($action == 'validate') 
   {
    if(isset($size[$attributes['default']])) return true;
    else return false;
   } 
  return '<span style="font-size:'.$size[$attributes['default']].';">'.$content.'</span>';
 }

// processes BBCode links for e-mail notifications (plain text)
function do_bbcode_url_email($action, $attributes, $content, $params, &$node_object)
 {
  if ($action == 'validate') 
   {
    if(!isset ($attributes['default'])) return is_valid_url ($content);
    return is_valid_url ($attributes['default']);
   }
  else
   {
    if(!isset ($attributes['default'])) return $content;
    return $content.' --> '.$attributes['default'];
   }
 }

// processes BBCode msg code for e-mail notifications (plain text)
function do_bbcode_msg_email($action, $attributes, $content, $params, &$node_object)
 {
  if ($action == 'validate') 
   {
    if(!isset($attributes['default'])) 
     {
      if(intval($content)>0) return true;
     }
    if(intval($attributes['default'])>0) return true;
   }
  else
   {
    if(!isset ($attributes['default'])) return '#'.$content;
    return $content.' --> '.$attributes['default'];
   }
 }

/**
 * processes BBCode images for e-mail notifications (plain text)
 */ 
function do_bbcode_img_email ($action, $attributes, $content, $params, $node_object)
 {
  if ($action == 'validate') return true;
  return '['.$content.']';
 }

/**
 * processes BBCode colors for e-mail notifications (plain text)
 */ 
function do_bbcode_color_email($action, $attributes, $content, $params, $node_object)
 {
  if($action == 'validate') return true;
  return $content;
 }
 
/**
 * processes BBCode sizes for e-mail notifications (plain text)
 */ 
function do_bbcode_size_email($action, $attributes, $content, $params, $node_object)
 {
  if($action == 'validate') return true;
  return $content;
 } 

/**
 * processes bbcode code
 */  
function do_bbcode_code($action, $attributes, $content, $params, &$node_object) 
 {
  global $settings;
  if ($action == 'validate') 
   {
    // [code]...[/code]
    #if(!isset($attributes['default'])) return true;
    // [code=lang]image[/code]
    #if(in_array(strtolower($attributes['default']),explode(',',$settings['syntax_highlighter_languages']))) return true;
    return true;
   }
  else
   {
    // [code]...[/code]
    if(!isset($attributes['default'])) return '<pre><code>'.htmlspecialchars($content).'</code></pre>';
    // [code=lang]...[/code]
    if($settings['syntax_highlighter']==1)
     {
      include_once('modules/geshi/geshi.php');
      $geshi =& new GeSHi($content, $attributes['default']);
      #$geshi->set_header_type(GESHI_HEADER_NONE);
      $geshi->enable_keyword_links(false);
      $geshi->set_overall_class(false);
      return $geshi->parse_code();
     }
    else
     {
      return '<pre><code>'.htmlspecialchars($content).'</code></pre>';
     }  
   }
 }

/**
 * removes [code] and [/code] in email texts
 */  
function do_bbcode_code_email($action, $attributes, $content, $params, &$node_object) 
 {
  if ($action == 'validate') 
   {
    return true;
   }
  else
   {
    // [code]...[/code]
    if(!isset($attributes['default'])) return $content;
    // [code=lang]...[/code]
    return $content;
   }
 }

/**
 * replaces
 *   "> hi,
 *    > how are you?
 *    I'm fine, thank you!" 
 * by
 *   "[quote]hi,
 *    how are you?[/quote]
 *    I'm fine, thank you!"
  * also nested:
 *   "> > text
 *    > > text 
 * is replaces by       
 *   "[quote][quote]text
 *    text[/quote][/quote]"  
 *
 * @param string $string
 * @return string
 */
function quote($string)
 {
  global $settings;
  $string_array = explode("\n",$string);
  
  // check which lines begin with how many quote symbols:
  $line_nr=0;
  foreach($string_array as $line)
   {
    $q=0; // quote symbol counter
    // if line begins with a quote symbol...
    if(my_substr($line, 0, 1, CHARSET)==$settings['quote_symbol'])
     {
      $len=strlen($line);
      for($i=0;$i<$len;$i++)
       {
        // strip quote symbols and spaces and increment quote symbol counter
        if(my_substr($line, 0, 1, CHARSET)==$settings['quote_symbol'] || my_substr($line, 0, 1, CHARSET)==' ') 
         {
          if(my_substr($line, 0, 1, CHARSET)==$settings['quote_symbol']) $q++;
          $line = my_substr($line, 1, my_strlen($line, CHARSET), CHARSET);
         } 
        else break; // leave the loop if reached other character than quote symbol or space
       }  
      
     }
    // create array without quote symbols:
    $stripped_string_array[] = $line;
    // save number of quote symbols per line:
    $quotes_array[$line_nr] = $q;
    $line_nr++;
   }

  // if you want to keep the quote symbols delete or comment the following line:
  $string_array = $stripped_string_array;

  // add [quote]...[/quote] around quotes:
  $l=0;
  foreach($quotes_array as $quotes)
   {
    if($quotes > 0)
     { 
      $start_tag = '';
      $end_tag = '';
      // nest tags:
      for($q_nr=0;$q_nr<$quotes;$q_nr++) 
       { 
        $start_tag .= '[quote]';
        $end_tag .= '[/quote]';
       }
      // add start and end tags to quotes belonging together:
      if(empty($quotes_array[$l-1]) || $quotes!=$quotes_array[$l-1]) $string_array[$l] = $start_tag.$string_array[$l];
      if(empty($quotes_array[$l+1]) || $quotes!=$quotes_array[$l+1]) $string_array[$l] = $string_array[$l].$end_tag;
     } 
    $l++;
   }

  $string = implode("\n",$string_array);
  
  return $string;
 }

/**
 * formats posting texts into HTML using the stringparser bbcode class
 * http://www.christian-seiler.de/projekte/php/bbcode/
 *
 * @param string $string
 * @return string
 */
function html_format($string)
 {
  global $settings;
  require_once('modules/stringparser_bbcode/stringparser_bbcode.class.php');
  $bbcode = new StringParser_BBCode(); 
  $bbcode->addFilter (STRINGPARSER_FILTER_PRE, 'convertlinebreaks');
  $bbcode->addFilter (STRINGPARSER_FILTER_PRE, 'quote');
  $bbcode->addParser (array ('block', 'inline', 'link', 'listitem', 'quote', 'pre'), 'htmlspecialchars');
  $bbcode->addParser (array ('block', 'inline', 'link', 'listitem', 'quote'), 'nl2br');
  if($settings['smilies'] == 1) $bbcode->addParser (array ('block', 'inline', 'listitem', 'quote'), 'smilies');  
  if($settings['autolink'] == 1) $bbcode->addParser (array ('block', 'inline', 'listitem', 'quote'), 'make_link');

  $bbcode->addCode ('quote', 'simple_replace', null, array ('start_tag' => '<blockquote>', 'end_tag' => '</blockquote>'), 'quote', array ('block','quote'), array ());
  $bbcode->setCodeFlag ('quote', 'paragraphs', true);  
  $bbcode->setCodeFlag ('quote', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
  $bbcode->setCodeFlag ('quote', 'closetag.after.newline', BBCODE_NEWLINE_IGNORE);
  $bbcode->setCodeFlag ('quote', 'opentag.before.newline', BBCODE_NEWLINE_DROP);
  $bbcode->setCodeFlag ('quote', 'closetag.before.newline', BBCODE_NEWLINE_DROP);
  #$bbcode->setCodeFlag ('quote', 'closetag', BBCODE_CLOSETAG_OPTIONAL);
  
  if($settings['bbcode'] == 1)
   {
    $bbcode->setGlobalCaseSensitive(false);
    
    $bbcode->addCode ('b', 'simple_replace', null, array ('start_tag' => '<strong>', 'end_tag' => '</strong>'), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote', 'pre', 'monospace'), array ());
    $bbcode->addCode ('i', 'simple_replace', null, array ('start_tag' => '<em>', 'end_tag' => '</em>'), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote', 'pre', 'monospace'), array ());
    $bbcode->addCode ('u', 'simple_replace', null, array ('start_tag' => '<span class="underline">', 'end_tag' => '</span>'), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote', 'pre', 'monospace'), array ());
    $bbcode->addCode ('url', 'usecontent?', 'do_bbcode_url', array ('usecontent_param' => 'default'), 'link', array ('listitem', 'block', 'inline', 'quote', 'pre', 'monospace'), array ('link'));
    $bbcode->addCode ('link', 'usecontent?', 'do_bbcode_url', array ('usecontent_param' => 'default'), 'link', array ('listitem', 'block', 'inline', 'quote', 'pre', 'monospace'), array ('link'));
    $bbcode->addCode ('msg', 'usecontent?', 'do_bbcode_msg', array ('usecontent_param' => 'default'), 'link', array ('listitem', 'block', 'inline', 'quote', 'pre', 'monospace'), array ('link'));
    #$bbcode->setOccurrenceType ('img', 'image');
    #$bbcode->setMaxOccurrences ('image', 2);
    #$bbcode->addCode ('code', 'simple_replace', null, array ('start_tag' => '<pre><code>', 'end_tag' => '</code></pre>'), 'code', array ('block','quote'), array ());
    
    $bbcode->addParser ('list', 'bbcode_stripcontents');
    $bbcode->addCode ('list', 'simple_replace', null, array ('start_tag' => '<ul>', 'end_tag' => '</ul>'), 'list', array ('block', 'listitem', 'quote'), array ());
    $bbcode->setCodeFlag ('list', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
    $bbcode->setCodeFlag ('list', 'closetag.after.newline', BBCODE_NEWLINE_IGNORE);
    $bbcode->setCodeFlag ('list', 'opentag.before.newline', BBCODE_NEWLINE_DROP);
    $bbcode->setCodeFlag ('list', 'closetag.before.newline', BBCODE_NEWLINE_DROP);
    $bbcode->addCode ('*', 'simple_replace', null, array ('start_tag' => '<li>', 'end_tag' => '</li>'), 'listitem', array ('list'), array ());
    $bbcode->setCodeFlag ('*', 'closetag', BBCODE_CLOSETAG_OPTIONAL);
    #$bbcode->setCodeFlag ('*', 'paragraphs', true);
    
    if($settings['bbcode_code']==1)
     {
      $bbcode->addCode ('code', 'usecontent', 'do_bbcode_code', array (), 'code', array ('block','quote'), array ());    
      $bbcode->setCodeFlag ('code', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
      $bbcode->addParser ('inlinecode', 'parse_inlinecode');
      $bbcode->addParser ('monospace', 'parse_monospace');
      $bbcode->addCode('inlinecode', 'simple_replace', null, array ('start_tag' => '<code>', 'end_tag' => '</code>'), 'inlinecode', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
      $bbcode->addCode('monospace', 'simple_replace', null, array ('start_tag' => '<code class="monospace">', 'end_tag' => '</code>'), 'monospace', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
      $bbcode->addCode('pre', 'simple_replace', null, array ('start_tag' => '<pre>', 'end_tag' => '</pre>'), 'pre', array ('block','quote'), array ());
      $bbcode->setCodeFlag('pre', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
      #$bbcode->addCode('inlinepre', 'simple_replace', null, array ('start_tag' => '<pre class="inline">', 'end_tag' => '</pre>'), 'inlinepre', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
     }
    if($settings['bbcode_img']==1) 
     { 
      $bbcode->addCode ('img', 'usecontent', 'do_bbcode_img', array (), 'image', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
     }
    if($settings['bbcode_color']==1) 
     {
      $bbcode->addCode ('color', 'callback_replace', 'do_bbcode_color', array ('usecontent_param' => 'default'), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote', 'pre', 'monospace'), array ());
     }
    if($settings['bbcode_size']==1) 
     {
      $bbcode->addCode ('size', 'callback_replace', 'do_bbcode_size', array ('usecontent_param' => 'default'), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
     }
   }

  $bbcode->setRootParagraphHandling(true);
  $string = $bbcode->parse($string);            
  return $string;
 }

/**
 * formats signatures into HTML using the stringparser bbcode class
 * http://www.christian-seiler.de/projekte/php/bbcode/
 *
 * @param string $string
 * @return string
 */
function signature_format($string)
 {
  global $settings;
  // stringparser bbcode class, documentation: http://www.christian-seiler.de/projekte/php/bbcode/
  require_once('modules/stringparser_bbcode/stringparser_bbcode.class.php');
  $bbcode = new StringParser_BBCode(); 
  $bbcode->addFilter (STRINGPARSER_FILTER_PRE, 'convertlinebreaks');
  $bbcode->addParser (array ('block', 'inline', 'link', 'listitem', 'code', 'quote'), 'htmlspecialchars');
  $bbcode->addParser (array ('block', 'inline', 'link', 'listitem', 'quote'), 'nl2br');
  if($settings['smilies'] == 1) $bbcode->addParser (array ('block', 'inline', 'listitem', 'quote'), 'smilies');  
  if($settings['autolink'] == 1) $bbcode->addParser (array ('block', 'inline', 'listitem', 'quote'), 'make_link');
  if($settings['bbcode'] == 1)
   {
    $bbcode->setGlobalCaseSensitive(false);
    $bbcode->addCode ('b', 'simple_replace', null, array ('start_tag' => '<strong>', 'end_tag' => '</strong>'), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
    $bbcode->addCode ('i', 'simple_replace', null, array ('start_tag' => '<em>', 'end_tag' => '</em>'), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
    $bbcode->addCode ('u', 'simple_replace', null, array ('start_tag' => '<span class="underline">', 'end_tag' => '</span>'), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
    $bbcode->addCode ('url', 'usecontent?', 'do_bbcode_url', array ('usecontent_param' => 'default'), 'link', array ('listitem', 'block', 'inline', 'quote'), array ('link'));
    $bbcode->addCode ('link', 'usecontent?', 'do_bbcode_url', array ('usecontent_param' => 'default'), 'link', array ('listitem', 'block', 'inline', 'quote'), array ('link'));
    $bbcode->addCode ('color', 'callback_replace', 'do_bbcode_color', array ('usecontent_param' => 'default'), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
    #$bbcode->setOccurrenceType ('img', 'image');
    #$bbcode->setMaxOccurrences ('image', 2);
    if($settings['bbcode_img'] == 1) $bbcode->addCode ('img', 'usecontent', 'do_bbcode_img', array (), 'image', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
   }
  #$bbcode->setRootParagraphHandling(true);
  $string = $bbcode->parse($string);            
  return $string;
 }

/**
 * formats posting texts into plain text for e-mail notifications using the stringparser bbcode class
 * http://www.christian-seiler.de/projekte/php/bbcode/
 *
 * @param string $string
 * @return string
 */
function email_format($string)
 {
  global $settings;
  require_once('modules/stringparser_bbcode/stringparser_bbcode.class.php');
  $bbcode = new StringParser_BBCode(); 
  $bbcode->setGlobalCaseSensitive(false);
  $bbcode->addCode ('quote', 'simple_replace', null, array ('start_tag' => '', 'end_tag' => ''), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
  if($settings['bbcode'] == 1)
   {
    $bbcode->addParser ('list', 'bbcode_stripcontents');
    $bbcode->addCode ('b', 'simple_replace', null, array ('start_tag' => '*', 'end_tag' => '*'), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote', 'pre', 'monospace'), array ());
    $bbcode->addCode ('i', 'simple_replace', null, array ('start_tag' => '', 'end_tag' => ''), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote', 'pre', 'monospace'), array ());
    $bbcode->addCode ('u', 'simple_replace', null, array ('start_tag' => '', 'end_tag' => ''), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote', 'pre', 'monospace'), array ());
    $bbcode->addCode ('url', 'usecontent?', 'do_bbcode_url_email', array ('usecontent_param' => 'default'), 'link', array ('listitem', 'block', 'inline', 'quote', 'pre', 'monospace'), array ('link'));
    $bbcode->addCode ('link', 'usecontent?', 'do_bbcode_url_email', array ('usecontent_param' => 'default'), 'link', array ('listitem', 'block', 'inline', 'quote', 'pre', 'monospace'), array ('link'));
    if($settings['bbcode_img'] == 1) $bbcode->addCode ('img', 'usecontent', 'do_bbcode_img_email', array (), 'image', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
    $bbcode->addCode ('color', 'callback_replace', 'do_bbcode_color_email', array ('start_tag' => '', 'end_tag' => ''), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote', 'pre', 'monospace'), array ());
    $bbcode->addCode ('size', 'callback_replace', 'do_bbcode_size_email', array ('start_tag' => '', 'end_tag' => ''), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
    $bbcode->addCode ('list', 'simple_replace', null, array ('start_tag' => '', 'end_tag' => ''), 'list', array ('block', 'listitem'), array ());
    $bbcode->addCode ('*', 'simple_replace', null, array ('start_tag' => '* ', 'end_tag' => ''), 'listitem', array ('list'), array ());
    $bbcode->setCodeFlag ('*', 'closetag', BBCODE_CLOSETAG_OPTIONAL);    
    #$bbcode->addCode ('code', 'simple_replace', null, array ('start_tag' => '', 'end_tag' => ''), 'code', array ('block', 'inline'), array ());
    if($settings['bbcode_code']==1)
     {
      $bbcode->addCode('code', 'usecontent', 'do_bbcode_code_email', array (), 'code', array ('block','quote'), array ());    
      $bbcode->addCode ('pre', 'simple_replace', null, array ('start_tag' => '', 'end_tag' => ''), 'pre', array ('block', 'quote'), array ());
      $bbcode->addCode ('inlinecode', 'simple_replace', null, array ('start_tag' => '', 'end_tag' => ''), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
      $bbcode->addCode ('monospace', 'simple_replace', null, array ('start_tag' => '', 'end_tag' => ''), 'inline', array ('listitem', 'block', 'inline', 'link', 'quote'), array ());
     }
   }
  $string = $bbcode->parse($string);
  return $string;
 }

/**
 * adds the quote symbol (">") before each line for textareas in replies 
 *
 * @param string $string
 * @return string
 */
function quote_reply($string)
 {
  global $settings;
  $string = preg_replace("/^/m", $settings['quote_symbol']." ", $string);
  #$string = preg_replace("/^(".$settings['quote_symbol']." ){2,}/m", $settings['quote_symbol']." ", $string);
  return $string; 
 }

/**
 * shortens links 
 *
 * @param string $string
 * @return string
 */
function shorten_link($string)
 {
  global $settings;
  if(is_array($string))
   {
    if(count($string) == 2) { $pre = ""; $url = $string[1]; }
    else { $pre = $string[1]; $url = $string[2]; }
    $shortened_url = $url;
    if (strlen($url) > $settings['text_word_maxlength']) $shortened_url = my_substr($url, 0, $settings['text_word_maxlength']-3, CHARSET) . '...';
    return $pre.'<a href="'.$url.'">'.$shortened_url.'</a>';
   } 
 }

/**
 * shortens urls 
 *
 * @param string $url
 * @return string
 */
function shorten_url($url)
 {
  global $settings;
  if(strlen($url) > $settings['text_word_maxlength']) $url_short = my_substr($url, 0, $settings['text_word_maxlength']-3, CHARSET) . '...';
  else $url_short = $url;
  return $url_short;
 }

/**
 * replaces text smilies by images
 *
 * @param string $string
 * @return string
 */ 
function smilies($string)
 {
  global $connid, $db_settings;
  $result = mysql_query("SELECT file, code_1, code_2, code_3, code_4, code_5, title FROM ".$db_settings['smilies_table'], $connid);
  while($data = mysql_fetch_array($result))
   {
    if($data['title']!='') $title = ' title="'.stripslashes($data['title']).'"'; else $title='';
    if($data['code_1']!='') $string = str_replace($data['code_1'], "<img src=\"images/smilies/".$data['file']."\" alt=\"".$data['code_1']."\"".$title." />", $string);
    if($data['code_2']!='') $string = str_replace($data['code_2'], "<img src=\"images/smilies/".$data['file']."\" alt=\"".$data['code_2']."\"".$title." />", $string);
    if($data['code_3']!='') $string = str_replace($data['code_3'], "<img src=\"images/smilies/".$data['file']."\" alt=\"".$data['code_3']."\"".$title." />", $string);
    if($data['code_4']!='') $string = str_replace($data['code_4'], "<img src=\"images/smilies/".$data['file']."\" alt=\"".$data['code_4']."\"".$title." />", $string);
    if($data['code_5']!='') $string = str_replace($data['code_5'], "<img src=\"images/smilies/".$data['file']."\" alt=\"".$data['code_5']."\"".$title." />", $string);
   }
  mysql_free_result($result);
  return($string);
 }

/**
 * counts the users that are online
 */ 
function user_online($user_online_period=10)
 {
  global $connid, $db_settings, $settings;
  if (isset($_SESSION[$settings['session_prefix'].'user_id'])) $user_id = $_SESSION[$settings['session_prefix'].'user_id']; else $user_id = 0;
  $diff = time()-($user_online_period*60);
  if (isset($_SESSION[$settings['session_prefix'].'user_id'])) $ip = "uid_".$_SESSION[$settings['session_prefix'].'user_id'];
  else $ip = $_SERVER['REMOTE_ADDR'];
  @mysql_query("DELETE FROM ".$db_settings['useronline_table']." WHERE time < ".$diff, $connid);
  list($is_online) = @mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM ".$db_settings['useronline_table']." WHERE ip= '".$ip."'", $connid));
  if ($is_online > 0) @mysql_query("UPDATE ".$db_settings['useronline_table']." SET time='".time()."', user_id='".$user_id."' WHERE ip='".$ip."'", $connid);
  else @mysql_query("INSERT INTO ".$db_settings['useronline_table']." SET time='".time()."', ip='".$ip."', user_id='".$user_id."'", $connid);
  #list($user_online) = @mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM ".$db_settings['useronline_table'], $connid));
  #return $user_online;
 }

/**
 * checks strings for too long words
 */ 
function too_long_word($text,$word_maxlength)
 {
  $text_arr = str_replace("\n", " ", $text);
  $text_arr = explode(" ",$text_arr);
  for ($i=0;$i<count($text_arr);$i++)
   {
    trim($text_arr[$i]);
    $length = my_strlen($text_arr[$i], CHARSET);
    if($length > $word_maxlength)
     {
      $too_long_word = htmlspecialchars(stripslashes(my_substr($text_arr[$i],0,$word_maxlength, CHARSET)))."...";
      break;
     }
   }
  if(isset($too_long_word)) return $too_long_word;
  else return FALSE;
 }

/**
 * deletes a posting and all its replies
 * 
 * @param int $id : the id of the posting 
 */ 
function delete_posting_recursive($id)
 {
  global $db_settings, $connid;
  $id = intval($id);
  $result=mysql_query("SELECT pid, tid FROM ".$db_settings['forum_table']." WHERE id = ".$id, $connid) or raise_error('database_error',mysql_error());
  $field = mysql_fetch_array($result);
  $tid = $field['tid'];
  mysql_free_result($result);
  if($field["pid"] == 0)
   {
    // it's a thread starting posting - delete whole thread: 
        // clear cache:
        $ids_result=mysql_query("SELECT id FROM ".$db_settings['forum_table']." WHERE tid = ".intval($id), $connid);
        while($ids_data = mysql_fetch_array($ids_result))
         {
          @mysql_query("DELETE FROM ".$db_settings['entry_cache_table']." WHERE cache_id=".intval($ids_data['id']), $connid);
         }
        mysql_free_result($ids_result);
        // end clear cache
    @mysql_query("DELETE FROM ".$db_settings['forum_table']." WHERE tid = ".intval($id), $connid);
   }
  else
   {
    // it's a posting within the thread - delete posting and child postings: 
    $child_ids = get_child_ids($id);
    @mysql_query("DELETE FROM ".$db_settings['forum_table']." WHERE id = ".intval($id), $connid);
    @mysql_query("DELETE FROM ".$db_settings['entry_cache_table']." WHERE cache_id=".intval($id), $connid);
    if(isset($child_ids) && is_array($child_ids))
     {
      foreach($child_ids as $child_id)
       {
        @mysql_query("DELETE FROM ".$db_settings['forum_table']." WHERE id = ".intval($child_id), $connid);
        @mysql_query("DELETE FROM ".$db_settings['entry_cache_table']." WHERE cache_id=".intval($child_id), $connid);
       }
     }  
    // set last reply time:
    $result = @mysql_query("SELECT time FROM ".$db_settings['forum_table']." WHERE tid = ".intval($tid)." ORDER BY time DESC LIMIT 1", $connid) or raise_error('database_error',mysql_error());
    $field = mysql_fetch_array($result);
    mysql_free_result($result);
    @mysql_query("UPDATE ".$db_settings['forum_table']." SET time=time, last_reply='".$field['time']."' WHERE tid=".intval($tid), $connid);
   }
 }

/**
 * returns child ids of a posting
 * required by the function delete_posting_recursive 
 */ 
function get_child_ids($id)
 {
  global $db_settings, $connid, $child_ids;
  $result = @mysql_query("SELECT tid FROM ".$db_settings['forum_table']." WHERE id = ".intval($id)." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
  $data = mysql_fetch_array($result);
  mysql_free_result($result);
  $tid = $data['tid'];
  $result = @mysql_query("SELECT id, pid FROM ".$db_settings['forum_table']." WHERE tid = ".intval($tid), $connid) or raise_error('database_error',mysql_error());
  while($tmp = mysql_fetch_array($result))
   {
    $child_array[$tmp["pid"]][] = $tmp["id"];
   }
  mysql_free_result($result);
  child_ids_recursive($id, $child_array);
  if(isset($child_ids) && is_array($child_ids)) return($child_ids);
  else return false;
 }

/**
 * help function for get_child_ids
 */ 
function child_ids_recursive($id, $child_array)
 {
  global $child_ids;
  if(isset($child_array[$id]) && is_array($child_array[$id]))
   {
    foreach($child_array[$id] as $child)
     {
      $child_ids[] = $child; 
      child_ids_recursive($child, $child_array);
     }
   }  
 }

/**
 * checks if birthday is formed like DD.MM.YYYY and age is betwenn 0 and 150 years 
 */ 
function is_valid_birthday($birthday)
 {
  if(strlen($birthday) != 10 || my_substr($birthday,2,1,CHARSET)!='.' || my_substr($birthday,5,1, CHARSET)!='.') $date_invalid=true;
  if(empty($date_invalid))
   {
    $year = intval(my_substr($birthday, 6, 4, CHARSET));
    $month = intval(my_substr($birthday, 3, 2, CHARSET));
    $day = intval(my_substr($birthday, 0, 2, CHARSET));
    if(!checkdate($month,$day,$year)) $date_invalid=true;
   }
  if(empty($date_invalid))
   {
    if($month >= 1 && $month <= 9) $monthstr = '0'.$month; else $monthstr = $month;
    if($day >= 1 && $day <= 9) $daystr = '0'.$day; else $daystr = $day;
    $years = intval(strrev(my_substr(strrev(intval(strftime("%Y%m%d"))-intval($year.$monthstr.$daystr)),4, CHARSET)));
    if($years<0 || $years>150) $date_invalid=true;
   }
  if(empty($date_invalid)) return true;
  else return false; 
 } 

/**
 * sends an e-mail notification to the parent posting author if a reply was 
 * posted and a notification was requested 
 * 
 * @param int $id : the id of the reply
 * @param bool $delayed : true adds a delayed message (when postibg was activated manually)   
 */ 
function emailNotification2ParentAuthor($id, $delayed=false)
 {
  global $settings, $db_settings, $lang, $connid;
  $id=intval($id);
  // data of posting:
  $result = @mysql_query("SELECT pid, tid, name, user_name, ".$db_settings['forum_table'].".user_id, subject, text 
                          FROM ".$db_settings['forum_table']." 
                          LEFT JOIN ".$db_settings['userdata_table']." ON ".$db_settings['userdata_table'].".user_id=".$db_settings['forum_table'].".user_id
                          WHERE id = ".intval($id)." LIMIT 1", $connid);
  $data = mysql_fetch_array($result);
  mysql_free_result($result);
  // overwrite $data['name'] with $data['user_name'] if registered user:
  if($data['user_id']>0)
   {
    if(!$data['user_name']) $data['name'] = $lang['unknown_user'];
    else $data['name'] = $data['user_name'];
   }   
  // if it's a reply (pid!=0) check if notification was desired by parent posting author:
  if($data['pid']!=0)
   {
    $parent_result = mysql_query("SELECT pid, user_id, name, email, subject, text, email_notification FROM ".$db_settings['forum_table']." WHERE id = ".intval($data['pid'])." LIMIT 1", $connid);
    $parent_data = mysql_fetch_array($parent_result);
    mysql_free_result($parent_result);
    if($parent_data['email_notification'] == 1 && ($parent_data['user_id']>0 || $settings['email_notification_unregistered']))
     {
      // if message is by a registered user, fetch e-mail address from userdata:
      if($parent_data['user_id'] > 0)
       {
        $email_result = mysql_query("SELECT user_name, user_email FROM ".$db_settings['userdata_table']." WHERE user_id = ".intval($parent_data['user_id'])." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
        $field = mysql_fetch_array($email_result);
        mysql_free_result($email_result);
        $parent_data['name'] = $field['user_name'];
        $parent_data['email'] = $field['user_email'];
       }
      $name = stripslashes($data['name']);
      $subject = stripslashes($data['subject']);
      $text = email_format(stripslashes($data['text']));
      $emailbody = str_replace("[recipient]", $parent_data['name'], $lang['email_text']);
      $emailbody = str_replace("[name]", $name, $emailbody);
      $emailbody = str_replace("[subject]", $subject, $emailbody);
      $emailbody = str_replace("[text]", $text, $emailbody);
      $emailbody = str_replace("[posting_address]", $settings['forum_address']."index.php?id=".$id, $emailbody);
      $emailbody = str_replace("[original_subject]", $parent_data['subject'], $emailbody);
      $emailbody = str_replace("[original_text]", $parent_data["text"], $emailbody);
      $emailbody = str_replace("[forum_address]", $settings['forum_address'], $emailbody);
      if($delayed==true) $emailbody = $emailbody . "\n\n" . $lang['email_text_delayed_addition'];
      $emailbody = stripslashes($emailbody);
      $recipient = my_mb_encode_mimeheader($parent_data['name'], CHARSET, "Q")." <".$parent_data['email'].">";
      $subject = str_replace("[original_subject]",  stripslashes($parent_data['subject']), $lang['email_subject']);
      my_mail($recipient, $subject, $emailbody); 
     }
    if($parent_data['pid']!=0)
     {
      // parent posting wasn't thread start so check if thread starter autor wants to be notified:
      $ts_result = mysql_query("SELECT pid, user_id, name, email, subject, text, email_notification FROM ".$db_settings['forum_table']." WHERE id = ".intval($data['tid'])." LIMIT 1", $connid);
      $ts_data = mysql_fetch_array($ts_result);
      mysql_free_result($ts_result);
      if($ts_data['email_notification'] == 1 && ($ts_data['user_id']>0 || $settings['email_notification_unregistered']))
       {
        // if message is by a registered user, fetch e-mail address from userdata:
        if($ts_data['user_id'] > 0)
         {
          $email_result = mysql_query("SELECT user_name, user_email FROM ".$db_settings['userdata_table']." WHERE user_id = ".intval($ts_data['user_id'])." LIMIT 1", $connid) or raise_error('database_error',mysql_error());
          $field = mysql_fetch_array($email_result);
          mysql_free_result($email_result);
          $ts_data['name'] = $field['user_name'];
          $ts_data['email'] = $field['user_email'];
         }
        $name = stripslashes($data['name']);
        $subject = stripslashes($data['subject']);
        $text = email_format(stripslashes($data['text']));
        $emailbody = str_replace("[recipient]", $ts_data['name'], $lang['email_text']);
        $emailbody = str_replace("[name]", $name, $emailbody);
        $emailbody = str_replace("[subject]", $subject, $emailbody);
        $emailbody = str_replace("[text]", $text, $emailbody);
        $emailbody = str_replace("[posting_address]", $settings['forum_address']."index.php?id=".$id, $emailbody);
        $emailbody = str_replace("[original_subject]", $ts_data['subject'], $emailbody);
        $emailbody = str_replace("[original_text]", $ts_data["text"], $emailbody);
        $emailbody = str_replace("[forum_address]", $settings['forum_address'], $emailbody);
        if($delayed==true) $emailbody = $emailbody . "\n\n" . $lang['email_text_delayed_addition'];
        $emailbody = stripslashes($emailbody);
        $recipient = my_mb_encode_mimeheader($ts_data['name'], CHARSET, "Q")." <".$ts_data['email'].">";
        $subject = str_replace("[original_subject]",  stripslashes($ts_data['subject']), $lang['email_subject']);
        my_mail($recipient, $subject, $emailbody); 
       }      
     }
   }   
 }

/**
 * sends an e-mail notification to all admins and mods who have activated  
 * e-mail notification 
 * 
 * @param int $id : the id of the posting
 * @param bool $delayed : true adds a delayed message (when postibg was activated manually)   
 */ 
function emailNotification2ModsAndAdmins($id, $delayed=false)
 {
  global $settings, $db_settings, $lang, $connid;
  $id=intval($id);
  // data of posting:
  $result = @mysql_query("SELECT pid, name, user_name, ".$db_settings['forum_table'].".user_id, subject, text 
                         FROM ".$db_settings['forum_table']." 
                         LEFT JOIN ".$db_settings['userdata_table']." ON ".$db_settings['userdata_table'].".user_id=".$db_settings['forum_table'].".user_id
                         WHERE id = ".intval($id)." LIMIT 1", $connid);
  $data = mysql_fetch_array($result);
  mysql_free_result($result);
  // overwrite $data['name'] with $data['user_name'] if registered user:
  if($data['user_id']>0)
   {
    if(!$data['user_name']) $data['name'] = $lang['unknown_user'];
    else $data['name'] = $data['user_name'];
   }   
  $name = stripslashes($data['name']);
  $subject = stripslashes($data['subject']);
  $text = email_format(stripslashes($data['text']));
  if($data['pid'] > 0) $emailbody = str_replace("[name]", $name, $lang['admin_email_text_reply']); else $emailbody = str_replace("[name]", $name, $lang['admin_email_text']);
  $emailbody = str_replace("[subject]", $subject, $emailbody);
  $emailbody = str_replace("[text]", $text, $emailbody);
  $emailbody = str_replace("[posting_address]", $settings['forum_address']."index.php?id=".$id, $emailbody);
  $emailbody = str_replace("[forum_address]", $settings['forum_address'], $emailbody);
  if($delayed==true) $emailbody = $emailbody . "\n\n" . $lang['email_text_delayed_addition'];
  $emailbody = stripslashes($emailbody);
  $lang['admin_email_subject'] = str_replace("[subject]", stripslashes($subject), $lang['admin_email_subject']);
  // who gets an E-mail notification?
  $recipient_result = @mysql_query("SELECT user_name, user_email FROM ".$db_settings['userdata_table']." WHERE user_type > 0 AND new_posting_notification=1", $connid) or raise_error('database_error',mysql_error());
  while($admin_array = mysql_fetch_array($recipient_result))
   {
    $ind_emailbody = str_replace("[admin]", $admin_array['user_name'], $emailbody);
    $recipient = my_mb_encode_mimeheader($admin_array['user_name'], CHARSET, "Q")." <".$admin_array['user_email'].">";
    my_mail($recipient, $lang['admin_email_subject'], $ind_emailbody);
   }
  mysql_free_result($recipient_result);
 }

/**
 * function for the up/down buttons in the admin area in case JavaScript
 * isn't available   
 * 
 * @param string $table : name of database table
 * @param int $id : id of the item
 * @param string $direction : 'up' or 'down'    
 */ 
function move_item($table, $id, $direction)
 {
  global $connid;
  if($direction=='up')
   {
    $result = mysql_query("SELECT order_id FROM ".$table." WHERE id = ".intval($id)." LIMIT 1", $connid) or die(mysql_error());
    $data = mysql_fetch_array($result);
    mysql_free_result($result);
    if($data['order_id'] > 1)
     {
      mysql_query("UPDATE ".$table." SET order_id=0 WHERE order_id=".$data['order_id']."-1", $connid);
      mysql_query("UPDATE ".$table." SET order_id=order_id-1 WHERE order_id=".$data['order_id'], $connid);
      mysql_query("UPDATE ".$table." SET order_id=".$data['order_id']." WHERE order_id=0", $connid);
     }
   }
  else // down
   {
    list($item_count) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM ".$table, $connid));
    $result = mysql_query("SELECT order_id FROM ".$table." WHERE id = ".intval($id)." LIMIT 1", $connid) or die(mysql_error());
    $data = mysql_fetch_array($result);
    mysql_free_result($result);
    if ($data['order_id'] < $item_count)
     {
      mysql_query("UPDATE ".$table." SET order_id=0 WHERE order_id=".$data['order_id']."+1", $connid);
      mysql_query("UPDATE ".$table." SET order_id=order_id+1 WHERE order_id=".$data['order_id'], $connid);
      mysql_query("UPDATE ".$table." SET order_id=".$data['order_id']." WHERE order_id=0", $connid);
     }
   }   
 }

/**
 * resizes uploaded images 
 * 
 * @param string $uploaded_file : uploaded file
 * @param string $file : destination file 
 * @param int $new_width : new width
 * @param int $new_height : new height
 * @param int $compression : compression rate
 * @return bool
 */ 
function resize_image($uploaded_file, $file, $new_width, $new_height, $compression=80)
 {
  if(file_exists($file))
   {
    @chmod($file, 0777);
    @unlink($file);
   }
  
  $image_info = getimagesize($uploaded_file);
  if(!is_array($image_info) || $image_info[2] != 1 && $image_info[2] != 2 && $image_info[2] != 3) $error = true;
  if(empty($error))
  {
  if($image_info[2]==1) // GIF
   {
    $current_image = @ImageCreateFromGIF($uploaded_file) or $error = true;
    if(empty($error)) $new_image = @ImageCreate($new_width,$new_height) or $error = true;
    if(empty($error)) @ImageCopyResized($new_image,$current_image,0,0,0,0,$new_width,$new_height,$image_info[0],$image_info[1]) or $error=true;
    if(empty($error)) @ImageGIF($new_image, $file) or $error = true;
   }
  elseif($image_info[2]==2) // JPG
   {
    $current_image = @ImageCreateFromJPEG($uploaded_file) or $error = true;
    if(empty($error)) $new_image=@imagecreatetruecolor($new_width,$new_height) or $error = true;
    if(empty($error)) @ImageCopyResized($new_image,$current_image,0,0,0,0,$new_width,$new_height,$image_info[0],$image_info[1]) or $error = true;
    if(empty($error)) @ImageJPEG($new_image, $file, $compression) or $error = true;
   }
  elseif($image_info[2]==3) // PNG
   {
    $current_image=ImageCreateFromPNG($uploaded_file) or $error = true;
    if(empty($error)) $new_image=imagecreatetruecolor($new_width,$new_height) or $error = true;
    if(empty($error)) ImageCopyResized($new_image,$current_image,0,0,0,0,$new_width,$new_height,$image_info[0],$image_info[1]) or $error = true;
    if(empty($error)) ImagePNG($new_image, $file) or $error = $true;
   }
  }
  if(empty($error)) return true;
  else return false;
 }

/**
 * returns an array with recent tags 
 * 
 * @param int $days : period in days
 * @param int $scale_min : frequency mimimum scale 
 * @param int $scale_max : frequency maximun scale 
 * @return array
 */ 
function tag_cloud($days,$scale_min,$scale_max)
 {
  global $categories, $category_ids_query, $db_settings,$connid;
  if($categories==false)
   {
    $result = @mysql_query("SELECT tags FROM ".$db_settings['forum_table']." WHERE time > (NOW() - INTERVAL ".intval($days)." DAY)", $connid);
   }
  else
   {
    $result = @mysql_query("SELECT tags FROM ".$db_settings['forum_table']." WHERE category IN (".$category_ids_query.") AND time > (NOW() - INTERVAL ".intval($days)." DAY)", $connid);
   } 
  if(mysql_num_rows($result)>0)
   {
    while($data = mysql_fetch_array($result))
     {
      $entry_tags = stripslashes($data['tags']);
      if($entry_tags!='')
       { 
        $tags_help_array = explode(';',$entry_tags);
        $i=0;
        foreach($tags_help_array as $tag)
         {
          if($tag!='') 
           {
            $all_tags[] = $tag;
            $i++;
           } 
         }
       }
     }
   }

  if(isset($all_tags))
   {
    $tags_array = array();
    foreach($all_tags as $tag)
     {
      if(isset($tags_array[$tag])) $tags_array[$tag]++;
      else 
       {
        $tags_array[$tag] = 1;
       }   
     }
    ksort($tags_array);

    // minimum and maximum value:
    foreach($tags_array as $tag)
     {
      if(empty($max)) $max=$tag; elseif($tag>$max) $max=$tag;
      if(empty($min)) $min=$tag; elseif($tag<$min) $min=$tag;
     }
    reset($tags_array);
    
    if($max-$min<1) $d = 1;
    else $d = $max-$min;
    $m = ($scale_max-$scale_min)/$d;
    $t = $scale_min-$m*$min;
  
    $i=0;
    while(list($key, $val) = each($tags_array))
     {
      if(my_strpos($key, ' ', 0, CHARSET)) $tag_escaped='"'.$key.'"';
      else $tag_escaped = $key;
      $tags[$i]['tag'] = $key;
      $tags[$i]['escaped'] = urlencode($tag_escaped);
      $tags[$i]['frequency'] = round($m*$val+$t,0);
      $i++;
     } 
   } 
  if(isset($tags)) return $tags;
  else return false;
 }

/**
 * converts unix timestamp into a formated and utf-8 capable date string
 * 
 * @param string $format : like parameter for strftime()
 * @param int $timestamp : UNIX timestamp  
 * @return string
 */ 
function format_time($format, $timestamp=0)
 {
  if($timestamp==0) $timestamp=time();
  if(function_exists('iconv') && function_exists('iconv_get_encoding'))
   {
    $iconv_encoding = iconv_get_encoding();
    if(strtolower($iconv_encoding['input_encoding']) != strtolower(CHARSET))
     {
      $formated_time = iconv($iconv_encoding['input_encoding'],CHARSET,strftime($format,$timestamp));
     }
    else
     {
      $formated_time = strftime($format,$timestamp);
     }
   }
  else
   {
    $formated_time = strftime($format,$timestamp);
   }  
  return $formated_time;
 }

/**
 * checks permission to edit a posting 
 * 
 * @return int : 0 = not authorized, 1 = edit period expired, 2 = locked, 3 = posting has replies, 4 = no replies
 */ 
function get_edit_authorization($id, $posting_user_id, $edit_key, $time, $locked)
 {
  global $settings, $db_settings, $connid;

  $authorization['edit'] = false;
  $authorization['delete'] = false;
  
  $reply_result = mysql_query("SELECT COUNT(*) FROM ".$db_settings['forum_table']." WHERE pid = ".intval($id), $connid);
  list($replies) = mysql_fetch_row($reply_result);
  #$authorization['replies'] = $replies;
  
  if($settings['edit_min_time_period'] != 0 && (time() - $settings['edit_min_time_period']*60) < $time) $edit_min_time_period_expired = false;
  else $edit_min_time_period_expired = true; 

  if($settings['edit_max_time_period'] == 0 || (time() - $settings['edit_max_time_period']*60) < $time) $edit_max_time_period_expired = false;
  else $edit_max_time_period_expired = true; 
   
  if($locked == 0) $locked = false;
  else $locked = true;
  
  if(isset($_SESSION[$settings['session_prefix'].'user_id']) && isset($_SESSION[$settings['session_prefix'].'user_type'])) // registered user 
   {
    if($_SESSION[$settings['session_prefix'].'user_type'] > 0) // admin or mod 
     {
      $authorization['edit'] = true;
      $authorization['delete'] = true;
     }
    elseif($_SESSION[$settings['session_prefix'].'user_type']==0)
     {
      if($posting_user_id == $_SESSION[$settings['session_prefix'].'user_id'] && $settings['user_edit'] > 0 && $edit_max_time_period_expired==false && $locked==false)
       {
        if($settings['user_edit_if_no_replies']==0 || ($settings['user_edit_if_no_replies']==1 && ($replies==0 || $edit_min_time_period_expired==false)))
         {
          $authorization['edit'] = true;
         }
        if($replies==0)
         {
          $authorization['delete'] = true;
         }
       }
     } 
   }
  elseif($settings['user_edit']>1 && isset($_SESSION[$settings['session_prefix'].'edit_keys']))
   {
    if(isset($_SESSION[$settings['session_prefix'].'edit_keys'][$id]) && is_pw_correct($_SESSION[$settings['session_prefix'].'edit_keys'][$id],$edit_key) && trim($edit_key)!='' && $edit_max_time_period_expired==false && $locked==false) 
     {
      if($settings['user_edit_if_no_replies']==0 || ($settings['user_edit_if_no_replies']==1 && ($replies==0 || $edit_min_time_period_expired==false)))
       {
        $authorization['edit'] = true;
       }
      if($replies==0)
       {
        $authorization['delete'] = true;
       }
     }
   }
  return $authorization;
 }
  
/**
 * creates a backup file 
 * 
 * @param int $mode : 0 = complete, 1 = entries, 2 = userdata
 * @return bool
 */ 
function create_backup_file($mode=0)
 {
  global $settings, $db_settings, $connid;
  @set_time_limit(30);
  
  $mode=intval($mode);
  if($mode<0 || $mode > 7) $mode = 0;
  
  $dump = "# Database backup of ".$settings['forum_name'].", created on ".date("F d, Y, H:i:s")."\n";

  if($mode==0 || $mode==3) // settings
   {
    $dump .= "#\n";
    $dump .= "# ".$db_settings['settings_table']."\n";
    $dump .= "#\n";
    $dump .= "TRUNCATE TABLE ".$db_settings['settings_table'].";\n";
    $result = @mysql_query("SELECT name, value FROM ".$db_settings['settings_table'], $connid) or $error=true;
    while($data = mysql_fetch_array($result))
     {
      $data['name'] = mysql_real_escape_string($data['name']);
      $data['value'] = mysql_real_escape_string($data['value']);
      $dump .= "INSERT INTO ".$db_settings['settings_table']." VALUES ('".$data['name']."', '".$data['value']."');\n";
     }
    mysql_free_result($result);
   }
  
  if($mode==0 || $mode==4) // categories
   {
    $dump .= "#\n";
    $dump .= "# ".$db_settings['category_table']."\n";
    $dump .= "#\n";
    $dump .= "TRUNCATE TABLE ".$db_settings['category_table'].";\n";
    $result = @mysql_query("SELECT id, order_id, category, description, accession FROM ".$db_settings['category_table'], $connid) or $error=true;
    while($data = mysql_fetch_array($result))
     {
      $data['category'] = mysql_real_escape_string($data['category']);
      $data['description'] = mysql_real_escape_string($data['description']);
      $data['description'] = str_replace("\r", "\\r", $data['description']);
      $data['description'] = str_replace("\n",  "\\n", $data['description']);
      $dump .= "INSERT INTO ".$db_settings['category_table']." VALUES (".$data['id'].", ".$data['order_id'].", '".$data['category']."', '".$data['description']."', ".$data['accession'].");\n";
     }
    mysql_free_result($result);
   }
  
  if($mode==0 || $mode==5) // pages
   {
    $dump .= "#\n";
    $dump .= "# ".$db_settings['pages_table']."\n";
    $dump .= "#\n";
    $dump .= "TRUNCATE TABLE ".$db_settings['pages_table'].";\n";
    $result = @mysql_query("SELECT id, order_id, title, content, menu_linkname, access FROM ".$db_settings['pages_table'], $connid) or $error=true;
    while($data = mysql_fetch_array($result))
     {
      $data['title'] = mysql_real_escape_string($data['title']);
      $data['content'] = mysql_real_escape_string($data['content']);
      $data['content'] = str_replace("\r", "\\r", $data['content']);
      $data['content'] = str_replace("\n",  "\\n", $data['content']);
      $data['menu_linkname'] = mysql_real_escape_string($data['menu_linkname']);
      $dump .= "INSERT INTO ".$db_settings['pages_table']." VALUES (".$data['id'].", ".$data['order_id'].", '".$data['title']."', '".$data['content']."', '".$data['menu_linkname']."', ".$data['access'].");\n";
     }
    mysql_free_result($result);
   }
  
  if($mode==0 || $mode==6) // smilies
   {
    $dump .= "#\n";
    $dump .= "# ".$db_settings['smilies_table']."\n";
    $dump .= "#\n";
    $dump .= "TRUNCATE TABLE ".$db_settings['smilies_table'].";\n";
    $result = @mysql_query("SELECT id, order_id, file, code_1, code_2, code_3, code_4, code_5, title FROM ".$db_settings['smilies_table'], $connid) or $error=true;
    while($data = mysql_fetch_array($result))
     {
      $data['file'] = mysql_real_escape_string($data['file']);
      $data['code_1'] = mysql_real_escape_string($data['code_1']);
      $data['code_2'] = mysql_real_escape_string($data['code_2']);
      $data['code_3'] = mysql_real_escape_string($data['code_3']);
      $data['code_4'] = mysql_real_escape_string($data['code_4']);
      $data['code_5'] = mysql_real_escape_string($data['code_5']);
      $data['title'] = mysql_real_escape_string($data['title']);
      $dump .= "INSERT INTO ".$db_settings['smilies_table']." VALUES (".$data['id'].", ".$data['order_id'].", '".$data['file']."', '".$data['code_1']."', '".$data['code_2']."', '".$data['code_3']."', '".$data['code_4']."', '".$data['code_5']."', '".$data['title']."');\n";
     }
    mysql_free_result($result);
   }
   
  if($mode==0 || $mode==7) // banlists
   {
    $dump .= "#\n";
    $dump .= "# ".$db_settings['banlists_table']."\n";
    $dump .= "#\n";
    $dump .= "TRUNCATE TABLE ".$db_settings['banlists_table'].";\n";
    $result = @mysql_query("SELECT name, list FROM ".$db_settings['banlists_table'], $connid) or $error=true;
    while($data = mysql_fetch_array($result))
     {
      $data['name'] = mysql_real_escape_string($data['name']);
      $data['list'] = mysql_real_escape_string($data['list']);
      $dump .= "INSERT INTO ".$db_settings['banlists_table']." VALUES ('".$data['name']."', '".$data['list']."');\n";
     }
    mysql_free_result($result);
   }

  if($mode==0 || $mode==2) // userdata
   {
    $dump .= "#\n";
    $dump .= "# ".$db_settings['userdata_table']."\n";
    $dump .= "#\n";
    $dump .= "TRUNCATE TABLE ".$db_settings['userdata_table'].";\n";
    $dump .= "TRUNCATE TABLE ".$db_settings['userdata_cache_table'].";\n";
    $result = @mysql_query("SELECT user_id, user_type, user_name, user_real_name, gender, birthday, user_pw, user_email, email_contact, user_hp, user_location, signature, profile, logins, last_login, last_logout, user_ip, registered, thread_order, user_view, sidebar, fold_threads, thread_display, new_posting_notification, new_user_notification, time_difference, user_lock, auto_login_code, pwf_code, activate_code FROM ".$db_settings['userdata_table'], $connid) or $error=true;
    $time_start = time();
    while($data = mysql_fetch_array($result))
     {
      $data['user_name'] = mysql_real_escape_string($data['user_name']);
      $data['user_real_name'] = mysql_real_escape_string($data['user_real_name']);
      $data['birthday'] = mysql_real_escape_string($data['birthday']);
      $data['user_pw'] = mysql_real_escape_string($data['user_pw']);
      $data['user_email'] = mysql_real_escape_string($data['user_email']);
      $data['user_hp'] = mysql_real_escape_string($data['user_hp']);
      $data['user_location'] = mysql_real_escape_string($data['user_location']);
      $data['signature'] = mysql_real_escape_string($data['signature']);
      $data['signature'] = str_replace("\r", "\\r", $data['signature']);
      $data['signature'] = str_replace("\n",  "\\n", $data['signature']);
      $data['profile'] = mysql_real_escape_string($data['profile']);
      $data['profile'] = str_replace("\r", "\\r", $data['profile']);
      $data['profile'] = str_replace("\n",  "\\n", $data['profile']);
      $data['last_login'] = mysql_real_escape_string($data['last_logout']);
      $data['user_ip'] = mysql_real_escape_string($data['user_ip']);
      $data['registered'] = mysql_real_escape_string($data['registered']);
      $data['auto_login_code'] = mysql_real_escape_string($data['auto_login_code']);
      $data['pwf_code'] = mysql_real_escape_string($data['pwf_code']);
      $data['activate_code'] = mysql_real_escape_string($data['activate_code']);
      $dump .= "INSERT INTO ".$db_settings['userdata_table']." VALUES (".$data['user_id'].", ".$data['user_type'].", '".$data['user_name']."', '".$data['user_real_name']."', ".$data['gender'].", '".$data['birthday']."', '".$data['user_pw']."', '".$data['user_email']."', ".$data['email_contact'].", '".$data['user_hp']."', '".$data['user_location']."', '".$data['signature']."', '".$data['profile']."', ".$data['logins'].", '".$data['last_login']."', '".$data['last_logout']."', '".$data['user_ip']."', '".$data['registered']."', ".$data['thread_order'].", ".$data['user_view'].", ".$data['sidebar'].", ".$data['fold_threads'].", ".$data['thread_display'].", ".$data['new_posting_notification'].", ".$data['new_user_notification'].", ".$data['time_difference'].", ".$data['user_lock'].", '".$data['auto_login_code']."', '".$data['pwf_code']."', '".$data['activate_code']."');\n";
     
      $time_now = time();
      if(($time_now-25)>=$time_start)
       {
        echo 'xxx';
        $time_start = $time_now;
        @set_time_limit(30);
       }
     }
    mysql_free_result($result);
   }

  if($mode==0 || $mode==1) // entries
   {
    $dump .= "#\n";
    $dump .= "# ".$db_settings['forum_table']."\n";
    $dump .= "#\n";
    $dump .= "TRUNCATE TABLE ".$db_settings['forum_table'].";\n";
    $dump .= "TRUNCATE TABLE ".$db_settings['entry_cache_table'].";\n";
    $result = @mysql_query("SELECT id,pid,tid,uniqid,time,last_reply,edited,edited_by,user_id,name,subject,category,email,hp,location,ip,text,tags,show_signature,email_notification,marked,locked,sticky,views,spam,spam_check_status,edit_key FROM ".$db_settings['forum_table'], $connid) or $error=true;
    $time_start = time();
    while($data = mysql_fetch_array($result))
     {
      $data['uniqid'] = mysql_real_escape_string($data['uniqid']);
      $data['time'] = mysql_real_escape_string($data['time']);
      $data['last_reply'] = mysql_real_escape_string($data['last_reply']);
      $data['edited'] = mysql_real_escape_string($data['edited']);
      if(is_null($data['edited_by'])) $data['edited_by'] = 'NULL'; else $data['edited_by'] = intval($data['edited_by']);
      $data['name'] = mysql_real_escape_string($data['name']);
      $data['subject'] = mysql_real_escape_string($data['subject']);
      $data['email'] = mysql_real_escape_string($data['email']);
      $data['location'] = mysql_real_escape_string($data['location']);
      $data['ip'] = mysql_real_escape_string($data['ip']);
      $data['tags'] = mysql_real_escape_string($data['tags']);
      #$data['text'] = iconv("UTF-8","ISO-8859-1",$data['text']);
      $data['text'] = mysql_real_escape_string($data['text']);
      $data['text'] = str_replace("\r", "\\r", $data['text']);
      $data['text'] = str_replace("\n",  "\\n", $data['text']);
      $data['edit_key'] = mysql_real_escape_string($data['edit_key']);
      $dump .= "INSERT INTO ".$db_settings['forum_table']." VALUES (".$data['id'].", ".$data['pid'].", ".$data['tid'].", '".$data['uniqid']."', '".$data['time']."', '".$data['last_reply']."', '".$data['edited']."', ".$data['edited_by'].", ".$data['user_id'].", '".$data['name']."', '".$data['subject']."', ".$data['category'].", '".$data['email']."', '".$data['hp']."', '".$data['location']."', '".$data['ip']."', '".$data['text']."', '".$data['tags']."', ".$data['show_signature'].", ".$data['email_notification'].", ".$data['marked'].", ".$data['locked'].", ".$data['sticky'].", ".$data['views'].", ".$data['spam'].", ".$data['spam_check_status'].", '".$data['edit_key']."');\n";
     
      $time_now = time();
      if(($time_now-25)>=$time_start)
       {
        $time_start = $time_now;
        @set_time_limit(30);
       }
     }
    mysql_free_result($result);
   }
  
  // write dump into backup file:
  if(empty($error))
   {
    switch($mode)
     {
      case 0: $filename = 'mlf_backup_complete_'.date("YmdHis").'.sql'; break;
      case 1: $filename = 'mlf_backup_entries_'.date("YmdHis").'.sql'; break;
      case 2: $filename = 'mlf_backup_userdata_'.date("YmdHis").'.sql'; break;
      case 3: $filename = 'mlf_backup_settings_'.date("YmdHis").'.sql'; break;
      case 4: $filename = 'mlf_backup_categories_'.date("YmdHis").'.sql'; break;
      case 5: $filename = 'mlf_backup_pages_'.date("YmdHis").'.sql'; break;
      case 6: $filename = 'mlf_backup_smilies_'.date("YmdHis").'.sql'; break;
      case 7: $filename = 'mlf_backup_banlists_'.date("YmdHis").'.sql'; break;
     }
    if($fp = @fopen('backup/'.$filename, 'w'))
     {
      flock($fp, 2);  
      #fwrite($fp, "\xEF\xBB\xBF");
      fwrite($fp, $dump);
      flock($fp, 3);
      fclose($fp);
     } 
    else $error = true;
   }
  if(empty($error)) return true;
  else return false;     
 }

/**
 * restores a backup file
 *
 * @param string $backup_file
 */ 
function restore_backup($backup_file, $error_message='')
 {
  global $connid, $error_message;
  @set_time_limit(30);
  
  $lines = file($backup_file);
  $cleared_lines = array();
  foreach($lines as $line)
   {
    $line = trim($line);
    if(my_substr($line, -1, my_strlen($line, CHARSET), CHARSET)==';') $line = my_substr($line,0,-1,CHARSET);
    if($line != '' && my_substr($line,0,1,CHARSET)!='#') $cleared_lines[] = $line;
   }
  
  $time_start = time();
         
  @mysql_query("START TRANSACTION", $connid) or die(mysql_error());
  foreach($cleared_lines as $line)
   {
    if(!@mysql_query($line, $connid)) 
     {
      $error_message = mysql_error($connid);
      break;
     } 
    
    $time_now = time();
    if(($time_now-25)>=$time_start)
     {
      $time_start = $time_now;
      @set_time_limit(30);
      #header('X-mlf2-says: Hello World!');
     }
    
   }
  @mysql_query("COMMIT", $connid);
  if(empty($error_message)) return true;
  else return false;
 }

/**
 * checks file names
 *
 * @param string $filename
 * @return bool 
 */ 
function check_filename($filename)
 {
  #$file_name = trim($filename);
  #$file_name = str_replace('/','',$file_name);
  #$file_name = str_replace('\\','',$file_name);
  #$file_name = str_replace('..','',$file_name);
  #return $file_name;  
  if(preg_match('/^[a-zA-Z0-9._\-]+$/', $filename)) return true;
  else return false;
 }

/**
 * generates a random string
 *
 * @param int $length
 * @param string $characters 
 * @return string 
 */ 
function random_string($length=8,$characters='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
 {
  $random_string = '';
  $characters_length = strlen($characters);
  for($i=0;$i<$length;$i++)
   {
    $random_string .= $characters[mt_rand(0, $characters_length - 1)];
   }
  return $random_string;
 } 

/**
 * generates password hash
 *
 * @param string $pw 
 * @return string 
 */ 
function generate_pw_hash($pw)
 {
  $salt = random_string(10,'0123456789abcdef');
  $salted_hash = sha1($pw.$salt);
  $hash_with_salt = $salted_hash.$salt;
  return $hash_with_salt;
 } 

/**
 * checks password comparing it with the hash
 *
 * @param string $pw
 * @param string $hash
 * @return bool 
 */ 
function is_pw_correct($pw,$hash)
 {
  if(strlen($hash)==50) // salted sha1 hash with salt
   {
    $salted_hash = substr($hash,0,40);
    $salt = substr($hash,40,10);
    if(sha1($pw.$salt)==$salted_hash) return true;
    else return false;
   }
  elseif(strlen($hash)==32) // md5 hash generated in an older version
   {
    if($hash == md5($pw)) return true;
    else return false;
   } 
  else return false;
 } 

/**
 * add "http://" to url if given without protocol 
 *
 * @param string $url
 * @return string 
 */ 
function add_http_if_no_protocol($url)
 {
  if(my_substr($url,0,7,CHARSET) != 'http://' && my_substr($url,0,8,CHARSET) != 'https://' && my_substr($url,0,6,CHARSET) != 'ftp://' && my_substr($url,0,9,CHARSET) != 'gopher://' && my_substr($url,0,7,CHARSET) != 'news://')
   {
    $url = 'http://'.$url;
   }
  return $url;
 }  

/**
 * determine string length using mb_strlen if available or strlen if not
 *
 * @param string $string
 * @param string $encoding
 * @return int 
 */ 
function my_strlen($string, $encoding='utf-8')
 {
  if(function_exists('mb_strlen'))
   {
    return mb_strlen($string, $encoding); 
   }
  else
   {
    return strlen($string); 
   } 
 }

/**
 * returns string with all alphabetic characters converted to lowercase
 * using mb_strtolower if available or strtolower if not
 *
 * @param string $string
 * @param string $encoding
 * @return string 
 */ 
function my_strtolower($string, $encoding='utf-8')
 {
  if(function_exists('mb_strtolower'))
   {
    return mb_strtolower($string, $encoding); 
   }
  else
   {
    return strtolower($string); 
   } 
 }

/**
 * gets part of string using mb_substr if available or substr if not
 *
 * @param string $string
 * @param string $encoding
 * @return string 
 */ 
function my_substr($string, $start, $length, $encoding='utf-8')
 {
  if(function_exists('mb_substr'))
   {
    return mb_substr($string, $start, $length, $encoding); 
   }
  else
   {
    return substr($string, $start, $length); 
   } 
 }

/**
 * find position of first occurrence of string in a string using mb_strpos 
 * if available or strpos if not
 *
 * @param string $haystack
 * @param mixed $needle
 * @param int $offset
 * @param string $encoding  
 * @return string 
 */ 
function my_strpos($haystack, $needle, $offset=0, $encoding='utf-8')
 {
  if(function_exists('mb_strpos'))
   {
    return mb_strpos($haystack, $needle, $offset, $encoding); 
   }
  else
   {
    return strpos($haystack, $needle, $offset); 
   } 
 }

/**
 * encodes a given string by the MIME header encoding scheme using 
 * mb_encode_mimeheader if available or base64_encode if not
 *
 * @param string $string
 * @param string $encoding
 * @param string $transfer_encoding 
 * @return string 
 */ 
function my_mb_encode_mimeheader($string, $charset, $transfer_encoding)
 {
  if(function_exists('mb_internal_encoding') && function_exists('mb_encode_mimeheader'))
   {
    mb_internal_encoding($charset);
    $string = mb_encode_mimeheader($string, $charset, $transfer_encoding, '');
    return $string;    
   }
  else
   {
    return '=?'.$charset.'?B?'.base64_encode($string).'?=';
   } 
 }

/**
 * sends an email 
 *
 * @param string $to
 * @param string $subject
 * @param string $message
 * @param string $headers  
 * @return string 
 */ 
function my_mail($to, $subject, $message, $from='')
 {
  global $settings;
  if($from == '')
   {
    $headers = "From: " . my_mb_encode_mimeheader($settings['forum_name'], CHARSET, "Q")." <".$settings['forum_email'].">". MAIL_HEADER_SEPARATOR;
   }
  else
   {
    $headers  = "From: " . $from . MAIL_HEADER_SEPARATOR;
   }
 
  $headers .= "X-Sender-IP: ".$_SERVER["REMOTE_ADDR"] . MAIL_HEADER_SEPARATOR;
  $headers .= "X-Mailer: " . $settings['forum_address'] . MAIL_HEADER_SEPARATOR;
  $headers .= "Content-Type: text/plain; charset=" . CHARSET . MAIL_HEADER_SEPARATOR;
  $headers .= "Content-transfer-encoding: 8bit" . MAIL_HEADER_SEPARATOR;

  $subject = my_mb_encode_mimeheader($subject, CHARSET, "Q");
  
  // for debugging:
  /*
  echo '<pre>';
  echo $headers;
  echo "\n\n";
  echo $to . "\n" . $subject . "\n\n" . $message;
  exit;
  */
  
  if($settings['mail_parameter']!='')
   {
    if(@mail($to, $subject, $message, $headers, $settings['mail_parameter']))
     {
      return true;
     }
    else
     {
      return false;
     }
   } 
  else
   {
    if(@mail($to, $subject, $message, $headers))
     {
      return true;
     }
    else
     {
      return false;
     }   
   }
 }

/**
 * sends a status code, displays an error message and halts the script
 *
 * @param string $status_code
 */ 
function raise_error($error,$error_message='')
 {
  global $settings, $lang;
  if(empty($lang['language'])) $lang['language'] ='en';
  if(empty($lang['charset'])) $lang['charset'] ='utf-8';
  if(empty($lang['db_error'])) $lang['db_error'] = 'Database error';
  if(empty($settings['forum_name'])) $settings['forum_name'] = 'my little forum';
  $title = 'Error';
  $message = '';
  switch($error)
   {
    case '403':
     header($_SERVER['SERVER_PROTOCOL'] . " 403 Forbidden");
     header("Status: 403 Forbidden");
     $title = '403 Forbidden';
     $message = 'You don\'t have permission to access this page.';
     break;
    case 'mysql_connect':
     header($_SERVER['SERVER_PROTOCOL'] . " 503 Service Unavailable");
     header("Status: 503 Service Unavailable");  
     $title = 'Database error';
     $message = 'Could not connect to the MySQL database. The forum is probably not installed yet.';
     if($error_message!='') $message .= '<br />MySQL error message: '.$error_message;
     break;
    case 'mysql_select_db':
     header($_SERVER['SERVER_PROTOCOL'] . " 503 Service Unavailable");
     header("Status: 503 Service Unavailable");  
     $title = 'Database error';
     $message = 'The Database could not be selected. The script is probably not installed yet.';
     if($error_message!='') $message .= '<br />MySQL error message: '.$error_message;
     break;
    case 'database_error':
     header($_SERVER['SERVER_PROTOCOL'] . " 503 Service Unavailable");
     header("Status: 503 Service Unavailable");  
     $title = $lang['db_error'];
     if($error_message!='') $message = $error_message;
     break;
    default:
     header($_SERVER['SERVER_PROTOCOL'] . " 503 Service Unavailable");
     header("Status: 503 Service Unavailable");  
     break;
   }
  ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang['language']; ?>">
  <head>
  <title><?php echo $settings['forum_name'].' - '.$title; ?></title>
  <meta http-equiv="content-type" content="text/html; charset=<?php echo $lang['charset']; ?>" />
  <style type="text/css">
  <!--
  body              { color:#000; background:#fff; margin:0; padding:0; font-family: verdana, arial, sans-serif; font-size:100.1%; }
  h1                { font-size:1.25em; }
  p,ul              { font-size:0.82em; line-height:1.45em; }
  #top              { margin:0; padding:0 20px 0 20px; height:4.4em; color:#000000; background:#d2ddea; border-bottom: 1px solid #bacbdf; line-height:4.4em;}
  #top h1           { font-size:1.7em; margin:0; padding:0; color:#000080; }
  #content          { padding:20px; }
  -->
  </style>
  </head>
  <body>
  <div id="top"><h1><?php echo $settings['forum_name']; ?></h1></div>
  <div id="content">
  <h1><?php echo $title; ?></h1>
  <p><?php echo $message; ?></p>
  </div>
  </body>
  </html><?php
  exit; 
 }

?>
