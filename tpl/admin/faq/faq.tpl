{strip}
{include file='admin/admin/header.tpl' title=$_AT['FAQ']}

{include file='edit_admin.tpl'
	title=$_AT['Question']
	title_new=$_AT['New question']
	fields=[
		'fID'=>[],
		'fCTS'=>
			[
				'X',
				$_AT['Creation date'],
				'skip'=>!$el.fID
			],
		'fHidden'=>
			[
				'C',
				$_AT['Hidden']
			],
		'fCat'=>
			[
				'S',
				$_AT['Category!!'],
				[],
				[''=>$_AT['- no -']] + (array)$cats,
				'skip'=>!$cats
			],
		'fQuestion'=>
			[
				'L',
				$_AT['Question!!'],
				[
					'question_empty'=>$_AT['input question']
				],
				size=>50
			],
		'fAnswer'=>
			[
				'Y',
				$_AT['Answer!!'],
				[
					'answer_empty'=>$_AT['input answer']
				],
				'size'=>15
			],
		'fOrder'=>
			[
				'I',
				$_AT['Sorting order']|html_entity_decode
			]
	]
	values=$el
}

{include file='admin/admin/footer.tpl'}
{/strip}