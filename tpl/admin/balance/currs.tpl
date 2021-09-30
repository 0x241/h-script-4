{strip}
{include file='admin/admin/header.tpl' title=$_AT['Pay.systems']}

{include file='list_admin.tpl'
	title=$_AT['Pay.systems']
	url='*'
	fields=[
		'cID'=>[$_AT['ID']],
		'cCID'=>[$_AT['Code']],
		'cName'=>[$_AT['Title']],
		'cCurr'=>[$_AT['Currency']],
		'cBal'=>['Balance'],
		'cAPI'=>[$_AT['API']],
		'cDisable'=>[$_AT['<small>Disabled.</small>']|html_entity_decode],
		'cCASHIN'=>[$_AT['<small>Add funds</small>']|html_entity_decode],
		'cCASHOUT'=>[$_AT['<small>Withdraw</small>']|html_entity_decode],
		'cEX'=>[$_AT['<small>Exch.</small>']|html_entity_decode],
		'cTR'=>[$_AT['<small>Transf.</small>']|html_entity_decode],
		'cBUY'=>[$_AT['<small>Buy</small>']|html_entity_decode],
		'cSELL'=>[$_AT['<small>Sale</small>']|html_entity_decode],
		'cBUY2'=>[$_AT['<small>Service</small>']|html_entity_decode],
		'cSELL2'=>[$_AT['<small>Sale service</small>']|html_entity_decode],
		'cGIVE'=>[$_AT['<small>Deposit</small>']|html_entity_decode],
		'cTAKE'=>[$_AT['<small>Removal</small>']|html_entity_decode],
		'cHidden'=>[$_AT['<small>Hidden</small>']|html_entity_decode]
	]
	values=$list
	row='*'
	btns=['del'=>$_AT['Delete']]
}

<a href="{_link module='balance/admin/curr'}?add" class="button-blue">{$_AT['Add pay.system']}</a><br>

{include file='admin/admin/footer.tpl'}
{/strip}