{strip}
{include file='header.tpl' title=$_TRANS['Support'] class="static"}

<h1>{$_TRANS['Support request']}</h1>

{if isset($smarty.get.done)}

	<h2>{$_TRANS['Your request has been sent successfully to support!']}</h2>
    <p class="info">
        {$_TRANS['The administrator will respond to you within 24 hours']}
    </p>

{else}

	{include file='message/support.box.tpl'}

{/if}

{include file='footer.tpl' class="static"}
{/strip}