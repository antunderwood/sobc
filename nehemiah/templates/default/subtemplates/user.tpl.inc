{config_load file=$settings.language_file section="user"}
<div class="usernav">
<div class="usersearch">
<label for="search_user">{#search_user#}</label><form action="index.php" method="get" accept-charset="{#charset#}">
<div style="display:inline;">
<input type="hidden" name="mode" value="user" />
<input id="search_user" type="text" name="search_user" value="{if $search_user}{$search_user}{/if}" size="25" />&nbsp;<input type="image" src="templates/{$settings.template}/images/submit.png" alt="[&raquo;]" />
</div>
</form>
</div>
<div class="userbrowse">
{if $user_page_browse && $user_page_browse.total_items > $user_page_browse.items_per_page}
{if $user_page_browse.previous_page!=0}
<a href="index.php?mode={$mode}{if $action}&amp;action={$action}{/if}{if $search_user_encoded}&amp;search_user={$search_user_encoded}{/if}{if $method && $method!='fulltext'}&amp;method={$method}{/if}{if $id}&amp;id={$id}{/if}{if $user_page_browse.previous_page>1}&amp;page={$user_page_browse.previous_page}{/if}{if $p_category && $p_category>0}&amp;p_category={$p_category}{/if}{if $order}&amp;order={$order}{/if}{if $descasc}&amp;descasc={$descasc}{/if}">&laquo;</a>
{/if}
{section name=x loop=$user_page_browse.browse_array}
{if $user_page_browse.browse_array[x]==$user_page_browse.page}
<span style="color:red;">{$user_page_browse.browse_array[x]}</span>
{elseif $user_page_browse.browse_array[x]==0}
..
{else}
<a href="index.php?mode={$mode}{if $action}&amp;action={$action}{/if}{if $search_user_encoded}&amp;search_user={$search_user_encoded}{/if}{if $method && $method!='fulltext'}&amp;method={$method}{/if}{if $id}&amp;id={$id}{/if}{if $user_page_browse.browse_array[x]>1}&amp;page={$user_page_browse.browse_array[x]}{/if}{if $p_category && $p_category>0}&amp;p_category={$p_category}{/if}{if $order}&amp;order={$order}{/if}{if $descasc}&amp;descasc={$descasc}{/if}">{$user_page_browse.browse_array[x]}</a>
{/if}
{/section}
{if $user_page_browse.next_page!=0}
<a href="index.php?mode={$mode}{if $action}&amp;action={$action}{/if}{if $search_user_encoded}&amp;search_user={$search_user_encoded}{/if}{if $method && $method!='fulltext'}&amp;method={$method}{/if}{if $id}&amp;id={$id}{/if}&amp;page={$user_page_browse.next_page}{if $p_category && $p_category>0}&amp;p_category={$p_category}{/if}{if $order}&amp;order={$order}{/if}{if $descasc}&amp;descasc={$descasc}{/if}">&raquo;</a>
{/if}
{else}
&nbsp;
{/if}
</div>
</div>
{if $total_users > 0}
<table class="normaltab" border="0" cellpadding="5" cellspacing="1">
<tr>
<th><a href="index.php?mode=user{if $search_user_encoded}&amp;search_user={$search_user_encoded}{/if}&amp;order=user_name&amp;descasc={if $descasc=="ASC" && $order=="user_name"}DESC{else}ASC{/if}&amp;ul={$ul}" title="{#order_linktitle#}">{#user_name#}</a>{if $order=="user_name" && $descasc=="ASC"}&nbsp;<img src="templates/{$settings.template}/images/asc.png" alt="[asc]" width="5" height="9" />{elseif $order=="user_name" && $descasc=="DESC"}&nbsp;<img src="templates/{$settings.template}/images/desc.png" alt="[desc]" width="5" height="9" />{/if}</th>
<th><a href="index.php?mode=user{if $search_user_encoded}&amp;search_user={$search_user_encoded}{/if}&amp;order=user_type&amp;descasc={if $descasc=="ASC" && $order=="user_type"}DESC{else}ASC{/if}&amp;ul={$ul}" title="{#order_linktitle#}">{#user_type#}</a>{if $order=="user_type" && $descasc=="ASC"}&nbsp;<img src="templates/{$settings.template}/images/asc.png" alt="[asc]" width="5" height="9" />{elseif $order=="user_type" && $descasc=="DESC"}&nbsp;<img src="templates/{$settings.template}/images/desc.png" alt="[desc]" width="5" height="9" />{/if}</th>
<th>{#user_hp#}</th>
<th>{#user_email#}</th>
<th>{#user_postings#}</th>
{if $settings.count_users_online>0}<th>{#user_online#}</th>{/if}
{if $mod || $admin}<th><a href="index.php?mode=user{if $search_user_encoded}&amp;search_user={$search_user_encoded}{/if}&amp;order=user_lock&amp;descasc={if $descasc=="ASC" && $order=="user_lock"}DESC{else}ASC{/if}&amp;ul={$ul}" title="{#order_linktitle#}">{#user_blockage#}</a>{if $order=="user_lock" && $descasc=="ASC"}&nbsp;<img src="templates/{$settings.template}/images/asc.png" alt="[asc]" width="5" height="9" />{elseif $order=="user_lock" && $descasc=="DESC"}&nbsp;<img src="templates/{$settings.template}/images/desc.png" alt="[desc]" width="5" height="9" />{/if}</th>{/if}
</tr>
{foreach from=$userdata item=row}
{cycle values="a,b" assign=c}
<tr>
<td class="{$c}"><a href="index.php?mode=user&amp;show_user={$row.user_id}" title="{#show_userdata_linktitle#|replace:"[user]":$row.user_name}"><strong>{$row.user_name}</strong></a></td>
<td class="{$c}"><span class="small">{if $row.user_type==2}{#admin#}{elseif $row.user_type==1}{#mod#}{else}{#user#}{/if}</span></td>
<td class="{$c}"><span class="small">{if $row.user_hp!=''}<a href="{$row.user_hp}" title="{$row.user_hp}"><img src="templates/{$settings.template}/images/homepage.png" alt="{#homepage#}" width="13" height="13" /></a>{else}&nbsp;{/if}</span></td>
<td class="{$c}"><span class="small">{if $row.user_email}<a href="index.php?mode=contact&amp;user_id={$row.user_id}" title="{#mailto_user#|replace:"[user]":$row.user_name}"><img src="templates/{$settings.template}/images/email.png" alt="{#email#}" width="13" height="10" /></a>{else}&nbsp;{/if}</span></td>
<td class="{$c}"><span class="small">{if $row.postings>0}<a href="index.php?mode=user&amp;action=show_posts&amp;id={$row.user_id}">{$row.postings}</a>{else}{$row.postings}{/if}</span></td>
{if $settings.count_users_online>0}<td class="{$c}"><span class="small">{if $row.online}<span style="color:red;">{#online#}</span>{else}&nbsp;{/if}</span></td>{/if}
{if $mod || $admin}<td class="{$c}"><span class="small">{if $row.user_type>0}{if $row.user_lock==0}{#unlocked#}{else}{#locked#}{/if}{elseif $row.user_lock==0}<a href="index.php?mode=user{if $search_user_encoded}&amp;search_user={$search_user_encoded}{/if}&amp;user_lock={$row.user_id}&amp;page={$page}&amp;order={$order}&amp;descasc={$descasc}" title="{#lock_title#}">{#unlocked#}</a>{else}<a style="color: red;" href="index.php?mode=user{if $search_user_encoded}&amp;search_user={$search_user_encoded}{/if}&amp;user_lock={$row.user_id}&amp;page={$page}&amp;order={$order}&amp;descasc={$descasc}" title="{#unlock_title#}">{#locked#}</a>{/if}</span></td>{/if}
</tr>
{/foreach}
</table>
<div class="usernav-bottom">
{if $user_page_browse && $user_page_browse.total_items > $user_page_browse.items_per_page}
{if $user_page_browse.previous_page!=0}
<a href="index.php?mode={$mode}{if $action}&amp;action={$action}{/if}{if $search_user_encoded}&amp;search_user={$search_user_encoded}{/if}{if $method && $method!='fulltext'}&amp;method={$method}{/if}{if $id}&amp;id={$id}{/if}{if $user_page_browse.previous_page>1}&amp;page={$user_page_browse.previous_page}{/if}{if $p_category && $p_category>0}&amp;p_category={$p_category}{/if}{if $order}&amp;order={$order}{/if}{if $descasc}&amp;descasc={$descasc}{/if}">&laquo;</a>
{/if}
{section name=x loop=$user_page_browse.browse_array}
{if $user_page_browse.browse_array[x]==$user_page_browse.page}
<span style="color:red;">{$user_page_browse.browse_array[x]}</span>
{elseif $user_page_browse.browse_array[x]==0}
..
{else}
<a href="index.php?mode={$mode}{if $action}&amp;action={$action}{/if}{if $search_user_encoded}&amp;search_user={$search_user_encoded}{/if}{if $method && $method!='fulltext'}&amp;method={$method}{/if}{if $id}&amp;id={$id}{/if}{if $user_page_browse.browse_array[x]>1}&amp;page={$user_page_browse.browse_array[x]}{/if}{if $p_category && $p_category>0}&amp;p_category={$p_category}{/if}{if $order}&amp;order={$order}{/if}{if $descasc}&amp;descasc={$descasc}{/if}">{$user_page_browse.browse_array[x]}</a>
{/if}
{/section}
{if $user_page_browse.next_page!=0}
<a href="index.php?mode={$mode}{if $action}&amp;action={$action}{/if}{if $search_user_encoded}&amp;search_user={$search_user_encoded}{/if}{if $method && $method!='fulltext'}&amp;method={$method}{/if}{if $id}&amp;id={$id}{/if}&amp;page={$user_page_browse.next_page}{if $p_category && $p_category>0}&amp;p_category={$p_category}{/if}{if $order}&amp;order={$order}{/if}{if $descasc}&amp;descasc={$descasc}{/if}">&raquo;</a>
{/if}
{/if}
</div>
{else}
<p><em>{#no_users#}</em></p>
{/if}
