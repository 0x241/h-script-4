{strip}
{include file='admin/admin/header.tpl' title=$_AT['Settings']}

{include file='edit_admin.tpl'
    values=$cfg
    fields=[
        'NoMail'=>['C', $_AT['Do not send notification to  e-mail']],
        'Captcha'=>['S', $_AT['Defence "captcha"'], 0, [0=>$_AT['No'], 1=>$_AT['Auto'], 2=>$_AT['Always']]],
        '_Cats'=>['A', $_AT['Categories posts <br> <<one line - one category>>']|html_entity_decode, 'size'=>20]
    ]
}

{include file='admin/admin/footer.tpl'}
{/strip}