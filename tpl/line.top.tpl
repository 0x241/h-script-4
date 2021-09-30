{strip}
<div class="_topLine">
	<div class="topLinks">
	<table class="formatTable" width="100%">
	<tr>
		<td align="left">
			{include file='links.tpl'
				elements=[
					['index', $_TRANS['Main']],
					['news', $_TRANS['News']],
					['cabinet', $_TRANS['Cabinet'], 'skip'=>!_uid()],
					['admin', $_TRANS['Control panel'], 'count'=>$count_aopers, 'skip'=>($user.uLevel < 90)]
				]
			}
		</td>
		<td align="right">
			{if _uid()}
				{include file='links.element.tpl' module='account' text=$user.aName}
				{include file='links.element.tpl' module='balance' text=$_TRANS['Balance']}
				{_z($user.uBalUSD, 'USD', 2)}&nbsp;&nbsp;
				{_z($user.uBalEUR, 'EUR', 2)}&nbsp;&nbsp;
				{_z($user.uBalRUB, 'RUB', 2)}&nbsp;&nbsp;
				{_z($user.uBalBTC, 'BTC', 2)}&nbsp;&nbsp;
				{_z($user.uBalETH, 'ETH', 2)}&nbsp;&nbsp;
				{_z($user.uBalXRP, 'XRP', 2)}&nbsp;&nbsp;
				{include file='links.element.tpl' module='account/login' params='out' text=$_TRANS['Logout']}
			{else}
				{if $_cfg.RegMode >= 0}
					{include file='links.element.tpl' module='account/register' text=$_TRANS['Registration']}
				{/if}
				{include file='links.element.tpl' module='account/login' text=$_TRANS['Login']}
			{/if}
		</td>
		<td align="right" width="100px">
			{include file='widget/clock/index.tpl'}
		</td>
	</tr>
	</table>
	</div>
</div>
{/strip}