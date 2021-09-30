{strip}
{include file='admin/admin/header.tpl' title=$_AT['Settings']}

{include file='edit_admin.tpl'
	values=$cfg
	fields=[
		'LockData'=>['C', $_AT['Deny modify personal data']],
		'Loginza'=>['C', $_AT['Allow a "quick" registration and login,<br>using accounts other services <<provider uLogin.ru>>']|html_entity_decode],
		'ISP'=>['C', 'Allow a "quick" registration and login via ISP <<InvestorsStartPage.com>>'],

		1=>$_AT['Registration'],
		'RegMode'=>['S', $_AT['Mode'], 0, [0=>$_AT['Deny'], 1=>$_AT['Allow'], 2=>$_AT['Only with ref'], 3=>$_AT['By invitation only']]],
		'RegCheck'=>['S', $_AT['Checking for multiple registrations'], 0, [0=>$_AT['No'], 1=>$_AT['By IP-address'], 2=>$_AT['By cookie'], 3=>$_AT['By IP-address and cookie']]],
		'UseName'=>['S', $_AT['Require the entry of the Name'], 0, [0=>$_AT['No (=Login)'], 1=>$_AT['Yes'], 2=>$_AT['In Personal settings']]],
		'UseAvatar'=>['S', 'Avatar', 0, [0=>'No', 1=>'yes'], 'comment'=>'using  <a href="https://ru.gravatar.com/">gravatar.com</a>'],
		'MinLogin'=>['I', $_AT['Min Login length']],
		'LoginRegx'=>['T', $_AT['Login format <<regular expression>>']|html_entity_decode],
		'MinPass'=>['I', $_AT['Min Password length']],
		'PassRegx'=>['T', $_AT['Password format <<regular expression>>']|html_entity_decode],
		'RegCaptcha'=>['S', $_AT['Protect by "captcha"'], 0, [0=>$_AT['No'], 1=>$_AT['Auto'], 2=>$_AT['Always']]],
		'RegConfirm'=>['C', $_AT['Confirm operation by e-mail']],
		'RegLogin'=>['C', $_AT['Log in to your account immediately after registration']],

		$_AT['Sign in'],
		'LoginCaptcha'=>['S', $_AT['Protect by "captcha"'], 0, [0=>$_AT['No'], 1=>$_AT['Auto'], 2=>$_AT['Always']]],

		$_AT['Change e-mail'],
		'ChangeMailCaptcha'=>['S', $_AT['Protect by "captcha"'], 0, [0=>$_AT['No'], 1=>$_AT['Auto'], 2=>$_AT['Always']]],
		'ChangeMailConfirm'=>['C', $_AT['Confirm operation by e-mail']],

		$_AT['Password reset'],
		'ResetPassCaptcha'=>['S', $_AT['Protect by "captcha"'], 0, [0=>$_AT['No'], 1=>$_AT['Auto'], 2=>$_AT['Always']]]
	]
}

{include file='admin/admin/footer.tpl'}
{/strip}