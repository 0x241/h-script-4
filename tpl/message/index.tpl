{strip}
{include file='header.tpl' title=$_TRANS['Messages'] class="cabinet"}

<h2>{$_TRANS['Messages']}</h2>

{if $_cfg.Msg_Mode > 1}
	<a href="{_link module='message/outbox'}" class="button-green">{$_TRANS['Outbox']}</a>
	<br/><br/>
{/if}

{if $list}
	<form method="post" action="messages" name="message_frm">
		<table class="styleTable" border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<th>
					<input type="checkbox" id="swall" onclick="setchkbox('swall','b')" title="Select all">
				</th>
				<th>{$_TRANS['ID']}</th>
				<th><a href="messages?sort=mTS1">{$_TRANS['Date']}</a></th>
				<th>{$_TRANS['Sender']}</th>
				<th>{$_TRANS['Topic']}</th>
				<th>{$_TRANS['Readed']}</th>
			</tr>
			{foreach name=messages from=$list key=id item=l}
				<tr>
					<td>
						<input name="ids[]" value="{$id}" id="b{$smarty.foreach.messages.iteration}" type="checkbox">
					</td>
					<td>{$id}</td>
					<td>{$l.mTS}</td>
					<td class="nowrap">{$l.uLogin}</td>
					<td><a href="message?id={$id}">{$l.mTopic}</a></td>
					<td class="nowrap">{$l.bRTS}</td>
				</tr>
			{/foreach}
		</table>

		{_getFormSecurity form='message_frm'}
		<br/>
		<div>{$_TRANS['With selected']}: &nbsp;<input name="message_frm_btndel" value="{$_TRANS['Delete']}" onclick="return confirm($_TRANS['Confirm operation "Delete"']);" type="submit" class="button-green"></div>
	</form>

	{*include file='list.tpl'
		title='Входящие'
		url='*'
		fields=[
			'bID'=>['ID'],
			'mTS'=>['Дата'],
			'uLogin'=>['Отправитель'],
			'mTopic'=>['Тема'],
			'bRTS'=>['Прочтено']
		]
		values=$list
		row='*'
		btns=['del'=>'Удалить']
	*}

{else}

	{$_TRANS['No messages']}

{/if}

{include file='footer.tpl' class="cabinet"}
{/strip}