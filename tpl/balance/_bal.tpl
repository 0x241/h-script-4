{strip}
{if $currs}
	{include file='balance/bal.tpl'}
{else}
	{$_TRANS['<b>No funds</b> on your balance']|html_entity_decode}
{/if}
{/strip}
