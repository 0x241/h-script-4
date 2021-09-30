{strip}
{include file='admin/admin/header.tpl' title=$_AT['Plans']}
{include file='list_admin.tpl'
	title=$_AT['Plans']
	url='*'
	fields=[
		'pID'=>[$_AT['ID']],
		'pHidden'=>[$_AT['<small>Hidden</small>']|html_entity_decode],
		'pNoCalc'=>[$_AT['<small>No accruals</small>']|html_entity_decode],
		'pGroup'=>[$_AT['Group']],
		'pName'=>[$_AT['Title']],
		'pMin'=>[$_AT['Min']],
		'pMax'=>[$_AT['Max']],
		'pDays'=>[$_AT['Duration']],
		'pPerc'=>[$_AT['<small>Profit</small>']|html_entity_decode],
		'z'=>[$_AT['<small>All deposits</small>']|html_entity_decode],
		'za'=>[$_AT['<small>Active deposits</small>']|html_entity_decode]
	]
	values=$list
	row='*'
	btns=['del'=>$_AT['Delete']]
}

<a href="{_link module='depo/admin/plan'}?add" class="button-blue">{$_AT['Add plan']}</a><br>

{include file='admin/admin/footer.tpl'}
{/strip}