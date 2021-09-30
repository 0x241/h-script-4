{strip}
{include file='header.tpl' title=$_TRANS['Change e-mail'] class="cabinet"}

<h1>{$_TRANS['Change e-mail']}</h1>

{if isset($smarty.get.done)}

	<h2>{$_TRANS['Е-mail changed!']}</h2>

{elseif isset($smarty.get.need_confirm)}

	<h2>{$_TRANS['Operation NOT complete!']}</h2>
	<p class="info">
		{$_TRANS['To complete the operation, you must confirm your e-mail']}.<br>
		{$_TRANS['Please']} <a href="{_link module='confirm'}">{$_TRANS['input confirmation code']}</a><br>
		{$_TRANS['or click on the link that was sent to your e-mail']}.<br><br>
		{$_TRANS['If message is not coming, then try']} <a href="{_link module='account/change_mail'}">{$_TRANS['change e-mail']}</a>
	</p>

{elseif isset($smarty.get.already_used)}

	<h2>{$_TRANS['The operation could not be completed!']}</h2>
	<p class="info">
		{$_TRANS['This e-mail can not be confirmed by you,<br>because it is already used by another user']|html_entity_decode}
	</p>

{elseif isset($squest)}

	{include file='sqa.tpl'}

{else}

	<div class="block_form">
		{if $tpl_errors['account/change_mail_frm']|count}
			<ul class="error_message">
		    	{$_TRANS['Please fix the following errors']}:<br/>
		        {if $tpl_errors['account/change_mail_frm'][0]=='login_empty'}<li>{$_TRANS['Input Login/Password']}</li>{/if}
		        {if $tpl_errors['account/change_mail_frm'][0]=='login_not_found'}<li>{$_TRANS['Wrong Login/Password']}</li>{/if}
		        {if $tpl_errors['account/change_mail_frm'][0]=='not_active'}<li>{$_TRANS['E-Mail is not confirmed']}</li>{/if}
		        {if $tpl_errors['account/change_mail_frm'][0]=='banned'}<li>{$_TRANS['Access to the account is suspended']} {$ban_date}</li>{/if}
				{if $tpl_errors['account/change_mail_frm'][0]=='pass_not_found'}<li>{$_TRANS['Wrong Password']}</li>{/if}
		        {if $tpl_errors['account/change_mail_frm'][0]=='mail_empty'}<li>{$_TRANS['Input e-mail']}</li>{/if}
		        {if $tpl_errors['account/change_mail_frm'][0]=='mail_wrong'}<li>{$_TRANS['Wrong e-mail']}</li>{/if}
		        {if $tpl_errors['account/change_mail_frm'][0]=='mail_used'}<li>{$_TRANS['E-Mail is already used']}</li>{/if}
		        {if $tpl_errors['account/change_mail_frm'][0]=='captcha_wrong'}<li>{$_TRANS['Wrong code']}</li>{/if}
		    </ul>
		{/if}

		<form method="post" name="account/change_mail_frm" {if $url} action="{if $url == '*'}{$_selfLink}{else}{$url}{/if}"{/if}>

			{if !_uid()}
				<div class="block_form_el cfix">
					{$txt_login=valueIf($_cfg.Const_NoLogins, 'e-mail', $_TRANS['Login'])}
		            <label for="login_frm_Login">{$txt_login} <span class="descr_star">*</span></label>
		            <div class="block_form_el_right">
		            	<input name="Login" id="login_frm_Login" value="{$smarty.request.Login}" type="text">
		            </div>
		        </div>
	        {/if}

	        <div class="block_form_el cfix">
	            <label for="login_frm_Pass">{$_TRANS['Password']} <span class="descr_star">*</span></label>
	            <div class="block_form_el_right">
	            	<input name="Pass" id="login_frm_Pass" value="" type="password">
	            </div>
	        </div>

	        <div class="block_form_el cfix">
	            <label for="login_frm_NewMail">{valueIf($_cfg.Account_ChangeMailConfirm, {$_TRANS['New e-mail (confirmation will be sent)']}, $_TRANS['New e-mail'])} <span class="descr_star">*</span></label>
	            <div class="block_form_el_right">
	            	<input name="NewMail" id="login_frm_NewMail" value="{$smarty.request.NewMail}" type="text">
	            </div>
	        </div>

	        {_getFormSecurity form='account/change_mail_frm' captcha=$_cfg.Account_ChangeMailCaptcha}
	        {if $__Capt}
	        	{include file='captcha.tpl' form='account/change_mail_frm' star=$edit_descr_star}
	        {/if}

	        <div class="block_form_el cfix">
	        	<label for="login_frm_Pass">&nbsp;</label>
	        	<div class="block_form_el_right">
	        		<input name="account/change_mail_frm_btn" value="{$_TRANS['Next']}" type="submit" class="button-green">
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
						'login_empty'=>"input $txt_login/Password",
						'login_not_found'=>"wrong $txt_login/Пароль",
						'banned'=>"access to the account is suspended $ban_date",
						'blocked'=>'account is blocked'
					],
					'skip'=>_uid()
				],
			'Pass'=>
				[
					'*',
					'Пароль!!',
					[
						'pass_not_found'=>'wrong Password'
					]
				],
			'NewMail'=>
				[
					'T',
					valueIf($_cfg.Account_ChangeMailConfirm, 'New e-mail!! <<confirmation will be sent>>', 'New e-mail!!'),
					[
						'mail_empty'=>'input e-mail',
						'mail_wrong'=>'wrong e-mail',
						'mail_used'=>'e-mail is already used'
					]
				]
		]
		captcha=$_cfg.Account_ChangeMailCaptcha
		btn_text='Next'
	*}

{/if}

{include file='footer.tpl' class="cabinet"}
{/strip}