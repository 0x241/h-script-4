{strip}
{include file='header.tpl' title=$_TRANS['FAQ'] class="static"}

<h1>{$_TRANS['FAQ']}</h1>

{if $list}
	{foreach name=list from=$list key=id item=l}
				<div class="question" style="cursor: pointer;">
					<h2>{$l.fQuestion}</h2>
				</div>
				<div style="padding: 10px; display: none;">
					{if $l.fCat}<small>{$l.fCat}</small><br>{/if}
					{$l.fAnswer}
				</div>
	{/foreach}
	{include file='pl.tpl'}
	<br>
{/if}

<script type="text/javascript">
	$('.question').next().hide();
	$('.question').click(
		function()
		{
			$(this).next().slideToggle();
	    }
	);
</script>

{include file='footer.tpl' class="static"}
{/strip}