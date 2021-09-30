{strip}
<td>
	{$l.pID}
</td>
<td>
	{if $l.pHidden}*{/if}
</td>
<td>
	{if $l.pNoCalc}*{/if}
</td>
<td>
	{$l.pGroup}
</td>
<td>
	<a href="{_link module='depo/admin/plan'}?id={$l.pID}">{$l.pName}</a>
</td>
<td>
	{$l.pMin}
</td>
<td>
	{$l.pMax}
</td>
<td>
	{$l.pDays}
</td>
<td>
	{$l.pPerc}
</td>
<td align="right">
	{$l.cnt} ({_z($l.dsum, 1)})
</td>
<td align="right">
	{$l.acnt} ({_z($l.adsum, 1)})
</td>
{/strip}