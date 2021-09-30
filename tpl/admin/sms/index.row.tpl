{strip}
<td>
	{$l.qID}
	<br>
	<sup>{$l.qKey}</sup>
</td>
<td class="nowrap">
	{if $l.quID}
		<a href="{_link module='adm_user'}?id={$l.quID}" target="_blank">{$l.uLogin}</a>
	{else}
		{$_AT['- System -']}
	{/if}
	<br>
	<small>{$l.qTS}</small>
</td>
<td>
	{$l.qTo}
</td>
<td>
	<small>{$l.qText|truncate: 70}</small>
</td>
<td class="nowrap">
	{$sms_statuses[$l.qState]}
	<br>
	<small>{$l.qSTS}</small>
</td>
<td align="right">
	{$l.qParts}
</td>
<td>
	<small>
		{exValue($l.qError, $sms_errors[$l.qError])}
	</small>
</td>
<td>
	<small>
		{if $l.qErrCnt}{$l.qErrCnt}{/if}
	</small>
</td>
{/strip}