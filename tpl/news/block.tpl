{strip}
{if $list}
	{if $_cfg.News_InBlock == 1}
		{$l = reset($list)}
		<div>
			<a href="{_link module='news/show' chpu=[$l.nID, $l.nTopic]}">
				<h3>{$l.nTopic}</h3>
			</a>
			<small>{$l.nTS}</small>{if $l.nAttn}&nbsp;&nbsp;&nbsp;<b style="color: red;">{$_TRANS['Important']}!</b>{/if}
			<div>
				{$l.nAnnounce|nl2br}
			</div>
		</div>
	{else}
		{foreach name=list from=$list key=id item=l}
			<div>
				<a href="{_link module='news/show' chpu=[$l.nID, $l.nTopic]}">
					<h3>{$l.nTopic}</h3>
				</a>
				<small>{$l.nTS}</small>{if $l.nAttn}&nbsp;&nbsp;&nbsp;<b style="color: red;">{$_TRANS['Important']}!</b>{/if}
				<div>
					{$l.nAnnounce|nl2br|truncate:100}
				</div>
			</div>
		{/foreach}
	{/if}
{/if}
{/strip}