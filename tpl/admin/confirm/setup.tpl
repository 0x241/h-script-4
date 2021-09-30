{strip}
{include file='admin/admin/header.tpl' title=$_AT['Confirmation']}

{include file='edit_admin.tpl'
    values=$cfg
    fields=[
        'Captcha'=>['S', $_AT['Protect by "captcha"'], 0, [0=>$_AT['no'], 1=>$_AT['auto'], 2=>$_AT['always']]]
    ]
}

{include file='admin/admin/footer.tpl'}
{/strip}