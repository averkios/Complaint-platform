<?php
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'].'/login/logout.php');
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
    <title>Complaints Inc. Διαχείριση</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

     <!-- Custom CSS -->
    <link href="/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
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
                    <li class="active">
                        <a href="/admin/"><i class="fa fa-fw fa-edit"></i> Παράπονα</a>
                    </li>
                    <li>
                        <a href="/admin/stats.php"><i class="fa fa-fw fa-bar-chart-o"></i> Στατιστικά</a>
                    </li>
                    <li>
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
                            Παράπονα
                        </h1>
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
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
						
                                <?php
									require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
                      				mysqli_select_db($connection, "paraponaDB");

									mysqli_query($connection, "SET CHARACTER SET 'utf8'");

									if (isset($_POST['sort']) && $_POST['sort']== "DateSort" )
									{
										$query = "SELECT Categories.category, Complaints.content, Complaints.date, Complaints.email FROM Complaints INNER JOIN Categories ON Categories.Ca_Id = Complaints.category ORDER BY date DESC";
									}
									else
									{
										$query = "SELECT Categories.category, Complaints.content, Complaints.date, Complaints.email FROM Complaints INNER JOIN Categories ON Categories.Ca_Id = Complaints.category ORDER BY Ca_Id";
									}
									
									$result = mysqli_query($connection, $query);
									$rows = mysqli_num_rows($result);

									if ($rows > 0)
									{
										while($rowContent = mysqli_fetch_array($result, MYSQLI_BOTH))
										{
											$date = date_create($rowContent["date"]);
											echo '<div class="jumbotron"><h3>' . $rowContent["category"] . '</h3><p>' . $rowContent["email"] . ' είπε:</br></br>' . '<p>' . $rowContent["content"] . '</p></p><h4>' . date_format($date, "g:i a \o\\n l jS F Y") . '</h4></div>';
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
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

  	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
    <!-- Morris Charts JavaScript -->
    <script src="/js/plugins/morris/raphael.min.js"></script>
    <script src="/js/plugins/morris/morris.min.js"></script>
    <script src="/js/plugins/morris/morris-data.js"></script>
  </body>
</html>
