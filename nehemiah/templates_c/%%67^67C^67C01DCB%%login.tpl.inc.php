<?php /* Smarty version 2.6.22, created on 2009-03-03 00:22:56
         compiled from default/subtemplates/login.tpl.inc */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'default/subtemplates/login.tpl.inc', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['settings']['language_file'],'section' => 'login'), $this);?>

<?php if ($this->_tpl_vars['ip_temporarily_blocked']): ?>
<?php echo $this->_config[0]['vars']['login_message']; ?>

<p class="caution"><?php echo $this->_config[0]['vars']['login_ip_temp_blocked']; ?>
</p>
<?php else: ?>
<?php if ($this->_tpl_vars['login_message'] && $this->_config[0]['vars'][$this->_tpl_vars['login_message']]): ?>
<p class="<?php if ($this->_tpl_vars['login_message'] == 'account_activated'): ?>ok<?php else: ?>caution<?php endif; ?>"><?php echo $this->_config[0]['vars'][$this->_tpl_vars['login_message']]; ?>
</p>
<?php endif; ?>
<form action="index.php" method="post" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
">
<div>
<input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['mode']; ?>
" />
<?php if ($this->_tpl_vars['back']): ?><input type="hidden" name="back" value="<?php echo $this->_tpl_vars['back']; ?>
" /><?php endif; ?>
<?php if ($this->_tpl_vars['id']): ?><input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" /><?php endif; ?>
<p><label for="login" class="main"><?php echo $this->_config[0]['vars']['login_username']; ?>
</label><br /><input id="login" type="text" name="username" size="25" /></p>
<p><label for="password" class="main"><?php echo $this->_config[0]['vars']['login_password']; ?>
</label><br /><input id="password" type="password" name="userpw" size="25" /></p>
<?php if ($this->_tpl_vars['settings']['autologin'] == 1): ?>
<p class="small"><input id="autologin" type="checkbox" name="autologin_checked" value="true" /> <label for="autologin"><?php echo $this->_config[0]['vars']['login_auto']; ?>
</label></p>
<?php endif; ?>
<p><input type="submit" value="<?php echo $this->_config[0]['vars']['login_submit']; ?>
" /></p>
</div>
</form>
<script type="text/javascript">/* <![CDATA[ */ sf('login'); /* ]]> */</script>
<p class="small"><?php echo $this->_config[0]['vars']['login_advice']; ?>
</p>
<p class="small"><a href="index.php?mode=login&amp;action=pw_forgotten"><?php echo $this->_config[0]['vars']['pw_forgotten_link']; ?>
</a></p>
<?php endif; ?>

