{config_load file=$settings.language_file section="entry"}
{*{assign var=formated_time value=$disp_time|date_format:#time_format_full#}*}
{assign var=template value=$settings.template}
{assign var=email_alt value=$smarty.config.email}
{assign var=homepage_alt value=$smarty.config.homepage}
{if $hp && !$email}
{assign var=email_hp value=" <a href=\"$hp\"><img src=\"templates/$template/images/homepage.png\" title=\"$homepage_alt\" alt=\"⌂\" width=\"13\" height=\"13\" /></a>"}
{elseif !$hp && $email}
{assign var=email_hp value=" <a href=\"index.php?mode=contact&amp;id=$id\"><img src=\"templates/$template/images/email.png\" title=\"$email_alt\" alt=\"@\" width=\"13\" height=\"10\" /></a>"}
{elseif $hp && $email}
{assign var=email_hp value=" <a href=\"$hp\"><img src=\"templates/$template/images/homepage.png\" title=\"$homepage_alt\" alt=\"⌂\" width=\"13\" height=\"13\" /></a> <a href=\"index.php?mode=contact&amp;id=$id\"><img src=\"templates/$template/images/email.png\" title=\"$email_alt\" alt=\"@\" width=\"13\" height=\"10\" /></a>"}
{else}
{assign var=email_hp value=""}
{/if}
{if $user_type==2}
{assign var=admin_title value=$smarty.config.administrator_title}
{assign var=name value="<span class=\"admin\" title=\"$admin_title\">$name</span>"}
{elseif $user_type==1}
{assign var=mod_title value=$smarty.config.moderator_title}
{assign var=name value="<span class=\"mod\" title=\"$mod_title\">$name</span>"}
{else}
{assign var=name value="$name"}
{/if}
{if $posting_user_id>0 && ($user || $settings.user_area_public==1)}{assign var=name value="<a href=\"index.php?mode=user&amp;show_user=$posting_user_id\">$name</a>"}{/if}
<div class="posting">{if $spam}<p class="spam-note">{#spam_note#}</p>{/if}
{if $avatar}<img class="avatar" src="{$avatar.image}" alt="{#avatar_img_alt#}" width="{$avatar.width}" height="{$avatar.height}" />{/if}
<h1>{$subject}{if $category_name} <span class="category">({$category_name})</span>{/if}</h1>
<p class="author">{if $location}{#posted_by_location#|replace:"[name]":$name|replace:"[email_hp]":$email_hp|replace:"[location]":$location|replace:"[time]":$formated_time}{else}{#posted_by#|replace:"[name]":$name|replace:"[email_hp]":$email_hp|replace:"[time]":$formated_time}{/if}{if $admin} <span class="ip">({$ip})</span>{/if}{if $pid!=0} <span class="op-link"><a href="index.php?id={$pid}" title="{#original_posting_linktitle#|replace:"[name]":$data.$pid.name}">@ {$data.$pid.name}</a></span>{/if}{if $edited}<br />
<span class="edited">{#edited_by#|replace:"[name]":$edited_by|replace:"[time]":$formated_edit_time}</span>{/if}</p>
{if $posting}
{$posting}
{else}
<p>{#no_text#}</p>
{/if}
{if $signature}
<p class="signature">---<br />
{$signature}</p>
{/if}
{if $tags}
<p class="tags">{#tags_marking#}<br />
{foreach name="tags" from=$tags item=tag}<a href="index.php?mode=search&amp;search={$tag.escaped}&amp;method=tags">{$tag.display}</a>{if !$smarty.foreach.tags.last}, {/if}{/foreach}</p>
{/if}
</div>
<div class="postingbottom">
<div class="postinganswer">{if $locked==0}<a class="stronglink" href="index.php?mode=posting&amp;id={$id}&amp;back=entry" title="{#reply_link_title#}">{#reply_link#}</a>{else}<span class="locked"><img src="templates/{$template}/images/lock.png" alt="" width="14" height="12" />{#posting_locked#}</span>{/if}</div>
<div class="postingedit">&nbsp;
{if $views}<span class="xsmall">{if $views==1}{#one_view#}{else}{#several_views#|replace:"[views]":$views}{/if}</span>{/if}
{if $edit_authorization} &nbsp;<span class="small"><a href="index.php?mode=posting&amp;edit={$id}&amp;back=entry" title="{#edit_message_linktitle#}"><img src="templates/{$template}/images/edit_small.png" alt="" width="15" height="10" />{#edit_message_linkname#}</a></span>{/if}
{if $delete_authorization} &nbsp;<span class="small"><a href="index.php?mode=posting&amp;delete_posting={$id}&amp;back=entry" title="{#delete_message_linktitle#}" onclick="return delete_posting_confirm(this, '{if $admin||$mod}{$smarty.config.delete_posting_confirm_admin|escape:"url"}{else}{$smarty.config.delete_posting_confirm|escape:"url"}{/if}')"><img src="templates/{$template}/images/delete_small.png" alt="" width="13" height="9" />{#delete_message_linkname#}</a></span>{/if}
{if $move_posting_link} &nbsp;<span class="small"><a href="index.php?mode=posting&amp;move_posting={$id}&amp;back=entry" title="{#move_posting_linktitle#}"><img src="templates/{$template}/images/move_posting.png" alt="" width="14" height="10" />{#move_posting_linkname#}</a></span>{/if}
{if $report_spam_link} &nbsp;<span class="small"><a href="index.php?mode=posting&amp;report_spam={$id}&amp;back=entry" title="{#report_spam_linktitle#}"><img src="templates/{$template}/images/spam_link.png" alt="" width="13" height="9" />{#report_spam_linkname#}</a></span>{/if}
{if $flag_ham_link} &nbsp;<span class="small"><a href="index.php?mode=posting&amp;flag_ham={$id}&amp;back=entry" title="{#flag_ham_linktitle#}"><img src="templates/{$template}/images/spam_link.png" alt="" width="13" height="9" />{#flag_ham_linkname#}</a></span>{/if}
{if $admin || $mod} &nbsp;<span class="small"><a href="index.php?mode=posting&amp;lock={$id}&amp;back=entry" title="{if $locked==0}{#lock_linktitle#}{else}{#unlock_linktitle#}{/if}"><img src="templates/{$template}/images/{if $locked==0}lock.png{else}unlock.png{/if}" alt="" width="14" height="12" />{if $locked==0}{#lock_linkname#}{else}{#unlock_linkname#}{/if}</a></span>{if $pid==0} &nbsp;<span class="small"><a href="index.php?mode=posting&amp;lock_thread={$id}&amp;back=entry" title="{#lock_thread_linktitle#}"><img src="templates/{$template}/images/lock_thread.png" alt="" width="14" height="12" />{#lock_thread_linkname#}</a></span> &nbsp;<span class="small"><a href="index.php?mode=posting&amp;unlock_thread={$id}&amp;back=entry" title="{#unlock_thread_linktitle#}"><img src="templates/{$template}/images/unlock_thread.png" alt="" width="14" height="12" />{#unlock_thread_linkname#}</a></span>{/if}{/if}
</div></div>

{* Displays direct replies: *}
{*
{if $direct_replies}
<hr class="entryline" />
<div class="complete-thread">
<p class="left"><strong>{#direct_replies_marking#}</strong></p><p class="right">&nbsp;</p>
</div>
<ul class="complete-thread">
{foreach from=$direct_replies item=reply}
<li><a class="{if $newtime&&$newtime<$data.$reply.time||$last_visit&&$data.$reply.time>$last_visit}replynew{else}reply{/if}" href="index.php?id={$data.$reply.id}">{$data.$reply.subject}</a> - <strong>{$data.$reply.name}</strong>, {$data.$reply.time|date_format:#time_format#} <a href="#" onclick="ajax_preview({$data.$reply.id},'{#reply_link#}'); return false" title="{#ajax_preview_title#}"><img src="templates/{$settings.template}/images/ajax_preview.png" title="{#ajax_preview_title#}" alt="[…]" width="11" height="11" /></a></li>
{/foreach}
</ul>
{/if}
*}

{* Displays the complete thread: *}
<hr class="entryline" />
<div class="complete-thread">
<p class="left"><strong>{#complete_thread_marking#}</strong></p><p class="right">&nbsp;{if $settings.rss_feed==1}<img src="templates/{$template}/images/rss_link.png" alt="" width="13" height="9" /><a href="index.php?mode=rss&amp;thread={$tid}" title="{#rss_feed_thread_title#}">{#rss_feed_thread#}</a>{/if}</p>
</div>
{defun name="tree" list=$tree level=0}
{assign var=level value=$level+1}
{foreach from=$list item=element}
{if is_array($element)}<ul class="{if $level==1}complete-thread{elseif $level>1&&$level<$settings.deep_reply}reply{elseif $level>=$settings.deep_reply&&$level<$settings.very_deep_reply}deep-reply{else}very-deep-reply{/if}">{fun name="tree" list=$element level=$level}</li></ul>
{else}<li>{if $data.$element.id!=$id}<a class="{if $data.$element.pid==0&&$newtime&&$newtime<$data.$element.last_reply||$data.$element.pid==0&&$last_visit&&$data.$element.last_reply>$last_visit}threadnew{elseif $data.$element.pid==0}thread{elseif $data.$element.pid!=0&&$newtime&&$newtime<$data.$element.time||$data.$element.pid!=0&&$last_visit&&$data.$element.time>$last_visit}replynew{else}reply{/if}{if $visited && in_array($data.$element.id,$visited)} visited{/if}" href="index.php?id={$data.$element.id}">{$data.$element.subject}</a>{else}<span class="{if $data.$element.pid==0}actthread{else}actreply{/if}">{$data.$element.subject}</span>{/if}{if $data.$element.no_text} <img class="no-text" src="templates/{$settings.template}/images/no_text.png" title="{#no_text_title#}" alt="{#no_text_alt#}" width="11" height="9" />{/if} - <strong>{$data.$element.name}</strong>, {$data.$element.formated_time}{if $data.$element.id!=$id} <a href="#" onclick="ajax_preview({$data.$element.id},'{#reply_link#}'); return false" title="{#ajax_preview_title#}"><img src="templates/{$settings.template}/images/ajax_preview.png" title="{#ajax_preview_title#}" alt="[…]" width="11" height="11" /></a>{/if}{if $data.$element.pid==0} <a href="index.php?mode=thread&amp;id={$data.$element.id}" title="{#open_whole_thread#}"><img src="templates/{$settings.template}/images/complete_thread.png" title="{#open_whole_thread#}" alt="[*]" width="11" height="11" /></a>{/if}{if $admin || $mod} <a id="marklink_{$data.$element.id}" href="index.php?mode=posting&amp;mark={$data.$element.id}&amp;back={$id}" title="{#mark_linktitle#}" onclick="mark({$data.$element.id},'templates/{$settings.template}/images/marked.png','templates/{$settings.template}/images/unmarked.png','templates/{$settings.template}/images/mark_process.png','{#mark_linktitle#}','{#unmark_linktitle#}'); return false">{if $data.$element.marked==0}<img id="markimg_{$data.$element.id}" src="templates/{$settings.template}/images/unmarked.png" title="{#mark_linktitle#}" alt="[○]" width="11" height="11" />{else}<img id="markimg_{$data.$element.id}" src="templates/{$settings.template}/images/marked.png" title="{#unmark_linktitle#}" alt="[●]" width="11" height="11" title="{#unmark_linktitle#}" />{/if}</a> <a href="index.php?mode=posting&amp;delete_posting={$data.$element.id}&amp;back=entry" title="{#delete_posting_title#}" onclick="return delete_posting_confirm(this, '{$smarty.config.delete_posting_confirm|escape:"url"}')"><img src="templates/{$template}/images/delete_small_2.png" alt="[x]" width="9" height="9" /></a>{/if}{if $data.$element.category_name && $data.$element.pid==0 && $category==0} <a href="index.php?mode=index&amp;category={$data.$element.category}"><span class="category">({$data.$element.category_name})</span></a>{/if}
{/if}
{/foreach}
{/defun}

{* Displays the current branch only: *} 
{*
<hr class="entryline" />
<div class="complete-thread">
<p class="left"><strong>{#branch_marking#}</strong></p><p class="right">&nbsp;{if $settings.rss_feed==1 && $pid==0}<img src="templates/{$template}/images/rss_link.png" alt="" width="13" height="9" /><a href="index.php?mode=rss&amp;thread={$tid}">{#rss_feed_thread#}</a>{/if}</p>
</div>
{defun name="tree" list=$branch level=0}
{assign var=level value=$level+1}
{foreach from=$list item=element}
{if is_array($element)}<ul class="{if $level==1}complete-thread{elseif $level>1&&$level<$settings.deep_reply}reply{elseif $level>=$settings.deep_reply&&$level<$settings.very_deep_reply}deep-reply{else}very-deep-reply{/if}">{fun name="tree" list=$element level=$level}</li></ul>
{else}<li>{if $data.$element.id!=$id}<a class="{if $data.$element.pid==0&&$newtime&&$newtime<$data.$element.last_reply||$data.$element.pid==0&&$last_visit&&$data.$element.last_reply>$last_visit}threadnew{elseif $data.$element.pid==0}thread{elseif $data.$element.pid!=0&&$newtime&&$newtime<$data.$element.time||$data.$element.pid!=0&&$last_visit&&$data.$element.time>$last_visit}replynew{else}reply{/if}" href="index.php?id={$data.$element.id}">{$data.$element.subject}</a>{else}<span class="{if $data.$element.pid==0}actthread{else}actreply{/if}">{$data.$element.subject}</span>{/if} - <strong>{$data.$element.name}</strong>, {$data.$element.time|date_format:#time_format#} <a href="#" onclick="ajax_preview({$data.$element.id},'{#reply_link#}'); return false" title="{#ajax_preview_title#}"><img src="templates/{$settings.template}/images/ajax_preview.png" title="{#ajax_preview_title#}" alt="[…]" width="11" height="11" /></a>{if $data.$element.pid==0} <a href="index.php?mode=thread&amp;id={$data.$element.id}" title="{#open_whole_thread#}"><img src="templates/{$settings.template}/images/complete_thread.png" alt="{#open_whole_thread#}" width="11" height="11" /></a>{/if}{if $admin || $mod} <a id="marklink_{$data.$element.id}" href="index.php?mode=posting&amp;mark={$data.$element.id}&amp;back={$id}" title="{#mark_linktitle#}" onclick="mark({$data.$element.id},'templates/{$settings.template}/images/marked.png','templates/{$settings.template}/images/unmarked.png','templates/{$settings.template}/images/mark_process.png','{#mark_linktitle#}','{#unmark_linktitle#}'); return false">{if $data.$element.marked==0}<img id="markimg_{$data.$element.id}" src="templates/{$settings.template}/images/unmarked.png" alt="[ ]" width="11" height="11" />{else}<img id="markimg_{$data.$element.id}" src="templates/{$settings.template}/images/marked.png" alt="[x]" width="11" height="11" title="{#unmark_linktitle#}" />{/if}</a> <a href="index.php?mode=posting&amp;delete_posting={$data.$element.id}&amp;back=entry" title="{#delete_posting_title#}" onclick="return delete_posting_confirm(this, '{$smarty.config.delete_posting_confirm|escape:"url"}')" title="{#delete_posting_title#}"><img src="templates/{$template}/images/delete_small_2.png" alt="x" width="9" height="9" /></a>{/if}{if $data.$element.category_name && $data.$element.pid==0 && $category==0} <a href="index.php?mode=index&amp;category={$data.$element.category}"><span class="category">({$data.$element.category_name})</span></a>{/if}
{/if}
{/foreach}
{/defun}
*}

{include file="$template/subtemplates/ajax_preview.tpl.inc"}
