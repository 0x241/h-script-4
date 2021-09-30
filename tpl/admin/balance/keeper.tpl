{strip}
{include file='admin/admin/header.tpl' title=$_AT['Online keeper']}

{$_AT['ok_descr']} <a href="http://{$_AT['ok_url']}">{$_AT['ok_url']}</a>
<br><br>

{if $list}

	<table class="Table" border="1">
	<tr>
		<th>
			{$_AT['ok_paysys']}
		<th>
			{$_AT['ok_balance']}
		<th>
			{$_AT['ok_result']}
	{foreach $list as $cid => $l}
	<tr>
		<td>
			{$l.cName}
		<td>
			{_z($l.balance.sum, $cid, 1)}
		<td>
			{$l.balance.result}
	{/foreach}
	</table>

	<h1>{$_AT['ok_header']}</h1>

	{if isset($smarty.get.batch)}

		<p class="info">
			{$_AT['ok_info']} Batch: {$smarty.get.batch}
		</p>

	{/if}

	{include file='edit.tpl'
		url='*'
		fields=[
			'PSys'=>['S', $_AT['ok_fps'], ['psys_empty'=>$_AT['ok_frpserror']], [0=>$_AT['ok_fpsselect']] + (array)$clist],
			'Sum'=>['$', $_AT['ok_fsum'], ['sum_wrong'=>$_AT['ok_fsumerror']]],
			'To'=>['T', $_AT['ok_fw'], ['wallet_empty'=>$_AT['ok_fwerror']]],
			'Memo'=>['W', $_AT['ok_fm'], 'size'=>4]
		]
		btn_text=' '
		btns=['send' => $_AT['ok_fb']]
	}

{else}

	{$_AT['ok_no']}

{/if}

{include file='admin/admin/footer.tpl'}
{/strip}