<?php

	if (basename($_SERVER['PHP_SELF']) == 'login.php') {
		die('You cannot load this page directly.');
	};
  
session_start(); // Starting Session
$error = ""; // Variable To Store Error Message
if (isset($_POST['login'])) {
	if (empty($_POST['username']) || empty($_POST['password'])) {
		$error = "&#149; Το όνομα χρήστη και ο κωδικός είναι υποχρεωτικά";
	}
	else
	{
		// Define $username and $password
		$username=$_POST['username'];
		$password=$_POST['password'];
		// Establishing Connection with Server by passing server_name, user_id and password as a parameter
		require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
		// To protect MySQL injection for Security purpose
		$username = stripslashes($username);
		$password = stripslashes($password);
		$username = mysqli_real_escape_string($connection, $username);
		$password = mysqli_real_escape_string($connection, $password);
		
		$username = filter_var($username, FILTER_SANITIZE_EMAIL);
		$password = sha1($password);
		
		if(!filter_var($username, FILTER_VALIDATE_EMAIL)) 
		{
			$error = "&#149; Το e-mail δεν είναι έγγυρο";
		}
		else
		{
			// Selecting Database
			mysqli_select_db($connection, "paraponaDB");
			// SQL query to fetch information of registerd users and finds user match.
			$query = "select * from Users where password='$password' AND email='$username'";
			$result = mysqli_query($connection, $query);
			$rows = mysqli_num_rows($result);
			$rowContent = mysqli_fetch_array($result, MYSQLI_BOTH);
			if ($rows == 1) {
				$_SESSION['login_user']=$username; // Initializing Session
				//header("location: /login/profile.php"); // Redirecting To Other Page
				$success = "Η σύνδεση έγινε με επιτυχία ως ";
				($rowContent['Admin']==1 ? ($_SESSION['Admin']=1 AND $success = "Καλώς ορίσατε διαχειριστή ") : $_SESSION['Admin']=0);
			}
			else
			{
				$error = "&#149; Το όνομα χρήστη ή ο κωδικός δεν ήταν σωστό";
			}
		}
		mysqli_close($connection); // Closing Connection
	}
}
?>