{*strip*}

<table class="styleTable" border="0" cellspacing="0" cellpadding="0">
<tr>
	<th colspan="2">
		{$_TRANS['Plan']} '<span id="plan">?</span>'
	</th>
</tr>
<tr>

	<td>
		{$_TRANS['Bonus']}
	</td>
	<td align="right" width="60px">
		<span id="bonus">?</span>%
	</td>
</tr>

<tr>
	<td>
		{$_TRANS['Accrual']}
	</td>
	<td align="right">
		<span id="profit">?</span>%
	</td>
</tr>

<tr>
	<td>
		{$_TRANS['Accruals count']}
	</td>
	<td align="right">
		<span id="period">?</span>
	</td>
</tr>
<tr>
	<td>
		{$_TRANS['Duration, days']}
	</td>
	<td align="right">
		<span id="days">?</span>
	</td>
</tr>
<tr>
	<td>
		{$_TRANS['Compaund']}
	</td>
	<td align="right">
		<span id="cmpd">?</span>%
	</td>
</tr>
<tr>
	<td>
		{$_TRANS['Total profit']}
	</td>
	<td align="right">
		<span id="prib">?</span>
	</td>
</tr>
<tr>
	<td>
		{$_TRANS['Deposit return']}
	</td>
	<td align="right">
		<span id="return">?</span>%
	</td>
</tr>
<tr>
	<td>
		{$_TRANS['Total returns']}
	</td>
	<td align="right">
		<b><span id="prib2">?</span></b>
	</td>
</tr>
</table>

<script>
	function round2(z)
	{
		z = (1*z).toFixed(2);
		return 1*z;
	}
	function recalc()
	{
		var sum=round2(document.forms['calc']['sum'].value.replace(',', '.'));
        var currency_payment=document.forms['calc']['currency_payment'].value;
		var sum2=sum*currency_payment;
		var prib=0;

{*
		var cmpd=0;
		var radios=document.getElementsByName('cmpd');
		for (i=0; i<radios.length; i++)
			if (radios[i].checked)
			{
				cmpd=radios[i].value;
				break;
			}
*}
		var cmpd=document.forms['calc']['cmpd'];
		if (cmpd==undefined)
		{
			cmpd=0;
		}
		else
		{
			cmpd=cmpd.value;
		}
		document.getElementById('cmpd').innerHTML=cmpd;
		var days=document.forms['calc']['days'];
		if (days==undefined)
		{
			days=0;
		}
		else
		{
			days=days.value;
		}
		var plans=[{$calc_plans}];
		var pn='?';
		var pd='?';
		var ip='?';
		var db='?';
		var dr='?';
		var dd='?';
		var p=document.forms['calc']['plan'];
		if (p==undefined  || p.value == -1)
		{
			for (var p in plans)
            {
				if ((sum2>=plans[p][1]) & (sum2<plans[p][2]))
				{
					pn=plans[p][0];
					pd=plans[p][3];
					ip=plans[p][4];
					db=plans[p][5];
					dr=plans[p][6];
					dd=plans[p][7];
					$("#calc_plan").val(p);
					break;
				}
            }
		}
		else
		{
			p=p.value;
			pn=plans[p][0];
			pd=plans[p][3];
			ip=plans[p][4];
			db=plans[p][5];
			dr=plans[p][6];
			dd=plans[p][7];

		}

		if (pn!='?')
		{
			if (ip == 0)
			{
			    if ($("#period_val").val()>0)
                {
                   ip = parseInt($("#period_val").val()); 
                }
                else
                {
                   ip = days; 
                }
				dd = round2(ip*dd);
                $("#period_div").show();  
			}
            else
            {
				dd = round2(ip*dd);
               $("#period_div").hide();     
            }
		}
				
        if ((sum2>=plans[p][1]) & (sum2<plans[p][2]))
		{
			sum=round2(sum+db*sum/100);
			zcomp=0;
			for (i=0; i<ip; i++)
			{
				profit=parseFloat(round2(pd*sum/100));
                csum=parseFloat(round2(cmpd*profit/100));
				zcomp=parseFloat(round2(zcomp+csum));
				prib=parseFloat(round2(prib+profit-csum));
				sum=parseFloat(round2(sum+csum));
			}
			sum=round2(dr*(sum-zcomp)/100);
            
            document.getElementById('plan').innerHTML=pn;
		    document.getElementById('bonus').innerHTML=db;
	    	document.getElementById('profit').innerHTML=pd;
		    document.getElementById('period').innerHTML=ip;
	    	document.getElementById('days').innerHTML=dd;
	    	document.getElementById('prib').innerHTML=round2(prib+zcomp);
	    	document.getElementById('return').innerHTML=dr;
	    	document.getElementById('prib2').innerHTML=round2(sum+prib+zcomp);
            
		}
        else
        {
           	document.getElementById('plan').innerHTML='';
		    document.getElementById('bonus').innerHTML='';
	    	document.getElementById('profit').innerHTML='';
		    document.getElementById('period').innerHTML='';
		    document.getElementById('days').innerHTML='';
	    	document.getElementById('prib').innerHTML='';
	    	document.getElementById('return').innerHTML='';
		    document.getElementById('prib2').innerHTML='';

{*            if (currency_payment != '' && currency_payment != '0')
            {
               alert("Подходящий план не найден");
            }*}
        }
	}

	recalc();

    $( document ).ready(function() {
{*        $("#calc_plan").val(-1);
        
        $( "#calc_sum" ).keyup(function() {
            $("#calc_plan").val(-1);
            recalc();
        });*}
        $( "#calc_currency_payment" ).change(function() {
            recalc();
        });
        $( "#calc_plan" ).change(function() {
            recalc();
        });
    });
</script>

{*/strip*}