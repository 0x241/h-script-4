{strip}
{include file='admin/admin/header.tpl' title=$_AT['User']}

<h2>{$_AT['User']} '{$el.aName}'</h2>
<a href="{_link module='account/admin/user'}?id={$el.uID}" class="button-gray">{$_AT['Main']}</a>
<br><br>

{$txt_login=valueIf($_cfg.Const_NoLogins, $_AT['e-mail'], $_AT['Login'])}
{include file='edit_admin.tpl'
	fields=[
		'auID'=>[],
		'uLogin'=>
			[
				'X',
				$txt_login
			],
		'C'=>
			[
				'X',
				$_AT['Registration'],
				0,
				"{$el.aCTS} <small>(IP {$el.aCIP})</small> {include file='_country.tpl' ip=$el.aCIP}",
				'skip'=>!$el.aCTS
			],
		'aName'=>
			[
				'T',
				$_AT['Name!!'],
				[
					'name_empty'=>$_AT['input Name']
				]
			],
		'aTZ'=>
			[
				'T',
				$_AT['Time zone!! <<GMT>>']|html_entity_decode,
				[
					'tz_wrong'=>$_AT['wrong zone [h:m]']
				],
				'comment'=>$_AT['+3:00 = Moscow'],
				'size'=>6
			],
		'aBD'=>
			[
				'D',
				$_AT['Date of birth']
			],
		'aCountry'=>
			[
				'T',
				$_AT['Country']
			],
		'aCity'=>
			[
				'T',
				$_AT['City']
			],
		'aTel'=>
			[
				'T',
				$_AT['Phone number']
			],
		'aNoMail'=>
			[
				'C',
				$_AT['Do not be notified by e-mail'],
				'skip'=>$_cfg.Msg_NoMail
			],
		50=>$_AT['Special ref.system'],
		'aPerc'=>
			[
				'A',
				$_AT['From add funds<br><<values by levels>>']|html_entity_decode
			],
		'aDPerc'=>
			[
				'A',
				$_AT['From deposit<br><<values by levels>>']|html_entity_decode
			],
		'aPPerc'=>
			[
				'A',
				$_AT['From profit<br><<values by levels>>']|html_entity_decode
			],
		99=>$_AT['Security'],
		'aGA'=>['T', 'Google Authenticator'],
		'aIPSec'=>
			[
				'S',
				$_AT['IP-address change control'],
				0,
				[
					0=>$_AT['- by default -'],
					1=>'x.0.0.0',
					2=>'x.x.0.0',
					3=>'x.x.x.0',
					4=>'x.x.x.x'
				]
			],
		'aSessIP'=>['C', $_AT['Bind session to IP-address']],
		'aSessUniq'=>['C', $_AT['Deny parallel sessions']],
		'aTimeOut'=>['I', $_AT['Autologout after N min <<0 - by default>>']|html_entity_decode],
		'aSQuestion'=>
			[
				'T',
				$_AT['Secret question!!'],
				[
					'secq_empty'=>$_AT['input question'],
					'secq_short'=>$_AT['the question is too short']|cat:" ["|cat:$_AT['not less']|cat:" {$_cfg.Sec_MinSQA}]"
				],
				'skip'=>($_cfg.Sec_MinSQA == 0),
				'size'=>40
			],
		'aSAnswer'=>
			[
				'*',
				$_AT['Secret answer <<fill to change>>']|html_entity_decode,
				[
					'seca_empty'=>$_AT['input answer'],
					'seca_short'=>$_AT['the answer is too short']|cat:" ["|cat:$_AT['not less']|cat:" {$_cfg.Sec_MinSQA}]",
					'seqa_equal_secq'=>$_AT['answer and the question must be different']
				],
				'skip'=>($_cfg.Sec_MinSQA == 0),
				'size'=>40
			]
	]
	values=$el
}

{if $wfields}

	<br>
	{$wfields = [
		'auID'=>[],
		'DefCurr'=>[
			'S',
			$_AT['Payment system by default!!'],
			[
				'psys_wrong'=>$_AT['input pay.system']
			],
			[0=>$_AT['- select -']] + (array)$defcurr,
			'default'=>$el['aDefCurr']
		]
	]+$wfields}

	{include file='edit_admin.tpl'
		form='wallets'
		title=$_AT['Payment details']
		fields=$wfields
		values=$wdata
	}

{/if}

{include file='admin/admin/footer.tpl'}
{/strip}