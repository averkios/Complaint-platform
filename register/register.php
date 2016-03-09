<?php
	if (basename($_SERVER['PHP_SELF']) == 'register.php') {
		die('You cannot load this page directly.');
	};
//session_start(); // Already Initialised by Include
//$error = ""; // Already Initialised by Include
if (isset($_POST['register'])) {
	if (/*empty($_POST['lastname']) || empty($_POST['firstname']) || */empty($_POST['username']) || empty($_POST['address']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['password2'])) {
		$error = "&#149; Τα υποχρεωτικά πεδία πρέπει να συμπλήρωθούν !";
	}
	else
	{
		// Define $username and $password
		$lastname=$_POST['lastname'];
		$firstname=$_POST['firstname'];
		$username=$_POST['username'];
		$address=$_POST['address'];
		$phone=$_POST['phone'];
		$password=$_POST['password'];
		$password2=$_POST['password2'];
		// Establishing Connection with Server by passing server_name, user_id and password as a parameter
		require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
		// To protect MySQL injection for Security purpose
		$lastname = stripslashes($lastname);
		$firstname = stripslashes($firstname);
		$username = stripslashes($username);
		$address = stripslashes($address);
		$phone = stripslashes($phone);
		//$password = stripslashes($password);
		//no need cause password is hashed
		
		$lastname = mysqli_real_escape_string($connection, $lastname);
		$firstname = mysqli_real_escape_string($connection, $firstname);
		$username = mysqli_real_escape_string($connection, $username);
		$address = mysqli_real_escape_string($connection, $address);
		$phone = mysqli_real_escape_string($connection, $phone);
		//$password = mysql_real_escape_string($password);
		
		$lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
		$firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
		$username = filter_var($username, FILTER_SANITIZE_EMAIL);
		//$address = filter_var($address, FILTER_SANITIZE_NUMBER_INT);
		//$phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
		
		/*if($lastname == "") 
		{
			$error = "&#149; Please enter a valid last name</br>";
		}
		if($firstname == "") 
		{
			$error .= "&#149; Please enter a valid name</br>";
		}
		*/
		if(!filter_var($username, FILTER_VALIDATE_EMAIL)) 
		{
			$error .= "&#149; Το e-mail δεν είναι έγγυρο</br>";
		}
		if(!filter_var($address, FILTER_VALIDATE_INT)) 
		{
			$error .= "&#149; Ο ταχυδρομικός κώδικας δεν είναι έγγυρος</br>";
		}
		elseif (strlen($address) < 5)
		{
			$error .="&#149; Ο ταχυδρομικός κώδικας δεν μπορεί να είναι λιγότερο από 5 χαρακτήρες</br>";
		}
		elseif (strlen($address) > 5)
		{
			$error .="&#149; Ο ταχυδρομικός κώδικας δεν μπορεί να είναι περισσότερο από 5 χαρακτήρες</br>";
		}
		if(!filter_var($phone, FILTER_VALIDATE_INT)) 
		{
			$error .= "&#149; Ο αριθμός τηλεφώνου δεν είναι έγγυρος</br>";
		}
		elseif (strlen($phone) < 10)
		{
			$error .="&#149; Ο αριθμός τηλεφώνου δεν μπορεί να είναι λιγότερο από 10 χαρακτήρες</br>";
		}
		elseif (strlen($phone) > 10)
		{
			$error .="&#149; Ο αριθμός τηλεφώνου δεν μπορεί να είναι περισσότερο από 10 χαρακτήρες</br>";
		}
		if(strcmp($password,$password2) <> 0)
		{
			$error .= "&#149; Οι κωδικοί δεν ισοδυναμούν</br>";
		}
		elseif(strlen($password) < 9)
		{
			$error .= "&#149; Ο κωδικός δεν μπορεί να είναι λιγότερο από 9 χαρακτήρες</br>";
		}
		
		$password = sha1($password);
		
		if($error=="")
		{
			// Selecting Database
			mysqli_select_db($connection, "paraponaDB");
			mysqli_query($connection, "SET CHARACTER SET 'utf8'");
			// SQL query to fetch information of registerd users and finds user match.
			//$query = mysql_query("select * from Users where password='$password' AND email='$username'", $connection);
			
			$query = "SELECT * FROM Users WHERE email='$username' AND Guest='1'";
			$result = mysqli_query($connection, $query);
			$rows = mysqli_num_rows($result);
			
			if($rows == 1)
			{
				$query = "UPDATE Users SET LastName='$lastname',FirstName='$firstname',password='$password',Address='$address',Phone='$phone',Guest='0' WHERE email='$username'";
			}
			else
			{
				
				$query = "INSERT INTO Users (LastName, FirstName, email, password, address, Phone, Guest) VALUES ('$lastname','$firstname','$username','$password','$address','$phone',0)";
			}
			
			$result = mysqli_query($connection, $query);
			
			if ($result == 1)
			{
				$_SESSION['login_user']=$username;
				$success = "Η εγγραφή έγινε με επιτυχία ως ";
			}
			else
			{
				$error = "&#149; Υπάρχει ήδη λογαριασμός με όνομα χρήστη " . $username;
			}
		}
		mysqli_close($connection); // Closing Connection
	}
}
?>