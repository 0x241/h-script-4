{strip}
{include file='admin/admin/header.tpl' title=$_AT['Settings']}

{*, 0, $_AT['- disabled -', 'epochta.ru']*}
{include file='edit_admin.tpl'
	values=$cfg
	fields=[
		'Prov'=>['S', $_AT['Provider'], 0, array('- disabled -', 'epochta.ru')],
		'From'=>['T', $_AT['Sender << 14 numeric characters <br> or 11 alphanumeric (English letters and numbers) >>']|html_entity_decode],
		'SendCount'=>['I', $_AT['Send messages to no more than a minute in N']],
		'UpdateCount'=>['I', $_AT['Update the status messages, no more than a minute in N']],
		1=>$_AT['Confirmation operations'],
		'REG'=>['C', $_AT['Registration']],
		'CASHOUT'=>['C', $_AT['Cashout']],
		'epochta.ru',
		'EP_Login'=>['T', $_AT['Login << e-mail >>']|html_entity_decode],
    	'EP_Pass'=>['*', $_AT['Password']]
	]
	btn_text=$_AT['Save']
}
{*		'smspilot.ru',
		'SP_Pass'=>['*', 'API-ключ']*}

{include file='admin/admin/footer.tpl'}
{/strip}