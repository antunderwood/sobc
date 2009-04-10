<?php /* Smarty version 2.6.22, created on 2009-03-03 00:22:42
         compiled from default/subtemplates/ajax_preview.tpl.inc */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'default/subtemplates/ajax_preview.tpl.inc', 2, false),)), $this); ?>
<script type="text/javascript">/* <![CDATA[ */
var ajax_preview_structure = '<div id="ajax-preview-top" onclick="ajax_preview_close()">&nbsp;<\/div><a id="ajax-preview-close" href="#" onclick="ajax_preview_close(); return false"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/close.png" alt="[x]" title="<?php echo ((is_array($_tmp=$this->_config[0]['vars']['close'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
" width="14" height="14" /><\/a><div id="ajax-preview-body"><div id="ajax-preview-throbber"><img src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/throbber.gif" alt="" width="16" height="16" /><\/div><div id="ajax-preview-content"><\/div><?php if ($this->_tpl_vars['mode'] == 'index'): ?><div id="ajax-preview-replylink">[ <a id="replylink" href=""><?php echo ((is_array($_tmp=$this->_config[0]['vars']['reply_link'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
<\/a> ]<\/div>\<?php endif; ?><\/div>';
/* ]]> */</script>