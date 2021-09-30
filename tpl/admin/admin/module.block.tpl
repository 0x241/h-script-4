{strip}

{if $modules}
	<h1>{exValue('Прочие', $modules_cat)}</h1>

	<table class="formatTable">
	<tr>
	{foreach name=cc from=$modules key=n item=m}
		{if ($smarty.foreach.cc.iteration % 6) == 0}
			</tr>
			<tr>
		{/if}
		<td width="100px" align="center">
			<a href="{_link module=$m}">
				<img src="images/module.png"><br>
				{$n}
			</a>
		</td>
	{/foreach}
	</tr>
	</table>
	<br>
{/if}

{/strip}