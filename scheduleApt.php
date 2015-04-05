<?php 
	require 'vendor/autoload.php';
	include_once("navbar.php");
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	use Parse\ParseSessionStorage;
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	
	ParseClient::setStorage( new ParseSessionStorage() );
	
	$currentUser = ParseUser::getCurrentUser();

	$query = new ParseQuery("appointments");
	$query->equalTo("physicianEmail", $_POST["doctorSelect"]);
	$query->equalTo("Date", $_POST["dateSel"]);
	$query->equalTo("Time", $_POST["timeSelect"]);

	$results = $query->find();

	$results[0]->set("available", "taken");
	$results[0]->set("patientEmail", $currentUser->get("email"));
	$results[0]->save();


	echo <<<EOL

<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>
  		Schedule Appointments
  	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
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


	<!-- Include Parse Stuff -->
    <script src="//www.parsecdn.com/js/parse-1.3.5.min.js"></script>

    <link rel="stylesheet" href="bower_components/bootstrap-calendar/css/calendar.css">

    <!-- Include Bootstrap Datepicker -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />

	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

	<style type="text/css">
		/**
		 * Override feedback icon position
		 * See http://formvalidation.io/examples/adjusting-feedback-icon-position/
		 */
		#dateRangeForm .form-control-feedback {
		    top: 0;
		    right: -15px;
		}
		/* Adjust feedback icon position */
		#signupForm .selectContainer .form-control-feedback,
		#signupForm .inputGroupContainer .form-control-feedback {
		    right: -15px;
		}
	</style>


	<script type="text/javascript" src="bower_components/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="bower_components/moment/min/moment.min.js"></script>
  <script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
  <link rel="stylesheet" href="css/calendar.css">
  <link href="makeappointment.css" rel="stylesheet">
  </head>
  
  <body>
	<div style="position: relative; top: 5%; left: 30%; width: 70%; font-weight: bold; font-size: 32px; color: white; margin-bottom: 20px;">
		<p>RWR Hospital Management System</p>
	</div>
	<div class="panel panel-default" style="margin-left: 12%; margin-right: 12%;">
  		<div class="panel-body"> 
EOL;
	$to = $currentUser->get("email");
	$subject = "Appointment";
	$content= 'Appointment Successfully made for: ' . $_POST["dateSel"] . ' at ' . $_POST["timeSelect"];
	$headers = "From:Appointments@rwrso.ls\r\n";

	if(mail($to,$subject,$content,$headers))
	{
		echo '<h3>Appointment Successfully made for: ' . $_POST["dateSel"] . ' at ' . $_POST["timeSelect"] . '</h3>';
	}
echo <<<EOL
		<a href="homepage.php"><button type="button" class="btn btn-primary btn-med">Return to Homepage
		</button></a>
  		</div>
  	</div>
   </body>
</html>
EOL;
?>