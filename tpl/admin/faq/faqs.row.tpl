{strip}
<td>
	{$l.fID}
</td>
<td class="nowrap">
	<small>{$l.fCTS}</small>
</td>
<td>
	{if $l.fHidden}*{/if}
</td>
<td>
	<small>{$l.fCat}</small>
</td>
<td>
	{$l.fQuestion}
</td>
<td>
	<a href="{_link module='faq/admin/faq'}?id={$l.fID}">{$l.fAnswer|truncate: 70}</a>
</td>
<td>
	{$l.fOrder}
</td>
{/strip}