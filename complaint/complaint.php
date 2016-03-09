<?php
//session_start(); // Already Initialised by Include
//$error = ""; // Already Initialised by Include
	if (basename($_SERVER['PHP_SELF']) == 'complaint.php') {
		die('You cannot load this page directly.');
	};
if (isset($_POST['newComplaint'])) {
	if ( ( !isset($_SESSION['login_user']) && empty($_POST['username']) ) || empty($_POST['category']) || empty($_POST['complaint']) ) {
			$error = "&#149; Τα υποχρεωτικά πεδία πρέπει να συμπλήρωθούν !";
	}
	else
	{
		// Define $username and $password
		$lastname=$_POST['lastname'];
		$firstname=$_POST['firstname'];
		(isset($_SESSION['login_user']) ? $username=$_SESSION['login_user'] : $username=$_POST['username']);
		$category=$_POST['category'];
		$complaint=$_POST['complaint'];
		
		require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
		
		// To protect MySQL injection for Security purpose
		$lastname = stripslashes($lastname);
		$firstname = stripslashes($firstname);
		$username = stripslashes($username);
		$category = stripslashes($category);
		$complaint = stripslashes($complaint);
		//$password = stripslashes($password);
		
		$lastname = mysqli_real_escape_string($connection, $lastname);
		$firstname = mysqli_real_escape_string($connection, $firstname);
		$username = mysqli_real_escape_string($connection, $username);
		$category = mysqli_real_escape_string($connection, $category);
		$complaint = mysqli_real_escape_string($connection, $complaint);
		//$password = mysql_real_escape_string($password);
		
		$lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
		$firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
		$username = filter_var($username, FILTER_SANITIZE_EMAIL);
		//$address = filter_var($address, FILTER_SANITIZE_NUMBER_INT);
		//$phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
		
		/*if($lastname == "") 
		{
			$error = "&#149; Το επώνυμο δεν είναι έγγυρο</br>";
		}
		if($firstname == "") 
		{
			$error .= "&#149; Το όνομα δεν είναι έγγυρο</br>";
		}
		*/
		if(!filter_var($username, FILTER_VALIDATE_EMAIL)) 
		{
			$error .= "&#149; Το e-mail δεν είναι έγγυρο</br>";
		}
		if(!filter_var($category, FILTER_VALIDATE_INT)) 
		{
			$error .= "&#149; Η κατηγορία δεν είναι έγγυρη</br>";
		}
		if($complaint == "") 
		{
			$error .= "&#149; Η Καταγγελία δεν μπορεί να είναι κενή</br>";
		}
		
		if($error=="")
		{
			// Selecting Database
			mysqli_select_db($connection, "paraponaDB");
			mysqli_query($connection, "SET CHARACTER SET 'utf8'");
			// SQL query to fetch information of registerd users and finds user match.
			//$query = mysql_query("select * from Users where password='$password' AND email='$username'", $connection);
			//$queryFind = mysql_query("SELECT EXISTS(SELECT * FROM Users WHERE email='$username');");
			
			if (!isset($_SESSION['login_user'])) 
			{
				$queryGuest = "INSERT INTO Users (LastName, FirstName, email, Guest) VALUES ('$lastname','$firstname','$username',1)";
				$result = mysqli_query($connection, $queryGuest);
			}
			
			$query = "INSERT INTO Complaints (email, category, content) VALUES ( (SELECT email from Users WHERE email='$username'),(SELECT Ca_Id from Categories WHERE Ca_Id='$category'),'$complaint')";
			$result = mysqli_query($connection, $query);
			
			//$rows = mysql_num_rows($query);
			if ($result == 1) 
			{
				$success = "Η καταχώρηση έγινε με επιτυχία ως ";
			}
			else
			{
				$error = "&#149; Η καταχώρηση απέτυχε";
			}
		}
		mysqli_close($connection);
	}
}
?>