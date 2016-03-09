<?php

	if (basename($_SERVER['PHP_SELF']) == 'PermissionChange.php') {
		die('You cannot load this page directly.');
	};

if (isset($_POST['PermChange'])) 
{
	require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
	mysqli_select_db($connection, "paraponaDB");
	
	if(isset($_POST['PermBox']))
	{
		$query = "UPDATE Permissions SET Flag=1 WHERE PermissionFor='" . $_POST['PermBox'] . "'";
	}
	else
	{
		//$query = "UPDATE Permissions SET Flag=0 WHERE PermissionFor='" . $_POST['PermBox'] . "'";
		$query = "UPDATE Permissions SET Flag=0 WHERE PermissionFor='ComplaintDelete'";
	}
	
	$result = mysqli_query($connection, $query);
	
	($result==1 ? $success = "Τα δικαιώματα άλλαξαν με επιτυχία" : "");
	
	mysqli_close($connection);
}

?>