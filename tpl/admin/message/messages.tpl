{strip}
{include file='admin/admin/header.tpl' title=$_AT['Messages']}

{include file='list_admin.tpl'
	title=$_AT['Messages']
	url='*'
	fields=[
		'bID'=>[$_AT['ID']],
		'mTS'=>[$_AT['Date']],
		'uLogin'=>[$_AT['Sender']],
		'To'=>[$_AT['Receivers']],
		'mTopic'=>[$_AT['Topic']],
		'mText'=>[$_AT['Text']]
	]
	values=$list
	row='*'
	btns=['del'=>$_AT['Delete']]
}

<a href="{$root_url}admin/message?add" class="button-green">{$_AT['New message']}</a><br>

{include file='admin/admin/footer.tpl'}
{/strip}