{strip}
<td class="nowrap">
	<small>{$l.tLTS}</small>
</td>
<td>
	<a href="{_link module='tickets/ticket'}?id={$l.tID}">{$l.tTopic}</a>
</td>
<td>
	{$_tstates[$l.tState]}
</td>
<td>
	{$l.cnt}
</td>
{/strip}