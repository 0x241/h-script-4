{strip}
{include file='admin/admin/header.tpl' title=$_AT['Operations']}

{include file='balance/_statuses.tpl'}

{include file='edit.begin.tpl' form='opers_filter' url='*'}
<table class="formatTable">
<tr>
	{include file='edit.row.tpl' f='D1' v=['T', $_AT['D1'], 'size'=>10]
		vv=$smarty.session[$edit_form_name].D1 l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='D2' v=['T', $_AT['D2'], 'size'=>10]
		vv=$smarty.session[$edit_form_name].D2 l_width='0%' r_width='0%'}
<tr>
	{include file='edit.row.tpl' f='uLogin' v=['T', $_AT['User'], 'size'=>10]
		vv=$smarty.session[$edit_form_name].uLogin l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='oOper' v=['S', $_AT['Operation'], 0, [$_AT['- all -']] + $op_names]
		vv=$smarty.session[$edit_form_name].oOper l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='ocID' v=['S', $_AT['Pay.system'], 0, [$_AT['- all -']] + $currs2]
		vv=$smarty.session[$edit_form_name].ocID l_width='0%' r_width='0%'}
<tr>
</tr>
	{include file='edit.row.tpl' f='oBatch' v=['T', $_AT['Batch-number'], 'size'=>10]
		vv=$smarty.session[$edit_form_name].oBatch l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='oState' v=['S', $_AT['State'], 0, [9=>$_AT['- all -']] + $op_statuses]
		vv=valueIf(isset($smarty.session[$edit_form_name]), $smarty.session[$edit_form_name].oState, 9) l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='oMemo' v=['T', $_AT['<i>Description</i>']|html_entity_decode, 'size'=>20]
		vv=$smarty.session[$edit_form_name].oMemo l_width='0%' r_width='0%'}
</tr>
<tr>
    {include file='edit.row.tpl' f='ocCurrID' v=['S', $_AT['Account currency'], 0, [''=>$_AT['- all -'], 'USD' => 'USD', 'EUR' => 'EUR', 'RUB' => 'RUB', 'BTC' => 'BTC', 'ETH' => 'ETH', 'XRP' => 'XRP']]
		vv=valueIf(isset($smarty.session[$edit_form_name]), $smarty.session[$edit_form_name].ocCurrID, 9) l_width='0%' r_width='0%'}
</tr>
</table>
{include file='edit.end.tpl' btn_text=$_AT['Filter'] btns=valueIf(isset($smarty.session[$edit_form_name]), ['clear'=>$_AT['Show all']])}

<link rel="stylesheet" type="text/css" media="all" href="../static/admin/js/jscalendar/calendar-blue.css" title="win2k-cold-1" />
<script type="text/javascript" src="../static/admin/js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="../static/admin/js/jscalendar/calendar-ru.js"></script>
<script type="text/javascript" src="../static/admin/js/jscalendar/calendar-setup.js"></script>
<script type="text/javascript">
	Calendar.setup({
		inputField  : "opers_filter_D1",
		ifFormat    : "%d/%m/%Y",
		button      : "opers_filter_D1"
	});
	Calendar.setup({
		inputField  : "opers_filter_D2",
		ifFormat    : "%d/%m/%Y",
		button      : "opers_filter_D2"
	});
</script>
<br/>
<a href="{_link module='balance/admin/oper'}?add" class="button-blue">{$_AT['Create operation']}</a><br>
<br/>
{include file='list_admin.tpl'
	title=$_AT['Operations']|cat:"{valueIf(isset($smarty.session[$edit_form_name]), $_AT['(filtered)'])}"
	url='*'
	fields=[
		'oID'=>[$_AT['ID']],
		'uLogin'=>[$_AT['User']],
		'oTS'=>[$_AT['Created<br>Completed']|html_entity_decode],
		'oOper'=>[$_AT['Operation']],
		'ocID'=>[$_AT['Pay.system<br><small>Account</small>']|html_entity_decode],
		'oSum'=>[$_AT['Amount<br><small>Comission</small>']|html_entity_decode],
        'summ_currency_operation'=>[$_AT['Comming to account']],
		'oBatch'=>[$_AT['Batch-number']],
		'oState'=>[$_AT['State']],
		'oMemo'=>[$_AT['Description']]
	]
	values=$list
	row='*'
	btns=['complete'=>$_AT['Perform'], 'confirm'=>$_AT['Simulate perform'], 'cancel'=>$_AT['Decline'], 'del'=>$_AT['Delete']]
	linkparams=$linkparams
}

<a href="{_link module='balance/admin/oper'}?add" class="button-blue">{$_AT['Create operation']}</a><br>

{include file='admin/admin/footer.tpl'}
{/strip}