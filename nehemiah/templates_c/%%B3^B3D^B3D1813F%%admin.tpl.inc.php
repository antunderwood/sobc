<?php /* Smarty version 2.6.22, created on 2009-03-03 00:23:10
         compiled from default/subtemplates/admin.tpl.inc */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'default/subtemplates/admin.tpl.inc', 1, false),array('function', 'html_options', 'default/subtemplates/admin.tpl.inc', 44, false),array('function', 'cycle', 'default/subtemplates/admin.tpl.inc', 247, false),array('modifier', 'escape', 'default/subtemplates/admin.tpl.inc', 9, false),array('modifier', 'replace', 'default/subtemplates/admin.tpl.inc', 82, false),array('modifier', 'date_format', 'default/subtemplates/admin.tpl.inc', 384, false),array('modifier', 'default', 'default/subtemplates/admin.tpl.inc', 545, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['settings']['language_file'],'section' => 'admin'), $this);?>

<?php if ($this->_tpl_vars['action'] == 'settings'): ?>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<table class="normaltab" border="0" cellpadding="5" cellspacing="1">
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['forum_name']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['forum_name_desc']; ?>
</span></td>
<td class="d"><input type="text" name="forum_name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['forum_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="40" /></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['forum_description']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['forum_description_desc']; ?>
</span></td>
<td class="d"><input type="text" name="forum_description" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['forum_description'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="40" /></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['forum_address']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['forum_address_desc']; ?>
</span></td>
<td class="d"><input type="text" name="forum_address" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['forum_address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="40" /></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['forum_email']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['forum_email_desc']; ?>
</span></td>
<td class="d"><input type="text" name="forum_email" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['forum_email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="40" /></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['home_link']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['home_link_desc']; ?>
</span></td>
<td class="d"><input type="text" name="home_linkaddress" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['home_linkaddress'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="40" /></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['home_link_name']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['home_link_name_desc']; ?>
</span></td>
<td class="d"><input type="text" name="home_linkname" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['home_linkname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="40" /></td>
</tr>
<?php if ($this->_tpl_vars['more_than_one_language_available']): ?>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['language_file']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['language_file_desc']; ?>
</span></td>
<td class="d"><select name="language_file" size="1">
<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['language_file']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['nr']['show'] = true;
$this->_sections['nr']['max'] = $this->_sections['nr']['loop'];
$this->_sections['nr']['step'] = 1;
$this->_sections['nr']['start'] = $this->_sections['nr']['step'] > 0 ? 0 : $this->_sections['nr']['loop']-1;
if ($this->_sections['nr']['show']) {
    $this->_sections['nr']['total'] = $this->_sections['nr']['loop'];
    if ($this->_sections['nr']['total'] == 0)
        $this->_sections['nr']['show'] = false;
} else
    $this->_sections['nr']['total'] = 0;
if ($this->_sections['nr']['show']):

            for ($this->_sections['nr']['index'] = $this->_sections['nr']['start'], $this->_sections['nr']['iteration'] = 1;
                 $this->_sections['nr']['iteration'] <= $this->_sections['nr']['total'];
                 $this->_sections['nr']['index'] += $this->_sections['nr']['step'], $this->_sections['nr']['iteration']++):
$this->_sections['nr']['rownum'] = $this->_sections['nr']['iteration'];
$this->_sections['nr']['index_prev'] = $this->_sections['nr']['index'] - $this->_sections['nr']['step'];
$this->_sections['nr']['index_next'] = $this->_sections['nr']['index'] + $this->_sections['nr']['step'];
$this->_sections['nr']['first']      = ($this->_sections['nr']['iteration'] == 1);
$this->_sections['nr']['last']       = ($this->_sections['nr']['iteration'] == $this->_sections['nr']['total']);
?>
<option value="<?php echo $this->_tpl_vars['language_file'][$this->_sections['nr']['index']]['file']; ?>
"<?php if ($this->_tpl_vars['language_file'][$this->_sections['nr']['index']]['file'] == $this->_tpl_vars['settings']['language_file']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['language_file'][$this->_sections['nr']['index']]['name']; ?>
</option>
<?php endfor; endif; ?>
</select></td>
</tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['more_than_one_template_available']): ?>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['template']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['template_desc']; ?>
</span></td>
<td class="d"><select name="template" size="1"><?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['templates'],'selected' => $this->_tpl_vars['settings']['template'],'output' => $this->_tpl_vars['templates']), $this);?>
</select></td>
</tr>
<?php endif; ?>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['accession']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['accession_desc']; ?>
</span></td>
<td class="d"><input id="access_for_all" type="radio" name="access_for_users_only" value="0"<?php if ($this->_tpl_vars['settings']['access_for_users_only'] == 0): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('access_for_all_label','access_for_users_only_label'))" /><label id="access_for_all_label" for="access_for_all" class="<?php if ($this->_tpl_vars['settings']['access_for_users_only'] == 0): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['all_users']; ?>
</label><br />
<input id="access_for_users_only" type="radio" name="access_for_users_only" value="1"<?php if ($this->_tpl_vars['settings']['access_for_users_only'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('access_for_users_only_label','access_for_all_label'))" /><label id="access_for_users_only_label" for="access_for_users_only" class="<?php if ($this->_tpl_vars['settings']['access_for_users_only'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['only_registered_users']; ?>
</label></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['post_permission']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['post_permission_desc']; ?>
</span></td>
<td class="d"><input id="entries_by_all" type="radio" name="entries_by_users_only" value="0"<?php if ($this->_tpl_vars['settings']['entries_by_users_only'] == 0): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('entries_by_all_label','entries_by_users_label'))" /><label id="entries_by_all_label" for="entries_by_all" class="<?php if ($this->_tpl_vars['settings']['entries_by_users_only'] == 0): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['all_users']; ?>
</label><br />
<input id="entries_by_users" type="radio" name="entries_by_users_only" value="1"<?php if ($this->_tpl_vars['settings']['entries_by_users_only'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('entries_by_users_label','entries_by_all_label'))" /><label id="entries_by_users_label" for="entries_by_users" class="<?php if ($this->_tpl_vars['settings']['entries_by_users_only'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['only_registered_users']; ?>
</label></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['register_permission']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['register_permission_desc']; ?>
</span></td>
<td class="d"><input id="register_mode_0" type="radio" name="register_mode" value="0"<?php if ($this->_tpl_vars['settings']['register_mode'] == 0): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('register_mode_0_label','register_mode_1_label','register_mode_2_label'))" /><label id="register_mode_0_label" for="register_mode_0" class="<?php if ($this->_tpl_vars['settings']['register_mode'] == 0): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['register_self']; ?>
</label><br />
<input id="register_mode_1" type="radio" name="register_mode" value="1"<?php if ($this->_tpl_vars['settings']['register_mode'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('register_mode_1_label','register_mode_0_label','register_mode_2_label'))" /><label id="register_mode_1_label" for="register_mode_1" class="<?php if ($this->_tpl_vars['settings']['register_mode'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['register_self_locked']; ?>
</label><br />
<input id="register_mode_2" type="radio" name="register_mode" value="2"<?php if ($this->_tpl_vars['settings']['register_mode'] == 2): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('register_mode_2_label','register_mode_0_label','register_mode_1_label'))" /><label id="register_mode_2_label" for="register_mode_2" class="<?php if ($this->_tpl_vars['settings']['register_mode'] == 2): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['register_only_admin']; ?>
</label></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['user_area']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['user_area_desc']; ?>
</span></td>
<td class="d"><input id="public" type="radio" name="user_area_public" value="1"<?php if ($this->_tpl_vars['settings']['user_area_public'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('public_label','not_public_label'))" /><label id="public_label" for="public" class="<?php if ($this->_tpl_vars['settings']['user_area_public'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['public_accessible']; ?>
</label><br />
<input id="not_public" type="radio" name="user_area_public" value="0"<?php if ($this->_tpl_vars['settings']['user_area_public'] == 0): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('not_public_label','public_label'))" /><label id="not_public_label" for="not_public" class="<?php if ($this->_tpl_vars['settings']['user_area_public'] == 0): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['accessible_reg_users_only']; ?>
</label></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['latest_postings']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['latest_postings_desc']; ?>
</span></td>
<td class="d"><input type="text" name="latest_postings" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['latest_postings'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="5" /></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['tag_cloud']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['tag_cloud_desc']; ?>
</span></td>
<td class="d"><input id="tag_cloud" type="checkbox" name="tag_cloud" value="1"<?php if ($this->_tpl_vars['settings']['tag_cloud'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('tag_cloud_label'))" /><label id="tag_cloud_label" for="tag_cloud" class="<?php if ($this->_tpl_vars['settings']['tag_cloud'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['enable_tag_cloud']; ?>
</label></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_postings']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['edit_postings_desc']; ?>
</span></td>
<td class="d">
<?php $this->assign('settings_edit_delay', $this->_tpl_vars['settings']['edit_delay']); ?>
<?php $this->assign('input_edit_delay', "<input type=\"text\" name=\"edit_delay\" value=\"".($this->_tpl_vars['settings_edit_delay'])."\" size=\"3\" />"); ?>

<p><input id="show_if_edited" type="checkbox" name="show_if_edited" value="1"<?php if ($this->_tpl_vars['settings']['show_if_edited'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('show_if_edited_label'))" /><label id="show_if_edited_label" for="show_if_edited" class="<?php if ($this->_tpl_vars['settings']['show_if_edited'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo ((is_array($_tmp=$this->_config[0]['vars']['show_if_edited'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[minutes]", $this->_tpl_vars['input_edit_delay']) : smarty_modifier_replace($_tmp, "[minutes]", $this->_tpl_vars['input_edit_delay'])); ?>
</label><br />
<input id="dont_reg_edit_by_admin" type="checkbox" name="dont_reg_edit_by_admin" value="1"<?php if ($this->_tpl_vars['settings']['dont_reg_edit_by_admin'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('dont_reg_edit_by_admin_label'))" /><label id="dont_reg_edit_by_admin_label" for="dont_reg_edit_by_admin" class="<?php if ($this->_tpl_vars['settings']['dont_reg_edit_by_admin'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['dont_show_edit_by_admin']; ?>
</label><br />
<input id="dont_reg_edit_by_mod" type="checkbox" name="dont_reg_edit_by_mod" value="1"<?php if ($this->_tpl_vars['settings']['dont_reg_edit_by_mod'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('dont_reg_edit_by_mod_label'))" /><label id="dont_reg_edit_by_mod_label" for="dont_reg_edit_by_mod" class="<?php if ($this->_tpl_vars['settings']['dont_reg_edit_by_mod'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['dont_show_edit_by_mod']; ?>
</label></p>

<p><em><?php echo $this->_config[0]['vars']['edit_own_postings']; ?>
</em></p>
<p><input id="edit_own_postings_all" type="radio" name="user_edit" value="2"<?php if ($this->_tpl_vars['settings']['user_edit'] == 2): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('edit_own_postings_all_label','edit_own_postings_users_label','edit_own_postings_disabled_label')); set_label_class('user_edit_details','active')" /><label id="edit_own_postings_all_label" for="edit_own_postings_all" class="<?php if ($this->_tpl_vars['settings']['user_edit'] == 2): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['edit_own_postings_all']; ?>
</label><br />
<input id="edit_own_postings_users" type="radio" name="user_edit" value="1"<?php if ($this->_tpl_vars['settings']['user_edit'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('edit_own_postings_users_label','edit_own_postings_all_label','edit_own_postings_disabled_label')); set_label_class('user_edit_details','active')" /><label id="edit_own_postings_users_label" for="edit_own_postings_users" class="<?php if ($this->_tpl_vars['settings']['user_edit'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['edit_own_postings_users']; ?>
</label><br />
<input id="edit_own_postings_disabled" type="radio" name="user_edit" value="0"<?php if ($this->_tpl_vars['settings']['user_edit'] == 0): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('edit_own_postings_disabled_label','edit_own_postings_all_label','edit_own_postings_users_label')); set_label_class('user_edit_details','inactive')" /><label id="edit_own_postings_disabled_label" for="edit_own_postings_disabled" class="<?php if ($this->_tpl_vars['settings']['user_edit'] == 0): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['edit_own_postings_disabled']; ?>
</label></p>

<fieldset id="user_edit_details" class="<?php if ($this->_tpl_vars['settings']['user_edit'] == 0): ?>inactive<?php else: ?>active<?php endif; ?>">
<?php $this->assign('settings_edit_max_time_period', $this->_tpl_vars['settings']['edit_max_time_period']); ?>
<?php $this->assign('input_edit_max_time_period', "<input type=\"text\" id=\"edit_max_time_period\" name=\"edit_max_time_period\" value=\"".($this->_tpl_vars['settings_edit_max_time_period'])."\" size=\"3\" />"); ?>
<p><label id="edit_max_time_period_label" for="edit_max_time_period"><?php echo ((is_array($_tmp=$this->_config[0]['vars']['edit_max_time_period'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[minutes]", $this->_tpl_vars['input_edit_max_time_period']) : smarty_modifier_replace($_tmp, "[minutes]", $this->_tpl_vars['input_edit_max_time_period'])); ?>
</label></p>
<?php $this->assign('settings_edit_min_time_period', $this->_tpl_vars['settings']['edit_min_time_period']); ?>
<?php $this->assign('input_edit_min_time_period', "<input type=\"text\" name=\"edit_min_time_period\" value=\"".($this->_tpl_vars['settings_edit_min_time_period'])."\" size=\"3\" />"); ?>
<p><input id="user_edit_if_no_replies" type="checkbox" name="user_edit_if_no_replies" value="1"<?php if ($this->_tpl_vars['settings']['user_edit_if_no_replies'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('user_edit_if_no_replies_label'))" /><label id="user_edit_if_no_replies_label" for="user_edit_if_no_replies" class="<?php if ($this->_tpl_vars['settings']['user_edit_if_no_replies'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo ((is_array($_tmp=$this->_config[0]['vars']['user_edit_if_no_replies'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[minutes]", $this->_tpl_vars['input_edit_min_time_period']) : smarty_modifier_replace($_tmp, "[minutes]", $this->_tpl_vars['input_edit_min_time_period'])); ?>
</label></p>
</fieldset>

</td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['bbcode']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['bbcode_desc']; ?>
</span></td>
<td class="d"><input id="bbcode" type="checkbox" name="bbcode" value="1"<?php if ($this->_tpl_vars['settings']['bbcode'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('bbcode_label'))" /><label id="bbcode_label" for="bbcode" class="<?php if ($this->_tpl_vars['settings']['bbcode'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['bbcodes_enabled']; ?>
</label><br />
<input id="bbcode_img" type="checkbox" name="bbcode_img" value="1"<?php if ($this->_tpl_vars['settings']['bbcode_img'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('bbcode_img_label'))" /><label id="bbcode_img_label" for="bbcode_img" class="<?php if ($this->_tpl_vars['settings']['bbcode_img'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['bbcodes_img_enabled']; ?>
</label></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['smilies']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['smilies_desc']; ?>
</span></td>
<td class="d"><input id="smilies" type="checkbox" name="smilies" value="1"<?php if ($this->_tpl_vars['settings']['smilies'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('smilies_label'))" /><label id="smilies_label" for="smilies" class="<?php if ($this->_tpl_vars['settings']['smilies'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['smilies_enabled']; ?>
</label></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['enamble_avatars']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['enamble_avatars_desc']; ?>
</span></td>
<td class="d"><p><input id="avatars_profiles_postings" type="radio" name="avatars" value="2"<?php if ($this->_tpl_vars['settings']['avatars'] == 2): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('avatars_profiles_postings_label','avatars_profiles_label','avatars_disabled_label')); set_label_class('max_avatar_size_label','active')" /><label id="avatars_profiles_postings_label" for="avatars_profiles_postings" class="<?php if ($this->_tpl_vars['settings']['avatars'] == 2): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['avatars_profiles_postings']; ?>
</label><br />
<input id="avatars_profiles" type="radio" name="avatars" value="1"<?php if ($this->_tpl_vars['settings']['avatars'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('avatars_profiles_label','avatars_profiles_postings_label','avatars_disabled_label')); set_label_class('max_avatar_size_label','active')" /><label id="avatars_profiles_label" for="avatars_profiles" class="<?php if ($this->_tpl_vars['settings']['avatars'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['avatars_profiles']; ?>
</label><br />
<input id="avatars_disabled" type="radio" name="avatars" value="0"<?php if ($this->_tpl_vars['settings']['avatars'] == 0): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('avatars_disabled_label','avatars_profiles_label','avatars_profiles_postings_label')); set_label_class('max_avatar_size_label','inactive')" /><label id="avatars_disabled_label" for="avatars_disabled" class="<?php if ($this->_tpl_vars['settings']['avatars'] == 0): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['disabled']; ?>
</label></p>


<?php $this->assign('settings_avatar_max_width', $this->_tpl_vars['settings']['avatar_max_width']); ?>
<?php $this->assign('input_avatar_max_width', "<input id=\"avatar_max_width\" type=\"text\" name=\"avatar_max_width\" value=\"".($this->_tpl_vars['settings_avatar_max_width'])."\" size=\"3\" />"); ?>
<?php $this->assign('settings_avatar_max_height', $this->_tpl_vars['settings']['avatar_max_height']); ?>
<?php $this->assign('input_avatar_max_height', "<input type=\"text\" name=\"avatar_max_height\" value=\"".($this->_tpl_vars['settings_avatar_max_height'])."\" size=\"3\" />"); ?>
<?php $this->assign('settings_avatar_max_filesize', $this->_tpl_vars['settings']['avatar_max_filesize']); ?>
<?php $this->assign('input_avatar_max_filesize', "<input type=\"text\" name=\"avatar_max_filesize\" value=\"".($this->_tpl_vars['settings_avatar_max_filesize'])."\" size=\"3\" />"); ?>
<p><label id="max_avatar_size_label" for="avatar_max_width" class="<?php if ($this->_tpl_vars['settings']['avatars'] == 0): ?>inactive<?php else: ?>active<?php endif; ?>"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['max_avatar_size'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[width]", $this->_tpl_vars['input_avatar_max_width']) : smarty_modifier_replace($_tmp, "[width]", $this->_tpl_vars['input_avatar_max_width'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[height]", $this->_tpl_vars['input_avatar_max_height']) : smarty_modifier_replace($_tmp, "[height]", $this->_tpl_vars['input_avatar_max_height'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[filesize]", $this->_tpl_vars['input_avatar_max_filesize']) : smarty_modifier_replace($_tmp, "[filesize]", $this->_tpl_vars['input_avatar_max_filesize'])); ?>
</label></p></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['upload_images']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['upload_images_desc']; ?>
</span></td>
<td class="d"><p><input id="upload_images_all" type="radio" name="upload_images" value="3"<?php if ($this->_tpl_vars['settings']['upload_images'] == 3): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('upload_images_all_label','upload_images_users_label','upload_images_admins_mods_label','upload_images_disabled_label')); set_label_class('max_upload_size_label','active')" /><label id="upload_images_all_label" for="upload_images_all" class="<?php if ($this->_tpl_vars['settings']['upload_images'] == 3): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['upload_enabled_all']; ?>
</label><br />
<input id="upload_images_users" type="radio" name="upload_images" value="2"<?php if ($this->_tpl_vars['settings']['upload_images'] == 2): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('upload_images_users_label','upload_images_all_label','upload_images_admins_mods_label','upload_images_disabled_label')); set_label_class('max_upload_size_label','active')" /><label id="upload_images_users_label" for="upload_images_users" class="<?php if ($this->_tpl_vars['settings']['upload_images'] == 2): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['upload_enabled_users']; ?>
</label><br />
<input id="upload_images_admins_mods" type="radio" name="upload_images" value="1"<?php if ($this->_tpl_vars['settings']['upload_images'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('upload_images_admins_mods_label','upload_images_all_label','upload_images_users_label','upload_images_disabled_label')); set_label_class('max_upload_size_label','active')" /><label id="upload_images_admins_mods_label" for="upload_images_admins_mods" class="<?php if ($this->_tpl_vars['settings']['upload_images'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['upload_enabled_admins_mods']; ?>
</label><br />
<input id="upload_images_disabled" type="radio" name="upload_images" value="0"<?php if ($this->_tpl_vars['settings']['upload_images'] == 0): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('upload_images_disabled_label','upload_images_all_label','upload_images_users_label','upload_images_admins_mods_label')); set_label_class('max_upload_size_label','inactive')" /><label id="upload_images_disabled_label" for="upload_images_disabled" class="<?php if ($this->_tpl_vars['settings']['upload_images'] == 0): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['disabled']; ?>
</label></p>
<?php $this->assign('settings_upload_max_width', $this->_tpl_vars['settings']['upload_max_img_width']); ?>
<?php $this->assign('input_upload_max_width', "<input id=\"upload_max_img_width\" type=\"text\" name=\"upload_max_img_width\" value=\"".($this->_tpl_vars['settings_upload_max_width'])."\" size=\"3\" />"); ?>
<?php $this->assign('settings_upload_max_height', $this->_tpl_vars['settings']['upload_max_img_height']); ?>
<?php $this->assign('input_upload_max_height', "<input type=\"text\" name=\"upload_max_img_height\" value=\"".($this->_tpl_vars['settings_upload_max_height'])."\" size=\"3\" />"); ?>
<?php $this->assign('settings_upload_max_img_size', $this->_tpl_vars['settings']['upload_max_img_size']); ?>
<?php $this->assign('input_upload_max_filesize', "<input type=\"text\" name=\"upload_max_img_size\" value=\"".($this->_tpl_vars['settings_upload_max_img_size'])."\" size=\"3\" />"); ?>
<p><label id="max_upload_size_label" for="upload_max_img_width" class="<?php if ($this->_tpl_vars['settings']['upload_images'] == 0): ?>inactive<?php else: ?>active<?php endif; ?>"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['max_upload_size'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[width]", $this->_tpl_vars['input_upload_max_width']) : smarty_modifier_replace($_tmp, "[width]", $this->_tpl_vars['input_upload_max_width'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[height]", $this->_tpl_vars['input_upload_max_height']) : smarty_modifier_replace($_tmp, "[height]", $this->_tpl_vars['input_upload_max_height'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[filesize]", $this->_tpl_vars['input_upload_max_filesize']) : smarty_modifier_replace($_tmp, "[filesize]", $this->_tpl_vars['input_upload_max_filesize'])); ?>
</label></p></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['autolink']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['autolink_desc']; ?>
</span></td>
<td class="d"><input id="autolink" type="checkbox" name="autolink" value="1"<?php if ($this->_tpl_vars['settings']['autolink'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('autolink_label'))" /><label id="autolink_label" for="autolink" class="<?php if ($this->_tpl_vars['settings']['autolink'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['autolink_enabled']; ?>
</label></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['count_views']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['count_views_desc']; ?>
</span></td>
<td class="d"><input id="count_views" type="checkbox" name="count_views" value="1"<?php if ($this->_tpl_vars['settings']['count_views'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('count_views_label'))" /><label id="count_views_label" for="count_views" class="<?php if ($this->_tpl_vars['settings']['count_views'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['views_counter_enabled']; ?>
</label></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['rss_feed']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['rss_feed_desc']; ?>
</span></td>
<td class="d"><input id="rss_feed" type="checkbox" name="rss_feed" value="1"<?php if ($this->_tpl_vars['settings']['rss_feed'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('rss_feed_label'))" /><label id="rss_feed_label" for="rss_feed" class="<?php if ($this->_tpl_vars['settings']['rss_feed'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['rss_feed_enabled']; ?>
</label></td>
</tr>

<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['threads_per_page']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['threads_per_page_desc']; ?>
</span></td>
<td class="d"><input type="text" name="threads_per_page" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['threads_per_page'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="5" /></td>
</tr>

<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['count_users_online']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['count_users_online_desc']; ?>
</span></td>
<td class="d"><input type="text" name="count_users_online" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['count_users_online'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="5" /></td>
</tr>

<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['time_difference']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['time_difference_desc']; ?>
</span></td>
<td class="d"><input type="text" name="time_difference" value="<?php echo $this->_tpl_vars['settings']['time_difference']; ?>
" size="5" /></td>
</tr>

<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['terms_of_use_agreement']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['terms_of_use_agreement_desc']; ?>
</span></td>
<td class="d"><p><input id="terms_of_use_agreement" type="checkbox" name="terms_of_use_agreement" value="1"<?php if ($this->_tpl_vars['settings']['terms_of_use_agreement'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('terms_of_use_agreement_label')); set_label_class('terms_of_use_url_label')" /><label id="terms_of_use_agreement_label" for="terms_of_use_agreement" class="<?php if ($this->_tpl_vars['settings']['terms_of_use_agreement'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['terms_of_use_agreement_enabled']; ?>
</label></p>
<p><label id="terms_of_use_url_label" for="terms_of_use_url" class="<?php if ($this->_tpl_vars['settings']['terms_of_use_agreement'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['terms_of_use_url']; ?>
</label><br /><input id="terms_of_use_url" type="text" name="terms_of_use_url" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['terms_of_use_url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="40" /></p></td>
</tr>

<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['forum_enabled_marking']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['forum_enabled_desc']; ?>
</span></td>
<td class="d"><p><input id="forum_enabled" type="checkbox" name="forum_enabled" value="1"<?php if ($this->_tpl_vars['settings']['forum_enabled'] == 1): ?> checked="checked"<?php endif; ?> onchange="change_label_classes(new Array('forum_enabled_label')); set_label_class('forum_disabled_message_label')" /><label id="forum_enabled_label" for="forum_enabled" class="<?php if ($this->_tpl_vars['settings']['forum_enabled'] == 1): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo $this->_config[0]['vars']['forum_enabled']; ?>
</label></p>
<p><label id="forum_disabled_message_label" for="forum_disabled_message" class="<?php if ($this->_tpl_vars['settings']['forum_enabled'] == 1): ?>inactive<?php else: ?>active<?php endif; ?>"><?php echo $this->_config[0]['vars']['forum_disabled_message']; ?>
</label><br /><input id="forum_disabled_message" type="text" name="forum_disabled_message" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['forum_disabled_message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="40" /></p></td>
</tr>
<tr>
<td class="c">&nbsp;</td>
<td class="d"><p class="small"><input id="clear_chache" type="checkbox" name="clear_cache" value="1" /><label for="clear_chache"><?php echo $this->_config[0]['vars']['clear_chache']; ?>
</label></p>
<p><input type="submit" name="settings_submit" value="<?php echo $this->_config[0]['vars']['settings_submit_button']; ?>
" /></p></td>
</tr>
</table>
</div>
</form>
<p style="margin-top:10px;"><a class="stronglink" href="index.php?mode=admin&amp;action=advanced_settings"><?php echo $this->_config[0]['vars']['advanced_settings_link']; ?>
</a></p>
<?php elseif ($this->_tpl_vars['action'] == 'advanced_settings'): ?>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<table class="normaltab" border="0" cellpadding="5" cellspacing="1">
<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['settings_sorted']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['nr']['show'] = true;
$this->_sections['nr']['max'] = $this->_sections['nr']['loop'];
$this->_sections['nr']['step'] = 1;
$this->_sections['nr']['start'] = $this->_sections['nr']['step'] > 0 ? 0 : $this->_sections['nr']['loop']-1;
if ($this->_sections['nr']['show']) {
    $this->_sections['nr']['total'] = $this->_sections['nr']['loop'];
    if ($this->_sections['nr']['total'] == 0)
        $this->_sections['nr']['show'] = false;
} else
    $this->_sections['nr']['total'] = 0;
if ($this->_sections['nr']['show']):

            for ($this->_sections['nr']['index'] = $this->_sections['nr']['start'], $this->_sections['nr']['iteration'] = 1;
                 $this->_sections['nr']['iteration'] <= $this->_sections['nr']['total'];
                 $this->_sections['nr']['index'] += $this->_sections['nr']['step'], $this->_sections['nr']['iteration']++):
$this->_sections['nr']['rownum'] = $this->_sections['nr']['iteration'];
$this->_sections['nr']['index_prev'] = $this->_sections['nr']['index'] - $this->_sections['nr']['step'];
$this->_sections['nr']['index_next'] = $this->_sections['nr']['index'] + $this->_sections['nr']['step'];
$this->_sections['nr']['first']      = ($this->_sections['nr']['iteration'] == 1);
$this->_sections['nr']['last']       = ($this->_sections['nr']['iteration'] == $this->_sections['nr']['total']);
?>
<tr>
<td class="c"><strong><?php echo $this->_tpl_vars['settings_sorted'][$this->_sections['nr']['index']]['key']; ?>
</strong></td>
<td class="d"><input type="text" name="<?php echo $this->_tpl_vars['settings_sorted'][$this->_sections['nr']['index']]['key']; ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings_sorted'][$this->_sections['nr']['index']]['val'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></td>
</tr>
<?php endfor; endif; ?>
<tr>
<td class="c">&nbsp;</td>
<td class="d"><input type="submit" name="settings_submit" value="<?php echo $this->_config[0]['vars']['settings_submit_button']; ?>
" /></td>
</tr>
</table>
</div>
</form>
<?php elseif ($this->_tpl_vars['action'] == 'categories'): ?>
<?php if ($this->_tpl_vars['entries_in_not_existing_categories'] > 0): ?>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div style="margin:0px 0px 20px 0px; padding:10px; border:1px dotted red;">
<input type="hidden" name="mode" value="admin" />
<p><?php echo $this->_config[0]['vars']['entries_in_not_ex_cat']; ?>
</p>
<p><input type="radio" name="entry_action" value="delete" checked="checked" /><?php echo $this->_config[0]['vars']['entries_in_not_ex_cat_del']; ?>
<br />
<input type="radio" name="entry_action" value="move" /><?php echo $this->_config[0]['vars']['entries_in_not_ex_cat_mov']; ?>

<select class="kat" size="1" name="move_category">
<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
<?php if ($this->_tpl_vars['key'] != 0): ?><option value="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['val']; ?>
</option><?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</select>
</p>
<p><input type="submit" name="entries_in_not_existing_categories_submit" value="<?php echo $this->_config[0]['vars']['submit_button_ok']; ?>
"></p>
</div>
</form>
<?php endif; ?>
<?php if ($this->_tpl_vars['errors']): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['error_headline']; ?>
</p>
<ul>
<?php unset($this->_sections['mysec']);
$this->_sections['mysec']['name'] = 'mysec';
$this->_sections['mysec']['loop'] = is_array($_loop=$this->_tpl_vars['errors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mysec']['show'] = true;
$this->_sections['mysec']['max'] = $this->_sections['mysec']['loop'];
$this->_sections['mysec']['step'] = 1;
$this->_sections['mysec']['start'] = $this->_sections['mysec']['step'] > 0 ? 0 : $this->_sections['mysec']['loop']-1;
if ($this->_sections['mysec']['show']) {
    $this->_sections['mysec']['total'] = $this->_sections['mysec']['loop'];
    if ($this->_sections['mysec']['total'] == 0)
        $this->_sections['mysec']['show'] = false;
} else
    $this->_sections['mysec']['total'] = 0;
if ($this->_sections['mysec']['show']):

            for ($this->_sections['mysec']['index'] = $this->_sections['mysec']['start'], $this->_sections['mysec']['iteration'] = 1;
                 $this->_sections['mysec']['iteration'] <= $this->_sections['mysec']['total'];
                 $this->_sections['mysec']['index'] += $this->_sections['mysec']['step'], $this->_sections['mysec']['iteration']++):
$this->_sections['mysec']['rownum'] = $this->_sections['mysec']['iteration'];
$this->_sections['mysec']['index_prev'] = $this->_sections['mysec']['index'] - $this->_sections['mysec']['step'];
$this->_sections['mysec']['index_next'] = $this->_sections['mysec']['index'] + $this->_sections['mysec']['step'];
$this->_sections['mysec']['first']      = ($this->_sections['mysec']['iteration'] == 1);
$this->_sections['mysec']['last']       = ($this->_sections['mysec']['iteration'] == $this->_sections['mysec']['total']);
?>
<?php $this->assign('error', $this->_tpl_vars['errors'][$this->_sections['mysec']['index']]); ?>
<li><?php echo $this->_config[0]['vars'][$this->_tpl_vars['error']]; ?>
</li>
<?php endfor; endif; ?>
</ul>
<?php endif; ?>
<?php if ($this->_tpl_vars['categories_count'] > 0): ?>
<table class="normaltab" cellspacing="1" cellpadding="5">
<thead>
<tr>
<th><?php echo $this->_config[0]['vars']['category_name']; ?>
</th>
<th><?php echo $this->_config[0]['vars']['category_accession']; ?>
</th>
<th><?php echo $this->_config[0]['vars']['category_topics']; ?>
</th>
<th><?php echo $this->_config[0]['vars']['category_entries']; ?>
</th>
<th>&#160;</th>
</tr>
</thead>
<tbody id="items">
<?php unset($this->_sections['row']);
$this->_sections['row']['name'] = 'row';
$this->_sections['row']['loop'] = is_array($_loop=$this->_tpl_vars['categories_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['row']['show'] = true;
$this->_sections['row']['max'] = $this->_sections['row']['loop'];
$this->_sections['row']['step'] = 1;
$this->_sections['row']['start'] = $this->_sections['row']['step'] > 0 ? 0 : $this->_sections['row']['loop']-1;
if ($this->_sections['row']['show']) {
    $this->_sections['row']['total'] = $this->_sections['row']['loop'];
    if ($this->_sections['row']['total'] == 0)
        $this->_sections['row']['show'] = false;
} else
    $this->_sections['row']['total'] = 0;
if ($this->_sections['row']['show']):

            for ($this->_sections['row']['index'] = $this->_sections['row']['start'], $this->_sections['row']['iteration'] = 1;
                 $this->_sections['row']['iteration'] <= $this->_sections['row']['total'];
                 $this->_sections['row']['index'] += $this->_sections['row']['step'], $this->_sections['row']['iteration']++):
$this->_sections['row']['rownum'] = $this->_sections['row']['iteration'];
$this->_sections['row']['index_prev'] = $this->_sections['row']['index'] - $this->_sections['row']['step'];
$this->_sections['row']['index_next'] = $this->_sections['row']['index'] + $this->_sections['row']['step'];
$this->_sections['row']['first']      = ($this->_sections['row']['iteration'] == 1);
$this->_sections['row']['last']       = ($this->_sections['row']['iteration'] == $this->_sections['row']['total']);
?>
<tr id="id_<?php echo $this->_tpl_vars['categories_list'][$this->_sections['row']['index']]['id']; ?>
">
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><strong><?php echo $this->_tpl_vars['categories_list'][$this->_sections['row']['index']]['name']; ?>
</strong></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><?php if ($this->_tpl_vars['categories_list'][$this->_sections['row']['index']]['accession'] == 2): ?><?php echo $this->_config[0]['vars']['cat_accessible_admin_mod']; ?>
<?php elseif ($this->_tpl_vars['categories_list'][$this->_sections['row']['index']]['accession'] == 1): ?><?php echo $this->_config[0]['vars']['cat_accessible_reg_users']; ?>
<?php else: ?><?php echo $this->_config[0]['vars']['cat_accessible_all']; ?>
<?php endif; ?></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><?php echo $this->_tpl_vars['categories_list'][$this->_sections['row']['index']]['threads_in_category']; ?>
</td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><?php echo $this->_tpl_vars['categories_list'][$this->_sections['row']['index']]['postings_in_category']; ?>
</td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b"), $this);?>
"><a href="index.php?mode=admin&amp;edit_category=<?php echo $this->_tpl_vars['categories_list'][$this->_sections['row']['index']]['id']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/edit.png" title="<?php echo $this->_config[0]['vars']['edit']; ?>
" alt="<?php echo $this->_config[0]['vars']['edit']; ?>
" width="16" height="16" /></a> &nbsp; <a href="index.php?mode=admin&amp;delete_category=<?php echo $this->_tpl_vars['categories_list'][$this->_sections['row']['index']]['id']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/delete.png" title="<?php echo $this->_config[0]['vars']['delete']; ?>
" alt="<?php echo $this->_config[0]['vars']['delete']; ?>
" width="16" height="16"/></a> &nbsp; <a href="index.php?mode=admin&amp;move_up_category=<?php echo $this->_tpl_vars['categories_list'][$this->_sections['row']['index']]['id']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/arrow_up.png" alt="<?php echo $this->_config[0]['vars']['up']; ?>
" title="<?php echo $this->_config[0]['vars']['up']; ?>
" width="16" height="16" /></a>&nbsp;<a href="index.php?mode=admin&amp;move_down_category=<?php echo $this->_tpl_vars['categories_list'][$this->_sections['row']['index']]['id']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/arrow_down.png" alt="<?php echo $this->_config[0]['vars']['down']; ?>
" title="<?php echo $this->_config[0]['vars']['down']; ?>
" width="16" height="16" /></a></td>
</tr>
<?php endfor; endif; ?>
</tbody>
</table>
<script type="text/javascript">Sortable.create('items', <?php echo '{ tag:\'tr\', onUpdate : updateCategoryOrder }'; ?>
); addMoveTitle('<?php echo $this->_config[0]['vars']['move_drag_and_drop']; ?>
')</script>
<?php else: ?>
<p><?php echo $this->_config[0]['vars']['no_categories']; ?>
</p>
<?php endif; ?>
<br />
<form action="index.php" method="post" class="normalform" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<label for="new_category" class="main"><?php echo $this->_config[0]['vars']['new_category']; ?>
</label><br />
<input id="new_category" type="text" name="new_category" size="25" value="<?php if ($this->_tpl_vars['new_category']): ?><?php echo $this->_tpl_vars['new_category']; ?>
<?php endif; ?>" /><br /><br />
<strong><?php echo $this->_config[0]['vars']['category_accessible_by']; ?>
</strong><br />
<input id="cat_accessible_all" type="radio" name="accession" value="0"<?php if (! $this->_tpl_vars['accession'] || acession == 0): ?> checked="checked"<?php endif; ?> /><label for="cat_accessible_all"><?php echo $this->_config[0]['vars']['cat_accessible_all']; ?>
</label><br />
<input id="cat_accessible_reg_users" type="radio" name="accession" value="1"<?php if (acession == 1): ?> checked="checked"<?php endif; ?> /><label for="cat_accessible_reg_users"><?php echo $this->_config[0]['vars']['cat_accessible_reg_users']; ?>
</label><br />
<input id="cat_accessible_admin_mod" type="radio" name="accession" value="2"<?php if (acession == 2): ?> checked="checked"<?php endif; ?> /><label for="cat_accessible_admin_mod"><?php echo $this->_config[0]['vars']['cat_accessible_admin_mod']; ?>
</label><br /><br />
<input type="submit" value="<?php echo $this->_config[0]['vars']['submit_button_ok']; ?>
" />
</div>
</form>
<?php elseif ($this->_tpl_vars['action'] == 'edit_category'): ?>
<?php if ($this->_tpl_vars['errors']): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['error_headline']; ?>
</p>
<ul>
<?php unset($this->_sections['mysec']);
$this->_sections['mysec']['name'] = 'mysec';
$this->_sections['mysec']['loop'] = is_array($_loop=$this->_tpl_vars['errors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mysec']['show'] = true;
$this->_sections['mysec']['max'] = $this->_sections['mysec']['loop'];
$this->_sections['mysec']['step'] = 1;
$this->_sections['mysec']['start'] = $this->_sections['mysec']['step'] > 0 ? 0 : $this->_sections['mysec']['loop']-1;
if ($this->_sections['mysec']['show']) {
    $this->_sections['mysec']['total'] = $this->_sections['mysec']['loop'];
    if ($this->_sections['mysec']['total'] == 0)
        $this->_sections['mysec']['show'] = false;
} else
    $this->_sections['mysec']['total'] = 0;
if ($this->_sections['mysec']['show']):

            for ($this->_sections['mysec']['index'] = $this->_sections['mysec']['start'], $this->_sections['mysec']['iteration'] = 1;
                 $this->_sections['mysec']['iteration'] <= $this->_sections['mysec']['total'];
                 $this->_sections['mysec']['index'] += $this->_sections['mysec']['step'], $this->_sections['mysec']['iteration']++):
$this->_sections['mysec']['rownum'] = $this->_sections['mysec']['iteration'];
$this->_sections['mysec']['index_prev'] = $this->_sections['mysec']['index'] - $this->_sections['mysec']['step'];
$this->_sections['mysec']['index_next'] = $this->_sections['mysec']['index'] + $this->_sections['mysec']['step'];
$this->_sections['mysec']['first']      = ($this->_sections['mysec']['iteration'] == 1);
$this->_sections['mysec']['last']       = ($this->_sections['mysec']['iteration'] == $this->_sections['mysec']['total']);
?>
<?php $this->assign('error', $this->_tpl_vars['errors'][$this->_sections['mysec']['index']]); ?>
<li><?php echo $this->_config[0]['vars'][$this->_tpl_vars['error']]; ?>
</li>
<?php endfor; endif; ?>
</ul>
<?php endif; ?>
<form action="index.php" method="post" class="normalform" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['category_id']; ?>
" />
<strong><?php echo $this->_config[0]['vars']['edit_category']; ?>
</strong><br />
<input type="text" name="category" value="<?php echo $this->_tpl_vars['edit_category']; ?>
" size="25" /><br /><br />
<strong><?php echo $this->_config[0]['vars']['category_accessible_by']; ?>
</strong><br />
<input id="cat_accessible_all" type="radio" name="accession" value="0"<?php if ($this->_tpl_vars['edit_accession'] == 0): ?> checked="checked"<?php endif; ?> /><label for="cat_accessible_all"><?php echo $this->_config[0]['vars']['cat_accessible_all']; ?>
</label><br />
<input id="cat_accessible_reg_users" type="radio" name="accession" value="1"<?php if ($this->_tpl_vars['edit_accession'] == 1): ?> checked="checked"<?php endif; ?> /><label for="cat_accessible_reg_users"><?php echo $this->_config[0]['vars']['cat_accessible_reg_users']; ?>
</label><br />
<input id="cat_accessible_admin_mod" type="radio" name="accession" value="2"<?php if ($this->_tpl_vars['edit_accession'] == 2): ?> checked="checked"<?php endif; ?> /><label for="cat_accessible_admin_mod"><?php echo $this->_config[0]['vars']['cat_accessible_admin_mod']; ?>
</label><br /><br />
<input type="submit" name="edit_category_submit" value="<?php echo $this->_config[0]['vars']['submit_button_ok']; ?>
" />
</div>
</form>
<?php elseif ($this->_tpl_vars['action'] == 'delete_category'): ?>
<?php if ($this->_tpl_vars['errors']): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['error_headline']; ?>
</p>
<ul>
<?php unset($this->_sections['mysec']);
$this->_sections['mysec']['name'] = 'mysec';
$this->_sections['mysec']['loop'] = is_array($_loop=$this->_tpl_vars['errors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mysec']['show'] = true;
$this->_sections['mysec']['max'] = $this->_sections['mysec']['loop'];
$this->_sections['mysec']['step'] = 1;
$this->_sections['mysec']['start'] = $this->_sections['mysec']['step'] > 0 ? 0 : $this->_sections['mysec']['loop']-1;
if ($this->_sections['mysec']['show']) {
    $this->_sections['mysec']['total'] = $this->_sections['mysec']['loop'];
    if ($this->_sections['mysec']['total'] == 0)
        $this->_sections['mysec']['show'] = false;
} else
    $this->_sections['mysec']['total'] = 0;
if ($this->_sections['mysec']['show']):

            for ($this->_sections['mysec']['index'] = $this->_sections['mysec']['start'], $this->_sections['mysec']['iteration'] = 1;
                 $this->_sections['mysec']['iteration'] <= $this->_sections['mysec']['total'];
                 $this->_sections['mysec']['index'] += $this->_sections['mysec']['step'], $this->_sections['mysec']['iteration']++):
$this->_sections['mysec']['rownum'] = $this->_sections['mysec']['iteration'];
$this->_sections['mysec']['index_prev'] = $this->_sections['mysec']['index'] - $this->_sections['mysec']['step'];
$this->_sections['mysec']['index_next'] = $this->_sections['mysec']['index'] + $this->_sections['mysec']['step'];
$this->_sections['mysec']['first']      = ($this->_sections['mysec']['iteration'] == 1);
$this->_sections['mysec']['last']       = ($this->_sections['mysec']['iteration'] == $this->_sections['mysec']['total']);
?>
<?php $this->assign('error', $this->_tpl_vars['errors'][$this->_sections['mysec']['index']]); ?>
<li><?php echo $this->_config[0]['vars'][$this->_tpl_vars['error']]; ?>
</li>
<?php endfor; endif; ?>
</ul>
<?php endif; ?>
<h2><?php echo ((is_array($_tmp=$this->_config[0]['vars']['delete_category_hl'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[category]", $this->_tpl_vars['category_name']) : smarty_modifier_replace($_tmp, "[category]", $this->_tpl_vars['category_name'])); ?>
</h2>
<p class="caution"><?php echo $this->_config[0]['vars']['caution']; ?>
</p>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<input type="hidden" name="category_id" value="<?php echo $this->_tpl_vars['category_id']; ?>
" />
<p><input type="radio" name="delete_mode" value="complete" checked="checked" /> <?php echo $this->_config[0]['vars']['delete_category_compl']; ?>
</p></td>
<p><input type="radio" name="delete_mode" value="keep_entries" /> <?php if ($this->_tpl_vars['categories_count'] <= 1): ?><?php echo $this->_config[0]['vars']['del_cat_keep_entries']; ?>

<?php else: ?><?php echo $this->_config[0]['vars']['del_cat_move_entries']; ?>

<select class="kat" size="1" name="move_category">
<option value="0">&nbsp;</option>
<?php $_from = $this->_tpl_vars['move_categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
<?php if ($this->_tpl_vars['key'] != 0): ?><option value="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['val']; ?>
</option><?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</select>
<?php endif; ?>
<p><input type="submit" name="delete_category_submit" value="<?php echo $this->_config[0]['vars']['delete_category_submit']; ?>
" /></p>
</div>
</form>
<?php elseif ($this->_tpl_vars['action'] == 'user'): ?>
<?php if ($this->_tpl_vars['new_user'] && ! $this->_tpl_vars['send_error']): ?><p class="ok"><?php echo ((is_array($_tmp=$this->_config[0]['vars']['new_user_registered'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[name]", $this->_tpl_vars['new_user']) : smarty_modifier_replace($_tmp, "[name]", $this->_tpl_vars['new_user'])); ?>
</p><?php elseif ($this->_tpl_vars['new_user'] && $this->_tpl_vars['send_error']): ?><p class="caution"><?php echo ((is_array($_tmp=$this->_config[0]['vars']['new_user_reg_send_error'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[name]", $this->_tpl_vars['new_user']) : smarty_modifier_replace($_tmp, "[name]", $this->_tpl_vars['new_user'])); ?>
</p><?php endif; ?>
<!--<p><?php echo ((is_array($_tmp=$this->_config[0]['vars']['num_registerd_users'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[number]", $this->_tpl_vars['total_users']) : smarty_modifier_replace($_tmp, "[number]", $this->_tpl_vars['total_users'])); ?>
</p>-->
<div class="usernav">
<div class="usersearch">
<label for="search_user"><?php echo $this->_config[0]['vars']['search_user']; ?>
</label><form action="index.php" method="get" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div style="display:inline;">
<input type="hidden" name="mode" value="admin" />
<input type="hidden" name="action" value="user" />
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
<?php if ($this->_tpl_vars['result_count'] > 0): ?>
<?php if ($this->_tpl_vars['no_users_in_selection']): ?><p class="caution"><?php echo $this->_config[0]['vars']['no_users_in_sel']; ?>
</p><?php endif; ?>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<table class="normaltab" border="0" cellpadding="5" cellspacing="1">
<tr>
<th>&nbsp;</th>
<!--<th><a href="index.php?mode=admin&amp;action=user<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;order=user_id&amp;descasc=<?php if ($this->_tpl_vars['descasc'] == 'ASC' && $this->_tpl_vars['order'] == 'user_id'): ?>DESC<?php else: ?>ASC<?php endif; ?>&amp;ul=<?php echo $this->_tpl_vars['ul']; ?>
" title="<?php echo $this->_config[0]['vars']['order_linktitle']; ?>
"><?php echo $this->_config[0]['vars']['user_id']; ?>
</a><?php if ($this->_tpl_vars['order'] == 'user_id' && $this->_tpl_vars['descasc'] == 'ASC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/asc.png" alt="[asc]" width="5" height="9" /><?php elseif ($this->_tpl_vars['order'] == 'user_id' && $this->_tpl_vars['descasc'] == 'DESC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/desc.png" alt="[desc]" width="5" height="9" /><?php endif; ?></th>-->
<th><a href="index.php?mode=admin&amp;action=user<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;order=user_name&amp;descasc=<?php if ($this->_tpl_vars['descasc'] == 'ASC' && $this->_tpl_vars['order'] == 'user_name'): ?>DESC<?php else: ?>ASC<?php endif; ?>&amp;ul=<?php echo $this->_tpl_vars['ul']; ?>
" title="<?php echo $this->_config[0]['vars']['order_linktitle']; ?>
"><?php echo $this->_config[0]['vars']['user_name']; ?>
</a><?php if ($this->_tpl_vars['order'] == 'user_name' && $this->_tpl_vars['descasc'] == 'ASC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/asc.png" alt="[asc]" width="5" height="9" /><?php elseif ($this->_tpl_vars['order'] == 'user_name' && $this->_tpl_vars['descasc'] == 'DESC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/desc.png" alt="[desc]" width="5" height="9" /><?php endif; ?></th>
<th><a href="index.php?mode=admin&amp;action=user<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;order=user_email&amp;descasc=<?php if ($this->_tpl_vars['descasc'] == 'ASC' && $this->_tpl_vars['order'] == 'user_email'): ?>DESC<?php else: ?>ASC<?php endif; ?>&amp;ul=<?php echo $this->_tpl_vars['ul']; ?>
" title="<?php echo $this->_config[0]['vars']['order_linktitle']; ?>
"><?php echo $this->_config[0]['vars']['user_email']; ?>
</a><?php if ($this->_tpl_vars['order'] == 'user_email' && $this->_tpl_vars['descasc'] == 'ASC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/asc.png" alt="[asc]" width="5" height="9" /><?php elseif ($this->_tpl_vars['order'] == 'user_email' && $this->_tpl_vars['descasc'] == 'DESC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/desc.png" alt="[desc]" width="5" height="9" /><?php endif; ?></th>
<th><a href="index.php?mode=admin&amp;action=user<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;order=user_type&amp;descasc=<?php if ($this->_tpl_vars['descasc'] == 'ASC' && $this->_tpl_vars['order'] == 'user_type'): ?>DESC<?php else: ?>ASC<?php endif; ?>&amp;ul=<?php echo $this->_tpl_vars['ul']; ?>
" title="<?php echo $this->_config[0]['vars']['order_linktitle']; ?>
"><?php echo $this->_config[0]['vars']['user_type']; ?>
</a><?php if ($this->_tpl_vars['order'] == 'user_type' && $this->_tpl_vars['descasc'] == 'ASC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/asc.png" alt="[asc]" width="5" height="9" /><?php elseif ($this->_tpl_vars['order'] == 'user_type' && $this->_tpl_vars['descasc'] == 'DESC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/desc.png" alt="[desc]" width="5" height="9" /><?php endif; ?></th>
<th><a href="index.php?mode=admin&amp;action=user<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;order=registered&amp;descasc=<?php if ($this->_tpl_vars['descasc'] == 'ASC' && $this->_tpl_vars['order'] == 'registered'): ?>DESC<?php else: ?>ASC<?php endif; ?>&amp;ul=<?php echo $this->_tpl_vars['ul']; ?>
" title="<?php echo $this->_config[0]['vars']['order_linktitle']; ?>
"><?php echo $this->_config[0]['vars']['user_registered']; ?>
</a><?php if ($this->_tpl_vars['order'] == 'registered' && $this->_tpl_vars['descasc'] == 'ASC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/asc.png" alt="[asc]" width="5" height="9" /><?php elseif ($this->_tpl_vars['order'] == 'registered' && $this->_tpl_vars['descasc'] == 'DESC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/desc.png" alt="[desc]" width="5" height="9" /><?php endif; ?></th>
<th><a href="index.php?mode=admin&amp;action=user<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;order=logins&amp;descasc=<?php if ($this->_tpl_vars['descasc'] == 'ASC' && $this->_tpl_vars['order'] == 'logins'): ?>DESC<?php else: ?>ASC<?php endif; ?>&amp;ul=<?php echo $this->_tpl_vars['ul']; ?>
" title="<?php echo $this->_config[0]['vars']['order_linktitle']; ?>
"><?php echo $this->_config[0]['vars']['user_logins']; ?>
</a><?php if ($this->_tpl_vars['order'] == 'logins' && $this->_tpl_vars['descasc'] == 'ASC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/asc.png" alt="[asc]" width="5" height="9" /><?php elseif ($this->_tpl_vars['order'] == 'logins' && $this->_tpl_vars['descasc'] == 'DESC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/desc.png" alt="[desc]" width="5" height="9" /><?php endif; ?></th>
<th><a href="index.php?mode=admin&amp;action=user<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;order=last_login&amp;descasc=<?php if ($this->_tpl_vars['descasc'] == 'ASC' && $this->_tpl_vars['order'] == 'last_login'): ?>DESC<?php else: ?>ASC<?php endif; ?>&amp;ul=<?php echo $this->_tpl_vars['ul']; ?>
" title="<?php echo $this->_config[0]['vars']['order_linktitle']; ?>
"><?php echo $this->_config[0]['vars']['last_login']; ?>
</a><?php if ($this->_tpl_vars['order'] == 'last_login' && $this->_tpl_vars['descasc'] == 'ASC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/asc.png" alt="[asc]" width="5" height="9" /><?php elseif ($this->_tpl_vars['order'] == 'last_login' && $this->_tpl_vars['descasc'] == 'DESC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/desc.png" alt="[desc]" width="5" height="9" /><?php endif; ?></th>
<th><a href="index.php?mode=admin&amp;action=user<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;order=user_lock&amp;descasc=<?php if ($this->_tpl_vars['descasc'] == 'ASC' && $this->_tpl_vars['order'] == 'user_lock'): ?>DESC<?php else: ?>ASC<?php endif; ?>&amp;ul=<?php echo $this->_tpl_vars['ul']; ?>
" title="<?php echo $this->_config[0]['vars']['order_linktitle']; ?>
"><?php echo $this->_config[0]['vars']['lock']; ?>
</a><?php if ($this->_tpl_vars['order'] == 'user_lock' && $this->_tpl_vars['descasc'] == 'ASC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/asc.png" alt="[asc]" width="5" height="9" /><?php elseif ($this->_tpl_vars['order'] == 'user_lock' && $this->_tpl_vars['descasc'] == 'DESC'): ?>&nbsp;<img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/desc.png" alt="[desc]" width="5" height="9" /><?php endif; ?></th>
<th colspan="2">&nbsp;</th>
</tr>
<?php unset($this->_sections['row']);
$this->_sections['row']['name'] = 'row';
$this->_sections['row']['loop'] = is_array($_loop=$this->_tpl_vars['userdata']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['row']['show'] = true;
$this->_sections['row']['max'] = $this->_sections['row']['loop'];
$this->_sections['row']['step'] = 1;
$this->_sections['row']['start'] = $this->_sections['row']['step'] > 0 ? 0 : $this->_sections['row']['loop']-1;
if ($this->_sections['row']['show']) {
    $this->_sections['row']['total'] = $this->_sections['row']['loop'];
    if ($this->_sections['row']['total'] == 0)
        $this->_sections['row']['show'] = false;
} else
    $this->_sections['row']['total'] = 0;
if ($this->_sections['row']['show']):

            for ($this->_sections['row']['index'] = $this->_sections['row']['start'], $this->_sections['row']['iteration'] = 1;
                 $this->_sections['row']['iteration'] <= $this->_sections['row']['total'];
                 $this->_sections['row']['index'] += $this->_sections['row']['step'], $this->_sections['row']['iteration']++):
$this->_sections['row']['rownum'] = $this->_sections['row']['iteration'];
$this->_sections['row']['index_prev'] = $this->_sections['row']['index'] - $this->_sections['row']['step'];
$this->_sections['row']['index_next'] = $this->_sections['row']['index'] + $this->_sections['row']['step'];
$this->_sections['row']['first']      = ($this->_sections['row']['iteration'] == 1);
$this->_sections['row']['last']       = ($this->_sections['row']['iteration'] == $this->_sections['row']['total']);
?>
<tr>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
" style="width:10px;"><input type="checkbox" name="selected[]" value="<?php echo $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_id']; ?>
" /></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><?php if ($this->_tpl_vars['userdata'][$this->_sections['row']['index']]['inactive']): ?><span title="<?php echo $this->_config[0]['vars']['user_inactive']; ?>
" style="font-weight:bold;color:red;"><?php echo $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_name']; ?>
</span><?php else: ?><a href="index.php?mode=user&amp;show_user=<?php echo $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_id']; ?>
" title="<?php echo ((is_array($_tmp=$this->_config[0]['vars']['show_userdata_linktitle'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[user]", $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_name']) : smarty_modifier_replace($_tmp, "[user]", $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_name'])); ?>
"><strong><?php echo $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_name']; ?>
</strong></a><?php endif; ?></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><span class="small"><a href="mailto:<?php echo $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_email']; ?>
" title="<?php echo ((is_array($_tmp=$this->_config[0]['vars']['mailto_user_lt'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[user]", $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_name']) : smarty_modifier_replace($_tmp, "[user]", $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_name'])); ?>
"><?php echo $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_email']; ?>
</a></span></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><span class="small"><?php if ($this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_type'] == 2): ?><?php echo $this->_config[0]['vars']['admin']; ?>
<?php elseif ($this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_type'] == 1): ?><?php echo $this->_config[0]['vars']['mod']; ?>
<?php else: ?><?php echo $this->_config[0]['vars']['user']; ?>
<?php endif; ?></span></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><span class="small"><?php echo ((is_array($_tmp=$this->_tpl_vars['userdata'][$this->_sections['row']['index']]['registered_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['time_format']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['time_format'])); ?>
</span></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><span class="small"><?php echo $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['logins']; ?>
</span></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><span class="small"><?php if ($this->_tpl_vars['userdata'][$this->_sections['row']['index']]['logins'] > 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['userdata'][$this->_sections['row']['index']]['last_login_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['time_format']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['time_format'])); ?>
<?php else: ?>&nbsp;<?php endif; ?></span></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><span class="small"><?php if ($this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_type'] > 0): ?><?php if ($this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_lock'] == 0): ?><?php echo $this->_config[0]['vars']['unlocked']; ?>
<?php else: ?><?php echo $this->_config[0]['vars']['locked']; ?>
<?php endif; ?><?php elseif ($this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_lock'] == 0): ?><a href="index.php?mode=admin&amp;user_lock=<?php echo $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_id']; ?>
<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;page=<?php echo $this->_tpl_vars['page']; ?>
&amp;order=<?php echo $this->_tpl_vars['order']; ?>
&amp;descasc=<?php echo $this->_tpl_vars['descasc']; ?>
" title="<?php echo $this->_config[0]['vars']['lock_title']; ?>
"><?php echo $this->_config[0]['vars']['unlocked']; ?>
</a><?php else: ?><a style="color:red;" href="index.php?mode=admin&amp;user_lock=<?php echo $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_id']; ?>
<?php if ($this->_tpl_vars['search_user_encoded']): ?>&amp;search_user=<?php echo $this->_tpl_vars['search_user_encoded']; ?>
<?php endif; ?>&amp;page=<?php echo $this->_tpl_vars['page']; ?>
&amp;order=<?php echo $this->_tpl_vars['order']; ?>
&amp;descasc=<?php echo $this->_tpl_vars['descasc']; ?>
" title="<?php echo $this->_config[0]['vars']['unlock_title']; ?>
"><?php echo $this->_config[0]['vars']['locked']; ?>
</a><?php endif; ?></span></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><a href="index.php?mode=admin&amp;edit_user=<?php echo $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_id']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/edit.png" title="<?php echo $this->_config[0]['vars']['edit']; ?>
" alt="<?php echo $this->_config[0]['vars']['edit']; ?>
" width="16" height="16" /></a></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b"), $this);?>
"><a href="index.php?mode=admin&amp;delete_user=<?php echo $this->_tpl_vars['userdata'][$this->_sections['row']['index']]['user_id']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/delete.png" title="<?php echo $this->_config[0]['vars']['delete']; ?>
" alt="<?php echo $this->_config[0]['vars']['delete']; ?>
" width="16" height="16" /></a></td>
</tr>
<?php endfor; endif; ?>
</table>
<div>
<div style="float:left; margin:5px 0px 0px 7px; padding:0px;"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/selected_arrow.png" alt="" width="35" height="20" /><input type="submit" name="delete_selected_users" value="<?php echo $this->_config[0]['vars']['delete_selected_users']; ?>
" title="<?php echo $this->_config[0]['vars']['delete_users_sb_title']; ?>
" /></div>
<div style="text-align:right; padding:10px 0 0 0; font-size:0.82em;">
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
</div>
</form>
<?php else: ?>
<p><em><?php echo $this->_config[0]['vars']['no_users']; ?>
</em></p>
<?php endif; ?>
<ul class="adminmenu">
<li><a href="index.php?mode=admin&amp;action=register"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/add_user.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['add_user']; ?>
</span></a></li>
<li><a href="index.php?mode=admin&amp;action=email_list"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/email_list.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['email_list']; ?>
</span></a></li>
<li><a href="index.php?mode=admin&amp;action=clear_userdata"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/delete.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['clear_userdata']; ?>
</span></a></li>
</ul>
<?php elseif ($this->_tpl_vars['action'] == 'edit_user'): ?>
<?php if ($this->_tpl_vars['errors']): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['error_headline']; ?>
</p>
<ul>
<?php unset($this->_sections['mysec']);
$this->_sections['mysec']['name'] = 'mysec';
$this->_sections['mysec']['loop'] = is_array($_loop=$this->_tpl_vars['errors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mysec']['show'] = true;
$this->_sections['mysec']['max'] = $this->_sections['mysec']['loop'];
$this->_sections['mysec']['step'] = 1;
$this->_sections['mysec']['start'] = $this->_sections['mysec']['step'] > 0 ? 0 : $this->_sections['mysec']['loop']-1;
if ($this->_sections['mysec']['show']) {
    $this->_sections['mysec']['total'] = $this->_sections['mysec']['loop'];
    if ($this->_sections['mysec']['total'] == 0)
        $this->_sections['mysec']['show'] = false;
} else
    $this->_sections['mysec']['total'] = 0;
if ($this->_sections['mysec']['show']):

            for ($this->_sections['mysec']['index'] = $this->_sections['mysec']['start'], $this->_sections['mysec']['iteration'] = 1;
                 $this->_sections['mysec']['iteration'] <= $this->_sections['mysec']['total'];
                 $this->_sections['mysec']['index'] += $this->_sections['mysec']['step'], $this->_sections['mysec']['iteration']++):
$this->_sections['mysec']['rownum'] = $this->_sections['mysec']['iteration'];
$this->_sections['mysec']['index_prev'] = $this->_sections['mysec']['index'] - $this->_sections['mysec']['step'];
$this->_sections['mysec']['index_next'] = $this->_sections['mysec']['index'] + $this->_sections['mysec']['step'];
$this->_sections['mysec']['first']      = ($this->_sections['mysec']['iteration'] == 1);
$this->_sections['mysec']['last']       = ($this->_sections['mysec']['iteration'] == $this->_sections['mysec']['total']);
?>
<?php $this->assign('error', $this->_tpl_vars['errors'][$this->_sections['mysec']['index']]); ?>
<li><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars'][$this->_tpl_vars['error']])) ? $this->_run_mod_handler('replace', true, $_tmp, "[profile_length]", $this->_tpl_vars['profil_length']) : smarty_modifier_replace($_tmp, "[profile_length]", $this->_tpl_vars['profil_length'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[profile_maxlength]", $this->_tpl_vars['settings']['profile_maxlength']) : smarty_modifier_replace($_tmp, "[profile_maxlength]", $this->_tpl_vars['settings']['profile_maxlength'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[signature_length]", $this->_tpl_vars['signature_length']) : smarty_modifier_replace($_tmp, "[signature_length]", $this->_tpl_vars['signature_length'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[signature_maxlength]", $this->_tpl_vars['settings']['signature_maxlength']) : smarty_modifier_replace($_tmp, "[signature_maxlength]", $this->_tpl_vars['settings']['signature_maxlength'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[word]", $this->_tpl_vars['word']) : smarty_modifier_replace($_tmp, "[word]", $this->_tpl_vars['word'])); ?>
</li>
<?php endfor; endif; ?>
</ul>
<?php endif; ?>
<?php if ($this->_tpl_vars['inactive']): ?><p class="caution"><?php echo $this->_config[0]['vars']['caution']; ?>
</p><p><?php echo $this->_config[0]['vars']['activate_note']; ?>
 <a href="index.php?mode=admin&amp;activate=<?php echo $this->_tpl_vars['edit_user_id']; ?>
"><?php echo $this->_config[0]['vars']['activate_link']; ?>
</a></p><?php endif; ?>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<input type="hidden" name="edit_user_id" value="<?php echo $this->_tpl_vars['edit_user_id']; ?>
" />
<table class="normaltab" border="0" cellpadding="5" cellspacing="1">
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_user_name']; ?>
</strong></td>
<td class="d"><input type="text" size="40" name="edit_user_name" value="<?php echo $this->_tpl_vars['edit_user_name']; ?>
" maxlength="<?php echo $this->_tpl_vars['settings']['name_maxlength']; ?>
" /></td>
</tr>
<?php if ($this->_tpl_vars['avatar']): ?>
<tr>
<td class="c"><p class="userdata"><strong><?php echo $this->_config[0]['vars']['edit_user_avatar']; ?>
</strong></p></td>
<td class="d"><p class="userdata"><img src="<?php echo $this->_tpl_vars['avatar']['image']; ?>
" alt="<?php echo $this->_config[0]['vars']['avatar_img_alt']; ?>
" width="<?php echo $this->_tpl_vars['avatar']['width']; ?>
" height="<?php echo $this->_tpl_vars['avatar']['height']; ?>
" /><br />
<input id="delete_avatar" type="checkbox" name="delete_avatar" value="1"<?php if ($this->_tpl_vars['delete_avatar'] == '1'): ?> checked="checked"<?php endif; ?> /><label for="delete_avatar"><?php echo $this->_config[0]['vars']['delete_avatar']; ?>
</label></p>
</td>
</tr>
<?php endif; ?>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_user_type']; ?>
</strong></td>
<td class="d"><input id="edit_user_type_0" type="radio" name="edit_user_type" value="0"<?php if ($this->_tpl_vars['edit_user_type'] == 0): ?> checked="checked"<?php endif; ?> /><label for="edit_user_type_0"><?php echo $this->_config[0]['vars']['user']; ?>
</label><br /><input id="edit_user_type_1" type="radio" name="edit_user_type" value="1"<?php if ($this->_tpl_vars['edit_user_type'] == 1): ?> checked="checked"<?php endif; ?> /><label for="edit_user_type_1"><?php echo $this->_config[0]['vars']['mod']; ?>
</label><br /><input id="edit_user_type_2" type="radio" name="edit_user_type" value="2"<?php if ($this->_tpl_vars['edit_user_type'] == 2): ?> checked="checked"<?php endif; ?> /><label for="edit_user_type_2"><?php echo $this->_config[0]['vars']['admin']; ?>
</label></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_user_email']; ?>
</strong></td>
<td class="d"><input type="text" size="40" name="user_email" value="<?php echo $this->_tpl_vars['user_email']; ?>
" /><br />
<span class="small"><input id="email_contact" type="checkbox" name="email_contact" value="1"<?php if ($this->_tpl_vars['email_contact'] == 1): ?> checked="checked"<?php endif; ?> /><label for="email_contact"><?php echo $this->_config[0]['vars']['edit_user_email_contact']; ?>
</label></span></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_user_hp']; ?>
</strong></td>
<td class="d"><input type="text" size="40" name="user_hp" value="<?php echo $this->_tpl_vars['user_hp']; ?>
" maxlength="<?php echo $this->_tpl_vars['settings']['hp_maxlength']; ?>
" /></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_user_real_name']; ?>
</strong></td>
<td class="d"><input type="text" size="40" name="user_real_name" value="<?php echo $this->_tpl_vars['user_real_name']; ?>
" maxlength="<?php echo $this->_tpl_vars['settings']['name_maxlength']; ?>
" /></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_user_gender']; ?>
</strong></td>
<td class="d">
<input id="user_gender_1" type="radio" name="user_gender" value="1"<?php if ($this->_tpl_vars['user_gender'] == '1'): ?> checked="checked"<?php endif; ?> /><label for="user_gender_1"><?php echo $this->_config[0]['vars']['male']; ?>
</label><br />
<input id="user_gender_2" type="radio" name="user_gender" value="2"<?php if ($this->_tpl_vars['user_gender'] == '2'): ?> checked="checked"<?php endif; ?> /><label for="user_gender_2"><?php echo $this->_config[0]['vars']['female']; ?>
</label>
</td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_user_birthday']; ?>
</strong></td>
<td class="d"><input type="text" size="40" name="user_birthday" value="<?php echo $this->_tpl_vars['user_birthday']; ?>
" /> <span class="small">(<?php echo $this->_config[0]['vars']['birthday_format']; ?>
)</span></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_user_location']; ?>
</strong></td>
<td class="d"><input type="text" size="40" name="user_location" value="<?php echo $this->_tpl_vars['user_location']; ?>
" maxlength="<?php echo $this->_tpl_vars['settings']['location_maxlength']; ?>
" /></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_user_profile']; ?>
</strong></td>
<td class="d"><textarea cols="65" rows="4" name="profile"><?php echo $this->_tpl_vars['profile']; ?>
</textarea></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_user_signature']; ?>
</strong></td>
<td class="d"><textarea cols="65" rows="4" name="signature"><?php echo $this->_tpl_vars['signature']; ?>
</textarea></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_user_time_diff']; ?>
</strong></td>
<td class="d"><input id="user_time_difference" type="text" size="6" name="user_time_difference" value="<?php echo $this->_tpl_vars['user_time_difference']; ?>
" maxlength="6" /> <span class="small">(<?php echo $this->_config[0]['vars']['edit_user_time_diff_format']; ?>
)</span></td>
</tr>
<?php if ($this->_tpl_vars['edit_user_type'] == 2 || $this->_tpl_vars['edit_user_type'] == 1): ?>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_user_notification']; ?>
</strong></td>
<td class="d"><input id="new_posting_notification" type="checkbox" name="new_posting_notification" value="1"<?php if ($this->_tpl_vars['new_posting_notification'] == '1'): ?> checked="checked"<?php endif; ?> /><label for="new_posting_notification"><?php echo $this->_config[0]['vars']['admin_mod_notif_posting']; ?>
</label><br />
<input id="new_user_notification" type="checkbox" name="new_user_notification" value="1"<?php if ($this->_tpl_vars['new_user_notification'] == '1'): ?> checked="checked"<?php endif; ?> /><label for="new_user_notification"><?php echo $this->_config[0]['vars']['admin_mod_notif_register']; ?>
</label></td>
</tr>
<?php endif; ?>
<tr>
<td class="c">&nbsp;</td>
<td class="d"><input type="submit" name="edit_user_submit" value="<?php echo $this->_config[0]['vars']['userdata_submit_button']; ?>
" /></td>
</tr>
</table>
</div>
</form>
<?php elseif ($this->_tpl_vars['action'] == 'delete_users'): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['caution']; ?>
</p>
<p><?php if ($this->_tpl_vars['selected_users_count'] > 1): ?><?php echo $this->_config[0]['vars']['delete_users_confirmation']; ?>
<?php else: ?><?php echo $this->_config[0]['vars']['delete_user_confirmation']; ?>
<?php endif; ?></p>
<ul>
<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['selected_users']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['nr']['show'] = true;
$this->_sections['nr']['max'] = $this->_sections['nr']['loop'];
$this->_sections['nr']['step'] = 1;
$this->_sections['nr']['start'] = $this->_sections['nr']['step'] > 0 ? 0 : $this->_sections['nr']['loop']-1;
if ($this->_sections['nr']['show']) {
    $this->_sections['nr']['total'] = $this->_sections['nr']['loop'];
    if ($this->_sections['nr']['total'] == 0)
        $this->_sections['nr']['show'] = false;
} else
    $this->_sections['nr']['total'] = 0;
if ($this->_sections['nr']['show']):

            for ($this->_sections['nr']['index'] = $this->_sections['nr']['start'], $this->_sections['nr']['iteration'] = 1;
                 $this->_sections['nr']['iteration'] <= $this->_sections['nr']['total'];
                 $this->_sections['nr']['index'] += $this->_sections['nr']['step'], $this->_sections['nr']['iteration']++):
$this->_sections['nr']['rownum'] = $this->_sections['nr']['iteration'];
$this->_sections['nr']['index_prev'] = $this->_sections['nr']['index'] - $this->_sections['nr']['step'];
$this->_sections['nr']['index_next'] = $this->_sections['nr']['index'] + $this->_sections['nr']['step'];
$this->_sections['nr']['first']      = ($this->_sections['nr']['iteration'] == 1);
$this->_sections['nr']['last']       = ($this->_sections['nr']['iteration'] == $this->_sections['nr']['total']);
?>
<li><a href="index.php?mode=user&amp;show_user=<?php echo $this->_tpl_vars['selected_users'][$this->_sections['nr']['index']]['id']; ?>
"><strong><?php echo $this->_tpl_vars['selected_users'][$this->_sections['nr']['index']]['name']; ?>
</strong></a></li>
<?php endfor; endif; ?>
</ul>
<br />
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['selected_users']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['nr']['show'] = true;
$this->_sections['nr']['max'] = $this->_sections['nr']['loop'];
$this->_sections['nr']['step'] = 1;
$this->_sections['nr']['start'] = $this->_sections['nr']['step'] > 0 ? 0 : $this->_sections['nr']['loop']-1;
if ($this->_sections['nr']['show']) {
    $this->_sections['nr']['total'] = $this->_sections['nr']['loop'];
    if ($this->_sections['nr']['total'] == 0)
        $this->_sections['nr']['show'] = false;
} else
    $this->_sections['nr']['total'] = 0;
if ($this->_sections['nr']['show']):

            for ($this->_sections['nr']['index'] = $this->_sections['nr']['start'], $this->_sections['nr']['iteration'] = 1;
                 $this->_sections['nr']['iteration'] <= $this->_sections['nr']['total'];
                 $this->_sections['nr']['index'] += $this->_sections['nr']['step'], $this->_sections['nr']['iteration']++):
$this->_sections['nr']['rownum'] = $this->_sections['nr']['iteration'];
$this->_sections['nr']['index_prev'] = $this->_sections['nr']['index'] - $this->_sections['nr']['step'];
$this->_sections['nr']['index_next'] = $this->_sections['nr']['index'] + $this->_sections['nr']['step'];
$this->_sections['nr']['first']      = ($this->_sections['nr']['iteration'] == 1);
$this->_sections['nr']['last']       = ($this->_sections['nr']['iteration'] == $this->_sections['nr']['total']);
?>
<input type="hidden" name="selected_confirmed[]" value="<?php echo $this->_tpl_vars['selected_users'][$this->_sections['nr']['index']]['id']; ?>
" />
<?php endfor; endif; ?>
<input type="submit" name="delete_confirmed" value="<?php echo $this->_config[0]['vars']['delete_users_submit']; ?>
" />
</div>
</form>
<?php elseif ($this->_tpl_vars['action'] == 'register'): ?>
<?php if ($this->_tpl_vars['errors']): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['error_headline']; ?>
</p>
<ul>
<?php unset($this->_sections['mysec']);
$this->_sections['mysec']['name'] = 'mysec';
$this->_sections['mysec']['loop'] = is_array($_loop=$this->_tpl_vars['errors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mysec']['show'] = true;
$this->_sections['mysec']['max'] = $this->_sections['mysec']['loop'];
$this->_sections['mysec']['step'] = 1;
$this->_sections['mysec']['start'] = $this->_sections['mysec']['step'] > 0 ? 0 : $this->_sections['mysec']['loop']-1;
if ($this->_sections['mysec']['show']) {
    $this->_sections['mysec']['total'] = $this->_sections['mysec']['loop'];
    if ($this->_sections['mysec']['total'] == 0)
        $this->_sections['mysec']['show'] = false;
} else
    $this->_sections['mysec']['total'] = 0;
if ($this->_sections['mysec']['show']):

            for ($this->_sections['mysec']['index'] = $this->_sections['mysec']['start'], $this->_sections['mysec']['iteration'] = 1;
                 $this->_sections['mysec']['iteration'] <= $this->_sections['mysec']['total'];
                 $this->_sections['mysec']['index'] += $this->_sections['mysec']['step'], $this->_sections['mysec']['iteration']++):
$this->_sections['mysec']['rownum'] = $this->_sections['mysec']['iteration'];
$this->_sections['mysec']['index_prev'] = $this->_sections['mysec']['index'] - $this->_sections['mysec']['step'];
$this->_sections['mysec']['index_next'] = $this->_sections['mysec']['index'] + $this->_sections['mysec']['step'];
$this->_sections['mysec']['first']      = ($this->_sections['mysec']['iteration'] == 1);
$this->_sections['mysec']['last']       = ($this->_sections['mysec']['iteration'] == $this->_sections['mysec']['total']);
?>
<?php $this->assign('error', $this->_tpl_vars['errors'][$this->_sections['mysec']['index']]); ?>
<li><?php echo $this->_config[0]['vars'][$this->_tpl_vars['error']]; ?>
</li>
<?php endfor; endif; ?>
</ul>
<?php endif; ?>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<p><label for="ar_username" class="main"><?php echo $this->_config[0]['vars']['register_username']; ?>
</label><br />
<input id="ar_username" type="text" size="25" name="ar_username" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['ar_username'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
" maxlength="<?php echo $this->_tpl_vars['settings']['name_maxlength']; ?>
" /></p>
<p><label for="ar_email" class="main"><?php echo $this->_config[0]['vars']['register_email']; ?>
</label><br />
<input id="ar_email" type="text" size="25" name="ar_email" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['ar_email'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
" maxlength="<?php echo $this->_tpl_vars['settings']['email_maxlength']; ?>
" /></p>
<p><label for="ar_pw" class="main"><?php echo $this->_config[0]['vars']['register_pw']; ?>
</label><br />
<input id="ar_pw" type="password" size="25" name="ar_pw" maxlength="50" /></p>
<p><label for="ar_pw_conf" class="main"><?php echo $this->_config[0]['vars']['register_pw_conf']; ?>
</label><br />
<input id="ar_pw_conf" type="password" size="25" name="ar_pw_conf" maxlength="50" /></p>
<p><input id="ar_send_userdata" type="checkbox" name="ar_send_userdata" value="true"<?php if ($this->_tpl_vars['ar_send_userdata']): ?> checked="checked"<?php endif; ?> /> <label for="ar_send_userdata"><?php echo $this->_config[0]['vars']['register_send_userdata']; ?>
</label></p>
<p><input type="submit" name="register_submit" value="<?php echo $this->_config[0]['vars']['submit_button_ok']; ?>
" /></p>
</div>
</form>
<p class="small"><?php echo $this->_config[0]['vars']['register_exp']; ?>
</p>
<?php elseif ($this->_tpl_vars['action'] == 'smilies'): ?>
<?php if ($this->_tpl_vars['errors']): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['error_headline']; ?>
</p>
<ul>
<?php unset($this->_sections['mysec']);
$this->_sections['mysec']['name'] = 'mysec';
$this->_sections['mysec']['loop'] = is_array($_loop=$this->_tpl_vars['errors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mysec']['show'] = true;
$this->_sections['mysec']['max'] = $this->_sections['mysec']['loop'];
$this->_sections['mysec']['step'] = 1;
$this->_sections['mysec']['start'] = $this->_sections['mysec']['step'] > 0 ? 0 : $this->_sections['mysec']['loop']-1;
if ($this->_sections['mysec']['show']) {
    $this->_sections['mysec']['total'] = $this->_sections['mysec']['loop'];
    if ($this->_sections['mysec']['total'] == 0)
        $this->_sections['mysec']['show'] = false;
} else
    $this->_sections['mysec']['total'] = 0;
if ($this->_sections['mysec']['show']):

            for ($this->_sections['mysec']['index'] = $this->_sections['mysec']['start'], $this->_sections['mysec']['iteration'] = 1;
                 $this->_sections['mysec']['iteration'] <= $this->_sections['mysec']['total'];
                 $this->_sections['mysec']['index'] += $this->_sections['mysec']['step'], $this->_sections['mysec']['iteration']++):
$this->_sections['mysec']['rownum'] = $this->_sections['mysec']['iteration'];
$this->_sections['mysec']['index_prev'] = $this->_sections['mysec']['index'] - $this->_sections['mysec']['step'];
$this->_sections['mysec']['index_next'] = $this->_sections['mysec']['index'] + $this->_sections['mysec']['step'];
$this->_sections['mysec']['first']      = ($this->_sections['mysec']['iteration'] == 1);
$this->_sections['mysec']['last']       = ($this->_sections['mysec']['iteration'] == $this->_sections['mysec']['total']);
?>
<?php $this->assign('error', $this->_tpl_vars['errors'][$this->_sections['mysec']['index']]); ?>
<li><?php echo $this->_config[0]['vars'][$this->_tpl_vars['error']]; ?>
</li>
<?php endfor; endif; ?>
</ul>
<?php endif; ?>
<?php if ($this->_tpl_vars['settings']['smilies'] == 1): ?>
<table class="normaltab" border="0" cellpadding="5" cellspacing="1">
<thead>
<tr>
<th><?php echo $this->_config[0]['vars']['smiley_image']; ?>
</th>
<th><?php echo $this->_config[0]['vars']['smiley_codes']; ?>
</th>
<th><?php echo $this->_config[0]['vars']['smiley_title']; ?>
</th>
<th>&#160;</th>
</tr>
</thead>
<tbody id="items">
<?php unset($this->_sections['row']);
$this->_sections['row']['name'] = 'row';
$this->_sections['row']['loop'] = is_array($_loop=$this->_tpl_vars['smilies']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['row']['show'] = true;
$this->_sections['row']['max'] = $this->_sections['row']['loop'];
$this->_sections['row']['step'] = 1;
$this->_sections['row']['start'] = $this->_sections['row']['step'] > 0 ? 0 : $this->_sections['row']['loop']-1;
if ($this->_sections['row']['show']) {
    $this->_sections['row']['total'] = $this->_sections['row']['loop'];
    if ($this->_sections['row']['total'] == 0)
        $this->_sections['row']['show'] = false;
} else
    $this->_sections['row']['total'] = 0;
if ($this->_sections['row']['show']):

            for ($this->_sections['row']['index'] = $this->_sections['row']['start'], $this->_sections['row']['iteration'] = 1;
                 $this->_sections['row']['iteration'] <= $this->_sections['row']['total'];
                 $this->_sections['row']['index'] += $this->_sections['row']['step'], $this->_sections['row']['iteration']++):
$this->_sections['row']['rownum'] = $this->_sections['row']['iteration'];
$this->_sections['row']['index_prev'] = $this->_sections['row']['index'] - $this->_sections['row']['step'];
$this->_sections['row']['index_next'] = $this->_sections['row']['index'] + $this->_sections['row']['step'];
$this->_sections['row']['first']      = ($this->_sections['row']['iteration'] == 1);
$this->_sections['row']['last']       = ($this->_sections['row']['iteration'] == $this->_sections['row']['total']);
?>
<tr id="id_<?php echo $this->_tpl_vars['smilies'][$this->_sections['row']['index']]['id']; ?>
">
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><img src="images/smilies/<?php echo $this->_tpl_vars['smilies'][$this->_sections['row']['index']]['file']; ?>
" alt="<?php echo $this->_tpl_vars['smilies'][$this->_sections['row']['index']]['code_1']; ?>
" /></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><?php echo $this->_tpl_vars['smilies'][$this->_sections['row']['index']]['codes']; ?>
</td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><?php echo $this->_tpl_vars['smilies'][$this->_sections['row']['index']]['title']; ?>
</td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b"), $this);?>
"><a href="index.php?mode=admin&amp;edit_smiley=<?php echo $this->_tpl_vars['smilies'][$this->_sections['row']['index']]['id']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/edit.png" title="<?php echo $this->_config[0]['vars']['edit']; ?>
" alt="<?php echo $this->_config[0]['vars']['edit']; ?>
" width="16" height="16" /></a> &nbsp; <a href="index.php?mode=admin&amp;delete_smiley=<?php echo $this->_tpl_vars['smilies'][$this->_sections['row']['index']]['id']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/delete.png" title="<?php echo $this->_config[0]['vars']['delete']; ?>
" alt="<?php echo $this->_config[0]['vars']['delete']; ?>
" width="16" height="16"/></a> &nbsp; <a href="index.php?mode=admin&amp;move_up_smiley=<?php echo $this->_tpl_vars['smilies'][$this->_sections['row']['index']]['id']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/arrow_up.png" alt="<?php echo $this->_config[0]['vars']['move_up']; ?>
" title="<?php echo $this->_config[0]['vars']['move_up']; ?>
" width="16" height="16" /></a><a href="index.php?mode=admin&amp;move_down_smiley=<?php echo $this->_tpl_vars['smilies'][$this->_sections['row']['index']]['id']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/arrow_down.png" alt="<?php echo $this->_config[0]['vars']['move_down']; ?>
" title="<?php echo $this->_config[0]['vars']['move_down']; ?>
" width="16" height="16" /></a></td>
</tr>
<?php endfor; endif; ?>
</tbody>
</table>
<script type="text/javascript">Sortable.create('items', <?php echo '{ tag:\'tr\', onUpdate : updateSmiliesOrder }'; ?>
); addMoveTitle('<?php echo $this->_config[0]['vars']['move_drag_and_drop']; ?>
')</script>
<?php if ($this->_tpl_vars['smiley_files']): ?>
<form action="index.php" method="post" class="normalform" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin">
<table style="margin-top:20px;">
<tr>
<td><label for="add_smiley"><?php echo $this->_config[0]['vars']['add_smiley']; ?>
</label></td>
<td><label for="smiley_code"><?php echo $this->_config[0]['vars']['add_smiley_code']; ?>
</label></td>
<td>&nbsp;</td>
</tr>
<tr>
<td>
<select id="add_smiley" name="add_smiley" size="1">
<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['smiley_files']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['nr']['show'] = true;
$this->_sections['nr']['max'] = $this->_sections['nr']['loop'];
$this->_sections['nr']['step'] = 1;
$this->_sections['nr']['start'] = $this->_sections['nr']['step'] > 0 ? 0 : $this->_sections['nr']['loop']-1;
if ($this->_sections['nr']['show']) {
    $this->_sections['nr']['total'] = $this->_sections['nr']['loop'];
    if ($this->_sections['nr']['total'] == 0)
        $this->_sections['nr']['show'] = false;
} else
    $this->_sections['nr']['total'] = 0;
if ($this->_sections['nr']['show']):

            for ($this->_sections['nr']['index'] = $this->_sections['nr']['start'], $this->_sections['nr']['iteration'] = 1;
                 $this->_sections['nr']['iteration'] <= $this->_sections['nr']['total'];
                 $this->_sections['nr']['index'] += $this->_sections['nr']['step'], $this->_sections['nr']['iteration']++):
$this->_sections['nr']['rownum'] = $this->_sections['nr']['iteration'];
$this->_sections['nr']['index_prev'] = $this->_sections['nr']['index'] - $this->_sections['nr']['step'];
$this->_sections['nr']['index_next'] = $this->_sections['nr']['index'] + $this->_sections['nr']['step'];
$this->_sections['nr']['first']      = ($this->_sections['nr']['iteration'] == 1);
$this->_sections['nr']['last']       = ($this->_sections['nr']['iteration'] == $this->_sections['nr']['total']);
?>
<option value="<?php echo $this->_tpl_vars['smiley_files'][$this->_sections['nr']['index']]; ?>
"><?php echo $this->_tpl_vars['smiley_files'][$this->_sections['nr']['index']]; ?>
</option>
<?php endfor; endif; ?>
</select>
</select></td>
<td><input id="smiley_code" type="text" name="smiley_code" size="10" /></td>
<td><input type="submit" value="<?php echo $this->_config[0]['vars']['submit_button_ok']; ?>
" /></td>
</tr>
</table>
</div>
</form>
<?php else: ?>
<p style="margin-top:20px;"><em><?php echo $this->_config[0]['vars']['no_other_smilies_in_folder']; ?>
</em></p>
<?php endif; ?>
<?php else: ?>
<p><em><?php echo $this->_config[0]['vars']['smilies_disabled']; ?>
</em></p>
<?php endif; ?>
<ul class="adminmenu">
<li><?php if ($this->_tpl_vars['settings']['smilies'] == 1): ?><a href="index.php?mode=admin&amp;disable_smilies=true"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/smilies_disable.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['disable_smilies']; ?>
</span></a><?php else: ?><a href="index.php?mode=admin&amp;enable_smilies=true"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/smilies.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['enable_smilies']; ?>
</span></a><?php endif; ?></li>
</ul>
<?php elseif ($this->_tpl_vars['action'] == 'spam_protection'): ?>
<?php if ($this->_tpl_vars['errors']): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['error_headline']; ?>
</p>
<ul>
<?php unset($this->_sections['mysec']);
$this->_sections['mysec']['name'] = 'mysec';
$this->_sections['mysec']['loop'] = is_array($_loop=$this->_tpl_vars['errors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mysec']['show'] = true;
$this->_sections['mysec']['max'] = $this->_sections['mysec']['loop'];
$this->_sections['mysec']['step'] = 1;
$this->_sections['mysec']['start'] = $this->_sections['mysec']['step'] > 0 ? 0 : $this->_sections['mysec']['loop']-1;
if ($this->_sections['mysec']['show']) {
    $this->_sections['mysec']['total'] = $this->_sections['mysec']['loop'];
    if ($this->_sections['mysec']['total'] == 0)
        $this->_sections['mysec']['show'] = false;
} else
    $this->_sections['mysec']['total'] = 0;
if ($this->_sections['mysec']['show']):

            for ($this->_sections['mysec']['index'] = $this->_sections['mysec']['start'], $this->_sections['mysec']['iteration'] = 1;
                 $this->_sections['mysec']['iteration'] <= $this->_sections['mysec']['total'];
                 $this->_sections['mysec']['index'] += $this->_sections['mysec']['step'], $this->_sections['mysec']['iteration']++):
$this->_sections['mysec']['rownum'] = $this->_sections['mysec']['iteration'];
$this->_sections['mysec']['index_prev'] = $this->_sections['mysec']['index'] - $this->_sections['mysec']['step'];
$this->_sections['mysec']['index_next'] = $this->_sections['mysec']['index'] + $this->_sections['mysec']['step'];
$this->_sections['mysec']['first']      = ($this->_sections['mysec']['iteration'] == 1);
$this->_sections['mysec']['last']       = ($this->_sections['mysec']['iteration'] == $this->_sections['mysec']['total']);
?>
<?php $this->assign('error', $this->_tpl_vars['errors'][$this->_sections['mysec']['index']]); ?>
<li><?php echo $this->_config[0]['vars'][$this->_tpl_vars['error']]; ?>
</li>
<?php endfor; endif; ?>
</ul>
<?php endif; ?>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<table class="normaltab" border="0" cellpadding="5" cellspacing="1">

<tr>
<td class="c" style="width:30%;"><strong><?php echo $this->_config[0]['vars']['captcha']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['captcha_desc']; ?>
<?php if (! $this->_tpl_vars['graphical_captcha_available'] || ! $this->_tpl_vars['font_available']): ?><br /><?php echo $this->_config[0]['vars']['captcha_graphical_desc']; ?>
<?php endif; ?></span></td>
<td class="d">
 <table border="0" cellpadding="0" cellspacing="3">
  <tr>
   <td><strong><?php echo $this->_config[0]['vars']['captcha_posting']; ?>
</strong></td>
   <td><input id="captcha_posting_0" type="radio" name="captcha_posting" value="0"<?php if ($this->_tpl_vars['captcha_posting'] == 0): ?> checked="checked"<?php endif; ?> /><label for="captcha_posting_0"><?php echo $this->_config[0]['vars']['captcha_disabled']; ?>
</label></td>
   <td><input id="captcha_posting_1" type="radio" name="captcha_posting" value="1"<?php if ($this->_tpl_vars['captcha_posting'] == 1): ?> checked="checked"<?php endif; ?> /><label for="captcha_posting_1"><?php echo $this->_config[0]['vars']['captcha_mathematical']; ?>
</label></td>
   <td><input id="captcha_posting_2" type="radio" name="captcha_posting" value="2"<?php if ($this->_tpl_vars['captcha_posting'] == 2): ?> checked="checked"<?php endif; ?><?php if (! $this->_tpl_vars['graphical_captcha_available']): ?> disabled="disabled"<?php endif; ?> /><label for="captcha_posting_2"<?php if (! $this->_tpl_vars['graphical_captcha_available']): ?> class="unavailable"<?php endif; ?>><?php echo $this->_config[0]['vars']['captcha_graphical']; ?>
<?php if (! $this->_tpl_vars['graphical_captcha_available'] || ! $this->_tpl_vars['font_available']): ?><sup>*</sup><?php endif; ?></label></td>
  </tr>
  <tr>
   <td><strong><?php echo $this->_config[0]['vars']['captcha_email']; ?>
</strong></td>
   <td><input id="captcha_email_0" type="radio" name="captcha_email" value="0"<?php if ($this->_tpl_vars['captcha_email'] == 0): ?> checked="checked"<?php endif; ?> /><label for="captcha_email_0"><?php echo $this->_config[0]['vars']['captcha_disabled']; ?>
</label></td>
   <td><input id="captcha_email_1" type="radio" name="captcha_email" value="1"<?php if ($this->_tpl_vars['captcha_email'] == 1): ?> checked="checked"<?php endif; ?> /><label for="captcha_email_1"><?php echo $this->_config[0]['vars']['captcha_mathematical']; ?>
</label></td>
   <td><input id="captcha_email_2" type="radio" name="captcha_email" value="2"<?php if ($this->_tpl_vars['captcha_email'] == 2): ?> checked="checked"<?php endif; ?><?php if (! $this->_tpl_vars['graphical_captcha_available']): ?> disabled="disabled"<?php endif; ?> /><label for="captcha_email_2"<?php if (! $this->_tpl_vars['graphical_captcha_available']): ?> class="unavailable"<?php endif; ?>><?php echo $this->_config[0]['vars']['captcha_graphical']; ?>
<?php if (! $this->_tpl_vars['graphical_captcha_available'] || ! $this->_tpl_vars['font_available']): ?><sup>*</sup><?php endif; ?></label></td>
  </tr>
  <tr>
   <td><strong><?php echo $this->_config[0]['vars']['captcha_register']; ?>
</strong></td>
   <td><input id="captcha_register_0" type="radio" name="captcha_register" value="0"<?php if ($this->_tpl_vars['captcha_register'] == 0): ?> checked="checked"<?php endif; ?> /><label for="captcha_register_0"><?php echo $this->_config[0]['vars']['captcha_disabled']; ?>
</label></td>
   <td><input id="captcha_register_1" type="radio" name="captcha_register" value="1"<?php if ($this->_tpl_vars['captcha_register'] == 1): ?> checked="checked"<?php endif; ?> /><label for="captcha_register_1"><?php echo $this->_config[0]['vars']['captcha_mathematical']; ?>
</label></td>
   <td><input id="captcha_register_2" type="radio" name="captcha_register" value="2"<?php if ($this->_tpl_vars['captcha_register'] == 2): ?> checked="checked"<?php endif; ?><?php if (! $this->_tpl_vars['graphical_captcha_available']): ?> disabled="disabled"<?php endif; ?> /><label for="captcha_register_2"<?php if (! $this->_tpl_vars['graphical_captcha_available']): ?> class="unavailable"<?php endif; ?>><?php echo $this->_config[0]['vars']['captcha_graphical']; ?>
<?php if (! $this->_tpl_vars['graphical_captcha_available'] || ! $this->_tpl_vars['font_available']): ?><sup>*</sup><?php endif; ?></label></td>
  </tr>
 </table>
 <?php if (! $this->_tpl_vars['graphical_captcha_available'] || ! $this->_tpl_vars['font_available']): ?>
 <p class="xsmall"><sup>*</sup> <?php if (! $this->_tpl_vars['graphical_captcha_available']): ?><?php echo $this->_config[0]['vars']['gr_captcha_not_available']; ?>
<?php elseif (! $this->_tpl_vars['font_available']): ?><?php echo $this->_config[0]['vars']['gr_captcha_no_font']; ?>
<?php endif; ?></p>
 <?php endif; ?>
</td>
</tr>

<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['bad_behavior']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['bad_behavior_desc']; ?>
</span></td>
<td class="d"><input id="bad_behavior" type="checkbox" name="bad_behavior" value="1"<?php if ($this->_tpl_vars['bad_behavior'] == 1): ?> checked="checked"<?php endif; ?> /><label for="bad_behavior"><?php echo $this->_config[0]['vars']['bad_behavior_enable']; ?>
</label></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['akismet']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['akismet_desc']; ?>
</span></td>
<td class="d"><p><?php echo $this->_config[0]['vars']['akismet_key']; ?>
<br />
<input type="text" name="akismet_key" value="<?php echo $this->_tpl_vars['akismet_key']; ?>
" size="25" /></p>
<p><input id="akismet_entry_check" type="checkbox" name="akismet_entry_check" value="1"<?php if ($this->_tpl_vars['akismet_entry_check'] == 1): ?> checked="checked"<?php endif; ?> /><label for="akismet_entry_check"><?php echo $this->_config[0]['vars']['akismet_entry']; ?>
</label><br />
<input id="akismet_mail_check" type="checkbox" name="akismet_mail_check" value="1"<?php if ($this->_tpl_vars['akismet_mail_check'] == 1): ?> checked="checked"<?php endif; ?> /><label for="akismet_mail_check"><?php echo $this->_config[0]['vars']['akismet_mail']; ?>
</label></p>
<p><?php echo $this->_config[0]['vars']['akismet_save_spam']; ?>
 <input type="radio" name="save_spam" value="1"<?php if ($this->_tpl_vars['save_spam'] == 1): ?> checked="checked"<?php endif; ?> /><?php echo $this->_config[0]['vars']['yes']; ?>
 <input type="radio" name="save_spam" value="0"<?php if ($this->_tpl_vars['save_spam'] == 0): ?> checked="checked"<?php endif; ?> /><?php echo $this->_config[0]['vars']['no']; ?>
<br />
<?php echo $this->_config[0]['vars']['akismet_auto_delete_spam']; ?>
 <input type="text" name="auto_delete_spam" value="<?php echo $this->_tpl_vars['auto_delete_spam']; ?>
" size="5" /></p></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['not_accepted_words']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['not_accepted_words_desc']; ?>
</span></td>
<td class="d"><textarea name="not_accepted_words" cols="50" rows="5"><?php echo $this->_tpl_vars['not_accepted_words']; ?>
</textarea></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['banned_ips']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['banned_ips_desc']; ?>
</span></td>
<td class="d"><textarea name="banned_ips" cols="50" rows="5"><?php echo $this->_tpl_vars['banned_ips']; ?>
</textarea></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['banned_user_agents']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['banned_user_agents_desc']; ?>
</span></td>
<td class="d"><textarea name="banned_user_agents" cols="50" rows="5"><?php echo $this->_tpl_vars['banned_user_agents']; ?>
</textarea></td>
</tr>
<tr>
<td class="c">&nbsp;</td>
<td class="d"><input type="submit" name="spam_protection_submit" value="<?php echo $this->_config[0]['vars']['spam_protection_submit']; ?>
" /></td>
</tr>
</table>
</div>
</form>
<?php elseif ($this->_tpl_vars['action'] == 'reset_uninstall'): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['caution']; ?>
</p>
<?php if ($this->_tpl_vars['errors']): ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/subtemplates/errors.tpl.inc", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>

<h2><?php echo $this->_config[0]['vars']['reset_forum']; ?>
</h2>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<p><input id="delete_postings" type="checkbox" name="delete_postings" value="true" /><label for="delete_postings"> <?php echo $this->_config[0]['vars']['delete_postings']; ?>
</label></p>
<p><input id="delete_userdata" type="checkbox" name="delete_userdata" value="true" /><label for="delete_userdata"> <?php echo $this->_config[0]['vars']['delete_userdata']; ?>
</label></p>
<p><?php echo $this->_config[0]['vars']['admin_confirm_password']; ?>
<br />
<input type="password" size="20" name="confirm_pw" /> <input type="submit" name="reset_forum_confirmed" value="<?php echo $this->_config[0]['vars']['reset_forum_submit']; ?>
" /></p>
</div>
</form>

<hr style="margin:20px 0px 20px 0px; border-top: 1px dotted #808080; border-left: 0; border-right: 0; border-bottom: 0; height: 1px;"/>

<h2><?php echo $this->_config[0]['vars']['uninstall_forum']; ?>
</h2>
<p><?php echo $this->_config[0]['vars']['uninstall_forum_exp']; ?>
</p>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<p><?php echo $this->_config[0]['vars']['reset_uninstall_conf_pw']; ?>
<br />
<input type="password" size="20" name="confirm_pw" /> <input type="submit" name="uninstall_forum_confirmed" value="<?php echo $this->_config[0]['vars']['uninstall_forum_submit']; ?>
" /></p>
</div>
</form>
<?php elseif ($this->_tpl_vars['action'] == 'backup'): ?>
<?php if ($this->_tpl_vars['errors']): ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/subtemplates/errors.tpl.inc", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>
<?php if ($this->_tpl_vars['message']): ?><p class="ok"><?php echo $this->_config[0]['vars'][$this->_tpl_vars['message']]; ?>
</p><?php endif; ?>
<?php if ($this->_tpl_vars['backup_files']): ?>
<form id="selectform" action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<input type="hidden" name="delete_backup_files_confirm" value="" />
<table class="normaltab" border="0" cellpadding="5" cellspacing="1">
<tr>
<th>&#160;</th>
<th><?php echo $this->_config[0]['vars']['backup_file']; ?>
</th>
<th><?php echo $this->_config[0]['vars']['backup_date']; ?>
</th>
<th><?php echo $this->_config[0]['vars']['backup_size']; ?>
</th>
<th>&#160;</th>
</tr>
<?php $_from = $this->_tpl_vars['backup_files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['file']):
?>
<?php echo smarty_function_cycle(array('assign' => 'class','values' => "a,b"), $this);?>

<tr>
<td class="<?php echo $this->_tpl_vars['class']; ?>
" style="width:10px;"><input type="checkbox" name="delete_backup_files[]" value="<?php echo $this->_tpl_vars['file']['file']; ?>
" /></td>
<td class="<?php echo $this->_tpl_vars['class']; ?>
"><?php echo $this->_tpl_vars['file']['file']; ?>
</td>
<td class="<?php echo $this->_tpl_vars['class']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['file']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['time_format']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['time_format'])); ?>
</td>
<td class="<?php echo $this->_tpl_vars['class']; ?>
"><?php echo $this->_tpl_vars['file']['size']; ?>
</td>
<td class="<?php echo $this->_tpl_vars['class']; ?>
"><a href="index.php?mode=admin&amp;download_backup_file=<?php echo $this->_tpl_vars['file']['file']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/disk.png" title="<?php echo $this->_config[0]['vars']['download_backup_file']; ?>
" alt="<?php echo $this->_config[0]['vars']['download_backup_file']; ?>
" width="16" height="16" /></a> &#160; <a href="index.php?mode=admin&amp;restore=<?php echo $this->_tpl_vars['file']['file']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/restore.png" title="<?php echo $this->_config[0]['vars']['restore']; ?>
" alt="<?php echo $this->_config[0]['vars']['restore']; ?>
" width="16" height="16" /></a> &#160; <a href="index.php?mode=admin&amp;delete_backup_files[]=<?php echo $this->_tpl_vars['file']['file']; ?>
" onclick="return delete_backup_confirm(this, '<?php echo ((is_array($_tmp=$this->_config[0]['vars']['delete_backup_file_confirm'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
')"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/delete.png" title="<?php echo $this->_config[0]['vars']['delete_backup_file']; ?>
" alt="<?php echo $this->_config[0]['vars']['delete_backup_file']; ?>
" width="16" height="16" /></a></td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<div style="margin:5px 0px 0px 7px; padding:0px;"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/selected_arrow.png" alt="" width="35" height="20" /><input type="submit" name="delete_selected_backup_files" value="<?php echo $this->_config[0]['vars']['delete_selected']; ?>
" onclick="return delete_backup_selected_confirm('<?php echo ((is_array($_tmp=$this->_config[0]['vars']['delete_selected_confirm'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
')" /> &#160;<span class="small"><a href="#" onclick="checkall('selectform', 'delete_backup_files[]', true); return false"><?php echo $this->_config[0]['vars']['check_all']; ?>
</a> / <a href="#" onclick="checkall('selectform', 'delete_backup_files[]', false); return false"><?php echo $this->_config[0]['vars']['uncheck_all']; ?>
</a></span></div>
</div>
</form>
<?php else: ?>
<p class="caution"><?php echo $this->_config[0]['vars']['caution']; ?>
</p>
<p><?php echo $this->_config[0]['vars']['backup_note']; ?>
</p>
<!--<p><em>No backup files available.</em></p>-->
<?php endif; ?>
<ul class="adminmenu">
<li><a href="index.php?mode=admin&amp;create_backup=0"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/backup.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['create_backup_complete']; ?>
</span></a></li>
<li><span class="small"><?php echo $this->_config[0]['vars']['only_create_backup_of']; ?>
 <a href="index.php?mode=admin&amp;create_backup=1"><span><?php echo $this->_config[0]['vars']['backup_entries']; ?>
</span></a>, <a href="index.php?mode=admin&amp;create_backup=2"><span><?php echo $this->_config[0]['vars']['backup_userdata']; ?>
</span></a>, <a href="index.php?mode=admin&amp;create_backup=3"><span><?php echo $this->_config[0]['vars']['backup_settings']; ?>
</span></a>, <a href="index.php?mode=admin&amp;create_backup=4"><span><?php echo $this->_config[0]['vars']['backup_categories']; ?>
</span></a>, <a href="index.php?mode=admin&amp;create_backup=5"><span><?php echo $this->_config[0]['vars']['backup_pages']; ?>
</span></a>, <a href="index.php?mode=admin&amp;create_backup=6"><span><?php echo $this->_config[0]['vars']['backup_smilies']; ?>
</span></a>, <a href="index.php?mode=admin&amp;create_backup=7"><span><?php echo $this->_config[0]['vars']['backup_banlists']; ?>
</span></a></span></li>
</ul>
<?php elseif ($this->_tpl_vars['action'] == 'delete_backup_files_confirm'): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['caution']; ?>
</p>
<p><?php if ($this->_tpl_vars['file_number'] == 1): ?><?php echo $this->_config[0]['vars']['delete_backup_file_confirm']; ?>
<?php else: ?><?php echo $this->_config[0]['vars']['delete_backup_files_confirm']; ?>
<?php endif; ?></p>
<ul>
<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['delete_backup_files']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['nr']['show'] = true;
$this->_sections['nr']['max'] = $this->_sections['nr']['loop'];
$this->_sections['nr']['step'] = 1;
$this->_sections['nr']['start'] = $this->_sections['nr']['step'] > 0 ? 0 : $this->_sections['nr']['loop']-1;
if ($this->_sections['nr']['show']) {
    $this->_sections['nr']['total'] = $this->_sections['nr']['loop'];
    if ($this->_sections['nr']['total'] == 0)
        $this->_sections['nr']['show'] = false;
} else
    $this->_sections['nr']['total'] = 0;
if ($this->_sections['nr']['show']):

            for ($this->_sections['nr']['index'] = $this->_sections['nr']['start'], $this->_sections['nr']['iteration'] = 1;
                 $this->_sections['nr']['iteration'] <= $this->_sections['nr']['total'];
                 $this->_sections['nr']['index'] += $this->_sections['nr']['step'], $this->_sections['nr']['iteration']++):
$this->_sections['nr']['rownum'] = $this->_sections['nr']['iteration'];
$this->_sections['nr']['index_prev'] = $this->_sections['nr']['index'] - $this->_sections['nr']['step'];
$this->_sections['nr']['index_next'] = $this->_sections['nr']['index'] + $this->_sections['nr']['step'];
$this->_sections['nr']['first']      = ($this->_sections['nr']['iteration'] == 1);
$this->_sections['nr']['last']       = ($this->_sections['nr']['iteration'] == $this->_sections['nr']['total']);
?>
<li><?php echo $this->_tpl_vars['delete_backup_files'][$this->_sections['nr']['index']]; ?>
</li>
<?php endfor; endif; ?>
</ul>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['delete_backup_files']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['nr']['show'] = true;
$this->_sections['nr']['max'] = $this->_sections['nr']['loop'];
$this->_sections['nr']['step'] = 1;
$this->_sections['nr']['start'] = $this->_sections['nr']['step'] > 0 ? 0 : $this->_sections['nr']['loop']-1;
if ($this->_sections['nr']['show']) {
    $this->_sections['nr']['total'] = $this->_sections['nr']['loop'];
    if ($this->_sections['nr']['total'] == 0)
        $this->_sections['nr']['show'] = false;
} else
    $this->_sections['nr']['total'] = 0;
if ($this->_sections['nr']['show']):

            for ($this->_sections['nr']['index'] = $this->_sections['nr']['start'], $this->_sections['nr']['iteration'] = 1;
                 $this->_sections['nr']['iteration'] <= $this->_sections['nr']['total'];
                 $this->_sections['nr']['index'] += $this->_sections['nr']['step'], $this->_sections['nr']['iteration']++):
$this->_sections['nr']['rownum'] = $this->_sections['nr']['iteration'];
$this->_sections['nr']['index_prev'] = $this->_sections['nr']['index'] - $this->_sections['nr']['step'];
$this->_sections['nr']['index_next'] = $this->_sections['nr']['index'] + $this->_sections['nr']['step'];
$this->_sections['nr']['first']      = ($this->_sections['nr']['iteration'] == 1);
$this->_sections['nr']['last']       = ($this->_sections['nr']['iteration'] == $this->_sections['nr']['total']);
?>
<input type="hidden" name="delete_backup_files[]" value="<?php echo $this->_tpl_vars['delete_backup_files'][$this->_sections['nr']['index']]; ?>
" />
<?php endfor; endif; ?>
<input type="submit" name="delete_backup_files_confirm" value="<?php echo $this->_config[0]['vars']['delete_backup_submit']; ?>
" />
</div>
</form>
<?php elseif ($this->_tpl_vars['action'] == 'restore'): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['caution']; ?>
</p>
<p><?php echo $this->_config[0]['vars']['restore_confirm']; ?>
</p>
<p><strong><?php echo $this->_tpl_vars['backup_file']; ?>
</strong> - <?php echo ((is_array($_tmp=$this->_tpl_vars['backup_file_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['time_format']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['time_format'])); ?>
</p>
<?php if ($this->_tpl_vars['safe_mode_warning']): ?><p class="caution"><?php echo $this->_config[0]['vars']['restore_safe_mode_warning']; ?>
</p>
<p style="color:red;"><?php echo $this->_config[0]['vars']['restore_safe_mode_note']; ?>
</p><?php endif; ?>
<?php if ($this->_tpl_vars['errors']): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['error_headline']; ?>
</p>
<ul>
<?php unset($this->_sections['error']);
$this->_sections['error']['name'] = 'error';
$this->_sections['error']['loop'] = is_array($_loop=$this->_tpl_vars['errors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['error']['show'] = true;
$this->_sections['error']['max'] = $this->_sections['error']['loop'];
$this->_sections['error']['step'] = 1;
$this->_sections['error']['start'] = $this->_sections['error']['step'] > 0 ? 0 : $this->_sections['error']['loop']-1;
if ($this->_sections['error']['show']) {
    $this->_sections['error']['total'] = $this->_sections['error']['loop'];
    if ($this->_sections['error']['total'] == 0)
        $this->_sections['error']['show'] = false;
} else
    $this->_sections['error']['total'] = 0;
if ($this->_sections['error']['show']):

            for ($this->_sections['error']['index'] = $this->_sections['error']['start'], $this->_sections['error']['iteration'] = 1;
                 $this->_sections['error']['iteration'] <= $this->_sections['error']['total'];
                 $this->_sections['error']['index'] += $this->_sections['error']['step'], $this->_sections['error']['iteration']++):
$this->_sections['error']['rownum'] = $this->_sections['error']['iteration'];
$this->_sections['error']['index_prev'] = $this->_sections['error']['index'] - $this->_sections['error']['step'];
$this->_sections['error']['index_next'] = $this->_sections['error']['index'] + $this->_sections['error']['step'];
$this->_sections['error']['first']      = ($this->_sections['error']['iteration'] == 1);
$this->_sections['error']['last']       = ($this->_sections['error']['iteration'] == $this->_sections['error']['total']);
?>
<?php $this->assign('error', $this->_tpl_vars['errors'][$this->_sections['error']['index']]); ?>
<li><?php echo ((is_array($_tmp=$this->_config[0]['vars'][$this->_tpl_vars['error']])) ? $this->_run_mod_handler('replace', true, $_tmp, "[mysql_error]", $this->_tpl_vars['mysql_error']) : smarty_modifier_replace($_tmp, "[mysql_error]", $this->_tpl_vars['mysql_error'])); ?>
</li>
<?php endfor; endif; ?>
</ul>
<?php endif; ?>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<input type="hidden" name="backup_file" value="<?php echo $this->_tpl_vars['backup_file']; ?>
" />
<p><?php echo $this->_config[0]['vars']['admin_confirm_password']; ?>
<br /><input type="password" name="restore_password" size="25"/></p>
<p><input type="submit" name="restore_submit" value="<?php echo $this->_config[0]['vars']['restore_submit']; ?>
" onclick="document.getElementById('throbber-submit').style.visibility = 'visible';" /> <img id="throbber-submit" style="visibility:hidden;" src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/throbber_submit.gif" alt="" width="16" height="16" /></p>
</div>
</form>
<?php elseif ($this->_tpl_vars['action'] == 'update'): ?>
<p style="margin-bottom:25px;"><span style="background:yellow; padding:5px;"><?php echo ((is_array($_tmp=$this->_config[0]['vars']['update_current_version'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[version]", $this->_tpl_vars['settings']['version']) : smarty_modifier_replace($_tmp, "[version]", $this->_tpl_vars['settings']['version'])); ?>
</span></p>

<h3><?php echo $this->_config[0]['vars']['update_instructions_hl']; ?>
</h3>
<ul>
<?php $_from = $this->_config[0]['vars']['update_instructions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['instruction']):
?>
<li><?php echo $this->_tpl_vars['instruction']; ?>
</li>
<?php endforeach; endif; unset($_from); ?>
</ul>

<?php if ($this->_tpl_vars['errors']): ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/subtemplates/errors.tpl.inc", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>
<?php if ($this->_tpl_vars['message']): ?><p class="ok"><?php echo $this->_config[0]['vars'][$this->_tpl_vars['message']]; ?>
</p><?php endif; ?>
<?php if ($this->_tpl_vars['update_files']): ?>
<h3><?php echo $this->_config[0]['vars']['update_available_files']; ?>
</h3>
<ul>
<?php $_from = $this->_tpl_vars['update_files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['file']):
?>
<li><a href="index.php?mode=admin&amp;run_update=<?php echo $this->_tpl_vars['file']['filename']; ?>
" title="<?php echo $this->_config[0]['vars']['update_file_title']; ?>
"><?php echo $this->_tpl_vars['file']['filename']; ?>
</a></li>
<?php endforeach; endif; unset($_from); ?>
</ul>
<?php else: ?>
<p><em><?php echo $this->_config[0]['vars']['update_no_files_available']; ?>
</em></p>
<?php endif; ?>
<?php elseif ($this->_tpl_vars['action'] == 'run_update'): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['caution']; ?>
</p>
<p><?php echo $this->_config[0]['vars']['update_confirm']; ?>
</p>
<p><strong><?php echo $this->_tpl_vars['update_file']; ?>
</strong><?php if ($this->_tpl_vars['update_from_version'] && $this->_tpl_vars['update_to_version']): ?> <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['update_file_details'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[update_from_version]", $this->_tpl_vars['update_from_version']) : smarty_modifier_replace($_tmp, "[update_from_version]", $this->_tpl_vars['update_from_version'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[update_to_version]", $this->_tpl_vars['update_to_version']) : smarty_modifier_replace($_tmp, "[update_to_version]", $this->_tpl_vars['update_to_version'])); ?>
<?php endif; ?></p>
<p style="color:red;font-weight:bold;"><?php echo $this->_config[0]['vars']['update_note']; ?>
</p>
<?php if ($this->_tpl_vars['errors']): ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/subtemplates/errors.tpl.inc", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<input type="hidden" name="update_file_submit" value="<?php echo $this->_tpl_vars['update_file']; ?>
" />
<p><?php echo $this->_config[0]['vars']['admin_confirm_password']; ?>
<br /><input type="password" name="update_password" size="25"/></p>
<p><input type="submit" name="update_submit" value="<?php echo $this->_config[0]['vars']['update_submit']; ?>
" onclick="document.getElementById('throbber-submit').style.visibility = 'visible';" /> <img id="throbber-submit" style="visibility:hidden;" src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/throbber_submit.gif" alt="" width="16" height="16" /></p>
</div>
</form>
<?php elseif ($this->_tpl_vars['action'] == 'update_done'): ?>
<?php if ($this->_tpl_vars['update_errors']): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['error_headline']; ?>
</p>
<ul>
<?php unset($this->_sections['mysec']);
$this->_sections['mysec']['name'] = 'mysec';
$this->_sections['mysec']['loop'] = is_array($_loop=$this->_tpl_vars['update_errors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mysec']['show'] = true;
$this->_sections['mysec']['max'] = $this->_sections['mysec']['loop'];
$this->_sections['mysec']['step'] = 1;
$this->_sections['mysec']['start'] = $this->_sections['mysec']['step'] > 0 ? 0 : $this->_sections['mysec']['loop']-1;
if ($this->_sections['mysec']['show']) {
    $this->_sections['mysec']['total'] = $this->_sections['mysec']['loop'];
    if ($this->_sections['mysec']['total'] == 0)
        $this->_sections['mysec']['show'] = false;
} else
    $this->_sections['mysec']['total'] = 0;
if ($this->_sections['mysec']['show']):

            for ($this->_sections['mysec']['index'] = $this->_sections['mysec']['start'], $this->_sections['mysec']['iteration'] = 1;
                 $this->_sections['mysec']['iteration'] <= $this->_sections['mysec']['total'];
                 $this->_sections['mysec']['index'] += $this->_sections['mysec']['step'], $this->_sections['mysec']['iteration']++):
$this->_sections['mysec']['rownum'] = $this->_sections['mysec']['iteration'];
$this->_sections['mysec']['index_prev'] = $this->_sections['mysec']['index'] - $this->_sections['mysec']['step'];
$this->_sections['mysec']['index_next'] = $this->_sections['mysec']['index'] + $this->_sections['mysec']['step'];
$this->_sections['mysec']['first']      = ($this->_sections['mysec']['iteration'] == 1);
$this->_sections['mysec']['last']       = ($this->_sections['mysec']['iteration'] == $this->_sections['mysec']['total']);
?>
<?php $this->assign('error', $this->_tpl_vars['update_errors'][$this->_sections['mysec']['index']]); ?>
<li><?php echo $this->_tpl_vars['error']; ?>
</li>
<?php endfor; endif; ?>
</ul>
<?php else: ?>
<p class="ok"><?php echo $this->_config[0]['vars']['update_successful']; ?>
</p>
<?php endif; ?>
<?php if ($this->_tpl_vars['update_items']): ?>
<p><?php echo ((is_array($_tmp=$this->_config[0]['vars']['update_items_note'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[version]", $this->_tpl_vars['update_new_version']) : smarty_modifier_replace($_tmp, "[version]", $this->_tpl_vars['update_new_version'])); ?>
</p>
<ul class="filelist">
<?php $_from = $this->_tpl_vars['update_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<li><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/<?php if ($this->_tpl_vars['item']['type'] == 0): ?>folder.png<?php else: ?>file.png<?php endif; ?>" alt="[<?php if ($this->_tpl_vars['item']['type'] == 0): ?><?php echo $this->_config[0]['vars']['folder_alt']; ?>
<?php else: ?><?php echo $this->_config[0]['vars']['file_alt']; ?>
<?php endif; ?>]" width="16" height="16" /><?php echo $this->_tpl_vars['item']['name']; ?>
</li>
<?php endforeach; endif; unset($_from); ?>
</ul>
<?php endif; ?>
<?php if ($this->_tpl_vars['update_download_url']): ?><p class="small"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['update_download'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[[", "<a href=\"".($this->_tpl_vars['update_download_url'])."\">") : smarty_modifier_replace($_tmp, "[[", "<a href=\"".($this->_tpl_vars['update_download_url'])."\">")))) ? $this->_run_mod_handler('replace', true, $_tmp, "]]", "</a>") : smarty_modifier_replace($_tmp, "]]", "</a>")); ?>
</p><?php endif; ?>
<?php if ($this->_tpl_vars['update_message']): ?><?php echo $this->_tpl_vars['update_message']; ?>
<?php endif; ?>
<?php elseif ($this->_tpl_vars['action'] == 'email_list'): ?>
<textarea onfocus="this.select()" onclick="this.select()" readonly="readonly" cols="60" rows="15"><?php echo $this->_tpl_vars['email_list']; ?>
</textarea>
<?php elseif ($this->_tpl_vars['action'] == 'clear_userdata'): ?>
<?php if ($this->_tpl_vars['no_users_in_selection']): ?><p class="caution"><?php echo $this->_config[0]['vars']['no_users_in_selection']; ?>
</p><?php endif; ?>
<?php $this->assign('input_logins', "<input type=\"text\" name=\"logins\" value=\"".($this->_tpl_vars['logins'])."\" size=\"4\" />"); ?>
<?php $this->assign('input_days', "<input type=\"text\" name=\"days\" value=\"".($this->_tpl_vars['days'])."\" size=\"4\" />"); ?>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" /> 
<p><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['clear_userdata_condition'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[logins]", $this->_tpl_vars['input_logins']) : smarty_modifier_replace($_tmp, "[logins]", $this->_tpl_vars['input_logins'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[days]", $this->_tpl_vars['input_days']) : smarty_modifier_replace($_tmp, "[days]", $this->_tpl_vars['input_days'])); ?>
 <input type="submit" name="clear_userdata" value="<?php echo $this->_config[0]['vars']['submit_button_ok']; ?>
" /></p>
</div>
</form>
<p class="small"><?php echo $this->_config[0]['vars']['clear_userdata_note']; ?>
</p>
<?php elseif ($this->_tpl_vars['action'] == 'edit_smiley'): ?>
<?php if ($this->_tpl_vars['errors']): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['error_headline']; ?>
</p>
<ul>
<?php unset($this->_sections['mysec']);
$this->_sections['mysec']['name'] = 'mysec';
$this->_sections['mysec']['loop'] = is_array($_loop=$this->_tpl_vars['errors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mysec']['show'] = true;
$this->_sections['mysec']['max'] = $this->_sections['mysec']['loop'];
$this->_sections['mysec']['step'] = 1;
$this->_sections['mysec']['start'] = $this->_sections['mysec']['step'] > 0 ? 0 : $this->_sections['mysec']['loop']-1;
if ($this->_sections['mysec']['show']) {
    $this->_sections['mysec']['total'] = $this->_sections['mysec']['loop'];
    if ($this->_sections['mysec']['total'] == 0)
        $this->_sections['mysec']['show'] = false;
} else
    $this->_sections['mysec']['total'] = 0;
if ($this->_sections['mysec']['show']):

            for ($this->_sections['mysec']['index'] = $this->_sections['mysec']['start'], $this->_sections['mysec']['iteration'] = 1;
                 $this->_sections['mysec']['iteration'] <= $this->_sections['mysec']['total'];
                 $this->_sections['mysec']['index'] += $this->_sections['mysec']['step'], $this->_sections['mysec']['iteration']++):
$this->_sections['mysec']['rownum'] = $this->_sections['mysec']['iteration'];
$this->_sections['mysec']['index_prev'] = $this->_sections['mysec']['index'] - $this->_sections['mysec']['step'];
$this->_sections['mysec']['index_next'] = $this->_sections['mysec']['index'] + $this->_sections['mysec']['step'];
$this->_sections['mysec']['first']      = ($this->_sections['mysec']['iteration'] == 1);
$this->_sections['mysec']['last']       = ($this->_sections['mysec']['iteration'] == $this->_sections['mysec']['total']);
?>
<?php $this->assign('error', $this->_tpl_vars['errors'][$this->_sections['mysec']['index']]); ?>
<li><?php echo $this->_config[0]['vars'][$this->_tpl_vars['error']]; ?>
</li>
<?php endfor; endif; ?>
</ul>
<?php endif; ?>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" /> 
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" />
<table class="normaltab" border="0" cellpadding="5" cellspacing="1">
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_smilies_smiley']; ?>
</strong></td>
<td class="d"><select name="file" size="1">
<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['smiley_files']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['nr']['show'] = true;
$this->_sections['nr']['max'] = $this->_sections['nr']['loop'];
$this->_sections['nr']['step'] = 1;
$this->_sections['nr']['start'] = $this->_sections['nr']['step'] > 0 ? 0 : $this->_sections['nr']['loop']-1;
if ($this->_sections['nr']['show']) {
    $this->_sections['nr']['total'] = $this->_sections['nr']['loop'];
    if ($this->_sections['nr']['total'] == 0)
        $this->_sections['nr']['show'] = false;
} else
    $this->_sections['nr']['total'] = 0;
if ($this->_sections['nr']['show']):

            for ($this->_sections['nr']['index'] = $this->_sections['nr']['start'], $this->_sections['nr']['iteration'] = 1;
                 $this->_sections['nr']['iteration'] <= $this->_sections['nr']['total'];
                 $this->_sections['nr']['index'] += $this->_sections['nr']['step'], $this->_sections['nr']['iteration']++):
$this->_sections['nr']['rownum'] = $this->_sections['nr']['iteration'];
$this->_sections['nr']['index_prev'] = $this->_sections['nr']['index'] - $this->_sections['nr']['step'];
$this->_sections['nr']['index_next'] = $this->_sections['nr']['index'] + $this->_sections['nr']['step'];
$this->_sections['nr']['first']      = ($this->_sections['nr']['iteration'] == 1);
$this->_sections['nr']['last']       = ($this->_sections['nr']['iteration'] == $this->_sections['nr']['total']);
?>
<option value="<?php echo $this->_tpl_vars['smiley_files'][$this->_sections['nr']['index']]; ?>
"<?php if ($this->_tpl_vars['file'] == $this->_tpl_vars['smiley_files'][$this->_sections['nr']['index']]): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['smiley_files'][$this->_sections['nr']['index']]; ?>
</option>
<?php endfor; endif; ?>
</select></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_smilies_codes']; ?>
</strong></td>
<td class="d"><input type="text" name="code_1" size="7" value="<?php echo $this->_tpl_vars['code_1']; ?>
" /> <input type="text" name="code_2" size="7" value="<?php echo $this->_tpl_vars['code_2']; ?>
" /> <input type="text" name="code_3" size="7" value="<?php echo $this->_tpl_vars['code_3']; ?>
" /> <input type="text" name="code_4" size="7" value="<?php echo $this->_tpl_vars['code_4']; ?>
" /> <input type="text" name="code_5" size="7" value="<?php echo $this->_tpl_vars['code_5']; ?>
" /></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['edit_smilies_title']; ?>
</strong></td>
<td class="d"><input type="text" name="title" size="25" value="<?php echo $this->_tpl_vars['title']; ?>
" /></td>
</tr>
<tr>
<td class="c">&nbsp;</td>
<td class="d"><input type="submit" name="edit_smiley_submit" value="<?php echo $this->_config[0]['vars']['submit_button_ok']; ?>
" /></td>
</tr>
</table>
</div>
</form>
<?php elseif ($this->_tpl_vars['action'] == 'pages'): ?>
<?php if ($this->_tpl_vars['pages']): ?>
<table class="normaltab" cellspacing="1" cellpadding="5">
<thead>
<tr>
<th><?php echo $this->_config[0]['vars']['page_title']; ?>
</th>
<th><?php echo $this->_config[0]['vars']['page_menu_linkname']; ?>
</th>
<th><?php echo $this->_config[0]['vars']['page_access']; ?>
</th>
<th>&#160;</th>
</tr>
</thead>
<tbody id="items">
<?php unset($this->_sections['page']);
$this->_sections['page']['name'] = 'page';
$this->_sections['page']['loop'] = is_array($_loop=$this->_tpl_vars['pages']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['page']['show'] = true;
$this->_sections['page']['max'] = $this->_sections['page']['loop'];
$this->_sections['page']['step'] = 1;
$this->_sections['page']['start'] = $this->_sections['page']['step'] > 0 ? 0 : $this->_sections['page']['loop']-1;
if ($this->_sections['page']['show']) {
    $this->_sections['page']['total'] = $this->_sections['page']['loop'];
    if ($this->_sections['page']['total'] == 0)
        $this->_sections['page']['show'] = false;
} else
    $this->_sections['page']['total'] = 0;
if ($this->_sections['page']['show']):

            for ($this->_sections['page']['index'] = $this->_sections['page']['start'], $this->_sections['page']['iteration'] = 1;
                 $this->_sections['page']['iteration'] <= $this->_sections['page']['total'];
                 $this->_sections['page']['index'] += $this->_sections['page']['step'], $this->_sections['page']['iteration']++):
$this->_sections['page']['rownum'] = $this->_sections['page']['iteration'];
$this->_sections['page']['index_prev'] = $this->_sections['page']['index'] - $this->_sections['page']['step'];
$this->_sections['page']['index_next'] = $this->_sections['page']['index'] + $this->_sections['page']['step'];
$this->_sections['page']['first']      = ($this->_sections['page']['iteration'] == 1);
$this->_sections['page']['last']       = ($this->_sections['page']['iteration'] == $this->_sections['page']['total']);
?>
<tr id="id_<?php echo $this->_tpl_vars['pages'][$this->_sections['page']['index']]['id']; ?>
">
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><a href="index.php?mode=page&amp;id=<?php echo $this->_tpl_vars['pages'][$this->_sections['page']['index']]['id']; ?>
" title="<?php echo $this->_tpl_vars['pages'][$this->_sections['page']['index']]['title']; ?>
"><strong><?php echo $this->_tpl_vars['pages'][$this->_sections['page']['index']]['title']; ?>
</strong></a></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><span class="small"><?php if ($this->_tpl_vars['pages'][$this->_sections['page']['index']]['menu_linkname'] != ''): ?><?php echo $this->_tpl_vars['pages'][$this->_sections['page']['index']]['menu_linkname']; ?>
<?php else: ?>&nbsp;<?php endif; ?></span></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b",'advance' => false), $this);?>
"><span class="small"><?php if ($this->_tpl_vars['pages'][$this->_sections['page']['index']]['access'] == 1): ?><?php echo $this->_config[0]['vars']['page_access_reg_users']; ?>
<?php elseif ($this->_tpl_vars['pages'][$this->_sections['page']['index']]['access'] == 0): ?><?php echo $this->_config[0]['vars']['page_access_public']; ?>
<?php endif; ?></span></td>
<td class="<?php echo smarty_function_cycle(array('values' => "a,b"), $this);?>
"><a href="index.php?mode=admin&amp;edit_page=<?php echo $this->_tpl_vars['pages'][$this->_sections['page']['index']]['id']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/edit.png" title="<?php echo $this->_config[0]['vars']['edit']; ?>
" alt="<?php echo $this->_config[0]['vars']['edit']; ?>
" width="16" height="16" /></a> &#160; <a href="index.php?mode=admin&amp;delete_page=<?php echo $this->_tpl_vars['pages'][$this->_sections['page']['index']]['id']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/delete.png" title="<?php echo $this->_config[0]['vars']['delete']; ?>
" alt="<?php echo $this->_config[0]['vars']['delete']; ?>
" width="16" height="16"/></a> &nbsp; <a href="index.php?mode=admin&amp;move_up_page=<?php echo $this->_tpl_vars['pages'][$this->_sections['page']['index']]['id']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/arrow_up.png" alt="<?php echo $this->_config[0]['vars']['move_up']; ?>
" title="<?php echo $this->_config[0]['vars']['move_up']; ?>
" width="16" height="16" /></a>&nbsp;<a href="index.php?mode=admin&amp;move_down_page=<?php echo $this->_tpl_vars['pages'][$this->_sections['page']['index']]['id']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/arrow_down.png" alt="<?php echo $this->_config[0]['vars']['move_down']; ?>
" title="<?php echo $this->_config[0]['vars']['move_down']; ?>
" width="16" height="16" /></a></td>
</tr>
<?php endfor; endif; ?>
</tbody>
</table>
<script type="text/javascript">Sortable.create('items', <?php echo '{ tag:\'tr\', onUpdate : updatePagesOrder }'; ?>
); addMoveTitle('<?php echo $this->_config[0]['vars']['move_drag_and_drop']; ?>
')</script>
<?php else: ?>
<p><?php echo $this->_config[0]['vars']['no_pages']; ?>
</p>
<?php endif; ?>
<ul class="adminmenu"><li><a href="index.php?mode=admin&amp;action=edit_page"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/add_page.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['add_page_link']; ?>
</span></a></li></ul>
<?php elseif ($this->_tpl_vars['action'] == 'edit_page'): ?>
<?php if ($this->_tpl_vars['errors']): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['error_headline']; ?>
</p>
<ul>
<?php unset($this->_sections['mysec']);
$this->_sections['mysec']['name'] = 'mysec';
$this->_sections['mysec']['loop'] = is_array($_loop=$this->_tpl_vars['errors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mysec']['show'] = true;
$this->_sections['mysec']['max'] = $this->_sections['mysec']['loop'];
$this->_sections['mysec']['step'] = 1;
$this->_sections['mysec']['start'] = $this->_sections['mysec']['step'] > 0 ? 0 : $this->_sections['mysec']['loop']-1;
if ($this->_sections['mysec']['show']) {
    $this->_sections['mysec']['total'] = $this->_sections['mysec']['loop'];
    if ($this->_sections['mysec']['total'] == 0)
        $this->_sections['mysec']['show'] = false;
} else
    $this->_sections['mysec']['total'] = 0;
if ($this->_sections['mysec']['show']):

            for ($this->_sections['mysec']['index'] = $this->_sections['mysec']['start'], $this->_sections['mysec']['iteration'] = 1;
                 $this->_sections['mysec']['iteration'] <= $this->_sections['mysec']['total'];
                 $this->_sections['mysec']['index'] += $this->_sections['mysec']['step'], $this->_sections['mysec']['iteration']++):
$this->_sections['mysec']['rownum'] = $this->_sections['mysec']['iteration'];
$this->_sections['mysec']['index_prev'] = $this->_sections['mysec']['index'] - $this->_sections['mysec']['step'];
$this->_sections['mysec']['index_next'] = $this->_sections['mysec']['index'] + $this->_sections['mysec']['step'];
$this->_sections['mysec']['first']      = ($this->_sections['mysec']['iteration'] == 1);
$this->_sections['mysec']['last']       = ($this->_sections['mysec']['iteration'] == $this->_sections['mysec']['total']);
?>
<?php $this->assign('error', $this->_tpl_vars['errors'][$this->_sections['mysec']['index']]); ?>
<li><?php echo $this->_config[0]['vars'][$this->_tpl_vars['error']]; ?>
</li>
<?php endfor; endif; ?>
</ul>
<?php endif; ?>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<?php if ($this->_tpl_vars['id']): ?><input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" /><?php endif; ?>
<table class="normaltab" border="0" cellpadding="5" cellspacing="1">
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['page_title']; ?>
</strong></td>
<td class="d"><input type="text" name="title" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['title'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
" size="50" /></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['page_content']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['page_content_desc']; ?>
</span></td>
<td class="d"><textarea name="content" cols="70" rows="20"><?php echo ((is_array($_tmp=@$this->_tpl_vars['content'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
</textarea></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['page_menu_linkname']; ?>
</strong><br /><span class="small"><?php echo $this->_config[0]['vars']['page_menu_linkname_desc']; ?>
</span></td>
<td class="d"><input type="text" name="menu_linkname" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['menu_linkname'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
" size="50" /></td>
</tr>
<tr>
<td class="c"><strong><?php echo $this->_config[0]['vars']['page_access']; ?>
</strong></td>
<td class="d"><input type="radio" name="access" value="0"<?php if ($this->_tpl_vars['access'] == 0): ?> checked="checked"<?php endif; ?> /><span class="small"><?php echo $this->_config[0]['vars']['page_access_public']; ?>
</span> <input type="radio" name="access" value="1"<?php if ($this->_tpl_vars['access'] == 1): ?> checked="checked"<?php endif; ?> /><span class="small"><?php echo $this->_config[0]['vars']['page_access_reg_users']; ?>
</span></td>
</tr>

<tr>
<td class="c">&nbsp;</td>
<td class="d"><input type="submit" name="edit_page_submit" value="<?php echo $this->_config[0]['vars']['edit_page_submit']; ?>
" /></td>
</tr>
</table>
</div>
</form>
<?php elseif ($this->_tpl_vars['action'] == 'delete_page'): ?>
<?php if ($this->_tpl_vars['page']): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['caution']; ?>
</p>
<p><?php echo $this->_config[0]['vars']['delete_page_confirm']; ?>
</p>
<p><strong><?php echo $this->_tpl_vars['page']['title']; ?>
</strong></p>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="admin" />
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['page']['id']; ?>
" />
<input type="submit" name="delete_page_submit" value="<?php echo $this->_config[0]['vars']['delete_page_submit']; ?>
" />
</div>
</form>
<?php else: ?>
<p><?php echo $this->_config[0]['vars']['page_doesnt_exist']; ?>
</p>
<?php endif; ?>
<?php else: ?>
<ul class="adminmenu">
<li><a href="index.php?mode=admin&amp;action=settings"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/settings.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['forum_settings_link']; ?>
</span></a></li>
<li><a href="index.php?mode=admin&amp;action=categories"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/categories.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['category_administr_link']; ?>
</span></a></li>
<li><a href="index.php?mode=admin&amp;action=user"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/user.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['user_administr_link']; ?>
</span></a></li>
<li><a href="index.php?mode=admin&amp;action=smilies"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/smilies.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['smilies_administr_link']; ?>
</span></a></li>
<li><a href="index.php?mode=admin&amp;action=pages"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/pages.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['pages_administr_link']; ?>
</span></a></li>
<li><a href="index.php?mode=admin&amp;action=spam_protection"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/spam_protection.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['spam_protection_link']; ?>
</span></a></li>
<li><a href="index.php?mode=admin&amp;action=backup"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/backup.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['backup_restore_link']; ?>
</span></a></li>
<li><a href="index.php?mode=admin&amp;action=update"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/update.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['update_link']; ?>
</span></a></li>
<li><a href="index.php?mode=admin&amp;action=reset_uninstall"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/delete.png" alt="" width="16" height="16" /><span><?php echo $this->_config[0]['vars']['reset_uninstall_link']; ?>
</span></a></li>
</ul>
<?php endif; ?>