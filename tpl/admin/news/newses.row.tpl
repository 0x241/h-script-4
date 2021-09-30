{strip}
<td>
	{$l.nID}
</td>
<td class="nowrap">
	<small>{$l.nTS}</small>
</td>
<td>
	<a href="{_link module='news/admin/news'}?id={$l.nID}">{$l.nAnnounce|truncate: 70}</a>
</td>
<td>
	<small>{$l.nDBegin}</small>
</td>
<td>
	<small>{$l.nDEnd}</small>
</td>
<td>
	{if $l.nAttn}{$_AT['Yes']}{/if}
</td>
{/strip}