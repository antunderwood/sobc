{config_load file=$settings.language_file section="general"}{assign var='template' value=$settings.template}{if $subnav_location && $subnav_location_var}{assign var="subnav_location" value=$smarty.config.$subnav_location|replace:"[var]":$subnav_location_var}{elseif $subnav_location}{assign var='subnav_location' value=$smarty.config.$subnav_location}{/if}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{#language#}" dir="{#dir#}">
<head>
<title>{$settings.forum_name|escape:"html"}{if $page_title} - {$page_title}{elseif $subnav_location} - {$subnav_location}{/if}</title>
<meta http-equiv="content-type" content="text/html; charset={#charset#}" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="description" content="{$settings.forum_description|escape:"html"}" />
<meta name="keywords" content="{$keywords|default:""}" />
<meta name="generator" content="my little forum {$settings.version}" />
<link rel="stylesheet" type="text/css" href="templates/{$settings.template}/style.css" media="all" />
{if $settings.rss_feed==1}<link rel="alternate" type="application/rss+xml" title="RSS" href="index.php?mode=rss" />{/if}
<link rel="top" href="./" />
<link rel="search" href="index.php?mode=search" />
<link rel="shortcut icon" href="templates/{$settings.template}/images/favicon.ico" />
<script src="js/main.js" type="text/javascript"></script>
{if $mode=='admin'}
<script src="js/admin.js" type="text/javascript"></script>
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js" type="text/javascript"></script>
{/if}
</head>

<body onload="preload_images(new Array('templates/{$settings.template}/images/link_hover.png','templates/{$settings.template}/images/throbber.gif'))">

<div id="top">
<div class="left">
{if $settings.home_linkname}<p class="home"><a href="{$settings.home_linkaddress}">{$settings.home_linkname}</a></p>{/if}
<h1><a href="./" title="{#forum_index_link_title#}">{$settings.forum_name|escape:"html"}</a></h1>
</div>
<div class="right">
<div id="usermenu">{if $user}<a href="index.php?mode=user&amp;action=edit_profile" title="{#profile_link_title#}"><strong>{$user}</strong></a> | <a href="index.php?mode=user" title="{#user_area_link_title#}">{#user_area_link#}</a>{if $admin} | <a href="index.php?mode=admin" title="{#admin_area_link_title#}">{#admin_area_link#}</a>{/if} | <a href="index.php?mode=login" title="{#log_out_link_title#}">{#log_out_link#}</a>{else}<a href="index.php?mode=login" title="{#log_in_link_title#}">{#log_in_link#}</a>{if $settings.register_mode!=2} | <a href="index.php?mode=register" title="{#register_link_title#}">{#register_link#}</a>{/if}{if $settings.user_area_public} | <a href="index.php?mode=user" title="{#user_area_link_title#}">{#user_area_link#}</a>{/if}{/if}{if $menu} | {foreach name='menu' from=$menu item=menu}<a href="index.php?mode=page&amp;id={$menu.id}">{$menu.linkname}</a>{if !$smarty.foreach.menu.last} | {/if}{/foreach}{/if}</div>
<form action="index.php" method="get" title="{#search_title#}" accept-charset="{#charset#}"><div class="search"><input type="hidden" name="mode" value="search" /><label for="search_top">{#search_marking#}</label>&nbsp;<input class="searchfield" type="text" name="search" value=""{* onfocus="if(this.value=='{#search_default_value#}') this.value=''" onblur="if(this.value=='') this.value='{#search_default_value#}'"*} size="25" id="search_top" /><!--&nbsp;<input type="image" src="templates/{$settings.template}/images/submit.png" alt="[&raquo;]" />--></div></form></div>
</div>
<div id="topnav">
<div class="left">{include file="$template/subtemplates/subnavigation_1.tpl.inc"}</div>
<div class="right">{include file="$template/subtemplates/subnavigation_2.tpl.inc"}</div>
</div>

<div id="content">
{if $subtemplate}
{include file="$template/subtemplates/$subtemplate"}
{else}
{$content|default:""}
{/if}
</div>

<div id="bottom">
<div class="left">{if $total_users_online}{#counter_users_online#|replace:"[total_postings]":$total_postings|replace:"[total_threads]":$total_threads|replace:"[registered_users]":$registered_users|replace:"[total_users_online]":$total_users_online|replace:"[registered_users_online]":$registered_users_online|replace:"[unregistered_users_online]":$unregistered_users_online}{else}{#counter#|replace:"[total_postings]":$total_postings|replace:"[total_threads]":$total_threads|replace:"[registered_users]":$registered_users}{/if}</div>
<div class="right">{if $settings.rss_feed==1}<a href="index.php?mode=rss" title="{#rss_feed_postings_title#}"><img src="templates/{$template}/images/rss_link.png" alt="" width="13" height="9" />{#rss_feed_postings#}</a> &nbsp;<a href="index.php?mode=rss&amp;items=thread_starts" title="{#rss_feed_new_threads_title#}"><img src="templates/{$template}/images/rss_link.png" alt="" width="13" height="9" />{#rss_feed_new_threads#}</a> | {/if}<a href="index.php?mode=contact" title="{#contact_linktitle#}">{#contact_link#}</a></div>
</div>

{*
Please donate if you want to remove this link: 
https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=1922497
*}
<div id="pbmlf"><a href="http://mylittleforum.net/">powered by my little forum</a></div>

</body>
</html>
