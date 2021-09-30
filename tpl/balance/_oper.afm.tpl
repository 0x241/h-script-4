{if $pvalues.acc}

	{if $el.oState <= 1}

		<br>
		<p class="info">
			{if $pform}{$_TRANS['If you can not pay directly through the merchant']},<br>{/if}
			{$_TRANS['You can make a payment on the specified details manually,<br>and then specify the details of this payment in the form below']|html_entity_decode}
		</p>

	{/if}

	<h2>{$_TRANS['Our payment details']}<br>({$_TRANS['to pay manually through']} {$el.cName})</h2>

	<table class="styleTable" border="0" cellspacing="0" cellpadding="0" width="100%">
	{foreach from=$pfields key=f item=v}
	{if $pvalues[$f]}
		<tr>
			<td align="right">
				{$v[0] = str_replace('*', ' <span class="descr_rem">($_TRANS["optional"])</span>', $v[0])}
				{if $f === 'acc'}
					{$_TRANS['Payee account']} <span class="descr_rem">({$v[0]})</span>
				{else}
					{$v[0]}
				{/if}
			</td>
			<td>
				<span class="uline">{$pvalues[$f]}</span>
			</td>
		</tr>
	{/if}
	{/foreach}
		<tr>
			<td align="right">
				{$_TRANS['Amount']}
			</td>
			<td>
				<span class="uline">{_z($el.oSum2, $el.ocID, 1)}</span>
			</td>
		</tr>
	</table>

{/if}