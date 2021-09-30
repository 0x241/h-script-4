{strip}
{if count($pl_params.Pages) > 0}
	<div class="paginator">
		<small>{$_TRANS['Page']} {$pl_params.Page} {$_TRANS['of']} {$pl_params.PagesCount}</small>
		{if count($pl_params.Pages) > 0}&nbsp;&nbsp;&nbsp;{/if}
		{foreach from=$pl_params.Pages key=i item=pn}
			<a href="{$_selfLink}?page={$pn[1]}{$linkparams}" class="{if $pn[1] == $pl_params.Page}pgactive{else}pgbutton{/if}">
				{if $pn[0] == '&lt;&lt;'}
					{$_TRANS['First']}
				{elseif $pn[0] == '&lt;'}
					{$_TRANS['Back']}
				{elseif $pn[0] == '&gt;'}
					{$_TRANS['Forward']}
				{elseif $pn[0] == '&gt;&gt;'}
					{$_TRANS['Last']}
				{else}
					{$pn[0]}
				{/if}
			</a>
		{/foreach}
	</div>
{/if}
{/strip}