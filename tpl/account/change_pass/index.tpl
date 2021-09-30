{strip}
{include file='header.tpl' title=$_TRANS['Change password'] class="cabinet"}

<h1>{$_TRANS['Change password']}</h1>

{if $user.uPTS == 1}

	<p class="info">
		{$_TRANS['You have been given a temporary password.<br>Change it to a more complex']|html_entity_decode}
	</p>

{elseif isset($smarty.get.need_change)}

	<p class="info">
		{$_TRANS['You have not changed your password.<br>The security policy of our website requires a change it']|html_entity_decode}
	</p>

{/if}

	<div class="block_form">
		{if $tpl_errors['account/change_pass_frm']|count}
			<ul class="error_message">
				{$_TRANS['Please fix the following errors']}:<br/>
		        {if $tpl_errors['account/change_pass_frm'][0]=='pass0_wrong'}<li>{$_TRANS['Wrong password']}</li>{/if}
		        {if $tpl_errors['account/change_pass_frm'][0]=='pass_empty'}<li>{$_TRANS['Input password']}</li>{/if}
		        {if $tpl_errors['account/change_pass_frm'][0]=='pass_short'}<li>{$_TRANS['Password is too short']} ({$_TRANS['less than']} {$_cfg.Account_MinPass})</li>{/if}
		        {if $tpl_errors['account/change_pass_frm'][0]=='pass_wrong'}<li>{$_TRANS['Password does not match the format']}</li>{/if}
		        {if $tpl_errors['account/change_pass_frm'][0]=='pass_not_equal'}<li>{$_TRANS['Passwords do not match']}</li>{/if}
		        {if $tpl_errors['account/change_pass_frm'][0]=='pin_wrong'}<li>{$_TRANS['Wrong code']}</li>{/if}
		    </ul>
		{/if}

		<form method="post" action="changepass" name="account/change_pass_frm">
			<div class="block_form_el cfix">
		        <label for="login_frm_Pass0">{$_TRANS['Old password']} <span class="descr_star">*</span></label>
		        <div class="block_form_el_right">
		            <input name="Pass0" id="login_frm_Pass0" value="" type="password">
		        </div>
		    </div>

		    <div class="block_form_el cfix">
		        <label for="login_frm_Pass">{$_TRANS['New password']} <span class="descr_star">*</span></label>
		        <div class="block_form_el_right">
		            <input name="Pass" id="login_frm_Pass" value="" type="password">
		        </div>
		    </div>

		    <div class="block_form_el cfix">
		        <label for="login_frm_Pass2">{$_TRANS['Repeat new password']} <span class="descr_star">*</span></label>
		        <div class="block_form_el_right">
		            <input name="Pass2" id="login_frm_Pass2" value="" type="password">
		        </div>
		    </div>

			{if ($_cfg.Sec_MinPIN != 0)}
			    <div class="block_form_el cfix">
			        <label for="login_frm_PIN">{$_TRANS['Enter the PIN-code (to confirm the change)']} <span class="descr_star">*</span></label>
			        <div class="block_form_el_right">
			            <input name="PIN" id="login_frm_PIN" value="" type="text">
			        </div>
			    </div>
		    {/if}

	        {_getFormSecurity form='account/change_pass_frm'}

	        <div class="block_form_el cfix">
	        	<label for="login_frm_Pass">&nbsp;</label>
	        	<div class="block_form_el_right">
	        		<input name="account/change_pass_frm_btn" value="{$_TRANS['Change']}" type="submit" class="button-green">
	            </div>
	        </div>
		</form>
	</div>

{*include file='edit.tpl'
	url='*'
	fields=
	[
		'Pass0'=>
			[
				'*',
				'Old password!!',
				[
					'pass0_wrong'=>'wrong password'
				]
			],
		'Pass'=>
			[
				'*',
				'New password!!',
				[
					'pass_empty'=>'input password',
					'pass_short'=>"password is too short [less than $MinPass]",
					'pass_wrong'=>'password does not match the format'
				]
			],
		'Pass2'=>
			[
				'*',
				'Повторите новый пароль!!',
				[
					'pass_not_equal'=>'passwords do not match'
				]
			],
		'PIN'=>
			[
				'*',
				'Enter the PIN-code! <<to confirm the change>>',
				[
					'pin_wrong'=>'wrong code'
				],
				'skip'=>($_cfg.Sec_MinPIN == 0),
				'size'=>8
			]
	]
	btn_text='Change'
	btns=valueIf(isset($smarty.get.need_change), ['skip'=>'Do not change'])
*}

{include file='footer.tpl' class="cabinet"}
{/strip}