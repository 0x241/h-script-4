{*strip*}
{include file='header.tpl' title=$_TRANS['Operation'] class="cabinet"}

{include file='balance/_statuses.tpl'}

{if $el}

	<h1>{$op_names[$el.oOper]}</h1>
	{if isset($smarty.get.check)}

		<p class="info">
			{$_TRANS['Waiting for payment confirmation...']}
		</p>

	{else}

		{if ($el.oState <= 1)}

			{$opc = (($el.oOper != 'CASHIN') or $dfields)}
			{if $opc}
				<p class="info">
					{$_TRANS['Operation NOT confirmed by you!']}
				</p>
			{/if}

		{elseif $el.oState == 2}

			<p class="info">
				{$_TRANS['The operation will be processed by the Administrator shortly']}
			</p>

		{/if}

		{$b = []}
		{if $el.oState <= 2}
			{$b['cancel'] = $_TRANS['Cancel']}
		{/if}
		{if $el.oState >= 5}
			{$b['del'] = $_TRANS['Delete']}
		{/if}
		{include file='balance/_oper.tpl' bt=valueIf($opc, $_TRANS['Confirm'], ' ') b=$b edit_form_name='balance/oper_frm'
			errors=[
				'oper_not_found'=>$_TRANS['wrong state'],
        'oper_disabled'=>$_TRANS['operation disabled'],
        'low_bal1'=>$_TRANS['insufficient funds'],
        'data_date_wrong'=>$_TRANS['wrong operation date'],
        'data_sum_wrong'=>$_TRANS['wrong amount'],
        'data_batch_wrong'=>$_TRANS['batch-number empty'],
        'batch_exists'=>$_TRANS['operation with batch-number already exists']
			]
		}

	{/if}

{else}

	{include file='balance/_bal.tpl'}

	{$oper = $smarty.get.add}
	{if $oper == 'CASHIN'}

		{include file='balance/oper.CASHIN.tpl'}

	{elseif $oper == 'CASHOUT'}

		{include file='balance/oper.CASHOUT.tpl'}

	{elseif $oper == 'EX'}

		{include file='balance/oper.EX.tpl'}

	{elseif $oper == 'TR'}

		{include file='balance/oper.TR.tpl'}

	{/if}

{/if}

{include file='footer.tpl'}
{*/strip*}