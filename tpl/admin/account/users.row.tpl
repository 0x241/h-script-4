{strip}
<td>
	{$l.uID}
</td>
<td>
	{$l.uGroup}
</td>
<td>
	<a href="{_link module='account/admin/user'}?id={$l.uID}">{$l.uLogin}</a>
</td>
<td>
	<a href="{_link module='account/admin/user2'}?id={$l.uID}">{$l.aName}</a>
</td>
<td>
	<a href="{_link module='account/admin/user'}?id={$l.uID}">{$l.uMail}</a>
</td>
<td>
	{$usr_statuses[$l.uState]}
</td>
<td>
	{$l.uLevel}
</td>
<td>
	<a href="{_link module='account/admin/user'}?id={$l.uRef}">{$l.RefLogin}</a>
</td>
      <td>{_z($l.uBalUSD, 'USD')}</td>
      <td>{_z($l.uBalEUR, 'EUR')}</td>
      <td>{_z($l.uBalRUB, 'RUB')}</td>
      <td>{_z($l.uBalBTC, 'BTC')}</td>
      <td>{_z($l.uBalETH, 'ETH')}</td>
      <td>{_z($l.uBalXRP, 'XRP')}</td>
{/strip}