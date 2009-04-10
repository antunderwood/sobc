{if $mode=='index'}
{if $user}<a href="index.php?update=1&amp;category={$category}"><img class="reload" src="templates/{$settings.template}/images/plain.png" alt="[&loz;]" title="{#reload_linktitle#}" width="11" height="11" /></a>{/if}
{if $thread_order==0} &nbsp;<span class="small"><a href="index.php?mode=index&amp;thread_order=1" title="{#order_link_title_1#}"><img src="templates/{$settings.template}/images/order.png" alt="" width="12" height="9" />{#order_link#}</a></span>{else} &#160;<span class="small"><a href="index.php?mode=index&amp;thread_order=0" title="{#order_link_title_2#}"><img src="templates/{$settings.template}/images/order.png" alt="" width="12" height="9" />{#order_link#}</a></span>{/if}
{if $usersettings.fold_threads==0} &nbsp;<span class="small"><a href="index.php?fold_threads=true" title="{#fold_threads_linktitle#}"><img src="templates/{$settings.template}/images/fold_threads.png" alt="" width="12" height="9" />{#fold_threads#}</a></span>{else} &#160;<span class="small"><a href="index.php?fold_threads=true" title="{#expand_threads_linktitle#}"><img src="templates/{$settings.template}/images/fold_threads.png" alt="" width="12" height="9" />{#expand_threads#}</a></span>{/if}
{if $usersettings.user_view==0} &nbsp;<span class="small"><a href="index.php?toggle_view=true" title="{#table_view_linktitle#}"><img src="templates/{$settings.template}/images/table_view.png" alt="" width="12" height="9" />{#table_view#}</a></span>{else} &#160;<span class="small"><a href="index.php?toggle_view=true" title="{#thread_view_linktitle#}"><img src="templates/{$settings.template}/images/thread_view.png" alt="" width="12" height="9" />{#thread_view#}</a></span>{/if}
{elseif $mode=='entry'}
<span class="small"><a href="index.php?mode=thread&amp;id={$tid}#p{$id}" title="{#open_in_thread_linktitle#}"><img src="templates/{$settings.template}/images/open_thread.png" alt="" width="13" height="8" />{#open_in_thread_link#}</a></span>
{elseif $mode=='thread'}
{if $usersettings.thread_display==0}<span class="small"><a href="index.php?mode=thread&amp;id={$id}&amp;toggle_thread_display=true" title="{#thread_linear_linktitle#}"><img src="templates/{$settings.template}/images/thread_linear.png" alt="" width="12" height="8" />{#thread_linear#}</a></span>{else}<span class="small"><a href="index.php?mode=thread&amp;id={$id}&amp;toggle_thread_display=true" title="{#thread_hierarchical_linktitle#}"><img src="templates/{$settings.template}/images/thread_hierarchical.png" alt="" width="12" height="8" />{#thread_hierarchical#}</a></span>{/if}
<script type="text/javascript">/* <![CDATA[ */document.write('&nbsp; <span class="small"><a href="#" onclick="hide_all_postings(\'templates/{$template}/images/show_posting.png\'); return false" onfocus="this.blur()" title="{#hide_all_messages_title#|escape:"quotes"}"><img src="templates/{$settings.template}/images/collapse_messages.png" alt="" width="12" height="9" />{#hide_all_messages#|escape:"quotes"}</a> &nbsp;<a href="#" onclick="show_all_postings(\'templates/{$template}/images/hide_posting.png\'); return false" onfocus="this.blur()" title="{#show_all_messages_title#|escape:"quotes"}"><img src="templates/{$settings.template}/images/expand_messages.png" alt="" width="12" height="9" />{#show_all_messages#|escape:"quotes"}</a></span>');/* ]]> */</script>
{/if}
{if $categories && $mode=='index'}
&nbsp;<form action="index.php" method="get" accept-charset="{#charset#}"><div class="inline">
<input type="hidden" name="mode" value="{$mode}" />
{if $category}<input type="hidden" name="category" value="{$category}" />{/if}
<select class="kat" size="1" name="category" onchange="this.form.submit();" title="{#category_title#}">
<option value="0"{if $category==0} selected="selected"{/if}>{#all_categories#}</option>
{foreach key=key item=val from=$categories}
{if $key!=0}<option value="{$key}"{if $key==$category} selected="selected"{/if}>{$val}</option>{/if}
{/foreach}
</select><noscript><div class="inline"><input class="kat" type="submit" value="&raquo;" title="{#go#}" /></div></noscript></div></form>{/if}
{if $browse_array}
{if $item_count > $items_per_page}&nbsp; {if $page > 1}<a href="index.php?mode={$mode}&amp;page={$page-1}{if $category}&amp;category={$category}{/if}"><img class="previous" src="templates/{$settings.template}/images/plain.png" alt="[&laquo;]" title="{#previous_page_link_title#}" width="6" height="11" /></a>{/if}
<form action="index.php" method="get"><div class="inline">
<input type="hidden" name="mode" value="{$mode}" />
{if $order}<input type="hidden" name="order" value="{$order}" />{/if}
{if $category}<input type="hidden" name="category" value="{$category}" />{/if}
<select class="kat" size="1" name="page" onchange="this.form.submit();" title="{#page_title#}">
{section name=x loop=$browse_array}
{if $browse_array[x]!=0}<option value="{$browse_array[x]}"{if $browse_array[x]==$page} selected="selected"{/if}>{$browse_array[x]}</option>{/if}
{/section}
</select><noscript><div class="inline"><input class="kat" type="submit" value="&raquo;" title="{#go#}" /></div></noscript>
</div></form>
{if $page < $page_count}<a href="index.php?mode={$mode}&amp;page={$page+1}{if $category}&amp;category={$category}{/if}"><img class="next" src="templates/{$settings.template}/images/plain.png" alt="[&raquo;]" title="{#next_page_link_title#}" width="6" height="11" /></a>{/if}
{/if}
{/if}
