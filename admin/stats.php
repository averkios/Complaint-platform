<?php
  session_start();
  require_once($_SERVER['DOCUMENT_ROOT'].'/login/logout.php');
  if (!$_SESSION['Admin']==1)
  {
    header("location: /");
  }
  
  function percentage ($sunolo, $xrhstes) {
	$xrhstes = $xrhstes / $sunolo;
	$xrhstes = $xrhstes * 100;
	
	$whole = floor($xrhstes);
	$fraction = $xrhstes - $whole;

	if(!($fraction == 1/2))
	{
		$xrhstes = round($xrhstes);
	}
	
	return $xrhstes;
  }
  
  //file download
  if (isset($_POST['xml']))
  {
  	$file = $_SERVER['DOCUMENT_ROOT']."/output/statistics.xml";

	if (file_exists($file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		exit;
	}
  }    
  if (isset($_POST['txt']))
  {
  	$file = $_SERVER['DOCUMENT_ROOT']."/output/statistics.txt";

	if (file_exists($file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		exit;
	}
  } 
                    
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complaints Inc. Στατιστικά</title>

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
                    <li>
                        <a href="/admin/"><i class="fa fa-fw fa-edit"></i> Παράπονα</a>
                    </li>
                    <li class="active">
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
                            Στατιστικά
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">

                      <?php
                      require($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
                      mysqli_select_db($connection, "paraponaDB");
                      
                      //Users percentage
                      $query = "SELECT * FROM Users";
                      $result = mysqli_query($connection, $query);
                      $sunolo = mysqli_num_rows($result);

                      $query = "SELECT Users.Guest FROM Users WHERE Guest = 1";
                      $result = mysqli_query($connection, $query);
                      $guests = mysqli_num_rows($result);

                      $query = "SELECT Users.Admin FROM Users WHERE Admin = 1";
                      $result = mysqli_query($connection, $query);
                      $admins = mysqli_num_rows($result);

                      $users = $sunolo - ($admins + $guests);
                		
					  $guests = percentage($sunolo, $guests);
					  $admins = percentage($sunolo, $admins);
					  $users = percentage($sunolo, $users);
					  
					  //Complaints per Category
					  $query = "SELECT * FROM Complaints";
                      $result = mysqli_query($connection, $query);
                      $sunolo = mysqli_num_rows($result);
                      
                      $query = "SELECT * FROM Categories";
                      $result = mysqli_query($connection, $query);
                      $categories = mysqli_num_rows($result);
                	  
                	  $cat = array();
                      while($rowContent = mysqli_fetch_array($result, MYSQLI_BOTH))
					  {
						array_push($cat, $rowContent["Ca_Id"]);
					  }
					
					 $temp = array();
					  foreach ($cat as $c) 
					  {
					  	  mysqli_query($connection, "SET CHARACTER SET 'utf8'");
						  $query = 'SELECT Categories.category, Categories.Ca_Id, Complaints.content, Complaints.date, Complaints.email 
									FROM Complaints INNER JOIN Categories ON Categories.Ca_Id = Complaints.category WHERE Ca_Id = "' . $c . '"' ;
						  $result = mysqli_query($connection, $query);
						  $rowContent = mysqli_fetch_array($result, MYSQLI_BOTH);
						  $katigoria = mysqli_num_rows($result);
					  
						  $PosostoKatigorias = percentage($sunolo, $katigoria);
						  $temp['KatID'] = $c;
						  $temp['Kat'] = $rowContent["category"];
						  $temp['Plithos'] = $katigoria;
						  $temp['Percent'] = $PosostoKatigorias;
						  $pososta[] = $temp;
					  }
					  
 					 //Complaints per year
					 $years = $temp = array();
				
					 $query = 'SELECT DISTINCT YEAR(Complaints.date) as year FROM Complaints ORDER BY date ASC';
					 $result = mysqli_query($connection, $query);						  		
					 
					 while($rowContent = mysqli_fetch_array($result, MYSQLI_BOTH))
					 {
						array_push($years, $rowContent["year"]);
					 }
				
					 foreach ($years as $y) 
					 {	
						 $query = 'SELECT * FROM Complaints WHERE YEAR(Complaints.date)="' . $y . '"';
						 $result = mysqli_query($connection, $query);
						 $rowContent = mysqli_fetch_array($result, MYSQLI_BOTH);
						 $xronia/*Χρονιά*/ = mysqli_num_rows($result);
						
						 $PosostoXronou = percentage($sunolo, $xronia);
						 $temp['xronia'] = $y;
						 $temp['Plithos'] = $xronia;
						 $temp['Percent'] = $PosostoXronou;
						 $xronosPososta[] = $temp;
					 }	

                      mysqli_close($connection);
                      
                      //File creation
                      
                      require($_SERVER['DOCUMENT_ROOT'].'/admin/filecreation.php');
                      
                      ?>
                      <div class=".container-fluid" style="max-width:800px; margin:0 auto;">
						  <div><h2 class="text-center">Συνολικά στοιχεία<hr></hr></h2></div>
						  
						  <div><h3 class="text-center">Παράπονα ανα Κατηγορία</h3></div>
						  <div id="katigories"></div>
						  <div><h3 class="text-center">Παράπονα ανα Έτος</h3></div>
						  <div id="parapona-xrono"></div>
			
                      </div>
                      <div class=".container-fluid" style="max-width:800px; margin:0 auto;">
						  <div><h2 class="text-center">Στατιστικά στοιχεία<hr></hr></h2></div>
						  
						  <div><h3 class="text-center">Κατανομή χρηστών</h3></div>
						  <div id="users-chart"></div>
						  <div><h3 class="text-center">Κατανομή παραπόνων ανα κατηγορία</h3></div>
						  <div id="category-chart"></div>
						  <div><h3 class="text-center">Κατανομή παραπόνων ανα έτος</h3></div>
						  <div id="category-chart-year"></div>
						  
                      </div>
                      
                      <div class=".container-fluid" style="max-width:800px; margin:0 auto;">
						  <div><h2 class="text-center">Εξαγωγή στοιχείων<hr></hr></h2><div>
						  <div><h3 class="text-center">Προβολή στοιχείων</h3></div>
						  <div class="row">
							  <div class="text-center">
								  <div class="col-md-6"><a class="btn btn-primary" href="/output/statistics.xml" target="_blank" role="button">Στατιστικά σε xml</a></div>
								  <div class="col-md-6"><a class="btn btn-primary" href="/output/statistics.txt" target="_blank" role="button">Στατιστικά σε txt</a></div>
							  </div>
						  </div>
						  <div class="row">
							  <div><h3 class="text-center">Λήψη στοιχείων</h3></div>
							  <div class="text-center">
							  	<form role="form" action="" method="post">
								  <div class="col-md-6"><input class="btn btn-primary" type="submit" name="xml" value="Στατιστικά σε xml"></div>
								  <div class="col-md-6"><input class="btn btn-primary" type="submit" name="txt" value="Στατιστικά σε txt"></div>
							  	</form>
							  </div>
						  </div>
                      </div>
                       
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
    <!-- Chart script -->
    <script>
      Morris.Donut({
        element: 'users-chart',
        data: [
        <?php
          echo '
            {label: "Χρήστες", value: ' . $users . '},
            {label: "Φιλοξενούμενοι", value: ' . $guests . '},
            {label: "Διαχειριστές", value: ' . $admins . '}
            ';
        ?>
        ],
        colors: [
        '#00639E', '#F29F00', '#000'
        ],
        formatter: function (y, data) { return y + '%' }
      });
      
      Morris.Bar({
		  element: 'parapona-xrono',
		  data: [
		  <?php
		  	foreach ($xronosPososta as $y) 
			{
			  if(isset($y["xronia"]))
			  {
				echo "
					{ y: '" . $y['xronia'] . "', a: " . $y['Plithos'] . "},
				";
			  }
			}
		  ?>
		  ],
		  xkey: 'y',
		  ykeys: ['a'],
		  labels: ['Παράπονα'],
	 });
	 
	 Morris.Bar({
		  element: 'category-chart',
		  data: [
		  <?php
		  	foreach ($pososta as $p) 
			{
			  if(isset($p["Kat"]))
			  {
			  	$ylabel = explode(" ", $p['Kat']);
			  	
				echo "
					{ y: '" . $ylabel[1] . "', a: " . $p['Percent'] . "},
				";
			  }
			}
		  ?>
		  ],
		  xkey: 'y',
		  ykeys: ['a'],
		  labels: ['Ποσοστό'],
		  hoverCallback: function (index, options, content) {
			  var row = options.data[index];
			  return 'Ποσοστό : '+row.a+'%';
		  }
	 });
	 
	 Morris.Bar({
		  element: 'category-chart-year',
		  data: [
		  <?php
		  	foreach ($xronosPososta as $y) 
			{
			  if(isset($y["xronia"]))
			  {
				echo "
					{ y: '" . $y["xronia"] . "', a: " . $y['Percent'] . "},
				";
			  }
			}
		  ?>
		  ],
		  xkey: 'y',
		  ykeys: ['a'],
		  labels: ['Ποσοστό'],
		  hoverCallback: function (index, options, content) {
			  var row = options.data[index];
			  return 'Ποσοστό : '+row.a+'%';
		  }
	 });
	 
	 Morris.Bar({
		  element: 'katigories',
		  data: [
		  <?php
		  	foreach ($pososta as $p) 
			{
			  if(isset($p["Kat"]))
			  {
			  	$ylabel = explode(" ", $p['Kat']);
			  	
				echo "
					{ y: '" . $ylabel[1] . "', a: " . $p['Plithos'] . "},
				";
			  }
			}
		  ?>
		  ],
		  xkey: 'y',
		  ykeys: ['a'],
		  labels: ['Παράπονα'],
	 });
    </script>
  </body>
</html>
