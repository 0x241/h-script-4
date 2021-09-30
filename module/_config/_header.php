<html>
	<head>
		<title>Configurator</title>
	</head>
	<body>
		<center>
			<?php if ($_SESSION['cfg_logged']) { ?>
			<div>
				<a href="?modules">Modules</a> |
				<a href="?update" onClick="return confirm('Start database structure update?');">Update</a> |
				<a href="?install">Install</a> |
				<a href="?setup">Setup</a> |
				<a href="?pass">Change password</a> |
				<a href="?login&out">Logout</a>
			</div>
			<?php } showMsg(); ?>