{strip}
{include file='admin/admin/header.tpl' title=$_AT['Deposits']}

{include file='depo/_statuses.tpl'}

{include file='edit.begin.tpl' form='deps_filter' url='*'}
<table class="formatTable">
<tr>
	{include file='edit.row.tpl' f='uLogin' v=['T', $_AT['User'], 'size'=>10]
		vv=$smarty.session[$edit_form_name].uLogin l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
        {include file='edit.row.tpl' f='dcCurrID' v=['S', $_AT['Account currency'], 0, [''=>$_AT['- all -'], 'USD' => 'USD', 'EUR' => 'EUR', 'RUB' => 'RUB', 'BTC' => 'BTC', 'ETH' => 'ETH', 'XRP' => 'XRP']]
		vv=$smarty.session[$edit_form_name].dcCurrID l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='dpID' v=['S', $_AT['Plan'], 0, [$_AT['- all -']] + $plans]
		vv=$smarty.session[$edit_form_name].dpID l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='dState' v=['S', $_AT['State'], 0, [9=>$_AT['- all -']] + $ststrs]
		vv=valueIf(isset($smarty.session[$edit_form_name]), $smarty.session[$edit_form_name].dState, 9) l_width='0%' r_width='0%'}
</tr>
</table>
{include file='edit.end.tpl' btn_text=$_AT['Filter'] btns=valueIf(isset($smarty.session[$edit_form_name]), ['clear'=>$_AT['Show all']])}
<br>
<a href="{_link module='depo/admin/depo'}?add" class="button-blue">{$_AT['Create deposit']}</a><br>
<br>
{include file='list_admin.tpl'
	title=$_AT['Deposits']|cat:"{valueIf(isset($smarty.session[$edit_form_name]), $_AT['(filtered)'])}"
	url='*'
	fields=[
		'dID'=>[$_AT['ID']],
		'dCTS'=>[$_AT['Creation date']],
		'uLogin'=>[$_AT['User']],
		'dZD'=>[$_AT['Amount']],
		'pName'=>[$_AT['Plan']],
		'dLTS'=>[$_AT['Last accrual']],
		'dN'=>[$_AT['Accruals count']],
		'dZP'=>[$_AT['<small>Profit</small>']|html_entity_decode],
		'dNTS'=>[$_AT['Next accrual']],
		'dState'=>[$_AT['State']]
	]
	values=$list
	row='*'
}

<a href="{_link module='depo/admin/depo'}?add" class="button-blue">{$_AT['Create deposit']}</a><br>

{include file='admin/admin/footer.tpl'}
{/strip}