{strip}
<div{if $class} class="{$class}"{/if}>
	{foreach from=$elements item=e}
		{if !$e.skip}
			{include file='links.element.tpl' module=$e[0] text=$e[1] text2=$e[2] text3=$e[3] count=$e.count params=$e.params}
		{/if}
	{/foreach}
</div>
{/strip}