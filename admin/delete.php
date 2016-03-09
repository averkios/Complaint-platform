<?php

	if (basename($_SERVER['PHP_SELF']) == 'delete.php') {
		die('You cannot load this page directly.');
	};

if (isset($_POST['delete'])) 
{
	require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
	mysqli_select_db($connection, "paraponaDB");
	
	$success = "";
	if (isset($_POST['delboxUsr']))
	{
		$DelUsers = count($_POST['delboxUsr']);
		($DelUsers == 1 ? $success .= "&#149;Διαγράφηκε " . $DelUsers . " Χρήστης<br/>" : $success .= "&#149;Διαγράφηκαν " . $DelUsers . " Χρήστες<br/>");
		foreach($_POST['delboxUsr'] as $selected) 
		{	
			$query = "DELETE FROM Users WHERE Users.email = '" . $selected . "'"; 
			$result = mysqli_query($connection, $query);
		}
	}
	
	if (isset($_POST['delboxGuest']))
	{
		$DelGuests = count($_POST['delboxGuest']);
		($DelGuests == 1 ? $success .= "&#149;Διαγράφηκε " . $DelGuests . " Φιλοξενούμενος<br/>" : $success .= "&#149;Διαγράφηκαν " . $DelGuests . " Φιλοξενούμενοι<br/>");
		foreach($_POST['delboxGuest'] as $selected) 
		{	
			$query = "DELETE FROM Users WHERE Users.email = '" . $selected . "'"; 
			$result = mysqli_query($connection, $query);
		}
	}
	
	if (isset($_POST['delboxComp']))
	{
		$DelComplaints = count($_POST['delboxComp']);
		($DelComplaints == 1 ? $success .= "&#149;Διαγράφηκε " . $DelComplaints . " Παράπονο<br/>" : $success .= "&#149;Διαγράφηκαν " . $DelComplaints . " Παράπονα<br/>");
		foreach($_POST['delboxComp'] as $selected) 
		{	
			$query = "DELETE FROM Complaints WHERE Complaints.Co_Id = " . $selected;
			$result = mysqli_query($connection, $query);
		}
	}
	
	if (isset($_POST['delboxCa']))
	{
		$DelCategory = count($_POST['delboxCa']);
		($DelCategory == 1 ? $success .= "&#149;Διαγράφηκε " . $DelCategory . " Κατηγορία<br/>" : $success .= "&#149;Διαγράφηκαν " . $DelCategory . " Κατηγορίες<br/>");
		foreach($_POST['delboxCa'] as $selected) 
		{	
			$query = "DELETE FROM Categories WHERE Categories.Ca_Id = " . $selected;
			$result = mysqli_query($connection, $query);
		}
	}
	
	if(empty($success))
	{
		$error = "&#149;Δεν επιλέξατε τίποτα";
	}
	
	mysqli_close($connection);
}

if (isset($_POST['complaintDelUsr']))
{
	require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
	mysqli_select_db($connection, "paraponaDB");
	
	if (isset($_POST['delboxComplaintUsr']))
	{
		$DelComplaintUsr = count($_POST['delboxComplaintUsr']);
		($DelComplaintUsr == 1 ? $success .= "&#149;Διαγράφηκε " . $DelComplaintUsr . " Παράπονο ως " : $success .= "&#149;Διαγράφηκαν " . $DelComplaintUsr . " Παράπονα ως ");
		foreach($_POST['delboxComplaintUsr'] as $selected) 
		{	
			$query = "DELETE FROM Complaints WHERE Complaints.Co_Id = " . $selected . " AND Complaints.email= '" . $_SESSION['login_user'] . "'"; 
			$result = mysqli_query($connection, $query);
		}
	}
	
	if(empty($success))
	{
		$error = "&#149;Δεν επιλέξατε τίποτα";
	}
	mysqli_close($connection);
}
?>