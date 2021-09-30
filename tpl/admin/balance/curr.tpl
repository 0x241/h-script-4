{strip}
{include file='admin/admin/header.tpl' title=$_AT['Payment system']}

{if $el}

	<h2>{if $el.cCID == '*'}{$_AT['Internal payment system']}{else}{$_AT['Payment system']} [{$el.cCID}]{/if}</h2>

	{if isset($smarty.get.testapi)}

		<h2>{$_AT['Test API']}</h2>
		<p class="info">
			{if $res.result == 'OK'}
				{$_AT['Wallet balance']}: <b>{_z($res.sum, $el.cID, -1)}</b> {$el.cCurr}.<br>
				{$_AT['Test completed!']}
			{else}
				{$_AT['Error']} <b>{$res.result}</b>
			{/if}
		</p>

	{/if}

	{if $sfields}
		{$sfields = [1=>$_AT['SCI <small>(add funds/merchant)</small>']|html_entity_decode] + $sfields}
	{/if}
	{if $afields}
		{$afields = [2=>$_AT['API <small>(withdraw)</small>']|html_entity_decode] + $afields}
	{/if}
	{$params=[
		77=>'Live balance',
		'cBal' => ['X', 'Last value'],
		'cBalMin' => ['$', 'Notify if balance is below Õ'],
		5=>$_AT['Add funds'],
		'cCASHINMode'=>['S', $_AT['Mode'], 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['thru merchant'], 3=>$_AT['manual or thru merchant']]],
		'cCASHINMin'=>
			[
				'$',
				$_AT['Min amount']
			],
		'cCASHINMax'=>
			[
				'$',
				$_AT['Max amount <<0 - default>>']|html_entity_decode
			],
		'cCASHINInt'=>
			[
				'C',
				$_AT['Only integer amounts'],
				'default'=>0
			],
		'cCASHINComis'=>
			[
				'%',
				$_AT['Comission perc.']
			],
		'cCASHINComisMin'=>
			[
				'$',
				$_AT['Min comission']
			],
		'cCASHINComisMax'=>
			[
				'$',
				$_AT['Max comission <<0 - no>>']|html_entity_decode
			],
		6=>$_AT['Withdraw'],
		'cCASHOUTMode'=>['S', $_AT['Mode'], 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['instant']]],
		'cCASHOUTMin'=>
			[
				'$',
				$_AT['Min amount']
			],
		'cCASHOUTMax'=>
			[
				'$',
				$_AT['Max amount <<0 - default>>']|html_entity_decode
			],
		'cCASHOUTInt'=>
			[
				'C',
				$_AT['Only integer amounts'],
				'default'=>0
			],
		'cCASHOUTComis'=>
			[
				'%',
				$_AT['Comission perc.']
			],
		'cCASHOUTComisMin'=>
			[
				'$',
				$_AT['Min comission']
			],
		'cCASHOUTComisMax'=>
			[
				'$',
				$_AT['Max comission <<0 - no>>']|html_entity_decode
			],
		'cCASHOUTLimitPer'=>
			[
				'I',
				$_AT['Limit period <<in hours, 0 - no>>']|html_entity_decode
			],
		'cCASHOUTLimit'=>
			[
				'$',
				$_AT['Limit amount']
			],
		8=>$_AT['Transfer'],
		'cTRMode'=>['S', $_AT['Mode'], 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['instant']]],
		'cTRMin'=>
			[
				'$',
				$_AT['Min amount']
			],
		'cTRMax'=>
			[
				'$',
				$_AT['Max amount <<0 - default>>']|html_entity_decode
			],
		'cTRInt'=>
			[
				'C',
				$_AT['Only integer amounts'],
				'default'=>0
			],
		'cTRComis'=>
			[
				'%',
				$_AT['Comission, perc.']
			],
		'cTRComisMin'=>
			[
				'$',
				$_AT['Min comission']
			],
		'cTRComisMax'=>
			[
				'$',
				$_AT['Max comission <<0 - no>>']|html_entity_decode
			]
	]}
	{include file='edit_admin.tpl'
		fields=[
			'cID'=>[],
			'cCID'=>[],
			'cDisabled'=>
				[
					'C',
					$_AT['Disabled'],
					'default'=>1
				],
			'cHidden'=>
				[
					'C',
					$_AT['Hidden'],
					'default'=>1
				],
			'cMTS'=>
				[
					'X',
					$_AT['Modified'],
					'skip'=>!$el.cMTS
				],
			99=>$_AT['Type'],
			'cName'=>
				[
					'T',
					$_AT['Title'],
					'size'=>30,
					'comment'=>$cName
				],
			'cCurr'=>
				[
					'T',
					$_AT['Currency'],
					'comment'=>$el.cCurrID
				],
			'cNumDec'=>
				[
					'I',
					$_AT['Number of decimal places <<0 - default>>']|html_entity_decode
				]
		] +
		(array)$pfields +
		(array)$sfields +
		(array)$afields +
		$params
		values=$el
	}

{else}

	{include file='edit_admin.tpl'
		form='add'
		title=$_AT['New pay.system']
		fields=[
			'PSys'=>
				[
					'S',
					'',
					[
						'psys_not_selected'=>$_AT['select pay.system']
					],
					[0=>$_AT['- select -']] + (array)$cids
				]
		]
		btn_text=$_AT['Add']
	}

{/if}

{include file='admin/admin/footer.tpl'}
{/strip}