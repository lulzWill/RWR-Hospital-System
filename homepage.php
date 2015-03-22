<?php
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	use Parse\ParseSessionStorage;
	
	session_start();
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	
	ParseClient::setStorage( new ParseSessionStorage() );
	
	$currentUser = ParseUser::getCurrentUser();
	
	if(!$currentUser)
	{
		header("Location: test.php");
		exit;
		
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>
  		Home
  	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	  <link href="homepage.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <?php include_once("navbar.php"); ?>
  </head>
  
  <body>
	  <div class="header-image">
		  <div style="position: absolute; bottom: 0; left: 30%; width: 100%; font-weight: bold; font-size: 32px; color: #fff; margin-bottom: 280px;">
		  	<p>RWR Hospital Management System</p>
	  	  </div>
	  </div>
	  <?php
	  if($currentUser->get("position") == "patient")
	  {
		  echo <<<EOL
	  <div style="position: relative; width: 100%; height: 160px">
	  	<a href="makeappoint.php"><img src="icons/appointmenticon.png" alt="appointment temp" class="img-circle button-left" height="140px" width="140px"></a>
	  	<a href="viewprofile.php"><img src="icons/viewprofileicon.png" alt="appointment temp" class="img-circle button-middle" height="140px" width="140px"></a>
	  	<a href="#"><img src="http://ih1.redbubble.net/image.16620010.6522/fc,140x140,white.jpg" alt="appointment temp" class="img-circle button-right" height="140px" width="140px"></a>
  	  </div>
EOL;
	  }
?>
  </body>
</html>