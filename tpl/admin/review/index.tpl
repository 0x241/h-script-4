{strip}
{include file='admin/admin/header.tpl' title=$_AT['Reviews']}

{include file='list_admin.tpl'
	title=$_AT['Reviews']
	url='*'
	fields=[
		'oID'=>[$_AT['ID']],
		'oTS'=>[$_AT['Date']],
		'uLogin'=>[$_AT['Author']],
		'oText'=>[$_AT['Text']],
		'oState'=>[$_AT['<small>Approved</small>']|html_entity_decode],
		'oOrder'=>[$_AT['<small>Weight</small>']|html_entity_decode]
	]
	values=$list
	row='*'
	btns=['accept'=>$_AT['Approve'], 'del'=>$_AT['Delete']]
}

{include file='admin/admin/footer.tpl'}
{/strip}