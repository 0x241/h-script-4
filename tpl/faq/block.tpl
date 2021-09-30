{strip}
{if $list}
	{if $_cfg.FAQ_InBlock == 1}
		{$l = reset($list)}
		<div>
			<h3>{$l.fQuestion}</h3>
			<div>
				<small>{$l.fCat}</small><br>
				{$l.fAnswer}
			</div>
		</div>
	{else}
		{foreach name=list from=$list key=id item=l}
			<div>
				<h3>{$l.fQuestion}</h3>
				<div>
					<small>{$l.fCat}</small><br>
					{$l.fAnswer|truncate:40}
				</div>
			</div>
		{/foreach}
	{/if}
{/if}
{/strip}