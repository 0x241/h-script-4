{strip}
{include file='admin/admin/header.tpl' title=$_AT['Settings']}

{include file='edit_admin.tpl'
	values=$cfg
	fields=[
		'ShowCount'=>['I', $_AT['Rows count in page']],
		'InBlock'=>['I', $_AT['Random records rows count']],
		'_Cats'=>['A', $_AT['Categories<br><<one line - one category>>']|html_entity_decode, 'size'=>20]
	]
}

{include file='admin/admin/footer.tpl'}
{/strip}