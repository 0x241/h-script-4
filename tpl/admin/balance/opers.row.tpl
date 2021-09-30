{strip}
<td>
	{$l.oID}
</td>
<td>
	<a href="{_link module='account/admin/user'}?id={$l.ouID}" target="_blank">{$l.uLogin}</a>
	<br>
	<sup>{$l.oParams.user}</sup>
</td>
<td class="nowrap">
	<small>{$l.oCTS}</small>
	<br>
	<small>{$l.oTS}</small>
</td>
<td>
	<a href="{_link module='balance/admin/oper'}?id={$l.oID}">
		{$op_names[$l.oOper]}
	</a>
</td>
<td>
	{if in_array($l.oOper, ['BONUS', 'PENALTY', 'CASHIN', 'CASHOUT', 'TR', 'TRIN'])}
		<small><a href="{_link module='balance/admin/curr'}?id={$l.ocID}" target="_blank">{$l.cName}</a></small><br>
        	{_z($l.oSum2, $l.ocID, 1)}
	{/if}
	
</td>
<td align="right">
	{_z($l.oSum, $l.ocCurrID, 1)}
	{if $l.oComis != 0}
		<br>
		<sup>{_z($l.oComis, $l.ocCurrID, -1)}</sup>
	{/if}
</td>
<td align="right">{$l.summ_currency_operation} {$l.curr_operation}</td>
<td>
	{$l.oBatch}
	<br><small>{$l.oParams2.acc}</small>
</td>
<td class="nowrap">
	<a href="{_link module='balance/admin/oper'}?id={$l.oID}">
		{$op_statuses[$l.oState]}
	</a>
</td>
<td>
	<small>
		{$l.oMemo}
	</small>
</td>
{/strip}