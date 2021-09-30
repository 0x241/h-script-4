{strip}
{include file='header.tpl' title=$_TRANS['Registration'] class="cabinet"}

<h1>{$_TRANS['Registration']}</h1>

{if isset($smarty.get.done)}

	<h2>{$_TRANS['Registration complete']}!</h2>
	<p class="info">
		{$_TRANS['Now You can']} <a href="{_link module='account/login'}">{$_TRANS['login']}</a> {$_TRANS['to your account']}
	</p>

{elseif isset($smarty.get.need_confirm)}

	<h2>{$_TRANS['Registration']}!</h2>
	<p class="info">
		{$_TRANS['To complete the operation, you must confirm your e-mail']}.<br>
		{$_TRANS['Please']} <a href="{_link module='confirm'}">{$_TRANS['input confirmation code']}</a><br>
		{$_TRANS['or click on the link that was sent to your e-mail']}.<br><br>
		{$_TRANS['If message is not coming, then try']} <a href="{_link module='account/change_mail'}">{$_TRANS['change e-mail']}</a>
	</p>

{elseif isset($smarty.get.need_confirm_sms)}

	<h2>{$_TRANS['Registration NOT complete']}!</h2>
	<p class="info">
		{$_TRANS['To complete the operation, you must confirm your phone number']}.<br>
		{$_TRANS['Please']} <a href="{_link module='confirm'}">{$_TRANS['input confirmation code']}</a><br>
		{$_TRANS['that was sent to your phone']}
	</p>

{elseif $_cfg.Account_RegMode == 0}

	<h2>{$_TRANS['Registration suspended']}!</h2>
	<p class="info">
		{$_TRANS['Registration on the site is temporarily suspended']}.<br>
		{$_TRANS['For all questions please contact the']} <a href="{_link module='message/support'}">{$_TRANS['support']}</a>
	</p>

