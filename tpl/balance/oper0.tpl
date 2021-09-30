{strip}
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

		<h1>{$_TRANS['Add funds']}</h1>

        <script>
          var currency_rates_data = new Array();
          {if $currency_rates_data ne ""}
             {foreach from=$currency_rates_data key=key item=item }
                currency_rates_data['{$key}']={$item};
             {/foreach}
          {/if}

          var currency_list_ids_names= new Array();

          {foreach from=$currency_list_data item=item}
            currency_list_ids_names[{$item.cID}]='{$item.cCurr}';
          {/foreach}

          $(document).ready(function(){

                      {if $smarty.request.Sum gt 0}
                         var summ=parseFloat($("#add_Sum").val());
                         var paysys=$("#add_PSys").val();
                         var account_currency=$("#account_currency").val();

                         if (summ>0 && paysys >0 && account_currency !='')
                         {
                            var paysys_currency=currency_list_ids_names[paysys];

                             if (account_currency != paysys_currency)
                             {
                                summ=Number(Number((summ/parseFloat(currency_rates_data[paysys_currency])).toFixed(2))*parseFloat(currency_rates_data[account_currency])).toFixed(2);
                             }

                            if (summ>0)
                            {
                               $("#sum2").html('<b>'+summ+' '+account_currency+'</b>');
                            }
                            else
                            {
                               $("#sum2").html('-');
                            }
                         }
                         else
                         {
                            $("#sum2").html('-');
                         }
                      {/if}

                      $("#add_Sum").keyup(function () {
                     	 var summ=parseFloat($("#add_Sum").val());
                         var paysys=$("#add_PSys").val();
                         var account_currency=$("#account_currency").val();

                         if (summ>0 && paysys >0 && account_currency !='')
                         {
                            var paysys_currency=currency_list_ids_names[paysys];

                             if (account_currency != paysys_currency)
                             {
                                summ=Number(Number((summ/parseFloat(currency_rates_data[paysys_currency])).toFixed(2))*parseFloat(currency_rates_data[account_currency])).toFixed(2);
                             }

                            if (summ>0)
                            {
                               $("#sum2").html('<b>'+summ+' '+account_currency+'</b>');
                            }
                            else
                            {
                               $("#sum2").html('-');
                            }
                         }
                         else
                         {
                            $("#sum2").html('-');
                         }
                      });

                      $("#add_Sum").keypress(function () {
                         $("#add_Sum").keyup();
                      });
                      $("#account_currency").change(function () {
                           $("#add_Sum").keyup();
                      });
                      $("#add_PSys").change(function () {
                          var paysys=$("#add_PSys").val();
                         $("#ccurr").html('<small>' +currency_list_ids_names[paysys]+ '</small>');
                         $("#add_Sum").keyup();
                      });
           });
       </script>

		{if $_cfg.Depo_AutoDepo}
			{include file='depo/_depo.interval.tpl'}
		{/if}

    <div class="block_form">
      {if $tpl_errors|count}
              <ul class="error_message">
                {$_TRANS['Please fix the following errors']}:<br/>
                  {if $tpl_errors['add'][0]=='psys_empty'}<li>{$_TRANS['Select pay.system']}</li>{/if}
                  {if $tpl_errors['add'][0]=='sum_wrong'}<li>{$_TRANS['Wrong amount']}</li>{/if}
                  {if $tpl_errors['add'][0]=='limit_exceeded'}<li>{$_TRANS['Limit exceeded']}</li>{/if}
                  {if $tpl_errors['add'][0]=='pin_wrong'}<li>{$_TRANS['Wrong code']}</li>{/if}
                  {if $tpl_errors['add'][0]=='plan_wrong'}<li>{$_TRANS['Wrong plan']}</li>{/if}
                  {if $tpl_errors['add'][0]=='compnd_wrong'}<li>{$_TRANS['Wrong value']} ({$cmin}..{$cmax})</li>{/if}
                  {if $tpl_errors['add'][0]=='compnd_wrong1'}<li>{$_TRANS['Wrong value for plan']} '{$cplan}'</li>{/if}
                  {if $tpl_errors['add'][0]=='oper_disabled'}<li>{$_TRANS['Operation disabled']}</li>{/if}
              </ul>
          {/if}

          <form method="post" name="add">
            <input name="Oper" id="add_Oper" value="CASHIN" type="hidden">

            <div class="block_form_el cfix">
          <label for="">{$_TRANS['From payment system']}<span class="descr_star">*</span></label>
          <div class="block_form_el_right">
            <select name="PSys" id="add_PSys">
              <option value="0">- {$_TRANS['select']} -</option>
              {foreach from=$clist item=i key=k}
                <option value="{$k}" {if ($user.aDefCurr)==$k}selected="selected"{/if}>{$i}</option>
              {/foreach}
            </select>
          </div>
        </div>

        <div class="block_form_el cfix">
          <label for="">{$_TRANS['Currency account']}<span class="descr_star">*</span></label>
          <div class="block_form_el_right">
            <select class="select" name="currency" id="account_currency">
              <option selected="" value="0">- выберите -</option>
              {section name=i loop=$currs_rates_list}
                  <option value="{$currs_rates_list[i]}" {if $currency eq $currs_rates_list[i]}selected{/if}>{$currs_rates_list[i]}</option>
              {/section}
            </select>
          </div>
        </div>

        <div class="block_form_el cfix">
          <label for="">{$_TRANS['Amount']}<span class="descr_star">*</span></label>
          <div class="block_form_el_right">
            <input name="Sum" id="add_Sum" value="{$smarty.request.Sum}" type="text">
          </div>
        </div>
        <div class="block_form_el cfix">
          <label for="">{$_TRANS['Comission']}</label>
          <div class="block_form_el_right">
            <span id="csum">-</span>
          </div>
        </div>
        <div class="block_form_el cfix">
          <label for="">{$_TRANS['Your balance will be credited to the amount']}</label>
          <div class="block_form_el_right">
            <span id="sum2">-</span>
          </div>
        </div>
        {if (count($plans) > 1)}
          <div class="block_form_el cfix">
            <label for="">{$_TRANS['Plan']}</label>
            <div class="block_form_el_right">
              <select name="Plan" id="add_Plan">
                <option value="0">- {$_TRANS['auto']} -</option>
                {foreach from=$plans item=i key=k}
                  <option value="{$k}">{$i}</option>
                      {/foreach}
              </select>
            </div>
          </div>
        {/if}
        {if ($pcmax)}
          <div class="block_form_el cfix">
            <label for="">{$_TRANS['Compaund']}</label>
            <div class="block_form_el_right">
              <input name="Compnd" id="add_Compnd" value="" type="text">
            </div>
          </div>
        {/if}

        {_getFormSecurity form='add'}
            <input name="add_btn" value="{$_TRANS['Create']}" type="submit" class="button-green">
      </form>
    </div>

		{*include file='edit.tpl'
			form='add'
			fields=[
				'Oper'=>$oper,
				'PSys'=>['S', 'С платежной системы!!', ['psys_empty'=>'плат.система не указана'], valueIf(count((array)$clist) > 1, [0=>'- выберите -'], []) + (array)$clist, 'default'=>$user.aDefCurr],
				'Sum'=>['$', 'Сумма!!', ['sum_wrong'=>'неверная сумма'], 'comment'=>' <i><span id="ccurr"></span></i>'],
				'Comis'=>['X', 'Комиссия', 'comment'=>' <i><span id="csum"></span></i>'],
				'Sum2'=>['X', 'Ваш баланс будет пополнен на сумму', 'comment'=>' <i><span id="sum2"></span></i>'],
				'Plan'=>['S', 'План', ['plan_wrong'=>'неверный план'], [0=>'- авто -'] + (array)$plans, 'skip'=>(count($plans) <= 1)],
				'Compnd'=>['%',	'Процент реинвеста <<капитализация>>', ['compnd_wrong'=>"неверное значение [$cmin..$cmax]", 'compnd_wrong1'=>"неверное значение для плана '$cplan'"], 'skip'=>!$pcmax]
			]
			errors=[
				'oper_disabled'=>'операция отключена'
			]
		*}

	{elseif $oper == 'CASHOUT'}

		<h1>{$_TRANS['Withdraw']}</h1>
		{$s = valueIf($_cfg.Const_IntCurr, $_TRANS['Amount (in internal units)'], $_TRANS['Amount'])}

        <script>
          var currency_rates_data = new Array();
          {if $currency_rates_data ne ""}
             {foreach from=$currency_rates_data key=key item=item }
                currency_rates_data['{$key}']={$item};
             {/foreach}
          {/if}

          var currency_balance = new Array();
          {section name=i loop=$currs}
              currency_balance['{$currs[i].currency_account}']={$currs[i].wBal};
          {/section}

          {if $_cfg.Bal_PayOutType eq 0 || $_cfg.Bal_PayOutType eq 3}
                var currency_list_ids_names= new Array();
                var currency_list_ids = new Array();
                var currency_list_names = new Array();

                {foreach from=$currency_list_data item=item}
                   currency_list_ids_names[{$item.cID}]='{$item.cCurr}';
                {/foreach}

                 $(document).ready(function(){

                      {if $smarty.request.Sum gt 0}
                         var summ=parseFloat($("#output_Sum").val());
                         var paysys=$("#payment_currency").val();
                         var account_currency=$("#account_currency").val();

                         if (summ>0 && paysys >0 && account_currency !='')
                         {
                            var paysys_currency=currency_list_ids_names[paysys];

                             if (account_currency != paysys_currency)
                             {
                                summ=Number(Number((summ/parseFloat(currency_rates_data[account_currency])).toFixed(2))*parseFloat(currency_rates_data[paysys_currency])).toFixed(2);
                             }

                            $("#sum2").html(summ+' '+paysys_currency);
                         }
                         else
                         {
                            $("#sum2").html('-');
                         }
                      {/if}

                      $("#output_Sum").keyup(function () {
                     	 var summ=parseFloat($("#output_Sum").val());
                         var paysys=$("#payment_currency").val();
                         var account_currency=$("#account_currency").val();

                         if (summ>0 && paysys >0 && account_currency !='')
                         {
                            var paysys_currency=currency_list_ids_names[paysys];

                             if (account_currency != paysys_currency)
                             {
                                summ=Number(Number((summ/parseFloat(currency_rates_data[account_currency])).toFixed(2))*parseFloat(currency_rates_data[paysys_currency])).toFixed(2);
                             }

                            $("#sum2").html(summ+' '+paysys_currency);
                         }
                         else
                         {
                            $("#sum2").html('-');
                         }
                      });
                      $("#output_Sum").keypress(function () {
                         $("#output_Sum").keyup();
                      });
                      $("#account_currency").change(function () {
                           var account_currency=$("#account_currency").val();

                           if (account_currency == 'BTC')
                           {
                              var options = $('#payment_currency option');

                              var values = $.map(options ,function(option) {
                                 if (option.value != 6)
                                 {
                                   $("#payment_currency option[value=" + option.value + "]").hide();
                                 }
                              });
                           }
                           else
                           {
                              var options = $('#payment_currency option');

                              var values = $.map(options ,function(option) {
                                   $("#payment_currency option[value=" + option.value + "]").show();
                              });
                           }

                           $("#output_Sum").keyup();
                      });
                      $("#payment_currency").change(function () {
                         $("#output_Sum").keyup();
                      });

                 });
             {elseif $_cfg.Bal_PayOutType eq 1 || $_cfg.Bal_PayOutType eq 2 || $_cfg.Bal_PayOutType eq 4}
                var currency_list_ids = new Array();
                var currency_list_names = new Array();
                var currency_list_paysys_currs = new Array();
                var currency_list_coefs = new Array();
                var currency_list_index = new Array();

                {foreach from=$operations_currs_data key=key item=item}
                   currency_list_ids['{$key}']=new Array();
                   currency_list_names['{$key}'] = new Array();
                   currency_list_paysys_currs['{$key}'] = new Array();
                   currency_list_coefs['{$key}'] = new Array();
                   currency_list_index['{$key}'] = new Array();

                   {section name=i loop=$item}
                      currency_list_ids['{$key}'][{$smarty.section.i.index}]='{$item[i].id}';
                      currency_list_names['{$key}'][{$smarty.section.i.index}]='{$item[i].name}';
                      currency_list_paysys_currs['{$key}'][{$smarty.section.i.index}]='{$item[i].paysys_curr}';
                      currency_list_coefs['{$key}'][{$smarty.section.i.index}]='{$item[i].coef}';
                      currency_list_index['{$key}']['{$item[i].id}']={$smarty.section.i.index};
                   {/section}
                {/foreach}

                {if $_cfg.Bal_PayOutType eq 1}
                   {literal}
                    $(document).ready(function(){
                      $("#account_currency").change(function () {
                           var account_currency=$("#account_currency").val();

                           $("#payment_currency").children().remove();
		   	               $("#payment_currency").append('<option value="0">- выберите -</option>');

                           if (currency_list_ids[account_currency] != null && currency_list_names[account_currency] != null)
                           {
			                   for (var i=0; i<currency_list_ids[account_currency].length; i++)
				               {
				                 $("#payment_currency").append('<option value="' + currency_list_ids[account_currency][i] +'">' + currency_list_names[account_currency][i] +'</option>');
			 	                }
		  	               }

                           $("#output_Sum").keypress();
                      });
                   });
                  {/literal}

                  {elseif $_cfg.Bal_PayOutType eq 2 || $_cfg.Bal_PayOutType eq 4}
                    $(document).ready(function(){

                      $("#account_currency").change(function () {
                           var account_currency=$("#account_currency").val();

                           $("#payment_currency").children().remove();
		   	               $("#payment_currency").append('<option value="0">- выберите -</option>');

                           if (currency_list_ids[account_currency] != null && currency_list_names[account_currency] != null)
                           {
			                   for (var i=0; i<currency_list_ids[account_currency].length; i++)
				               {
				                 $("#payment_currency").append('<option value="' + currency_list_ids[account_currency][i] +'">' + currency_list_names[account_currency][i] +' (максимум '+Number((currency_list_coefs[account_currency][i]*currency_balance[account_currency]).toFixed(2))+')</option>');
			 	                }
		  	               }

                           $("#output_Sum").keypress();
                      });
                   });
                {/if}

                $(document).ready(function(){

                      {if $smarty.request.account_currency ne ""}
                        $("#account_currency").change();
                        {if $smarty.request.PSys gt 0}
                          $("#payment_currency").val({$smarty.request.PSys});
                        {/if}
                      {/if}

                      {if $smarty.request.Sum gt 0}
                         var summ=parseFloat($("#output_Sum").val());
                         var paysys=$("#payment_currency").val();
                         var account_currency=$("#account_currency").val();

                         if (summ>0 && paysys >0 && account_currency !='')
                         {
                            var paysys_index=currency_list_index[account_currency][paysys];
                            var paysys_currency=currency_list_paysys_currs[account_currency][paysys_index];

                            if (account_currency != paysys_currency)
                            {
                              summ=Number(Number((summ/parseFloat(currency_rates_data[account_currency])).toFixed(2))*parseFloat(currency_rates_data[paysys_currency])).toFixed(2);
                            }

                            $("#sum2").html(summ+' '+paysys_currency);
                         }
                         else
                         {
                            $("#sum2").html('-');
                         }
                      {/if}

                      $("#output_Sum").keyup(function () {
                     	 var summ=parseFloat($("#output_Sum").val());
                         var paysys=$("#payment_currency").val();
                         var account_currency=$("#account_currency").val();

                         if (summ>0 && paysys >0 && account_currency !='')
                         {
                            var paysys_index=currency_list_index[account_currency][paysys];
                            var paysys_currency=currency_list_paysys_currs[account_currency][paysys_index];

                            if (account_currency != paysys_currency)
                            {
                              summ=Number(Number((summ/parseFloat(currency_rates_data[account_currency])).toFixed(2))*parseFloat(currency_rates_data[paysys_currency])).toFixed(2);
                            }

                            $("#sum2").html(summ+' '+paysys_currency);
                         }
                         else
                         {
                            $("#sum2").html('-');
                         }
                      });

                      $("#output_Sum").keypress(function () {
                         $("#output_Sum").keyup();
                      });
                      $("#account_currency").change(function () {

                           var account_currency=$("#account_currency").val();

                           if (account_currency == 'BTC')
                           {
                              var options = $('#payment_currency option');

                              var values = $.map(options ,function(option) {
                                 if (option.value != 6)
                                 {
                                   $("#payment_currency option[value=" + option.value + "]").hide();
                                 }
                              });
                           }
                           else
                           {
                              var options = $('#payment_currency option');

                              var values = $.map(options ,function(option) {
                                   $("#payment_currency option[value=" + option.value + "]").show();
                              });
                           }

                           $("#output_Sum").keyup();
                      });
                      $("#payment_currency").change(function () {
                         $("#output_Sum").keyup();
                      });
                 });
          {/if}
        </script>

        <div class="block_form">
        {if $tpl_errors|count}
                <ul class="error_message">
                  {$_TRANS['Please fix the following errors']}:<br/>
                    {if $tpl_errors['add'][0]=='psys_empty'}<li>{$_TRANS['Pay.system wrong']}</li>{/if}
                    {if $tpl_errors['add'][0]=='sum_wrong'}<li>{$_TRANS['Calculator']}</li>{/if}
                    {if $tpl_errors['add'][0]=='limit_exceeded'}<li>{$_TRANS['Limit exceeded']}</li>{/if}
                    {if $tpl_errors['add'][0]=='pin_wrong'}<li>{$_TRANS['Wrong code']}</li>{/if}
                    {if $tpl_errors['add'][0]=='low_bal1'}<li>{$_TRANS['Insufficient funds']}</li>{/if}
                    {if $tpl_errors['add'][0]=='oper_disabled'}<li>{$_TRANS['Operation disabled']}</li>{/if}   
                    {if $tpl_errors['add'][0]=='sum_max'}<li>{$_TRANS['sum_max']}</li>{/if}
                    {if $tpl_errors['add'][0]=='sum_min'}<li>{$_TRANS['sum_min']}</li>{/if}      
          </ul>
            {/if}
            <br/>

        <form method="post" name="add">
          <input name="Oper" id="add_Oper" value="CASHOUT" type="hidden">
          <div class="block_form_el cfix">
            <label for="">{$_TRANS['Currency account']} <span>*</span></label>
            <div class="block_form_el_right">
                            <select class="select" id="account_currency" name="account_currency">
                              <option selected="" value="0">{$_TRANS['- select -']}</option>
                              {section name=i loop=$currs}
                                {if $currs[i].wBal gt 0}
                                  <option value="{$currs[i].currency_account}" {if $smarty.request.account_currency eq $currs[i].currency_account}selected{/if}>{$currs[i].currency_account} ({$currs[i].wBal})</option>
                                {/if}
                              {/section}
                           </select>
            </div>
          </div>
          {if $_cfg.Bal_PayOutType eq 0 || $_cfg.Bal_PayOutType eq 3}
            <div class="block_form_el cfix">
              <label for="">{$_TRANS['On payment system']} <span>*</span></label>
              <div class="block_form_el_right">
                            <select class="select" id="payment_currency" name="PSys">
                              <option selected="" value="0">{$_TRANS['- select -']}</option>
                              {foreach from=$currency_list_data item=item}
                               {if $item.cID gt 0 && ($_cfg.Bal_PayOutType eq 3 && $item.cTAKEMode eq 1 || $_cfg.Bal_PayOutType eq 0)}
                                   <option value="{$item.cID}" {if $smarty.request.PSys eq $item.cID}selected{/if}>{$item.cName} ({$item.cCurr})</option>
                               {/if}
                              {/foreach}
                              </select>
              </div>
            </div>
          {elseif $_cfg.Bal_PayOutType eq 1 || $_cfg.Bal_PayOutType eq 2 || $_cfg.Bal_PayOutType eq 4}
            <div class="block_form_el cfix">
              <label for="">{$_TRANS['On payment system']} <span>*</span></label>
              <div class="block_form_el_right">
                              <select class="select" id="payment_currency" name="PSys">
                              <option selected="" value="0">{$_TRANS['- select -']}</option>
                              </select>
              </div>
            </div>
          {/if}

          <div class="block_form_el cfix">
            <label for="">{$_TRANS['Amount']}</label>
            <div class="block_form_el_right">
              <input type="text" class="float" size="10" value="{$smarty.request.Sum}" id="output_Sum" name="Sum">
            </div>
          </div>
          <div class="block_form_el cfix">
            <label for="">{$_TRANS['Your account will be injected amount']}</label>
            <div class="block_form_el_right">
              <span class="value"></span> <i><span id="sum2">-</span></i>
            </div>
          </div>

          {_getFormSecurity form='add'}
          <input name="add_btn" value="{$_TRANS['Create']}" type="submit" class="button-green">
        </form>
      </div>

        {*include file='edit_begin.tpl'
			form='add'
			fields=[

			]
			errors=[
				'low_bal1'=>'недостаточно средств',
				'oper_disabled'=>'операция отключена'
			]
		}
            <fieldset>
            <table class="formatTable">
               <input type="hidden" value="CASHOUT" id="add_Oper" name="Oper">
               <tbody>
                  <tr>
                    <td width="50%" align="right">Валюта счета</td>
                    <td align="left">
                          <select class="select" id="account_currency" name="account_currency">
                              <option selected="" value="0">- выберите -</option>
                              {section name=i loop=$currs}
                                {if $currs[i].wBal gt 0}
                                  <option value="{$currs[i].currency_account}" {if $smarty.request.account_currency eq $currs[i].currency_account}selected{/if}>{$currs[i].currency_account} ({$currs[i].wBal})</option>
                                {/if}
                              {/section}
                           </select>
                    </td>
                  </tr>
                  {if $_cfg.Bal_PayOutType eq 0 || $_cfg.Bal_PayOutType eq 3}
                     <tr>
                         <td width="50%" align="right">
                           <label><span class="descr_req">На платежную систему<span class="descr_star">*</span></span></label>
                         </td>
                          <td align="left">
                             <select class="select" id="payment_currency" name="PSys">
                              <option selected="" value="0">- выберите -</option>
                              {foreach from=$currency_list_data item=item}
                               {if $item.cID gt 0 && ($_cfg.Bal_PayOutType eq 3 && $item.cTAKEMode eq 1 || $_cfg.Bal_PayOutType eq 0)}
                                   <option value="{$item.cID}" {if $smarty.request.PSys eq $item.cID}selected{/if}>{$item.cName} ({$item.cCurr})</option>
                               {/if}
                              {/foreach}
                              </select>
                         </td>
                      </tr>
                    {elseif $_cfg.Bal_PayOutType eq 1 || $_cfg.Bal_PayOutType eq 2 || $_cfg.Bal_PayOutType eq 4}
                     <tr>
                         <td width="50%" align="right">
                           <label><span class="descr_req">На платежную систему<span class="descr_star">*</span></span></label>
                         </td>
                          <td align="left">
                             <select class="select" id="payment_currency" name="PSys">
                              <option selected="" value="0">- выберите -</option>
                              </select>
                         </td>
                      </tr>
                  {/if}
                   <tr>
                      <td width="50%" align="right">
                          <label for="add_Sum">
                             <span class="descr_req">Сумма<span class="descr_star">*</span></span>
                          </label>
                      </td>
                      <td align="left">
                          <input type="text" class="float" size="10" value="{$smarty.request.Sum}" id="output_Sum" name="Sum">
                      </td>
                   </tr>
                   <tr>
                       <td width="50%" align="right">На Ваш счет будет выведена сумма</td>
                       <td align="left">
                           <span class="value"></span> <i><span id="sum2">-</span></i>
                       </td>
                   </tr>
                   </tbody>
                   </table>
                   </fieldset>
       {include file='edit_end.tpl'
			form='add'
			fields=[

			]
			errors=[
				'low_bal1'=>'недостаточно средств',
				'oper_disabled'=>'операция отключена'
			]
		*}

	{elseif $oper == 'EX'}

     <script>
          var currency_rates_data = new Array();
          {if $currency_rates_data ne ""}
             {foreach from=$currency_rates_data key=key item=item }
                currency_rates_data['{$key}']={$item};
             {/foreach}
          {/if}

          $(document).ready(function(){

                      $("#add_Sum").keyup(function () {
                           var currency1=$("#add_PSys").val();
                           var currency2=$("#add_PSys2").val();
                           var summ=parseFloat($("#add_Sum").val());

                           if (summ>0 && currency1 != '' && currency2 != '' && currency1 != '0' && currency2 != '0')
                           {

                             if (currency1 != currency2)
                             {
                                summ=Number(Number((summ/parseFloat(currency_rates_data[currency1])).toFixed(2))*parseFloat(currency_rates_data[currency2])).toFixed(2);
                             }

                             $("#sum2").html(summ+' '+currency2);
                           }
                           else
                           {
                              $("#sum2").html('-');
                           }
                      });

                      $("#add_PSys").keypress(function () {
                         $("#add_Sum").keyup();
                      });
                      $("#add_PSys2").change(function () {
                           $("#add_Sum").keyup();
                      });
                      $("#add_Sum").change(function () {
                         $("#add_Sum").keyup();
                      });
           });
       </script>


		<h1>Обмен валют</h1>
		{include file='edit.tpl'
			form='add'
			fields=[
				'Oper'=>$oper,
				'PSys'=>['S', 'Со счета!!', ['psys_empty'=>'плат.система не указана'], valueIf(count((array)$clist) > 1, [0=>'- выберите -'], []) + (array)$clist],
				'Sum'=>['$', 'Сумма!!', ['sum_wrong'=>'неверная сумма'], 'comment'=>' <i><span id="ccurr"></span></i>'],
				'Comis'=>['X', 'Комиссия', 'comment'=>' <i><span id="csum"></span></i>'],
				'PSys2'=>['S', 'На счет!!', ['psys2_empty'=>'плат.система не указана', 'psys2_equal_psys'=>'плат.системы должны различаться', 'ex_rate_not_set'=>'Курс валюты не задан'], valueIf(count((array)$clist2) > 1, [0=>'- выберите -'], []) + (array)$clist2],
				'Sum2'=>['X', 'Сумма к получению', 'comment'=>' <i><span id="sum2"></span></i>']
			]
			errors=[
				'low_bal1'=>'недостаточно средств',
				'oper_disabled'=>'операция отключена'
			]
		}

	{elseif $oper == 'TR'}

        <script>
          var currency_rates_data = new Array();
          {if $currency_rates_data ne ""}
             {foreach from=$currency_rates_data key=key item=item }
                currency_rates_data['{$key}']={$item};
             {/foreach}
          {/if}

          $(document).ready(function(){

                      $("#add_Sum").keyup(function () {
                           var currency1=$("#add_PSys").val();
                           var summ=parseFloat($("#add_Sum").val());

                           if (summ>0 && currency1 != '0' && currency1 != '')
                           {
                             $("#sum2").html(summ+' '+currency1);
                           }
                           else
                           {
                              $("#sum2").html('-');
                           }
                      });

                      $("#add_PSys").keypress(function () {
                         $("#add_Sum").keyup();
                      });
                      $("#add_Sum").change(function () {
                         $("#add_Sum").keyup();
                      });
           });
        </script>

		<h1>{$_TRANS['Transfer']}</h1>

    <div class="block_form">
      {if $tpl_errors|count}
              <ul class="error_message">
                {$_TRANS['Please fix the following errors']}:<br/>
                  {if $tpl_errors['add'][0]=='psys_empty'}<li>{$_TRANS['Pay.system wrong']}</li>{/if}
                  {if $tpl_errors['add'][0]=='sum_wrong'}<li>{$_TRANS['Wrong amount']}</li>{/if}
                  {if $tpl_errors['add'][0]=='user2_empty'}<li>{$_TRANS['User not found']}</li>{/if}
                  {if $tpl_errors['add'][0]=='user2_equal_user'}<li>{$_TRANS['Users must be different']}</li>{/if}
                  {if $tpl_errors['add'][0]=='low_bal1'}<li>{$_TRANS['Insufficient funds']}</li>{/if}
                  {if $tpl_errors['add'][0]=='oper_disabled'}<li>{$_TRANS['Operation disabled']}</li>{/if}

        </ul>
          {/if}
          <br/>

          <form method="post" name="add">
            <input name="Oper" id="add_Oper" value="TR" type="hidden">
            {if $_cfg.Const_IntCurr}
          <input name="PSys" id="add_PSys" value="{$_cfg.Const_IntCurr}" type="hidden">
        {else}
          <div class="block_form_el cfix">
            <label for="">{$_TRANS['Payment system']}</label>
            <div class="block_form_el_right">
              <select name="PSys" id="add_PSys">
                <option value="0">- {$_TRANS['select']} -</option>
                {foreach from=$clist item=i key=k}
                  <option value="{$k}" {if ($user.aDefCurr)==$k}selected="selected"{/if}>{$i}</option>
                      {/foreach}
              </select>
            </div>
          </div>
        {/if}
        <div class="block_form_el cfix">
          <label for="">{$_TRANS['Amount']}</label>
          <div class="block_form_el_right">
            <input name="Sum" id="add_Sum" value="{$smarty.request.Sum}" type="text">
          </div>
        </div>
        <div class="block_form_el cfix">
          <label for="">{$_TRANS['Comission']}</label>
          <div class="block_form_el_right">
            <span id="csum">-</span>
          </div>
        </div>
        <div class="block_form_el cfix">
          <label for="">{$_TRANS['The recipient will be transfered']}</label>
          <div class="block_form_el_right">
            <span id="sum2">-</span>
          </div>
        </div>
        <div class="block_form_el cfix">
          <label for="">{$_TRANS['Recipient']}</label>
          <div class="block_form_el_right">
            <input name="Login2" id="add_Login2" value="{$smarty.request.Login2}" size="20" type="text" class="string_small">
          </div>
        </div>
        <div class="block_form_el cfix">
          <label for="">{$_TRANS['Memo']}</label>
          <div class="block_form_el_right">
            <textarea name="Memo" id="add_Memo" cols="60" rows="4" wrap="off" class="text">{$smarty.request.Memo}</textarea>
          </div>
        </div>

        {_getFormSecurity form='add'}
        <input name="add_btn" value="{$_TRANS['Create']}" type="submit" class="button-green">
          </form>
      </div>

		{*include file='edit.tpl'
			form='add'
			fields=[
				'Oper'=>$oper,
                'PSys'=>['S', 'Со счета!!', ['psys_empty'=>'плат.система не указана'], valueIf(count((array)$clist) > 1, [0=>'- выберите -'], []) + (array)$clist],
				'Sum'=>['$', 'Сумма!!', ['sum_wrong'=>'неверная сумма'], 'comment'=>' <i><span id="ccurr"></span></i>'],
				'Comis'=>['X', 'Комиссия', 'comment'=>' <i><span id="csum"></span></i>'],
				'Sum2'=>['X', 'Получателю будет переведена сумма', 'comment'=>' <i><span id="sum2"></span></i>'],
				'Login2'=>['T', 'Получатель!!', ['user2_empty'=>'пользователь не найден', 'user2_equal_user'=>'пользователи должны различаться']],
				'Memo'=>['W', 'Примечание', 'size'=>4]
			]
			errors=[
				'low_bal1'=>'недостаточно средств',
				'oper_disabled'=>'операция отключена'
			]
		*}

	{/if}

	{include file='balance/_oper.js.tpl' oper=$oper use_sum2=true}

{/if}

{include file='footer.tpl'}
{/strip}