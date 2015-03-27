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
	$currentUser->save();
	
	try {
		$query=new ParseQuery("Patient");
		$query->equalTo("email", $currentUser->get("email"));
		$patient=$query->first();
	}
	catch (ParseException $ex) {
		
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

		<h1>
			RWR Hospital Management System
		</h1>
		
		<form class="form-horizontal" action="edituserprofile.php" method="post" id="editProfile" onsubmit="return validateForm()">
		<div class="continfo">
			<h2>Patient Contact Information</h2>
			<div class="form-group">
				<label for="address" class="col-sm-2 control-label whitelabel">Address:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="address" name="address" value="
EOL;
echo $patient->get("address");
echo <<<EOL
" required>
                </div>			
			</div>
			<div class="form-group">
				<label for="citystate" class="col-sm-2 control-label whitelabel">City, State:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="citystate" name="citystate" value="
EOL;
echo $patient->get("citystate");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="zipcode" class="col-sm-2 control-label whitelabel">Zipcode:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="zipcode" name="zipcode" value="
EOL;
echo $patient->get("zipcode");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="homephone" class="col-sm-2 control-label whitelabel">Home Phone:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="homephone" name="homephone" value="
EOL;
echo $patient->get("homephone");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="cellphone" class="col-sm-2 control-label whitelabel">Cell Phone:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="cellphone" name="cellphone" value="
EOL;
echo $patient->get("cellphone");
echo <<<EOL
" required>
				</div>
			</div>
		</div>
		<div class="emerginfo">
			<h2>Emergency Contact Information</h2>
			<h3>Primary</h3>
			<div class="form-group">
				<label for="emerg_name" class="col-sm-2 control-label whitelabel">Emergency Contact's Name:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="emerg_name" name="emerg_name" value="
EOL;
echo $patient->get("emerg_name");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="emerg_num" class="col-sm-2 control-label whitelabel">Emergency Contact's Number:</label>
				<div class="col-sm-10">
					<input type="text" size="8" class="form-control" id="emerg_num" name="emerg_num" value="
EOL;
echo $patient->get("emerg_num");
echo <<<EOL
" required>
				</div>
			</div>
			
			<div class="form-group">
				<label for="emerg_rel" class="col-sm-2 control-label whitelabel">Relation to Emergency Contact:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="emerg_rel" name="emerg_rel" value="
EOL;
echo $patient->get("emerg_rel");
echo <<<EOL
" required>
				</div>
			</div>
			<h3>Secondary</h3>
			<div class="form-group">
				<label for="emerg_name2" class="col-sm-2 control-label whitelabel">Emergency Contact's Name:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="emerg_name2" name="emerg_name2" value="
EOL;
echo $patient->get("emerg_name2");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="emerg_num2" class="col-sm-2 control-label whitelabel">Emergency Contact's Number:</label>
				<div class="col-sm-10">
					<input type="text" size="8" class="form-control" id="emerg_num2" name="emerg_num2" value="
EOL;
echo $patient->get("emerg_num2");
echo <<<EOL
" required>
				</div>
			</div>
			
			<div class="form-group">
				<label for="emerg_rel2" class="col-sm-2 control-label whitelabel">Relation to Emergency Contact:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="emerg_rel2" name="emerg_rel2" value="
EOL;
echo $patient->get("emerg_rel2");
echo <<<EOL
" required>
				</div>
			</div>
		</div>
		<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      	<button type="submit" class="btn btn-success">Save Settings</button>
			    </div>
		</div>
		</form>

		

		<script>
			function validateForm() {
				var h = document.forms["signupForm"]["sex"].value;
				if (h == null || h == "" || h == "Choose a sex") {
					alert("Select a sex");
					return false;
				}
			}
		</script>
	</body>
  </body>
</html>
EOL;



?>