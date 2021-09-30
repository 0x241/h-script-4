{strip}
{include file='admin/admin/header.tpl' title='e-Mail'}

{include file='edit_admin.tpl'
    values=$cfg
    fields=[
        'Host'=>['T', $_AT['Server address']],
        'Port'=>['I', $_AT['Port']],
        'Secure'=>['C', $_AT['Secure connection']],
        'Username'=>['T', $_AT['Login']],
        'Password'=>['*', $_AT['Password <<empty - send via php mail()>>']|html_entity_decode]
    ]
}

{include file='admin/admin/footer.tpl'}
{/strip}