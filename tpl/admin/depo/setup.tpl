{strip}
{include file='admin/admin/header.tpl' title=$_AT['Settings']}

{if ($_cfg.Depo_ChargeMode == 1) and !$_cfg.Cron_Enabled}

	<p class="info">
		{$_AT['For automatic accruals']} <a href="{_link module='cron/admin/setup'}">{$_AT['Scheduler']}</a> {$_AT['must be <b>enabled</b>']|html_entity_decode}
	</p>

{/if}

{include file='edit_admin.tpl'
	values=$cfg
	fields=[
		'OneFromGroup'=>['C', $_AT['Avalible only one plan from group']],
		'AutoDepo'=>['C', $_AT['Automatically make deposit after add funds']],
		'Interval'=>['I', $_AT['Activate deposits are not more than 1 time in N minutes<br><<0 - no limits>>']|html_entity_decode],
		'LastTime'=>['X', $_AT['Activation date of the last deposit'], 0, $depolasttime, 'comment'=>valueIf($depolast < 0, "{$_AT['after']} {-$depolast} $_AT['min.']", "$depolast "|cat:$_AT['min. ago']), 'skip'=>(abs($depolast) >= 60)],'skip'=>(abs($depolast) >= 60),
		'ChargeMode'=>['S', $_AT['Accruals'], 0, [0=>$_AT['off'], 1=>$_AT['each in its time (automatic)'], 2=>$_AT['all at the same time (manual)']]],
		1=>$_AT['Manual accruals'],
		'ManualPeriod'=>['S', $_AT['Accrual once in'], 0, [0=>$_AT['day'], 1=>$_AT['week'], 2=>$_AT['month']]],
		'ManualDay'=>['I', $_AT['Day number <<1..7>> or month <<1..31>>']|html_entity_decode, 'comment'=>$_AT['0 = last day']],
		$_AT['Calculator'],
		'_Compnd'=>['A', $_AT['Reinvest percs']|html_entity_decode, 'size'=>5],
		$_AT['Statistics'],
		'ShowStat'=>['C', 'Show statistics'],
		'S0'=>['DT', $_AT['Date and time stamp of start <<YYYYMMDDhhmmss>>']|html_entity_decode, 'comment'=>20130924130000],
		'S1'=>['I', $_AT['Total users']],
		'zinUSD'=>['$', $_AT['Total add funds USD']],
		'zinEUR'=>['$', $_AT['Total add funds EUR']],
		'zinRUB'=>['$', $_AT['Total add funds RUB']],
		'zinBTC'=>['$', $_AT['Total add funds BTC']],
		'zinETH'=>['$', $_AT['Total add funds ETH']],
		'zinXRP'=>['$', $_AT['Total add funds XRP']],
		'zoutUSD'=>['$', $_AT['Total withdraws USD']],
		'zoutEUR'=>['$', $_AT['Total withdraws EUR']],
		'zoutRUB'=>['$', $_AT['Total withdraws RUB']],
		'zoutBTC'=>['$', $_AT['Total withdraws BTC']],
		'zoutETH'=>['$', $_AT['Total withdraws ETH']],
		'zoutXRP'=>['$', $_AT['Total withdraws XRP']],
		'zrefUSD'=>['$', $_AT['Total ref.comm USD']],
		'zrefEUR'=>['$', $_AT['Total ref.comm EUR']],
		'zrefRUB'=>['$', $_AT['Total ref.comm RUB']],
		'zrefBTC'=>['$', $_AT['Total ref.comm BTC']],
		'zrefETH'=>['$', $_AT['Total ref.comm ETH']],
		'zrefXRP'=>['$', $_AT['Total ref.comm XRP']]
	]
}

{include file='admin/admin/footer.tpl'}
{/strip}