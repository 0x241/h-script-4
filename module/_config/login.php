<?php

if (isset($_GET['out']))
{
	session_destroy();
	session_start();
	goToURL($_cfg['cfg_link']);
}

if (!$pass)
{
	$_SESSION['cfg_logged'] = 1;
	goToURL($_cfg['cfg_link']);
}
if (isset_IN('bLogin'))
{
	if (md5($_GS['domain'] . _IN('pass')) == $pass)
	{
		$_SESSION['cfg_logged'] = 1;
		goToURL($_cfg['cfg_link']);
	}
	else
		addMsg('Wrong password');
}

include('module/_config/_header.php');

?>

<h1>Login</h1>

<table width="300px" border="0" align="center">
<tr>
	<td align="center">
		<form method="post">
			<fieldset>
				password<br>
				<input name="pass" value="" type="password"><br>
			</fieldset>
			<br>
			<input name="bLogin" value="Login" type="submit">
		</form>
	</td>
</tr>
</table>

<?php

include('module/_config/_footer.php');
	
?>