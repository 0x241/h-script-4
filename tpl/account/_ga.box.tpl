{if !$user.aGA}
	<input name="GAKey" value="{$GACode}" type="hidden">
	{$_TRANS['GA_enable']}<br>
	<big>{$GACode}</big><br>
	<img src="{$GAQR}">
{else}
	{$_TRANS['GA_disable']}
{/if}