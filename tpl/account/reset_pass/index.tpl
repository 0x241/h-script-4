{strip}
{include file='header.tpl' title=$_TRANS['Password reset'] class="cabinet"}

<h1>{$_TRANS['Password reset']}</h1>

{if isset($smarty.get.done)}

	<h2>{$_TRANS['Operation completed']}!</h2>
	<p class="info">
		{$_TRANS['Now You can']} <a href="{_link module='account/login'}">{$_TRANS['login']}</a> {$_TRANS['to your account, with <b>new</b> password']|html_entity_decode}.<br>
		{$_TRANS['After that it must be changed to another']}
	</p>

{elseif isset($smarty.get.need_confirm)}

	<h2>{$_TRANS['Operation NOT completed']}!</h2>
	<p class="info">
		{$_TRANS['To get a temporary password']} <a href="{_link module='confirm'}">{$_TRANS['input confirmation code']}</a><br>
		{$_TRANS['or click on the link that was sent to your e-mail']}.<br><br>
		{$_TRANS['If message is not coming, then try']} <a href="{_link module='account/change_mail'}">{$_TRANS['change e-mail']}</a>
	</p>

{elseif isset($squest)}

	{include file='sqa.tpl'}

{else}

	<div class="block_form">
		{if $tpl_errors['account/reset_pass_frm']|count}
			<ul class="error_message">
		    	{$_TRANS['Main']}Please fix the following errors:<br/>
		        {if $tpl_errors['account/reset_pass_frm'][0]=='login_empty'}<li>{$_TRANS['Input Login/Password']}</li>{/if}
		        {if $tpl_errors['account/reset_pass_frm'][0]=='login_not_found'}<li>{$_TRANS['Wrong Login/Password']}</li>{/if}
		        {if $tpl_errors['account/reset_pass_frm'][0]=='mail_not_found'}<li>{$_TRANS['E-Mail not found']}</li>{/if}
		        {if $tpl_errors['account/reset_pass_frm'][0]=='captcha_wrong'}<li>{$_TRANS['Wrong code']}</li>{/if}
		    </ul>
		{/if}

		<form method="post" name="account/reset_pass_frm" {if $url} action="{if $url == '*'}{$_selfLink}{else}{$url}{/if}"{/if}>

			<div class="block_form_el cfix">
				{$txt_login=valueIf($_cfg.Const_NoLogins, 'e-mail', {$_TRANS['Login']})}
		        <label for="login_frm_Login">{$txt_login} <span class="descr_star">*</span></label>
		        <div class="block_form_el_right">
		            <input name="Login" id="login_frm_Login" value="{$smarty.request.Login}" type="text">
		        </div>
		    </div>

			{if !$_cfg.Const_NoLogins}
		        <div class="block_form_el cfix">
		            <label for="login_frm_Mail">{$_TRANS['E-Mail']} <span class="descr_star">*</span></label>
		            <div class="block_form_el_right">
		            	<input name="Mail" id="login_frm_Mail" value="{$smarty.request.Mail}" type="text">
		            </div>
		        </div>
	        {/if}

	        {_getFormSecurity form='account/reset_pass_frm' captcha=$_cfg.Account_ResetPassCaptcha}
	        {if $__Capt}
	        	{include file='captcha.tpl' form='account/reset_pass_frm' star=$edit_descr_star}
	        {/if}

	        <div class="block_form_el cfix">
	        	<label for="login_frm_Pass">&nbsp;</label>
	        	<div class="block_form_el_right">
	        		<input name="account/reset_pass_frm_btn" value="{$_TRANS['Next']}" type="submit" class="button-green">
	            </div>
	        </div>
		</form>
	</div>

	{*$txt_login=valueIf($_cfg.Const_NoLogins, 'e-mail', 'Login')}
	{include file='edit.tpl'
		url='*'
		fields=
		[
			'Login'=>
				[
					'T',
					"$txt_login!!",
					[
						'login_empty'=>"input $txt_login",
						'login_not_found'=>'wrong Login/e-mail',
						'mail_not_found'=>'e-mail not found'
					]
				],
			'Mail'=>
				[
					'T',
					'e-mail!!',
					[
					],
					'skip'=>$_cfg.Const_NoLogins
				]
		]
		captcha=$_cfg.Account_ResetPassCaptcha
		btn_text='Next'
	*}

{/if}

{include file='footer.tpl' class="cabinet"}
{/strip}
