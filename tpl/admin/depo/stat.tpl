{strip}
{include file='admin/admin/header.tpl' title=$_AT['Statistics']}

<h2>{$_AT['Information']}</h2>

{$_AT['Total users']}: {$users.all}, {$_AT['incl. active']}: {$users.active}, {$_AT['incl. with deposits']}: {$users.wdepo}<br>
{$_AT['Total dposits']}: {$deps.all}, {$_AT['incl. active']}: {$deps.active}<br>
<br>

<table class="styleTable1" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th></th>
		<th colspan="11">{$_AT['Operation']}</th>
		<th rowspan="2"><small>{$_AT['Active deposits']}</small></th>
		<th colspan="3">{$_AT['Balance']}</th>
	</tr>
	<tr>
		<th>{$_AT['Currency']}</th>
		<th><small>{$_AT['Bonus']}</small></th>
		<th><small>{$_AT['Penalty']}</small></th>
		<th><small>{$_AT['Add funds']}</small></th>
		<th><small>{$_AT['Ref.com']}</small></th>
		<th><small>{$_AT['Deposit']}</small></th>
		<th><small>{$_AT['Reinvest']}</small></th>
		<th><small>{$_AT['Removal']}</small></th>
		<th><small>{$_AT['Accrual']}</small></th>
		<th><small>{$_AT['Calcout']}</small></th>
		<th><small>{$_AT['Pending']}</small></th>
		<th><small>{$_AT['Withdrawal']}</small></th>
		<th><small>{$_AT['Available']}</small></th>
		<th><small>{$_AT['Locked']}</small></th>
		<th><small>{$_AT['Waiting']}</small></th>
	</tr>
{foreach $stat as $cid => $c}
	<tr>
		<td align="right">{$cid}</td>
		<td align="right">{_z($stat[$cid].BONUS, $cid, -1)}</td>
		<td align="right">{_z($stat[$cid].PENALTY, $cid, -1)}</td>
		<td align="right">{_z($stat[$cid].CASHIN, $cid, -1)}</td>
		<td align="right">{_z($stat[$cid].REF, $cid, -1)}</td>
		<td align="right">{_z($stat[$cid].GIVE, $cid, -1)}</td>
		<td align="right">{_z($stat[$cid].GIVE2, $cid, -1)}</td>
		<td align="right">{_z($stat[$cid].TAKE, $cid, -1)}</td>
		<td align="right">{_z($stat[$cid].CALCIN, $cid, -1)}</td>
		<td align="right">{_z($stat[$cid].CALCOUT, $cid, -1)}</td>
		<td align="right">{_z($stat[$cid].CASHOUT2, $cid, -1)}</td>
		<td align="right">{_z($stat[$cid].CASHOUT, $cid, -1)}</td>
		<td align="right">{_z($stat[$cid].DEPO, $cid, -1)}</td>
		<td align="right">{_z($stat[$cid].BAL, $cid, -1)}</td>
		<td align="right">{_z($stat[$cid].LOCK, $cid, -1)}</td>
		<td align="right">{_z($stat[$cid].OUT, $cid, -1)}</td>
	</tr>
{/foreach}
</table>
<br>

{include file='edit_admin.tpl'
	title=$_AT['Filter parameters']
	fields=[
		'PSys'=>
			[
				'S',
				$_AT['Currency'],
				0,
				[0=>$_AT['- all -'], 'USD' => 'USD', 'EUR' => 'EUR', 'RUB' => 'RUB', 'BTC' => 'BTC', 'ETH' => 'ETH', 'XRP' => 'XRP']
			],
		'D1'=>
			[
				'DT',
				$_AT['Date from'],
				'default'=>$today
			],
		'D2'=>
			[
				'DT',
				$_AT['Date to']
			]
	]
	btn_text=$_AT['Show']
}

{if $res}
	<br>
	<table class="styleTable1" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td></td>
          {foreach $currs as $cid => $c}{if $res.$cid}
            <td>{$cid}</td>
          {/if}{/foreach}
        </tr>
		<tr>
			<td>{$_AT['Registtrations']}</td>
            {foreach $currs as $cid => $c}{if $res.$cid}
			   <td align="right">{$res.REG}</td>
            {/if}{/foreach}    
		</tr>
		<tr>
			<td>{$_AT['Bonus']}</td>
            {foreach $currs as $cid => $c}{if $res.$cid}
		    	<td align="right">{_z($res.$cid.BONUS, 1)}</td>
            {/if}{/foreach}        
		</tr>
		<tr>
			<td>{$_AT['Penalty']}</td>
            {foreach $currs as $cid => $c}{if $res.$cid}
			   <td align="right">{_z($res.$cid.PENALTY, 1)}</td>
            {/if}{/foreach}      
		</tr>
		<tr>
			<td>{$_AT['Add funds']}</td>
            {foreach $currs as $cid => $c}{if $res.$cid}
			  <td align="right">{_z($res.$cid.CASHIN, 1)}</td>
            {/if}{/foreach}     
		</tr>
		<tr>
			<td>{$_AT['Ref.com']}</td>
            {foreach $currs as $cid => $c}{if $res.$cid}
		    	<td align="right">{_z($res.$cid.REF, 1)}</td>
            {/if}{/foreach}    
		</tr>
		<tr>
			<td>{$_AT['Deposit']}</td>
            {foreach $currs as $cid => $c}{if $res.$cid}
			  <td align="right">{_z($res.$cid.GIVE, 1)}</td>
            {/if}{/foreach}       
		</tr>
		<tr>
			<td>{$_AT['Removal']}</td>
            {foreach $currs as $cid => $c}{if $res.$cid}
			   <td align="right">{_z($res.$cid.TAKE, 1)}</td>
            {/if}{/foreach}        
		</tr>
		<tr>
			<td>{$_AT['Accrual']}</td>
            {foreach $currs as $cid => $c}{if $res.$cid}
			   <td align="right">{_z($res.$cid.CALCIN, 1)}</td>
            {/if}{/foreach}      
		</tr>
		<tr>
			<td>{$_AT['Calcout']}</td>
            {foreach $currs as $cid => $c}{if $res.$cid}
			   <td align="right">{_z($res.$cid.CALCOUT, 1)}</td>
            {/if}{/foreach}   
		</tr>
		<tr>
			<td>{$_AT['Withdraw']}</td>
            {foreach $currs as $cid => $c}{if $res.$cid}
		      <td align="right">{_z($res.$cid.CASHOUT, 1)}</td>
            {/if}{/foreach}    
		</tr>
		<tr>
			<td>{$_AT['Deposited']}</td>
            {foreach $currs as $cid => $c}{if $res.$cid}
			   <td align="right">{_z($res.$cid.DEPO, 1)}</td>
            {/if}{/foreach}      
		</tr>
		<tr>
			<td>{$_AT['incl. active now']}</td>
            {foreach $currs as $cid => $c}{if $res.$cid}
			   <td align="right">{_z($res.$cid.DEPO2, 1)}</td>
            {/if}{/foreach}         
		</tr>
		<tr>
			<td>{$_AT['System profit']}</td>
            {foreach $currs as $cid => $c}{if $res.$cid}
			  <td align="right">{_z($res.$cid.CASHIN - $res.$cid.CASHOUT, 1)}</td>
            {/if}{/foreach}      
		</tr>
	</table>

{/if}

{include file='admin/admin/footer.tpl'}
{/strip}