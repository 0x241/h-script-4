{strip}
<td>
	{$l.uLogin}
</td>
<td>
	{$l.uMail}
</td>
<td class="nowrap">
	<small>{$l.aCTS}</small>
</td>
{foreach $vcurrs as $curr => $cids}
<td align="right">
	{_z($list2[$curr][$l.uID]['ZDepo'], $curr)}
</td>
{/foreach}
{foreach $vcurrs as $curr => $cids}
<td align="right">
	{_z($list[$l.uID]["Sum$curr"], $curr)}
</td>
{/foreach}
{/strip}