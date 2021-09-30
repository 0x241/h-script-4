function setchkbox(n,p) {
	var chk=document.getElementById(n).checked;
	var i=1;
	while (c=document.getElementById(p+i)) {
		c.checked=chk;
		i++;
	}
}

function swchkbox(p) {
	var i=1;
	while (c=document.getElementById(p+i)) {
		c.checked=!c.checked;
		i++;
	}
}