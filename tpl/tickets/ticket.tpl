{strip}
	{include file='header.tpl' title='Тикет'}

	{include file='tickets/_states.tpl'}

	{if $el.tID}

		<h1>{$_TRANS['Ticket']}</h1>
        <div class="block_form">

            <form method="post" name="ticket">
                <input name="tID" id="ticket_tID" value="{$el.tID}" type="hidden">

                <div class="block_form_el cfix">
                    <label for="tickets/ticket_frm_mText">{$_TRANS['State']} <span class="descr_star">*</span></label>
                    <div class="block_form_el_right">
                        {$_tstates[$el.tState]}
                    </div>
                </div>

                <div class="block_form_el cfix">
                    <label for="ticket_tTopic">{$_TRANS['Subject']} <span class="descr_star">*</span></label>
                    <div class="block_form_el_right">
                        <input id="ticket_tTopic" disabled="disabled" value="{$el.tTopic}" type="text">
                    </div>
                </div>

                <div class="block_form_el cfix">
                    <label for="ticket_tText">{$_TRANS['Text']} <span class="descr_star">*</span></label>
                    <div class="block_form_el_right">
                        <textarea id="ticket_tText" disabled="disabled" cols="60" rows="10" wrap="off" class1="ckeditor">{$el.tText}</textarea>
                    </div>
                </div>

                {_getFormSecurity form='ticket'}
                {if $el.tState < 8}
                    <div class="block_form_el cfix">
                        <label for="login_frm_Pass">&nbsp;</label>
                        <div class="block_form_el_right">
                            <input name="ticket_btnclose" value="{$_TRANS['Close Ticket']}" onclick="return confirm('{$_TRANS['Confirm operation']}');" type="submit" class="button-red">
                        </div>
                    </div>
                {/if}
            </form>
        </div>

		{*include file='edit.tpl'
			form='ticket'
			title='Тикет'
			fields=[
				'tID'=>[],
				'tState'=>
					[
						'X',
						'Статус',
						0,
						$_tstates[$el.tState]
					],
				'tTopic'=>
					[
						'L',
						'Тема',
						'size'=>50,
						'readonly'=>true
					],
				'tText'=>
					[
						'W',
						'Текст',
						'size'=>10,
						'readonly'=>true
					]
			]
			values=$el
			btn_text=' '
			btns=valueIf($el.tState < 8, ['close'=>'Закрыть тикет'])
		*}

		<table class="FromatTable">
			{foreach $list as $l}
				<tr><td width="250px"><td width="250px"><td width="250px"></tr>
				<tr>
					{if $l.muID == $el.tuID}
						<td colspan="2">
					{else}
						<td><td colspan="2">
					{/if}
					<fieldset>
					{if $l.muID == $el.tuID}Вы{else}Тех.поддержка{/if}, {$l.mTS}<br>
					{$l.mText}
					</fieldset>
					</td>
				</tr>
			{/foreach}
		</table><br>

		{if $el.tState < 8}

			<div class="block_form">
                {if $tpl_errors['tickets/ticket_frm']|count}
                    <ul class="error_message">
                        {$_TRANS['Please fix the following errors']}:<br/>
                        {if $tpl_errors['tickets/ticket_frm'][0]=='text_empty'}<li>{$_TRANS['fill text']}</li>{/if}
                    </ul>
                {/if}

                <form method="post" name="tickets/ticket_frm">
                    <input type="hidden" name="tID" id="tickets/ticket_frm_tID" value="{$el.tID}">

                    <div class="block_form_el cfix">
                        <label for="tickets/ticket_frm_mText">{$_TRANS['Text']} <span class="descr_star">*</span></label>
                        <div class="block_form_el_right">
                            <textarea name="mText" id="tickets/ticket_frm_mText" cols="60" rows="15" wrap="off" class1="ckeditor">{$smarty.request.mText}</textarea>
                        </div>
                    </div>

                    {_getFormSecurity form='tickets/ticket_frm'}
                    <div class="block_form_el cfix">
                        <label for="login_frm_Pass">&nbsp;</label>
                        <div class="block_form_el_right">
                            <input name="tickets/ticket_frm_btnanswer" value="{$_TRANS['Answer']}" onclick="return confirm('{$_TRANS['Confirm operation']}');" type="submit" class="button-red">
                        </div>
                    </div>
                </form>
            </div>

			{*include file='edit.tpl'
				fields=[
					'tID'=>$el.tID,
					'mText'=>
						[
							'W',
							'Сообщение!!',
							[
								'text_empty'=>'укажите текст'
							],
							'size'=>10
						]
				]
				values=$el
				btn_text=' '
				btns=['answer'=>'Ответить']
			*}

		{/if}

	{else}

		<h1>{$_TRANS['New ticket']}</h1>
        <div class="block_form">
            {if $tpl_errors['tickets/ticket_frm']|count}
                <ul class="error_message">
                    {$_TRANS['Please fix the following errors']}:<br/>
                    {if $tpl_errors['tickets/ticket_frm'][0]=='topic_empty'}<li>{$_TRANS['type subject']}</li>{/if}
                    {if $tpl_errors['tickets/ticket_frm'][0]=='text_empty'}<li>{$_TRANS['fill text']}</li>{/if}
                </ul>
            {/if}

            <form method="post" name="tickets/ticket_frm">

                <div class="block_form_el cfix">
                    <label for="tickets/ticket_frm_tTopic">{$_TRANS['Subject']} <span class="descr_star">*</span></label>
                    <div class="block_form_el_right">
                        <input name="tTopic" id="tickets/ticket_frm_tTopic" value="{$smarty.request.tTopic}" type="text">
                    </div>
                </div>

                <div class="block_form_el cfix">
                    <label for="tickets/ticket_frm_tText">{$_TRANS['Text']} <span class="descr_star">*</span></label>
                    <div class="block_form_el_right">
                        <textarea name="tText" id="tickets/ticket_frm_tText" cols="60" rows="15" wrap="off" class1="ckeditor">{$smarty.request.tText}</textarea>
                    </div>
                </div>

                {_getFormSecurity form='tickets/ticket_frm'}

                <div class="block_form_el cfix">
                    <label for="login_frm_Pass">&nbsp;</label>
                    <div class="block_form_el_right">
                        <input name="tickets/ticket_frm_btncreate" value="{$_TRANS['Create ticket']}" onclick="return confirm('{$_TRANS['Confirm operation']}');" type="submit" class="button-green">
                    </div>
                </div>
            </form>
        </div>

		{*include file='edit.tpl'
			title='Новый тикет'
			fields=[
				'tTopic'=>
					[
						'L',
						'Тема!!',
						[
							'topic_empty'=>'укажите тему'
						],
						'size'=>50
					],
				'tText'=>
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
			btns=['create'=>'Создать тикет']
		*}

	{/if}

    {include file='footer.tpl' class="cabinet"}
{/strip}