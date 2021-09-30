{strip}
{include file='admin/admin/header.tpl' title=$_AT['Settings']}

{if $curr1 && $_cfg.Const_IntCurr}
	<p class="info">
			{$_AT['Script is running in "Uniform currency']} ({$curr1.cCurrID})" {$_AT['mode']}.<br>
			{$_AT['This means that all the operations in the system will performs only in this currency,<br>all funds, supplemented with external payment systems will automatically<br>converted into local currency at the following rate']|html_entity_decode}
	</p>
{/if}

{$clist = []}
{foreach $currs2 as $cid => $c}
	{$clist[$cid] = $c.cName}
{/foreach}

{include file='edit_admin.tpl'
	values=$cfg
	fields=[
		'RegBonus'=>['$', $_AT['The bonus amount for registration <<in internal units>>']|html_entity_decode],
       	'RegBonusCurrency'=>['S', $_AT['Registration currency bonus'], 0, $clist],
		'LockWallets'=>['C', $_AT['Deny to change payment details']],
		1=>$_AT['Rates (in internal units)'],
		'RateUSD'=>['$', '1 USD ='],
		'RateEUR'=>['$', '1 EUR ='],
		'RateRUB'=>['$', '1 RUB ='],
		'UpdateRates'=>['C', $_AT['Refresh rates <<from cite cbr.ru>>']|html_entity_decode, 'comment'=>$lastupdate],
		'RateBTC'=>['$', '1 BTC ='],
		'UpdateBTCRate'=>['C', 'Refresh BTC rate <<from site cryptonator.com>>'],
		'RateETH'=>['$', '1 ETH ='],
		'UpdateETHRate'=>['C', 'Refresh ETH rate <<from site cryptonator.com>>'],
		'RateLTC'=>['$', '1 LTC ='],
		'UpdateLTCRate'=>['C', 'Refresh LTC rate <<from site cryptonator.com>>'],
		'RateXRP'=>['$', '1 XRP ='],
		'UpdateXRPRate'=>['C', 'Refresh XRP rate <<from site cryptonator.com>>'],
		'Update'=>['C', 'Update wallets balances'],

		$_AT['Add funds'],
		'SumInInternal'=>['C', 'Input amount in internal units', 'skip' => !$_cfg.Const_IntCurr],
		'CASHINText'=>['T', $_AT['Memo <<use #id#, #user#>>']|html_entity_decode, 'size'=>30],
		'ForcePayer'=>['C', $_AT['Force <<and fix>> payeer accont number']|html_entity_decode],
		'AFMMode'=>['S', 'Manual payment parameters input', [], ['separated', 'direct: account', 'direct: batch', 'direct: account+batch']],

		$_AT['Withdraw'],
		'CASHOUTText'=>['T', $_AT['Memo <<use #id#, #user#>>']|html_entity_decode, 'size'=>30],
		'NeedPIN'=>['C', $_AT['Require PIN-code <<in manual mode>>']|html_entity_decode],
		'PayOutType' => ['S', $_AT['Output'], 0, [0 => $_AT['dear to'], 2 => $_AT['proportsyonalno']]],

		$_AT['OperEX'],
		'OperEXMode'=>		['S', $_AT.Mode, 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['instant']]],
		'OperEXMin'=>		['$', $_AT['Min amount']],
		'OperEXMax'=>		['$', $_AT['Max amount <<0 - default>>']|html_entity_decode],
		'OperEXInt'=>		['C', $_AT['Only integer amounts'], 'default'=>0],
		'OperEXComis'=>	['%', $_AT['Comission, perc.']],
		'OperEXComisMin'=>	['$', $_AT['Min comission']],
		'OperEXComisMax'=>	['$', $_AT['Max comission <<0 - no>>']|html_entity_decode],
		
		$_AT['Automatic withdraw'],
		'AWDBONUS'=>['C', $_AT['Bonus']],
		'AWDEXIN'=>['C', $_AT['Exchange']],
		'AWDTRIN'=>['C', $_AT['Transfer']],
		'AWDSELL'=>['C', $_AT['Sell']],
		'AWDSELL2'=>['C', $_AT['Sell service']],
		'AWDREF'=>['C', $_AT['Ref.bonus']],
		'AWDTAKE'=>['C', $_AT['Removal']],
		'AWDCALCIN'=>['C', $_AT['Accrual']]
	]
}
{*
		$_AT['Operations'],
		'OperBONUS'=>	['S', "{$_AT.Mode} {$_AT.OperBONUS}", 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['instant']]],
		'OperPENALTY'=>	['S', "{$_AT.Mode} {$_AT.OperPENALTY}", 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['instant']]],
		'OperBUY'=>		['S', "{$_AT.Mode} {$_AT.OperBUY}", 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['instant']]],
		'OperSELL'=>	['S', "{$_AT.Mode} {$_AT.OperSELL}", 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['instant']]],
		'OperBUY2'=>	['S', "{$_AT.Mode} {$_AT.OperBUY2}", 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['instant']]],
		'OperSELL2'=>	['S', "{$_AT.Mode} {$_AT.OperSELL2}", 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['instant']]],
		'OperREF'=>		['S', "{$_AT.Mode} {$_AT.OperREF}", 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['instant']]],
		'OperGIVE'=>	['S', "{$_AT.Mode} {$_AT.OperGIVE}", 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['instant']]],
		'OperTAKE'=>	['S', "{$_AT.Mode} {$_AT.OperTAKE}", 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['instant']]],
		'OperCALCIN'=>	['S', "{$_AT.Mode} {$_AT.OperCALCIN}", 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['instant']]],
		'OperCALCOUT'=>	['S', "{$_AT.Mode} {$_AT.OperCALCOUT}", 0, [0=>$_AT['off'], 1=>$_AT['manual'], 2=>$_AT['instant']]],
		
*}
{include file='admin/admin/footer.tpl'}
{/strip}