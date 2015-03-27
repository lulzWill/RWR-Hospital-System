<?php
require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseException;
	use Parse\ParseQuery;
	use Parse\ParseSessionStorage;
	
	require_once('navbar.php');
	
	ParseClient::initialize('kHbyXSdw4DIXw4Q0DYDcdM8QTDQnOewKJhc9ppAr', '9h80LHVDFOSAgVQ1NSPf5IgaWAaDnHdPoJWt2CDc', '3q1HVOiiywyBdtalMN1sozceJbNXuD9WKZSSmgvI');
	ParseClient::setStorage( new ParseSessionStorage() );
	$currentUser = ParseUser::getCurrentUser();
	$currentUser->save();
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
	else if($currentUser->get("position") == "physician")
	{
		try {
			$query=new ParseQuery("Physician");
			$query->equalTo("email", $currentUser->get("email"));
			$physician=$query->first();
		}
		catch (ParseException $ex) {
	
		}
	}
	else if($currentUser->get("position") == "nurse")
	{
		try {
			$query=new ParseQuery("Nurse");
			$query->equalTo("email", $currentUser->get("email"));
			$nurse=$query->first();
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
		
		<form class="form-horizontal" action="edituserprofile.php" method="post" id="editProfile" onsubmit="return validateForm()">
		<div class="profpic">
			<h2>Profile Picture</h2>
			<div class="form-group">
				<label for="prof_pic" class="col-sm-2 control-label whitelabel">Profile Picture Link:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="prof_pic" name="prof_pic" align="left" value="
EOL;
$profilePhoto = $patient->get("prof_pic");
echo $profilePhoto->getURL();
echo <<<EOL
" required>

                </div>			
			</div>
		</div>
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
EOL;
}
else if($currentUser->get("position") == "physician")
{
echo <<<EOL
<h1>
			RWR Hospital Management System
			<a href="viewprofile.php">Exit without Saving</a>
		</h1>
		
		<form class="form-horizontal" action="edituserprofile.php" method="post" id="editProfile1" onsubmit="return validateForm()">
		<div class="profpic">
			<h2>Profile Picture</h2>
			<div class="form-group">
				<label for="prof_pic" class="col-sm-2 control-label whitelabel">Profile Picture Link:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="prof_pic" name="prof_pic" align="left" value="
EOL;
$profilePhoto = $physician->get("prof_pic");
echo $profilePhoto->getURL();
echo <<<EOL
" required>

                </div>			
			</div>
		</div>
		<div class="continfo">
			<h2>Physician Information</h2>
			<div class="form-group">
				<label for="degree" class="col-sm-2 control-label whitelabel">Degree:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="degree" name="degree" value="
EOL;
echo $physician->get("degree");
echo <<<EOL
" required>
                </div>			
			</div>
			<div class="form-group">
				<label for="school" class="col-sm-2 control-label whitelabel">College/University:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="school" name="school" value="
EOL;
echo $physician->get("school");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="area_of_spec" class="col-sm-2 control-label whitelabel">Area of Specialization(s):</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="area_of_spec" name="area_of_spec" value="
EOL;
echo $physician->get("area_of_spec");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="experience" class="col-sm-2 control-label whitelabel">Years of Experience:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="experience" name="experience" value="
EOL;
echo $physician->get("experience");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="address" class="col-sm-2 control-label whitelabel">Work Address:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="address" name="address" value="
EOL;
echo $physician->get("address");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="citystate" class="col-sm-2 control-label whitelabel">City, State:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="citystate" name="citystate" value="
EOL;
echo $physician->get("citystate");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="zipcode" class="col-sm-2 control-label whitelabel">Zipcode:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="zipcode" name="zipcode" value="
EOL;
echo $physician->get("zipcode");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="phone" class="col-sm-2 control-label whitelabel">Work/Office Phone:</label>
				<div class="col-sm-10">
					<input type="text" size="8" class="form-control" id="phone" name="phone" value="
EOL;
echo $physician->get("phone");
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
EOL;
}
else if($currentUser->get("position") == "nurse")
{
echo <<<EOL
<h1>
			RWR Hospital Management System
			<a href="viewprofile.php">Exit without Saving</a>
		</h1>
		
		<form class="form-horizontal" action="edituserprofile.php" method="post" id="editProfile1" onsubmit="return validateForm()">
		<div class="profpic">
			<h2>Profile Picture</h2>
			<div class="form-group">
				<label for="prof_pic" class="col-sm-2 control-label whitelabel">Profile Picture Link:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="prof_pic" name="prof_pic" align="left" value="
EOL;
$profilePhoto = $nurse->get("prof_pic");
echo $profilePhoto->getURL();
echo <<<EOL
" required>

                </div>			
			</div>
		</div>
		<div class="continfo">
			<h2>Physician Information</h2>
			<div class="form-group">
				<label for="degree" class="col-sm-2 control-label whitelabel">Degree:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="degree" name="degree" value="
EOL;
echo $nurse->get("degree");
echo <<<EOL
" required>
                </div>			
			</div>
			<div class="form-group">
				<label for="school" class="col-sm-2 control-label whitelabel">College/University:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="school" name="school" value="
EOL;
echo $nurse->get("school");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="department" class="col-sm-2 control-label whitelabel">Department(s):</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="department" name="department" value="
EOL;
echo $nurse->get("department");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="experience" class="col-sm-2 control-label whitelabel">Years of Experience:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="experience" name="experience" value="
EOL;
echo $nurse->get("experience");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="address" class="col-sm-2 control-label whitelabel">Work Address:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="address" name="address" value="
EOL;
echo $nurse->get("address");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="citystate" class="col-sm-2 control-label whitelabel">City, State:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="citystate" name="citystate" value="
EOL;
echo $nurse->get("citystate");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="zipcode" class="col-sm-2 control-label whitelabel">Zipcode:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="zipcode" name="zipcode" value="
EOL;
echo $nurse->get("zipcode");
echo <<<EOL
" required>
				</div>
			</div>
			<div class="form-group">
				<label for="phone" class="col-sm-2 control-label whitelabel">Work/Office Phone:</label>
				<div class="col-sm-10">
					<input type="text" size="8" class="form-control" id="phone" name="phone" value="
EOL;
echo $nurse->get("phone");
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
EOL;
}
		
echo <<<EOL
	</body>
  </body>
</html>
EOL;



?>