{strip}
{include file='admin/admin/header.tpl' title=$_AT['Day']}

{include file='admin/calendar/_statuses.tpl'}

{include file='edit_admin.tpl'
	title=$_AT['Day']
	title_new=$_AT['New day']
	fields=[
		'cID'=>[],
		'cTS'=>
			[
				'D',
				$_AT['Date!!'],
				[
					'date_empty'=>$_AT['input date'],
					'date_exist'=>$_AT['date alredy exists']
				],
				'default'=>$today
			],
		'cType'=>
			[
				'S',
				$_AT['Type!!'],
				[
					'type_empty'=>$_AT['select type']
				],
				[0=>$_AT['- select -']] + $d_types
			],
		'cPerc'=>
			[
				'%',
				$_AT['Percent'],
				['perc_wrong'=>$_AT['fill percent']]
			]
	]
	values=$el
}

{include file='admin/admin/footer.tpl'}
{/strip}