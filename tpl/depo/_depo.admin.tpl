{strip}

{include file='depo/_statuses.tpl'}

{$chg=(($el.dState == 1) and ($el.pCompndMax > 0) and ($el.pCompndMin < $el.pCompndMax))}
{$modbuttons=[] scope='global'}
{if $chg}
	{$modbuttons['chg']='Сменить процент реинвеста' scope='global'}
{/if}

{$add=$el.pEnAdd}
{$sub=(($el.pClComis < 100) and ($el.dNPer >= $el.pMPer))}
{$modform=[] scope='global'}
{if ($el.dState == 1) and ($add or $sub)}
	{$modform=[
		1=>'',
		'Sum'=>
			[
				'$',
				'Сумма изменения!!',
				[
					'sum_empty'=>'укажите сумму',
					'sum_wrong'=>'неверная сумма',
					'low_balance'=>'недостаточно средств',
					'cant_add'=>'невозможно довложить',
					'cant_sub'=>'невозможно снять',
					'plan_not_found'=>'нет подходящего плана'
				],
				'comment'=>" <i><small>{$el.cCurr}</small></i>",
				'default'=>0
			]
	] scope='global'}
	{if $add}
		{$modbuttons['add']='ДОвложить' scope='global'} 
	{/if}
	{if $sub}
		{$modbuttons['sub']='Снять' scope='global'}
	{/if}
{/if}
{if $el.dState == 1}
	{$modbuttons['chp']='Сменить план' scope='global'}
	{$modbuttons['cls']='Закрыть' scope='global'}
{/if}

{include file='edit.tpl'
	title=valueIf($from_admin, 'Депозит')
	fields=[
		'dID'=>[],
		'duID'=>[],
		'dcID'=>[],
		'dState'=>
			[
				'X', 
				'Статус',
				0,
				"<b>{$ststrs[$el.dState]}</b>"
			],
		'dCTS'=>
			[
				'X',
				'Создано'
			],
		'uLogin'=>
			[
				'X',
				'Пользователь',
				'skip'=>!$from_admin
			],
		'Bal'=>
			[
				'U',
				'balance/bal.tpl',
				'skip'=>!$from_admin
			],
		'dcCurrID'=>
			[
				'T',
				'Валюта',
				'readonly'=>1
			],
		'dZD'=>
			[
				'X',
				'Сумма',
				0,
				_z($el.dZD, $el.dcID, 1)
			],
		'dpID'=>
			[
				'S', 
				'План',
				0,
				$plans
			],
		'dN'=>
			[
				'X', 
				'Начислений',
				0,
				"{$el.dNPer} из {$el.pNPer}"
			],
		'dLTS'=>
			[
				'X', 
				'Последнее начисление'
			],
		'dNTS'=>
			[
				'X', 
				'Следующее начисление'
			],
		'dCompnd'=>
			[
				'X',
				'Процент реинвеста <<капитализация>>',
				'skip'=>$chg
			],
		'Compnd'=>
			[
				'%',
				'Процент реинвеста <<капитализация>>',
				[
					'compnd_wrong'=>"неверное значение [$cmin..$cmax]"
				],
				'default'=>$el.dCompnd,
				'skip'=>!$chg
			],
		'dM'=>
			[
				'X', 
				'Досрочное снятие',
				0,
				valueIf($el.pClComis >= 100, 'Невозможно',
					valueIf($el.dNPer >= $el.pMPer, "Возможно", 
						"Осталось начислений: {$el.pMPer - $el.dNPer}")
				),
				'skip'=>($el.dState > 1)
			]
	]+$modform
	values=$el
	errors=[
		'oper_disabled'=>'операция запрещена'
	]
	btn_text=' '
	btns=$modbuttons
}

{/strip}