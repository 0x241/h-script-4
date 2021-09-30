{strip}
{if $_info}
	{include file='info.messages.tpl'}
	{if $info_msg[$_info[0]]}
		<div id="info_box" class="flash_{if substr($_info[0], 0, 1) == '*'}error{else}info{/if}">
			<b>{$info_msg[$_info[0]]}</b>
			{if (substr($_info[0], 0, 1) == '*') and !is_array($_info[1])}
				<br>{$info_msg['*ErrorCode']} {$_info[1]}
			{/if}
		</div>
		{if substr($_info[0], 0, 1) != '*'}
			<script type="text/javascript">
				setTimeout(
					function()
					{
						$('#info_box').fadeOut('slow')
					},
					5000
				);
			</script>
		{/if}
	{/if}
{/if}
{/strip}