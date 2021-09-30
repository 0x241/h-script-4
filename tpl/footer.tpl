{strip}
	{if !$short}
				</div>
			</td>
			{if $_cfg.UI_RightPanel}
				<td class="_panel">
					{include file='panel.right.tpl'}
				</td>
			{/if}
		</tr>
		</table>
		{if $_cfg.UI_BottomPanel}
			{include file='panel.bottom.tpl'}
		{/if}
		</div>
		{include file='line.bottom.tpl'}
	{/if}
	</center></body>
</html>
{/strip}