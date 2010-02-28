<?php
	//Start a session to facilitate storing device data in the session which vastly improves performance.
	session_start();
	include "dtd.xhtml-mp.php";
	include "functions.php";
?>
<head>
	<?php
		include "style.css";
	?>
	<title>
	<?php
			echo $title;
	?>
	</title>
</head>
<body>
	<div class="header">
	<?php
			echo $header;
	?>
	</div>
