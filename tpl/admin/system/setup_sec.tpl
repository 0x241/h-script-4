{strip}
{include file='admin/admin/header.tpl' title=$_AT['Security']}

{include file='edit_admin.tpl'
	values=$cfg
	fields=[
		'HTTPSMode'=>['S', $_AT['Use http<b>s</b> <<to change use https://>>']|html_entity_decode, 0, [0=>$_AT['only at secure pages'], 1=>$_AT['always']], 'readonly'=>!$via_https],
		'MinPIN'=>['I', $_AT['Min PIN-code length <<0 - do not use>>']|html_entity_decode],
		'MinSQA'=>['I', $_AT['Min Question/Answer length <<0 - do not use>>']|html_entity_decode],
		'BFC'=>['I', $_AT['Brute force checking (N wrong logins) <<0 - do not use>>']|html_entity_decode],
		'IP'=>['S', $_AT['IP-address change cheking'], 0, [0=>$_AT['no'], 1=>'x.0.0.0', 2=>'x.x.0.0', 3=>'x.x.x.0', 4=>'x.x.x.x']],
		'ForceReConfig'=>['C', $_AT['Require verification of "Personal Settings" after registration']],
		'PassTime'=>['I', $_AT['User must change password every N days <<0 - no>>']|html_entity_decode],
		'TimeOut'=>['I', $_AT['Autologout after N minutes <<0 - do not use>>']|html_entity_decode],
		'_IPs' => ['A', $_AT['IP-addresses that are allowed to access the Control Panel <br> <<one line - one address in the format xxxx>> <br> your current IP:']|html_entity_decode|cat:"<b> {$curr_ip} </ b> {include file='_country.tpl' ip=$curr_ip}"],
		'Proxy server',
		'ProxyHost'=>['T', 'Host!! <<[scheme://]address[:port]>>'],
		'ProxyAuth'=>['T', 'Authorization <<login:password>>']
	]
}

{include file='admin/admin/footer.tpl'}
{/strip}