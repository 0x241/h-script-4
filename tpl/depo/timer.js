<script>
	var tmrs=[];

	function to2dig(v)
	{
		return (v<10?'0'+v:v);
	}

	function showtimer(did) 
	{
		document.getElementById('timer'+did).innerHTML = to2dig(tmrs[did][1] * 24 + tmrs[did][2])+':'+to2dig(tmrs[did][3])+':'+to2dig(tmrs[did][4]);
		var t=tmrs[did][1]*86400+tmrs[did][2]*3600+tmrs[did][3]*60+tmrs[did][4];
		if (t>0)
		{
			changetimer(did);
			window.setTimeout('showtimer('+did+');',1000);
		}
		else if (t<1) 
		{
			window.clearTimeout(tmrs[did][5]);
			window.location.reload(true);
		}
	}

	function changetimer(did)
	{
		tmrs[did][4]--;
		if (tmrs[did][4]<0)
		{
			tmrs[did][4]=59;
			tmrs[did][3]--;
			if (tmrs[did][3]<0) 
			{
				tmrs[did][3]=59;
				tmrs[did][2]--;
				if (tmrs[did][2]<0)
				{
					tmrs[did][2]=23;
					tmrs[did][1]--;
					if (tmrs[did][1]<0)
					{
						tmrs[did][1]=0;
						tmrs[did][2]=0;
						tmrs[did][3]=0;
						tmrs[did][4]=0;
					}
				}
			}
		}
	}

	function inittimer(did,days,hour,min,sec) 
	{
		tmrs[did] = [];
		tmrs[did][1]=Math.max(days,0);
		tmrs[did][2]=Math.max(hour,0);
		tmrs[did][3]=Math.max(min,0);
		tmrs[did][4]=Math.max(sec,0);
		tmrs[did][5]=window.setTimeout('showtimer('+did+');',1000);
	}
</script>