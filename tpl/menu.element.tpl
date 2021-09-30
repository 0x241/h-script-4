{strip}
<li{if ($module == $tpl_module) or ($module == $tpl_vmodule) or $current} class="current"{/if}>
	<a href="{_link module=$module}{if $params}?{$params}{/if}">
		{$text}
		{if $text2}
			<span>{$text2}</span>
		{/if}
		{if $count > 0}
			<b><sup>{$count}</sup></b>
		{/if}
	</a>
	{if $submenu}
		<ul>
			{foreach from=$submenu item=sm}
				<li>
					<a href="{_link module=$sm[0]}">
						{$sm[1]}
					</a>
				</li>
			{/foreach}
		</ul>
	{/if}
</li>
{/strip}