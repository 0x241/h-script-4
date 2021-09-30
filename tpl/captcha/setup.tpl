{strip}
{include file='admin/admin/header.tpl' title=$_TRANS['Captcha']}

{include file='edit.tpl'
    values=$cfg
    fields=[
        'View'=>['S', $_AT['Type'], 0, [1=>$_TRANS['Distortion'], 2=>$_TRANS['Mosaic'], 3=>$_TRANS['Shadows']]]
    ]
}

{include file='admin/admin/footer.tpl'}
{/strip}