{strip}
{include file='header.tpl' title=$_TRANS['Confirmation'] class="cabinet"}

<h1>{$_TRANS['Operation confirmation']}</h1>

{if isset($smarty.get.done)}

	<h2>{$_TRANS['Operation complete']}!</h2>

{else}

	{if isset($smarty.get.need_confirm_sms)}

		<h2>{$_TRANS['Operation NOT complete!']}</h2>
		<p class="info">
			{$_TRANS['To complete the operation, you must input confirmation code<br>that was sent to your phone']|html_entity_decode}
		</p>

	{/if}

	<div class="block_form">
		{if $tpl_errors['confirm_frm']|count}
			<ul class="error_message">
		    	{$_TRANS['Please fix the following errors']}:<br/>
		        {if $tpl_errors['confirm_frm'][0]=='code_empty'}<li>{$_TRANS['Input code']}</li>{/if}
		        {if $tpl_errors['confirm_frm'][0]=='code_not_found'}<li>{$_TRANS['Wrong code']}</li>{/if}
		        {if $tpl_errors['confirm_frm'][0]=='code_used'}<li>{$_TRANS['Code is already outdated']}</li>{/if}
		        {if $tpl_errors['confirm_frm'][0]=='code_expired'}<li>{$_TRANS['Code has expired']}</li>{/if}
		        {if $tpl_errors['confirm_frm'][0]=='dif_ip'}<li>{$_TRANS['Confirmation from your IP-address can not be done']}</li>{/if}
		        {if $tpl_errors['confirm_frm'][0]=='oper_wrong'}<li>{$_TRANS['Wrong operation']}</li>{/if}
		        {if $tpl_errors['confirm_frm'][0]=='oper_unkn'}<li>{$_TRANS['Operation is not implemented']}</li>{/if}
		    </ul>
		{/if}

		<form method="post" action="{_link module='confirm'}" name="confirm_frm">
			<div class="block_form_el cfix">
		        <label for="login_frm_Code">{$_TRANS['Confirmation code']} <span class="descr_star">*</span></label>
		        <div class="block_form_el_right">
		            <input name="Code" id="login_frm_Code" value="{$smarty.get.code}" type="text">
		        </div>
		    </div>

	        {_getFormSecurity form='confirm_frm' captcha=$_cfg.Confirm_Captcha}
	        {if $__Capt}
	        	{include file='captcha.tpl' form='confirm_frm' star=$edit_descr_star}
	        {/if}

	        <div class="block_form_el cfix">
	        	<label for="login_frm_Pass">&nbsp;</label>
	        	<div class="block_form_el_right">
	        		<input name="confirm_frm_btn" value="{$_TRANS['Execute']}" type="submit" class="button-green">
	            </div>
	        </div>
		</form>
	</div>

	{*include file='edit.tpl'
		url="{_link module='confirm'}"
		fields=
		[
			'Code'=>
				[
					'T',
					'Confirmation code!!',
					[
						'code_empty'=>'input code',
						'code_not_found'=>'wrong code',
						'code_used'=>'code is already outdated',
						'code_expired'=>'code has expired',
						'dif_ip'=>'confirmation from your IP-address can not be done',
						'oper_wrong'=>'wrong operation',
						'oper_unkn'=>'operation is not implemented'
					],
					'size'=>40,
					'default'=>$smarty.get.code
				]
		]
		captcha=$_cfg.Confirm_Captcha
		btn_text='Execute'
	*}

{/if}

{include file='footer.tpl' class="cabinet"}
{/strip}