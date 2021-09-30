{strip}
<div class="_block">
	{$_TRANS['Left panel']}<br>

	{if $_cfg.Depo_ShowStat}
		<div>
			<h2>Statistics</h2>
			{include file='depo/block.stat.tpl' stat=$leftstat}
		</div>
	{/if}

	{if $_cfg.News_InBlock > 0}
		<div>
			<h2>News</h2>
			{include file='news/block.tpl' list=$leftnews}
		</div>
	{/if}

	{if $_cfg.FAQ_InBlock > 0}
		<div>
			<h2>FAQ</h2>
			{include file='faq/block.tpl' list=$leftfaqs}
		</div>
	{/if}

	{if $_cfg.Review_InBlock > 0}
		<div>
			<h2>Reviews</h2>
			{include file='review/block.tpl' list=$leftreview}
		</div>
	{/if}

</div>
{/strip}