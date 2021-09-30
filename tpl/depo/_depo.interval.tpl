{strip}

{if $_cfg.Depo_Interval > 0}

    <p class="info">
        {if $nextdepoleft > 0}
            {$_TRANS['Estimated time of deposit activation']} - <b>{$nextdepotime}</b><br>
            ({$_TRANS['approximately']} {$nextdepoleft} {$_TRANS['min']}.)
        {else}
            {$_TRANS['Your deposit will be activated <b>immediately</b>']|html_entity_decode}
        {/if}
    </p>

{/if}

{/strip}