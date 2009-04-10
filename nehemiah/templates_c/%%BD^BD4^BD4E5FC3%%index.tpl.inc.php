<?php /* Smarty version 2.6.22, created on 2009-03-03 00:22:42
         compiled from default/subtemplates/index.tpl.inc */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'default/subtemplates/index.tpl.inc', 10, false),array('modifier', 'replace', 'default/subtemplates/index.tpl.inc', 11, false),array('modifier', 'escape', 'default/subtemplates/index.tpl.inc', 42, false),)), $this); ?>
<?php if ($this->_tpl_vars['tag_cloud'] || $this->_tpl_vars['latest_postings'] || $this->_tpl_vars['admin'] || $this->_tpl_vars['mod']): ?>
<div id="sidebar">
<a href="index.php?toggle_sidebar=true" onclick="toggle_sidebar('templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/hide_sidebar.png','templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/show_sidebar.png'); return false;"><img id="sidebartoggle" src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/<?php if ($this->_tpl_vars['usersettings']['sidebar'] == 0): ?>show_sidebar.png<?php else: ?>hide_sidebar.png<?php endif; ?>" title="<?php echo $this->_config[0]['vars']['toggle_sidebar']; ?>
" alt="[+/-]" width="9" height="9" /></a>
<h3 class="sidebar"><a href="index.php?toggle_sidebar=true" title="<?php echo $this->_config[0]['vars']['toggle_sidebar']; ?>
" onclick="toggle_sidebar('templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/hide_sidebar.png','templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/show_sidebar.png'); return false;"><?php echo $this->_config[0]['vars']['sidebar']; ?>
</a></h3>
<div id="sidebarcontent"<?php if ($this->_tpl_vars['usersettings']['sidebar'] == 0): ?> style="display:none;"<?php endif; ?>>
<?php if ($this->_tpl_vars['latest_postings']): ?>
<div id="latest-postings" <?php if ($this->_tpl_vars['usersettings']['latest_postings'] == 0): ?> style="width:7em;"<?php endif; ?>>
<h3><?php echo $this->_config[0]['vars']['latest_postings_hl']; ?>
</h3>
<ul id="latest-postings-container"<?php if ($this->_tpl_vars['usersettings']['latest_postings'] == 0): ?> style="display:none;"<?php endif; ?>>
<?php $_from = $this->_tpl_vars['latest_postings']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['posting']):
?><li><a href="index.php?id=<?php echo $this->_tpl_vars['posting']['id']; ?>
" title="<?php echo $this->_tpl_vars['posting']['name']; ?>
, <?php echo $this->_tpl_vars['posting']['formated_time']; ?>
<?php if ($this->_tpl_vars['posting']['category_name']): ?> (<?php echo $this->_tpl_vars['posting']['category_name']; ?>
)<?php endif; ?>"><span<?php if ($this->_tpl_vars['visited'] && in_array ( $this->_tpl_vars['posting']['id'] , $this->_tpl_vars['visited'] )): ?> class="visited"<?php endif; ?>><?php if ($this->_tpl_vars['posting']['pid'] == 0): ?><strong><?php echo ((is_array($_tmp=$this->_tpl_vars['posting']['subject'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 29, "...") : smarty_modifier_truncate($_tmp, 29, "...")); ?>
</strong><?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['posting']['subject'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 29, "...") : smarty_modifier_truncate($_tmp, 29, "...")); ?>
<?php endif; ?></span><br />
<?php if ($this->_tpl_vars['posting']['days_ago'] == 0 && $this->_tpl_vars['posting']['hours_ago'] == 0): ?><?php echo ((is_array($_tmp=$this->_config[0]['vars']['posting_minutes_ago'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[minutes]", $this->_tpl_vars['posting']['minutes_ago']) : smarty_modifier_replace($_tmp, "[minutes]", $this->_tpl_vars['posting']['minutes_ago'])); ?>
<?php elseif ($this->_tpl_vars['posting']['days_ago'] == 0 && $this->_tpl_vars['posting']['hours_ago'] != 0): ?><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['posting_hours_ago'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[hours]", $this->_tpl_vars['posting']['hours_ago']) : smarty_modifier_replace($_tmp, "[hours]", $this->_tpl_vars['posting']['hours_ago'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[minutes]", $this->_tpl_vars['posting']['minutes_ago']) : smarty_modifier_replace($_tmp, "[minutes]", $this->_tpl_vars['posting']['minutes_ago'])); ?>
<?php else: ?><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['posting_days_ago'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[days]", $this->_tpl_vars['posting']['days_ago']) : smarty_modifier_replace($_tmp, "[days]", $this->_tpl_vars['posting']['days_ago'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[hours]", $this->_tpl_vars['posting']['hours_ago']) : smarty_modifier_replace($_tmp, "[hours]", $this->_tpl_vars['posting']['hours_ago'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[minutes]", $this->_tpl_vars['posting']['minutes_ago']) : smarty_modifier_replace($_tmp, "[minutes]", $this->_tpl_vars['posting']['minutes_ago'])); ?>
<?php endif; ?></a></li><?php endforeach; endif; unset($_from); ?>
</ul>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['tag_cloud']): ?>
<div id="tagcloud">
<h3><?php echo $this->_config[0]['vars']['tag_cloud_hl']; ?>
</h3>
<p id="tagcloud-container"><?php $_from = $this->_tpl_vars['tag_cloud']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tag']):
?>
<?php unset($this->_sections['strong_start']);
$this->_sections['strong_start']['name'] = 'strong_start';
$this->_sections['strong_start']['start'] = (int)0;
$this->_sections['strong_start']['loop'] = is_array($_loop=$this->_tpl_vars['tag']['frequency']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['strong_start']['show'] = true;
$this->_sections['strong_start']['max'] = $this->_sections['strong_start']['loop'];
$this->_sections['strong_start']['step'] = 1;
if ($this->_sections['strong_start']['start'] < 0)
    $this->_sections['strong_start']['start'] = max($this->_sections['strong_start']['step'] > 0 ? 0 : -1, $this->_sections['strong_start']['loop'] + $this->_sections['strong_start']['start']);
else
    $this->_sections['strong_start']['start'] = min($this->_sections['strong_start']['start'], $this->_sections['strong_start']['step'] > 0 ? $this->_sections['strong_start']['loop'] : $this->_sections['strong_start']['loop']-1);
if ($this->_sections['strong_start']['show']) {
    $this->_sections['strong_start']['total'] = min(ceil(($this->_sections['strong_start']['step'] > 0 ? $this->_sections['strong_start']['loop'] - $this->_sections['strong_start']['start'] : $this->_sections['strong_start']['start']+1)/abs($this->_sections['strong_start']['step'])), $this->_sections['strong_start']['max']);
    if ($this->_sections['strong_start']['total'] == 0)
        $this->_sections['strong_start']['show'] = false;
} else
    $this->_sections['strong_start']['total'] = 0;
if ($this->_sections['strong_start']['show']):

            for ($this->_sections['strong_start']['index'] = $this->_sections['strong_start']['start'], $this->_sections['strong_start']['iteration'] = 1;
                 $this->_sections['strong_start']['iteration'] <= $this->_sections['strong_start']['total'];
                 $this->_sections['strong_start']['index'] += $this->_sections['strong_start']['step'], $this->_sections['strong_start']['iteration']++):
$this->_sections['strong_start']['rownum'] = $this->_sections['strong_start']['iteration'];
$this->_sections['strong_start']['index_prev'] = $this->_sections['strong_start']['index'] - $this->_sections['strong_start']['step'];
$this->_sections['strong_start']['index_next'] = $this->_sections['strong_start']['index'] + $this->_sections['strong_start']['step'];
$this->_sections['strong_start']['first']      = ($this->_sections['strong_start']['iteration'] == 1);
$this->_sections['strong_start']['last']       = ($this->_sections['strong_start']['iteration'] == $this->_sections['strong_start']['total']);
?><strong><?php endfor; endif; ?><a href="index.php?mode=search&amp;search=<?php echo $this->_tpl_vars['tag']['escaped']; ?>
&amp;method=tags"><?php echo $this->_tpl_vars['tag']['tag']; ?>
</a> <?php unset($this->_sections['strong_end']);
$this->_sections['strong_end']['name'] = 'strong_end';
$this->_sections['strong_end']['start'] = (int)0;
$this->_sections['strong_end']['loop'] = is_array($_loop=$this->_tpl_vars['tag']['frequency']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['strong_end']['show'] = true;
$this->_sections['strong_end']['max'] = $this->_sections['strong_end']['loop'];
$this->_sections['strong_end']['step'] = 1;
if ($this->_sections['strong_end']['start'] < 0)
    $this->_sections['strong_end']['start'] = max($this->_sections['strong_end']['step'] > 0 ? 0 : -1, $this->_sections['strong_end']['loop'] + $this->_sections['strong_end']['start']);
else
    $this->_sections['strong_end']['start'] = min($this->_sections['strong_end']['start'], $this->_sections['strong_end']['step'] > 0 ? $this->_sections['strong_end']['loop'] : $this->_sections['strong_end']['loop']-1);
if ($this->_sections['strong_end']['show']) {
    $this->_sections['strong_end']['total'] = min(ceil(($this->_sections['strong_end']['step'] > 0 ? $this->_sections['strong_end']['loop'] - $this->_sections['strong_end']['start'] : $this->_sections['strong_end']['start']+1)/abs($this->_sections['strong_end']['step'])), $this->_sections['strong_end']['max']);
    if ($this->_sections['strong_end']['total'] == 0)
        $this->_sections['strong_end']['show'] = false;
} else
    $this->_sections['strong_end']['total'] = 0;
if ($this->_sections['strong_end']['show']):

            for ($this->_sections['strong_end']['index'] = $this->_sections['strong_end']['start'], $this->_sections['strong_end']['iteration'] = 1;
                 $this->_sections['strong_end']['iteration'] <= $this->_sections['strong_end']['total'];
                 $this->_sections['strong_end']['index'] += $this->_sections['strong_end']['step'], $this->_sections['strong_end']['iteration']++):
$this->_sections['strong_end']['rownum'] = $this->_sections['strong_end']['iteration'];
$this->_sections['strong_end']['index_prev'] = $this->_sections['strong_end']['index'] - $this->_sections['strong_end']['step'];
$this->_sections['strong_end']['index_next'] = $this->_sections['strong_end']['index'] + $this->_sections['strong_end']['step'];
$this->_sections['strong_end']['first']      = ($this->_sections['strong_end']['iteration'] == 1);
$this->_sections['strong_end']['last']       = ($this->_sections['strong_end']['iteration'] == $this->_sections['strong_end']['total']);
?></strong><?php endfor; endif; ?>
<?php endforeach; endif; unset($_from); ?></p>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['admin'] || $this->_tpl_vars['mod']): ?>
<div id="modmenu">
<h3><?php echo $this->_config[0]['vars']['options']; ?>
</h3>
<ul>
<li><a href="index.php?mode=posting&amp;delete_marked=true"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/marked_link.png" alt="" width="13" height="9" /><?php echo $this->_config[0]['vars']['delete_marked_link']; ?>
</a></li>
<li><a href="index.php?mode=posting&amp;manage_postings=true"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/manage_postings.png" alt="" width="13" height="9" /><?php echo $this->_config[0]['vars']['manage_postings_link']; ?>
</a></li>
<?php if ($this->_tpl_vars['show_spam_link']): ?><li><a href="index.php?show_spam=true"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/spam_link.png" alt="" width="13" height="9" /><?php echo ((is_array($_tmp=$this->_config[0]['vars']['show_spam_link'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[number]", $this->_tpl_vars['total_spam']) : smarty_modifier_replace($_tmp, "[number]", $this->_tpl_vars['total_spam'])); ?>
</a></li><?php endif; ?>
<?php if ($this->_tpl_vars['hide_spam_link']): ?><li><a href="index.php?show_spam=true"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/spam_link.png" alt="" width="13" height="9" /><?php echo ((is_array($_tmp=$this->_config[0]['vars']['hide_spam_link'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[number]", $this->_tpl_vars['total_spam']) : smarty_modifier_replace($_tmp, "[number]", $this->_tpl_vars['total_spam'])); ?>
</a></li><?php endif; ?>
<?php if ($this->_tpl_vars['delete_spam_link']): ?><li><a href="index.php?mode=posting&amp;delete_spam=true"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/delete_small.png" alt="" width="13" height="9" /><?php echo $this->_config[0]['vars']['delete_spam_link']; ?>
</a></li><?php endif; ?>
</ul>
</div><?php endif; ?>
</div>
</div>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/subtemplates/ajax_preview.tpl.inc", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">/* <![CDATA[ */
<?php if ($this->_tpl_vars['admin'] || $this->_tpl_vars['mod']): ?>
function mk(id)
<?php echo '{'; ?>

mark(id,'templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/marked.png','templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/unmarked.png','templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/mark_process.png','<?php echo ((is_array($_tmp=$this->_config[0]['vars']['mark_linktitle'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
','<?php echo ((is_array($_tmp=$this->_config[0]['vars']['unmark_linktitle'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
');
<?php echo '}'; ?>

function dl(ths)
<?php echo '{'; ?>

return delete_posting_confirm(ths, '<?php echo ((is_array($_tmp=$this->_config[0]['vars']['delete_posting_confirm_admin'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
')
<?php echo '}'; ?>

<?php endif; ?>
function ap(id,locked)
<?php echo '{'; ?>

var reply_link = typeof(locked) == 'undefined' || locked == 0 ? 1 : 0;
document.write(' <a href="#" onclick="ajax_preview('+id+','+reply_link+'); return false" title="<?php echo ((is_array($_tmp=$this->_config[0]['vars']['ajax_preview_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
" onfocus="this.blur()"><img class="ap" src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/ajax_preview.png" title="<?php echo ((is_array($_tmp=$this->_config[0]['vars']['ajax_preview_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
" alt="[…]" width="11" height="11" /><\/a>'); 
<?php echo '}'; ?>

<?php if ($this->_tpl_vars['fold_threads'] == 1): ?>
function ft(id,replies)
<?php echo '{'; ?>
 
if(replies > 0) document.write('<a id="expand_link_'+id+'" href="#" onclick="fold_thread('+id+',\'templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/expand_thread.png\',\'templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/fold_thread.png\'); return false" title="<?php echo ((is_array($_tmp=$this->_config[0]['vars']['expand_fold_thread_linktitle'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
"><img id="expand_img_'+id+'" src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/expand_thread.png" title="<?php echo ((is_array($_tmp=$this->_config[0]['vars']['expand_fold_thread_linktitle'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
" alt="[+]" width="9" height="11" /><\/a> ');
else document.write('<img id="expand_img_'+id+'" src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/expand_thread_inactive.png" alt="[+]" width="9" height="11" /> ');
<?php echo '}'; ?>

<?php endif; ?>
/* ]]> */</script>
<?php if ($this->_tpl_vars['tree']): ?>
<?php if (!function_exists('smarty_fun_tree')) { function smarty_fun_tree(&$smarty, $params) { $_fun_tpl_vars = $smarty->_tpl_vars; $smarty->assign($params);  ?>
<?php $smarty->assign('level', $smarty->_tpl_vars['level']+1); ?>
<?php $_from = $smarty->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $smarty->_tpl_vars['element']):
?>
<?php if (is_array ( $smarty->_tpl_vars['element'] )): ?><ul<?php if ($smarty->_tpl_vars['level'] == 1): ?> id="thread-<?php echo $smarty->_tpl_vars['element']['0']; ?>
"<?php elseif ($smarty->_tpl_vars['level'] > 1 && $smarty->_tpl_vars['fold_threads'] == 1): ?> style="display:none;"<?php endif; ?> class="<?php if ($smarty->_tpl_vars['level'] == 1): ?>thread<?php elseif ($smarty->_tpl_vars['level'] > 1 && $smarty->_tpl_vars['level'] < $smarty->_tpl_vars['settings']['deep_reply']): ?>reply<?php elseif ($smarty->_tpl_vars['level'] >= $smarty->_tpl_vars['settings']['deep_reply'] && $smarty->_tpl_vars['level'] < $smarty->_tpl_vars['settings']['very_deep_reply']): ?>deep-reply<?php else: ?>very-deep-reply<?php endif; ?>"><?php smarty_fun_tree($smarty, array('list'=>$smarty->_tpl_vars['element'],'level'=>$smarty->_tpl_vars['level']));  ?></li></ul>
<?php else: ?><li><?php if ($smarty->_tpl_vars['fold_threads'] == 1 && $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] == 0): ?><script type="text/javascript">/* <![CDATA[ */ ft(<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
,<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['replies']; ?>
) /* ]]> */</script><?php endif; ?><a class="<?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] == 0 && $smarty->_tpl_vars['newtime'] && $smarty->_tpl_vars['newtime'] < $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['last_reply'] || $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] == 0 && $smarty->_tpl_vars['last_visit'] && $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['last_reply'] > $smarty->_tpl_vars['last_visit']): ?><?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['sticky'] == 1): ?>threadnew-sticky<?php else: ?>threadnew<?php endif; ?><?php elseif ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] == 0): ?><?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['sticky'] == 1): ?>thread-sticky<?php else: ?>thread<?php endif; ?><?php elseif ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] != 0 && $smarty->_tpl_vars['newtime'] && $smarty->_tpl_vars['newtime'] < $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['time'] || $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] != 0 && $smarty->_tpl_vars['last_visit'] && $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['time'] > $smarty->_tpl_vars['last_visit']): ?>replynew<?php else: ?>reply<?php endif; ?><?php if ($smarty->_tpl_vars['visited'] && in_array ( $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id'] , $smarty->_tpl_vars['visited'] )): ?> visited<?php endif; ?>" href="index.php?id=<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
"<?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['spam'] == 1): ?> title="<?php echo $smarty->_config[0]['vars']['spam']; ?>
"<?php endif; ?>><?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['spam'] == 1): ?><span class="spam"><?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['subject']; ?>
</span><?php else: ?><?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['subject']; ?>
<?php endif; ?></a><?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['no_text']): ?> <img class="no-text" src="templates/<?php echo $smarty->_tpl_vars['settings']['template']; ?>
/images/no_text.png" title="<?php echo $smarty->_config[0]['vars']['no_text_title']; ?>
" alt="<?php echo $smarty->_config[0]['vars']['no_text_alt']; ?>
" width="11" height="9" /><?php endif; ?> - <strong><?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['user_type'] == 2): ?><span class="admin" title="<?php echo $smarty->_config[0]['vars']['administrator_title']; ?>
"><?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['name']; ?>
</span><?php elseif ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['user_type'] == 1): ?><span class="mod" title="<?php echo $smarty->_config[0]['vars']['moderator_title']; ?>
"><?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['name']; ?>
</span><?php else: ?><?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['name']; ?>
<?php endif; ?></strong>, <?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['formated_time']; ?>
<script type="text/javascript">/* <![CDATA[ */ ap(<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
<?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['locked'] == 1): ?>,1<?php endif; ?>); /* ]]> */</script><?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] == 0): ?> <a href="index.php?mode=thread&amp;id=<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
" title="<?php echo $smarty->_config[0]['vars']['open_whole_thread']; ?>
"><img src="templates/<?php echo $smarty->_tpl_vars['settings']['template']; ?>
/images/complete_thread.png" title="<?php echo $smarty->_config[0]['vars']['open_whole_thread']; ?>
" alt="[*]" width="11" height="11" /></a><?php endif; ?><?php if ($smarty->_tpl_vars['admin'] || $smarty->_tpl_vars['mod']): ?> <a id="marklink_<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
" href="index.php?mode=posting&amp;mark=<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
" title="<?php echo $smarty->_config[0]['vars']['mark_linktitle']; ?>
" onclick="mk(<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
); return false" onfocus="this.blur()"><?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['marked'] == 0): ?><img id="markimg_<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
" src="templates/<?php echo $smarty->_tpl_vars['settings']['template']; ?>
/images/unmarked.png" title="<?php echo $smarty->_config[0]['vars']['mark_linktitle']; ?>
" alt="[○]" width="11" height="11" /><?php else: ?><img id="markimg_<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
" src="templates/<?php echo $smarty->_tpl_vars['settings']['template']; ?>
/images/marked.png" title="<?php echo $smarty->_config[0]['vars']['unmark_linktitle']; ?>
" alt="[●]" width="11" height="11" title="<?php echo $smarty->_config[0]['vars']['unmark_linktitle']; ?>
" /><?php endif; ?></a> <a href="index.php?mode=posting&amp;delete_posting=<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['id']; ?>
&amp;back=index" title="<?php echo $smarty->_config[0]['vars']['delete_posting_title']; ?>
" onclick="return dl(this)"><img src="templates/<?php echo $smarty->_tpl_vars['template']; ?>
/images/delete_small_2.png" title="<?php echo $smarty->_config[0]['vars']['delete_posting_title']; ?>
" alt="[x]" width="9" height="9" /></a><?php endif; ?>
<?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] == 0 && $smarty->_tpl_vars['fold_threads'] == 1): ?> <span class="small" title="<?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['replies'] == 0): ?><?php echo $smarty->_config[0]['vars']['no_replies']; ?>
<?php elseif ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['replies'] == 1): ?><?php echo $smarty->_config[0]['vars']['one_reply']; ?>
<?php else: ?><?php echo ((is_array($_tmp=$smarty->_config[0]['vars']['several_replies'])) ? $smarty->_run_mod_handler('replace', true, $_tmp, "[replies]", $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['replies']) : smarty_modifier_replace($_tmp, "[replies]", $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['replies'])); ?>
<?php endif; ?>">(<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['replies']; ?>
)</span><?php endif; ?><?php if ($smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['category_name'] && $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['pid'] == 0 && $smarty->_tpl_vars['category'] == 0): ?> <a href="index.php?mode=index&amp;category=<?php echo $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['category']; ?>
" title="<?php echo ((is_array($_tmp=((is_array($_tmp=$smarty->_config[0]['vars']['change_category_link'])) ? $smarty->_run_mod_handler('replace', true, $_tmp, "[category]", $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['category_name']) : smarty_modifier_replace($_tmp, "[category]", $smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['category_name'])))) ? $smarty->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"><span class="category">(<?php echo ((is_array($_tmp=$smarty->_tpl_vars['data'][$smarty->_tpl_vars['element']]['category_name'])) ? $smarty->_run_mod_handler('replace', true, $_tmp, ' ', "&nbsp;") : smarty_modifier_replace($_tmp, ' ', "&nbsp;")); ?>
)</span></a><?php endif; ?><?php endif; ?><?php endforeach; endif; unset($_from); ?><?php  $smarty->_tpl_vars = $_fun_tpl_vars; }} smarty_fun_tree($this, array('list'=>$this->_tpl_vars['tree'],'level'=>0));  ?>
<?php else: ?><p><?php if ($this->_tpl_vars['category'] != 0): ?><?php echo $this->_config[0]['vars']['no_messages_in_category']; ?>
<?php else: ?><?php echo $this->_config[0]['vars']['no_messages']; ?>
<?php endif; ?></p><?php endif; ?>

<?php if ($this->_tpl_vars['browse_array']): ?><p class="pagebrowse"><?php if ($this->_tpl_vars['page'] > 1): ?><a href="index.php?mode=<?php echo $this->_tpl_vars['mode']; ?>
&amp;page=<?php echo $this->_tpl_vars['page']-1; ?>
<?php if ($this->_tpl_vars['category']): ?>&amp;category=<?php echo $this->_tpl_vars['category']; ?>
<?php endif; ?>"><?php echo $this->_config[0]['vars']['previous_page_link']; ?>
</a><?php endif; ?><?php if ($this->_tpl_vars['page'] < $this->_tpl_vars['page_count']): ?><?php if ($this->_tpl_vars['page'] > 1 && $this->_tpl_vars['page'] < $this->_tpl_vars['page_count']): ?> - <?php endif; ?><a href="index.php?mode=<?php echo $this->_tpl_vars['mode']; ?>
&amp;page=<?php echo $this->_tpl_vars['page']+1; ?>
<?php if ($this->_tpl_vars['category']): ?>&amp;category=<?php echo $this->_tpl_vars['category']; ?>
<?php endif; ?>"><?php echo $this->_config[0]['vars']['next_page_link']; ?>
</a><?php endif; ?></p><?php endif; ?>