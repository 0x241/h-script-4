{strip}
{include file='admin/admin/header.tpl' title=$_AT['Manual accruals']}

{if $_cfg.Depo_ChargeMode == 2}

	<p class="info">
		{$_AT['There will be <b>single</b> interest accrual<br>at the']} {$cdate} {$_AT['on all deposits that have marked plans']}
	</p>

	{include file='list_admin.tpl'
		title=$_AT['Manual accrual']
		url='*'
		fields=[
			'pID'=>[$_AT['ID']],
			'pHidden'=>[$_AT['Hidden']],
			'pName'=>[$_AT['Plan']],
			'pMin'=>[$_AT['Min']],
			'pMax'=>[$_AT['Max']],
			'pDays'=>[$_AT['Dur.']],
			'pPerc'=>[$_AT['<small>Perc.</small>']|html_entity_decode],
			'cnt'=>[$_AT['<small>Deposits</small>']|html_entity_decode]
		]
		values=$list
		row='*'
		btns=['del'=>$_AT['Make accrual']]
	}

	<a href="{_link module='balance/admin/opers'}" class="button-green">{$_AT['Operations']}</a><br>

{elseif $_cfg.Depo_ChargeMode == 1}

	<p class="info">
		{$_AT['Accrual occurs']} <a href="{_link module='depo/admin/setup'}">{$_AT['automatically']}</a>
	</p>

{else}

	<p class="info">
		{$_AT['Accruals are']} <a href="{_link module='depo/admin/setup'}">{$_AT['disabled']}</a>
	</p>

{/if}

{include file='admin/admin/footer.tpl'}
{/strip}