{strip}
{include file='admin/admin/header.tpl' title=$_AT['Custom page']}

{include file='edit_admin.tpl'
	title=$_AT['Custom page']
	title_new=$_AT['New custom page']
	fields=[
		'pID'=>[],
		'pHidden'=>
			[
				'C',
				$_AT['Disabled']
			],
		'pDirect'=>
			[
				'C',
				$_AT['Show only code <<w/o footer/header>>']|html_entity_decode
			],
		'pTopic'=>
			[
				'L',
				$_AT['Title!!'],
				[
					'topic_empty'=>$_AT['input title']
				],
				size=>50
			],
		'pText'=>
			[
				'Y',
				$_AT['Contents!!'],
				[
					'text_empty'=>$_AT['input contents']
				],
				'size'=>15
			]
	]
	values=$el
}

{include file='admin/admin/footer.tpl'}
{/strip}