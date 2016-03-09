<?php

	if (basename($_SERVER['PHP_SELF']) == 'newCategory.php') {
		die('You cannot load this page directly.');
	};

if (isset($_POST['newCategory'])) {
	require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
	mysqli_select_db($connection, "paraponaDB");
	mysqli_query($connection, "SET CHARACTER SET 'utf8'");
	
	$query = "SELECT * FROM Categories WHERE category = '". $_POST['category'] . "'";
	$result = mysqli_query($connection, $query);
	$rows = mysqli_num_rows($result);
	
	if($rows==1) 
	{
		$error = '&#149; Υπάρχει ήδη η κατηγορία "' . $_POST["category"] . '"';
	}
	else
	{
		$query = "INSERT INTO Categories (category) VALUES ('" . $_POST['category'] . "')"; 
		$result = mysqli_query($connection, $query);
		($result==1 ? $success = "Η εγγραφή κατηγορίας έγινε με επιτυχία" : "");
	}
	
	mysqli_close($connection);
}

?>