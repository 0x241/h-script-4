{strip}
{if in_array($oper, array('CASHIN', 'CASHOUT', 'EX', 'TR', 'SELL'))}

<script type="text/javascript">
	function showComis()
	{
		$('#csum').html('');
		{if $use_sum2}
			$('#sum2').html('');
		{/if}
		$.ajax(
			{
				type: 'POST',
				url: 'ajax',
				data: 'module=balance&do=getsum'+
					'&oper='+$('#add_Oper').val()+
					'&cid='+$('#add_PSys').val()+
					'&sum='+$('#add_Sum').val(){if $oper == 'EX'}+'&cid2='+$('#add_PSys2').val(){/if},
				success: 
					function(ex)
					{
						ex=eval(ex);
						/*$('#ccurr').html(ex[0]);*/
						$('#csum').html(ex[1]);
						{if $use_sum2}
							$('#sum2').html(ex[2]);
						{/if}
					}
			}
		);
	}
	tid=0;
	tf=function()
	{
		clearTimeout(tid);
		tid=setTimeout(function(){ showComis(); }, 200);
	};
	$('#add_PSys').change(tf);
	//$('#add_Sum').keypress(tf);
	{if $oper == 'EX'}
		$('#add_PSys2').change(tf);
	{/if}
	showComis();
</script>

{/if}
{/strip}