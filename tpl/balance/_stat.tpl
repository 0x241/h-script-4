{strip}
{if $stats}
<table class="styleTable" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<th class="alignleft">{$_TRANS['Pay. system']}</th>
		<th>{$_TRANS['Referral']}</th>
		<th>{$_TRANS['Added']}</th>
		<th>{$_TRANS['Deposited']}</th>
		<th>{$_TRANS['Accrued']}</th>
		<th>{$_TRANS['Withdrawal']}</th>
	</tr>
{foreach from=$stats key=i item=c}
	<tr>
		<td class="alignleft">{$c.cName} <i><small>{$c.cCurr}</small></i></td>
		<td>{_z($c.ZREF, $c.cID, -1)}</td>
		<td>{_z($c.ZIN, $c.cID, -1)}</td>
		<td>{_z($c.ZINDEPO, $c.cID, -1)}</td>
		<td>{_z($c.ZCALCIN, $c.cID, -1)}</td>
		<td>{_z($c.ZOUT, $c.cID, -1)}</td>
	</tr>
{/foreach}
</table>
{/if}
{/strip}