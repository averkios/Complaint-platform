<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/login/login.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/login/logout.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/register/register.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/complaint/complaint.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/admin/delete.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complaints Inc.</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
	  $(document).ready(function(){
			//Handles menu drop down
			$('.dropdown-menu').find('form').click(function (e) {
				e.stopPropagation();
			});
		});
    </script>
  </head>
  <body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				  <span class="sr-only">Toggle navigation</span>
				  <span class="icon-bar"></span>
				  <span class="icon-bar"></span>
				  <span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Complaints</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
			  <ul class="nav navbar-nav navbar-right">
			  	<?php
			  	echo ($_SESSION['Admin']==1 ? '<li><a href="/admin/" class="noOutline" type="button">Διαχείριση</a></li>' : "");
			  	?>
			  	<?php
			  	echo ($_SESSION['login_user'] ? '<li><a href="#" class="noOutline" type="button" data-toggle="modal" data-target="#modalUsr">Τα παράπονα μου</a></li>' : "");
			  	?>
				<li><a href="#" class="noOutline" type="button" data-toggle="modal" data-target="#modalCom">Νέο Παράπονο</a></li>
				<li><a href="#" class="noOutline" type="button" data-toggle="modal" data-target="#modalCapab">Δυνατότητες</a></li>
				<?php
					if(!isset($_SESSION['login_user']))
					{
						echo '<li><a href="#" class="noOutline" type="button" data-toggle="modal" data-target="#modalReg">Εγγραφή</a></li>';
					}
				?>
				
					<?php
						if(isset($_SESSION['login_user']))
						{		
							echo '<li><a href="#" class="noOutline">' . $_SESSION["login_user"] . '</a></li>
								<li><form role="form" action="" method="post"><input style="text-decoration:none; padding: 15px;" class="btn btn-link" name="logout" type="submit" value=" Αποσύνδεση "></form></li>';	
						}
						else
						{
							echo '<li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown"> Σύνδεση <strong class="caret"></strong></a>
							<div class="dropdown-menu" style="min-width: 280px; padding: 15px; padding-bottom: 30px;">
								<form role="form" action="" method="post" accept-charset="UTF-8">
									<div class="form-group">
										<label><span class="required">*</span> e-mail :</label>
										<input class="form-control" name="username" placeholder="Πληκτρολογήστε το e-mail σας" ' . (isset($_POST["login"]) ? (isset($_POST["username"]) ? 'value="' . $_POST["username"] . '"' : "") : "") . ' type="text">
									</div>
									<div class="form-group">
										<label><span class="required">*</span> Κωδικός :</label>
										<input type="password" class="form-control" name="password" placeholder="Πληκτρολογήστε το κωδικό σας" type="password">
									</div>
									<input class="btn btn-primary pull-right" name="login" type="submit" value=" Σύνδεση ">
								</form>
							</div></li>';
						}
					?>

			  </ul>
			</div>
  		</div>
	</nav>

	<div id="modalReg" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Νέος Χρήστης</h4>
			</div>
			<div class="modal-body">
			  <form role="form" action="" method="post">
				<div class="form-group">
					<label>Επώνυμο :</label>
					<?php
						echo '<input class="form-control" name="lastname" placeholder="Πληκτρολογήστε το επώνυμο σας" ' . (isset($_POST["register"]) ? (isset($_POST["lastname"]) ? 'value="' . $_POST["lastname"] . '"' : "") : "") . '" type="text">';
					?>
				</div>
				<div class="form-group">
					<label>Όνομα :</label>
					<?php
					echo '<input class="form-control" name="firstname" placeholder="Πληκτρολογήστε το όνομα σας" ' . (isset($_POST["register"]) ? (isset($_POST["firstname"]) ? 'value="' . $_POST["firstname"] . '"' : "") : "") . '" type="text">';
					?>
				</div>
				<div class="form-group">
					<label><span class="required">*</span> e-mail :</label>
					<?php
						echo '<input class="form-control" name="username" placeholder="Πληκτρολογήστε το e-mail σας" ' . (isset($_POST["register"]) ? (isset($_POST["username"]) ? 'value="' . $_POST["username"] . '"' : "") : "") . '" type="text">';
					?>
				</div>
				<div class="form-group">
					<label><span class="required">*</span> Ταχυδρομικός κώδικας :</label>
					<?php
						echo '<input class="form-control" name="address" placeholder="Πληκτρολογήστε το ταχυδρομικό κώδικα σας" ' . (isset($_POST["register"]) ? (isset($_POST["address"]) ? 'value="' . $_POST["address"] . '"' : "") : "") . '" type="text">';
					?>
				</div>
				<div class="form-group">
					<label><span class="required">*</span> Αριθμός Τηλεφώνου :</label>
					<?php
						echo '<input class="form-control" name="phone" placeholder="Πληκτρολογήστε τον αριθμό τηλεφώνου σας" ' . (isset($_POST["register"]) ? (isset($_POST["phone"]) ? 'value="' . $_POST["phone"] . '"' : "") : "") . '" type="text">';
					?>
				</div>
				<div class="form-group">
					<label><span class="required">*</span> Κωδικός :</label>
					<input type="password" class="form-control" name="password" placeholder="Πληκτρολογήστε το κωδικό σας">
				</div>
				<div class="form-group">
					<label><span class="required">*</span>Επαλήθευση κωδικού :</label>
					<input type="password" class="form-control" name="password2" placeholder="Πληκτρολογήστε το κωδικό σας">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
					<input class="btn btn-primary" name="register" type="submit" value=" Εγγραφή ">
				</div>
			  </form>
			</div>
		</div>
	  </div>
	</div>
	
	<div id="modalCom" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Νέο Παράπονο</h4>
			</div>
			<div class="modal-body">
			  <form role="form" action="" method="post">
			  		<?php
						if(!isset($_SESSION['login_user'])) 
						{
							echo '
							<div class="form-group">					
							<label>Επώνυμο :</label>
								<input class="form-control" name="lastname" placeholder="Πληκτρολογήστε το επώνυμο σας" ' . (isset($_POST["newComplaint"]) ? (isset($_POST["lastname"]) ? 'value="' . $_POST["lastname"] . '"' : "") : "") . '" type="text">
							</div>
							<div class="form-group">
								<label>Όνομα :</label>
								<input class="form-control" name="firstname" placeholder="Πληκτρολογήστε το όνομα σας" ' . (isset($_POST["newComplaint"]) ? (isset($_POST["firstname"]) ? 'value="' . $_POST["firstname"] . '"' : "") : "") . '" type="text">
							</div>
							<div class="form-group">
								<label><span class="required">*</span> e-mail :</label>
								<input class="form-control" name="username" placeholder="Πληκτρολογήστε το e-mail σας" ' . (isset($_POST["newComplaint"]) ? (isset($_POST["username"]) ? 'value="' . $_POST["username"] . '"' : "") : "") . '" type="text">
							</div>
						';
						}
						/*else
						{
							$_POST['username'] = $_SESSION['login_user'];
						}*/
					?>
				<div class="form-group">
					<label><span class="required">*</span> Κατηγορία :</label>
					<select class="form-control" name="category">
					<option>Επιλέξτε κατηγορία</option>
					<?php
						require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
                      	mysqli_select_db($connection, "paraponaDB");
						
						mysqli_query($connection, "SET CHARACTER SET 'utf8'");
						
						$query = "SELECT * FROM Categories"; 
						$result = mysqli_query($connection, $query);

						while($rowContent = mysqli_fetch_array($result, MYSQLI_BOTH))
						{
							echo '<option value="' . $rowContent["Ca_Id"] . '">' . $rowContent["category"] . '</option>';
						}
						
						mysqli_close($connection);
					?>
					</select>
				</div>
				<div class="form-group">
					<label><span class="required">*</span> Καταγγελία :</label>
					<?php
						echo '<textarea class="form-control" name="complaint" placeholder="Πληκτρολογήστε τη καταγγελλία σας" rows="5" type="text">' . (isset($_POST["newComplaint"]) ? (isset($_POST["complaint"]) ? htmlspecialchars($_POST['complaint']) : "") : "") . '</textarea>';
					?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
					<input class="btn btn-primary" name="newComplaint" type="submit" value=" Αποστολή ">
				</div>
			  </form>
			</div>
		</div>
	  </div>
	</div>
	
	<div id="modalUsr" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Τα παράπονα μου</h4>
			</div>
			<div class="modal-body">
			  <form role="form" action="" method="post">
				<div class="form-group">
					<?php
						require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
                      	mysqli_select_db($connection, "paraponaDB");
						
						$query = "SELECT * FROM Permissions";
						$result = mysqli_query($connection, $query);
						
						while($rowContent = mysqli_fetch_array($result, MYSQLI_BOTH))
						{
							$temp = array();
							array_push($temp, $rowContent["PermissionFor"], $rowContent["Flag"]);
							$Permissions[] = $temp;
						}
						
						mysqli_query($connection, "SET CHARACTER SET 'utf8'");
						
						$query = "SELECT Categories.category, Complaints.content, Complaints.date, Complaints.email, Complaints.Co_Id FROM Complaints INNER JOIN Categories ON Categories.Ca_Id = Complaints.category WHERE email='" . $_SESSION['login_user'] . "'";
						$result = mysqli_query($connection, $query);
						$rows = mysqli_num_rows($result);

						if ($rows > 0)
						{
							while($rowContent = mysqli_fetch_array($result, MYSQLI_BOTH))
							{
								$date = date_create($rowContent["date"]);
								echo '<div class="jumbotron"><div class="container">' . (($Permissions[0][1]==1 || $_SESSION['Admin']==1) ? "<p>Επιλέξτε για διαγραφή <input class='UsrBox' type='checkbox' name='delboxComplaintUsr[]' value='" . $rowContent["Co_Id"] . "'></p>" : "" ) . '<h3>' . $rowContent["category"] . '</h3><p>' . $rowContent["email"] . ' είπε:</br></br>' . '<p>' . $rowContent["content"] . '</p></p><h4">' . date_format($date, "g:i a \o\\n l jS F Y") . '</h4></div></div>';
							}
						}
						else
						{
							echo '
								<div class="alert alert-danger alert-dismissible fade in" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
									<span>&#149; Δεν υπάρχουν παράπονα ακόμα</span>
								</div>
							';
						}
						mysqli_close($connection);
					?>
				</div>
				<div class="modal-footer">
				<?php
					if($Permissions[0][1]==1 || $_SESSION['Admin']==1)
					{
						echo '
						<button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
						<input class="btn btn-danger" name="complaintDelUsr" type="submit" value=" Διαγραφή Επιλεγμένων ">';
					}
					else
					{
						echo '<button type="button" class="btn btn-primary" data-dismiss="modal">Οκ</button>';
					}
				?>
				</div>
			  </form>
			</div>
		</div>
	  </div>
	</div>
	
	<div id="modalCapab" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Δυνατότητες Συστήματος</h4>
			</div>
			<div class="modal-body">
			  <dl class="dl-horizontal">
			  	<dt>Open for everyone</dt>
				<dd>Όλοι μπορούν να δουν όλα τα παράπονα.</dd><br/>
				<dt>User register</dt>
				<dd>Δυνατότητα εγγραφής.</dd><br/>
				<dt>Complaint insert</dt>
				<dd>Δυνατότητα καταχώρησης παραπόνου από οποιονδήποτε.</dd><br/>
				<dt>User date</dt>
				<dd>Διατηρούνται στοιχεία για κάθε χρήστη.</dd><br/>
				<dt>Form field persistence</dt>
				<dd>Διατηρούνται τα στοιχεία των πεδίων της φόρμας σε περίπτωση λάθους.</dd><br/>
				<dt>Access control</dt>
				<dd>Περιορισμός χρηστών από σελίδες που δεν έχουν δικαιώματα πρόσβασης, όπως οι σελίδες του διαχειριστή.</dd><br/>
				<dt>Cascade delete</dt>
				<dd>Όταν διαγράφεται μια κατηγορία, διαγράφονται και όλες οι εγγραφές της. Το ίδιο ισχύει και για τους χρήστες.</dd><br/>
				<dt>Input validation</dt>
				<dd>Έλεγχος εισαγωγής για επαλήθευση εγκυρότητας και αποφυγή "sql injection".</dd><br/>
				<dt>Alert boxes</dt>
				<dd>Παράθυρα ενημέρωσης για σφάλματα ή ενημέρωση για την επιτυχή ολοκλήρωση μιας πράξης.</dd><br/>
				<dt>password encryption</dt>
				<dd>Πάρα πολύ απλή κρυπτογράφηση κωδικών.</dd><br/>
				<dt>User aware</dt>
				<dd>Το σύστημα γνωρίζει κάθε στιγμή ποιος το χρησιμοποιεί. (χρήστης, διαχειριστής, φιλοξενούμενος)</dd><br/>
				<dt>Category insert</dt>
				<dd>Ο διαχειριστής μπορεί να εισάγει νέες κατηγορίες.</dd><br/>
				<dt>Duplicate aware</dt>
				<dd>Το σύστημα γνωρίζει αν υπάρχει ήδη εγγεγραμμένος κάποιος χρήστης την στιγμή που γίνεται μια νέα εγγραφή ή αν υπάρχει ήδη μία κατηγορία όταν ο διαχειριστής εισάγει μια νέα.</dd><br/>
				<dt>Database managment</dt>
				<dd>Ο διαχειριστής μπορεί να διαγράψει κατηγορίες, παράπονα, χρήστες, φιλοξενούμενους.</dd><br/>
				<dt>User capabilities</dt>
				<dd>Κάθε χρήστης μπορεί να προβάλει και να διαγράφει τα παράπονα του.(διαγραφή αν το επιτρέπει ο διαχειριστής)</dd><br/>
				<dt>Database reset</dt>
				<dd>Επαναφορά βάσης</dd><br/>
				<dt>Permission control</dt>
				<dd>Ο διαχειριστής μπορεί να αλλάξει τα δικαιώματα των χρηστών όσων αφορά την ικανότητα τους να διαγράφουν τα παράπονα τους.</dd><br/>
				<dt>Sorting</dt>
				<dd>Ταξινόμηση προβολής παραπόνων με βάση ημερομηνία ή κατηγορία.</dd><br/>
				<dt>Statistics</dt>
				<dd>Το σύστημα εξάγει στατιστικά στοιχεία ζωγραφίζοντας τα σε παραστάσεις.</dd><br/>
				<dt>File export(xml, txt)</dt>
				<dd>Το σύστημα εξάγει στατιστικά στοιχεία σε αρχεία xml και txt, τα οποία είναι διαθέσιμα για προβολή στο φυλλομετρητή αλλά και για λήψη.</dd><br/>
				<dt>Guest upgrade</dt>
				<dd>Το σύστημα αποθηκεύει τους χρήστες που κάνουν παράπονα ως φιλοξενούμενοι και αργότερα αν δημιουργήσουν λογαριασμό ανανεώνονται τα στοιχεία τους.</dd><br/>
				<dt>Dynamic</dt>
				<dd>Όλα υπολογίζονται και αλλάζουν δυναμικά.</dd><br/>
				<dt>external frameworks,<br/>plugins</dt>
				<dd>Bootstrap 3, morris.js.</dd><br/>
			  </dl>
			</div>
		</div>
	  </div>
	</div>
	
	<div class="container">
		<?php
			if (!empty($error))
			{
				echo '
					<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						<span>' . $error . '</span>
					</div>
				';
			}
			if (!empty($success))
			{
				echo '
					<div class="alert alert-success alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						<span>' . $success .= $_SESSION["login_user"] .'</span>
					</div>
				';
			}
		?>
		<div class="page-header text-center">
			<h1>Παράπονα</h1>
			<div class="pull-left">
			<h4>Ταξινόμηση ανα </h4>
			<form class="pull-right" action="" method="post">
				<select class="form-control" name="sort" onchange="this.form.submit()">
					<?php 
					echo '<option ' . ($_POST["sort"] == "CatSort" ? "selected" : "") . ' value="CatSort">Κατηγορία</option>';
					echo '<option ' .  ($_POST["sort"] == "DateSort" ? "selected" : "") . ' value="DateSort">Ημερομηνία</option>';
					?>
				</select>
				<noscript><input type="submit" value="Αλλαγή"></noscript>
			</form>
			</div>
			<br/><br/><br/><br/>
		</div>
		<?php
			require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
            mysqli_select_db($connection, "paraponaDB");
		
			mysqli_query($connection, "SET CHARACTER SET 'utf8'");
		
			if (isset($_POST['sort']) && $_POST['sort']== "DateSort" )
			{
				$query = "SELECT Categories.category, Complaints.content, Complaints.date FROM Complaints INNER JOIN Categories ON Categories.Ca_Id = Complaints.category ORDER BY date DESC";
			}
			else
			{
				$query = "SELECT Categories.category, Complaints.content, Complaints.date FROM Complaints INNER JOIN Categories ON Categories.Ca_Id = Complaints.category ORDER BY Ca_Id";
			}
			
			$result = mysqli_query($connection, $query);
			$rows = mysqli_num_rows($result);
			
			if ($rows > 0)
			{
				while($rowContent = mysqli_fetch_array($result, MYSQLI_BOTH))
				{
					$date = date_create($rowContent["date"]);
					echo '<div class="jumbotron"><h3>' . $rowContent["category"] . '</h3><p>' . $rowContent["content"] . '</p><h4>' . date_format($date, "g:i a \o\\n l jS F Y") . '</h4></div>';
				}
			}
			else
			{
				echo '
					<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						<span>&#149; Δεν υπάρχουν παράπονα ακόμα</span>
					</div>
				';
			}
			mysqli_close($connection);
		?>
	</div>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>