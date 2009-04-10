{if $tag_cloud || $latest_postings || $admin || $mod}
<div id="sidebar">
<a href="index.php?toggle_sidebar=true" onclick="toggle_sidebar('templates/{$settings.template}/images/hide_sidebar.png','templates/{$settings.template}/images/show_sidebar.png'); return false;"><img id="sidebartoggle" src="templates/{$settings.template}/images/{if $usersettings.sidebar==0}show_sidebar.png{else}hide_sidebar.png{/if}" title="{#toggle_sidebar#}" alt="[+/-]" width="9" height="9" /></a>
<h3 class="sidebar"><a href="index.php?toggle_sidebar=true" title="{#toggle_sidebar#}" onclick="toggle_sidebar('templates/{$settings.template}/images/hide_sidebar.png','templates/{$settings.template}/images/show_sidebar.png'); return false;">{#sidebar#}</a></h3>
<div id="sidebarcontent"{if $usersettings.sidebar==0} style="display:none;"{/if}>
{if $latest_postings}
<div id="latest-postings" {if $usersettings.latest_postings==0} style="width:7em;"{/if}>
<h3>{#latest_postings_hl#}</h3>
<ul id="latest-postings-container"{if $usersettings.latest_postings==0} style="display:none;"{/if}>
{foreach from=$latest_postings item=posting}<li><a href="index.php?id={$posting.id}" title="{$posting.name}, {$posting.formated_time}{if $posting.category_name} ({$posting.category_name}){/if}"{* onmouseover="highlight_posting('thread-{$posting.tid}','transparent','posting-{$posting.id}','#ff9')" onmouseout="highlight_posting('thread-{$posting.tid}','transparent','posting-{$posting.id}','transparent')"*}><span{if $visited && in_array($posting.id,$visited)} class="visited"{/if}>{if $posting.pid==0}<strong>{$posting.subject|truncate:29:"..."}</strong>{else}{$posting.subject|truncate:29:"..."}{/if}</span><br />
{if $posting.days_ago==0 && $posting.hours_ago==0}{#posting_minutes_ago#|replace:"[minutes]":$posting.minutes_ago}{elseif $posting.days_ago==0 && $posting.hours_ago!=0}{#posting_hours_ago#|replace:"[hours]":$posting.hours_ago|replace:"[minutes]":$posting.minutes_ago}{else}{#posting_days_ago#|replace:"[days]":$posting.days_ago|replace:"[hours]":$posting.hours_ago|replace:"[minutes]":$posting.minutes_ago}{/if}</a></li>{/foreach}
</ul>
</div>
{/if}
{if $tag_cloud}
<div id="tagcloud">
<h3>{#tag_cloud_hl#}</h3>
<p id="tagcloud-container">{foreach from=$tag_cloud item=tag}
{section name=strong_start start=0 loop=$tag.frequency}<strong>{/section}<a href="index.php?mode=search&amp;search={$tag.escaped}&amp;method=tags">{$tag.tag}</a> {section name=strong_end start=0 loop=$tag.frequency}</strong>{/section}
{/foreach}</p>
</div>
{/if}
{if $admin || $mod}
<div id="modmenu">
<h3>{#options#}</h3>
<ul>
<li><a href="index.php?mode=posting&amp;delete_marked=true"><img src="templates/{$template}/images/marked_link.png" alt="" width="13" height="9" />{#delete_marked_link#}</a></li>
<li><a href="index.php?mode=posting&amp;manage_postings=true"><img src="templates/{$template}/images/manage_postings.png" alt="" width="13" height="9" />{#manage_postings_link#}</a></li>
{if $show_spam_link}<li><a href="index.php?show_spam=true"><img src="templates/{$template}/images/spam_link.png" alt="" width="13" height="9" />{$smarty.config.show_spam_link|replace:"[number]":$total_spam}</a></li>{/if}
{if $hide_spam_link}<li><a href="index.php?show_spam=true"><img src="templates/{$template}/images/spam_link.png" alt="" width="13" height="9" />{$smarty.config.hide_spam_link|replace:"[number]":$total_spam}</a></li>{/if}
{if $delete_spam_link}<li><a href="index.php?mode=posting&amp;delete_spam=true"><img src="templates/{$template}/images/delete_small.png" alt="" width="13" height="9" />{#delete_spam_link#}</a></li>{/if}
</ul>
</div>{/if}
</div>
</div>
{/if}
{include file="$template/subtemplates/ajax_preview.tpl.inc"}
<script type="text/javascript">/* <![CDATA[ */
{if $admin || $mod}
function mk(id)
{literal}{{/literal}
mark(id,'templates/{$settings.template}/images/marked.png','templates/{$settings.template}/images/unmarked.png','templates/{$settings.template}/images/mark_process.png','{$smarty.config.mark_linktitle|escape:"url"}','{$smarty.config.unmark_linktitle|escape:"url"}');
{literal}}{/literal}
function dl(ths)
{literal}{{/literal}
return delete_posting_confirm(ths, '{$smarty.config.delete_posting_confirm_admin|escape:"url"}')
{literal}}{/literal}
{/if}
function ap(id,locked)
{literal}{{/literal}
var reply_link = typeof(locked) == 'undefined' || locked == 0 ? 1 : 0;
document.write(' <a href="#" onclick="ajax_preview('+id+','+reply_link+'); return false" title="{#ajax_preview_title#|escape:"quotes"}" onfocus="this.blur()"><img class="ap" src="templates/{$settings.template}/images/ajax_preview.png" title="{#ajax_preview_title#|escape:"quotes"}" alt="[…]" width="11" height="11" /><\/a>'); 
{literal}}{/literal}
{if $fold_threads==1}
function ft(id,replies)
{literal}{{/literal} 
if(replies > 0) document.write('<a id="expand_link_'+id+'" href="#" onclick="fold_thread('+id+',\'templates/{$settings.template}/images/expand_thread.png\',\'templates/{$settings.template}/images/fold_thread.png\'); return false" title="{#expand_fold_thread_linktitle#|escape:"quotes"}"><img id="expand_img_'+id+'" src="templates/{$settings.template}/images/expand_thread.png" title="{#expand_fold_thread_linktitle#|escape:"quotes"}" alt="[+]" width="9" height="11" /><\/a> ');
else document.write('<img id="expand_img_'+id+'" src="templates/{$settings.template}/images/expand_thread_inactive.png" alt="[+]" width="9" height="11" /> ');
{literal}}{/literal}
{/if}
/* ]]> */</script>
{if $tree}
{defun name="tree" list=$tree level=0}
{assign var=level value=$level+1}
{foreach from=$list item=element}
{if is_array($element)}<ul{if $level==1} id="thread-{$element.0}"{elseif $level>1 && $fold_threads==1} style="display:none;"{/if} class="{if $level==1}thread{elseif $level>1&&$level<$settings.deep_reply}reply{elseif $level>=$settings.deep_reply&&$level<$settings.very_deep_reply}deep-reply{else}very-deep-reply{/if}">{fun name="tree" list=$element level=$level}</li></ul>
{else}<li>{if $fold_threads==1 && $data.$element.pid==0}<script type="text/javascript">/* <![CDATA[ */ ft({$data.$element.id},{$data.$element.replies}) /* ]]> */</script>{/if}<a class="{if $data.$element.pid==0&&$newtime&&$newtime<$data.$element.last_reply||$data.$element.pid==0&&$last_visit&&$data.$element.last_reply>$last_visit}{if $data.$element.sticky==1}threadnew-sticky{else}threadnew{/if}{elseif $data.$element.pid==0}{if $data.$element.sticky==1}thread-sticky{else}thread{/if}{elseif $data.$element.pid!=0&&$newtime&&$newtime<$data.$element.time||$data.$element.pid!=0&&$last_visit&&$data.$element.time>$last_visit}replynew{else}reply{/if}{if $visited && in_array($data.$element.id,$visited)} visited{/if}" href="index.php?id={$data.$element.id}"{if $data.$element.spam==1} title="{#spam#}"{/if}>{if $data.$element.spam==1}<span class="spam">{$data.$element.subject}</span>{else}{$data.$element.subject}{/if}</a>{if $data.$element.no_text} <img class="no-text" src="templates/{$settings.template}/images/no_text.png" title="{#no_text_title#}" alt="{#no_text_alt#}" width="11" height="9" />{/if} - <strong>{if $data.$element.user_type==2}<span class="admin" title="{#administrator_title#}">{$data.$element.name}</span>{elseif $data.$element.user_type==1}<span class="mod" title="{#moderator_title#}">{$data.$element.name}</span>{else}{$data.$element.name}{/if}</strong>, {$data.$element.formated_time}<script type="text/javascript">/* <![CDATA[ */ ap({$data.$element.id}{if $data.$element.locked==1},1{/if}); /* ]]> */</script>{if $data.$element.pid==0} <a href="index.php?mode=thread&amp;id={$data.$element.id}" title="{#open_whole_thread#}"><img src="templates/{$settings.template}/images/complete_thread.png" title="{#open_whole_thread#}" alt="[*]" width="11" height="11" /></a>{/if}{if $admin || $mod} <a id="marklink_{$data.$element.id}" href="index.php?mode=posting&amp;mark={$data.$element.id}" title="{#mark_linktitle#}" onclick="mk({$data.$element.id}); return false" onfocus="this.blur()">{if $data.$element.marked==0}<img id="markimg_{$data.$element.id}" src="templates/{$settings.template}/images/unmarked.png" title="{#mark_linktitle#}" alt="[○]" width="11" height="11" />{else}<img id="markimg_{$data.$element.id}" src="templates/{$settings.template}/images/marked.png" title="{#unmark_linktitle#}" alt="[●]" width="11" height="11" title="{#unmark_linktitle#}" />{/if}</a> <a href="index.php?mode=posting&amp;delete_posting={$data.$element.id}&amp;back=index" title="{#delete_posting_title#}" onclick="return dl(this)"><img src="templates/{$template}/images/delete_small_2.png" title="{#delete_posting_title#}" alt="[x]" width="9" height="9" /></a>{/if}
{if $data.$element.pid==0 && $fold_threads==1} <span class="small" title="{if $data.$element.replies==0}{#no_replies#}{elseif $data.$element.replies==1}{#one_reply#}{else}{$smarty.config.several_replies|replace:"[replies]":$data.$element.replies}{/if}">({$data.$element.replies})</span>{/if}{if $data.$element.category_name && $data.$element.pid==0 && $category==0} <a href="index.php?mode=index&amp;category={$data.$element.category}" title="{#change_category_link#|replace:"[category]":$data.$element.category_name|escape:"html"}"><span class="category">({$data.$element.category_name|replace:" ":"&nbsp;"})</span></a>{/if}{/if}{/foreach}{/defun}
{else}<p>{if $category!=0}{#no_messages_in_category#}{else}{#no_messages#}{/if}</p>{/if}

{if $browse_array}<p class="pagebrowse">{if $page > 1}<a href="index.php?mode={$mode}&amp;page={$page-1}{if $category}&amp;category={$category}{/if}">{#previous_page_link#}</a>{/if}{if $page < $page_count}{if $page > 1 && $page < $page_count} - {/if}<a href="index.php?mode={$mode}&amp;page={$page+1}{if $category}&amp;category={$category}{/if}">{#next_page_link#}</a>{/if}</p>{/if}