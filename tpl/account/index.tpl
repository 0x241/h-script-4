{strip}
{include file='header.tpl' title=$_TRANS['Account'] class="cabinet"}

<h1>{$_TRANS['Personal settings']}</h1>

{if $_cfg.Sec_ForceReConfig and $user.aNeedReConfig}

	<p class="info">
		{$_TRANS['Before you begin you must set your personal settings']}
	</p>

{/if}

<div class="block_form">
	{if $tpl_errors|count}
		<ul class="error_message">
			{$_TRANS['Please fix the following errors']}:<br/>
		    {if $tpl_errors['account_frm'][0]=='name_empty'}<li>{$_TRANS['Input name']}</li>{/if}
		    {if $tpl_errors['account_frm'][0]=='tel_wrong'}<li>{$_TRANS['Wrong number']}></li>{/if}
		    {if $tpl_errors['account_frm'][0]=='tz_wrong'}<li>{$_TRANS['Wrong zone (h:m)']}</li>{/if}
		    {if $tpl_errors['account_frm'][0]=='secq_empty'}<li>{$_TRANS['Input question']}</li>{/if}
		    {if $tpl_errors['account_frm'][0]=='secq_short'}<li>{$_TRANS['Question is too short']} ({$_TRANS['less than']} {$_cfg.Sec_MinSQA})</li>{/if}
		    {if $tpl_errors['account_frm'][0]=='seca_empty'}<li>{$_TRANS['Input answer']}</li>{/if}
		    {if $tpl_errors['account_frm'][0]=='seca_short'}<li>{$_TRANS['Answer is too short']} ({$_TRANS['less than']} {$_cfg.Sec_MinSQA})</li>{/if}
		    {if $tpl_errors['account_frm'][0]=='seqa_equal_secq'}<li>{$_TRANS['Answer can not be the same with the question']}</li>{/if}
		    {if $tpl_errors['account_frm'][0]=='pin_wrong'}<li>{$_TRANS['Wrong code']}</li>{/if}
		    {if $tpl_errors['account_frm'][0]=='ga_wrong'}<li>{$_TRANS['GA_wrong_code']}</li>{/if}
		</ul>
	{/if}

	<form method="post" action="account" name="account_frm">
		{if ($_cfg.Account_UseAvatar != 0)}
			<div class="block_form_el cfix">
				{include file='account/_avatar.box.tpl'}
			</div>
		{/if}
		{if ($_cfg.Account_UseName != 0)}
			<div class="block_form_el cfix">
				<label for="">{$_TRANS['Your Name']}</label>
				{if $_cfg.Account_LockData}
					<div class="block_form_el_right">{$user.aName}</div>
				{else}
					<input type="text" name="aName" id="account_frm_aName" value="{$user.aName}"/>
				{/if}
			</div>
		{/if}
		{if !$_cfg.Const_NoLogins}
			<div class="block_form_el cfix">
				<label for="">{$_TRANS['Your Login']}</label>
				<div class="block_form_el_right">{$user.uLogin}</div>
			</div>
		{/if}
		<div class="block_form_el cfix">
			<label for="">{$_TRANS['Youe E-Mail']}</label>
			<div class="block_form_el_right">{$user.uMail}</div>
		</div>
		{if $_cfg.SMS_REG}
			<div class="block_form_el cfix">
				<label for="">{$_TRANS['Phone number']}</label>
				<div class="block_form_el_right">{$user.aTel}</div>
			</div>
		{/if}
		<div class="block_form_el cfix">
			<label for="">{$_TRANS['Your time zone (от GMT) (+3:00 = Moscow)']}</label>
			<div class="block_form_el_right">
				<input name="TZ" id="account_frm_TZ" value="{$utz}" type="text">
			</div>
		</div>
		{if !$_cfg.Msg_NoMail}
			<div class="block_form_el checkbox cfix">
				<label for="login_frm_Pass">&nbsp;</label>
	            <div class="block_form_el_right">
	            	{$_TRANS['Do not be notified to e-mail']}
	            	<input name="aNoMail" id="account_frm_aNoMail" value="1" {if $user.aNoMail}checked="checked"{/if} type="checkbox">
	            </div>
			</div>
		{/if}
		<br/>
		<h2>Google Authenticator</h2>
		<div class="block_form_el cfix">
			<div>
				{include file='account/_ga.box.tpl'}
			</div>
			<label for="">{$_TRANS['GA_input']}</label>
			<div class="block_form_el_right">
				<input name="GACode" id="account_frm_GACode" value="" type="text">
			</div>
		</div>
		<h2>{$_TRANS['Security']}</h2>
		<div class="block_form_el cfix">
			<label for="">{$_TRANS['Control IP-address change']}</label>
			<div class="block_form_el_right">
				<select name="aIPSec" id="account_frm_aIPSec">
					<option value="0">- {$_TRANS['default']} -</option>
					<option value="1" {if $user.aIPSec==1}selected="selected"{/if}>x.0.0.0</option>
					<option value="2" {if $user.aIPSec==2}selected="selected"{/if}>x.x.0.0</option>
					<option value="3" {if $user.aIPSec==3}selected="selected"{/if}>x.x.x.0</option>
					<option value="4" {if $user.aIPSec==4}selected="selected"{/if}>x.x.x.x</option>
				</select>
			</div>
		</div>
		<div class="block_form_el checkbox cfix">
			<label for="login_frm_Pass">&nbsp;</label>
	        <div class="block_form_el_right">
	        	{$_TRANS['Bind session to IP-address']}
	            <input name="aSessIP" id="account_frm_aSessIP" value="1" {if $user.aSessIP}checked="checked"{/if} type="checkbox">
	        </div>
		</div>
		<div class="block_form_el checkbox cfix">
			<label for="login_frm_Pass">&nbsp;</label>
	        <div class="block_form_el_right">
	        	{$_TRANS['Disallow parallel sessions']}
	            <input name="aSessUniq" id="account_frm_aSessUniq" value="1" {if $user.aSessUniq}checked="checked"{/if} type="checkbox">
	        </div>
		</div>
		<div class="block_form_el cfix">
			<label for="">{$_TRANS['Auto logout in N minutes (0 - default)']}</label>
			<div class="block_form_el_right">
				<input name="aTimeOut" id="account_frm_aTimeOut" value="{$user.aTimeOut}" type="text">
			</div>
		</div>
		{if ($_cfg.Sec_MinSQA != 0)}
			<div class="block_form_el cfix">
				<label for="">{$_TRANS['Secret question']}</label>
				<div class="block_form_el_right">
					<textarea class="ckeditor" name="aSQuestion" id="account_frm_aSQuestion" value="{$user.aSQuestion}" type="text"></textarea>
				</div>
			</div>
		{/if}
		{if ($_cfg.Sec_MinSQA != 0)}
			<div class="block_form_el cfix">
				<label for="">{$_TRANS['Secret answer(input to change)']}</label>
				<div class="block_form_el_right">
					<input name="aSAnswer" id="account_frm_aSAnswer" value="{$user.aSAnswer}" type="text">
				</div>
			</div>
		{/if}
		{if ($_cfg.Sec_MinPIN != 0)}
			<div class="block_form_el cfix">
				<label for="">{$_TRANS['Input PIN-code (to confirm changes)']}</label>
				<div class="block_form_el_right">
					<input name="PIN" id="account_frm_PIN" value="{$user.PIN}" type="text">
				</div>
			</div>
		{/if}

		{_getFormSecurity form='account_frm'}
		<br><input name="account_frm_btn" value="{$_TRANS['Save']}" type="submit" class="button-green">
	</form>
