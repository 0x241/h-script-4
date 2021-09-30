{strip}
{if !$el.pDirect}
    {include file='header.tpl' title=$el.pTopic class="static"}
{/if}

<h1>{$el.pTopic}</h1>

{$el.pText}

{if !$el.pDirect}
    {include file='footer.tpl' class="static"}
{/if}
{/strip}