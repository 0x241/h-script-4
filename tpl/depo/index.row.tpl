{strip}
<td>
	{$l.dID}
</td>
<td class="nowrap">
	<small>{$l.dCTS}</small>
</td>
<td align="right">
	{_z($l.dZD, $l.dcCurrID, 1)}
</td>
<td>
	<a href="{_link module='depo/depo'}?id={$l.dID}">{$l.pName}</a>
</td>
<td class="nowrap">
	<small>{$l.dLTS}</small>
</td>
<td>
	{$l.dNPer} of {$l.pNPer}
	<br><small id="progress{$l.dID}"></small>
</td>
<td align="right">
	{_z($l.dZP, $l.dcCurrID, 1)}
	<br><small id="profit{$l.dID}"></small>
</td>
<td class="nowrap">
	<small>{$l.dNTS}</small>
	<br><span id="timer{$l.dID}"></span>
</td>
<td>
	<a href="{_link module='depo/depo'}?id={$l.dID}">{$ststrs[$l.dState]}</a>
</td>
{if $l.dState == 1}
<script>
	setInterval(function(){
		updateDepoProgress({$l.dID}, {0+$l.CurrentProgress}, {0+$l.ProgressPerHour});
		updateDepoProfit({$l.dID}, {0+$l.CurrentProfit}, {0+$l.ProfitPerHour});
	}, 200);
	{if $l.Timer}inittimer({$l.dID}, {$l.Timer.D}, {$l.Timer.H}, {$l.Timer.M}, {$l.Timer.S});{/if}
</script>
{/if}
{/strip}