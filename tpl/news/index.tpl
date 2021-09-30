{strip}
{include file='header.tpl' title=$_TRANS['News']}

<h1>{$_TRANS['News']}</h1>

{if $list}
	<table class="formatTable" width="600px">
	{foreach name=list from=$list key=id item=l}
		<tr>
			<td>
				<h2>{$l.nTopic}</h2>
				<small>{$l.nTS}</small>
				{if $l.nAttn}&nbsp;&nbsp;&nbsp;<b style="color: red;">{$_TRANS['Important']}!</b>{/if}
				<div style="padding: 10px; background-color: #F3F3F3;">
					{$l.nAnnounce|nl2br}
				</div>
				<div style="text-align: right;">
					<a href="{_link module='news/show' chpu=[$l.nID, $l.nTopic]}"><small>{$_TRANS['read more']}</small></a>
				</div>
			</td>
		</tr>
	{/foreach}
	</table>
	{include file='pl.tpl'}
	<br>
{/if}

{include file='footer.tpl'}
{/strip}