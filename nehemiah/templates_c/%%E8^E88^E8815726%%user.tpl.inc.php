<?php /* Smarty version 2.6.22, created on 2009-03-03 00:23:07
         compiled from default/subtemplates/user.tpl.inc */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'default/subtemplates/user.tpl.inc', 1, false),array('function', 'cycle', 'default/subtemplates/user.tpl.inc', 45, false),array('modifier', 'replace', 'default/subtemplates/user.tpl.inc', 47, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['settings']['language_file'],'section' => 'user'), $this);?>

<div class="usernav">
<div class="usersearch">
<label for="search_user"><?php echo $this->_config[0]['vars']['search_user']; ?>
</label><form action="index.php" method="get" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div style="display:inline;">
<input type="hidden" name="mode" value="user" />
<input id="search_user" type="text" name="search_user" value="<?php if ($this->_tpl_vars['search_user']): ?><?php echo $this->_tpl_vars['search_user']; ?>
<?php endif; ?>" size="25" />&nbsp;<input type="image" src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/submit.png" alt="[&raquo;]" />
</div>
</form>
</div>
<div class="userbrowse">
<?php if ($this->_tpl_vars['user_page_browse'] && $this->_tpl_vars['user_page_browse']['total_items'] > $this->_tpl_vars['user_page_browse']['items_per_page']): ?>
<?php if ($this->_tpl_vars['user_page_browse']['previous_page'] != 0): ?>
<a href="index.php?mode=<?php echo $this->_tpl_vars['mode']; ?>
<?php if ($this->_tpl_vars['action']): ?>&amp;action=<?php echo $this->_tpl_vars['action']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['method'] && $this->_tpl_vars['method'] != 'fulltext'): ?>&amp;method=<?php echo $this->_tpl_vars['method']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['id']): ?>&amp;id=<?php echo $this->_tpl_vars['id']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['user_page_browse']['previous_page'] > 1): ?>&amp;page=<?php echo $this->_tpl_vars['user_page_browse']['previous_page']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['p_category'] && $this->_tpl_vars['p_category'] > 0): ?>&amp;p_category=<?php echo $this->_tpl_vars['p_category']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['order']): ?>&amp;order=<?php echo $this->_tpl_vars['order']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['descasc']): ?>&amp;descasc=<?php echo $this->_tpl_vars['descasc']; ?>
<?php endif; ?>">&laquo;</a>
<?php endif; ?>
<?php unset($this->_sections['x']);
$this->_sections['x']['name'] = 'x';
$this->_sections['x']['loop'] = is_array($_loop=$this->_tpl_vars['user_page_browse']['browse_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<?php if ($this->_tpl_vars['user_page_browse']['browse_array'][$this->_sections['x']['index']] == $this->_tpl_vars['user_page_browse']['page']): ?>
<span style="color:red;"><?php echo $this->_tpl_vars['user_page_browse']['browse_array'][$this->_sections['x']['index']]; ?>
</span>
<?php elseif ($this->_tpl_vars['user_page_browse']['browse_array'][$this->_sections['x']['index']] == 0): ?>
..
<?php else: ?>
<a href="index.php?mode=<?php echo $this->_tpl_vars['mode']; ?>
<?php if ($this->_tpl_vars['action']): ?>&amp;action=<?php echo $this->_tpl_vars['action']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['method'] && $this->_tpl_vars['method'] != 'fulltext'): ?>&amp;method=<?php echo $this->_tpl_vars['method']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['id']): ?>&amp;id=<?php echo $this->_tpl_vars['id']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['user_page_browse']['browse_array'][$this->_sections['x']['index']] > 1): ?>&amp;page=<?php echo $this->_tpl_vars['user_page_browse']['browse_array'][$this->_sections['x']['index']]; ?>
<?php endif; ?><?php if ($this->_tpl_vars['p_category'] && $this->_tpl_vars['p_category'] > 0): ?>&amp;p_category=<?php echo $this->_tpl_vars['p_category']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['order']): ?>&amp;order=<?php echo $this->_tpl_vars['order']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['descasc']): ?>&amp;descasc=<?php echo $this->_tpl_vars['descasc']; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['user_page_browse']['browse_array'][$this->_sections['x']['index']]; ?>
</a>
<?php endif; ?>
<?php endfor; endif; ?>
<?php if ($this->_tpl_vars['user_page_browse']['next_page'] != 0): ?>
<a href="index.php?mode=<?php echo $this->_tpl_vars['mode']; ?>
<?php if ($this->_tpl_vars['action']): ?>&amp;action=<?php echo $this->_tpl_vars['action']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['method'] && $this->_tpl_vars['method'] != 'fulltext'): ?>&amp;method=<?php echo $this->_tpl_vars['method']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['id']): ?>&amp;id=<?php echo $this->_tpl_vars['id']; ?>
<?php endif; ?>&amp;page=<?php echo $this->_tpl_vars['user_page_browse']['next_page']; ?>
<?php if ($this->_tpl_vars['p_category'] && $this->_tpl_vars['p_category'] > 0): ?>&amp;p_category=<?php echo $this->_tpl_vars['p_category']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['order']): ?>&amp;order=<?php echo $this->_tpl_vars['order']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['descasc']): ?>&amp;descasc=<?php echo $this->_tpl_vars['descasc']; ?>
<?php endif; ?>">&raquo;</a>
<?php endif; ?>
<?php else: ?>
&nbsp;
<?php endif; ?>
</div>
</div>
<?php if ($this->_tpl_vars['total_users'] > 0): ?>
<table class="normaltab" border="0" cellpadding="5" cellspacing="1">
<tr>
<th><a href="index.php?mode=user<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;order=user_name&amp;descasc=<?php if ($this->_tpl_vars['descasc'] == 'ASC' && $this->_tpl_vars['order'] == 'user_name'): ?>DESC<?php else: ?>ASC<?php endif; ?>&amp;ul=<?php echo $this->_tpl_vars['ul']; ?>
" title="<?php echo $this->_config[0]['vars']['order_linktitle']; ?>
"><?php echo $this->_config[0]['vars']['user_name']; ?>
</a><?php if ($this->_tpl_vars['order'] == 'user_name' && $this->_tpl_vars['descasc'] == 'ASC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/asc.png" alt="[asc]" width="5" height="9" /><?php elseif ($this->_tpl_vars['order'] == 'user_name' && $this->_tpl_vars['descasc'] == 'DESC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/desc.png" alt="[desc]" width="5" height="9" /><?php endif; ?></th>
<th><a href="index.php?mode=user<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;order=user_type&amp;descasc=<?php if ($this->_tpl_vars['descasc'] == 'ASC' && $this->_tpl_vars['order'] == 'user_type'): ?>DESC<?php else: ?>ASC<?php endif; ?>&amp;ul=<?php echo $this->_tpl_vars['ul']; ?>
" title="<?php echo $this->_config[0]['vars']['order_linktitle']; ?>
"><?php echo $this->_config[0]['vars']['user_type']; ?>
</a><?php if ($this->_tpl_vars['order'] == 'user_type' && $this->_tpl_vars['descasc'] == 'ASC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/asc.png" alt="[asc]" width="5" height="9" /><?php elseif ($this->_tpl_vars['order'] == 'user_type' && $this->_tpl_vars['descasc'] == 'DESC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/desc.png" alt="[desc]" width="5" height="9" /><?php endif; ?></th>
<th><?php echo $this->_config[0]['vars']['user_hp']; ?>
</th>
<th><?php echo $this->_config[0]['vars']['user_email']; ?>
</th>
<th><?php echo $this->_config[0]['vars']['user_postings']; ?>
</th>
<?php if ($this->_tpl_vars['settings']['count_users_online'] > 0): ?><th><?php echo $this->_config[0]['vars']['user_online']; ?>
</th><?php endif; ?>
<?php if ($this->_tpl_vars['mod'] || $this->_tpl_vars['admin']): ?><th><a href="index.php?mode=user<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;order=user_lock&amp;descasc=<?php if ($this->_tpl_vars['descasc'] == 'ASC' && $this->_tpl_vars['order'] == 'user_lock'): ?>DESC<?php else: ?>ASC<?php endif; ?>&amp;ul=<?php echo $this->_tpl_vars['ul']; ?>
" title="<?php echo $this->_config[0]['vars']['order_linktitle']; ?>
"><?php echo $this->_config[0]['vars']['user_blockage']; ?>
</a><?php if ($this->_tpl_vars['order'] == 'user_lock' && $this->_tpl_vars['descasc'] == 'ASC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/asc.png" alt="[asc]" width="5" height="9" /><?php elseif ($this->_tpl_vars['order'] == 'user_lock' && $this->_tpl_vars['descasc'] == 'DESC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/desc.png" alt="[desc]" width="5" height="9" /><?php endif; ?></th><?php endif; ?>
</tr>
<?php $_from = $this->_tpl_vars['userdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
<?php echo smarty_function_cycle(array('values' => "a,b",'assign' => 'c'), $this);?>

<tr>
<td class="<?php echo $this->_tpl_vars['c']; ?>
"><a href="index.php?mode=user&amp;show_user=<?php echo $this->_tpl_vars['row']['user_id']; ?>
" title="<?php echo ((is_array($_tmp=$this->_config[0]['vars']['show_userdata_linktitle'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[user]", $this->_tpl_vars['row']['user_name']) : smarty_modifier_replace($_tmp, "[user]", $this->_tpl_vars['row']['user_name'])); ?>
"><strong><?php echo $this->_tpl_vars['row']['user_name']; ?>
</strong></a></td>
<td class="<?php echo $this->_tpl_vars['c']; ?>
"><span class="small"><?php if ($this->_tpl_vars['row']['user_type'] == 2): ?><?php echo $this->_config[0]['vars']['admin']; ?>
<?php elseif ($this->_tpl_vars['row']['user_type'] == 1): ?><?php echo $this->_config[0]['vars']['mod']; ?>
<?php else: ?><?php echo $this->_config[0]['vars']['user']; ?>
<?php endif; ?></span></td>
<td class="<?php echo $this->_tpl_vars['c']; ?>
"><span class="small"><?php if ($this->_tpl_vars['row']['user_hp'] != ''): ?><a href="<?php echo $this->_tpl_vars['row']['user_hp']; ?>
" title="<?php echo $this->_tpl_vars['row']['user_hp']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/homepage.png" alt="<?php echo $this->_config[0]['vars']['homepage']; ?>
" width="13" height="13" /></a><?php else: ?>&nbsp;<?php endif; ?></span></td>
<td class="<?php echo $this->_tpl_vars['c']; ?>
"><span class="small"><?php if ($this->_tpl_vars['row']['user_email']): ?><a href="index.php?mode=contact&amp;user_id=<?php echo $this->_tpl_vars['row']['user_id']; ?>
" title="<?php echo ((is_array($_tmp=$this->_config[0]['vars']['mailto_user'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[user]", $this->_tpl_vars['row']['user_name']) : smarty_modifier_replace($_tmp, "[user]", $this->_tpl_vars['row']['user_name'])); ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/email.png" alt="<?php echo $this->_config[0]['vars']['email']; ?>
" width="13" height="10" /></a><?php else: ?>&nbsp;<?php endif; ?></span></td>
<td class="<?php echo $this->_tpl_vars['c']; ?>
"><span class="small"><?php if ($this->_tpl_vars['row']['postings'] > 0): ?><a href="index.php?mode=user&amp;action=show_posts&amp;id=<?php echo $this->_tpl_vars['row']['user_id']; ?>
"><?php echo $this->_tpl_vars['row']['postings']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['row']['postings']; ?>
<?php endif; ?></span></td>
<?php if ($this->_tpl_vars['settings']['count_users_online'] > 0): ?><td class="<?php echo $this->_tpl_vars['c']; ?>
"><span class="small"><?php if ($this->_tpl_vars['row']['online']): ?><span style="color:red;"><?php echo $this->_config[0]['vars']['online']; ?>
</span><?php else: ?>&nbsp;<?php endif; ?></span></td><?php endif; ?>
<?php if ($this->_tpl_vars['mod'] || $this->_tpl_vars['admin']): ?><td class="<?php echo $this->_tpl_vars['c']; ?>
"><span class="small"><?php if ($this->_tpl_vars['row']['user_type'] > 0): ?><?php if ($this->_tpl_vars['row']['user_lock'] == 0): ?><?php echo $this->_config[0]['vars']['unlocked']; ?>
<?php else: ?><?php echo $this->_config[0]['vars']['locked']; ?>
<?php endif; ?><?php elseif ($this->_tpl_vars['row']['user_lock'] == 0): ?><a href="index.php?mode=user<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;user_lock=<?php echo $this->_tpl_vars['row']['user_id']; ?>
&amp;page=<?php echo $this->_tpl_vars['page']; ?>
&amp;order=<?php echo $this->_tpl_vars['order']; ?>
&amp;descasc=<?php echo $this->_tpl_vars['descasc']; ?>
" title="<?php echo $this->_config[0]['vars']['lock_title']; ?>
"><?php echo $this->_config[0]['vars']['unlocked']; ?>
</a><?php else: ?><a style="color: red;" href="index.php?mode=user<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;user_lock=<?php echo $this->_tpl_vars['row']['user_id']; ?>
&amp;page=<?php echo $this->_tpl_vars['page']; ?>
&amp;order=<?php echo $this->_tpl_vars['order']; ?>
&amp;descasc=<?php echo $this->_tpl_vars['descasc']; ?>
" title="<?php echo $this->_config[0]['vars']['unlock_title']; ?>
"><?php echo $this->_config[0]['vars']['locked']; ?>
</a><?php endif; ?></span></td><?php endif; ?>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<div class="usernav-bottom">
<?php if ($this->_tpl_vars['user_page_browse'] && $this->_tpl_vars['user_page_browse']['total_items'] > $this->_tpl_vars['user_page_browse']['items_per_page']): ?>
<?php if ($this->_tpl_vars['user_page_browse']['previous_page'] != 0): ?>
<a href="index.php?mode=<?php echo $this->_tpl_vars['mode']; ?>
<?php if ($this->_tpl_vars['action']): ?>&amp;action=<?php echo $this->_tpl_vars['action']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['method'] && $this->_tpl_vars['method'] != 'fulltext'): ?>&amp;method=<?php echo $this->_tpl_vars['method']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['id']): ?>&amp;id=<?php echo $this->_tpl_vars['id']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['user_page_browse']['previous_page'] > 1): ?>&amp;page=<?php echo $this->_tpl_vars['user_page_browse']['previous_page']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['p_category'] && $this->_tpl_vars['p_category'] > 0): ?>&amp;p_category=<?php echo $this->_tpl_vars['p_category']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['order']): ?>&amp;order=<?php echo $this->_tpl_vars['order']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['descasc']): ?>&amp;descasc=<?php echo $this->_tpl_vars['descasc']; ?>
<?php endif; ?>">&laquo;</a>
<?php endif; ?>
<?php unset($this->_sections['x']);
$this->_sections['x']['name'] = 'x';
$this->_sections['x']['loop'] = is_array($_loop=$this->_tpl_vars['user_page_browse']['browse_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<?php if ($this->_tpl_vars['user_page_browse']['browse_array'][$this->_sections['x']['index']] == $this->_tpl_vars['user_page_browse']['page']): ?>
<span style="color:red;"><?php echo $this->_tpl_vars['user_page_browse']['browse_array'][$this->_sections['x']['index']]; ?>
</span>
<?php elseif ($this->_tpl_vars['user_page_browse']['browse_array'][$this->_sections['x']['index']] == 0): ?>
..
<?php else: ?>
<a href="index.php?mode=<?php echo $this->_tpl_vars['mode']; ?>
<?php if ($this->_tpl_vars['action']): ?>&amp;action=<?php echo $this->_tpl_vars['action']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['method'] && $this->_tpl_vars['method'] != 'fulltext'): ?>&amp;method=<?php echo $this->_tpl_vars['method']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['id']): ?>&amp;id=<?php echo $this->_tpl_vars['id']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['user_page_browse']['browse_array'][$this->_sections['x']['index']] > 1): ?>&amp;page=<?php echo $this->_tpl_vars['user_page_browse']['browse_array'][$this->_sections['x']['index']]; ?>
<?php endif; ?><?php if ($this->_tpl_vars['p_category'] && $this->_tpl_vars['p_category'] > 0): ?>&amp;p_category=<?php echo $this->_tpl_vars['p_category']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['order']): ?>&amp;order=<?php echo $this->_tpl_vars['order']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['descasc']): ?>&amp;descasc=<?php echo $this->_tpl_vars['descasc']; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['user_page_browse']['browse_array'][$this->_sections['x']['index']]; ?>
</a>
<?php endif; ?>
<?php endfor; endif; ?>
<?php if ($this->_tpl_vars['user_page_browse']['next_page'] != 0): ?>
<a href="index.php?mode=<?php echo $this->_tpl_vars['mode']; ?>
<?php if ($this->_tpl_vars['action']): ?>&amp;action=<?php echo $this->_tpl_vars['action']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['method'] && $this->_tpl_vars['method'] != 'fulltext'): ?>&amp;method=<?php echo $this->_tpl_vars['method']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['id']): ?>&amp;id=<?php echo $this->_tpl_vars['id']; ?>
<?php endif; ?>&amp;page=<?php echo $this->_tpl_vars['user_page_browse']['next_page']; ?>
<?php if ($this->_tpl_vars['p_category'] && $this->_tpl_vars['p_category'] > 0): ?>&amp;p_category=<?php echo $this->_tpl_vars['p_category']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['order']): ?>&amp;order=<?php echo $this->_tpl_vars['order']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['descasc']): ?>&amp;descasc=<?php echo $this->_tpl_vars['descasc']; ?>
<?php endif; ?>">&raquo;</a>
<?php endif; ?>
<?php endif; ?>
</div>
<?php else: ?>
<p><em><?php echo $this->_config[0]['vars']['no_users']; ?>
</em></p>
<?php endif; ?>