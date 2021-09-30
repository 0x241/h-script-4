		<h1>{$_TRANS['Add funds']}</h1>

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
          <label for="">{$_TRANS['Currency account']}<span class="descr_star">*</span></label>
          <div class="block_form_el_right">
            <select class="select" name="Curr" id="add_Curr">
              <option selected="" value="0">- {$_TRANS['select']} -</option>
              {foreach $currs as $cid => $c}
                  <option value="{$cid}" {if $cid eq $smarty.post.Curr}selected{/if}>{$cid}</option>
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
          <label for="">{$_TRANS['To pay']}</label>
          <div class="block_form_el_right">
            <span id="topay">-</span>
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
		
        {if $plans}
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
		
        {if $pcmax}
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
					'&cid='+$('#add_PSys').val()+
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
	$('#add_PSys').change(tf);
	$('#add_Sum').keypress(tf);
	showComis();
</script>
