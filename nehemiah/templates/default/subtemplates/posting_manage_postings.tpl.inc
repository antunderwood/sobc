{config_load file=$settings.language_file section="manage_postings"}
{if $no_authorisation}
<p class="caution">{$smarty.config.$no_authorisation}</p>
{else}
{assign var='input_days' value='<input type="text" name="days" value="" size="5" />'}
<h1>{#manage_postings_hl#}</h1>
<form action="index.php" method="post" accept-charset="{#charset#}">
<div style="margin-top:30px;">
<input type="hidden" name="mode" value="posting" />
<p>{$smarty.config.lock_old_threads|replace:"[days]":$input_days} <input type="submit" name="lock_old_threads_submit" value="{#submit_button_ok#}" /></p>
<p>{#lock_all_threads#} <input type="submit" name="lock_all_threads_submit" value="{#submit_button_ok#}" /></p>
<p>{#unlock_all_threads#} <input type="submit" name="unlock_all_threads_submit" value="{#submit_button_ok#}" /></p>
</div>
</form>
{/if}
