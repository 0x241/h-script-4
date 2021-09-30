{strip}

{if $up_category}
	<h1>{$up_category}</h1>

	<div class="_menuPanel">
		<ul class="mainMenu">
			{foreach name=cc from=$up_modules key=n item=m}
				{include file='menu.element.tpl' module=$m text=$n}
			{/foreach}
		</ul>
	</div>
	<br>
{/if}

{/strip}