{strip}
<td class="nowrap">
	<small>{$l.oCTS}</small>
	<br>
	<small>{$l.oTS}</small>
</td>
<td>
	<a href="{_link module='balance/oper'}?id={$l.oID}">
	{if $l.oNTS}
		<b>{$op_names[$l.oOper]}</b>
	{else}
		{$op_names[$l.oOper]}
	{/if}
	</a>
</td>
<td>
{$l.ocID}
	{if $l.ocID > 0}
		{$l.cName}
	{else}
		{$l.ocCurrID}
	{/if}
{$l.ocCurrID}
</td>
<td align="right">
	{if in_array($l.oOper, array('BONUS', 'CASHIN', 'EXIN', 'TRIN', 'SELL', 'REF', 'TAKE', 'CALCIN'))}
		{_z($l.oSum, $l.ocCurrID, -1)}
		{if $l.oComis != 0}
			<br>
			<sup>{_z($l.oComis, $l.ocCurrID, -1)}</sup>
		{/if} 
        {$l.cCurr}
	{/if}
</td>
<td align="right">
	{if in_array($l.oOper, array('PENALTY', 'CASHOUT', 'EX', 'TR', 'BUY', 'GIVE', 'CALCOUT'))}
		<span style="color: red;">{_z($l.oSum, $l.ocCurrID, -1)}</span>
		{if $l.oComis != 0}
			<br>
			<sup>{_z($l.oComis, $l.ocCurrID, -1)}</sup>
		{/if}
         {$l.cCurr}
	{/if}
</td>
<td>
	{$l.oBatch}
</td>
<td class="nowrap">
	<a href="{_link module='balance/oper'}?id={$l.oID}">
	{if $l.oNTS}
		<b>{$op_statuses[$l.oState]}</b>
	{else}
		{$op_statuses[$l.oState]}
	{/if}
	</a>
	{if $l.oNTS}
		<br>
		<small>{$l.oNTS}</small>
	{/if}
</td>
<td>
	{if $l.oParams.user}<i>{$l.oParams.user}</i> {/if}
	<small>
		{if $l.oMemo[0] == '~'}
			Ошибка
		{else}
			{$l.oMemo}
		{/if}
	</small>
</td>
{/strip}