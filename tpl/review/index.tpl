{strip}
{include file='header.tpl' title=$_TRANS['Reviews'] class="cabinet"}

<h1>{$_TRANS['Reviews']}</h1>
<h3>{$_TRANS['Total reviews']} - {$total}</h3>

{if isset($smarty.get.awating)}

	<h2>{$_TRANS['Your review has successfully added!']}</h2>
	<p class="info">
		{$_TRANS['The administrator will check it in the near future']}
	</p>

{else}

	{if $list}
		<table class="formatTable" width="600px">
		{foreach name=list from=$list key=id item=l}
			<tr>
				<td>
					{include file='_usericon.tpl' user=$l}
					<h2>{$l.uLogin}</h2>
					<small>{$l.oTS}</small>
					<div style="padding: 10px; background-color: #F3F3F3;">
						{$l.oText|nl2br}
					</div>
				</td>
			</tr>
		{/foreach}
		</table>
		{include file='pl.tpl'}
		<br>
	{else}
		- {$_TRANS['No records']} -
	{/if}

	{if _uid()}

		<h2>{$_TRANS['Leave your own review']}</h2>
		<div class="block_form">
			{if $tpl_errors['review_frm']|count}
				<ul class="error_message">
			    	{$_TRANS['Please fix the following errors']}:<br/>
			        {if $tpl_errors['review_frm'][0]=='text_empty'}<li>{$_TRANS['Input text']}</li>{/if}
			    </ul>
			{/if}

			<form method="post" name="review_frm">
		        <div class="block_form_el checkbox cfix">
		            <label for="login_frm_Text">{$_TRANS['Text']} <span class="descr_rem">(moderated)</span></label>
		            <div class="block_form_el_right">
		            	<textarea name="Text" id="review_frm_Text" cols="60" rows="5" wrap="off"></textarea>
		            </div>
		        </div>

		        {_getFormSecurity form='review_frm'}
		        <div class="block_form_el cfix">
		        	<label for="login_frm_Pass">&nbsp;</label>
		        	<div class="block_form_el_right">
		            	<input name="review_frm_btn" value="{$_TRANS['Add']}" type="submit" class="button-green">
		            </div>
		        </div>
			</form>
		</div>

		{*include file='edit.tpl'
			title='Оставьте свой отзыв'
			fields=
			[
				'Text'=>
					[
						'W',
						valueIf($_cfg.Review_Mode, 'Текст <<проверяется>>', 'Текст'),
						[
							'text_empty'=>'укажите текст'
						],
						'size'=>5
					]
			]
			btn_text='Добавить'
		*}
	{/if}

{/if}

{include file='footer.tpl' class="cabinet"}
{/strip}