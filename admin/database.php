<?php
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'].'/login/logout.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/admin/delete.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/admin/newCategory.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/admin/PermissionChange.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/admin/dbreset.php');
	if (!$_SESSION['Admin']==1)
	{
		header("location: /");
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Complaints Inc. Βάση</title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Complaints Inc.</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                	<?php
									echo '<p style="color:#fff; padding: 10px 20px 0 0;">Έχετε συνδεθεί ως ο διαχειριστής ' . $_SESSION["login_user"] . '</p>';
                    ?>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="/admin/"><i class="fa fa-fw fa-edit"></i> Παράπονα</a>
                    </li>
                    <li>
                        <a href="/admin/stats.php"><i class="fa fa-fw fa-bar-chart-o"></i> Στατιστικά</a>
                    </li>
                    <li class="active">
                        <a href="/admin/database.php"><i class="fa fa-fw fa-database"></i> Βάση</a>
                    </li>
					<li style="">
						<form style="width:225px;"role="form" action="" method="post"><input class="link" name="logout" type="submit" value=" Αποσύνδεση "></form>
					</li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Διαχείριση Βάσης Δεδομένων
                        </h1>
                    </div>
                </div>
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
							<span>' . $success .'</span>
						</div>
					';
				}
				?>
                <form role="form" action="" method="post">
                	<div class="form-group">
						<div class="row">
							<div class="col-lg-12">
								<h2>Χρήστες</h2>
								<div class="table-responsive">
									<table class="table table-bordered table-hover table-striped">
										<thead>
											<tr>
												<th>Επώνυμο</th>
												<th>Όνομα</th>
												<th>e-mail</th>
												<th>Διεύθυνση</th>
												<th>Τηλέφωνο</th>
												<th class="del"><input type="checkbox" class="UsrBoxBtn" label="check all"/><i class="fa fa-fw fa-trash-o"></i></th>
											</tr>
										</thead>
										<tbody>
											<?php
												require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
                      							mysqli_select_db($connection, "paraponaDB");

												mysqli_query($connection, "SET CHARACTER SET 'utf8'");

												$query = "SELECT * FROM Users WHERE Admin=0 AND Guest=0";
												$result = mysqli_query($connection, $query);

												while($rowContent = mysqli_fetch_array($result, MYSQLI_BOTH))
												{
													echo '<tr>';
													echo '<td>' . $rowContent["LastName"] . '</td>';
													echo '<td>' . $rowContent["FirstName"] . '</td>';
													echo '<td>' . $rowContent["email"] . '</td>';
													echo '<td>' . $rowContent["Address"] . '</td>';
													echo '<td>' . $rowContent["Phone"] . '</td>';
													echo '<td><input class="UsrBox" type="checkbox" name="delboxUsr[]" value="' . $rowContent["email"] . '"></td>';
													echo '</tr>';
												}

												mysqli_close($connection);
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<!-- /.row -->
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-lg-12">
								<h2>Φιλοξενούμενοι</h2>
								<div class="table-responsive">
									<table class="table table-bordered table-hover table-striped">
										<thead>
											<tr>
												<th>Επώνυμο</th>
												<th>Όνομα</th>
												<th>e-mail</th>
												<th>Διεύθυνση</th>
												<th>Τηλέφωνο</th>
												<th class="del"><input type="checkbox" class="GuestBoxBtn" label="check all"/><i class="fa fa-fw fa-trash-o"></i></th>
											</tr>
										</thead>
										<tbody>
											<?php
												require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
                      							mysqli_select_db($connection, "paraponaDB");

												mysqli_query($connection, "SET CHARACTER SET 'utf8'");

												$query = "SELECT * FROM Users WHERE Admin=0 AND Guest=1";
												$result = mysqli_query($connection, $query);

												while($rowContent = mysqli_fetch_array($result, MYSQLI_BOTH))
												{
													echo '<tr>';
													echo '<td>' . $rowContent["LastName"] . '</td>';
													echo '<td>' . $rowContent["FirstName"] . '</td>';
													echo '<td>' . $rowContent["email"] . '</td>';
													echo '<td>' . $rowContent["Address"] . '</td>';
													echo '<td>' . $rowContent["Phone"] . '</td>';
													echo '<td><input class="GuestBox" type="checkbox" name="delboxGuest[]" value="' . $rowContent["email"] . '"></td>';
													echo '</tr>';
												}

												mysqli_close($connection);
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<!-- /.row -->
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-lg-12">
								<h2>Διαχειριστές</h2>
								<div class="table-responsive">
									<table class="table table-bordered table-hover table-striped">
										<thead>
											<tr>
												<th>Επώνυμο</th>
												<th>Όνομα</th>
												<th>e-mail</th>
												<th>Διεύθυνση</th>
												<th>Τηλέφωνο</th>
											</tr>
										</thead>
										<tbody>
											<?php
												require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
                      							mysqli_select_db($connection, "paraponaDB");

												mysqli_query($connection, "SET CHARACTER SET 'utf8'");

												$query = "SELECT * FROM Users WHERE Admin=1 AND Guest=0";
												$result = mysqli_query($connection, $query);

												while($rowContent = mysqli_fetch_array($result, MYSQLI_BOTH))
												{
													echo '<tr>';
													echo '<td>' . $rowContent["LastName"] . '</td>';
													echo '<td>' . $rowContent["FirstName"] . '</td>';
													echo '<td>' . $rowContent["email"] . '</td>';
													echo '<td>' . $rowContent["Address"] . '</td>';
													echo '<td>' . $rowContent["Phone"] . '</td>';
													echo '</tr>';
												}

												mysqli_close($connection);
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<!-- /.row -->
					</div>
					<div class="form-group">
					<div class="row">
						<div class="col-lg-12">
							<h2>Παράπονα</h2>
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped">
									<thead>
										<tr>
											<th>e-mail</th>
											<th>Κατηγορία</th>
											<th>Περιεχόμενο</th>
											<th>Ημερομηνία</th>
											<th class="del"><input type="checkbox" class="CompBoxBtn" label="check all"/><i class="fa fa-fw fa-trash-o"></i></th>
										</tr>
									</thead>
									<tbody>
										<?php
											require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
                      						mysqli_select_db($connection, "paraponaDB");

											mysqli_query($connection, "SET CHARACTER SET 'utf8'");

											$query = "SELECT Categories.category, Complaints.Co_Id, Complaints.content, Complaints.date, Complaints.email FROM Complaints INNER JOIN Categories ON Categories.Ca_Id = Complaints.category";
											$result = mysqli_query($connection, $query);

											while($rowContent = mysqli_fetch_array($result, MYSQLI_BOTH))
											{
												echo '<tr>';
												echo '<td>' . $rowContent["email"] . '</td>';
												echo '<td>' . $rowContent["category"] . '</td>';
												echo '<td><textarea readonly>' . $rowContent["content"] . '</textarea></td>';
												echo '<td>' . $rowContent["date"] . '</td>';
												echo '<td><input class="CompBox" type="checkbox" name="delboxComp[]" value="' . $rowContent["Co_Id"] . '"></td>';
												echo '</tr>';
											}

											mysqli_close($connection);
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- /.row -->
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-lg-12">
								<h2>Κατηγορίες</h2>
								<div class="table-responsive">
											<table class="table table-bordered table-hover table-striped">
												<thead>
													<tr>
														<th>Κατηγορία</th>
														<th class="del"><input type="checkbox" class="CaBoxBtn" label="check all"/><i class="fa fa-fw fa-trash-o"></i><a href="#" class="noOutline noUnderline" type="button" data-toggle="modal" data-target="#modalCat"><i class="fa fa-fw fa-plus-square-o"></i>Προσθήκη</a></th>
													</tr>
												</thead>
													<tbody>
														<?php
															require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
                      										mysqli_select_db($connection, "paraponaDB");

															mysqli_query($connection, "SET CHARACTER SET 'utf8'");
															
															$query = "SELECT * FROM Categories";
															$result = mysqli_query($connection, $query);

															while($rowContent = mysqli_fetch_array($result, MYSQLI_BOTH))
															{
																echo '<tr>';
																echo '<td>' . $rowContent["category"] . '</td>';
																echo '<td><input class="CaBox" type="checkbox" name="delboxCa[]" value="' . $rowContent["Ca_Id"] . '"></td>';
																echo '</tr>';
															}

															mysqli_close($connection);
														?>
													</tbody>
											</table>
										</div>
								</div>
							</div>
						</div>
						<!-- /.row -->
						<input class="btn btn-danger pull-right" name="delete" type="submit" value=" Διαγραφή Επιλεγμένων ">
						<a href="#" class="noOutline btn btn-primary pull-right" style="margin: 0 20px 0 0;" type="button" data-toggle="modal" data-target="#modalPer">Αλλαγή Δικαιωμάτων</a>
						<a href="#" class="noOutline btn btn-primary pull-left" style="margin: 0 20px 0 0;" type="button" data-toggle="modal" data-target="#modalReset">Επαναφορά βάσης</a>
					</div>
				</form>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <div id="modalCat" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Νέα Κατηγορία</h4>
			</div>
			<div class="modal-body">
			  <form role="form" action="" method="post">
				<div class="form-group">
					<input class="form-control" name="category" placeholder="Πληκτρολογήστε την κατηγορία" type="text">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
					<input class="btn btn-primary" name="newCategory" type="submit" value=" Δημιουργία ">
				</div>
			  </form>
			</div>
		</div>
	  </div>
	</div>
	
	<div id="modalPer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Αλλαγή Δικαιωμάτων</h4>
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
						
						echo '<label>Οι χρήστες μπορούν να διαγράψουν τα παράπονα τους</label>&nbsp;&nbsp;<input class="PermBox" type="checkbox" name="PermBox" value="' . $Permissions[0][0] . '" ' . ($Permissions[0][1]==1 ? "checked" : "") . '>';
					
					?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
					<input class="btn btn-primary" name="PermChange" type="submit" value=" Αποθήκευση ">
				</div>
			  </form>
			</div>
		</div>
	  </div>
	</div>
	
	<div id="modalReset" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Επαναφορά βάσης</h4>
			</div>
			<div class="modal-body">
			  <form role="form" action="" method="post">
				<div class="form-group">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<h3 class="panel-title">Προσοχή !</h3>
					  	</div>
						<div class="panel-body">
							Η επαναφορά βάσης διαγράφει όλα τα δεδομένα και επαναφέρει τη βάση στην αρχική της μορφή
					    </div>
				    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
					<input class="btn btn-danger" name="dbreset" type="submit" value=" Επαναφορά ">
				</div>
			  </form>
			</div>
		</div>
	  </div>
	</div>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>

    <script>
	$(function() {
		$('.UsrBoxBtn').click(function() {
			$('.UsrBox').prop('checked', this.checked);
		});
	});

	$(function() {
		$('.GuestBoxBtn').click(function() {
			$('.GuestBox').prop('checked', this.checked);
		});
	});

	$(function() {
		$('.CompBoxBtn').click(function() {
			$('.CompBox').prop('checked', this.checked);
		});
	});

	$(function() {
		$('.CaBoxBtn').click(function() {
			$('.CaBox').prop('checked', this.checked);
		});
	});
    </script>

</body>

</html>
