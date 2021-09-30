{strip}
{include file='header.tpl' title=$_TRANS['Main'] class="splash"}

<h1>{$_TRANS['Main']}</h1>

{if $demo}

    <p class="info">
        {$_TRANS['Script works in <b>demo</b> mode.<br>Some functions are disabled']}
    </p>

{/if}

{$_TRANS['Current language folder']}: <a href="{_link module='system'}">{$current_lang}</a>

{include file='footer.tpl' class="splash"}
{/strip}