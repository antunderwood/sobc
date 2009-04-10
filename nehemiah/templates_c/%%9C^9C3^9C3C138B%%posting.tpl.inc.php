<?php /* Smarty version 2.6.22, created on 2009-03-03 00:24:22
         compiled from default/subtemplates/posting.tpl.inc */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'default/subtemplates/posting.tpl.inc', 1, false),array('modifier', 'replace', 'default/subtemplates/posting.tpl.inc', 5, false),array('modifier', 'escape', 'default/subtemplates/posting.tpl.inc', 13, false),array('modifier', 'default', 'default/subtemplates/posting.tpl.inc', 98, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['settings']['language_file'],'section' => 'posting'), $this);?>

<?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['settings']['language_file'],'section' => 'thread_entry'), $this);?>

<?php if ($this->_tpl_vars['captcha']): ?><?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['settings']['language_file'],'section' => 'captcha'), $this);?>
<?php endif; ?>
<?php if ($this->_tpl_vars['no_authorisation']): ?>
<p class="caution"><?php echo ((is_array($_tmp=$this->_config[0]['vars'][$this->_tpl_vars['no_authorisation']])) ? $this->_run_mod_handler('replace', true, $_tmp, "[minutes]", $this->_tpl_vars['settings']['edit_period']) : smarty_modifier_replace($_tmp, "[minutes]", $this->_tpl_vars['settings']['edit_period'])); ?>
</p>
<?php if ($this->_tpl_vars['text']): ?>
<textarea onfocus="this.select()" onclick="this.select()" readonly="readonly" cols="80" rows="21" name="text"><?php echo $this->_tpl_vars['text']; ?>
</textarea>
<?php endif; ?>
<?php else: ?>
<h1><?php if ($this->_tpl_vars['posting_mode'] == 0 && $this->_tpl_vars['id'] == 0): ?><?php echo $this->_config[0]['vars']['new_topic_hl']; ?>
<?php elseif ($this->_tpl_vars['posting_mode'] == 0 && $this->_tpl_vars['id'] > 0): ?><?php echo $this->_config[0]['vars']['reply_hl']; ?>
<?php elseif ($this->_tpl_vars['posting_mode'] == 1): ?><?php echo $this->_config[0]['vars']['edit_hl']; ?>
<?php endif; ?></h1>
<?php if ($this->_tpl_vars['posting_mode'] == 0 && $this->_tpl_vars['id'] > 0 && $this->_tpl_vars['name_repl_subnav']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/subtemplates/ajax_preview.tpl.inc", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<p class="reply-to"><?php echo ((is_array($_tmp=$this->_config[0]['vars']['reply_to_posting_marking'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[name]", $this->_tpl_vars['name_repl_subnav']) : smarty_modifier_replace($_tmp, "[name]", $this->_tpl_vars['name_repl_subnav'])); ?>
<script type="text/javascript">/* <![CDATA[ */document.write(' <a href="#" onclick="ajax_preview(<?php echo $this->_tpl_vars['id']; ?>
); return false" title="<?php echo ((is_array($_tmp=$this->_config[0]['vars']['ajax_preview_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/ajax_preview.png" alt="<?php echo ((is_array($_tmp=$this->_config[0]['vars']['ajax_preview_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
" width="11" height="11" /><\/a>')/* ]]> */</script></p>
<?php endif; ?>

<?php if ($this->_tpl_vars['errors']): ?>
<p class="caution"><?php echo $this->_config[0]['vars']['error_headline']; ?>
</p>
<ul style="margin-bottom:25px;">
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
<li><?php $this->assign('error', $this->_tpl_vars['errors'][$this->_sections['mysec']['index']]); ?><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars'][$this->_tpl_vars['error']])) ? $this->_run_mod_handler('replace', true, $_tmp, "[text_length]", $this->_tpl_vars['text_length']) : smarty_modifier_replace($_tmp, "[text_length]", $this->_tpl_vars['text_length'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[text_maxlength]", $this->_tpl_vars['settings']['text_maxlength']) : smarty_modifier_replace($_tmp, "[text_maxlength]", $this->_tpl_vars['settings']['text_maxlength'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[word]", $this->_tpl_vars['word']) : smarty_modifier_replace($_tmp, "[word]", $this->_tpl_vars['word'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[minutes]", $this->_tpl_vars['minutes']) : smarty_modifier_replace($_tmp, "[minutes]", $this->_tpl_vars['minutes'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[not_accepted_word]", $this->_tpl_vars['not_accepted_word']) : smarty_modifier_replace($_tmp, "[not_accepted_word]", $this->_tpl_vars['not_accepted_word'])); ?>
</li>
<?php endfor; endif; ?>
</ul>
<?php elseif (isset ( $this->_tpl_vars['minutes_left_to_edit'] )): ?>
<p class="caution"><?php if ($this->_tpl_vars['settings']['user_edit_if_no_replies'] == 1): ?><?php echo ((is_array($_tmp=$this->_config[0]['vars']['minutes_left_to_edit_reply'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[minutes]", $this->_tpl_vars['minutes_left_to_edit']) : smarty_modifier_replace($_tmp, "[minutes]", $this->_tpl_vars['minutes_left_to_edit'])); ?>
<?php else: ?><?php echo ((is_array($_tmp=$this->_config[0]['vars']['minutes_left_to_edit'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[minutes]", $this->_tpl_vars['minutes_left_to_edit']) : smarty_modifier_replace($_tmp, "[minutes]", $this->_tpl_vars['minutes_left_to_edit'])); ?>
<?php endif; ?></p>
<?php endif; ?>

<?php if ($this->_tpl_vars['preview']): ?>
<?php $this->assign('template', $this->_tpl_vars['settings']['template']); ?>
<?php if ($this->_tpl_vars['preview_hp'] && ! $this->_tpl_vars['email']): ?>
<?php $this->assign('email_hp', " <a href=\"".($this->_tpl_vars['preview_hp'])."\"><img src=\"templates/".($this->_tpl_vars['template'])."/images/homepage.png\" alt=\"".($this->_tpl_vars['homepage_alt'])."\" width=\"13\" height=\"13\"></a>"); ?>
<?php elseif (! $this->_tpl_vars['preview_hp'] && $this->_tpl_vars['email']): ?>
<?php $this->assign('email_hp', " <a href=\"index.php?mode=contact&amp;id=".($this->_tpl_vars['id'])."\"><img src=\"templates/".($this->_tpl_vars['template'])."/images/email.png\" alt=\"".($this->_tpl_vars['email_alt'])."\" width=\"13\" height=\"10\"></a>"); ?>
<?php elseif ($this->_tpl_vars['preview_hp'] && $this->_tpl_vars['email']): ?>
<?php $this->assign('email_hp', " <a href=\"".($this->_tpl_vars['preview_hp'])."\"><img src=\"templates/".($this->_tpl_vars['template'])."/images/homepage.png\" alt=\"".($this->_tpl_vars['homepage_alt'])."\" width=\"13\" height=\"13\"></a> <a href=\"index.php?mode=contact&amp;id=".($this->_tpl_vars['id'])."\"><img src=\"templates/".($this->_tpl_vars['template'])."/images/email.png\" alt=\"".($this->_tpl_vars['email_alt'])."\" width=\"13\" height=\"10\"></a>"); ?>
<?php else: ?>
<?php $this->assign('email_hp', ""); ?>
<?php endif; ?>
<h3 class="preview"><?php echo $this->_config[0]['vars']['preview_headline']; ?>
</h3>
<div class="preview">
<div class="posting">
<h1 class="postingheadline"><?php echo $this->_tpl_vars['preview_subject']; ?>
<?php if ($this->_tpl_vars['category_name']): ?> <span class="category">(<?php echo $this->_tpl_vars['category_name']; ?>
)</span><?php endif; ?></h1>
<p class="author"><?php if ($this->_tpl_vars['preview_location']): ?><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['posted_by_location'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[name]", $this->_tpl_vars['preview_name']) : smarty_modifier_replace($_tmp, "[name]", $this->_tpl_vars['preview_name'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[email_hp]", $this->_tpl_vars['email_hp']) : smarty_modifier_replace($_tmp, "[email_hp]", $this->_tpl_vars['email_hp'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[location]", $this->_tpl_vars['preview_location']) : smarty_modifier_replace($_tmp, "[location]", $this->_tpl_vars['preview_location'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[time]", $this->_tpl_vars['preview_formated_time']) : smarty_modifier_replace($_tmp, "[time]", $this->_tpl_vars['preview_formated_time'])); ?>
<?php else: ?><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['posted_by'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[name]", $this->_tpl_vars['preview_name']) : smarty_modifier_replace($_tmp, "[name]", $this->_tpl_vars['preview_name'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[email_hp]", $this->_tpl_vars['email_hp']) : smarty_modifier_replace($_tmp, "[email_hp]", $this->_tpl_vars['email_hp'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[time]", $this->_tpl_vars['preview_formated_time']) : smarty_modifier_replace($_tmp, "[time]", $this->_tpl_vars['preview_formated_time'])); ?>
<?php endif; ?></p>
<?php if ($this->_tpl_vars['preview_text']): ?><?php echo $this->_tpl_vars['preview_text']; ?>
<?php else: ?><p><?php echo $this->_config[0]['vars']['no_text']; ?>
</p><?php endif; ?>
<?php if ($this->_tpl_vars['preview_signature'] && $this->_tpl_vars['show_signature'] == 1): ?>
<p class="signature">---<br />
<?php echo $this->_tpl_vars['preview_signature']; ?>
</p>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
<form action="index.php" method="post" id="postingform" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="back" value="<?php echo $this->_tpl_vars['back']; ?>
" />
<input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['mode']; ?>
" />
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" />
<input type="hidden" name="uniqid" value="<?php echo $this->_tpl_vars['uniqid']; ?>
" />
<input type="hidden" name="posting_mode" value="<?php echo $this->_tpl_vars['posting_mode']; ?>
" />
<?php if ($this->_tpl_vars['session']): ?><input type="hidden" name="<?php echo $this->_tpl_vars['session']['name']; ?>
" value="<?php echo $this->_tpl_vars['session']['id']; ?>
" /><?php endif; ?>

<table border="0" cellpadding="0" cellspacing="5">
<?php if ($this->_tpl_vars['form_type'] == 0): ?>
<tr>
<td><label for="name" class="main"><?php echo $this->_config[0]['vars']['name_marking']; ?>
</label></td><td><input id="name" type="text" size="40" name="name" value="<?php if ($this->_tpl_vars['name']): ?><?php echo $this->_tpl_vars['name']; ?>
<?php endif; ?>" maxlength="<?php echo $this->_tpl_vars['settings']['username_maxlength']; ?>
"  tabindex="1" /></td>
</tr>
<tr>
<td><label for="email" class="main"><?php echo $this->_config[0]['vars']['email_marking']; ?>
</label></td><td><input id="email" type="text" size="40" name="email" value="<?php if ($this->_tpl_vars['email']): ?><?php echo $this->_tpl_vars['email']; ?>
<?php endif; ?>" maxlength="<?php echo $this->_tpl_vars['settings']['email_maxlength']; ?>
" tabindex="2" />&nbsp;<span class="xsmall"><?php echo $this->_config[0]['vars']['optional_email']; ?>
</span></td>
</tr>
<tr>
<td><label for="hp" class="main"><?php echo $this->_config[0]['vars']['hp_marking']; ?>
</label></td><td><input id="hp" type="text" size="40" name="hp" value="<?php if ($this->_tpl_vars['hp']): ?><?php echo $this->_tpl_vars['hp']; ?>
<?php endif; ?>" maxlength="<?php echo $this->_tpl_vars['settings']['hp_maxlength']; ?>
" tabindex="3" />&nbsp;<span class="xsmall"><?php echo $this->_config[0]['vars']['optional']; ?>
</span></td>
</tr>
<tr>
<td><label for="location" class="main"><?php echo $this->_config[0]['vars']['location_marking']; ?>
</label></td><td><input id="location" type="text" size="40" name="location" value="<?php if ($this->_tpl_vars['location']): ?><?php echo $this->_tpl_vars['location']; ?>
<?php endif; ?>" maxlength="<?php echo $this->_tpl_vars['settings']['location_maxlength']; ?>
" tabindex="4" />&nbsp;<span class="xsmall"><?php echo $this->_config[0]['vars']['optional']; ?>
</span></td>
</tr>
<?php if ($this->_tpl_vars['settings']['remember_userdata'] == 1 && $this->_tpl_vars['posting_mode'] == 0 && ! $this->_tpl_vars['user']): ?>
<tr>
<td>&nbsp;</td><td><input id="setcookie" type="checkbox" name="setcookie" value="1"<?php if ($this->_tpl_vars['setcookie']): ?> checked="checked"<?php endif; ?> />&nbsp;<label for="setcookie"><span class="small"><?php echo $this->_config[0]['vars']['remember_userdata_marking']; ?>
</span></label><?php if ($this->_tpl_vars['cookie']): ?> &nbsp;<span id="delete_cookie"><a href="index.php?mode=delete_cookie" onclick="delete_cookie('<?php echo ((is_array($_tmp=$this->_config[0]['vars']['deleting_cookie'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
'); return false;" ><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/delete_small.png" alt="" width="12" height="9" /><?php echo $this->_config[0]['vars']['delete_cookie_linkname']; ?>
</a></span><?php endif; ?></td>
</tr>
<?php endif; ?>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['categories']): ?>
<tr>
<td><label for="p_category" class="main"><?php echo $this->_config[0]['vars']['category_marking']; ?>
</label></td>
<td><select id="p_category" size="1" name="p_category" tabindex="5"<?php if ($this->_tpl_vars['posting_mode'] == 0 && $this->_tpl_vars['id'] > 0 || $this->_tpl_vars['posting_mode'] == 1 && $this->_tpl_vars['pid'] > 0): ?> disabled="disabled"<?php endif; ?>>
<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
<?php if ($this->_tpl_vars['key'] != 0): ?><option value="<?php echo $this->_tpl_vars['key']; ?>
"<?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['p_category']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['val']; ?>
</option><?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</select></td>
</tr>
<?php endif; ?>
<tr>
<td><label for="subject" class="main"><?php echo $this->_config[0]['vars']['subject_marking']; ?>
</label></td><td><input id="subject" type="text" size="50" name="subject" value="<?php if ($this->_tpl_vars['subject']): ?><?php echo $this->_tpl_vars['subject']; ?>
<?php endif; ?>" maxlength="<?php echo $this->_tpl_vars['settings']['subject_maxlength']; ?>
" tabindex="6" /></td>
</tr>
<?php if (( $this->_tpl_vars['admin'] || $this->_tpl_vars['mod'] ) && $this->_tpl_vars['settings']['tags'] > 0): ?>
<tr>
<td><label for="tags" class="main"><?php echo $this->_config[0]['vars']['tags_marking']; ?>
</label></td><td><input id="tags" type="text" size="50" name="tags" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['tags'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
" maxlength="253" />&nbsp;<span class="xsmall"><?php echo $this->_config[0]['vars']['tags_note']; ?>
</span></td>
</tr>
<?php endif; ?>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td colspan="2"><label for="text" class="main"><?php echo $this->_config[0]['vars']['message_marking']; ?>
</label><?php if ($this->_tpl_vars['hide_quote']): ?> &nbsp;<span class="small"><a href="#" onclick="insert_quote(); return false" id="insert_quote_link" style="visibility:hidden;"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/quote_message.png" alt="" width="14" height="9" /><?php echo $this->_config[0]['vars']['quote_message']; ?>
</a></span><?php endif; ?><!--<?php if ($this->_tpl_vars['id'] != 0 && $this->_tpl_vars['action'] == 'posting'): ?> &nbsp;<span class="small"><a href="#" onclick="clear_input('postingform','text'); return false"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/delete_small.png" alt="" width="13" height="9"><?php echo $this->_config[0]['vars']['clear_textarea']; ?>
</a></span><?php endif; ?>--></td>
</tr>
<tr>
<td colspan="2">
<table class="normal" border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign="top">
<textarea id="text" cols="80" rows="21" name="text" tabindex="7"><?php if ($this->_tpl_vars['text']): ?><?php echo $this->_tpl_vars['text']; ?>
<?php endif; ?></textarea><?php if ($this->_tpl_vars['hide_quote']): ?><script type="text/javascript">/* <![CDATA[ */ hide_quote(); /* ]]> */</script><?php endif; ?></td><td valign="top" style="padding: 0px 0px 0px 5px;">
<div id="jsbuttons" style="display:none;">
<?php if ($this->_tpl_vars['settings']['bbcode']): ?>
<input class="bbcode-button" style="font-weight: bold;" type="button" name="bold" value="<?php echo $this->_config[0]['vars']['bbcode_bold_marking']; ?>
" title="<?php echo $this->_config[0]['vars']['bbcode_bold_title']; ?>
" onclick="bbcode('text','b');" /><br />
<input class="bbcode-button" style="font-style: italic;" type="button" name="italic" value="<?php echo $this->_config[0]['vars']['bbcode_italic_marking']; ?>
" title="<?php echo $this->_config[0]['vars']['bbcode_italic_title']; ?>
" onclick="bbcode('text','i');" /><br />
<input class="bbcode-button" style="color: #0000ff; text-decoration: underline;" type="button" name="link" value="<?php echo $this->_config[0]['vars']['bbcode_link_marking']; ?>
" title="<?php echo $this->_config[0]['vars']['bbcode_link_title']; ?>
" onclick="insert_link('text','<?php echo ((is_array($_tmp=$this->_config[0]['vars']['bbcode_link_linktext'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
','<?php echo ((is_array($_tmp=$this->_config[0]['vars']['bbcode_link_url'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
');" /><br />
<?php if ($this->_tpl_vars['settings']['bbcode_color']): ?><input class="bbcode-button" style="color: red;" type="button" name="color" value="<?php echo $this->_config[0]['vars']['bbcode_color']; ?>
" title="<?php echo $this->_config[0]['vars']['bbcode_color_title']; ?>
" onclick="show_box('colorpicker',30,-30);" /><br /><?php endif; ?>
<?php if ($this->_tpl_vars['settings']['bbcode_size']): ?><input class="bbcode-button" type="button" name="size" value="<?php echo $this->_config[0]['vars']['bbcode_font_size']; ?>
" title="<?php echo $this->_config[0]['vars']['bbcode_font_size_title']; ?>
" onclick="show_box('sizepicker',30,-20);" /><br /><?php endif; ?>
<input class="bbcode-button" type="button" name="list" value="<?php echo $this->_config[0]['vars']['bbcode_list_marking']; ?>
" title="<?php echo $this->_config[0]['vars']['bbcode_list_title']; ?>
" onclick="insert('text','[list]\n[*]...\n[*]...\n[/list]');" /><br />
<?php if ($this->_tpl_vars['settings']['bbcode_img']): ?><input class="bbcode-button" type="button" name="image" value="<?php echo $this->_config[0]['vars']['bbcode_image_marking']; ?>
" title="<?php echo $this->_config[0]['vars']['bbcode_image_title']; ?>
" onclick="insert_image('text','<?php echo ((is_array($_tmp=$this->_config[0]['vars']['bbcode_image_url'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
');" /><br /><?php endif; ?>
<?php if ($this->_tpl_vars['upload_images']): ?><input class="bbcode-button" type="button" name="imgupload" value="<?php echo $this->_config[0]['vars']['upload_image_marking']; ?>
" title="<?php echo $this->_config[0]['vars']['upload_image_title']; ?>
" onclick="popup('index.php?mode=upload_image');" /><br /><?php endif; ?><br />
<?php endif; ?>
<?php if ($this->_tpl_vars['settings']['smilies'] == 1 && $this->_tpl_vars['smilies']): ?>
<?php unset($this->_sections['smiley']);
$this->_sections['smiley']['name'] = 'smiley';
$this->_sections['smiley']['start'] = (int)0;
$this->_sections['smiley']['step'] = ((int)2) == 0 ? 1 : (int)2;
$this->_sections['smiley']['max'] = (int)'3';
$this->_sections['smiley']['loop'] = is_array($_loop=$this->_tpl_vars['smilies']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['smiley']['show'] = true;
if ($this->_sections['smiley']['max'] < 0)
    $this->_sections['smiley']['max'] = $this->_sections['smiley']['loop'];
if ($this->_sections['smiley']['start'] < 0)
    $this->_sections['smiley']['start'] = max($this->_sections['smiley']['step'] > 0 ? 0 : -1, $this->_sections['smiley']['loop'] + $this->_sections['smiley']['start']);
else
    $this->_sections['smiley']['start'] = min($this->_sections['smiley']['start'], $this->_sections['smiley']['step'] > 0 ? $this->_sections['smiley']['loop'] : $this->_sections['smiley']['loop']-1);
if ($this->_sections['smiley']['show']) {
    $this->_sections['smiley']['total'] = min(ceil(($this->_sections['smiley']['step'] > 0 ? $this->_sections['smiley']['loop'] - $this->_sections['smiley']['start'] : $this->_sections['smiley']['start']+1)/abs($this->_sections['smiley']['step'])), $this->_sections['smiley']['max']);
    if ($this->_sections['smiley']['total'] == 0)
        $this->_sections['smiley']['show'] = false;
} else
    $this->_sections['smiley']['total'] = 0;
if ($this->_sections['smiley']['show']):

            for ($this->_sections['smiley']['index'] = $this->_sections['smiley']['start'], $this->_sections['smiley']['iteration'] = 1;
                 $this->_sections['smiley']['iteration'] <= $this->_sections['smiley']['total'];
                 $this->_sections['smiley']['index'] += $this->_sections['smiley']['step'], $this->_sections['smiley']['iteration']++):
$this->_sections['smiley']['rownum'] = $this->_sections['smiley']['iteration'];
$this->_sections['smiley']['index_prev'] = $this->_sections['smiley']['index'] - $this->_sections['smiley']['step'];
$this->_sections['smiley']['index_next'] = $this->_sections['smiley']['index'] + $this->_sections['smiley']['step'];
$this->_sections['smiley']['first']      = ($this->_sections['smiley']['iteration'] == 1);
$this->_sections['smiley']['last']       = ($this->_sections['smiley']['iteration'] == $this->_sections['smiley']['total']);
?>
<?php unset($this->_sections['smiley_row']);
$this->_sections['smiley_row']['name'] = 'smiley_row';
$this->_sections['smiley_row']['start'] = (int)$this->_sections['smiley']['index'];
$this->_sections['smiley_row']['loop'] = is_array($_loop=$this->_sections['smiley']['index']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['smiley_row']['show'] = true;
$this->_sections['smiley_row']['max'] = $this->_sections['smiley_row']['loop'];
$this->_sections['smiley_row']['step'] = 1;
if ($this->_sections['smiley_row']['start'] < 0)
    $this->_sections['smiley_row']['start'] = max($this->_sections['smiley_row']['step'] > 0 ? 0 : -1, $this->_sections['smiley_row']['loop'] + $this->_sections['smiley_row']['start']);
else
    $this->_sections['smiley_row']['start'] = min($this->_sections['smiley_row']['start'], $this->_sections['smiley_row']['step'] > 0 ? $this->_sections['smiley_row']['loop'] : $this->_sections['smiley_row']['loop']-1);
if ($this->_sections['smiley_row']['show']) {
    $this->_sections['smiley_row']['total'] = min(ceil(($this->_sections['smiley_row']['step'] > 0 ? $this->_sections['smiley_row']['loop'] - $this->_sections['smiley_row']['start'] : $this->_sections['smiley_row']['start']+1)/abs($this->_sections['smiley_row']['step'])), $this->_sections['smiley_row']['max']);
    if ($this->_sections['smiley_row']['total'] == 0)
        $this->_sections['smiley_row']['show'] = false;
} else
    $this->_sections['smiley_row']['total'] = 0;
if ($this->_sections['smiley_row']['show']):

            for ($this->_sections['smiley_row']['index'] = $this->_sections['smiley_row']['start'], $this->_sections['smiley_row']['iteration'] = 1;
                 $this->_sections['smiley_row']['iteration'] <= $this->_sections['smiley_row']['total'];
                 $this->_sections['smiley_row']['index'] += $this->_sections['smiley_row']['step'], $this->_sections['smiley_row']['iteration']++):
$this->_sections['smiley_row']['rownum'] = $this->_sections['smiley_row']['iteration'];
$this->_sections['smiley_row']['index_prev'] = $this->_sections['smiley_row']['index'] - $this->_sections['smiley_row']['step'];
$this->_sections['smiley_row']['index_next'] = $this->_sections['smiley_row']['index'] + $this->_sections['smiley_row']['step'];
$this->_sections['smiley_row']['first']      = ($this->_sections['smiley_row']['iteration'] == 1);
$this->_sections['smiley_row']['last']       = ($this->_sections['smiley_row']['iteration'] == $this->_sections['smiley_row']['total']);
?>
<?php if ($this->_tpl_vars['smilies'][$this->_sections['smiley_row']['index']]['file']): ?><button class="smiley-button" name="smiley" type="button" value="<?php echo $this->_tpl_vars['smilies'][$this->_sections['smiley_row']['index']]['code']; ?>
" title="Insert smiley" onclick="insert('text','<?php echo $this->_tpl_vars['smilies'][$this->_sections['smiley_row']['index']]['code']; ?>
 ')"><img src="images/smilies/<?php echo $this->_tpl_vars['smilies'][$this->_sections['smiley_row']['index']]['file']; ?>
" alt="<?php echo $this->_tpl_vars['smilies'][$this->_sections['smiley_row']['index']]['code']; ?>
" /></button><?php else: ?>&nbsp;<?php endif; ?>
<?php endfor; endif; ?>
<?php unset($this->_sections['smiley_row']);
$this->_sections['smiley_row']['name'] = 'smiley_row';
$this->_sections['smiley_row']['start'] = (int)$this->_sections['smiley']['index']+1;
$this->_sections['smiley_row']['loop'] = is_array($_loop=$this->_sections['smiley']['index']+2) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['smiley_row']['show'] = true;
$this->_sections['smiley_row']['max'] = $this->_sections['smiley_row']['loop'];
$this->_sections['smiley_row']['step'] = 1;
if ($this->_sections['smiley_row']['start'] < 0)
    $this->_sections['smiley_row']['start'] = max($this->_sections['smiley_row']['step'] > 0 ? 0 : -1, $this->_sections['smiley_row']['loop'] + $this->_sections['smiley_row']['start']);
else
    $this->_sections['smiley_row']['start'] = min($this->_sections['smiley_row']['start'], $this->_sections['smiley_row']['step'] > 0 ? $this->_sections['smiley_row']['loop'] : $this->_sections['smiley_row']['loop']-1);
if ($this->_sections['smiley_row']['show']) {
    $this->_sections['smiley_row']['total'] = min(ceil(($this->_sections['smiley_row']['step'] > 0 ? $this->_sections['smiley_row']['loop'] - $this->_sections['smiley_row']['start'] : $this->_sections['smiley_row']['start']+1)/abs($this->_sections['smiley_row']['step'])), $this->_sections['smiley_row']['max']);
    if ($this->_sections['smiley_row']['total'] == 0)
        $this->_sections['smiley_row']['show'] = false;
} else
    $this->_sections['smiley_row']['total'] = 0;
if ($this->_sections['smiley_row']['show']):

            for ($this->_sections['smiley_row']['index'] = $this->_sections['smiley_row']['start'], $this->_sections['smiley_row']['iteration'] = 1;
                 $this->_sections['smiley_row']['iteration'] <= $this->_sections['smiley_row']['total'];
                 $this->_sections['smiley_row']['index'] += $this->_sections['smiley_row']['step'], $this->_sections['smiley_row']['iteration']++):
$this->_sections['smiley_row']['rownum'] = $this->_sections['smiley_row']['iteration'];
$this->_sections['smiley_row']['index_prev'] = $this->_sections['smiley_row']['index'] - $this->_sections['smiley_row']['step'];
$this->_sections['smiley_row']['index_next'] = $this->_sections['smiley_row']['index'] + $this->_sections['smiley_row']['step'];
$this->_sections['smiley_row']['first']      = ($this->_sections['smiley_row']['iteration'] == 1);
$this->_sections['smiley_row']['last']       = ($this->_sections['smiley_row']['iteration'] == $this->_sections['smiley_row']['total']);
?>
<?php if ($this->_tpl_vars['smilies'][$this->_sections['smiley_row']['index']]['file']): ?><button class="smiley-button" name="smiley" type="button" value="<?php echo $this->_tpl_vars['smilies'][$this->_sections['smiley_row']['index']]['code']; ?>
" title="Insert smiley" onclick="insert('text','<?php echo $this->_tpl_vars['smilies'][$this->_sections['smiley_row']['index']]['code']; ?>
 ')"><img src="images/smilies/<?php echo $this->_tpl_vars['smilies'][$this->_sections['smiley_row']['index']]['file']; ?>
" alt="<?php echo $this->_tpl_vars['smilies'][$this->_sections['smiley_row']['index']]['code']; ?>
" /></button><br /><?php else: ?><br /><?php endif; ?>
<?php endfor; endif; ?>
<?php endfor; endif; ?>
<?php if ($this->_tpl_vars['smilies_count'] > 6): ?><span class="small"><a href="#" onclick="show_box('more-smilies',10,-120); return false" title="<?php echo $this->_config[0]['vars']['more_smilies_title']; ?>
"><?php echo $this->_config[0]['vars']['more_smilies_link']; ?>
</a></span><?php endif; ?>
<?php endif; ?>
</div>
<script type="text/javascript">/* <![CDATA[ */document.getElementById('jsbuttons').style.display="block"; /* ]]> */</script>
<noscript><p class="small">
<?php if ($this->_tpl_vars['settings']['bbcode']): ?>
<?php echo $this->_config[0]['vars']['bbcode_bold_title']; ?>
<br />
<?php echo $this->_config[0]['vars']['bbcode_italic_title']; ?>
<br />
<?php echo $this->_config[0]['vars']['bbcode_link_title']; ?>

<?php if ($this->_tpl_vars['settings']['bbcode_color']): ?><?php echo $this->_config[0]['vars']['bbcode_color_title']; ?>
<br /><?php endif; ?>
<?php if ($this->_tpl_vars['settings']['bbcode_size']): ?><?php echo $this->_config[0]['vars']['bbcode_font_size_title']; ?>
<br /><?php endif; ?>
<?php echo $this->_config[0]['vars']['bbcode_list_title']; ?>
<br />
<?php if ($this->_tpl_vars['settings']['bbcode_img']): ?><?php echo $this->_config[0]['vars']['bbcode_image_title']; ?>
<br /><?php endif; ?>
<?php if ($this->_tpl_vars['upload_images']): ?><a href="index.php?mode=upload_image"><?php echo $this->_config[0]['vars']['upload_image_title']; ?>
</a><br /><?php endif; ?>
<?php endif; ?>
</p></noscript>
</td></tr></table>
</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<?php if ($this->_tpl_vars['signature']): ?>
<tr>
<td colspan="2"><input id="show_signature" type="checkbox" name="show_signature" value="1"<?php if ($this->_tpl_vars['show_signature'] && $this->_tpl_vars['show_signature'] == 1): ?> checked="checked"<?php endif; ?> />&nbsp;<label for="show_signature"><?php echo $this->_config[0]['vars']['show_signature_marking']; ?>
</label></td>
</tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['provide_email_notification']): ?>
<tr>
<td colspan="2"><input id="email_notification" type="checkbox" name="email_notification" value="1"<?php if ($this->_tpl_vars['email_notification'] && $this->_tpl_vars['email_notification'] == 1): ?> checked="checked"<?php endif; ?> />&nbsp;<label for="email_notification"><?php if ($this->_tpl_vars['id'] == 0): ?><?php echo $this->_config[0]['vars']['email_notific_reply_thread']; ?>
<?php else: ?><?php echo $this->_config[0]['vars']['email_notific_reply_post']; ?>
<?php endif; ?></label></td>
</tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['provide_sticky']): ?>
<tr>
<td colspan="2"><input id="sticky" type="checkbox" name="sticky" value="1"<?php if ($this->_tpl_vars['sticky'] && $this->_tpl_vars['sticky'] == 1): ?> checked="checked"<?php endif; ?> />&nbsp;<label for="sticky"><?php echo $this->_config[0]['vars']['sticky_thread']; ?>
</label></td>
</tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['terms_of_use_agreement']): ?>
<?php $this->assign('terms_of_use_url', $this->_tpl_vars['settings']['terms_of_use_url']); ?>
<tr>
<td colspan="2"><input id="terms_of_use_agree" type="checkbox" name="terms_of_use_agree" value="1"<?php if ($this->_tpl_vars['terms_of_use_agree'] && $this->_tpl_vars['terms_of_use_agree'] == 1): ?> checked="checked"<?php endif; ?> />&nbsp;<label for="terms_of_use_agree"><?php if ($this->_tpl_vars['terms_of_use_url']): ?><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['terms_of_use_agreement'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[[", "<a href=\"".($this->_tpl_vars['terms_of_use_url'])."\" onclick=\"popup('".($this->_tpl_vars['terms_of_use_url'])."',640,480); return false\">") : smarty_modifier_replace($_tmp, "[[", "<a href=\"".($this->_tpl_vars['terms_of_use_url'])."\" onclick=\"popup('".($this->_tpl_vars['terms_of_use_url'])."',640,480); return false\">")))) ? $this->_run_mod_handler('replace', true, $_tmp, "]]", "</a>") : smarty_modifier_replace($_tmp, "]]", "</a>")); ?>
<?php else: ?><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['terms_of_use_agreement'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[[", "") : smarty_modifier_replace($_tmp, "[[", "")))) ? $this->_run_mod_handler('replace', true, $_tmp, "]]", "") : smarty_modifier_replace($_tmp, "]]", "")); ?>
<?php endif; ?></label></td>
</tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['signature'] || $this->_tpl_vars['provide_email_notification'] || $this->_tpl_vars['provide_sticky'] || $this->_tpl_vars['terms_of_use_agreement']): ?>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['captcha']): ?>
<tr>
<td colspan="2">
<div id="captcha">
<?php if ($this->_tpl_vars['captcha']['type'] == 2): ?>
<p><strong><?php echo $this->_config[0]['vars']['captcha_marking']; ?>
</strong><br />
<img class="captcha" src="modules/captcha/captcha_image.php?<?php echo $this->_tpl_vars['captcha']['session_name']; ?>
=<?php echo $this->_tpl_vars['captcha']['session_id']; ?>
" alt="<?php echo $this->_config[0]['vars']['captcha_image_alt']; ?>
" width="180" height="40" /><br />
<label for="captcha_code"><?php echo $this->_config[0]['vars']['captcha_expl_image']; ?>
</label> <input id="captcha_code" type="text" name="captcha_code" value="" size="10" /></p>
<?php else: ?>
<p><strong><?php echo $this->_config[0]['vars']['captcha_marking']; ?>
</strong><br />
<label for="captcha_code"><?php echo $this->_config[0]['vars']['captcha_expl_math']; ?>
 <?php echo $this->_tpl_vars['captcha']['number_1']; ?>
 + <?php echo $this->_tpl_vars['captcha']['number_2']; ?>
 = </label><input id="captcha_code" type="text" name="captcha_code" value="" size="5" maxlength="5" /></p>
<?php endif; ?>
</div>
</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<?php endif; ?>
<tr>
<td colspan="2"><input type="submit" name="save_entry" value="<?php echo $this->_config[0]['vars']['message_submit_button']; ?>
" title="<?php echo $this->_config[0]['vars']['message_submit_title']; ?>
" tabindex="8" onclick="return is_postingform_complete('<?php echo ((is_array($_tmp=$this->_config[0]['vars']['error_no_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
','<?php echo ((is_array($_tmp=$this->_config[0]['vars']['error_no_subject'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
','<?php if ($this->_tpl_vars['settings']['empty_postings_possible'] == 0): ?><?php echo ((is_array($_tmp=$this->_config[0]['vars']['error_no_text'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
<?php endif; ?>'<?php if ($this->_tpl_vars['terms_of_use_agreement']): ?>,'<?php echo ((is_array($_tmp=$this->_config[0]['vars']['terms_of_use_agree_error_posting'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
'<?php endif; ?>)" />&nbsp;<input type="submit" name="preview" value="<?php echo $this->_config[0]['vars']['message_preview_button']; ?>
" title="<?php echo $this->_config[0]['vars']['message_preview_title']; ?>
" tabindex="9" onclick="return is_postingform_complete('<?php echo ((is_array($_tmp=$this->_config[0]['vars']['error_no_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
','<?php echo ((is_array($_tmp=$this->_config[0]['vars']['error_no_subject'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
','<?php if ($this->_tpl_vars['settings']['empty_postings_possible'] == 0): ?><?php echo ((is_array($_tmp=$this->_config[0]['vars']['error_no_text'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
<?php endif; ?>'<?php if ($this->_tpl_vars['terms_of_use_agreement']): ?>,'<?php echo ((is_array($_tmp=$this->_config[0]['vars']['terms_of_use_agree_error_posting'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
'<?php endif; ?>)" /> <img id="throbber-submit" style="visibility:hidden;" src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/throbber_submit.gif" alt="" width="16" height="16" /></td>
</tr>
</table>
</div>
</form>
<?php if (! $this->_tpl_vars['user']): ?><p class="xsmall" style="margin-top: 30px;"><?php echo $this->_config[0]['vars']['email_exp']; ?>
</p><?php else: ?><p>&nbsp;</p><?php endif; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['settings']['smilies'] == 1 && $this->_tpl_vars['smilies']): ?>
<div id="more-smilies">
<a href="#" onclick="hide_element('more-smilies'); return false"><img class="close" src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/close.png" alt="[x]" title="<?php echo $this->_config[0]['vars']['close']; ?>
" width="14" height="14" /></a>
<div id="more-smilies-body">
<div id="more-smilies-content">
<p><?php unset($this->_sections['smiley']);
$this->_sections['smiley']['name'] = 'smiley';
$this->_sections['smiley']['loop'] = is_array($_loop=$this->_tpl_vars['smilies']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['smiley']['show'] = true;
$this->_sections['smiley']['max'] = $this->_sections['smiley']['loop'];
$this->_sections['smiley']['step'] = 1;
$this->_sections['smiley']['start'] = $this->_sections['smiley']['step'] > 0 ? 0 : $this->_sections['smiley']['loop']-1;
if ($this->_sections['smiley']['show']) {
    $this->_sections['smiley']['total'] = $this->_sections['smiley']['loop'];
    if ($this->_sections['smiley']['total'] == 0)
        $this->_sections['smiley']['show'] = false;
} else
    $this->_sections['smiley']['total'] = 0;
if ($this->_sections['smiley']['show']):

            for ($this->_sections['smiley']['index'] = $this->_sections['smiley']['start'], $this->_sections['smiley']['iteration'] = 1;
                 $this->_sections['smiley']['iteration'] <= $this->_sections['smiley']['total'];
                 $this->_sections['smiley']['index'] += $this->_sections['smiley']['step'], $this->_sections['smiley']['iteration']++):
$this->_sections['smiley']['rownum'] = $this->_sections['smiley']['iteration'];
$this->_sections['smiley']['index_prev'] = $this->_sections['smiley']['index'] - $this->_sections['smiley']['step'];
$this->_sections['smiley']['index_next'] = $this->_sections['smiley']['index'] + $this->_sections['smiley']['step'];
$this->_sections['smiley']['first']      = ($this->_sections['smiley']['iteration'] == 1);
$this->_sections['smiley']['last']       = ($this->_sections['smiley']['iteration'] == $this->_sections['smiley']['total']);
?>
<?php if ($this->_tpl_vars['smilies'][$this->_sections['smiley']['index']]['file']): ?><a href="#" onclick="insert('text','<?php echo $this->_tpl_vars['smilies'][$this->_sections['smiley']['index']]['code']; ?>
 '); return false;"><img src="images/smilies/<?php echo $this->_tpl_vars['smilies'][$this->_sections['smiley']['index']]['file']; ?>
" alt="<?php echo $this->_tpl_vars['smilies'][$this->_sections['smiley']['index']]['code']; ?>
" /></a><?php endif; ?>
<?php endfor; endif; ?>
</p>
</div>
</div>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['settings']['bbcode_color']): ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/subtemplates/colorpicker.tpl.inc", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>
<?php if ($this->_tpl_vars['settings']['bbcode_size']): ?>
<div id="sizepicker">
<p style="font-size:x-small;"><a href="#" onclick="bbcode('text','size','small'); hide_element('sizepicker'); return false"><?php echo $this->_config[0]['vars']['bbcode_font_size_small']; ?>
</a></p>
<p style="font-size:large;"><a href="#" onclick="bbcode('text','size','large'); hide_element('sizepicker'); return false"><?php echo $this->_config[0]['vars']['bbcode_font_size_large']; ?>
</a></p>
</div>
<?php endif; ?>