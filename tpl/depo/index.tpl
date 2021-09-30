{strip}
{include file='header.tpl' title=$_TRANS['Deposits'] class="cabinet"}

<h1>{$_TRANS['Deposits']}</h1>

{include file='depo/depolist.js'}
{include file='depo/timer.js'}

{include file='depo/_statuses.tpl'}

{if $list}

	{include file='list.tpl'
		url='*'
		table_class='styleTable'
		fields=[
			'dID'=>[$_TRANS['ID']],
			'dCTS'=>[$_TRANS['Created']],
			'dZD'=>[$_TRANS['Amount']],
			'pName'=>[$_TRANS['Plan']],
			'dLTS'=>[$_TRANS['Last accrual']],
			'dN'=>[$_TRANS['Accruals count']],
			'dZP'=>[$_TRANS['<small>Profit</small>']|html_entity_decode],
			'dNTS'=>[$_TRANS['Next accrual']],
			'dState'=>[$_TRANS['State']]
		]
		values=$list
		row='*'
	}

{else}

	{$_TRANS['You <b>do not have deposits']|html_entity_decode}</b>
	<br>
	<br>

{/if}

<a href="{_link module='depo/depo'}?add" class="button-green">{$_TRANS['Make deposit']}</a>

{include file='footer.tpl' class="cabinet"}
{/strip}