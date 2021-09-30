{strip}
{include file='admin/admin/header.tpl' title=$_AT['News']}

{include file='edit_admin.tpl'
	title=$_AT['News']
	title_new=$_AT['News']
	fields=[
		'nID'=>[],
		'nTS'=>
			[
				'DT',
				$_AT['Publication date!!'],
				[
					'date_empty'=>$_AT['input date']
				],
				'default'=>$today
			],
		'nTopic'=>
			[
				'L',
				$_AT['Topic!!'],
				[
					'topic_empty'=>$_AT['input topic']
				],
				size=>50
			],
		'nAttn'=>
			[
				'CC',
				$_AT['Important']
			],
		'nAnnounce'=>
			[
				'W',
				$_AT['Announce!!'],
				[
					'ann_empty'=>$_AT['input announce']
				],
				'size'=>5
			],
		'nText'=>
			[
				'Y',
				$_AT['Full text!!'],
				[
					'text_empty'=>$_AT['input text']
				],
				'size'=>15
			],
		'nDBegin'=>
			[
				'D',
				$_AT['Show from']
			],
		'nDEnd'=>
			[
				'D',
				$_AT['To']
			]
	]
	values=$el
}

{include file='admin/admin/footer.tpl'}
{/strip}