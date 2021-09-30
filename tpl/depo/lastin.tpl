{strip}
{include file='header.tpl' title=$_TRANS['Last investors'] class="cabinet"}

<h1>{$_TRANS['Last investors']}</h1>

{$imgs=[
	1=>'lr_small.png',
	2=>'pm_small.png'
]}

{if $list}
	<table cellspacing="0" cellpadding="0" border="0" class="styleTable">
		<tr>
			<th>{$_TRANS['User']}</th>
			<th>{$_TRANS['Amount']}</th>
			<th>{$_TRANS['Batch']}</th>
		</tr>
		{foreach from=$list key=i item=r}
			{if $r.oSum > 0}
				<tr>
					<td>{include file='_usericon.tpl' user=$r} {$r.uLogin}</td>
					<td align="right"><img src="images/{$imgs[$r.ocID]}"> {_z($r.oSum, $r.ocID)}</td>
					<td>{$r.oBatch}</td>
				</tr>
			{/if}
		{/foreach}
	</table>
{/if}
<br>

{include file='footer.tpl' class="cabinet"}
{/strip}