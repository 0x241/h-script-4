<?php

if (isset_IN('bSave')) 
{

	if ($f = fopen('module/_config/pass', 'w'))
	{
		fputs($f, md5($_GS['domain'] . _IN('newPass')));
		fclose($f);
		addMsg('Password saved!');
		goToURL($_cfg['cfg_link'] . '?setup');
	} else
		addMsg("Can't open file for writing");
}

include('module/_config/_header.php');

?>

<h1>Change password</h1>

<table width="300px" border="0" align="center">
<tr>
	<td align="center">
		<form method="post">
			<fieldset>
				new password<br>
				<input name="newPass" value="" type="password"><br>
			</fieldset>
			<br>
			<input name="bSave" value="Save" type="submit">
		</form>
	</td>
</tr>
</table>

<?php

include('module/_config/_footer.php');
	
?>