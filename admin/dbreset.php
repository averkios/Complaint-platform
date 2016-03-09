<?php
    if (basename($_SERVER['PHP_SELF']) == 'dbreset.php') { 
	    die('You cannot load this page directly.');
    };
    
    if (isset($_POST['dbreset'])) 
    {
    	$error="";
		require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');	
	
		$query = "DROP DATABASE paraponaDB";
		$result = mysqli_query($connection, $query);
		
		if($result==0)
		{
			$error .= "Δεν ήταν δυνατή η διαγραφή της παλιάς βάσης</br>";
		}
		
		$query = "CREATE DATABASE paraponaDB
				  DEFAULT CHARACTER SET utf8
				  DEFAULT COLLATE utf8_unicode_ci";
			  
		$result = mysqli_query($connection, $query);
		
		if($error=="" && $result==0)
		{
			$error .= "Δεν ήταν δυνατή η δημιουργία της νέας βάσης</br>";
		}
		
		mysqli_select_db($connection, "paraponaDB");
	
		$query = "
				CREATE TABLE Users
				(
				LastName varchar(255),
				FirstName varchar(255),
				email varchar(255) NOT NULL,
				password varchar(255) NOT NULL,
				Address varchar(255),
				Phone varchar(10),
				Guest BOOLEAN DEFAULT TRUE,
				Admin BOOLEAN DEFAULT FALSE,
				PRIMARY KEY (email)
				)
		";
		
		$result = mysqli_query($connection, $query);
		
		if($error=="" && $result==0)
		{
			$error .= "Δεν ήταν δυνατή η δημιουργία πίνακα Users</br>";
		}
	
		$query = "
				CREATE TABLE Categories
				(
				Ca_Id int NOT NULL AUTO_INCREMENT,
				category varchar(255),
				PRIMARY KEY (Ca_Id)
				)
		";
		
		$result = mysqli_query($connection, $query);
		
		if($error=="" && $result==0)
		{
			$error .= "Δεν ήταν δυνατή η δημιουργία πίνακα Categories</br>";
		}
		
		$query = "
				CREATE TABLE Complaints
				(
				Co_Id int NOT NULL AUTO_INCREMENT,
				email varchar(255) NOT NULL,
				category int NOT NULL,
				content varchar(255),
				date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY (Co_Id),
				FOREIGN KEY (email) REFERENCES Users(email) ON DELETE CASCADE,
				FOREIGN KEY (category) REFERENCES Categories(Ca_Id) ON DELETE CASCADE
				)
		";
		
		$result = mysqli_query($connection, $query);
		
		if($error=="" && $result==0)
		{
			$error .= "Δεν ήταν δυνατή η δημιουργία πίνακα Complaints</br>";
		}
		
		$query = "
				CREATE TABLE Permissions
				(
				PermissionFor varchar(255) NOT NULL,
				Flag BOOLEAN DEFAULT TRUE,
				PRIMARY KEY (PermissionFor)
				)
		";
		
		$result = mysqli_query($connection, $query);	
		
		if($error=="" && $result==0)
		{
			$error .= "Δεν ήταν δυνατή η δημιουργία πίνακα Permissions</br>";
		}
		
		$query = "
				INSERT INTO Permissions 
				(PermissionFor, Flag)
				VALUES ('ComplaintDelete', 1)
		";
		
		$result = mysqli_query($connection, $query);
		
		if($error=="" && $result==0)
		{
			$error .= "Δεν ήταν δυνατή η εισαγωγή στοιχείων στον πίνακα Permissions</br>";
		}
		
		$query = "
				INSERT INTO Users 
				(LastName, FirstName, email, password, address, Phone, Guest, Admin)
				VALUES ('Felonius','Gru','gru@evil.com','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','Villain City','2254354320',0,1)
		";
		
		$result = mysqli_query($connection, $query);
		
		if($error=="" && $result==0)
		{
			$error .= "Δεν ήταν δυνατή η εισαγωγή στοιχείων στον πίνακα Users</br>";
		}
		
		$query = "SET GLOBAL time_zone = '+2:00'";
		
		$result = mysqli_query($connection, $query);
		
		if($error=="")
		{
			$success = "Η επαναφορά έγινε με επιτυχία";
		}
		
		mysqli_close($connection);

	}
?>