<?php /* Smarty version 2.6.22, created on 2009-03-03 00:22:42
         compiled from default/subtemplates/subnavigation_1.tpl.inc */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'default/subtemplates/subnavigation_1.tpl.inc', 13, false),array('modifier', 'default', 'default/subtemplates/subnavigation_1.tpl.inc', 13, false),)), $this); ?>
<?php if ($this->_tpl_vars['subnav_location']): ?>
<p class="subnav">
<?php if ($this->_tpl_vars['breadcrumbs']): ?>
<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['breadcrumbs']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<?php $this->assign('breadcrumb_linkname', $this->_tpl_vars['breadcrumbs'][$this->_sections['nr']['index']]['linkname']); ?>
<a href="<?php echo $this->_tpl_vars['breadcrumbs'][$this->_sections['nr']['index']]['link']; ?>
"><?php echo $this->_config[0]['vars'][$this->_tpl_vars['breadcrumb_linkname']]; ?>
</a> &raquo;
<?php endfor; endif; ?>
<?php endif; ?>
<?php echo $this->_tpl_vars['subnav_location']; ?>
</p>
<?php elseif ($this->_tpl_vars['subnav_link']): ?>
<?php $this->assign('link_name', $this->_tpl_vars['subnav_link']['name']); ?>
<?php if ($this->_tpl_vars['subnav_link']['title']): ?><?php $this->assign('link_title', $this->_tpl_vars['subnav_link']['title']); ?><?php endif; ?>
<a class="stronglink" href="index.php<?php if ($this->_tpl_vars['subnav_link']['id'] && ! $this->_tpl_vars['subnav_link']['mode']): ?>?id=<?php echo $this->_tpl_vars['subnav_link']['id']; ?>
<?php else: ?>?mode=<?php echo $this->_tpl_vars['subnav_link']['mode']; ?>
<?php if ($this->_tpl_vars['subnav_link']['back']): ?>&amp;back=<?php echo $this->_tpl_vars['subnav_link']['back']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['subnav_link']['id']): ?>&amp;id=<?php echo $this->_tpl_vars['subnav_link']['id']; ?>
<?php endif; ?><?php endif; ?>" title="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars'][$this->_tpl_vars['link_title']])) ? $this->_run_mod_handler('replace', true, $_tmp, "[name]", $this->_tpl_vars['name_repl_subnav']) : smarty_modifier_replace($_tmp, "[name]", $this->_tpl_vars['name_repl_subnav'])))) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
"><?php echo ((is_array($_tmp=$this->_config[0]['vars'][$this->_tpl_vars['link_name']])) ? $this->_run_mod_handler('replace', true, $_tmp, "[name]", $this->_tpl_vars['name_repl_subnav']) : smarty_modifier_replace($_tmp, "[name]", $this->_tpl_vars['name_repl_subnav'])); ?>
</a>
<?php else: ?>
&nbsp;
<?php endif; ?>