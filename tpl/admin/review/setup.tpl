{strip}
{include file='admin/admin/header.tpl' title=$_AT['Settings']}

{include file='edit_admin.tpl'
    values=$cfg
    fields=[
        'Mode'=>['C', $_AT['Moderate reviews']],
        'ShowCount'=>['I', $_AT['Rows count on page']],
        'InBlock'=>['I', $_AT['Rows count in block']]
    ]
}

{include file='admin/admin/footer.tpl'}
{/strip}