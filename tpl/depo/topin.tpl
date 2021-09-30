{strip}
{include file='header.tpl' title=$_TRANS['Top of investors']}

<h1>{$_TRANS['Top of investors']}</h1>

{if $list}
	<table cellspacing="0" cellpadding="0" border="0" class="styleTable">
		<tr>
			<th>{$_TRANS['User']}</th>
			<th>{$_TRANS['Deposit amount']}</th>
		</tr>
		{foreach from=$list key=i item=r}
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

{include file='footer.tpl'}
{/strip}