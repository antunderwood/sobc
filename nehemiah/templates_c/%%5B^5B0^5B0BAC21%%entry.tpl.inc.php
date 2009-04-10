<?php /* Smarty version 2.6.22, created on 2009-03-03 00:32:14
         compiled from default/subtemplates/entry.tpl.inc */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'default/subtemplates/entry.tpl.inc', 1, false),array('modifier', 'replace', 'default/subtemplates/entry.tpl.inc', 28, false),array('modifier', 'escape', 'default/subtemplates/entry.tpl.inc', 49, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['settings']['language_file'],'section' => 'entry'), $this);?>

<?php $this->assign('template', $this->_tpl_vars['settings']['template']); ?>
<?php $this->assign('email_alt', $this->_config[0]['vars']['email']); ?>
<?php $this->assign('homepage_alt', $this->_config[0]['vars']['homepage']); ?>
<?php if ($this->_tpl_vars['hp'] && ! $this->_tpl_vars['email']): ?>
<?php $this->assign('email_hp', " <a href=\"".($this->_tpl_vars['hp'])."\"><img src=\"templates/".($this->_tpl_vars['template'])."/images/homepage.png\" title=\"".($this->_tpl_vars['homepage_alt'])."\" alt=\"⌂\" width=\"13\" height=\"13\" /></a>"); ?>
<?php elseif (! $this->_tpl_vars['hp'] && $this->_tpl_vars['email']): ?>
<?php $this->assign('email_hp', " <a href=\"index.php?mode=contact&amp;id=".($this->_tpl_vars['id'])."\"><img src=\"templates/".($this->_tpl_vars['template'])."/images/email.png\" title=\"".($this->_tpl_vars['email_alt'])."\" alt=\"@\" width=\"13\" height=\"10\" /></a>"); ?>
<?php elseif ($this->_tpl_vars['hp'] && $this->_tpl_vars['email']): ?>
<?php $this->assign('email_hp', " <a href=\"".($this->_tpl_vars['hp'])."\"><img src=\"templates/".($this->_tpl_vars['template'])."/images/homepage.png\" title=\"".($this->_tpl_vars['homepage_alt'])."\" alt=\"⌂\" width=\"13\" height=\"13\" /></a> <a href=\"index.php?mode=contact&amp;id=".($this->_tpl_vars['id'])."\"><img src=\"templates/".($this->_tpl_vars['template'])."/images/email.png\" title=\"".($this->_tpl_vars['email_alt'])."\" alt=\"@\" width=\"13\" height=\"10\" /></a>"); ?>
<?php else: ?>
<?php $this->assign('email_hp', ""); ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['user_type'] == 2): ?>
<?php $this->assign('admin_title', $this->_config[0]['vars']['administrator_title']); ?>
<?php $this->assign('name', "<span class=\"admin\" title=\"".($this->_tpl_vars['admin_title'])."\">".($this->_tpl_vars['name'])."</span>"); ?>
<?php elseif ($this->_tpl_vars['user_type'] == 1): ?>
<?php $this->assign('mod_title', $this->_config[0]['vars']['moderator_title']); ?>
<?php $this->assign('name', "<span class=\"mod\" title=\"".($this->_tpl_vars['mod_title'])."\">".($this->_tpl_vars['name'])."</span>"); ?>
<?php else: ?>
<?php $this->assign('name', ($this->_tpl_vars['name'])); ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['posting_user_id'] > 0 && ( $this->_tpl_vars['user'] || $this->_tpl_vars['settings']['user_area_public'] == 1 )): ?><?php $this->assign('name', "<a href=\"index.php?mode=user&amp;show_user=".($this->_tpl_vars['posting_user_id'])."\">".($this->_tpl_vars['name'])."</a>"); ?><?php endif; ?>
<div class="posting"><?php if ($this->_tpl_vars['spam']): ?><p class="spam-note"><?php echo $this->_config[0]['vars']['spam_note']; ?>
</p><?php endif; ?>
<?php if ($this->_tpl_vars['avatar']): ?><img class="avatar" src="<?php echo $this->_tpl_vars['avatar']['image']; ?>
" alt="<?php echo $this->_config[0]['vars']['avatar_img_alt']; ?>
" width="<?php echo $this->_tpl_vars['avatar']['width']; ?>
" height="<?php echo $this->_tpl_vars['avatar']['height']; ?>
" /><?php endif; ?>
<h1><?php echo $this->_tpl_vars['subject']; ?>
<?php if ($this->_tpl_vars['category_name']): ?> <span class="category">(<?php echo $this->_tpl_vars['category_name']; ?>
)</span><?php endif; ?></h1>
<p class="author"><?php if ($this->_tpl_vars['location']): ?><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['posted_by_location'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[name]", $this->_tpl_vars['name']) : smarty_modifier_replace($_tmp, "[name]", $this->_tpl_vars['name'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[email_hp]", $this->_tpl_vars['email_hp']) : smarty_modifier_replace($_tmp, "[email_hp]", $this->_tpl_vars['email_hp'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[location]", $this->_tpl_vars['location']) : smarty_modifier_replace($_tmp, "[location]", $this->_tpl_vars['location'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[time]", $this->_tpl_vars['formated_time']) : smarty_modifier_replace($_tmp, "[time]", $this->_tpl_vars['formated_time'])); ?>
<?php else: ?><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['posted_by'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[name]", $this->_tpl_vars['name']) : smarty_modifier_replace($_tmp, "[name]", $this->_tpl_vars['name'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[email_hp]", $this->_tpl_vars['email_hp']) : smarty_modifier_replace($_tmp, "[email_hp]", $this->_tpl_vars['email_hp'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[time]", $this->_tpl_vars['formated_time']) : smarty_modifier_replace($_tmp, "[time]", $this->_tpl_vars['formated_time'])); ?>
<?php endif; ?><?php if ($this->_tpl_vars['admin']): ?> <span class="ip">(<?php echo $this->_tpl_vars['ip']; ?>
)</span><?php endif; ?><?php if ($this->_tpl_vars['pid'] != 0): ?> <span class="op-link"><a href="index.php?id=<?php echo $this->_tpl_vars['pid']; ?>
" title="<?php echo ((is_array($_tmp=$this->_config[0]['vars']['original_posting_linktitle'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[name]", $this->_tpl_vars['data'][$this->_tpl_vars['pid']]['name']) : smarty_modifier_replace($_tmp, "[name]", $this->_tpl_vars['data'][$this->_tpl_vars['pid']]['name'])); ?>
">@ <?php echo $this->_tpl_vars['data'][$this->_tpl_vars['pid']]['name']; ?>
</a></span><?php endif; ?><?php if ($this->_tpl_vars['edited']): ?><br />
<span class="edited"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['edited_by'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[name]", $this->_tpl_vars['edited_by']) : smarty_modifier_replace($_tmp, "[name]", $this->_tpl_vars['edited_by'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[time]", $this->_tpl_vars['formated_edit_time']) : smarty_modifier_replace($_tmp, "[time]", $this->_tpl_vars['formated_edit_time'])); ?>
</span><?php endif; ?></p>
<?php if ($this->_tpl_vars['posting']): ?>
<?php echo $this->_tpl_vars['posting']; ?>

<?php else: ?>
<p><?php echo $this->_config[0]['vars']['no_text']; ?>
</p>
<?php endif; ?>
<?php if ($this->_tpl_vars['signature']): ?>
<p class="signature">---<br />
<?php echo $this->_tpl_vars['signature']; ?>
</p>
<?php endif; ?>
<?php if ($this->_tpl_vars['tags']): ?>
<p class="tags"><?php echo $this->_config[0]['vars']['tags_marking']; ?>
<br />
<?php $_from = $this->_tpl_vars['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tags'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tags']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['tag']):
        $this->_foreach['tags']['iteration']++;
?><a href="index.php?mode=search&amp;search=<?php echo $this->_tpl_vars['tag']['escaped']; ?>
&amp;method=tags"><?php echo $this->_tpl_vars['tag']['display']; ?>
</a><?php if (! ($this->_foreach['tags']['iteration'] == $this->_foreach['tags']['total'])): ?>, <?php endif; ?><?php endforeach; endif; unset($_from); ?></p>
<?php endif; ?>
</div>
<div class="postingbottom">
<div class="postinganswer"><?php if ($this->_tpl_vars['locked'] == 0): ?><a class="stronglink" href="index.php?mode=posting&amp;id=<?php echo $this->_tpl_vars['id']; ?>
&amp;back=entry" title="<?php echo $this->_config[0]['vars']['reply_link_title']; ?>
"><?php echo $this->_config[0]['vars']['reply_link']; ?>
</a><?php else: ?><span class="locked"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/lock.png" alt="" width="14" height="12" /><?php echo $this->_config[0]['vars']['posting_locked']; ?>
</span><?php endif; ?></div>
<div class="postingedit">&nbsp;
<?php if ($this->_tpl_vars['views']): ?><span class="xsmall"><?php if ($this->_tpl_vars['views'] == 1): ?><?php echo $this->_config[0]['vars']['one_view']; ?>
<?php else: ?><?php echo ((is_array($_tmp=$this->_config[0]['vars']['several_views'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[views]", $this->_tpl_vars['views']) : smarty_modifier_replace($_tmp, "[views]", $this->_tpl_vars['views'])); ?>
<?php endif; ?></span><?php endif; ?>
<?php if ($this->_tpl_vars['edit_authorization']): ?> &nbsp;<span class="small"><a href="index.php?mode=posting&amp;edit=<?php echo $this->_tpl_vars['id']; ?>
&amp;back=entry" title="<?php echo $this->_config[0]['vars']['edit_message_linktitle']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/edit_small.png" alt="" width="15" height="10" /><?php echo $this->_config[0]['vars']['edit_message_linkname']; ?>
</a></span><?php endif; ?>
<?php if ($this->_tpl_vars['delete_authorization']): ?> &nbsp;<span class="small"><a href="index.php?mode=posting&amp;delete_posting=<?php echo $this->_tpl_vars['id']; ?>
&amp;back=entry" title="<?php echo $this->_config[0]['vars']['delete_message_linktitle']; ?>
" onclick="return delete_posting_confirm(this, '<?php if ($this->_tpl_vars['admin'] || $this->_tpl_vars['mod']): ?><?php echo ((is_array($_tmp=$this->_config[0]['vars']['delete_posting_confirm_admin'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
<?php else: ?><?php echo ((is_array($_tmp=$this->_config[0]['vars']['delete_posting_confirm'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
<?php endif; ?>')"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/delete_small.png" alt="" width="13" height="9" /><?php echo $this->_config[0]['vars']['delete_message_linkname']; ?>
</a></span><?php endif; ?>
<?php if ($this->_tpl_vars['move_posting_link']): ?> &nbsp;<span class="small"><a href="index.php?mode=posting&amp;move_posting=<?php echo $this->_tpl_vars['id']; ?>
&amp;back=entry" title="<?php echo $this->_config[0]['vars']['move_posting_linktitle']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/move_posting.png" alt="" width="14" height="10" /><?php echo $this->_config[0]['vars']['move_posting_linkname']; ?>
</a></span><?php endif; ?>
<?php if ($this->_tpl_vars['report_spam_link']): ?> &nbsp;<span class="small"><a href="index.php?mode=posting&amp;report_spam=<?php echo $this->_tpl_vars['id']; ?>
&amp;back=entry" title="<?php echo $this->_config[0]['vars']['report_spam_linktitle']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/spam_link.png" alt="" width="13" height="9" /><?php echo $this->_config[0]['vars']['report_spam_linkname']; ?>
</a></span><?php endif; ?>
<?php if ($this->_tpl_vars['flag_ham_link']): ?> &nbsp;<span class="small"><a href="index.php?mode=posting&amp;flag_ham=<?php echo $this->_tpl_vars['id']; ?>
&amp;back=entry" title="<?php echo $this->_config[0]['vars']['flag_ham_linktitle']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/spam_link.png" alt="" width="13" height="9" /><?php echo $this->_config[0]['vars']['flag_ham_linkname']; ?>
</a></span><?php endif; ?>
<?php if ($this->_tpl_vars['admin'] || $this->_tpl_vars['mod']): ?> &nbsp;<span class="small"><a href="index.php?mode=posting&amp;lock=<?php echo $this->_tpl_vars['id']; ?>
&amp;back=entry" title="<?php if ($this->_tpl_vars['locked'] == 0): ?><?php echo $this->_config[0]['vars']['lock_linktitle']; ?>
<?php else: ?><?php echo $this->_config[0]['vars']['unlock_linktitle']; ?>
<?php endif; ?>"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/<?php if ($this->_tpl_vars['locked'] == 0): ?>lock.png<?php else: ?>unlock.png<?php endif; ?>" alt="" width="14" height="12" /><?php if ($this->_tpl_vars['locked'] == 0): ?><?php echo $this->_config[0]['vars']['lock_linkname']; ?>
<?php else: ?><?php echo $this->_config[0]['vars']['unlock_linkname']; ?>
<?php endif; ?></a></span><?php if ($this->_tpl_vars['pid'] == 0): ?> &nbsp;<span class="small"><a href="index.php?mode=posting&amp;lock_thread=<?php echo $this->_tpl_vars['id']; ?>
&amp;back=entry" title="<?php echo $this->_config[0]['vars']['lock_thread_linktitle']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/lock_thread.png" alt="" width="14" height="12" /><?php echo $this->_config[0]['vars']['lock_thread_linkname']; ?>
</a></span> &nbsp;<span class="small"><a href="index.php?mode=posting&amp;unlock_thread=<?php echo $this->_tpl_vars['id']; ?>
&amp;back=entry" title="<?php echo $this->_config[0]['vars']['unlock_thread_linktitle']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/unlock_thread.png" alt="" width="14" height="12" /><?php echo $this->_config[0]['vars']['unlock_thread_linkname']; ?>
</a></span><?php endif; ?><?php endif; ?>
</div></div>


<hr class="entryline" />
<div class="complete-thread">
<p class="left"><strong><?php echo $this->_config[0]['vars']['complete_thread_marking']; ?>
</strong></p><p class="right">&nbsp;<?php if ($this->_tpl_vars['settings']['rss_feed'] == 1): ?><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/rss_link.png" alt="" width="13" height="9" /><a href="index.php?mode=rss&amp;thread=<?php echo $this->_tpl_vars['tid']; ?>
" title="<?php echo $this->_config[0]['vars']['rss_feed_thread_title']; ?>
"><?php echo $this->_config[0]['vars']['rss_feed_thread']; ?>
</a><?php endif; ?></p>
</div>
<?php if (!function_exists('smarty_fun_tree')) { function smarty_fun_tree(&$smarty, $params) { $_fun_tpl_vars = $smarty->_tpl_vars; $smarty->assign($params);  ?>
<?php $smarty->assign('level', $smarty->_tpl_vars['level']+1); ?>
<?php $_from = $smarty->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $smarty->_tpl_vars['element']):
?>
<?php if (is_array ( $smarty->_tpl_vars['element'] )): ?><ul class="<?php if ($smarty->_tpl_vars['level'] == 1): ?>complete-thread<?php elseif ($smarty->_tpl_vars['level'] > 1 && $smarty->_tpl_vars['level'] < $smarty->_tpl_vars['settings']['deep_reply']): ?>reply<?php elseif ($smarty->_tpl_vars['level'] >= $smarty->_tpl_vars['settings']['deep_reply'] && $smarty->_tpl_vars['level'] < $smarty->_tpl_vars['settings']['very_deep_reply']): ?>deep-reply<?php else: ?>very-deep-reply<?php endif; ?>"><?php smarty_fun_tree($smarty, array('list'=>$smarty->_tpl_vars['element'],'level'=>$smarty->_tpl_vars['level']));  ?></li></ul>
<?php else: ?><li><?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id'] != $smarty->_tpl_vars['id']): ?><a class="<?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] == 0 && $smarty->_tpl_vars['newtime'] && $smarty->_tpl_vars['newtime'] < $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['last_reply'] || $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] == 0 && $smarty->_tpl_vars['last_visit'] && $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['last_reply'] > $smarty->_tpl_vars['last_visit']): ?>threadnew<?php elseif ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] == 0): ?>thread<?php elseif ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] != 0 && $smarty->_tpl_vars['newtime'] && $smarty->_tpl_vars['newtime'] < $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['time'] || $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] != 0 && $smarty->_tpl_vars['last_visit'] && $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['time'] > $smarty->_tpl_vars['last_visit']): ?>replynew<?php else: ?>reply<?php endif; ?><?php if ($smarty->_tpl_vars['visited'] && in_array ( $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id'] , $smarty->_tpl_vars['visited'] )): ?> visited<?php endif; ?>" href="index.php?id=<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
"><?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['subject']; ?>
</a><?php else: ?><span class="<?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] == 0): ?>actthread<?php else: ?>actreply<?php endif; ?>"><?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['subject']; ?>
</span><?php endif; ?><?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['no_text']): ?> <img class="no-text" src="templates/<?php echo $smarty->_tpl_vars['settings']['template']; ?>
/images/no_text.png" title="<?php echo $smarty->_config[0]['vars']['no_text_title']; ?>
" alt="<?php echo $smarty->_config[0]['vars']['no_text_alt']; ?>
" width="11" height="9" /><?php endif; ?> - <strong><?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['name']; ?>
</strong>, <?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['formated_time']; ?>
<?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id'] != $smarty->_tpl_vars['id']): ?> <a href="#" onclick="ajax_preview(<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
,'<?php echo $smarty->_config[0]['vars']['reply_link']; ?>
'); return false" title="<?php echo $smarty->_config[0]['vars']['ajax_preview_title']; ?>
"><img src="templates/<?php echo $smarty->_tpl_vars['settings']['template']; ?>
/images/ajax_preview.png" title="<?php echo $smarty->_config[0]['vars']['ajax_preview_title']; ?>
" alt="[…]" width="11" height="11" /></a><?php endif; ?><?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] == 0): ?> <a href="index.php?mode=thread&amp;id=<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
" title="<?php echo $smarty->_config[0]['vars']['open_whole_thread']; ?>
"><img src="templates/<?php echo $smarty->_tpl_vars['settings']['template']; ?>
/images/complete_thread.png" title="<?php echo $smarty->_config[0]['vars']['open_whole_thread']; ?>
" alt="[*]" width="11" height="11" /></a><?php endif; ?><?php if ($smarty->_tpl_vars['admin'] || $smarty->_tpl_vars['mod']): ?> <a id="marklink_<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
" href="index.php?mode=posting&amp;mark=<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
&amp;back=<?php echo $smarty->_tpl_vars['id']; ?>
" title="<?php echo $smarty->_config[0]['vars']['mark_linktitle']; ?>
" onclick="mark(<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
,'templates/<?php echo $smarty->_tpl_vars['settings']['template']; ?>
/images/marked.png','templates/<?php echo $smarty->_tpl_vars['settings']['template']; ?>
/images/unmarked.png','templates/<?php echo $smarty->_tpl_vars['settings']['template']; ?>
/images/mark_process.png','<?php echo $smarty->_config[0]['vars']['mark_linktitle']; ?>
','<?php echo $smarty->_config[0]['vars']['unmark_linktitle']; ?>
'); return false"><?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['marked'] == 0): ?><img id="markimg_<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
" src="templates/<?php echo $smarty->_tpl_vars['settings']['template']; ?>
/images/unmarked.png" title="<?php echo $smarty->_config[0]['vars']['mark_linktitle']; ?>
" alt="[○]" width="11" height="11" /><?php else: ?><img id="markimg_<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
" src="templates/<?php echo $smarty->_tpl_vars['settings']['template']; ?>
/images/marked.png" title="<?php echo $smarty->_config[0]['vars']['unmark_linktitle']; ?>
" alt="[●]" width="11" height="11" title="<?php echo $smarty->_config[0]['vars']['unmark_linktitle']; ?>
" /><?php endif; ?></a> <a href="index.php?mode=posting&amp;delete_posting=<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
&amp;back=entry" title="<?php echo $smarty->_config[0]['vars']['delete_posting_title']; ?>
" onclick="return delete_posting_confirm(this, '<?php echo ((is_array($_tmp=$smarty->_config[0]['vars']['delete_posting_confirm'])) ? $smarty->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
')"><img src="templates/<?php echo $smarty->_tpl_vars['template']; ?>
/images/delete_small_2.png" alt="[x]" width="9" height="9" /></a><?php endif; ?><?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['category_name'] && $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] == 0 && $smarty->_tpl_vars['category'] == 0): ?> <a href="index.php?mode=index&amp;category=<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['category']; ?>
"><span class="category">(<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['category_name']; ?>
)</span></a><?php endif; ?>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php  $smarty->_tpl_vars = $_fun_tpl_vars; }} smarty_fun_tree($this, array('list'=>$this->_tpl_vars['tree'],'level'=>0));  ?>

 

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/subtemplates/ajax_preview.tpl.inc", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>