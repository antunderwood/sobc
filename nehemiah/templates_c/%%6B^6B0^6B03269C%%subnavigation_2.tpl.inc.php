<?php /* Smarty version 2.6.22, created on 2009-03-03 00:22:42
         compiled from default/subtemplates/subnavigation_2.tpl.inc */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'default/subtemplates/subnavigation_2.tpl.inc', 10, false),)), $this); ?>
<?php if ($this->_tpl_vars['mode'] == 'index'): ?>
<?php if ($this->_tpl_vars['user']): ?><a href="index.php?update=1&amp;category=<?php echo $this->_tpl_vars['category']; ?>
"><img class="reload" src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/plain.png" alt="[&loz;]" title="<?php echo $this->_config[0]['vars']['reload_linktitle']; ?>
" width="11" height="11" /></a><?php endif; ?>
<?php if ($this->_tpl_vars['thread_order'] == 0): ?> &nbsp;<span class="small"><a href="index.php?mode=index&amp;thread_order=1" title="<?php echo $this->_config[0]['vars']['order_link_title_1']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/order.png" alt="" width="12" height="9" /><?php echo $this->_config[0]['vars']['order_link']; ?>
</a></span><?php else: ?> &#160;<span class="small"><a href="index.php?mode=index&amp;thread_order=0" title="<?php echo $this->_config[0]['vars']['order_link_title_2']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/order.png" alt="" width="12" height="9" /><?php echo $this->_config[0]['vars']['order_link']; ?>
</a></span><?php endif; ?>
<?php if ($this->_tpl_vars['usersettings']['fold_threads'] == 0): ?> &nbsp;<span class="small"><a href="index.php?fold_threads=true" title="<?php echo $this->_config[0]['vars']['fold_threads_linktitle']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/fold_threads.png" alt="" width="12" height="9" /><?php echo $this->_config[0]['vars']['fold_threads']; ?>
</a></span><?php else: ?> &#160;<span class="small"><a href="index.php?fold_threads=true" title="<?php echo $this->_config[0]['vars']['expand_threads_linktitle']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/fold_threads.png" alt="" width="12" height="9" /><?php echo $this->_config[0]['vars']['expand_threads']; ?>
</a></span><?php endif; ?>
<?php if ($this->_tpl_vars['usersettings']['user_view'] == 0): ?> &nbsp;<span class="small"><a href="index.php?toggle_view=true" title="<?php echo $this->_config[0]['vars']['table_view_linktitle']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/table_view.png" alt="" width="12" height="9" /><?php echo $this->_config[0]['vars']['table_view']; ?>
</a></span><?php else: ?> &#160;<span class="small"><a href="index.php?toggle_view=true" title="<?php echo $this->_config[0]['vars']['thread_view_linktitle']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/thread_view.png" alt="" width="12" height="9" /><?php echo $this->_config[0]['vars']['thread_view']; ?>
</a></span><?php endif; ?>
<?php elseif ($this->_tpl_vars['mode'] == 'entry'): ?>
<span class="small"><a href="index.php?mode=thread&amp;id=<?php echo $this->_tpl_vars['tid']; ?>
#p<?php echo $this->_tpl_vars['id']; ?>
" title="<?php echo $this->_config[0]['vars']['open_in_thread_linktitle']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/open_thread.png" alt="" width="13" height="8" /><?php echo $this->_config[0]['vars']['open_in_thread_link']; ?>
</a></span>
<?php elseif ($this->_tpl_vars['mode'] == 'thread'): ?>
<?php if ($this->_tpl_vars['usersettings']['thread_display'] == 0): ?><span class="small"><a href="index.php?mode=thread&amp;id=<?php echo $this->_tpl_vars['id']; ?>
&amp;toggle_thread_display=true" title="<?php echo $this->_config[0]['vars']['thread_linear_linktitle']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/thread_linear.png" alt="" width="12" height="8" /><?php echo $this->_config[0]['vars']['thread_linear']; ?>
</a></span><?php else: ?><span class="small"><a href="index.php?mode=thread&amp;id=<?php echo $this->_tpl_vars['id']; ?>
&amp;toggle_thread_display=true" title="<?php echo $this->_config[0]['vars']['thread_hierarchical_linktitle']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/thread_hierarchical.png" alt="" width="12" height="8" /><?php echo $this->_config[0]['vars']['thread_hierarchical']; ?>
</a></span><?php endif; ?>
<script type="text/javascript">/* <![CDATA[ */document.write('&nbsp; <span class="small"><a href="#" onclick="hide_all_postings(\'templates/<?php echo $this->_tpl_vars['template']; ?>
/images/show_posting.png\'); return false" onfocus="this.blur()" title="<?php echo ((is_array($_tmp=$this->_config[0]['vars']['hide_all_messages_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/collapse_messages.png" alt="" width="12" height="9" /><?php echo ((is_array($_tmp=$this->_config[0]['vars']['hide_all_messages'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
</a> &nbsp;<a href="#" onclick="show_all_postings(\'templates/<?php echo $this->_tpl_vars['template']; ?>
/images/hide_posting.png\'); return false" onfocus="this.blur()" title="<?php echo ((is_array($_tmp=$this->_config[0]['vars']['show_all_messages_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/expand_messages.png" alt="" width="12" height="9" /><?php echo ((is_array($_tmp=$this->_config[0]['vars']['show_all_messages'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
</a></span>');/* ]]> */</script>
<?php endif; ?>
<?php if ($this->_tpl_vars['categories'] && $this->_tpl_vars['mode'] == 'index'): ?>
&nbsp;<form action="index.php" method="get" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
"><div class="inline">
<input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['mode']; ?>
" />
<?php if ($this->_tpl_vars['category']): ?><input type="hidden" name="category" value="<?php echo $this->_tpl_vars['category']; ?>
" /><?php endif; ?>
<select class="kat" size="1" name="category" onchange="this.form.submit();" title="<?php echo $this->_config[0]['vars']['category_title']; ?>
">
<option value="0"<?php if ($this->_tpl_vars['category'] == 0): ?> selected="selected"<?php endif; ?>><?php echo $this->_config[0]['vars']['all_categories']; ?>
</option>
<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
<?php if ($this->_tpl_vars['key'] != 0): ?><option value="<?php echo $this->_tpl_vars['key']; ?>
"<?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['category']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['val']; ?>
</option><?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</select><noscript><div class="inline"><input class="kat" type="submit" value="&raquo;" title="<?php echo $this->_config[0]['vars']['go']; ?>
" /></div></noscript></div></form><?php endif; ?>
<?php if ($this->_tpl_vars['browse_array']): ?>
<?php if ($this->_tpl_vars['item_count'] > $this->_tpl_vars['items_per_page']): ?>&nbsp; <?php if ($this->_tpl_vars['page'] > 1): ?><a href="index.php?mode=<?php echo $this->_tpl_vars['mode']; ?>
&amp;page=<?php echo $this->_tpl_vars['page']-1; ?>
<?php if ($this->_tpl_vars['category']): ?>&amp;category=<?php echo $this->_tpl_vars['category']; ?>
<?php endif; ?>"><img class="previous" src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/plain.png" alt="[&laquo;]" title="<?php echo $this->_config[0]['vars']['previous_page_link_title']; ?>
" width="6" height="11" /></a><?php endif; ?>
<form action="index.php" method="get"><div class="inline">
<input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['mode']; ?>
" />
<?php if ($this->_tpl_vars['order']): ?><input type="hidden" name="order" value="<?php echo $this->_tpl_vars['order']; ?>
" /><?php endif; ?>
<?php if ($this->_tpl_vars['category']): ?><input type="hidden" name="category" value="<?php echo $this->_tpl_vars['category']; ?>
" /><?php endif; ?>
<select class="kat" size="1" name="page" onchange="this.form.submit();" title="<?php echo $this->_config[0]['vars']['page_title']; ?>
">
<?php unset($this->_sections['x']);
$this->_sections['x']['name'] = 'x';
$this->_sections['x']['loop'] = is_array($_loop=$this->_tpl_vars['browse_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['x']['show'] = true;
$this->_sections['x']['max'] = $this->_sections['x']['loop'];
$this->_sections['x']['step'] = 1;
$this->_sections['x']['start'] = $this->_sections['x']['step'] > 0 ? 0 : $this->_sections['x']['loop']-1;
if ($this->_sections['x']['show']) {
    $this->_sections['x']['total'] = $this->_sections['x']['loop'];
    if ($this->_sections['x']['total'] == 0)
        $this->_sections['x']['show'] = false;
} else
    $this->_sections['x']['total'] = 0;
if ($this->_sections['x']['show']):

            for ($this->_sections['x']['index'] = $this->_sections['x']['start'], $this->_sections['x']['iteration'] = 1;
                 $this->_sections['x']['iteration'] <= $this->_sections['x']['total'];
                 $this->_sections['x']['index'] += $this->_sections['x']['step'], $this->_sections['x']['iteration']++):
$this->_sections['x']['rownum'] = $this->_sections['x']['iteration'];
$this->_sections['x']['index_prev'] = $this->_sections['x']['index'] - $this->_sections['x']['step'];
$this->_sections['x']['index_next'] = $this->_sections['x']['index'] + $this->_sections['x']['step'];
$this->_sections['x']['first']      = ($this->_sections['x']['iteration'] == 1);
$this->_sections['x']['last']       = ($this->_sections['x']['iteration'] == $this->_sections['x']['total']);
?>
<?php if ($this->_tpl_vars['browse_array'][$this->_sections['x']['index']] != 0): ?><option value="<?php echo $this->_tpl_vars['browse_array'][$this->_sections['x']['index']]; ?>
"<?php if ($this->_tpl_vars['browse_array'][$this->_sections['x']['index']] == $this->_tpl_vars['page']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['browse_array'][$this->_sections['x']['index']]; ?>
</option><?php endif; ?>
<?php endfor; endif; ?>
</select><noscript><div class="inline"><input class="kat" type="submit" value="&raquo;" title="<?php echo $this->_config[0]['vars']['go']; ?>
" /></div></noscript>
</div></form>
<?php if ($this->_tpl_vars['page'] < $this->_tpl_vars['page_count']): ?><a href="index.php?mode=<?php echo $this->_tpl_vars['mode']; ?>
&amp;page=<?php echo $this->_tpl_vars['page']+1; ?>
<?php if ($this->_tpl_vars['category']): ?>&amp;category=<?php echo $this->_tpl_vars['category']; ?>
<?php endif; ?>"><img class="next" src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/plain.png" alt="[&raquo;]" title="<?php echo $this->_config[0]['vars']['next_page_link_title']; ?>
" width="6" height="11" /></a><?php endif; ?>
<?php endif; ?>
<?php endif; ?>