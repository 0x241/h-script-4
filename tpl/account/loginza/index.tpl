{strip}
{include file='header.tpl' title='Профили'}

<h1>Профили</h1>

{if $logins}

	{include file='list.tpl' 
		title='Прикрепленные'
		fields=[
			'Icon'=>[''],
			'url'=>['Аккаунт'],
			'Action'=>['']
		]
		values=$logins
		row='*'
	}
	
{/if}

<p class="info">
	Вы можете прикрепить и другие Ваши профили.<br>
	Это позволит сайту при авторизации понимать<br>
	что это <strong>именно Вы</strong>, а не несколько разных пользователей
</p>

<h2>Добавить профиль</h2>
<script src="//loginza.ru/js/widget.js" type="text/javascript"></script>
<iframe src="//loginza.ru/api/widget?overlay=loginza&token_url={$loginza_url}" 
style="width: 400px; height: 180px;" scrolling="no" frameborder="no"></iframe>

{include file='footer.tpl'}
{/strip}