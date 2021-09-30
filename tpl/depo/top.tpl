{strip}
{include file='header.tpl' title=$_TRANS['Top of inviters']}

<h1>{$_TRANS['Top of inviters']}</h1>

<h2>{$_TRANS['By amount']}</h2>
{if $list1}
	<table cellspacing="0" cellpadding="0" border="0" class="styleTable">
		<tr>
			<th>{$_TRANS['User']}</th>
			<th>{$_TRANS['Amount']}</th>
		</tr>
		{foreach from=$list1 key=i item=r}
			{if $r.RSUM > 0}
				<tr>
					<td>{include file='_usericon.tpl' user=$r} {$r.uLogin}</td>
					<td align="right">{_z($r.RSUM, 1)}</td>
				</tr>
			{/if}
		{/foreach}
	</table>
{/if}
<br>

<h2>{$_TRANS['By count']}</h2>
{if $list2}
	<table cellspacing="0" cellpadding="0" border="0" class="styleTable">
		<tr>
			<th>{$_TRANS['User']}</th>
			<th>{$_TRANS['Count']}</th>
		</tr>
		{foreach from=$list2 key=i item=r}
			{if $r.RCNT > 0}
				<tr>
					<td>{include file='_usericon.tpl' user=$r} {$r.uLogin}</td>
					<td align="right">{$r.RCNT}</td>
				</tr>
			{/if}
		{/foreach}
	</table>
{/if}

{include file='footer.tpl'}
{/strip}