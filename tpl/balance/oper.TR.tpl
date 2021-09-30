		<h1>{$_TRANS['Transfer']}</h1>

        <div class="block_form">
        {if $tpl_errors|count}
{print_r($tpl_errors, 1)}
                <ul class="error_message">
                  {$_TRANS['Please fix the following errors']}:<br/>
                    {if $tpl_errors['add'][0]=='curr_wrong'}<li>{$_TRANS['Curr wrong']}</li>{/if}
                    {if $tpl_errors['add'][0]=='psys_empty'}<li>{$_TRANS['Pay.system wrong']}</li>{/if}
                    {if $tpl_errors['add'][0]=='sum_wrong'}<li>{$_TRANS['Wrong amount']}</li>{/if}
                    {if $tpl_errors['add'][0]=='user2_empty'}<li>{$_TRANS['Input receiver']}</li>{/if}
                    {if $tpl_errors['add'][0]=='user2_not_found'}<li>{$_TRANS['Wrong reciever']}</li>{/if}
                    {if $tpl_errors['add'][0]=='limit_exceeded'}<li>{$_TRANS['Limit exceeded']}</li>{/if}
                    {if $tpl_errors['add'][0]=='pin_wrong'}<li>{$_TRANS['Wrong code']}</li>{/if}
                    {if $tpl_errors['add'][0]=='low_bal1'}<li>{$_TRANS['Insufficient funds']}</li>{/if}
                    {if $tpl_errors['add'][0]=='oper_disabled'}<li>{$_TRANS['Operation disabled']}</li>{/if}   
                    {if $tpl_errors['add'][0]=='sum_max'}<li>{$_TRANS['sum_max']}</li>{/if}
                    {if $tpl_errors['add'][0]=='sum_min'}<li>{$_TRANS['sum_min']}</li>{/if}      
          </ul>
        {/if}

          <form method="post" name="add">
            <input name="Oper" id="add_Oper" value="TR" type="hidden">

        <div class="block_form_el cfix">
          <label for="">{$_TRANS['Recipient']}<span class="descr_star">*</span></label>
          <div class="block_form_el_right">
            <input name="Login2" id="add_Login2" value="{$smarty.request.Login2}" type="text">
          </div>
        </div>
		
        <div class="block_form_el cfix">
          <label for="">{$_TRANS['Memo']}</label>
          <div class="block_form_el_right">
            <input name="Memo" id="add_Memo" value="{$smarty.request.Memo}" type="text">
          </div>
        </div>
		
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
          <label for="">{$_TRANS['Can withdraw']}</label>
          <div class="block_form_el_right">
			<table class="styleTable" border="0" cellspacing="0" cellpadding="0">
              {foreach from=$clist item=i key=k}
				<tr>
					<td>{$i}</td>
					<td width="50px" align="right" id="av{$k}">-</td>
				</tr>
              {/foreach}
			</table>
		  </div>
        </div>

        <div class="block_form_el cfix">
          <label for="">{$_TRANS['Amount']}<span class="descr_star">*</span></label>
          <div class="block_form_el_right">
            <input name="Sum" id="add_Sum" value="{$smarty.request.Sum}" type="text">
          </div>
        </div>
		
        <div class="block_form_el cfix">
          <label for="">{$_TRANS['On payment system']}<span class="descr_star">*</span></label>
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
		for (var i=1;i<=100;i++)
		{
			$('#av'+i).html('-');
		}
		$.ajax(
			{
				type: 'POST',
				url: 'ajax',
				data: 'module=balance&do=getsum'+
					'&oper='+$('#add_Oper').val()+
					'&curr='+$('#add_Curr').val()+
					'&cid='+$('#add_PSys').val()+
					'&sum='+$('#add_Sum').val(),
				success: function(ex) {
						ex=eval(ex);
						$('#topay').html(ex[0]);
						$('#ccurr').html(ex[1]);
						$('#csum').html(ex[2]);
						$('#sum2').html(ex[3]);
						for (i in ex[4])
						{
							$('#av'+i).html(ex[4][i]);
						}
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
	$('#add_PSys').change(tf);
	$('#add_Sum').keypress(tf);
	showComis();
</script>
