{strip}
{include file='admin/admin/header.tpl' title=$_AT['Send SMS']}

{include file='edit_admin.tpl'
	fields=[
		'From' => ['T', $_AT['Sender << empty - "default" >>']|html_entity_decode, ['from_wrong' => $_AT['invalid sender']]],
        'To' => ['T', $_AT['Number of the recipient'], ['to_wrong' => $_AT['invalid number of the recipient']]],
        'Text' => ['W', $_AT['Text'], ['msg_empty' => $_AT['enter message'], 'msg_too_long' => $_AT['Message too long']], 'size' => 5]
	]
	btn_text=' '
	btns=['send'=>$_AT['Send']]
}

{include file='admin/admin/footer.tpl'}
{/strip}