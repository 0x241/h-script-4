{strip}
{include file='err.tpl' errs=['captcha_wrong'=>'неверный код']}
{if $class}
	{$class = " {$class}"}
{/if}
{$class = "captcha{$class}{$error_class}"}
{include file='captcha/box.tpl'}
{/strip}