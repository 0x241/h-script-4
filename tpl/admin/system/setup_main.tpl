{strip}
{include file='admin/admin/header.tpl' title=$_AT['Main']}

{if $cfg.NeedReConfig}

	<p class="info">
		{$_AT['Check all script settings']}
	</p>

{/if}
        {*'SiteInfDisable'=>['C', $_AT['Turn off information line']],*}
{include file='edit_admin.tpl'
	values=$cfg
	fields=[
		'SiteName'=>['T', $_AT['Site name']],
		'ForceCharset'=>['C', $_AT['Force header "utf-8 encoding" <<for some hostings>>']|html_entity_decode],
		'AdminMail'=>['T', $_AT['Admin e-mail']],
		'NotifyMail'=>['T', $_AT['Notification center e-mail']],
		'LockSite'=>['C', $_AT['Technical work <<login prohibition>>']|html_entity_decode],
		'OutIP'=>['X', $_AT['Server outgoing IP-address'] , "  {include file='_country.tpl' ip=$ip_server}", 'default' => $ip_server]
	]
}

{include file='admin/admin/footer.tpl'}
{/strip}