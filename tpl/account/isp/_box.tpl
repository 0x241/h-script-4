<script>

function isp_login_popup() {
	var url = 'http://login.investorsstartpage.com/json.aspx';
	var w = 600;
	var h = 500;
	var left = (screen.width / 2) - (w / 2);
	var top = (screen.height / 2) - (h / 2);
	return window.open(
		url + '?domain=' + window.location.hostname,
		'ISP Login',
		'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left
	);
}

window.addEventListener('message', function(evt){
	if ( evt.origin.indexOf('//login.investorsstartpage.com') >= 0 )
	{
		{literal}if ( unescape(evt.data).indexOf('{') == 0 ) { {/literal}
			$.post(
				"{FullURL(moduleToLink('account/isp'))}",
				{ isp_profile: unescape(evt.data) }
			).done( function(data) {
				// TODO: redirect to cabinet
				window.location.href = '{moduleToLink('cabinet')}';
			});
		}

	}
});

</script>
<button onclick="isp_login_popup()">Login via InvestorsStartPage.com</button>