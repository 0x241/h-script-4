{strip}
{include file='admin/admin/header.tpl' title=$_AT['Settings']}

{include file='edit_admin.tpl'
	values=$cfg
	fields=[
		'Word'=>['T', $_AT['To enable <b>ref.system<b><br>specify the word in a ref-link']|html_entity_decode, 'comment'=>'../?<u>ref</u>=..'],
		'Force'=>['C', $_AT['Force rewrite new  ref in cookie']],
		'Levels'=>['I', $_AT['Number of shown levels <<for multilevel>>']|html_entity_decode],
		1=>$_AT['Add funds'],
		'Type'=>['S', $_AT['Type'], '', [
			$_AT['Multilevel']=>'',
			0=>$_AT['<rate> up-level']|html_entity_decode,
			$_AT['one level']=>'',
			2=>$_AT['&nbsp;from_num_of_actives_refers&nbsp;-&nbsp;rate(%)&nbsp;'],
            3=>$_AT['&nbsp;from_sum_depo_refers&nbsp;-&nbsp;rate(%)&nbsp;'],
            4=>$_AT['&nbsp;from_sum_active_depo_of_user&nbsp;-&nbsp;rate(%)&nbsp;']
		]],
		'_Perc'=>['A', $_AT['Values'], 'size'=>5],
		$_AT['Deposit'],
		'PType'=>['S', $_AT['Type'], '', [
			$_AT['Multilevel']=>'',
			0=>$_AT['<rate> up-level']|html_entity_decode,
        	$_AT['one level']=>'',
        	2=>$_AT['&nbsp;from_num_of_actives_refers&nbsp;-&nbsp;rate(%)&nbsp;'],
        	3=>$_AT['&nbsp;from_sum_depo_refers&nbsp;-&nbsp;rate(%)&nbsp;'],
        	4=>$_AT['&nbsp;from_sum_active_depo_of_user&nbsp;-&nbsp;rate(%)&nbsp;']
		]],
		'_DPerc'=>['A', $_AT['Values'], 'size'=>5],
		$_AT['Accrual'],
		'DType'=>['S', $_AT['Type'], '', [
			$_AT['Multilevel']=>'',
        	0=>$_AT['<rate> up-level']|html_entity_decode,
        	$_AT['one level']=>'',
        	2=>$_AT['&nbsp;from_num_of_actives_refers&nbsp;-&nbsp;rate(%)&nbsp;'],
        	3=>$_AT['&nbsp;from_sum_depo_refers&nbsp;-&nbsp;rate(%)&nbsp;'],
        	4=>$_AT['&nbsp;from_sum_active_depo_of_user&nbsp;-&nbsp;rate(%)&nbsp;']
		]],
		'_PPerc'=>['A', $_AT['Values'], 'size'=>5]
	]
}

{include file='admin/admin/footer.tpl'}
{/strip}