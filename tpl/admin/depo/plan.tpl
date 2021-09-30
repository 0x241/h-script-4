{strip}
{include file='admin/admin/header.tpl' title=$_AT['Plan']}

{include file='edit_admin.tpl'
	title=$_AT['Plan']
	title_new=$_AT['New plan']
	fields=[
		'pID'=>[],
		'pHidden'=>
			[
				'C',
				$_AT['Hidden']
			],
		'pNoCalc'=>
			[
				'C',
				$_AT['No accruals']
			],
		'pGroup'=>
			[
				'I',
				$_AT['Plan group number']
			],
		'pName'=>
			[
				'L',
				$_AT['Title!!'],
				['name_empty'=>$_AT['input title']]
			],
		'pDescr'=>
			[
				'W',
				$_AT['Description']
			],
		'pMin'=>
			[
				'$',
				$_AT['Min amount!! <<incl.>>']|html_entity_decode,
				['min_wrong'=>$_AT['input min [from 0.010]']|html_entity_decode]
			],
		'pMax'=>
			[
				'$',
				$_AT['Max amount!! <<NOT incl.>>']|html_entity_decode,
				['max_wrong'=>$_AT['specify the maximum amount [to 1000000.000]']|html_entity_decode]
			],
		'pBonus'=>
			[
				'%',
				$_AT['Bonus in perc.']
			],
        'pBonusDay'=>
			[
				'%',
				$_AT['Bonus in perc (everyday)']
			],
		'pWDays'=>
			[
				'C',
				$_AT['Only']|cat:" <a href=\"{_link module='calendar/admin/days'}\" target=\"_blank\">"|cat:$_AT['work days']|cat:"</a> "|cat:$_AT['<<for periods not more than day>>']|html_entity_decode
			],
        'pPClndr'=>
			[
				'C',
				$_AT['Profit perc. from Calendar <<if calndar not set or 0% - percent will set from plan>>']|html_entity_decode
			],
		'pPerc'=>
			[
				'%',
				$_AT['Profit perc.'],
				['perc_wrong'=>$_AT['input perc']]
			],
		'pPer'=>
			[
				'I',
				$_AT['Accrual period!! <<in hours>>']|html_entity_decode,
				['period_wrong'=>$_AT['input period']]
			],
		'pNPer'=>
			[
				'I',
				$_AT['Periods count <<0 - endless>>']|html_entity_decode
			],
		'pReturn'=>
			[
				'%',
				$_AT['Perc. payout at the end of deposit'],
				['perc2_wrong'=>$_AT['input perc.']],
				'default'=>100
			],
		1=>$_AT['Reinvest'],
		'pCompndMin'=>
			[
				'%',
				$_AT['Min perc'],
				['compndmin_wrong' => $_AT['wrong value']]
			],
		'pCompndMax'=>
			[
				'%',
				$_AT['Max perc <<0 - disabled>>']|html_entity_decode,
				['compndmax_wrong' => $_AT['wrong value']]
			],
		$_AT['Deposit increase'],
		'pEnAdd'=>
			[
				'C',
				$_AT['Enable']
			],
		'pMinAdd'=>
			[
				'$',
				$_AT['Min amount <<incl.>>']|html_entity_decode
			],
		$_AT['Deposit decrease (Removal)'],
		'pClComis'=>
			[
				'%',
				$_AT['Comission perc. <<100 - disabled>>']|html_entity_decode,
				['clcomis_wrong' => $_AT['wrong value']],
				'default'=>100
			],
		'pMPer'=>
			[
				'I',
				$_AT['Number of periods can not be removed']
			],
		'pClPer'=>
			[
				'I',
				$_AT['Number of periods no comission']
			],
		$_AT['Restrictions'],
		'pGroupReq'=>
			[
				'I',
				$_AT['Available only after the deposit of the plan with group<br><<0 - not use>>']|html_entity_decode
			],
		'pMaxCount'=>
			[
				'I',
				$_AT['Max number of deposits with the plan <<0 - no limits>>']|html_entity_decode
			],
		$_AT['Special ref.system'],
		'pDPerc'=>
			[
				'A',
				$_AT['From deposit<br><<values by levels>>']|html_entity_decode
			],
		'pPPerc'=>
			[
				'A',
				$_AT['From profit<br><<values by levels>>']|html_entity_decode
			]
	]
	values=$el
}

{include file='admin/admin/footer.tpl'}
{/strip}