{else}

	{$txt_login=valueIf($_cfg.Const_NoLogins, 'e-mail', $_TRANS['login'])}
	{if ($_cfg.Account_RegMode == 2) and !$valid_ref}

		<h2>{$_TRANS['Attention']}!</h2>
		<p class="info">
			{$_TRANS['Registration on the site is possible']} <a href="{_link module='udp/about'}">{$_TRANS['by invitation']}</a> <b>{$_TRANS['only']}</b>.<br>
			{$_TRANS['To do this, you must come to our website<br>by special member ref-link or specify the']|html_entity_decode} {$txt_login}
		</p>

	{elseif $_cfg.Account_RegMode == 3}

		<h2>{$_TRANS['Attention']}!</h2>
		<p class="info">
			{$_TRANS['Registration on the site is possible']} <a href="{_link module='udp/about'}">{$_TRANS['by invitation']}</a> <b>{$_TRANS['only']}</b>.<br>
			{$_TRANS['To do this, you must specify an invitation code']}
		</p>

	{/if}

	{if $_cfg.Account_Loginza and (($_cfg.Account_RegMode == 1) or (($_cfg.Account_RegMode == 2) and $valid_ref)) and ($_cfg.Sec_MinSQA == 0)}
		{include file='account/ulogin/_box.tpl'}
		<br>
		<h3>{$_TRANS['or']}</h3>
	{/if}
	{if $_cfg.Account_ISP and (($_cfg.Account_RegMode == 1) or (($_cfg.Account_RegMode == 2) and $valid_ref)) and ($_cfg.Sec_MinSQA == 0)}
		{include file='account/isp/_box.tpl'}
		<br>
		<h3>{$_TRANS['or']}</h3>
	{/if}

	<div class="block_form">
		<form method="post" action="registration" name="register_frm">
            {if $tpl_errors|count}
	        	<ul class="error_message">
	            	{$_TRANS['Please fix the following errors']}:<br/>
{*$tpl_errors['register_frm'][0]*}
{*xstop($_TRANS['Wrong e-mail'], 1)*}
	                {if $tpl_errors['register_frm'][0]=='name_empty'}<li>{$_TRANS['Input Name']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='login_empty'}<li>{$_TRANS['Enter login']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='login_short'}<li>{$_TRANS['Login is too short, less than']} {$_cfg.Account_MinLogin}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='login_wrong'}<li>{$_TRANS['Wrong login format']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='login_used'}<li>{$_TRANS['Registration']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='mail_empty'}<li>{$_TRANS['Input e-mail']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='mail_wrong'}<li>{$_TRANS['Wrong e-mail']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='mail_used'}<li>{$_TRANS['E-Mail is already used']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='pass_empty'}<li>{$_TRANS['Input password']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='pass_short'}<li>{$_TRANS['Password is too short, less than']} {$_cfg.Account_MinPass}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='pass_wrong'}<li>{$_TRANS['Password does not match the format']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='pass_not_equal'}<li>{$_TRANS['Passwords do not match']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='tel_wrong'}<li>{$_TRANS['Wrong number']}</li>{/if}
					{if $tpl_errors['register_frm'][0]=='defpsys_wrong'}<li>{$_TRANS['Wrong default payment system']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='ref_empty'}<li>{$_TRANS['Input']} {$txt_login}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='ref_not_found'}<li>{$txt_login} {$_TRANS['not found']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='inv_empty'}<li>{$_TRANS['Input code']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='inv_not_found'}<li>{$_TRANS['Wrong code']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='inv_used'}<li>{$_TRANS['Code is already in use']}</li>{/if}
					{if $tpl_errors['register_frm'][0]=='secq_empty'}<li>{$_TRANS['Input question']}</li>{/if}
					{if $tpl_errors['register_frm'][0]=='secq_short'}<li>{$_TRANS['question is too short']} ({$_TRANS['less than']} {$_cfg.Sec_MinSQA})</li>{/if}
					{if $tpl_errors['register_frm'][0]=='seca_empty'}<li>{$_TRANS['Input answer']}</li>{/if}
					{if $tpl_errors['register_frm'][0]=='seca_short'}<li>{$_TRANS['answer is too short']} ({$_TRANS['less than']} {$_cfg.Sec_MinSQA})</li>{/if}
					{if $tpl_errors['register_frm'][0]=='seqa_equal_secq'}<li>{$_TRANS['Answer can not be the same with the question']}</li>{/if}
					{if $tpl_errors['register_frm'][0]=='captcha_wrong'}<li>{$_TRANS['Wrong code']}</li>{/if}
	                {if $tpl_errors['register_frm'][0]=='must_agree'}<li>{$_TRANS['You must accept the rules']}</li>{/if}
	            </ul>
	        {/if}

			{if $_cfg.Account_UseName == 1}
		        <div class="block_form_el cfix">
		            <label for="register_frm_aName">{$_TRANS['You name']}</label>
		            <div class="block_form_el_right">
		            	<input name="aName" id="register_frm_aName" value="{$smarty.post.aName}" type="text">
		            </div>
		        </div>
	        {/if}

	        {if !$_cfg.Const_NoLogins}
		        <div class="block_form_el cfix">
		            <label for="register_frm_uLogin">{$_TRANS['Login']}</label>
		            <div class="block_form_el_right">
		            	<input name="uLogin" id="register_frm_uLogin" value="{$smarty.post.uLogin}" type="text">
		            </div>
		        </div>
	        {/if}

			<div class="block_form_el cfix">
		    	<label for="register_frm_uMail">{valueIf($_cfg.Account_RegConfirm, $_TRANS['E-Mail (confirmation will be sent)'], 'E-Mail')}</label>
		        <div class="block_form_el_right">
		        	<input name="uMail" id="register_frm_uMail" value="{$smarty.post.uMail}" type="text">
		        </div>
		    </div>

			<div class="block_form_el cfix">
		    	<label for="register_frm_uPass">{$_TRANS['Password']} <span class="descr_star">*</span></label>
		        <div class="block_form_el_right">
		        	<input name="uPass" id="register_frm_uPass" value="" type="password">
		        </div>
		    </div>

			<div class="block_form_el cfix">
		    	<label for="register_frm_Pass2">{$_TRANS['Repeat password']} <span class="descr_star">*</span></label>
		        <div class="block_form_el_right">
		        	<input name="Pass2" id="register_frm_Pass2" value="" type="password">
		        </div>
		    </div>

			{if $_cfg.SMS_REG}
		        <div class="block_form_el cfix">
		            <label for="register_frm_aTel">{$_TRANS['Phone number (with country code)']}</label>
		            <div class="block_form_el_right">
		            	<input name="aTel" id="register_frm_aTel" value="{$smarty.post.aTel}" type="text">
		            </div>
		        </div>
	        {/if}

        <div class="block_form_el cfix">
          <label for="register_frm_aDefCurr">{$_TRANS['Default payment system']}<span class="descr_star">*</span></label>
          <div class="block_form_el_right">
            <select name="aDefCurr" id="register_frm_aDefCurr">
              <option value="0">- {$_TRANS['select']} -</option>
              {foreach from=$currs2 item=c key=k}
                <option value="{$k}"{if $smarty.post.aDefCurr == $k} selected{/if}>{$c.cName}</option>
              {/foreach}
            </select>
          </div>
        </div>
		
	        {if (($_cfg.Account_RegMode != 3) or $_cfg.Ref_Word)}
		        <div class="block_form_el cfix">
		            <label for="register_frm_uRef">{$_TRANS['You invited by']}</label>
		            <div class="block_form_el_right">
                        {$smarty.session._ref}
		            	<input name="uRef" id="register_frm_uRef" value="{$smarty.session._ref}" type="hidden"/>
                        {* {if $valid_ref}disabled="disabled"{/if}*}
		            </div>
		        </div>
	        {/if}

	        {if ($_cfg.Account_RegMode == 3)}
		        <div class="block_form_el cfix">
		            <label for="register_frm_Invite">{$_TRANS['Invite code']}</label>
		            <div class="block_form_el_right">
		            	<input name="Invite" id="register_frm_Invite" value="{$smarty.post.Invite}" type="text">
		            </div>
		        </div>
	        {/if}

	        {if ($_cfg.Sec_MinSQA != 0)}
		        <div class="block_form_el cfix">
		            <label for="register_frm_aSQuestion">{$_TRANS['Secret question']} <span class="descr_star">*</span></label>
		            <div class="block_form_el_right">
		            	<input name="aSQuestion" id="register_frm_aSQuestion" value="{$smarty.post.aSQuestion}" type="text">
		            </div>
		        </div>
	        {/if}

	        {if ($_cfg.Sec_MinSQA != 0)}
		        <div class="block_form_el cfix">
		            <label for="register_frm_aSAnswer">{$_TRANS['Secret answer']} <span class="descr_star">*</span></label>
		            <div class="block_form_el_right">
		            	<input name="aSAnswer" id="register_frm_aSAnswer" value="{$smarty.post.aSAnswer}" type="text">
		            </div>
		        </div>
	        {/if}

			<div class="block_form_el checkbox cfix">
	            <label for="register_frm_Agree">&nbsp;</label>
	            <div class="block_form_el_right">
	            	{$_TRANS['I accept']} <a href="{_link module='udp/rules'}" target="_blank">{$_TRANS['rules']}</a> {$_TRANS['and agree terms of service']}
	            	<input name="Agree" id="register_frm_Agree" value="1" type="checkbox">
	            </div>
	        </div>

            {_getFormSecurity form='register_frm' captcha=$_cfg.Account_RegCaptcha}
            {if $__Capt}
	        	{include file='captcha.tpl' form='register_frm' star=$edit_descr_star}
	        {/if}

	        <div class="block_form_el cfix">
	        	<label for="login_frm_Pass">&nbsp;</label>
	        	<div class="block_form_el_right">
	            	<input name="register_frm_btn" value="{$_TRANS['Sign up']}" type="submit" class="button-green">
	            </div>
	        </div>
        </form>
    </div>

	{*include file='edit.tpl'
		url="{_link module='account/register'}"
		form='register_frm'
		fields=
		[
			'aName'=>
				[
					'T',
					'Your Name',
					[
						'name_empty'=>'input Name'
					],
					'skip'=>($_cfg.Account_UseName != 1)
				],
			'uLogin'=>
				[
					'T',
					'Your Login!!',
					[
						'login_empty'=>'Enter login',
						'login_short'=>"login is too short [less than {$_cfg.Account_MinLogin}]",
						'login_wrong'=>'wrong login format',
						'login_used'=>'this login is busy'
					],
					'skip'=>$_cfg.Const_NoLogins,
					'comment'=>' <span id="login_check" class="err"></span>'
				],
			'uMail'=>
				[
					'T',
					valueIf($_cfg.Account_RegConfirm, 'e-mail!! <<confirmation will be sent>>', 'e-mail!!'),
					[
						'mail_empty'=>'input e-mail',
						'mail_wrong'=>'wrong e-mail',
						'mail_used'=>'e-mail is already in use'
					],
					'comment'=>' <span id="mail_check" class="err"></span>'
				],
			'uPass'=>
				[
					'*',
					'Your Password!!',
					[
						'pass_empty'=>'input password',
						'pass_short'=>"password is too short [less than {$_cfg.Account_MinPass}]",
						'pass_wrong'=>'password does not match the format'
					]
				],
			'Pass2'=>
				[
					'*',
					'Re-type password!!',
					[
						'pass_not_equal'=>'passwords do not match'
					]
				],
			'aTel'=>
				[
					'T',
					'Phone number!! <<with country code>>',
					[
						'tel_wrong'=>'wrong number'
					],
					'skip'=>!$_cfg.SMS_REG
				],
			'uRef'=>
				[
					'T',
					"You invited by{if $_cfg.Account_RegMode == 2}!!{/if}{if $_cfg.Const_NoLogins} <<e-mail>>{/if}",
					[
						'ref_empty'=>"inpur $txt_login",
						'ref_not_found'=>"$txt_login not found"
					],
					'default'=>$smarty.session._ref,
					'skip'=>(($_cfg.Account_RegMode == 3) or !$_cfg.Ref_Word),
					'readonly'=>$valid_ref
				],
			'Invite'=>
				[
					'T',
					'Invite code!!',
					[
						'inv_empty'=>'input code',
						'inv_not_found'=>'wrong code',
						'inv_used'=>'code is already in use'
					],
					'skip'=>($_cfg.Account_RegMode != 3)
				],
			'aSQuestion'=>
				[
					'T',
					'Secret question!!',
					[
						'secq_empty'=>'input question',
						'secq_short'=>"question is too short [less than {$_cfg.Sec_MinSQA}]"
					],
					'skip'=>($_cfg.Sec_MinSQA == 0),
					'size'=>40
				],
			'aSAnswer'=>
				[
					'T',
					'Secret answer!!',
					[
						'seca_empty'=>'input answer',
						'seca_short'=>"answer is too short [less than {$_cfg.Sec_MinSQA}]",
						'seqa_equal_secq'=>'answer can not be the same with the question'
					],
					'skip'=>($_cfg.Sec_MinSQA == 0),
					'size'=>40
				],
			'Agree'=>
				[
					'CC',
					"I accept <a href=\"{_link module='udp/rules'}\" target=\"_blank\">rules</a> and agree!! terms of service",
					[
						'must_agree'=>'you must accept the rules'
					]
				]
		]
		errors=['multi_reg'=>'multiple registration is forbidden']
		captcha=$_cfg.Account_RegCaptcha
		btn_text='Sign up'
	*}

