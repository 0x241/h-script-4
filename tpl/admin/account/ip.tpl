{strip}
 {include file='admin/admin/header.tpl' title='IP Usage'}

	<h2> Statistics for IP:{$smarty.get.ip}</h2>

	{include file='list_admin.tpl'
	url='*'
	fields=[
		'uID'=>['ID'],
		'uLogin'=>['Login'],
    	'aCIP'=>['IP reg'],
    	'uLIP'=>['IP auth']
	]
	values=$list
    linkparams="&ip={$smarty.get.ip}"
	row='*'
}



{include file='admin/admin/footer.tpl'}
{/strip}