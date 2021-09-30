{strip}
{include file='admin/admin/header.tpl' title=$_AT['Support']}

{include file='tickets/_states.tpl'}

{include file='list_admin.tpl'
	title=$_AT['Tickets']
	url='*'
	fields=[
		'tID'=>[$_AT['ID']],
		'tLTS'=>[$_AT['Date']],
		'uLogin'=>[$_AT['Sender']],
		'tTopic'=>[$_AT['Subject']],
		'tText'=>[$_AT['Text']],
		'tState'=>[$_AT['State']],
		'cnt'=>[$_AT['Response']]
	]
	values=$list
	row='*'
	btns=['del'=>$_AT['Delete']]
}

<a href="{_link module='tickets/admin/ticket'}?add" class="button-blue">{$_AT['Create']}</a><br>

{include file='admin/admin/footer.tpl'}
{/strip}