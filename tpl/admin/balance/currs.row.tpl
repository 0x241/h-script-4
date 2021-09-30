{strip}
<td>
	{$l.cID}
</td>
<td class="nowrap">
	{$l.cCID} {$l.cCurrID}
</td>
<td>
	<a href="{_link module='balance/admin/curr'}?id={$l.cID}">{$l.cName}</a>
</td>
<td>
	{$l.cCurr}
</td>
<td>
{if $_cfg.Bal_Update}
	{_z($l.cBal, $l.cID)}<br>
	<small>{timeToStr(stampToTime($l.cBalTS))}</small>
{/if}
</td>
<td>
	{if $l.PAPI.apipass}
		<a href="{_link module='balance/admin/curr'}?id={$l.cID}&testapi">тест</a>
	{/if}
</td>
<td>
	{if $l.cDisabled}<b style="color: red">X</b>{/if}
</td>
<td>
	{if $l.cCASHINMode > 0}*{/if}
</td>
<td>
	{if $l.cCASHOUTMode > 0}*{/if}
</td>
<td align="right">
	{if $l.cEXMode > 0}<small>{$l.cEXOut}/{$l.cEXIn}</small>{/if}
</td>
<td>
	{if $l.cTRMode > 0}*{/if}
</td>
<td>
	{if $l.cBUYMode > 0}*{/if}
</td>
<td>
	{if $l.cSELLMode > 0}*{/if}
</td>
<td>
	{if $l.cBUY2Mode > 0}*{/if}
</td>
<td>
	{if $l.cSELL2Mode > 0}*{/if}
</td>
<td>
	{if $l.cGIVEMode > 0}*{/if}
</td>
<td>
	{if $l.cTAKEMode > 0}*{/if}
</td>
<td>
	{if $l.cHidden}{$_AT['Yes']}{/if}
</td>
{/strip}