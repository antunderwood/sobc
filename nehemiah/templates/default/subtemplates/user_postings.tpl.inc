{if $user_postings_data}
{include file="$template/subtemplates/ajax_preview.tpl.inc"}
<p>{if $user_postings_count>1}{$smarty.config.several_postings_by_user|replace:"[number]":$user_postings_count}{else}{#one_posting_by_user#}{/if}</p>
<ul class="searchresults">
{section name=ix loop=$user_postings_data}
<li><a class="{if $user_postings_data[ix].pid==0}thread-search{else}reply-search{/if} {if $visited && in_array($user_postings_data[ix].id,$visited)} visited{/if}" href="index.php?mode=entry&amp;id={$user_postings_data[ix].id}">{$user_postings_data[ix].subject}</a> - <strong>{$user_postings_data[ix].name}</strong>, {$user_postings_data[ix].disp_time|date_format:#time_format#}<script type="text/javascript">/* <![CDATA[ */document.write(' <a href="#" onclick="ajax_preview({$user_postings_data[ix].id}); return false" title="{#ajax_preview_title#|escape:"quotes"}"><img class="ap" src="templates/{$settings.template}/images/ajax_preview.png" alt="{#ajax_preview_title#|escape:"quotes"}" width="11" height="11" /><\/a>')/* ]]> */</script> <a href="index.php?mode=thread&amp;id={$user_postings_data[ix].id}" title="{#open_whole_thread#}"><img src="templates/{$settings.template}/images/complete_thread.png" alt="{#open_whole_thread#}" width="11" height="11" /></a> {if $user_postings_data[ix].category}<a href="index.php?mode=index&amp;category={$user_postings_data[ix].category}"><span class="category">({$user_postings_data[ix].category_name})</span></a>{/if}</li>
{/section}
</ul>
{if $show_posts_browse && $show_posts_browse.total_items > $show_posts_browse.items_per_page}
<p>
{if $show_posts_browse.previous_page!=0}
<a href="index.php?mode={$mode}{if $action}&amp;action={$action}{/if}{if $id}&amp;id={$id}{/if}{if $show_posts_browse.previous_page>1}&amp;page={$show_posts_browse.previous_page}{/if}">&laquo;</a>
{/if}
{section name=x loop=$show_posts_browse.browse_array}
{if $show_posts_browse.browse_array[x]==$show_posts_browse.page}
<span style="color:red;">{$show_posts_browse.browse_array[x]}</span>
{elseif $show_posts_browse.browse_array[x]==0}
..
{else}
<a href="index.php?mode={$mode}{if $action}&amp;action={$action}{/if}{if $id}&amp;id={$id}{/if}{if $show_posts_browse.browse_array[x]>1}&amp;page={$show_posts_browse.browse_array[x]}{/if}">{$show_posts_browse.browse_array[x]}</a>
{/if}
{/section}
{if $show_posts_browse.next_page!=0}
<a href="index.php?mode={$mode}{if $action}&amp;action={$action}{/if}{if $id}&amp;id={$id}{/if}&amp;page={$show_posts_browse.next_page}">&raquo;</a>
{/if}
</p>
{/if}
{else}
<p>{#no_postings_by_user#}</p>
{/if}
