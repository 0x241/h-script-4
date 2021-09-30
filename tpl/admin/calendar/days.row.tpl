{strip}
<td>
	{$l.cID}
</td>
<td class="nowrap">
	{$l.cTS}
</td>
<td>
	<a href="{_link module='calendar/admin/day'}?id={$l.cID}">{$l.cPerc}</a>
</td>
<td>
    <a href="{_link module='calendar/admin/day'}?id={$l.cID}">{$d_types[$l.cType]}</a>
</td>
{/strip}