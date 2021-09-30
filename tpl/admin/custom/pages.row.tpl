{strip}
<td>
    {$l.pID}
</td>
<td>
    <a href="{_link module='custom/admin/page'}?id={$l.pID}">{$l.pTopic}</a>
</td>
<td>
    {if $l.pHidden}{$_AT['Yes']}{/if}
</td>
<td>
    {$link = fullURL(moduleToLink('custom', array($l.pID, $l.pTopic)))}
    <a href="{_link module='custom' chpu=[$l.pID, $l.pTopic]}" target="_blank">{$link}</a>
</td>
{/strip}