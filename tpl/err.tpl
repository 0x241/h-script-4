{strip}
{$error_text='' scope='global'}
{$error_class='' scope='global'}
{if $errs and (count($tpl_errors[$form]) > 0)}
	{foreach from=$errs key=i item=e}
		{if in_array($i, $tpl_errors[$form])}
			{$error_text="{$error_text}$e<br>" scope='global'}
			{$error_class='error' scope='global'}
			{$tpl_errors[$form][array_search($i, $tpl_errors[$form])] = NULL scope='global'}
		{/if}
	{/foreach}
	{assign var='error_text' value="<span class=\"err\">{$error_text}</span>" scope='global'}
{/if}
{/strip}