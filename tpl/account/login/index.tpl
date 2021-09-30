{strip}
{include file='header.tpl' title=$_TRANS['Login'] class="cabinet"}

<h1>{$_TRANS['Login']}</h1>

{if isset($smarty.get.ip_changed)}

	<h2>{$_TRANS['Security system']}</h2>
	<p class="info">
		{$_TRANS['You are trying to access your account from a different IP-addresses']}.<br>
		{$_TRANS['To continue']} <a href="{_link module='confirm'}">{$_TRANS['input confirmation code']}</a><br> {$_TRANS['or click on the link that was sent to your e-mail']}
	</p>

{elseif isset($smarty.get.brute_force)}

	<h2>{$_TRANS['Security system']}</h2>
	<p class="info">
		{$_TRANS['Password has been entered incorrectly multiple times']}.<br>
		{$_TRANS['To continue']} <a href="{_link module='confirm'}">{$_TRANS['input confirmation code']}</a><br>
		{$_TRANS['or click on the link that was sent to your e-mail']}
	</p>

{else}

	{if $url}
		{$_TRANS['Page']} "<i>...{$url}</i>" {$_TRANS['requires authorization']}<br><br>
	{/if}
	{if $_cfg.Sys_LockSite}
		<p class="info">
			{$_TRANS['Currently on the site are technical works']}.<br>
			{$_TRANS['Login <b>only</b> for staff']|html_entity_decode}
		</p>
	{/if}

	{include file='account/login/box.tpl'}

	{if !$_cfg.Sys_LockSite}
		<br>
		<a href="{_link module='account/reset_pass'}">{$_TRANS['Forgot password']}</a><br>
		{if $_cfg.Account_RegMode >= 0}<a href="{_link module='account/register'}">{$_TRANS['I do not have a login']}</a><br>{/if}
		<a href="{_link module='confirm'}">{$_TRANS['Confirm']}</a> {$_TRANS['or']} <a href="{_link module='account/change_mail'}">{$_TRANS['change e-mail']}</a>
		<br>
	{/if}

{/if}

{include file='footer.tpl' class="cabinet"}
{/strip}