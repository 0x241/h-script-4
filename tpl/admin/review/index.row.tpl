{strip}
<td>
    {$l.oID}
</td>
<td class="nowrap">
    <small>{$l.oTS}</small>
</td>
<td>
    <a href="{_link module='account/admin/user'}?id={$l.ouID}">{$l.uLogin}</a>
</td>
<td>
    <small>{$l.oText}</small>
</td>
<td>
    {if $l.oState}{$_AT['Yes']}{/if}
</td>
<td>
    {$l.oOrder}
</td>
{/strip}