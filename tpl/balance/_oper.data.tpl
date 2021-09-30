{strip}
{if $from_admin or ($_cfg.Bal_AFMMode == 0)}

<h2>
	{$_TRANS['Payment data through']} {$el.cName},<br>
	{$_TRANS['produced manually']}
	{if !$from_admin and ($el.oOper == 'CASHIN')} {$_TRANS['and<br/> payeer details']|html_entity_decode}{/if}
</h2>

{$ro = !$from_admin and ($el.oState > 1)}
{include file='edit.tpl'
	form='data'
	fields=[
		'oID'=>$el.oID,
		'date'=>
			[
				'D',
				'Дата!!',
				[
					'data_date_wrong'=>'неверная дата'
				],
				'default'=>$today,
				'readonly'=>$ro
			],
		'sum'=>
			[
				'X',
				'Сумма',
				0,
				_z($el.oSum2, $el.oParams.cid, 1)
			],
		'batch'=>
			[
				'T',
				'Batch-номер!! <<операции/транзакции>>',
				[
					'data_batch_wrong'=>'укажите номер операции',
					'batch_exists'=>'номер используется'
				],
				'default'=>$defaultbatch,
				'readonly'=>$ro
			],
		'memo'=>
			[
				'A',
				'Примечание',
				'readonly'=>$ro
			]
	] + (array)$dfields
	values=$el.oParams2
	btn_text=valueIf($ro, ' ', valueIf($el.oParams2.batch, 'Изменить', 'Создать'))
	hide_cancel=true
}

{/if}
{/strip}