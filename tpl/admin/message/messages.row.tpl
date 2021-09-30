{strip}
<td>
	{$l.mID}
</td>
<td class="nowrap">
	<small>{$l.mTS}</small>
</td>
<td>
	{$l.uLogin}
	<br>
	<small>{$l.mMail}</small>
</td>
<td>
	{if $l.mToCnt > 1}{$l.mToCnt}: {/if}<small>{$l.To|truncate: 120}</small>
</td>
<td>
	<a href="{_link module='message/admin/message'}?id={$l.mID}">{$l.mTopic}</a>
</td>
<td>
	<small>{$l.mText|truncate: 120}</small>
</td>
{/strip}