<?php
	if (basename($_SERVER['PHP_SELF']) == 'logout.php') {
		die('You cannot load this page directly.');
	};

if (isset($_POST['logout'])) {
	session_unset(); //for session checks based on session variables
	session_destroy(); // Destroying All Sessions
	$success = "Η αποσύνδεση έγινε με επιτυχία";
}
?>