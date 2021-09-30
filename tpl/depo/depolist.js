<script>
	var t0 = new Date().getTime();
	function updateDepoProgress(id, p0, dp)
	{
		v = p0 + dp*(new Date().getTime() - t0)/1000/60/60;
		if (v>100)
			v = 100;
		$('#progress'+id).html(v.toFixed(2)+'%');
	}
	function updateDepoProfit(id, z0, dz)
	{
		v = z0 + dz*(new Date().getTime() - t0)/1000/60/60;
		$('#profit'+id).html(v.toFixed(6));
	}
</script>