{strip}
<td>
	{$l.dID}
</td>
<td class="nowrap">
	<small>{$l.dCTS}</small>
</td>
<td>
	<a href="{_link module='account/admin/user'}?id={$l.duID}" target="_blank">{$l.uLogin}</a>
</td>
<td align="right">
	{_z($l.dZD, $l.dcCurrID, 1)}
</td>
<td>
	<a href="{_link module='depo/admin/depo'}?id={$l.dID}">{$l.pName}</a>
</td>
<td class="nowrap">
	<small>{$l.dLTS}</small>
</td>
<td>
	{$l.dNPer} из {$l.pNPer}
</td>
<td align="right">
	{_z($l.dZP, $l.dcCurrID, 1)}
</td>
<td class="nowrap">
	<small>{$l.dNTS}</small>
</td>
<td>
	<a href="{_link module='depo/admin/depo'}?id={$l.dID}">{$ststrs[$l.dState]}</a>
</td>
{/strip}