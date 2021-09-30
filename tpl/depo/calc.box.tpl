<script>
         var currency_rates_data = new Array();
          {if $currency_rates_data ne ""}
             {foreach from=$currency_rates_data key=key item=item }
                currency_rates_data['{$key}']={$item};
             {/foreach}
          {/if}
</script>


{strip}
	<div class="block_form">

        <form method="post" name="calc" onsubmit="recalc(); return false;">
        	<div class="block_form_el cfix">
				<label for="calc_sum">{$_TRANS['Amount']}</label>
				<div class="block_form_el_right">
					<input name="sum" id="calc_sum" type="text" value="{if $smarty.request.sum}{$smarty.request.sum}{else}10{/if}">
				</div>
			</div>

				<div class="block_form_el cfix">
					<label for="calc_currency_payment">{$_TRANS['Currency replenishment']}</label>
					<div class="block_form_el_right">
						<select name="currency_payment" id="calc_currency_payment">
					{foreach from=$currs item=i key=k}
						<option value="{$_cfg["Bal_Rate{$k}"]}">{$k}</option>
				    {/foreach}
						</select>
					</div>
				</div>

				<div class="block_form_el cfix">
					<label for="calc_plan">{$_TRANS['Plan']}</label>
					<div class="block_form_el_right">
						<select name="plan" id="calc_plan">
							<option value="-1">{$_TRANS['- auto -']}</option>
							{foreach from=$calc_pselect item=i key=k}
								<option value="{$k}">{$i}</option>
				            {/foreach}
						</select>
					</div>
				</div>

        	{if $calc_compnd}
				<div class="block_form_el cfix">
					<label for="calc_cmpd">{$_TRANS['Compaund']}</label>
					<div class="block_form_el_right">
						<select name="cmpd" id="calc_cmpd">
							{foreach from=$calc_compnd item=i key=k}
								<option value="{$k}">{$i}</option>
				            {/foreach}
						</select>
					</div>
				</div>
			{/if}
            
            <div class="block_form_el cfix" id="period_div" style="display:none;">
				<label for="calc_sum">Период</label>
				<div class="block_form_el_right">
					<input name="period" id="period_val" type="text" value="{if $smarty.request.period}{$smarty.request.period}{else}0{/if}">
				</div>
			</div>

			{_getFormSecurity form='calc'}
			<div class="block_form_el cfix">
	        	<label for="login_frm_Pass">&nbsp;</label>
	        	<div class="block_form_el_right">
	        		<input name="calc_btn" value="{$_TRANS['Calculate']}" type="submit" class="button-green">
	            </div>
	        </div>
        </form>
    </div>

{*include file='edit.tpl'
	form='calc'
	fields=[
		'sum'=>[
			'$',
			'Сумма пополнения',
			'default'=>10
		],

        'currency_payment'=>[
			'S',
			'Валюта пополнения',
			0,
			[0=>'- выберите -']+  $currs_rates_list_values,
			'skip'=>false
		],
		'plan'=>[
			'S',
			'План',
			-1,
			[-1=>'- выбор -']+ $calc_pselect,
			'skip'=>false
		],
		'cmpd'=>[
			'S',
			'Реинвестирование',
			0,
			$calc_compnd,
			'skip'=>!$calc_compnd
		]
	]
	on_submit='recalc(); return false;'
	btn_text='Расчет'
*}

{/strip}