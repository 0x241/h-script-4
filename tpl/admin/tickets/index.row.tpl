{strip}
<td>
	{$l.tID}
</td>
<td class="nowrap">
	<small>{$l.tLTS}</small>
</td>
<td>
	{$l.uLogin}
	<br>
	<small>{$l.tMail}</small>
</td>
<td>
	<a href="{_link module='tickets/admin/ticket'}?id={$l.tID}">{$l.tTopic}</a>
</td>
<td>
	<small>{$l.tText|truncate: 60}</small>
</td>
<td>
	{$_tstates[$l.tState]}
</td>
<td>
	{$l.cnt}
</td>
{/strip}