{strip}
{include file='header.tpl' title=$_TRANS['Messages'] class="cabinet"}

<h1>{$_TRANS['Messages']}</h1>

<a href="{_link module='message'}" class="button-green">{$_TRANS['Inbox']}</a>

{if $list}

	{include file='list.tpl'
		title='Исходящие'
		url='*'
		fields=[
			'mID'=>['ID'],
			'mTS'=>['Дата'],
			'uLogin'=>['Получатель'],
			'mTopic'=>['Тема'],
			'mText'=>['Текст']
		]
		values=$list
		row='*'
	}

{else}

	{$_TRANS['No messages']}

{/if}

<a href="{_link module='message/show'}?new" class="button-green">{$_TRANS['Create']}</a><br>

{include file='footer.tpl' class="cabinet"}
{/strip}