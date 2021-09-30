{strip}
<ul class="{$class}">
	{foreach from=$elements item=e}
		{if !$e.skip}
			{include file='menu.element.tpl' module=$e[0] text=$e[1] text2=$e[2] text3=$e[3] count=$e.count submenu=$e.submenu params=$e.params}
		{/if}
	{/foreach}
</ul>
{/strip}