{/if}

{if !$_cfg.Const_NoLogins}

	<script type="text/javascript">
		function chkLogin()
		{
			$('#register_frm_uLogin').removeClass('error');
			$('#login_check').html('');
			$.ajax(
				{
					type: 'POST',
					url: 'ajax',
					data: 'module=account/register&do=chklogin&login='+
						encodeURIComponent($('#register_frm_uLogin').val()),
					success:
						function(ex)
						{
							if (ex == 1)
							{
								$('#register_frm_uLogin').addClass('error');
								$('#login_check').html('used');
							}
						}
				}
			);
		}
		tid2=0;
		$('#register_frm_uLogin').keypress(
			function()
			{
				clearTimeout(tid2);
				tid2=setTimeout(function(){ chkLogin(); }, 1000);
			}
		);
		chkLogin();
	</script>

{/if}

	<script type="text/javascript">
		function chkMail()
		{
			$('#register_frm_uMail').removeClass('error');
			$('#mail_check').html('');
			$.ajax(
				{
					type: 'POST',
					url: 'ajax',
					data: 'module=account/register&do=chkmail&mail='+
						encodeURIComponent($('#register_frm_uMail').val()),
					success:
						function(ex)
						{
							if (ex == 1)
							{
								$('#register_frm_uMail').addClass('error');
								$('#mail_check').html('used');
							}
						}
				}
			);
		}
		tid=0;
		$('#register_frm_uMail').keypress(
			function()
			{
				clearTimeout(tid);
				tid=setTimeout(function(){ chkMail(); }, 1000);
			}
		);
		chkMail();
	</script>

{include file='footer.tpl' class="cabinet"}
{/strip}