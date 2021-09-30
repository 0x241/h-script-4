{strip}
<td>
	{$l.pID}
</td>
<td>
	{if $l.pHidden}*{/if}
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
	<input name="p[{$l.pID}]" value="{$l.pPerc}" type="text" size="5">
</td>
<td>
	{$l.cnt}
</td>
{/strip}