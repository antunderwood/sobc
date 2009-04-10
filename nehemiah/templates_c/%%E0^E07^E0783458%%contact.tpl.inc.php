<?php /* Smarty version 2.6.22, created on 2009-03-06 23:07:43
         compiled from default/subtemplates/contact.tpl.inc */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'default/subtemplates/contact.tpl.inc', 1, false),array('modifier', 'replace', 'default/subtemplates/contact.tpl.inc', 8, false),array('modifier', 'default', 'default/subtemplates/contact.tpl.inc', 27, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['settings']['language_file'],'section' => 'contact'), $this);?>

<?php if ($this->_tpl_vars['captcha']): ?><?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['settings']['language_file'],'section' => 'captcha'), $this);?>
<?php endif; ?>
<?php if ($this->_tpl_vars['error_message']): ?>
<p class="caution"><?php echo $this->_config[0]['vars'][$this->_tpl_vars['error_message']]; ?>
</p>
<?php elseif ($this->_tpl_vars['sent']): ?>
<p class="ok"><?php echo $this->_config[0]['vars']['email_sent']; ?>
</p>
<?php else: ?>
<h1><?php if ($this->_tpl_vars['recipient_name']): ?><?php echo ((is_array($_tmp=$this->_config[0]['vars']['contact_user_hl'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[recipient_name]", ($this->_tpl_vars['recipient_name'])) : smarty_modifier_replace($_tmp, "[recipient_name]", ($this->_tpl_vars['recipient_name']))); ?>
<?php else: ?><?php echo $this->_config[0]['vars']['contact_hl']; ?>
<?php endif; ?></h1>
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
<li><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars'][$this->_tpl_vars['error']])) ? $this->_run_mod_handler('replace', true, $_tmp, "[text_length]", $this->_tpl_vars['text_length']) : smarty_modifier_replace($_tmp, "[text_length]", $this->_tpl_vars['text_length'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[text_maxlength]", $this->_tpl_vars['settings']['email_text_maxlength']) : smarty_modifier_replace($_tmp, "[text_maxlength]", $this->_tpl_vars['settings']['email_text_maxlength'])); ?>
</li>
<?php endfor; endif; ?>
</ul>
<?php endif; ?>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="contact" />
<?php if ($this->_tpl_vars['id']): ?><input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" /><?php endif; ?>
<?php if ($this->_tpl_vars['recipient_user_id']): ?><input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars['recipient_user_id']; ?>
" /><?php endif; ?>
<?php if ($this->_tpl_vars['session']): ?><input type="hidden" name="<?php echo $this->_tpl_vars['session']['name']; ?>
" value="<?php echo $this->_tpl_vars['session']['id']; ?>
" /><?php endif; ?>
<p><label for="sender_email"><?php echo $this->_config[0]['vars']['sender_address_caption']; ?>
</label><br />
<input id="sender_email" type="text" name="sender_email" value="<?php echo $this->_tpl_vars['sender_email']; ?>
" size="50" /></p>
<p><label for="subject"><?php echo $this->_config[0]['vars']['subject_caption']; ?>
</label><br />
<input id="subject" type="text" name="subject" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['subject'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
" size="50" maxlength="<?php echo $this->_tpl_vars['settings']['email_subject_maxlength']; ?>
" /></p>
<p><label for="message"><?php echo $this->_config[0]['vars']['message_caption']; ?>
</label><br />
<textarea id="message" name="text" rows="20" cols="80"><?php echo ((is_array($_tmp=@$this->_tpl_vars['text'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
</textarea></p>
<?php if ($this->_tpl_vars['captcha']): ?>
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
 = </label><input id="captcha_code" type="text" name="captcha_code" value="" size="5" /></p>
<?php endif; ?>
<?php endif; ?>
<p><input type="submit" name="message_submit" value="<?php echo $this->_config[0]['vars']['message_submit_caption']; ?>
" size="50" onclick="document.getElementById('throbber-submit').style.display = 'inline'" /> <img id="throbber-submit" style="display:none;" src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/throbber_submit.gif" alt="" width="16" height="16" /></p>
</div>
</form>
<?php endif; ?>