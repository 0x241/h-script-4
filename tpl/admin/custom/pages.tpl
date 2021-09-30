{strip}
{include file='admin/admin/header.tpl' title=$_AT['Custom pages']}

{include file='list_admin.tpl'
	title=$_AT['Custom pages']
	url='*'
	fields=[
		'pID'=>[$_AT['ID']],
		'pTopic'=>[$_AT['Title']],
		'pHidden'=>[$_AT['<small>Disabled</small>']|html_entity_decode],
		'URL'=>[$_AT['Link']]
	]
	values=$list
	row='*'
	btns=['del'=>$_AT['Delete']]
}

<a href="{_link module='custom/admin/page'}?add" class="button-blue">{$_AT['Add custom page']}</a><br>

{include file='admin/admin/footer.tpl'}
{/strip}