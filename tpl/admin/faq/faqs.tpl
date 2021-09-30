{strip}
{include file='admin/admin/header.tpl' title=$_AT['FAQ']}

{include file='list_admin.tpl'
	title=$_AT['FAQ']
	url='*'
	fields=[
		'fID'=>[$_AT['ID']],
		'fCTS'=>[$_AT['<small>Creation date</small>']|html_entity_decode],
		'fHidden'=>[$_AT['<small>Hidden</small>']|html_entity_decode],
		'fCat'=>[$_AT['Category']],
		'fQuestion'=>[$_AT['Question']],
		'fAnswer'=>[$_AT['Answer']],
		'fOrder'=>[$_AT['<small>Sorting order</small>']|html_entity_decode]
	]
	values=$list
	row='*'
	btns=['del'=>$_AT['Delete']]
}

<a href="{_link module='faq/admin/faq'}?add" class="button-blue">{$_AT['Add question']}</a><br>

{include file='admin/admin/footer.tpl'}
{/strip}