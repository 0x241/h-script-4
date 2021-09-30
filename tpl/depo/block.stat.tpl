{strip}

{$_TRANS['Project works']} {$stat.worked} {$_TRANS['days']}<br>
{$_TRANS['Total users']} {$stat.users}<br>
{$_TRANS['Users on-line']} {$stat.usersonline}<br>
{$_TRANS['Total accepted funds']} USD ${$stat.zinUSD|string_format:"%.2f"}<br>
{$_TRANS['Total accepted funds']} EUR ${$stat.zinEUR|string_format:"%.2f"}<br>
{$_TRANS['Total accepted funds']} RUB ${$stat.zinRUB|string_format:"%.2f"}<br>
{$_TRANS['Total accepted funds']} BTC ${$stat.zinBTC|string_format:"%.4f"}<br>
{$_TRANS['Total accepted funds']} ETH ${$stat.zinETH|string_format:"%.4f"}<br>
{$_TRANS['Total accepted funds']} XRP ${$stat.zinXRP|string_format:"%.4f"}<br>
{$_TRANS['Total withdrawals']} USD ${$stat.zoutUSD|string_format:"%.2f"}<br>
{$_TRANS['including RCB']} USD ${$stat.zrefUSD|string_format:"%.2f"}<br>
{$_TRANS['Total withdrawals']} EUR ${$stat.zoutEUR|string_format:"%.2f"}<br>
{$_TRANS['including RCB']} EUR ${$stat.zrefEUR|string_format:"%.2f"}<br>
{$_TRANS['Total withdrawals']} RUB ${$stat.zoutRUB|string_format:"%.2f"}<br>
{$_TRANS['including RCB']} RUB ${$stat.zrefRUB|string_format:"%.2f"}<br>
{$_TRANS['Total withdrawals']} BTC ${$stat.zoutBTC|string_format:"%.2f"}<br>
{$_TRANS['including RCB']} BTC ${$stat.zrefBTC|string_format:"%.2f"}<br>
{$_TRANS['Total withdrawals']} ETH ${$stat.zoutETH|string_format:"%.2f"}<br>
{$_TRANS['including RCB']} ETH ${$stat.zrefETH|string_format:"%.2f"}<br>
{$_TRANS['Total withdrawals']} XRP ${$stat.zoutXRP|string_format:"%.2f"}<br>
{$_TRANS['including RCB']} XRP ${$stat.zrefXRP|string_format:"%.2f"}<br>
{if $stat.lastuser}
    {$_TRANS['New user']} ({$stat.lastuser.uLogin})<br>
{/if}
{if $stat.lastinop}
    {$_TRANS['New deposit']} ${$stat.lastinop.oSum|string_format:"%.2f"} ({$stat.lastinop.uLogin})<br>
{*  New deposit {_z($stat.lastinop.oSum, $stat.lastinop.ocID, 2)} ({$stat.lastinop.uLogin})<br>*}
{/if}
{if $stat.lastoutop}
    {$_TRANS['Last withdrawal']} ${$stat.lastoutop.oSum|string_format:"%.2f"} ({$stat.lastoutop.uLogin})<br>
{/if}

{/strip}