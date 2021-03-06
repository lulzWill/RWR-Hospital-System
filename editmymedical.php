<?php
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	use Parse\ParseSessionStorage;
	
	include_once('navbar.php');

	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	ParseClient::setStorage( new ParseSessionStorage() );
	$currentUser = ParseUser::getCurrentUser();
	$currentUser->save();
	
	if(!$currentUser)
	{
		header("Location: index.php");
		exit;
		
	}
	if($currentUser->get("position") == "patient")
	{
		try {
			$query=new ParseQuery("Patient");
			$query->equalTo("email", $currentUser->get("email"));
			$patient=$query->first();
		}
		catch (ParseException $ex) {
	
		}
	}
echo <<<EOL
  <!DOCTYPE html>
  <html lang="en">
  <head>
  	<title>
  		Edit Profile Page
  	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="editprofile.css" rel="stylesheet">
	<link href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

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

	<!-- Include Bootstrap Combobox -->
	<link rel="stylesheet" href="/vendor/bootstrap-combobox/css/bootstrap-combobox.css">

	<script src="/vendor/bootstrap-combobox/js/bootstrap-combobox.js"></script>
	
	<!-- Include Parse Stuff -->
    <script src="//www.parsecdn.com/js/parse-1.3.5.min.js"></script>
  </head>
  <body>
	<body>
		
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
EOL;
if($currentUser->get("position") == "patient")
{
echo <<<EOL
<h1>
			RWR Hospital Management System
			<a href="viewprofile.php">Exit without Saving</a>
		</h1>
		
		<form class="form-horizontal" action="editusermedical.php" method="post" id="editProfile" onsubmit="return validateForm()">
		<div class="medical">
			<h2>Medical Information</h2>
			<div class="container">
			<div class="row">
				<label for="insurance" class="col-sm-2 control-label whitelabel">Insurance:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="insurance" name="insurance" align="left" value="
EOL;
echo $patient->get("insurance");
echo <<<EOL
" required>

                </div>			
			</div>
			</div>
			<div class="container">
			<div class="row">
				<label for="pre_conditions" class="col-sm-2 control-label whitelabel">Pre-Existing Conditions:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="pre_conditions" name="pre_conditions" value="
EOL;
echo $patient->get("pre_conditions");
echo <<<EOL
" required>
                </div>			
			</div>
			</div>
			<div class="container">
			<div class="row">
				<label for="medications" class="col-sm-2 control-label whitelabel">Medications:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="medications" name="medications" value="
EOL;
echo $patient->get("medications");
echo <<<EOL
" required>
				</div>
			</div>
			</div>
			<div class="container">
			<div class="row">
				<label for="allergies" class="col-sm-2 control-label whitelabel">Allergies:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="allergies" name="allergies" value="
EOL;
echo $patient->get("allergies");
echo <<<EOL
" required>
				</div>
			</div>
			</div>
		<div class="container">
			<div class="row">>
			    <div class="col-sm-offset-2 col-sm-10">
			      	<button type="submit" class="btn btn-success">Save Settings</button>
			    </div>
			</div>
		</div>
		</div>
		</form>
EOL;
}		
echo <<<EOL
	</body>
  </body>
</html>
EOL;



?>