<?php

	if (basename($_SERVER['PHP_SELF']) == 'dbconnect.php') {
		die('You cannot load this page directly.');
	};
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/credentials.php');
	$connection = mysqli_connect($DBserver, $DBuser, $DBpassword) or die("Error: " . mysqli.error($connection));

?>
