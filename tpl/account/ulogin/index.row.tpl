{strip}
<td>
    <image src="//favicon.yandex.net/favicon/{getDomain($l.url)}">
</td>
<td>
    <a href="{$l.url}" target="_blank">{getDomain($l.url)}</a>
</td>
<td>
    <a href="{$_selfLink}?sub={base64_encode($l.url)}" onClick="return confirm('{$_TRANS['Confirm detachment account']} \'{getDomain($l.url)}\'');"><small>{$_TRANS['detach']}</small></a>
</td>
{/strip}