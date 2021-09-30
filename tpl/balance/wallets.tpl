{strip}
{include file='header.tpl' title=$_TRANS['Payment details'] class="cabinet"}

<h1>{$_TRANS['Payment details']}</h1>

{if !$wfields}

	<p class="info">
		{$_TRANS['Payment systems are not connected']}
	</p>

{else}

	<div class="block_form">
        {$_TRANS['bal_save']}


		{if $tpl_errors['balance/wallets_frm']|count}
			<ul class="error_message">
		    	{$_TRANS['Please fix the following errors']}:<br/>
		        {if $tpl_errors['balance/wallets_frm'][0]=='psys_wrong'}<li>{$_TRANS['Input pay.system']}</li>{/if}
		        {if $tpl_errors['balance/wallets_frm'][0]=='pin_wrong'}<li>{$_TRANS['Wrong code']}</li>{/if}
		    </ul>
		{/if}

		<form method="post" action="balance/wallets" name="balance/wallets_frm">
			<div class="block_form_el cfix">
				<label for="">{$_TRANS['Default payment system']}</label>
				<div class="block_form_el_right">
					<select name="DefCurr" id="balance/wallets_frm_DefCurr" class="select">
						<option value="0" selected="">- {$_TRANS['select']} -</option>
						{foreach from=$defcurr key=k item=v}
							<option value="{$k}" {if $user['aDefCurr']==$k}selected="selected"{/if}>{$v}</option>
						{/foreach}
					</select>
				</div>
			</div>
			{foreach from=$wfields key=f item=v}
			<div class="block_form_el cfix">
				<label for="">{$v[1]}</label>
				<div class="block_form_el_right">
					{$vv = _arr_val($wdata, $f)}
					<input name="{$f}" id="balance/wallets_frm_{$f}" value="{$vv}" type="text" style="margin: 0 0 10px 0;">
					<small>{$v.comment}</small>
				</div>
			</div>
			{/foreach}
			{if $showbutton and ($_cfg.Sec_MinPIN > 0)}
				<div class="block_form_el cfix">
					<label for="">{$_TRANS['Input PIN-code (to confirm changes)']}</label>
					<div class="block_form_el_right">
						<input name="PIN" id="balance/wallets_frm_PIN" value="{$smarty.request.PIN}" type="text">
					</div>
				</div>
			{/if}

			{_getFormSecurity form='balance/wallets_frm'}
			<input name="balance/wallets_frm_btn" value="{$_TRANS['Save']}" type="submit" class="button-green">
		</form>
	</div>

	{*if $_cfg.Const_IntCurr}
		{$wfields = [
			'DefCurr'=>[
				'S',
				'Платежная система по умолчанию!!',
				[
					'psys_wrong'=>'укажите плат.систему'
				],
				[0=>'- выберите -'] + (array)$defcurr,
				'default'=>$user['aDefCurr']
			]
		]+$wfields}
	{/if}

	{if $showbutton and ($_cfg.Sec_MinPIN > 0)}
		{$wfields[] = ''}
		{$wfields['PIN'] = [
						'*',
						'Введите PIN-код!! <<чтобы подтвердить изменения>>',
						[
							'pin_wrong'=>'неверный код'
						],
						'size'=>8
					]}
	{/if}

	{include file='edit.tpl'
		url='*'
		fields=$wfields
		values=$wdata
		btn_text=valueIf(!$showbutton, ' ')
	*}

{/if}

{include file='footer.tpl' class="cabinet"}
{/strip}