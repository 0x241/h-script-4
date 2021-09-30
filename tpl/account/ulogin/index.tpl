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

{include file='account/ulogin/_box.tpl'}

{include file='footer.tpl'}
{/strip}