{strip}
{include file='header.tpl' title=$_TRANS['Support'] class="cabinet"}

{include file='tickets/_states.tpl'}

{include file='list.tpl'
    title=$_TRANS['Tickets']
    fields=[
        'tLTS'=>[$_TRANS['Date']],
        'tTopic'=>[$_TRANS['Subject']],
        'tState'=>[$_TRANS['Status']],
        'cnt'=>[$_TRANS['Answers']]
    ]
    values=$list
    row='*'
}

<a href="{_link module='tickets/ticket'}?add" class="button-green">{$_TRANS['Create']}</a><br>

{include file='footer.tpl' class="cabinet"}
{/strip}