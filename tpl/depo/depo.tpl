{strip}
{include file='header.tpl' title=$_TRANS['Deposit'] class="cabinet"}

{if $el}

    <h1>{$_TRANS['Deposit']}</h1>
    {include file='depo/_depo.tpl'}

{else}

	{include file='balance/_bal.tpl'}

    <h1>{$_TRANS['New deposit']}</h1>
    {include file='depo/_depo.interval.tpl'}
    {include file='depo/_depo.new.tpl'}

{/if}

{include file='footer.tpl' class="cabinet"}
{/strip}