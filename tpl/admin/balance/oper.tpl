{strip}
{include file='admin/admin/header.tpl' title=$_AT['Operation']}

{include file='balance/_statuses.tpl'}

{if $el}

	<h2>{$op_names[$el['oOper']]}</h2>
	{$b = []}
	{if $el.oState <= 2}
		{$b['cancel'] = $_AT['Decline']}
	{/if}
	{if $el.oState >= 4}
		{$b['del'] = $_AT['Delete']}
	{/if}
	{include file='balance/_oper.tpl' bt=valueIf($el.oState <= 2, $_AT['Perform'], ' ') b=$b edit_form_name='balance/admin/oper_frm'
		errors=[
			'oper_not_found'=>$_AT['wrong operation state'],
			'oper_disabled'=>$_AT['operation disabled'],
			'low_bal1'=>$_AT['insufficient funds'],
			'data_date_wrong'=>$_AT['wrong date'],
			'data_sum_wrong'=>$_AT['wrong amount'],
			'data_batch_wrong'=>$_AT['batch-number not set'],
			'batch_exists'=>$_AT['operation with this batch-number already exists'],
			'send_error'=>$_AT['sending funds error']
		]
		from_admin=true
	}

{else}

	{if $smarty.get.add}
		{$oper = $smarty.get.add}
		{$use_sum2 = in_array($oper, array('CASHIN', 'CASHOUT', 'EX', 'TR', 'SELL'))}
		{include file='edit_admin.tpl'
			form='add'
			title=$op_names[$oper]
			fields=[
				'Oper'=>$oper,
				'Login'=>$smarty.get.user,
				'User'=>
					[
						'X',
						$_AT['User'],
						0,
						$smarty.get.user
					],
				'Bal'=>
					[
						'U',
						'balance/bal.tpl'
					],
				'PSys'=>
					[
						'S',
						$_AT['Pay System!!'],
						[
							'depo_wrong'=>$_AT['wrong deposit'],
							'psys_empty'=>$_AT['input pay.system']
						],
						valueIf(count((array)$clist) > 1, [0=>$_AT['- select -']], []) + (array)$clist,
						skip=>!in_array($oper, ['BONUS', 'PENALTY', 'CASHIN', 'CASHOUT', 'TR', 'TRIN'])
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
						valueIf($_cfg.Const_IntCurr and in_array($oper, array('CASHOUT')), $_AT['Amount!! <<in internal units>>'], $_AT['Amount!!']),
						[
							'sum_wrong'=>$_AT['wrong amount']
						],
						'comment'=>' <i><span id="ccurr"></span></i>'
					],
				'Comis'=>
					[
						'X',
						$_AT['Comission'],
						'comment'=>' <i><span id="csum"></span></i>',
						'skip'=>!$use_sum2
					],
				'Curr2'=>
					[
						'S',
						valueIf($oper == 'EX', $_AT['To pay.system!!'], $_AT['From pay.system!!']),
						[
							'psys2_empty'=>$_AT['pay.system not set'],
							'psys2_equal_psys'=>$_AT['pay.system must be different']
						],
						[0=>$_AT['- select -'], 'USD' => 'USD', 'EUR' => 'EUR', 'RUB' => 'RUB', 'BTC' => 'BTC', 'ETH' => 'ETH', 'XRP' => 'XRP'],
						'skip'=>($oper != 'EX')
					],
				'Sum2'=>
					[
						'X',
						valueIf($oper == 'CASHIN', $_AT['Result deposit'], $_AT['Result amount']),
						'comment'=>' <i><span id="sum2"></span></i>',
						'skip'=>!$use_sum2
					],
				'Login2'=>
					[
						'T',
						valueIf($oper == 'TR', $_AT['Receiver!!'], $_AT['Sender!!']),
						[
							'user2_empty'=>$_AT['user not found'],
							'user2_equal_user'=>$_AT['users must be different']
						],
						'skip'=>!in_array($oper, array('TR', 'TRIN'))
					],
				'Memo'=>
					[
						'W',
						$_AT['Description'],
						'size'=>4
					]
			]
			errors=[
				'oper_disabled'=>$_AT['operation disabled']
			]
		}

		{include file='balance/_oper.js.tpl' oper=$oper use_sum2=$use_sum2}

	{else}

		{include file='edit_admin.tpl'
			form='add'
			title=$_AT['New operation']
			fields=[
				'Oper'=>
					[
						'S',
						$_AT['Operation!!'],
						[
							'oper_empty'=>$_AT['operation is not specified'],
							'oper_wrong'=>$_AT['unknown operation']
						],
						[0=>$_AT['- select -']] + (array)$aop_names
					],
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