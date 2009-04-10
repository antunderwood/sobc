{config_load file=$settings.language_file section="user_edit"}
{if $errors}
<p class="caution">{#error_headline#}</p>
<ul>
{section name=mysec loop=$errors}
{assign var="error" value=$errors[mysec]}
<li>{$smarty.config.$error|replace:"[profile_length]":$profil_length|replace:"[profile_maxlength]":$settings.profile_maxlength|replace:"[signature_length]":$signature_length|replace:"[signature_maxlength]":$settings.signature_maxlength|replace:"[word]":$word}</li>
{/section}
</ul>
{/if}
{if $msg}<p class="ok">{$smarty.config.$msg}</p>{/if}
<form action="index.php" method="post" accept-charset="{#charset#}">
<div>
<input type="hidden" name="mode" value="user" />
<table class="normaltab" border="0" cellpadding="5" cellspacing="1">
<tr>
<td class="c"><strong>{#edit_user_name#}</strong></td>
<td class="d"><strong>{$user_name}</strong></td>
</tr>
{if $settings.avatars>0}
<tr>
<td class="c"><strong>{#edit_avatar#}</strong></td>
<td class="d"><span id="avatar">{if $avatar}<a href="index.php?mode=avatar" title="{#edit_avatar_link_title#}" onclick="popup('index.php?mode=avatar'); return false"><img src="{$avatar.image}" alt="{#edit_avatar_link_title#}" width="{$avatar.width}" height="{$avatar.height}" /></a>{else}<span class="small">[ <a href="index.php?mode=avatar" onclick="popup('index.php?mode=avatar'); return false">{#add_avatar_link#}</a> ]</span>{/if}</span></td>
</tr>
{/if}
<tr>
<td class="c"><strong>{#edit_user_pw#}</strong></td>
<td class="d"><span class="small">[ <a href="index.php?mode=user&amp;action=edit_pw">{#edit_pw#}</a> ]</span></td>
</tr>
<tr>
<td class="c"><strong>{#edit_user_email#}</strong></td>
<td class="d"><!--<a href="mailto:{$user_email}">-->{$user_email}<!--</a>--> &nbsp;<span class="small">[ <a href="index.php?mode=user&amp;action=edit_email">{#edit_email#}</a> ]</span><br />
<span class="small"><input id="email_contact" type="checkbox" name="email_contact" value="1"{if $email_contact==1} checked="checked"{/if} /><label for="email_contact">{#edit_user_email_contact#}</label></span></td>
</tr>
<tr>
<td class="c"><label for="user_hp"><strong>{#edit_user_hp#}</strong></label></td>
<td class="d"><input id="user_hp" type="text" size="40" name="user_hp" value="{$user_hp}" maxlength="{$settings.hp_maxlength}" /></td>
</tr>
<tr>
<td class="c"><label for="user_real_name"><strong>{#edit_user_real_name#}</strong></label></td>
<td class="d"><input id="user_real_name" type="text" size="40" name="user_real_name" value="{$user_real_name}" maxlength="{$settings.name_maxlength}" /></td>
</tr>
<tr>
<td class="c"><strong>{#edit_user_gender#}</strong></td>
<td class="d">
<input id="male" type="radio" name="user_gender" value="1"{if $user_gender=="1"} checked="checked"{/if} /><label for="male">{#male#}</label><br />
<input id="female" type="radio" name="user_gender" value="2"{if $user_gender=="2"} checked="checked"{/if} /><label for="female">{#female#}</label></td>
</tr>
<tr>
<td class="c"><label for="user_birthday"><strong>{#edit_user_birthday#}</strong></label></td>
<td class="d"><input id="user_birthday" type="text" size="40" name="user_birthday" value="{$user_birthday}" /> <span class="small">({#birthday_format#})</span></td>
</tr>
<tr>
<td class="c"><label for="user_location"><strong>{#edit_user_location#}</strong></label></td>
<td class="d"><input id="user_location" type="text" size="40" name="user_location" value="{$user_location}" maxlength="{$settings.location_maxlength}" /></td>
</tr>
<tr>
<td class="c"><label for="profile"><strong>{#edit_user_profile#}</strong></label></td>
<td class="d"><textarea id="profile" cols="65" rows="12" name="profile">{$profile}</textarea></td>
</tr>
<tr>
<td class="c"><label for="signature"><strong>{#edit_user_signature#}</strong></label></td>
<td class="d"><textarea id="signature" cols="65" rows="4" name="signature">{$signature}</textarea></td>
</tr>
<tr>
<td class="c"><label for="user_time_difference"><strong>{#edit_user_time_diff#}</strong></label></td>
<td class="d"><p><input id="user_time_difference" type="text" size="6" name="user_time_difference" value="{$user_time_difference}" maxlength="6" /> <span class="small">({#time_diff_format#})</span></p>
<p class="xsmall">{#current_forum_time#|replace:"[time]":$forum_time}</p></td>
</tr>
{if $mod||$admin}
<tr>
<td class="c"><strong>{#edit_user_notification#}</strong></td>
<td class="d"><input id="new_posting_notification" type="checkbox" name="new_posting_notification" value="1"{if $new_posting_notification=="1"} checked="checked"{/if} /><label for="new_posting_notification">{#admin_mod_notif_posting#}</label><br />
<input id="new_user_notification" type="checkbox" name="new_user_notification" value="1"{if $new_user_notification=="1"} checked="checked"{/if} /><label for="new_user_notification">{#admin_mod_notif_register#}</label></td>
</tr>
{/if}
<tr>
<td class="c">&nbsp;</td>
<td class="d"><input type="submit" name="edit_user_submit" value="{#userdata_submit_button#}" /></td>
</tr>
</table>
</div>
</form>
