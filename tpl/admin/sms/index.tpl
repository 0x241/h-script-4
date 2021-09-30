{strip}
{include file='admin/admin/header.tpl' title=$_AT['Queue']}

{include file='sms/_statuses.tpl'}

{include file='list_admin.tpl'
	title=$_AT['Queue']
	url='*'
	fields=[
		'qID' => [$_AT['ID']],
	    'uLogin' => [$_AT['Sent']],
	    'qFromTo' => [$_AT['To']],
	    'qText' => [$_AT['Text']],
	    'qState' => [$_AT['Status']],
	    'qPartsPrice' => [$_AT['<small> Number <br> parts </small>']|html_entity_decode],
	    'qError' => [$_AT['description']],
	    'qErrCnt' => [$_AT['<small> attempted </small>']|html_entity_decode]
	]
	values=$list
	row='*'
	btns=['del'=>$_AT['Delete']]
}

{include file='admin/admin/footer.tpl'}
{/strip}