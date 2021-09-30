{strip}
{if $_info}
	{include file='info.messages.tpl'}
	{if $info_msg[$_info[0]]}
		<div id="edit_{$_info[0]}_info_box" class="flash_edit_{if substr($_info[0], 0, 1) == '*'}error{else}info{/if}">
			<b>{$info_msg[$_info[0]]}</b>
		</div>
		{*if substr($_info[0], 0, 1) != '*'}
			<script type="text/javascript">
				setTimeout(
					function()
					{
						$('#edit_{$_info[0]}_info_box').fadeOut('slow')
					},
					5000
				);
			</script>
		{/if*}
	{/if}
{/if}
{/strip}