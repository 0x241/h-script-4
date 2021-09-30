{strip}
    {include file='admin/admin/header.tpl' title='IP Table'}

	<h2> Statistics of IP <br>and numbers of login and registrations</h2>
	<small><< only one IPs usage is not shown >></small>

	{include file='list_admin.tpl'

	url='*'
	fields=[
		'ip'=>['IP'],
		'auth'=>['auth'],
    	'reg'=>['reg'],
    	'sum'=>['sum']
	]
	values=$list
	row='*'

}

{include file='admin/admin/footer.tpl'}
{/strip}