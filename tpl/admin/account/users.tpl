{strip}
{include file='admin/admin/header.tpl' title=$_AT['Users']}

{include file='admin/account/_statuses.tpl'}

{include file='edit.begin.tpl' form='users_filter' url='*'}
<table class="formatTable">
<tr>
	{include file='edit.row.tpl' f='uGroup' v=['T', $_AT['Group'], 'size'=>10]
		vv=$smarty.session[$edit_form_name].uGroup l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='uLogin' v=['T', $_AT['<i>Login</i>']|html_entity_decode, 'size'=>10]
		vv=$smarty.session[$edit_form_name].uLogin l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='aName' v=['T', $_AT['<i>Name</i>']|html_entity_decode, 'size'=>10]
		vv=$smarty.session[$edit_form_name].aName l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='uMail' v=['T', $_AT['<i>e-mail</i>']|html_entity_decode, 'size'=>15]
		vv=$smarty.session[$edit_form_name].uMail l_width='0%' r_width='0%'}
<tr>
</tr>
	<td colspan="3"></td>
	{include file='edit.row.tpl' f='uState' v=['S', $_AT['State'], 0, [9=>$_AT['- all -']] + $usr_statuses]
		vv=valueIf(isset($smarty.session[$edit_form_name]), $smarty.session[$edit_form_name].uState, 9) l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='RefLogin' v=['T', $_AT['Ref'], 'size'=>10]
		vv=$smarty.session[$edit_form_name].RefLogin l_width='0%' r_width='0%'}
</tr>
</table>
{include file='edit.end.tpl' btn_text=$_AT['Filter'] btns=valueIf(isset($smarty.session[$edit_form_name]), ['clear'=>$_AT['Show all']])}
{include file='list_admin.tpl'
	title=$_AT['Users']|cat:"{valueIf(isset($smarty.session[$edit_form_name]), $_AT['(filtered)'])}"
	url='*'
	fields=[
		'uID'=>[$_AT['ID']],
		'uGroup'=>[$_AT['Group']],
		'uLogin'=>[$_AT['Login']],
		'aName'=>[$_AT['Name']],
		'uMail'=>[$_AT['e-mail']],
		'uState'=>[$_AT['State']],
		'uLevel'=>[$_AT['<small>Level</small>']|html_entity_decode],
		'RefLogin'=>[$_AT['Ref']],
		'uBalUSD'=>["{$_AT['Balance']} USD"],
		'uBalEUR'=>["{$_AT['Balance']} EUR"],
		'uBalRUB'=>["{$_AT['Balance']} RUB"],
		'uBalBTC'=>["{$_AT['Balance']} BTC"],
		'uBalETH'=>["{$_AT['Balance']} ETH"],
		'uBalXRP'=>["{$_AT['Balance']} XRP"]
	]
	values=$list
	row='*'
	include_code='<input name="Group" type="text">'
	btns=['setgroup'=>$_AT['Set group'], 'del'=>$_AT['Delete']]
}

<a href="{$root_url}admin/account/user?add" class="button-blue">{$_AT['Add user']}</a><br>

{include file='admin/admin/footer.tpl'}
{/strip}