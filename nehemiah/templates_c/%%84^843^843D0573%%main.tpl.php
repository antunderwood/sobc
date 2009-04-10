<?php /* Smarty version 2.6.22, created on 2009-03-03 00:22:42
         compiled from default/main.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'default/main.tpl', 1, false),array('modifier', 'replace', 'default/main.tpl', 1, false),array('modifier', 'escape', 'default/main.tpl', 4, false),array('modifier', 'default', 'default/main.tpl', 8, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['settings']['language_file'],'section' => 'general'), $this);?>
<?php $this->assign('template', $this->_tpl_vars['settings']['template']); ?><?php if ($this->_tpl_vars['subnav_location'] && $this->_tpl_vars['subnav_location_var']): ?><?php $this->assign('subnav_location', ((is_array($_tmp=$this->_config[0]['vars'][$this->_tpl_vars['subnav_location']])) ? $this->_run_mod_handler('replace', true, $_tmp, "[var]", $this->_tpl_vars['subnav_location_var']) : smarty_modifier_replace($_tmp, "[var]", $this->_tpl_vars['subnav_location_var']))); ?><?php elseif ($this->_tpl_vars['subnav_location']): ?><?php $this->assign('subnav_location', $this->_config[0]['vars'][$this->_tpl_vars['subnav_location']]); ?><?php endif; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->_config[0]['vars']['language']; ?>
" dir="<?php echo $this->_config[0]['vars']['dir']; ?>
">
<head>
<title><?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['forum_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
<?php if ($this->_tpl_vars['page_title']): ?> - <?php echo $this->_tpl_vars['page_title']; ?>
<?php elseif ($this->_tpl_vars['subnav_location']): ?> - <?php echo $this->_tpl_vars['subnav_location']; ?>
<?php endif; ?></title>
<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->_config[0]['vars']['charset']; ?>
" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="description" content="<?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['forum_description'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" />
<meta name="keywords" content="<?php echo ((is_array($_tmp=@$this->_tpl_vars['keywords'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
" />
<meta name="generator" content="my little forum <?php echo $this->_tpl_vars['settings']['version']; ?>
" />
<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/style.css" media="all" />
<?php if ($this->_tpl_vars['settings']['rss_feed'] == 1): ?><link rel="alternate" type="application/rss+xml" title="RSS" href="index.php?mode=rss" /><?php endif; ?>
<link rel="top" href="./" />
<link rel="search" href="index.php?mode=search" />
<link rel="shortcut icon" href="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/favicon.ico" />
<script src="js/main.js" type="text/javascript"></script>
<?php if ($this->_tpl_vars['mode'] == 'admin'): ?>
<script src="js/admin.js" type="text/javascript"></script>
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js" type="text/javascript"></script>
<?php endif; ?>
</head>

<body onload="preload_images(new Array('templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/link_hover.png','templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/throbber.gif'))">

<div id="top">
<div class="left">
<?php if ($this->_tpl_vars['settings']['home_linkname']): ?><p class="home"><a href="<?php echo $this->_tpl_vars['settings']['home_linkaddress']; ?>
"><?php echo $this->_tpl_vars['settings']['home_linkname']; ?>
</a></p><?php endif; ?>
<h1><a href="./" title="<?php echo $this->_config[0]['vars']['forum_index_link_title']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['settings']['forum_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a></h1>
</div>
<div class="right">
<div id="usermenu"><?php if ($this->_tpl_vars['user']): ?><a href="index.php?mode=user&amp;action=edit_profile" title="<?php echo $this->_config[0]['vars']['profile_link_title']; ?>
"><strong><?php echo $this->_tpl_vars['user']; ?>
</strong></a> | <a href="index.php?mode=user" title="<?php echo $this->_config[0]['vars']['user_area_link_title']; ?>
"><?php echo $this->_config[0]['vars']['user_area_link']; ?>
</a><?php if ($this->_tpl_vars['admin']): ?> | <a href="index.php?mode=admin" title="<?php echo $this->_config[0]['vars']['admin_area_link_title']; ?>
"><?php echo $this->_config[0]['vars']['admin_area_link']; ?>
</a><?php endif; ?> | <a href="index.php?mode=login" title="<?php echo $this->_config[0]['vars']['log_out_link_title']; ?>
"><?php echo $this->_config[0]['vars']['log_out_link']; ?>
</a><?php else: ?><a href="index.php?mode=login" title="<?php echo $this->_config[0]['vars']['log_in_link_title']; ?>
"><?php echo $this->_config[0]['vars']['log_in_link']; ?>
</a><?php if ($this->_tpl_vars['settings']['register_mode'] != 2): ?> | <a href="index.php?mode=register" title="<?php echo $this->_config[0]['vars']['register_link_title']; ?>
"><?php echo $this->_config[0]['vars']['register_link']; ?>
</a><?php endif; ?><?php if ($this->_tpl_vars['settings']['user_area_public']): ?> | <a href="index.php?mode=user" title="<?php echo $this->_config[0]['vars']['user_area_link_title']; ?>
"><?php echo $this->_config[0]['vars']['user_area_link']; ?>
</a><?php endif; ?><?php endif; ?><?php if ($this->_tpl_vars['menu']): ?> | <?php $_from = $this->_tpl_vars['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menu'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menu']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['menu']):
        $this->_foreach['menu']['iteration']++;
?><a href="index.php?mode=page&amp;id=<?php echo $this->_tpl_vars['menu']['id']; ?>
"><?php echo $this->_tpl_vars['menu']['linkname']; ?>
</a><?php if (! ($this->_foreach['menu']['iteration'] == $this->_foreach['menu']['total'])): ?> | <?php endif; ?><?php endforeach; endif; unset($_from); ?><?php endif; ?></div>
<form action="index.php" method="get" title="<?php echo $this->_config[0]['vars']['search_title']; ?>
" accept-charset="<?php echo $this->_config[0]['vars']['charset']; ?>
"><div class="search"><input type="hidden" name="mode" value="search" /><label for="search_top"><?php echo $this->_config[0]['vars']['search_marking']; ?>
</label>&nbsp;<input class="searchfield" type="text" name="search" value="" size="25" id="search_top" /><!--&nbsp;<input type="image" src="templates/<?php echo $this->_tpl_vars['settings']['template']; ?>
/images/submit.png" alt="[&raquo;]" />--></div></form></div>
</div>
<div id="topnav">
<div class="left"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/subtemplates/subnavigation_1.tpl.inc", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
<div class="right"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/subtemplates/subnavigation_2.tpl.inc", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
</div>

<div id="content">
<?php if ($this->_tpl_vars['subtemplate']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/subtemplates/".($this->_tpl_vars['subtemplate']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
<?php echo ((is_array($_tmp=@$this->_tpl_vars['content'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>

<?php endif; ?>
</div>

<div id="bottom">
<div class="left"><?php if ($this->_tpl_vars['total_users_online']): ?><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['counter_users_online'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[total_postings]", $this->_tpl_vars['total_postings']) : smarty_modifier_replace($_tmp, "[total_postings]", $this->_tpl_vars['total_postings'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[total_threads]", $this->_tpl_vars['total_threads']) : smarty_modifier_replace($_tmp, "[total_threads]", $this->_tpl_vars['total_threads'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[registered_users]", $this->_tpl_vars['registered_users']) : smarty_modifier_replace($_tmp, "[registered_users]", $this->_tpl_vars['registered_users'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[total_users_online]", $this->_tpl_vars['total_users_online']) : smarty_modifier_replace($_tmp, "[total_users_online]", $this->_tpl_vars['total_users_online'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[registered_users_online]", $this->_tpl_vars['registered_users_online']) : smarty_modifier_replace($_tmp, "[registered_users_online]", $this->_tpl_vars['registered_users_online'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[unregistered_users_online]", $this->_tpl_vars['unregistered_users_online']) : smarty_modifier_replace($_tmp, "[unregistered_users_online]", $this->_tpl_vars['unregistered_users_online'])); ?>
<?php else: ?><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_config[0]['vars']['counter'])) ? $this->_run_mod_handler('replace', true, $_tmp, "[total_postings]", $this->_tpl_vars['total_postings']) : smarty_modifier_replace($_tmp, "[total_postings]", $this->_tpl_vars['total_postings'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[total_threads]", $this->_tpl_vars['total_threads']) : smarty_modifier_replace($_tmp, "[total_threads]", $this->_tpl_vars['total_threads'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "[registered_users]", $this->_tpl_vars['registered_users']) : smarty_modifier_replace($_tmp, "[registered_users]", $this->_tpl_vars['registered_users'])); ?>
<?php endif; ?></div>
<div class="right"><?php if ($this->_tpl_vars['settings']['rss_feed'] == 1): ?><a href="index.php?mode=rss" title="<?php echo $this->_config[0]['vars']['rss_feed_postings_title']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/rss_link.png" alt="" width="13" height="9" /><?php echo $this->_config[0]['vars']['rss_feed_postings']; ?>
</a> &nbsp;<a href="index.php?mode=rss&amp;items=thread_starts" title="<?php echo $this->_config[0]['vars']['rss_feed_new_threads_title']; ?>
"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/images/rss_link.png" alt="" width="13" height="9" /><?php echo $this->_config[0]['vars']['rss_feed_new_threads']; ?>
</a> | <?php endif; ?><a href="index.php?mode=contact" title="<?php echo $this->_config[0]['vars']['contact_linktitle']; ?>
"><?php echo $this->_config[0]['vars']['contact_link']; ?>
</a></div>
</div>

<div id="pbmlf"><a href="http://mylittleforum.net/">powered by my little forum</a></div>

</body>
</html>