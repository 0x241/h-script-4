{strip}

{if $pform.html}

	<br>
	<center>
	{$pform.html}
	</center>

{elseif $pform.url}

	<br>
	<center>
	<form method="{if $pform.get}get{else}post{/if}" action="{$pform.url}" name="pay_form">
		{foreach from=$pform key=f item=v}
			{if ($f != 'url') and ($f != 'get')}
				<input name="{$f}" value="{$v}" type="hidden">
			{/if}
		{/foreach}
		<input value="{if $btn_text}{$btn_text}{else}{$_TRANS['To payment system']}{/if}" type="submit" class="button-green">
	</form>
	{if isset($smarty.get.pay)}
		<script type="text/javascript">
			document.pay_form.submit();
		</script>
	{/if}
	</center>

{/if}

{/strip}