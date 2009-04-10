<?php /* Smarty version 2.6.22, created on 2009-03-03 00:22:43
         compiled from default/rss.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'default/rss.tpl', 1, false),array('modifier', 'escape', 'default/rss.tpl', 5, false),array('modifier', 'replace', 'default/rss.tpl', 13, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['settings']['language_file'],'section' => 'general'), $this);?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="<?php echo $this->_config[0]['vars']['charset']; ?>
"<?php echo '?>'; ?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
<title><?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['forum_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</title>
<link><?php echo $this->_tpl_vars['settings']['forum_address']; ?>
</link>
<description><?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['forum_description'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</description>
<language><?php echo $this->_config[0]['vars']['language']; ?>
</language>
<?php if ($this->_tpl_vars['rss_items']): ?>
<?php $_from = $this->_tpl_vars['rss_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<item>
<title><?php echo $this->_tpl_vars['item']['title']; ?>
</title>
<content:encoded><![CDATA[<p><em><?php if ($this->_tpl_vars['item']['reply']): ?><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['rss_reply_by'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[name]", $this->_tpl_vars['item']['name']) : smarty_modifier_replace($_tmp, "[name]", $this->_tpl_vars['item']['name'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[time]", $this->_tpl_vars['item']['formated_time']) : smarty_modifier_replace($_tmp, "[time]", $this->_tpl_vars['item']['formated_time'])); ?>
<?php else: ?><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['rss_posting_by'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[name]", $this->_tpl_vars['item']['name']) : smarty_modifier_replace($_tmp, "[name]", $this->_tpl_vars['item']['name'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[time]", $this->_tpl_vars['item']['formated_time']) : smarty_modifier_replace($_tmp, "[time]", $this->_tpl_vars['item']['formated_time'])); ?>
<?php endif; ?></em></p><p><?php if ($this->_tpl_vars['item']['text'] != ''): ?><?php echo $this->_tpl_vars['item']['text']; ?>
<?php else: ?><?php echo $this->_config[0]['vars']['no_text']; ?>
<?php endif; ?></p>]]></content:encoded>
<link><?php echo $this->_tpl_vars['item']['link']; ?>
</link>
<guid><?php echo $this->_tpl_vars['item']['link']; ?>
</guid>
<pubDate><?php echo $this->_tpl_vars['item']['pubdate']; ?>
</pubDate>
<?php if ($this->_tpl_vars['item']['category']): ?>
<category><?php echo $this->_tpl_vars['item']['category']; ?>
</category>
<?php endif; ?>
<dc:creator><?php echo $this->_tpl_vars['item']['name']; ?>
</dc:creator>
</item>
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
</channel>
</rss>