{strip}
{include file='admin/admin/header.tpl' title=$_AT['User']}

{include file='admin/account/_statuses.tpl'}

{if $el}
	<h2>{$_AT['User']} '{$el.aName}'</h2>
	<a href="{$root_url}admin/account/user/addinfo?id={$el.uID}" class="button-gray">{$_AT['Additional']}</a>
	<br><br>
{else}
	<h2>{$_AT['New user']}</h2>
{/if}

{$txt_login=valueIf($_cfg.Const_NoLogins, $_AT['e-mail'], $_AT['login'])}
{include file='edit_admin.tpl'
	fields=[
		'uID'=>[],
		'uGroup'=>
			[
				'T',
				$_AT['Group'],
				'skip'=>!$el

			],
		'uLogin'=>
			[
				'T',
				$_AT['Login!!'],
				[
					'login_empty'=>$_AT['input login'],
					'login_short'=>$_AT['username is too short']|cat:" ["|cat:$_AT['not less']|cat:" $MinLogin]",
					'login_wrong'=>$_AT['login can not contain a space'],
					'login_used'=>$_AT['login is already in use']
				],
				'skip'=>($_cfg.Const_NoLogins)
			],
		'uMail'=>
			[
				'T',
				$_AT['e-mail!!'],
				[
					'mail_empty'=>$_AT['input e-mail'],
					'mail_wrong'=>$_AT['wrong e-mail'],
					'mail_used'=>$_AT['e-mail is already in use']
				]
			],
		'uPass'=>
			[
				'*',
				valueIf(!$el, $_AT['Password!!'], $_AT['Password']),
				[
					'pass_empty'=>$_AT['input password'],
					'pass_short'=>$_AT['password is too short']|cat:" ["|cat:$_AT['not less']|cat:" $MinPass]",
					'pass_wrong'=>$_AT['password does not match format']
				]
			],
		'uPIN'=>
			[
				'*',
				valueIf(!$el, $_AT['PIN-code!!'], $_AT['PIN-code']),
				[
					'pin_empty'=>$_AT['input PIN-code'],
					'pin_short'=>$_AT['PIN-code is too short']|cat:" ["|cat:$_AT['not less']|cat:" $MinPass]",
					'pin_wrong'=>$_AT['PIN-code does not match format']
				],
				'skip'=>($_cfg.Sec_MinPIN == 0) or !$el
			],
		'uState'=>
			[
				'S',
				$_AT['State'],
				0,
				$usr_statuses,
				'skip'=>!$el
			],
		'uBTS'=>
			[
				'DT',
				$_AT['Banned till'],
				[
					'bdate_empty'=>$_AT['input date']
				],
				'skip'=>!$el
			],
		'uLevel'=>
			[
				'I',
				$_AT['Access level'],
				[
					'lvl_wrong'=>$_AT['wrong value']
				],
				'size'=>3,
				'skip'=>!$el
			],
		'uRef'=>
			[
				'T',
				"Inviter{if $_cfg.Account_RegMode == 2}!!{/if}",
				[
					'ref_empty'=>"укажите $txt_login",
					'ref_not_found'=>"$txt_login не найден",
					'ref_is_self'=>'неверное значение'
				],
				'skip'=>(($_cfg.Account_RegMode == 3) or !$_cfg.Ref_Word or !$el)
			],
		'Bal'=>
			[
				'U',
				'balance/bal.tpl',
				'skip'=>!$el
			],
		'uWDDisable'=>['C', 'Disable withdraw'],
		'uLang'=>
			[
				'S',
				$_AT['Language'],
				0,
				$langs,
				'skip'=>!$el
			],
		'uMode'=>
			[
				'T',
				$_AT['Skin'],
				'size'=>8,
				'skip'=>!$el
			],
		'uTheme'=>
			[
				'T',
				$_AT['Theme'],
				'size'=>8,
				'skip'=>!$el
			],
		'Act'=>
			[
				'X',
				$_AT['Last activity'],
				0,
				"{$el.uLTS} <small>(IP {$el.uLIP})</small> {include file='_country.tpl' ip=$el.uLIP}",
				'skip'=>!$el.uLTS
			]
	]
	values=$el
}
{*
		'uBal'=>
			[
				'X',
				$_AT['Balance <<summary by all pay.systems>>']|html_entity_decode,
				0,
				_z($el.uBal, 1),
				'skip'=>!$el
			],
*}
{if $el}
	<br>
	<a href="{$root_url}admin/opers?user={$el.uLogin}" class="button-green">{$_AT['All user operations']}</a>&nbsp;
	<a href="{$root_url}admin/message?add&to={$el.uLogin}" class="button-green">{$_AT['Send a message to the user']}</a>&nbsp;
	<a href="{$root_url}admin/account/user?id={$el.uID}&login" class="button-green">{$_AT['Login as user']}</a><br>
{/if}
{include file='admin/admin/footer.tpl'}
{/strip}