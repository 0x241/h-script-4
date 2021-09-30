{strip}
{include file='admin/admin/header.tpl' title=$_AT['Settings']}

{include file='edit_admin.tpl'
	values=$cfg
	fields=[
		'Mode'=>['S', $_AT['Mode'], '', [0=>$_AT['only support'], 1=>$_AT['support and private message'], 2=>$_AT['all']]],
		'NoMail'=>['C', $_AT['Do not send alerts to e-mail']],
		'ShowCount'=>['I', $_AT['Rows count on page']],
		1=>$_AT['Support'],
		'Captcha'=>['S', $_AT['Protect by "captcha"'], 0, [0=>$_AT['no'], 1=>$_AT['auto'], 2=>$_AT['always']]],
		'_Cats'=>['A', $_AT['Category'], 'size'=>20]
	]
}

{include file='admin/admin/footer.tpl'}
{/strip}