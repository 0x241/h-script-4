{strip}

{include file='edit.tpl'
	form='sqa'
	fields=
	[
		'uID' => $uid,
		'SQuestion'=>
			[
				'X', 
				'',
				0,
				$squest
			],
		'SAnswer'=>
			[
				'T', 
				'Контрольный ответ!!',
				[
					'answer_wrong'=>'неверный ответ'
				],
				'size'=>40
			]
	]
	btn_text='Далее'
}

{/strip}