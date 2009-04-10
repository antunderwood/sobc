{config_load file=$settings.language_file section="general"}{config_load file=$settings.language_file section="upload_image"}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{#language#}">
<head>
<title>{$settings.forum_name}{if $page_title} - {$page_title}{elseif $subnav_location} - {$subnav_location}{/if}</title>
<meta http-equiv="content-type" content="text/html; charset={#charset#}" />
<style type="text/css">
{literal}
<!--
body          { color: #000000; background: #ffffff; margin: 20px; padding: 0px; font-family: verdana, arial, sans-serif; font-size: 13px; }
h1            { font-family: verdana, arial, sans-serif; font-size: 18px; font-weight: bold; }
p             { font-family: verdana, arial, sans-serif; font-size: 13px; line-height: 19px; }
.caution      { padding: 0px 0px 0px 20px; color: red; font-weight: bold; background-image:url(templates/{/literal}{$settings.template}{literal}/images/caution.png); background-repeat:no-repeat; background-position: left; }
.ok           { padding: 0px 0px 0px 20px; font-weight:bold; color:red; background-image:url(templates/{/literal}{$settings.template}{literal}/images/tick.png); background-repeat:no-repeat; background-position: left; }
img.uploaded  { border: 1px solid #000; cursor:pointer; }
.small        { font-size:11px; line-height:16px; }
code          { font-family:"courier new", courier; color:#000080; }
a:link        { color: #0000cc; text-decoration: none; }
a:visited     { color: #0000cc; text-decoration: none; }
a:hover       { color: #0000ff; text-decoration: underline; }
a:active      { color: #ff0000; text-decoration: none; }
-->
{/literal}
</style>
</head>
<body>
{if $form}
<h1>{#upload_image_hl#}</h1>
{if $errors}
<p class="caution">{#error_headline#}</p>
<ul>
{section name=mysec loop=$errors}
<li>{assign var="error" value=$errors[mysec]}{$smarty.config.$error|replace:"[width]":$width|replace:"[height]":$height|replace:"[filesize]":$filesize|replace:"[max_width]":$max_width|replace:"[max_height]":$max_height|replace:"[max_filesize]":$max_filesize|replace:"[server_max_filesize]":$server_max_filesize}</li>
{/section}
</ul>
{/if}
<form id="uploadform" action="index.php" method="post" enctype="multipart/form-data" accept-charset="{#charset#}">
<div>
<input type="hidden" name="mode" value="upload_image" />
<p><input type="file" name="probe" size="17" /></p>
<p><input type="submit" name="" value="{#upload_image_button#}" onclick="document.getElementById('throbber-submit').style.visibility='visible'" /> <img id="throbber-submit" style="visibility:hidden;" src="templates/{$settings.template}/images/throbber_submit.gif" alt="" width="16" height="16" /></p>
</div>
</form>
<p class="small"><a href="index.php?mode=upload_image&amp;browse_images=1">{#browse_uploaded_images#}</a></p>
{elseif $uploaded_file}
<h1>{#upload_image_hl#}</h1>
<p class="ok">{#upload_successful#}</p>
<script type="text/javascript">/* <![CDATA[ */document.write('<p>{#insert_image_exp#|escape:quotes}<\/p>'); /* ]]> */</script>
<noscript><p>{#insert_image_exp_no_js#}</p>
<p><code>[img]images/uploaded/{$uploaded_file}[/img]</code></p></noscript>
<img class="uploaded" src="images/uploaded/{$uploaded_file}" title="{#insert_image#}" onclick="opener.insert('text','[img]images/uploaded/{$uploaded_file}[/img]'); window.close()" height="100" alt="{#insert_image#}" />
{if $image_downsized}<p class="small">{$smarty.config.image_downsized|replace:"[width]":$new_width|replace:"[height]":$new_height|replace:"[filesize]":$new_filesize}</p>{/if}
{elseif $browse_images}
<p class="small"><a href="index.php?mode=upload_image">{#upload_image#}</a></p>
<p>
{section name=nr loop=$images start=$start max=$images_per_page}
<img class="uploaded" src="images/uploaded/{$images[nr]}" title="{#insert_image#}" onclick="opener.insert('text','[img]images/uploaded/{$images[nr]}[/img]'); window.close()" height="100" alt="{#insert_image#}" />
{sectionelse}
{#no_images#}
{/section}
</p>
<p>{if $previous}[ <a href="index.php?mode=upload_image&amp;browse_images={$previous}">&laquo;</a> ]{/if}{if $previous && next} {/if}{if $next}[ <a href="index.php?mode=upload_image&amp;browse_images={$next}">&raquo;</a> ]{/if}
{else}
<p class="caution">{#image_upload_not_enabled#}</p> 
{/if}
</body>
</html>
