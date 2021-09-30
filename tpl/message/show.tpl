{strip}
{include file='header.tpl' title=$_TRANS['Messages'] class="cabinet"}

{if $el.mID}

	<h2>{$_TRANS['Messages']}</h2>

	<div class="block_form">
		<form method="post" name="message/show_frm">
			<input name="Re" id="message/show_frm_Re" value="" type="hidden">

			<div class="block_form_el cfix">
	            <label for="message/show_frm_uLogin">{$_TRANS['Sender']}</label>
	            <div class="block_form_el_right">
	            	<input name="uLogin" id="message/show_frm_uLogin" value="{$el.uLogin}" type="text" readonly="true">
	            </div>
	        </div>

	        <div class="block_form_el cfix">
	            <label for="message/show_frm_mTopic">{$_TRANS['Topic']}</label>
	            <div class="block_form_el_right">
	            	<input name="mTopic" id="message/show_frm_mTopic" value="{$el.mTopic}" type="text" readonly="true">
	            </div>
	        </div>

			<div class="block_form_el cfix">
	            <label for="message/show_frm_mText">{$_TRANS['Text']}</label>
	            <div class="block_form_el_right">
	            	<textarea name="mText" id="message/show_frm_mText" cols="60" rows="15" wrap="off" readonly="">{$el.mText}</textarea>
	            </div>
	        </div>

	        {_getFormSecurity form='message/show_frm'}
	        {*<div class="block_form_el cfix">
	        	<label for="login_frm_Pass">&nbsp;</label>
	        	<div class="block_form_el_right">
	            	{if $_cfg.Msg_Mode > 1}
						<a href="{_link module='message/show'}?new&re={$el.bID}" class="button-green">{$_TRANS['Answer']}</a><br>
					{/if}
	            </div>
	        </div>*}
		</form>
	</div>

	{*include file='edit.tpl'
		title='Сообщение'
		fields=[
			'uLogin'=>
				[
					'T',
					'Отправитель',
					'readonly'=>true
				],
			'mTopic'=>
				[
					'T',
					'Тема',
					'readonly'=>true
				],
			'mText'=>
				[
					'W',
					'Текст',
					'size'=>15,
					'readonly'=>true
				]
		]
		values=$el
		btn_text=' '
	*}

{if $_cfg.Msg_Mode > 1}
	<a href="{_link module='message/show'}?new&re={$el.bID}" class="button-green">{$_TRANS['Answer']}</a><br>
{/if}

{else}

	<h1>{$_TRANS['New message']}</h1>

	<div class="block_form">
		{if $tpl_errors['message/show_frm']|count}
			<ul class="error_message">
		    	{$_TRANS['Please fix the following errors']}:<br/>
		        {if $tpl_errors['message/show_frm'][0]=='to_empty'}<li>{$_TRANS['Input receiver']}</li>{/if}
		        {if $tpl_errors['message/show_frm'][0]=='to_wrong'}<li>{$_TRANS['User not found']}</li>{/if}
		        {if $tpl_errors['message/show_frm'][0]=='topic_empty'}<li>{$_TRANS['Input topic']}</li>{/if}
		        {if $tpl_errors['message/show_frm'][0]=='text_empty'}<li>{$_TRANS['Input text']}</li>{/if}
		    </ul>
		{/if}

		<form method="post" name="message/show_frm">
			<input name="Re" id="message/show_frm_Re" value="" type="hidden">

			<div class="block_form_el cfix">
	            <label for="message/show_frm_mTo">{$_TRANS['Receiver']} <span class="descr_star">*</span></label>
	            <div class="block_form_el_right">
	            	<input name="mTo" id="message/show_frm_mTo" value="{$smarty.request.mTo}" size="30" type="text">
	            </div>
	        </div>

	        <div class="block_form_el cfix">
	            <label for="message/show_frm_mTopic">{$_TRANS['Topic']} <span class="descr_star">*</span></label>
	            <div class="block_form_el_right">
	            	<input name="mTopic" id="message/show_frm_mTopic" value="{$smarty.request.mTopic}" type="text">
	            </div>
	        </div>

			<div class="block_form_el cfix">
	            <label for="message/show_frm_mText">{$_TRANS['Text']} <span class="descr_star">*</span></label>
	            <div class="block_form_el_right">
	            	<textarea name="mText" id="message/show_frm_mText" cols="60" rows="15" wrap="off">{$smarty.request.mText}</textarea>
	            </div>
	        </div>

	        {_getFormSecurity form='message/show_frm'}
	        <div class="block_form_el cfix">
	        	<label for="login_frm_Pass">&nbsp;</label>
	        	<div class="block_form_el_right">
	            	<input name="message/show_frm_btnsend" value="{$_TRANS['Send']}" onclick="return confirm('{$_TRANS['Confirm the operation "Send"']}');" type="submit" class="button-green">
	            </div>
	        </div>
		</form>
	</div>

	{*include file='edit.tpl'
		title='Новое сообщение'
		fields=[
			'Re'=>[],
			'mTo'=>
				[
					'T',
					'Получатель!!',
					[
						'to_empty'=>'укажите получателя',
						'to_wrong'=>'получатель не найдены'
					],
					'size'=>30
				],
			'mTopic'=>
				[
					'L',
					'Тема!!',
					[
						'topic_empty'=>'укажите тему'
					],
					size=>50
				],
			'mText'=>
				[
					'W',
					'Текст!!',
					[
						'text_empty'=>'укажите текст'
					],
					'size'=>15
				]
		]
		values=$el
		btn_text=' '
		btns=['send'=>'Отправить']
	*}

{/if}

{include file='footer.tpl' class="cabinet"}
{/strip}