</div>

{*include file='edit.tpl'
	url='*'
	title1='Parameters'
	fields=
	[
		'aName'=>
			[
				'T',
				'Your Name!!',
				[
					'name_empty'=>'input Name'
				],
				'readonly'=>$_cfg.Account_LockData,
				'skip'=>($_cfg.Account_UseName == 0)
			],
		'uLogin'=>
			[
				'X',
				'Your Login',
				0,
				'skip'=>$_cfg.Const_NoLogins
			],
		'uMail'=>
			[
				'X',
				'Your e-mail'
			],
		'aTel'=>
			[
				'T',
				'Your phone number!! <<with country code>>',
				[
					'tel_wrong'=>'wrong number'
				],
				'skip'=>!$_cfg.SMS_REG
			],
		'TZ'=>
			[
				'T',
				'Your time zone!! <<от GMT>>',
				[
					'tz_wrong'=>'wrong zone [h:m]'
				],
				'comment'=>'+3 = Moscow',
				default=>$utz,
				'size'=>6
			],
		'aNoMail'=>
			[
				'C',
				'Do not be notified to e-mail',
				'skip'=>$_cfg.Msg_NoMail
			],
		99=>'Security',
		'aIPSec'=>
			[
				'S',
				'Control IP-address change',
				0,
				[
					0=>'- default -',
					1=>'x.0.0.0',
					2=>'x.x.0.0',
					3=>'x.x.x.0',
					4=>'x.x.x.x'
				]
			],
		'aSessIP'=>['C', 'Bind session to IP-address'],
		'aSessUniq'=>['C', 'Disallow parallel sessions'],
		'aTimeOut'=>['I', 'Auto logout in N minutes <<0 - default>>'],
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
				'*',
				'Secret answer!! <<input to change>>',
				[
					'seca_empty'=>'input answer',
					'seca_short'=>"answer is too short [less than {$_cfg.Sec_MinSQA}]",
					'seqa_equal_secq'=>'answer can not be the same with the question'
				],
				'skip'=>($_cfg.Sec_MinSQA == 0),
				'size'=>40
			],
		'PIN'=>
			[
				'*',
				'Input PIN-code!! <<to confirm changes>>',
				[
					'pin_wrong'=>'wrong code'
				],
				'skip'=>($_cfg.Sec_MinPIN == 0),
				'size'=>8
			]
	]
	values=$user
	hide_cancel=$user.aNeedReConfig
*}

{if !($_cfg.Sec_ForceReConfig and $user.aNeedReConfig)}
	<br>
	{if $_cfg.Account_Loginza}<a href="{_link module='account/ulogin'}" class="button-green">{$_TRANS['Profiles']}</a>&nbsp;{/if}
	{if !$_cfg.Account_LockData}<a href="{_link module='account/change_mail'}" class="button-green">{$_TRANS['Change e-mail']}</a>&nbsp;{/if}
	<a href="{_link module='account/change_pass'}" class="button-green">{$_TRANS['Change password']}</a>
{/if}

{include file='footer.tpl' class="cabinet"}

{/strip}