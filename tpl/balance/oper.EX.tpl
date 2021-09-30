		<h1>{$_TRANS['Exchange']}</h1>
		{$s = valueIf($_cfg.Const_IntCurr, $_TRANS['Amount (in internal units)'], $_TRANS['Amount'])}

        <div class="block_form">
        {if $tpl_errors|count}
{*print_r($tpl_errors, 1)*}
                <ul class="error_message">
                  {$_TRANS['Please fix the following errors']}:<br/>
                    {if $tpl_errors['add'][0]=='psys2_equal_psys'}<li>{$_TRANS['Currencies must be different']}</li>{/if}

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

          <form method="post" name="add">
            <input name="Oper" id="add_Oper" value="EX" type="hidden">

        <div class="block_form_el cfix">
          <label for="">{$_TRANS['Currency account']}<span class="descr_star">*</span></label>
          <div class="block_form_el_right">
            <select class="select" name="Curr" id="add_Curr">
              <option selected="" value="0">- {$_TRANS['select']} -</option>
              {foreach $currs as $cid => $c}
				{if $c.Bal > 0}
                  <option value="{$cid}" {if $cid eq $smarty.post.Curr}selected{/if}>{$cid}</option>
				{/if}
              {/foreach}
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
          <label for="">{$_TRANS['To currency account']}<span class="descr_star">*</span></label>
          <div class="block_form_el_right">
            <select class="select" name="Curr2" id="add_Curr2">
              <option selected="" value="0">- {$_TRANS['select']} -</option>
              {foreach $currs as $cid => $c}
                  <option value="{$cid}" {if $cid eq $smarty.post.Curr}selected{/if}>{$cid}</option>
              {/foreach}
            </select>
          </div>
        </div>

        <div class="block_form_el cfix">
          <label for="">{$_TRANS['Your account will be injected amount']}</label>
          <div class="block_form_el_right">
            <span id="sum2">-</span>
          </div>
        </div>
		
        <div class="block_form_el cfix">
          <label for="">{$_TRANS['Comission']}</label>
          <div class="block_form_el_right">
            <span id="csum">-</span>
          </div>
        </div>
		
        <div class="block_form_el cfix">
          <label for="">{$_TRANS['To withdraw']}</label>
          <div class="block_form_el_right">
            <span id="topay">-</span>
          </div>
        </div>
		
        {_getFormSecurity form='add'}
            <input name="add_btn" value="{$_TRANS['Create']}" type="submit" class="button-green">
      </form>
    </div>

<script>
	function showComis()
	{
		$('#topay').html('');
		$('#csum').html('');
		$('#sum2').html('');
		$.ajax(
			{
				type: 'POST',
				url: 'ajax',
				data: 'module=balance&do=getsum'+
					'&oper='+$('#add_Oper').val()+
					'&curr='+$('#add_Curr').val()+
					'&curr2='+$('#add_Curr2').val()+
					'&sum='+$('#add_Sum').val(),
				success: function(ex) {
						ex=eval(ex);
						$('#topay').html(ex[0]);
						$('#ccurr').html(ex[1]);
						$('#csum').html(ex[2]);
						$('#sum2').html(ex[3]);
					}
			}
		);
	}
	tid=0;
	tf=function()
	{
		clearTimeout(tid);
		tid=setTimeout(function(){ showComis(); }, 200);
	};
	$('#add_Curr').change(tf);
	$('#add_Curr2').change(tf);
	$('#add_Sum').keypress(tf);
	showComis();
</script>
