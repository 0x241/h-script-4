{strip}
{include file='admin/admin/header.tpl' title=$_AT['Deposit']}

{if $el}

	{include file='depo/_depo.admin.tpl' from_admin=true}

{else}

	{if $smarty.get.user}

		{include file='edit_admin.tpl'
			form='new'
			title=$_AT['New deposit']
	fields=[
		'Login'=>$smarty.get.user,
		'User'=>
			[
				'X',
				$_AT['User'],
				0,
				$smarty.get.user,
				'skip'=>!$from_admin
			],
		'Bal'=>
			[
				'U',
				'balance/bal.tpl'
			],
		'Curr'=>
			[
				'S',
				$_AT['Currs'],
				0,
				[0=>$_AT['- select -'], 'USD' => 'USD', 'EUR' => 'EUR', 'RUB' => 'RUB', 'BTC' => 'BTC', 'ETH' => 'ETH', 'XRP' => 'XRP']
			],
		'Sum'=>
			[
				'$',
				$_AT['Amount'],
				[
					'sum_empty'=>$_AT['wrong amount'],
					'sum_wrong'=>$_AT['wrong amount'],
					'low_bal1'=>'Low balance'
				]
			],
		'Plan'=>
			[
				'S', 
				$_AT['Plan'],
				[
					'plan_wrong'=>'wrong plan'
				],
				$plans,
				'skip'=>(count($plans) <= 1)
			],
		'Compnd'=>
			[
				'%',
				'Compaund',
				[
					'compnd_wrong'=>"wrong compaund",
					'compnd_wrong1'=>"wrong compaund"
				],
				'skip'=>!$pcmax
			]
	]
	values=$el
	errors=[
		'oper_disabled'=>$_AT['operation disabled']
	]
}

	{else}

		{include file='edit_admin.tpl'
			form='new'
			title=$_AT['New deposit']
			fields=[
				'Login'=>
					[
						'T',
						$_AT['User!!'],
						[
							'user_empty'=>$_AT['user not found']
						],
						'default'=>$smarty.get.user
					]
			]
			btn_text=$_AT['Next']
		}

	{/if}

{/if}

{include file='admin/admin/footer.tpl'}
{/strip}