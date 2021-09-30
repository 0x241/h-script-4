{strip}
{include file='admin/admin/header.tpl' title=$_AT['News']}

{include file='list_admin.tpl'
	title=$_AT['News']
	url='*'
	fields=[
		'nID'=>[$_AT['ID']],
		'nTS'=>[$_AT['Date']],
		'nAnnounce'=>[$_AT['Announce']],
		'nDBegin'=>[$_AT['Show from']],
		'nDEnd'=>[$_AT['To']],
		'nAttn'=>[$_AT['<small>Important</small>']|html_entity_decode]
	]
	values=$list
	row='*'
	btns=['del'=>$_AT['Delete']]
}

<a href="{_link module='news/admin/news'}?add" class="button-blue">{$_AT['Add news']}</a><br>

{include file='admin/admin/footer.tpl'}
{/strip}