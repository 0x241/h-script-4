{strip}
{if $currs}
<table class="styleTable" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th>{$_TRANS['Currency account']}</th>
		<th><small>{$_TRANS['Available']}</small></th>
		<th><small>{$_TRANS['Busy']}</small></th>
		<th><small>{$_TRANS['Pending']}</small></th>
	</tr>
{foreach from=$currs key=i item=c}
{if ($c.Bal != 0) or ($c.Lock != 0) or ($c.Out != 0)}
	<tr>
		<td>{$i}</td>
		<td align="right">{_z($c.Bal, $i, -1)}</td>
		<td align="right">{_z($c.Lock, $i, -1)}</td>
		<td align="right">{_z($c.Out, $i, -1)}</td>
	</tr>
{/if}
{/foreach}
</table>
{/if}
{/strip}
